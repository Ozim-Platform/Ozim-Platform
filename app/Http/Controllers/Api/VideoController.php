<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VideoResource;
use App\Http\Validators\LanguageValidator;
use App\Models\Video;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class VideoController extends Controller
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

        $videos = Video::where('language', $request->language ?? 'ru')->when($request->category, function ($q, $k){
            $q->where('category', $k);
        })->paginate(10);

        return response()->json(['data' => VideoResource::collection($videos),
            'page' => $videos->currentPage(),
            'pages' => $videos->lastPage()])->setStatusCode(200);
    }

}

