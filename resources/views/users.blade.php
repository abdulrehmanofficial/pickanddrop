@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Users</div>

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
                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                        <td><a href="{{ $user->user_image }}"><img style="height:70px" src="{{ $user->user_image }}"></a></td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->mobile }}</td>
                        <td>{{ $user->address }}</td>
                        <td><a href="{{ $user->cnic_front }}"><img style="height:70px" src="{{ $user->cnic_front }}"></a></td>
                        <td><a href="{{ $user->cnic_back }}"><img style="height:70px" src="{{ $user->cnic_back }}"></a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
