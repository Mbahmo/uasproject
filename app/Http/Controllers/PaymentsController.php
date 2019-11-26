<?php

namespace App\Http\Controllers;

use App\Payments;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Validator;
class PaymentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(){

        $payments = Payments::all();
        // dd($payments);
        if (request()->ajax()) {
            return Datatables::of($payments)
                ->editColumn('created_at', function ($data) {
                    return $data->created_at->toDayDateTimeString();
                })
                ->editColumn('updated_at', function ($data) {
                    return $data->updated_at->toDayDateTimeString();
                })
                ->addColumn('action',function($payments){
                    return
                    '
                    <button type="button" class="btn btn-info btn-sm btnEdit" data-edit="/payments/'.$payments->id.'/edit">Edit</button>
                    <button type="submit" class="btn btn-warning btn-sm btnDelete" data-remove="/payments/'.$payments->id.'">Delete</button>
                    ';
                })
                ->make(true);
        }
        return view('payments/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|min:2|max:32',
            'contact' => 'required|digits_between:1,12|numeric',
            'address' => 'required|min:5|max:100'
        ];
        $validator = Validator::make(Input::all(),$rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        }else{
            $crud = new Crud();
            $crud->name = $request->name;
            $crud->contact = $request->contact;
            $crud->address = $request->address;
            $crud->save();
            return response()->json(array("success"=>true));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Crud::find($id);
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
            'edit_name'    => 'required|min:2|max:32',
            'edit_contact' => 'required|numeric|digits_between:1,12',
            'edit_address' => 'required|min:5|max:100'
        ];
        $message = [
            'edit_name.required'          => 'The Name field is required.',
            'edit_name.min'               => 'The Name must be at least 2 characters.',
            'edit_name.max'               => 'The Name may not be greater than 32 characters.',
            'edit_contact.required'       => 'The contact field is required.',
            'edit_contact.digits_between' => 'The contact must be between 1 and 12 digits.',
            'edit_contact.numeric'        => 'The contact must be number.',
            'edit_address.required'       => 'The Brand Name field is required.',
            'edit_address.min'            => 'The Brand Name must be at least 5 characters.',
            'edit_address.max'            => 'The Brand Name may not be greater than 100 characters.',
        ];
        $Validator = Validator::make(Input::all(),$rules,$message);
        if($Validator->fails()) {
            return response()->json(array('errors' => $Validator->getMessageBag()->toArray()));
        } else {
            $crud = Crud::find($id);
            $crud->name = $request->edit_name;
            $crud->contact = $request->edit_contact;
            $crud->address = $request->edit_address;
            $crud->save();
            return response()->json(array("success"=>true));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Crud::destroy($id)) {
            $data = 'Success';
         }else{
             $data = 'Failed';
         }
         return response()->json($data);
    }
}
