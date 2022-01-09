<?php

namespace App\Http\Controllers;

use App\Http\Resources\PublicationCityCollection;
use App\Http\Resources\PublicationCityResource;
use App\Models\PublicationCity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PublicationCityController extends Controller
{
    public function index()
    {
        $cities = PublicationCity::all();
        return new PublicationCityCollection($cities);
    }

    public function show(PublicationCity $city)
    {
        return new PublicationCityResource($city);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $city = PublicationCity::create(['slug' => $request->slug, 'name' => $request->name, 'zip_code' => $request->zip_code]);

        return response()->json(['Publication city is created', new PublicationCityResource($city)]);
    }

    public function update(Request $request, PublicationCity $city)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'zip_code' => 'required|string|max:20'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $city->slug = $request->slug;
        $city->name = $request->name;
        $city->zip_code = $request->zip_code;
        $city->save();

        return response()->json(['Publication city is updated', new PublicationCityResource($city)]);
    }

    public function destroy(PublicationCity $city)
    {
        $city->delete();
        return response()->json('Publication city is deleted');
    }
}
