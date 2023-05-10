<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Api\Article;
use App\Models\Api\Diagnoses;
use App\Models\Api\Inclusion;
use App\Models\Api\Rights;
use App\Models\Api\ServiceProvider;
use App\Models\Api\Skill;
use App\Models\Banner as Model;
use App\Models\Category;
use App\Models\CategoryType;
use App\Models\Faq;
use App\Models\ForParent;
use App\Models\Forum;
use App\Models\Language;
use App\Models\Link;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BannerController extends Controller
{

    public function index(){
        $namespace_create = 'admin.banner.create';
        $namespace_edit = 'admin.banner.edit';
        $namespace_destroy = 'admin.banner.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.banner.index';
        $namespace_store = 'admin.banner.store';
        $languages = Language::all();
        $category_types = CategoryType::query()->where('sys_name', 'article')->get();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'category_types' => $category_types,
        ]);
    }

    public function store(Request $request){

        $namespace_index = 'admin.banner.index';

        $model = new Model();
        $model->record_id = $request->record_id;
        $model->type = $request->type;
        $model->language = $request->language;
        $model->image = $request->has('image') && is_file($request->file('image'))
            ? MediaHelper::uploadFile($request->file('image'), 'banner') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.banner.index';
        $namespace_update = 'admin.banner.update';
        $languages = Language::all();
        $category_types = CategoryType::query()->where('sys_name', 'article')->get();

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
        $namespace_index = 'admin.banner.index';

        $model = Model::find($id);

        $model->record_id = $request->record_id;
        $model->type = $request->type;
        $model->language = $request->language;
        $model->image = $request->has('image') && is_file($request->file('image'))
            ? MediaHelper::uploadFile($request->file('image'), 'banner') : $model->image;

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
        $namespace = 'admin.banner.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

    public function getRecordsByType(Request $request){

        if (!CategoryType::query()->where('sys_name', $request->type)->exists())
            return response()->json(['error' => 'Неправильный тип'])->setStatusCode(500);

        switch ($request->type)
        {
            case 'article':

                $model = Article::query()->where('category', Category::query()->where('name', 'Новости')->first()->{'sys_name'} ?? '')->get();
                break;
            case 'diagnosis':
                $model = Diagnoses::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'faq':
                $model = Faq::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'for_parent':
                $model = ForParent::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'forum':
                $model = Forum::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'inclusion':
                $model = Inclusion::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'link':
                $model = Link::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'questionnaire':
                $model = Questionnaire::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'right':
                $model = Rights::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'service_provider':
                $model = ServiceProvider::query()->where('language', $request->language ?? 'ru')->get();
                break;

            case 'skill':
                $model = Skill::query()->where('language', $request->language ?? 'ru')->get();
                break;

        }


        return response()->json($model)->setStatusCode(200);
    }

}
