<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\InclusionResource;
use App\Http\Validators\Api\InclusionValidator;
use App\Models\Api\Inclusion as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InclusionController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = InclusionValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $inclusions = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => InclusionResource::collection($inclusions),
            'page' => $inclusions->currentPage(),
            'pages' => $inclusions->lastPage()
        ])->setStatusCode(200);
    }

}
