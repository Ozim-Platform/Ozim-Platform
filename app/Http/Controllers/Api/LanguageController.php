<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LanguageController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        return response()->json(Language::all())->setStatusCode(200);
    }

}
