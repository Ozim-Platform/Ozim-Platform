<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use App\Models\Api\{Diagnoses, ForParent, Inclusion, Rights, ServiceProvider, Skill};
use App\Presenters\api\{ArticlePresenter,
    DiagnosisPresenter,
    FaqPresenter,
    ForParentPresenter,
    ForumPresenter,
    InclusionPresenter,
    LinkPresenter,
    QuestionnairePresenter,
    RightsPresenter,
    ServiceProviderPresenter,
    SkillPresenter};
use Jenssegers\Mongodb\Eloquent\Model;

class RecordBookmarks extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'record_bookmarks';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        'folder',
        'record'
    ];

    public function getFolderAttribute()
    {
        return RecordBookmarkFolder::where('id', $this->attributes['folder'])->first();
    }

    public function getRecordAttribute()
    {
        switch ($this->type)
        {
            case 'article':

                $data = Article::query()->where('id', $this->record_id)->first();

                $model = new ArticlePresenter($data);

                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'category' => $model->category,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'diagnosis':

                $data = Diagnoses::query()->where('id', $this->record_id)->first();

                $model = new DiagnosisPresenter($data);

                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'category' => $model->category,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'faq':
                $data = Faq::query()->where('id', $this->record_id)->first();

                $model = new FaqPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'for_parent':
                $data = ForParent::query()->where('id', $this->record_id)->first();

                $model = new ForParentPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'category' => $model->category,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'forum':
                $data = Forum::query()->where('id', $this->record_id)->first();

                $model = new ForumPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'language' => $model->language,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'subcategory' => $model->subcategory,
                    'comments' => $model->comments(),
                    'user' => $model->user(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'inclusion':

                $data = Inclusion::query()->where('id', $this->record_id)->first();

                $model = new InclusionPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'category' => $model->category,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'link':

                $data = Link::query()->where('id', $this->record_id)->first();

                $model = new LinkPresenter($data);

                return [
                    'id' => $model->id,
                    'name' => $model->name,
                    'link' => $model->link,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'description' => $model->description,
                    'category' => $model->category,
                ];

                break;

            case 'questionnaire':

                $data = Questionnaire::query()->where('id', $this->record_id)->first();

                $model = new QuestionnairePresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'age' => $model->age,
                    'questions' => $model->questions,
                    'category' => $model->category,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'right':

                $data = Rights::query()->where('id', $this->record_id)->first();

                $model = new RightsPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'category' => $model->category,
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'created_at' => $model->created_at,
                ];

                break;

            case 'service_provider':

                $data = ServiceProvider::query()->where('id', $this->record_id)->first();

                $model = new ServiceProviderPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'phone' => $model->phone,
                    'email' => $model->email,
                    'link' => $model->link,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'rating' => $model->rating(),
                    'rated' => $model->rated(),
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'category' => $model->category,
                    'created_at' => $model->created_at,
                ];

                break;

            case 'skill':
                $data = Skill::query()->where('id', $this->record_id)->first();

                $model = new SkillPresenter($data);

                return [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'image' => $model->image,
                    'preview' => $model->preview,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder($this->folder->id),
                    'category' => $model->category,
                    'created_at' => $model->created_at,
                ];

                break;
        }
    }

}
