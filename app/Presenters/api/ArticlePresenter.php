<?php


namespace App\Presenters\api;

use App\Models\ArticleComment;
use App\Models\ArticleLikes;
use App\Models\ArticleViews;
use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordRating;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;
use Illuminate\Support\Facades\Auth;

class ArticlePresenter extends BasePresenter
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
            return ArticleLikes::where('article_id', $id)->count();

        return ArticleLikes::where('article_id', $this->id)->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return ArticleViews::where('article_id', $id)->count();

        return ArticleViews::where('article_id', $this->id)->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return ArticleLikes::where([['article_id', $id], ['user_id', Auth::user()->id]])->exists();

        return ArticleLikes::where([['article_id', $this->id], ['user_id', Auth::user()->id]])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'article']])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'article']])->exists();
    }

    public function bookmark_folder($id = null)
    {
        if ($id != null)
            return RecordBookmarkFolder::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        return RecordBookmarkFolder::where([['id', $this->id], ['user_id', Auth::user()->id]])->first();
    }

    public function comments($id = null)
    {
        if ($id == null)
            $comments = ArticleComment::where([['article_id', $this->id],['comment_id', 'exists', false]])->get();

        if ($id != null)
            $comments = ArticleComment::where([['article_id', $id], ['comment_id', 'exists', false]])->get();

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

    public function rating($id = null)
    {
        if ($id != null)
            $ratings = RecordRating::where([['record_id', $id], ['type', 'article']])->pluck('rating');
        else
            $ratings = RecordRating::where([['record_id', $this->id], ['type', 'article']])->pluck('rating');

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
            $rating = RecordRating::query()->where([['record_id', $id], ['type', 'article'], ['user_id', Auth::user()->id]])->first();
        else
            $rating = RecordRating::query()->where([['record_id', $this->id], ['type', 'article'], ['user_id', Auth::user()->id]])->first();

        if (!$rating)
            return null;

        return $rating;

    }

}