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
        // dd(Products::all());
        if (request()->ajax()) {
            $products = Products::all();
            return Datatables::of($products)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->toDayDateTimeString();
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->toDayDateTimeString();
                })
                ->editColumn('ProductsImage', function ($data) {
                    return asset("images/$data->ProductsImage");
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $rules = [
            'name'        => 'required|min:2|max:32',
            'description' => 'required|min:5|max:100',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $validator = Validator::make(Input::all(), $rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $products = new Products();
            $image = $request->file('image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);
            $products->ProductsName        = $request->name;
            $products->ProductsPrice       = $request->price;
            $products->ProductsImage       = $new_name;
            $products->ProductsDescription = $request->description;
            $products->save();
            return response()->json(array("success"=>true));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        $data = Products::find($id);
        return response()->json($data);
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
        $rules= [
            'edit_name'        => 'required|min:2|max:32',
            'edit_price'       => 'required|^-?\\d*(\\.\\d+)?$',
            'edit_description' => 'required|min:5|max:100',
            'edit_image'       => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ];
        $message = [
            'edit_name.required'              => 'The Name field is required.',
            'edit_name.min'                   => 'The Name must be at least 2 characters.',
            'edit_name.max'                   => 'The Name may not be greater than 32 characters.',
            'edit_description.required'       => 'The Description field is required.',
            'edit_description.min'            => 'The Description must be at least 5 characters.',
            'edit_description.max'            => 'The Description may not be greater than 100 characters.',
        ];
        $Validator = Validator::make(Input::all(),$rules,$message);
        if($Validator->fails()) {
            return response()->json(array('errors' => $Validator->getMessageBag()->toArray()));
        } else {
            $products = Products::find($id);

            $imagelama = (public_path('images').'/'.$products->ProductsImage);
            unlink($imagelama);
            $image = $request->file('edit_image');
            $new_name = rand() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $new_name);

            $products->ProductsName        = $request->edit_name;
            $products->ProductsPrice       = $request->edit_price;
            $products->ProductsImage       = $new_name;
            $products->ProductsDescription = $request->edit_description;
            $products->save();
            return response()->json(array("success"=>true));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if ($products = Products::find($id)) {
            $imagelama = (public_path('images').'/'.$products->ProductsImage);
            unlink($imagelama);
            Products::destroy($id);
            $data = "Success";
        } else {
            $data = 'Failed';
        }
        return response()->json($data);
    }
    public function print(){
        return Excel::download(new ProductsExport, 'products.xlsx');
    }
}
