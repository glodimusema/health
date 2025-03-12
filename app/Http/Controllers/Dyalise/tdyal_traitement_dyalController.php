<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dyalise\tdyal_traitement_dyal;
use DB;


class tdyal_traitement_dyalController extends Controller
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
            
            $data = DB::table('tdyal_traitement_dyal')
            ->join('tdyal_rapport_med_dyalyse','tdyal_rapport_med_dyalyse.id','=','tdyal_traitement_dyal.refRapport')
            ->join('tconf_medicament','tconf_medicament.id','=','tdyal_traitement_dyal.refMedicament')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
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

            ->select("tdyal_traitement_dyal.id",
            "refRapport","refMedicament",
            "rensMedicant","nephropatie","dateSeance",
            "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
            "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
            "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
            "nb","dr","specialite","cNom",
            "refRapport",
          
//=====================================
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
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
                ['tdyal_traitement_dyal.deleted','NON']
            ])           
            ->orderBy("tdyal_traitement_dyal.id", "desc")          
            ->paginate(10);

            return response()->json(
               $data
            );
           

        }
        else{
            $data = DB::table('tdyal_traitement_dyal')
            ->join('tdyal_rapport_med_dyalyse','tdyal_rapport_med_dyalyse.id','=','tdyal_traitement_dyal.refRapport')
            ->join('tconf_medicament','tconf_medicament.id','=','tdyal_traitement_dyal.refMedicament')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
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

            ->select("tdyal_traitement_dyal.id",
            "refRapport","refMedicament",
            "rensMedicant","nephropatie","dateSeance",
            "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
            "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
            "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
            "nb","dr","specialite","cNom",
            "refRapport",
         

            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tdyal_traitement_dyal.deleted','NON']])
            ->orderBy("tdyal_traitement_dyal.id", "desc")
            ->paginate(10);
            return response()->json(
              $data
            );
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tdyal_traitement_dyal')
        ->join('tdyal_rapport_med_dyalyse','tdyal_rapport_med_dyalyse.id','=','tdyal_traitement_dyal.refRapport')
        ->join('tconf_medicament','tconf_medicament.id','=','tdyal_traitement_dyal.refMedicament')
        ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
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

        ->select("tdyal_traitement_dyal.id",
        "refRapport","refMedicament",
        "rensMedicant","nephropatie","dateSeance",
        "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
        "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
        "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
        "nb","dr","specialite","cNom",
        "refRapport",
//=====================================
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tdyal_traitement_dyal.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    
 
    function fetch_traitement_rapport(Request $request,$refRapport)
    {
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tdyal_traitement_dyal')
            ->join('tdyal_rapport_med_dyalyse','tdyal_rapport_med_dyalyse.id','=','tdyal_traitement_dyal.refRapport')
            ->join('tconf_medicament','tconf_medicament.id','=','tdyal_traitement_dyal.refMedicament')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
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
    
            ->select("tdyal_traitement_dyal.id",
            "refRapport","refMedicament",
            "rensMedicant","nephropatie","dateSeance",
            "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
            "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
            "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
            "nb","dr","specialite","cNom",
            "refRapport",
          

    //=====================================
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
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
            ['refRapport',$refRapport],
            ['tdyal_traitement_dyal.deleted','NON']
        ])                    
        ->orderBy("tdyal_traitement_dyal.id", "desc")
        ->paginate(10);

        return response()->json(
            $data
        );
    }else{
        $data = DB::table('tdyal_traitement_dyal')
        ->join('tdyal_rapport_med_dyalyse','tdyal_rapport_med_dyalyse.id','=','tdyal_traitement_dyal.refRapport')
        ->join('tconf_medicament','tconf_medicament.id','=','tdyal_traitement_dyal.refMedicament')
        ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
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

        ->select("tdyal_traitement_dyal.id",
        "refRapport","refMedicament",
        "rensMedicant","nephropatie","dateSeance",
        "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
        "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
        "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
        "nb","dr","specialite","cNom",
        "refRapport",
      
//=====================================
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where([['refRapport',$refRapport],
        ['tdyal_traitement_dyal.deleted','NON']])    
            ->orderBy("tdyal_traitement_dyal.id", "desc")
            ->paginate(10);
            return response()->json(
                $data
            );
    }
}



    function insertData(Request $request)
    {
        $request->validate([
            'refRapport'=>'required',
            'refMedicament'=>'required',
            'heure'=>'required',
            'ta'=>'required',
            'bP'=>'required',
            'mAp'=>'required',
            'hR'=>'required',
            'hR'=>'required',
            'pA'=>'required',
            'pV'=>'required',
            'tMP'=>'required',
            'qB'=>'required',
            'qD'=>'required',
            'uF'=>'required',
            'observation'=>'required',
            'author'=>'required'
        ]);


        $data = tdyal_traitement_dyal::create([
            'refRapport'       =>  $request->refRapport,
            'refMedicament'    =>  $request->refMedicament,                               
            'heure'       =>  $request->heure,
            'ta'       =>  $request->ta,
            'bP'    =>  $request->bP,                               
            'mAp'       =>  $request->mAp,
            'hR'       =>  $request->hR,
            'pA'    =>  $request->pA,                               
            'pV'       =>  $request->pV,
            'tMP'       =>  $request->tMP,
            'qB'    =>  $request->qB,                               
            'qD'       =>  $request->qD,
            'prisePoids'       =>  $request->prisePoids,
            'debitPrompe'    =>  $request->debitPrompe,                               
            'TAhabituelle'       =>  $request->TAhabituelle,
            'valeurDialysat'       =>  $request->valeurDialysat,
            'nA'    =>  $request->nA,                               
            'k'       =>  $request->k,
            'ca'       =>  $request->ca,
            'chloride'    =>  $request->chloride,                               
            'hco3'       =>  $request->hco3,
            'mg'       =>  $request->mg,
            'acitate'    =>  $request->acitate,                               
            'evolution'       =>  $request->evolution,
            'conclusion'       =>  $request->conclusion,
            'recommandation'    =>  $request->recommandation,                               
            'nb'       =>  $request->nb,
            'specialite'       =>  $request->specialite,
            'cNom'    =>  $request->cNom,   
            'author'    =>  $request->author,   

        ]);
        if($data)
        {
         return $this->sendResponse($data,'Insertion avec succès!!!');
        }
        return $this->sendErrorResponse(' Erreur de creation!!');
    }


    function updateData(Request $request,$id)
    {
       $validateData=  $request->validate([
        'refRapport'=>'sometimes|integer',
        'refMedicament'=>'sometimes|integer',
        'heure'=>'sometimes|string',
        'ta'=>'sometimes|string',
        'bP'=>'sometimes|string',
        'mAp'=>'sometimes|string',
        'hR'=>'sometimes|string',
        'hR'=>'sometimes|string',
        'pA'=>'sometimes|string',
        'pV'=>'sometimes|string',
        'tMP'=>'sometimes|string',
        'qB'=>'sometimes|string',
        'qD'=>'sometimes|string',
        'uF'=>'sometimes|string',
        'observation'=>'sometimes|string',
        'author'=>'sometimes|string'
       ]);
   
       $data=tdyal_traitement_dyal::find($id);
   
       if($data){
           $payload = array_merge($payload, $validateData);
           
           $data->update($payload);
       
           return $this->sendResponse($data,'modification avec succes!!');
   
       }else{
           return $this->sendErrorResponse('Resource donner est invalide!');
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
     $data = tdyal_traitement_dyal::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
