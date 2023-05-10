<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Http\Resources\FAQResource;
use App\Http\Validators\LanguageValidator;
use App\Models\Faq;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FaqController extends Controller
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

        $faqs = Faq::where('language', $request->language ?? 'ru')->orderByDesc('id')->paginate(10);

        return response()->json(['data' => FAQResource::collection($faqs),
        'page' => $faqs->currentPage(),
        'pages' => $faqs->lastPage()])->setStatusCode(200);
    }

}
