<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_categoriemaladie};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tcategoriemaladieController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tconf_categoriemaladie')->select("tconf_categoriemaladie.id","tconf_categoriemaladie.nom_categoriemaladie","tconf_categoriemaladie.created_at")->where('nom_categoriemaladie', 'like', '%'.$query.'%')
            ->orWhere('nom_categoriemaladie', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_categoriemaladie')->select("tconf_categoriemaladie.id","tconf_categoriemaladie.nom_categoriemaladie","tconf_categoriemaladie.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tconf_categoriemaladie_2()
    {
        $data = DB::table('tconf_categoriemaladie')->select("tconf_categoriemaladie.id","tconf_categoriemaladie.nom_categoriemaladie","tconf_categoriemaladie.created_at")->orderBy("id", "desc")->paginate(10);
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
            $data = tconf_categoriemaladie::where("id", $request->id)->update([
                'nom_categoriemaladie' =>  $request->nom_categoriemaladie
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_categoriemaladie::create([

                'nom_categoriemaladie' =>  $request->nom_categoriemaladie
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
        $data = tconf_categoriemaladie::where('id', $id)->get();
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
        $data = tconf_categoriemaladie::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
