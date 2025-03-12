<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_detail_sortie;
use DB;
class tdetailsortieController extends Controller
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

            $data = DB::table('tmed_detail_sortie')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
            'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
            "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
            'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where('nom_agent', 'like', '%'.$query.'%')            
            ->orderBy("tmed_detail_sortie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_detail_sortie')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
            'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
            "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
            'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->orderBy("tmed_detail_sortie.id", "desc")
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

            $data= DB::table('tmed_detail_sortie')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
            'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
            "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
            'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->where([
                ['nom_agent', 'like', '%'.$query.'%'],          
                ['refEnteteSortie',$refEntete]
            ])
            ->orderBy("tmed_detail_sortie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data= DB::table('tmed_detail_sortie')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
            'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
            "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
            'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
            ->selectRaw('(qteSortie*puSortie) as PTSortie')
            ->Where('refEnteteSortie',$refEntete) 
            ->orderBy("tmed_detail_sortie.id", "desc")
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

    function fetch_list_detail_medicament2($refmedicament)
    {
        $data = DB::table('tconf_detailmedicament')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
        ->select("tconf_detailmedicament.id","refmedicament","quantite","dateexpiration","tconf_detailmedicament.author",
        "tconf_detailmedicament.created_at","nom_medicament","refcategoriemedicament",
        "pu_medicament","forme","nom_categoriemedicament")
        ->Where('refmedicament',$refmedicament)
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_detail($id)
    {

        $data= DB::table('tmed_detail_sortie')
        ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
        ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
        'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
        "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
        'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
        ->selectRaw('(qteSortie*puSortie) as PTSortie')
        ->where('tmed_detail_sortie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   //id,refEnteteSortie,refDetailMed,puSortie,qteSortie,author
    function insert_detail(Request $request)
    {
        $qte=$request->qteSortie;
        $idDetail=$request->refDetailMed;
        $idMed=0;
        $qteDispo=0;
//quantite

        $detailprod = DB::select('select * from tconf_detailmedicament where id = :idDet' ,
        ['idDet' => $idDetail]); 
         foreach ($detailprod as $details) {
            $idMed = $details->refmedicament;
            $qteDispo = $details->quantite;
         }

         if($qte <= $qteDispo)
         {
            $data = tmed_detail_sortie::create([
                'refEnteteSortie'       =>  $request->refEnteteSortie,
                'refDetailMed'    =>  $request->refDetailMed,
                'puSortie'    =>  $request->puSortie,
                'qteSortie'    =>  $request->qteSortie,
                'author'       =>  $request->author
            ]);
    
            $data2 = DB::update(
                'update tconf_detailmedicament set quantite = quantite - :qteVente where id = :refDetailMed',
                ['qteVente' => $qte,'refDetailMed' => $idDetail]
            );
    
            $data3 = DB::update(
                'update tconf_medicament set qtetot = qtetot - :qteEntree where id = :refProduit',
                ['qteEntree' => $qte,'refProduit' => $idMed]
            );
    
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);
         }
         else
         {
            return response()->json([
                'data'  =>  "La quantité demandée n'est pas disponible en stock !!!",
            ]);
         }
       

    }

    function update_detail(Request $request, $id)
    {
        $data = tmed_detail_sortie::where('id', $id)->update([
            'refEnteteSortie'       =>  $request->refEnteteSortie,
            'refDetailMed'    =>  $request->refDetailMed,
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
        $idMed=0;
        $qteDispo=0;

        $deleteds = DB::select('select * from tmed_detail_sortie'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteSortie;
            $idDetail = $deleted->refDetailMed;
        }

        $detailprod = DB::select('select * from tconf_detailmedicament where id = :idDet' ,
        ['idDet' => $idDetail]); 
         foreach ($detailprod as $details) {
            $idMed = $details->refmedicament;
            $qteDispo = $details->quantite;
         }


        $data = tmed_detail_sortie::where('id',$id)->delete();

        $data2 = DB::update(
            'update tconf_detailmedicament set quantite = quantite + :qteVente where id = :refDetailMed',
            ['qteVente' => $qte,'refDetailMed' => $idDetail]
        );

        $data3 = DB::update(
            'update tconf_medicament set qtetot = qtetot + :qteEntree where id = :refProduit',
            ['qteEntree' => $qte,'refProduit' => $idMed]
        );
              
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
