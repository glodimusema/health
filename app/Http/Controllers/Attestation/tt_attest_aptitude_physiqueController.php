<?php

namespace App\Http\Controllers\Attestation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Attestation\tt_attest_aptitude_physique;
use App\Models\Attestation\tt_attest_entete_attestation;
use App\Models\tentetetriage;
use App\Models\tdetailtriage;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

class tt_attest_aptitude_physiqueController extends Controller
{
    function Gquery($request)
    {
        return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);
            $data = DB::table('tt_attest_aptitude_physique')
            ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
            "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
            "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tt_attest_aptitude_physique.deleted','NON']
            ])           
            ->orderBy("tt_attest_aptitude_physique.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
           
            $data = DB::table('tt_attest_aptitude_physique')
            ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
            "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
            "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tt_attest_aptitude_physique.deleted','NON']
            ])
            ->orderBy("tt_attest_aptitude_physique.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }





    public function fetch_aptitudephysique_entete(Request $request,$refAttestation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tt_attest_aptitude_physique')
            ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
            "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
            "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refAttestation',$refAttestation],
                ['tt_attest_aptitude_physique.deleted','NON']
            ])                  
            ->orderBy("tt_attest_aptitude_physique.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tt_attest_aptitude_physique')
            ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
            "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
            "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refAttestation',$refAttestation],
                ['tt_attest_aptitude_physique.deleted','NON']
            ])    
            ->orderBy("tt_attest_aptitude_physique.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 




    function fetch_single_aptPhysique($id)
    {
        $data = DB::table('tt_attest_aptitude_physique')
        ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')

        ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
        "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
        "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tt_attest_aptitude_physique.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }



    function fetch_max_aptitude_physique(Request $request)
    {

        $refMouvement=$request->refMouvement;
        $refMedecin=$request->refMedecin;
        $author=$request->author;
        $refTypeCons=$request->refTypeCons;
        $refService=$request->refService;

        //Triage====================================
        $plainte_triage=$request->plainte_triage;
        $antecedent_trige=$request->antecedent_trige;
        $cas_triage=$request->cas_triage;
        $Poids=$request->Poids;
        $Taille=$request->Taille;
        $TA=$request->TA;
        $Temperature=$request->Temperature;
        $FC=$request->FC;
        $FR=$request->FR;
        $Oxygene=$request->Oxygene;
        //Aptitude physique ============================
        $thoracique    =  $request->thoracique;
        $indiceDePignat    =  $request->indiceDePignat;  
        $etatDeSante       =  $request->etatDeSante;
        $remarque    =  $request->remarque;
        $conclusion    =  $request->conclusion; 
        $DateDebut       =  $request->DateDebut;
        $DateFin    =  $request->DateFin;
        $examination    =  $request->examination; 



        $data = tentetetriage::create([
            'refMouvement'       =>  $refMouvement,
            'dateTriage'    =>  date('Y-m-d'),                      
            'author'       =>  $author
        ]);

        $id_entete_triage_max=0;
        $enteteTriage = DB::table('tentetetriage')      
        ->selectRaw('MAX(tentetetriage.id) as code_entete_triage')
        ->where([
            ['tentetetriage.refMouvement',$refMouvement]
        ])
        ->get();
        foreach ($enteteTriage as $list) {
            $id_entete_triage_max= $list->code_entete_triage;
        }


        $data1 = tdetailtriage::create([
            'refEnteteTriage'       =>  $id_entete_triage_max,
            'plainte_triage'       =>  $plainte_triage,
            'antecedent_trige'       =>  $antecedent_trige,
            'cas_triage'       =>  $cas_triage,
            'Poids'    =>  $Poids,
            'Taille'    =>  $Taille,
            'TA'    =>  $TA,
            'Temperature'    =>  $Temperature,
            'FC'    =>  $FC,
            'FR'    => $FR,
            'Oxygene'    =>  $Oxygene,                      
            'author'       =>  $author
        ]);
        $id_detail_triage_max=0;
        $detailTriage = DB::table('tdetailtriage')      
        ->selectRaw('MAX(tdetailtriage.id) as code_detail_triage')
        ->where([
            ['tdetailtriage.refEnteteTriage',$id_entete_triage_max]
        ])
        ->get();
        foreach ($detailTriage as $list) {
            $id_detail_triage_max= $list->code_detail_triage;
        }


        $data2 = tenteteconsulter::create([
            'refDetailTriage'       =>  $id_detail_triage_max,
            'refMedecin'    =>  $refMedecin,
            'TypeOrientation'    =>  'URGENCES',
            'dateConsultation'    =>  date('Y-m-d'),    
            'cloture'    =>  'NON',
            'refLitUrgence'    =>  1,
            'parcours'    => 'Consultation',     
            'author'       =>  $author
        ]);
        $id_entete_cons_max=0;
        $enteteCons = DB::table('tenteteconsulter')      
        ->selectRaw('MAX(tenteteconsulter.id) as code_entete_cons')
        ->where([
            ['tenteteconsulter.refDetailTriage',$id_detail_triage_max]
        ])
        ->get();
        foreach ($enteteCons as $list) {
            $id_entete_cons_max= $list->code_entete_cons;
        }



        $data3 = tdetailconsultation::create([
            'refEnteteCons'       =>   $id_entete_cons_max,
            'refTypeCons'    =>  $refTypeCons,
            'plainte'    =>  'Consultation Exrtene',
            'historique'    =>  'Consultation Exrtene',
            'antecedent'    =>  'Consultation Exrtene',
            'complementanamnese'    =>  'Consultation Exrtene',
            'examenphysique'    =>  'Consultation Exrtene',
            'diagnostiquePres'    =>  'Consultation Exrtene',
            'dateDetailCons'    =>  date('Y-m-d'),  
            'AutresDiagnostics'    =>  'Consultation Exrtene',            
            'author'       =>  $author
        ]);
        $id_detail_cons_max=0;
        $detailCons = DB::table('tdetailconsultation')      
        ->selectRaw('MAX(tdetailconsultation.id) as code_detail_cons')
        ->where([
            ['tdetailconsultation.refEnteteCons',$id_entete_cons_max]
        ])
        ->get();
        foreach ($detailCons as $list) {
            $id_detail_cons_max= $list->code_detail_cons;
        }



       $refDetailCons =$id_detail_cons_max;

        $data1 = tt_attest_entete_attestation::create([
            'refDetailConst'       =>  $refDetailCons,
            'dateAttestation'    =>  date('Y-m-d'),
            'author'    =>  $request->author  
        ]);


        $idmax=0;
        $maxid = DB::table('tt_attest_entete_attestation')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->selectRaw('MAX(tt_attest_entete_attestation.id) as code_entete_attestation')
        ->where('tt_attest_entete_attestation.refDetailConst', $refDetailCons)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_attestation;
        }

        $data = tt_attest_aptitude_physique::create([
            'refAttestation'       =>  $idmax,
            'thoracique'    =>  $thoracique,
            'indiceDePignat'    =>  $indiceDePignat,  
            'etatDeSante'       =>  $etatDeSante,
            'remarque'    =>  $remarque,
            'conclusion'    =>  $conclusion, 
            'DateDebut'       =>  $DateDebut,
            'DateFin'    =>  $DateFin,
            'examination'    =>  $examination,  
            'author'    =>  $request->author                        
        ]);


        $data = DB::table('tt_attest_aptitude_physique')
        ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')

        ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
        "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
        "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->where('tt_attest_aptitude_physique.refAttestation', $idmax)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }



 
    function insertdata(Request $request)
    {

        $data = tt_attest_aptitude_physique::create([
            'refAttestation'       =>  $request->refAttestation,
            'thoracique'    =>  $request->thoracique,
            'indiceDePignat'    =>  $request->indiceDePignat,  
            'etatDeSante'       =>  $request->etatDeSante,
            'remarque'    =>  $request->remarque,
            'conclusion'    =>  $request->conclusion, 
            'DateDebut'       =>  $request->DateDebut,
            'DateFin'    =>  $request->DateFin,
            'examination'    =>  $request->examination,  
            'author'    =>  $request->author                        
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    //id,refAttestation,thoracique,indiceDePignat,etatDeSante,remarque,conclusion,DateDebut,DateFin,examination,author

    function updateData(Request $request, $id)
    {
        $data = tt_attest_aptitude_physique::where('id', $id)->update([
            'refAttestation'       =>  $request->refAttestation,
            'thoracique'    =>  $request->thoracique,
            'indiceDePignat'    =>  $request->indiceDePignat,  
            'etatDeSante'       =>  $request->etatDeSante,
            'remarque'    =>  $request->remarque,
            'conclusion'    =>  $request->conclusion, 
            'DateDebut'       =>  $request->DateDebut,
            'DateFin'    =>  $request->DateFin,
            'examination'    =>  $request->examination,  
            'author'    =>  $request->author  
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     //
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
     //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tt_attest_aptitude_physique::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
