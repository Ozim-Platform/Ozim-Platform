<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\Banner as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BannerController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $banners = Model::where('language', $request->language ?? 'ru')->get();

        return response()->json($banners);
    }

}
