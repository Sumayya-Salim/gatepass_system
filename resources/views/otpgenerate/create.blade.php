@extends('Layouts.layouts')

@section('content')
    {{-- <div class="d-flex justify-content-end mt-2">
        <a href="{{ route('gatepasses.index') }}"><button class="btn btn-primary">BACK</button></a><br><br>
    </div> --}}
    <!-- left column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">OTP Verification</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="otpverify">
                        @csrf
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="email" class="col-sm-2 col-form-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                </div>
                            </div>
                            

                            <div class="form-group row">
                                <label for="otp" class="col-sm-2 col-form-label">OTP</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="otp" name="otp" placeholder="Enter otp">
                                </div>
                            </div>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{-- <button type="submit" class="btn btn-info">Sign in</button> --}}
                            <button type="submit" class="btn btn-success float-right" id="submitBtn">Submit</button>
                        </div>
                        <!-- /.card-footer -->
                    </form>
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
        const dashboard_url = "{{ route('flatguest.index') }}";
        const OTP_VERIFY = "{{ route('securitycheck.otpverify') }}";

    </script>
    <script src="{{ asset('assets/js/otp/otpverify.js') }}"></script>
@endpush
