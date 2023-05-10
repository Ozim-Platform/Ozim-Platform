<?php


namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserChildrenResource;
use App\Http\Resources\UserResource;
use App\Models\UserChildren;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * класс предназначенный для работы с детьми авторизированным пользователем
 * Class UserController
 * @package App\Http\Controllers\Api\User
 */
class UserChildrenController extends Controller
{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $children = auth()->user()->children()->orderByDesc('id')->paginate($request->limit ?? 10);

        return response()->json(['data' => UserChildrenResource::collection($children), 'page' => $children->currentPage(), 'pages' => $children->lastPage()]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {

        // инициализация валидатора
        $request->validate([
            'name' => ['required', 'max:255'],
            'gender' => ['required', 'int', Rule::in([1, 2])],
            'birth_date' => ['required', 'date_format:Y-m-d']
        ]);

        $child = auth()->user()->children()->create([
            'name' => $request->name,
            'gender' => $request->gender,
            'birth_date' => $request->birth_date,
        ]);

        // проверка на неуспешность создания
        if (!$child)
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно создали', 'user' => new UserResource(auth()->user())])->setStatusCode(200);
    }

    /**
     * @param Request $request
     * @param UserChildren $child
     * @return JsonResponse
     */
    public function update(Request $request, $child_id)
    {
        $request->replace(['child_id' => (int)$child_id, 'birth_date' => $request->birth_date]);

        // инициализация валидатора
        $request->validate([
            'child_id' => ['required', 'exists:user_children,id'],
            'birth_date' => ['required', 'date_format:Y-m-d']
        ]);

        $child = UserChildren::query()->where('id', (int)$child_id)->first();

        $child->fill([
            'birth_date' => $request->birth_date,
        ]);

        // проверка на неуспешность создания
        if (!$child->save())
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно обновили', 'user' => new UserResource(auth()->user())])->setStatusCode(200);
    }

    /**
     * @return JsonResponse
     */
    public function destroy($child_id)
    {
        $request = new Request(['child_id' => (int)$child_id]);

        // инициализация валидатора
        $request->validate([
            'child_id' => ['required', 'exists:user_children,id'],
        ]);

        $child = UserChildren::query()->where('id', (int)$child_id)->first();

        // проверка на неуспешность
        if (!$child->delete())
            return response()->json(['error' => 'Что то пошло не так попробуйте позже'])->setStatusCode(500);

        return response()->json(['success' => 'Успешно удалили', 'user' => new UserResource(auth()->user())])->setStatusCode(200);
    }


}
