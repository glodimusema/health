<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pharmacie\tmed_detailbesoin;
use DB;
class tmed_detailbesoinController extends Controller
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

            $data = DB::table('tmed_detailbesoin')
           //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
            ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
            ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
            ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
            ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
            'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
            "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
            ->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("tmed_detailbesoin.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmed_detailbesoin')
            //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
             ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
             ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
             ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
             ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
             ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
             ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
             ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
             'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
             'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
             "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
             "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
             "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
             "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
             "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
             "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
             "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
             "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
             "numeroCarte_malade","dateExpiration_malade")
             ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
             ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
            ->orderBy("tmed_detailbesoin.id", "desc")
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

            $data= DB::table('tmed_detailbesoin')
            //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
             ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
             ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
             ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
             ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
             ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
             ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
             ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
             'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
             'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
             "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
             "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
             "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
             "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
             "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
             "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
             "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
             "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
             "numeroCarte_malade","dateExpiration_malade")
             ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
             ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['refEnteteVente',$refEntete]
            ])                     
            ->orderBy("tmed_detailbesoin.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmed_detailbesoin')
            //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
             ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
             ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
             ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
             ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
             ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
             ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
             ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
             'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
             'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
             "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
             "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
             "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
             "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
             "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
             "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
             "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
             "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
             "numeroCarte_malade","dateExpiration_malade")
             ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
             ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
            ->Where('refEnteteVente',$refEntete) 
            ->orderBy("tmed_detailbesoin.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

  

    function fetch_single_detail($id)
    {

        $data = DB::table('tmed_detailbesoin')        
         ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
         ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
         ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
         ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
         'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
         'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
         "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
         "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
         'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
         "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
         "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
         "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
         "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
         "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
         "numeroCarte_malade","dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
        ->where('tmed_detailbesoin.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   ////tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
    function insert_detail(Request $request)
    {
        $data = tmed_detailbesoin::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refmedicament'    =>  $request->refmedicament,
            'qte_besoin'    =>  $request->qte_besoin,
            'pu_besoin'    =>  $request->pu_besoin,
            'observation_besoin'    =>  $request->observation_besoin,            
            'author'       =>  $request->author
        ]);

        return response()->json([
            'data'  =>  "Enregistrement reussi !!!",
        ]);
         
       


    }

    function update_detail(Request $request, $id)
    {
        $data = tmed_detailbesoin::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refmedicament'    =>  $request->refmedicament,
            'qte_besoin'    =>  $request->qte_besoin,
            'pu_besoin'    =>  $request->pu_besoin,
            'observation_besoin'    =>  $request->observation_besoin,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tmed_detailbesoin::where('id',$id)->delete();

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
