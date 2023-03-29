<?php


namespace App\Presenters\api;

use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordComment;
use App\Models\RecordLike;
use App\Models\RecordView;
use App\Presenters\BasePresenter;
use Illuminate\Support\Facades\Auth;

class SkillPresenter extends BasePresenter
{
    public function likes($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['type', 'skill']])->count();

        return RecordLike::where([['record_id', $this->id], ['type', 'skill']])->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return RecordView::where([['record_id', $id], ['type', 'skill']])->count();

        return RecordView::where([['record_id', $this->id], ['type', 'skill']])->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'skill']])->exists();

        return RecordLike::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'skill']])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'skill']])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'skill']])->exists();
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
            $comments = RecordComment::where([['record_id', $this->id],['comment_id', 'exists', false], ['type', 'skill']])->get();

        if ($id != null)
            $comments = RecordComment::where([['record_id', $id], ['comment_id', 'exists', false], ['type', 'skill']])->get();

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