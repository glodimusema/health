<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Chirurgie\{tope_acteoperatoire};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tacteoperatoireController extends Controller
{
    //tacteoperatoireController
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tope_acteoperatoire')
            ->select("tope_acteoperatoire.id","tope_acteoperatoire.nom_acteop","prix_acteop","tope_acteoperatoire.created_at")
            ->where('nom_acteop', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_acteoperatoire')
            ->select("tope_acteoperatoire.id","tope_acteoperatoire.nom_acteop","tope_acteoperatoire.created_at","prix_acteop")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tope_acteoperatoire_2()
    {
        $data = DB::table('tope_acteoperatoire')
        ->select("tope_acteoperatoire.id","tope_acteoperatoire.nom_acteop","tope_acteoperatoire.created_at","prix_acteop")
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
            # prix_acteop...
            // update 
            $data = tope_acteoperatoire::where("id", $request->id)->update([
                'nom_acteop' =>  $request->nom_acteop,
                'prix_acteop' =>  $request->prix_acteop
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tope_acteoperatoire::create([

                'nom_acteop' =>  $request->nom_acteop,
                'prix_acteop' =>  $request->prix_acteop
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
        $data = tope_acteoperatoire::where('id', $id)->get();
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
        $data = tope_acteoperatoire::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
