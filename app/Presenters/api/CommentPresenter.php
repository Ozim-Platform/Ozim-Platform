<?php


namespace App\Presenters\api;

use App\Models\Api\Article;
use App\Models\ArticleComment;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;

class CommentPresenter extends BasePresenter
{
    public function user($id = null)
    {
        if ($id != null)
            $user = User::where('id', $id)->first();

        if ($id == null)
        $user = User::where('id', $this->user_id)->first();

        if ($user === null)
            return null;

        $user = new UserPresenter($user);

        return [
            'id' => $user->id,
            'phone' => $user->phone,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
        ];
    }

    public function article($id = null)
    {
        if ($id != null)
            $article = Article::where('id', $id)->first();

        if ($id == null)
        $article = Article::where('id', $this->article_id)->first();

        if ($article === null)
            return null;

        $model = new ArticlePresenter($article);

        return [
            'id' => $model->id,
            'name' => $model->name,
            'title' => $model->title,
            'description' => $model->description,
            'author' => $model->author,
            'author_position' => $model->author_position,
            'author_photo' => $model->author_photo,
            'category' => $model->category,
            'rating' => $model->rating(),
            'rated' => $model->rated(),
            'image' => $model->image,
            'preview' => $model->preview,
            'likes' => $model->likes(),
            'views' => $model->views(),
            'is_liked' => $model->is_liked(),
            'in_bookmarks' => $model->in_bookmarks(),
            'bookmark_folder' => $model->bookmark_folder(),
            'comments' => $model->comments(),
            'created_at' => $model->created_at,
        ];
    }

    public function replies($id = null)
    {
        if ($id != null)
            $comments = ArticleComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->get();

        if ($id == null)
            $comments = ArticleComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->get();

        return $comments->present(CommentPresenter::class)->map(function ($model){
            return [
                'id' => $model->id,
                'text' => $model->text,
                'user' => $model->user(),
                'replies' => $model->replies(),
                'repliesCount' => $model->repliesCount(),
                'created_at' => $model->created_at,
            ];
        });
    }

    public function repliesCount($id = null)
    {
        if ($id != null)
            $comments = ArticleComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->count();

        if ($id == null)
            $comments = ArticleComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->count();

        return $comments;
    }

}