<?php


namespace App\Http\Controllers\Api\User;




use App\Helpers\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\TokenDevice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class TokenController   extends Controller
{
    public function store(string $type,string $token){

        // инициализация валидатора
        $validator = Validator::make(['type' => $type,'token' => $token],[
            'type' => ['string','required'],
            'token' => ['string','required'],
        ]);

        // если в валидаторе есть ошибки верни первую
        if($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if($type !== 'ios' && $type !== 'android')
            return response()->json(['error' => 'Необходимо указать ios или андроид'])->setStatusCode(422);

        $token_k = TokenDevice::query()->where('token', $token)->first();

        if($token_k == null){

            $token_k = new TokenDevice();

            $token_k->user_id = Auth::user()->{'id'};
            $token_k->token = $token;
            $token_k->type = $type;

            $token_k->save();

        } else{

            $tokens = TokenDevice::query()->where('token', $token)->get();

            foreach ($tokens as $tokenget)
            {
                $tokenget->delete();
            }

            $token_device_created = TokenDevice::query()->create([
                'token' => $token,
                'type' => $type,
                'user_id' => Auth::user()->{'id'}
            ]);

            if(!$token_device_created)
                return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);


        }

        $user_tokens = TokenDevice::query()->where('user_id', Auth::user()->{'id'})->where('token', '!=', $token)->get();

        foreach ($user_tokens as $user_token) {
            $user_token->delete();
        }

        return response()->json(['success'=>'Токен успешно добавлен',])->setStatusCode(200);


    }

    public function test(Request $request){

        $user_message = [
            'body' => 'Тест пуша',
            'title' => 'Уведомления',
            'subtitle' => '',
            'vibrate' => 1,
            'sound' => 1,
            'priority' => 10,
            'data' => $request->data
        ];

        $tokens = TokenDevice::getUserTokens(Auth::user()->id);

        if (PushNotificationHelper::sendPush($user_message, array_unique($tokens)))
            return response()->json($request->data);

        return response()->json(['message' => 'Что-то пошло не так'], 401);

    }
}
