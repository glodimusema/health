<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_departement};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdepartementfinController extends Controller
{

    // protected $fillable=['id','nom_departement','code_departement','author'];
    // protected $table = 'tfin_departement'; 
    
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_departement')
            ->select("tfin_departement.id","tfin_departement.nom_departement",
            "code_departement",'author',"tfin_departement.created_at")
            ->where('nom_departement', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_departement')
            ->select("tfin_departement.id","tfin_departement.nom_departement",
            "code_departement",'author',"tfin_departement.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tfin_departement_2()
    {
        $data = DB::table('tfin_departement')
        ->select("tfin_departement.id","tfin_departement.nom_departement",
        "code_departement",'author', "tfin_departement.created_at")
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
        //,'code_departement','author'
        if ($request->id !='') 
        {
            # code...author
            // update 
            $data = tfin_departement::where("id", $request->id)->update([
                'nom_departement' =>  $request->nom_departement,
                'code_departement' =>  $request->code_departement,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tfin_departement::create([
                'nom_departement' =>  $request->nom_departement,
                'code_departement' =>  $request->code_departement,
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
        $data = tfin_departement::where('id', $id)->get();
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
        $data = tfin_departement::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
