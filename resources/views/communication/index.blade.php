@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Lead Communication</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Lead Communication</li>
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
                    <h3 class="card-title">Lead Communication List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right sendEmail"
                       >Send Email</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" id="leadForm" action="{{route('communication.email')}}">
                        @csrf
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="headBox"></th>
                                <th>Lead Name</th>
                                <th>Lead Email</th>
                                <th>Lead Country/City</th>
                                <th>Lead Country/City</th>
                                <th>Partner Name</th>
                                <th>Partner Email</th>
                                <th>Partner Country/City</th>
                                <th>Partner Country/City</th>
                                <th>Partner Speciality</th>
                                <th>Partner Description</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody></tbody>

                        </table>
                    </form>
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
                    "ajax": {url: "{{route('getCommunication')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "columns": [
                        { "data": "id", name: 'id', 'checkboxes': true, 'className': 'leadBox'},
                        { "data": "lead.name", name: 'lead.name' },
                        { "data": "lead.email", name: 'lead.email' },
                        { "data": "lead.country_id", name: 'lead.country_id' },
                        { "data": "lead.city_id", name: 'lead.city_id', visible:false },
                        { "data": "partner.name", name: 'partner.name' },
                        { "data": "partner.email", name: 'partner.email' },
                        { "data": "partner.country_id", name: 'partner.country_id' },
                        { "data": "partner.city_id", name: 'partner.city_id', visible:false },
                        { "data": "partner.speciality", name: 'partner.speciality' },
                        { "data": "partner.description", name: 'partner.description' },
                        { "data": "status", name: 'status' },
                    ],
                    'columnDefs': [{
                        'targets': 0,
                        'searchable':false,
                        'orderable':false,
                        'className': 'dt-body-center',
                        'render': function (data, type, full, meta){
                            return '<input type="checkbox" name="id[]" value="'
                                + $('<div/>').text(data).html() + '">';
                        }
                    }],
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

                $('.headBox').on('click', function(){
                    // Check/uncheck all checkboxes in the table
                    var rows = table.rows({ 'search': 'applied' }).nodes();
                    $('input[type="checkbox"]', rows).prop('checked', this.checked);
                });
                $('.sendEmail').click(function(){
                    var check = 0;
                    $('input[type="checkbox"]').each(function(){
                        if($(this).prop('checked') == true){
                            check = 1;
                        }
                    });
                    if(check == 1){
                        $('#leadForm').submit();
                    }

                });
        </script>
    @endpush
@endsection
