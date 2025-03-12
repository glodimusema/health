<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chirurgie\top_cons_preanesthesie;
use DB;

class tconspresanesthesieController extends Controller
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

            $data = DB::table('top_cons_preanesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tClient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("top_cons_preanesthesie.id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
            "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
            "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
            "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",'refDetailCons',
            "dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            
             "top_cons_preanesthesie.author", "top_cons_preanesthesie.created_at", "top_cons_preanesthesie.updated_at",
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
            ->orderBy("top_cons_preanesthesie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('top_cons_preanesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tClient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("top_cons_preanesthesie.id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
            "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
            "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
            "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",'refDetailCons',
            "dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            
             "top_cons_preanesthesie.author", "top_cons_preanesthesie.created_at", "top_cons_preanesthesie.updated_at",
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
            ->orderBy("top_cons_preanesthesie.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteOperation)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('top_cons_preanesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tClient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("top_cons_preanesthesie.id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
            "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
            "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
            "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",'refDetailCons',
            "dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            
             "top_cons_preanesthesie.author", "top_cons_preanesthesie.created_at", "top_cons_preanesthesie.updated_at",
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
                ['refEnteteOperation',$refEnteteOperation]
            ])                    
            ->orderBy("top_cons_preanesthesie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('top_cons_preanesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tClient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("top_cons_preanesthesie.id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
            "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
            "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
            "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",'refDetailCons',
            "dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            
             "top_cons_preanesthesie.author", "top_cons_preanesthesie.created_at", "top_cons_preanesthesie.updated_at",
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
            ->Where('refEnteteOperation',$refEnteteOperation)    
            ->orderBy("top_cons_preanesthesie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

 

    function fetch_single_detail($id)
    {

        $data = DB::table('top_cons_preanesthesie')
        ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tope_enteteoperation.refDetailCons')
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tClient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("top_cons_preanesthesie.id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire",
        "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
        "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur",
        "Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
        "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro",
        "Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
        "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",'refDetailCons',
        "dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
        
         "top_cons_preanesthesie.author", "top_cons_preanesthesie.created_at", "top_cons_preanesthesie.updated_at",
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
        ->where('top_cons_preanesthesie.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

    // "id","refEnteteOperation","TypeIntervension","diagnostic_preoperatoire","antecedents_cpa",
    //"rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations","dyspnee_2","dyspnee_3",
    //"spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie","Vomissements","Pyrasis","Diarrhees",
    //"UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2","TraitementEncours","Malformations",
    //"Prothese","Obesite","Estomac_plein","Ouverture_Bucale","Distance_thyro","Mobilite_cervicale",
    //"Lips_Test","Mallampatie","Prediction_intubation","Consculsion_CPA","Premedication",
    // "Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA","ConsentementEclaire",
    // "author"  
    function insert_detail(Request $request)
    {
       
        $data = top_cons_preanesthesie::create([
            'refEnteteOperation'       =>  $request->refEnteteOperation,           
            "TypeIntervension"=>  $request->TypeIntervension,
            "diagnostic_preoperatoire"=>  $request->diagnostic_preoperatoire,
            "antecedents_cpa"=>  $request->antecedents_cpa,
            "rhume"=>  $request->rhume,
            "dyspnee_1"=>  $request->dyspnee_1,
            "Toux"=>  $request->Toux,
            "spo2_1"=>  $request->spo2_1,
            "crachats"=>  $request->crachats,
            "Examen_Poumons"=>  $request->Examen_Poumons,
            "Palpitations"=>  $request->Palpitations,
            "dyspnee_2"=>  $request->dyspnee_2,
            "dyspnee_3"=>  $request->dyspnee_3,
            "spo2_2"=>  $request->spo2_2,
            "Precodialgies"=>  $request->Precodialgies,
            "ExamenduCoeur"=>  $request->ExamenduCoeur,
            "Nausees"=>  $request->Nausees,
            "Epigastralgie"=>  $request->Epigastralgie,
            "Vomissements"=>  $request->Vomissements,
            "Pyrasis"=>  $request->Pyrasis,
            "Diarrhees"=>  $request->Diarrhees,
            "UlceresGD"=>  $request->UlceresGD,
            "Diures"=>  $request->Diures,
            "Autres1"=>  $request->Autres1,
            "Systeme_nerveux"=>  $request->Systeme_nerveux,
            "Autres2"=>  $request->Autres2,

            "TraitementEncours"=>  $request->TraitementEncours,
            "Malformations"=>  $request->Malformations,
            "Prothese"=>  $request->Prothese,
            "Obesite"=>  $request->Obesite,

            "Estomac_plein"=>  $request->Estomac_plein,
            "Ouverture_Bucale"=>  $request->Ouverture_Bucale,
            "Distance_thyro"=>  $request->Distance_thyro,
            "Mobilite_cervicale"=>  $request->Mobilite_cervicale,
            "Lips_Test"=>  $request->Lips_Test,
            "Mallampatie"=>  $request->Mallampatie,
            "Prediction_intubation"=>  $request->Prediction_intubation,
            "Consculsion_CPA"=>  $request->Consculsion_CPA,
            "Premedication"=>  $request->Premedication,
            "Typeanesthesie"=>  $request->Typeanesthesie,
            "AutresTypeAnesthesie"=>  $request->AutresTypeAnesthesie,
            "Protocole_CPA"=>  $request->Protocole_CPA,
            "ConsentementEclaire"=>  $request->ConsentementEclaire,                                                                   
            'author'       =>  $request->author

       ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detail(Request $request, $id)
    {
        $data = top_cons_preanesthesie::where('id', $id)->update([
            'refEnteteOperation'       =>  $request->refEnteteOperation,           
            "TypeIntervension"=>  $request->TypeIntervension,
            "diagnostic_preoperatoire"=>  $request->diagnostic_preoperatoire,
            "antecedents_cpa"=>  $request->antecedents_cpa,
            "rhume"=>  $request->rhume,
            "dyspnee_1"=>  $request->dyspnee_1,
            "Toux"=>  $request->Toux,
            "spo2_1"=>  $request->spo2_1,
            "crachats"=>  $request->crachats,
            "Examen_Poumons"=>  $request->Examen_Poumons,
            "Palpitations"=>  $request->Palpitations,
            "dyspnee_2"=>  $request->dyspnee_2,
            "dyspnee_3"=>  $request->dyspnee_3,
            "spo2_2"=>  $request->spo2_2,
            "Precodialgies"=>  $request->Precodialgies,
            "ExamenduCoeur"=>  $request->ExamenduCoeur,
            "Nausees"=>  $request->Nausees,
            "Epigastralgie"=>  $request->Epigastralgie,
            "Vomissements"=>  $request->Vomissements,
            "Pyrasis"=>  $request->Pyrasis,
            "Diarrhees"=>  $request->Diarrhees,
            "UlceresGD"=>  $request->UlceresGD,
            "Diures"=>  $request->Diures,
            "Autres1"=>  $request->Autres1,
            "Systeme_nerveux"=>  $request->Systeme_nerveux,
            "Autres2"=>  $request->Autres2,

            "TraitementEncours"=>  $request->TraitementEncours,
            "Malformations"=>  $request->Malformations,
            "Prothese"=>  $request->Prothese,
            "Obesite"=>  $request->Obesite,

            "Estomac_plein"=>  $request->Estomac_plein,
            "Ouverture_Bucale"=>  $request->Ouverture_Bucale,
            "Distance_thyro"=>  $request->Distance_thyro,
            "Mobilite_cervicale"=>  $request->Mobilite_cervicale,
            "Lips_Test"=>  $request->Lips_Test,
            "Mallampatie"=>  $request->Mallampatie,
            "Prediction_intubation"=>  $request->Prediction_intubation,
            "Consculsion_CPA"=>  $request->Consculsion_CPA,
            "Premedication"=>  $request->Premedication,
            "Typeanesthesie"=>  $request->Typeanesthesie,
            "AutresTypeAnesthesie"=>  $request->AutresTypeAnesthesie,
            "Protocole_CPA"=>  $request->Protocole_CPA,
            "ConsentementEclaire"=>  $request->ConsentementEclaire,
                                                                   
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = top_cons_preanesthesie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
