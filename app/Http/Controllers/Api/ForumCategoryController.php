<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Validators\LanguageValidator;
use App\Models\ForumCategory as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForumCategoryController extends Controller
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

        return response()->json(Model::where('language', $request->language ?? 'ru')->get())->setStatusCode(200);
    }

}