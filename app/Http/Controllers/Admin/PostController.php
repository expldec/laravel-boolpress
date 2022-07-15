<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Mail\SendNewMail;
use App\Post;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->image);
        $request->validate($this->getValidationRules());
        $data = $request->all();

        if (isset($data['image'])) {
            $image_path = Storage::put('post_covers', $data['image']);
            // dd($image_path);
            $data['cover'] = $image_path;
        }

        $post = new Post();
        $post->fill($data);
        $post->slug = Post::generatePostSlugFromTitle($post->title);
        $post->save();
        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        Mail::to('superadmin@boolpress.it')->send(new SendNewMail($post));

        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $category = $post->category;
        return view('admin.posts.show', compact('post', 'category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate($this->getValidationRules());
        $data = $request->all();
        $post = Post::findOrFail($id);

        //se la richiesta contiene l'immagine
        if (isset($data['image'])) {
            //  E se il post ha già una sua immagine
            if ($post->cover) {
                //cancelliamo l'immagine esistente
                Storage::delete($post->cover);
            }
            //  E salviamo comunque l'immagine nuova
            $image_path = Storage::put('post_covers', $data['image']);
            //  Salviamo il relativo path nel database
            $data['cover'] = $image_path;
        }

        //generiamo lo slug dal titolo
        $data['slug'] = Post::generatePostSlugFromTitle($data['title']);
        //aggiorniamo il record nel DB
        $post->update($data);
        //se abbiamo tag nella request
        if (isset($data['tags'])) {
            //aggiorniamo la tabella post_tag
            $post->tags()->sync($data['tags']);
        } else {
            //atrimenti aggiorniamola comunque con un array vuoto per eliminare tutti i record per il post da post_tag
            $post->tags()->sync([]);
        }
        return redirect()->route('admin.posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // individuiamo il post da cancellare facendo una query con il Model
        $post = Post::findOrFail($id);
        // eliminiamo tutti i tag dalla tabella post_tag con un sync di un array vuoto
        $post->tags()->sync([]);

        // se il Model ha l'attributo "cover" (l'immagine)
        if($post->cover) {
            // cancelliamo l'immagine dal filesystem
            Storage::delete($post->cover);
        }


        $post->delete();
        return redirect()->route('admin.posts.index');
    }

    private function getValidationRules()
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required|max:30000',
            'category_id' => 'nullable|exists:categories,id',
            'tags' => 'nullable|exists:tags,id',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:1024'
        ];
    }
}
