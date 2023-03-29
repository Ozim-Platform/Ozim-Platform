<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\ForumCategory as Model;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ForumCategoryController extends Controller
{

    public function index(){
        $namespace_create = 'admin.forum_category.create';
        $namespace_edit = 'admin.forum_category.edit';
        $namespace_destroy = 'admin.forum_category.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.forum_category.index';
        $namespace_store = 'admin.forum_category.store';
        $languages = Language::all();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => ['required'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.forum_category.index';

        $model = new Model();
        $model->name = $request->name;
        $model->language = $request->language;
        $model->sys_name = Str::slug($request->name, '_');

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.forum_category.index';
        $namespace_update = 'admin.forum_category.update';
        $languages = Language::all();

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
            'languages' => $languages,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.forum_category.index';

        $model = Model::find($id);

        $model->name = $request->name;
        $model->language = $request->language;

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
        $namespace = 'admin.forum_category.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
