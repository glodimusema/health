<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dyalise\tdyal__dose_cathetere;
use DB;

class tdyal_dosecathetereController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
        // "FR_avant","FR_Apres",
        // "Plaquette_avant", "Plaquette_apres"
     
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);
    
            $data = DB::table('tdyal__dose_cathetere')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal__dose_cathetere.refEnteteDyalise')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal__dose_cathetere.refTypeMachine')
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
            //DETAIL 

            ->select("tdyal__dose_cathetere.id","dateDemande","dateDose","indication",'shifts',
            "tdyal_entete_dyalise.auther","refEnteteDyalise","refTypeMachine","KT","CM_marque",
            "Dimension","siteactuel","lieu","autres","operateur_Dr","tdyal_type_machine.nomTypeMachine",
            "tdyal_type_machine.description as descriptionMachine",
            'assistant','infirmier',"descriptionOperation",'PA_avant','PA_apres','pauls_avant',
            'pauls_apres',"FR_avant","FR_Apres",'saO2_avant','saO2_apres','to_avant','to_apres',
            "Plaquette_avant", "Plaquette_apres",'observation','instruction',"nomTypeMachine",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tdyal__dose_cathetere.deleted','NON']
            ])           
            ->orderBy("tdyal__dose_cathetere.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
              $data = DB::table('tdyal__dose_cathetere')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal__dose_cathetere.refEnteteDyalise')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal__dose_cathetere.refTypeMachine')
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
            //DETAIL 
            
            ->select("tdyal__dose_cathetere.id","dateDemande","dateDose","indication","shifts",
            "tdyal_entete_dyalise.auther","refEnteteDyalise","refTypeMachine","KT","CM_marque",
            "Dimension","siteactuel","lieu","autres","operateur_Dr","tdyal_type_machine.nomTypeMachine",
            "tdyal_type_machine.description as descriptionMachine",
            'assistant','infirmier',"descriptionOperation",'PA_avant','PA_apres','pauls_avant',
            'pauls_apres',"FR_avant","FR_Apres","Plaquette_avant", "Plaquette_apres",
            'saO2_avant','saO2_apres','to_avant','to_apres','observation','instruction',"nomTypeMachine",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tdyal__dose_cathetere.deleted','NON']])
            ->orderBy("tdyal__dose_cathetere.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_posecathetere_dialyse(Request $request,$refEnteteDyalise)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdyal__dose_cathetere')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal__dose_cathetere.refEnteteDyalise')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal__dose_cathetere.refTypeMachine')
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
            //DETAIL 
            
            ->select("tdyal__dose_cathetere.id","dateDemande","dateDose","indication","shifts",
            "tdyal_entete_dyalise.auther","refEnteteDyalise","refTypeMachine","KT","CM_marque",
            "Dimension","siteactuel","lieu","autres","operateur_Dr","tdyal_type_machine.nomTypeMachine",
            "tdyal_type_machine.description as descriptionMachine",
            'assistant','infirmier',"descriptionOperation",'PA_avant','PA_apres',
            'pauls_avant','pauls_apres',"FR_avant","FR_Apres","Plaquette_avant", "Plaquette_apres",
            'saO2_avant','saO2_apres','to_avant','to_apres','observation','instruction',"nomTypeMachine",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteDyalise',$refEnteteDyalise],
                ['tdyal__dose_cathetere.deleted','NON']
            ])                    
            ->orderBy("tdyal__dose_cathetere.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdyal__dose_cathetere')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal__dose_cathetere.refEnteteDyalise')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal__dose_cathetere.refTypeMachine')
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
            //DETAIL 
            
            ->select("tdyal__dose_cathetere.id","dateDemande","dateDose","indication","shifts",
            "tdyal_entete_dyalise.auther","refEnteteDyalise","refTypeMachine","KT","CM_marque",
            "Dimension","siteactuel","lieu","autres","operateur_Dr","tdyal_type_machine.nomTypeMachine",
            "tdyal_type_machine.description as descriptionMachine",
            'assistant','infirmier',"descriptionOperation",'PA_avant','PA_apres',
            'pauls_avant','pauls_apres',"FR_avant","FR_Apres","Plaquette_avant", "Plaquette_apres",
            'saO2_avant','saO2_apres','to_avant','to_apres','observation','instruction',"nomTypeMachine",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([
                ['refEnteteDyalise',$refEnteteDyalise],
                ['tdyal__dose_cathetere.deleted','NON']
            ])    
            ->orderBy("tdyal__dose_cathetere.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    







    function fetch_singleData($id)
    {
        $data = DB::table('tdyal__dose_cathetere')
            ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal__dose_cathetere.refEnteteDyalise')
            ->join('tdyal_type_machine','tdyal_type_machine.id','=','tdyal__dose_cathetere.refTypeMachine')
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
            //DETAIL 
            
            ->select("tdyal__dose_cathetere.id","dateDemande","dateDose","indication","shifts",
            "tdyal_entete_dyalise.auther","refEnteteDyalise","refTypeMachine","KT","CM_marque",
            "Dimension","siteactuel","lieu","autres","operateur_Dr","tdyal_type_machine.nomTypeMachine",
            "tdyal_type_machine.description as descriptionMachine",
            'assistant','infirmier',"descriptionOperation",'PA_avant','PA_apres',
            'pauls_avant','pauls_apres',"FR_avant","FR_Apres","Plaquette_avant", "Plaquette_apres",
            'saO2_avant','saO2_apres','to_avant','to_apres','observation','instruction',"nomTypeMachine",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('tdyal__dose_cathetere.id', $id)
            ->get();

            return response()->json([
                'data'  => $data,
            ]);
    }
 //,"FR_avant","FR_Apres","Plaquette_avant", "Plaquette_apres",
    function insertData(Request $request)
    {
        $data = tdyal__dose_cathetere::create([
            'refEnteteDyalise'       =>  $request->refEnteteDyalise,
            'refTypeMachine'    =>  $request->refTypeMachine,  
            'indication'    =>  $request->indication,                               
            'dateDose'       =>  $request->dateDose,
            'shifts'       =>  $request->shifts,
            'KT'       =>  $request->KT,
            'CM_marque'    =>  $request->CM_marque,                               
            'Dimension'       =>  $request->Dimension,
            'siteactuel'       =>  $request->siteactuel,
            'lieu'       =>  $request->lieu,
            'autres'    =>  $request->autres,                               
            'operateur_Dr'       =>  $request->operateur_Dr,
            'assistant'       =>  $request->assistant,
            'infirmier'    =>  $request->infirmier,       
            'descriptionOperation' =>  $request->descriptionOperation,                         
            'PA_avant'       =>  $request->PA_avant,
            'PA_apres'    =>  $request->PA_apres,                               
            'pauls_avant'       =>  $request->pauls_avant,
            'pauls_apres'       =>  $request->pauls_apres,
            'FR_avant'       =>  $request->FR_avant,
            'FR_Apres'       =>  $request->FR_Apres,            
            'saO2_avant'    =>  $request->saO2_avant,                               
            'saO2_apres'       =>  $request->saO2_apres,
            'to_avant'       =>  $request->to_avant,
            'to_apres'    =>  $request->to_apres,  
            'Plaquette_avant'    =>  $request->Plaquette_avant,  
            'Plaquette_apres'    =>  $request->Plaquette_apres,                               
            'observation'       =>  $request->observation,
            'instruction'       =>  $request->instruction

        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function updateData(Request $request, $id)
    {
        $data = tdyal__dose_cathetere::where('id', $id)->update([
            'refEnteteDyalise'       =>  $request->refEnteteDyalise,
            'refTypeMachine'    =>  $request->refTypeMachine, 
            'indication'    =>  $request->indication,                              
            'dateDose'       =>  $request->dateDose,
            'shifts'       =>  $request->shifts,
            'KT'       =>  $request->KT,
            'CM_marque'    =>  $request->CM_marque,                               
            'Dimension'       =>  $request->Dimension,
            'siteactuel'       =>  $request->siteactuel,
            'lieu'       =>  $request->lieu,
            'autres'    =>  $request->autres,                               
            'operateur_Dr'       =>  $request->operateur_Dr,
            'assistant'       =>  $request->assistant,
            'infirmier'    =>  $request->infirmier,  
            'descriptionOperation' =>  $request->descriptionOperation,                              
            'PA_avant'       =>  $request->PA_avant,
            'PA_apres'    =>  $request->PA_apres,                               
            'pauls_avant'       =>  $request->pauls_avant,
            'pauls_apres'       =>  $request->pauls_apres,
            'FR_avant'       =>  $request->FR_avant,
            'FR_Apres'       =>  $request->FR_Apres,   
            'saO2_avant'    =>  $request->saO2_avant,                               
            'saO2_apres'       =>  $request->saO2_apres,
            'to_avant'       =>  $request->to_avant,
            'to_apres'    =>  $request->to_apres,  
            'Plaquette_avant'    =>  $request->Plaquette_avant,  
            'Plaquette_apres'    =>  $request->Plaquette_apres,                               
            'observation'       =>  $request->observation,
            'instruction'       =>  $request->instruction
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
     $data = tdyal__dose_cathetere::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
