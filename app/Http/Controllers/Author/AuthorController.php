<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Author;
use Exception;

class AuthorController extends Controller
{
    // Author registration section
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|unique:authors|max:255',
            'mobile' => 'required',
            'email' => 'required | email',
            'passwordHash' => 'required',
        ]);

        try {
            $author = new Author;
            $author->name = $request->name;
            $author->mobile = $request->mobile;
            $author->email = $request->email;
            $author->passwordHash = bcrypt($request->passwordHash);
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

    //Author login section
    public function login(Request  $req)
    {
        $validated = $req->validate([
            'email' => 'required | email',
            'password' => 'required',
        ]);

        try {
            $credentials = request(['email', 'password']);
            if ($credentials && $validated) {
                $author = Author::where('email', $req->email)
                    ->where('passwordHash', $req->password)
                    ->first(['id', 'name', 'email', 'mobile', 'profile']);
                $token = $author->createToken('authToken')->plainTextToken;
                return response()->json([
                    'response_code' => 200,
                    'message' => 'Success',
                    'token' => $token,
                    'author' => $author
                ]);
            } else {
                return response()->json([
                    'response_code' => 401,
                    'message' => 'Not loggedIn'
                ]);
            }
        } catch (Exception $ex) {
            return $ex;
        }
    }

    //logout author
    public function logout(Request $req)
    {
        try {
            $req->user()->currentAccessToken()->delete();
            return response()->json([
                'response_code' => 200,
                'message' => 'Token deleted successfully.'
            ]);
        } catch (Exception $ex) {
            return $ex;
        }
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
