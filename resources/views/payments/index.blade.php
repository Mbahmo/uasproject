@extends('adminlte::page')
@section('title', 'AdminLTE')

<!-- jQuery library -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<link  href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
<meta name="csrf-token" content="{{csrf_token()}}">

@section('content')
<div class="container">
    <h2>Laravel DataTable - Tuts Make</h2>
    <button type="button" class="btn btn-primary" id="btnAdd">Add New</button>
    <table class="table table-bordered" id="laravel_datatable">
        {{csrf_field()}}
        <thead>
            <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>

<!-- start addmodal-->
<div class="modal fade" tabindex="-1" role="dialog" id="mdlAddData">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Form</h4>
                </div>
                <div class="modal-body">
                <form role="form" id="frmDataAdd">
                    <div class="form-group">
                        <label for="name" class="control-label">
                        Name<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="name" name="name">
                        <p class="errorName text-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="description" class="control-label">
                        Description<span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="description" name="description"></textarea>
                        <p class="errordescription text-danger hidden"></p>
                    </div>
                </form>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnSave"><i class="glyphicon glyphicon-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- start endmodal-->

    <!-- start editmodal-->
    <div class="modal fade" tabindex="-1" role="dialog" id="mdlEditData">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Edit Form</h4>
                </div>
                <div class="modal-body">
                <form role="form" id="frmDataEdit">
                    <div class="form-group">
                        <label for="edit_ID" class="control-label">
                        ID
                        </label>
                        <input type="text" class="form-control" id="edit_ID" name="edit_ID" disabled>
                    </div>
                    <div class="form-group">
                        <label for="edit_name" class="control-label">
                        Name<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="edit_name" name="edit_name">
                        <p class="edit_errorName text-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="edit_contact" class="control-label">
                        Contact<span class="required">*</span>
                        </label>
                        <input type="text" class="form-control" id="edit_contact" name="edit_contact">
                        <p class="edit_errorContact text-danger hidden"></p>
                    </div>
                    <div class="form-group">
                        <label for="edit_address" class="control-label">
                        Address<span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="edit_address" name="edit_address"></textarea>
                        <p class="edit_errorAddress text-danger hidden"></p>
                    </div>
                </form>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="btnUpdate"><i class="glyphicon glyphicon-save"></i>&nbsp;Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end editmodal-->
<script>
    $(document).ready(function(){

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        table = $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('payments.index')}}",
            columns: [{
                    data: 'PaymentsId',
                    name: 'PaymentsId'
                },
                {
                    data: 'PaymentsName',
                    name: 'PaymentsName'
                },
                {data: 'action' , name : 'action', orderable : false ,searchable: false},
            ]
        });

    //calling add modal
    $('#btnAdd').click(function(e){
        $('#mdlAddData').modal();
    });

    //Adding new data
    $('#btnSave').click(function(e){
        // console.log("test");
        e.preventDefault();
        var frm = $('#frmDataAdd');
        $.ajax({
            url : '/payments',
            type : 'POST',
            dataType: 'json',
            data : {
                'csrf-token': '{{csrf_token()}}',
                 name : $('#name').val(),
                 description : $('#description').val(),
            },
            success:function(data){
                $('.errorName').addClass('hidden');
                $('.errorDescription').addClass('hidden');
                if (data.errors) {
                    if (data.errors.name) {
                        $('.errorName').removeClass('hidden');
                        $('.errorName').text(data.errors.name);
                    }
                    if (data.errors.description) {
                        $('.errorDescription').removeClass('hidden');
                        $('.errorDescription').text(data.errors.description);
                    }
                }
                if (data.success == true) {
                    $('#mdlAddData').modal('hide');
                    frm.trigger('reset');
                    table.ajax.reload(null,false);
                    swal('success!','Successfully Added','success');
                }
            },
            error:function(data){
                console.log(data);
            }

        });
    });

    //calling edit modal and id info of data
    $('#tblData').on('click','.btnEdit[data-edit]',function(e){
        e.preventDefault();
        var url = $(this).data('edit');
        swal({
              title: "Are you sure want to Edit this item?",
              type: "info",
              showCancelButton: true,
              confirmButtonClass: "btn-info",
              confirmButtonText: "Confirm",
              cancelButtonText: "Cancel",
              closeOnConfirm: true,
              closeOnCancel: true
            },
                function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url : url,
                        type : 'GET',
                        datatype : 'json',
                        success:function(data){
                            $('#edit_ID').val(data.id);
                            $('#edit_name').val(data.name);
                            $('#edit_contact').val(data.contact);
                            $('#edit_address').val(data.address);
                            $('.edit_errorName').addClass('hidden');
                            $('.edit_errorContact').addClass('hidden');
                            $('.edit_errorAddress').addClass('hidden');
                            $('#mdlEditData').modal('show');
                            $('#mdlEditData').modal('show');
                        }
                    });
                }
        });
    });

    // updating data infomation
    $('#btnUpdate').on('click',function(e){
        e.preventDefault();
        var url = "http://localhost:8000/crud/"+$('#edit_ID').val();
        var frm = $('#frmDataEdit');
        $.ajax({
            type :'PUT',
            url : url,
            dataType : 'json',
            data : frm.serialize(),
            success:function(data){
                // console.log(data);
                if (data.errors) {
                    if (data.errors.edit_name) {
                        $('.edit_errorName').removeClass('hidden');
                        $('.edit_errorName').text(data.errors.edit_name);
                    }
                    if (data.errors.edit_contact) {
                        $('.edit_errorContact').removeClass('hidden');
                        $('.edit_errorContact').text(data.errors.edit_contact);
                    }
                    if (data.errors.edit_address) {
                        $('.edit_errorAddress').removeClass('hidden');
                        $('.edit_errorAddress').text(data.errors.edit_address);
                    }
                }
                if (data.success == true) {
                    // console.log(data);
                    $('.edit_errorName').addClass('hidden');
                    $('.edit_errorContact').addClass('hidden');
                    $('.edit_errorAddress').addClass('hidden');
                    frm.trigger('reset');
                    $('#mdlEditData').modal('hide');
                    swal('Success!','Data Updated Successfully','success');
                    table.ajax.reload(null,false);
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
                {
                    alert('Please Reload to read Ajax');
                }
        });
    });

    //deleting data
    $('#tblData').on('click','.btnDelete[data-remove]',function(e){
        e.preventDefault();
        var url = $(this).data('remove');
        swal({
           title: "Are you sure want to remove this item?",
           text: "Data will be Temporary Deleted!",
           type: "warning",
           showCancelButton: true,
           confirmButtonClass: "btn-danger",
           confirmButtonText: "Confirm",
           cancelButtonText: "Cancel",
           closeOnConfirm: false,
           closeOnCancel: false,
        },
        function(isConfirm) {
            if (isConfirm) {
            $.ajax({
                url : url,
                type: 'DELETE',
                dataType : 'json',
                data : { method : '_DELETE' , submit : true},
                success:function(data){
                    if (data == 'Success') {
                        swal("Deleted!", "Category has been deleted", "success");
                        table.ajax.reload(null,false);
                    }
                }
            });
        }else{
        swal("Cancelled", "You Cancelled", "error");
        }
        });
    });
});
</script>
@stop
