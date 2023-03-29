<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use App\Models\Language as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class LanguageController extends Controller
{

    public function index(){
        $namespace_create = 'admin.language.create';
        $namespace_edit = 'admin.language.edit';
        $namespace_destroy = 'admin.language.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.language.index';
        $namespace_store = 'admin.language.store';

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'unique:languages'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
                'name.unique' => 'name | Такой язык уже есть: ' . $request->name,
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.language.index';

        $model = new Model();
        $model->name = $request->name;
        $model->sys_name = Str::slug($request->name, '_');

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.language.index';
        $namespace_update = 'admin.language.update';

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.language.index';

        $model = Model::find($id);

        $model->name = $request->name;

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
        $namespace = 'admin.language.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
