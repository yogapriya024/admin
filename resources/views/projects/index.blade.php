@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Projects</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Projects</li>
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
                    <h3 class="card-title">Project List</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Lead Name</th>
                            <th>Lead URL</th>
                            <th>Partner Name</th>
                            <th>Partner URL</th>
                            <th>Description</th>
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('projects.update')}}" class="needs-validation bootstrap-form" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">

                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea type="text" name="description" class="form-control" id="description"
                                          placeholder="Enter description" ></textarea>
                                <div class="invalid-feedback">
                                    Please Enter description
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
                "ajax": {url: "{{route('getProjects')}}", type: 'post'},
                "language": {
                    "emptyTable": "No data found"
                },
                'aLengthMenu': [
                    [25, 50, 100, 200, -1],
                    [25, 50, 100, 200, "All"]
                ],
                "columns": [

                    { "data": "lead.name", name: 'lead.name' },
                    { "data": "lead.url", name: 'lead.url' },
                    { "data": "partner.name", name: 'partner.name' },
                    { "data": "partner.url", name: 'partner.url' },
                    { "data": "description", name: 'description' },
                    { "data": "action", name: 'action', searchable:false, sortable:false }
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
            function updateContent(v)
            {
                var id = $(v).data('id');
                var description = $(v).data('description');
                $('#id').val(id);
                $('#description').val(description);
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
                                toastr.success('Description Saved Successfully');
                            }

                            $('.btn-up').prop("disabled",false);
                            $('.btn-up').html('Save');

                        }
                    });
                }
            });

        </script>
    @endpush
@endsection
