<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tentetelabo;
use DB;

class tentetelaboController extends Controller
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

            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')            
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')      
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')      
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tentetelabo.deleted','NON']
            ])            
            ->orderBy("tentetelabo.id", "desc")          
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([          
                ['tentetelabo.deleted','NON']
            ])
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_entete_labo(Request $request,$refEntetePrelevement)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
             ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntetePrelevement',$refEntetePrelevement],
                ['statutentetelabo','Validé'],          
                ['tentetelabo.deleted','NON']
            ])  
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntetePrelevement',$refEntetePrelevement],     
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tentetelabo.deleted','NON']
            ]) 
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntetePrelevement',$refEntetePrelevement],     
                ['TypeOrientation','MATERNITE'],
                ['tentetelabo.deleted','NON']
            ])   
            //['TypeOrientation','MATERNITE'],            
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')           
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['refEntetePrelevement',$refEntetePrelevement],
                ['statutentetelabo','Validé'],          
                ['tentetelabo.deleted','NON']
            ]) 
            ->orWhere([
                ['refEntetePrelevement',$refEntetePrelevement],     
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tentetelabo.deleted','NON']
            ]) 
            ->orWhere([
                ['refEntetePrelevement',$refEntetePrelevement],     
                ['TypeOrientation','MATERNITE'],
                ['tentetelabo.deleted','NON']
            ])  
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 


    public function fetch_entete_labo_medecin(Request $request,$refEntetePrelevement)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntetePrelevement',$refEntetePrelevement],          
                ['tentetelabo.deleted','NON']
            ])                  
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['refEntetePrelevement',$refEntetePrelevement],          
                ['tentetelabo.deleted','NON']
            ])  
            //   
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 

    
    
    public function fetch_entete_labo_attente(Request $request,$refEntetePrelevement)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin',
            'dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at","tenteteconsulter.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntetePrelevement',$refEntetePrelevement],
                ['statutentetelabo','Attente'],          
                ['tentetelabo.deleted','NON']
            ])                  
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['refEntetePrelevement',$refEntetePrelevement],
                ['statutentetelabo','Attente'],          
                ['tentetelabo.deleted','NON']
            ])    
            ->orderBy("tentetelabo.id", "desc")
            ->paginate(80);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    


    //mes scripts
    function fetch_list_ValeurForExam($refExamen)
    {
        $data = DB::table('tvaleurnormale')
        ->select("tvaleurnormale.id","tvaleurnormale.designation")
        ->Where('refExamen',$refExamen) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_ExamenForCat($refCatexamen)
    {
        $data = DB::table('texamen')
        ->select("texamen.id","texamen.designation")
        ->Where('refCatexamen',$refCatexamen) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_CatexamenForGrandCat($refGrandCategorie)
    {
        $data = DB::table('tcategorieexament')
        ->select("tcategorieexament.id","tcategorieexament.designation")
        ->Where('refGrandCategorie',$refGrandCategorie) 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_GrandCategorie()
    {
        $data = DB::table('tgcategorieexament')
        ->select("tgcategorieexament.id","tgcategorieexament.designation")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = DB::table('tentetelabo')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')        
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
        ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
        ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        //MALADE
        ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
        'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
        'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
        "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
        "tcategorieexament.designation as designationCatEx","refGrandCategorie",
        "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique",
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
        "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
        "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
        "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
        ->where('tentetelabo.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    // function fetch_examen_episode($refMouvement)
    // {

    //     $data = DB::table('tentetelabo')
    //     ->join('texamen','texamen.id','=','tentetelabo.refExamen')
    //     ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
    //     ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
    //     ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    //     ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')        
    //     ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
    //     ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
    //     ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
    //     ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
    //     ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
    //     ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
    //     ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
    //     ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
    //     ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
    //     ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
    //     ->join('tclient','tclient.id','=','tmouvement.refMalade')
    //     ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    //     ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
    //     ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    //     ->join('communes' , 'communes.id','=','quartiers.idCommune')
    //     ->join('villes' , 'villes.id','=','communes.idVille')
    //     ->join('provinces' , 'provinces.id','=','villes.idProvince')
    //     ->join('pays' , 'pays.id','=','provinces.idPays')
    //     ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
    //     ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
    //     //MALADE
    //     ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
    //     'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
    //     'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
    //     'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
    //     "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
    //     "tcategorieexament.designation as designationCatEx","refGrandCategorie",
    //     "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
    //     "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
    //     "historique","antecedent","complementanamnese","examenphysique",
    //     "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
    //     "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
    //     "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
    //     "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
    //     "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
    //     "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
    //     "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
    //     "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
    //     "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    //     "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    //     "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
    //     "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    //     "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    //     "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
    //     "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    //     "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
    //     "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
    //     "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
    //     ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    //     ->where('refMouvement', $refMouvement)
    //     ->get();

    //     return response()->json([
    //     'data' => $data,
    //     ]);
    // }

   //'refDetailCons','refExamen','dateLabo','serviceProvenance','author'
    function insert_entete(Request $request)
    {
        $nom_uniteproduction='';

        $ent = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        //MALADE
        ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
        "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
         "tlabo_entete_prelevement.updated_at")
        ->where([        
            ['tlabo_entete_prelevement.id',$request->refEntetePrelevement]
        ]) ->get();
 
        foreach ($ent as $entete) {
            $nom_uniteproduction= $entete->nom_uniteproduction;
        }

        $paquet= $request->type_paquet;
        $refCatexamen = $request->refCatexamen;
        $idExamen = 0 ;

        if($nom_uniteproduction == 'HOSPITALISATION')
        {
            if($paquet == "Selection par paquet"){

                $Examens = DB::table('texamen')
                ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
                ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
                ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
                ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
                "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
                "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube",
                "designationTube","couleurTube")
                ->where([
                    ['texamen.refCatexamen',$refCatexamen]
                ])
                ->get();
                foreach ($Examens as $list) {
                    $idExamen= $list->id;

                    $data = tentetelabo::create([
                        'refEntetePrelevement' =>  $request->refEntetePrelevement,
                        'refExamen' =>  $idExamen,
                        'serviceProvenance' =>  $request->serviceProvenance,
                        'dateLabo' =>  date('Y-m-d'), 
                        'statutentetelabo' =>  'Validé',                  
                        'author'  =>  $request->author
                    ]);
                    $data2 = tlabo_entete_prelevement::where('id', $request->refEntetePrelevement)->update([             
                        'statutprelevement'    =>  'Validé', 
                        'preleveur'    =>  'OUI',             
                        'author'       =>  $request->author
                    ]);

                }

            }
            else
            {
                $data = tentetelabo::create([
                    'refEntetePrelevement'       =>  $request->refEntetePrelevement,
                    'refExamen'    =>  $request->refExamen,
                    'serviceProvenance'    =>  $request->serviceProvenance,
                    'dateLabo'    =>  date('Y-m-d'), 
                    'statutentetelabo'    =>  'Validé',                  
                    'author'       =>  $request->author
                ]);
    
                $data2 = tlabo_entete_prelevement::where('id', $request->refEntetePrelevement)->update([             
                    'statutprelevement'    =>  'Validé', 
                    'preleveur'    =>  'OUI',             
                    'author'       =>  $request->author
                ]);
    
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }

        }
        else
        {
            if($paquet == "Selection par paquet")
            {

                $Examens = DB::table('texamen')
                ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
                ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
                ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
                ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
                "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
                "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube",
                "designationTube","couleurTube")
                ->where([
                    ['texamen.refCatexamen',$refCatexamen]
                ])
                ->get();
                foreach ($Examens as $list) {
                    $idExamen= $list->id;

                    $data = tentetelabo::create([
                        'refEntetePrelevement' =>  $request->refEntetePrelevement,
                        'refExamen' =>  $idExamen,
                        'serviceProvenance' =>  $request->serviceProvenance,
                        'dateLabo' =>  date('Y-m-d'),                  
                        'author'  =>  $request->author
                    ]);                   

                }

            }
            else
            {
                $data = tentetelabo::create([
                    'refEntetePrelevement'       =>  $request->refEntetePrelevement,
                    'refExamen'    =>  $request->refExamen,
                    'serviceProvenance'    =>  $request->serviceProvenance,
                    'dateLabo'    =>  date('Y-m-d'),                  
                    'author'       =>  $request->author
                ]);    
  
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
        }
       

    }

    //statutentetelabo
    function update_entete(Request $request, $id)
    {
        $data = tentetelabo::where('id', $id)->update([
            'refEntetePrelevement'       =>  $request->refEntetePrelevement,
            'refExamen'    =>  $request->refExamen,
            'serviceProvenance'    =>  $request->serviceProvenance,                      
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_statutexamen(Request $request, $id)
    {
        $data = tentetelabo::where('id', $id)->update([             
            'statutentetelabo'    =>  'Validé',             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tentetelabo::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }


    












}
