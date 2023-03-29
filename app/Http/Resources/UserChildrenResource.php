<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserChildrenResource extends JsonResource
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
            'birth_date' => $this->birth_date,
            'gender' => $this->gender,
            'age' => $this->age,
            'results' => QuestionnaireAnswerResource::collection($this->results()->with('questionnaire')->get())->collection->groupBy('age'),
            'new_questionnaires' => QuestionnaireResource::collection($this->new_questionnaires)->collection->groupBy('age')
        ];
    }

}
