@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body"> 
                    @if($user->status == 1)
                    <a type ="button" class="btn btn-danger float-right" onclick="return confirm('Are you sure you want to suspend {{$user->first_name}} {{$user->last_name}}?')" href="/users/status/{{$user->id}}">Suspend Account</a>
                    @else
                    <a type ="button" class="btn btn-success float-right" onclick="return confirm('Are you sure you want to reinstate {{$user->first_name}} {{$user->last_name}}?')" href="/users/status/{{$user->id}}">Reinstate Account</a>
                    @endif
                    <h4 class="card-title">{{$user->first_name}} {{$user->last_name}}</h4>
                    <hr>
                    <h5 class="card-text">Email: {{$user->email}}</h5>
                    <h5 class="card-text">Status: @if($user->status == 1) Active @else Inactive @endif</h5>
                    <hr>
                    <div class="row">  
                        <div class="col-lg-12">
                            <a type ="button" class="btn btn-success float-right" href="/users/{{$user->id}}/edit">Add Course</a>
                        </div>
                    </div>
                    @if(count($courses) > 0)
                        @foreach($courses as $course)
                            <h4 class="card-title mt-3"><?php echo \App\Http\Controllers\CoursesController::showname($course->course_id);?></h4>
                            <?php $units = \App\Http\Controllers\CoursesController::findunits($course->course_id);?>
                            <div id="accordion">  
                                @foreach($units as $unit)
                                    <div class="card">
                                        <div class="card-header list-group-item-warning" id="heading{{$unit->unit_id}}" data-toggle="collapse" data-target="#collapse{{$unit->unit_id}}" aria-expanded="false" aria-controls="collapse{{$unit->unit_id}}">
                                            <p class="btn text-left mb-0">
                                                <?php echo \App\Http\Controllers\UnitsController::showname($unit->unit_id);?> - Timetable
                                            </p>
                                        </div>
                                        <div id="collapse{{$unit->unit_id}}" class="collapse" aria-labelledby="heading{{$unit->unit_id}}" data-parent="#accordion">
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-bordered">
                                                        <thead class="thead-dark">
                                                            <tr>
                                                                <th scope="col">Assignment</th>
                                                                <th scope="col">Result</th>
                                                                <th scope="col">Submitted</th>
                                                                <th scope="col">Update</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $assignmentsinfo = \App\Http\Controllers\UnitsController::findassignments($unit->unit_id);?>
                                                            @foreach($assignmentsinfo as $assignment)
                                                                <tr>
                                                                    <td><a href="/assignments/{{$assignment->id}}">{{$assignment->name}}</a></td>
                                                                    <?php $result = \App\Http\Controllers\UserAssignmentsController::results($user->id, $assignment->id);?>   
                                                                    @if(!empty($result))
                                                                        {!! Form::open(['action' => ['UserAssignmentsController@update', $result->id], 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
                                                                        <td>{{Form::select('result', $results, $result->result_type_id, ['class' => 'form-control', 'placeholder' => 'Enter Result'])}}</td>
                                                                        <td>{{ \Carbon\Carbon::parse($result->updated_at)->format('d/m/Y')}}</td>
                                                                        <td>
                                                                            {{Form::hidden('_method','PUT')}}
                                                                            {{Form::submit('Update', ['class' => 'btn btn-primary btn-sm'])}}
                                                                        </td>
                                                                        {!! Form::close() !!}
                                                                    @else
                                                                        {!! Form::open(['action' => ['UserAssignmentsController@store', $assignment->id, $user->id], 'method' => 'POST', 'autocomplete' => 'off', 'files' => true]) !!}
                                                                        <td>{{Form::select('result', $results, null, ['class' => 'form-control', 'placeholder' => 'Enter Result'])}}</td>
                                                                        <td></td>
                                                                        <td>
                                                                            {{Form::hidden('_method','PUT')}}
                                                                            {{Form::submit('Update', ['class' => 'btn btn-primary btn-sm'])}}
                                                                        </td>
                                                                        {!! Form::close() !!}
                                                                    @endif
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                        <div class="row">  
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-danger float-right mt-3" data-toggle="modal" data-target="#removecourseModal">Remove Course</button>   
                            </div>
                        </div>
                        <!-- Modal -->
                        <div class="modal fade" id="removecourseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Remove Course</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row justify-content-center mb-1">         
                                            <div class="col-lg-12">
                                                <div class="list-group">
                                                    @foreach($courses as $course)
                                                    <?php $coursename = \App\Http\Controllers\CoursesController::showname($course->course_id);?>
                                                        <div class="list-group-item">
                                                            <a class="btn btn-link text-left" href="/users/removecourse/{{$course->id}}" onclick="return confirm('Are you sure you want to remove {{$coursename}}?')">{{$coursename}}</a>
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
            </div>
        </div>
        <div class="col-lg-1">
        </div>
    </div>
@endsection

