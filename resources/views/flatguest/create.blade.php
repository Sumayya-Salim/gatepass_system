@extends('Layouts.layouts')

@section('content')
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ route('flatguest.index') }}"><button class="btn btn-primary">BACK</button></a><br><br>
    </div>
    <!-- left column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Create Gatepass</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="guestform">
                        @csrf
                        <div class="card-body">
                            <!-- User ID (assuming this will be a hidden field or a dropdown if you want to select a user) -->
                            <div class="form-group">
                                <label for="user_id">User ID</label>
                                <select class="form-control" id="user_id" name="user_id">
                                    <option>Select User</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Visitor Name -->
                            <div class="form-group">
                                <label for="visitor_name">Visitor Name</label>
                                <input type="text" class="form-control" id="visitor_name" name="visitor_name"
                                    placeholder="Enter Visitor Name">
                            </div>

                            <div class="form-group">
                                <label for="visitor_email">Visitor Email</label>
                                <input type="text" class="form-control" id="visitor_email" name="visitor_email"
                                    placeholder="Enter Visitor Email">
                            </div>

                            <!-- Visitor Phone Number -->
                            <div class="form-group">
                                <label for="visitor_phoneno">Visitor Phone Number</label>
                                <input type="text" class="form-control" id="visitor_phoneno" name="visitor_phoneno"
                                    placeholder="Enter Visitor Phone Number">
                            </div>

                            <!-- Purpose -->
                            <div class="form-group">
                                <label for="purpose">Purpose</label>
                                <textarea class="form-control" id="purpose" name="purpose" placeholder="Enter Purpose"></textarea>
                            </div>

                            <!-- Entry Time (You might want to handle this with a timestamp in the backend) -->
                            <div class="form-group">
                                <label for="entry_time">Entry Time</label>
                                <input type="datetime-local" class="form-control" id="entry_time" name="entry_time">
                            </div>

                            <!-- Exit Time (You might want to handle this with a timestamp in the backend) -->
                            <div class="form-group">
                                <label for="exit_time">Exit Time</label>
                                <input type="datetime-local" class="form-control" id="exit_time" name="exit_time">
                            </div>
                            <div>
                                <button type="submit" class="btn btn-primary float-right" id="sendOtpBtn">Generate OTP And
                                    Submit</button>
                            </div>
                        </div>
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
        const generateOtpUrl = "{{ route('flatguest.generate.otp')}}";
    </script>

    <script src="{{ asset('assets/js/flatguest/create.js') }}"></script>
@endpush
