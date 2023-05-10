<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Category as Model;
use App\Models\CategoryType;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index(){
        $namespace_create = 'admin.category.create';
        $namespace_edit = 'admin.category.edit';
        $namespace_destroy = 'admin.category.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.category.index';
        $namespace_store = 'admin.category.store';
        $languages = Language::all();
        $category_types = CategoryType::all();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'category_types' => $category_types,
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

        $namespace_index = 'admin.category.index';

        $model = new Model();
        $model->name = $request->name;
        $model->type = $request->type;
        $model->language = $request->language;
        $model->sys_name = Str::slug($request->name, '_').time();

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.category.index';
        $namespace_update = 'admin.category.update';
        $languages = Language::all();
        $category_types = CategoryType::all();

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
            'languages' => $languages,
            'category_types' => $category_types,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.category.index';

        $model = Model::find($id);

        $model->name = $request->name;
        $model->type = $request->type;
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
        $namespace = 'admin.category.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
