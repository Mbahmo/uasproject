@extends('adminlte::page')
@section('title', 'AdminLTE')

<!-- jQuery library -->
<script src="{{ mix('js/app.js') }}"></script>

<!-- Latest compiled JavaScript -->

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
                        <p class="errorDescription text-danger hidden"></p>
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
                    <div class="form-group" style="display:none;">
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
                        <label for="edit_description" class="control-label">
                        Address<span class="required">*</span>
                        </label>
                        <textarea class="form-control" id="edit_description" name="edit_description"></textarea>
                        <p class="edit_errorDescription text-danger hidden"></p>
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
                    Swal.fire('success!','Successfully Added','success');
                }
            },
            error:function(data){
                console.log(data);
            }

        });
    });

    //calling edit modal and id info of data
    $('#laravel_datatable').on('click','.btnEdit[data-edit]',function(e){
        e.preventDefault();
        var url = $(this).data('edit');

                    $.ajax({
                        url : url,
                        type : 'GET',
                        datatype : 'json',
                        success:function(data){
                            $('#edit_ID').val(data.PaymentsId);
                            $('#edit_name').val(data.PaymentsName);
                            $('#edit_description').val(data.PaymentsDescription);
                            $('.edit_errorName').addClass('hidden');
                            $('.edit_errorDescription').addClass('hidden');
                            $('#mdlEditData').modal('show');
                        }
                    });

    });

    // updating data infomation
    $('#btnUpdate').on('click',function(e){
        e.preventDefault();
        var url = "/payments/"+$('#edit_ID').val();
        var frm = $('#frmDataEdit');
         Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, edit it!'

        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type :'PUT',
                    url : url,
                    dataType : 'json',
                    data : frm.serialize(),
                    success:function(data){
                        if (data.errors) {
                            if (data.errors.edit_name) {
                                $('.edit_errorName').removeClass('hidden');
                                $('.edit_errorName').text(data.errors.edit_name);
                            }
                            if (data.errors.edit_description) {
                                $('.edit_errorDescription').removeClass('hidden');
                                $('.edit_errorDescription').text(data.errors.edit_description);
                            }
                        }
                        if (data.success == true) {
                            // console.log(data);
                            $('.edit_errorName').addClass('hidden');
                            $('.edit_errorDescription').addClass('hidden');
                            frm.trigger('reset');
                            $('#mdlEditData').modal('hide');
                            swal.fire('Success!','Data Updated Successfully','success');
                            table.ajax.reload(null,false);
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                            alert('Please Reload to read Ajax');
                    }
                });
        } else {
            swal.fire("Cancelled", "You Cancelled", "error");
        }
        })
    });

    //deleting data
    $('#laravel_datatable').on('click','.btnDelete[data-remove]',function(e){
        e.preventDefault();
        var url = $(this).data('remove');

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'

        }).then((result) => {
            if (result.value) {
                    $.ajax({
                    url : url,
                    type: 'DELETE',
                    dataType : 'json',
                    data : { method : '_DELETE' , submit : true},
                    success:function(data){
                        if (data == 'Success') {
                            swal.fire("Deleted!", "Category has been deleted", "success");
                            table.ajax.reload(null,false);
                        }
                    }
                });
            } else {
                swal.fire("Cancelled", "You Cancelled", "error");
            }
        })
    });
});
</script>
@stop
