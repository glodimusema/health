<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Chirurgie\tope_affectanesthesie;
use DB;

class taffectationanesthesieController extends Controller
{
    public function index()
    {
        return 'hello';
    }

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

            $data = DB::table('tope_affectanesthesie')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tope_affectanesthesie.refTypeAnesthesie')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
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
            ->select("tope_affectanesthesie.id","refEnteteAnesthesie","refTypeAnesthesie","detail_affectAnesthesie",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',
            "nom_typecompte",'nom_acte',
            
            "TypeIntervension","diagnostic_preoperatoire","antecedents_cpa","rhume","dyspnee_1",
            "Toux","spo2_1","crachats","Examen_Poumons","Palpitations","dyspnee_2","dyspnee_3",
            "spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_affectanesthesie.author","tope_affectanesthesie.created_at", 
            "tope_affectanesthesie.updated_at","refEnteteCons","refTypeCons"
            
            ,"plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
           "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
           'refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
            ['tope_affectanesthesie.deleted','NON']
            ])            
            ->orderBy("tope_affectanesthesie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_affectanesthesie')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tope_affectanesthesie.refTypeAnesthesie')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
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
            ->select("tope_affectanesthesie.id","refEnteteAnesthesie","refTypeAnesthesie","detail_affectAnesthesie",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',
            "nom_typecompte",'nom_acte',
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_affectanesthesie.author","tope_affectanesthesie.created_at", 
            "tope_affectanesthesie.updated_at","refEnteteCons","refTypeCons"
            
            ,"plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
           "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
           'refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
            ->where([[['tope_affectanesthesie.deleted','NON']]])
            ->orderBy("tope_affectanesthesie.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_entete(Request $request,$refEnteteAnesthesie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tope_affectanesthesie')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tope_affectanesthesie.refTypeAnesthesie')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
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
            ->select("tope_affectanesthesie.id","refEnteteAnesthesie","refTypeAnesthesie","detail_affectAnesthesie",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',
            "nom_typecompte",'nom_acte',
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_affectanesthesie.author","tope_affectanesthesie.created_at", 
            "tope_affectanesthesie.updated_at","refEnteteCons","refTypeCons"
            
            ,"plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
           "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
           'refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
                ['refEnteteAnesthesie',$refEnteteAnesthesie],
                ['tope_affectanesthesie.deleted','NON']
            ])                    
            ->orderBy("tope_affectanesthesie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tope_affectanesthesie')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tope_affectanesthesie.refTypeAnesthesie')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            
            ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
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
            ->select("tope_affectanesthesie.id","refEnteteAnesthesie","refTypeAnesthesie","detail_affectAnesthesie",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',
            "nom_typecompte",'nom_acte',
            
            "TypeIntervension","diagnostic_preoperatoire",
            "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
            "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
            "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
            "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
            "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
            "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
            "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
            "tope_affectanesthesie.author","tope_affectanesthesie.created_at", 
            "tope_affectanesthesie.updated_at","refEnteteCons","refTypeCons"
            
            ,"plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
           "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
           'refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
            ->Where([
            ['refEnteteAnesthesie',$refEnteteAnesthesie],
            ['tope_affectanesthesie.deleted','NON']
            ])    
            ->orderBy("tope_affectanesthesie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

 

    function fetch_single_detail($id)
    {

        $data = DB::table('tope_affectanesthesie')
        ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tope_affectanesthesie.refTypeAnesthesie')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        
        ->join('top_cons_preanesthesie','top_cons_preanesthesie.id','=','tope_affectanesthesie.refEnteteAnesthesie')
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
        ->select("tope_affectanesthesie.id","refEnteteAnesthesie","refTypeAnesthesie","detail_affectAnesthesie",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',
        "nom_typecompte",'nom_acte',
        
        "TypeIntervension","diagnostic_preoperatoire",
        "antecedents_cpa","rhume","dyspnee_1","Toux","spo2_1","crachats","Examen_Poumons","Palpitations",
        "dyspnee_2","dyspnee_3","spo2_2","Precodialgies","ExamenduCoeur","Nausees","Epigastralgie",
        "Vomissements","Pyrasis","Diarrhees","UlceresGD","Diures","Autres1","Systeme_nerveux","Autres2",
        "TraitementEncours","Malformations","Prothese","Obesite","Estomac_plein","Ouverture_Bucale",
        "Distance_thyro","Mobilite_cervicale","Lips_Test","Mallampatie","Prediction_intubation",
        "Consculsion_CPA","Premedication","Typeanesthesie","AutresTypeAnesthesie","Protocole_CPA",
        "ConsentementEclaire",'refDetailCons',"dateeneteop","tope_enteteoperation.author as MedecinDemandeur",
        "tope_affectanesthesie.author","tope_affectanesthesie.created_at", 
        "tope_affectanesthesie.updated_at","refEnteteCons","refTypeCons"
        
        ,"plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
       "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
       'refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
        ->where('tope_affectanesthesie.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

   //'id','refDetailOpe','refTypeAnesthesie','detail_affectAnesthesie','author'

    function insert_detail(Request $request)
    {
       //refEnteteAnesthesie,refTypeAnesthesie,detail_affectAnesthesie
        $data = tope_affectanesthesie::create([
            'refEnteteAnesthesie'       =>  $request->refEnteteAnesthesie,
            'refTypeAnesthesie'    =>  $request->refTypeAnesthesie,
            'detail_affectAnesthesie'    =>  $request->detail_affectAnesthesie,                           
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detail(Request $request, $id)
    {
        $data = tope_affectanesthesie::where('id', $id)->update([
            'refEnteteAnesthesie'       =>  $request->refEnteteAnesthesie,
            'refTypeAnesthesie'    =>  $request->refTypeAnesthesie,
            'detail_affectAnesthesie'    =>  $request->detail_affectAnesthesie,                           
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tope_affectanesthesie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
