<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceProviderResource;
use App\Http\Validators\Api\ServiceProviderValidator;
use App\Models\Api\ServiceProvider as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = ServiceProviderValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $serviceProviders = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => ServiceProviderResource::collection($serviceProviders),
            'page' => $serviceProviders->currentPage(),
            'pages' => $serviceProviders->lastPage()
        ])->setStatusCode(200);
    }

}
