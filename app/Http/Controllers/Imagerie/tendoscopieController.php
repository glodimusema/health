<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_endoscopie;
use App\Traits\{GlobalMethod,Slug};
use DB;


class tendoscopieController extends Controller
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

            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['tim_endoscopie.deleted','NON']
            ])           
            ->orderBy("tim_endoscopie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['tim_endoscopie.deleted','NON']
            ])
            ->orderBy("tim_endoscopie.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_endoscopie_imagerie(Request $request,$refImagerie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['refImagerie',$refImagerie],
                ['tim_endoscopie.deleted','NON']
            ])                  
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['refImagerie',$refImagerie],
                ['tim_endoscopie.deleted','NON']
            ])    
            ->orderBy("tim_imagerie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 


    public function fetch_endoscopie_imagerie_valide(Request $request,$refImagerie)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['refImagerie',$refImagerie],
                ['tim_imagerie.status','Validé'],
                ['tim_endoscopie.deleted','NON']
            ])                  
            ->orderBy("tim_endoscopie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tim_endoscopie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
      
            ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
            "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
                ['refImagerie',$refImagerie],
                ['tim_imagerie.status','Validé'],
                ['tim_endoscopie.deleted','NON']
            ])    
            ->orderBy("tim_endoscopie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    } 





    function fetch_single_EndoscopieImage($id)
    {
        $data = DB::table('tim_endoscopie')
        ->join('tim_imagerie','tim_imagerie.id','=','tim_endoscopie.refImagerie')
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
  
        ->select("tim_endoscopie.id",'refImagerie','descriptionEndo','conclusionEndo','imageEndo',
        "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","refTypeCons",
        "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
        "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
        "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
        "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tim_endoscopie.created_at",
        "tim_endoscopie.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tim_endoscopie.author",
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
        ->where('tim_endoscopie.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
 function insertData(Request $request)
 {

     if (!is_null($request->image)) 
     {
        $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName); 

         $data= tim_endoscopie::create([
            'refImagerie' =>  $formData->refImagerie,
            'descriptionEndo'       => $formData->descriptionEndo,
            'conclusionEndo'     =>   $formData->conclusionEndo,           
            'imageEndo'            =>  $imageName,                         
            'author'           => $formData->author         
         ]);

         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
     }
     else{
        $formData = json_decode($_POST['data']);
        $data= tim_endoscopie::create([
            'refImagerie' =>  $formData->refImagerie,
            'descriptionEndo'       => $formData->descriptionEndo,
            'conclusionEndo'     =>   $formData->conclusionEndo,           
            'imageEndo'            =>  'avatar.png',                        
            'author'           => $formData->author      
        ]);
         return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);

     }

 }

 function updateData(Request $request)
 {

     if (!is_null($request->image)) 
     {
         $formData = json_decode($_POST['data']);
         $imageName = time().'.'.$request->image->getClientOriginalExtension();          
         $request->image->move(public_path('/fichier'), $imageName);
      
        $data= tim_endoscopie::where('id',$formData->id)->update([
            'refImagerie' =>  $formData->refImagerie,
            'descriptionEndo'       => $formData->descriptionEndo,
            'conclusionEndo'     =>   $formData->conclusionEndo,           
            'imageEndo'            =>  $imageName,                           
            'author'           => $formData->author    
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);
 
     }
     else{
         $formData = json_decode($_POST['data']);
         $data= tim_endoscopie::where('id',$formData->id)->update([
            'refImagerie' =>  $formData->refImagerie,
            'descriptionEndo'       => $formData->descriptionEndo,
            'conclusionEndo'     =>   $formData->conclusionEndo,
            'author'           => $formData->author       
         ]);

         return response()->json([
            'data'  =>  "Modification avec succès!!",
        ]);

     }

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
     $data = tim_endoscopie::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }


}
