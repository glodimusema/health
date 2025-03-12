<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\{t_periode_peni_mere};
use App\Traits\{GlobalMethod,Slug};
use DB;



class t_periode_peni_mereController extends Controller
{

    use GlobalMethod;

    public function index(Request $request)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("t_periode_peni_mere")
            ->select("t_periode_peni_mere.id", "t_periode_peni_mere.name_periode","t_periode_peni_mere.created_at")
            ->where('name_periode', 'like', '%'.$query.'%')
            ->orderBy("t_periode_peni_mere.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);           

        }
        else{
            $data =DB::table("t_periode_peni_mere")
            ->select("t_periode_peni_mere.id", "t_periode_peni_mere.name_periode","t_periode_peni_mere.created_at")
            ->orderBy("t_periode_peni_mere.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }


         

    }


    function fetch_periode_peni_mere2()
    {
        $data =DB::table('t_periode_peni_mere')
        ->select("t_periode_peni_mere.id","t_periode_peni_mere.name_periode","t_periode_peni_mere.created_at")
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

            $data = t_periode_peni_mere::where("id", $request->id)->update([
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
            $data = t_periode_peni_mere::create([
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
        $data = t_periode_peni_mere::where('id', $id)->get();
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
        $data = t_periode_peni_mere::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
