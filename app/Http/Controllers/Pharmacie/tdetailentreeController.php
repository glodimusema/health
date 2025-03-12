<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_detail_entree;
use App\Models\Parametres\{tconf_detailmedicament};
use DB;
class tdetailentreeController extends Controller
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

            $data = DB::table('tmed_detail_entree')
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
            'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_detail_entree.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_detail_entree')
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
            'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->orderBy("tmed_detail_entree.id", "desc")
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

           
            $data= DB::table('tmed_detail_entree')
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
            'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->where([
                 ['noms', 'like', '%'.$query.'%'],          
                 ['refEnteteEntree',$refEntete]
             ])           
            ->orderBy("tmed_detail_entree.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_detail_entree')
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
            ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
            ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
            'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
            'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
            ->selectRaw('(qteEntree*puEntree) as PTEntree')
            ->Where('refEnteteEntree',$refEntete) 
            ->orderBy("tmed_detail_entree.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_medicament2()
    {

        $data = DB::table('tconf_medicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament",
        "pu_medicament","forme","nom_categoriemedicament")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_medicament2($id)
    {
        $data = DB::table('tconf_medicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament",
        "pu_medicament","forme","nom_categoriemedicament")
        ->where('tconf_medicament.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


        

    function fetch_single_detail($id)
    {

        $data = DB::table('tmed_detail_entree')
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
        ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
        ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
        'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
        "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->where('tmed_detail_entree.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   //id,refEnteteEntree,refmedicament,dateExpiration,numeroLot,puEntree,qteEntree,author
   
    function insert_detail(Request $request)
    {
        $dateExp=$request->dateExpiration;
        $idMed=$request->refmedicament;
        $qteDet=$request->qteEntree;
        $user=$request->author;
        $refEntree=$request->refEnteteEntree;
        $dateEntree="";

        $dateExpTest=date('Y-m-d');


       $entrees = DB::select('select * from tmed_entete_entree where id = :refEntree',
       ['refEntree' => $refEntree]); 
        foreach ($entrees as $entree) {
            $dateEntree = $entree->dateEntree;
        }

       $detailprod = DB::select('select * from tconf_detailmedicament where refmedicament = :idMedicament and dateexpiration = :dateexpiration' ,
       ['idMedicament' => $idMed, 'dateexpiration' => $dateExp]); 
        foreach ($detailprod as $details) {
            $dateExpTest = $details->dateexpiration;
        }

        if($dateExpTest == $dateExp)
        {
            $data = tmed_detail_entree::create([
                'refEnteteEntree'       =>  $request->refEnteteEntree,
                'refmedicament'    =>  $request->refmedicament,
                'dateExpiration'    =>  $request->dateExpiration,
                'numeroLot'    =>  $request->numeroLot,
                'puEntree'    =>  $request->puEntree,
                'qteEntree'    =>  $request->qteEntree,
                'author'       =>  $request->author
            ]);

            $data2 = DB::update(
                'update tconf_detailmedicament set quantite = quantite + :qteEntree where refmedicament = :refProduit and dateexpiration = :dateexp',
                ['qteEntree' => $qteDet,'refProduit' => $idMed,'dateexp' => $dateExp]
            );
    
            $data3 = DB::update(
                'update tconf_medicament set qtetot = qtetot + :qteEntree where id = :refProduit',
                ['qteEntree' => $qteDet,'refProduit' => $idMed]
            );
    
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
    
        }
        else
        {
            $data = tmed_detail_entree::create([
                'refEnteteEntree'       =>  $request->refEnteteEntree,
                'refmedicament'    =>  $request->refmedicament,
                'dateExpiration'    =>  $request->dateExpiration,
                'numeroLot'    =>  $request->numeroLot,
                'puEntree'    =>  $request->puEntree,
                'qteEntree'    =>  $request->qteEntree,
                'author'       =>  $request->author
            ]);
            $data1 = tconf_detailmedicament::create([
                'refmedicament'       =>  $idMed,
                'quantite'    =>  $qteDet,
                'dateexpiration'    =>  $dateExp,
                'dateEntree'    => $dateEntree,                
                'author'       =>  $request->author
            ]);
    
            $data2 = DB::update(
                'update tconf_medicament set qtetot = qtetot + :qteEntree where id = :refProduit',
                ['qteEntree' => $qteDet,'refProduit' => $idMed]
            );
    
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);

        }
        

        
        

       
    }

    function update_detail(Request $request, $id)
    {
        $data = tmed_detail_entree::where('id', $id)->update([
            'refEnteteEntree'       =>  $request->refEnteteEntree,
            'refmedicament'    =>  $request->refmedicament,
            'dateExpiration'    =>  $request->dateExpiration,
            'numeroLot'    =>  $request->numeroLot,
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

        $refEntree=0;
        $refmedicament=0;
        $dateEntree="";
        $dateExpiration="";
        
        $deleteds = DB::table('tmed_detail_entree')
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
        ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
        ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
        'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
        'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
        "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
        ->selectRaw('(qteEntree*puEntree) as PTEntree')
        ->where('tmed_detail_entree.id', $id)->get(); 
        foreach ($deleteds as $deleted) {
            $refmedicament = $deleted->refmedicament;
            $dateExpiration = $deleted->dateExpiration;
            $refEntree = $deleted->refEnteteEntree;
            $dateEntree = $deleted->dateEntree;
            $qte = $deleted->qteEntree;
        }
                
        $data = tmed_detail_entree::where('id',$id)->delete();

        $data2 = DB::delete(
            'delete from tconf_detailmedicament where refmedicament = :refmedicament and dateexpiration = :dateexpiration and dateEntree = :dateEntree',
            ['refmedicament' => $refmedicament,'dateexpiration' => $dateExpiration,'dateEntree' => $dateEntree]
        );

        $data3 = DB::update(
            'update tconf_medicament set qtetot = qtetot - :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $refmedicament]
        );
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);        
    }
}
