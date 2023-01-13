@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col-lg-1">
        </div>
        <div class="col-lg-10">
            <div class="card card-info">
                <div class="card-heading">
                    <div class="card-title">
                        <h2 class="h1-responsive font-weight-bold text-center my-4">Units</h2>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <a href="/units/create" type="button" class="btn btn-success btn mb-3 float-right">Add New Unit</a>
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
                            @if(count($aunits) > 0)
                                <div class="row justify-content-center">
                                    @foreach($aunits as $aunit)
                                        <div class="col-lg-4 col-md-6 mb-4">
                                            <div class="card h-100">
                                                <a href="/units/{{$aunit->id}}"><img class="img-fluid" src="/storage/unitimages/{{$aunit->image}}" alt=""></a>
                                                <div class="card-body">
                                                    <h4 class="card-title">{{$aunit->name}}</h4>
                                                </div>
                                                <div class="card-footer">
                                                    <a type ="button" class="btn btn-success btn-sm" href="/units/{{$aunit->id}}">View Unit</a>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach 
                                </div> 
                                {{ $aunits->links() }}  
                            @else
                                <h3>No Active Units Available</h3>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="inactive">  
                            @if(count($iunits) > 0)
                            <div class="row justify-content-center">
                                @foreach($iunits as $iunit)
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="card h-100">
                                            <a href="#"><img class="img-fluid" src="/storage/unitimages/{{$iunit->image}}" alt=""></a>
                                            <div class="card-body">
                                                <h4 class="card-title">{{$iunit->name}}</h4>
                                            </div>
                                            <div class="card-footer">
                                                <a type ="button" class="btn btn-success btn-sm" href="/units/{{$iunit->id}}">View Unit</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach 
                            </div>  
                                {{ $iunits->links() }}  
                            @else
                                <h3>No Inactive Units Available</h3>
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