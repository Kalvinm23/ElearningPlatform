@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Add Version</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'VersionsController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Version Name')}}
                                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Version Name'])}}
                                    </div>
                                </div>
                            </div>
                        <div class="row justify-content-center">
                            {{Form::submit('Add', ['class' => 'btn btn-primary btn-lg'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection