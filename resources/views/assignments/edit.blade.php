@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Update Assignment</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => ['AssignmentsController@update', $assignment->id], 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Assignment Name')}}
                                    {{Form::text('name', $assignment->name, ['class' => 'form-control'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('type', 'Assignment Name')}}
                                    {{Form::select('type', $types, $assignment->assignment_type_id, ['class' => 'form-control', 'placeholder' => 'Enter Type'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('url', 'Assignment URL')}}
                                    {{Form::text('url', $assignment->link, ['class' => 'form-control', 'placeholder' => 'Enter Assignment URL'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('description', 'Description')}}
                                    {{Form::textarea('description', $assignment->description, ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter Description'])}}
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