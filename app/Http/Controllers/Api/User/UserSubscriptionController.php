<?php


namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\UserSubscription as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * класс предназначенный для работы с авторизированным пользователем
 * Class UserSubscriptionController
 * @package App\Http\Controllers\Api\User
 */
class UserSubscriptionController extends Controller
{

    /**
     *
     * @return JsonResponse
     */
    public function index() : JsonResponse
    {
        // верни
        return response()->json(Model::query()->where('value', 'exists', true)->first());
    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function subscription(Request $request) : JsonResponse
    {
        Model::query()->where('value', 'exists', true)->delete();

        $model = new Model();

        $model->value = $request->array;

        $model->save();

        // верни
        return response()->json($model);

    }

    /**
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request) : JsonResponse
    {
        $request->validate([
            'subscription' => ['required', 'bool'],
            'expires' => [Rule::requiredIf($request->subscription), 'date_format:Y-m-d']
        ],
        [
            'subscription.required' => 'subscription | Обязателен для заполнения!',
            'expires.required' => 'expires | Обязателен для заполнения!',
            'expires.format' => 'expires | Должен быть в формате 2022-02-02 : Y-m-d!',
        ]);

        auth()->user()->subscription()
            ->delete();

        $model = auth()->user()->subscription()
            ->create($request->all());

        // верни
        return response()->json($model);

    }

}
