<?php

namespace App\Models;

use App\Presenters\api\ArticlePresenter;
use App\Presenters\api\DiagnosisPresenter;
use App\Presenters\api\FaqPresenter;
use App\Presenters\api\ForParentPresenter;
use App\Presenters\api\ForumPresenter;
use App\Presenters\api\InclusionPresenter;
use App\Presenters\api\LinkPresenter;
use App\Presenters\api\QuestionnairePresenter;
use App\Presenters\api\RightsPresenter;
use App\Presenters\api\ServiceProviderPresenter;
use App\Presenters\api\SkillPresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = [
        'created_at',
        'updated_at',
        'record_id',
        '_id',
    ];

    protected $appends = [
        'type',
        'language',
        'record'
    ];

    public function getTypeAttribute()
    {
        if (!isset($this->attributes['type']))
            return null;

        return CategoryType::query()->where('sys_name', $this->attributes['type'])->first();
    }

    public function getLanguageAttribute()
    {
        if (!isset($this->attributes['language']))
            return null;

        return Language::where('sys_name', $this->attributes['language'])->first();
    }

    public function getRecordAttribute()
    {
        if (!isset($this->attributes['type']))
            return null;

        if (!isset($this->attributes['record_id']))
            return null;

        switch ($this->attributes['type'])
        {
            case 'article':
                $model = Article::query()->where('id', (int)$this->attributes['record_id'])->first();
                $model = new ArticlePresenter($model);
                $data = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'title' => $model->title,
                    'description' => $model->description,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'category' => $model->category,
                    'image' => $model->image,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'comments' => $model->comments(),
                    'created_at' => $model->created_at,
                ];
                break;
            case 'diagnosis':
                $model = Diagnoses::query()->where('language', $request->language ?? 'ru')->first();
                $model = new DiagnosisPresenter($model);
                $data = [
                    'id' => $model->id,
                    'name' => $model->name,
                    'description' => $model->description,
                    'image' => $model->image,
                    'category' => $model->category,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'faq':
                $model = Faq::query()->where('language', $request->language ?? 'ru')->first();
                $model = new FaqPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'for_parent':
                $model = ForParent::query()->where('language', $request->language ?? 'ru')->first();
                $model = new ForParentPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'category' => $model->category,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'forum':
                $model = Forum::query()->where('language', $request->language ?? 'ru')->first();
                $model = new ForumPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'language' => $model->language,
                    'image' => $model->image,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
//                    'category' => $model->category,
//                    'subcategory' => $model->subcategory,
                    'comments' => $model->comments(),
                    'user' => $model->user(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'inclusion':
                $model = Inclusion::query()->where('language', $request->language ?? 'ru')->first();
                $model = new InclusionPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'category' => $model->category,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'link':
                $model = Link::query()->where('language', $request->language ?? 'ru')->first();
                $model = new LinkPresenter($model);
                $data = [
                    'id' => $model->id,
                    'link' => $model->link,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'description' => $model->description,
                    'category' => $model->category,
                ];
                break;

            case 'questionnaire':
                $model = Questionnaire::query()->where('language', $request->language ?? 'ru')->first();
                $model = new QuestionnairePresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'age' => $model->age,
                    'questions' => $model->questions,
                    'category' => $model->category,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'right':
                $model = Rights::query()->where('language', $request->language ?? 'ru')->first();
                $model = new RightsPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'category' => $model->category,
                    'bookmark_folder' => $model->bookmark_folder(),
                    'created_at' => $model->created_at,
                ];
                break;

            case 'service_provider':
                $model = ServiceProvider::query()->where('language', $request->language ?? 'ru')->first();
                $model = new ServiceProviderPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'name' => $model->name,
                    'description' => $model->description,
                    'image' => $model->image,
                    'rating' => $model->rating,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'category' => $model->category,
                    'created_at' => $model->created_at,
                ];
                break;

            case 'skill':
                $model = Skill::query()->where('language', $request->language ?? 'ru')->first();
                $model = new SkillPresenter($model);
                $data = [
                    'id' => $model->id,
                    'title' => $model->title,
                    'description' => $model->description,
                    'image' => $model->image,
                    'author' => $model->author,
                    'author_position' => $model->author_position,
                    'author_photo' => $model->author_photo,
                    'likes' => $model->likes(),
                    'views' => $model->views(),
                    'is_liked' => $model->is_liked(),
                    'comments' => $model->comments(),
                    'in_bookmarks' => $model->in_bookmarks(),
                    'bookmark_folder' => $model->bookmark_folder(),
                    'category' => $model->category,
                    'created_at' => $model->created_at,
                ];
                break;

        }

        return $data;
    }

}
