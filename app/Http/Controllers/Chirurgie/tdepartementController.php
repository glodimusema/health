<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Chirurgie\{tope_departement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdepartementController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tope_departement')
            ->select("tope_departement.id","tope_departement.nom_departement","tope_departement.created_at")
            ->where('nom_departement', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_departement')->select("tope_departement.id","tope_departement.nom_departement","tope_departement.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tope_departement_2()
    {
        $data = DB::table('tope_departement')->select("tope_departement.id","tope_departement.nom_departement","tope_departement.created_at")->orderBy("id", "desc")->paginate(10);
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
            $data = tope_departement::where("id", $request->id)->update([
                'nom_departement' =>  $request->nom_departement
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tope_departement::create([

                'nom_departement' =>  $request->nom_departement
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
        $data = tope_departement::where('id', $id)->get();
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
        $data = tope_departement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
