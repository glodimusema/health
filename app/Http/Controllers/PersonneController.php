<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Personne;

class PersonneController extends Controller
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
        return Personne::all();
    }
 
    public function getById($id)
    {
        return Personne::findOrFail($id);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPersonne(Request $request)
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
            $response = Personne::create($parameters);
            return response()->json($response,201);
        }else{
            $errors=$validator->errors();
            return response()->json(["error"=>'Validation error(s) occured',"message" =>$errors->all()], 400);
        }
    }
 

   
    public function updatePersonne(Request $request, $id)
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
        $cust = Personne::findOrFail($id);
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

    public function deletePersonne($id)
    {
        try{
            $resp=Personne::findOrFail($id)->delete();
            return response()->json($resp,201);
            // return response(['status' => $resp, "message" => 'Record has been deleted Successfully'],200);
        }catch(ModelNotFoundException $e){
            return response()->json(["error"=>$response,"message" =>"Error"], 400);
        }
    }
}
