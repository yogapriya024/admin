@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Email Sent</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Email Sent</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Email Sent List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>MI</th>
                            <th>Lead Name</th>
                            <th>Lead URL</th>
                            <th>Partner URL</th>
                            <th>Partner Email</th>
                            <th>Partner Country/City</th>
                            <th>Partner Country/City</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody></tbody>

                    </table>
                </div>
                <!-- /.card-body -->
            </div>

            <!-- /.card -->

        </section>
        <!-- /.content -->
    </div>


    @push('styles')
        <link rel="stylesheet" href="{{url('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{url('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    @endpush
    @push('scripts')
        <script src="{{url('public/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script>

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var table = $("#example1").DataTable({
                    "responsive": true,
                    "autoWidth": false,
                    "processing": true,
                    "serverSide": true,
                    "ajax": {url: "{{route('getCommunication', 'emailSent')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "columns": [
                        { "data": "lead.id", name: 'lead.id', 'checkboxes': true, 'className': 'leadBox'},
                        { "data": "lead.name", name: 'lead.name' },
                        { "data": "lead.url", name: 'lead.url' },
                        { "data": "partner.url", name: 'partner.url' },
                        { "data": "partner.email", name: 'partner.email' },
                        { "data": "partner.country_id", name: 'partner.country_id' },
                        { "data": "partner.city_id", name: 'partner.city_id', visible:false },
                        { "data": "introduce", name: 'introduce', searchable:false },
                    ],

                    'order': [1, 'asc']
                });


            $(".modal").on("hidden.bs.modal", function () {
                $('form').each(function(){
                    $(this)[0].reset();
                });
                $(':input').each(function(){
                    $(this).removeClass('is-invalid');
                    $(this).removeClass('is-valid');
                });
                $('#id').val('');
            });


        </script>
    @endpush
@endsection
