<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionnaireAnswerResource extends JsonResource
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
            'answers' => $this->answers,
            'age' => $this->age,
            'child_id' => $this->child_id,
            'questionnaire_id' => $this->questionnaire_id,
            'questionnaire' => new QuestionnaireResource($this->whenLoaded('questionnaire')),
        ];
    }

}
