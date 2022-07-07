<?php

namespace App\Http\Controllers;
use App\Models\Vagas;
use App\Http\Controllers\findOrFile;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class VagasController extends Controller
{
    public function index()
    {
   
     $vagas = Vagas::paginate(20);
    
     return view ('vagas.list', ['vagas' => $vagas]);
    }
    public function new()
    {
     return view('vagas.form');
 
    }
    public function add(Request $request)
    {
     $vagas= new Vagas;
     $vagas= $vagas->create($request->all());
     return Redirect::to('/vagas');
    }
 
    public function edit($id)
    {
     $vagas = Vagas::findOrFail($id);
     return view ('vagas.form', ['vagas' => $vagas]);
    }
 
    public function update($id, Request $request)
    {
     $vagas = Vagas::findOrFail($id);
     $vagas->update($request->all());
     return Redirect::to('/vagas');
 
    }
 
    public function delet($id)
    {
     $Vagas = Vagas::findOrFail($id);
     $Vagas->delete();
     return Redirect::to('/vagas');
    }
}
