<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\DiagnosisResource;
use App\Http\Validators\Api\DiagnosisValidator;
use App\Models\Api\Diagnoses as Model;
use App\Presenters\api\DiagnosisPresenter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class DiagnosisController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = DiagnosisValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $diagnoses = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->orderByDesc('id')->paginate(10);

        return response()->json([
            'data' => DiagnosisResource::collection($diagnoses),
            'page' => $diagnoses->currentPage(),
            'pages' => $diagnoses->lastPage()
        ])->setStatusCode(200);
    }

}
