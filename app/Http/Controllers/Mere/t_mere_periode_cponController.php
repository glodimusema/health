<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\{t_mere_periode_cpon};
use App\Traits\{GlobalMethod,Slug};
use DB;



class t_mere_periode_cponController extends Controller
{

    use GlobalMethod;

    public function index(Request $request)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("t_mere_periode_cpon")
            ->select("t_mere_periode_cpon.id", "t_mere_periode_cpon.name_periode","dure_periode","t_mere_periode_cpon.created_at")
            ->where('name_periode', 'like', '%'.$query.'%')
            ->orderBy("t_mere_periode_cpon.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data =DB::table("t_mere_periode_cpon")
            ->select("t_mere_periode_cpon.id", "t_mere_periode_cpon.name_periode","dure_periode","t_mere_periode_cpon.created_at")
            ->orderBy("t_mere_periode_cpon.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }      

    }


    function fetch_periode_cpon_mere2()
    {
        $data =DB::table('t_mere_periode_cpon')
        ->select("t_mere_periode_cpon.id","t_mere_periode_cpon.name_periode","dure_periode","t_mere_periode_cpon.created_at")
        ->orderBy("id", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

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
        if ($request->id !='') 
        {
            //id,name_periode,dure_periode

            $data = t_mere_periode_cpon::where("id", $request->id)->update([
                'name_periode' =>  $request->name_periode,
                'dure_periode' =>  0
            ]);

            
            return response()->json([
                'data'=> 'modification avec succes!!'
             ]);
          

        }
        else
        {
            // insertion 
            $data = t_mere_periode_cpon::create([
                'name_periode' =>  $request->name_periode,
                'dure_periode' =>  0
            ]);

            return response()->json([
                'data'=> 'Insertion reussie avec succes!!'
             ]);

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
        //
        $data = t_mere_periode_cpon::where('id', $id)->get();
        return response()->json([
            'data'=>$data
           ]);           

    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = t_mere_periode_cpon::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
