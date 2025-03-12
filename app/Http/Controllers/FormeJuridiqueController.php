<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{FormeJuridique};
use App\Traits\{GlobalMethod,Slug};
use DB;


class FormeJuridiqueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("forme_juridiques")
            ->select("forme_juridiques.id", "forme_juridiques.nomForme", "forme_juridiques.created_at")
            ->where('forme_juridiques.nomForme', 'like', '%'.$query.'%')
            ->orWhere('forme_juridiques.id', 'like', '%'.$query.'%')
            ->orderBy("forme_juridiques.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("forme_juridiques")
            ->select("forme_juridiques.id", "forme_juridiques.nomForme", "forme_juridiques.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
        
    }


    function fetch_forme_juridiques_2()
    {
        $data = DB::table("forme_juridiques")
        ->select("forme_juridiques.id", "forme_juridiques.nomForme", "forme_juridiques.created_at")
        ->get();
        
        return response()->json(['data' => $data]);

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
            $data = FormeJuridique::where("id", $request->id)->update([
                'nomForme' =>  $request->nomForme
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = FormeJuridique::create([

                'nomForme' =>  $request->nomForme
            ]);

            return $this->msgJson('Insertion avec succès!!!');
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
        $data = FormeJuridique::where('id', $id)->get();
        return response()->json(['data' => $data]);
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
        $data = FormeJuridique::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }
}
