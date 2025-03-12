<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dyalise\tdyal_vaccination_dyalise;
use DB;

class tdyal_vaccinationdyaliseController extends Controller
{
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

            $data = DB::table('tdyal_vaccination_dyalise')
            ->join('tdyal_vaccin_dyalise','tdyal_vaccin_dyalise.id','=','tdyal_vaccination_dyalise.refVaccinDyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=','tdyal_vaccin_dyalise.refcategorieVac')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal_vaccination_dyalise.refTypeMachine')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_vaccination_dyalise.refEnteteDyalise')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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
//
            ->select("tdyal_vaccination_dyalise.id","dateVaccin","dose","dosageLitre","observation",
            "infirmier","dateDemande","nomVaccinDyal",'nomTypeMachine','description',"nomVaccinDyal","nomCategorieVac",
            "tdyal_vaccination_dyalise.auther","refTypeMachine","refEnteteDyalise","refVaccinDyalise",
            "plainte","historique","antecedent","complementanamnese","examenphysique","refcategorieVac",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            "numroBon","categoriemaladiemvt","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
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
                ['tdyal_vaccination_dyalise.deleted','NON']
            ])           
            ->orderBy("tdyal_entete_dyalise.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
           
            $data = DB::table('tdyal_vaccination_dyalise')
            ->join('tdyal_vaccin_dyalise','tdyal_vaccin_dyalise.id','=','tdyal_vaccination_dyalise.refVaccinDyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=','tdyal_vaccin_dyalise.refcategorieVac')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal_vaccination_dyalise.refTypeMachine')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_vaccination_dyalise.refEnteteDyalise')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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

            ->select("tdyal_vaccination_dyalise.id","dateVaccin","dose","dosageLitre","observation",
            "infirmier","dateDemande","nomVaccinDyal",'nomTypeMachine','description',"nomVaccinDyal","nomCategorieVac",
            "tdyal_vaccination_dyalise.auther","refTypeMachine","refEnteteDyalise","refVaccinDyalise",
            "plainte","historique","antecedent","complementanamnese","examenphysique","refcategorieVac",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            "numroBon","categoriemaladiemvt","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tdyal_vaccination_dyalise.deleted','NON']])
            ->orderBy("tdyal_vaccination_dyalise.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_vaccination_dialyse(Request $request,$refEnteteDyalise)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdyal_vaccination_dyalise')
            ->join('tdyal_vaccin_dyalise','tdyal_vaccin_dyalise.id','=','tdyal_vaccination_dyalise.refVaccinDyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=','tdyal_vaccin_dyalise.refcategorieVac')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal_vaccination_dyalise.refTypeMachine')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_vaccination_dyalise.refEnteteDyalise')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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
//
            ->select("tdyal_vaccination_dyalise.id","dateVaccin","dose","dosageLitre","observation",
            "infirmier","dateDemande","nomVaccinDyal",'nomTypeMachine','description',"nomVaccinDyal","nomCategorieVac",
            "tdyal_vaccination_dyalise.auther","refTypeMachine","refEnteteDyalise","refVaccinDyalise",
            "plainte","historique","antecedent","complementanamnese","examenphysique","refcategorieVac",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            "numroBon","categoriemaladiemvt","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
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
                ['refEnteteDyalise',$refEnteteDyalise],
                ['tdyal_vaccination_dyalise.deleted','NON']
            ])                    
            ->orderBy("tdyal_vaccination_dyalise.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdyal_vaccination_dyalise')
            ->join('tdyal_vaccin_dyalise','tdyal_vaccin_dyalise.id','=','tdyal_vaccination_dyalise.refVaccinDyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=','tdyal_vaccin_dyalise.refcategorieVac')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal_vaccination_dyalise.refTypeMachine')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_vaccination_dyalise.refEnteteDyalise')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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
//
            ->select("tdyal_vaccination_dyalise.id","dateVaccin","dose","dosageLitre","observation",
            "infirmier","dateDemande","nomVaccinDyal",'nomTypeMachine','description',"nomVaccinDyal","nomCategorieVac",
            "tdyal_vaccination_dyalise.auther","refTypeMachine","refEnteteDyalise","refVaccinDyalise",
            "plainte","historique","antecedent","complementanamnese","examenphysique","refcategorieVac",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            "numroBon","categoriemaladiemvt","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([
                ['refEnteteDyalise',$refEnteteDyalise],
                ['tdyal_vaccination_dyalise.deleted','NON']
            ])    
            ->orderBy("tdyal_vaccination_dyalise.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    function fetch_single_VaccinationDyalise($id)
    {
        $data = DB::table('tdyal_vaccination_dyalise')
        ->join('tdyal_vaccin_dyalise','tdyal_vaccin_dyalise.id','=','tdyal_vaccination_dyalise.refVaccinDyalise')
        ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=','tdyal_vaccin_dyalise.refcategorieVac')
        ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal_vaccination_dyalise.refTypeMachine')
        ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_vaccination_dyalise.refEnteteDyalise')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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

        ->select("tdyal_vaccination_dyalise.id","dateVaccin","dose","dosageLitre","observation",
        "infirmier","dateDemande","nomVaccinDyal",'nomTypeMachine','description',"nomVaccinDyal","nomCategorieVac",
        "tdyal_vaccination_dyalise.auther","refTypeMachine","refEnteteDyalise","refVaccinDyalise",
        "plainte","historique","antecedent","complementanamnese","examenphysique","refcategorieVac",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
        "numroBon","categoriemaladiemvt","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tdyal_vaccination_dyalise.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

 
    function insertData(Request $request)
    {
        $data = tdyal_vaccination_dyalise::create([
            'refEnteteDyalise'       =>  $request->refEnteteDyalise,
            'refTypeMachine'    =>  $request->refTypeMachine,                               
            'refVaccinDyalise'       =>  $request->refVaccinDyalise,
            'dateVaccin'       =>  $request->dateVaccin,
            'dose'    =>  $request->dose,                               
            'dosageLitre'       =>  $request->dosageLitre,
            'observation'       =>  $request->observation,
            'infirmier'    =>  $request->infirmier,                               
            'auther'       =>  $request->auther
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function updateData(Request $request, $id)
    {
        $data = tdyal_vaccination_dyalise::where('id', $id)->update([
            'refEnteteDyalise'       =>  $request->refEnteteDyalise,
            'refTypeMachine'    =>  $request->refTypeMachine,                               
            'refVaccinDyalise'       =>  $request->refVaccinDyalise,
            'dateVaccin'       =>  $request->dateVaccin,
            'dose'    =>  $request->dose,                               
            'dosageLitre'       =>  $request->dosageLitre,
            'observation'       =>  $request->observation,
            'infirmier'    =>  $request->infirmier,                               
            'auther'       =>  $request->auther
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
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
     $data = tdyal_vaccination_dyalise::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
