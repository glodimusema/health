<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_medicament};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tmedicamentController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function all(Request $request)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_medicament')           
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
            "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
            ->where('nom_medicament', 'like', '%'.$query.'%')
            ->orWhere('nom_categoriemedicament', 'like', '%'.$query.'%')
            ->orderBy("nom_medicament", "asc")
            ->paginate(20);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_medicament')           
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
            "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
            ->orderBy("nom_medicament", "asc")
            ->paginate(20);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_medicament_categorie(Request $request,$refcategoriemedicament)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_medicament')           
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
            "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
            ->where([
                ['nom_medicament', 'like', '%'.$query.'%'],
                ['refcategoriemedicament', $refcategoriemedicament]
            ])
            ->orderBy("nom_medicament", "asc")
            ->paginate(20);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tconf_medicament')           
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
            "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
            ->Where('refcategoriemedicament',$refcategoriemedicament)
            ->orderBy("nom_medicament", "asc")
            ->paginate(20);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }



    //mes scripts
    function fetch_list_categoriemedicament()
    {

        $data = DB::table('tconf_categoriemedicament')
        ->select("id","nom_categoriemedicament")
        ->orderBy("nom_categoriemedicament", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_medicament()
    {

        $data = DB::table('tconf_medicament')           
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
        "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
        ->orderBy("nom_medicament", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    
    function fetch_single_medicament($id)
    {
        $data = DB::table('tconf_medicament')           
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
        "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
        ->where('tconf_medicament.id', $id)
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    //id,nom_medicament,refcategoriemedicament,pu_medicament,forme,author
   
    function insert_medicament(Request $request)
    {
        $data = tconf_medicament::create([
            'nom_medicament'       =>  $request->nom_medicament,
            'refcategoriemedicament'    =>  $request->refcategoriemedicament,
            'pu_medicament'    =>  0,
            'forme'    =>  $request->forme,             
            'qtetot'    =>  0,   
            'stock_alerte'    =>  $request->stock_alerte,       
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }
    //stock_alerte

    function update_medicament(Request $request, $id)
    {
        $data = tconf_medicament::where('id', $id)->update([
            'nom_medicament'       =>  $request->nom_medicament,
            'refcategoriemedicament'    =>  $request->refcategoriemedicament,
            'pu_medicament'    =>  0,
            'forme'    =>  $request->forme,        
            'qtetot'    =>  $request->qtetot, 
            'stock_alerte'    =>  $request->stock_alerte,        
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_medicament($id)
    {
        $data = tconf_medicament::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
