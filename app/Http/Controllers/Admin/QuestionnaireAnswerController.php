<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Questionnaire;
use App\Models\QuestionnaireAnswer as Model;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class QuestionnaireAnswerController extends Controller
{

    public function index(){
        $namespace_create = 'admin.questionnaire_answer.create';
        $namespace_edit = 'admin.questionnaire_answer.edit';
        $namespace_destroy = 'admin.questionnaire_answer.destroy';

        $items = Model::paginate();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.questionnaire_answer.index';
        $namespace_store = 'admin.questionnaire_answer.store';
        $languages = Language::all();
        $questionnaires = Questionnaire::all();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'questionnaires' => $questionnaires,

        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'description' => ['required'],
            ],[
                'description.required' => 'description | Обязателен для заполнения',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.questionnaire_answer.index';

        $model = new Model();

        $answers = [];

        $answers[] = (bool)$request->answers0;
        $answers[] = (bool)$request->answers1;
        $answers[] = (bool)$request->answers2;
        $answers[] = (bool)$request->answers3;
        $answers[] = (bool)$request->answers4;
        $answers[] = (bool)$request->answers5;
        $answers[] = (bool)$request->answers6;
        $answers[] = (bool)$request->answers7;

        $model->questionnaire_id = $request->questionnaire_id;
        $model->description = $request->description;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'q_answer') : $model->image;
        $model->answers = $answers;
        $model->language = $request->language;

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.questionnaire_answer.index';
        $namespace_update = 'admin.questionnaire_answer.update';
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
        $namespace_index = 'admin.questionnaire_answer.index';

        $answers = [];

        $answers[] = (bool)$request->answers0;
        $answers[] = (bool)$request->answers1;
        $answers[] = (bool)$request->answers2;
        $answers[] = (bool)$request->answers3;
        $answers[] = (bool)$request->answers4;
        $answers[] = (bool)$request->answers5;
        $answers[] = (bool)$request->answers6;
        $answers[] = (bool)$request->answers7;

        $model = Model::find($id);

        $model->description = $request->description;
        $model->image = $request->has('image')
            ? MediaHelper::uploadFile($request->image, 'q_answer') : $model->image;
        $model->answers = $answers;
        $model->language = $request->language;

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
        $namespace = 'admin.questionnaire_answer.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
