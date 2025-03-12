<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\tsortiehospitaliser;
use DB;

class tsortiehospitaliserController extends Controller
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

            $data = DB::table('tsortiehospitaliser')
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
            ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",'dateSortie','diagnosticSortie','autreDetails',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
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
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')
            ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour')          
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['tsortiehospitaliser.deleted','NON']
            ])            
            ->orderBy("tsortiehospitaliser.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tsortiehospitaliser')
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
            ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",'dateSortie','diagnosticSortie','autreDetails',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
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
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle') 
            ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour') 
            ->where([
                ['tmouvement.Statut','Encours'],
                ['tsortiehospitaliser.deleted','NON']
            ])          
            ->orderBy("tsortiehospitaliser.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_sortie_hospitaliser(Request $request,$refHospitaliser)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tsortiehospitaliser')
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
            ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",'dateSortie','diagnosticSortie','autreDetails',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
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
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) * PrixSalle) as montantSalle')  
            ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour')        
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refHospitaliser',$refHospitaliser],
                ['tmouvement.Statut','Encours'],
                ['tsortiehospitaliser.deleted','NON']
            ])                    
            ->orderBy("tsortiehospitaliser.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tsortiehospitaliser')
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
            ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
            "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",'dateSortie','diagnosticSortie','autreDetails',
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
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
            ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle') 
            ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour')          
            ->where([
                ['refHospitaliser',$refHospitaliser],
                ['tmouvement.Statut','Encours'],
                ['tsortiehospitaliser.deleted','NON']
            ])    
            ->orderBy("tsortiehospitaliser.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

   function fetch_single_sortiehospitaliser($id)
    {

        $data = DB::table('tsortiehospitaliser')
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
        ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
        "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",'dateSortie','diagnosticSortie','autreDetails',
        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
        'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
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
        ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')
        ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour')           
        ->where('tsortiehospitaliser.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    // ,"medecin1","specialite1","cnom1","medecin2",
    //         "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp"
   //'id','refHospitaliser','dateSortie','diagnosticSortie','autreDetails','author'
    function insert_sortiehospitaliser(Request $request)
    {
        $states='Sortie';
        $data = tsortiehospitaliser::create([
            'refHospitaliser'       =>  $request->refHospitaliser,
            'dateSortie'    =>  $request->dateSortie,
            'diagnosticSortie'    =>  $request->diagnosticSortie,
            'autreDetails'    =>  $request->autreDetails, 
            'medecin1'    =>  $request->medecin1, 
            'specialite1'    =>  $request->specialite1, 
            'cnom1'    =>  $request->cnom1, 
            'medecin2'    =>  $request->medecin2, 
            'specialite2'    =>  $request->specialite2, 
            'cnom2'    =>  $request->cnom2, 
            'medecin3'    =>  $request->medecin3, 
            'specialite3'    =>  $request->specialite3, 
            'cnom3'    =>  $request->cnom3, 
            'dateRDV'    =>  $request->dateRDV, 
            'heureSortieHosp'    =>  $request->heureSortieHosp,                                     
            'author'       =>  $request->author
        ]);
        $data2 = DB::update(
            'update thospitalisation set statutHospi = :states where id = :refHospitaliser',
            ['states' => $states,'refHospitaliser' => $request->refHospitaliser]
        );
        // $data = thospitalisation::where('id', $request->refHospitaliser)->update([
        //     'statutHospi'       => 'Sortie'
        // ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

    }


    function update_sortiehospitaliser(Request $request, $id)
    {
        $data = tsortiehospitaliser::where('id', $id)->update([
            'refHospitaliser'       =>  $request->refHospitaliser,
            'dateSortie'    =>  $request->dateSortie,
            'diagnosticSortie'    =>  $request->diagnosticSortie,
            'autreDetails'    =>  $request->autreDetails, 
            'medecin1'    =>  $request->medecin1, 
            'specialite1'    =>  $request->specialite1, 
            'cnom1'    =>  $request->cnom1, 
            'medecin2'    =>  $request->medecin2, 
            'specialite2'    =>  $request->specialite2, 
            'cnom2'    =>  $request->cnom2, 
            'medecin3'    =>  $request->medecin3, 
            'specialite3'    =>  $request->specialite3, 
            'cnom3'    =>  $request->cnom3, 
            'dateRDV'    =>  $request->dateRDV, 
            'heureSortieHosp'    =>  $request->heureSortieHosp,                                      
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_sortiehospitaliser(Request $request)
    {
        $states='Encours';
        $data2 = DB::update(
            'update thospitalisation set statutHospi = :states where id = :refHospitaliser',
            ['states' => $states,'refHospitaliser' => $request->refHospitaliser]
        );
        $data = tsortiehospitaliser::where('refHospitaliser',$request->refHospitaliser)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
