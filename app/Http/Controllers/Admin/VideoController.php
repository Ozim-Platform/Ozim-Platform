<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Video as Model;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class VideoController extends Controller
{

    public function index(){
        $namespace_create = 'admin.video.create';
        $namespace_edit = 'admin.video.edit';
        $namespace_destroy = 'admin.video.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.video.index';
        $namespace_store = 'admin.video.store';
        $languages = Language::all();
        $categories = Category::where('type', 'video')->get();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'categories' => $categories,

        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
            ],[
                'title.required' => 'title | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
                'description.string' => 'description | Должен быть строкой',
                'title.string' => 'title | Должен быть строкой',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.video.index';

        $model = new Model();

        $model->title = $request->title;
        $model->description = $request->description;
        $model->name = $request->name;
        $model->link = $request->link;
        $model->tags = $request->tags;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->is_paid = (bool)$request->is_paid;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'image') : $model->image;
        $model->video = $request->has('video')
            ? MediaHelper::uploadFile($request->video, 'video') : $model->video;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : null;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->file('author_photo'), 'author_photo') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.video.index';
        $namespace_update = 'admin.video.update';

        if (!Model::where('_id', $id)->exists())
            return Redirect::route($namespace_index)->with('warning', __('messages.warning'));


        $languages = Language::all();
        $categories = Category::where('type', 'video')->get();

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
            'languages' => $languages,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.video.index';

        $validator = Validator::make($request->all(),
            [
                'title' => ['required', 'string'],
                'description' => ['required', 'string'],
            ],[
                'title.required' => 'title | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
                'description.string' => 'description | Должен быть строкой',
                'title.string' => 'title | Должен быть строкой',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        if (!Model::where('_id', $id)->exists())
            return Redirect::route($namespace_index)->with('warning', __('messages.warning'));

        $model = Model::find($id);

        $model->title = $request->title;
        $model->description = $request->description;
        $model->name = $request->name;
        $model->link = $request->link;
        $model->tags = $request->tags;
        $model->is_paid = (bool)$request->is_paid;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'video') : $model->image;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : $model->preview;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->author_photo, 'author_photo') : $model->author_photo;

        if (!$model->update())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $model
     * @return \Illuminate\Http\Response|RedirectResponse
     */
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.video.index';

        if (!Model::where('_id', $id)->exists())
            return Redirect::route($namespace)->with('warning', __('messages.warning'));

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
