<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_detail_vente;
use DB;
class tdetailventeController extends Controller
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

            $data = DB::table('tmed_detail_vente')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_vente.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_vente','tmed_entete_vente.id','=','tmed_detail_vente.refEnteteVente')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_vente.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmed_detail_vente.id",'refEnteteVente','refDetailMed','puVente','qteVente',
            "refMouvement","dateVente","nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'dateexpiration',"tmed_detail_vente.author",
            "tmed_detail_vente.created_at","tmed_detail_vente.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qteVente*puVente) as PTVente')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_detail_vente.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_detail_vente')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_vente.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_vente','tmed_entete_vente.id','=','tmed_detail_vente.refEnteteVente')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_vente.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmed_detail_vente.id",'refEnteteVente','refDetailMed','puVente','qteVente',
            "refMouvement","dateVente","nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'dateexpiration',"tmed_detail_vente.author",
            "tmed_detail_vente.created_at","tmed_detail_vente.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qteVente*puVente) as PTVente')
            ->orderBy("tmed_detail_vente.id", "desc")
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

            $data= DB::table('tmed_detail_vente')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_vente.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_vente','tmed_entete_vente.id','=','tmed_detail_vente.refEnteteVente')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_vente.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmed_detail_vente.id",'refEnteteVente','refmedicament','refDetailMed','puVente','qteVente',
            "refMouvement","dateVente","nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'dateexpiration',"tmed_detail_vente.author",
            "tmed_detail_vente.created_at","tmed_detail_vente.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qteVente*puVente) as PTVente')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refEnteteVente',$refEntete]
            ])                     
            ->orderBy("tmed_detail_vente.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_detail_vente')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_vente.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_vente','tmed_entete_vente.id','=','tmed_detail_vente.refEnteteVente')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_vente.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmed_detail_vente.id",'refEnteteVente','refDetailMed','puVente','qteVente',
            "refMouvement","dateVente","nom_medicament","refcategoriemedicament","pu_medicament","forme",
            "nom_categoriemedicament",'dateexpiration',"tmed_detail_vente.author",
            "tmed_detail_vente.created_at","tmed_detail_vente.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qteVente*puVente) as PTVente')
            ->Where('refEnteteVente',$refEntete) 
            ->orderBy("tmed_detail_vente.id", "desc")
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
        "pu_medicament","forme","nom_categoriemedicament", DB::raw("CONCAT(dateexpiration,'  :  ',quantite,'(',forme,')') AS dateqte"))
        ->where([
            ['refmedicament',$refmedicament],          
            ['quantite','>',0]
        ])        
        ->orderBy("dateexpiration", "desc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_detail($id)
    {

        $data = DB::table('tmed_detail_vente')
        ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_vente.refDetailMed')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_vente','tmed_entete_vente.id','=','tmed_detail_vente.refEnteteVente')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_vente.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tmed_detail_vente.id",'refEnteteVente','refDetailMed','puVente','qteVente',
        "refMouvement","dateVente","nom_medicament","refcategoriemedicament","pu_medicament","forme",
        "nom_categoriemedicament",'dateexpiration',"tmed_detail_vente.author",
        "tmed_detail_vente.created_at","tmed_detail_vente.updated_at","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('(qteVente*puVente) as PTVente')
        ->where('tmed_detail_vente.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   //id,refEnteteVente,refDetailMed,puVente,qteVente,author
    function insert_detail(Request $request)
    {
        $qte=$request->qteVente;
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
            $data = tmed_detail_vente::create([
                'refEnteteVente'       =>  $request->refEnteteVente,
                'refDetailMed'    =>  $request->refDetailMed,
                'puVente'    =>  $request->puVente,
                'qteVente'    =>  $request->qteVente,
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
        $data = tmed_detail_vente::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refDetailMed'    =>  $request->refDetailMed,
            'puVente'    =>  $request->puVente,
            'qteVente'    =>  $request->qteVente,
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

        $deleteds = DB::select('select * from tmed_detail_vente'); 
        foreach ($deleteds as $deleted) {
            $qte = $deleted->qteVente;
            $idDetail = $deleted->refDetailMed;
        }

        $detailprod = DB::select('select * from tconf_detailmedicament where id = :idDet' ,
        ['idDet' => $idDetail]); 
         foreach ($detailprod as $details) {
            $idMed = $details->refmedicament;
            $qteDispo = $details->quantite;
         }

        $data = tmed_detail_vente::where('id',$id)->delete();

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
