<?php

namespace App\Providers;

use App\Models\{ArticleBookmarkFolder, ArticleComment, ForumComment, RecordBookmarkFolder, RecordComment};
use App\Observers\{ArticleBookmarkFolderObserver,
    ArticleCommentObserver,
    ForumCommentObserver,
    RecordBookmarkFolderObserver,
    RecordCommentObserver};
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

        Collection::macro('present', function ($class) {
            return $this->map(function ($model) use ($class) {
                return new $class($model);
            });
        });
    }
}
