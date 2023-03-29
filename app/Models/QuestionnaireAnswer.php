<?php

namespace App\Models;

use App\Traits\UseAutoIncrementID;
use Jenssegers\Mongodb\Eloquent\Model;
use Jenssegers\Mongodb\Relations\HasOne;

class QuestionnaireAnswer extends Model
{

    use UseAutoIncrementID;

    protected $primaryKey = '_id';

    protected $table = 'questionnaire_answers';

    protected $guarded = [];

    protected $hidden = [
        '_id',
        'updated_at',
        'created_at',
    ];

    protected $appends = [
        //
    ];

    protected $casts = [
        'age' => 'int'
    ];

    public function questionnaire() : HasOne
    {
        return $this->hasOne(Questionnaire::class, 'id', 'questionnaire_id');
    }

    public function child() : HasOne
    {
        return $this->hasOne(UserChildren::class, 'id', 'child_id');
    }

}
