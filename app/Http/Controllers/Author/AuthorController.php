<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Author;
use Exception;

class AuthorController extends Controller
{
    // Author create section
    public function createAuthor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:authors|max:255',
            'mobile' => 'required',
            'email' => 'required',
            'passwordHash' => 'required',
        ]);

        try {
            $author = new Author;
            $author->name = $request->name;
            $author->mobile = $request->mobile;
            $author->email = $request->email;
            $author->passwordHash = $request->passwordHash;
            $author->intro = $request->intro;
            $author->profile = $request->profile;

            $author->save();

            return response([
                'message' => 'Success' . '. ' . $request->name . ' ' . 'added.',
                'response_code' => '200'
            ]);
        } catch (Exception $ex) {
            return response([
                'message' =>  $ex
            ]);
        };
    }

    // Get all authors
    public function getAllAuthor()
    {
        try {
            $allAuthors = Author::orderby('id')
                ->get(['id', 'name', 'mobile', 'email', 'intro', 'profile']);

            return response(([
                'total_authors' => count($allAuthors),
                'massage' => ' Success',
                'response_code' => 200,
                'getAllAuthors' => $allAuthors
            ]));
        } catch (Exception $ex) {
            return response([
                'message' => $ex
            ]);
        };
    }
}
