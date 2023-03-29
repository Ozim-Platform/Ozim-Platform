<?php

namespace App\Console\Commands;

use App\Models\CategoryType as Model;
use Illuminate\Console\Command;

class AddCategoryTypes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add_category_types';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new category types';

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

        $data =[
            [
                'name' => 'Видео',
                'sys_name' => 'video',
                'created_at' => date('Y-m-d'),
                'updated_at' => date('Y-m-d'),
            ],

        ];

        if (!Model::query()->where('sys_name', 'video')->exists())
            foreach($data as $i){
                $count++;
                // добавление категории
                Model::create($i);
            }

        $this->info('Добавлено ' . $count);

        return $count;
    }
}
