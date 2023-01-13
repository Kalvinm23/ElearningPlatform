@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">{{$unit->name}}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$unit->description!!}
                        </div>
                    </div>
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">             
                            <div class="col-lg-12">  
                                <a href="/assignments/{{$unit->id}}/create" type="button" class="btn btn-primary btn mb-3 float-right">Add New Assignment</a>  
                            </div>
                        </div>
                    @endif
                    @if(count($assignments) > 0)
                    {!! Form::open(['action' => 'AssignmentsController@orderupdate', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                    <div class="row justify-content-center mb-1" id="post_list">
                            @foreach($assignments as $assignment)
                                <div class="col-lg-8 col-md-8 mb-3 border text-center" data-post-id="{{$assignment->id}}">
                                    <a type ="button" class="float-right " onclick="return confirm('Are you sure you want to remove {{$assignment->name}}?')" href="/assignments/{{$assignment->id}}/destroy"><span class="badge badge-danger" aria-hidden="true"><i class="fas fa-times"></i></span></a>
                                    <h3>{{$assignment->name}} {{$assignment->order}}</h3>
                                    {{Form::hidden('order_id[]', $assignment->id, array('id' => 'order_id[]'))}}
                                </div>
                            @endforeach
                    </div>
                    @if(count($assignments) > 1)                            
                        {{Form::submit('Update Assignment Order', ['class' => 'btn btn-primary btn-block btn-lg'])}}
                    @endif
                        {!! Form::close() !!}
                        @else
                        <div class="row justify-content-center mb-1">
                            <h2>No Assignments Available</h2>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection
