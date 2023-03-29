<?php


namespace App\Http\Controllers\Api\User;

use App\Helpers\DefaultHelper;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Validators\Api\User\UserValidator;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * класс предназначенный для работы с авторизированным пользователем
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserController extends Controller
{
    // репозиторий пользователя
    private UserRepositoryInterface $userRepository;

    /**
     * конструктор класса
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * регистрация нового пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function registration(Request $request)
    {

        // инициализация валидатора
        $validator = UserValidator::init('registrationUser', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        // создание пользователя
        $user_created = $this->userRepository->store(
            array_merge($request->only('email', 'name', 'language', 'type'),
                ['password' => Hash::make($request->password),
                    'auth_password' => Hash::make($request->password),
                    'role' => 'user',
                    'points' => 0,
                    'avatar' => null,
                    'auth_token' => Hash::make(DefaultHelper::generateRandomNumber(15))
                ]));

        // проверка на неуспешность создания
        if ($user_created === false)
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        $user = User::query()->where('phone', $request->phone)->orWhere('email', $request->email)->first();

        return response()->json(['success' => 'Регистрация успешна', 'auth_token' => $user->auth_token, 'user' => new UserResource($user)])->setStatusCode(200);
    }

    /**
     * авторизация пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function authorization(Request $request)
    {

        // инициализация валидатора
        $validator = UserValidator::init('authorizationUser', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // получение пользователя по номеру телефона
        $user = $this->userRepository->getUserByPhoneOrEmail($request->username, $fieldType);

        // если пароль неправильный верни ошибку
        if (!$user)
            return response()->json(['error' => 'Такого пользователя нет'])->setStatusCode(422);

        // если auth_token пустой создай новый
        if ($user->auth_token === '') {
            $user->auth_token = Hash::make(DefaultHelper::generateRandomNumber(15));
            $user->save();
        }

        // верни пользователя
        return response()->json(['success' => 'Авторизация успешна', 'auth_token' => $user->auth_token])->setStatusCode(200);

    }

    /**
     * авторизация пользователя по паролю
     * @param Request $request
     * @return JsonResponse
     */
    public function authorizationPassword(Request $request)
    {

        // инициализация валидатора
        $validator = UserValidator::init('authorizationPassword', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $fieldType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        // получение пользователя по номеру телефона
        $user = $this->userRepository->getUserByPhoneOrEmail($request->username, $fieldType);

        // если пароль неправильный верни ошибку
        if (!Hash::check($request->password, $user->auth_password))
            return response()->json(['error' => 'Неверный пароль'])->setStatusCode(422);

        // если auth_token пустой создай новый
        if ($user->auth_token === '') {
            $user->auth_token = Hash::make(DefaultHelper::generateRandomNumber(4));
            $user->save();
        }

        // верни пользователя
        return response()->json(['success' => 'Авторизация успешна', 'auth_token' => $user->auth_token, 'user' => new UserResource($this->userRepository->getAuthUser())])->setStatusCode(200);

    }

    /**
     * отображение  авторизованного пользователя
     * @return JsonResponse
     */
    public function show()
    {
        return response()->json(new UserResource($this->userRepository->getAuthUser()))->setStatusCode(200);

    }

    /**
     * редактирование текущего пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function update(Request $request)
    {

        // инициализация валидатора
        $validator = UserValidator::init('updateUser', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        // получение текущего авторизированного пользователя
        $user = $this->userRepository->getAuthUser();

        // обновление данных пользователя
        $user_updated = $this->userRepository->update($user->_id, $request->only(
            ['name']));

        unset($user);

        // если сохранение не успешно верни ошибку
        if (!$user_updated)
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        // верни успешный ответ
        return response()->json(['success' => 'Данные успешно обновлены', 'user' => new UserResource($this->userRepository->getAuthUser())])->setStatusCode(200);

    }

    /**
     * редактирование аватара текущего пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function updateAvatar(Request $request)
    {

        // инициализация валидатора
        $validator = UserValidator::init('updateUserAvatar', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        // получение текущего авторизированного пользователя
        $user = $this->userRepository->getAuthUser();

        // загрузка аватара
        $avatar_updated = $this->userRepository->updateAvatar($user->_id, $request->avatar);

        // если сохранение не успешно верни ошибку
        if (!$avatar_updated)
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        // верни успешный ответ
        return response()->json(['success' => 'Аватар успешно обновлен', 'user' => new UserResource($this->userRepository->getAuthUser())])->setStatusCode(200);

    }



    /**
     * редактирование аватара текущего пользователя
     * @param Request $request
     * @return JsonResponse
     */
    public function changeLanguage(Request $request)
    {
        // инициализация валидатора
        $validator = UserValidator::init('updateUserLanguage', $request->all());

        // если в валидаторе есть ошибки верни первую
        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        // получение текущего авторизированного пользователя
        $user = $this->userRepository->getAuthUser();

        // обновление данных пользователя
        $user_updated = $this->userRepository->update($user->_id, $request->only(
            ['language']));

        // если сохранение не успешно верни ошибку
        if (!$user_updated)
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        // верни успешный ответ
        return response()->json(['success' => 'Язык успешно обновлен'])->setStatusCode(200);

    }



    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getPoints(Request $request)
    {
        // получение текущего авторизированного пользователя
        $user = $this->userRepository->getAuthUser();

        $user->points += 50;

        // если сохранение не успешно верни ошибку
        if (!$user->save())
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        // верни успешный ответ
        return response()->json(['success' => 'Баллы успешно начислили'])->setStatusCode(200);

    }



}
