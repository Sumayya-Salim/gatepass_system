@extends('Layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-2">
            <a href="{{ route('owner_crud.index') }}"><button class="btn btn-primary">Back to List</button></a>
        </div>
        <h2>Flat Owner Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Owner Name:</strong> {{ $ownerDetail->owner_name }}</p>
                <p><strong>Flat Number:</strong> {{ $flat->flat_no }}</p>
                <p><strong>Parking Slot:</strong> {{ config('constants.park_slott')[$ownerDetail->park_slott] }}</p>
                <p><strong>Number of Members:</strong> {{ $ownerDetail->members }}</p>
            </div>
        </div>
    </div>
@endsection
