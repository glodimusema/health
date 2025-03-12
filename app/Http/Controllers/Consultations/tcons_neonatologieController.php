<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultations\tcons_neonatologie;
use App\Traits\{GlobalMethod,Slug};

use DB;

use App\User;
use App\Message;

class tcons_neonatologieController extends Controller
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
        
    //
        
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tcons_neonatologie')
            ->join('thospitalisation','thospitalisation.id','=','tcons_neonatologie.refHospi')
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
            ->select("tcons_neonatologie.id","nomPere","nomMere","adresse","telephone","dateAcouchement","heureAcouchemnt",
            "dateTransfert","heureTransfert","dateAdmission","heureAdmission","motifAppel","ageMere","poidsMere","tailleMere",
            "gastrite","partie","avortement","deces","dateTransfert2","tcons_neonatologie.groupeSanguin as groupeSanguin_neo ","antecedante","DDR","DRA","nbrCPN","fiv",
            "VAT","DPA","SP","acideFolique","vih","agHbs","hepatheC","syphilis","toxo","rubeole","mebesdazole","autres","HTA","diabet",
            "urogenital","paludisme","toxenule","nbrECHO","protocole","DPASebuecho","traitemesvats","tcons_neonatologie.datenaissance as datenaissanceNeo","Hnaissance",
            "termeSeonEcho","termeSeionScore","RPM","notionFievre","sifievreResultat","termeSeonDDR","aspestDuLA","autresNEO","dureeTravail",
            "dureeTravail","presentation","modeAcouchement","peridurable","cesarieneIndicat","tempsMaternel","carticotherapie","surfaceMg","MedicamentRecus","presencePediatre",
            "RealiserPar","parDr","sexe","tcons_neonatologie.poids as poids_neo","pc","pt","saOxygeneNeo","glicemie","apgarm1","apgarm5","apgarm10","criM1","criM5","reanimationNeo","duree","cyanose",
            "abdoman","frNeo","tempeNeo","trcNeo","conjonctivebaion","membres","examenNerologique","coeurPoumon","ban","tic","tsc","enfance","balenceMautxiphoide","scareSylverman","vigilance"
            ,"vigilance","attitude","sd","criNeo","echarpe","maro","matiliste_spautaue","talonOreilles","grosping","relativite","actif","conclusionNeo","conclusionTenarNeo",
            "tcons_neonatologie.auther","refHospi",'gestite','obesite','autresAccouchement',
            'taille_2','Fc_2', 'organes_genitaux', 'ailleurs',
            //---------------------------------------------------
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
            "tmedecin.slug as slug_medecin","refEnteteTriage","tdetailtriage.Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')            
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tcons_neonatologie.deleted','NON']
            ])            
            ->orderBy("tcons_neonatologie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
          
            $data = DB::table('tcons_neonatologie')
            ->join('thospitalisation','thospitalisation.id','=','tcons_neonatologie.refHospi')
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
            ->select("tcons_neonatologie.id","nomPere","nomMere","adresse","telephone","dateAcouchement","heureAcouchemnt",
            "dateTransfert","heureTransfert","dateAdmission","heureAdmission","motifAppel","ageMere","poidsMere","tailleMere",
            "gastrite","partie","avortement","deces","dateTransfert2","tcons_neonatologie.groupeSanguin as groupeSanguin_neo","antecedante","DDR","DRA","nbrCPN","fiv",
            "VAT","DPA","SP","acideFolique","vih","agHbs","hepatheC","syphilis","toxo","rubeole","mebesdazole","autres","HTA","diabet",
            "urogenital","paludisme","toxenule","nbrECHO","protocole","DPASebuecho","traitemesvats","tcons_neonatologie.datenaissance as datenaissanceNeo","termeSeonDDR",
            "termeSeonEcho","termeSeionScore","RPM","notionFievre","sifievreResultat","Hnaissance","aspestDuLA","autresNEO","dureeTravail",
            "dureeTravail","presentation","modeAcouchement","peridurable","cesarieneIndicat","tempsMaternel","carticotherapie","surfaceMg","MedicamentRecus","presencePediatre",
            "RealiserPar","parDr","sexe","tcons_neonatologie.poids as poids_neo","pc","pt","saOxygeneNeo","glicemie","apgarm1","apgarm5","apgarm10","criM1","criM5","reanimationNeo","duree","cyanose",
            "abdoman","frNeo","tempeNeo","trcNeo","conjonctivebaion","membres","examenNerologique","coeurPoumon","ban","tic","tsc","enfance","balenceMautxiphoide","scareSylverman","vigilance"
            ,"vigilance","attitude","sd","criNeo","echarpe","maro","matiliste_spautaue","talonOreilles","grosping","relativite","actif","conclusionNeo","conclusionTenarNeo",
            "tcons_neonatologie.auther","refHospi",'gestite','obesite','autresAccouchement',
            'taille_2','Fc_2', 'organes_genitaux', 'ailleurs',
            //---------------------------------------------------
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
            "tmedecin.slug as slug_medecin","refEnteteTriage","tdetailtriage.Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
            ->where([['tcons_neonatologie.deleted','NON']])            
            ->orderBy("tcons_neonatologie.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_consultNeo(Request $request,$refHospi)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tcons_neonatologie')
            ->join('thospitalisation','thospitalisation.id','=','tcons_neonatologie.refHospi')
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
            ->select("tcons_neonatologie.id","nomPere","nomMere","adresse","telephone","dateAcouchement","heureAcouchemnt",
            "dateTransfert","heureTransfert","dateAdmission","heureAdmission","motifAppel","ageMere","poidsMere","tailleMere",
            "gastrite","partie","avortement","deces","dateTransfert2","tcons_neonatologie.groupeSanguin as groupeSanguin_neo","antecedante","DDR","DRA","nbrCPN","fiv",
            "VAT","DPA","SP","acideFolique","vih","agHbs","hepatheC","syphilis","toxo","rubeole","mebesdazole","autres","HTA","diabet",
            "urogenital","paludisme","toxenule","nbrECHO","protocole","DPASebuecho","traitemesvats","tcons_neonatologie.datenaissance as datenaissanceNeo","Hnaissance","termeSeonDDR",
            "termeSeonEcho","termeSeionScore","RPM","notionFievre","sifievreResultat","aspestDuLA","autresNEO","dureeTravail",
            "presentation","modeAcouchement","peridurable","cesarieneIndicat","tempsMaternel","carticotherapie","surfaceMg","MedicamentRecus","presencePediatre",
            "RealiserPar","parDr","sexe","tcons_neonatologie.poids as poids_neo","pc","pt","saOxygeneNeo","glicemie","apgarm1","apgarm5","apgarm10","criM1","criM5","reanimationNeo","duree","cyanose",
            "abdoman","frNeo","tempeNeo","trcNeo","conjonctivebaion","membres","examenNerologique","coeurPoumon","ban","tic","tsc","enfance","balenceMautxiphoide","scareSylverman","vigilance"
            ,"vigilance","attitude","sd","criNeo","echarpe","maro","matiliste_spautaue","talonOreilles","grosping","relativite","actif","conclusionNeo","conclusionTenarNeo",
            "tcons_neonatologie.auther","refHospi",'gestite','obesite','autresAccouchement',
            'taille_2','Fc_2', 'organes_genitaux', 'ailleurs',
            //---------------------------------------------------
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
            "tmedecin.slug as slug_medecin","refEnteteTriage","tdetailtriage.Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')            
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refHospi',$refHospi],
                ['tcons_neonatologie.deleted','NON']
            ])                    
            ->orderBy("tcons_neonatologie.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tcons_neonatologie')
            ->join('thospitalisation','thospitalisation.id','=','tcons_neonatologie.refHospi')
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
            ->select("tcons_neonatologie.id","nomPere","nomMere","adresse","telephone","dateAcouchement","heureAcouchemnt",
            "dateTransfert","heureTransfert","dateAdmission","heureAdmission","motifAppel","ageMere","poidsMere","tailleMere",
            "gastrite","partie","avortement","deces","dateTransfert2","tcons_neonatologie.groupeSanguin as groupeSanguin_neo","antecedante","DDR","DRA","nbrCPN","fiv",
            "VAT","DPA","SP","acideFolique","vih","agHbs","hepatheC","syphilis","toxo","rubeole","mebesdazole","autres","HTA","diabet",
            "urogenital","paludisme","toxenule","nbrECHO","protocole","DPASebuecho","traitemesvats","tcons_neonatologie.datenaissance as datenaissanceNeo","Hnaissance","termeSeonDDR",
            "termeSeonEcho","termeSeionScore","RPM","notionFievre","sifievreResultat","aspestDuLA","autresNEO","dureeTravail",
            "presentation","modeAcouchement","peridurable","cesarieneIndicat","tempsMaternel","carticotherapie","surfaceMg","MedicamentRecus","presencePediatre",
            "RealiserPar","parDr","sexe","tcons_neonatologie.poids as poids_neo","pc","pt","saOxygeneNeo","glicemie","apgarm1","apgarm5","apgarm10","criM1","criM5","reanimationNeo","duree","cyanose",
            "abdoman","frNeo","tempeNeo","trcNeo","conjonctivebaion","membres","examenNerologique","coeurPoumon","ban","tic","tsc","enfance","balenceMautxiphoide","scareSylverman","vigilance"
            ,"vigilance","attitude","sd","criNeo","echarpe","maro","matiliste_spautaue","talonOreilles","grosping","relativite","actif","conclusionNeo","conclusionTenarNeo",
            "tcons_neonatologie.auther","refHospi",'gestite','obesite','autresAccouchement',
            'taille_2','Fc_2', 'organes_genitaux', 'ailleurs',
            //---------------------------------------------------
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
            "tmedecin.slug as slug_medecin","refEnteteTriage","tdetailtriage.Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')             
            ->Where([
                ['refHospi',$refHospi],
                ['tcons_neonatologie.deleted','NON']
            ])    
            ->orderBy("tcons_neonatologie.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    

   

    function fetch_single_consultneo($id)
    {

        $data = DB::table('tcons_neonatologie')
            ->join('thospitalisation','thospitalisation.id','=','tcons_neonatologie.refHospi')
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
            ->select("tcons_neonatologie.id","nomPere","nomMere","adresse","telephone","dateAcouchement","heureAcouchemnt",
            "dateTransfert","heureTransfert","dateAdmission","heureAdmission","motifAppel","ageMere","poidsMere","tailleMere",
            "gastrite","partie","avortement","deces","dateTransfert2","tcons_neonatologie.groupeSanguin","antecedante","DDR","DRA","nbrCPN","fiv",
            "VAT","DPA","SP","acideFolique","vih","agHbs","hepatheC","syphilis","toxo","rubeole","mebesdazole","autres","HTA","diabet",
            "urogenital","paludisme","toxenule","nbrECHO","protocole","DPASebuecho","traitemesvats","tcons_neonatologie.datenaissance as datenaissanceNeo","Hnaissance","termeSeonDDR",
            "termeSeonEcho","termeSeionScore","RPM","notionFievre","sifievreResultat","aspestDuLA","autresNEO","dureeTravail",
            "presentation","modeAcouchement","peridurable","cesarieneIndicat","tempsMaternel","carticotherapie","surfaceMg","MedicamentRecus","presencePediatre",
            "RealiserPar","parDr","sexe","tcons_neonatologie.poids as poids_neo","pc","pt","saOxygeneNeo","glicemie","apgarm1","apgarm5","apgarm10","criM1","criM5","reanimationNeo","duree","cyanose",
            "abdoman","frNeo","tempeNeo","trcNeo","conjonctivebaion","membres","examenNerologique","coeurPoumon","ban","tic","tsc","enfance","balenceMautxiphoide","scareSylverman","vigilance"
            ,"vigilance","attitude","sd","criNeo","echarpe","maro","matiliste_spautaue","talonOreilles","grosping","relativite","actif","conclusionNeo","conclusionTenarNeo",
            "tcons_neonatologie.auther","refHospi",'gestite','obesite','autresAccouchement',
            'taille_2','Fc_2', 'organes_genitaux', 'ailleurs',
            //---------------------------------------------------
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
            "tmedecin.slug as slug_medecin","refEnteteTriage","tdetailtriage.Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')          
        ->where('tcons_neonatologie.id', $id)
                ->get();

                return response()->json([
                'data' => $data,
                ]);
    }

   //autresAccouchement
    function insert_consult_neo(Request $request)
    {
        $data = tcons_neonatologie::create([
            'refHospi'       =>  $request->refHospi,
            'nomPere'    =>  $request->nomPere,
            'nomMere'    =>  $request->nomMere,
            'adresse'    =>  $request->adresse,
            'telephone'    =>  $request->telephone,
            'dateAcouchement'    =>  $request->dateAcouchement, 
            'heureAcouchemnt'    =>  $request->heureAcouchemnt,
            'dateTransfert'       =>  $request->dateTransfert,
            'heureTransfert'    =>  $request->heureTransfert,
            'dateAdmission'    =>  $request->dateAdmission,
            'heureAdmission'    =>  $request->heureAdmission,
            'motifAppel'    =>  $request->motifAppel, 
            'ageMere'    =>  $request->ageMere,
            'poidsMere'       =>  $request->poidsMere,
            'tailleMere'       =>  $request->tailleMere,
            'gastrite'    =>  $request->gastrite,
            'partie'    =>  $request->partie,
            'avortement'    =>  $request->avortement,
            'deces'    =>  $request->deces, 
            'dateTransfert2'    =>  $request->dateTransfert2,
            'gestite'  =>  $request->gestite,
            'groupeSanguin'       =>  $request->groupeSanguin,
            'antecedante'       =>  $request->antecedante,
            'DDR'    =>  $request->DDR,
            'DRA'    =>  $request->DRA,
            'nbrCPN'    =>  $request->nbrCPN,
            'fiv'    =>  $request->fiv, 
            'VAT'    =>  $request->VAT,
            'DPA'       =>  $request->DPA,
            'SP'       =>  $request->SP,
            'acideFolique'    =>  $request->acideFolique,
            'vih'    =>  $request->vih,
            'agHbs'    =>  $request->agHbs,
            'hepatheC'    =>  $request->hepatheC, 
            'syphilis'    =>  $request->syphilis,
            'toxo'       =>  $request->toxo,
            'rubeole'       =>  $request->rubeole,
            'mebesdazole'    =>  $request->mebesdazole,
            'autres'    =>  $request->autres,
            'HTA'    =>  $request->HTA,
            'diabet'    =>  $request->diabet, 
            'obesite'    =>  $request->obesite, 
            'urogenital'    =>  $request->urogenital,
            'paludisme'       =>  $request->paludisme,
            'toxenule'       =>  $request->toxenule,
            'nbrECHO'    =>  $request->nbrECHO,
            'protocole'    =>  $request->protocole,
            'DPASebuecho'    =>  $request->DPASebuecho,
            'traitemesvats'    =>  $request->traitemesvats, 
            'datenaissance'    =>  $request->datenaissance,
            'Hnaissance'       =>  $request->Hnaissance,
            'termeSeonDDR'       =>  $request->termeSeonDDR,
            'termeSeonEcho'    =>  $request->termeSeonEcho,
            'termeSeionScore'    =>  $request->termeSeionScore,
            'RPM'    =>  $request->RPM,
            'notionFievre'    =>  $request->notionFievre, 
            'sifievreResultat'    =>  $request->sifievreResultat,
            'aspestDuLA'       =>  $request->aspestDuLA,
            'autresNEO'    =>  $request->autresNEO,
            'autresAccouchement'    =>  $request->autresAccouchement,
            'dureeTravail'    =>  $request->dureeTravail,
            'presentation'    =>  $request->presentation,
            'modeAcouchement'    =>  $request->modeAcouchement, 
            'peridurable'    =>  $request->peridurable,
            'cesarieneIndicat'       =>  $request->cesarieneIndicat,
            'tempsMaternel'       =>  $request->tempsMaternel,
            'carticotherapie'    =>  $request->carticotherapie,
            'surfaceMg'    =>  $request->surfaceMg,
            'MedicamentRecus'    =>  $request->MedicamentRecus,
            'presencePediatre'    =>  $request->presencePediatre, 
            'RealiserPar'    =>  $request->RealiserPar,
            'parDr'       =>  $request->parDr,
            'sexe'       =>  $request->sexe,
            'poids'    =>  $request->poids,
            'taille_2'  => $request->taille_2,
            'pc'    =>  $request->pc,
            'pt'    =>  $request->pt,
            'saOxygeneNeo'    =>  $request->saOxygeneNeo, 
            'glicemie'    =>  $request->glicemie,
            'apgarm1'       =>  $request->apgarm1,
            'apgarm5'       =>  $request->apgarm5,
            'apgarm10'    =>  $request->apgarm10,
            'criM1'       =>  $request->criM1,
            'criM5'       =>  $request->criM5,
            'reanimationNeo'    =>  $request->reanimationNeo,
            'duree'    =>  $request->duree,
            'cyanose'    =>  $request->cyanose,
            'abdoman'    =>  $request->abdoman, 
            'frNeo'    =>  $request->frNeo,
            'tempeNeo'       =>  $request->tempeNeo,
            'trcNeo'       =>  $request->trcNeo,
            'conjonctivebaion'    =>  $request->conjonctivebaion,
            'membres'       =>  $request->membres,
            'examenNerologique'       =>  $request->examenNerologique,
            'Fc_2'       =>  $request->Fc_2,
            'organes_genitaux'       =>  $request->organes_genitaux,
            'ailleurs'       =>  $request->ailleurs,
            //,'Fc_2', 'organes_genitaux', 'ailleurs'
            'coeurPoumon'       =>  $request->coeurPoumon,
            'ban'    =>  $request->ban,
            'tic'    =>  $request->tic,
            'tsc'    =>  $request->tsc,
            'enfance'    =>  $request->enfance,
            'balenceMautxiphoide'    =>  $request->balenceMautxiphoide, 
            'scareSylverman'    =>  $request->scareSylverman,
            'vigilance'       =>  $request->vigilance,
            'attitude'       =>  $request->attitude,
            'sd'    =>  $request->sd,
            'criNeo'       =>  $request->criNeo,
            'echarpe'       =>  $request->echarpe,
            'maro'    =>  $request->maro,
            'matiliste_spautaue'    =>  $request->matiliste_spautaue,
            'talonOreilles'    =>  $request->talonOreilles,
            'grosping'    =>  $request->grosping, 
            'relativite'    =>  $request->relativite,
            'actif'       =>  $request->actif,
            'conclusionNeo'       =>  $request->conclusionNeo,
            'conclusionTenarNeo'       =>  $request->conclusionTenarNeo,
            'auther'       =>  $request->auther
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_consult_neo(Request $request, $id)
    {
        $data = tcons_neonatologie::where('id', $id)->update([
            'refHospi'       =>  $request->refHospi,
            'nomPere'    =>  $request->nomPere,
            'nomMere'    =>  $request->nomMere,
            'adresse'    =>  $request->adresse,
            'telephone'    =>  $request->telephone,
            'dateAcouchement'    =>  $request->dateAcouchement, 
            'heureAcouchemnt'    =>  $request->heureAcouchemnt,
            'dateTransfert'       =>  $request->dateTransfert,
            'heureTransfert'    =>  $request->heureTransfert,
            'dateAdmission'    =>  $request->dateAdmission,
            'heureAdmission'    =>  $request->heureAdmission,
            'motifAppel'    =>  $request->motifAppel, 
            'ageMere'    =>  $request->ageMere,
            'poidsMere'       =>  $request->poidsMere,
            'tailleMere'       =>  $request->tailleMere,
            'gastrite'    =>  $request->gastrite,
            'partie'    =>  $request->partie,
            'avortement'    =>  $request->avortement,
            'deces'    =>  $request->deces, 
            'dateTransfert2'    =>  $request->dateTransfert2,
            'gestite'  =>  $request->gestite,
            'groupeSanguin'       =>  $request->groupeSanguin,
            'antecedante'       =>  $request->antecedante,
            'DDR'    =>  $request->DDR,
            'DRA'    =>  $request->DRA,
            'nbrCPN'    =>  $request->nbrCPN,
            'fiv'    =>  $request->fiv, 
            'VAT'    =>  $request->VAT,
            'DPA'       =>  $request->DPA,
            'SP'       =>  $request->SP,
            'acideFolique'    =>  $request->acideFolique,
            'vih'    =>  $request->vih,
            'agHbs'    =>  $request->agHbs,
            'hepatheC'    =>  $request->hepatheC, 
            'syphilis'    =>  $request->syphilis,
            'toxo'       =>  $request->toxo,
            'rubeole'       =>  $request->rubeole,
            'mebesdazole'    =>  $request->mebesdazole,
            'autres'    =>  $request->autres,
            'HTA'    =>  $request->HTA,
            'diabet'    =>  $request->diabet, 
            'obesite'    =>  $request->obesite, 
            'urogenital'    =>  $request->urogenital,
            'paludisme'       =>  $request->paludisme,
            'toxenule'       =>  $request->toxenule,
            'nbrECHO'    =>  $request->nbrECHO,
            'protocole'    =>  $request->protocole,
            'DPASebuecho'    =>  $request->DPASebuecho,
            'traitemesvats'    =>  $request->traitemesvats, 
            'datenaissance'    =>  $request->datenaissance,
            'Hnaissance'       =>  $request->Hnaissance,
            'termeSeonDDR'       =>  $request->termeSeonDDR,
            'termeSeonEcho'    =>  $request->termeSeonEcho,
            'termeSeionScore'    =>  $request->termeSeionScore,
            'RPM'    =>  $request->RPM,
            'notionFievre'    =>  $request->notionFievre, 
            'sifievreResultat'    =>  $request->sifievreResultat,
            'aspestDuLA'       =>  $request->aspestDuLA,
            'autresNEO'    =>  $request->autresNEO,
            'autresAccouchement'    =>  $request->autresAccouchement,
            'dureeTravail'    =>  $request->dureeTravail,
            'presentation'    =>  $request->presentation,
            'modeAcouchement'    =>  $request->modeAcouchement, 
            'peridurable'    =>  $request->peridurable,
            'cesarieneIndicat'       =>  $request->cesarieneIndicat,
            'tempsMaternel'       =>  $request->tempsMaternel,
            'carticotherapie'    =>  $request->carticotherapie,
            'surfaceMg'    =>  $request->surfaceMg,
            'MedicamentRecus'    =>  $request->MedicamentRecus,
            'presencePediatre'    =>  $request->presencePediatre, 
            'RealiserPar'    =>  $request->RealiserPar,
            'parDr'       =>  $request->parDr,
            'sexe'       =>  $request->sexe,
            'poids'    =>  $request->poids,
            'taille_2'  => $request->taille_2,
            'pc'    =>  $request->pc,
            'pt'    =>  $request->pt,
            'saOxygeneNeo'    =>  $request->saOxygeneNeo, 
            'glicemie'    =>  $request->glicemie,
            'apgarm1'       =>  $request->apgarm1,
            'apgarm5'       =>  $request->apgarm5,
            'apgarm10'    =>  $request->apgarm10,
            'criM1'       =>  $request->criM1,
            'criM5'       =>  $request->criM5,
            'reanimationNeo'    =>  $request->reanimationNeo,
            'duree'    =>  $request->duree,
            'cyanose'    =>  $request->cyanose,
            'abdoman'    =>  $request->abdoman, 
            'frNeo'    =>  $request->frNeo,
            'tempeNeo'       =>  $request->tempeNeo,
            'trcNeo'       =>  $request->trcNeo,
            'conjonctivebaion'    =>  $request->conjonctivebaion,
            'membres'       =>  $request->membres,
            'examenNerologique'       =>  $request->examenNerologique,
            'Fc_2'       =>  $request->Fc_2,
            'organes_genitaux'       =>  $request->organes_genitaux,
            'ailleurs'       =>  $request->ailleurs,
            'coeurPoumon'       =>  $request->coeurPoumon,
            'ban'    =>  $request->ban,
            'tic'    =>  $request->tic,
            'tsc'    =>  $request->tsc,
            'enfance'    =>  $request->enfance,
            'balenceMautxiphoide'    =>  $request->balenceMautxiphoide, 
            'scareSylverman'    =>  $request->scareSylverman,
            'vigilance'       =>  $request->vigilance,
            'attitude'       =>  $request->attitude,
            'sd'    =>  $request->sd,
            'criNeo'       =>  $request->criNeo,
            'echarpe'       =>  $request->echarpe,
            'maro'    =>  $request->maro,
            'matiliste_spautaue'    =>  $request->matiliste_spautaue,
            'talonOreilles'    =>  $request->talonOreilles,
            'grosping'    =>  $request->grosping, 
            'relativite'    =>  $request->relativite,
            'actif'       =>  $request->actif,
            'conclusionNeo'       =>  $request->conclusionNeo,
            'conclusionTenarNeo'       =>  $request->conclusionTenarNeo,
            'auther'       =>  $request->auther
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_consult_neo($id)
    {
        $data = tcons_neonatologie::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
