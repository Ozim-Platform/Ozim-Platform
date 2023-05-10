<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Carbon\Carbon;
use Jenssegers\Mongodb\Eloquent\Model;

class UserChildren extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'user_children';

    protected $guarded = [];

    protected $casts = [
        'gender' => 'int'
    ];

    public function getAgeAttribute()
    {
        return Carbon::parse($this->birth_date)->diffInMonths(now());
    }

    public function getNewQuestionnairesAttribute()
    {

        $ids = $this->results()->pluck('questionnaire_id');
        return Questionnaire::query()->where(function ($q) use ($ids){

            if (!empty($ids))
                $q->whereNotIn('id', $ids);

            $q->where('age', $this->age);

        })->get();
    }

    public function results()
    {
        return $this->hasMany(QuestionnaireAnswer::class, 'child_id', 'id');
    }

    public function parent()
    {
        return $this->hasOne(User::class, 'id', 'parent_id');
    }

}
