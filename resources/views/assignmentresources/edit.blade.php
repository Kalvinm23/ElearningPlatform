@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">{{$assignment->name}}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$assignment->description!!}
                        </div>
                    </div>
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">             
                            <div class="col-lg-12">  
                                <a href="/assignment/resources/{{$assignment->id}}/create" type="button" class="btn btn-primary btn mb-3 float-right">Add New Resource</a>  
                            </div>                      
                            @if(count($addresources) > 0)                        
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn mb-3 float-right" data-toggle="modal" data-target="#helpsheetsModal">Add Previous Resource</button>   
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="helpsheetsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Previous Resource</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row justify-content-center mb-1">         
                                                    <div class="col-lg-12">
                                                        <div class="list-group">
                                                            @foreach($addresources as $addresource)
                                                                <div class="list-group-item">
                                                                    <a class="btn btn-link text-left" href="/assignment/resources/{{$assignment->id}}/{{$addresource['id']}}">{{$addresource['name']}} - <?php echo \App\Http\Controllers\ResourcesController::typename($addresource['resource_type_id']);?></a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif
                    @if(count($resources) > 0)
                    {!! Form::open(['action' => 'AssignmentResourcesController@update', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                    <div class="row justify-content-center mb-1">
                        <div class="col-lg-12">
                            <div class="list-group" id="post_list">
                                @foreach($resources as $resource)
                                <?php $resourceinfo = \App\Http\Controllers\ResourcesController::resourceinfo($resource->resource_id);?>
                                    @if($resourceinfo->resource_type_id == 1)    
                                        <div class="list-group-item list-group-item-warning" data-post-id="{{$resourceinfo->id}}">
                                            <a type ="button" class="float-right " onclick="return confirm('Are you sure you want to remove {{$resourceinfo->name}}?')" href="/assignment/resources/{{$resource->id}}/destroy"><span class="badge badge-danger" aria-hidden="true"><i class="fas fa-times"></i></span></a>
                                            <h5>{{$resourceinfo->name}}</h5>
                                            <h5><?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?></h5>
                                            {{Form::hidden('order_id[]', $resource->id, array('id' => 'order_id[]'))}}
                                        </div>
                                    @elseif($resourceinfo->resource_type_id == 2)
                                        <div class="list-group-item list-group-item-info" data-post-id="{{$resourceinfo->id}}">
                                            <a type ="button" class="float-right " onclick="return confirm('Are you sure you want to remove {{$resourceinfo->name}}?')" href="/assignment/resources/{{$resource->id}}/destroy"><span class="badge badge-danger" aria-hidden="true"><i class="fas fa-times"></i></span></a>
                                            <h5>{{$resourceinfo->name}}</h5>
                                            <h5><?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?></h5>
                                            {{Form::hidden('order_id[]', $resource->id, array('id' => 'order_id[]'))}}
                                        </div>
                                    @elseif($resourceinfo->resource_type_id == 3)
                                        <div class="list-group-item list-group-item-success" data-post-id="{{$resourceinfo->id}}">
                                            <a type ="button" class="float-right " onclick="return confirm('Are you sure you want to remove {{$resourceinfo->name}}?')" href="/assignment/resources/{{$resource->id}}/destroy"><span class="badge badge-danger" aria-hidden="true"><i class="fas fa-times"></i></span></a>
                                            <h5>{{$resourceinfo->name}}</h5>
                                            <h5><?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?></h5>
                                            {{Form::hidden('order_id[]', $resource->id, array('id' => 'order_id[]'))}}
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @if(count($resources) > 1)                            
                        {{Form::submit('Update Resource Order', ['class' => 'btn btn-primary btn-block btn-lg'])}}
                    @endif
                        {!! Form::close() !!}
                    @else
                        <div class="row justify-content-center mb-1">
                            <h2>No Resources Available</h2>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection
