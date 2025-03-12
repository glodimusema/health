<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chirurgie\tope_entetesurveillance;
use DB;

class tentetesurveillanceController extends Controller
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
        
    // ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tope_entetesurveillance')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
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
            ->select("tope_entetesurveillance.id",'refAnesthesie','tope_entetesurveillance.refDepartement',
            'tfin_uniteproduction.refDepartement as refDepartementUnite',
            'nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            'dateSurveillance','tope_entetesurveillance.chirurgien','tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires',            
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_entetesurveillance.created_at",
    
             "tope_entetesurveillance.author", "tope_entetesurveillance.created_at", "tope_entetesurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
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
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tope_entetesurveillance.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_entetesurveillance')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
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
            ->select("tope_entetesurveillance.id",'refAnesthesie','tope_entetesurveillance.refDepartement',
            'tfin_uniteproduction.refDepartement as refDepartementUnite',
            'nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            'dateSurveillance','tope_entetesurveillance.chirurgien','tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires',            
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_entetesurveillance.created_at",
    
             "tope_entetesurveillance.author", "tope_entetesurveillance.created_at", "tope_entetesurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
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
            ->orderBy("tope_entetesurveillance.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refAnesthesie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tope_entetesurveillance')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
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
            ->select("tope_entetesurveillance.id",'refAnesthesie','tope_entetesurveillance.refDepartement',
            'tfin_uniteproduction.refDepartement as refDepartementUnite',
            'nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            'dateSurveillance','tope_entetesurveillance.chirurgien','tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires',            
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_entetesurveillance.created_at",
    
             "tope_entetesurveillance.author", "tope_entetesurveillance.created_at", "tope_entetesurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
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
                ['refAnesthesie',$refAnesthesie]
            ])                    
            ->orderBy("tope_entetesurveillance.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tope_entetesurveillance')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_entetesurveillance.refAnesthesie')
            ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
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
            ->select("tope_entetesurveillance.id",'refAnesthesie','tope_entetesurveillance.refDepartement',
            'tfin_uniteproduction.refDepartement as refDepartementUnite',
            'nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            'dateSurveillance','tope_entetesurveillance.chirurgien','tope_entetesurveillance.anesthesiste',
            'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
            'autresCommentaires',            
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_entetesurveillance.created_at",
    
             "tope_entetesurveillance.author", "tope_entetesurveillance.created_at", "tope_entetesurveillance.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
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
            ->Where('refAnesthesie',$refAnesthesie)    
            ->orderBy("tope_entetesurveillance.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

 

    function fetch_single_detail($id)
    {

        $data = DB::table('tope_entetesurveillance')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tope_entetesurveillance.refDepartement')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_entetesurveillance.refAnesthesie')
        ->join('tope_enteteoperation','tope_enteteoperation.id','=','top_cons_preanesthesie.refEnteteOperation')
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
        ->select("tope_entetesurveillance.id",'refAnesthesie','tope_entetesurveillance.refDepartement',
        'tfin_uniteproduction.refDepartement as refDepartementUnite',
        'nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
        'dateSurveillance','tope_entetesurveillance.chirurgien','tope_entetesurveillance.anesthesiste',
        'infirmierSalle','heureAdmiSalle','heureDebutInterv','diagnosticOpe','acteOpe','heureFin',
        'autresCommentaires',            
        
        "TypeIntervension","diagnostic_preoperatoire",
        "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
        "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
        "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
        "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
        "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
        "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
        "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
        "tope_entetesurveillance.created_at",

         "tope_entetesurveillance.author", "tope_entetesurveillance.created_at", "tope_entetesurveillance.updated_at",
        "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
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
        ->where('tope_entetesurveillance.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

    function insert_detail(Request $request)
    {
       
        $data = tope_entetesurveillance::create([
            'refAnesthesie'       =>  $request->refAnesthesie,
            "refDepartement"=>  $request->refDepartement,
            "dateSurveillance"=>  $request->dateSurveillance,
            "chirurgien"=>  $request->chirurgien,
            "anesthesiste"=>  $request->anesthesiste,
            "infirmierSalle"=>  $request->infirmierSalle,
            "heureAdmiSalle"=>  $request->heureAdmiSalle,
            "heureDebutInterv"=>  $request->heureDebutInterv,
            "diagnosticOpe"=>  $request->diagnosticOpe,
            "acteOpe"=>  $request->acteOpe,
            "heureFin"=>  $request->heureFin,
            "autresCommentaires"=>  $request->autresCommentaires,                             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detail(Request $request, $id)
    {
        $data = tope_entetesurveillance::where('id', $id)->update([
            'refAnesthesie'       =>  $request->refAnesthesie,
            "refDepartement"=>  $request->refDepartement,
            "dateSurveillance"=>  $request->dateSurveillance,
            "chirurgien"=>  $request->chirurgien,
            "anesthesiste"=>  $request->anesthesiste,
            "infirmierSalle"=>  $request->infirmierSalle,
            "heureAdmiSalle"=>  $request->heureAdmiSalle,
            "heureDebutInterv"=>  $request->heureDebutInterv,
            "diagnosticOpe"=>  $request->diagnosticOpe,
            "acteOpe"=>  $request->acteOpe,
            "heureFin"=>  $request->heureFin,
            "autresCommentaires"=>  $request->autresCommentaires,                             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tope_entetesurveillance::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
