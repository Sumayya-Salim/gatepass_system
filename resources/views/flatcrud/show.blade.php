@extends('Layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-2">
            <a href="{{ route('flatcrud.index') }}"><button class="btn btn-primary">Back to List</button></a>
        </div>
        <h2>Flat Details</h2>
        <div class="card">
            <div class="card-body">
                <p><strong>Flat Number:</strong> {{ $flat->flat_no }}</p>
                <p><strong>Flat Type:</strong> {{ config('constants.flat_type')[$flat->flat_type] }}</p>
                <p><strong>Furnish Type:</strong> {{ config('constants.furniture_type')[$flat->furniture_type] }}</p>
            </div>
        </div>
    </div>
@endsection
