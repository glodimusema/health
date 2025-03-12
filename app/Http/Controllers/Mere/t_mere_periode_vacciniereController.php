<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\{t_mere_periode_vacciniere};
use App\Traits\{GlobalMethod,Slug};
use DB;



class t_mere_periode_vacciniereController extends Controller
{

    use GlobalMethod;

    public function index(Request $request)
    {

        $data = DB::table("t_mere_periode_vacciniere")
        ->select("t_mere_periode_vacciniere.id", "t_mere_periode_vacciniere.nom_periode","dure_semsuie" ,"t_mere_periode_vacciniere.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('t_mere_periode_vacciniere.nom_periode', 'like', '%'.$query.'%')
            ->orWhere('t_mere_periode_vacciniere.id', 'like', '%'.$query.'%')
            ->orderBy("t_mere_periode_vacciniere.id", "asc")
            ->paginate(10);;

            return response()->json([
                'data'=>$data
        ]);           

        }
        $data = DB::table('t_mere_periode_vacciniere')
        ->select("t_mere_periode_vacciniere.id","t_mere_periode_vacciniere.nom_periode","dure_semsuie","t_mere_periode_vacciniere.created_at")
        ->orderBy("id", "asc")->paginate(10);
        return response()->json(
            ['data'=>$data ]);   

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
        if ($request->id !='') 
        {
            //id,nom_periode,dure_semsuie,author
            $data = t_mere_periode_vacciniere::where("id", $request->id)->update([
                'nom_periode' =>  $request->nom_periode,
                'dure_semsuie' =>  $request->dure_semsuie,
                'author' =>  $request->author,
            ]);

            return response()->json(['data'=>'modification avec succes!!']);

        }
        else
        {
            // insertion 
            $data = t_mere_periode_vacciniere::create([
                'nom_periode' =>  $request->nom_periode,
                'dure_semsuie' =>  $request->dure_semsuie,
                'author' =>  $request->author,
            ]);
            return response()->json(['data'=>'modification avec succes!!']);
        }
    }  
    
    function fetch_periode_vaccin_mere2()
    {
        $data = DB::table('t_mere_periode_vacciniere')
        ->select("t_mere_periode_vacciniere.id","t_mere_periode_vacciniere.nom_periode",
        "t_mere_periode_vacciniere.created_at")
        ->orderBy("id", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

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
        $data = t_mere_periode_vacciniere::where('id', $id)->get();
        return response()->json([
            
            'data'=> $data]);
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
        $data = t_mere_periode_vacciniere::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
