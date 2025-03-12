<?php

namespace App\Http\Controllers\Neurologie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Neurologie\tnero_protocole_neurologie;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tnero_protocole_neurologieController extends Controller
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
        
    //
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tnero_protocole_neurologie')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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

            ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
            "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation",
            "tnero_protocole_neurologie.author",
            'refDetailConst', "tnero_protocole_neurologie.created_at", "tnero_protocole_neurologie.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tnero_protocole_neurologie.id", "desc")          
            ->paginate(10);

            return response()->json(
               $data
            );
           

        }
        else{
            $data = DB::table('tnero_protocole_neurologie')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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

            ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
            "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation",
            "tnero_protocole_neurologie.author",
            'refdetailConst', "tnero_protocole_neurologie.created_at", "tnero_protocole_neurologie.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->orderBy("tnero_protocole_neurologie.id", "desc")
            ->paginate(10);
                return response()->json(
                    $data
                );
            }

    }


    public function fetch_protocole_cons(Request $request,$refDetailConst)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tnero_protocole_neurologie')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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

            ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
            "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation",
            "tnero_protocole_neurologie.author",
            'refdetailConst', "tnero_protocole_neurologie.created_at", "tnero_protocole_neurologie.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refDetailConst',$refDetailConst]
            ])                    
            ->orderBy("tnero_protocole_neurologie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tnero_protocole_neurologie')
            ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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

            ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
            "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3",
            "preambule","developpement","traitementsRecus","conclusion","recomandation",
            "tnero_protocole_neurologie.author",
            'refdetailConst', "tnero_protocole_neurologie.created_at", "tnero_protocole_neurologie.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
            "tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
            "tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refDetailConst',$refDetailConst)    
            ->orderBy("tnero_protocole_neurologie.id", "desc")
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

    function fetch_single_protocole_neuro($id)
    {

        $data = DB::table('tnero_protocole_neurologie')
        ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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

        ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
        "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3",
        "preambule","developpement","traitementsRecus","conclusion","recomandation",
        "tnero_protocole_neurologie.author",'refdetailConst', "tnero_protocole_neurologie.created_at",
        "tnero_protocole_neurologie.updated_at","refEnteteCons","refTypeCons","plainte","historique",
        "antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin',
        'dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at",
        "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
        "tmedecin.photo as photo_medecin","tmedecin.slug as slug_medecin","refEnteteTriage","Poids",
        "Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tnero_protocole_neurologie.id', $id)
        ->get();

            return response()->json([
                'data'  => $data,
            ]);
    }


    function insertData(Request $request)
    {
           $data= tnero_protocole_neurologie::create([
               'refDetailConst'=>$request->refDetailConst,
               'reftyperapport'=>$request->reftyperapport,
               'medecin1'       =>  $request->medecin1,
               'specialite1'       =>  $request->specialite1,
               'cnom1'       =>  $request->cnom1,
               'medecin2'       =>  $request->medecin2,
               'specialite2'       =>  $request->specialite2,
               'cnom2'       =>  $request->cnom2,
               'medecin3'       =>  $request->medecin3,
               'specialite3'       =>  $request->specialite2,
               'cnom3'       =>  $request->cnom3,
               'preambule'       =>  $request->preambule,
               'developpement'       =>  $request->developpement,
               'traitementsRecus'       =>  $request->traitementsRecus,
               'conclusion'       =>  $request->conclusion,
               'recomandation'       =>  $request->recomandation,
               'author'           =>$request->author        
            ]);

            if($data)
            {
                return $this->msgJson('Insertion avec succès!!!');
            }
            return $this->msgJson('Erreur de creation!!');
    }
   
    function updateData(Request $request,$id)
    {
       
        $data = tnero_protocole_neurologie::where('id', $id)->update([
            'refDetailConst'=>$request->refDetailConst,
            'reftyperapport'=>$request->reftyperapport,
            'medecin1'       =>  $request->medecin1,
            'specialite1'       =>  $request->specialite1,
            'cnom1'       =>  $request->cnom1,
            'medecin2'       =>  $request->medecin2,
            'specialite2'       =>  $request->specialite2,
            'cnom2'       =>  $request->cnom2,
            'medecin3'       =>  $request->medecin3,
            'specialite3'       =>  $request->specialite2,
            'cnom3'       =>  $request->cnom3,
            'preambule'       =>  $request->preambule,
            'developpement'       =>  $request->developpement,
            'traitementsRecus'       =>  $request->traitementsRecus,
            'conclusion'       =>  $request->conclusion,
            'recomandation'       =>  $request->recomandation,
            'author'           =>$request->author        
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
   }
    function delete_protocole($id)
    {
        $data = tnero_protocole_neurologie::where('id',$id)->delete();

        if($data)
        {
         return $this->msgJson('suppression avec succès!!!');
        }
        return $this->msgJson(' Erreur de suppression!!');
        
    }
}
