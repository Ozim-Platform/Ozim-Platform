<?php

namespace App\Http\Resources;

use App\Models\ArticleComment;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;

class CommentWithoutArticleResource extends CommentResource
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

    public function replies($id = null)
    {
        if ($id != null)
            $comments = ArticleComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->get();

        if ($id == null)
            $comments = ArticleComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->get();

        return CommentWithoutArticleReplyResource::collection($comments);
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
