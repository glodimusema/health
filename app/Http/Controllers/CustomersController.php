<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customers;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return 'hello';
    }

    public function all()
    {
        return Customers::all();
    }
 
    public function getById($id)
    {
        return Customers::findOrFail($id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createCustomer(Request $request)
    {
        $response= array();
        $parameters = $request->all();

        $rules = array(
            'name' => 'required'
        );

        $customer_name=$parameters['name'];

        $messages = array(
            'name.required' => 'name is required.'
        );
        $validator = \Validator::make(array('name'=> $customer_name), $rules, $messages);
        if(!$validator->fails()){
            $response = Customers::create($parameters);
            return response()->json($response,201);
        }else{
            $errors=$validator->errors();
            return response()->json(["error"=>'Validation error(s) occured',"message" =>$errors->all()], 400);
        }
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
   

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateCustomer(Request $request, $id)
    {
        $response= array();
        $parameters = $request->all();

        $rules = array(
            'name' => 'required'
        );

        $customer_name = $parameters['name'];

        $messages = array(
            'name.required' => 'name is required.'
        );
        $cust = Customers::findOrFail($id);
        if(empty($cust)){
            return response()->json(["error" => 'Record not found!'], 400);
        }


        $validator = \Validator::make(array('name'=> $customer_name), $rules, $messages);
        if(!$validator->fails()){
            $response = $cust->update($parameters);
            return response()->json($response,201);
            // return response()->json(['status' => 'Validation error(s) occured',"message" =>$errors->all()], 400);
        }else{
            $errors=$validator->errors();
            return response()->json(["error"=>$response,"message" =>"Error"], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomer($id)
    {
        try{
            $resp=Customers::findOrFail($id)->delete();
            return response()->json($resp,201);
            // return response(['status' => $resp, "message" => 'Record has been deleted Successfully'],200);
        }catch(ModelNotFoundException $e){
            return response()->json(["error"=>$response,"message" =>"Error"], 400);
        }
    }
}
