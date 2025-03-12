<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tlabo_annexe;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

class tlabo_annexeController extends Controller
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

            $data = DB::table('tlabo_annexe')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_annexe.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
            ->select("tlabo_annexe.id","tlabo_annexe.refEnteteLabo","pdfLabo","descriptionImage","refEntetePrelevement",
            "tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tlabo_annexe.author", "tlabo_annexe.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_annexe.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tlabo_annexe.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_annexe')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_annexe.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
            ->select("tlabo_annexe.id","tlabo_annexe.refEnteteLabo","pdfLabo","descriptionImage","refEntetePrelevement",
            "tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tlabo_annexe.author", "tlabo_annexe.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_annexe.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            ->orderBy("tlabo_annexe.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_date_entete(Request $request,$refEnteteLabo)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_annexe')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_annexe.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
            ->select("tlabo_annexe.id","tlabo_annexe.refEnteteLabo","pdfLabo","descriptionImage","refEntetePrelevement",
            "tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tlabo_annexe.author", "tlabo_annexe.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_annexe.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tlabo_annexe.refEnteteLabo',$refEnteteLabo],
                ['statutentetelabo','Validé']
            ])                  
            ->orderBy("tlabo_annexe.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlabo_annexe')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_annexe.refEnteteLabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
            ->select("tlabo_annexe.id","tlabo_annexe.refEnteteLabo","pdfLabo","descriptionImage","refEntetePrelevement",
            "tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tlabo_annexe.author", "tlabo_annexe.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_annexe.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            ->where([
                ['tlabo_annexe.refEnteteLabo',$refEnteteLabo],
                ['statutentetelabo','Validé']
            ])    
            ->orderBy("tlabo_annexe.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 


    

    function fetch_single_data($id)
    {

        $data = DB::table('tlabo_annexe')
        ->join('tentetelabo','tentetelabo.id','=','tlabo_annexe.refEnteteLabo')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
        ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
        ->select("tlabo_annexe.id","tlabo_annexe.refEnteteLabo","pdfLabo","descriptionImage","refEntetePrelevement",
        "tentetelabo.refExamen","serviceProvenance","dateLabo",
        'statutentetelabo', "tlabo_annexe.author", "tlabo_annexe.created_at",'refDetailCons','refService','dateprelevement',
        'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
        "tlabo_annexe.updated_at","texamen.designation as designationEx","refCatexamen",
        "tcategorieexament.designation as designationCatEx","refGrandCategorie",
        "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
        "tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
        ->where('tlabo_annexe.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

   // id,refEnteteLabo,pdfLabo,descriptionImage
   function insertData(Request $request)
   {
       $idEnteteCons=0;

       if (!is_null($request->image)) 
       {
          $formData = json_decode($_POST['data']);
           $imageName = time().'.'.$request->image->getClientOriginalExtension();          
           $request->image->move(public_path('/fichier'), $imageName); 
  
           $data= tlabo_annexe::create([
               'refEnteteLabo'=>$formData->refEnteteLabo,
               'pdfLabo'=>$imageName,
               'descriptionImage'=>$formData->descriptionImage,
               'author'=>$formData->author         
           ]);          

           $consList = DB::table('tentetelabo')
           ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
           ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
           ->select("tentetelabo.id","refEnteteCons")
           ->where([
               ['tentetelabo.id',$formData->refEnteteLabo]
           ])
           ->get();
           foreach ($consList as $liste_mvt) {
               $idEnteteCons= $liste_mvt->refEnteteCons;
           }
           $data1 = tenteteconsulter::where('id', $idEnteteCons)->update([
               'parcours'    => 'Resultats' 
           ]);
  
           return response()->json([
              'data'  =>  "Insertion avec succès!!!",
          ]);
       }
       else{
          $formData = json_decode($_POST['data']);
          $data= tlabo_annexe::create([
               'refEnteteLabo'=>$formData->refEnteteLabo,
               'pdfLabo'=> 'avatar.png',
               'descriptionImage'=>$formData->descriptionImage,
               'author'=>$formData->author        
          ]);

          $idEnteteCons=0;

          $consList = DB::table('tentetelabo')
          ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
          ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
          ->select("tentetelabo.id","refEnteteCons")
          ->where([
              ['tentetelabo.id',$formData->refEnteteLabo]
          ])
          ->get();
          foreach ($consList as $liste_mvt) {
              $idEnteteCons= $liste_mvt->refEnteteCons;
          }
          $data1 = tenteteconsulter::where('id', $idEnteteCons)->update([
              'parcours'    => 'Resultats' 
          ]);

           return response()->json([
              'data'  =>  "Insertion avec succès!!!",
          ]);   
       }
  

   }
  
   function updateData(Request $request,$id)
   {  
     
   if (!is_null($request->image)) 
    {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();          
        $request->image->move(public_path('/fichier'), $imageName);
     
       $data= tlabo_annexe::where('id',$formData->id)->update([
           'refEnteteLabo'=>$formData->refEnteteLabo,
           'pdfLabo'=> $imageName,
           'descriptionImage'=>$formData->descriptionImage,
           'author'=>$formData->author   
        ]);

        return response()->json([
           'data'  =>  "Modification avec succès!!",
       ]);

    }
    else{
        $formData = json_decode($_POST['data']);
        $data= tlabo_annexe::where('id',$formData->id)->update([
           'refEnteteLabo'=>$formData->refEnteteLabo,
           'pdfLabo'=> 'avatar.png',
           'descriptionImage'=>$formData->descriptionImage,
           'author'=>$formData->author         
        ]);

        return response()->json([
           'data'  =>  "Modification avec succès!!",
       ]);

    }

   }
//
    function delete_entete($id)
    {
        $data = tlabo_annexe::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }

    public function downloadfile($filenamess)
    {
        $filepath = public_path('fichier/'.$filenamess.'');
        return response()->file($filepath);
    }
}
