<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_entetefacturation;
use App\Models\Finances\tfin_detailfacturation;
use App\Models\Finances\tfin_paiementfacture;
use App\Models\Finances\tfin_cloture_caisse;
use Carbon\Carbon;
use DB;

class tentetefacturationController extends Controller
{
    public function index()
    {
        return 'hello';
    }
//
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }
   
    public function all(Request $request)
    {
        //'categoriemaladiemvt'    =>  $request->categoriemaladiemvt,
               
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
            "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
            ->selectRaw('IFNULL(montant,0) as totalFacture')
            ->selectRaw('IFNULL(paie,0) as totalPaie')
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['tfin_entetefacturation.deleted','NON']
            ])
            ->orWhere([
                ['tfin_entetefacturation.id', 'like', '%'.$query.''],
                ['tmouvement.Statut','Encours'],
                ['tfin_entetefacturation.deleted','NON']
            ])            
            ->orderBy("tfin_entetefacturation.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
            "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
            ->selectRaw('IFNULL(montant,0) as totalFacture')
            ->selectRaw('IFNULL(paie,0) as totalPaie')
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['tmouvement.Statut','Encours'],
                ['tfin_entetefacturation.deleted','NON']
            ])   
            ->orderBy("tfin_entetefacturation.id", "desc")           
            ->paginate(10);
                return response()->json([
                        'data'  => $data,
                    ]);
            }

    }


    public function fetch_entete_mouvement(Request $request,$refMouvement)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
            "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
            ->selectRaw('IFNULL(montant,0) as totalFacture')
            ->selectRaw('IFNULL(paie,0) as totalPaie')
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMouvement',$refMouvement],
                ['tmouvement.Statut','Encours'],
                ['tfin_entetefacturation.deleted','NON']
            ])                      
            ->orderBy("tfin_entetefacturation.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tfin_entetefacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
            'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
            "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
            ->selectRaw('IFNULL(montant,0) as totalFacture')
            ->selectRaw('IFNULL(paie,0) as totalPaie')
            ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
            ->where([
                ['refMouvement',$refMouvement],
                ['tmouvement.Statut','Encours'],
                ['tfin_entetefacturation.deleted','NON']
            ])    
            ->orderBy("tfin_entetefacturation.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 

    function fetch_single_entete($id)
    {

        $data = DB::table('tfin_entetefacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
        "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where('tfin_entetefacturation.id', $id)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_sommation_recette()
    {     
        $current = Carbon::now()->format('Y-m-d');

        $data = DB::table('tfin_entetefacturation')
        ->selectRaw('SUM(IFNULL(montant,0)) as totalFacture')
        ->selectRaw('SUM(IFNULL(paie,0)) as totalPaie')
        ->selectRaw('(SUM(IFNULL(montant,0)) - SUM(IFNULL(paie,0))) as TotalReste')
        ->where('tfin_entetefacturation.datefacture','>=', $current)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    } 

    function fetch_sommation_depense()
    {
        $current = Carbon::now()->format('Y-m-d');

        $data = DB::table('tdepense')
        ->selectRaw('SUM(IFNULL(montant,0)) as totalDepense')
        ->where([
            ['tdepense.dateOperation','>=', $current],
            ['tdepense.refMvt', '2']
        ])
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_max_entete_paiement_Mouvement(Request $request)
    {
        $refMouvement=$request->refMouvement;
        $refUniteProduction=$request->refUniteProduction;
        $refMedecin=$request->refMedecin;
        $author=$request->author;
        $refProduit=$request->refProduit;
        $modepaie=$request->modepaie;
        $refBanque=$request->refBanque;

        // $modepaie=$request->modepaie;
        // $refBanque=$request->refBanque;

        $idmax=0;       
        $quantite=1;
        $prixunitaire=0;
        $organisationAbonne='';
        $refCategorieSociete=0;
        $categoriemaladiemvt='';

        $mouvementList = DB::table('tmouvement')            
        ->select('categoriemaladiemvt')
        ->where([
            ['tmouvement.id',$refMouvement]
        ])
        ->get();
        foreach ($mouvementList as $liste_mvt) {
            $categoriemaladiemvt= $liste_mvt->categoriemaladiemvt;
        }

        $banqueList = DB::table('tconf_banque')            
        ->select("tconf_banque.id","tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode')
        ->where([
            ['tconf_banque.nom_mode','CASH']
        ])
        ->get();
        foreach ($banqueList as $liste_banque) {
            $modepaie= $liste_banque->nom_mode;
            $refBanque= $liste_banque->id;
        }

        $statuts='';
        if($categoriemaladiemvt == 'ABONNE(E)'){

            $statuts='CREDIT';

            $data1 = tfin_entetefacturation::create([
                'refMouvement'       =>  $refMouvement,
                'refUniteProduction'       =>  $refUniteProduction,
                'refMedecin'       =>  $refMedecin,
                'datefacture'       =>  date('Y-m-d'),
                'statut'    =>  $statuts,                           
                'author'       =>  $author
            ]);
        }
        else
        {
            $statuts='CASH';

            $data1 = tfin_entetefacturation::create([
                'refMouvement'       =>  $refMouvement,
                'refUniteProduction'       =>  $refUniteProduction,
                'refMedecin'       =>  $refMedecin,
                'datefacture'       =>  date('Y-m-d'),
                'statut'    =>  $statuts,                           
                'author'       =>  $author
            ]);
        } 

        $maxid = DB::table('tfin_entetefacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')        
        ->selectRaw('MAX(tfin_entetefacturation.id) as code_entete_facture')
        ->where([
            ['tfin_entetefacturation.refMouvement', $refMouvement],
            ['tfin_entetefacturation.deleted','NON']
        ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_facture;
        }

        
        //===Detail de la Facture =========================================================

        $montant_taux=0;
        $taux = DB::table('tfin_taux')->get(); 
        foreach ($taux as $tau) {
            $montant_taux= $tau->montant_taux;
        }

        $data2 = DB::table('tfin_entetefacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
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
        ->select('refMouvement','organisationAbonne')
        ->where([
            ['tfin_entetefacturation.id', $idmax],
            ['tfin_entetefacturation.deleted','NON']
        ])         
        ->get();
        foreach ($data2 as $list) {
           $organisationAbonne= $list->organisationAbonne;
        }

        $data3 = DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
         'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
         'name_categorie_societe','author',"tconf_organisationabone.created_at")
        ->where('nom_org', $organisationAbonne)         
        ->get();
        foreach ($data3 as $list) {
           $refCategorieSociete= $list->refCategorieSociete;
        }

        $data4 = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
        ->where([
            ['refCategorieSociete',$refCategorieSociete],
            ['tfin_produit.id',$refProduit]
        ])                 
        ->get();
        foreach ($data4 as $list) {
            $prixunitaire= $list->prix_produit;
        }
       
        $data5 = tfin_detailfacturation::create([
            'refEnteteFacturation'       =>  $idmax,
            'refProduit'       =>  $refProduit,
            'quantite'       =>  $quantite,
            'prixunitaire'       =>  $prixunitaire,                              
            'author'       =>  $author,
            'montant_taux'       =>  $montant_taux
        ]);

        $data33 = DB::update(
            'update tfin_entetefacturation set montant = montant + (:prixunitaire * :quantite) where id = :refEnteteFacturation',
            ['prixunitaire' => $prixunitaire,'quantite' => $quantite,'refEnteteFacturation' => $idmax]
        );
        
        //======== Paiement =====================================================================

        $datetest='';
        $data6 = DB::table('tfin_cloture_caisse')
       ->select('date_cloture')
       ->where('date_cloture','=', date('Y-m-d'))         
       ->get();    
       foreach ($data6 as $row) 
       {                           
          $datetest=$row->date_cloture;          
       }

       if($datetest == date('Y-m-d'))
       {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {   
            $data7 = tfin_paiementfacture::create([
                'refEnteteFacturation'       =>  $idmax,
                'montantpaie'       =>  $prixunitaire,
                'datepaie'       =>  date('Y-m-d'),
                'modepaie'       =>  $modepaie,
                'libellepaie'       =>  'Paiement Consultation',                     
                'author'       =>  $author,
                'montant_taux'       =>  $montant_taux,
                'refBanque'       =>  $refBanque,
                'numeroBordereau'       =>  '0000000'
            ]);
//
            $data34 = DB::update(
                'update tfin_entetefacturation set paie = paie + (:paiement) where id = :refEnteteFacturation',
                ['paiement' => $prixunitaire,'refEnteteFacturation' => $idmax]
            );
       }


       $data = DB::table('tfin_entetefacturation')
       ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
       ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
       ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
       ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
       ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
       ->join('tclient','tclient.id','=','tmouvement.refMalade')
       ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
       ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
       ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
       ->join('communes' , 'communes.id','=','quartiers.idCommune')
       ->join('villes' , 'villes.id','=','communes.idVille')
       ->join('provinces' , 'provinces.id','=','villes.idProvince')
       ->join('pays' , 'pays.id','=','provinces.idPays')
       ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
       'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
       'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
       "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
       "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
       "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
       "dateMouvement",'organisationAbonne','taux_prisecharge',
       'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
       "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
       "ttypemouvement_malade.designation as Typemouvement","noms","contact",
       "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
       "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
       "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
       "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
       "contactPersRef_malade","organisation_malade","numeroCarte_malade",
       "dateExpiration_malade")
       ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
       ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
       ->selectRaw('IFNULL(montant,0) as totalFacture')
       ->selectRaw('IFNULL(paie,0) as totalPaie')
       ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
       ->where([
        ['tfin_entetefacturation.id', $idmax],
        ['tfin_entetefacturation.deleted','NON']
        ])
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);


    }





    function insert_entete(Request $request)
    {
        $categoriemaladiemvt='';
        $mouvementList = DB::table('tmouvement')            
        ->select('categoriemaladiemvt')
        ->where([
            ['tmouvement.id',$request->refMouvement]
        ])
        ->get();
        foreach ($mouvementList as $liste_mvt) {
            $categoriemaladiemvt= $liste_mvt->categoriemaladiemvt;
        }

        $statuts='';
        if($categoriemaladiemvt == 'ABONNE(E)'){

            $statuts='CREDIT';           
        }
        else
        {
            $statuts='CASH';
        }    
        
        $data1 = tfin_entetefacturation::create([
            'refMouvement'       =>  $request->refMouvement,
            'refUniteProduction'       =>  $request->refUniteProduction,
            'refMedecin'       =>  $request->refMedecin,
            'datefacture'       =>  date('Y-m-d'),
            'statut'    =>  $statuts,                           
            'author'       =>  $request->author
        ]);

        $idmax=0; 
        $maxid = DB::table('tfin_entetefacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')        
        ->selectRaw('MAX(tfin_entetefacturation.id) as code_entete_facture')
        ->where([
            ['tfin_entetefacturation.refMouvement', $request->refMouvement],
            ['tfin_entetefacturation.deleted','NON']
        ])
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_facture;
        }
        $data = DB::table('tfin_entetefacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
        "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL(montant,0)-IFNULL(paie,0)) as RestePaie')
        ->where([
            ['tfin_entetefacturation.id', $idmax],
            ['tfin_entetefacturation.deleted','NON']
        ])
         ->get();
         //
         return response()->json([
         'data' => $data,
         ]);

        // return response()->json([
        //     'data'  =>  "Insertion avec succès!!!",
        // ]);
    }


    function update_entete(Request $request, $id)
    {
        $idFacture=0;
        $datefacture=0;

        $deleteds = DB::table('tfin_entetefacturation')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->id;
            $datefacture = $deleted->datefacture;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
        ->select('date_cloture')
        ->where('date_cloture','=', $datefacture)         
        ->get();    
        foreach ($data3 as $row) 
        {                           
           $datetest=$row->date_cloture;          
        }

        if($datefacture == $datetest)
        {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour toutes les factures de cette date svp!!! !!!",
            ]);
        }
        else
        {
            $data = tfin_entetefacturation::where('id', $id)->update([
                'refMouvement'       =>  $request->refMouvement,
                'refUniteProduction'       =>  $request->refUniteProduction,
                'refMedecin'       =>  $request->refMedecin,
                'statut'    =>  $request->statut,                           
                'author'       =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);
        }

    }

    function delete_entete($id)
    {
        $idFacture=0;
        $datefacture=0;

        $deleteds = DB::table('tfin_entetefacturation')->Where('id',$id)->get(); 
        foreach ($deleteds as $deleted) {
            $idFacture = $deleted->id;
            $datefacture = $deleted->datefacture;
        }

        $datetest='';
        $data3 = DB::table('tfin_cloture_caisse')
        ->select('date_cloture')
        ->where('date_cloture','=', $datefacture)         
        ->get();    
        foreach ($data3 as $row) 
        {                           
           $datetest=$row->date_cloture;          
        }

        if($datefacture == $datetest)
        {
            return response()->json([
                'data'  =>  "La Caisse est déja cloturée pour toutes les factures de cette date svp!!! !!!",
            ]);
        }
        else
        {
            $data = tfin_detailfacturation::where('refEnteteFacturation',$id)->delete();
            $data = tfin_paiementfacture::where('refEnteteFacturation',$id)->delete();
            $data = tfin_entetefacturation::where('id',$id)->delete();
            return response()->json([
                'data'  =>  "suppression avec succès",
            ]); 
        }
       
    }
}
