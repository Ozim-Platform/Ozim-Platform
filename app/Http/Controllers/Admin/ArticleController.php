<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Article as Model;
use App\Models\Category;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{

    public function index(){
        $namespace_create = 'admin.article.create';
        $namespace_edit = 'admin.article.edit';
        $namespace_destroy = 'admin.article.destroy';

        $items = Model::paginate(10);

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.article.index';
        $namespace_store = 'admin.article.store';
        $languages = Language::all();
        $categories = Category::where('type', 'article')->get();


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
                'name' => ['required', 'unique:articles'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
                'name.unique' => 'name | Такая категория уже есть: ' . $request->name,
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.article.index';

        $model = new Model();
        $model->name = $request->name;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->is_paid = (bool)$request->is_paid;
        $model->tags = $request->tags;
        $model->image = $request->has('image') && is_file($request->file('image'))
            ? MediaHelper::uploadFile($request->file('image'), 'article') : null;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : null;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->file('author_photo'), 'author_photo') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.article.index';
        $namespace_update = 'admin.article.update';
        $languages = Language::all();
        $categories = Category::where('type', 'article')->get();

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
        $namespace_index = 'admin.article.index';

        $model = Model::find($id);

        $model->name = $request->name;
        $model->title = $request->title;
        $model->description = $request->description;
        $model->author = $request->author;
        $model->is_paid = (bool)$request->is_paid;
        $model->author_position = $request->author_position;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->tags = $request->tags;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'article') : $model->image;
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
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.article.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
