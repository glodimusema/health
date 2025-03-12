<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\tdetailsortiehospitaliser;
use DB;

class tdetailsortiehospitaliserController extends Controller
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

            $data = DB::table('tdetailsortiehospitaliser')
            ->join('tservicehospi','tservicehospi.id','=','tdetailsortiehospitaliser.refServiceHospi')
            ->join('tsortiehospitaliser','tsortiehospitaliser.id','=','tdetailsortiehospitaliser.refSortriHospi')
            ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            ->select("tdetailsortiehospitaliser.id",'refSortriHospi','refServiceHospi','nombreJour','tdetailsortiehospitaliser.autreDetails',
            'nom_servicehospi','prix_servicehospi','refHospitaliser','dateSortie','diagnosticSortie',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailsortiehospitaliser.author","tdetailsortiehospitaliser.created_at","tdetailsortiehospitaliser.updated_at",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('(nombreJour * prix_servicehospi) as montantHospi')
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')            
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tdetailsortiehospitaliser.deleted','NON']
            ])            
            ->orderBy("tdetailsortiehospitaliser.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdetailsortiehospitaliser')
            ->join('tservicehospi','tservicehospi.id','=','tdetailsortiehospitaliser.refServiceHospi')
            ->join('tsortiehospitaliser','tsortiehospitaliser.id','=','tdetailsortiehospitaliser.refSortriHospi')
            ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            ->select("tdetailsortiehospitaliser.id",'refSortriHospi','refServiceHospi','nombreJour','tdetailsortiehospitaliser.autreDetails',
            'nom_servicehospi','prix_servicehospi','refHospitaliser','dateSortie','diagnosticSortie',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailsortiehospitaliser.author","tdetailsortiehospitaliser.created_at","tdetailsortiehospitaliser.updated_at",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('(nombreJour * prix_servicehospi) as montantHospi')
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')   
            ->where([['tdetailsortiehospitaliser.deleted','NON']])         
            ->orderBy("tsortiehospitaliser.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detail_sortie(Request $request,$refSortriHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdetailsortiehospitaliser')
            ->join('tservicehospi','tservicehospi.id','=','tdetailsortiehospitaliser.refServiceHospi')
            ->join('tsortiehospitaliser','tsortiehospitaliser.id','=','tdetailsortiehospitaliser.refSortriHospi')
            ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            ->select("tdetailsortiehospitaliser.id",'refSortriHospi','refServiceHospi','nombreJour','tdetailsortiehospitaliser.autreDetails',
            'nom_servicehospi','prix_servicehospi','refHospitaliser','dateSortie','diagnosticSortie',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailsortiehospitaliser.author","tdetailsortiehospitaliser.created_at","tdetailsortiehospitaliser.updated_at",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('(nombreJour * prix_servicehospi) as montantHospi')
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')            
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refSortriHospi',$refSortriHospi],
                ['tdetailsortiehospitaliser.deleted','NON']
            ])                    
            ->orderBy("tdetailsortiehospitaliser.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdetailsortiehospitaliser')
            ->join('tservicehospi','tservicehospi.id','=','tdetailsortiehospitaliser.refServiceHospi')
            ->join('tsortiehospitaliser','tsortiehospitaliser.id','=','tdetailsortiehospitaliser.refSortriHospi')
            ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
            ->select("tdetailsortiehospitaliser.id",'refSortriHospi','refServiceHospi','nombreJour',
            'tdetailsortiehospitaliser.autreDetails',
            'nom_servicehospi','prix_servicehospi','refHospitaliser','dateSortie','diagnosticSortie',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailsortiehospitaliser.author","tdetailsortiehospitaliser.created_at","tdetailsortiehospitaliser.updated_at",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->selectRaw('(nombreJour * prix_servicehospi) as montantHospi')
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')            
            ->Where([
                ['refSortriHospi',$refSortriHospi],
                ['tdetailsortiehospitaliser.deleted','NON']
            ])    
            ->orderBy("tdetailsortiehospitaliser.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

   function fetch_single_detailsortiehospitaliser($id)
    {

        $data = DB::table('tdetailsortiehospitaliser')
        ->join('tservicehospi','tservicehospi.id','=','tdetailsortiehospitaliser.refServiceHospi')
        ->join('tsortiehospitaliser','tsortiehospitaliser.id','=','tdetailsortiehospitaliser.refSortriHospi')
        ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
        ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
        ->join('tlit','tlit.id','=','thospitalisation.refLit')
        ->join('tsalle','tsalle.id','=','tlit.refSalle')
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
        ->select("tdetailsortiehospitaliser.id",'refSortriHospi','refServiceHospi','nombreJour',
        'tdetailsortiehospitaliser.autreDetails',
        'nom_servicehospi','prix_servicehospi','refHospitaliser','dateSortie','diagnosticSortie',
        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
        'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailsortiehospitaliser.author","tdetailsortiehospitaliser.created_at","tdetailsortiehospitaliser.updated_at",
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
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
        ->selectRaw('(nombreJour * prix_servicehospi) as montantHospi')
        ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')            
        ->where('tdetailsortiehospitaliser.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

   //'id','refSortriHospi','refServiceHospi','nombreJour','autreDetails','author'
    function insert_detailsortiehospitaliser(Request $request)
    {
       
        $data = tdetailsortiehospitaliser::create([
            'refSortriHospi'       =>  $request->refSortriHospi,
            'refServiceHospi'    =>  $request->refServiceHospi,
            'nombreJour'    =>  $request->nombreJour,
            'autreDetails'    =>  $request->autreDetails,                                     
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_detailsortiehospitaliser(Request $request, $id)
    {
        $data = tdetailsortiehospitaliser::where('id', $id)->update([
            'refSortriHospi'       =>  $request->refSortriHospi,
            'refServiceHospi'    =>  $request->refServiceHospi,
            'nombreJour'    =>  $request->nombreJour,
            'autreDetails'    =>  $request->autreDetails,                                     
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detailsortiehospitaliser($id)
    {
        $data = tdetailsortiehospitaliser::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
