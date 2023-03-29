<?php


namespace App\Presenters\api;

use App\Models\Forum;
use App\Models\ForumComment;
use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordLike;
use App\Models\RecordView;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;
use Illuminate\Support\Facades\Auth;

class ForumPresenter extends BasePresenter
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
            return RecordLike::where([['record_id', $id], ['type', 'forum']])->count();

        return RecordLike::where([['record_id', $this->id], ['type', 'forum']])->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return RecordView::where([['record_id', $id], ['type', 'forum']])->count();

        return RecordView::where([['record_id', $this->id], ['type', 'forum']])->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'forum']])->exists();

        return RecordLike::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'forum']])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'forum']])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'forum']])->exists();
    }

    public function bookmark_folder($id = null)
    {
        if ($id != null)
            return RecordBookmarkFolder::where([['id', $id], ['user_id', Auth::user()->id]])->first();

        return RecordBookmarkFolder::where([['id', $this->folder], ['user_id', Auth::user()->id]])->first();
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

    public function comments($id = null)
    {
        if ($id == null)
            $comments = ForumComment::where([['forum_id', $this->id],['comment_id', 'exists', false]])->get();

        if ($id != null)
            $comments = ForumComment::where([['forum_id', $id], ['comment_id', 'exists', false]])->get();

        return $comments->present(ForumPresenter::class)->map(function ($model){
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

    public function forum($id = null)
    {
        if ($id != null)
            $forum = Forum::query()->where('id', (int)$id)->first();

        if ($id == null)
            $forum = Forum::query()->where('id', $this->forum_id)->first();

        if (!$forum)
            return null;

        $model = new ForumPresenter($forum);

        return [
            'id' => $model->id,
            'title' => $model->title,
            'description' => $model->description,
            'language' => $model->language,
            'image' => $model->image,
            'preview' => $model->preview,
            'likes' => $model->likes(),
            'views' => $model->views(),
            'subcategory' => $model->subcategory,
            'is_liked' => $model->is_liked(),
            'comments' => $model->comments(),
            'user' => $model->user(),
            'in_bookmarks' => $model->in_bookmarks(),
            'bookmark_folder' => $model->bookmark_folder(),
            'created_at' => $model->created_at,
        ];
    }

}