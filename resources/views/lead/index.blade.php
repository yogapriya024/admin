@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Leads</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Leads</li>
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
                    <h3 class="card-title">Lead List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                       data-toggle="modal" data-target="#user-modal">Add Lead</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Url</th>
                            <th>Date</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Tags</th>
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
                    <h4 class="modal-title">Lead</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('leads.store')}}" class="needs-validation bootstrap-form" method="post" novalidate>
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
                                <label for="exampleInputEmail1">Contact</label>
                                <input type="text" name="contact" class="form-control" id="contact"
                                       placeholder="Enter Contact" >
                                <div class="invalid-feedback">
                                    Please Enter Contact
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
                                <label for="exampleInputEmail1">Date</label>
                                <input type="date" name="date" class="form-control" id="date"
                                       placeholder="Enter Date" min="{{date('Y-m-d')}}"  required>
                                <div class="invalid-feedback">
                                    Please Enter a valid Date
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="tag_id">Tags</label>
                                <select class="select2bs4" name="tag_id[]" id="tag_id" multiple="multiple" data-placeholder="Select a Tag"  style="width: 100%;" required>
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->description}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Tag
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="country_id">Country</label>
                                <select class="form-control" name="country_id" id="country_id" required>
                                    <option value="">--Select--</option>
                                    @foreach($country as $cuntry)
                                        <option value="{{$cuntry->id}}">{{$cuntry->description}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Country
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="city_id">City</label>
                                <select class="form-control" name="city_id" id="city_id">
                                    <option value="">--Select--</option>
                                    @foreach($country as $c)
                                        <optgroup class="group{{$c->id}} countryGroup" label="{{$c->description}}">
                                            @foreach($c->cities as $city)
                                                <option value="{{$city->id}}">{{$city->description}}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select City
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" value="1"  class="form-check-input" name="world_wide" id="world_wide">
                                <label class="form-check-label" for="world_wide">World Wide</label>
                            </div>

                            <div class="form-check">
                                <input type="checkbox" value="1"  class="form-check-input" name="isrfp" id="isrfp">
                                <label class="form-check-label" for="isrfp">ISRFP</label>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">RFP Email Text</label>
                                <textarea name="rfp_email_text" class="form-control" id="rfp_email_text"
                                          placeholder="Enter RFP Email Text"  ></textarea>
                                <div class="invalid-feedback">
                                    Please RFP Email Text
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea type="text" name="description" class="form-control" id="description"
                                          placeholder="Enter description" ></textarea>
                                <div class="invalid-feedback">
                                    Please Enter description
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Initial Requirements</label>
                                <textarea type="text" name="initial_requirements" class="form-control" id="initial_requirements" required
                                          placeholder="Enter Initial Requirements" ></textarea>
                                <div class="invalid-feedback">
                                    Please Enter Initial Requirements
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Requirements For</label>
                                <textarea type="text" name="requirements" class="form-control" id="requirements" required
                                          placeholder="Enter Requirements"  maxlength="200"></textarea>
                                <div class="invalid-feedback">
                                    Please Enter Requirements
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
        <link rel="stylesheet" href="{{url('public/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{url('public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{url('public/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet" href="{{url('public/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
        <style>
            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #007bff !important;
                border-color: #006fe6 !important;;
                color: #fff !important;;
            }
        </style>
    @endpush
    @push('scripts')
        <script src="{{url('public/assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{url('public/assets/plugins/select2/js/select2.full.min.js')}}"></script>
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
                    "ajax": {url: "{{route('getLead')}}", type: 'post'},
                    "language": {
                        "emptyTable": "No data found"
                    },
                    'aLengthMenu': [
                        [25, 50, 100, 200, -1],
                        [25, 50, 100, 200, "All"]
                    ],
                    "order": [3, 'asc' ],
                    "columns": [
                        { "data": "name", name: 'name' },
                        { "data": "email", name: 'email' },
                        { "data": "url", name: 'url' },
                        { "data": "date", name: 'date' },
                        { "data": "description", name: 'description' },
                        { "data": "status", name: 'status' },
                        { "data": "tag", name: 'tag.description', searchable:true, sorting:false },
                        { "data": "action", name: 'action', searchable:false, sorting:false},
                    ],
                    "createdRow": function( row, data, dataIndex){
                        if(data.status == 'Converted'){
                            $(row).css('background-color', 'rgba(0,0,0,.10)');
                        }
                    }
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
                var id = $(v).data('id');
                var name = $(v).data('name');
                var email = $(v).data('email');
                var date = $(v).data('date');
                var contact = $(v).data('contact');
                var description = $(v).data('description');
                var tag_id = $(v).data('tag_id');
                var city_id = $(v).data('city_id');
                var country_id = $(v).data('country_id');
                var url = $(v).data('url');
                var isrfp = $(v).data('isrfp');
                var world_wide = $(v).data('world_wide');
                var rfp_email_text = $(v).data('rfp_email_text');
                var initial_requirements = $(v).data('initial_requirements');
                var requirements = $(v).data('requirements');
                $.each(tag_id, function(i, v){
                    $("#tag_id option[value='" + v + "']").prop("selected", true);
                });
                $('#id').val(id);
                $('#name').val(name);
                $('#email').val(email);
                $('#date').val(date);
                $('#contact').val(contact);
                $('#description').val(description);
                $('#tag_id').trigger('change');
                $('#country_id').val(country_id);
                $('#city_id').val(city_id);
                $('#url').val(url);
                $('#rfp_email_text').val(rfp_email_text);
                $('#initial_requirements').val(initial_requirements);
                $('#requirements').val(requirements);
                $('#isrfp').prop('checked', false);
                $('#world_wide').prop('checked', false);
                if(isrfp == 1){
                    $('#isrfp').prop('checked', true);
                }
                if(world_wide == 1){
                    $('#world_wide').prop('checked', true);
                }
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
                                toastr.success('Lead Saved Successfully');
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
                $('.select2bs4').removeClass('is-invalid');
                $('.select2bs4').removeClass('is-valid');
            });
            $('#country_id').change(function(){
                var value= $(this).val();
                $('.countryGroup').addClass('d-none');
                $('.group'+value).removeClass('d-none');
            });
            $('#email').focus(function(){
                var name = $('#name').val();
                name = name.split(" ").join("")
                var email = name+"@malharinfoway.com";
                var field = $(this).val();
                if(field == '' || field == "@malharinfoway.com"){
                    $(this).val(email);
                }
            });
            $('.select2bs4').select2();


        </script>
    @endpush
@endsection
