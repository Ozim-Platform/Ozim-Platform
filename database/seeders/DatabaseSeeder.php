<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            UserRoleSeeder::class,
            LanguageSeeder::class,
            UserTypeSeeder::class,
            CategorySeeder::class,
            ArticleSeeder::class,
            FaqSeeder::class,
            ForumSeeder::class,
            ForumCategorySeeder::class,
            ForumSubcategorySeeder::class,
            LinkSeeder::class,
            QuestionnaireSeeder::class,
            QuestionnaireAnswerSeeder::class,
            DiagnosesSeeder::class,
            SkillSeeder::class,
            ServiceProviderSeeder::class,
            RightsSeeder::class,
            InclusionSeeder::class,
            ForParentSeeder::class,
            RegionSeeder::class,
            CategoryTypeSeeder::class
        ]);
    }
}
