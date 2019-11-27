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

        // dd($payments);
        if (request()->ajax()) {
            $payments = Payments::all();
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
                    <button type="button" class="btn btn-info btn-sm btnEdit" data-edit="/payments/'.$payments->PaymentsId.'/edit">Edit</button>
                    <button type="submit" class="btn btn-warning btn-sm btnDelete" data-remove="/payments/'.$payments->PaymentsId.'">Delete</button>
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
            'description' => 'required|min:5|max:100'
        ];
        $validator = Validator::make(Input::all(),$rules);
        if ($validator->fails()) {
            return response()->json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $payments = new Payments();
            $payments->PaymentsName = $request->name;
            $payments->PaymentsDescription = $request->description;
            $payments->save();
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

        // dd(Payments::find($id)->toSql());
        $data = Payments::find($id);
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
            'edit_description' => 'required|min:5|max:100'
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
            $payments = Payments::find($id);
            $payments->PaymentsName        = $request->edit_name;
            $payments->PaymentsDescription = $request->edit_description;
            $payments->save();
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
        // dd(Payments::destroy($id)->toSql());
        if (Payments::destroy($id)) {
            $data = 'Success';
        } else {
            $data = 'Failed';
        }
         return response()->json($data);
    }
}
