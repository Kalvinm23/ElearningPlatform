@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Versions</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/versions/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Version</a>
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
                            @if(count($aversions) > 0)
                                <table class="table table-striped border">
                                    @foreach($aversions as $aversion)
                                        <tr>
                                            <td colspan='3'><h5>{{$aversion->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/versions/{{$aversion->id}}" type="button" class="btn btn-success btn">Courses</a></td>
                                            <td><a href="/versions/{{$aversion->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$aversion->name}}?')" href="versions/status/{{$aversion->id}}">Deactivate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $aversions->links() }}  
                            @else
                                <h3>No Active Versions Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($iversions) > 0)
                                <table class="table table-striped border">
                                    @foreach($iversions as $iversion)
                                        <tr>
                                            <td colspan='3'><h5>{{$iversion->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/versions/{{$iversion->id}}" type="button" class="btn btn-success btn">Courses</a></td>
                                            <td><a href="/versions/{{$iversion->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to activate {{$iversion->name}}?')" href="versions/status/{{$iversion->id}}">Activate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $iversions->links() }}  
                            @else
                                <h3>No Inactive Versions Available</h3>
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