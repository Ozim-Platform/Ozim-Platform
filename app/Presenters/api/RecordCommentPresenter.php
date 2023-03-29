<?php


namespace App\Presenters\api;

use App\Models\Api\Article;
use App\Models\ArticleComment;
use App\Models\Diagnoses;
use App\Models\Faq;
use App\Models\ForParent;
use App\Models\Inclusion;
use App\Models\Link;
use App\Models\Questionnaire;
use App\Models\RecordComment;
use App\Models\Rights;
use App\Models\ServiceProvider;
use App\Models\Skill;
use App\Models\User;
use App\Presenters\api\User\UserPresenter;
use App\Presenters\BasePresenter;

class RecordCommentPresenter extends BasePresenter
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
            $comments = RecordComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->get();

        if ($id == null)
            $comments = RecordComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->get();

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

    public function record($type, $id = null)
    {
        switch ($type)
        {
            case 'diagnosis':
                if ($id)
                    $data = Diagnoses::query()->where('id', $id)->first();

                if (!$id)
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'created_at' => $model->created_at,
                    ];
                break;

            case 'faq':

                if ($id)
                    $data = Faq::query()->where('id', $id)->first();
                if (!$id)
                    $data = Faq::query()->where('id', $this->record_id)->first();

                $model = new FaqPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
                        'description' => $model->description,
                        'image' => $model->image,
                        'preview' => $model->preview,
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

                if ($id)
                    $data = ForParent::query()->where('id', $id)->first();
                if (!$id)
                    $data = ForParent::query()->where('id', $this->record_id)->first();

                $model = new ForParentPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'created_at' => $model->created_at,
                    ];

                break;

            case 'inclusion':
                if ($id)
                    $data = Inclusion::query()->where('id', $id)->first();
                if (!$id)
                    $data = Inclusion::query()->where('id', $this->record_id)->first();

                $model = new InclusionPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'created_at' => $model->created_at,
                    ];

                break;

            case 'link':

                if ($id)
                    $data = Link::query()->where('id', $id)->first();
                if (!$id)
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'description' => $model->description,
                        'category' => $model->category,
                    ];

                break;

            case 'questionnaire':

                if ($id)
                    $data = Questionnaire::query()->where('id', $id)->first();
                if (!$id)
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'created_at' => $model->created_at,
                    ];

                break;

            case 'right':

                if ($id)
                    $data = Rights::query()->where('id', $id)->first();
                if (!$id)
                    $data = Rights::query()->where('id', $this->record_id)->first();

                $model = new RightsPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'category' => $model->category,
                        'created_at' => $model->created_at,
                    ];

                break;

            case 'service_provider':

                if ($id)
                    $data = ServiceProvider::query()->where('id', $id)->first();
                if (!$id)
                    $data = ServiceProvider::query()->where('id', $this->record_id)->first();

                $model = new ServiceProviderPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
                        'name' => $model->name,
                        'description' => $model->description,
                        'image' => $model->image,
                        'preview' => $model->preview,
                        'rating' => $model->rating(),
                        'author' => $model->author,
                        'author_position' => $model->author_position,
                        'author_photo' => $model->author_photo,
                        'likes' => $model->likes(),
                        'views' => $model->views(),
                        'is_liked' => $model->is_liked(),
                        'comments' => $model->comments(),
                        'in_bookmarks' => $model->in_bookmarks(),
                        'category' => $model->category,
                        'created_at' => $model->created_at,
                    ];

                break;

            case 'skill':

                if ($id)
                    $data = Skill::query()->where('id', $id)->first();
                if (!$id)
                    $data = Skill::query()->where('id', $this->record_id)->first();

                $model = new SkillPresenter($data);

                    return [
                        'id' => $model->id,
                        'title' => $model->title,
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
                        'bookmark_folder' => $model->bookmark_folder(),
                        'category' => $model->category,
                        'created_at' => $model->created_at,
                    ];

                break;
        }
    }

    public function repliesCount($id = null)
    {
        if ($id != null)
            $comments = RecordComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->count();

        if ($id == null)
            $comments = RecordCommentPresenter::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->count();

        return $comments;
    }

}