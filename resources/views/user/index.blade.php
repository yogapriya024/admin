@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Users</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
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
                    <h3 class="card-title">Users List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                       data-toggle="modal" data-target="#user-modal">Add User</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
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
    <div class="modal fade" id="user-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('user.store')}}" class="needs-validation bootstrap-form" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name</label>
                                <input type="text" name="name" class="form-control" id="name"
                                       placeholder="Enter Name" required>
                                <div class="invalid-feedback">
                                    Please Enter Name
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email</label>
                                <input type="email" name="email" class="form-control" id="email"
                                       placeholder="Enter email" autocomplete="off" required>
                                <div class="invalid-feedback">
                                    Please Enter Email
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">--Select--</option>
                                    <option value="Active">Active</option>
                                    <option value="In Active">In Active</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Status
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" vlaue="1" onchange="showPassword()" class="form-check-input" name="set_password" id="set_password">
                                <label class="form-check-label" for="set_password">Set Password</label>
                            </div>

                            <div class="form-group passDiv d-none">
                                <label for="name">Password</label>
                                <input type="password" class="form-control" id="password" name="password" >
                                <div class="invalid-feedback">
                                    Please Enter Password
                                </div>
                            </div>
                            <div class="form-group passDiv d-none">
                                <label for="name">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" equalTo="#password"
                                       password-error="Confirm password does not match"  >
                                <div class="invalid-feedback">
                                    Please Enter Confirm Password
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
        <script src="{{url('public/assets/dist/js/validator.js')}}"></script>
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
                    "ajax": {url: "{{route('getUser')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "columns": [
                        { "data": "name", name: 'name' },
                        { "data": "email", name: 'email' },
                        { "data": "status", name: 'status' },
                        { "data": "action", name: 'action'},
                    ]
                });

            function showPassword()
            {
                $('.passDiv').addClass('d-none');
                if($( '#set_password' ).is( ":checked" ) ){
                    $('.passDiv').removeClass('d-none');
                }
            }
            function updateContent(v)
            {
                var id = $(v).data('id')
                var name = $(v).data('name')
                var email = $(v).data('email')
                var status = $(v).data('status')
                $('#id').val(id)
                $('#name').val(name)
                $('#email').val(email)
                $('#status').val(status)
                $('#user-modal').modal('show');
            }
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
                                toastr.success('User Saved Successfully');
                            }

                            $('.btn-up').prop("disabled",false);
                            $('.btn-up').html('Save');

                        }
                    });
                }
            });
            $(".modal").on("hidden.bs.modal", function () {
                $('form').each(function(){
                    $(this)[0].reset();
                });
                $('.bootstrap-form').removeClass('was-validated');
                $('#id').val('');
            });
        </script>
    @endpush
@endsection
