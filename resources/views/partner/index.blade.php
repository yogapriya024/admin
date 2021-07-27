@extends('layouts.portal')

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Partners</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                            <li class="breadcrumb-item active">Partners</li>
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
                    <h3 class="card-title">Partner List</h3>
                    <a type="button" href="javascript:void(0)" class="btn btn-primary btn-sm float-right"
                       data-toggle="modal" data-target="#user-modal">Add Partner</a>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Url</th>
                            <th>Country</th>
                            <th>City</th>
                            <th>Speciality</th>
                            <th>Description</th>
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
                    <h4 class="modal-title">Partner</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form role="form" action="{{route('partners.store')}}" class="needs-validation bootstrap-form" method="post" novalidate>
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
                                <label for="exampleInputEmail1">Speciality</label>
                                <input type="text" name="speciality" class="form-control" id="speciality"
                                       placeholder="Enter Speciality" >
                                <div class="invalid-feedback">
                                    Please Enter Speciality
                                </div>
                            </div>
                            <div class="form-check">
                                <input type="checkbox" value="1"  class="form-check-input" name="block" id="block">
                                <label class="form-check-label" for="isrfp">Block</label>
                            </div>

                            <div class="form-group">
                                <label for="status">Category</label>
                                <select class="form-control" name="category_id" id="category_id" required>
                                    <option value="">--Select--</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}">{{$category->category}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Category
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status">Tags</label>
                                <select class="select2bs4" name="tag_id[]" id="tag_id" multiple style="width: 100%;" data-placeholder="Select a Tag" required>
                                    @foreach($tags as $tag)
                                        <option value="{{$tag->id}}">{{$tag->description}}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Tag
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="status">Country</label>
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
                            <div class="form-group">
                                <label for="percentage">Percentage</label>
                                <div class="input-group">
                                    <input type="text" name="percentage" class="form-control" id="percentage" percentage required
                                           percentage-error="Please enter valid data"
                                           placeholder="Enter Percentage" >
                                    <div class="input-group-append">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please Enter Percentage
                                    </div>
                                </div>

                            </div>

                            <div class="form-check">
                                <input type="checkbox" value="1"  class="form-check-input" name="is_regular" id="is_regular">
                                <label class="form-check-label" for="isrfp">Is Regular</label>
                            </div>



                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea type="text" name="description" class="form-control" id="description"
                                          placeholder="Enter description" ></textarea>
                                <div class="invalid-feedback">
                                    Please description
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
        <link rel="stylesheet" href="{{url('public/assets/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{url('public/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
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
                    "ajax": {url: "{{route('getPartner')}}", type: 'post'},
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
                        { "data": "url", name: 'url' },
                        { "data": "country.description", name: 'country.description' },
                        { "data": "city.description", name: 'city.description' },
                        { "data": "speciality", name: 'speciality' },
                        { "data": "description", name: 'description' },
                        { "data": "tag", name: 'tag.description', searchable:true, sorting:false },
                        { "data": "action", name: 'action', searchable:false, sorting:false},
                    ]
                });


            function updateContent(v)
            {
                var id = $(v).data('id');
                var email = $(v).data('email');
                var name = $(v).data('name');
                var block = $(v).data('block');
                var contact = $(v).data('contact');
                var description = $(v).data('description');
                var tag_id = $(v).data('tag_id');
                var city_id = $(v).data('city_id');
                var category_id = $(v).data('category_id');
                var country_id = $(v).data('country_id');
                var speciality = $(v).data('speciality');
                var is_regular = $(v).data('is_regular');
                var percentage = $(v).data('percentage');
                var url = $(v).data('url');
                $.each(tag_id, function(i, v){
                    $("#tag_id option[value='" + v + "']").prop("selected", true);
                });
                $('#id').val(id);
               // $('#block').val(block);
                $('#email').val(email);
                $('#name').val(name);
                $('#contact').val(contact);
                $('#description').val(description);
                $('#tag_id').trigger('change');
                $('#country_id').val(country_id);
                $('#city_id').val(city_id);
                $('#category_id').val(category_id);
                $('#speciality').val(speciality);
                $('#percentage').val(percentage);
                $('#is_regular').prop('checked', false);
                $('#block').prop('checked', false);
                $('#url').val(url);
                if(is_regular == 1){
                    $('#is_regular').prop('checked', true);
                }
                if(block == 1){
                    $('#block').prop('checked', true);
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
                                toastr.success('Partner Saved Successfully');
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
                $('#id').val('');
                $('.bootstrap-form').removeClass('was-validated');
            });
                $('#country_id').change(function(){
                    var value= $(this).val();
                    $('.countryGroup').addClass('d-none');
                    $('.group'+value).removeClass('d-none');
                });
                $('.select2bs4').select2()
        </script>
    @endpush
@endsection
