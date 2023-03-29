<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Faq as Model;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class FaqController extends Controller
{

    public function index(){
        $namespace_create = 'admin.faq.create';
        $namespace_edit = 'admin.faq.edit';
        $namespace_destroy = 'admin.faq.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.faq.index';
        $namespace_store = 'admin.faq.store';
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
                'title' => ['required'],
                'description' => ['required'],
            ],[
                'title.required' => 'name | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.faq.index';

        $model = new Model();
        $model->title = $request->title;
        $model->description = $request->description;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'faq') : $model->image;
        $model->language = $request->language ?? 'ru';

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.faq.index';
        $namespace_update = 'admin.faq.update';
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
        $namespace_index = 'admin.faq.index';

        $model = Model::find($id);

        $model->title = $request->title;
        $model->description = $request->description;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'faq') : $model->image;
        $model->language = $request->language ?? 'ru';

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
        $namespace = 'admin.faq.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
