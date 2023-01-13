@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Add Professional Body</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'ProfessionalBodiesController@store', 'method' => 'POST', 'autocomplete' => 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Professional Body Name')}}
                                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Professional Body Name'])}}
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