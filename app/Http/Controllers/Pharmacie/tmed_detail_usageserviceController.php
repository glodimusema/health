<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_detail_usageservice;
use DB;
class tmed_detail_usageserviceController extends Controller
{

    

    //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author

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

            $data = DB::table('tmed_detail_usageservice')
            //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
            ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
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
            ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
            'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
            "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_usage*pu_usage) as PTVente')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_detail_usageservice.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_detail_usageservice')
            //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
            ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
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
            ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
            'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
            "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_usage*pu_usage) as PTVente')
            ->orderBy("tmed_detail_usageservice.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {  
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);


            $data= DB::table('tmed_detail_usageservice')
            //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
            ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
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
            ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
            'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
            "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_usage*pu_usage) as PTVente')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refEnteteVente',$refEntete]
            ])                     
            ->orderBy("tmed_detail_usageservice.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_detail_usageservice')
            //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
            ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
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
            ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
            'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
            "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_usage*pu_usage) as PTVente')
            ->Where('refEnteteVente',$refEntete) 
            ->orderBy("tmed_detail_usageservice.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

  

    function fetch_single_detail($id)
    {

        $data = DB::table('tmed_detail_usageservice')
        //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
        ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
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
        ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
        'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
        'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
        "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
        "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
        'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
        "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
        "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
        "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
        "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
        "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
        "numeroCarte_malade","dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('(qte_usage*pu_usage) as PTVente')
        ->where('tmed_detail_usageservice.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   ////tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
    function insert_detail(Request $request)
    {
        $data = tmed_detail_usageservice::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refmedicament'    =>  $request->refmedicament,
            'qte_usage'    =>  $request->qte_usage,
            'pu_usage'    =>  $request->pu_usage,
            'observation_usage'    =>  $request->observation_usage,            
            'author'       =>  $request->author
        ]);

        return response()->json([
            'data'  =>  "Enregistrement reussi !!!",
        ]);
         
       


    }

    function update_detail(Request $request, $id)
    {
        $data = tmed_detail_usageservice::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refmedicament'    =>  $request->refmedicament,
            'qte_usage'    =>  $request->qte_usage,
            'pu_usage'    =>  $request->pu_usage,
            'observation_usage'    =>  $request->observation_usage,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tmed_detail_usageservice::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
