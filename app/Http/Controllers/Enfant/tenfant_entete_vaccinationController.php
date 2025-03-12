<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_entete_vaccination;
use App\Models\Enfant\tenfant_rendevous_enfant;

use DB;

class tenfant_entete_vaccinationController extends Controller
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

            $data = DB::table('tenfant_entete_vaccination')
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
            ->select("tenfant_entete_vaccination.id","medecin","cnom","refMouvement","tenfant_entete_vaccination.author",

            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
            "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

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
                ['tenfant_entete_vaccination.deleted','NON']
            ])            
            ->orderBy("tenfant_entete_vaccination.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenfant_entete_vaccination')
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
            ->select("tenfant_entete_vaccination.id","refMouvement","medecin","cnom","tenfant_entete_vaccination.author",

            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
            "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

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
            ->where([['tenfant_entete_vaccination.deleted','NON']])
            ->orderBy("tenfant_entete_vaccination.id", "desc")
            ->where('Statut','Encours')   
            ->paginate(10);
                return response()->json([
                        'data'  => $data,
                    ]);
            }

    }


    public function fetch_entete_mouvement(Request $request,$refMouvement)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tenfant_entete_vaccination')
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
            ->select("tenfant_entete_vaccination.id","refMouvement","medecin","cnom","tenfant_entete_vaccination.author",

            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
            "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

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
                ['refMouvement',$refMouvement],
                ['Statut','Encours'],
                ['tenfant_entete_vaccination.deleted','NON']
            ])                      
            ->orderBy("tenfant_entete_vaccination.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tenfant_entete_vaccination')
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
            ->select("tenfant_entete_vaccination.id","refMouvement","medecin","cnom","tenfant_entete_vaccination.author",

            "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
            "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
            "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
            "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
            "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

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
                ['refMouvement',$refMouvement],
                ['tenfant_entete_vaccination.deleted','NON']
            ])    
            ->orderBy("tenfant_entete_vaccination.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    } 

    function fetch_single_entete($id)
    {

        $data = DB::table('tenfant_entete_vaccination')
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
        ->select("tenfant_entete_vaccination.id","refMouvement","medecin","cnom","tenfant_entete_vaccination.author",

        "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
        "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
        "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
        "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
        "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",

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
        ->where('tenfant_entete_vaccination.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

     //id,refMouvement,NomPere,NomMere,ContactPere,ContactMere,dateEntete,numeroEnreg,
     //PoidsNaissance,ZoneSante,AireSante,CentreSante,Estnedomicile,OrphelinMere,
    //OrphelinPere,FrereSoeur,Mere5Enfants,EnfantJumeau,NaissanceRapproche,Mere18ans,ModeAccouchement,
    //Apgar,Nevaripine,Mortne,Mort24h,ComplicationAccouchement,ReanimationEnfant,ComplicatioPostPartum,
    //VitamineMere,FerMere,TailleNaissance,CPON,PF,CPS,TypeAccouchement,AccouchementFOSA,author
    function insertData(Request $request)
    {
       
        $data = tenfant_entete_vaccination::create([
             'refMouvement'=>  $request->refMouvement,
             'NomPere'=>  $request->NomPere,
             'NomMere'=>  $request->NomMere,
             'ContactPere'=>  $request->ContactPere,
             'ContactMere'=>  $request->ContactMere,
             'dateEntete'=>  date('Y-m-d'),
             'numeroEnreg'=>  '00000',
             'PoidsNaissance'=>  $request->PoidsNaissance,
             'ZoneSante'=>  $request->ZoneSante,
             'AireSante'=>  $request->AireSante,
             'CentreSante'=>  $request->CentreSante,
             'Estnedomicile'=>  $request->Estnedomicile,
             'OrphelinMere'=>  $request->OrphelinMere,
             'OrphelinPere'=>  $request->OrphelinPere,
             'FrereSoeur'=>  $request->FrereSoeur,
             'Mere5Enfants'=>  $request->Mere5Enfants,
             'EnfantJumeau'=>  $request->EnfantJumeau,
             'NaissanceRapproche'=>  $request->NaissanceRapproche,
             'Mere18ans'=>  $request->Mere18ans,
             'ModeAccouchement'=>  $request->ModeAccouchement,
             'Apgar'=>  $request->Apgar,
             'Nevaripine'=>  $request->Nevaripine,
             'Mortne'=>  $request->Mortne,
             'Mort24h'=>  $request->Mort24h,
             'ComplicationAccouchement'=>  $request->ComplicationAccouchement,
             'ReanimationEnfant'=>  $request->ReanimationEnfant,
             'ComplicatioPostPartum'=>  $request->ComplicatioPostPartum,
             'VitamineMere'=>  $request->VitamineMere,
             'FerMere'=>  $request->FerMere,
             'TailleNaissance'=>  $request->TailleNaissance,
             'CPON'=>  $request->CPON,
             'PF'=>  $request->PF,
             'CPS'=>  $request->CPS,
             'TypeAccouchement'=>  $request->TypeAccouchement,
             'AccouchementFOSA'=>  $request->AccouchementFOSA,
             'medecin'=>  $request->medecin,
             'cnom'=>  $request->cnom,                                
             'author'       =>  $request->author
        ]);

        //,"medecin","cnom"

        $idmax=0;
        $listmax = DB::table('tenfant_entete_vaccination')            
        ->selectRaw('MAX(tenfant_entete_vaccination.id) as id_entete')
        ->where('tenfant_entete_vaccination.refMouvement', $request->refMouvement)
        ->get();
        foreach ($listmax as $listm) {
            $idmax= $listm->id_entete;
        }      

        $compteur = 0;
        $etatrdv = 0;
        $idPeriode = 0;
        $duree=0;
        $daterdv='';
        $periodeList = DB::table("tenfant_periode_vac_enfant")
        ->select("tenfant_periode_vac_enfant.id", "tenfant_periode_vac_enfant.name_periode",
        "duree_periode","tenfant_periode_vac_enfant.created_at")
        ->get();
        foreach ($periodeList as $list) {
            $compteur= $compteur+1;
            $idPeriode= $list->id;
            $duree = $list->duree_periode;
            $idEnteteVac=0;
            
            $data22 = DB::table('tenfant_entete_vaccination')
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
            ->select("tenfant_entete_vaccination.id")
            ->selectRaw('(ADDDATE(dateNaissance_malade, INTERVAL '.$duree.' WEEK)) as daterendezvous')
            ->where('tenfant_entete_vaccination.id', $idmax)
            ->get();
            foreach ($data22 as $list22) {
                $daterdv= $list22->daterendezvous;
                $idEnteteVac= $list22->id;
            }


            $data44 = tenfant_rendevous_enfant::create([
                'refEntete'       =>  $idEnteteVac,
                'refPeriode'    =>  $idPeriode,                           
                'dateRdv'       =>  $daterdv,
                'etatRdv'=>0,
                'compteurRandezvous'=>$compteur,
                'author'=>$request->author
            ]);

        } 

        return response()->json([
            'data'  =>  "Insertion  avec succès!!!",
        ]);

    }


    
    function updateData(Request $request,$id)
    {
       
        $data = tenfant_entete_vaccination::where('id', $id)->update([
            'refMouvement'=>  $request->refMouvement,
            'NomPere'=>  $request->NomPere,
            'NomMere'=>  $request->NomMere,
            'ContactPere'=>  $request->ContactPere,
            'ContactMere'=>  $request->ContactMere,
            'PoidsNaissance'=>  $request->PoidsNaissance,
            'ZoneSante'=>  $request->ZoneSante,
            'AireSante'=>  $request->AireSante,
            'CentreSante'=>  $request->CentreSante,
            'Estnedomicile'=>  $request->Estnedomicile,
            'OrphelinMere'=>  $request->OrphelinMere,
            'OrphelinPere'=>  $request->OrphelinPere,
            'FrereSoeur'=>  $request->FrereSoeur,
            'Mere5Enfants'=>  $request->Mere5Enfants,
            'EnfantJumeau'=>  $request->EnfantJumeau,
            'NaissanceRapproche'=>  $request->NaissanceRapproche,
            'Mere18ans'=>  $request->Mere18ans,
            'ModeAccouchement'=>  $request->ModeAccouchement,
            'Apgar'=>  $request->Apgar,
            'Nevaripine'=>  $request->Nevaripine,
            'Mortne'=>  $request->Mortne,
            'Mort24h'=>  $request->Mort24h,
            'ComplicationAccouchement'=>  $request->ComplicationAccouchement,
            'ReanimationEnfant'=>  $request->ReanimationEnfant,
            'ComplicatioPostPartum'=>  $request->ComplicatioPostPartum,
            'VitamineMere'=>  $request->VitamineMere,
            'FerMere'=>  $request->FerMere,
            'TailleNaissance'=>  $request->TailleNaissance,
            'CPON'=>  $request->CPON,
            'PF'=>  $request->PF,
            'CPS'=>  $request->CPS,
            'TypeAccouchement'=>  $request->TypeAccouchement,
            'AccouchementFOSA'=>  $request->AccouchementFOSA, 
            'medecin'=>  $request->medecin, 
            'cnom'=>  $request->cnom,                                       
            'author'       =>  $request->author      
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
   }

 //,"medecin","cnom"
    function delete_entete($id)
    {
        $data = tenfant_rendevous_enfant::where('refEntete',$id)->delete();
       
        $data = tenfant_entete_vaccination::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);

        
    }
}
