@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="row">               
                @if(count($users) > 0)
                @foreach($users as $user)
                <div class="col-lg-6 col-md-6 mt-2 mb-2">
                    <div class="card h-100">
                        <div class="card-body">
                            <h4 class="card-title">
                               ID: #{{$user->id}}
                            </h4>
                            <p class="card-text">Name: {{$user->first_name}} {{$user->last_name}}</p>
                            <p class="card-text">Email: {{$user->email}}</p>
                            <a type ="button" class="btn btn-success btn-lg" href="/users/{{$user->id}}">View</a>
                        </div>
                    </div>
                </div>
                @endforeach
                @endif
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
@endsection