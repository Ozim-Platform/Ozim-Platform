<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\RecordCommentResource;
use App\Http\Validators\Api\RecordBookmarkValidator;
use App\Models\Api\{Article, Diagnoses, ForParent, Inclusion, Rights, ServiceProvider, Skill};
use App\Models\{CategoryType, Faq, Forum, Link, Questionnaire, RecordBookmarkFolder, RecordBookmarks, RecordComment, RecordLike, RecordRating, RecordView};
use App\Presenters\api\{RecordCommentPresenter,
    RecordPresenter};
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RecordController extends Controller
{

    /**
     * Просмотр записи
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(500);

        $like = RecordView::query()->where([
            ['record_id', $request->record_id],
            ['type', $request->type],
            ['user_id', Auth::user()->id]
        ])->first();

        if ($like)
            return response()->json(['error' => 'Увас уже есть просмотр'])->setStatusCode(400);

        RecordView::query()->create([
            'record_id' => $request->record_id,
            'type' => $request->type,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['success' => 'Успешно сохранили'])->setStatusCode(200);

    }

    /**
     * Лайкнуть
     * @param Request $request
     * @return JsonResponse
     */
    public function like(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(500);

        $like = new RecordLike();

        $like->record_id = $request->record_id;
        $like->type = $request->type;
        $like->user_id = Auth::user()->id;

        if (!$like->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно сохранили'])->setStatusCode(200);

    }

    /**
     * Убрать лайк
     * @param Request $request
     * @return JsonResponse
     */
    public function unlike(Request $request)
    {
        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(422);

        if (!RecordLike::where([['user_id', Auth::user()->id], ['record_id', $request->record_id], ['type', $request->type]])->exists())
            return response()->json(['error' => 'У вас нет лайка на эту запись'])->setStatusCode(422);

        $like = RecordLike::where([['user_id', Auth::user()->id], ['record_id', $request->record_id], ['type', $request->type]])->first();

        if (!$like->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

    /**
     * Коммент написать
     * @param Request $request
     * @return JsonResponse
     */
    public function comment(Request $request)
    {
        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(500);

        if ($request->has('comment_id') && $request->comment_id != null && !RecordComment::query()->where([['id', $request->comment_id], ['type', $request->type]])->exists())
            return response()->json(['error' => 'Такого комментария в этом типе нет'])->setStatusCode(500);

        $record = new RecordComment();

        $record->text = $request->text;
        $record->record_id = $request->record_id;
        $record->type = $request->type;
        $record->user_id = Auth::user()->id;
        if ($request->has('comment_id') && $request->comment_id != null)
            $record->comment_id = $request->comment_id;

        if (!$record->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно написали', 'comment' => $record->toArray()])->setStatusCode(200);
    }

    /**
     * Показать коммент
     * @param Request $request
     * @return JsonResponse
     */
    public function commentIndex(Request $request)
    {
        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(500);

        $comments = RecordComment::query()->where([
            ['record_id', (int)$request->record_id],
            ['type', $request->type],
            ['comment_id', 'exists', false]])
            ->orderByDesc('created_at')
            ->get();

        return response()->json(RecordCommentResource::collection($comments));
    }

    /**
     * Показать ответы
     * @param Request $request
     * @return JsonResponse
     */
    public function userReplies(Request $request)
    {

        $myComments = RecordComment::where([['user_id', Auth::user()->id]])->get()->pluck('id');

        $comments = RecordComment::where(function ($query) use ($request, $myComments){

            $query->whereIn('comment_id', $myComments);

        });

        $comments = $comments->paginate(10);

        return response()->json(['data' => $comments->present(RecordCommentPresenter::class)->map(function ($model) use ($request){
            return [
                'id' => $model->id,
                'text' => $model->text,
                'user' => $model->user(),
                'record' => $model->record($model->type),
                'replies' => $model->replies(),
                'repliesCount' => $model->repliesCount(),
                'created_at' => $model->created_at,
            ];
        }),
            'page' => $comments->currentPage(),
            'pages' => $comments->lastPage()
        ])->setStatusCode(200);

    }

    /**
     * Удалить коммент
     * @param $id
     * @return JsonResponse
     */
    public function commentDelete($id)
    {
        if(!RecordComment::where([['user_id', Auth::user()->id], ['id', (int)$id]])->exists())
            return response()->json(['error' => 'Такого комментария нет'])->setStatusCode(500);

        $record = RecordComment::where([['user_id', Auth::user()->id], ['id', (int)$id]])->first();

        if (!$record->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

    /**
     * Записи из избранных
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark(Request $request)
    {

        $data = RecordBookmarks::query()->where(function ($query) use ($request){

            if ($request->language)
                $query->where('language', $request->language);

            $query->where('user_id', Auth::user()->id);

//            if ($request->type)
//            $query->where('type', $request->type);

            if ($request->has('folder'))
                $query->where('folder', (int)$request->folder);

        })->paginate(10);

        return response()->json([
            'data' => $data->pluck('record'),
            'page' => $data->currentPage(),
            'pages' => $data->lastPage()])->setStatusCode(200);
    }

    /**
     * Папки избранных
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark_folder(Request $request)
    {
        $data = RecordBookmarkFolder::where(function ($query) use ($request){

            $query->where('user_id', Auth::user()->id);

            if ($request->folder)
                $query->where('id', (int)$request->folder);

            if ($request->type)
                $query->where('type', $request->type);

        })->paginate(10);

        return response()->json([
            'data' => $data->present(RecordPresenter::class)->map(function ($model){
                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'sys_name' => $model->sys_name,
//                    'type' => $model->type,
                    'created_at' => $model->created_at,
                ];
            })])->setStatusCode(200);
    }

    /**
     * Создать папку
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark_folder_store(Request $request)
    {

        $validator = RecordBookmarkValidator::init('store', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (RecordBookmarkFolder::where([['name', $request->name], ['user_id', Auth::user()->id]])->exists())
            return response()->json(['error' => 'Такая папка уже имеется'])->setStatusCode(422);

        $folder = new RecordBookmarkFolder();

        $folder->name = $request->name;
//        $folder->type = $request->type;
        $folder->user_id = Auth::user()->id;
        $folder->sys_name = Str::slug($request->name).time();

        if (!$folder->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно сохранили', 'data' => $folder])->setStatusCode(200);

    }

    /**
     * Обновить папку
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark_folder_update(Request $request)
    {

        $validator = RecordBookmarkValidator::init('update', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (!RecordBookmarkFolder::where([['id', (int)$request->folder], ['user_id', Auth::user()->id]])->exists())
            return response()->json(['error' => 'Такой папки в этом типе нет'])->setStatusCode(422);

        $folder = RecordBookmarkFolder::where([['id', (int)$request->folder], ['user_id', Auth::user()->id]])->first();

        $folder->fill(['name' => $request->name]);

        if (!$folder->update())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно обновили', 'data' => $folder])->setStatusCode(200);

    }

    /**
     * Удалить папку
     * @param $id
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark_folder_delete(Request $request, $id)
    {

        if (!RecordBookmarkFolder::query()->where([
            ['id', (int)$id],
            ['user_id', Auth::user()->id]
        ])->exists())
            return response()->json(['error' => 'Такого папки нет'])->setStatusCode(422);

        $folder = RecordBookmarkFolder::where([['id', (int)$id], ['user_id', Auth::user()->id]])->first();

        RecordBookmarks::query()
            ->where([['folder', (int)$id], ['user_id', Auth::user()->id]])->get()->each(function ($bookmark){
                $bookmark->delete();
            });

        if (!$folder->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

    /**
     * Добавить запись в папку
     * @param Request $request
     * @return JsonResponse
     */
    public function to_bookmark(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа записи нет'])->setStatusCode(400);

        $folder = RecordBookmarkFolder::where([['id', (int)$request->folder], ['user_id', Auth::user()->id]])->first();

        if (!$folder)
            return response()->json(['error' => 'Такого папки нет'])->setStatusCode(400);

        if (RecordBookmarks::query()->where([['user_id', Auth::user()->id], ['record_id', (int)$request->record_id], ['type', $request->type]])->exists())
            return response()->json(['error' => 'У вас уже есть закладка'])->setStatusCode(400);

        switch ($request->type) {
            case 'diagnosis':

                $validator = Diagnoses::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'article':

                $validator = Article::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'faq':
                $validator = Faq::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'for_parent':
                $validator = ForParent::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'forum':
                $validator = Forum::query()->where('id', (int)$request->record_id)->exists();


                break;

            case 'inclusion':

                $validator = Inclusion::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'link':

                $validator = Link::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'questionnaire':

                $validator = Questionnaire::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'right':
                $validator = Rights::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'service_provider':

                $validator = ServiceProvider::query()->where('id', (int)$request->record_id)->exists();

                break;

            case 'skill':
                $validator = Skill::query()->where('id', (int)$request->record_id)->exists();

        }

        if (!$validator)
            return response()->json(['error' => 'Такого записи нет'])->setStatusCode(422);

        $bookmark = new RecordBookmarks();

        $bookmark->record_id = $request->record_id;
        $bookmark->type = $request->type;
        $bookmark->folder = (int)$request->folder;
        $bookmark->user_id = Auth::user()->id;

        if (!$bookmark->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно сохранили'])->setStatusCode(200);

    }

    /**
     * Удалить запись из папку
     * @param Request $request
     * @return JsonResponse
     */
    public function delete_bookmark(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа записи нет'])->setStatusCode(400);

        if (!RecordBookmarks::where([['user_id', Auth::user()->id], ['record_id', (int)$request->record_id], ['type', $request->type]])->exists())
            return response()->json(['error' => 'У вас нет закладки на эту запись'])->setStatusCode(422);

        $record = RecordBookmarks::where([['user_id', Auth::user()->id], ['record_id', (int)$request->record_id], ['type', $request->type]])->first();

        if (!$record->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

    /**
     * Переместить запись из папку
     * @param Request $request
     * @return JsonResponse
     */
    public function from_bookmark(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа записи нет'])->setStatusCode(400);

        $folder = RecordBookmarkFolder::where([['id', (int)$request->folder], ['user_id', Auth::user()->id]])->first();

        if (!$folder)
            return response()->json(['error' => 'Такого папки нет'])->setStatusCode(400);

        if (!RecordBookmarks::where([['user_id', Auth::user()->id], ['record_id', (int)$request->record_id], ['type', $request->type]])->exists())
            return response()->json(['error' => 'У вас нет закладки на эту запись'])->setStatusCode(422);

        $record = RecordBookmarks::where([['user_id', Auth::user()->id], ['record_id', (int)$request->record_id], ['type', $request->type]])->first();

        $record->folder = $request->folder;

        if (!$record->update())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно переместили'])->setStatusCode(200);

    }

    /**
     * Дать рейтинг
     * @param Request $request
     * @return JsonResponse
     */
    public function rating(Request $request)
    {

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'type | Такого типа нет'])->setStatusCode(400);

        if ($request->rating > 5)
            return response()->json(['error' => 'rating | Максимальный рейтинг до 5'])->setStatusCode(400);

        if (RecordRating::query()->where([
            ['record_id', (int)$request->record_id],
            ['user_id', Auth::user()->id],
            ['type', $request->type]])
            ->exists())
            return response()->json(['error' => 'Вы уже поставили рейтинг'])->setStatusCode(400);

        $rating = new RecordRating();

        $rating->record_id = (int)$request->record_id;
        $rating->type = $request->type;
        $rating->text = $request->text;
        $rating->rating = (float)$request->rating;
        $rating->user_id = Auth::user()->id;

        if (!$rating->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно поставили рейтинг'])->setStatusCode(200);

    }
}
