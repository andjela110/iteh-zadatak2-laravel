<?php

namespace App\Http\Controllers;

use App\Http\Resources\AuthorCollection;
use App\Http\Resources\AuthorResource;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::all();
        return new AuthorCollection($authors);
    }

    public function show(Author $author)
    {
        return new AuthorResource($author);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'resting_place' => 'required|string'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $author = Author::create(['slug' => $request->slug, 'name' => $request->name, 'resting_place' => $request->resting_place]);

        return response()->json(['Author is created', new AuthorResource($author)]);
    }

    public function update(Request $request, Author $author)
    {
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|max:100',
            'name' => 'required|string|max:100',
            'resting_place' => 'required|string'
        ]);

        if ($validator->fails()) return response()->json($validator->errors());
        $author->slug = $request->slug;
        $author->name = $request->name;
        $author->resting_place = $request->resting_place;
        $author->save();

        return response()->json(['Author is updated', new AuthorResource($author)]);
    }

    public function destroy(Author $author)
    {
        $author->delete();
        return response()->json('Author is deleted');
    }
}
