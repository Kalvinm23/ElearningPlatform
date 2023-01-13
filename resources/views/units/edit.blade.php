@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Update Unit</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => ['UnitsController@update', $unit->id], 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Unit Name')}}
                                    {{Form::text('name', $unit->name, ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('image', 'Attach Image')}}
                                    {{Form::file('image', ['class' => 'form-control-file'])}}
                                </div>        
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('description', 'Description')}}
                                    {{Form::textarea('description', $unit->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter Description'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            {{Form::hidden('_method','PUT')}}
                            {{Form::submit('Update', ['class' => 'btn btn-primary btn-lg'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection