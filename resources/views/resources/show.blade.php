@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">{{$resource->name}}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">
                            <div class="col-lg-12">  
                                <a href="/resources/{{$resource->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Resource</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-center mb-1">                      
                        <div class="col-lg-12">  
                            <div id="accordion">     
                                @if($resource->resource_type_id == 1)    
                                    <div class="card">
                                        <div class="card-header list-group-item-warning" id="heading{{$resource->id}}" data-toggle="collapse" data-target="#collapse{{$resource->id}}" aria-expanded="false" aria-controls="collapse{{$resource->id}}">
                                            <p class="btn text-left mb-0">
                                                {{$resource->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resource->resource_type_id);?>
                                            </p>
                                        </div>
                                        <div id="collapse{{$resource->id}}" class="collapse" aria-labelledby="heading{{$resource->id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <object class="embed-responsive-item" data="/storage/bookchapters/{{$resource->link}}" type="application/pdf" internalinstanceid="9" title="">
                                                        <p>Your browser isn't supporting embedded pdf files. You can download the file
                                                            <a href="/storage/bookchapters/{{$resource->link}}" target="_blank">here</a>.
                                                        </p>
                                                    </object>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($resource->resource_type_id == 2)
                                    <div class="card">
                                        <div class="card-header list-group-item-info" id="heading{{$resource->id}}" data-toggle="collapse" data-target="#collapse{{$resource->id}}" aria-expanded="false" aria-controls="collapse{{$resource->id}}">
                                            <p class="btn text-left mb-0">
                                                {{$resource->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resource->resource_type_id);?>
                                            </p>
                                        </div>
                                        <div id="collapse{{$resource->id}}" class="collapse" aria-labelledby="heading{{$resource->id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe class="embed-responsive-item" src="https://mypta.premiertraining.co.uk/assignment_3.0/quiz_4.0/{{$resource->link}}" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($resource->resource_type_id == 3)
                                    <div class="card">
                                        <div class="card-header list-group-item-success" id="heading{{$resource->id}}" data-toggle="collapse" data-target="#collapse{{$resource->id}}" aria-expanded="false" aria-controls="collapse{{$resource->id}}">
                                                <p class="btn text-left mb-0">
                                                    {{$resource->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resource->resource_type_id);?>
                                                </p>
                                        </div>
                                        <div id="collapse{{$resource->id}}" class="collapse" aria-labelledby="heading{{$resource->id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="embed-responsive embed-responsive-16by9">
                                                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$resource->link}}?rel=0" allowfullscreen></iframe>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif                    
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center mb-1">                      
                        <div class="col-lg-12"> 
                            <h3 class="h1-responsive font-weight-bold text-center my-4">Assignments</h3>
                            <div class="row">               
                                @if(count($relationships) > 0)
                                    @foreach($relationships as $relationship)                                    
                                    <?php $assignment = \App\Http\Controllers\AssignmentsController::assignmentinfo($relationship->assignment_id);?>  
                                    <div class="col-lg-4 col-md-6 mt-2 mb-2">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h4 class="card-title"> <?php echo \App\Http\Controllers\UnitsController::showname($assignment->unit_id);?> </h4>
                                                <p class="card-text">Name: {{$assignment->name}}</p>
                                                <a type ="button" class="btn btn-success btn-sm" href="/assignments/{{$assignment->id}}">View</a>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>


                    @if (Auth::user()->permission == 2)
                        <div class="row">
                            <div class="col-lg-12"> 
                                @if($resource->status == 1)
                                <a type ="button" class="btn btn float-right btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$resource->name}}?')" href="/resources/status/{{$resource->id}}">Deactivate Resource</a>
                                @else
                                <a type ="button" class="btn btn float-right btn-success" onclick="return confirm('Are you sure you want to activate {{$resource->name}}?')" href="/resources/status/{{$resource->id}}">Activate Resource</a>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection
