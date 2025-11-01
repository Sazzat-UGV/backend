@extends('backend.layouts.app')
@section('title')
    Create Event
@endsection
@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/css/dropify.css"
        integrity="sha512-In/+MILhf6UMDJU4ZhDL0R0fEpsp4D3Le23m6+ujDWXwl3whwpucJG1PEmI3B07nyJx+875ccs+yX2CqQJUxUw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .dropify-wrapper .dropify-message p {
            font-size: 20px;
        }
    </style>
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Events',
        'page_name' => 'Add New Event',
    ])
    <div class="row">
        <div class="col-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    @can('browse-event')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="">
                                    <a href="{{ route('admin.event.index') }}"
                                        class="btn btn-secondary btn-rounded waves-effect waves-light addContact-modal mb-2">
                                        <i class="mdi mdi-arrow-left me-1"></i> Back to Events
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 mb-4">
                                <label class="form-label">Name<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('name')
                                            is-invalid
                                        @enderror"
                                    type="text" placeholder="Enter event name" name="name"
                                    value="{{ old('name') }}">
                                @error('name')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>


                            <div class="col-12 col-md-8  mb-4">
                                <label class="form-label">Locaiton<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('location')
                                            is-invalid
                                        @enderror"
                                    type="text" name="location" value="{{ old('location') }}" placeholder="Enter location">
                                @error('location')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 mb-4">
                                <label class="form-label">Date<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('date')
                                            is-invalid
                                        @enderror"
                                    type="date" name="date" value="{{ old('date') }}">
                                @error('date')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 mb-4">
                                <label class="form-label">Time<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('time')
                                            is-invalid
                                        @enderror"
                                    type="time" name="time" value="{{ old('time') }}">
                                @error('time')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Email</label>
                                <input
                                    class="form-control @error('email')
                                            is-invalid
                                        @enderror"
                                    type="text" name="email" value="{{ old('email') }}" placeholder="Enter email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Phone<span class="text-danger">*</span></label>
                                <input
                                    class="form-control @error('phone')
                                            is-invalid
                                        @enderror"
                                    type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone">
                                @error('phone')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>

                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Price</label>
                                <input
                                    class="form-control @error('price')
                                            is-invalid
                                        @enderror"
                                    type="text" name="price" value="{{ old('price') }}"
                                    placeholder="Enter price">
                                @error('price')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Total Seat</label>
                                <input
                                    class="form-control @error('total_seat')
                                            is-invalid
                                        @enderror"
                                    type="text" name="total_seat" value="{{ old('total_seat') }}"
                                    placeholder="Enter total seat">
                                @error('total_seat')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-4 mb-4">
                                <label class="form-label">Booked Seat</label>
                                <input
                                    class="form-control @error('booked_seat')
                                            is-invalid
                                        @enderror"
                                    type="text" name="booked_seat" value="{{ old('booked_seat') }}" placeholder="Enter booked seat">
                                @error('booked_seat')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Description<span class="text-danger">*</span></label>
                                <textarea name="description" id="description" cols="30" rows="5"
                                    class="form-control @error('description')
                                is-invalid
                                @enderror"
                                    placeholder="Enter description">{{ old('description') }}</textarea>
                                @error('description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 mb-4">
                                <label class="form-label">Short Description<span class="text-danger">*</span></label>
                                <textarea name="short_description" id="" cols="30" rows="5"
                                    class="form-control @error('short_description')
                                            is-invalid
                                        @enderror"
                                    placeholder="Enter short description">{{ old('short_description') }}</textarea>
                                @error('short_description')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Map</label>
                                <textarea name="map" id="" cols="30" rows="9"
                                    class="form-control @error('map')
                                            is-invalid
                                        @enderror"
                                    placeholder="Enter map code">{{ old('map') }}</textarea>
                                @error('map')
                                    <span class="invalid-feedback" role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                            <div class="col-12 col-md-6 mb-4">
                                <label class="form-label">Photo<span class="text-danger">*</span></label>
                                <input
                                    class="form-control dropify @error('photo')
                                    is-invalid
                                @enderror"
                                    type="file" name="photo">
                                @error('photo')
                                    <span class="text-danger" style="font-size: 11px"
                                        role="alert"><strong>{{ $message }}</strong></span>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button class="btn btn-success rounded-pill px-4" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Dropify/0.2.2/js/dropify.min.js"
        integrity="sha512-8QFTrG0oeOiyWo/VM9Y8kgxdlCryqhIxVeRpWSezdRRAvarxVtwLnGroJgnVW9/XBRduxO/z1GblzPrMQoeuew=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $('.dropify').dropify();
    </script>
        <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
        <script>
            ClassicEditor
                .create(document.querySelector('#description'))
                .catch(error => {
                    console.error(error);
                });
        </script>
@endpush
