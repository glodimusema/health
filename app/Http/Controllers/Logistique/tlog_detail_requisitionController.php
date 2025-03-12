<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_detail_requisition;
use DB;
class tlog_detail_requisitionController extends Controller
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

            $data = DB::table('tlog_detail_requisition')
            ->join('tproduit','tproduit.id','=','tlog_detail_requisition.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
            'qteCmd','noms','contact','mail','adresse','dateCmd',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
            ->selectRaw('(qteCmd*puCmd) as PTEntree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlog_detail_requisition.deleted','NON']
            ])            
            ->orderBy("tlog_detail_requisition.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlog_detail_requisition')
            ->join('tproduit','tproduit.id','=','tlog_detail_requisition.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
            'qteCmd','noms','contact','mail','adresse','dateCmd',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
            ->selectRaw('(qteCmd*puCmd) as PTEntree')
            ->where([      
                ['tlog_detail_requisition.deleted','NON']
            ])
            ->orderBy("tlog_detail_requisition.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {  
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

           
            $data= DB::table('tlog_detail_requisition')
            ->join('tproduit','tproduit.id','=','tlog_detail_requisition.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
            'qteCmd','noms','contact','mail','adresse','dateCmd',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
            ->selectRaw('(qteCmd*puCmd) as PTEntree')
            ->where([
                 ['noms', 'like', '%'.$query.'%'],          
                 ['refEnteteCmd',$refEntete],
                 ['tlog_detail_requisition.deleted','NON']
             ])           
            ->orderBy("tlog_detail_requisition.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlog_detail_requisition')
            ->join('tproduit','tproduit.id','=','tlog_detail_requisition.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
            ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
            'qteCmd','noms','contact','mail','adresse','dateCmd',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
            ->selectRaw('(qteCmd*puCmd) as PTEntree')
            ->where([       
                ['refEnteteCmd',$refEntete],
                ['tlog_detail_requisition.deleted','NON']
            ])
            ->orderBy("tlog_detail_requisition.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts



        

    function fetch_single_detail($id)
    {
        $data = DB::table('tlog_detail_requisition')
        ->join('tproduit','tproduit.id','=','tlog_detail_requisition.refProduit')
        ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
        ->join('tlog_entete_requisition','tlog_entete_requisition.id','=','tlog_detail_requisition.refEnteteCmd')
        ->join('tfournisseur','tfournisseur.id','=','tlog_entete_requisition.refFournisseur')
        ->select('tlog_detail_requisition.id','refEnteteCmd','refProduit','puCmd',
        'qteCmd','noms','contact','mail','adresse','dateCmd',
        'libelle',"tproduit.designation","refCategorie","pu","unite",
        "tcategorieproduit.designation as Categorie",'tlog_detail_requisition.author','tlog_detail_requisition.created_at')
        ->selectRaw('(qteCmd*puCmd) as PTEntree')
        ->where('tlog_detail_requisition.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   //id,refEnteteCmd,refProduit,dateExpiration,numeroLot,puCmd,qteCmd,author
   
    function insert_detail(Request $request)
    {
        $data = tlog_detail_requisition::create([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $request->puCmd,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

        
        

       
    }

    function update_detail(Request $request, $id)
    {
        $data = tlog_detail_requisition::where('id', $id)->update([
            'refEnteteCmd'       =>  $request->refEnteteCmd,
            'refProduit'    =>  $request->refProduit,
            'puCmd'    =>  $request->puCmd,
            'qteCmd'    =>  $request->qteCmd,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tlog_detail_requisition::where('id',$id)->delete();              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }
}
