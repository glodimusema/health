<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\{tim_libelle_score};
use App\Traits\{GlobalMethod,Slug};

use DB;


class tim_libelle_scoreController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tim_libelle_score")
            ->select("tim_libelle_score.id", "tim_libelle_score.desi_libelle", "tim_libelle_score.created_at")
            ->where('desi_libelle', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("tim_libelle_score")
            ->select("tim_libelle_score.id", "tim_libelle_score.desi_libelle", "tim_libelle_score.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }

    function fetch_libelleScore2()
    {
        $data = DB::table("tim_libelle_score")
        ->select("tim_libelle_score.id", "tim_libelle_score.desi_libelle", "tim_libelle_score.created_at")
        ->orderBy("id", "desc")
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
            $data = tim_libelle_score::where("id", $request->id)->update([
                'desi_libelle' =>  $request->desi_libelle
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!",
            ]);

        }
        else
        {
            // insertion 
            $data = tim_libelle_score::create([
                'desi_libelle' =>  $request->desi_libelle
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!",
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
        $data = tim_libelle_score::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
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
        $data = tim_libelle_score::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
