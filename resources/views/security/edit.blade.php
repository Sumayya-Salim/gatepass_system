@extends('Layouts.layouts')

@section('content')
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ route('security.index') }}"><button class="btn btn-primary">BACK</button></a>
    </div>

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Edit Security Details</h3>
                    </div>

                    <!-- Form Start -->
                    <form id="securityeditform">
                        @csrf
                        @method('PUT') <!-- for update -->
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" 
                                       value="{{ $user->name }}" placeholder="Enter name" required>
                            </div>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ $user->email }}" placeholder="Enter email" required>
                            </div>

                            <div class="form-group">
                                <label for="phoneno">Phone No</label>
                                <input type="text" class="form-control" id="phoneno" name="phoneno" 
                                       value="{{ $user->phoneno }}" placeholder="Enter phone number" required pattern="\d{10}">
                            </div>


                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary" id="submitBtn">Update</button>
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
        const INDEX_SECURITY_URL = "{{ route('security.update', $user->id) }}";
        const dashboard_url = "{{ route('security.index') }}";
    </script>
    <script src="{{ asset('assets/js/security/update.js') }}"></script>
@endpush
