@extends('backend.layouts.master')

@section('content')
<div class="content_area">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="title">Compression</h4>
        @can('add_designation')
        <button type="button" class="btn btn-primary" id="add_btn">Add file</button>
        @endcan
    </div>

    @if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
    </div>
    @endif

    <div class="card">
        <div class="card-header">Compressed Files</div>
        <div class="card-body">
            <table class="table table-bordered" id="compressions_table">
                <button class="btn btn-danger" id="bulk_delete_btn" type="button">Bulk Delete</button>
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select_all" title="select all"></th>
                        <th>File</th>
                        <th>File Type</th>
                        <th>Download</th>
                        <th>Size Before</th>
                        <th>Size After</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>

    <div class="modal fade" id="compression_modal" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('file.upload') }}" enctype="multipart/form-data" class="needs-validation" novalidate id="file_form">
                    @csrf
                    <div id="method_field"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="model_label"></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <div class="mb-3">
                                <label for="file" class="form-label">Upload File</label>
                                <input class="form-control" type="file" name="file" required id="file">
                                <div class="invalid-feedback">Please choose a file.</div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button class="btn-soft" type="submit">Upload file</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endsection

    @push('scripts')
    <script>
        $(document).ready(function() {
            $('#compressions_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('compression.index') }}",
                columns: [{
                        data: 'checkbox',
                        name: 'checkbox',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'file',
                        name: 'file'
                    },
                    {
                        data: 'filetype',
                        name: 'filetype'
                    },
                    {
                        data: 'download',
                        name: 'download'
                    },
                    {
                        data: 'size_before',
                        name: 'size_before'
                    },
                    {
                        data: 'size_after',
                        name: 'size_after'
                    },
                    {
                        data: 'actions',
                        name: 'actions',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        });


        // sweetalert on delete
        function confirmDelete(event) {
            event.preventDefault();
            var form = event.target.closest("form");

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
    @endpush

    @push('styles')
    <style>
        table.dataTable td:nth-child(2),
        table.dataTable td:nth-child(3),
        table.dataTable td:nth-child(4) {
            word-break: break-all;
            white-space: pre-line;
        }
    </style>
    @endpush