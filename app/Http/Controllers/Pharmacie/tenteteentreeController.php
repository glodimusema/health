<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_entete_entree;
use DB;

class tenteteentreeController extends Controller
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

            $data = DB::table('tmed_entete_entree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_entete_entree.id','noms','contact','mail','adresse','dateEntree',
            'libelle','tmed_entete_entree.author','tmed_entete_entree.created_at')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_entete_entree.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_entete_entree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_entete_entree.id','noms','contact','mail','adresse','dateEntree',
            'libelle','tmed_entete_entree.author','tmed_entete_entree.created_at')
            ->orderBy("tmed_entete_entree.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_entete_fournisseur(Request $request,$refFournisseur)
    { 
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tmed_entete_entree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_entete_entree.id','noms','contact','mail','adresse','dateEntree',
            'libelle','tmed_entete_entree.author','tmed_entete_entree.created_at')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refFournisseur',$refFournisseur]
            ])             
            ->orderBy("tmed_entete_entree.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_entete_entree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_entete_entree.id','noms','contact','mail','adresse','dateEntree',
            'libelle','tmed_entete_entree.author','tmed_entete_entree.created_at')
            ->Where('refFournisseur',$refFournisseur) 
            ->orderBy("tmed_entete_entree.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_fournisseur()
    {

        $data = DB::table('tfournisseur')->select("tfournisseur.id","tfournisseur.noms")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = DB::table('tmed_entete_entree')
        ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
        ->select('tmed_entete_entree.id','noms','contact','mail','adresse','dateEntree',
        'libelle','tmed_entete_entree.author','tmed_entete_entree.created_at')
        ->where('tmed_entete_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refFournisseur,dateEntree,libelle,author
    function insert_entete(Request $request)
    {
       
        $data = tmed_entete_entree::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_entete(Request $request, $id)
    {
        $data = tmed_entete_entree::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateEntree'    =>  $request->dateEntree,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tmed_entete_entree::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
