<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\ForParentResource;
use App\Http\Validators\Api\IndexValidator;
use App\Models\Api\ForParent as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ForParentController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = IndexValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $forParent = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => ForParentResource::collection($forParent),
            'page' => $forParent->currentPage(),
            'pages' => $forParent->lastPage()])->setStatusCode(200);
    }

}
