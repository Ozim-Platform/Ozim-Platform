<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Forum as Model;
use App\Models\Category;
use App\Models\ForumCategory;
use App\Models\ForumSubcategory;
use App\Models\Language;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ForumController extends Controller
{

    public function index(){
        $namespace_create = 'admin.forum.create';
        $namespace_edit = 'admin.forum.edit';
        $namespace_destroy = 'admin.forum.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.forum.index';
        $namespace_store = 'admin.forum.store';
        $languages = Language::all();
        $categories = ForumCategory::all();
        $subcategories = ForumSubcategory::all();
        $users = User::all();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'users' => $users,

        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'title' => ['required'],
            ],[
                'title.required' => 'title | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.forum.index';

        $model = new Model();
        $model->title = $request->title;
        $model->description = $request->description;
        $model->user_id = $request->user_id;
        $model->category = $request->category;
        $model->subcategory = $request->subcategory;
        $model->language = $request->language;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'forum') : $model->image;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.forum.index';
        $namespace_update = 'admin.forum.update';
        $languages = Language::all();
        $categories = ForumCategory::all();
        $subcategories = ForumSubcategory::all();
        $users = User::all();

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
            'languages' => $languages,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'users' => $users,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.forum.index';

        $model = Model::find($id);

        $model->title = $request->title;
        $model->description = $request->description;
        $model->user_id = $request->user_id;
        $model->category = $request->category;
        $model->subcategory = $request->subcategory;
        $model->language = $request->language;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'forum') : $model->image;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : $model->preview;

        if (!$model->update())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.forum.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
