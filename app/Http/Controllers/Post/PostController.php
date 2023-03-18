<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\models\Post;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Exception;

class PostController extends Controller
{
    public function createPost(Request $request)
    {

        $validated = $request->validate([
            'authorId' => 'required',
            'title' => 'required|unique:posts|max:255',
            'content' => 'required'
        ]);

        try {
            $newPost = new Post;

            $newPost->authorId = $request->authorId;
            $newPost->categoryId = $request->categoryId;
            $newPost->parentId = $request->parentId;
            $newPost->title = $request->title;
            $newPost->slug = Str::slug($request->title, '_');
            $newPost->metaTitle = $request->title;
            $newPost->summary =  Str::words($request->content, 5, '...');
            $newPost->published = 0;
            // $newPost->published = $request->published;
            $newPost->publishedAt = null;
            $newPost->content = $request->content;

            $savePost = $newPost->save();
            if ($savePost) {
                return response([
                    'message' => 'Post saved successfully',
                    'response_code' => 200
                ]);
            }
        } catch (Exception $ex) {
            return response([
                'message' => $ex
            ]);
        }
    }
}
