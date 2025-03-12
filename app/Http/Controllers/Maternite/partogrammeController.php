<?php

namespace App\Http\Controllers\Maternite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maternite\tmat_partogramme;
use App\Traits\JsonResponseTrait; 
use App\Traits\{GlobalMethod,Slug};
use DB;

class partogrammeController extends Controller
{

    use GlobalMethod, Slug,JsonResponseTrait;
  

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

            $data = DB::table('tmat_partogramme')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tmat_partogramme.refDetailConst')
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

            ->select("tmat_partogramme.id","refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
            "telephone_Prevenir","anamnese","motifconsultation","rh","status_AA","status_AS","status_SS",
            "gatiste","parite","avortement","enfantEnVie","DateAdmission","heure1","date_DDr","date_DPA","femme_CDV",
            "femme_testee","femme_resultat","regime","date_commencement","date_debut_travail","heure_debut_travail","antecedent_chirurgie",
            "nbrEnfant_vivant","morts","morte_ne","mort_avant_7jours","date_dernierAcouchemnt","nbr_eutocie",
            "nbr_dystocie","type_eutocie","nbre_bebe_poids","grossesse_multilple","cesarienne1","nbre_cesarienne","Annees1",
            "indications1","Annees2","Indication2","Annee3","Indication3","Annee4","Indication4","Annee5",
            "Indication5","poids_patrogramme","taille_patogramme","temperature_pato","pauls_pato",
            "TA_pato","oedemes","conjoctive_coloree","conjoctive_pauls","etat_generale","systeme_respiratoire","systeme_circulatoire",
            "systeme_digestif","systeme_urinaire","systeme_locomoteur","systeme_nerveux","Hu","presentation",
            "position","bcf","contraction_uterines","mfa_presents","MFA_absants","bv_cal","col_efface",
            "col_delate","col_particularite","poche_rampui","date_poche","heure_poche","LA_claire","verdatre","sanguinolent",
            "jaunatre","pirulent","degre_haute","degre_amorcee","degre_fixee","dregre_engagee","bassin_bon",
            "bassin_limite","bassin_retreci","bassin_asymetrique","result_GS","result_HC","result_HB","tDR_paludisme",
            "result_GE","result_albuminurie","result_rpr1","result_urines","conclusion","pronostic","conduite_tenir",
            "nom_examinateur","heure_examinateur","phase_lalente","phase_active","dilatation_complete","libelle_femme","accouchement_normal",
            "acouchement_heure","gemellaire","dechirure","degre_acouchement","apisiotomie","sature_par",
            "ventouse","forceps","symphyseotamie","cesarienne2","indication","accouchement","assistant",
            "ne_date","ne_heure","ne_sexe","maintien","taxillaire","crede","sein_cordon","mise_au_sein",
            "ne_poids","ne_taille","ne_pc","ocytocine","delivrance_heure","traction_cordon","message_delivrance",
            "delivrance_spontanee","spontanee_heure","delivrance_artificielle","atificielle_heure",
            "placenta_complet","placenta_incomplet","aspect_delivrance","membranes_complet","membranes_incomplet",
            "hemo_physidagique","hemo_pathologique","remination","stimulation","aspiration","ventilation",
            "autres_remination","vid_k1","antibotique","Arv","autreTraitement_donne","soins_post_partum",
            "signes_danger1","utilisation_micd","planification_familiale","nutrition","diagnostic_precoce",
            "traitement_ARV","consultion_suiviere","allaitement_materiel","hygiene_soins","recommandation",
            "signes_danger2","consultation_suivi_ne","fer_falates","mebendazole","sultadoxine","dormir_mld_mere",
            "vaccine_anti_tetuiquie","vitamineA","test_RPR","traitement_prophylaxie","bCG_vpo","result_rPR2",
            "profilaxie_TB","dormir_mlcd_de","cas_risque_infection","prophylaxie_Arv_ne",
            "tmat_partogramme.author",

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
            ->orderBy("tmat_partogramme.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=>$data
           ]);
           
         
            

        }
        else{
          
            $data = DB::table('tmat_partogramme')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tmat_partogramme.refDetailConst')
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

            ->select("refDetailConst","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
            "telephone_Prevenir","anamnese","motifconsultation","rh","status_AA","status_AS","status_SS",
            "gatiste","parite","avortement","enfantEnVie","DateAdmission","heure1","date_DDr","date_DPA","femme_CDV",
            "femme_testee","femme_resultat","regime","date_commencement","date_debut_travail","heure_debut_travail","antecedent_chirurgie",
            "nbrEnfant_vivant","morts","morte_ne","mort_avant_7jours","date_dernierAcouchemnt","nbr_eutocie",
            "nbr_dystocie","type_eutocie","nbre_bebe_poids","grossesse_multilple","cesarienne1","nbre_cesarienne","Annees1",
            "indications1","Annees2","Indication2","Annee3","Indication3","Annee4","Indication4","Annee5",
            "Indication5","poids_patrogramme","taille_patogramme","temperature_pato","pauls_pato",
            "TA_pato","oedemes","conjoctive_coloree","conjoctive_pauls","etat_generale","systeme_respiratoire","systeme_circulatoire",
            "systeme_digestif","systeme_urinaire","systeme_locomoteur","systeme_nerveux","Hu","presentation",
            "position","bcf","contraction_uterines","mfa_presents","MFA_absants","bv_cal","col_efface",
            "col_delate","col_particularite","poche_rampui","date_poche","heure_poche","LA_claire","verdatre","sanguinolent",
            "jaunatre","pirulent","degre_haute","degre_amorcee","degre_fixee","dregre_engagee","bassin_bon",
            "bassin_limite","bassin_retreci","bassin_asymetrique","result_GS","result_HC","result_HB","tDR_paludisme",
            "result_GE","result_albuminurie","result_rpr1","result_urines","conclusion","pronostic","conduite_tenir",
            "nom_examinateur","heure_examinateur","phase_lalente","phase_active","dilatation_complete","libelle_femme","accouchement_normal",
            "acouchement_heure","gemellaire","dechirure","degre_acouchement","apisiotomie","sature_par",
            "ventouse","forceps","symphyseotamie","cesarienne2","indication","accouchement","assistant",
            "ne_date","ne_heure","ne_sexe","maintien","taxillaire","crede","sein_cordon","mise_au_sein",
            "ne_poids","ne_taille","ne_pc","ocytocine","delivrance_heure","traction_cordon","message_delivrance",
            "delivrance_spontanee","spontanee_heure","delivrance_artificielle","atificielle_heure",
            "placenta_complet","placenta_incomplet","aspect_delivrance","membranes_complet","membranes_incomplet",
            "hemo_physidagique","hemo_pathologique","remination","stimulation","aspiration","ventilation",
            "autres_remination","vid_k1","antibotique","Arv","autreTraitement_donne","soins_post_partum",
            "signes_danger1","utilisation_micd","planification_familiale","nutrition","diagnostic_precoce",
            "traitement_ARV","consultion_suiviere","allaitement_materiel","hygiene_soins","recommandation",
            "signes_danger2","consultation_suivi_ne","fer_falates","mebendazole","sultadoxine","dormir_mld_mere",
            "vaccine_anti_tetuiquie","vitamineA","test_RPR","traitement_prophylaxie","bCG_vpo","result_rPR2",
            "profilaxie_TB","dormir_mlcd_de","cas_risque_infection","prophylaxie_Arv_ne",
            "tmat_partogramme.author",

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
            ->orderBy("tmat_partogramme.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'=>$data
           ]);
        }

    }

    function fetch_single_patrogramme($id)
    {

        $data = DB::table('tmat_partogramme')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tmat_partogramme.refDetailConst')
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

        ->select("refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
        "telephone_Prevenir","anamnese","motifconsultation","rh","status_AA","status_AS","status_SS",
        "gatiste","parite","avortement","enfantEnVie","DateAdmission","heure1","date_DDr","date_DPA","femme_CDV",
        "femme_testee","femme_resultat","regime","date_commencement","date_debut_travail","heure_debut_travail","antecedent_chirurgie",
        "nbrEnfant_vivant","morts","morte_ne","mort_avant_7jours","date_dernierAcouchemnt","nbr_eutocie",
        "nbr_dystocie","type_eutocie","nbre_bebe_poids","grossesse_multilple","cesarienne1","nbre_cesarienne","Annees1",
        "indications1","Annees2","Indication2","Annee3","Indication3","Annee4","Indication4","Annee5",
        "Indication5","poids_patrogramme","taille_patogramme","temperature_pato","pauls_pato",
        "TA_pato","oedemes","conjoctive_coloree","conjoctive_pauls","etat_generale","systeme_respiratoire","systeme_circulatoire",
        "systeme_digestif","systeme_urinaire","systeme_locomoteur","systeme_nerveux","Hu","presentation",
        "position","bcf","contraction_uterines","mfa_presents","MFA_absants","bv_cal","col_efface",
        "col_delate","col_particularite","poche_rampui","date_poche","heure_poche","LA_claire","verdatre","sanguinolent",
        "jaunatre","pirulent","degre_haute","degre_amorcee","degre_fixee","dregre_engagee","bassin_bon",
        "bassin_limite","bassin_retreci","bassin_asymetrique","result_GS","result_HC","result_HB","tDR_paludisme",
        "result_GE","result_albuminurie","result_rpr1","result_urines","conclusion","pronostic","conduite_tenir",
        "nom_examinateur","heure_examinateur","phase_lalente","phase_active","dilatation_complete","libelle_femme","accouchement_normal",
        "acouchement_heure","gemellaire","dechirure","degre_acouchement","apisiotomie","sature_par",
        "ventouse","forceps","symphyseotamie","cesarienne2","indication","accouchement","assistant",
        "ne_date","ne_heure","ne_sexe","maintien","taxillaire","crede","sein_cordon","mise_au_sein",
        "ne_poids","ne_taille","ne_pc","ocytocine","delivrance_heure","traction_cordon","message_delivrance",
        "delivrance_spontanee","spontanee_heure","delivrance_artificielle","atificielle_heure",
        "placenta_complet","placenta_incomplet","aspect_delivrance","membranes_complet","membranes_incomplet",
        "hemo_physidagique","hemo_pathologique","remination","stimulation","aspiration","ventilation",
        "autres_remination","vid_k1","antibotique","Arv","autreTraitement_donne","soins_post_partum",
        "signes_danger1","utilisation_micd","planification_familiale","nutrition","diagnostic_precoce",
        "traitement_ARV","consultion_suiviere","allaitement_materiel","hygiene_soins","recommandation",
        "signes_danger2","consultation_suivi_ne","fer_falates","mebendazole","sultadoxine","dormir_mld_mere",
        "vaccine_anti_tetuiquie","vitamineA","test_RPR","traitement_prophylaxie","bCG_vpo","result_rPR2",
        "profilaxie_TB","dormir_mlcd_de","cas_risque_infection","prophylaxie_Arv_ne",
        "tmat_partogramme.author",

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
        ->where('tmat_partogramme.id', $id)
        ->get();

        return response()->json([
            'data'=>$data
       ]);
    }

    function insertData(Request $request)
    {

        $data = tmat_partogramme::create([
            'refDetailConst'  => $request->refDetailConst,
            'prov_As'  =>  $request->prov_As,
            'prov_Has'  =>  $request->prov_Has,
            'prov_HZ'  =>  $request->prov_HZm,
            'personne_Prevenir'  =>  $request->personne_Prevenir,
            'adresse_prevenir'  =>  $request->adresse_prevenir,
            'telephone_Prevenir'  =>  $request->telephone_Prevenir,
            'anamnese'  =>  $request->anamnese,
            'motifconsultation'  =>  $request->motifconsultation,
            'rh'  =>$request->rh,
            'status_AA'  =>  $request->status_AA,
            'status_AS'  =>  $request->status_AS,
            'status_SS'  =>  $request->status_SS,
            'gatiste'  =>  $request->gatiste,
            'parite'  =>  $request->parite,
            'avortement'  =>  $request->avortement,
            'enfantEnVie'  =>  $request->enfantEnVie,
            'DateAdmission'  =>  $request->DateAdmission,
            'heure1'  =>  $request->heure1,
            'date_DDr'  =>  $request->date_DDr,
            'date_DPA'  =>  $request->date_DPA,
            'femme_CDV'  =>  $request->femme_CDV,
            'femme_testee'  =>  $request->femme_testee,
            'femme_resultat'  =>  $request->femme_resultat,
            'regime'  =>  $request->regime,
            'date_commencement'  =>  $request->date_commencement,
            'date_debut_travail'  =>  $request->date_debut_travail,
            'heure_debut_travail'  =>  $request->heure_debut_travail,
            'antecedent_chirurgie'  =>  $request->antecedent_chirurgie,
            'nbrEnfant_vivant'  =>  $request->nbrEnfant_vivant,
            'morts'  =>  $request->morts,
            'morte_ne'  =>  $request->morte_ne,
            'mort_avant_7jours'  =>  $request->mort_avant_7jours,
            'date_dernierAcouchemnt'  => $request->date_dernierAcouchemnt,
            'nbr_eutocie'  =>  $request->nbr_eutocie,
            'nbr_dystocie'  =>  $request->nbr_dystocie,
            'type_eutocie'  =>  $request->type_eutocie,
            'nbre_bebe_poids'  =>  $request->nbre_bebe_poids,
            'grossesse_multilple'  =>  $request->grossesse_multilple,
            'cesarienne1'  =>  $request->cesarienne1,
            'nbre_cesarienne'  =>  $request->nbre_cesarienne,
            'Annees1'  =>  $request->Annees1,
            'indications1'  =>  $request->indications1,
            'Annees2'  =>  $request->Annees2,
            'Indication2'  =>  $request->Indication2,
            'Annee3'  =>  $request->Annee3,
            'Indication3'  =>  $request->Indication3,
            'Annee4'  =>  $request->Annee4,
            'Indication4'  =>  $request->Indication4,
            'Annee5'  =>  $request->Annee5,
            'Indication5'  =>  $request->Indication5,
            'poids_patrogramme'  =>  $request->poids_patrogramme,
            'taille_patogramme'  =>  $request->taille_patogramme,
            'temperature_pato'  =>  $request->temperature_pato,
            'pauls_pato'  =>  $request->pauls_pato,
            'TA_pato'  =>  $request->TA_pato,
            'oedemes'  =>  $request->oedemes,
            'conjoctive_coloree'  =>  $request->conjoctive_coloree,
            'conjoctive_pauls'  =>  $request->conjoctive_pauls,
            'etat_generale'  =>  $request->etat_generale,
            'systeme_respiratoire'  =>  $request->systeme_respiratoire,
            'systeme_circulatoire'  =>  $request->systeme_circulatoire,
            'systeme_digestif' =>  $request->systeme_digestif,
            'systeme_urinaire'  =>  $request->systeme_urinaire,
            'systeme_locomoteur'  =>  $request->systeme_locomoteur,
            'systeme_nerveux'  =>  $request->systeme_nerveux,
            'Hu'  =>  $request->Hu,
            'presentation'  =>  $request->presentation,
            'position'  =>  $request->position,
            'bcf'  =>  $request->bcf,
            'contraction_uterines'  => $request->contraction_uterines,
            'mfa_presents'  =>  $request->mfa_presents,
            'MFA_absants'  =>  $request->MFA_absants,
            'bv_cal'  =>  $request->bv_cal,
            'col_efface'  =>  $request->col_efface,
            'col_delate'  =>  $request->col_delate,
            'col_particularite'  =>  $request->col_particularite,
            'poche_rampui'  =>  $request->poche_rampui,
            'date_poche'  =>  $request->date_poche,
            'heure_poche'  =>  $request->heure_poche,
            'LA_claire'  =>  $request->LA_claire,
            'verdatre'  =>  $request->verdatre,
            'sanguinolent'  =>  $request->sanguinolent,
            'jaunatre'  =>  $request->jaunatre,
            'pirulent'  =>  $request->pirulent,
            'degre_haute'  =>  $request->degre_haute,
            'degre_amorcee'  =>  $request->degre_amorcee,
            'degre_fixee'  =>  $request->degre_fixee,
            'dregre_engagee'  =>  $request->dregre_engagee,
            'bassin_bon'  =>  $request->bassin_bon,
            'bassin_limite'  =>  $request->bassin_limite,
            'bassin_retreci'  =>  $request->bassin_retreci,
            'bassin_asymetrique'  =>  $request->bassin_asymetrique,
            'result_GS'  =>  $request->result_GS,
            'result_HC'  =>  $request->result_HC,
            'result_HB'  =>  $request->result_HB,
            'tDR_paludisme'  =>  $request->tDR_paludisme,
            'result_GE'  =>  $request->result_GE,
            'result_albuminurie'  =>  $request->result_albuminurie,
            'result_rpr1'  =>  $request->result_rpr1,
            'result_urines'  =>  $request->result_urines,
            'conclusion'  =>  $request->conclusion,
            'pronostic'  =>  $request->pronostic,
            'conduite_tenir'  =>  $request->conduite_tenir,
            'nom_examinateur'  =>  $request->nom_examinateur,
            'heure_examinateur'  =>  $request->heure_examinateur,
            'phase_lalente'  =>  $request->phase_lalente,
            'phase_active'  =>  $request->phase_active,
            'dilatation_complete'  =>  $request->dilatation_complete,
            'libelle_femme'  =>  $request->libelle_femme,
            'accouchement_normal'  =>  $request->accouchement_normal,
            'acouchement_heure'  =>  $request->acouchement_heure,
            'gemellaire'  =>  $request->gemellaire,
            'dechirure'  =>  $request->dechirure,
            'degre_acouchement'  =>  $request->degre_acouchement,
            'apisiotomie'  =>  $request->apisiotomie,
            'sature_par'  =>  $request->sature_par,
            'ventouse'  =>  $request->ventouse,
            'forceps'  =>  $request->forceps,
            'symphyseotamie'  =>  $request->symphyseotamie,
            'cesarienne2'  =>  $request->cesarienne2,
            'indication'  =>  $request->indication,
            'accouchement'  =>  $request->accouchement,
            'assistant'  =>  $request->assistant,
            'ne_date'  =>  $request->ne_date,
            'ne_heure'  =>  $request->ne_heure,
            'ne_sexe'  =>  $request->ne_sexe,
            'maintien'  =>  $request->maintien,
            'taxillaire'  =>  $request->taxillaire,
            'crede'  =>  $request->crede,
            'sein_cordon'  =>  $request->sein_cordon,
            'mise_au_sein'  =>  $request->mise_au_sein,
            'ne_poids'  =>  $request->ne_poids,
            'ne_taille'  =>  $request->ne_taille,
            'ne_pc'  =>  $request->ne_pc,
            'ocytocine'  =>  $request->ocytocine,
            'delivrance_heure'  =>  $request->delivrance_heure,
            'traction_cordon'  =>  $request->traction_cordon,
            'message_delivrance'  =>  $request->message_delivrance,
            'delivrance_spontanee'  =>  $request->delivrance_spontanee,
            'spontanee_heure'  =>  $request->spontanee_heure,
            'delivrance_artificielle'  =>  $request->delivrance_artificielle,
            'atificielle_heure'  =>  $request->atificielle_heure,
            'placenta_complet'  =>  $request->placenta_complet,
            'placenta_incomplet'  =>  $request->placenta_incomplet,
            'aspect_delivrance'  =>  $request->aspect_delivrance,
            'membranes_complet'  =>  $request->membranes_complet,
            'membranes_incomplet'  =>  $request->membranes_incomplet,
            'hemo_physidagique'  =>  $request->hemo_physidagique,
            'hemo_pathologique'  =>  $request->hemo_pathologique,
            'remination'  =>  $request->remination,
            'stimulation'  =>  $request->stimulation,
            'aspiration'  =>  $request->aspiration,
            'ventilation'  =>  $request->ventilation,
            'autres_remination'  =>  $request->autres_remination,
            'vid_k1'  =>  $request->vid_k1,
            'antibotique'  =>  $request->antibotique,
            'Arv'  =>  $request->Arv,
            'autreTraitement_donne'  =>  $request->autreTraitement_donne,
            'soins_post_partum'  =>$request->soins_post_partum,
            'signes_danger1'  =>  $request->signes_danger1,
            'utilisation_micd'  =>  $request->utilisation_micd,
            'planification_familiale'  =>  $request->planification_familiale,
            'nutrition'  =>  $request->nutrition,
            'diagnostic_precoce'  =>  $request->diagnostic_precoce,
            'traitement_ARV'  =>  $request->traitement_ARV,
            'consultion_suiviere'  =>  $request->consultion_suiviere,
            'allaitement_materiel'  =>  $request->allaitement_materiel,
            'hygiene_soins'  =>  $request->hygiene_soins,
            'recommandation'  =>  $request->recommandation,
            'signes_danger2'  =>  $request->signes_danger2,
            'consultation_suivi_ne'  =>  $request->consultation_suivi_ne,
            'fer_falates'  =>  $request->fer_falates,
            'mebendazole'  =>  $request->mebendazole,
            'sultadoxine'  =>  $request->sultadoxine,
            'dormir_mld_mere'  =>  $request->dormir_mld_mere,
            'vaccine_anti_tetuiquie'  =>  $request->vaccine_anti_tetuiquie,
            'vitamineA'  =>  $request->vitamineA,
            'test_RPR'  =>  $request->test_RPR,
            'traitement_prophylaxie'  =>  $request->traitement_prophylaxie,
            'bCG_vpo'  =>  $request->bCG_vpo,
            'result_rPR2'  =>  $request->result_rPR2,
            'profilaxie_TB'  =>  $request->profilaxie_TB,
            'dormir_mlcd_de'  =>  $request->dormir_mlcd_de,
            'cas_risque_infection'  =>  $request->cas_risque_infection,
            'prophylaxie_Arv_ne'  =>  $request->prophylaxie_Arv_ne,
            'author'  =>  $request->author      
        ]);

        return response()->json([
            'data'  =>  "Insertion  avec succès!!!",
        ]);
    }

 function updateData(Request $request)
 {
    

         $data= tmat_partogramme::where('id',$request->id)->update([
            'refDetailConst'  =>$request->refDetailConst,
            'prov_As'  =>  $request->prov_As,
            'prov_Has'  =>  $request->prov_Has,
            'prov_HZ'  =>  $request->prov_HZm,
            'personne_Prevenir'  =>  $request->personne_Prevenir,
            'adresse_prevenir'  =>  $request->adresse_prevenir,
            'telephone_Prevenir'  =>  $request->telephone_Prevenir,
            'anamnese'  =>  $request->anamnese,
            'motifconsultation'  =>  $request->motifconsultation,
            'rh'  =>$request->rh,
            'status_AA'  =>  $request->status_AA,
            'status_AS'  =>  $request->status_AS,
            'status_SS'  =>  $request->status_SS,
            'gatiste'  =>  $request->gatiste,
            'parite'  =>  $request->parite,
            'avortement'  =>  $request->avortement,
            'enfantEnVie'  =>  $request->enfantEnVie,
            'DateAdmission'  =>  $request->DateAdmission,
            'heure1'  =>  $request->heure1,
            'date_DDr'  =>  $request->date_DDr,
            'date_DPA'  =>  $request->date_DPA,
            'femme_CDV'  =>  $request->femme_CDV,
            'femme_testee'  =>  $request->femme_testee,
            'femme_resultat'  =>  $request->femme_resultat,
            'regime'  =>  $request->regime,
            'date_commencement'  =>  $request->date_commencement,
            'date_debut_travail'  =>  $request->date_debut_travail,
            'heure_debut_travail'  =>  $request->heure_debut_travail,
            'antecedent_chirurgie'  =>  $request->antecedent_chirurgie,
            'nbrEnfant_vivant'  =>  $request->nbrEnfant_vivant,
            'morts'  =>  $request->morts,
            'morte_ne'  =>  $request->morte_ne,
            'mort_avant_7jours'  =>  $request->mort_avant_7jours,
            'date_dernierAcouchemnt'  => $request->date_dernierAcouchemnt,
            'nbr_eutocie'  =>  $request->nbr_eutocie,
            'nbr_dystocie'  =>  $request->nbr_dystocie,
            'type_eutocie'  =>  $request->type_eutocie,
            'nbre_bebe_poids'  =>  $request->nbre_bebe_poids,
            'grossesse_multilple'  =>  $request->grossesse_multilple,
            'cesarienne1'  =>  $request->cesarienne1,
            'nbre_cesarienne'  =>  $request->nbre_cesarienne,
            'Annees1'  =>  $request->Annees1,
            'indications1'  =>  $request->indications1,
            'Annees2'  =>  $request->Annees2,
            'Indication2'  =>  $request->Indication2,
            'Annee3'  =>  $request->Annee3,
            'Indication3'  =>  $request->Indication3,
            'Annee4'  =>  $request->Annee4,
            'Indication4'  =>  $request->Indication4,
            'Annee5'  =>  $request->Annee5,
            'Indication5'  =>  $request->Indication5,
            'poids_patrogramme'  =>  $request->poids_patrogramme,
            'taille_patogramme'  =>  $request->taille_patogramme,
            'temperature_pato'  =>  $request->temperature_pato,
            'pauls_pato'  =>  $request->pauls_pato,
            'TA_pato'  =>  $request->TA_pato,
            'oedemes'  =>  $request->oedemes,
            'conjoctive_coloree'  =>  $request->conjoctive_coloree,
            'conjoctive_pauls'  =>  $request->conjoctive_pauls,
            'etat_generale'  =>  $request->etat_generale,
            'systeme_respiratoire'  =>  $request->systeme_respiratoire,
            'systeme_circulatoire'  =>  $request->systeme_circulatoire,
            'systeme_digestif' =>  $request->systeme_digestif,
            'systeme_urinaire'  =>  $request->systeme_urinaire,
            'systeme_locomoteur'  =>  $request->systeme_locomoteur,
            'systeme_nerveux'  =>  $request->systeme_nerveux,
            'Hu'  =>  $request->Hu,
            'presentation'  =>  $request->presentation,
            'position'  =>  $request->position,
            'bcf'  =>  $request->bcf,
            'contraction_uterines'  => $request->contraction_uterines,
            'mfa_presents'  =>  $request->mfa_presents,
            'MFA_absants'  =>  $request->MFA_absants,
            'bv_cal'  =>  $request->bv_cal,
            'col_efface'  =>  $request->col_efface,
            'col_delate'  =>  $request->col_delate,
            'col_particularite'  =>  $request->col_particularite,
            'poche_rampui'  =>  $request->poche_rampui,
            'date_poche'  =>  $request->date_poche,
            'heure_poche'  =>  $request->heure_poche,
            'LA_claire'  =>  $request->LA_claire,
            'verdatre'  =>  $request->verdatre,
            'sanguinolent'  =>  $request->sanguinolent,
            'jaunatre'  =>  $request->jaunatre,
            'pirulent'  =>  $request->pirulent,
            'degre_haute'  =>  $request->degre_haute,
            'degre_amorcee'  =>  $request->degre_amorcee,
            'degre_fixee'  =>  $request->degre_fixee,
            'dregre_engagee'  =>  $request->dregre_engagee,
            'bassin_bon'  =>  $request->bassin_bon,
            'bassin_limite'  =>  $request->bassin_limite,
            'bassin_retreci'  =>  $request->bassin_retreci,
            'bassin_asymetrique'  =>  $request->bassin_asymetrique,
            'result_GS'  =>  $request->result_GS,
            'result_HC'  =>  $request->result_HC,
            'result_HB'  =>  $request->result_HB,
            'tDR_paludisme'  =>  $request->tDR_paludisme,
            'result_GE'  =>  $request->result_GE,
            'result_albuminurie'  =>  $request->result_albuminurie,
            'result_rpr1'  =>  $request->result_rpr1,
            'result_urines'  =>  $request->result_urines,
            'conclusion'  =>  $request->conclusion,
            'pronostic'  =>  $request->pronostic,
            'conduite_tenir'  =>  $request->conduite_tenir,
            'nom_examinateur'  =>  $request->nom_examinateur,
            'heure_examinateur'  =>  $request->heure_examinateur,
            'phase_lalente'  =>  $request->phase_lalente,
            'phase_active'  =>  $request->phase_active,
            'dilatation_complete'  =>  $request->dilatation_complete,
            'libelle_femme'  =>  $request->libelle_femme,
            'accouchement_normal'  =>  $request->accouchement_normal,
            'acouchement_heure'  =>  $request->acouchement_heure,
            'gemellaire'  =>  $request->gemellaire,
            'dechirure'  =>  $request->dechirure,
            'degre_acouchement'  =>  $request->degre_acouchement,
            'apisiotomie'  =>  $request->apisiotomie,
            'sature_par'  =>  $request->sature_par,
            'ventouse'  =>  $request->ventouse,
            'forceps'  =>  $request->forceps,
            'symphyseotamie'  =>  $request->symphyseotamie,
            'cesarienne2'  =>  $request->cesarienne2,
            'indication'  =>  $request->indication,
            'accouchement'  =>  $request->accouchement,
            'assistant'  =>  $request->assistant,
            'ne_date'  =>  $request->ne_date,
            'ne_heure'  =>  $request->ne_heure,
            'ne_sexe'  =>  $request->ne_sexe,
            'maintien'  =>  $request->maintien,
            'taxillaire'  =>  $request->taxillaire,
            'crede'  =>  $request->crede,
            'sein_cordon'  =>  $request->sein_cordon,
            'mise_au_sein'  =>  $request->mise_au_sein,
            'ne_poids'  =>  $request->ne_poids,
            'ne_taille'  =>  $request->ne_taille,
            'ne_pc'  =>  $request->ne_pc,
            'ocytocine'  =>  $request->ocytocine,
            'delivrance_heure'  =>  $request->delivrance_heure,
            'traction_cordon'  =>  $request->traction_cordon,
            'message_delivrance'  =>  $request->message_delivrance,
            'delivrance_spontanee'  =>  $request->delivrance_spontanee,
            'spontanee_heure'  =>  $request->spontanee_heure,
            'delivrance_artificielle'  =>  $request->delivrance_artificielle,
            'atificielle_heure'  =>  $request->atificielle_heure,
            'placenta_complet'  =>  $request->placenta_complet,
            'placenta_incomplet'  =>  $request->placenta_incomplet,
            'aspect_delivrance'  =>  $request->aspect_delivrance,
            'membranes_complet'  =>  $request->membranes_complet,
            'membranes_incomplet'  =>  $request->membranes_incomplet,
            'hemo_physidagique'  =>  $request->hemo_physidagique,
            'hemo_pathologique'  =>  $request->hemo_pathologique,
            'remination'  =>  $request->remination,
            'stimulation'  =>  $request->stimulation,
            'aspiration'  =>  $request->aspiration,
            'ventilation'  =>  $request->ventilation,
            'autres_remination'  =>  $request->autres_remination,
            'vid_k1'  =>  $request->vid_k1,
            'antibotique'  =>  $request->antibotique,
            'Arv'  =>  $request->Arv,
            'autreTraitement_donne'  =>  $request->autreTraitement_donne,
            'soins_post_partum'  =>$request->soins_post_partum,
            'signes_danger1'  =>  $request->signes_danger1,
            'utilisation_micd'  =>  $request->utilisation_micd,
            'planification_familiale'  =>  $request->planification_familiale,
            'nutrition'  =>  $request->nutrition,
            'diagnostic_precoce'  =>  $request->diagnostic_precoce,
            'traitement_ARV'  =>  $request->traitement_ARV,
            'consultion_suiviere'  =>  $request->consultion_suiviere,
            'allaitement_materiel'  =>  $request->allaitement_materiel,
            'hygiene_soins'  =>  $request->hygiene_soins,
            'recommandation'  =>  $request->recommandation,
            'signes_danger2'  =>  $request->signes_danger2,
            'consultation_suivi_ne'  =>  $request->consultation_suivi_ne,
            'fer_falates'  =>  $request->fer_falates,
            'mebendazole'  =>  $request->mebendazole,
            'sultadoxine'  =>  $request->sultadoxine,
            'dormir_mld_mere'  =>  $request->dormir_mld_mere,
            'vaccine_anti_tetuiquie'  =>  $request->vaccine_anti_tetuiquie,
            'vitamineA'  =>  $request->vitamineA,
            'test_RPR'  =>  $request->test_RPR,
            'traitement_prophylaxie'  =>  $request->traitement_prophylaxie,
            'bCG_vpo'  =>  $request->bCG_vpo,
            'result_rPR2'  =>  $request->result_rPR2,
            'profilaxie_TB'  =>  $request->profilaxie_TB,
            'dormir_mlcd_de'  =>  $request->dormir_mlcd_de,
            'cas_risque_infection'  =>  $request->cas_risque_infection,
            'prophylaxie_Arv_ne'  =>  $request->prophylaxie_Arv_ne,
            'author'  =>  $request->author     
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
     $data = tmat_partogramme::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "Insertion  avec succès!!!",
    ]);
 }

}
