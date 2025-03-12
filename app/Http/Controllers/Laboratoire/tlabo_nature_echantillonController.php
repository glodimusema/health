<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{tlabo_nature_echantillon};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tlabo_nature_echantillonController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_nature_echantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->select("tlabo_nature_echantillon.id","refCategorieEchantillon","designation_nature","designation_valeur",
            "tlabo_categorie_echantillon.nom_categorieechantillon")
            ->where('tlabo_nature_echantillon.designation', 'like', '%'.$query.'%')            
            ->orderBy("tlabo_nature_echantillon.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_nature_echantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->select("tlabo_nature_echantillon.id","tlabo_nature_echantillon.refCategorieEchantillon",
            "tlabo_nature_echantillon.designation_nature","designation_valeur",
            "tlabo_categorie_echantillon.nom_categorieechantillon")
            ->orderBy("tlabo_nature_echantillon.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tlabo_nature_echantillon_2()
    {
        $data = DB::table('tlabo_nature_echantillon')
        ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
        ->select("tlabo_nature_echantillon.id","tlabo_nature_echantillon.refCategorieEchantillon",
        "tlabo_nature_echantillon.designation_nature","designation_valeur",
        "tlabo_categorie_echantillon.nom_categorieechantillon")
        ->orderBy("tlabo_nature_echantillon.id", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }


    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tlabo_nature_echantillon::where("id", $request->id)->update([
                'designation_nature' =>  $request->designation_nature,
                'designation_valeur' =>  $request->designation_valeur,
                'refCategorieEchantillon' =>  $request->refCategorieEchantillon,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tlabo_nature_echantillon::create([
                'designation_nature' =>  $request->designation_nature,
                'designation_valeur' =>  $request->designation_valeur,
                'refCategorieEchantillon' =>  $request->refCategorieEchantillon,
                'author' =>  $request->author
            ]);

            return $this->msgJson('Insertion avec succès!!!');
        }
    }

    //'id','designation_nature','designation_valeur','refCategorieEchantillon','author'
   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tlabo_nature_echantillon::where('id', $id)->get();
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
        $data = tlabo_nature_echantillon::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
