<?php

namespace App\Http\Controllers\Admin;



use App\Helpers\DefaultHelper;
use App\Helpers\MediaHelper;
use App\Http\Controllers\Controller;
use App\Models\User as Model;
use App\Models\Language;
use App\Models\User;
use App\Models\UserRole;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index(){
        $namespace_create = 'admin.users.create';
        $namespace_edit = 'admin.users.edit';
        $namespace_destroy = 'admin.users.destroy';

        $items = Model::all();

        return view($this->controllerName(),[
            'items' => $items,
            'namespace_create' => $namespace_create,
            'namespace_edit' => $namespace_edit,
            'namespace_destroy' => $namespace_destroy,
        ]);
    }

    public function create(){
        $namespace_index = 'admin.users.index';
        $namespace_store = 'admin.users.store';
        $languages = Language::all();
        $types = UserType::all();
        $roles = UserRole::all();

        return view($this->controllerName(),[
            'namespace_index' => $namespace_index,
            'namespace_store' => $namespace_store,
            'languages' => $languages,
            'types' => $types,
            'roles' => $roles,

        ]);
    }

    public function store(Request $request){

        $validator = Validator::make($request->all(),
            [
                'name' => ['required'],
                'phone' => ['required'],
                'email' => ['required'],
                'type' => ['required', 'exists:users_types,sys_name'],
                'role' => ['required', 'exists:users_roles,sys_name'],
                'language' => ['required', 'exists:languages,sys_name'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
                'phone.required' => 'phone | Обязателен для заполнения',
                'email.required' => 'email | Обязателен для заполнения',
                'type.required' => 'type | Обязателен для заполнения',
                'type.exists' => 'type |Такой записи нет',
                'role.required' => 'role | Обязателен для заполнения',
                'role.exists' => 'role |Такой записи нет',
                'language.required' => 'language | Обязателен для заполнения',
                'language.exists' => 'language |Такой записи нет',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        $namespace_index = 'admin.users.index';

        $model = new Model();
        $model->name = $request->name;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->role = $request->role;
        $model->type = $request->type;
        $model->avatar = is_file($request->avatar)
            ? MediaHelper::uploadFile($request->avatar, 'avatar')['path'] : null;
        $model->language = $request->language;
        $model->password = Hash::make(DefaultHelper::generateRandomNumber(8));
        $model->auth_password = Hash::make(DefaultHelper::generateRandomNumber(8));
        $model->auth_token = Hash::make(DefaultHelper::generateRandomNumber(16));

        if (!$model->save())
            return Redirect::back()->with(['warning', __('messages.warning')]);

        return redirect()->route($namespace_index)->with('success', __('messages.added'));
    }

    public function edit($id){
        $namespace_index = 'admin.users.index';
        $namespace_update = 'admin.users.update';
        $languages = Language::all();
        $types = UserType::all();
        $roles = UserRole::all();

        $model = Model::find($id);

        return view($this->controllerName(),[
            'item' => $model,
            'namespace_index' => $namespace_index,
            'namespace_update' => $namespace_update,
            'languages' => $languages,
            'types' => $types,
            'roles' => $roles,
        ]);
    }

    public function update(Request $request, $id){
        $namespace_index = 'admin.users.index';

        $validator = Validator::make($request->all(),
            [
                'name' => ['required'],
                'phone' => ['required'],
                'email' => ['required'],
                'type' => ['required', 'exists:users_types,sys_name'],
                'role' => ['required', 'exists:users_roles,sys_name'],
                'language' => ['required', 'exists:languages,sys_name'],
            ],[
                'name.required' => 'name | Обязателен для заполнения',
                'phone.required' => 'phone | Обязателен для заполнения',
                'email.required' => 'email | Обязателен для заполнения',
                'type.required' => 'type | Обязателен для заполнения',
                'type.exists' => 'type |Такой записи нет',
                'role.required' => 'role | Обязателен для заполнения',
                'role.exists' => 'role |Такой записи нет',
                'language.required' => 'language | Обязателен для заполнения',
                'language.exists' => 'language |Такой записи нет',
            ]);

        if ($validator->fails())
        {
            return Redirect::back()->withErrors($validator);
        }

        if (User::where([['_id', '!=', $id], ['phone', $request->phone]])->exists())
            return Redirect::back()->with('warning', 'Такой номер уже используется: ' . $request->phone);

        $model = Model::find($id);

        $model->name = $request->name;
        $model->phone = $request->phone;
        $model->email = $request->email;
        $model->role = $request->role;
        $model->type = $request->type;
        $model->avatar = is_file($request->avatar)
            ? MediaHelper::uploadFile($request->avatar, 'avatar')['path']
            : $model->avatar;
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
        $namespace = 'admin.users.index';

        $model = Model::find($id);

        $model->delete();

        if (\request()->ajax()) {
            return response()->json(['success' => 'OK']);
        } else {
            return redirect()->route($namespace)->with('warning', __('messages.warning'));
        }
    }

}
