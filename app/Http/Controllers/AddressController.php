<?php

namespace App\Http\Controllers;

use App\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class AddressController extends Controller
{
    public function getCountries() {
        $countries = Address::select('country')->distinct()->get();
        return response(['countries' => json_encode($countries)], 200);
    }

    public function getCities(Request $request) {
        $countries = json_decode($request->countries);
        $countriesAndCities = [];
        for ($i = 0; $i < count($countries); $i++) {
            $find_cities = Address::select('country', 'city')->where('country', '=', $countries[$i])->find();
            $countriesAndCities[] = $find_cities;
        }
        return response()->json($countriesAndCities, Response::HTTP_OK);
    }
}
