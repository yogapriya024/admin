<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{url('public/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{url('public/assets/dist/css/adminlte.min.css')}}">

    <link rel="stylesheet" href="{{url('public/assets/plugins/toastr/toastr.min.css')}}">

    @stack('styles')
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">
    <!-- Navbar -->
    @include('layouts.header')
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    @include('layouts.sidebar')

    <!-- Content Wrapper. Contains page content -->
    @yield('content')
    <!-- /.content-wrapper -->

    @include('layouts.footer')

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <div class="modal fade" id="delModal">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Delete Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form role="form" name="delForm" id="delForm"
                          enctype="multipart/form-data" method="post" action="">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
                        <div class="box-body">
                            Are you sure want to delete this?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger pull-left mr-10">Delete</button>
                            <button type="button" class="btn btn-default pull-left lh-24" data-dismiss="modal">Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
    <div class="modal fade" id="archiveModal">
        <div class="modal-dialog ">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Archive Confirmation</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>

                </div>
                <div class="modal-body">
                    <form role="form" name="archiveForm" id="archiveForm"
                          enctype="multipart/form-data" method="post" action="">
                        <input type="hidden" name="_method" value="delete">
                        {{ csrf_field() }}
                        <div class="box-body">
                            Are you sure want to archive this?
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger pull-left mr-10">Archive</button>
                            <button type="button" class="btn btn-default pull-left lh-24" data-dismiss="modal">Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
    </div>
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{url('public/assets/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{url('public/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{url('public/assets/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{url('public/assets/dist/js/demo.js')}}"></script>
<script src="{{url('public/assets/plugins/toastr/toastr.min.js')}}"></script>
<script>
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    function deleteData(e){
        var url = $(e).data('url');
        $('#delModal').modal('show');
        $('#delForm').attr('action', url);
    }
    function archiveData(e){
        var url = $(e).data('url');
        $('#archiveModal').modal('show');
        $('#archiveForm').attr('action', url);
    }
    @if(session('success'))
        toastr.success('{{session('success')}}');
    @endif
    @if(session('error'))
        toastr.error('{{session('error')}}');
    @endif
</script>
@stack('scripts')
</body>
</html>
