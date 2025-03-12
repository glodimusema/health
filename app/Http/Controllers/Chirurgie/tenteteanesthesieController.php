<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chirurgie\tope_anesthesies;
use DB;

class tenteteanesthesieController extends Controller
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

            $data = DB::table('tope_anesthesies')
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
            ->select("tope_anesthesies.id",'refDetailCons',
            "refEnteteOpe","dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "denstisterie",
            "tromato_orthopedi",
            "chirurgie_cardiaque",
            "allergie_chirurgie",
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
            "TA_Anest",
            "FC_Anest",
            "FR_Anest",
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
            "Anesthesiste",
            "Chirurgien",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",
            
             "tope_anesthesies.author", "tope_anesthesies.created_at", "tope_anesthesies.updated_at",
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
            ->orderBy("tope_anesthesies.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_anesthesies')
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
            ->select("tope_anesthesies.id",'refDetailCons',
            "refEnteteOpe","dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "denstisterie",
            "tromato_orthopedi",
            "chirurgie_cardiaque",
            "allergie_chirurgie",
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
            "TA_Anest",
            "FC_Anest",
            "FR_Anest",
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
            "Anesthesiste",
            "Chirurgien",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",            
             "tope_anesthesies.author", "tope_anesthesies.created_at", "tope_anesthesies.updated_at",
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
            ->orderBy("tope_anesthesies.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteOpe)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tope_anesthesies')
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
            ->select("tope_anesthesies.id",'refDetailCons',
            "refEnteteOpe","dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "denstisterie",
            "tromato_orthopedi",
            "chirurgie_cardiaque",
            "allergie_chirurgie",
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
            "TA_Anest",
            "FC_Anest",
            "FR_Anest",
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
            "Anesthesiste",
            "Chirurgien",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",            
             "tope_anesthesies.author", "tope_anesthesies.created_at", "tope_anesthesies.updated_at",
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
                ['refEnteteOpe',$refEnteteOpe]
            ])                    
            ->orderBy("tope_anesthesies.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tope_anesthesies')
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
            ->select("tope_anesthesies.id",'refDetailCons',
            "refEnteteOpe","dateAnesthesie","diagnosticpreop","interventionEnvisagee",
            "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
            "anesthesieAnterieur",
            "protocole",
            "complication",
            "pathologieAnterieur",
            "nerveux",
            "renal",
            "cardio_circ",
            "pulmonaire",
            "foie",
            "denstisterie",
            "tromato_orthopedi",
            "chirurgie_cardiaque",
            "allergie_chirurgie",
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
            "TA_Anest",
            "FC_Anest",
            "FR_Anest",
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
            "Anesthesiste",
            "Chirurgien",
            "sousigne",
            "dateSousigne",
            "temoins",
            "nomPatient",    
            "serviceAnestesie",            
             "tope_anesthesies.author", "tope_anesthesies.created_at", "tope_anesthesies.updated_at",
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
            ->Where('refEnteteOpe',$refEnteteOpe)    
            ->orderBy("tope_anesthesies.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

 

    function fetch_single_detail($id)
    {

        $data = DB::table('tope_anesthesies')
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
        ->select("tope_anesthesies.id",'refDetailCons',
        "refEnteteOpe","dateAnesthesie","diagnosticpreop","interventionEnvisagee",
        "datePrevue","programme","urgence","reprise","chirurgieAnterieur",
        "anesthesieAnterieur",
        "protocole",
        "complication",
        "pathologieAnterieur",
        "nerveux",
        "renal",
        "cardio_circ",
        "pulmonaire",
        "foie",
        "denstisterie",
        "tromato_orthopedi",
        "chirurgie_cardiaque",
        "allergie_chirurgie",
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
        "TA_Anest",
        "FC_Anest",
        "FR_Anest",
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
        "Anesthesiste",
        "Chirurgien",
        "sousigne",
        "dateSousigne",
        "temoins",
        "nomPatient",    
        "serviceAnestesie",        
         "tope_anesthesies.author", "tope_anesthesies.created_at", "tope_anesthesies.updated_at",
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
        ->where('tope_anesthesies.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }


    // ,

    // "denstisterie",
    // "tromato_orthopedi",
    // "chirurgie_cardiaque",
    // "allergie_chirurgie"

  
    function insert_detail(Request $request)
    {
       
        $data = tope_anesthesies::create([
            'refEnteteOpe'       =>  $request->refEnteteOpe,           
            "dateAnesthesie"=>  $request->dateAnesthesie,
            "diagnosticpreop"=>  $request->diagnosticpreop,
            "interventionEnvisagee"=>  $request->interventionEnvisagee,
            "datePrevue"=>  $request->datePrevue,
            "programme"=>  $request->programme,
            "urgence"=>  $request->urgence,
            "reprise"=>  $request->reprise,
            "chirurgieAnterieur"=>  $request->chirurgieAnterieur,
            "anesthesieAnterieur"=>  $request->anesthesieAnterieur,
            "protocole"=>  $request->protocole,
            "complication"=>  $request->complication,
            "pathologieAnterieur"=>  $request->pathologieAnterieur,
            "nerveux"=>  $request->nerveux,
            "renal"=>  $request->renal,
            "cardio_circ"=>  $request->cardio_circ,
            "pulmonaire"=>  $request->pulmonaire,
            "foie"=>  $request->foie,
            "denstisterie"=>  $request->denstisterie,
            "tromato_orthopedi"=>  $request->tromato_orthopedi,
            "chirurgie_cardiaque"=>  $request->chirurgie_cardiaque,
            "allergie_chirurgie"=>  $request->allergie_chirurgie,
            "autresysteme"=>  $request->autresysteme,
            "ddr"=>  $request->ddr,
            "G_autres"=>  $request->G_autres,
            "P_autres"=>  $request->P_autres,
            "A_autres"=>  $request->A_autres,
            "D_autres"=>  $request->D_autres,
            "cardiophatie"=>  $request->cardiophatie,
            "diabete"=>  $request->diabete,
            "asthme"=>  $request->asthme,
            "tabac"=>  $request->tabac,
            "alcool"=>  $request->alcool,
            "hypertension"=>  $request->hypertension,
            "epilepsie"=>  $request->epilepsie,
            "alllergie"=>  $request->alllergie,
            "transfusion"=>  $request->transfusion,
            "medicament_drogue"=>  $request->medicament_drogue,
            "etatgeneral"=>  $request->etatgeneral,
            "conscience"=>  $request->conscience,
            "forcemusculaire"=>  $request->forcemusculaire,
            "bouche"=>  $request->bouche,
            "mallampatie"=>  $request->mallampatie,
            "conjonctive"=>  $request->conjonctive,
            "rhume"=>  $request->rhume,
            "taux"=>  $request->taux,
            "respiration"=>  $request->respiration,
            "choc_de_pointe"=>  $request->choc_de_pointe,
            "expectoration"=>  $request->expectoration,
            "auscultation"=>  $request->auscultation,
            "poumon"=>  $request->poumon,
            "coeurs"=>  $request->coeurs,
            "abdomen"=>  $request->abdomen,
            "dos"=>  $request->dos,
            "membres"=>  $request->membres,
            "TA_Anest"=>  $request->TA_Anest,
            "FC_Anest"=>  $request->FC_Anest,
            "FR_Anest"=>  $request->FR_Anest,
            "AutresSigneVitaux"=>  $request->AutresSigneVitaux,
            "HB"=>  $request->HB,
            "GS"=>  $request->GS,
            "RH"=>  $request->RH,
            "HT"=>  $request->HT,
            "TS"=>  $request->TS,
            "TC"=>  $request->TC,
            "Plaquette"=>  $request->Plaquette,
            "HIV"=>  $request->HIV,
            "FLN"=>  $request->FLN,
            "FLL"=>  $request->FLL,
            "FLM"=>  $request->FLM,
            "FLE"=>  $request->FLE,
            "FLB"=>  $request->FLB,
            "GB"=>  $request->GB,
            "GR"=>  $request->GR,
            "Uree"=>  $request->Uree,
            "Creat"=>  $request->Creat,
            "SGOT"=>  $request->SGOT,
            "SGPT"=>  $request->SGPT,
            "Lono"=>  $request->Lono,
            "Glycemie"=>  $request->Glycemie,
            "T3"=>  $request->T3,
            "T4"=>  $request->T4,
            "Albimines"=>  $request->Albimines,
            "Emmel"=>  $request->Emmel,
            "SAO2"=>  $request->SAO2,
            "RX"=>  $request->RX,
            "ECG"=>  $request->ECG,
            "EhoCardiaque"=>  $request->EhoCardiaque,
            "Patient"=>  $request->Patient,
            "Anesthesie"=>  $request->Anesthesie,
            "Chirurgie"=>  $request->Chirurgie,
            "Jeune"=>  $request->Jeune,
            "Rasage"=>  $request->Rasage,
            "Lavement"=>  $request->Lavement,
            "AutresCommandations"=>  $request->AutresCommandations,
            "LibelleAutresCommandation"=>  $request->LibelleAutresCommandation,
            "Anesthesiste"=>  $request->Anesthesiste,
            "Chirurgien"=>  $request->Chirurgien,
            "sousigne"=>  $request->sousigne,
            "dateSousigne"=>  $request->dateSousigne,
            "temoins"=>  $request->temoins,
            "nomPatient"=>  $request->nomPatient,    
            "serviceAnestesie"=>  $request->serviceAnestesie,                                                       
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detail(Request $request, $id)
    {
        $data = tope_anesthesies::where('id', $id)->update([
            'refEnteteOpe'       =>  $request->refEnteteOpe,           
            "dateAnesthesie"=>  $request->dateAnesthesie,
            "diagnosticpreop"=>  $request->diagnosticpreop,
            "interventionEnvisagee"=>  $request->interventionEnvisagee,
            "datePrevue"=>  $request->datePrevue,
            "programme"=>  $request->programme,
            "urgence"=>  $request->urgence,
            "reprise"=>  $request->reprise,
            "chirurgieAnterieur"=>  $request->chirurgieAnterieur,
            "anesthesieAnterieur"=>  $request->anesthesieAnterieur,
            "protocole"=>  $request->protocole,
            "complication"=>  $request->complication,
            "pathologieAnterieur"=>  $request->pathologieAnterieur,
            "nerveux"=>  $request->nerveux,
            "renal"=>  $request->renal,
            "cardio_circ"=>  $request->cardio_circ,
            "pulmonaire"=>  $request->pulmonaire,
            "foie"=>  $request->foie,
            "denstisterie"=>  $request->denstisterie,
            "tromato_orthopedi"=>  $request->tromato_orthopedi,
            "chirurgie_cardiaque"=>  $request->chirurgie_cardiaque,
            "allergie_chirurgie"=>  $request->allergie_chirurgie,
            "autresysteme"=>  $request->autresysteme,
            "ddr"=>  $request->ddr,
            "G_autres"=>  $request->G_autres,
            "P_autres"=>  $request->P_autres,
            "A_autres"=>  $request->A_autres,
            "D_autres"=>  $request->D_autres,
            "cardiophatie"=>  $request->cardiophatie,
            "diabete"=>  $request->diabete,
            "asthme"=>  $request->asthme,
            "tabac"=>  $request->tabac,
            "alcool"=>  $request->alcool,
            "hypertension"=>  $request->hypertension,
            "epilepsie"=>  $request->epilepsie,
            "alllergie"=>  $request->alllergie,
            "transfusion"=>  $request->transfusion,
            "medicament_drogue"=>  $request->medicament_drogue,
            "etatgeneral"=>  $request->etatgeneral,
            "conscience"=>  $request->conscience,
            "forcemusculaire"=>  $request->forcemusculaire,
            "bouche"=>  $request->bouche,
            "mallampatie"=>  $request->mallampatie,
            "conjonctive"=>  $request->conjonctive,
            "rhume"=>  $request->rhume,
            "taux"=>  $request->taux,
            "respiration"=>  $request->respiration,
            "choc_de_pointe"=>  $request->choc_de_pointe,
            "expectoration"=>  $request->expectoration,
            "auscultation"=>  $request->auscultation,
            "poumon"=>  $request->poumon,
            "coeurs"=>  $request->coeurs,
            "abdomen"=>  $request->abdomen,
            "dos"=>  $request->dos,
            "membres"=>  $request->membres,
            "TA_Anest"=>  $request->TA_Anest,
            "FC_Anest"=>  $request->FC_Anest,
            "FR_Anest"=>  $request->FR_Anest,
            "AutresSigneVitaux"=>  $request->AutresSigneVitaux,
            "HB"=>  $request->HB,
            "GS"=>  $request->GS,
            "RH"=>  $request->RH,
            "HT"=>  $request->HT,
            "TS"=>  $request->TS,
            "TC"=>  $request->TC,
            "Plaquette"=>  $request->Plaquette,
            "HIV"=>  $request->HIV,
            "FLN"=>  $request->FLN,
            "FLL"=>  $request->FLL,
            "FLM"=>  $request->FLM,
            "FLE"=>  $request->FLE,
            "FLB"=>  $request->FLB,
            "GB"=>  $request->GB,
            "GR"=>  $request->GR,
            "Uree"=>  $request->Uree,
            "Creat"=>  $request->Creat,
            "SGOT"=>  $request->SGOT,
            "SGPT"=>  $request->SGPT,
            "Lono"=>  $request->Lono,
            "Glycemie"=>  $request->Glycemie,
            "T3"=>  $request->T3,
            "T4"=>  $request->T4,
            "Albimines"=>  $request->Albimines,
            "Emmel"=>  $request->Emmel,
            "SAO2"=>  $request->SAO2,
            "RX"=>  $request->RX,
            "ECG"=>  $request->ECG,
            "EhoCardiaque"=>  $request->EhoCardiaque,
            "Patient"=>  $request->Patient,
            "Anesthesie"=>  $request->Anesthesie,
            "Chirurgie"=>  $request->Chirurgie,
            "Jeune"=>  $request->Jeune,
            "Rasage"=>  $request->Rasage,
            "Lavement"=>  $request->Lavement,
            "AutresCommandations"=>  $request->AutresCommandations,
            "LibelleAutresCommandation"=>  $request->LibelleAutresCommandation,
            "Anesthesiste"=>  $request->Anesthesiste,
            "Chirurgien"=>  $request->Chirurgien,
            "sousigne"=>  $request->sousigne,
            "dateSousigne"=>  $request->dateSousigne,
            "temoins"=>  $request->temoins,
            "nomPatient"=>  $request->nomPatient,    
            "serviceAnestesie"=>  $request->serviceAnestesie,                                                       
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tope_anesthesies::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
