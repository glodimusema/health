<?php

namespace App\Http\Controllers\Reanimation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reanimation\trea_evolution_rea;
use DB;


class trea_evolution_reaController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    {
//
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('trea_evolution_rea')
            ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
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
            ->select("trea_evolution_rea.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.author","trea_evolution_rea.created_at","trea_evolution_rea.updated_at",
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
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("trea_evolution_rea.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('trea_evolution_rea')
            ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
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
            ->select("trea_evolution_rea.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "trea_evolution_rea.author","trea_evolution_rea.created_at","trea_evolution_rea.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author as authorHospi","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
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
            ->orderBy("trea_evolution_rea.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }
    }



    public function fetch_evolution_for_enteterea(Request $request,$refHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('trea_evolution_rea')
            ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
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
            ->select("trea_evolution_rea.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "trea_evolution_rea.author","trea_evolution_rea.created_at","trea_evolution_rea.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author as authorHospi","trea_evolution_rea.created_at","trea_evolution_rea.updated_at","matricule_medecin",
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
                ['refHospi',$refHospi]
            ])                    
            ->orderBy("trea_evolution_rea.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('trea_evolution_rea')
            ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
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
            ->select("trea_evolution_rea.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "trea_evolution_rea.author","trea_evolution_rea.created_at",
            "trea_evolution_rea.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author as authorHospi","trea_evolution_rea.created_at",
            "trea_evolution_rea.updated_at","matricule_medecin",
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
            ->Where('refHospi',$refHospi)    
            ->orderBy("trea_evolution_rea.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }


    function fetch_single_evoRea($id)
    {
        $data = DB::table('trea_evolution_rea')
        ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
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
        ->select("trea_evolution_rea.id","observation","refHospi",
        'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
        "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "trea_evolution_rea.author","trea_evolution_rea.created_at",
        "trea_evolution_rea.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
        "thospitalisation.author as authorHospi","trea_evolution_rea.created_at",
        "trea_evolution_rea.updated_at","matricule_medecin",
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
        ->where('trea_evolution_rea.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

 
    function insert_revolutionRea(Request $request)
    {
       
        $data = trea_evolution_rea::create([
            'refHospi'       =>  $request->refHospi,
            'observation'    =>  $request->observation,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_revolutionRea(Request $request, $id)
    {
        $data = trea_evolution_rea::where('id', $id)->update([
            'refHospi'       =>  $request->refHospi,
            'observation'    =>  $request->observation,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

public function destroy($id)
 {
     $data = trea_evolution_rea::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
