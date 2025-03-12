<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_entete_sortie;
use DB;

class tentetesortieController extends Controller
{
    //vEnteteEntree
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
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tmed_entete_sortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_entete_sortie.id','nom_service','tmed_entete_sortie.dateSortie',
            'libelle','nom_agent','tmed_entete_sortie.author','tmed_entete_sortie.created_at')
            ->where('nom_agent', 'like', '%'.$query.'%')            
            ->orderBy("tmed_entete_sortie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_entete_sortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_entete_sortie.id','nom_service','dateSortie',
            'libelle','nom_agent','tmed_entete_sortie.author','tmed_entete_sortie.created_at')
            ->orderBy("tmed_entete_sortie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_entete_service(Request $request,$refService)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tmed_entete_sortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_entete_sortie.id','nom_service','dateSortie',
            'libelle','nom_agent','tmed_entete_sortie.author','tmed_entete_sortie.created_at')
            ->where([
                ['nom_agent', 'like', '%'.$query.'%'],          
                ['refService',$refService]
            ])             
            ->orderBy("tmed_entete_sortie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_entete_sortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_entete_sortie.id','nom_service','dateSortie',
            'libelle','nom_agent','tmed_entete_sortie.author','tmed_entete_sortie.created_at')
            ->Where('refService',$refService) 
            ->orderBy("tmed_entete_sortie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_service()
    {
        $data = DB::table('tservice_hopital')
        ->select("tservice_hopital.id","tservice_hopital.nom_service")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    function fetch_list_agent()
    {
        $data = DB::table('tmedecin')
        ->select("tmedecin.id","tmedecin.noms_medecin")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = DB::table('tmed_entete_sortie')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
        ->select('tmed_entete_sortie.id','nom_service','dateSortie',
        'libelle','nom_agent','tmed_entete_sortie.author','tmed_entete_sortie.created_at')
        ->where('tmed_entete_sortie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refService,nom_agent,dateSortie,libelle,author
    function insert_entete(Request $request)
    {
       
        $data = tmed_entete_sortie::create([
            'refService'       =>  $request->refService,
            'nom_agent'       =>  $request->nom_agent,
            'dateSortie'    =>  $request->dateSortie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_entete(Request $request, $id)
    {
        $data = tmed_entete_sortie::where('id', $id)->update([
            'refService'       =>  $request->refService,
            'nom_agent'       =>  $request->nom_agent,
            'dateSortie'    =>  $request->dateSortie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tmed_entete_sortie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
