<?php

namespace App\Http\Resources;

use App\Models\RecordBookmarkFolder;
use App\Models\RecordBookmarks;
use App\Models\RecordComment;
use App\Models\RecordLike;
use App\Models\RecordView;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LinkResource extends JsonResource
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
            'name' => $this->name,
            'link' => $this->link,
            'is_paid' => $this->is_paid,
            'image' => $this->image,
            'preview' => $this->preview,
            'author' => $this->author,
            'author_position' => $this->author_position,
            'author_photo' => $this->author_photo,
            'likes' => $this->likes(),
            'views' => $this->views(),
            'is_liked' => $this->is_liked(),
            'comments' => $this->comments(),
            'in_bookmarks' => $this->in_bookmarks(),
            'bookmark_folder' => $this->bookmark_folder(),
            'description' => $this->description,
            'category' => $this->category,
        ];
    }

    public function likes($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['type', 'link']])->count();

        return RecordLike::where([['record_id', $this->id], ['type', 'link']])->count();
    }

    public function views($id = null)
    {
        if ($id != null)
            return RecordView::where([['record_id', $id], ['type', 'link']])->count();

        return RecordView::where([['record_id', $this->id], ['type', 'link']])->count();
    }

    public function is_liked($id = null)
    {
        if ($id != null)
            return RecordLike::where([['record_id', $id], ['user_id', Auth::user()->id], ['type', 'link']])->exists();

        return RecordLike::where([['record_id', $this->id], ['user_id', Auth::user()->id], ['type', 'link']])->exists();
    }

    public function in_bookmarks($id = null)
    {
        if ($id != null)
            return RecordBookmarks::where([['record_id', $id], ['user_id', Auth::user()->id], 'type', 'link'])->exists();

        return RecordBookmarks::where([['record_id', $this->id], ['user_id', Auth::user()->id], 'type', 'link'])->exists();
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
            $comments = RecordComment::where([['record_id', $this->id],['comment_id', 'exists', false], ['type', 'link']])->get();

        if ($id != null)
            $comments = RecordComment::where([['record_id', $id], ['comment_id', 'exists', false], ['type', 'link']])->get();

        return RecordCommentResource::collection($comments);
    }

}