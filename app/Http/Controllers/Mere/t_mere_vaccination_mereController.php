<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\t_mere_vaccination_mere;
use App\Models\Mere\t_mere_rendez_vous_vac_mere;

use App\Traits\{GlobalMethod,Slug};
use DB;


class t_mere_vaccination_mereController extends Controller
{
  
    use GlobalMethod, Slug;

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

            $data = DB::table('t_mere_vaccination_mere')
            ->join('t_mere_periode_vacciniere','t_mere_periode_vacciniere.id','=','t_mere_vaccination_mere.refPeriode')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_vaccination_mere.refCPN')
            ->join('tdetailconsultation','tdetailconsultation.id','=','t_mere_consultation_prenatale.refDetailConst')
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

            ->select("t_mere_vaccination_mere.id","date_prevue","date_recus",
            "poids_vacMere","nom_periode","dure_semsuie","refCPN","refPeriode",
            "t_mere_vaccination_mere.author",

            "rh","electropherese","date_debut",
            "personne_contact","adresse_personne_ref","date_DDr","date_DPA","primipare",
            "plus_35","tbc","hta","sca","dbt","car","mef","raa","syphylis","vIH_sida","vvS",
            "vvS","pEP","cesarienne","cerciage","cerciage","fibrame","fature_bassin",
            "gEU","fistule","uterus_cicatrice","traitement_sterilite","parite","parite",
            "gestile","EnfantEnvie","Avortement","dystocie","eutocie","plusGrosPoids",
            "plusGrosPoids","plus4kg","premature","poste_mature","mort_ne","mort_avant_7j",
            "DernierAcouchement","interval2ans","complication_post_non","compl_post_oui",
            "Si_oui_lesquelles","malnutrition","conjoctives7g","conjoctivesIcterifars",
            "TA_systolique","TA_diastolique1","TA_diastolique2","proteine","festule_reparee",
            "proteine","festule_reparee","discondance","bcf","mouvementFoctaux","pres_transversale",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             "t_mere_consultation_prenatale.author",

            "refEnteteCons","refTypeCons",
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
                ['noms', 'like', '%'.$query.'%']
            ])           
            ->orderBy("t_mere_vaccination_mere.id", "desc")          
            ->paginate(10);

            return response()->json(['data'=>$data]);
           

        }
        else{
            $data = DB::table('t_mere_vaccination_mere')
            ->join('t_mere_periode_vacciniere','t_mere_periode_vacciniere.id','=','t_mere_vaccination_mere.refPeriode')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_vaccination_mere.refCPN')
            ->join('tdetailconsultation','tdetailconsultation.id','=','t_mere_consultation_prenatale.refDetailConst')
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

            ->select("t_mere_vaccination_mere.id","date_prevue","date_recus",
            "poids_vacMere","nom_periode","dure_semsuie","refCPN","refPeriode",
            "t_mere_vaccination_mere.author",

            "rh","electropherese","date_debut",
            "personne_contact","adresse_personne_ref","date_DDr","date_DPA","primipare",
            "plus_35","tbc","hta","sca","dbt","car","mef","raa","syphylis","vIH_sida","vvS",
            "vvS","pEP","cesarienne","cerciage","cerciage","fibrame","fature_bassin",
            "gEU","fistule","uterus_cicatrice","traitement_sterilite","parite","parite",
            "gestile","EnfantEnvie","Avortement","dystocie","eutocie","plusGrosPoids",
            "plusGrosPoids","plus4kg","premature","poste_mature","mort_ne","mort_avant_7j",
            "DernierAcouchement","interval2ans","complication_post_non","compl_post_oui",
            "Si_oui_lesquelles","malnutrition","conjoctives7g","conjoctivesIcterifars",
            "TA_systolique","TA_diastolique1","TA_diastolique2","proteine","festule_reparee",
            "proteine","festule_reparee","discondance","bcf","mouvementFoctaux","pres_transversale",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             "t_mere_consultation_prenatale.author",

            "refEnteteCons","refTypeCons",
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
            ->orderBy("t_mere_vaccination_mere.id", "desc")
            ->paginate(10);
        
            return response()->json(['data'=>$data]);
        }

    }


    public function fetch_detail_entete(Request $request,$refCPN)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('t_mere_vaccination_mere')
            ->join('t_mere_periode_vacciniere','t_mere_periode_vacciniere.id','=','t_mere_vaccination_mere.refPeriode')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_vaccination_mere.refCPN')
            ->join('tdetailconsultation','tdetailconsultation.id','=','t_mere_consultation_prenatale.refDetailConst')
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

            ->select("t_mere_vaccination_mere.id","date_prevue","date_recus",
            "poids_vacMere","nom_periode","dure_semsuie","refCPN","refPeriode",
            "t_mere_vaccination_mere.author",

            "rh","electropherese","date_debut",
            "personne_contact","adresse_personne_ref","date_DDr","date_DPA","primipare",
            "plus_35","tbc","hta","sca","dbt","car","mef","raa","syphylis","vIH_sida","vvS",
            "vvS","pEP","cesarienne","cerciage","cerciage","fibrame","fature_bassin",
            "gEU","fistule","uterus_cicatrice","traitement_sterilite","parite","parite",
            "gestile","EnfantEnvie","Avortement","dystocie","eutocie","plusGrosPoids",
            "plusGrosPoids","plus4kg","premature","poste_mature","mort_ne","mort_avant_7j",
            "DernierAcouchement","interval2ans","complication_post_non","compl_post_oui",
            "Si_oui_lesquelles","malnutrition","conjoctives7g","conjoctivesIcterifars",
            "TA_systolique","TA_diastolique1","TA_diastolique2","proteine","festule_reparee",
            "proteine","festule_reparee","discondance","bcf","mouvementFoctaux","pres_transversale",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             "t_mere_consultation_prenatale.author",

            "refEnteteCons","refTypeCons",
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
                ['refCPN',$refCPN]
            ])                      
            ->orderBy("t_mere_vaccination_mere.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);         

        }
        else{
            $data = DB::table('t_mere_vaccination_mere')
            ->join('t_mere_periode_vacciniere','t_mere_periode_vacciniere.id','=','t_mere_vaccination_mere.refPeriode')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_vaccination_mere.refCPN')
            ->join('tdetailconsultation','tdetailconsultation.id','=','t_mere_consultation_prenatale.refDetailConst')
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

            ->select("t_mere_vaccination_mere.id","date_prevue","date_recus",
            "poids_vacMere","nom_periode","dure_semsuie","refCPN","refPeriode",
            "t_mere_vaccination_mere.author",

            "rh","electropherese","date_debut",
            "personne_contact","adresse_personne_ref","date_DDr","date_DPA","primipare",
            "plus_35","tbc","hta","sca","dbt","car","mef","raa","syphylis","vIH_sida","vvS",
            "vvS","pEP","cesarienne","cerciage","cerciage","fibrame","fature_bassin",
            "gEU","fistule","uterus_cicatrice","traitement_sterilite","parite","parite",
            "gestile","EnfantEnvie","Avortement","dystocie","eutocie","plusGrosPoids",
            "plusGrosPoids","plus4kg","premature","poste_mature","mort_ne","mort_avant_7j",
            "DernierAcouchement","interval2ans","complication_post_non","compl_post_oui",
            "Si_oui_lesquelles","malnutrition","conjoctives7g","conjoctivesIcterifars",
            "TA_systolique","TA_diastolique1","TA_diastolique2","proteine","festule_reparee",
            "proteine","festule_reparee","discondance","bcf","mouvementFoctaux","pres_transversale",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             "t_mere_consultation_prenatale.author",

            "refEnteteCons","refTypeCons",
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
            ->Where('refCPN',$refCPN)    
            ->orderBy("t_mere_vaccination_mere.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    } 














    function fetch_single($id)
    {
        $data = DB::table('t_mere_vaccination_mere')
        ->join('t_mere_periode_vacciniere','t_mere_periode_vacciniere.id','=','t_mere_vaccination_mere.refPeriode')
        ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_vaccination_mere.refCPN')
        ->join('tdetailconsultation','tdetailconsultation.id','=','t_mere_consultation_prenatale.refDetailConst')
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

        ->select("t_mere_vaccination_mere.id","date_prevue","date_recus",
        "poids_vacMere","nom_periode","dure_semsuie","refCPN","refPeriode",
        "t_mere_vaccination_mere.author",

        "rh","electropherese","date_debut",
        "personne_contact","adresse_personne_ref","date_DDr","date_DPA","primipare",
        "plus_35","tbc","hta","sca","dbt","car","mef","raa","syphylis","vIH_sida","vvS",
        "vvS","pEP","cesarienne","cerciage","cerciage","fibrame","fature_bassin",
        "gEU","fistule","uterus_cicatrice","traitement_sterilite","parite","parite",
        "gestile","EnfantEnvie","Avortement","dystocie","eutocie","plusGrosPoids",
        "plusGrosPoids","plus4kg","premature","poste_mature","mort_ne","mort_avant_7j",
        "DernierAcouchement","interval2ans","complication_post_non","compl_post_oui",
        "Si_oui_lesquelles","malnutrition","conjoctives7g","conjoctivesIcterifars",
        "TA_systolique","TA_diastolique1","TA_diastolique2","proteine","festule_reparee",
        "proteine","festule_reparee","discondance","bcf","mouvementFoctaux","pres_transversale",
        "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
        "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
        "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
         "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
         "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
         "resultat_test2","date_annonce2"  ,"plau_accouchement",
         "t_mere_consultation_prenatale.author",

        "refEnteteCons","refTypeCons",
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
        ->where('t_mere_vaccination_mere.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //id,refCPN,refPeriode,date_prevue,date_recus,poids_vacMere,author

 function insertData(Request $request)
 {
        $data= t_mere_vaccination_mere::create([
            'refCPN'=>$request->refCPN,
            'refPeriode'=>$request->refPeriode,
            'date_prevue'=>$request->date_prevue,
            'date_recus'=>$request->date_recus,
            'poids_vacMere'=>$request->poids_vacMere,            
            'author'=>$request->author       
         ]);

        $data = t_mere_rendez_vous_vac_mere::where([
            ['refCPN', $request->refCPN],
            ['refPeriode', $request->refPeriode]
        ])->update([
            'etatRdv'=>1,
            'author'=>$request->author
        ]);

         return response()->json(['data'=>$data]);
 }
     

 

 function updateData(Request $request)
 {
        $data= t_mere_vaccination_mere::where('id',$request->id)->update([
            'refCPN'=>$request->refCPN,
            'refPeriode'=>$request->refPeriode,
            'date_prevue'=>$request->date_prevue,
            'date_recus'=>$request->date_recus,
            'poids_vacMere'=>$request->poids_vacMere,            
            'author'=>$request->author    
         ]);
         return response()->json(['data'=>$data]);
     
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
 public function destroy(Request $request)
 {
    $data = t_mere_rendez_vous_vac_mere::where([
        ['refCPN', $request->refCPN],
        ['refPeriode', $request->refPeriode]
    ])->update([
        'etatRdv'=>0
    ]);
     $data = t_mere_vaccination_mere::where('id', $request->id)->delete();

    

     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }


}
