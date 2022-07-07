@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{url('vagas/new')}}">Cadastrar Nova Vaga</a></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    <h1>Lista de Candidato</h1>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome da vaga</th>
                                <th scope="col">Empresa</th>
                                <th scope="col">Tipo</th>
                                <th scope="col">Status</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Deletar</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                    @foreach($vagas as $v)
               
                            <tr>
                                <th scope="row">{{$v->id}}</th>
                                <td>{{$v->nomevaga}}</td>
                                <td>{{$v->empresa}}</td>
                                <td>{{$v->tipo}}</td>
                                <td>{{$v->status}}</td>
                                <td>
                                    <a href="vagas/{{$v->id}}/edit" class="btn btn-info">Editar</a>

                                </td>
                                <td>
                                    <form action="vagas/delet/{{$v->id}}" method="post">
                                        @csrf
                                        @method('delete')
                                    <button class="btn btn-danger">Deletar</button>
                                    </form>
                                </td>

                            </tr>

                


                    @endforeach

                    </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection