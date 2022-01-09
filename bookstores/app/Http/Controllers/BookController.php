<?php

namespace App\Http\Controllers;

use App\Http\Resources\BookCollection;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();
        return new BookCollection($books);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'description' => 'required',
            'author_id' => 'required',
            'city_id' => 'required'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $books = Book::create([
            'slug' => $request->slug, 'title' => $request->title, 'description' => $request->description,
            'author_id' => $request->author_id, 'city_id' => $request->city_id, 'user_id' => Auth::user()->id
        ]);

        return response()->json(['Book is created', new BookResource($books)]);
    }

    public function update(Request $request, Book $book)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'title' => 'required|string|max:100',
            'description' => 'required',
            'author_id' => 'required',
            'city_id' => 'required'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $book->slug = $request->slug;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->author_id = $request->author_id;
        $book->city_id = $request->city_id;

        $book->save();

        return response()->json(['Book is updated', new BookResource($book)]);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json('Book is deleted');
    }
}
