@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">{{$helpsheet->name}}</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">
                            <div class="col-lg-12">  
                                <a href="/helpsheets/{{$helpsheet->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Helpsheet</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-center mb-1">                      
                        <div class="col-lg-12">  
                            <div id="accordion">     
                                <div class="card">
                                    <div class="card-header list-group-item-warning" id="heading{{$helpsheet->id}}" data-toggle="collapse" data-target="#collapse{{$helpsheet->id}}" aria-expanded="false" aria-controls="collapse{{$helpsheet->id}}">
                                        <p class="btn text-left mb-0">
                                            {{$helpsheet->name}}
                                        </p>
                                    </div>
                                    <div id="collapse{{$helpsheet->id}}" class="collapse" aria-labelledby="heading{{$helpsheet->id}}" data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <object class="embed-responsive-item" data="/storage/helpsheets/{{$helpsheet->link}}" type="application/pdf" internalinstanceid="9" title="">
                                                    <p>Your browser isn't supporting embedded pdf files. You can download the file
                                                        <a href="/storage/helpsheets/{{$helpsheet->link}}" target="_blank">here</a>.
                                                    </p>
                                                </object>
                                            </div>
                                        </div>
                                    </div>
                                </div>             
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
                                @if($helpsheet->status == 1)
                                <a type ="button" class="btn btn float-right btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$helpsheet->name}}?')" href="/helpsheets/status/{{$helpsheet->id}}">Deactivate Helpsheet</a>
                                @else
                                <a type ="button" class="btn btn float-right btn-success" onclick="return confirm('Are you sure you want to activate {{$helpsheet->name}}?')" href="/helpsheets/status/{{$helpsheet->id}}">Activate Helpsheet</a>
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
