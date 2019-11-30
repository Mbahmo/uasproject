<?php

namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Products;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        if (request()->ajax()) {
        // dd($payments);
            $i = 0;
            $products = Products::all();
            return Datatables::of($products)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->toDayDateTimeString();
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->toDayDateTimeString();
                })
                ->addColumn('action',function($products){
                    return
                    '
                    <button type="button" class="btn btn-info btn-sm btnEdit" data-edit="/products/'.$products->ProductsId.'/edit">Edit</button>
                    <button type="submit" class="btn btn-warning btn-sm btnDelete" data-remove="/products/'.$products->ProductsId.'">Delete</button>
                    ';
                })->make(true);
        }
        return view('pages/products');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if (Products::destroy($id)) {
            $data = 'Success';
        } else {
            $data = 'Failed';
        }
        return response()->json($data);
    }
    public function print(){
        return Excel::download(new ProductsExport, 'payments.xlsx');
    }
}
