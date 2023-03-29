<?php


namespace App\Observers;


use App\Models\RecordBookmarks;


class RecordBookmarkFolderObserver
{

    public function deleted($folder){

        $data = RecordBookmarks::query()->where([['type', $folder->type], ['folder', $folder->id]])->get();

        foreach ($data as $item) {
            $item->delete();
        }

    }


}