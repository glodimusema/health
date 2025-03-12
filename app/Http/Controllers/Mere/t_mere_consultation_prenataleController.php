<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\t_mere_consultation_prenatale;
use App\Models\Mere\t_mere_rendez_vous_vac_mere;
use App\Traits\{GlobalMethod,Slug};
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

//t_mere_rendez_vous_vac_mere
class t_mere_consultation_prenataleController extends Controller
{
  
    use GlobalMethod, Slug;

    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
              
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('t_mere_consultation_prenatale')
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
           
            ->select("t_mere_consultation_prenatale.id","rh","electropherese","date_debut",
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
             "resultat_test2","date_annonce2","goitre","donner_MII","plau_accouchement",
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
                ['tmouvement.Statut','Encours'],          
                ['t_mere_consultation_prenatale.deleted','NON']
            ])            
            ->orderBy("t_mere_consultation_prenatale.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('t_mere_consultation_prenatale')
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
           
            ->select("t_mere_consultation_prenatale.id","rh","electropherese","date_debut",
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
             "resultat_test2","date_annonce2","goitre","donner_MII","plau_accouchement",
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
                ['tmouvement.Statut','Encours'],          
                ['t_mere_consultation_prenatale.deleted','NON']
            ])    
            ->orderBy("t_mere_consultation_prenatale.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

        

    }


    public function fetch_CPN_for_cons(Request $request,$refDetailConst)
    {   
       

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('t_mere_consultation_prenatale')
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
           
            ->select("t_mere_consultation_prenatale.id","rh","electropherese","date_debut",
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
             "resultat_test2","date_annonce2","goitre","donner_MII","plau_accouchement",
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
                ['refDetailConst',$refDetailConst],              
                ['tmouvement.Statut','Encours'],          
                ['t_mere_consultation_prenatale.deleted','NON']
            ])            
            ->orderBy("t_mere_consultation_prenatale.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('t_mere_consultation_prenatale')
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
           
            ->select("t_mere_consultation_prenatale.id","rh","electropherese","date_debut",
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
             "resultat_test2","date_annonce2","goitre","donner_MII","plau_accouchement",
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
                ['refDetailConst',$refDetailConst],              
                ['tmouvement.Statut','Encours'],          
                ['t_mere_consultation_prenatale.deleted','NON']
            ])   
            ->orderBy("t_mere_consultation_prenatale.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    





    function fetch_single_CPN($id)
    {
        $data = DB::table('t_mere_consultation_prenatale')
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
       

        ->select("t_mere_consultation_prenatale.id","rh","electropherese","date_debut",
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
         "resultat_test2","date_annonce2","goitre","donner_MII","plau_accouchement",
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
        ->where('t_mere_consultation_prenatale.id', $id)
        ->get();

        return response()->json([
            'data'=> $data
        ]);
    }

    //goitre,donner_MII  : partenaire_date2,resultat_test3,date_annonce

 function insertData(Request $request)
 {

        $data= t_mere_consultation_prenatale::create([
            'refDetailConst'=>$request->refDetailConst,
            'rh'=>$request->rh,
            'electropherese'=>$request->electropherese,
            'date_debut'=>$request->date_debut,
            'personne_contact'=>$request->personne_contact,
            'adresse_personne_ref'=>$request->adresse_personne_ref,
            'date_DDr'=>$request->date_DDr,
            'date_DPA'=>$request->date_DPA,
            'primipare'=>$request->primipare,
            'plus_35'=>$request->plus_35,
            'tbc'=>$request->tbc,
            'hta'=>$request->hta,
            'sca'=>$request->sca,
            'dbt'=>$request->dbt,
            'car'=>$request->car,
            'mef'=>$request->mef,
            'raa'=>$request->raa,
            'syphylis'=>$request->syphylis,
            'vIH_sida'=>$request->vIH_sida,
            'vvS'=>$request->vvS,
            'pEP'=>$request->pEP,
            'cesarienne'=>$request->cesarienne,
            'cerciage'=>$request->cerciage,
            'fibrame'=>$request->fibrame,
            'fature_bassin'=>$request->fature_bassin,
            'gEU'=>$request->gEU,
            'fistule'=>$request->fistule,
            'uterus_cicatrice'=>$request->uterus_cicatrice,
            'traitement_sterilite'=>$request->traitement_sterilite,
            'parite'=>$request->parite,
            'gestile'=>$request->gestile,
            'EnfantEnvie'=>$request->EnfantEnvie,
            'Avortement'=>$request->Avortement,
            'dystocie'=>$request->dystocie,
            'eutocie'=>$request->eutocie,
            'plusGrosPoids'=>$request->plusGrosPoids,
            'plus4kg'=>$request->plus4kg,
            'premature'=>$request->premature,
            'poste_mature'=>$request->poste_mature,
            'mort_ne'=>$request->mort_ne,
            'mort_avant_7j'=>$request->mort_avant_7j,
            'DernierAcouchement'=>$request->DernierAcouchement,
            'interval2ans'=>$request->interval2ans,
            'complication_post_non'=>$request->complication_post_non,
            'compl_post_oui'=>$request->compl_post_oui,
            'Si_oui_lesquelles'=>$request->Si_oui_lesquelles,
            'malnutrition'=>$request->malnutrition,
            'goitre'=>$request->goitre,
            'conjoctives7g'=>$request->conjoctives7g,
            'conjoctivesIcterifars'=>$request->conjoctivesIcterifars,
            'TA_systolique'=>$request->TA_systolique,
            'TA_diastolique1'=>$request->TA_diastolique1,
            'TA_diastolique2'=>$request->TA_diastolique2,
            'proteine'=>$request->proteine,
            'festule_reparee'=>$request->festule_reparee,
            'discondance'=>$request->discondance,
            'bcf'=>$request->bcf,
            'mouvementFoctaux'=>$request->mouvementFoctaux,
            'pres_transversale'=>$request->pres_transversale,
            'bassin_aetreci'=>$request->bassin_aetreci,
            'bassin_limite'=>$request->bassin_limite,
            'anomalie'=>$request->anomalie,
            'uterus_cicotricile'=>$request->uterus_cicotricile,
            'masse_supecte'=>$request->masse_supecte,
            'maladie_chronique'=>$request->maladie_chronique,
            'drepanocytose'=>$request->drepanocytose,
            'Autres_raisons'=>$request->Autres_raisons,
            'date_references'=>$request->date_references,
            'date_du_debutCTX'=>$request->date_du_debutCTX,
            'aZT'=>$request->aZT,
            'tAR'=>$request->tAR,
            'cd4'=>$request->cd4,
            'dors_mil_oui'=>$request->dors_mil_oui,
            'donner_MII'=>$request->donner_MII,
            'fer_acide'=>$request->fer_acide,
            'apres_Accouchement'=>$request->apres_Accouchement,
            'vermifuge'=>$request->vermifuge,
            'Rpr'=>$request->Rpr,
            'rPR_positif_oui'=>$request->rPR_positif_oui,
            'depistage_cancer'=>$request->depistage_cancer,
            'depistage_TBc'=>$request->depistage_TBc,
            'conseilsPF'=>$request->conseilsPF,
            'methodePFchoisie'=>$request->methodePFchoisie,
            'dCIP'=>$request->dCIP,
            'pTME'=>$request->pTME,
            'resultat_test1'=>$request->resultat_test1,
            'date_annonce1'=>$request->date_annonce1,
            'partenaire_date1'=>$request->partenaire_date1,
            'resultat_test2'=>$request->resultat_test2,
            'date_annonce2'=>$request->date_annonce2,
            'plau_accouchement'=>$request->plau_accouchement,
            'author'=>$request->author       
         ]);

         $idEnteteCons=0;

         $consList = DB::table('tdetailconsultation')
         ->select("tdetailconsultation.id","refEnteteCons")
         ->where([
             ['tdetailconsultation.id',$request->refDetailConst]
         ])
         ->get();
         foreach ($consList as $liste_mvt) {
             $idEnteteCons= $liste_mvt->refEnteteCons;
         }
         $data = tenteteconsulter::where('id', $idEnteteCons)->update([
             'parcours'    => 'Hospitalisation' 
         ]);


         $idmax=0;
         $listmax = DB::table('t_mere_consultation_prenatale')            
         ->selectRaw('MAX(t_mere_consultation_prenatale.id) as id_entete')
         ->where('t_mere_consultation_prenatale.refDetailConst', $request->refDetailConst)
         ->get();
         foreach ($listmax as $listm) {
             $idmax= $listm->id_entete;
         }      
 
         $compteur = 0;
         $etatrdv = 0;
         $idPeriode = 0;
         $duree=0;
         $daterdv='';
         $periodeList = DB::table("t_mere_periode_vacciniere")
         ->select("t_mere_periode_vacciniere.id", "t_mere_periode_vacciniere.nom_periode",
         "dure_semsuie","t_mere_periode_vacciniere.created_at")
         ->get();
         foreach ($periodeList as $list) {
             $compteur= $compteur+1;
             $idPeriode= $list->id;
             $duree = $list->dure_semsuie;
             $idEnteteVac=0;
             
             $data22 = DB::table('t_mere_consultation_prenatale')             
             ->select("t_mere_consultation_prenatale.id")
             ->selectRaw('(ADDDATE(date_DDr, INTERVAL '.$duree.' WEEK)) as daterendezvous')
             ->where('t_mere_consultation_prenatale.id', $idmax)
             ->get();
             foreach ($data22 as $list22) {
                 $daterdv= $list22->daterendezvous;
                 $idEnteteVac= $list22->id;
             }
 
 
             $data44 = t_mere_rendez_vous_vac_mere::create([
                'refCPN'=>$idEnteteVac,
                'refPeriode'=>$idPeriode,
                'date_RDV'=>$daterdv,
                'etatRdv'=>0,
                'compteurRDV'=>$compteur,          
                'author'=>$request->author
             ]);
 
         }

         return response()->json([
            'data'=> 'Insertion reussie avec Succès!!!'
        ]);
     }
     

 

 function updateData(Request $request,$id)
 {

      
        $data= t_mere_consultation_prenatale::where('id',$request->id)->update([

            'refDetailConst'=>$request->refDetailConst,
            'rh'=>$request->rh,
            'electropherese'=>$request->electropherese,
            'date_debut'=>$request->date_debut,
            'personne_contact'=>$request->personne_contact,
            'adresse_personne_ref'=>$request->adresse_personne_ref,
            'date_DDr'=>$request->date_DDr,
            'date_DPA'=>$request->date_DPA,
            'primipare'=>$request->primipare,
            'plus_35'=>$request->plus_35,
            'tbc'=>$request->tbc,
            'hta'=>$request->hta,
            'sca'=>$request->sca,
            'dbt'=>$request->dbt,
            'car'=>$request->car,
            'mef'=>$request->mef,
            'raa'=>$request->raa,
            'syphylis'=>$request->syphylis,
            'vIH_sida'=>$request->vIH_sida,
            'vvS'=>$request->vvS,
            'pEP'=>$request->pEP,
            'cesarienne'=>$request->cesarienne,
            'cerciage'=>$request->cerciage,
            'fibrame'=>$request->fibrame,
            'fature_bassin'=>$request->fature_bassin,
            'gEU'=>$request->gEU,
            'fistule'=>$request->fistule,
            'uterus_cicatrice'=>$request->uterus_cicatrice,
            'traitement_sterilite'=>$request->traitement_sterilite,
            'parite'=>$request->parite,
            'gestile'=>$request->gestile,
            'EnfantEnvie'=>$request->EnfantEnvie,
            'Avortement'=>$request->Avortement,
            'dystocie'=>$request->dystocie,
            'eutocie'=>$request->eutocie,
            'plusGrosPoids'=>$request->plusGrosPoids,
            'plus4kg'=>$request->plus4kg,
            'premature'=>$request->premature,
            'poste_mature'=>$request->poste_mature,
            'mort_ne'=>$request->mort_ne,
            'mort_avant_7j'=>$request->mort_avant_7j,
            'DernierAcouchement'=>$request->DernierAcouchement,
            'interval2ans'=>$request->interval2ans,
            'complication_post_non'=>$request->complication_post_non,
            'compl_post_oui'=>$request->compl_post_oui,
            'Si_oui_lesquelles'=>$request->Si_oui_lesquelles,
            'malnutrition'=>$request->malnutrition,
            'goitre'=>$request->goitre,
            'conjoctives7g'=>$request->conjoctives7g,
            'conjoctivesIcterifars'=>$request->conjoctivesIcterifars,
            'TA_systolique'=>$request->TA_systolique,
            'TA_diastolique1'=>$request->TA_diastolique1,
            'TA_diastolique2'=>$request->TA_diastolique2,
            'proteine'=>$request->proteine,
            'festule_reparee'=>$request->festule_reparee,
            'discondance'=>$request->discondance,
            'bcf'=>$request->bcf,
            'mouvementFoctaux'=>$request->mouvementFoctaux,
            'pres_transversale'=>$request->pres_transversale,
            'bassin_aetreci'=>$request->bassin_aetreci,
            'bassin_limite'=>$request->bassin_limite,
            'anomalie'=>$request->anomalie,
            'uterus_cicotricile'=>$request->uterus_cicotricile,
            'masse_supecte'=>$request->masse_supecte,
            'maladie_chronique'=>$request->maladie_chronique,
            'drepanocytose'=>$request->drepanocytose,
            'Autres_raisons'=>$request->Autres_raisons,
            'date_references'=>$request->date_references,
            'date_du_debutCTX'=>$request->date_du_debutCTX,
            'aZT'=>$request->aZT,
            'tAR'=>$request->tAR,
            'cd4'=>$request->cd4,
            'dors_mil_oui'=>$request->dors_mil_oui,
            'donner_MII'=>$request->donner_MII,
            'fer_acide'=>$request->fer_acide,
            'apres_Accouchement'=>$request->apres_Accouchement,
            'vermifuge'=>$request->vermifuge,
            'Rpr'=>$request->Rpr,
            'rPR_positif_oui'=>$request->rPR_positif_oui,
            'depistage_cancer'=>$request->depistage_cancer,
            'depistage_TBc'=>$request->depistage_TBc,
            'conseilsPF'=>$request->conseilsPF,
            'methodePFchoisie'=>$request->methodePFchoisie,
            'dCIP'=>$request->dCIP,
            'pTME'=>$request->pTME,
            'resultat_test1'=>$request->resultat_test1,
            'date_annonce1'=>$request->date_annonce1,
            'partenaire_date1'=>$request->partenaire_date1,
            'resultat_test2'=>$request->resultat_test2,
            'date_annonce2'=>$request->date_annonce2,
            'plau_accouchement'=>$request->plau_accouchement,
            'author'=>$request->author       
         ]);

         return response()->json([
            'data'=> 'Modification reussie avec Succès!!!'
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
     $data = t_mere_rendez_vous_vac_mere::where('refCPN', $id)->delete();
     $data = t_mere_consultation_prenatale::where('id', $id)->delete();
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }


}
