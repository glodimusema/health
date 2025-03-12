<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_signe_vitaux_surveil;
use DB;

class thospi_signe_vitaux_surveilController extends Controller
{

    public function index()
    {
        return '';
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

            $data = DB::table('thospi_signe_vitaux_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_signe_vitaux_surveil.refSurvHospi')
            ->join('thospitalisation','thospitalisation.id','=','thospi_surveillance_hospie.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            //
            ->select("thospi_signe_vitaux_surveil.id","heure","temperatureSurv","thospi_signe_vitaux_surveil.TA as TAsigneVitaux",
            "respiration",'pulsation', 'qtepulsation','etatconscience',"refHospi",
            "mouvement","vomissement","diarhee","qteDiarhee","drainGauche","drainDroite","duirese","qteDuirese",
            "perfusion","qtePerfusion","AborVeineux","Glycemie","hemoragie","thospi_signe_vitaux_surveil.oxygene","pensement","detailPensement",
            "thospi_signe_vitaux_surveil.observation", "thospi_signe_vitaux_surveil.author",'qteVomissement',

            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","tdetailtriage.Oxygene",
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
                ['thospi_signe_vitaux_surveil.deleted','NON']
            ])            
            ->orderBy("thospi_signe_vitaux_surveil.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            
            $data = DB::table('thospi_signe_vitaux_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_signe_vitaux_surveil.refSurvHospi')
            ->join('thospitalisation','thospitalisation.id','=','thospi_surveillance_hospie.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            //
            ->select("thospi_signe_vitaux_surveil.id","heure","temperatureSurv",
            "thospi_signe_vitaux_surveil.TA as TAsigneVitaux","respiration",'pulsation', 'qtepulsation','etatconscience',"refHospi",
            "mouvement","vomissement","diarhee","qteDiarhee","drainGauche","drainDroite","duirese","qteDuirese",
            "perfusion","qtePerfusion","AborVeineux","Glycemie","hemoragie","thospi_signe_vitaux_surveil.oxygene","pensement","detailPensement",
            "thospi_signe_vitaux_surveil.observation", "thospi_signe_vitaux_surveil.author",'qteVomissement',

            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","tdetailtriage.Oxygene",
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
            ->where([['thospi_signe_vitaux_surveil.deleted','NON']])             
            ->orderBy("thospi_signe_vitaux_surveil.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_signe_vitaux_surveil(Request $request,$refSurvHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

   
            $data = DB::table('thospi_signe_vitaux_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_signe_vitaux_surveil.refSurvHospi')
            ->join('thospitalisation','thospitalisation.id','=','thospi_surveillance_hospie.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            //
            ->select("thospi_signe_vitaux_surveil.id","heure","temperatureSurv",
            "thospi_signe_vitaux_surveil.TA as TAsigneVitaux","respiration",'pulsation', 'qtepulsation','etatconscience',"refHospi",
            "mouvement","vomissement","diarhee","qteDiarhee","drainGauche","drainDroite","duirese","qteDuirese",
            "perfusion","qtePerfusion","AborVeineux","Glycemie","hemoragie","thospi_signe_vitaux_surveil.oxygene","pensement","detailPensement",
            "thospi_signe_vitaux_surveil.observation", "thospi_signe_vitaux_surveil.author",'qteVomissement',

            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","tdetailtriage.Oxygene",
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
                ['refSurvHospi',$refSurvHospi]
            ])                    
            ->orderBy("thospi_signe_vitaux_surveil.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
           
            $data = DB::table('thospi_signe_vitaux_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_signe_vitaux_surveil.refSurvHospi')
            ->join('thospitalisation','thospitalisation.id','=','thospi_surveillance_hospie.refHospi')
                ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            //
            ->select("thospi_signe_vitaux_surveil.id","heure","temperatureSurv",
            "thospi_signe_vitaux_surveil.TA as TAsigneVitaux","respiration",'pulsation', 'qtepulsation','etatconscience',"refHospi",
            "mouvement","vomissement","diarhee","qteDiarhee","drainGauche","drainDroite","duirese","qteDuirese",
            "perfusion","qtePerfusion","AborVeineux","Glycemie","hemoragie","thospi_signe_vitaux_surveil.oxygene","pensement","detailPensement",
            "thospi_signe_vitaux_surveil.observation", "thospi_signe_vitaux_surveil.author",'qteVomissement',

            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","tdetailtriage.Oxygene",
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
            ->Where('refSurvHospi',$refSurvHospi)    
            ->orderBy("thospi_signe_vitaux_surveil.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    // //mes scripts
    // function fetch_quantite_disponible($refmedicament)
    // {
    //         $data=DB::table("tconf_detailmedicament")
    //         ->selectRaw('SUM(IFNULL(tconf_detailmedicament.quantite,0)) as quantiteDispo')
    //         ->where('refmedicament','=', $refmedicament)     
    //         ->get();
    
    //         return response()->json([
    //             'data'  => $data,
    //         ]);   
    // }


    function fetch_single_signe_vitaux_surveil($id)
    {


        $data = DB::table('thospi_signe_vitaux_surveil')
        ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_signe_vitaux_surveil.refSurvHospi')
        ->join('thospitalisation','thospitalisation.id','=','thospi_surveillance_hospie.refHospi')
        ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
        ->join('tlit','tlit.id','=','thospitalisation.refLit')
        ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
        //
        ->select("thospi_signe_vitaux_surveil.id","heure","temperatureSurv",
        "thospi_signe_vitaux_surveil.TA as TAsigneVitaux","respiration",'pulsation', 'qtepulsation','etatconscience',"refHospi",
        "mouvement","vomissement","diarhee","qteDiarhee","drainGauche","drainDroite","duirese","qteDuirese",
        "perfusion","qtePerfusion","AborVeineux","Glycemie","hemoragie","thospi_signe_vitaux_surveil.oxygene","pensement","detailPensement",
        "thospi_signe_vitaux_surveil.observation", "thospi_signe_vitaux_surveil.author",'qteVomissement',

        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
        "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
        "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","tdetailtriage.Oxygene",
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
        ->where('thospi_signe_vitaux_surveil.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    //,'pulsation', 'qtepulsation',etatconscience

    function insert_signe_vitaux_surveil(Request $request)
    {
       
        $data = thospi_signe_vitaux_surveil::create([
            'refSurvHospi'       =>  $request->refSurvHospi,
            'heure'    =>  $request->heure,
            'temperatureSurv'    =>  $request->temperatureSurv,
            'TA'       =>  $request->TA,
            'respiration'    =>  $request->respiration,
            'pulsation'    =>  $request->pulsation,
            'qtepulsation'    =>  $request->qtepulsation,
            'etatconscience'    =>  $request->etatconscience,
            'mouvement'    =>  $request->mouvement,
            'vomissement'       =>  $request->vomissement,
            'qteVomissement'  => $request->qteVomissement,
            'diarhee'    =>  $request->diarhee,
            'qteDiarhee'    =>  $request->qteDiarhee,
            'drainGauche'       =>  $request->drainGauche,
            'drainDroite'    =>  $request->drainDroite,
            'duirese'    =>  $request->duirese,
            'qteDuirese'       =>  $request->qteDuirese,
            'perfusion'    =>  $request->perfusion,
            'qtePerfusion'    =>  $request->qtePerfusion,
            'AborVeineux'       =>  $request->AborVeineux,
            'Glycemie'    =>  $request->Glycemie,
            'hemoragie'    =>  $request->hemoragie,
            'oxygene'       =>  $request->oxygene,
            'pensement'    =>  $request->pensement,
            'detailPensement'    =>  $request->detailPensement,
            'observation'       =>  $request->observation,
            'author'    =>  $request->author,
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_signe_vitaux_surveil(Request $request, $id)
    {
        $data = thospi_signe_vitaux_surveil::where('id', $id)->update([
            'refSurvHospi'       =>  $request->refSurvHospi,
            'heure'    =>  $request->heure,
            'temperatureSurv'    =>  $request->temperatureSurv,
            'TA'       =>  $request->TA,
            'respiration'    =>  $request->respiration,
            'pulsation'    =>  $request->pulsation,
            'qtepulsation'    =>  $request->qtepulsation,
            'etatconscience'    =>  $request->etatconscience,
            'mouvement'    =>  $request->mouvement,
            'vomissement'       =>  $request->vomissement,
            'qteVomissement'  => $request->qteVomissement,
            'diarhee'    =>  $request->diarhee,
            'qteDiarhee'    =>  $request->qteDiarhee,
            'drainGauche'       =>  $request->drainGauche,
            'drainDroite'    =>  $request->drainDroite,
            'duirese'    =>  $request->duirese,
            'qteDuirese'       =>  $request->qteDuirese,
            'perfusion'    =>  $request->perfusion,
            'qtePerfusion'    =>  $request->qtePerfusion,
            'AborVeineux'       =>  $request->AborVeineux,
            'Glycemie'    =>  $request->Glycemie,
            'hemoragie'    =>  $request->hemoragie,
            'oxygene'       =>  $request->oxygene,
            'pensement'    =>  $request->pensement,
            'detailPensement'    =>  $request->detailPensement,
            'observation'       =>  $request->observation,
            'author'    =>  $request->author,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_signe_vitaux_surveil($id)
    {
        $data = thospi_signe_vitaux_surveil::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
