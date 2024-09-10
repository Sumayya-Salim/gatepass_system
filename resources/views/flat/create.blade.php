@extends('Layouts.layouts')
@section('content')
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('flat.index') }}"><button class="btn btn-primary">BACK</button></a><br><br>
    </div>

    <!-- left column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Flat Creation</h3>
                    </div>
                    <!-- form start -->
                    <form id="regform" method="POST" action="{{ route('flat.store') }}">
                        @csrf
                        <div class="card-body">
                            <div class="form-group">
                                <label for="flat_no">Flat Number</label>
                                <input type="Number" class="form-control" id="flat_no" name="flat_no"
                                    placeholder="Enter Flat Number">
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                            <div class="form-group">
                                <label for="flat_type">Flat Type</label>
                                <select class="custom-select form-control" id="flat_type" name="flat_type">
                                    <option value="">Select Flat Type</option>
                                    @foreach ($flat_type as $key => $flatType)
                                        <option value="{{ $key }}">{{ $flatType }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>

                            <div class="form-group">
                                <label for="furniture_type">Furnish Type</label>
                                <select class="custom-select form-control" id="furniture_type" name="furniture_type">
                                    <option value="">Select Furnish Type</option>
                                    @foreach ($furniture_type as $key => $furnitureType)
                                        <option value="{{ $key }}">{{ $furnitureType }}</option>
                                    @endforeach
                                </select>
                                <span class="invalid-feedback" role="alert"></span>
                            </div>
                        </div>

                        <div class="card-footer text-center">
                            <button id="submitBtn" type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
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
        const INDEX_EMPLOYEE_URL = "{{ route('flat.store') }}";
        const dashboard_url = "{{ route('flat.index') }}";
    </script>
    <script src="{{ asset('assets/js/flat/create.js') }}"></script>
@endpush
