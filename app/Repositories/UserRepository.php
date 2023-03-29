<?php


namespace App\Repositories;

use App\Helpers\{DefaultHelper,MediaHelper};
use App\Models\{User,UserRole};
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth,DB,Hash};
use MongoDB\Collection;

class UserRepository implements UserRepositoryInterface
{
    /**
     * добавление пользователя
     * @param array $data
     * @param bool $returned_object
     * @return mixed
     */
    public function store(array $data, bool $returned_object = false)
    {

        $user = new User();

        $user->fill($data);

        $user_created = $user->save();

        if($returned_object)
            return $user;

        return $user_created;
    }

    /**
     * удаление пользователя
     * @param string $id
     * @return bool
     */
    public function destroy(string $id)
    {
        return User::destroy($id);
    }

    /**
     * получение айди роли пользователя по имени
     * @param string $name
     * @return mixed
     */
    public function userRoleIdByName(string $name)
    {
        return UserRole::where('name_system',$name)->first()->{'_id'};
    }

    /**
     * получение пользователя по номеру телефона
     * @param string $phone
     * @return mixed
     */
    public function getUserByPhone(string $phone)
    {
        return User::where('phone',$phone)->first();
    }

    /**
     * получение пользователя по номеру телефона
     * @param string $username
     * @return mixed
     */
    public function getUserByPhoneOrEmail(string $username, $field = 'phone')
    {
        return User::where($field,$username)->first();
    }

    /**
     * получение пользователей по номеру телефона
     * @param string $phone
     * @return mixed
     */
    public function getUsersByPhoneLike($phone)
    {
        $user = User::where('phone', 'like', '%'.$phone.'%')->get();

        if ($user === null)
            return '';

        return $user->map(function ($target){
            return $target->_id;
        });
    }

    /**
     * получение авторизованного пользователя
     * @return Authenticatable
     */
    public function getAuthUser()
    {
        return Auth::user();
    }

    /**
     * проверка на уникальность номера телефона
     * @param string $field
     * @param string $value
     * @param string $user_id
     * @return boolean
     */
    public function userFieldUniqueCheck(string $field,string $value,string $user_id) : bool
    {
        if(User::where([[$field,'=',$value],['_id','!=',$user_id]])->count() > 0)
            return false;

        return true;
    }

    /**
     * обновление пользователя
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id,array $data)
    {
        return User::where('_id',$id)->update($data);
    }

    /**
     * загрузка аватара пользователя
     * @param string $user_id
     * @param $file
     * @return bool
     */
    public function updateAvatar(string $user_id,$file) : bool
    {

        // загрузка файла
        $file = MediaHelper::uploadFile($file,'avatar');

        return User::where('_id',$user_id)->update(['avatar' => $file['path']]);

    }

    /**
     * обновление пароля пользователя
     * @param string $password
     * @param string $phone
     * @return bool
     */
    public function updateUserPassword(string $phone,string $password) : bool
    {
        $password = Hash::make($password);

        return User::where('phone',$phone)->update(['password' => $password]);
    }

    /**
     * обновление пароля пользователя
     * @param string $password
     * @param string $phone
     * @return bool
     */
    public function updateUserAuthPassword(string $phone,string $password) : bool
    {
        $password = Hash::make($password);

        return User::where('phone',$phone)->update(['auth_password' => $password]);
    }

    /**
     * получение коллекций ролей пользователей
     * @param bool $employee_only
     * @return Collection
     */
    public function userRoles($employee_only = false)
    {
        if($employee_only)
            return UserRole::whereIn('name_system',['ksk_employee','ksk_manager'])->get();

        return UserRole::whereNotIn('name_system',['root','administrator','manager','akimat'])->get();
    }

    /**
     * обновление роли пользователя
     * @param string $user_id
     * @param string $role
     * @return bool
     * @throws \Exception
     */
    public function updateUserRole(string $user_id,string $role) : bool
    {
        $role_id = UserRole::where('name_system',$role)->first();

        if($role_id === null)
            throw new \Exception('User role not found');

        return User::where('_id',$user_id)->update(['role_id',$role_id->{'_id'}]);

    }

    /**
     * получение айди кск пользователя по айди
     * @return mixed
     * @throws \Exception
     */
    public function userKskIdByAuthUser()
    {
        // получение текущего авторизированного пользователя
        $user = $this->getAuthUser();

        // инициализация репозитория кск
        $kskRepository = new KskRepository();

        // если найден кск по айди тогда верни
        if($kskRepository->kskExistsById($user->ksk_id))
            return $user->ksk_id;

        // если не нашел кск айди у пользователя
        // тогда найди кск по айди пользователя
        try
        {
            $ksk_id = $kskRepository->kskGetByUserId($user->_id)->_id;
        }
        catch (\Exception $exception)
        {
            return false;
        }

        // отчистка памяти
        unset($user);

        return $ksk_id;

    }

