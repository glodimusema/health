<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tlabo_detail_examencolore;
use DB;

class tlabo_detail_examencoloreController extends Controller
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

            $data = DB::table('tlabo_detail_examencolore')
            ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_examencolore.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
            "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlabo_detail_examencolore.deleted','NON']
            ])            
            ->orderBy("tlabo_detail_examencolore.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_detail_examencolore')
            ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_examencolore.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
            "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([          
                ['tlabo_detail_examencolore.deleted','NON']
            ])
            ->orderBy("tlabo_detail_examencolore.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_data_entete(Request $request,$refResultatBacterie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_detail_examencolore')
            ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_examencolore.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
            "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refResultatBacterie',$refResultatBacterie],
                ['tlabo_detail_examencolore.deleted','NON']
            ])                    
            ->orderBy("tlabo_detail_examencolore.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlabo_detail_examencolore')
            ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_examencolore.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
            "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refResultatBacterie',$refResultatBacterie],
                ['tlabo_detail_examencolore.deleted','NON']
            ])    
            ->orderBy("tlabo_detail_examencolore.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    function fetch_single_data($id)
    {

        $data = DB::table('tlabo_detail_examencolore')
        ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
        ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
        ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
        ->select("tlabo_detail_examencolore.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
        'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
        'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
        'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
        "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
        "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
        "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
        "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
        "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
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
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tlabo_detail_examencolore.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

   //'id','refResultatBacterie','refExamenColore','Resultatexamen','author'

    function insert_data(Request $request)
    {
       
        $data = tlabo_detail_examencolore::create([
            'refResultatBacterie'       =>  $request->refResultatBacterie,
            'refExamenColore'    =>  $request->refExamenColore, 
            'Resultatexamen'    =>  $request->Resultatexamen,                  
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tlabo_detail_examencolore::where('id', $id)->update([
            'refResultatBacterie'       =>  $request->refResultatBacterie,
            'refExamenColore'    =>  $request->refExamenColore,  
            'Resultatexamen'    =>  $request->Resultatexamen,                
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlabo_detail_examencolore::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
