@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Customer Requests</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Customer Requests</li>
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
                    <h3 class="card-title">Customer Requests List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right sendEmail"
                       >Send Email</a>
                    <a type="button" href="javascript:void(0)" data-toggle="modal" data-target="#user-modal" class="btn btn-primary btn-sm float-right mr-3"
                    >Add New</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form method="post" id="leadForm" action="{{route('customerRequest.email')}}">
                        @csrf
                        <table id="example1" class="table table-bordered">
                            <thead>
                            <tr>
                                <th><input type="checkbox" class="headBox"></th>
                                <th>Email</th>
                                <th>Service</th>
                                <th>Type</th>
                                <th>Customer/company name/YOU</th>
                                <th>Contact Name</th>
                                <th>Location</th>
                                <th>Last Date</th>
                                <th>URL</th>
                                <th>Action</th>
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
    <div class="modal fade" id="user-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('customerRequest.store')}}" class="needs-validation bootstrap-form" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Enter Email" required>
                                <div class="invalid-feedback">
                                    Please Enter Email
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="service">Service</label>
                                <input type="text" name="service" class="form-control" id="service"
                                       placeholder="Enter Service" required>
                                <div class="invalid-feedback">
                                    Please Enter Service
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="type">Type</label>
                                <input type="text" name="type" class="form-control" id="type"
                                        placeholder="Enter Type" autocomplete="off" required />

                                <div class="invalid-feedback">
                                    Please Select Type
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="company">Customer/company name/YOU</label>
                                <input type="text" name="company" class="form-control" id="company"
                                       placeholder="Enter Customer/company name/YOU" >
                                <div class="invalid-feedback">
                                    Please Enter Customer/company name/YOU
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Url</label>
                                <input type="text" name="url" class="form-control" id="url"
                                       placeholder="Enter Url"  required>
                                <div class="invalid-feedback">
                                    Please Enter Url
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="contact_name">Contact Person Name</label>
                                <input type="text" name="contact_name" class="form-control" id="contact_name"
                                       placeholder="Enter Contact Person Name"  required>
                                <div class="invalid-feedback">
                                    Please Enter Contact Person Name
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="contact_name">Location</label>
                                <input type="text" name="location" class="form-control" id="location"
                                       placeholder="Enter Location"  required>
                                <div class="invalid-feedback">
                                    Please Enter Location
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Last Date</label>
                                <input type="date" name="last_date" class="form-control" id="last_date"
                                       placeholder="Enter Date" min="{{date('Y-m-d')}}"  required>
                                <div class="invalid-feedback">
                                    Please Enter a valid Date
                                </div>
                            </div>

                            <input type="hidden" name="id" id="id">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-up">Save</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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
                    "ajax": {url: "{{route('getCustomerRequest')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "columns": [
                        { "data": "id", name: 'id', 'checkboxes': true, 'className': 'leadBox'},
                        { "data": "email", name: 'email' },
                        { "data": "service", name: 'service' },
                        { "data": "type", name: 'type' },
                        { "data": "company", name: 'company' },
                        { "data": "contact_name", name: 'contact_name'},
                        { "data": "location", name: 'location' },
                        { "data": "last_date", name: 'last_date' },
                        { "data": "url", name: 'url' },
                        { "data": "action", name: 'action' }

                    ],
                    'columnDefs': [{
                        'targets': 0,
                        'searchable':false,
                        'orderable':false,
                        'className': 'dt-body-center',
                        'render': function (data, type, full, meta){
                            if(full.status == 1){
                                return '<input type="checkbox" name="id[]" value="'
                                    + $('<div/>').text(data).html() + '">';
                            }else{ return ''; }

                        }
                    }],
                    "createdRow": function( row, data, dataIndex){
                        if(data.compare == 'less'){
                            $(row).css('background-color', 'rgba(0,0,0,.10)');
                        }
                    },
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
                $('.bootstrap-form').on('submit', function (e) {
                    if(this.checkValidity() == false) {
                    } else {
                        var form = $(this).attr('id');
                        e.preventDefault();
                        $.ajax({
                            type: 'POST',
                            url: $(this).attr('action'),
                            data: new FormData(this),
                            contentType: false,
                            cache: false,
                            processData:false,
                            beforeSend: function(){
                                $('.btn-up').attr("disabled","disabled");
                                $('.btn-up').prepend('<i class="fa fa-spinner fa-spin"></i>');
                            },
                            success: function(msg){
                                if(msg.errors){
                                    $('.bootstrap-form').removeClass('was-validated')
                                    $.each(msg.errors, function(key, value){
                                        $('#'+key).addClass('is-invalid');
                                        $('#'+key).parent().find('.invalid-feedback').html(value);
                                    });
                                }else{
                                    table.ajax.reload();
                                    $(".bootstrap-form")[0].reset();
                                    $('#id').val('');
                                    $('#user-modal').modal('hide');
                                    toastr.success('Request Saved Successfully');
                                }

                                $('.btn-up').prop("disabled",false);
                                $('.btn-up').html('Save');

                            }
                        });
                    }
                });
                function updateContent(v)
                {
                    var id = $(v).data('id');
                    var contact_name = $(v).data('contact_name');
                    var email = $(v).data('email');
                    var service = $(v).data('service');
                    var type = $(v).data('type');
                    var company = $(v).data('company');
                    var location = $(v).data('location');
                    var url = $(v).data('url');

                    $('#id').val(id);
                    $('#contact_name').val(contact_name);
                    $('#email').val(email);
                    $('#service').val(service);
                    $('#type').val(type);
                    $('#company').val(company);
                    $('#location').val(location);
                    $('#url').val(url);


                    $('#user-modal').modal('show');
                }
        </script>
    @endpush
@endsection
