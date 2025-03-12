<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chirurgie\tope_detailsurveillance;
use DB;

class tdetailsurveillanceController extends Controller
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
        
    //
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tope_detailsurveillance')
            ->join('tope_rubriquesurveillance','tope_rubriquesurveillance.id','=','tope_detailsurveillance.refRubrique')
            ->join('tope_entetesurveillance','tope_entetesurveillance.id','=','tope_detailsurveillance.refEnteteSurv')

            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
//
            ->join('tope_anesthesies','tope_anesthesies.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','tope_anesthesies.refEnteteOpe')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
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
            //MALADE
            ->select("tope_detailsurveillance.id",
            'refEnteteSurv','refRubrique','nom_rubliquesurv','libres','encombres','ampleERugiliere','disphee',
            'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
            'Observe1','Observe2','Observe3','refAnesthesie','tope_entetesurveillance.refDepartement',
            'dateSurveillance','tope_entetesurveillance.chirurgien',
            'tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires','refDetailCons',"refEnteteOpe",
            "dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",'tfin_uniteproduction.refDepartement as refDepartementUnite','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "autresysteme",
            "ddr",
            "G_autres",
            "P_autres",
            "A_autres",
            "D_autres",
            "cardiophatie",
            "diabete",
            "asthme",
            "tabac",
            "alcool",
            "hypertension",
            "epilepsie",
            "alllergie",
            "transfusion",
            "medicament_drogue",
            "etatgeneral",
            "conscience",
            "forcemusculaire",
            "bouche",
            "mallampatie",
            "conjonctive",
            "rhume",
            "taux",
            "respiration",
            "choc_de_pointe",
            "expectoration",
            "auscultation",
            "poumon",
            "coeurs",
            "abdomen",
            "dos",
            "membres",
            "TA",
            "FC",
            "FR",
            "AutresSigneVitaux",
            "HB",
            "GS",
            "RH",
            "HT",
            "TS",
            "TC",
            "Plaquette",
            "HIV",
            "FLN",
            "FLL",
            "FLM",
            "FLE",
            "FLB",
            "GB",
            "GR",
            "Uree",
            "Creat",
            "SGOT",
            "SGPT",
            "Lono",
            "Glycemie",
            "T3",
            "T4",
            "Albimines",
            "Emmel",
            "SAO2",
            "RX",
            "ECG",
            "EhoCardiaque",
            "Patient",
            "Anesthesie",
            "Chirurgie",
            "Jeune",
            "Rasage",
            "Lavement",
            "AutresCommandations",
            "LibelleAutresCommandation",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",
              
             "tope_detailsurveillance.author", "tope_detailsurveillance.created_at", "tope_detailsurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tope_detailsurveillance.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_detailsurveillance')
            ->join('tope_rubriquesurveillance','tope_rubriquesurveillance.id','=','tope_detailsurveillance.refRubrique')
            ->join('tope_entetesurveillance','tope_entetesurveillance.id','=','tope_detailsurveillance.refEnteteSurv')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tope_anesthesies','tope_anesthesies.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','tope_anesthesies.refEnteteOpe')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
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
            //MALADE
            ->select("tope_detailsurveillance.id",
            'refEnteteSurv','refRubrique','nom_rubliquesurv','libres','encombres','ampleERugiliere','disphee',
            'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
            'Observe1','Observe2','Observe3','refAnesthesie','tope_entetesurveillance.refDepartement',
            'dateSurveillance','tope_entetesurveillance.chirurgien',
            'tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires','refDetailCons',"refEnteteOpe",
            "dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",'tfin_uniteproduction.refDepartement as refDepartementUnite','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "autresysteme",
            "ddr",
            "G_autres",
            "P_autres",
            "A_autres",
            "D_autres",
            "cardiophatie",
            "diabete",
            "asthme",
            "tabac",
            "alcool",
            "hypertension",
            "epilepsie",
            "alllergie",
            "transfusion",
            "medicament_drogue",
            "etatgeneral",
            "conscience",
            "forcemusculaire",
            "bouche",
            "mallampatie",
            "conjonctive",
            "rhume",
            "taux",
            "respiration",
            "choc_de_pointe",
            "expectoration",
            "auscultation",
            "poumon",
            "coeurs",
            "abdomen",
            "dos",
            "membres",
            "TA",
            "FC",
            "FR",
            "AutresSigneVitaux",
            "HB",
            "GS",
            "RH",
            "HT",
            "TS",
            "TC",
            "Plaquette",
            "HIV",
            "FLN",
            "FLL",
            "FLM",
            "FLE",
            "FLB",
            "GB",
            "GR",
            "Uree",
            "Creat",
            "SGOT",
            "SGPT",
            "Lono",
            "Glycemie",
            "T3",
            "T4",
            "Albimines",
            "Emmel",
            "SAO2",
            "RX",
            "ECG",
            "EhoCardiaque",
            "Patient",
            "Anesthesie",
            "Chirurgie",
            "Jeune",
            "Rasage",
            "Lavement",
            "AutresCommandations",
            "LibelleAutresCommandation",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",
              
             "tope_detailsurveillance.author", "tope_detailsurveillance.created_at", "tope_detailsurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->orderBy("tope_detailsurveillance.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteSurv)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tope_detailsurveillance')
            ->join('tope_rubriquesurveillance','tope_rubriquesurveillance.id','=','tope_detailsurveillance.refRubrique')
            ->join('tope_entetesurveillance','tope_entetesurveillance.id','=','tope_detailsurveillance.refEnteteSurv')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tope_anesthesies','tope_anesthesies.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','tope_anesthesies.refEnteteOpe')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
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
            //MALADE
            ->select("tope_detailsurveillance.id",
            'refEnteteSurv','refRubrique','nom_rubliquesurv','libres','encombres','ampleERugiliere','disphee',
            'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
            'Observe1','Observe2','Observe3','refAnesthesie','tope_entetesurveillance.refDepartement',
            'dateSurveillance','tope_entetesurveillance.chirurgien',
            'tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires','refDetailCons',"refEnteteOpe",
            "dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",'tfin_uniteproduction.refDepartement as refDepartementUnite','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "autresysteme",
            "ddr",
            "G_autres",
            "P_autres",
            "A_autres",
            "D_autres",
            "cardiophatie",
            "diabete",
            "asthme",
            "tabac",
            "alcool",
            "hypertension",
            "epilepsie",
            "alllergie",
            "transfusion",
            "medicament_drogue",
            "etatgeneral",
            "conscience",
            "forcemusculaire",
            "bouche",
            "mallampatie",
            "conjonctive",
            "rhume",
            "taux",
            "respiration",
            "choc_de_pointe",
            "expectoration",
            "auscultation",
            "poumon",
            "coeurs",
            "abdomen",
            "dos",
            "membres",
            "TA",
            "FC",
            "FR",
            "AutresSigneVitaux",
            "HB",
            "GS",
            "RH",
            "HT",
            "TS",
            "TC",
            "Plaquette",
            "HIV",
            "FLN",
            "FLL",
            "FLM",
            "FLE",
            "FLB",
            "GB",
            "GR",
            "Uree",
            "Creat",
            "SGOT",
            "SGPT",
            "Lono",
            "Glycemie",
            "T3",
            "T4",
            "Albimines",
            "Emmel",
            "SAO2",
            "RX",
            "ECG",
            "EhoCardiaque",
            "Patient",
            "Anesthesie",
            "Chirurgie",
            "Jeune",
            "Rasage",
            "Lavement",
            "AutresCommandations",
            "LibelleAutresCommandation",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",
              
             "tope_detailsurveillance.author", "tope_detailsurveillance.created_at", "tope_detailsurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteSurv',$refEnteteSurv]
            ])                    
            ->orderBy("tope_detailsurveillance.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tope_detailsurveillance')
            ->join('tope_rubriquesurveillance','tope_rubriquesurveillance.id','=','tope_detailsurveillance.refRubrique')
            ->join('tope_entetesurveillance','tope_entetesurveillance.id','=','tope_detailsurveillance.refEnteteSurv')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tope_anesthesies','tope_anesthesies.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','tope_anesthesies.refEnteteOpe')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
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
            //MALADE
            ->select("tope_detailsurveillance.id",
            'refEnteteSurv','refRubrique','nom_rubliquesurv','libres','encombres','ampleERugiliere','disphee',
            'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
            'Observe1','Observe2','Observe3','refAnesthesie','tope_entetesurveillance.refDepartement',
            'dateSurveillance','tope_entetesurveillance.chirurgien',
            'tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires','refDetailCons',"refEnteteOpe",
            "dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",'tfin_uniteproduction.refDepartement as refDepartementUnite','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "autresysteme",
            "ddr",
            "G_autres",
            "P_autres",
            "A_autres",
            "D_autres",
            "cardiophatie",
            "diabete",
            "asthme",
            "tabac",
            "alcool",
            "hypertension",
            "epilepsie",
            "alllergie",
            "transfusion",
            "medicament_drogue",
            "etatgeneral",
            "conscience",
            "forcemusculaire",
            "bouche",
            "mallampatie",
            "conjonctive",
            "rhume",
            "taux",
            "respiration",
            "choc_de_pointe",
            "expectoration",
            "auscultation",
            "poumon",
            "coeurs",
            "abdomen",
            "dos",
            "membres",
            "TA",
            "FC",
            "FR",
            "AutresSigneVitaux",
            "HB",
            "GS",
            "RH",
            "HT",
            "TS",
            "TC",
            "Plaquette",
            "HIV",
            "FLN",
            "FLL",
            "FLM",
            "FLE",
            "FLB",
            "GB",
            "GR",
            "Uree",
            "Creat",
            "SGOT",
            "SGPT",
            "Lono",
            "Glycemie",
            "T3",
            "T4",
            "Albimines",
            "Emmel",
            "SAO2",
            "RX",
            "ECG",
            "EhoCardiaque",
            "Patient",
            "Anesthesie",
            "Chirurgie",
            "Jeune",
            "Rasage",
            "Lavement",
            "AutresCommandations",
            "LibelleAutresCommandation",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",
              
             "tope_detailsurveillance.author", "tope_detailsurveillance.created_at", "tope_detailsurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refEnteteSurv',$refEnteteSurv)    
            ->orderBy("tope_detailsurveillance.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

 

    function fetch_single_detail($id)
    {

        $data = DB::table('tope_detailsurveillance')
        ->join('tope_rubriquesurveillance','tope_rubriquesurveillance.id','=','tope_detailsurveillance.refRubrique')
        ->join('tope_entetesurveillance','tope_entetesurveillance.id','=','tope_detailsurveillance.refEnteteSurv')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tope_anesthesies','tope_anesthesies.id','=','tope_entetesurveillance.refAnesthesie')
        ->join('tope_enteteoperation','tope_enteteoperation.id','=','tope_anesthesies.refEnteteOpe')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
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
        //MALADE
        ->select("tope_detailsurveillance.id",
        'refEnteteSurv','refRubrique','nom_rubliquesurv','libres','encombres','ampleERugiliere','disphee',
        'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
        'Observe1','Observe2','Observe3','refAnesthesie','tope_entetesurveillance.refDepartement',
        'dateSurveillance','tope_entetesurveillance.chirurgien',
        'tope_entetesurveillance.anesthesiste',
        'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
        'autresCommentaires','refDetailCons',"refEnteteOpe",
        "dateAnesthesie","diagnosticpreop","interventionEnvisagee",
        "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
        "anesthesieAnterieur",'tfin_uniteproduction.refDepartement as refDepartementUnite','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',
        "protocole",
        "complication",
        "pathologieAnterieur",
        "nerveux",
        "renal",
        "cardio_circ",
        "pulmonaire",
        "foie",
        "autresysteme",
        "ddr",
        "G_autres",
        "P_autres",
        "A_autres",
        "D_autres",
        "cardiophatie",
        "diabete",
        "asthme",
        "tabac",
        "alcool",
        "hypertension",
        "epilepsie",
        "alllergie",
        "transfusion",
        "medicament_drogue",
        "etatgeneral",
        "conscience",
        "forcemusculaire",
        "bouche",
        "mallampatie",
        "conjonctive",
        "rhume",
        "taux",
        "respiration",
        "choc_de_pointe",
        "expectoration",
        "auscultation",
        "poumon",
        "coeurs",
        "abdomen",
        "dos",
        "membres",
        "TA",
        "FC",
        "FR",
        "AutresSigneVitaux",
        "HB",
        "GS",
        "RH",
        "HT",
        "TS",
        "TC",
        "Plaquette",
        "HIV",
        "FLN",
        "FLL",
        "FLM",
        "FLE",
        "FLB",
        "GB",
        "GR",
        "Uree",
        "Creat",
        "SGOT",
        "SGPT",
        "Lono",
        "Glycemie",
        "T3",
        "T4",
        "Albimines",
        "Emmel",
        "SAO2",
        "RX",
        "ECG",
        "EhoCardiaque",
        "Patient",
        "Anesthesie",
        "Chirurgie",
        "Jeune",
        "Rasage",
        "Lavement",
        "AutresCommandations",
        "LibelleAutresCommandation",
        "sousigne",
        "dateSousigne",
        "temoins",
        "nomPatient",    
        "serviceAnestesie",
          
         "tope_detailsurveillance.author", "tope_detailsurveillance.created_at", "tope_detailsurveillance.updated_at",
        "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
        "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tope_detailsurveillance.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

   //'refEnteteSurv','refRubrique','libres','encombres','ampleERugiliere','disphee',
   // 'lucide','marcose','propre','souille','normale','nonretablie','observationSurv', 
    //'Observe1','Observe2','Observe3',
    function insert_detail(Request $request)
    {
       
        $data = tope_detailsurveillance::create([
            'refEnteteSurv'       =>  $request->refEnteteSurv,
            "refRubrique"=>  $request->refRubrique,
            "libres"=>  $request->libres,
            "encombres"=>  $request->encombres,
            "ampleERugiliere"=>  $request->ampleERugiliere,
            "disphee"=>  $request->disphee,
            "lucide"=>  $request->lucide,
            "marcose"=>  $request->marcose,
            "propre"=>  $request->propre,
            "souille"=>  $request->souille,
            "normale"=>  $request->normale,
            "nonretablie"=>  $request->nonretablie,
            "observationSurv"=>  $request->observationSurv, 
            "Observe1"=>  $request->Observe1, 
            "Observe2"=>  $request->Observe2, 
            "Observe3"=>  $request->Observe3,                             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detail(Request $request, $id)
    {
        $data = tope_detailsurveillance::where('id', $id)->update([
            'refEnteteSurv'       =>  $request->refEnteteSurv,
            "refRubrique"=>  $request->refRubrique,
            "libres"=>  $request->libres,
            "encombres"=>  $request->encombres,
            "ampleERugiliere"=>  $request->ampleERugiliere,
            "disphee"=>  $request->disphee,
            "lucide"=>  $request->lucide,
            "marcose"=>  $request->marcose,
            "propre"=>  $request->propre,
            "souille"=>  $request->souille,
            "normale"=>  $request->normale,
            "nonretablie"=>  $request->nonretablie,
            "observationSurv"=>  $request->observationSurv,
            "Observe1"=>  $request->Observe1, 
            "Observe2"=>  $request->Observe2, 
            "Observe3"=>  $request->Observe3,                                  
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tope_detailsurveillance::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
