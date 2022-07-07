<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
class UserController extends Controller
{
    public function index(Request $request)
   {
   // $usuarios= User::orderBy('name')->get();
    $usuarios = User::paginate(20);

    if($request->id)
    {
        $usuarios-> where('id', $request->id);

    }
    if($request->name)
    {
        $usuarios->where('name', $request->name);
    }
    
    return view ('user.list', ['user' => $usuarios]);
   }
   public function new()
   {
    return view('user.form');

   }
   public function add(Request $request)
   {
    $usuario = new User;
    $usuario = $usuario->create($request->all());
    return Redirect::to('/user');
   }

   public function edit($id)
   {
    $usuario = User::findOrFail($id);
    return view ('user.form', ['user' => $usuario]);
   }

   public function update($id, Request $request)
   {
    $usuario = User::findOrFail($id);
    $usuario->update($request->all());
    return Redirect::to('/user');

   }

   public function delet($id)
   {
    $usuario = User::findOrFail($id);
    $usuario->delete();
    return Redirect::to('/user');
   }
}
