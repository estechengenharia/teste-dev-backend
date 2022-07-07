@extends('adminlte::page')

@section('content')
<div class="container">
    <div class="card bg-light mt-3">
        <div class="card-header">
            Importar tarefas
        </div>
        <div class="card-body">
            <form action="{{ url('import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="file" class="form-control">
                <br>
                <button class="btn btn-success">Importar CVS</button>
            </form>
        </div>
    </div>
</div>

@endsection