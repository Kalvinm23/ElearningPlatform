@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Resources</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/resources/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Resource</a>
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
                            @if(count($aresources) > 0)
                                <table class="table table-striped border">
                                    @foreach($aresources as $aresource)
                                        <tr>
                                            <td colspan='3'><h5>{{$aresource->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($aresource->resource_type_id);?></h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/resources/{{$aresource->id}}" type="button" class="btn btn-success btn">View</a></td>
                                            <td><a href="/resources/{{$aresource->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$aresource->name}}?')" href="/resources/status/{{$aresource->id}}">Deactivate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $aresources->links() }}  
                            @else
                                <h3>No Active Resources Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($iresources) > 0)
                                <table class="table table-striped border">
                                    @foreach($iresources as $iresource)
                                        <tr>
                                            <td colspan='3'><h5>{{$iresource->name}} - <?php echo \App\Http\Controllers\ResourcesController::typename($iresource->resource_type_id);?></h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/resources/{{$iresource->id}}" type="button" class="btn btn-success btn">View</a></td>
                                            <td><a href="/resources/{{$iresource->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to activate {{$iresource->name}}?')" href="/resources/status/{{$iresource->id}}">Activate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $iresources->links() }}  
                            @else
                                <h3>No Inactive Resources Available</h3>
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