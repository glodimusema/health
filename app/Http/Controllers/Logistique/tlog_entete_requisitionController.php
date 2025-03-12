<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_entete_requisition;
use DB;

class tlog_entete_requisitionController extends Controller
{


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

            $data = DB::table('tlog_entete_requisition')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
            'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlog_entete_requisition.deleted','NON']
            ])            
            ->orderBy("tlog_entete_requisition.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlog_entete_requisition')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
            'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
            ->where([         
                ['tlog_entete_requisition.deleted','NON']
            ])
            ->orderBy("tlog_entete_requisition.id", "desc")
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

            $data = DB::table('tlog_entete_requisition')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
            'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refFournisseur',$refFournisseur],
                ['tlog_entete_requisition.deleted','NON']
            ])             
            ->orderBy("tlog_entete_requisition.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlog_entete_requisition')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
            'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
            ->where([          
                ['refFournisseur',$refFournisseur],
                ['tlog_entete_requisition.deleted','NON']
            ]) 
            ->orderBy("tlog_entete_requisition.id", "desc")
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

        $data = DB::table('tlog_entete_requisition')
        ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_entete_requisition.id','noms','contact','mail','adresse','dateCmd',
        'libelle','tlog_entete_requisition.author','tlog_entete_requisition.created_at')
        ->where('tlog_entete_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //id,refFournisseur,dateCmd,libelle,author
    function insert_entete(Request $request)
    {
       
        $data = tlog_entete_requisition::create([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_entete(Request $request, $id)
    {
        $data = tlog_entete_requisition::where('id', $id)->update([
            'refFournisseur'       =>  $request->refFournisseur,
            'dateCmd'    =>  $request->dateCmd,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tlog_entete_requisition::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
