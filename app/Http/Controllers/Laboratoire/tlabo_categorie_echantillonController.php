<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Laboratoire\{tlabo_categorie_echantillon};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tlabo_categorie_echantillonController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tlabo_categorie_echantillon')
            ->select("tlabo_categorie_echantillon.id","tlabo_categorie_echantillon.nom_categorieechantillon","author","tlabo_categorie_echantillon.created_at")
            ->where('nom_categorieechantillon', 'like', '%'.$query.'%')
            ->orderBy("id", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_categorie_echantillon')
            ->select("tlabo_categorie_echantillon.id","tlabo_categorie_echantillon.nom_categorieechantillon","author","tlabo_categorie_echantillon.created_at")
            ->orderBy("id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tlabo_categorie_echantillon_2()
    {
        $data = DB::table('tlabo_categorie_echantillon')
        ->select("tlabo_categorie_echantillon.id","tlabo_categorie_echantillon.nom_categorieechantillon",
        "author","tlabo_categorie_echantillon.created_at")
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
            $data = tlabo_categorie_echantillon::where("id", $request->id)->update([
                'nom_categorieechantillon' =>  $request->nom_categorieechantillon,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tlabo_categorie_echantillon::create([
                'nom_categorieechantillon' =>  $request->nom_categorieechantillon,
                'author' =>  $request->author
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
        $data = tlabo_categorie_echantillon::where('id', $id)->get();
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
        $data = tlabo_categorie_echantillon::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
