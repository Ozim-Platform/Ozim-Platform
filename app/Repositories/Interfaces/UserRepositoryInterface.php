<?php


namespace App\Repositories\Interfaces;


use App\Models\User;
use Illuminate\Http\Request;
use MongoDB\Collection;

interface UserRepositoryInterface
{
    /**
     * сохранение пользователя
     * @param array $data
     * @param bool $returned_object
     * @return mixed
     */
    public function store(array $data, bool $returned_object = false);

    /**
     * удаление пользователя
     * @param string $id
     * @return mixed
     */
    public function destroy(string $id);

    /**
     * получение айди роли пользователя по имени
     * @param string $name
     * @return mixed
     */
    public function userRoleIdByName(string $name);

    /**
     * получение пользователя по номеру телефона
     * @param string $phone
     * @return mixed
     */
    public function getUserByPhone(string $phone);

    /**
     * получение пользователя по номеру телефона
     * @param string $username
     * @return mixed
     */
    public function getUserByPhoneOrEmail(string $username, $field = 'phone');

    /**
     * получение пользователей по номеру телефона
     * @param string $phone
     * @return mixed
     */
    public function getUsersByPhoneLike(string $phone);

    /**
     * получение авторизованного пользователя
     * @return mixed
     */
    public function getAuthUser();

    /**
     * проверка на уникальность номера телефона
     * @param string $field
     * @param string $value
     * @param string $user_id
     * @return boolean
     */
    public function userFieldUniqueCheck(string $field,string $value,string $user_id) : bool ;

    /**
     * обновление пользователя
     * @param string $id
     * @param array $data
     * @return mixed
     */
    public function update(string $id,array $data);

    /**
     * загрузка аватара пользователя
     * @param string $user_id
     * @param $file
     * @return bool
     */
    public function updateAvatar(string $user_id,$file) : bool;

    /**
     * обновление пароля пользователя
     * @param string $password
     * @param string $phone
     * @return bool
     */
    public function updateUserPassword(string $phone,string $password) : bool;

    /**
     * обновление пароля авторизации пользователя
     * @param string $password
     * @param string $phone
     * @return bool
     */
    public function updateUserAuthPassword(string $phone,string $password) : bool;

    /**
     * получение коллекций ролей пользователей
     * @param bool $employee_only
     * @return Collection
     */
    public function userRoles($employee_only = false);

    /**
     * обновление роли пользователя
     * @param string $user_id
     * @param string $role
     * @return mixed
     */
    public function updateUserRole(string $user_id,string $role) : bool;

    /**
     * получение айди кск пользователя по айди
     * @return mixed
     */
    public function userKskIdByAuthUser();

    /**
     * получение сотрудников кск через айди
     * @param string $ksk_id
     * @param int $page
     * @param int $elements_count
     * @param bool $paginate
     * @return mixed
     */
    public function usersEmployeeListByKskId(string $ksk_id,int $page,int $elements_count = 10,bool $paginate = true);

    /**
     * получение ролей кск
     * @return mixed
     */
    public function userKskRoles();

    /**
     * получение должностей кск
     * @return mixed
     */
    public function userKskPosition();

    /**
     * проверка на существования сотрудника кск по номера телефона и айди кск
     * @param string $phone
     * @param string $ksk_id
     * @return mixed
     */
    public function userKskEmployeeByPhone(string $phone,string $ksk_id);

    /**
     * получение айди юзера по телефонному номера
     * @param string $phone
     * @return mixed
     */
    public function userIdByPhone(string $phone);

    /**
     * получение сотрудника по айди юзера и кск айди
     * @param string $user_id
     * @param string $ksk_id
     * @return mixed
     */
    public function userIdByIdAndKskId(string $user_id,string $ksk_id);

    /**
     * получение квартир пользователя
     * @param string $user_id
     * @return mixed
     */
    public function userApartments(string $user_id);

    /**
     * получение пользователя по телефону
     * или создай его если нет
     * @param string $phone
     * @param Request $request
     * @return User
     */
    public function getUserByPhoneOrCreate(string $phone,Request $request) :User;

    /**
     * получение сотрудников по идентификатору дома
     * @param string $house_id
     * @return mixed
     */
    public function getKskEmployeeByHouseId(string $house_id);

    /**
     * получение юзера по айди
     * @param string $id
     * @return User|null
     */
    public function getUserById(string $id) :?User;

    /**
     * получение пользователей по айди
     * @param array $ids
     * @param Request $request
     * @param bool $paginate
     */
    public function getUsersByIds(array $ids,Request $request,bool $paginate);

}