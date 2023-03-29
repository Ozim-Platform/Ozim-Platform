<?php


namespace App\Observers;


use App\Models\ArticleBookmarks;


class ArticleBookmarkFolderObserver
{

    public function deleted($folder){
        $data = ArticleBookmarks::query()->where('folder', $folder->id)->get();

        foreach ($data as $item) {
            $item->delete();
        }

    }


}