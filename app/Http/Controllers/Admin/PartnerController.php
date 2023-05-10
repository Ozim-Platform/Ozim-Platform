<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Partner as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PartnerController extends Controller
{

    public function index(){
        $namespace_create = 'admin.partner.create';
        $namespace_edit = 'admin.partner.edit';
        $namespace_destroy = 'admin.partner.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.partner.index';
        $namespace_store = 'admin.partner.store';

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'max:255'],
                'title' => ['required', 'max:255'],
                'description' => ['required'],
                'expires' => ['required'],
                'price' => ['required', 'int'],
                'image' => ['required', 'image'],
                'images' => ['required', 'array'],
                'images.*' => ['required', 'image'],
            ],[
                'title.required' => 'title | Обязателен для заполнения',
                'name.required' => 'name | Обязателен для заполнения',
                'expires.required' => 'expires | Обязателен для заполнения',
                'price.required' => 'price | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
                'images.required' => 'images | Обязателен для заполнения',
                'image.required' => 'image | Обязателен для заполнения',
                'images.*.required' => 'images.* | Обязателен для заполнения',
                'images.*.image' => 'images.* | Должен быть изображением',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.partner.index';

        $model = new Model();
        $model->title = $request->title;
        $model->name = $request->name;
        $model->expires = $request->expires;
        $model->is_paid = (bool)$request->is_paid;
        $model->description = $request->description;
        $model->price = $request->price;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'partner') : $model->image;
        $model->images = $request->has('images')
            ? MediaHelper::uploadFiles($request->images, 'partner') : $model->images;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.partner.index';
        $namespace_update = 'admin.partner.update';

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
        ]);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(),
            [
                'name' => ['required', 'max:255'],
                'title' => ['required', 'max:255'],
                'description' => ['required'],
                'expires' => ['required'],
                'price' => ['required', 'int'],
                'image' => ['nullable', 'image'],
                'images' => ['nullable', 'array'],
                'images.*' => ['required', 'image'],
            ],[
                'title.required' => 'title | Обязателен для заполнения',
                'name.required' => 'name | Обязателен для заполнения',
                'expires.required' => 'expires | Обязателен для заполнения',
                'price.required' => 'price | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
                'image.required' => 'image | Обязателен для заполнения',
                'images.required' => 'images | Обязателен для заполнения',
                'images.*.required' => 'images.* | Обязателен для заполнения',
                'images.*.image' => 'images.* | Должен быть изображением',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.partner.index';

        $model = Model::find($id);

        $model->title = $request->title;
        $model->name = $request->name;
        $model->expires = $request->expires;
        $model->is_paid = (bool)$request->is_paid;
        $model->description = $request->description;
        $model->price = $request->price;

        if ($request->has('image')){
            if ($model->image)
                Storage::delete($model->image['path']);

            $model->image = MediaHelper::uploadFile($request->image, 'partner');
        }

        if ($request->has('images')){
            if (is_array($model->images))
                foreach ($model->images as $image)
                    Storage::delete($image['path']);

            $model->images = MediaHelper::uploadFiles($request->images, 'partner');
        }

        if (!$model->update())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Model $model
     * @return mixed
     */
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.partner.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
