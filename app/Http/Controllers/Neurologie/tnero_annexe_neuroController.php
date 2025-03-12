<?php

namespace App\Http\Controllers\Neurologie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Neurologie\tnero_annexe_neuro;
use App\Traits\{GlobalMethod,Slug};
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Response;

class tnero_annexe_neuroController extends Controller
{


    use GlobalMethod, Slug;

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
        
    //    $table->integer('refProtocole');
         //   $table->string('pdfNeuro',100);
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tnero_annexe_neuro')
            ->join('tnero_protocole_neurologie','tnero_protocole_neurologie.id','=','tnero_annexe_neuro.refProtocole')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
            ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
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

            ->select("tnero_annexe_neuro.id","pdfNeuro","medecin1","medecin2","medecin3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation","refProtocole",
            "tnero_annexe_neuro.author",
            //------------------------------------------------
            'refdetailCons',"tdiagnosticdefinitif.refmaladie",
             "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
            "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tnero_annexe_neuro.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data' => $data,
                ]);
           

        }
        else{
            $data = DB::table('tnero_annexe_neuro')
            ->join('tnero_protocole_neurologie','tnero_protocole_neurologie.id','=','tnero_annexe_neuro.refProtocole')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
            ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
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

            ->select("tnero_annexe_neuro.id","pdfNeuro","medecin1","medecin2","medecin3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation","refProtocole",
            "tnero_annexe_neuro.author",
            //------------------------------------------------
            'refdetailCons',"tdiagnosticdefinitif.refmaladie",
             "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
            "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->orderBy("tnero_annexe_neuro.id", "desc")
            ->paginate(10);
            return response()->json([
                'data' => $data,
                ]);
            }

    }


    public function fetch_neuro_cons(Request $request,$refProtocole)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tnero_annexe_neuro')
            ->join('tnero_protocole_neurologie','tnero_protocole_neurologie.id','=','tnero_annexe_neuro.refProtocole')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
            ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
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

            ->select("tnero_annexe_neuro.id","pdfNeuro","medecin1","medecin2","medecin3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation","refProtocole",
            "tnero_annexe_neuro.author",
            //------------------------------------------------
            'refdetailCons',"tdiagnosticdefinitif.refmaladie",
             "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
            "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refProtocole',$refProtocole]
            ])                    
            ->orderBy("tnero_annexe_neuro.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tnero_annexe_neuro')
            ->join('tnero_protocole_neurologie','tnero_protocole_neurologie.id','=','tnero_annexe_neuro.refProtocole')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
            ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
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

            ->select("tnero_annexe_neuro.id","pdfNeuro","medecin1","medecin2","medecin3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation","refProtocole",
            "tnero_annexe_neuro.author",
            //------------------------------------------------
            'refdetailCons',"tdiagnosticdefinitif.refmaladie",
             "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
            "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
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
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refProtocole',$refProtocole)    
            ->orderBy("tnero_annexe_neuro.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    //mes scripts
    function fetch_list_maladie()
    {
        $data = DB::table('tconf_maladie')
        ->select("tconf_maladie.id","tconf_maladie.nom_maladie")
        ->orderBy("nom_maladie", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single($id)
    {

        $data = DB::table('tnero_annexe_neuro')
        ->join('tnero_protocole_neurologie','tnero_protocole_neurologie.id','=','tnero_annexe_neuro.refProtocole')
        ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
        ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
        ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
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

        ->select("tnero_annexe_neuro.id","pdfNeuro","medecin1","medecin2","medecin3",
        "preambule","developpement","traitementsRecus","conclusion","recomandation","refProtocole",
        "tnero_annexe_neuro.author",
        //------------------------------------------------
        'refdetailCons',"tdiagnosticdefinitif.refmaladie",
         "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
        "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
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
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tnero_annexe_neuro.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }


    function insertData(Request $request)
    {
        if (!is_null($request->image)) 
        {
           $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();          
            $request->image->move(public_path('/fichier'), $imageName); 
   
            $data= tnero_annexe_neuro::create([
                'refProtocole'=>$request->refProtocole,
                'pdfNeuro'=>$request->$imageName,
                'descriptionPFD'=>$request->descriptionPFD,
                'author'=>$request->author         
            ]);
   
            return response()->json([
               'data'  =>  "Insertion avec succès!!!",
           ]);
        }
        else{
           $formData = json_decode($_POST['data']);
           $data= tnero_annexe_neuro::create([
                'refProtocole'=>$request->refProtocole,
                'pdfNeuro'=> 'avatar.png',
                'descriptionPFD'=>$request->descriptionPFD,
                'author'=>$request->author        
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
      
        $data= tnero_annexe_neuro::where('id',$formData->id)->update([
            'refProtocole'=>$request->refProtocole,
            'pdfNeuro'=> $imageName,
            'descriptionPFD'=>$request->descriptionPFD,
            'author'=>$request->author   
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 //descriptionPFD,author
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tnero_annexe_neuro::where('id',$formData->id)->update([
            'refProtocole'=>$request->refProtocole,
            'pdfNeuro'=> 'avatar.png',
            'descriptionPFD'=>$request->descriptionPFD,
            'author'=>$request->author         
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);

     }

    }
    function delete_annexe($id)
    {
        $data = tnero_annexe_neuro::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "SUppression avec succès!!",
        ]);

        
    }
//

   





}
