<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Http\Validators\Api\SkillValidator;
use App\Models\Api\Skill as Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SkillController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $validator = SkillValidator::init('index', $request->all());

        if ($validator->fails())
            return response()->json(['error' => $validator->errors()->first()])->setStatusCode(422);

        $skills = Model::where(function ($query) use ($request){

            $query->where('language', $request->language);

            if ($request->has('category'))
                $query->where('category', $request->category);

            if ($request->has('id'))
                $query->where('id', (int)$request->id);

        })->paginate(10);

        return response()->json([
            'data' => SkillResource::collection($skills),
            'page' => $skills->currentPage(),
            'pages' => $skills->lastPage()
        ])->setStatusCode(200);
    }

}
