@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Add Student</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => 'UsersController@store', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('first_name', 'First Name')}}
                                    {{Form::text('first_name', '', ['class' => 'form-control', 'placeholder' => 'Enter First Name'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('last_name', 'Last Name')}}
                                    {{Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Enter Last Name'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('email', 'Email Address')}}
                                    {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Enter Email Address'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('course', 'Course')}}
                                    {{Form::select('course', $courses, null, ['class' => 'form-control', 'placeholder' => 'Enter Student Courses'])}}
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
