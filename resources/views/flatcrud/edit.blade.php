@extends('Layouts.layouts')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-end mt-2">
            <a href="{{ route('flatcrud.index') }}"><button class="btn btn-primary">BACK</button></a>
        </div>
        <form id="editform">
            @csrf
            @method('PUT') <!-- For sending a PUT request -->

            <div class="mb-3">
                <label for="flat_no" class="form-label">Flat Number</label>
                <input type="text" class="form-control" id="flat_no" name="flat_no" value="{{ $flat->flat_no }}"
                    placeholder="Enter Flat Number">
            </div>

            <div class="mb-3">
                <label for="flat_type" class="form-label">Flat Type</label>
                <select class="form-control" id="flat_type" name="flat_type">
                    <option>Select Flat Type</option>
                    @foreach ($flat_type as $key => $flatType)
                        <option value="{{ $key }}" {{ $flat->flat_type == $key ? 'selected' : '' }}>
                            {{ $flatType }}
                        </option>
                    @endforeach
                </select>
            </div>
    
            <div class="mb-3">
                <label for="furniture_type" class="form-label">Furniture Type</label>
                <select class="form-control" id="furniture_type" name="furniture_type">
                    <option>Select Furniture Type</option>
                    @foreach ($furniture_type as $key => $furnitureType)
                        <option value="{{ $key }}" {{ $flat->furniture_type == $key ? 'selected' : '' }}>
                            {{ $furnitureType }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary" id="updateBtn">UPDATE</button>
        </form>
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
        const UPDATE_FLAT_URL = "{{ route('flatcrud.update', $flat->id) }}";
        const dashboard_url = "{{ route('flatcrud.index') }}";
    </script>
    <script src="{{ asset('assets/js/flatcrud/update.js') }}"></script>
@endpush
