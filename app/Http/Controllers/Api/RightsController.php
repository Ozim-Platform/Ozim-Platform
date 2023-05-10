<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\RightsResource;
use App\Http\Validators\Api\RightsValidator;
use App\Models\Api\Rights as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RightsController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = RightsValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $rights = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->orderByDesc('id')->paginate(10);

        return response()->json([
            'data' => RightsResource::collection($rights),
            'page' => $rights->currentPage(),
            'pages' => $rights->lastPage()
        ])->setStatusCode(200);
    }

}
