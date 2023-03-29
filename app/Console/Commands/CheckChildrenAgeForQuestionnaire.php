<?php

namespace App\Console\Commands;

use App\Helpers\PushNotificationHelper;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer;
use App\Models\UserChildren;
use Illuminate\Console\Command;

class CheckChildrenAgeForQuestionnaire extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check_children_age';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send questionnaire push for Parents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $count = 0;

        $children = UserChildren::with('parent')->get();

        foreach($children as $child){
            $q_answers = QuestionnaireAnswer::query()
                ->where('child_id', $child->id)
                ->pluck('questionnaire_id');
            $questionnaire = Questionnaire::query()
                ->whereNotIn('id', $q_answers)
                ->where('age', $child->age)->count();
            $this->info($questionnaire);
            if ($questionnaire){
                PushNotificationHelper::sendPushForChildParent($child->parent->id, $child);
                $count++;
            }

        }

        $this->info('Отправлено ' . $count);

        return $count;
    }
}
