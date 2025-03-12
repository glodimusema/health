<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_vaccination_enfant;
use App\Models\Enfant\tenfant_rendevous_enfant;
use App\Traits\{GlobalMethod,Slug};

use DB;
//
class tenfant_vaccination_enfantController extends Controller
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

            $data = DB::table('tenfant_vaccination_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_vaccination_enfant.refEnteteVac')
            ->join('t_enfant_mode_attente_enfant','t_enfant_mode_attente_enfant.id','=','tenfant_vaccination_enfant.refModeAtteinte')
            ->join('t_enfant_strategie','t_enfant_strategie.id','=','tenfant_vaccination_enfant.refStrategie')
            ->join('tenfant_vaccin','tenfant_vaccin.id','=','tenfant_vaccination_enfant.refVaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')

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
                //MALADE
            ->select("tenfant_vaccination_enfant.id","refEnteteVac","refVaccin","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode",
            "refStrategie","name_strategie","refModeAtteinte","name_mode","dateprevue","dateRecu","poids",
            "observation","taille","refMouvement","dateEntete","tenfant_vaccination_enfant.author",
            "tenfant_vaccination_enfant.created_at",
    
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche",
            "Mere18ans","ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h",
            "ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS",
            "TypeAccouchement","AccouchementFOSA",
    
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
            ->selectRaw('TIMESTAMPDIFF(DAY, dateprevue, dateRecu) as nombrejourretard')
            ->where([
                ['noms', 'like', '%'.$query.'%'],               
                ['Statut','Encours'],
                ['tenfant_vaccination_enfant.deleted','NON']
            ])            
            ->orderBy("tenfant_vaccination_enfant.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenfant_vaccination_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_vaccination_enfant.refEnteteVac')
            ->join('t_enfant_mode_attente_enfant','t_enfant_mode_attente_enfant.id','=','tenfant_vaccination_enfant.refModeAtteinte')
            ->join('t_enfant_strategie','t_enfant_strategie.id','=','tenfant_vaccination_enfant.refStrategie')
            ->join('tenfant_vaccin','tenfant_vaccin.id','=','tenfant_vaccination_enfant.refVaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')

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
                //MALADE
            ->select("tenfant_vaccination_enfant.id","refEnteteVac","refVaccin","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode",
            "refStrategie","name_strategie","refModeAtteinte","name_mode","dateprevue","dateRecu","poids",
            "observation","taille","refMouvement","dateEntete","tenfant_vaccination_enfant.author",
            "tenfant_vaccination_enfant.created_at",
    
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche",
            "Mere18ans","ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h",
            "ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS",
            "TypeAccouchement","AccouchementFOSA",
    
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
            ->selectRaw('TIMESTAMPDIFF(DAY, dateprevue, dateRecu) as nombrejourretard')
            ->where([
                ['Statut','Encours'],
                ['tenfant_vaccination_enfant.deleted','NON']
            ])
            ->orderBy("tenfant_vaccination_enfant.id", "desc")               
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_vacination_entete(Request $request,$refEnteteVac)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tenfant_vaccination_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_vaccination_enfant.refEnteteVac')
            ->join('t_enfant_mode_attente_enfant','t_enfant_mode_attente_enfant.id','=','tenfant_vaccination_enfant.refModeAtteinte')
            ->join('t_enfant_strategie','t_enfant_strategie.id','=','tenfant_vaccination_enfant.refStrategie')
            ->join('tenfant_vaccin','tenfant_vaccin.id','=','tenfant_vaccination_enfant.refVaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')

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
                //MALADE
            ->select("tenfant_vaccination_enfant.id","refEnteteVac","refVaccin","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode",
            "refStrategie","name_strategie","refModeAtteinte","name_mode","dateprevue","dateRecu","poids",
            "observation","taille","refMouvement","dateEntete","tenfant_vaccination_enfant.author",
            "tenfant_vaccination_enfant.created_at",
    
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche",
            "Mere18ans","ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h",
            "ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS",
            "TypeAccouchement","AccouchementFOSA",
    
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
            ->selectRaw('TIMESTAMPDIFF(DAY, dateprevue, dateRecu) as nombrejourretard')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refEnteteVac',$refEnteteVac],
                ['tenfant_vaccination_enfant.deleted','NON']
            ])                      
            ->orderBy("tenfant_vaccination_enfant.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);         

        }
        else{
            $data = DB::table('tenfant_vaccination_enfant')
            ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_vaccination_enfant.refEnteteVac')
            ->join('t_enfant_mode_attente_enfant','t_enfant_mode_attente_enfant.id','=','tenfant_vaccination_enfant.refModeAtteinte')
            ->join('t_enfant_strategie','t_enfant_strategie.id','=','tenfant_vaccination_enfant.refStrategie')
            ->join('tenfant_vaccin','tenfant_vaccin.id','=','tenfant_vaccination_enfant.refVaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')

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
                //MALADE
            ->select("tenfant_vaccination_enfant.id","refEnteteVac","refVaccin","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode",
            "refStrategie","name_strategie","refModeAtteinte","name_mode","dateprevue","dateRecu","poids",
            "observation","taille","refMouvement","dateEntete","tenfant_vaccination_enfant.author",
            "tenfant_vaccination_enfant.created_at",
    
            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche",
            "Mere18ans","ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h",
            "ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS",
            "TypeAccouchement","AccouchementFOSA",
    
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
            ->selectRaw('TIMESTAMPDIFF(DAY, dateprevue, dateRecu) as nombrejourretard')
            ->Where([
                ['refEnteteVac',$refEnteteVac],
                ['tenfant_vaccination_enfant.deleted','NON']
            ])    
            ->orderBy("tenfant_vaccination_enfant.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    } 

    function fetch_single($id)
    {

        $data = DB::table('tenfant_vaccination_enfant')
        ->join('tenfant_entete_vaccination','tenfant_entete_vaccination.id','=','tenfant_vaccination_enfant.refEnteteVac')
        ->join('t_enfant_mode_attente_enfant','t_enfant_mode_attente_enfant.id','=','tenfant_vaccination_enfant.refModeAtteinte')
        ->join('t_enfant_strategie','t_enfant_strategie.id','=','tenfant_vaccination_enfant.refStrategie')
        ->join('tenfant_vaccin','tenfant_vaccin.id','=','tenfant_vaccination_enfant.refVaccin')
        ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
        ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')

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
            //MALADE
        ->select("tenfant_vaccination_enfant.id","refEnteteVac","refVaccin","name_vaccin","name_categorie",
        "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode",
        "refStrategie","name_strategie","refModeAtteinte","name_mode","dateprevue","dateRecu","poids",
        "observation","taille","refMouvement","dateEntete","tenfant_vaccination_enfant.author",
        "tenfant_vaccination_enfant.created_at",

        "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
        "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
        "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche",
        "Mere18ans","ModeAccouchement","Apgar","Nevaripine","Mortne","Mort24h",
        "ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
        "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS",
        "TypeAccouchement","AccouchementFOSA",

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
        ->selectRaw('TIMESTAMPDIFF(DAY, dateprevue, dateRecu) as nombrejourretard')
        ->where('tenfant_vaccination_enfant.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    //id,refEnteteVac,refPeriode,refStrategie,refModeAtteinte,dateprevue,dateRecu,poids,observation,taille,author

    function insertData(Request $request)
    { 
        $refPeriodes=$request->refPeriode;
        $idVaccin=0;
        $listes = DB::table('tenfant_vaccin')
        ->where('tenfant_vaccin.refPeriode', $refPeriodes)
        ->get();
    
        foreach ($listes as $list) {
            $idVaccin= $list->id;

            $data = tenfant_vaccination_enfant::create([
                'refEnteteVac'       =>  $request->refEnteteVac,
                'refVaccin'    =>  $idVaccin,                           
                'refStrategie'       =>  $request->refStrategie,
                'refModeAtteinte'=>$request->refModeAtteinte,
                'dateprevue'=>$request->dateprevue,
                'dateRecu'=>$request->dateRecu,
                'poids'=>$request->poids,
                'observation'=>$request->observation,
                'taille'=>$request->taille,
                'author'=>$request->author
            ]);
        }        
        
        $data = tenfant_rendevous_enfant::where([
            ['refEntete', $request->refEnteteVac],
            ['refPeriode', $request->refPeriode]
        ])->update([
            'etatRdv'=>1,
            'author'=>$request->author
        ]);
        
        return response()->json([
            'data'  =>  "Inbsertion  avec succès!!!",
        ]);
    }

    //id,refEnteteVac,refPeriode,refStrategie,refModeAtteinte,dateprevue,dateRecu,poids,observation,taille,author

    function updateData(Request $request,$id)
    {       
        $data = tenfant_vaccination_enfant::where('id', $id)->update([
            'refEnteteVac'       =>  $request->refEnteteVac,
            'refPeriode'    =>  $request->refPeriode,                           
            'refStrategie'       =>  $request->refStrategie,
            'refModeAtteinte'=>$request->refModeAtteinte,
            'dateprevue'=>$request->dateprevue,
            'dateRecu'=>$request->dateRecu,
            'poids'=>$request->poids,
            'observation'=>$request->observation,
            'taille'=>$request->taille,
            'author'=>$request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
   }


    function destroy(Request $request)
    {
        $data = tenfant_entete_vaccination::where([
            ['refEntete', $request->refEnteteVac],
            ['refPeriode', $request->refPeriode]
        ])->delete();

        $data = tenfant_rendevous_enfant::where([
            ['refEntete', $request->refEnteteVac],
            ['refPeriode', $request->refPeriode]
        ])->update([
            'etatRdv'=>0,
            'author'=>$request->author
        ]);

        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
