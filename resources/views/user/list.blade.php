@extends('layouts.app')


@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><a href="{{url('user/new')}}">Cadastrar Novo Usuário</a></div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <!-- {{ __('You are logged in!') }} -->
                    <h1>Lista de Candidato</h1>


                    <!-- Pesquisa -->
                    <section>
                        @csrf
                        <form action="{{route('user')}}">
                            <div class="row">
                                <div>
                                    <select name="name" id="name">
                                    <option value="">Selecione um Nome</option>
                                    @foreach($user as $n)
                                     <option value="{{$n->id}}">
                                        {{$n->name}}
                                     </option>
                                    @endforeach
                                    </select>
                                </div>
                                <div>
                                    <input type="text" name="name" id="name"/>
                                    <label for="name">Nome</label>
                              
                                </div>
                            </div>
                            <div>
                               <button type="submit">Filtrar</button>
                            </div>
                        </form>
                    </section>
                    <hr />

               
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Email</th>
                                <th scope="col">Senha</th>
                                <th scope="col">Editar</th>
                                <th scope="col">Deletar</th>
                               
                            </tr>
                        </thead>
                        <tbody>
                    @foreach($user as $u)
               
                            <tr>
                                <th scope="row">{{$u->id}}</th>
                                <td>{{$u->name}}</td>
                                <td>{{$u->email}}</td>
                                <td>{{$u->password}}</td>
                                <td>
                                    <a href="user/{{$u->id}}/edit" class="btn btn-info">Editar</a>

                                </td>
                                <td>
                                    <form action="user/delet/{{$u->id}}" method="post">
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
                <hr />
                {{ $user->links() }}
            </div>
        </div>
    </div> 
</div>

@endsection
