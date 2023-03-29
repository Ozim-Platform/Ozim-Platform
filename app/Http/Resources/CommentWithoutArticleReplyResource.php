<?php

namespace App\Http\Resources;

use App\Models\User;
use App\Presenters\api\User\UserPresenter;

class CommentWithoutArticleReplyResource extends CommentResource
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
            'text' => $this->text,
            'user' => $this->user(),
            'created_at' => $this->created_at,
        ];
    }

    public function user($id = null)
    {
        if ($id != null)
            $user = User::where('id', $id)->first();

        if ($id == null)
            $user = User::where('id', $this->user_id)->first();

        if ($user === null)
            return null;

        $user = new UserPresenter($user);

        return [
            'id' => $user->id,
            'phone' => $user->phone,
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
        ];
    }

}
