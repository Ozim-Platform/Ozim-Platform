<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Validators\LanguageValidator;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = LanguageValidator::init('check', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        return response()->json(Category::where(function ($query) use ($request){

            if ($request->has('language'))
                $query->where('language', $request->language ?? 'ru');

            if ($request->has('type'))
                $query->where('type', $request->type);

        })->get())->setStatusCode(200);
    }

}
