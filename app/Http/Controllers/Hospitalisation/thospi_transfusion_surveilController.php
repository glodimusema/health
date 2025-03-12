<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_transfusion_surveil;
use DB;

class thospi_transfusion_surveilController extends Controller
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

            $data = DB::table('thospi_transfusion_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_transfusion_surveil.refSurvHospi')
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
            ->select("thospi_transfusion_surveil.id","medecinAssistant","dateTransfusion","heureDebut","heureFin","status","Nmpoche",
            "dateperemption","medecinDemandeur","nombre","reatianTransttut",'tachycardie','paleurcutaneo',
            'extremitesfoides',"dysphee1","ExtrenateCyanosee","TA_transf","agitation",
            "autres1","indicationTransf","Hb_avant","hct_apres","qteSangTransfuse","nature","hbTransfusion","compatible",
            "temperatureSurv","FRtraitSurv","FCtraitSurv","TAtraitSurv","autres2","rashCutane","frisson","troubleRythme",
            "troubleRythme","nausee","temperature2","TA2","FR2","oedemelaynge1","diarhee","oedemelaynge2","dysphee2",
            "precardialge","lambelgue","TA_15a30","temperature_15a30","pauls_15a30","fr_15a30","autres3","observation2","ta_30a1_heure",
            "tempera_30a1_heure","pauls_30a1heure","fr_30a1heure","autres4","observation3","TA_2ha3h","temperature_2ha3h","pauls_2ha3h",
            "fr_2ha3h","observation3","autres5","observationsGenol",'pouls_0a15min',"thospi_transfusion_surveil.author",
            "hct_transfusion","hct_avant","douleurabdominal",'TA_1a2h','Pouls_1a2h','Temperature_1a2h',
            'FR_1a2h','autres_1a2h','observations_1a2h','autres_2ha3h','Hb_apres',
            //--------------------------------------------------------

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
                ['thospi_transfusion_surveil.deleted','NON']
            ])            
            ->orderBy("thospi_transfusion_surveil.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            
            $data = DB::table('thospi_transfusion_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_transfusion_surveil.refSurvHospi')
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
            ->select("thospi_transfusion_surveil.id","medecinAssistant","dateTransfusion","heureDebut","heureFin","status","Nmpoche",
            "dateperemption","medecinDemandeur","nombre","reatianTransttut",'tachycardie','paleurcutaneo','extremitesfoides',"dysphee1","ExtrenateCyanosee","TA_transf","agitation",
            "autres1","indicationTransf","Hb_avant","hct_apres","qteSangTransfuse","nature","hbTransfusion","compatible",
            "temperatureSurv","FRtraitSurv","FCtraitSurv","TAtraitSurv","autres2","rashCutane","frisson","troubleRythme",
            "troubleRythme","nausee","temperature2","TA2","FR2","oedemelaynge1","diarhee","oedemelaynge2","dysphee2",
            "precardialge","lambelgue","TA_15a30","temperature_15a30","pauls_15a30","fr_15a30","autres3","observation1","ta_30a1_heure",
            "tempera_30a1_heure","pauls_30a1heure","fr_30a1heure","autres4","observation2","TA_2ha3h","temperature_2ha3h","pauls_2ha3h",
            "fr_2ha3h","observation3","autres5","observationsGenol",'pouls_0a15min','TA_1a2h',
            'Pouls_1a2h','Temperature_1a2h','autres_2ha3h',
            'FR_1a2h','autres_1a2h','observations_1a2h','Hb_apres',
            "thospi_transfusion_surveil.author","hct_transfusion","hct_avant","douleurabdominal",
            //--------------------------------------------------------

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
               ['thospi_transfusion_surveil.deleted','NON']
            ])           
            ->orderBy("thospi_transfusion_surveil.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_transfusion_surveil(Request $request,$refSurvHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

   
            $data = DB::table('thospi_transfusion_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_transfusion_surveil.refSurvHospi')
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
            ->select("thospi_transfusion_surveil.id","medecinAssistant","dateTransfusion","heureDebut","heureFin","status","Nmpoche",
            "dateperemption","medecinDemandeur","nombre","reatianTransttut",'tachycardie','paleurcutaneo','extremitesfoides',"dysphee1","ExtrenateCyanosee","TA_transf","agitation",
            "autres1","indicationTransf","Hb_avant","hct_apres","qteSangTransfuse","nature","hbTransfusion","compatible",
            "temperatureSurv","FRtraitSurv","FCtraitSurv","TAtraitSurv","autres2","rashCutane","frisson","troubleRythme",
            "troubleRythme","nausee","temperature2","TA2","FR2","oedemelaynge1","diarhee","oedemelaynge2","dysphee2",
            "precardialge","lambelgue","TA_15a30","temperature_15a30","pauls_15a30","fr_15a30","autres3","observation1","ta_30a1_heure",
            "tempera_30a1_heure","pauls_30a1heure","fr_30a1heure","autres4","observation2","TA_2ha3h","temperature_2ha3h","pauls_2ha3h",
            "fr_2ha3h","observation3","autres5","observationsGenol",'TA_1a2h','Pouls_1a2h','Temperature_1a2h',
            'FR_1a2h','autres_1a2h','observations_1a2h','pouls_0a15min','autres_2ha3h','Hb_apres',
            "thospi_transfusion_surveil.author","hct_transfusion","hct_avant","douleurabdominal",
            //--------------------------------------------------------

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
                ['refSurvHospi',$refSurvHospi],
                ['thospi_transfusion_surveil.deleted','NON']
            ])                    
            ->orderBy("thospi_transfusion_surveil.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
           
            $data = DB::table('thospi_transfusion_surveil')
            ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_transfusion_surveil.refSurvHospi')
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
            ->select("thospi_transfusion_surveil.id","medecinAssistant","dateTransfusion","heureDebut","heureFin","status","Nmpoche",
            "dateperemption","medecinDemandeur","nombre","reatianTransttut",'tachycardie','paleurcutaneo','extremitesfoides',"dysphee1","ExtrenateCyanosee","TA_transf","agitation",
            "autres1","indicationTransf","Hb_avant","hct_apres","qteSangTransfuse","nature","hbTransfusion","compatible",
            "temperatureSurv","FRtraitSurv","FCtraitSurv","TAtraitSurv","autres2","rashCutane","frisson","troubleRythme",
            "troubleRythme","nausee","temperature2","TA2","FR2","oedemelaynge1","diarhee","oedemelaynge2","dysphee2",
            "precardialge","lambelgue","TA_15a30","temperature_15a30","pauls_15a30","fr_15a30","autres3","observation1","ta_30a1_heure",
            "tempera_30a1_heure","pauls_30a1heure","fr_30a1heure","autres4","observation2","TA_2ha3h","temperature_2ha3h","pauls_2ha3h",
            "fr_2ha3h","observation3","autres5","observationsGenol",'TA_1a2h','Pouls_1a2h','Temperature_1a2h','FR_1a2h',
            'autres_1a2h','observations_1a2h','pouls_0a15min','autres_2ha3h','Hb_apres',
            "thospi_transfusion_surveil.author","hct_transfusion","hct_avant","douleurabdominal",
            //--------------------------------------------------------

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
                ['refSurvHospi',$refSurvHospi],
                ['thospi_transfusion_surveil.deleted','NON']
            ])    
            ->orderBy("thospi_transfusion_surveil.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    
    function fetch_single_transfusion_surveil($id)
    {

        $data = DB::table('thospi_transfusion_surveil')
        ->join('thospi_surveillance_hospie','thospi_surveillance_hospie.id','=','thospi_transfusion_surveil.refSurvHospi')
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
        ->select("thospi_transfusion_surveil.id","medecinAssistant","dateTransfusion","heureDebut","heureFin","status","Nmpoche",
        "dateperemption","medecinDemandeur","nombre","reatianTransttut",'tachycardie','paleurcutaneo',
        'extremitesfoides',"dysphee1","ExtrenateCyanosee","TA_transf","agitation",
        "autres1","indicationTransf","Hb_avant","hct_apres","qteSangTransfuse","nature","hbTransfusion","compatible",
        "temperatureSurv","FRtraitSurv","FCtraitSurv","TAtraitSurv","autres2","rashCutane","frisson","troubleRythme",
        "troubleRythme","nausee","temperature2","TA2","FR2","oedemelaynge1","diarhee","oedemelaynge2","dysphee2",
        "precardialge","lambelgue","TA_15a30","temperature_15a30","pauls_15a30","fr_15a30","autres3","observation1","ta_30a1_heure",
        "tempera_30a1_heure","pauls_30a1heure","fr_30a1heure","autres4","observation2","TA_2ha3h","temperature_2ha3h","pauls_2ha3h",
        "fr_2ha3h","observation3","autres5","observationsGenol","thospi_transfusion_surveil.author",
        "hct_transfusion","hct_avant",'pouls_0a15min',"douleurabdominal",'TA_1a2h','Pouls_1a2h','autres_2ha3h',
        'Temperature_1a2h','FR_1a2h','autres_1a2h','observations_1a2h','Hb_apres',
        //--------------------------------------------------------

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
        ->where('thospi_transfusion_surveil.id', $id)
                ->get();

                return response()->json([
                'data' => $data,
                ]);
    }

    function insert_transfusion_surveil(Request $request)
    {
      
        $data = thospi_transfusion_surveil::create([
            'refSurvHospi'       =>  $request->refSurvHospi,
            'dateTransfusion'    =>  $request->dateTransfusion,
            'heureDebut'    =>  $request->heureDebut,
            'heureFin'       =>  $request->heureFin,
            'status'    =>  'Attente',
            'Nmpoche'    =>  $request->Nmpoche,
            'dateperemption'       =>  $request->dateperemption,
            'medecinDemandeur'    =>  $request->medecinDemandeur,
            'nombre'    =>  $request->nombre,
            'reatianTransttut'       =>  $request->reatianTransttut,
            'dysphee1'    =>  $request->dysphee1,
            'ExtrenateCyanosee'    =>  $request->ExtrenateCyanosee,
            'tachycardie'    =>  $request->tachycardie,
            'paleurcutaneo'    =>  $request->paleurcutaneo,
            'extremitesfoides'    =>  $request->extremitesfoides,
            // 'TA_transf'       =>  $request->TA_transf,
            'agitation'    =>  $request->agitation,
            'autres1'    =>  $request->autres1,
            'indicationTransf'       =>  $request->indicationTransf,
            'Hb_avant'    =>  $request->Hb_avant,
            'hct_avant'    =>  $request->hct_avant,
            'Hb_apres'    =>  $request->Hb_apres,
            'hct_apres'       =>  $request->hct_apres,
            'qteSangTransfuse'    =>  $request->qteSangTransfuse,
            'nature'    =>  $request->nature,
            'hbTransfusion'       =>  $request->hbTransfusion,
            'hct_transfusion'  =>  $request->hbTransfusion,
            'compatible'    =>  $request->compatible,
            'temperatureSurv'       =>  $request->temperatureSurv,
            'FRtraitSurv'    =>  $request->FRtraitSurv,
            'FCtraitSurv'    =>  $request->FCtraitSurv,
            'TAtraitSurv'       =>  $request->TAtraitSurv,
            'autres2'    =>  $request->autres2,
            'rashCutane'    =>  $request->rashCutane,
            'frisson'       =>  $request->frisson,
            'troubleRythme'    =>  $request->troubleRythme,
            'nausee'    =>  $request->nausee,
            'temperature2'       =>  $request->temperature2,
            'TA2'    =>  $request->TA2,
            'TA2'       =>  $request->TA2,
            'FR2'    =>  $request->FR2,
            'oedemelaynge1'    =>  $request->oedemelaynge1,
            'diarhee'       =>  $request->diarhee,
            'pouls_0a15min' =>  $request->pouls_0a15min,
            'oedemelaynge2'    =>  $request->oedemelaynge2,
            'dysphee2'    =>  $request->dysphee2,
            'precardialge'       =>  $request->precardialge,
            'lambelgue'    =>  $request->lambelgue,
            'douleurabdominal'    =>  $request->douleurabdominal,
            'TA_15a30'    =>  $request->TA_15a30,
            'temperature_15a30'       =>  $request->temperature_15a30,
            'pauls_15a30'    =>  $request->pauls_15a30,
            'fr_15a30'       =>  $request->fr_15a30,
            'autres3'    =>  $request->autres3,
            'observation1'    =>  $request->observation1,
            'ta_30a1_heure'       =>  $request->ta_30a1_heure,
            'tempera_30a1_heure'    =>  $request->tempera_30a1_heure,
            'pauls_30a1heure'    =>  $request->pauls_30a1heure,
            'fr_30a1heure'       =>  $request->fr_30a1heure,
            'autres4'    =>  $request->autres4,
            'observation2'    =>  $request->observation2,
            'autres_2ha3h' => $request->autres_2ha3h,
             'TA_1a2h'       =>  $request->TA_1a2h,
             'Pouls_1a2h'       =>  $request->Pouls_1a2h,
             'Temperature_1a2h'       =>  $request->Temperature_1a2h,
             'FR_1a2h'       =>  $request->FR_1a2h,
             'autres_1a2h'       =>  $request->autres_1a2h,
             'observations_1a2h'       =>  $request->observations_1a2h,
            'TA_2ha3h'       =>  $request->TA_2ha3h,
            'temperature_2ha3h'    =>  $request->temperature_2ha3h,
            'temperature_2ha3h'    =>  $request->temperature_2ha3h,
            'pauls_2ha3h'       =>  $request->pauls_2ha3h,
            'fr_2ha3h'    =>  $request->fr_2ha3h,
            'observation3'    =>  $request->observation3,
            'autres5'       =>  $request->autres5,
            // 'observationsGenol'    =>  $request->observationsGenol,
            'author'    =>  $request->author 
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_transfusion_surveil(Request $request, $id)
    {
        $data = thospi_transfusion_surveil::where('id', $id)->update([
            'refSurvHospi'       =>  $request->refSurvHospi,
            'dateTransfusion'    =>  $request->dateTransfusion,
            'heureDebut'    =>  $request->heureDebut,
            'heureFin'       =>  $request->heureFin,
            'status'    =>  'Attente',
            'Nmpoche'    =>  $request->Nmpoche,
            'dateperemption'       =>  $request->dateperemption,
            'medecinDemandeur'    =>  $request->medecinDemandeur,
            'nombre'    =>  $request->nombre,
            'reatianTransttut'       =>  $request->reatianTransttut,
            'dysphee1'    =>  $request->dysphee1,
            'ExtrenateCyanosee'    =>  $request->ExtrenateCyanosee,
            'tachycardie'    =>  $request->tachycardie,
            'paleurcutaneo'    =>  $request->paleurcutaneo,
            'extremitesfoides'    =>  $request->extremitesfoides,
            // 'TA_transf'       =>  $request->TA_transf,
            'agitation'    =>  $request->agitation,
            'autres1'    =>  $request->autres1,
            'indicationTransf'       =>  $request->indicationTransf,
            'Hb_avant'    =>  $request->Hb_avant,
            'hct_avant'    =>  $request->hct_avant,
            'Hb_apres'    =>  $request->Hb_apres,
            'hct_apres'       =>  $request->hct_apres,
            'qteSangTransfuse'    =>  $request->qteSangTransfuse,
            'nature'    =>  $request->nature,
            'hbTransfusion'       =>  $request->hbTransfusion,
            'hct_transfusion'  =>  $request->hbTransfusion,
            'compatible'    =>  $request->compatible,
            'temperatureSurv'       =>  $request->temperatureSurv,
            'FRtraitSurv'    =>  $request->FRtraitSurv,
            'FCtraitSurv'    =>  $request->FCtraitSurv,
            'TAtraitSurv'       =>  $request->TAtraitSurv,
            'autres2'    =>  $request->autres2,
            'rashCutane'    =>  $request->rashCutane,
            'frisson'       =>  $request->frisson,
            'troubleRythme'    =>  $request->troubleRythme,
            'nausee'    =>  $request->nausee,
            'temperature2'       =>  $request->temperature2,
            'TA2'    =>  $request->TA2,
            'TA2'       =>  $request->TA2,
            'FR2'    =>  $request->FR2,
            'oedemelaynge1'    =>  $request->oedemelaynge1,
            'diarhee'       =>  $request->diarhee,
            'pouls_0a15min' =>  $request->pouls_0a15min,
            'oedemelaynge2'    =>  $request->oedemelaynge2,
            'dysphee2'    =>  $request->dysphee2,
            'precardialge'       =>  $request->precardialge,
            'lambelgue'    =>  $request->lambelgue,
            'douleurabdominal'    =>  $request->douleurabdominal,
            'TA_15a30'    =>  $request->TA_15a30,
            'temperature_15a30'       =>  $request->temperature_15a30,
            'pauls_15a30'    =>  $request->pauls_15a30,
            'fr_15a30'       =>  $request->fr_15a30,
            'autres3'    =>  $request->autres3,
            'observation1'    =>  $request->observation1,
            'ta_30a1_heure'       =>  $request->ta_30a1_heure,
            'tempera_30a1_heure'    =>  $request->tempera_30a1_heure,
            'pauls_30a1heure'    =>  $request->pauls_30a1heure,
            'fr_30a1heure'       =>  $request->fr_30a1heure,
            'autres4'    =>  $request->autres4,
            'observation2'    =>  $request->observation2,
            'TA_1a2h'       =>  $request->TA_1a2h,
            'Pouls_1a2h'       =>  $request->Pouls_1a2h,
            'Temperature_1a2h'       =>  $request->Temperature_1a2h,
            'FR_1a2h'       =>  $request->FR_1a2h,
            'autres_1a2h'       =>  $request->autres_1a2h,
            'observations_1a2h'       =>  $request->observations_1a2h,
            'TA_2ha3h'       =>  $request->TA_2ha3h,
            'temperature_2ha3h'    =>  $request->temperature_2ha3h,
            'temperature_2ha3h'    =>  $request->temperature_2ha3h,
            'pauls_2ha3h'       =>  $request->pauls_2ha3h,
            'autres_2ha3h' => $request->autres_2ha3h,
            'fr_2ha3h'    =>  $request->fr_2ha3h,
            'observation3'    =>  $request->observation3,
            'autres5'       =>  $request->autres5,
            // 'observationsGenol'    =>  $request->observationsGenol,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_transfusion_surveil($id)
    {
        $data = thospi_transfusion_surveil::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
