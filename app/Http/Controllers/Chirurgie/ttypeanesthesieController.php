<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Chirurgie\{tope_typeanesthesie};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttypeanesthesieController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tope_typeanesthesie')
            ->select("tope_typeanesthesie.id","tope_typeanesthesie.nom_tyepeanesthesie","prix_typeanesthesie","tope_typeanesthesie.created_at")
            ->where('nom_tyepeanesthesie', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_typeanesthesie')
            ->select("tope_typeanesthesie.id","tope_typeanesthesie.nom_tyepeanesthesie","tope_typeanesthesie.created_at","prix_typeanesthesie")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tope_typeanesthesie_2()
    {
        $data = DB::table('tope_typeanesthesie')
        ->select("tope_typeanesthesie.id","tope_typeanesthesie.nom_tyepeanesthesie","tope_typeanesthesie.created_at","prix_typeanesthesie")
        ->orderBy("id", "desc")
        ->paginate(10);
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
            # prix_typeanesthesie...
            // update 
            $data = tope_typeanesthesie::where("id", $request->id)->update([
                'nom_tyepeanesthesie' =>  $request->nom_tyepeanesthesie,
                'prix_typeanesthesie' =>  $request->prix_typeanesthesie
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tope_typeanesthesie::create([

                'nom_tyepeanesthesie' =>  $request->nom_tyepeanesthesie,
                'prix_typeanesthesie' =>  $request->prix_typeanesthesie
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
        $data = tope_typeanesthesie::where('id', $id)->get();
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
        $data = tope_typeanesthesie::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
