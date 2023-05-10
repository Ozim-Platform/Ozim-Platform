<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Link as Model;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{

    public function index(){
        $namespace_create = 'admin.link.create';
        $namespace_edit = 'admin.link.edit';
        $namespace_destroy = 'admin.link.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.link.index';
        $namespace_store = 'admin.link.store';
        $languages = Language::all();
        $categories = Category::where('type', 'link')->get();

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
                'link' => ['required'],
                'description' => ['required'],
                'name' => ['required'],
                'book' => ['required'],
            ],[
                'link.required' => 'link | Обязателен для заполнения',
                'book.required' => 'file | Обязателен для заполнения',
                'name.required' => 'name | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.link.index';

        $model = new Model();
        $model->link = $request->link;
        $model->name = $request->name;
        $model->is_paid = (bool)$request->is_paid;
        $model->description = $request->description;
        $model->language = $request->language ?? 'ru';
        $model->category = $request->category;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'link') : $model->image;
        $model->book = $request->has('book')
            ? MediaHelper::uploadFile($request->book, 'books') : $model->book;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->file('author_photo'), 'author_photo') : null;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.link.index';
        $namespace_update = 'admin.link.update';
        $languages = Language::all();
        $categories = Category::where('type', 'link')->get();

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

        $validator = Validator::make($request->all(),
            [
                'name' => ['required'],
                'link' => ['required'],
                'description' => ['required'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
                'link.required' => 'link | Обязателен для заполнения',
                'description.required' => 'description | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.link.index';

        $model = Model::find($id);

        $model->link = $request->link;
        $model->name = $request->name;
        $model->is_paid = (bool)$request->is_paid;
        $model->description = $request->description;
        $model->language = $request->language ?? 'ru';
        $model->category = $request->category;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'link') : $model->image;
        $model->book = $request->has('book')
            ? MediaHelper::uploadFile($request->book, 'books') : $model->book;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->author_photo, 'author_photo') : $model->author_photo;
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
     * @return mixed
     */
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.link.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
