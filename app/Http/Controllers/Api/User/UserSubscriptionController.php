<?php


namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * класс предназначенный для работы с авторизированным пользователем
 * Class UsersubscriptionController
 * @package App\Http\Controllers\Api\User
 */
class UserSubscriptionController extends Controller
{

    /**
     * авторизация пользователя
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        // верни
        return response()->json(Model::query()->first());
    }

    /**
     * авторизация пользователя по паролю
     * @param Request $request
     * @return JsonResponse
     */
    public function subscription(Request $request) : JsonResponse
    {
        Model::query()->delete();

        $model = new Model();

        $model->value = $request->array;

        $model->save();

        // верни
        return response()->json($model);

    }

}
