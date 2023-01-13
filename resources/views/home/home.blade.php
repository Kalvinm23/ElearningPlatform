@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">My Courses</h2>
                    </div>
                </div>
                <div class="card-body">
                    @if(count($courses) > 0)
                        <div class="row">
                            @foreach($courses as $course)
                            <?php $courseinfo = \App\Http\Controllers\HomeController::courseinfo($course->course_id);?>
                                <div class="col-lg-5 col-md-6 mb-4">
                                    <div class="card h-100">
                                        <a href="/courses/{{$courseinfo->id}}"><img class="img-fluid" src="/storage/courseimages/{{$courseinfo->image}}" alt=""></a>
                                        <div class="card-body">
                                            <h4 class="card-title">{{$courseinfo->name}}</h4>
                                            <h5>
                                            <?php echo \App\Http\Controllers\ProfessionalBodiesController::showname($courseinfo->professional_body_id);?>
                                            </h5>
                                        </div>
                                        <div class="card-footer">
                                            <a type ="button" class="btn btn-success btn-sm" href="/courses/{{$courseinfo->id}}">View Course</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach 
                        </div> 
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-10">
        </div>
    </div>
@endsection

