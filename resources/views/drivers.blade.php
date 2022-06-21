@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Drivers</div>

        <div class="card-body">
            <table class="table table-condensed">
                <thead>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Mobile</th>
                    <th>Address</th>
                    <th>CNIC Front</th>
                    <th>CNIC Back</th>
                    <th>Details</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    @foreach($drivers as $driver)
                        <tr>
                            <td><a href="{{ $driver->user_image }}"><img style="height:70px" src="{{ $driver->user_image }}"></a></td>
                            <td>{{ $driver->name }}</td>
                            <td>{{ $driver->email }}</td>
                            <td>{{ $driver->mobile }}</td>
                            <td>{{ $driver->address }}</td>
                            <td><a href="{{ $driver->cnic_front }}"><img style="height:70px" src="{{ $driver->cnic_front }}"></a></td>
                            <td><a href="{{ $driver->cnic_back }}"><img style="height:70px" src="{{ $driver->cnic_back }}"></a></td>
                            <td><a class="btn btn-primary" href="#" data-toggle="modal" data-target="#details{{$driver->id}}">Details</a></td>
                            @if($driver->user_status == 0 || $driver->user_status == 2)
                                <td><a class="btn btn-success" href="{{ route('dashboard.approve.driver',$driver) }}">Approve</a></td>
                            @else
                                <td><a class="btn btn-danger" href="{{ route('dashboard.block.driver',$driver) }}">Block</a></td>
                            @endif
                        </tr>

                        <div id="details{{$driver->id}}" class="modal fade" role="dialog">
                            <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Driver Details</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body">
                                       @if($driver->vehicle)
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Vehicle Type: </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ $driver->vehicle->vehicle_type }}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Vehicle Number: </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        {{ $driver->vehicle->vehicle_num }}
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Licence Image: </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="{{ $driver->vehicle->licence_image }}"><img src="{{ $driver->vehicle->licence_image }}" style="height: 70px"></a>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <p>Certificate Image: </p>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <a href="{{ $driver->vehicle->certificate_image }}"><img src="{{ $driver->vehicle->certificate_image }}" style="height: 70px"></a>
                                                    </div>
                                                </div>
                                            </div>
                                       @else
                                           <p>No Vehicle data has been submitted yet.</p>
                                       @endif
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
