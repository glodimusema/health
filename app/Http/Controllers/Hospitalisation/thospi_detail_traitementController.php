<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_detail_traitement;
use DB;


class thospi_detail_traitementController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }
    
    public function all(Request $request)
    {     
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            
            $data = DB::table('thospi_detail_traitement')
            ->join('tconf_medicament','tconf_medicament.id','=','thospi_detail_traitement.refMedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('thospi_traitement_hospi','thospi_traitement_hospi.id','=','thospi_detail_traitement.refTraitem')
            ->join('thospitalisation','thospitalisation.id','=','thospi_traitement_hospi.refHospi')
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
            //
            ->select("thospi_detail_traitement.id","posologie","vait", "fait08h","qte08h","fait09h","qte09h",
            "fait10h","qte10h","fait11h","qte11h","fait12h","qte12h","fait13h","qte13h","fait14h","qte14h",
            "fait15h","qte15h","fait16h","qte16h","fait17h","qte17h","fait18h","qte18h","fait19h","qte19h",
            "fait20h","qte20h","fait21h","qte21h","fait22h","qte22h","fait23h","qte23h","fait24h","qte24h",
            "fait24h","qte24h","fait01h","qte01h","fait02h","qte02h","fait03h","qte03h","fait04h","qte04h",
            "fait04h","qte04h","fait05h","qte05h","fait06h","qte06h","fait07h","qte07h","thospi_detail_traitement.observation",
            "thospi_detail_traitement.author","refTraitem","refMedicament","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
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
                ['thospi_detail_traitement.deleted','NON']
            ])            
            ->orderBy("thospi_detail_traitement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('thospi_detail_traitement')
            ->join('tconf_medicament','tconf_medicament.id','=','thospi_detail_traitement.refMedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('thospi_traitement_hospi','thospi_traitement_hospi.id','=','thospi_detail_traitement.refTraitem')
            ->join('thospitalisation','thospitalisation.id','=','thospi_traitement_hospi.refHospi')
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
            //
            ->select("thospi_detail_traitement.id","posologie","vait", "fait08h","qte08h","fait09h","qte09h",
            "fait10h","qte10h","fait11h","qte11h","fait12h","qte12h","fait13h","qte13h","fait14h","qte14h",
            "fait15h","qte15h","fait16h","qte16h","fait17h","qte17h","fait18h","qte18h","fait19h","qte19h",
            "fait20h","qte20h","fait21h","qte21h","fait22h","qte22h","fait23h","qte23h","fait24h","qte24h",
            "fait24h","qte24h","fait01h","qte01h","fait02h","qte02h","fait03h","qte03h","fait04h","qte04h",
            "fait04h","qte04h","fait05h","qte05h","fait06h","qte06h","fait07h","qte07h","thospi_detail_traitement.observation",
            "thospi_detail_traitement.author","refTraitem","refMedicament","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
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
            ->where([['thospi_detail_traitement.deleted','NON']])            
            ->orderBy("thospi_traitement_hospi.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_detailtraitement_hospi(Request $request,$refTraitem)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

   
            $data = DB::table('thospi_detail_traitement')
            ->join('tconf_medicament','tconf_medicament.id','=','thospi_detail_traitement.refMedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('thospi_traitement_hospi','thospi_traitement_hospi.id','=','thospi_detail_traitement.refTraitem')
            ->join('thospitalisation','thospitalisation.id','=','thospi_traitement_hospi.refHospi')
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
            //
            ->select("thospi_detail_traitement.id","posologie","vait", "fait08h","qte08h","fait09h","qte09h",
            "fait10h","qte10h","fait11h","qte11h","fait12h","qte12h","fait13h","qte13h","fait14h","qte14h",
            "fait15h","qte15h","fait16h","qte16h","fait17h","qte17h","fait18h","qte18h","fait19h","qte19h",
            "fait20h","qte20h","fait21h","qte21h","fait22h","qte22h","fait23h","qte23h","fait24h","qte24h",
            "fait24h","qte24h","fait01h","qte01h","fait02h","qte02h","fait03h","qte03h","fait04h","qte04h",
            "fait04h","qte04h","fait05h","qte05h","fait06h","qte06h","fait07h","qte07h","thospi_detail_traitement.observation",
            "thospi_detail_traitement.author","refTraitem","refMedicament","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
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
                ['refTraitem',$refTraitem],
                ['thospi_detail_traitement.deleted','NON']
            ])                    
            ->orderBy("thospi_detail_traitement.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
           
            $data = DB::table('thospi_detail_traitement')
            ->join('tconf_medicament','tconf_medicament.id','=','thospi_detail_traitement.refMedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('thospi_traitement_hospi','thospi_traitement_hospi.id','=','thospi_detail_traitement.refTraitem')
            ->join('thospitalisation','thospitalisation.id','=','thospi_traitement_hospi.refHospi')
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
            //
            ->select("thospi_detail_traitement.id","posologie","vait", "fait08h","qte08h","fait09h","qte09h",
            "fait10h","qte10h","fait11h","qte11h","fait12h","qte12h","fait13h","qte13h","fait14h","qte14h",
            "fait15h","qte15h","fait16h","qte16h","fait17h","qte17h","fait18h","qte18h","fait19h","qte19h",
            "fait20h","qte20h","fait21h","qte21h","fait22h","qte22h","fait23h","qte23h","fait24h","qte24h",
            "fait24h","qte24h","fait01h","qte01h","fait02h","qte02h","fait03h","qte03h","fait04h","qte04h",
            "fait04h","qte04h","fait05h","qte05h","fait06h","qte06h","fait07h","qte07h","thospi_detail_traitement.observation",
            "thospi_detail_traitement.author","refTraitem","refMedicament","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
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
                ['refTraitem',$refTraitem],
                ['thospi_detail_traitement.deleted','NON']
            ])    
            ->orderBy("thospi_detail_traitement.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    






    function fetch_single_traitement($id)
    {
        $data = DB::table('thospi_detail_traitement')
        ->join('tconf_medicament','tconf_medicament.id','=','thospi_detail_traitement.refMedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('thospi_traitement_hospi','thospi_traitement_hospi.id','=','thospi_detail_traitement.refTraitem')
        ->join('thospitalisation','thospitalisation.id','=','thospi_traitement_hospi.refHospi')
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
        //
        ->select("thospi_detail_traitement.id","posologie","vait", "fait08h","qte08h","fait09h","qte09h",
        "fait10h","qte10h","fait11h","qte11h","fait12h","qte12h","fait13h","qte13h","fait14h","qte14h",
        "fait15h","qte15h","fait16h","qte16h","fait17h","qte17h","fait18h","qte18h","fait19h","qte19h",
        "fait20h","qte20h","fait21h","qte21h","fait22h","qte22h","fait23h","qte23h","fait24h","qte24h",
        "fait24h","qte24h","fait01h","qte01h","fait02h","qte02h","fait03h","qte03h","fait04h","qte04h",
        "fait04h","qte04h","fait05h","qte05h","fait06h","qte06h","fait07h","qte07h","thospi_detail_traitement.observation",
        "thospi_detail_traitement.author","refTraitem","refMedicament","nom_medicament","refcategoriemedicament","pu_medicament",
        "forme","nom_categoriemedicament","refHospi",
        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
        "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
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
        ->where('thospi_detail_traitement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function insert_detail_traitement(Request $request)
    {
       
        $data = thospi_detail_traitement::create([
            'refTraitem'    =>  $request->refTraitem,  
            'refMedicament'    =>  $request->refMedicament,                              
            'posologie'       =>  $request->posologie,
            'vait'    =>  $request->vait,  
            'fait08h'    =>  $request->fait08h,                              
            'qte08h'       =>  $request->qte08h,
            'fait09h'    =>  $request->fait09h,                              
            'qte09h'       =>  $request->qte09h,
            'fait10h'    =>  $request->fait10h,                              
            'qte10h'       =>  $request->qte10h,
            'fait12h'    =>  $request->fait12h,                              
            'qte12h'       =>  $request->qte12h,
            'fait13h'    =>  $request->fait13h,                              
            'qte13h'       =>  $request->qte13h,
            'fait14h'    =>  $request->fait14h,                              
            'qte14h'       =>  $request->qte14h,
            'fait15h'    =>  $request->fait15h,                              
            'qte15h'       =>  $request->qte15h,
            'fait16h'    =>  $request->fait16h,                              
            'qte16h'       =>  $request->qte16h,
            'fait17h'    =>  $request->fait17h,                              
            'qte17h'       =>  $request->qte17h,
            'fait18h'    =>  $request->fait18h,                              
            'qte18h'       =>  $request->qte18h,
            'fait19h'    =>  $request->fait19h,                              
            'qte19h'       =>  $request->qte19h,
            'fait20h'    =>  $request->fait20h,                              
            'qte20h'       =>  $request->qte20h,
            'fait21h'    =>  $request->fait21h,                              
            'qte21h'       =>  $request->qte21h,
            'fait22h'    =>  $request->fait22h,                              
            'qte22h'       =>  $request->qte22h,
            'fait23h'    =>  $request->fait23h,                              
            'qte23h'       =>  $request->qte23h,
            'fait24h'    =>  $request->fait24h,                              
            'qte24h'       =>  $request->qte24h,
            'fait01h'    =>  $request->fait01h,                              
            'qte01h'       =>  $request->qte01h,
            'fait02h'    =>  $request->fait02h,                              
            'qte02h'       =>  $request->qte02h,
            'fait03h'    =>  $request->fait03h,                              
            'qte03h'       =>  $request->qte03h,
            'fait04h'    =>  $request->fait04h,                              
            'qte04h'       =>  $request->qte04h,
            'fait05h'    =>  $request->fait05h,                              
            'qte05h'       =>  $request->qte05h,
            'fait06h'    =>  $request->fait06h,                              
            'qte06h'       =>  $request->qte06h,
            'fait07h'    =>  $request->fait07h,                              
            'qte07h'       =>  $request->qte07h,
            'author'       =>  $request->author,
            'observation'    =>  $request->observation,                              
           
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function updatethospi_detail_traitement(Request $request, $id)
    {
        $data = thospi_detail_traitement::where('id', $id)->update([
            'refTraitem'    =>  $request->refTraitem,  
            'refMedicament'    =>  $request->refMedicament,                              
            'posologie'       =>  $request->posologie,
            'vait'    =>  $request->vait,  
            'fait08h'    =>  $request->fait08h,                              
            'qte08h'       =>  $request->qte08h,
            'fait09h'    =>  $request->fait09h,                              
            'qte09h'       =>  $request->qte09h,
            'fait10h'    =>  $request->fait10h,                              
            'qte10h'       =>  $request->qte10h,
            'fait12h'    =>  $request->fait12h,                              
            'qte12h'       =>  $request->qte12h,
            'fait13h'    =>  $request->fait13h,                              
            'qte13h'       =>  $request->qte13h,
            'fait14h'    =>  $request->fait14h,                              
            'qte14h'       =>  $request->qte14h,
            'fait15h'    =>  $request->fait15h,                              
            'qte15h'       =>  $request->qte15h,
            'fait16h'    =>  $request->fait16h,                              
            'qte16h'       =>  $request->qte16h,
            'fait17h'    =>  $request->fait17h,                              
            'qte17h'       =>  $request->qte17h,
            'fait18h'    =>  $request->fait18h,                              
            'qte18h'       =>  $request->qte18h,
            'fait19h'    =>  $request->fait19h,                              
            'qte19h'       =>  $request->qte19h,
            'fait20h'    =>  $request->fait20h,                              
            'qte20h'       =>  $request->qte20h,
            'fait21h'    =>  $request->fait21h,                              
            'qte21h'       =>  $request->qte21h,
            'fait22h'    =>  $request->fait22h,                              
            'qte22h'       =>  $request->qte22h,
            'fait23h'    =>  $request->fait23h,                              
            'qte23h'       =>  $request->qte23h,
            'fait24h'    =>  $request->fait24h,                              
            'qte24h'       =>  $request->qte24h,
            'fait01h'    =>  $request->fait01h,                              
            'qte01h'       =>  $request->qte01h,
            'fait02h'    =>  $request->fait02h,                              
            'qte02h'       =>  $request->qte02h,
            'fait03h'    =>  $request->fait03h,                              
            'qte03h'       =>  $request->qte03h,
            'fait04h'    =>  $request->fait04h,                              
            'qte04h'       =>  $request->qte04h,
            'fait05h'    =>  $request->fait05h,                              
            'qte05h'       =>  $request->qte05h,
            'fait06h'    =>  $request->fait06h,                              
            'qte06h'       =>  $request->qte06h,
            'fait07h'    =>  $request->fait07h,                              
            'qte07h'       =>  $request->qte07h,
            'author'       =>  $request->author,
            'observation'    =>  $request->observation,
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
     $data = thospi_detail_traitement::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }
    


}
