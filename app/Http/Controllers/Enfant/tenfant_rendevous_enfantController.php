<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_rendevous_enfant;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tenfant_rendevous_enfantController extends Controller
{
     
    use GlobalMethod, Slug;

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

            $data = DB::table('tenfant_rendevous_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
            ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
            "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
            "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",

             "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
            "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
            "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
            "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

            "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
            "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
            'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],               
                ['Statut','Encours'],
                ['tenfant_rendevous_enfant.deleted','NON']
            ])            
            ->orderBy("tenfant_rendevous_enfant.id", "asc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenfant_rendevous_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
            ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
            "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
            "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",

             "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
            "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
            "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
            "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

            "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
            "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
            'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['Statut','Encours'],
                ['tenfant_rendevous_enfant.deleted','NON']
            ])
            ->orderBy("tenfant_rendevous_enfant.id", "asc")               
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);

            }

    }


    public function fetch_rendezvous_vaccination(Request $request,$refEntete)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tenfant_rendevous_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
            ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
            "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
            "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",

             "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
            "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
            "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
            "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

            "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
            "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
            'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEntete',$refEntete],
                ['tenfant_rendevous_enfant.deleted','NON']
            ])                      
            ->orderBy("tenfant_rendevous_enfant.id", "asc")
            ->paginate(10);

            return response()->json([
            'data'  => $data,
            ]);        

        }
        else{
            $data = DB::table('tenfant_rendevous_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
            ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')

            ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
            "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
            "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",

             "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
            "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
            "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
            "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

            "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
            "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
            'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([
                ['refEntete',$refEntete],
                ['tenfant_rendevous_enfant.deleted','NON']
            ])    
            ->orderBy("tenfant_rendevous_enfant.id", "asc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    } 

    function fetch_single($id)
    {

        $data = DB::table('tenfant_rendevous_enfant')
        ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
        ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
        ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')

        ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
        "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
        "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",

         "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
        "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
        "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
        "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
        "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
        "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
        "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

        "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
        "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
        'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tenfant_rendevous_enfant.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    public function fetch_rdv_patient(Request $request)
    {  
        if (($request->get('refPeriode')) && ($request->get('refEntete'))) 
        {
            $refPeriode = $request->get('refPeriode');
            $refEntete = $request->get('refEntete');

            $data=DB::table('tenfant_rendevous_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_rendevous_enfant.refEntete')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_rendevous_enfant.refPeriode')
            ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
    
            ->select("tenfant_rendevous_enfant.id","dateRdv","etatRdv","compteurRandezvous",
            "name_periode","duree_periode","tenfant_rendevous_enfant.author","refPeriode",
            "tenfant_rendevous_enfant.created_at","tenfant_rendevous_enfant.updated_at",
    
             "refMouvement","dateEntete","refEntete","tenfant_entete_vaccination.author",
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans",
            "ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement",
            "ReanimationEnfant","ComplicatioPostPartum","VitamineMere","FerMere","TailleNaissance",
            "CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",
    
            "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
            "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
            'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([             
                ['refPeriode', $refPeriode],
                ['refEntete', $refEntete],
                ['tenfant_rendevous_enfant.deleted','NON']
            ])    
            ->get();
            return response()->json([
                'data'  => $data,
            ]);
        
           
        
        
        }   
        
        
    }    










    function insertData(Request $request)
    {
        $data = tenfant_rendevous_enfant::create([
            'refEntete'       =>  $request->refEntete,
            'refPeriode'    =>  $request->refPeriode,                           
            'dateRdv'       =>  $request->dateRdv,
            'etatRdv'=>$request->etatRdv,
            'compteurRandezvous'=>$request->compteurRandezvous,
            'author'=>$request->author
        ]);
        return response()->json([
            'data'  =>  "Inbsertion  avec succès!!!",
        ]);

    }

    function updateData(Request $request,$id)
    {
        //id,refEntete,refPeriode,dateRdv,etatRdv,compteurRandezvous,author
       
        $data = tenfant_rendevous_enfant::where('id', $id)->update([
            'refEntete'       =>  $request->refEntete,
            'refPeriode'    =>  $request->refPeriode,                           
            'dateRdv'       =>  $request->dateRdv,
            'etatRdv'=>$request->etatRdv,
            'compteurRandezvous'=>$request->compteurRandezvous,
            'author'=>$request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
   }


    function delete($id)
    {
        $data = tenfant_rendevous_enfant::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
