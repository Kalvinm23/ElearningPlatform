@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Add Resource</h2>
                    </div>
                </div>
                <div class="card-body">
                    {!! Form::open(['action' => ['AssignmentResourcesController@store', $assignment->id], 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('name', 'Resource Name')}}
                                    {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Enter Resource Name'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('type', 'Type')}}
                                    {{Form::select('type', $types, null, ['class' => 'form-control', 'placeholder' => 'Enter Type'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('url', 'URL (If Quiz or Video Tutorial)')}}
                                    {{Form::text('url', '', ['class' => 'form-control', 'placeholder' => 'Enter URL'])}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    {{Form::label('pdf', 'Attach PDF (If Book Chapter)')}}
                                    {{Form::file('pdf', ['class' => 'form-control-file'])}}
                                </div>        
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            {{Form::hidden('_method','PUT')}}
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
