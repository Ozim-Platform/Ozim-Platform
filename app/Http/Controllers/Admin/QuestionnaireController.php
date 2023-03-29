<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Questionnaire as Model;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class QuestionnaireController extends Controller
{

    public function index(){
        $namespace_create = 'admin.questionnaire.create';
        $namespace_edit = 'admin.questionnaire.edit';
        $namespace_destroy = 'admin.questionnaire.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function select()
    {
        $questionnaire = Model::query()->where('id', (int)request()->questionnaire_id)->first();

        return response()->json($questionnaire->questions)->setStatusCode(200);
    }

    public function create(){
        $namespace_index = 'admin.questionnaire.index';
        $namespace_store = 'admin.questionnaire.store';
        $languages = Language::all();
        $categories = Category::where('type', 'questionnaire')->get();

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
                'age' => ['required', 'int'],
                'themes' => ['required', 'array'],
                'themes.*' => ['required', 'string'],
                'questions' => ['required', 'array'],
                'questions.*' => ['required', 'array'],
                'ranges' => ['required', 'array'],
                'ranges.*' => ['required', 'array'],
                'category' => ['nullable', 'exists:categories,sys_name,type,questionnaire'],
                'language' => ['nullable', 'exists:languages,sys_name'],
            ]);

        foreach ($request->ranges as $range){
            if (array_sum($range) >= 61)
                return Redirect::back()->with('error', 'Общая сумма диаграмм не должно превышать 60 : ' . implode(' ', $range));
            else if (array_sum($range) < 60)
                return Redirect::back()->with('error', 'Общая сумма диаграмм не должно быть меньше 60 : ' . implode('-', $range));
        }

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.questionnaire.index';

        $model = new Model();

        foreach($request->themes as $index => $theme){

            $questions[$theme] = ['questions' => $request->questions[$index]];
            if ($index !== 5)
            $questions[$theme]['ranges'] = $request->ranges[$index];
        }

        $model->age = (int)$request->age;
        $model->questions = $questions;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'questionnaire') : $model->image;
        $model->preview = $request->has('preview') && is_file($request->file('preview'))
            ? MediaHelper::uploadFile($request->file('preview'), 'preview', 'crop') : null;
        $model->author_photo = $request->has('author_photo') && is_file($request->file('author_photo'))
            ? MediaHelper::uploadFile($request->file('author_photo'), 'author_photo') : null;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.questionnaire.index';
        $namespace_update = 'admin.questionnaire.update';
        $languages = Language::all();
        $categories = Category::where('type', 'questionnaire')->get();

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

        $validator = Validator::make(array_merge(['id' => $id],$request->all()),
            [
                'id' => ['exists:questionnaires,_id'],
                'age' => ['required', 'int'],
                'themes' => ['required', 'array'],
                'themes.*' => ['required', 'string'],
                'questions' => ['required', 'array'],
                'questions.*' => ['required', 'array'],
                'ranges' => ['required', 'array'],
                'ranges.*' => ['required', 'array'],
                'category' => ['nullable', 'exists:categories,sys_name,type,questionnaire'],
                'language' => ['nullable', 'exists:languages,sys_name'],
            ]);

        foreach ($request->ranges as $range){
            if (array_sum($range) >= 61)
                return Redirect::back()->with('error', 'Общая сумма диаграмм не должно превышать 60% : ' . implode(' ', $range));
            else if (array_sum($range) < 60)
                return Redirect::back()->with('error', 'Общая сумма диаграмм не должно быть меньше 60% : ' . implode('-', $range));
        }

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.questionnaire.index';

        $model = Model::find($id);

        foreach($request->themes as $index => $theme){

            $questions[$theme] = ['questions' => $request->questions[$index]];
            if ($index !== 5)
                $questions[$theme]['ranges'] = $request->ranges[$index];
        }

        $model->age = (int)$request->age;
        $model->questions = $questions;
        $model->category = $request->category;
        $model->language = $request->language;
        $model->author = $request->author;
        $model->author_position = $request->author_position;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'questionnaire') : $model->image;
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
     * @param  Model $model
     * @return mixed
     **/
    public function destroy(Model $model, $id)
    {
        $namespace = 'admin.questionnaire.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
