@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="{{('../')}}">Voltar</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif



                    @if(Request::is('*/edit'))

                    <form action="{{ url('vagas/update') }}/{{$vagas->id}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nome da Vaga</label>
                            <input type="text" name="nomevaga" class="form-control" value="{{$vagas->nomevaga}}">

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Empresa</label>
                            <input type="text" name="empresa" class="form-control" value="{{$vagas->empresa}}">

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tipo</label>
                            <input type="text" name="tipo" class="form-control" value="{{$vagas->tipo}}">

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <input type="number" name="status" class="form-control" value="{{$vagas->status}}">

                        </div>

                        <button type="submit" class="btn btn-primary">Editar</button>
                    </form>

                    @endif
                    @if(Request::is('*/new'))
                    <!-- {{ __('You are logged in!') }} -->
                    <form action="{{ url('vagas/add')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nome da Vaga</label>
                            <input type="text" name="nomevaga" class="form-control">

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Empresa</label>
                            <input type="text" name="empresa" class="form-control">

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tipo</label>
                            <select name="tipo" required="true" >
                                <option value="CLT">CLT</option>
                                <option value="Freelance" >Freelance</option>
                                <option value="PJ">PJ</option>
                            </select>
                            
                            <!-- <input type="text" name="tipo" class="form-control" > -->

                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status</label>
                            <!-- <input type="number" name="status" class="form-control"> -->
                            <select name="status">
                                <option value="0">0</option>
                                <option value="1" >1</option>
                                
                            </select>

                        </div>

                        <button type="submit" class="btn btn-primary">Cadastrar</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection