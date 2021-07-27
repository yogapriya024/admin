@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Country</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Settings</li>
                            <li class="breadcrumb-item active">Country</li>
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
                    <h3 class="card-title">Country List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                       data-toggle="modal" data-target="#user-modal">Add Country</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Country</th>
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
                    <h4 class="modal-title">Country</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('country.store')}}" class="needs-validation bootstrap-form" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Country</label>
                                <input type="text" name="description" class="form-control" id="description"
                                       placeholder="Enter Country" required>
                                <div class="invalid-feedback">
                                    Please Enter Country
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="">--Select--</option>
                                    <option value="1">Active</option>
                                    <option value="2">In Active</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Status
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
                    "ajax": {url: "{{route('getCountry')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "columns": [
                        { "data": "description", name: 'description' },
                        { "data": "status", name: 'status' },
                        { "data": "action", name: 'action'},
                    ]
                });


            function updateContent(v)
            {
                var id = $(v).data('id')
                var description = $(v).data('description')
                var status = $(v).data('status')
                $('#id').val(id)
                $('#description').val(description)
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
                                toastr.success('Country Saved Successfully');
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
