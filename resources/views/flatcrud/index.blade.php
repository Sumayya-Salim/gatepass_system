@extends('layouts.layouts')
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('flatcrud.create') }}"><button class="btn btn-primary">NEW APPLICATION</button></a><br><br>
    </div>
    <div class="container mt-5">
        {{-- <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('list.create') }}"><button class="btn btn-primary">NEW APPLICANT</button></a>
    </div> --}}
        <div class="table-responsive">
            <table id="flatTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Flat No</th>
                        <th>Flat Type</th>
                        <th>Furniture Type</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    @endsection
    @push('scripts')
        <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>

        <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min') }}"></script>
        <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min') }}"></script>
        <script>
            const INDEX_EMPLOYEE_URL = "{{ route('flatcrud.index') }}"
        </script>
        <script src="{{ asset('assets/js/flatcrud/datatable.js') }}"></script>
    @endpush
