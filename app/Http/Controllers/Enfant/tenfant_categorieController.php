<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\{tenfant_categorie};
use App\Traits\{GlobalMethod,Slug};
use DB;


class tenfant_categorieController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {
        //
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tenfant_categorie")
            ->select("tenfant_categorie.id", "tenfant_categorie.name_categorie","tenfant_categorie.created_at")
            ->where('name_categorie', 'like', '%'.$query.'%')
            ->orderBy("tenfant_categorie.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data =DB::table("tenfant_categorie")
            ->select("tenfant_categorie.id", "tenfant_categorie.name_categorie","tenfant_categorie.created_at")
            ->orderBy("tenfant_categorie.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }

    function fetch_categorie_vac_enfant2()
    {
        $data = DB::table("tenfant_categorie")
        ->select("tenfant_categorie.id", "tenfant_categorie.name_categorie","tenfant_categorie.created_at")
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
            $data = tenfant_categorie::where("id", $request->id)->update([
                'name_categorie' =>  $request->name_categorie
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);
        }
        else
        {
            // insertion 
            $data = tenfant_categorie::create([
                'name_categorie' =>  $request->name_categorie
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
        $data = tenfant_categorie::where('id', $id)->get();
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
        $data = tenfant_categorie::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
