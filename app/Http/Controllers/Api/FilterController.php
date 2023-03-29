<?php

namespace App\Http\Controllers\Api;



use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Region;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FilterController extends Controller
{

    /**
     * Show the application dashboard.
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {

        $regions = Region::all();
        $cities = City::all();
        $age = [
            '0-3',
            '3-6',
            '6-9',
            '9-12',
            '12-18',
            '18-24',
            '24-36',
        ];

        return response()->json(['regions' => $regions, 'cities' => $cities, 'age' => $age])->setStatusCode(200);
    }

}
