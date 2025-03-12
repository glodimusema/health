<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\{tenfant_periode_vac_enfant};
use App\Traits\{GlobalMethod,Slug};
use DB;


class tenfant_periode_vac_enfantController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tenfant_periode_vac_enfant")
            ->select("tenfant_periode_vac_enfant.id", "tenfant_periode_vac_enfant.name_periode",
            "duree_periode","tenfant_periode_vac_enfant.created_at")
            ->where('name_periode', 'like', '%'.$query.'%')
            ->orderBy("tenfant_periode_vac_enfant.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data =DB::table("tenfant_periode_vac_enfant")
            ->select("tenfant_periode_vac_enfant.id", "tenfant_periode_vac_enfant.name_periode",
            "duree_periode","tenfant_periode_vac_enfant.created_at")
            ->orderBy("tenfant_periode_vac_enfant.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }


    function fetch_periode_vac_enfant2()
    {
        $data =DB::table("tenfant_periode_vac_enfant")
        ->select("tenfant_periode_vac_enfant.id", "tenfant_periode_vac_enfant.name_periode",
        "duree_periode","tenfant_periode_vac_enfant.created_at")
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
            # code...
            // update 
            $data = tenfant_periode_vac_enfant::where("id", $request->id)->update([
                'name_periode' =>  $request->name_periode,
                'duree_periode'=>$request->duree_periode
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);

        }
        else
        {
            // insertion 
            $data = tenfant_periode_vac_enfant::create([
                'name_periode' =>  $request->name_periode,
                 'duree_periode'=>$request->duree_periode
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
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
        $data = tenfant_periode_vac_enfant::where('id', $id)->get();
        return response()->json($data);
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
        $data = tenfant_periode_vac_enfant::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
