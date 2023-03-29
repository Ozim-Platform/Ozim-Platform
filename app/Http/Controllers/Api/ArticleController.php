<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\CommentResource;
use App\Http\Resources\DiagnosisResource;
use App\Http\Resources\ForParentResource;
use App\Http\Resources\InclusionResource;
use App\Http\Resources\RightsResource;
use App\Http\Resources\ServiceProviderResource;
use App\Http\Resources\SkillResource;
use App\Http\Resources\VideoResource;
use App\Http\Validators\Api\IndexValidator;
use App\Http\Validators\Api\ArticleValidator;
use App\Http\Validators\Api\BookmarkValidator;
use App\Models\Api\Article;
use App\Models\Api\ForParent;
use App\Models\Api\Inclusion;
use App\Models\Api\Rights;
use App\Models\Api\Skill;
use App\Models\ArticleBookmarkFolder;
use App\Models\ArticleBookmarks;
use App\Models\ArticleComment;
use App\Models\ArticleLikes;
use App\Models\ArticleViews;
use App\Models\Diagnoses;
use App\Models\ServiceProvider;
use App\Models\Video;
use App\Presenters\api\ArticlePresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = IndexValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $articles = Article::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => ArticleResource::collection($articles),
            'page' => $articles->currentPage(),
            'pages' => $articles->lastPage()])->setStatusCode(200);
    }

    public function search_by_category($category, $id)
    {
        $validator = IndexValidator::init('model', ['category' => $category, 'id' => $id]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $model = [];

        switch ($category) {
            case 'article':
                $articles = Article::where('id', (int)$id)->paginate();

                $model = ArticleResource::collection($articles);
                break;
            case 'service_provider':
                $service_providers = ServiceProvider::where('id', (int)$id)->paginate();

                $model = ServiceProviderResource::collection($service_providers);
                break;
            case 'diagnose':
                $diagnoses = Diagnoses::where('id', (int)$id)->paginate();

                $model = DiagnosisResource::collection($diagnoses);
                break;
            case 'skill':
                $skills = Skill::where('id', (int)$id)->paginate();

                $model = SkillResource::collection($skills);
                break;
            case 'for_parent':
                $for_parent = ForParent::where('id', (int)$id)->paginate();

                $model = ForParentResource::collection($for_parent);
                break;
            case 'rights':
                $rights = Rights::where('id', (int)$id)->paginate();

                $model = RightsResource::collection($rights);
                break;
            case 'inclusion':
                $inclusions = Inclusion::where('id', (int)$id)->paginate();

                $model = InclusionResource::collection($inclusions);
                break;
            default:
                $model = 'Категория не найдена';
        }

        return response()->json([
            $category => $model
        ]);
    }

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function search(Request $request)
    {
        $searchArray = explode(',', str_replace(', ', ',', $request->search));

        $articles = Article::where(function ($query) use ($request, $searchArray) {
            $query->where('name', 'like', '%' . $request->search . '%');
            $query->orWhere('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $service_providers = ServiceProvider::where(function ($query) use ($request, $searchArray) {

            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $diagnoses = Diagnoses::where(function ($query) use ($request, $searchArray) {
            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");


            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $skills = Skill::where(function ($query) use ($request, $searchArray) {
            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $for_parent = ForParent::where(function ($query) use ($request, $searchArray) {
            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $inclusions = Inclusion::where(function ($query) use ($request, $searchArray) {

            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $rights = Rights::where(function ($query) use ($request, $searchArray) {
            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        $videos = Video::where(function ($query) use ($request, $searchArray) {
            $query->where('description', 'like', "%" . $request->search . "%");
            $query->orWhere('title', 'like', "%" . $request->search . "%");
            $query->orWhere('author', 'like', "%" . $request->search . "%");
            $query->orWhere('tags', 'like', "%" . $request->search . "%");

            foreach ($searchArray as $search) {
                $query->orWhere('description', 'like', "%" . $search . "%");
                $query->orWhere('name', 'like', "%" . $search . "%");
                $query->orWhere('title', 'like', "%" . $search . "%");
                $query->orWhere('author', 'like', "%" . $search . "%");
            }

            foreach (explode(',', $request->search) as $search) {
                $query->orWhere('tags', 'like', "%" . $search . "%");
            }

        })->paginate(10);

        return response()->json([
            'articles' => ArticleResource::collection($articles),
            'service_providers' => ServiceProviderResource::collection($service_providers),
            'diagnoses' => DiagnosisResource::collection($diagnoses),
            'skill' => SkillResource::collection($skills),
            'for_parent' => ForParentResource::collection($for_parent),
            'rights' => RightsResource::collection($rights),
            'inclusion' => InclusionResource::collection($inclusions),
            'videos' => VideoResource::collection($videos),
            'page' => $articles->currentPage(),
            'pages' => $articles->lastPage()])->setStatusCode(200);
    }

    /**
     * Записи из избранных
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark(Request $request)
    {

        $articles = ArticleBookmarks::where(function ($query) use ($request){

            $query->where('language', $request->language);

            $query->where('user_id', Auth::user()->id);

            if ($request->has('folder'))
                $query->where('folder', (int)$request->folder);

        })->paginate(10);

        foreach ($articles as $key => $article) {
            if (!$article->article)
                $articles->forget($key);
        }

        return response()->json([
            'data' => ArticleResource::collection($articles),
            'page' => $articles->currentPage(),
            'pages' => $articles->lastPage()])->setStatusCode(200);
    }

    /**
     * Папки избранных
     * @param Request $request
     * @return JsonResponse
     */
    public function bookmark_folder(Request $request)
    {

        $articles = ArticleBookmarkFolder::where(function ($query) use ($request){

            $query->where('user_id', Auth::user()->id);

        })->paginate(10);

        return response()->json([
            'data' => $articles->present(ArticlePresenter::class)->map(function ($model){
                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'sys_name' => $model->sys_name,
//                    'articles' => $model->articles(),
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
        $validator = BookmarkValidator::init('store', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (ArticleBookmarkFolder::where([['name', $request->name], ['user_id', Auth::user()->id]])->exists())
            return response()->json(['error' => 'Такая папка уже имеется'])->setStatusCode(422);

        $folder = new ArticleBookmarkFolder();

        $folder->name = $request->name;
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

        $validator = BookmarkValidator::init('update', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $folder = ArticleBookmarkFolder::where([['id', (int)$request->folder], ['user_id', Auth::user()->id]])->first();

        $folder->fill(['name' => $request->name]);

        if (!$folder->update())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно обновили', 'data' => $folder])->setStatusCode(200);

    }

    /**
     * Удалить папку
     * @param $id
     * @return JsonResponse
     */
    public function bookmark_folder_delete($id)
    {

        $validator = BookmarkValidator::init('check',  ['folder' => (int)$id]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $folder = ArticleBookmarkFolder::where([['id', (int)$id], ['user_id', Auth::user()->id]])->first();

        ArticleBookmarks::query()
            ->where([['folder' => $id], ['user_id', Auth::user()->id]])->get()->each(function ($bookmark){
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
        $validator = ArticleValidator::init('like', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $bookmark = new ArticleBookmarks();

        $bookmark->article_id = $request->article_id;
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
        $validator = ArticleValidator::init('check', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (!ArticleBookmarks::where([['user_id', Auth::user()->id], ['article_id', (int)$request->article_id]])->exists())
            return response()->json(['error' => 'У вас нет закладки на эту запись'])->setStatusCode(422);

        $record = ArticleBookmarks::where([['user_id', Auth::user()->id], ['article_id', (int)$request->article_id]])->first();

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
        $validator = ArticleValidator::init('like', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (!ArticleBookmarks::where([['user_id', Auth::user()->id], ['article_id', (int)$request->article_id]])->exists())
            return response()->json(['error' => 'У вас нет закладки на эту запись'])->setStatusCode(422);

        $record = ArticleBookmarks::where([['user_id', Auth::user()->id], ['article_id', (int)$request->article_id]])->first();

        $record->folder = $request->folder;

        if (!$record->update())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно переместили'])->setStatusCode(200);

    }

    /**
     * Показать комменты
     * @param Request $request
     * @return JsonResponse
     */
    public function commentIndex(Request $request)
    {
        $validator = ArticleValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $myComments = ArticleComment::where('user_id', Auth::user()->id)->get()->pluck('id');

        $comments = ArticleComment::where(function ($query) use ($request, $myComments){

            $query->whereIn('comment_id', $myComments);

        });

        $comments = $comments->paginate(10);

        return response()->json(['data' => CommentResource::collection($comments),
            'page' => $comments->currentPage(),
            'pages' => $comments->lastPage()
            ])->setStatusCode(200);

    }

    /**
     * Показать комменты по ID
     * @param Request $request
     * @return JsonResponse
     */
    public function commentsByArticleId(Request $request)
    {

        if (!$request->has('article_id'))
            return response()->json(['error' => 'article_id | Обязателен для заполнения'])->setStatusCode(422);

        if (!Article::query()->where('id', (int)$request->article_id)->exists())
            return response()->json(['error' => 'Такого записи нет'])->setStatusCode(422);

        $comments = ArticleComment::where(function ($query) use ($request){

            $query->where('article_id', (int)$request->article_id);

            $query->where('comment_id', 'exists', false);

        });

        $comments = $comments
            ->orderByDesc('created_at')
            ->paginate(10);

        return response()->json(['data' => CommentResource::collection($comments),
            'page' => $comments->currentPage(),
            'pages' => $comments->lastPage()
            ])->setStatusCode(200);

    }

    /**
     * Добавить коммент
     * @param Request $request
     * @return JsonResponse
     */
    public function commentStore(Request $request)
    {
        $validator = ArticleValidator::init('comment', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $record = new ArticleComment();

        $record->text = $request->text;
        $record->article_id = $request->article_id;
        $record->user_id = Auth::user()->id;
        if ($request->has('comment_id') && $request->comment_id != null)
            $record->comment_id = $request->comment_id;

        if (!$record->save())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно написали', 'comment' => $record->toArray()])->setStatusCode(200);

    }

    /**
     * Удалить коммент
     * @param $id
     * @return JsonResponse
     */
    public function commentDelete($id)
    {
        $validator = ArticleValidator::init('comment_delete', ['comment_id' => (int)$id]);

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $record = ArticleComment::where([['user_id', Auth::user()->id], ['id', (int)$id]])->first();

        if (!$record->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

    /**
     * Просмотр записи
     * @param Request $request
     * @return JsonResponse
     */
    public function view(Request $request)
    {
        $validator = ArticleValidator::init('check', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $like = ArticleViews::query()->where([
            ['article_id', (int)$request->article_id],
            ['user_id', Auth::user()->id]
        ])->first();

        if ($like)
            return response()->json(['error' => 'У вас уже есть просмотр'])->setStatusCode(500);

        ArticleViews::query()->create([
            'article_id' => (int)$request->article_id,
            'user_id' => Auth::user()->id
        ]);

        return response()->json(['success' => 'Успешно сохранили'])->setStatusCode(200);

    }

    /**
     * Лайкнуть запись
     * @param Request $request
     * @return JsonResponse
     */
    public function like(Request $request)
    {
        $validator = ArticleValidator::init('check', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $like = new ArticleLikes();

        $like->article_id = $request->article_id;
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
        $validator = ArticleValidator::init('check', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        if (!ArticleLikes::where([['user_id', Auth::user()->id], ['article_id', $request->article_id]])->exists())
            return response()->json(['error' => 'У вас нет лайка на эту запись'])->setStatusCode(422);

        $like = ArticleLikes::where([['user_id', Auth::user()->id], ['article_id', $request->article_id]])->first();

        if (!$like->delete())
            return response()->json(['error' => 'Что-то пошло не так, попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили'])->setStatusCode(200);

    }

}

