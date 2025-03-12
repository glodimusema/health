<?php

namespace App\Http\Controllers;
use App\Models\Client;

use Illuminate\Http\Request;
use DB;
use App\Http\Requests\ClientRequest;

class ClientController extends BaseController
{
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

   


    public function all(Request $request)
    {

       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('client')->select("client.id","client.name","client.address","client.phone","client.created_at")->where('name', 'like', '%'.$query.'%')
            ->orWhere('address', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('client')->select("client.id","client.name","client.address","client.phone","client.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }



    }

    //mes scripts
    function fetch_list_client()
    {

        $data = DB::table('client')->select("client.id","client.name","client.address","client.phone","client.created_at")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    function fetch_single_client($id)
    {

        $data = DB::table('client')->select("client.id","client.name","client.address","client.phone","client.created_at")->where('client.id', $id)->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    // function insert_client(Request $request)
    // {
       
    //     $data = Client::create([
    //         'name'       =>  $request->name,
    //         'address'    =>  $request->address,
    //         'phone'       =>  $request->phone
    //     ]);
    //     return response()->json([
    //         'data'  =>  "Insertion avec succès!!!",
    //     ]);
    // }

    public function insert_client(ClientRequest $request)
    {
        $result = $this->executeWithoutReturn('saveClient', [
            'code'       =>  -1,
            'name'       =>  $request->name,
            'address'    =>  $request->address,
            'phone'       =>  $request->phone   
        ]);
        // dd($result);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_client(Request $request, $id)
    {
        $data = Client::where('id', $id)->update([
            'name'       =>  $request->name,
            'address'    =>  $request->address,
            'phone'       =>  $request->phone
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_client($id)
    {
        $data = $this->deleteAll('client','id',$id);
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    // fin mes scripts








 
    public function getById($id)
    {
        return Client::findOrFail($id);
    }

    public function createClient(Request $request)
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
            $response = Client::create($parameters);
            return response()->json($response,201);
        }else{
            $errors=$validator->errors();
            return response()->json(["error"=>'Validation error(s) occured',"message" =>$errors->all()], 400);
        }
    }

    public function updateClient(Request $request, $id)
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
        $cust = Client::findOrFail($id);
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

    public function deleteClient($id)
    {
        try{
            $resp=Client::findOrFail($id)->delete();
            return response()->json($resp,201);
            // return response(['status' => $resp, "message" => 'Record has been deleted Successfully'],200);
        }catch(ModelNotFoundException $e){
            return response()->json(["error"=>$resp,"message" =>"Error"], 400);
        }
    }
}
