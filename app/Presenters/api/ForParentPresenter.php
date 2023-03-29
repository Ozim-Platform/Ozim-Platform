<?php


namespace App\Presenters\api;

use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordComment;
use App\Models\RecordLike;
use App\Models\RecordView;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;
use Illuminate\Support\Facades\Auth;

class ForParentPresenter extends BasePresenter
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

    public function likes($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['type', 'for_parent']])->count();

        return RecordLike::where([['record_id', $this->id], ['type', 'for_parent']])->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return RecordView::where([['record_id', $id], ['type', 'for_parent']])->count();

        return RecordView::where([['record_id', $this->id], ['type', 'for_parent']])->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['user_id' => auth()->user()->id], ['type', 'for_parent']])->exists();

        return RecordLike::where([['record_id', $this->id], ['user_id' => auth()->user()->id], ['type', 'for_parent']])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'for_parent']])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'for_parent']])->exists();
    }

    public function bookmark_folder($id = null)
    {
        if ($id != null)
            return RecordBookmarkFolder::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        return RecordBookmarkFolder::where([['id', $this->folder], ['user_id', Auth::user()->id]])->first();
    }

    public function comments($id = null)
    {
        if ($id == null)
            $comments = RecordComment::where([['record_id', $this->id],['comment_id', 'exists', false], ['type', 'for_parent']])->get();

        if ($id != null)
            $comments = RecordComment::where([['record_id', $id], ['comment_id', 'exists', false], ['type', 'for_parent']])->get();

        return $comments->present(RecordCommentPresenter::class)->map(function ($model){
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

}