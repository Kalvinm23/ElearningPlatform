@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Add Course</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'CoursesController@store', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Course Name')}}
                                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Course Name'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('professionalbody', 'Professional Body')}}
                                    {{Form::select('professionalbody', $professionalbodies, null, ['class' => 'form-control', 'placeholder' => 'Enter Professional Body'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('version', 'Version')}}
                                    {{Form::select('version', $versions, null, ['class' => 'form-control', 'placeholder' => 'Enter Version'])}}
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
                                    {{Form::textarea('description', '', ['id' => 'article-ckeditor', 'class' => 'form-control', 'placeholder' => 'Enter Description'])}}
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
    </div>
    <div class="col-lg-1">
    </div>
    </div>  
@endsection
