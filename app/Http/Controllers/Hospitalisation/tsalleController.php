<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Hospitalisation\{tsalle};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tsalleController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
               
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tsalle')->select("tsalle.id","tsalle.nom_salle",
            "tsalle.PrixSalle","tsalle.created_at")
            ->where('nom_salle', 'like', '%'.$query.'%')           
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tsalle')->select("tsalle.id","tsalle.nom_salle",
            "tsalle.PrixSalle","tsalle.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_salle_2()
    {
        $data = DB::table('tsalle')->select("tsalle.id","tsalle.nom_salle",
        "tsalle.PrixSalle","tsalle.created_at")
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
        ////'id','nom_salle','PrixSalle'
        if ($request->id !='') 
        {
            // update 
            $data = tsalle::where("id", $request->id)->update([
                'nom_salle' =>  $request->nom_salle,
                'PrixSalle' =>  $request->PrixSalle
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tsalle::create([
                'nom_salle' =>  $request->nom_salle,
                'PrixSalle' =>  $request->PrixSalle
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
        $data = tsalle::where('id', $id)->get();
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
        $data = tsalle::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
