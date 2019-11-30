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
                    <label for="price" class="control-label">
                    Price<span class="required">*</span>
                    </label>
                    <input type="number" class="form-control" id="price" name="price">
                    <p class="errorPrice text-danger hidden"></p>
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
                    <label for="price" class="control-label">
                    Price<span class="required">*</span>
                    </label>
                    <input type="number" class="form-control" id="edit_price" name="edit_price">
                    <p class="errorPrice text-danger hidden"></p>
                </div>
                <div class="form-group">
                    <label for="edit_description" class="control-label">
                    Description<span class="required">*</span>
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
