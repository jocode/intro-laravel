<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function store(PostRequest $request){
        # Validación
        dd($request->all());
    }
}