    /**
     * получение сотрудников кск через айди
     * @param string $ksk_id
     * @param int $page
     * @param int $elements_count
     * @param bool $paginate
     * @return mixed
     */
    public function usersEmployeeListByKskId(string $ksk_id,int $page,int $elements_count = 10,bool $paginate = false)
    {

        // получений айди ролей работников
        $employee_roles_ids = UserRole::whereIn('name_system',
            ['ksk_employee','ksk_manager'])->get()
            ->pluck('_id')->toArray();

        $user_employee_list = User::where('ksk_id',$ksk_id)
            ->whereIn('role_id',$employee_roles_ids);

        if(!$paginate)
           return $user_employee_list->get();

       return $user_employee_list
           ->paginate($elements_count, ['*'], 'page', $page);
    }

    /**
     * получение ролей кск
     * @return mixed
     */
    public function userKskRoles()
    {
        return UserRole::whereIn('name_system',['ksk_manager','ksk_employee'])->get();
    }

    /**
     * получение должностей кск
     * @return mixed
     */
    public function userKskPosition()
    {
        return KskEmployeeRole::all();
    }

    /**
     * проверка на существования сотрудника кск по номера телефона и айди кск
     * @param string $phone
     * @param string $ksk_id
     * @return bool
     */
    public function userKskEmployeeByPhone(string $phone,string $ksk_id)
    {
        return User::where([['phone', $phone],['ksk_id', $ksk_id]])->exists();
    }

    /**
     * получение айди юзера по телефонному номера
     * @param string $phone
     * @return mixed
     */
    public function userIdByPhone(string $phone)
    {
        if(User::where('phone', $phone)->exists())
            return User::select(['_id'])->where('phone',$phone)->first();

        return false;
    }

    /**
     * получение сотрудника по айди юзера и кск айди
     * @param string $user_id
     * @param string $ksk_id
     * @return mixed
     */
    public function userIdByIdAndKskId(string $user_id,string $ksk_id)
    {
        if(!User::where([['_id',$user_id],['ksk_id',$ksk_id]])->exists())
            return false;

            return User::select(['_id'])->where([['_id',$user_id],['ksk_id',$ksk_id]])->first()->_id;
    }

    /**
     * получение квартир пользователя
     * @param string $user_id
     * @return Collection
     */
    public function userApartments(string $user_id)
    {

        $apartmentsOwners = ApartmentOwners::where('userId',$user_id)->get()->pluck('apartmentId','_id')
            ->toArray();

      return  Apartment::whereIn('_id',$apartmentsOwners)->get()->present(UserApartmentPresenter::class)
            ->map(function ($model) use ($user_id,$apartmentsOwners) {

                return [
                    '_id' => $model->_id,
                    'affilation' => $model->affilationName($user_id),
                    'floor_number' => (string) $model->floor_number,
                    'porch_number' => (string) $model->porch_number,
                    'apartment_number' => (string) $model->apartment_number,
                    'house' => $model->house(),
                    'ksk' => $model->ksk(),
                    'users_count' => $model->users_count,
                    'registration_id' => array_search($model->_id,$apartmentsOwners),
                ];

            });

    }

    /**
     * получение пользователя по телефону
     * или создай его если нет
     * @param string $phone
     * @param Request $request
     * @return User
     */
    public function getUserByPhoneOrCreate(string $phone,Request $request) :User
    {
        // получение пользователя
        $user = $this->getUserByPhone($phone);

        // если пользователь не найден тогда создай
        if($user === null)
        {
            // пароль для автороизаций
            $password = DefaultHelper::generateRandomNumber(4);

            // создание пользователя
            $user =  $this->store([
                'phone' => $phone,
                'password' => Hash::make($password),
                'auth_token' => Hash::make($password),
                'confirmed' => 1,
                'role_id' => $this->userRoleIdByName('user')
            ],true);
        }

        return $user;

    }

    /**
     * получение сотрудников кск через айди дома
     * @param $house_id
     * @return mixed
     */
    public function getKskEmployeeByHouseId($house_id)
    {
        $ksk_id = $this->userKskIdByAuthUser();

        $users = User::where('ksk_id', $ksk_id)->where(function ($query) use ($house_id){

            if($house_id !== null)
            {
                $query->where('ksk_houses_ids','all',[$house_id]);
                $query->orWhere('ksk_houses_ids','exists',false);
            }

        })->get();

        return $users;
    }

    /**
     * получение юзера по айди
     * @param string $id
     * @return User|null
     */
    public function getUserById(string $id) :?User
    {
        return User::find($id);
    }

    /**
     * получение пользователей по айди
     * @param array $ids
     * @param Request $request
     * @param bool $paginate
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getUsersByIds(array $ids,Request $request,bool $paginate = true)
    {
        $collection = User::select([
            '_id','name','phone','surname','patronymic'
        ])->orderBy('_id','DESC')
          ->where(function ($query) use ($request,$ids){

              $query->whereIn('_id',$ids);

              if($request->has('phone'))
              {
                  $query->where('phone','LIKE','%'.$request->phone.'%');
              }

              if($request->has('fio'))
              {

                  $query->whereRaw([
                      '$text'=>[
                          '$search'=> $request->fio,
                          '$language' => 'none'
                      ]
                  ]);

              }

          });

        if($paginate === true)
        {
            return $collection->paginate(10);
        }

        return $collection->get();

    }

}