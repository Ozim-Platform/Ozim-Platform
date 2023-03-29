<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\QuestionnaireAnswerResource;
use App\Http\Resources\QuestionnaireResource;
use App\Http\Validators\Api\QuestionnaireValidator;
use App\Models\Questionnaire;
use App\Models\Questionnaire as Model;
use App\Models\QuestionnaireAnswer;
use App\Models\UserChildren;
use App\Services\EmailService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class QuestionnaireController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = QuestionnaireValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $questions = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => QuestionnaireResource::collection($questions),
            'page' => $questions->currentPage(),
            'pages' => $questions->lastPage()
        ])->setStatusCode(200);
    }

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function answer(Request $request) : JsonResponse
    {
        $validator = QuestionnaireValidator::init('answer', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (!UserChildren::query()->where([['id', $request->child_id], ['parent_id', auth()->user()->id]])->exists())
            return response()->json(['error' => 'У вас нет такого ребенка'])->setStatusCode(422);

        $child = UserChildren::query()->where('id', $request->child_id)->first();

        if (!Questionnaire::query()->where('age', $child->age)->exists())
            return response()->json(['error' => 'Для вашего ребенка анкета еще разрабатывается'], 422);

        $questionnaire = Questionnaire::query()->where('age', $child->age)->first();

        if (QuestionnaireAnswer::query()->where([['child_id', $child->id], ['questionnaire_id', $questionnaire->id]])->exists())
            return response()->json(['error' => 'Вы уже сдавали эту анкету'], 422);

        $answer = new QuestionnaireAnswer();

        $count = 0;

        foreach ($questionnaire->questions as $title => $question){

            if ($count!==5)
                $data[$title] = ['answers' => $request->answers[$count], 'total' => array_sum($request->answers[$count])];
            else
                $data[$title] = ['answers' => $request->answers[$count]];

            $count++;
        }

        $answer->fill(['answers' => $data, 'child_id' => $request->child_id, 'questionnaire_id' => $questionnaire->id, 'age' => $questionnaire->age]);

        if (!$answer->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позднее!'])->setStatusCode(500);

        return response()->json(
               new QuestionnaireAnswerResource($answer->load('questionnaire'))
        )->setStatusCode(200);
    }

    public function sendToEmailAnswer(Request $request)
    {
        $request->validate([
            'answer_id' => ['required', 'exists:questionnaire_answers,id'],
            'email' => [Rule::requiredIf(auth()->user()->email == null), 'email:rfc,dns'],
        ],[
            'answer_id.required' => 'answer_id | Обязателен',
            'answer_id.exists' => 'answer_id | Такого записи нет',
        ]);

        $child_ids = UserChildren::query()->where('parent_id', auth()->user()->id)->pluck('id')->toArray();

        $answer = QuestionnaireAnswer::query()->where('id', $request->answer_id)->with(['child', 'questionnaire'])->first();

        $child = $answer->child;

        if (in_array($child->id, $child_ids))
            return response()->json(['error' => 'У вас нет такого результата'])->setStatusCode(422);

        $user = auth()->user();
        $email = $request->email ?? $user->email;

        $pdf = Pdf::loadView('exports.questionnaire_answer' , [
            'child' => $child,
            'user' => $user,
            'answer' => $answer,
        ])->setPaper('a4');

        $c = $pdf->download();

        $filename = 'q_answers/'.Str::slug($child->name) . '-' . now()->timestamp;

        Storage::disk('public')->put("$filename.pdf" , $c);

        $path = "storage/$filename.pdf";

        (new EmailService())->sendResults($email, $user, $child, $answer, public_path($path));

        return response()->json(['message' => 'Успешно отправили в почту']);
    }

}
