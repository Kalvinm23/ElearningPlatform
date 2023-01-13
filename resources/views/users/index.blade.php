@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Search Students</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    {!! Form::open(['action' => ['UsersController@search', 1], 'method' => 'POST', 'files' => true, 'autocomplete' => 'off']) !!}
                                    <td>
                                        {{Form::number('userid', '', ['class' => 'form-control', 'placeholder' => 'Search Users ID', 'required' => 'required'])}}
                                    </td>
                                    <td>
                                        {{Form::submit('Search', ['class' => 'btn btn-primary btn-lg'])}}
                                    </td>
                                    {!! Form::close() !!}
                                </tr>
                                <tr>
                                    {!! Form::open(['action' => ['UsersController@search', 2], 'method' => 'POST', 'files' => true, 'autocomplete' => 'off']) !!}
                                    <td>
                                        {{Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Search Users Email', 'required' => 'required'])}}
                                    </td>
                                    <td>
                                        {{Form::submit('Search', ['class' => 'btn btn-primary btn-lg'])}}
                                    </td>
                                    {!! Form::close() !!}
                                </tr>
                                <tr>
                                    {!! Form::open(['action' => ['UsersController@search', 3], 'method' => 'POST', 'files' => true, 'autocomplete' => 'off']) !!}
                                    <td>
                                        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Search Users Name', 'required' => 'required'])}}
                                    </td>
                                    <td>
                                        {{Form::submit('Search', ['class' => 'btn btn-primary btn-lg'])}}
                                    </td>
                                    {!! Form::close() !!}
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-1">
    </div>
    </div>  
@endsection