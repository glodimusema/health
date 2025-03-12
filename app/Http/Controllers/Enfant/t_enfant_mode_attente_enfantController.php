<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\{t_enfant_mode_attente_enfant};
use App\Traits\{GlobalMethod,Slug};
use DB;


class t_enfant_mode_attente_enfantController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("t_enfant_mode_attente_enfant")
            ->select("t_enfant_mode_attente_enfant.id", "t_enfant_mode_attente_enfant.name_mode",
            "t_enfant_mode_attente_enfant.created_at")
            ->where('name_strategie', 'like', '%'.$query.'%')
            ->orderBy("t_enfant_mode_attente_enfant.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data =DB::table("t_enfant_mode_attente_enfant")
            ->select("t_enfant_mode_attente_enfant.id", "t_enfant_mode_attente_enfant.name_mode",
            "t_enfant_mode_attente_enfant.created_at")
            ->orderBy("t_enfant_mode_attente_enfant.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }


    function fetch_mode_vac_enfant2()
    {
        $data =DB::table("t_enfant_mode_attente_enfant")
        ->select("t_enfant_mode_attente_enfant.id", "t_enfant_mode_attente_enfant.name_mode",
        "t_enfant_mode_attente_enfant.created_at")
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
            $data = t_enfant_mode_attente_enfant::where("id", $request->id)->update([
                'name_mode' =>  $request->name_mode
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);

        }
        else
        {
            // insertion 
            $data = t_enfant_mode_attente_enfant::create([
                'name_mode' =>  $request->name_mode
            ]);
            return response()->json([
                'data'  =>  "Insertion  avec succès!!!",
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
        $data = t_enfant_mode_attente_enfant::where('id', $id)->get();
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
        $data = t_enfant_mode_attente_enfant::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
