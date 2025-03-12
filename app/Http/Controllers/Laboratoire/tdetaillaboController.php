<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tdetaillabo;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

class tdetaillaboController extends Controller
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
  
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
            //MALADE
            ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
            ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
            'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
            
            "texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons" ,
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
            "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tdetaillabo.deleted','NON']
            ])            
            ->orderBy("tdetaillabo.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
            //MALADE
            ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
            ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
            'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
            
            "texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons" ,
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
            "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([         
                ['tdetaillabo.deleted','NON']
            ])
            ->orderBy("tdetaillabo.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
            //MALADE
            ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
            ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
            'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
            
            "texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons" ,
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
            "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tdetaillabo.refEnteteLabo',$refEntete],
                ['tdetaillabo.deleted','NON']
            ])            
            ->orderBy("tdetaillabo.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
            //MALADE
            ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
            ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
            'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
            
            "texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons" ,
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
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
            "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
            "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['tdetaillabo.refEnteteLabo',$refEntete],
                ['tdetaillabo.deleted','NON']
            ]) 
            ->orderBy("tdetaillabo.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    
    

    function fetch_single_detail($id)
    {
        $data = DB::table('tdetaillabo')
        ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
        //MALADE
        ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
        ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
        'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
        
        "texamen.designation as designationEx","refCatexamen",
        "tcategorieexament.designation as designationCatEx","refGrandCategorie",
        "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons" ,
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
        "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
        "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
        "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
        ->where('tdetaillabo.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'refEnteteLabo','refValeur','libelle','observation','author
    function insert_detail(Request $request)
    {
       
        $data = tdetaillabo::create([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refValeur'    =>  $request->refValeur,
            'libelle'    =>  $request->libelle,
            'observation'    =>  $request->observation,
            'natureechantillon'    =>  $request->natureechantillon,
            'methode'    =>  $request->methode,
            'commentaire'    =>  $request->commentaire,                     
            'author'       =>  $request->author
        ]);

        $idEnteteCons=0;

        $consList = DB::table('tentetelabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
        //MALADE
        ->select("tentetelabo.id","refEnteteCons")
        ->where([
            ['tentetelabo.id',$request->refEnteteLabo]
        ])
        ->get();
        foreach ($consList as $liste_mvt) {
            $idEnteteCons= $liste_mvt->refEnteteCons;
        }
        $data = tenteteconsulter::where('id', $idEnteteCons)->update([
            'parcours'    => 'Resultats' 
        ]);


        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }
//,'natureechantillon','methode','commentaire'
    function update_detail(Request $request, $id)
    {
        $data = tdetaillabo::where('id', $id)->update([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refValeur'    =>  $request->refValeur,
            'libelle'    =>  $request->libelle,
            'observation'    =>  $request->observation,
            'natureechantillon'    =>  $request->natureechantillon,
            'methode'    =>  $request->methode,
            'commentaire'    =>  $request->commentaire,                     
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tdetaillabo::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);       
    }

    function get_paie_Labo($refMouvement)
    {
        $data = DB::table('tdetailpaiement')
        ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
        ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
        ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //SUM(montantpaie)
        //IFNULL(vsommationvente.TotalVente,0)
        ->select("refMouvement", DB::raw('IFNULL(montantpaie,0) as total_paie'))
        ->where([
            ['refMouvement',$refMouvement],
            ['tconf_frais.designation','LABORATOIRE']
        ])       
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    
}
