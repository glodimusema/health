<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_detail_entree;
use DB;
class tlog_detail_entreeController extends Controller
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

            $data = DB::table('tlog_detail_entree')
            ->join('tproduit','tproduit.id','=','tlog_detail_entree.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_entree.refFournisseur')
            ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
            'qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlog_detail_entree.deleted','NON']
            ])            
            ->orderBy("tlog_detail_entree.id", "desc")          
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);         

        }
        else{
            $data = DB::table('tlog_detail_entree')
            ->join('tproduit','tproduit.id','=','tlog_detail_entree.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_entree.refFournisseur')
            ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
            'qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where([        
                ['tlog_detail_entree.deleted','NON']
            ])
            ->orderBy("tlog_detail_entree.id", "desc")
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
           
            $data= DB::table('tlog_detail_entree')
            ->join('tproduit','tproduit.id','=','tlog_detail_entree.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_entree.refFournisseur')
            ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
            'qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where([
                 ['noms', 'like', '%'.$query.'%'],          
                 ['refEnteteEntree',$refEntete],
                 ['tlog_detail_entree.deleted','NON']
             ])           
            ->orderBy("tlog_detail_entree.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlog_detail_entree')
            ->join('tproduit','tproduit.id','=','tlog_detail_entree.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tlog_entete_entree.refFournisseur')
            ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
            'qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"tproduit.designation","refCategorie","pu","unite",
            "tcategorieproduit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where([      
                ['refEnteteEntree',$refEntete],
                ['tlog_detail_entree.deleted','NON']
            ]) 
            ->orderBy("tlog_detail_entree.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }    

    //mes scripts
      

    function fetch_single_detail($id)
    {
        $data = DB::table('tlog_detail_entree')
        ->join('tproduit','tproduit.id','=','tlog_detail_entree.refProduit')
        ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
        ->join('tlog_entete_entree','tlog_entete_entree.id','=','tlog_detail_entree.refEnteteEntree')
        ->join('tfournisseur','tfournisseur.id','=','tlog_entete_entree.refFournisseur')
        ->select('tlog_detail_entree.id','refEnteteEntree','refProduit','puEntree',
        'qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"tproduit.designation","refCategorie","pu","unite",
        "tcategorieproduit.designation as Categorie",'tlog_detail_entree.author','tlog_detail_entree.created_at')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->where('tlog_detail_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
     
    function insert_detail(Request $request)
    {
        $qte=$request->qteEntree;
        $idDetail=$request->refProduit;       
        
        $data = tlog_detail_entree::create([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $request->puEntree,
            'qteEntree'    =>  $request->qteEntree,
            'author'       =>  $request->author
        ]);

        $data2 = DB::update(
            'update tproduit set qte = qte + :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idDetail]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
       
    }

    function update_detail(Request $request, $id)
    {
        $data = tlog_detail_entree::where('id', $id)->update([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refProduit'    =>  $request->refProduit,
            'puEntree'    =>  $request->puEntree,
            'qteEntree'    =>  $request->qteEntree,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $qte=0;
        $idDetail=0;
        $deleteds = DB::select('select * from tlog_detail_entree'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteEntree;
            $idDetail = $deleted->refProduit;
        }
        $data = tlog_detail_entree::where('id',$id)->delete();

        $data2 = DB::update(
            'update tproduit set qte = qte - :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idDetail]
        );
               
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }


}
