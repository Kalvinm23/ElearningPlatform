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
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">
                            <div class="col-lg-12">  
                                <a href="/courses/{{$course->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Course</a>  
                            </div>
                        </div>
                    @endif
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
                                <a href="/courses/units/{{$course->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Units</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-center mb-1">
                        @if(count($units) > 0)
                            @foreach($units as $unit)
                            <?php $unitinfo = \App\Http\Controllers\CoursesController::unitinfo($unit->unit_id);?>
                                <div class="col-lg-8 col-md-8 mb-2">
                                    <a href="/units/{{$unitinfo->id}}"><img class="img-fluid rounded" src="/storage/unitimages/{{$unitinfo->image}}" alt=""></a>
                                </div>
                            @endforeach
                        @else
                            <h2>No Units Available</h2>
                        @endif
                    </div>
                    @if (Auth::user()->permission == 2)
                        <div class="row">
                            <div class="col-lg-12"> 
                                @if($course->status == 1)
                                <a type ="button" class="btn btn float-right btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$course->name}}?')" href="status/{{$course->id}}">Deactivate Course</a>
                                @else
                                <a type ="button" class="btn btn float-right btn-success" onclick="return confirm('Are you sure you want to activate {{$course->name}}?')" href="status/{{$course->id}}">Activate Course</a>
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
