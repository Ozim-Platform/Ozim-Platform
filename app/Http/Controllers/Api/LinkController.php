<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\LinkResource;
use App\Http\Validators\Api\LinkValidator;
use App\Models\Link as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LinkController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = LinkValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $links = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->orderByDesc('id')->paginate(10);

        return response()->json([
            'data' => LinkResource::collection($links),
            'page' => $links->currentPage(),
            'pages' => $links->lastPage()
        ])->setStatusCode(200);
    }

}
