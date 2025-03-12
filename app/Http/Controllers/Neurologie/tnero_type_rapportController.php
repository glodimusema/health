<?php

namespace App\Http\Controllers\Neurologie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Neurologie\{tnero_type_rapport};
use App\Traits\{GlobalMethod,Slug};
use DB;


class tnero_type_rapportController extends Controller
{

    use GlobalMethod, Slug;

    public function all(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tnero_type_rapport")
            ->select("tnero_type_rapport.id", "tnero_type_rapport.name_typeRapport", "tnero_type_rapport.created_at")
            ->where('name_typeRapport', 'like', '%'.$query.'%')          
            ->orderBy("tnero_type_rapport.name_typeRapport", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("tnero_type_rapport")
            ->select("tnero_type_rapport.id", "tnero_type_rapport.name_typeRapport", "tnero_type_rapport.created_at")
            ->orderBy("tnero_type_rapport.name_typeRapport", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
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
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tnero_type_rapport::where("id", $request->id)->update([
                'name_typeRapport' =>  $request->name_typeRapport
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tnero_type_rapport::create([

                'name_typeRapport' =>$request->name_typeRapport
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    } 
    
    function fetch_typerapportneuro_2()
    {
        $data = DB::table('tnero_type_rapport')
        ->select("tnero_type_rapport.id","tnero_type_rapport.name_typeRapport","tnero_type_rapport.created_at")
        ->orderBy("id", "desc")
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
        $data = tnero_type_rapport::where('id', $id)->get();
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
        $data = tnero_type_rapport::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
