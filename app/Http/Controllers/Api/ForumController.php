<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Validators\Api\ForumValidator;
use App\Models\Forum as Model;
use App\Models\ForumComment;
use App\Models\ForumSubcategory;
use App\Presenters\api\ForumPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ForumController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = ForumValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $forums = Model::where(function ($query) use ($request){

            $query->where('language', $request->language ?? 'ru');

            $query->where('subcategory', $request->subcategory ?? 'ru');

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->orderByDesc('created_at')
          ->paginate(10);

        return response()->json([
            'data' => $forums->present(ForumPresenter::class)->map(function ($model){

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'language' => $model->language,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
//                    'category' => $model->category,
                    'subcategory' => $model->subcategory,
                    'comments' => $model->comments(),
                    'user' => $model->user(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];

            }),
            'page' => $forums->currentPage(),
            'pages' => $forums->lastPage()
        ])->setStatusCode(200);
    }

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function indexCommentById(Request $request)
    {

        if (!Model::query()->where('id', (int)$request->id)->exists())
            return response()->json(['error' => 'Такого записи нет'])->setStatusCode(422);

        $comments = ForumComment::query()
            ->where([['forum_id', (int)$request->id], ['comment_id', 'exists', false]])
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json([
            'data' => $comments->present(ForumPresenter::class)->map(function ($model){
                return [
                    'id' => $model->id,
                    'text' => $model->text,
                    'user' => $model->user(),
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
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $validator = ForumValidator::init('store', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $forum = new Model();

        $forum->title = $request->title;
        $forum->description = $request->description;
        $forum->category = ForumSubcategory::where('sys_name', $request->subcategory)->first()->{'category'} ?? '';
        $forum->subcategory = $request->subcategory;
        $forum->language = $request->language;
        $forum->user_id = Auth::user()->id;

        if (!$forum->save())
            return response()->json(['success' => 'Успешно создали'])->setStatusCode(200);

        return response()->json(['success' => 'Успешно создали', 'id' => $forum->id])->setStatusCode(200);
    }

    public function commentIndex(Request $request, $id)
    {

        if (!ForumComment::where('id',(int)$id)->exists())
            return response()->json(['error' => 'Такого коммента нет'])->setStatusCode(422);

        $record = ForumComment::where('id',(int)$id)->first();

        $model = new ForumPresenter($record);

        return response()->json(
            [
                'id' => $model->id,
                'text' => $model->text,
                'user' => $model->user(),
                'replies' => $model->replies(),
                'repliesCount' => $model->repliesCount(),
                'created_at' => $model->created_at,
            ]
        )->setStatusCode(200);

    }

    /**
     * Показать ответы
     * @param Request $request
     * @return JsonResponse
     */
    public function userReplies(Request $request)
    {

        $myComments = ForumComment::where('user_id', Auth::user()->id)->get()->pluck('id');

        $comments = ForumComment::where(function ($query) use ($request, $myComments){

            $query->whereIn('comment_id', $myComments);

        });

        $comments = $comments->paginate(10);

        return response()->json(['data' => $comments->present(ForumPresenter::class)->map(function ($model){
            return [
                'id' => $model->id,
                'text' => $model->text,
                'user' => $model->user(),
                'forum' => $model->forum(),
                'replies' => $model->replies(),
                'repliesCount' => $model->repliesCount(),
                'created_at' => $model->created_at,
            ];
        }),
            'page' => $comments->currentPage(),
            'pages' => $comments->lastPage()
        ])->setStatusCode(200);

    }

    public function commentStore(Request $request)
    {
        $validator = ForumValidator::init('comment', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $record = new ForumComment();

        $record->text = $request->text;
        $record->forum_id = $request->forum_id;
        $record->user_id = Auth::user()->id;
        if ($request->has('comment_id') && $request->comment_id != null)
            $record->comment_id = $request->comment_id;

        if (!$record->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно написали', 'comment' => $record->toArray()])->setStatusCode(200);

    }

    public function commentDelete($id)
    {
        $validator = ForumValidator::init('comment_delete', ['comment_id' => (int)$id]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $record = ForumComment::where([['user_id', Auth::user()->id], ['id', (int)$id]])->first();

        if (!$record->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

}
