@extends('template')

@section('title', 'Dashboard')

@section('content')
    <table class="table table-hover" id="user_table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
    </table>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready(function () {
            $('#user_table').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    url: "{{ route('user.datatable') }}",
                    dataType: "json",
                    type: "post"
                },
                "columns": [
                    {"data": "id"},
                    {"data": "name"},
                    {"data": "email"},
                    {"data": "role_id"},
                    {"data": "active"},
                    {"data": "created_at"},
                    {"data": "options"},
                ],
                order: [
                    ['1', 'asc']
                ],
                'columnDefs': [{
                    "orderable": false,
                    'targets': [0, 6]
                }]
            });
        });

        function confirmAlert() {
            if(confirm("Are you sure?")) {
                return true;
            }
            return false;
        }
    </script>

@endsection
