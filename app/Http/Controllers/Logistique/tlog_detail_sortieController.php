<?php

namespace App\Http\Controllers\Logistique;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Logistique\tlog_detail_sortie;
use DB;
class tlog_detail_sortieController extends Controller
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

            $data = DB::table('tlog_detail_sortie')
            ->join('tproduit','tproduit.id','=','tlog_detail_sortie.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
            'libelle',"tproduit.designation","refCategorie","pu","unite","tcategorieproduit.designation as Categorie",
            'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlog_detail_sortie.deleted','NON']
            ])           
            ->orderBy("tlog_detail_sortie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlog_detail_sortie')
            ->join('tproduit','tproduit.id','=','tlog_detail_sortie.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
            'libelle',"tproduit.designation","refCategorie","pu","unite","tcategorieproduit.designation as Categorie",
            'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where([        
                ['tlog_detail_sortie.deleted','NON']
            ])
            ->orderBy("tlog_detail_sortie.id", "desc")
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

            $data= DB::table('tlog_detail_sortie')
            ->join('tproduit','tproduit.id','=','tlog_detail_sortie.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
            'libelle',"tproduit.designation","refCategorie","pu","unite","tcategorieproduit.designation as Categorie",
            'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where([
                ['nom_agent', 'like', '%'.$query.'%'],          
                ['refEnteteSortie',$refEntete],
                ['tlog_detail_sortie.deleted','NON']
            ])
            ->orderBy("tlog_detail_sortie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data= DB::table('tlog_detail_sortie')
            ->join('tproduit','tproduit.id','=','tlog_detail_sortie.refProduit')
            ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
            ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
            ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
            ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
            ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
            'libelle',"tproduit.designation","refCategorie","pu","unite","tcategorieproduit.designation as Categorie",
            'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where([      
                ['refEnteteSortie',$refEntete],
                ['tlog_detail_sortie.deleted','NON']
            ])
            ->orderBy("tlog_detail_sortie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    function fetch_single_detail($id)
    {
        $data= DB::table('tlog_detail_sortie')
        ->join('tproduit','tproduit.id','=','tlog_detail_sortie.refProduit')
        ->join('tcategorieproduit','tcategorieproduit.id','=','tproduit.refCategorie')
        ->join('tlog_entete_sortie','tlog_entete_sortie.id','=','tlog_detail_sortie.refEnteteSortie')
        ->join('tperso_service_personnel','tperso_service_personnel.id','=','tlog_entete_sortie.refService')
        ->join('tperso_categorie_service','tperso_categorie_service.id','=','tperso_service_personnel.refCatService')
        ->select('tlog_detail_sortie.id','refEnteteSortie','refProduit','puSortie','qteSortie','nom_agent','dateSortie',
        'libelle',"tproduit.designation","refCategorie","pu","unite","tcategorieproduit.designation as Categorie",
        'tlog_detail_sortie.author','tlog_detail_sortie.created_at')
        ->selectRaw('(qteSortie*puSortie) as PTSortie')
        ->where('tlog_detail_sortie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_detail(Request $request)
    {
        $qte=$request->qteSortie;
        $idDetail=$request->refProduit;
       
        $data = tlog_detail_sortie::create([
            'refEnteteSortie'       =>  $request->refEnteteSortie,
            'refProduit'    =>  $request->refProduit,
            'puSortie'    =>  $request->puSortie,
            'qteSortie'    =>  $request->qteSortie,
            'author'       =>  $request->author
        ]);

        $data2 = DB::update(
            'update tproduit set qte = qte - :qteSortie where id = :refProduit',
            ['qteSortie' => $qte,'refProduit' => $idDetail]
        );

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tlog_detail_sortie::where('id', $id)->update([
            'refEnteteSortie'       =>  $request->refEnteteSortie,
            'refProduit'    =>  $request->refProduit,
            'puSortie'    =>  $request->puSortie,
            'qteSortie'    =>  $request->qteSortie,
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
        $deleteds = DB::select('select * from tlog_detail_sortie'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteSortie;
            $idDetail = $deleted->refProduit;
        }
        $data = tlog_detail_sortie::where('id',$id)->delete();

        $data2 = DB::update(
            'update tproduit set qte = qte + :qteSortie where id = :refProduit',
            ['qteSortie' => $qte,'refProduit' => $idDetail]
        );
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
