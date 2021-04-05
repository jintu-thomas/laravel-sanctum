@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h1 class="text-center display-4">Todo</h1>
                </div>
                <div class="col-md-12">
                    <form method="POST" action={{route('store')}}>
                        @csrf
                        <label for="title"></label>
                        <input type="text" name="title" id="title" class="form-control mb-2"/>
                        @foreach ($errors->get('title') as $err )
                            <small class="text-danger">{{$err}} </small>
                            
                        @endforeach
                        <input type="submit" class="btn btn-dark btn-block" value="Submit"/>
                    </form>
                </div>

                <div class="col-md-12 mt-3">
                    <div class="todo-list text-center">

                        @foreach ($todos as $todo)
                            
                            <div class="todo-content border border-dark p-2 mb-2 d-flex justify-content-between">
                                <div>
                                    <span class="lead">{{$todo->title}}</span>
                                </div>
                        
                                <div>
                                    <a href="{{route('edit',$todo->id)}}" class="btn btn-warning">Update</a>
                                    <form action="{{route('delete', $todo->id)}}" method="POST" class="d-inline-block">
                                        @csrf
                                        <input type="submit" class="btn btn-danger" value="Delete"/>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>

               
            </div>
        </div>
        
    </div>

</div>
@endsection




