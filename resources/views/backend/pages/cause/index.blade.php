@extends('backend.layouts.app')
@section('title')
    Causes
@endsection
@push('style')
    <style>
        .wrap {
            white-space: normal !important;
            word-wrap: break-word;
        }
    </style>
@endpush
@section('content')
    @include('backend.layouts.include.breadcrumb', [
        'parent_page' => 'Causes',
        'page_name' => 'Cause List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-cause')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <a href="{{ route('admin.cause.create') }}"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"><i
                                            class="mdi mdi-plus me-1"></i> New Cause</a>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <form action="{{ route('admin.cause.index') }}" method="GET">
                        <div class="row d-flex justify-content-end">
                            <div class="col-auto mb-4 d-flex">
                                <input class="form-control me-2" type="text" placeholder="Search" name="search"
                                    value="{{ request('search') }}">
                                <button type="submit" class="btn btn-success waves-effect waves-light">
                                    <i class="bx bx-search font-size-16 align-middle"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <table id="datatabl" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Goal</th>
                                <th>Raised</th>
                                @if (Auth::user()->haspermission('edit-cause') ||
                                        Auth::user()->haspermission('read-cause') ||
                                        Auth::user()->haspermission('cause-donation') ||
                                        Auth::user()->haspermission('delete-cause'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($causes as $index => $cause)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td><img src="{{ asset('uploads/cause') }}/{{ $cause->featured_photo }}"
                                            alt="Cause Photo" class="rounded" style="max-height:100px"></td>
                                    <td class="wrap">{{ $cause->name }}</td>
                                    <td class="wrap"><b>$</b>{{ $cause->goal }}</td>
                                    <td class="wrap"><b>$</b>{{ $cause->raised }}</td>
                                    @if (Auth::user()->haspermission('edit-cause') ||
                                            Auth::user()->haspermission('read-cause') ||
                                            Auth::user()->haspermission('delete-cause'))
                                        <td>
                                            @can('edit-cause')
                                                <a href="{{ route('admin.cause.edit', $cause->id) }}"
                                                    class="btn btn-warning position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-edit" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('read-cause')
                                                <a href="{{ route('admin.cause.show', $cause->id) }}"
                                                    class="btn btn-info position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bx-show" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-cause')
                                                <form action="{{ route('admin.cause.destroy', $cause->id) }}" method="POST"
                                                    class="btn btn-danger position-relative p-0 avatar-xs rounded">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-danger position-relative p-0 avatar-xs rounded show_confirm">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-trash" style="font-size: 16px"></i>
                                                        </span>
                                                    </button>
                                                </form>
                                            @endcan
                                            @if ($cause->raised > 0)
                                                @can('cause-donation')
                                                    <a href="{{ route('admin.causeDonationPage', $cause->id) }}"
                                                        class="btn btn-dark position-relative p-0 avatar-xs rounded editModule-btn">
                                                        <span class="avatar-title bg-transparent">
                                                            <i class="bx bx-money" style="font-size: 16px"></i>
                                                        </span>
                                                    </a>
                                                @endcan
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No data available in table</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $causes->links('vendor.pagination.admin_dashboard') }}
                </div>
            </div>
        </div> <!-- end col -->
    </div>
@endsection

@push('script')
    <script>
        $(document).on('click', '.show_confirm', function(event) {
            event.preventDefault();
            var form = $(this).closest('form');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    </script>
@endpush
