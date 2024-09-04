@extends('layouts.layouts')
@section('content')
    @push('style')
        <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    @endpush
    <div class="d-flex justify-content-end mt-2">
        <a href="{{ URL::route('owner_crud.create') }}"><button class="btn btn-primary">NEW APPLICATION</button></a><br><br>
    </div>
    <div class="container mt-5">
        
        <div class="table-responsive">
            <h4>FLAT OWNER DETAILS</h4>
            <table id="flatOwnerTable" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Owner Name</th>
                        <th>Flat No</th>
                        <th>Members</th>
                        <th>Park Slot</th>
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
            const INDEX_FLATOWNER_URL = "{{ route('owner_crud.index') }}"
        </script>
         <script src="{{ asset('assets/js/flatowner/datatable.js') }}"></script>
    @endpush
