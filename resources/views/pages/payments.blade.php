@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content')
<div class="container">
    <h2>Laravel DataTable - Tuts Make</h2>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" id="btnAdd">Add New</button>
        <a type="button" class="btn btn-primary" href="{{route('payments.print')}}" target="_blank">Print</a>
    </div>
    <table class="table table-bordered" id="laravel_datatable">
        {{csrf_field()}}
        <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
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
        table = $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('payments.index')}}",
            columns: [
                {
                    data: 'PaymentsName',
                    name: 'PaymentsName'
                },
                {
                    data: 'PaymentsDescription',
                    name: 'PaymentsDescription'
                },
                {data: 'action' , name : 'action', orderable : false ,searchable: false},
            ]
        });

    //Calling Add Modal
    $('#btnAdd').click(function(e){
        add_payments();
    });

    //Save New Data
    $('#btnSave').click(function(e){
       save_payments();
    });

    // Calling Edit Modal Data
    $('#laravel_datatable').on('click','.btnEdit[data-edit]',function(e){
        e.preventDefault();
        var url = $(this).data('edit');
        edit_payments(url);
    });

    // Updating Data Payments
    $('#btnUpdate').on('click',function(e){
        e.preventDefault();
        var url = "/payments/"+$('#edit_ID').val();
        var frm = $('#frmDataEdit');
        update_payments(url,frm);
    });

    //deleting data
    $('#laravel_datatable').on('click','.btnDelete[data-remove]',function(e){
        e.preventDefault();
        var url = $(this).data('remove');
        delete_payments(url);
    });
});
</script>
@stop
