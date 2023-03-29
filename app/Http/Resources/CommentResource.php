<?php

namespace App\Http\Resources;

use App\Models\Api\Article;
use App\Models\ArticleComment;
use App\Models\User;
use App\Presenters\api\CommentPresenter;
use App\Presenters\api\User\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'text' => $this->text,
            'user' => $this->user(),
            'article' => $this->article(),
            'replies' => $this->replies(),
            'repliesCount' => $this->repliesCount(),
            'created_at' => $this->created_at,
        ];
    }

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

        return new ArticleResource($article);
    }

    public function replies($id = null)
    {
        if ($id != null)
            $comments = ArticleComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->get();

        if ($id == null)
            $comments = ArticleComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->get();

        return CommentWithoutArticleResource::collection($comments);
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
