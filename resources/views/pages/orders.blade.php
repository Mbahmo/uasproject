@extends('adminlte::page')
@section('title', 'AdminLTE')
@section('content')
<div class="container">
    <h2>Products</h2>
    <div class="btn-group">
        <button type="button" class="btn btn-primary" id="btnAdd">Add New</button>
        <a type="button" class="btn btn-primary" href="{{route('orders.print')}}" target="_blank">Print</a>
    </div>
    <table class="table table-bordered" id="laravel_datatable">
        @csrf
        <thead>
            <tr>
                <th>Name</th>
                <th>Tipe Pembayaran</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
    </table>
</div>
{{-- @include('template/modal_products') --}}
<script>
    $(document).ready(function(){
    table = $('#laravel_datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{route('orders.index')}}",
            columns: [
                {
                    data: 'PaymentsId',
                    name: 'PaymentsId'
                }
                // {
                //     data: 'ProductsPrice',
                //     name: 'ProductsPrice'
                // },
                // {
                //     data: 'ProductsDescription',
                //     name: 'ProductsDescription'
                // },
                // {
                //     data: 'ProductsImage',
                //     name: 'ProductsImage',
                //     render: $.fn.dataTable.render.number( '.', '.', 0, 'Rp' )
                // }
            ]
    });

    //Calling Add Modal
    $('#btnAdd').click(function(e){
        add_modal();
    });

    //Save New Data
    $('#btnSave').click(function(e){
       save_products(table);
    });
});
</script>
@stop
