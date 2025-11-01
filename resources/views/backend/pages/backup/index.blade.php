@extends('backend.layouts.app')
@section('title')
    Database Backup
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
        'parent_page' => 'Database Backup',
        'page_name' => 'Backup List',
    ])
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    @can('add-database-backup')
                        <div class="row mb-3">
                            <div class="col-sm-12">
                                <div class="text-sm-end">
                                    <button type="button"
                                        class="btn btn-success btn-rounded waves-effect waves-light addContact-modal mb-2"
                                        onclick="event.preventDefault(); document.getElementById('new-backup-form').submit();">
                                        <i class="mdi mdi-plus me-1"></i> New Backup</button>
                                    <form action="{{ route('admin.backup.store') }}" method="POST" class="d-none"
                                        id="new-backup-form">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endcan
                    <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Last Backup</th>
                                <th>File Name</th>
                                <th>File Size</th>
                                @if (Auth::user()->haspermission('download-database-backup') || Auth::user()->haspermission('delete-database-backup'))
                                    <th>Action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($backups as $index => $backup)
                                <tr>
                                    <th>{{ $index + 1 }}</th>
                                    <td>{{ $backup['created_at'] }}</td>
                                    <td>{{ $backup['file_name'] }}</td>
                                    <td>{{ $backup['file_size'] }}</td>
                                    @if (Auth::user()->haspermission('download-database-backup') || Auth::user()->haspermission('delete-database-backup'))
                                        <td>
                                            @can('download-database-backup')
                                                <a href="{{ route('admin.backupDownload', $backup['file_name']) }}"
                                                    class="btn btn-info position-relative p-0 avatar-xs rounded editModule-btn">
                                                    <span class="avatar-title bg-transparent">
                                                        <i class="bx bxs-download" style="font-size: 16px"></i>
                                                    </span>
                                                </a>
                                            @endcan
                                            @can('delete-database-backup')
                                                <form action="{{ route('admin.backup.destroy', $backup['file_name']) }}"
                                                    method="POST"
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
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
