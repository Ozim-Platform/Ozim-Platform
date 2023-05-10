<?php

namespace App\Providers;

use App\Models\{ArticleBookmarkFolder,
    ArticleComment,
    Forum,
    ForumComment,
    QuestionnaireAnswer,
    RecordBookmarkFolder,
    RecordComment,
    RecordLike,
    RecordRating};
use App\Observers\{ArticleBookmarkFolderObserver,
    ArticleCommentObserver,
    ForumCommentObserver,
    ForumObserver,
    QAObserver,
    RecordBookmarkFolderObserver,
    RecordCommentObserver,
    RecordLikeObserver,
    RecordRatingObserver};
use Illuminate\Support\{ServiceProvider, Collection};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RepositoryServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ArticleComment::observe(ArticleCommentObserver::class);
        ForumComment::observe(ForumCommentObserver::class);
        RecordComment::observe(RecordCommentObserver::class);
        ArticleBookmarkFolder::observe(ArticleBookmarkFolderObserver::class);
        RecordBookmarkFolder::observe(RecordBookmarkFolderObserver::class);
        RecordLike::observe(RecordLikeObserver::class);
        QuestionnaireAnswer::observe(QAObserver::class);
        RecordRating::observe(RecordRatingObserver::class);
        Forum::observe(ForumObserver::class);

        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });
    }
}
