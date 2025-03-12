<?php

namespace App\Http\Controllers\Imagerie;
//
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_imagerie;

use App\Models\tentetetriage;
use App\Models\tdetailtriage;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;

use App\Traits\{GlobalMethod,Slug};

use DB;


class timagerieController extends Controller
{
 
    use GlobalMethod, Slug;

    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    {          
     

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'serviceProvenance','medecindemandeur',
            'urgent',"CNOM","examenDemande","tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie.status','Validé'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],         
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],         
                ['TypeOrientation','MATERNITE'],
                ['tim_imagerie.deleted','NON']
            ]) 
            //['TypeOrientation','MATERNITE'],          
            ->orderBy("tim_imagerie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'serviceProvenance',
            'medecindemandeur','urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([                      
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie.status','Validé'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([        
                ['tmouvement.Statut','Encours'],         
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([       
                ['tmouvement.Statut','Encours'],         
                ['TypeOrientation','MATERNITE'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_finance(Request $request)
    {          
     

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
            'medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie.status','Attente'],
                ['tim_imagerie.deleted','NON']
            ])           
            ->orderBy("tim_imagerie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
            'medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([          
                ['tmouvement.Statut','Encours'],
                ['tim_imagerie.status','Attente'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }
 


    public function fetch_imagerie_consultation(Request $request,$refDetailConst)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
            'medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],
                ['tim_imagerie.deleted','NON']
            ])                  
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
            'medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],
                ['tim_imagerie.deleted','NON']
            ])    
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 


    public function fetch_imagerie_consultation_valide(Request $request,$refDetailConst)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance','medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],
                ['tim_imagerie.status','Validé'],
                ['tim_imagerie.deleted','NON']
            ]) 
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],       
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],       
                ['TypeOrientation','MATERNITE'],
                ['tim_imagerie.deleted','NON']
            ]) 
            //['TypeOrientation','MATERNITE'],                
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
            'medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],
                ['tim_imagerie.status','Validé'],
                ['tim_imagerie.deleted','NON']
            ])
            ->orWhere([
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],         
                ['categoriemaladiemvt','ABONNE(E)'],
                ['tim_imagerie.deleted','NON']
            ]) 
            ->orWhere([
                ['tmouvement.Statut','Encours'],
                ['refDetailConst',$refDetailConst],       
                ['TypeOrientation','MATERNITE'],
                ['tim_imagerie.deleted','NON']
            ])   
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

        // 

    } 





    function fetch_single_Imagerie($id)
    {
        $data = DB::table('tim_imagerie')
        ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
  
        ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
        "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
        'medecindemandeur',"CNOM","examenDemande",
        "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
        "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tim_imagerie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    //medecindemandeur

 function insertData(Request $request)
 {

    $nom_uniteproduction=$request->serviceProvenance;


    if($nom_uniteproduction == 'HOSPITALISATION')
    {
        $data= tim_imagerie::create([
            'refDetailConst' =>  $request->refDetailConst,
            'refAnalyse'       => $request->refAnalyse,
            'dateImagerie'     =>   $request->dateImagerie,
            'clinique'         =>  $request->clinique,    
            'but'              => $request->but,
            'urgent'              => $request->urgent,
            'serviceProvenance'              => $request->serviceProvenance,
            'medecindemandeur'              => $request->medecindemandeur,
            'medecinProtocolaire' =>   $request->medecinProtocolaire,
            'specialiste'      =>  $request->specialiste,  
            'CNOM'             => $request->CNOM,
            'examenDemande'    =>   $request->examenDemande, 
            'status'    =>  'Validé',                              
            'author'           => $request->author         
         ]);

         $idEnteteCons=0;

         $consList = DB::table('tdetailconsultation')
         ->select("tdetailconsultation.id","refEnteteCons")
         ->where([
             ['tdetailconsultation.id',$request->refDetailConst]
         ])
         ->get();
         foreach ($consList as $liste_mvt) {
             $idEnteteCons= $liste_mvt->refEnteteCons;
         }
         $data = tenteteconsulter::where('id', $idEnteteCons)->update([
             'parcours'    => 'Imagerie' 
         ]);
    
    
         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }
    else
    {
        $data= tim_imagerie::create([
            'refDetailConst' =>  $request->refDetailConst,
            'refAnalyse'       => $request->refAnalyse,
            'dateImagerie'     =>   $request->dateImagerie,
            'clinique'         =>  $request->clinique,    
            'but'              => $request->but,
            'urgent'              => $request->urgent,
            'serviceProvenance'              => $request->serviceProvenance,
            'medecindemandeur'              => $request->medecindemandeur,
            'medecinProtocolaire' =>   $request->medecinProtocolaire,
            'specialiste'      =>  $request->specialiste,  
            'CNOM'             => $request->CNOM,
            'examenDemande'    =>   $request->examenDemande,                               
            'author'           => $request->author         
         ]);

         $idEnteteCons=0;

         $consList = DB::table('tdetailconsultation')
         ->select("tdetailconsultation.id","refEnteteCons")
         ->where([
             ['tdetailconsultation.id',$request->refDetailConst]
         ])
         ->get();
         foreach ($consList as $liste_mvt) {
             $idEnteteCons= $liste_mvt->refEnteteCons;
         }
         $data = tenteteconsulter::where('id', $idEnteteCons)->update([
             'parcours'    => 'Imagerie' 
         ]);
    
         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }
    
 }


//  this.svData.medecinProtocolaire = item.medecinProtocolaire;
//             this.svData.specialiste = item.specialiste;
//             this.svData.CNOM = item.CNOM;

 function updateData(Request $request)
 {
    $data= tim_imagerie::where('id',$request->id)->update([
        'refDetailConst'=>$request->refDetailConst,
        'refAnalyse'       =>$request->refAnalyse,
        'dateImagerie'     =>  $request->dateImagerie,
        'clinique'         => $request->clinique,    
        'but'              =>$request->but,
        'urgent'              =>$request->urgent,
        'serviceProvenance'              => $request->serviceProvenance,
        'medecindemandeur'              => $request->medecindemandeur,
        'medecinProtocolaire' =>  $request->medecinProtocolaire,
        'specialiste'      => $request->specialiste,  
        'CNOM'             =>$request->CNOM,
        'examenDemande'    =>  $request->examenDemande,
        'specialiste'    =>  $request->specialiste,                                
        'author'           => $request->author    
     ]);

     $idEnteteCons=0;

     $consList = DB::table('tdetailconsultation')
     ->select("tdetailconsultation.id","refEnteteCons")
     ->where([
         ['tdetailconsultation.id',$request->refDetailConst]
     ])
     ->get();
     foreach ($consList as $liste_mvt) {
         $idEnteteCons= $liste_mvt->refEnteteCons;
     }
     $data = tenteteconsulter::where('id', $idEnteteCons)->update([
         'parcours'    => 'Resultats' 
     ]);

     return response()->json([
        'data'  =>  "Modification avec succès!!",
    ]);   
 }

    function update_statuteimagerie(Request $request,$id)
    {

        $data= tim_imagerie::where('id',$id)->update([
            'status'    =>  $request->status,             
            'author'       =>  $request->author   
         ]);
    
         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]); 


    }





    function fetch_max_imagerie_externe(Request $request)
    {

        $refMouvement=$request->refMouvement;
        $refMedecin=$request->refMedecin;
        $author=$request->author;
        $refTypeCons=$request->refTypeCons;
        $refService=$request->refService;

        $refAnalyse=$request->refAnalyse;
        $dateImagerie=$request->dateImagerie;
        $clinique=$request->clinique;    
        $but=$request->but;
        $urgent=$request->urgent;
        $serviceProvenance=$request->serviceProvenance;
        $medecindemandeur=$request->medecindemandeur;
        $medecinProtocolaire=$request->medecinProtocolaire;
        $specialiste=$request->specialiste;  
        $CNOM=$request->CNOM;
        $examenDemande=$request->examenDemande;                               
        $author=$request->author; 


        $data = tentetetriage::create([
            'refMouvement'       =>  $refMouvement,
            'dateTriage'    =>  date('Y-m-d'),                      
            'author'       =>  $author
        ]);

        $id_entete_triage_max=0;
        $enteteTriage = DB::table('tentetetriage')      
        ->selectRaw('MAX(tentetetriage.id) as code_entete_triage')
        ->where([
            ['tentetetriage.refMouvement',$refMouvement]
        ])
        ->get();
        foreach ($enteteTriage as $list) {
            $id_entete_triage_max= $list->code_entete_triage;
        }


        $data1 = tdetailtriage::create([
            'refEnteteTriage'       =>  $id_entete_triage_max,
            'plainte_triage'       =>  "Externe",
            'antecedent_trige'       => "Externe",
            'cas_triage'       =>  "Nouveau Cas",
            'Poids'    =>  0,
            'Taille'    =>  0,
            'TA'    =>  '40-60',
            'Temperature'    =>  0,
            'FC'    =>  0,
            'FR'    => 0,
            'Oxygene'    =>  0,                      
            'author'       =>  'admin'
        ]);
        $id_detail_triage_max=0;
        $detailTriage = DB::table('tdetailtriage')      
        ->selectRaw('MAX(tdetailtriage.id) as code_detail_triage')
        ->where([
            ['tdetailtriage.refEnteteTriage',$id_entete_triage_max]
        ])
        ->get();
        foreach ($detailTriage as $list) {
            $id_detail_triage_max= $list->code_detail_triage;
        }


        $data2 = tenteteconsulter::create([
            'refDetailTriage'       =>  $id_detail_triage_max,
            'refMedecin'    =>  $refMedecin,
            'TypeOrientation'    =>  'URGENCES',
            'dateConsultation'    =>  date('Y-m-d'),    
            'cloture'    =>  'NON',
            'refLitUrgence'    =>  1,
            'parcours'    => 'Consultation',       
            'author'       =>  $author
        ]);
        $id_entete_cons_max=0;
        $enteteCons = DB::table('tenteteconsulter')      
        ->selectRaw('MAX(tenteteconsulter.id) as code_entete_cons')
        ->where([
            ['tenteteconsulter.refDetailTriage',$id_detail_triage_max]
        ])
        ->get();
        foreach ($enteteCons as $list) {
            $id_entete_cons_max= $list->code_entete_cons;
        }



        $data3 = tdetailconsultation::create([
            'refEnteteCons'       =>   $id_entete_cons_max,
            'refTypeCons'    =>  $refTypeCons,
            'plainte'    =>  'Consultation Exrtene',
            'historique'    =>  'Consultation Exrtene',
            'antecedent'    =>  'Consultation Exrtene',
            'complementanamnese'    =>  'Consultation Exrtene',
            'examenphysique'    =>  'Consultation Exrtene',
            'diagnostiquePres'    =>  'Consultation Exrtene',
            'dateDetailCons'    =>  date('Y-m-d'),  
            'AutresDiagnostics'    =>  'Consultation Exrtene',            
            'author'       =>  $author
        ]);
        $id_detail_cons_max=0;
        $detailCons = DB::table('tdetailconsultation')      
        ->selectRaw('MAX(tdetailconsultation.id) as code_detail_cons')
        ->where([
            ['tdetailconsultation.refEnteteCons',$id_entete_cons_max]
        ])
        ->get();
        foreach ($detailCons as $list) {
            $id_detail_cons_max= $list->code_detail_cons;
        }



       $refDetailCons =$id_detail_cons_max;

       $data= tim_imagerie::create([
        'refDetailConst' =>  $refDetailCons,
        'refAnalyse'       => $refAnalyse,
        'dateImagerie'     =>   $dateImagerie,
        'clinique'         =>  $clinique,    
        'but'              => $but,
        'urgent'              => $urgent,
        'serviceProvenance'              => $serviceProvenance,
        'medecindemandeur'              => $medecindemandeur,
        'medecinProtocolaire' =>   'Encours',
        'specialiste'      =>  'Encours',  
        'CNOM'             => 'Encours',
        'examenDemande'    =>   'Encours',                               
        'author'           => $author         
     ]);

     $idEnteteCons=0;

     $consList = DB::table('tdetailconsultation')
     ->select("tdetailconsultation.id","refEnteteCons")
     ->where([
         ['tdetailconsultation.id',$refDetailCons]
     ])
     ->get();
     foreach ($consList as $liste_mvt) {
         $idEnteteCons= $liste_mvt->refEnteteCons;
     }
     $data = tenteteconsulter::where('id', $idEnteteCons)->update([
         'parcours'    => 'Imagerie' 
     ]);

        $idmax=0;
        $maxid = DB::table('tim_imagerie')
        ->selectRaw('MAX(tim_imagerie.id) as code_imagerie')
        ->where('tim_imagerie.refDetailConst', $refDetailCons)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_imagerie;
        }

        $data = DB::table('tim_imagerie')
        ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
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
  
        ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
        "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance',
        'medecindemandeur',"CNOM","examenDemande",
        "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
        "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->where('tim_imagerie.id', $idmax)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }














 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
     //
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function edit($id)
 {
     //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tim_imagerie::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
