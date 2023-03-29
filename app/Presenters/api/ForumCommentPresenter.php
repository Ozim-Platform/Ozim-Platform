<?php


namespace App\Presenters\api;

use App\Models\ForumComment;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;

class ForumCommentPresenter extends BasePresenter
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

    public function replies($id = null)
    {
        if ($id != null)
            $comments = ForumComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->get();

        if ($id == null)
            $comments = ForumComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->get();

        return $comments->present(ForumCommentPresenter::class)->map(function ($model){
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
            $comments = ForumComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->count();

        if ($id == null)
            $comments = ForumComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->count();

        return $comments;
    }

}