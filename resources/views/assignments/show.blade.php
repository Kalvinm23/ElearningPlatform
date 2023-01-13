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
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">
                            <div class="col-lg-12">  
                                <a href="/assignments/{{$assignment->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Assignment</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$assignment->description!!}
                        </div>
                    </div>
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">                            
                            <div class="col-lg-12">
                                <a href="/assignment/helpsheets/{{$assignment->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-left">Edit Helpsheets</a>    
                                <a href="/assignment/resources/{{$assignment->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Resources</a>  
                            </div>
                        </div>
                    @endif
                    @if(count($helpsheets) > 0)
                        <div class="row mb-2">                            
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-primary btn mb-3" data-toggle="modal" data-target="#helpsheetsModal">Helpsheets</button>   
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="helpsheetsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Helpsheets</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-center mb-1">         
                                            <div class="col-lg-12">
                                                <div class="list-group">
                                                    @foreach($helpsheets as $helpsheet)
                                                    <?php $helpsheetinfo = \App\Http\Controllers\HelpsheetsController::helpsheetinfo($helpsheet->helpsheet_id);?>   
                                                        <div class="list-group-item" data-post-id="{{$helpsheetinfo->id}}">
                                                            <a type ="button" class="btn text-left btn-link" href="{{ asset('storage/helpsheets/'.$helpsheetinfo->link) }}"  target="_blank">{{$helpsheetinfo->name}}</a>
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
                    <div class="row justify-content-center mb-1">                      
                        <div class="col-lg-12">  
                            <div id="accordion">
                                @if(count($resources) > 0)
                                    @foreach($resources as $resource)
                                        <?php $resourceinfo = \App\Http\Controllers\ResourcesController::resourceinfo($resource->resource_id);?>
                                        @if($resourceinfo->resource_type_id == 1)    
                                            <div class="card">
                                                <div class="card-header list-group-item-warning" id="heading{{$resourceinfo->id}}" data-toggle="collapse" data-target="#collapse{{$resourceinfo->id}}" aria-expanded="false" aria-controls="collapse{{$resourceinfo->id}}">
                                                    <p class="btn text-left mb-0">
                                                        {{$resourceinfo->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?>
                                                    </p>
                                                </div>
                                                <div id="collapse{{$resourceinfo->id}}" class="collapse" aria-labelledby="heading{{$resourceinfo->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <object class="embed-responsive-item" data="/storage/bookchapters/{{$resourceinfo->link}}" type="application/pdf" internalinstanceid="9" title="">
                                                                <p>Your browser isn't supporting embedded pdf files. You can download the file
                                                                    <a href="/storage/bookchapters/{{$resourceinfo->link}}" target="_blank">here</a>.
                                                                </p>
                                                            </object>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($resourceinfo->resource_type_id == 2)
                                            <div class="card">
                                                <div class="card-header list-group-item-info" id="heading{{$resourceinfo->id}}" data-toggle="collapse" data-target="#collapse{{$resourceinfo->id}}" aria-expanded="false" aria-controls="collapse{{$resourceinfo->id}}">
                                                    <p class="btn text-left mb-0">
                                                        {{$resourceinfo->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?>
                                                    </p>
                                                </div>
                                                <div id="collapse{{$resourceinfo->id}}" class="collapse" aria-labelledby="heading{{$resourceinfo->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item" src="https://mypta.premiertraining.co.uk/assignment_3.0/quiz_4.0/{{$resourceinfo->link}}" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @elseif($resourceinfo->resource_type_id == 3)
                                            <div class="card">
                                                <div class="card-header list-group-item-success" id="heading{{$resourceinfo->id}}" data-toggle="collapse" data-target="#collapse{{$resourceinfo->id}}" aria-expanded="false" aria-controls="collapse{{$resourceinfo->id}}">
                                                        <p class="btn text-left mb-0">
                                                            {{$resourceinfo->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($resourceinfo->resource_type_id);?>
                                                        </p>
                                                </div>
                                                <div id="collapse{{$resourceinfo->id}}" class="collapse" aria-labelledby="heading{{$resourceinfo->id}}" data-parent="#accordion">
                                                    <div class="card-body">
                                                        <div class="embed-responsive embed-responsive-16by9">
                                                            <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/{{$resourceinfo->link}}?rel=0" allowfullscreen></iframe>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach 
                                @endif
                                <div class="card">
                                    <div class="card-header list-group-item-dark" id="headingA" data-toggle="collapse" data-target="#collapseA" aria-expanded="false" aria-controls="collapseA">
                                            <p class="btn text-left mb-0">
                                                {{$assignment->name}} 
                                            </p>
                                    </div>
                                    <div id="collapseA" class="collapse <?php if($assignment->assignment_type_id == 2){ echo 'show'; } ?>" aria-labelledby="headingA" data-parent="#accordion">
                                        <div class="card-body">
                                            <p>We have produced these online assignments to help you get used to the idea of entering your answers into a computer rather than writing them on a piece of paper.</p>
                                            <p>We have tried to replicate the "look" and "feel" of the AAT assessments in our assignments in order to give you as much practice as possible in preparation for your assessments. If you are ready to take your assignment then click the button below to start.</p>
                                            @if($assignment->order < 2)
                                                <a href="https://mypta.premiertraining.co.uk/assignment_3.0/{{$assignment->link}}" target="_blank" type="button" class="btn btn-primary btn mb-3 float-left">Launch Assignment</a>
                                            @else
                                                <?php $assignment->order-- ?>
                                                <?php $previousassignment = \App\Http\Controllers\AssignmentsController::previousassignment($assignment->unit_id, $assignment->order);?>
                                                <?php $result = \App\Http\Controllers\UserAssignmentsController::previousresult(Auth::user()->id, $previousassignment);?>
                                                @if(!empty($result))
                                                    <a href="https://mypta.premiertraining.co.uk/assignment_3.0/{{$assignment->link}}" target="_blank" type="button" class="btn btn-primary btn mb-3 float-left">Launch Assignment</a>
                                                @else
                                                    <p>Please wait for the feedback from your previous assignment before attempting this one.</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection
