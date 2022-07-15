<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Post;
use Dotenv\Result\Success;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with(['category'])->paginate(6);
        foreach ($posts as $post) {
            // se il post ha l'attributo cover, aggiungiamo un prefisso per ottenere il path assoluto
            if($post->cover) {
                $post->cover = url('storage/' . $post->cover);
            } 
        }
        return response()->json([
            'success' => true,
            'results' => $posts
        ]);
    }

    public function show($slug)
    {
        $post = Post::where('slug','=',$slug)->with(['category', 'tags'])->first();
        // dd($post);
        if ($post) {
            if($post->cover) {
                $post->cover = url('storage/' . $post->cover);
            } 
            return response()->json([
                'success' => true,
                'results' => $post
            ]);
        }
        else {
            return response()->json([
                'success' => false,
                'results' => []
            ]);
        }
    }
}
