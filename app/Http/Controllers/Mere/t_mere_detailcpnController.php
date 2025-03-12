<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\t_mere_detailcpn;
use App\Traits\{GlobalMethod,Slug};
use DB;


class t_mere_detailcpnController extends Controller
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

            $data = DB::table('t_mere_detailcpn')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_detailcpn.refCPN')
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

            ->select("t_mere_detailcpn.id","refCPN","typeCPN","date_visite","plaintes_notes","depistage","peauSeche","etatGenerale",
            "poids_detailCPN","bP","presence_cecite","presence_goittre","plaintes_fievre",
            "temps_valeur","duirese_oui_non","pertes_liquidiennes","ta_detailCPN","proteine_DetCPN",
            "oedemes_detCPN","coloration_conjonctive","paules_valeurs","etatSein_normal","presence_masse","ago_grossesse",
            "mouvement_foetus","hauteur_uterine_detCPN","t_mere_detailcpn.BCF","presentationFoetus_detCPN",
            "t_mere_detailcpn.pres_transversale",
            "Bclampsie","signes_symptomes","Etat_col_detCPN","conduite_DetCpn","t_mere_detailcpn.author",

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
            "proteine","festule_reparee","discondance","t_mere_consultation_prenatale.bcf","mouvementFoctaux",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             
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
                ['t_mere_detailcpn.deleted','NON']
            ])           
            ->orderBy("t_mere_detailcpn.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=> $data
            ]);
           

        }
        else{
        
            $data = DB::table('t_mere_detailcpn')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_detailcpn.refCPN')
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

            ->select("t_mere_detailcpn.id","refCPN","typeCPN","date_visite","plaintes_notes","depistage","peauSeche","etatGenerale",
            "poids_detailCPN","bP","presence_cecite","presence_goittre","plaintes_fievre",
            "temps_valeur","duirese_oui_non","pertes_liquidiennes","ta_detailCPN","proteine_DetCPN",
            "oedemes_detCPN","coloration_conjonctive","paules_valeurs","etatSein_normal","presence_masse","ago_grossesse",
            "mouvement_foetus","hauteur_uterine_detCPN","t_mere_detailcpn.BCF","presentationFoetus_detCPN","t_mere_detailcpn.pres_transversale",
            "Bclampsie","signes_symptomes","Etat_col_detCPN","conduite_DetCpn","t_mere_detailcpn.author",

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
            "proteine","festule_reparee","discondance","t_mere_consultation_prenatale.bcf","mouvementFoctaux",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
            
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
                ['t_mere_detailcpn.deleted','NON']
            ])
            ->orderBy("t_mere_detailcpn.id", "desc")
            ->paginate(10);
        
            return response()->json([
                'data'=> $data
            ]);
        }

    }




    public function fetch_detail_entete(Request $request,$refCPN)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('t_mere_detailcpn')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_detailcpn.refCPN')
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

            ->select("t_mere_detailcpn.id","refCPN","typeCPN","date_visite","plaintes_notes","depistage","peauSeche","etatGenerale",
            "poids_detailCPN","bP","presence_cecite","presence_goittre","plaintes_fievre",
            "temps_valeur","duirese_oui_non","pertes_liquidiennes","ta_detailCPN","proteine_DetCPN",
            "oedemes_detCPN","coloration_conjonctive","paules_valeurs","etatSein_normal","presence_masse","ago_grossesse",
            "mouvement_foetus","hauteur_uterine_detCPN","t_mere_detailcpn.BCF","presentationFoetus_detCPN","t_mere_detailcpn.pres_transversale",
            "Bclampsie","signes_symptomes","Etat_col_detCPN","conduite_DetCpn","t_mere_detailcpn.author",

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
            "proteine","festule_reparee","discondance","t_mere_consultation_prenatale.bcf","mouvementFoctaux",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             
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
                ['refCPN',$refCPN],
                ['t_mere_detailcpn.deleted','NON']
            ])                      
            ->orderBy("t_mere_detailcpn.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);         

        }
        else{
            $data = DB::table('t_mere_detailcpn')
            ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_detailcpn.refCPN')
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

            ->select("t_mere_detailcpn.id","refCPN","typeCPN","date_visite","plaintes_notes","depistage","peauSeche","etatGenerale",
            "poids_detailCPN","bP","presence_cecite","presence_goittre","plaintes_fievre",
            "temps_valeur","duirese_oui_non","pertes_liquidiennes","ta_detailCPN","proteine_DetCPN",
            "oedemes_detCPN","coloration_conjonctive","paules_valeurs","etatSein_normal","presence_masse","ago_grossesse",
            "mouvement_foetus","hauteur_uterine_detCPN","t_mere_detailcpn.BCF","presentationFoetus_detCPN",
            "t_mere_detailcpn.pres_transversale",
            "Bclampsie","signes_symptomes","Etat_col_detCPN","conduite_DetCpn","t_mere_detailcpn.author",

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
            "proteine","festule_reparee","discondance","t_mere_consultation_prenatale.bcf","mouvementFoctaux",
            "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
            "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
            "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
             "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
             "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
             "resultat_test2","date_annonce2"  ,"plau_accouchement",
             
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
                ['refCPN',$refCPN],
                ['t_mere_detailcpn.deleted','NON']
            ])    
            ->orderBy("t_mere_detailcpn.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    } 







    function fetch_single_DetailCPN($id)
    {

        $data = DB::table('t_mere_detailcpn')
        ->join('t_mere_consultation_prenatale','t_mere_consultation_prenatale.id','=','t_mere_detailcpn.refCPN')
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

        ->select("t_mere_detailcpn.id","refCPN","typeCPN","date_visite","plaintes_notes","depistage","peauSeche","etatGenerale",
        "poids_detailCPN","bP","presence_cecite","presence_goittre","plaintes_fievre",
        "temps_valeur","duirese_oui_non","pertes_liquidiennes","ta_detailCPN","proteine_DetCPN",
        "oedemes_detCPN","coloration_conjonctive","paules_valeurs","etatSein_normal","presence_masse","ago_grossesse",
        "mouvement_foetus","hauteur_uterine_detCPN","t_mere_detailcpn.BCF","presentationFoetus_detCPN","t_mere_detailcpn.pres_transversale",
        "Bclampsie","signes_symptomes","Etat_col_detCPN","conduite_DetCpn","t_mere_detailcpn.author",

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
        "proteine","festule_reparee","discondance","t_mere_consultation_prenatale.bcf","mouvementFoctaux",
        "bassin_aetreci","bassin_limite","anomalie","uterus_cicotricile","masse_supecte",
        "maladie_chronique","drepanocytose","drepanocytose","Autres_raisons","date_references",
        "date_du_debutCTX","aZT","tAR","cd4","dors_mil_oui","fer_acide","apres_Accouchement",
         "vermifuge","Rpr","rPR_positif_oui","depistage_cancer","depistage_TBc","conseilsPF",
         "methodePFchoisie","dCIP","pTME","resultat_test1","date_annonce1","partenaire_date1",
         "resultat_test2","date_annonce2"  ,"plau_accouchement",
        
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
        ->where('t_mere_detailcpn.id', $id)
        ->get();

        return response()->json([
            'data'=> $data
        ]);
    }

    //typeCPN

 function insertData(Request $request)
 {

        $data= t_mere_detailcpn::create([
            'refCPN'=>$request->refCPN,
            'typeCPN'=>$request->typeCPN,
            'date_visite'=>$request->date_visite,
            'plaintes_notes'=>$request->plaintes_notes,
            'depistage'=>$request->depistage,  
            'peauSeche'=>$request->peauSeche,
            'etatGenerale'=>$request->etatGenerale,
            'poids_detailCPN'=>$request->poids_detailCPN,
            'bP'=>$request->bP,
            'presence_cecite'=>$request->presence_cecite,
            'presence_goittre'=>$request->presence_goittre,
            'plaintes_fievre'=>$request->plaintes_fievre,
            'temps_valeur'=>$request->temps_valeur,
            'duirese_oui_non'=>$request->duirese_oui_non,
            'pertes_liquidiennes'=>$request->pertes_liquidiennes,
            'ta_detailCPN'=>$request->ta_detailCPN,
            'proteine_DetCPN'=>$request->proteine_DetCPN,
            'oedemes_detCPN'=>$request->oedemes_detCPN,
            'coloration_conjonctive'=>$request->coloration_conjonctive,
            'paules_valeurs'=>$request->paules_valeurs,
            'etatSein_normal'=>$request->etatSein_normal,
            'presence_masse'=>$request->presence_masse,
            'ago_grossesse'=>$request->ago_grossesse,
            'mouvement_foetus'=>$request->mouvement_foetus,
            'hauteur_uterine_detCPN'=>$request->hauteur_uterine_detCPN,
            'BCF'=>$request->BCF,
            'presentationFoetus_detCPN'=>$request->presentationFoetus_detCPN,
            'pres_transversale'=>$request->pres_transversale,
            'Bclampsie'=>$request->Bclampsie,
            'signes_symptomes'=>$request->signes_symptomes,
            'Etat_col_detCPN'=>$request->Etat_col_detCPN,
            'conduite_DetCpn'=>$request->conduite_DetCpn,
            'author'=>$request->author
         ]);

       
         return response()->json([
            'data'=> 'Insertion reussie avec succes!!'
         ]);
     }
     

 //id,refCPN,date_visite,plaintes_notes,depistage,peauSeche,etatGenerale,
 //poids_detailCPN,bP,presence_cecite,presence_goittre,plaintes_fievre,temps_valeur,duirese_oui_non,
 //pertes_liquidiennes,ta_detailCPN,proteine_DetCPN,oedemes_detCPN,coloration_conjonctive,paules_valeurs,etatSein_normal,
 //presence_masse,presence_masse,ago_grossesse,mouvement_foetus,hauteur_uterine_detCPN,BCF,
 //presentationFoetus_detCPN,pres_transversale,Bclampsie,signes_symptomes,Etat_col_detCPN,conduite_DetCpn,author

 function updateData(Request $request)
 {
        $data= t_mere_detailcpn::where('id',$request->id)->update([
            'refCPN'=>$request->refCPN,
            'typeCPN'=>$request->typeCPN,
            'date_visite'=>$request->date_visite,
            'plaintes_notes'=>$request->plaintes_notes,
            'depistage'=>$request->depistage,  
            'peauSeche'=>$request->peauSeche,
            'etatGenerale'=>$request->etatGenerale,
            'poids_detailCPN'=>$request->poids_detailCPN,
            'bP'=>$request->bP,
            'presence_cecite'=>$request->presence_cecite,
            'presence_goittre'=>$request->presence_goittre,
            'plaintes_fievre'=>$request->plaintes_fievre,
            'temps_valeur'=>$request->temps_valeur,
            'duirese_oui_non'=>$request->duirese_oui_non,
            'pertes_liquidiennes'=>$request->pertes_liquidiennes,
            'ta_detailCPN'=>$request->ta_detailCPN,
            'proteine_DetCPN'=>$request->proteine_DetCPN,
            'oedemes_detCPN'=>$request->oedemes_detCPN,
            'coloration_conjonctive'=>$request->coloration_conjonctive,
            'paules_valeurs'=>$request->paules_valeurs,
            'etatSein_normal'=>$request->etatSein_normal,
            'presence_masse'=>$request->presence_masse,
            'ago_grossesse'=>$request->ago_grossesse,
            'mouvement_foetus'=>$request->mouvement_foetus,
            'hauteur_uterine_detCPN'=>$request->hauteur_uterine_detCPN,
            'BCF'=>$request->BCF,
            'presentationFoetus_detCPN'=>$request->presentationFoetus_detCPN,
            'pres_transversale'=>$request->pres_transversale,
            'Bclampsie'=>$request->Bclampsie,
            'signes_symptomes'=>$request->signes_symptomes,
            'Etat_col_detCPN'=>$request->Etat_col_detCPN,
            'conduite_DetCpn'=>$request->conduite_DetCpn,
            'author'=>$request->author 
         ]);

         return response()->json([
            'data'=> 'modification reussie avec succes!!'
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
     $data = t_mere_detailcpn::where('id', $id)->delete();
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }


}
