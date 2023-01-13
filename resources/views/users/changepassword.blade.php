@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Change Password</div>
   
                <div class="card-body">
                    {!! Form::open(['action' => 'ChangePasswordController@store', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('current_password', 'Current Password')}}
                                    {{Form::password('current_password', ['class' => 'form-control', 'placeholder' => 'Enter Current Password'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('new_password', 'New Password')}}
                                    {{Form::password('new_password', ['class' => 'form-control', 'placeholder' => 'Enter New Password'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('new_confirm_password', 'Confirm New Password')}}
                                    {{Form::password('new_confirm_password', ['class' => 'form-control', 'placeholder' => 'Confirm New Password'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            {{Form::submit('Change', ['class' => 'btn btn-primary btn-lg'])}}
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection