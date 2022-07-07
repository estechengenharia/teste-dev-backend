

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h1>Bem-Vindo!</h1>
                    <a href="{{ url('usuarios') }}">Lista de Candidatos</a>
                    <p>  <a href="{{ url('vagas') }}">Lista de Vagas</a></p>
                    <p>  <a href="{{ url('user') }}">Lista de Usuários</a></p>
                  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
