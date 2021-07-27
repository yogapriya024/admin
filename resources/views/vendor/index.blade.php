@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Vendor</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Vendor</li>
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
                    <h3 class="card-title">Vendor Relation Request</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                       data-toggle="modal" data-target="#user-modal">Import</a>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right mr-2"
                       onclick="event.preventDefault();document.getElementById('emailForm').submit();">Send Email</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <form action="{{route('vendor.mail')}}" method="post" id="emailForm">
                        @csrf
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>Email</th>
                                <th>Location</th>
                                <th>Request For</th>
                            </tr>
                            </thead>
                            <tbody>


                            @foreach($data as $rows)
                                @if (!$loop->first && ($rows[0] !=''))
                                    <tr>
                                        @php

                                            $heading = ['email[]', 'location[]', 'request_for[]'];
                                            $class = ['emailBox', 'locationBox', 'request_forBox'];
                                        @endphp

                                        @foreach($rows as $key => $row)
                                                <td>
                                                    {{$row}}
                                                    <input type="hidden" class="{{$class[$key]}}" value="{{  $row }}" name="{{$heading[$key]}}"/>
                                                </td>
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach

                            </tbody>

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
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Import</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" enctype="multipart/form-data" action="{{route('vendor')}}"
                      class="needs-validation bootstrap-form" method="post" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Excel</label>
                                <input type="file" name="excel" class="form-control" id="excel" valid-ext="/\.(xls|xlsx|csv)$/i"
                                       accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                                       placeholder="Enter City" required>
                                <div class="invalid-feedback">
                                    Please Select the valid File
                                </div>
                            </div>
                            <a href="{{url('public/sample.xlsx')}}">Click Here</a> to download sample file.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default float-right" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary btn-up">Import</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    @push('styles')
        <link rel="stylesheet" href="{{url('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet"
              href="{{url('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
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
            var table = $("#example1").DataTable({});
            $('.bootstrap-form').on('submit', function (e) {
                if(this.checkValidity() == false) {
                    $('.btn-up').prop("disabled",false);
                    $('.btn-up').html('Import');
                } else {
                    $('.btn-up').attr("disabled","disabled");
                    $('.btn-up').prepend('<i class="fa fa-spinner fa-spin"></i>');
                }
            });

            $(".modal").on("hidden.bs.modal", function () {
                $('form').each(function () {
                    $(this)[0].reset();
                });
                $('.bootstrap-form').removeClass('was-validated');
                $('#id').val('');
                $('.btn-up').prop("disabled",false);
                $('.btn-up').html('Import');
            });
            function getemail()
            {
                $('#example1 tbody tr').each(function(i, trow){
                    if($(this).find(".emailBox option").length == 0){
                        var select = $(this).find(".emailBox");
                        var tr = $(this);
                        select.attr('disabled', 'disabled');
                        var url = $(this).find(".urlBox").val();
                        $.ajax({
                            url:'{{route('vendor.getEmail')}}',
                            data:'url='+url,
                            type:'get',
                            success:function(data){
                                var result = JSON.parse(data)
                                $(result).each(function(i, v){
                                    var option = '<option value="'+v+'">'+v+'</option>';
                                    select.append(option);
                                    select.attr('disabled', false);
                                    tr.find('.load').addClass('d-none');
                                });

                            }
                        })
                    }
                });
            }
            //getemail();
        </script>
    @endpush
@endsection
