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
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">
                            <div class="col-lg-12">  
                                <a href="/units/{{$unit->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Unit</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-lg-12">
                            {!!$unit->description!!}
                        </div>
                    </div>
                    @if (Auth::user()->permission == 2)     
                        <div class="row mb-2">                            
                            <div class="col-lg-12">  
                                <a href="/assignments/units/{{$unit->id}}/edit" type="button" class="btn btn-primary btn mb-3 float-right">Edit Assignments</a>  
                            </div>
                        </div>
                    @endif
                    <div class="row justify-content-center mb-1">
                        @if(count($assignments) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Assignment</th>
                                            <th scope="col">Result</th>
                                            <th scope="col">Submitted</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assignments as $assignment)
                                        <?php $result = \App\Http\Controllers\UserAssignmentsController::results(Auth::user()->id, $assignment->id);?>                                            
                                        @if(!empty($result))
                                            <tr>
                                                <td><a href="/assignments/{{$assignment->id}}">{{$assignment->name}}</a></td>
                                                <td><?php echo \App\Http\Controllers\UserAssignmentsController::showresulttype($result->result_type_id);?></td>
                                                <td>{{ \Carbon\Carbon::parse($result->updated_at)->format('d/m/Y')}}</td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td><a href="/assignments/{{$assignment->id}}">{{$assignment->name}}</a></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                        @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <h2>No Assignments Available</h2>
                        @endif
                    </div>
                    @if (Auth::user()->permission == 2)
                        <div class="row">
                            <div class="col-lg-12"> 
                                @if($unit->status == 1)
                                <a type ="button" class="btn btn float-right btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$unit->name}}?')" href="status/{{$unit->id}}">Deactivate Unit</a>
                                @else
                                <a type ="button" class="btn btn float-right btn-success" onclick="return confirm('Are you sure you want to activate {{$unit->name}}?')" href="status/{{$unit->id}}">Activate Unit</a>
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
