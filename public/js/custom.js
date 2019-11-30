// CALLING ADD MODAL JUGAAN SAMA SEMUA NYA
function add_modal(){
    $('#mdlAddData').modal();
}

// CRUD Payments
function save_payments(table){
    var frm = $('#frmDataAdd');
    $.ajax({
        url : '/products',
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
}
function edit_payments(url) {
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
}
function update_payments(url, frm, table){
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
    });
}
function delete_payments(url, table) {
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
                        swal.fire("Deleted!", "Payments has been deleted", "success");
                        table.ajax.reload(null,false);
                    }
                }
            });
        } else {
            swal.fire("Cancelled", "You Cancelled", "error");
        }
    });
}
// CRUD Payments ENDS HERE


// CRUD Products
function save_products(table){
    var frm = $('#frmDataAdd');
    $.ajax({
        url : '/products',
        type : 'POST',
        dataType: 'json',
        data : {
            'csrf-token': '{{csrf_token()}}',
             name : $('#name').val(),
             price : $('#price').val(),
             description : $('#description').val(),
        },
        success:function(data){
            $('.errorName').addClass('hidden');
            $('.errorPrice').addClass('hidden');
            $('.errorDescription').addClass('hidden');
            if (data.errors) {
                if (data.errors.name) {
                    $('.errorName').removeClass('hidden');
                    $('.errorName').text(data.errors.name);
                }
                if (data.errors.price) {
                    $('.errorPrice').removeClass('hidden');
                    $('.errorPrice').text(data.errors.description);
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
}
function edit_products(url) {
                $.ajax({
                    url : url,
                    type : 'GET',
                    datatype : 'json',
                    success:function(data){
                        $('#edit_ID').val(data.ProductsId);
                        $('#edit_price').val(data.ProductsPrice);
                        $('#edit_name').val(data.ProductsName);
                        $('#edit_description').val(data.ProductsDescription);
                        $('.edit_errorName').addClass('hidden');
                        $('.edit_errorPrice').addClass('hidden');
                        $('.edit_errorDescription').addClass('hidden');
                        $('#mdlEditData').modal('show');
                        console.log(data.ProductsId);
                    }
                });
}
function update_products(url, frm, table){
    // console.log(url);
    // console.log(frm.serialize());
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
                        if (data.errors.edit_price) {
                            $('.edit_errorDescription').removeClass('hidden');
                            $('.edit_errorDescription').text(data.errors.price);
                        }
                        if (data.errors.edit_description) {
                            $('.edit_errorDescription').removeClass('hidden');
                            $('.edit_errorDescription').text(data.errors.edit_description);
                        }
                    }
                    if (data.success == true) {
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
    });
}
// function delete_payments(url, table) {
//     Swal.fire({
//         title: 'Are you sure?',
//         text: "You won't be able to revert this!",
//         type: 'warning',
//         showCancelButton: true,
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Yes, delete it!'

//     }).then((result) => {
//         if (result.value) {
//                 $.ajax({
//                 url : url,
//                 type: 'DELETE',
//                 dataType : 'json',
//                 data : { method : '_DELETE' , submit : true},
//                 success:function(data){
//                     if (data == 'Success') {
//                         swal.fire("Deleted!", "Payments has been deleted", "success");
//                         table.ajax.reload(null,false);
//                     }
//                 }
//             });
//         } else {
//             swal.fire("Cancelled", "You Cancelled", "error");
//         }
    // });
// }
// CRUD Products Ends Here
