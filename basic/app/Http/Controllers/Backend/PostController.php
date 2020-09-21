<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Http\Requests\PostRequest;

// Para trabajar con almacenamiento.
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
        $posts = Post::latest()->get();

        return view('posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        // dd($request->all());
        
        // Función de guardado
        $post = Post::create([
            'user_id' => auth()->user()->id
        ] + $request->all() );

        // Image
        if ($request->file('file')){
            $post->image = $request->file('file')->store('posts', 'public');
            $post->save();
        }

        // Retornar
        return back()->with('status', 'Creado con éxito');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        // dd($request->all());

        // Editamos con update
        $post->update($request->all());

        // edito solo esos campos si no viene file
        /* $post->update([
            'title' => $request->title,
            'body' => $request->body,
            'iframe' => $request->iframe
        ]); */

        // Eliminamos la imagen anterior y guardamos la nueva
        if ($request->file('file')) {
            // Eliminamos la imagen anterior
            Storage::disk('public')->delete($post->image);

            // Guardamos la nueva imágen
            $post->image = $request->file('file')->store('posts', 'public');
            $post->save();
        }

         // Retornar
        return back()->with('status', 'Actualizado con éxito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Eliminación de la imagen (Dentro de almacenamiento, busca en public y elimina esta imagen en la ruta indicada.)
        Storage::disk('public')->delete($post->image);

        // Eliminación del registro en la base de datos
        $post->delete();
        
        return back()->with('status', 'Eliminado con éxito');
    }
}
