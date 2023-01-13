@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">{{$course->name}}</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <h5>
                            <?php echo \App\Http\Controllers\ProfessionalBodiesController::showname($course->professional_body_id);?>
                            </h5>
                            <h5>
                            <?php echo \App\Http\Controllers\VersionsController::showname($course->version_id);?>
                            </h5>
                            {!!$course->description!!}
                        </div>
                    </div>
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">             
                            <div class="col-lg-12">  
                                <a href="/courses/unit/{{$course->id}}" type="button" class="btn btn-primary btn mb-3 float-right">Add New Unit</a>  
                            </div>
                            @if(count($addunits) > 0)                    
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-primary btn mb-3 float-right" data-toggle="modal" data-target="#addunitsModal">Add Previous Unit</button>   
                                </div>
                                <!-- Modal -->
                                <div class="modal fade" id="addunitsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Add Previous Unit</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row justify-content-center mb-1">         
                                                    <div class="col-lg-12">
                                                        <div class="list-group">
                                                            @foreach($addunits as $addunit)
                                                                <div class="list-group-item">
                                                                    <a class="btn btn-link text-left" onclick="return confirm('Are you sure you want to add {{$addunit['name']}}?')" href="/courses/unit/{{$course->id}}/{{$addunit['id']}}">{{$addunit['name']}}</a>
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
                    @if(count($units) > 0)
                    {!! Form::open(['action' => 'CourseUnitsController@update', 'method' => 'POST', 'files' => true, 'autocomplete'=> 'off']) !!}
                    <div class="row justify-content-center mb-1" id="post_list">
                            @foreach($units as $unit)
                            <?php $unitinfo = \App\Http\Controllers\CoursesController::unitinfo($unit->unit_id);?>
                                <div class="col-lg-8 col-md-8 mb-2" data-post-id="{{$unit->id}}">
                                    <a type ="button" class="float-right " onclick="return confirm('Are you sure you want to remove {{$unitinfo->name}}?')" href="/courses/unit/{{$unit->id}}/destroy"><span class="badge badge-danger" aria-hidden="true"><i class="fas fa-times"></i></span></a>
                                   <img class="img-fluid rounded" src="/storage/unitimages/{{$unitinfo->image}}" alt="">
                                  {{Form::hidden('order_id[]', $unit->id, array('id' => 'order_id[]'))}}
                                </div>
                            @endforeach
                    </div>
                    @if(count($units) > 1)                            
                        {{Form::submit('Update Unit Order', ['class' => 'btn btn-primary btn-block btn-lg'])}}
                    @endif
                        {!! Form::close() !!}
                        @else
                        <div class="row justify-content-center mb-1">
                            <h2>No Units Available</h2>
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
