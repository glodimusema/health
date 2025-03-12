<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_cps;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tenfant_cpsController extends Controller
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

            $data = DB::table('tenfant_cps')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_cps.refEnteteVac')
            ->join('t_enfant_periode_c_p_s','t_enfant_periode_c_p_s.id','=','tenfant_cps.refPeriode')
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

            ->select("tenfant_cps.id","dateRecu","poids",
            "dateEntete","tenfant_cps.author","refPeriode","name_periode_cps","tenfant_cps.created_at","tenfant_cps.updated_at",    
            
            "refMouvement","dateEntete","refEnteteVac","tenfant_entete_vaccination.author",
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
                ['tenfant_cps.deleted','NON']
            ])            
            ->orderBy("tenfant_cps.id", "desc")          
            ->paginate(10);

            return response()->json(
                $data
            );
           

        }
        else{
            $data = DB::table('tenfant_cps')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_cps.refEnteteVac')
            ->join('t_enfant_periode_c_p_s','t_enfant_periode_c_p_s.id','=','tenfant_cps.refPeriode')
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

            ->select("tenfant_cps.id","dateRecu","poids",
            "dateEntete","tenfant_cps.author","refPeriode","name_periode_cps","tenfant_cps.created_at","tenfant_cps.updated_at",    
            
            "refMouvement","dateEntete","refEnteteVac","tenfant_entete_vaccination.author",
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
            ->where([['tenfant_cps.deleted','NON']])
            ->orderBy("tenfant_cps.id", "desc")
            ->where('Statut','Encours')   
            ->paginate(10);
                return response()->json(
                         $data
                    );
            }

    }


    public function fetch_cps_entetevac(Request $request,$refEnteteVac)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tenfant_cps')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_cps.refEnteteVac')
            ->join('t_enfant_periode_c_p_s','t_enfant_periode_c_p_s.id','=','tenfant_cps.refPeriode')
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

            ->select("tenfant_cps.id","dateRecu","poids",
            "dateEntete","tenfant_cps.author","refPeriode","name_periode_cps","tenfant_cps.created_at",
            "tenfant_cps.updated_at",    
            
            "refMouvement","dateEntete","refEnteteVac","tenfant_entete_vaccination.author",
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
                ['refEnteteVac',$refEnteteVac],
                ['Statut','Encours'],
                ['tenfant_cps.deleted','NON']
            ])                      
            ->orderBy("tenfant_cps.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);       

        }
        else{
            $data = DB::table('tenfant_cps')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_cps.refEnteteVac')
            ->join('t_enfant_periode_c_p_s','t_enfant_periode_c_p_s.id','=','tenfant_cps.refPeriode')
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

            ->select("tenfant_cps.id","dateRecu","poids",
            "dateEntete","tenfant_cps.author","refPeriode","name_periode_cps","tenfant_cps.created_at","tenfant_cps.updated_at",    
            
            "refMouvement","dateEntete","refEnteteVac","tenfant_entete_vaccination.author",
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
                ['refEnteteVac',$refEnteteVac],
                ['tenfant_cps.deleted','NON']
            ])    
            ->orderBy("tenfant_cps.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
        }

    } 

    function fetch_single($id)
    {

        $data = DB::table('tenfant_cps')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_cps.refEnteteVac')
            ->join('t_enfant_periode_c_p_s','t_enfant_periode_c_p_s.id','=','tenfant_cps.refPeriode')
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

            ->select("tenfant_cps.id","dateRecu","poids",
            "dateEntete","tenfant_cps.author","refMouvement","refEnteteVac","refPeriode","name_periode_cps",
            "tenfant_cps.created_at","tenfant_cps.updated_at","refMalade","refTypeMouvement","dateMouvement",
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tenfant_cps.id', $id)
        ->get();

        return response()->json(
             $data
        );
    }

   

    function insertData(Request $request)
    {
       $data = tenfant_cps::create([
            'refEnteteVac'       =>  $request->refEnteteVac,
            'refPeriode'    =>  $request->refPeriode,                           
            'dateRecu'       =>  $request->dateRecu,
            'poids'=>$request->poids,
            'author'=>$request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function updateData(Request $request,$id)
    {
       
        $data = tenfant_cps::where('id', $id)->update([
            'refEnteteVac'       =>  $request->refEnteteVac,
            'refPeriode'    =>  $request->refPeriode,                           
            'dateRecu'       =>  $request->dateRecu,
            'poids'=>$request->poids,
            'author'=>$request->author        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
   }


    function delete($id)
    {
        $data = tenfant_cps::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
