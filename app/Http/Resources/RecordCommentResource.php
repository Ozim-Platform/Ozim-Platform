<?php

namespace App\Http\Resources;

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
use App\Models\Video;
use App\Presenters\api\User\UserPresenter;
use Illuminate\Http\Resources\Json\JsonResource;

class RecordCommentResource extends JsonResource
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
            'text' => $this->text,
            'user' => $this->user(),
            'replies' => $this->replies(),
            'repliesCount' => $this->repliesCount(),
            'created_at' => $this->created_at,
        ];
    }

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

        return self::collection($comments);
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

                $model = new DiagnosisResource($data);

                return $model;
                break;

            case 'faq':

                if ($id)
                    $data = Faq::query()->where('id', $id)->first();
                if (!$id)
                    $data = Faq::query()->where('id', $this->record_id)->first();

                $model = new FAQResource($data);

                return $model;

                break;

            case 'for_parent':

                if ($id)
                    $data = ForParent::query()->where('id', $id)->first();
                if (!$id)
                    $data = ForParent::query()->where('id', $this->record_id)->first();

                $model = new ForParentResource($data);

                return $model;

                break;

            case 'inclusion':
                if ($id)
                    $data = Inclusion::query()->where('id', $id)->first();
                if (!$id)
                    $data = Inclusion::query()->where('id', $this->record_id)->first();

                $model = new InclusionResource($data);

                return $model;

                break;

            case 'link':

                if ($id)
                    $data = Link::query()->where('id', $id)->first();
                if (!$id)
                    $data = Link::query()->where('id', $this->record_id)->first();

                $model = new LinkResource($data);

                return $model;

                break;

            case 'questionnaire':

                if ($id)
                    $data = Questionnaire::query()->where('id', $id)->first();
                if (!$id)
                    $data = Questionnaire::query()->where('id', $this->record_id)->first();

                $model = new QuestionnaireResource($data);

                return $model;

                break;

            case 'right':

                if ($id)
                    $data = Rights::query()->where('id', $id)->first();
                if (!$id)
                    $data = Rights::query()->where('id', $this->record_id)->first();

                $model = new RightsResource($data);

                return $model;

                break;

            case 'service_provider':

                if ($id)
                    $data = ServiceProvider::query()->where('id', $id)->first();
                if (!$id)
                    $data = ServiceProvider::query()->where('id', $this->record_id)->first();

                $model = new ServiceProviderResource($data);

                return $model;

                break;

            case 'skill':

                if ($id)
                    $data = Skill::query()->where('id', $id)->first();
                if (!$id)
                    $data = Skill::query()->where('id', $this->record_id)->first();

                $model = new SkillResource($data);

                return $model;

                break;

            case 'video':

                if ($id)
                    $data = Video::query()->where('id', $id)->first();
                if (!$id)
                    $data = Video::query()->where('id', $this->record_id)->first();

                $model = new VideoResource($data);

                return $model;

                break;
        }
    }

    public function repliesCount($id = null)
    {
        if ($id != null)
            $comments = RecordComment::where([['comment_id', $id], ['comment_id', 'exists', true]])->count();

        if ($id == null)
            $comments = RecordComment::where([['comment_id', $this->id], ['comment_id', 'exists', true]])->count();

        return $comments;
    }



}
