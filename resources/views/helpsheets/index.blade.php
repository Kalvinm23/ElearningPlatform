@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Helpsheets</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/helpsheets/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Helpsheet</a>
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
                            @if(count($ahelpsheets) > 0)
                                <table class="table table-striped border">
                                    @foreach($ahelpsheets as $ahelpsheet)
                                        <tr>
                                            <td colspan='3'><h5>{{$ahelpsheet->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/helpsheets/{{$ahelpsheet->id}}" type="button" class="btn btn-success btn">View</a></td>
                                            <td><a href="/helpsheets/{{$ahelpsheet->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$ahelpsheet->name}}?')" href="/helpsheets/status/{{$ahelpsheet->id}}">Deactivate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $ahelpsheets->links() }}  
                            @else
                                <h3>No Active Helpsheets Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($ihelpsheets) > 0)
                                <table class="table table-striped border">
                                    @foreach($ihelpsheets as $ihelpsheet)
                                        <tr>
                                            <td colspan='3'><h5>{{$ihelpsheet->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/helpsheets/{{$ihelpsheet->id}}" type="button" class="btn btn-success btn">View</a></td>
                                            <td><a href="/helpsheets/{{$ihelpsheet->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to activate {{$ihelpsheet->name}}?')" href="/helpsheets/status/{{$ihelpsheet->id}}">Activate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $ihelpsheets->links() }}  
                            @else
                                <h3>No Inactive Helpsheets Available</h3>
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