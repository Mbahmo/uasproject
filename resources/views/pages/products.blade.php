@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content')
<div class="container">
    <h2>Products</h2>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" id="btnAdd">Add New</button>
        <a type="button" class="btn btn-primary" href="{{route('products.print')}}" target="_blank">Print</a>
    </div>
    <table class="table table-bordered" id="laravel_datatable">
        @csrf
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Description</th>
                <th>Image</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@include('template/modal_products')
<script>
    $(document).ready(function(){
    table = $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('products.index')}}",
            columns: [
                {
                    data: 'ProductsName',
                    name: 'ProductsName'
                },
                {
                    render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp' ),
                    data: 'ProductsPrice',
                    name: 'ProductsPrice'
                },
                {
                    data: 'ProductsDescription',
                    name: 'ProductsDescription'
                },
                {
                    data: 'ProductsImage',
                    name: 'ProductsImage',
                    render: function (data) {
                        return '<img src=' + data + ' width="200">';
                    }
                },
                {data: 'action' , name : 'action', orderable : false ,searchable: false},
            ]
    });

    //Calling Add Modal
    $('#btnAdd').click(function(e){
        add_modal();
    });

    //Save New Data
    $('#frmDataAdd').submit(function(e){
        e.preventDefault();
        save_products(this, table);
    });

    // Calling Edit Modal Data
    $('#laravel_datatable').on('click','.btnEdit[data-edit]',function(e){
        e.preventDefault();
        var url = $(this).data('edit');
        edit_products(url);
    });

    // Updating Data
    $('#frmDataEdit').submit(function(e){
        e.preventDefault();
        var id = +$('#edit_ID').val();
        var url = '{{ route("products.update", ":id") }}';
        url = url.replace(':id', id);
        update_products(url, this, table);
    });

    //Deleting Data
    $('#laravel_datatable').on('click','.btnDelete[data-remove]',function(e){
        e.preventDefault();
        var url = $(this).data('remove');
        delete_products(url, table);
    });
});
</script>
@stop
