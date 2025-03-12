<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Parametres\tconf_affectationabone;
use DB;

class taffectationabonneController extends Controller
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

            $data = DB::table('tconf_affectationabone')            
            ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
            ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tconf_affectationabone.id","refMalade","refOrganisation",
            "Statut","tauxcharge","tconf_affectationabone.author",
            "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
            'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],['tconf_affectationabone.deleted','NON']
            ])           
            ->orderBy("tconf_affectationabone.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_affectationabone')            
            ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
            ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tconf_affectationabone.id","refMalade","refOrganisation",
            "Statut","tauxcharge","tconf_affectationabone.author",
            "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
            'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tconf_affectationabone.deleted','NON']])
            ->orderBy("tconf_affectationabone.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_affectationabone_malade(Request $request,$refMalade)
    {     
        
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tconf_affectationabone')            
            ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
            ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tconf_affectationabone.id","refMalade","refOrganisation",
            "Statut","tauxcharge","tconf_affectationabone.author",
            "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
            'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMalade',$refMalade],
                ['tconf_affectationabone.deleted','NON']
            ])                
            ->orderBy("tconf_affectationabone.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tconf_affectationabone')            
            ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
            ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tconf_affectationabone.id","refMalade","refOrganisation",
            "Statut","tauxcharge","tconf_affectationabone.author",
            "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
            'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([['refMalade',$refMalade],['tconf_affectationabone.deleted','NON']])   
            ->orderBy("tconf_affectationabone.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_organisation()
    {

        $data = DB::table('tconf_organisationabone')
        ->select("id",'nom_org', 'adresse_org', 'contact_org', 'rccm_org', 'idnat_org')
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_affectationabone($id)
    {

        $data = DB::table('tconf_affectationabone')            
        ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
        ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tconf_affectationabone.id","refMalade","refOrganisation",
        "Statut","tauxcharge","tconf_affectationabone.author",
        "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
        'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where('tconf_affectationabone.id',$id)   
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_affectationabone_mvt(Request $request)
    {
        if (($request->get('refMalade')) && ($request->get('Statut'))) 
        {
            $refMalade = $request->get('refMalade');
            $Statut = $request->get('Statut');

            $categorie_malade='';

            $maladeList = DB::table('tclient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->select("tclient.id","refCategieClient","tcategorieclient.designation")
            ->where([
                ['tclient.id',$refMalade]
            ])
            ->get();
            foreach ($maladeList as $liste_malade) {
                $categorie_malade= $liste_malade->designation;
            }

            if($categorie_malade = 'ABONNE(E)')
            {
                $data = DB::table('tconf_affectationabone')            
                ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
                ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                //MALADE 
                ->select("tconf_affectationabone.id","refMalade","refOrganisation",
                "Statut","tauxcharge","tconf_affectationabone.author",
                "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
                'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
                "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->where([
                    ['refMalade',$refMalade],          
                    ['Statut',$Statut],
                    ['tconf_affectationabone.deleted','NON']
                ]) 
                ->get();
    
                return response()->json([
                    'data'  => $data,
                ]);
    
            }
            else
            {
                $data = DB::table('tconf_organisationabone')
                ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
                ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
                 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
                 'name_categorie_societe','author',"tconf_organisationabone.created_at")
                ->where([
                    ['nom_org','Privé(e)']
                ]) 
                ->get();
    
                return response()->json([
                    'data'  => $data,
                ]);
            }        
        }
        else
        {

        }

        
    }
   
    function insert_affectationabone(Request $request)
    {
       
        $data = tconf_affectationabone::create([
            'refMalade'       =>  $request->refMalade,
            'refOrganisation'    =>  $request->refOrganisation,
            'tauxcharge'    =>  $request->tauxcharge,              
            'Statut'    =>  $request->Statut,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_affectationabone(Request $request, $id)
    {
        $data = tconf_affectationabone::where('id', $id)->update([
            'refMalade'       =>  $request->refMalade,
            'refOrganisation'    =>  $request->refOrganisation,
            'tauxcharge'    =>  $request->tauxcharge,              
            'Statut'    =>  $request->Statut,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_statut(Request $request, $id)
    {
        $data = tconf_affectationabone::where('id', $id)->update([
            'Statut'       =>  $request->Statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_affectationabone($id)
    {
        $data = tconf_affectationabone::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
