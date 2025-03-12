<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_detailmedicament};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdetailmedicamentController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_detailmedicament')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree"
            ,"tconf_detailmedicament.author","tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
            "pu_medicament","forme","nom_categoriemedicament")
            ->where('tconf_medicament.nom_medicament', 'like', '%'.$query.'%')
            ->orWhere('nom_categoriemedicament', 'like', '%'.$query.'%')
            ->orderBy("dateexpiration", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_detailmedicament')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree","tconf_detailmedicament.author",
            "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
            "pu_medicament","forme","nom_categoriemedicament")
            ->orderBy("dateexpiration", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_medicament(Request $request,$refmedicament)
    {     
      
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_detailmedicament')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree","tconf_detailmedicament.author",
            "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
            "pu_medicament","forme","nom_categoriemedicament")
            ->where([
                ['nom_medicament', 'like', '%'.$query.'%'],
                ['refmedicament', $refmedicament]
            ])
            ->orderBy("dateexpiration", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tconf_detailmedicament')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
            ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree","tconf_detailmedicament.author",
            "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
            "pu_medicament","forme","nom_categoriemedicament")
            ->Where('refmedicament',$refmedicament)
            ->orderBy("dateexpiration", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }



    //mes scripts
    function fetch_list_medicament()
    {

        $data = DB::table('tconf_medicament')->select("id","nom_medicament")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    function fetch_list_categoriemedicament()
    {

        $data = DB::table('tconf_categoriemedicament')->select("id","nom_categoriemedicament")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_detail($id)
    {

        $data = DB::table('tconf_detailmedicament')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree","tconf_detailmedicament.author",
        "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
        "pu_medicament","forme","nom_categoriemedicament")
        ->where('tconf_detailmedicament.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
//
    function fetch_medicament_filtre($refmedicament)
    {

        $data = DB::table('tconf_detailmedicament')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","dateEntree","tconf_detailmedicament.author",
        "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
        "pu_medicament","forme","nom_categoriemedicament")
        ->where('tconf_detailmedicament.refmedicament', $refmedicament)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //dateEntree
    function insert_detail(Request $request)
    {
        $data = tconf_detailmedicament::create([
            'refmedicament'       =>  $request->refmedicament,
            'quantite'    =>  $request->quantite,
            'dateexpiration'       =>  $request->dateexpiration,
            'dateEntree'       =>  $request->dateEntree,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tconf_detailmedicament::where('id', $id)->update([
            'refmedicament'       =>  $request->refmedicament,
            'quantite'    =>  $request->quantite,
            'dateexpiration'       =>  $request->dateexpiration,
            'dateEntree'       =>  $request->dateEntree,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tconf_detailmedicament::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

}
