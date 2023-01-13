@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Professional Bodies</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/professionalbodies/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Professional Body</a>
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
                            @if(count($aprofessionalbodies) > 0)
                                <table class="table table-striped border">
                                    @foreach($aprofessionalbodies as $aprofessionalbody)
                                        <tr>
                                            <td colspan='3'><h5>{{$aprofessionalbody->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/professionalbodies/{{$aprofessionalbody->id}}" type="button" class="btn btn-success btn">Courses</a></td>
                                            <td><a href="/professionalbodies/{{$aprofessionalbody->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to deactivate {{$aprofessionalbody->name}}?')" href="professionalbodies/status/{{$aprofessionalbody->id}}">Deactivate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $aprofessionalbodies->links() }}  
                            @else
                                <h3>No Active Professional Bodies Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($iprofessionalbodies) > 0)
                                <table class="table table-striped border">
                                    @foreach($iprofessionalbodies as $iprofessionalbody)
                                        <tr>
                                            <td colspan='3'><h5>{{$iprofessionalbody->name}}</h5></td>
                                        </tr>
                                        <tr class="text-center">
                                            <td><a href="/professionalbodies/{{$iprofessionalbody->id}}" type="button" class="btn btn-success btn">Courses</a></td>
                                            <td><a href="/professionalbodies/{{$iprofessionalbody->id}}/edit" type="button" class="btn btn-success btn">Edit</a></td>
                                            <td><a type ="button" class="btn btn btn-danger" onclick="return confirm('Are you sure you want to activate {{$iprofessionalbody->name}}?')" href="professionalbodies/status/{{$iprofessionalbody->id}}">Activate</a></td>
                                        </tr>
                                    @endforeach
                                </table>  
                                {{ $iprofessionalbodies->links() }}  
                            @else
                                <h3>No Inactive Professional Bodies Available</h3>
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