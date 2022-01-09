<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class PublicationCityBookController extends Controller
{
    public function index($city_id)
    {
        $books = Book::get()->where('city_id', $city_id);
        if (is_null($books)) return response()->json('Data not found', 404);
        return response()->json($books);
    }
}
