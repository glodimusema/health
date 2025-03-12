<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_maladie};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tmaladieController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function all(Request $request)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_maladie')           
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
            ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
            "tconf_maladie.created_at","tconf_maladie.author")
            ->where('nom_maladie', 'like', '%'.$query.'%')
            ->orWhere('nom_categoriemaladie', 'like', '%'.$query.'%')
            ->orderBy("nom_maladie", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_maladie')           
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
            ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
            "tconf_maladie.created_at","tconf_maladie.author")
            ->orderBy("nom_maladie", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_maladie_categorie(Request $request,$refcategoriemaladie)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_maladie')           
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
            ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
            "tconf_maladie.created_at","tconf_maladie.author")
            ->where([
                ['nom_maladie', 'like', '%'.$query.'%'],
                ['refcategoriemaladie', $refcategoriemaladie]
            ])
            ->orderBy("nom_maladie", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tconf_maladie')           
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
            ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
            "tconf_maladie.created_at","tconf_maladie.author")
            ->Where('refcategoriemaladie',$refcategoriemaladie)
            ->orderBy("nom_maladie", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }



    //mes scripts
    function fetch_list_categoriemaladie()
    {

        $data = DB::table('tconf_categoriemaladie')
        ->select("id","nom_categoriemaladie")
        ->orderBy("nom_categoriemaladie", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    
    function fetch_single_maladie($id)
    {
        $data = DB::table('tconf_maladie')           
        ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
        ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
        "tconf_maladie.created_at","tconf_maladie.author")
        ->where('tconf_maladie.id', $id)
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    //id,nom_maladie,refcategoriemaladie,author
   
    function insert_maladie(Request $request)
    {
        $data = tconf_maladie::create([
            'nom_maladie'       =>  $request->nom_maladie,
            'refcategoriemaladie'    =>  $request->refcategoriemaladie,          
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_maladie(Request $request, $id)
    {
        $data = tconf_maladie::where('id', $id)->update([
            'nom_maladie'       =>  $request->nom_maladie,
            'refcategoriemaladie'    =>  $request->refcategoriemaladie,          
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_maladie($id)
    {
        $data = tconf_maladie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
