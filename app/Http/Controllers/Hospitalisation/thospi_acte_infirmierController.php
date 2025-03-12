<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_acte_infirmier;
use DB;

class thospi_acte_infirmierController extends Controller
{
 
    public function index()
    {
        return '';
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
            
            $data = DB::table('thospi_acte_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')           
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
            //
            ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
             "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
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
                ['thospitalisation.deleted','NON']
            ])            
            ->orderBy("thospi_acte_infirmier.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('thospi_acte_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
            //
            ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
            "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
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
            ->where([['thospitalisation.deleted','NON']])             
            ->orderBy("thospi_acte_infirmier.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_acte_infirmier(Request $request,$refHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('thospi_acte_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
            //
            ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
            "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
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
                ['refHospi',$refHospi],
                ['thospitalisation.deleted','NON']
            ])                    
            ->orderBy("thospi_acte_infirmier.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('thospi_acte_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
            //
            ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
            "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
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
            ->Where([
                ['refHospi',$refHospi],
                ['thospitalisation.deleted','NON']
            ])    
            ->orderBy("thospi_acte_infirmier.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

    function fetch_single_acte_infirmier($id)
    {

        $data = DB::table('thospi_acte_infirmier')
        ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
        ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
        ->join('tlit','tlit.id','=','thospitalisation.refLit')
        ->join('tsalle','tsalle.id','=','tlit.refSalle')
        ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
        //
        ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
        "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
        'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
        "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
        "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
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
        ->where('thospi_acte_infirmier.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function insert_acte_infirmier(Request $request)
    {
       
        $data = thospi_acte_infirmier::create([
            'refHospi'       =>  $request->refHospi,
            'refActeMedical'    =>  $request->refActeMedical,
            'Description'    =>  $request->Description,
            'auther'    =>  $request->auther,
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_acte_infirmier(Request $request, $id)
    {
        $data = thospi_acte_infirmier::where('id', $id)->update([
            'refHospi'       =>  $request->refHospi,
            'refActeMedical'    =>  $request->refActeMedical,
            'Description'    =>  $request->Description,
            'auther'    =>  $request->auther,
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_acte_infirmier($id)
    {
        $data = thospi_acte_infirmier::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
