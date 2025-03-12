<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tlabo_resultat_sperme;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

class tlabo_resultat_spermeController extends Controller
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
    //tlabo_nature_echantillon
    //'id','refEnteteLabo','refNatureEchantillon','designation_valeur','author'
    public function all(Request $request)
    { 
        $data = DB::table('tlabo_resultat_sperme')
        ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
        ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
        ->join('avenues', 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        //MALADE
        ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur','refDetailCons',
        "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
        "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author",
        'refService','dateprelevement','numroRecu','MedecinDemandeur','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tlabo_resultat_sperme.created_at", 
        "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
        "tcategorieexament.designation as designationCatEx","refGrandCategorie",
        "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
        "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
        "contactPersRef_malade","organisation_malade","numeroCarte_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade');
  
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlabo_resultat_sperme.deleted','NON']
            ])            
            ->orderBy("tlabo_resultat_sperme.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_resultat_sperme')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->join('avenues', 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')
            //MALADE
            ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur','refDetailCons',
            "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
            "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author",
            'refService','dateprelevement','numroRecu','MedecinDemandeur','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tlabo_resultat_sperme.created_at", 
            "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->where([       
                ['tlabo_resultat_sperme.deleted','NON']
            ])           
            ->orderBy("tlabo_resultat_sperme.id", "desc")
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

            $data = DB::table('tlabo_resultat_sperme')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->join('avenues', 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')
            //MALADE
            ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur','refDetailCons',
            "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
            "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author",
            'refService','dateprelevement','numroRecu','MedecinDemandeur','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tlabo_resultat_sperme.created_at", 
            "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tlabo_resultat_sperme.refEnteteLabo',$refEntete],
                ['tlabo_resultat_sperme.deleted','NON']
            ])            
            ->orderBy("tlabo_resultat_sperme.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlabo_resultat_sperme')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->join('avenues', 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')
            //MALADE
            ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur','refDetailCons',
            "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
            "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author",
            'refService','dateprelevement','numroRecu','MedecinDemandeur','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tlabo_resultat_sperme.created_at", 
            "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tlabo_resultat_sperme.refEnteteLabo',$refEntete],
                ['tlabo_resultat_sperme.deleted','NON']
            ])
            ->orderBy("tlabo_resultat_sperme.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    
    

    function fetch_single_detail($id)
    {
        $data = DB::table('tlabo_resultat_sperme')
        ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
        ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tentetelabo.refDetailCons')
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
        ->join('avenues', 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        //MALADE
        ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur','refDetailCons',
        "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
        "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author"
        , "tlabo_resultat_sperme.created_at", "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
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
        "contactPersRef_malade","organisation_malade","numeroCarte_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tlabo_resultat_sperme.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refEnteteLabo','refNatureEchantillon','designation_valeur','author'
    function insert_data(Request $request)
    {
       
        $data = tlabo_resultat_sperme::create([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refNatureEchantillon'    =>  $request->refNatureEchantillon,
            'designation_valeur'    =>  $request->designation_valeur, 
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
    function update_data(Request $request, $id)
    {
        $data = tlabo_resultat_sperme::where('id', $id)->update([
            'refEnteteLabo'       =>  $request->refEnteteLabo,
            'refNatureEchantillon'    =>  $request->refNatureEchantillon,
            'designation_valeur'    =>  $request->designation_valeur, 
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlabo_resultat_sperme::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);       
    }

 


    
}
