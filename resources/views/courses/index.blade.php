@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Courses</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/courses/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Course</a>
                        </div>
                    </div>
                    <ul class="nav nav-pills nav-fill mb-1">
                        <li class="nav-item">
                            <a href="#active" class="nav-link active" data-toggle="tab">Active</a>
                        </li>
                        <li class="nav-item">
                            <a href="#inactive" class="nav-link" data-toggle="tab">Inactive</a>
                        </li>
                    </ul>     
                    <div class="tab-content ">
                        <div class="tab-pane fade show active" id="active">   
                            @if(count($acourses) > 0)
                                <div class="row justify-content-center">
                                    @foreach($acourses as $acourse)
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card h-100">
                                                <a href="/courses/{{$acourse->id}}"><img class="img-fluid" src="/storage/courseimages/{{$acourse->image}}" alt=""></a>
                                                <div class="card-body">
                                                    <h4 class="card-title">{{$acourse->name}}</h4>
                                                    <h5>
                                                    <?php echo \App\Http\Controllers\ProfessionalBodiesController::showname($acourse->professional_body_id);?>
                                                    </h5>
                                                    <h5>
                                                    <?php echo \App\Http\Controllers\VersionsController::showname($acourse->version_id);?>
                                                    </h5>
                                                </div>
                                                <div class="card-footer">
                                                    <a type ="button" class="btn btn-success btn-sm" href="/courses/{{$acourse->id}}">View Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach 
                                </div> 
                                {{ $acourses->links() }}  
                            @else
                                <h3>No Active Courses Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($icourses) > 0)
                            <div class="row justify-content-center">
                                @foreach($icourses as $icourse)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card h-100">
                                            <a href="/courses/{{$icourse->id}}"><img class="img-fluid" src="/storage/courseimages/{{$icourse->image}}" alt=""></a>
                                            <div class="card-body">
                                                <h4 class="card-title">{{$icourse->name}}</h4>
                                                <h5>
                                                <?php echo \App\Http\Controllers\ProfessionalBodiesController::showname($icourse->professional_body_id);?>
                                                </h5>
                                                <h5>
                                                <?php echo \App\Http\Controllers\VersionsController::showname($icourse->version_id);?>
                                                </h5>
                                            </div>
                                            <div class="card-footer">
                                                <a type ="button" class="btn btn-success btn-sm" href="/courses/{{$icourse->id}}">View Course</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach 
                            </div>  
                                {{ $icourses->links() }}  
                            @else
                                <h3>No Inactive Courses Available</h3>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>  
@endsection