<?php


namespace App\Presenters\api;

use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordComment;
use App\Models\RecordLike;
use App\Models\RecordRating;
use App\Models\RecordView;
use App\Presenters\BasePresenter;
use Illuminate\Support\Facades\Auth;

class ServiceProviderPresenter extends BasePresenter
{
    public function likes($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['type', 'service_provider']])->count();

        return RecordLike::where([['record_id', $this->id], ['type', 'service_provider']])->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return RecordView::where([['record_id', $id], ['type', 'service_provider']])->count();

        return RecordView::where([['record_id', $this->id], ['type', 'service_provider']])->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'service_provider']])->exists();

        return RecordLike::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'service_provider']])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'service_provider']])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'service_provider']])->exists();
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
            $comments = RecordComment::where([['record_id', $this->id],['comment_id', 'exists', false], ['type', 'service_provider']])->get();

        if ($id != null)
            $comments = RecordComment::where([['record_id', $id], ['comment_id', 'exists', false], ['type', 'service_provider']])->get();

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

    public function rating($id = null)
    {
        if ($id != null)
            $ratings = RecordRating::where([['record_id', $id], ['type', 'service_provider']])->pluck('rating');
        else
            $ratings = RecordRating::where([['record_id', $this->id], ['type', 'service_provider']])->pluck('rating');

        $value = 0;

        foreach ($ratings as $rating) {
            $value += $rating;
        }

        if (sizeof($ratings) == 0)
            $size = 1;
        else
            $size = sizeof($ratings);

        return $value/$size;

    }

    public function rated($id = null)
    {
        if ($id != null)
            $rating = RecordRating::query()->where([['record_id', $id], ['type', 'service_provider'], ['user_id', Auth::user()->id]])->first();
        else
            $rating = RecordRating::query()->where([['record_id', $this->id], ['type', 'service_provider'], ['user_id', Auth::user()->id]])->first();

        if (!$rating)
            return null;

        return $rating;

    }
}