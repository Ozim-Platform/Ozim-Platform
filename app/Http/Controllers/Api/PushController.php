<?php

namespace App\Http\Controllers\Api;

use App\Helpers\PushNotificationHelper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PushController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function send(Request $request)
    {
        $request->user_id = (int)$request->user_id;

        $validator = Validator::make($request->all(), [
            'email' => 'email|required'
        ], [
            'email.email' => 'email | Должен быть почтой',
            'email.required' => 'email | Обязателен',
            'email.exists' => 'email | Такого пользователя нет',
        ]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $user = User::query()->where('email', $request->email)->first();

        if (!$user)
            return response()->json(['error' => 'Такого пользователя нет'])->setStatusCode(422);

        PushNotificationHelper::sendChatPush($user);

        return response()->json([
            'success' => 'Успешно отправили пуш'
        ])->setStatusCode(200);
    }

}
