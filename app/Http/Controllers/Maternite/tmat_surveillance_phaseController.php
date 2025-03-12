<?php

namespace App\Http\Controllers\Maternite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Maternite\tmat_surveillance_phase;
use App\Traits\JsonResponseTrait; 
use App\Traits\{GlobalMethod,Slug};
use DB;

class tmat_surveillance_phaseController extends Controller
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

            $data = DB::table('tmat_surveillance_phase')
            ->join('tmat_partogramme','tmat_partogramme.id','=','tmat_surveillance_phase.refpatogramme')
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

            ->select("tmat_surveillance_phase.id","heureReelle","dilatation","Engagement","incident",
            "bcf","tempsEcoule","contractionsUterines","duree_contraction",
            "membrane","LA_aspect","Pertes_sang","Temps_oxillaire","diurese",
            "ocytocine_u","ocytocine_ghes","medicaments_inject","tmat_surveillance_phase.author",

            "refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
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
            ->orderBy("tmat_surveillance_phase.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'=> $data
            ] );
           

        }
        else{
          
            $data = DB::table('tmat_surveillance_phase')
            ->join('tmat_partogramme','tmat_partogramme.id','=','tmat_surveillance_phase.refpatogramme')
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

            ->select("heureReelle","dilatation","Engagement","incident",
            "bcf","tempsEcoule","contractionsUterines","duree_contraction",
            "membrane","LA_aspect","Pertes_sang","Temps_oxillaire","diurese",
            "ocytocine_u","ocytocine_ghes","medicaments_inject","tmat_surveillance_phase.author",

            "refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
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
            ->orderBy("tmat_surveillance_phase.id", "desc")
            ->paginate(10);

              return response()->json([
               'data'=>$data
            ] );

        }

    }

    function fetch_single_SurveillanceP($id)
    {

        $data = DB::table('tmat_surveillance_phase')
        ->join('tmat_partogramme','tmat_partogramme.id','=','tmat_surveillance_phase.refpatogramme')
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

        ->select("heureReelle","dilatation","Engagement","incident",
        "bcf","tempsEcoule","contractionsUterines","duree_contraction",
        "membrane","LA_aspect","Pertes_sang","Temps_oxillaire","diurese",
        "ocytocine_u","ocytocine_ghes","medicaments_inject","tmat_surveillance_phase.author",

        "refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
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
        ->where('tmat_surveillance_phase.id', $id)
        ->get();

        return response()->json([
            'data'=> $data
        ] );
    }

    function insertData(Request $request)
    {
        $data = tmat_surveillance_phase::create([
            'refpatogramme'  => $request->refpatogramme,
            'heureReelle'  =>  $request->heureReelle,
            'dilatation'  =>  $request->dilatation,
            'Engagement'  =>  $request->Engagement,
            'incident'  =>  $request->incident,
            'bcf'  =>  $request->bcf,
            'tempsEcoule'  =>  $request->tempsEcoule,
            'contractionsUterines'  =>  $request->contractionsUterines,
            'duree_contraction'  =>  $request->duree_contraction,
            'membrane'  =>$request->membrane,
            'LA_aspect'  =>  $request->LA_aspect,
            'Pertes_sang'  =>  $request->Pertes_sang,
            'Temps_oxillaire'  =>  $request->Temps_oxillaire,
            'diurese'  =>  $request->diurese,
            'ocytocine_u'  =>$request->ocytocine_u,
            'ocytocine_ghes'  =>  $request->ocytocine_ghes,
            'medicaments_inject'  =>  $request->medicaments_inject,
            'author'  =>  $request->author,      
        ]);

        return response()->json([
        'data'=> 'Insertion reussie avec Succès!!!'
    ]);

}


    function mobile_insertData(Request $request)
    {
    
        $data = tmat_surveillance_phase::create([
            'refpatogramme'  => $request->refpatogramme,
            'heureReelle'  =>  $request->heureReelle,
            'dilatation'  =>  $request->dilatation,
            'Engagement'  =>  $request->Engagement,
            'incident'  =>  $request->incident,
            'bcf'  =>  $request->bcf,
            'tempsEcoule'  =>  $request->tempsEcoule,
            'contractionsUterines'  =>  $request->contractionsUterines,
            'duree_contraction'  =>  $request->duree_contraction,
            'membrane'  =>$request->membrane,
            'LA_aspect'  =>  $request->LA_aspect,
            'Pertes_sang'  =>  $request->Pertes_sang,
            'Temps_oxillaire'  =>  $request->Temps_oxillaire,
            'diurese'  =>  $request->diurese,
            'ocytocine_u'  =>$request->ocytocine_u,
            'ocytocine_ghes'  =>  $request->ocytocine_ghes,
            'medicaments_inject'  =>  $request->medicaments_inject,
            'author'  =>  $request->author,      
        ]);


        $lastId=$data->id;
        $data2 = DB::table('tmat_surveillance_phase')
        ->join('tmat_partogramme','tmat_partogramme.id','=','tmat_surveillance_phase.refpatogramme')
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

        ->select("heureReelle","dilatation","Engagement","incident",
        "bcf","tempsEcoule","contractionsUterines","duree_contraction",
        "membrane","LA_aspect","Pertes_sang","Temps_oxillaire","diurese",
        "ocytocine_u","ocytocine_ghes","medicaments_inject","tmat_surveillance_phase.author",

        "refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
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
        ->where('tmat_surveillance_phase.id',$lastId)
        ->get();

        if($data2)
        {
         return $this->sendResponse($data2[0],'Insertion avec succes!!');
        }
        return $this->sendErrorResponse(' Erreur d\'Insertion!!');
    }
   
   



 function mobile_updateData(Request $request, $id)
 {
         $data= tmat_surveillance_phase::where('id',$request->id)->update([
            'refpatogramme'  => $request->refpatogramme,
            'heureReelle'  =>  $request->heureReelle,
            'dilatation'  =>  $request->dilatation,
            'Engagement'  =>  $request->Engagement,
            'incident'  =>  $request->incident,
            'bcf'  =>  $request->bcf,
            'tempsEcoule'  =>  $request->tempsEcoule,
            'contractionsUterines'  =>  $request->contractionsUterines,
            'duree_contraction'  =>  $request->duree_contraction,
            'membrane'  =>$request->membrane,
            'LA_aspect'  =>  $request->LA_aspect,
            'Pertes_sang'  =>  $request->Pertes_sang,
            'Temps_oxillaire'  =>  $request->Temps_oxillaire,
            'diurese'  =>  $request->diurese,
            'ocytocine_u'  =>$request->ocytocine_u,
            'ocytocine_ghes'  =>  $request->ocytocine_ghes,
            'medicaments_inject'  =>  $request->medicaments_inject,
            'author'  =>  $request->author,    
         ]);
         $data2 = DB::table('tmat_surveillance_phase')
         ->join('tmat_partogramme','tmat_partogramme.id','=','tmat_surveillance_phase.refpatogramme')
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

         ->select("heureReelle","dilatation","Engagement","incident",
         "bcf","tempsEcoule","contractionsUterines","duree_contraction",
         "membrane","LA_aspect","Pertes_sang","Temps_oxillaire","diurese",
         "ocytocine_u","ocytocine_ghes","medicaments_inject","tmat_surveillance_phase.author",

         "refDetailConst","prov_As","prov_Has","prov_HZ","personne_Prevenir","adresse_prevenir",
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
         ->where('tmat_surveillance_phase.id', $id)
         ->get();

         if($data2)
         {
            return $this->sendResponse($data2[0],'modification avec succes!!');
         }else{
            return $this->sendErrorResponse('erreur de modification!!');
         }


 }



 function updateData(Request $request, $id)
 {
         $data= tmat_surveillance_phase::where('id',$request->id)->update([
            'refpatogramme'  => $request->refpatogramme,
            'heureReelle'  =>  $request->heureReelle,
            'dilatation'  =>  $request->dilatation,
            'Engagement'  =>  $request->Engagement,
            'incident'  =>  $request->incident,
            'bcf'  =>  $request->bcf,
            'tempsEcoule'  =>  $request->tempsEcoule,
            'contractionsUterines'  =>  $request->contractionsUterines,
            'duree_contraction'  =>  $request->duree_contraction,
            'membrane'  =>$request->membrane,
            'LA_aspect'  =>  $request->LA_aspect,
            'Pertes_sang'  =>  $request->Pertes_sang,
            'Temps_oxillaire'  =>  $request->Temps_oxillaire,
            'diurese'  =>  $request->diurese,
            'ocytocine_u'  =>$request->ocytocine_u,
            'ocytocine_ghes'  =>  $request->ocytocine_ghes,
            'medicaments_inject'  =>  $request->medicaments_inject,
            'author'  =>  $request->author,    
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
     $data = tmat_surveillance_phase::where('id', $id)->delete();
     
     if($data)
     {
        return $this->sendResponse($data,'suppression avec succès');
     }else{
        return $this->sendErrorResponse('erreur de suppression!!');
     }
 }

}
