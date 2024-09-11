@extends('Layouts.layouts')
@section('content')
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('owner_crud.index') }}"><button class="btn btn-primary">BACK</button></a><br><br>
    </div>
    <!-- left column -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h2 class="card-title">OWNER DETAILS</h2>
                    </div>
                    <!-- /.card-header -->

                    <!-- form start -->
                    <form id="parkingForm" class="card-body">
                        <div class="form-group mb-3">
                            <label for="owner_name" class="form-label">Owner Name</label>
                            <input type="text" class="form-control" id="owner_name" name="owner_name">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Owner Email</label>
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                        <div class="form-group mb-3">
                            <label for="phoneno" class="form-label">Phone no</label>
                            <input type="number" class="form-control" id="phoneno" name="phoneno">
                        </div>
                        <div class="form-group mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="form-group mb-3">
                            <label for="flat_no" class="form-label">Flat No</label>
                            <select class="custom-select form-control-border" id="flat_no" name="flat_no">
                                <option value="">Select Flat No</option>
                                @foreach ($flats as $flat)
                                    <option value="{{ $flat->id }}">{{ $flat->flat_no }}</option>
                                @endforeach
                            </select>
                        </div>



                        <div class="form-group" id="members_section">
                            <label for="members" class="form-label">Number of Members</label>

                            <input type="text" class="form-control" name="members" placeholder="Number of Members">
                        </div>


                        <div class="form-group mb-3">
                            <label for="park_slott" class="form-label">Park Slot</label>
                            <select class="custom-select form-control-border" id="park_slott" name="park_slott">
                                <option value="">Select Park Plot</option>
                                <option value="1">A1</option>
                                <option value="2">A2</option>
                                <option value="3">B1</option>
                                <option value="4">B2</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success" id="submitBtn">Submit</button>
                    </form>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"
        integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/additional-methods.min.js"
        integrity="sha512-TiQST7x/0aMjgVTcep29gi+q5Lk5gVTUPE9XgN0g96rwtjEjLpod4mlBRKWHeBcvGBAEvJBmfDqh2hfMMmg+5A=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        const CREATE_FLATOWNER_URL = "{{ route('owner_crud.store') }}";
        const dashboard_url = "{{ route('owner_crud.index') }}";
    </script>
    <script src="{{ asset('assets/js/flatowner/create.js') }}"></script>
@endpush
