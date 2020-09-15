<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index(){
        $users = User::latest()->get();
        return view('users.index', [
            'users' => $users
            ]);
    }

    public function store(Request $request){
        $this->middleware('auth'); // Usando el middleware en el controlador
        $request->validate([
            'name'  => 'required',
            'email' => ['required', 'email', 'unique:users'],
            'password'  => ['required', 'min:8'],
        ]);

        // Crea un usuario con estos datos
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \bcrypt($request->password),
        ]);
        // Retorna a la vista anterior
        return back();

    }

    public function destroy(User $user){
        $user->delete();
        return back();
    }
}
