@extends('Layouts.layouts')
@section('content')
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('security.index') }}"><button class="btn btn-primary">BACK</button></a><br><br>
    </div>
    <!-- left column -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">CREATION</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="securityregform">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                    >
                            </div>
                            
                            <div class="form-group">
                                <label for="phoneno">Phone no</label>
                                <input type="text" class="form-control" id="phoneno" name="phoneno"
                                    >
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    >
                            </div>
                        </div>
                        <!-- /.card-body -->

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary"  id="submitBtn">Submit</button>
                        </div>
                    </form>
                </div>
                <!-- /.card -->
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
            const INDEX_EMPLOYEE_URL = "{{ route('security.store') }}";
            const dashboard_url = "{{ route('security.index') }}";
        </script>
        <script src="{{ asset('assets/js/security/create.js') }}"></script>
    @endpush
