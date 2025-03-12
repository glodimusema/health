<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\{t_enfant_periode_c_p_s};
use App\Traits\{GlobalMethod,Slug};
use DB;


class t_enfant_periode_c_p_sController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("t_enfant_periode_c_p_s")
            ->select("t_enfant_periode_c_p_s.id", "t_enfant_periode_c_p_s.name_periode_cps","t_enfant_periode_c_p_s.created_at")
            ->where('name_periode', 'like', '%'.$query.'%')
            ->orderBy("t_enfant_periode_c_p_s.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data =DB::table("t_enfant_periode_c_p_s")
            ->select("t_enfant_periode_c_p_s.id", "t_enfant_periode_c_p_s.name_periode_cps","t_enfant_periode_c_p_s.created_at")
            ->orderBy("t_enfant_periode_c_p_s.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }

    function fetch_periode_cps2()
    {
        $data = DB::table("t_enfant_periode_c_p_s")
        ->select("t_enfant_periode_c_p_s.id", "t_enfant_periode_c_p_s.name_periode_cps","t_enfant_periode_c_p_s.created_at")
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
            $data = t_enfant_periode_c_p_s::where("id", $request->id)->update([
                'name_periode_cps' =>  $request->name_periode_cps
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);

        }
        else
        {
            // insertion 
            $data = t_enfant_periode_c_p_s::create([
                'name_periode_cps' =>  $request->name_periode_cps
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
        $data = t_enfant_periode_c_p_s::where('id', $id)->get();
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
        $data = t_enfant_periode_c_p_s::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
