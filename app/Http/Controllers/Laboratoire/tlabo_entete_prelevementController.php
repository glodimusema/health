<?php

namespace App\Http\Controllers\Laboratoire;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Laboratoire\tlabo_entete_prelevement;
use App\Models\tentetetriage;
use App\Models\tdetailtriage;
use App\Models\Consultations\tenteteconsulter;
use App\Models\Consultations\tdetailconsultation;
use DB;

class tlabo_entete_prelevementController extends Controller
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

            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['tlabo_entete_prelevement.deleted','NON']
            ])             
            ->orderBy("tlabo_entete_prelevement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([        
                ['tlabo_entete_prelevement.deleted','NON']
            ]) 
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }

    


    public function fetch_valide_prelevement(Request $request)
    { 
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
            "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
            'refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['statutprelevement','Validé'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])  
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],     
                ['categoriemaladiemvt','ABONNE(E)'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],     
                ['TypeOrientation','MATERNITE'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])          
            ->orderBy("tlabo_entete_prelevement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['statutprelevement','Validé'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orWhere([     
                ['categoriemaladiemvt','ABONNE(E)'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orWhere([     
                ['TypeOrientation','MATERNITE'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])  
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }

    

    public function fetch_valide_finance(Request $request)
    { 
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
             'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                // ['statutprelevement','Attente'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])            
            ->orderBy("tlabo_entete_prelevement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
             'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                // ['statutprelevement','Attente'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])  
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }

  


    public function fetch_valide_labo(Request $request)
    { 
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['statutprelevement','Validé'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],     
                ['categoriemaladiemvt','ABONNE(E)'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orWhere([
                ['noms', 'like', '%'.$query.'%'],     
                ['TypeOrientation','MATERNITE'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])            
            ->orderBy("tlabo_entete_prelevement.id", "desc")          
            ->paginate(10);
                //['TypeOrientation','MATERNITE'],
            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['statutprelevement','Validé'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ]) 
            ->orWhere([    
                ['categoriemaladiemvt','ABONNE(E)'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ]) 
            ->orWhere([
                ['TypeOrientation','MATERNITE'],
                ['preleveur','OUI'],
                ['Statut','Encours'],
                ['tlabo_entete_prelevement.deleted','NON']
            ])
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }
  //fetch_valide_prelevement,fetch_valide_finance,fetch_valide_labo

    public function fetch_data_entete(Request $request,$refDetailCons)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refDetailCons',$refDetailCons],
                ['tlabo_entete_prelevement.deleted','NON']
            ])                    
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlabo_entete_prelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
            ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
            "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
             "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
            ->where([
                ['refDetailCons',$refDetailCons],
                ['tlabo_entete_prelevement.deleted','NON']
            ])      
            ->orderBy("tlabo_entete_prelevement.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    function fetch_single_data($id)
    {

        $data = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
        ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
        "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
         "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
         "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
         "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
        ->where('tlabo_entete_prelevement.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

    function fetch_max_entete_prelevement_Cons(Request $request)
    {
        $refDetailCons = $request->id;

        $data1 = tlabo_entete_prelevement::create([

            'refDetailCons'       =>  $refDetailCons,
            'refService'    =>  $request->refService,
            'dateprelevement'    =>  date('Y-m-d'),
            'numroRecu'    =>  '00000',
            'MedecinDemandeur'    =>  $request->author,                            
            'author'       =>  $request->author
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
            'parcours'    => 'Laboratoire' 
        ]);


        $idmax=0;
        $maxid = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement') 
        ->selectRaw('MAX(tlabo_entete_prelevement.id) as code_entete_prelevement')
        ->where('tlabo_entete_prelevement.refDetailCons', $refDetailCons)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_prelevement;
        }


        $data = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
        ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
        "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
         "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
         "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
         "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
         'refMedecin','dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at",
         "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
        "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
        "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
        ->where('tlabo_entete_prelevement.id', $idmax)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }
   
    function insert_data(Request $request)
    {
       
        $data = tlabo_entete_prelevement::create([
            'refDetailCons'       =>  $request->refDetailCons,
            'refService'    =>  $request->refService,
            'dateprelevement'    =>  $request->dateprelevement,
            'numroRecu'    =>  $request->numroRecu,
            'MedecinDemandeur'    =>  $request->MedecinDemandeur,                            
            'author'       =>  $request->author
        ]);

        $idEnteteCons=0;

        $consList = DB::table('tdetailconsultation')
        ->select("tdetailconsultation.id","refEnteteCons")
        ->where([
            ['tdetailconsultation.id',$request->refDetailCons]
        ])
        ->get();
        foreach ($consList as $liste_mvt) {
            $idEnteteCons= $liste_mvt->refEnteteCons;
        }
        $data = tenteteconsulter::where('id', $idEnteteCons)->update([
            'parcours'    => 'Laboratoire' 
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_data(Request $request, $id)
    {
        $data = tlabo_entete_prelevement::where('id', $id)->update([
            'refDetailCons'       =>  $request->refDetailCons,
            'refService'    =>  $request->refService,
            'dateprelevement'    =>  $request->dateprelevement,
            'numroRecu'    =>  $request->numroRecu,
            'MedecinDemandeur'    =>  $request->MedecinDemandeur,                            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_statutprelevement(Request $request, $id)
    {
        $data = tlabo_entete_prelevement::where('id', $id)->update([             
            'statutprelevement'    =>  $request->statutprelevement,             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_preleveur(Request $request, $id)
    {
        $data = tlabo_entete_prelevement::where('id', $id)->update([             
            'preleveur'    =>  $request->preleveur,             
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_data($id)
    {
        $data = tlabo_entete_prelevement::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }





    function fetch_max_entete_prelevement_mouvement(Request $request)
    {

        $refMouvement=$request->refMouvement;
        $refMedecin=$request->refMedecin;
        $author=$request->author;
        $refTypeCons=$request->refTypeCons;
        $refService=$request->refService;

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
            'plainte_triage'       =>  'Externe',
            'antecedent_trige'       =>  'Externe',
            'cas_triage'       =>  'Externe',
            'Poids'    =>  0,
            'Taille'    =>  0,
            'TA'    =>  '0',
            'Temperature'    =>  0,
            'FC'    =>  0,
            'FR'    => 0,
            'Oxygene'    =>  0,                      
            'author'       =>  $author
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

        $data1 = tlabo_entete_prelevement::create([

            'refDetailCons'       =>  $refDetailCons,
            'refService'    =>  $request->refService,
            'dateprelevement'    =>  date('Y-m-d'),
            'numroRecu'    =>  '00000',
            'MedecinDemandeur'    =>  $request->author,                            
            'author'       =>  $request->author
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
            'parcours'    => 'Laboratoire' 
        ]);


        $idmax=0;
        $maxid = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
        ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
        ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
        ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
        ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
        ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement') 
        ->selectRaw('MAX(tlabo_entete_prelevement.id) as code_entete_prelevement')
        ->where('tlabo_entete_prelevement.refDetailCons', $refDetailCons)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_prelevement;
        }


        $data = DB::table('tlabo_entete_prelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
        ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
        "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
         "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
         "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
         "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
         'refMedecin','dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at",
         "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
        "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
        "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade","PrixCons")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"",DAY(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
        ->where('tlabo_entete_prelevement.id', $idmax)
        ->get();
        //
        return response()->json([
        'data' => $data,
        ]);
    }











}
