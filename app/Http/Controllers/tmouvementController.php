<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tmouvement;
use App\Models\tentetetriage;
use App\Models\tdetailtriage;
use DB;

class tmouvementController extends Controller
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

            $data = DB::table('tmouvement')            
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
            ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt',
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
            "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","idOrganisation","agemvt")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],          
                ['Statut','Encours'],
                ['tmouvement.deleted','NON']
            ])           
            ->orderBy("tmouvement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmouvement')            
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
            ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt','organisationAbonne',
            'taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
            "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","idOrganisation","agemvt")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['Statut','Encours'],
            ['tmouvement.deleted','NON']]) 
            ->orderBy("tmouvement.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_mouvement_malade(Request $request,$refMalade)
    {     
        
        

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tmouvement')            
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
            ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt','organisationAbonne',
            'taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
            "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","idOrganisation","agemvt")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMalade',$refMalade],          
                // ['Statut','Encours'],
                ['tmouvement.deleted','NON']
            ])                
            ->orderBy("tmouvement.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmouvement')            
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
            ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt','organisationAbonne',
            'taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
            "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","idOrganisation","agemvt")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['refMalade',$refMalade],          
                // ['Statut','Encours'],
                ['tmouvement.deleted','NON']
            ])    
            ->orderBy("tmouvement.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_typemouvement()
    {

        $data = DB::table('ttypemouvement_malade')
        ->select("id","designation as Typemouvement")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_mouvement($id)
    {

        $data = DB::table('tmouvement')            
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
        ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt','organisationAbonne',
        'taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
        "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","idOrganisation","agemvt")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where('tmouvement.id',$id)   
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function fetch_liste_mouvement()
    {

        $data = DB::table('tmouvement')            
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
        ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",'age_jourmvt','age_moismvt','organisationAbonne',
        'taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
        "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","idOrganisation","agemvt")
        ->selectRaw("CONCAT(noms,' - ',organisationAbonne,' :',DATE_FORMAT(dateMouvement,'%d/%M/%Y'), '(' , ttypemouvement_malade.designation,')') as data_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where([       
            ['tmouvement.Statut','Encours'],
            ['tmouvement.deleted','NON']
        ])
        ->orderBy("tmouvement.id", "desc") 
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
   
    function insert_mouvement(Request $request)
    {
        $organisationAbonne='';
        $pourcentageConvention=0;
        $nmbreJourConsMvt=0;
        $categoriemaladiemvt='';
        $numCartemvt='';
        $taux_prisecharge=0;
        $idOrganisation=0;
        $agemvt=0;
        $age_jourmvt=0;
        $age_moismvt=0;

        $maladeList = DB::table('tclient')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
        "tcategorieclient.designation as Categorie","photo","slug","author","tclient.created_at",
        "sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('TIMESTAMPDIFF(DAY, dateNaissance_malade, CURDATE()) as age_jour_malade')
        ->selectRaw('TIMESTAMPDIFF(MONTH, dateNaissance_malade, CURDATE()) as age_mois_malade')
        ->where([
            ['tclient.id',$request->refMalade]
        ])
        ->get();
        foreach ($maladeList as $liste_mvt) {
            $categoriemaladiemvt= $liste_mvt->Categorie;
            $numCartemvt=$liste_mvt->numeroCarte_malade;
            $agemvt=$liste_mvt->age_malade;
            $age_jourmvt=$liste_mvt->age_jour_malade;
            $age_moismvt=$liste_mvt->age_mois_malade; 
        }

        //,'age_jourmvt','age_moismvt'

        if($categoriemaladiemvt =="ABONNE(E)")
        {
            $organisationList = DB::table('tconf_affectationabone')            
            ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
            ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            //MALADE
            ->select("tconf_affectationabone.id","refMalade","refOrganisation",
            "Statut","tauxcharge","tconf_affectationabone.author",
            "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
            'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
            "slug","sexe_malade","dateNaissance_malade","etatcivil_malade","numeroMaison_malade",
            "fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->where([
                ['tconf_affectationabone.refMalade',$request->refMalade],
                ['tconf_affectationabone.Statut',"Encours"]
            ])
            ->get();
            foreach ($organisationList as $liste_org) {
                $nmbreJourConsMvt=$liste_org->nmbreJourCons;
                $pourcentageConvention=$liste_org->pourcentageConvention;
                $organisationAbonne=$liste_org->nom_org;
                $taux_prisecharge=$liste_org->tauxcharge;
                $idOrganisation=$liste_org->refOrganisation;
            }
            if($organisationAbonne != ""){
                $data = tmouvement::create([
                    'refMalade'       =>  $request->refMalade,
                    'refTypeMouvement'    =>  $request->refTypeMouvement,
                    'idOrganisation'    =>  $idOrganisation,
                    'agemvt'    =>  $agemvt,
                    'age_jourmvt'    =>  $age_jourmvt,
                    'age_moismvt'    =>  $age_moismvt,
                    'dateMouvement'    =>  date('Y-m-d'),
                    'organisationAbonne'    =>  $organisationAbonne,
                    'pourcentageConvention'    =>  $pourcentageConvention,
                    'nmbreJourConsMvt'    =>  $nmbreJourConsMvt,
                    'categoriemaladiemvt'    =>  $categoriemaladiemvt,
                    'numCartemvt'    =>  $numCartemvt,
                    'taux_prisecharge'    =>  $taux_prisecharge,
                    'numroBon'    =>  $request->numroBon,   
                    'Statut'    =>  $request->Statut,            
                    'author'       =>  $request->author
                ]);
                return response()->json([
                    'data'  =>  "Insertion avec succès!!!",
                ]);
            }
            else
            {
                return response()->json([
                    'data'  =>  "Complètez les informations de la prise en charge svp !!!",
                ]);
            }
    
        }
        else
        {
            $organisationList = DB::table('tconf_organisationabone')
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
            ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
             'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
             'name_categorie_societe','author',"tconf_organisationabone.created_at")
            ->where([
                ['nom_org','Privé(e)']
            ])
            ->get();
            foreach ($organisationList as $liste_privee) {
                $nmbreJourConsMvt=$liste_privee->nmbreJourCons;
                $pourcentageConvention=$liste_privee->pourcentageConvention;
                $organisationAbonne=$liste_privee->nom_org;
                $idOrganisation=$liste_privee->id;
            }


            $data = tmouvement::create([
                'refMalade'       =>  $request->refMalade,
                'refTypeMouvement'    =>  $request->refTypeMouvement,
                'idOrganisation'    =>  $idOrganisation,
                'agemvt'    =>  $agemvt,
                'age_jourmvt'    =>  $age_jourmvt,
                'age_moismvt'    =>  $age_moismvt,
                'dateMouvement'    =>  date('Y-m-d'),
                'organisationAbonne'    =>  $organisationAbonne,
                'pourcentageConvention'    =>  $pourcentageConvention,
                'nmbreJourConsMvt'    =>  $nmbreJourConsMvt,
                'categoriemaladiemvt'    =>  $categoriemaladiemvt,
                'numCartemvt'    =>  $numCartemvt,
                'taux_prisecharge'    =>  $taux_prisecharge,
                'numroBon'    =>  $request->numroBon,   
                'Statut'    =>  $request->Statut,            
                'author'       =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
            ]);

        }
       

    }
//,'nmbreJourConsMvt'

    function update_mouvement(Request $request, $id)
    {
        $data = tmouvement::where('id', $id)->update([
            'refMalade'       =>  $request->refMalade,
            'refTypeMouvement'    =>  $request->refTypeMouvement,
            'organisationAbonne'    =>  $request->organisationAbonne,
            'taux_prisecharge'    =>  $request->taux_prisecharge,
            'pourcentageConvention'    =>  $request->pourcentageConvention,
            'nmbreJourConsMvt'    =>  $request->nmbreJourConsMvt,
            'categoriemaladiemvt'    =>  $request->categoriemaladiemvt,
            'numCartemvt'    =>  $request->numCartemvt,
            'numroBon'    =>  $request->numroBon,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function update_statut(Request $request, $id)
    {
        $data = tmouvement::where('id', $id)->update([
            'Statut'       =>  $request->Statut,
            'dateSortieMvt'    =>  $request->dateSortieMvt,
            'motifSortieMvt'    =>  $request->motifSortieMvt,
            'autoriseSortieMvt'    =>  $request->autoriseSortieMvt,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
//'id','refMalade','refTypeMouvement','dateMouvement','numroBon',
//'Statut','dateSortieMvt','motifSortieMvt','autoriseSortieMvt','author'
    function update_sortie(Request $request, $id)
    {
        $data = tmouvement::where('id', $id)->update([            
            'Statut'    =>  $request->Statut,
            'dateSortieMvt'    =>  $request->dateSortieMvt,
            'motifSortieMvt'    =>  $request->motifSortieMvt,
            'autoriseSortieMvt'    =>  $request->autoriseSortieMvt,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_mouvement($id)
    {
        $data = tmouvement::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }





    function fetch_examen_episode($refMouvement)
    {

        $data = DB::table('tentetelabo')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')        
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
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
        ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
        ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        //MALADE
        ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
        'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
        'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
        "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
        "tcategorieexament.designation as designationCatEx","refGrandCategorie",
        "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
        "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
        "tenteteconsulter.author","tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin","lieunaissnce_medecin","provinceOrigine_medecin",
        "etatcivil_medecin","refAvenue_medecin","contact_medecin","mail_medecin","grade_medecin","fonction_medecin",
        "specialite_medecin","Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
        "tmedecin.photo as photo_medecin","tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA",
        "Temperature","FC","FR","Oxygene","refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
        "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
        "tclient.slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
        "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
        "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2",
        "tdetaillabo.natureechantillon as natureechantillon2",
        "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('refMouvement', $refMouvement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function fetch_actes_episode($refMouvement)
    {

        $data = DB::table('tfin_actesposemedecin')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tfin_actesposemedecin.refDetailCons')
        ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tfin_actesposemedecin.refActemedecin')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
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
        //MALADE
        ->select("tfin_actesposemedecin.id",'refDetailCons',"tfin_actesposemedecin.refActemedecin",'descriptionacte',
        "tfin_actesposemedecin.author", "tfin_actesposemedecin.created_at","tfin_actesposemedecin.updated_at",
        'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
        'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
        "dateExpiration_malade","PrixCons")
        ->where('refMouvement', $refMouvement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_imagerie_episode($refMouvement)
    {

        $data = DB::table('tim_imagerie')
        ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
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
  
        ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
        "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'serviceProvenance','medecindemandeur',
        'urgent',"CNOM","examenDemande","tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
        "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
        "plainte","historique","antecedent","complementanamnese","examenphysique",
        "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
        "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
        'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
        "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
        "noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
        "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->where('refMouvement', $refMouvement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_medicaments_episode($refMouvement)
    {

        $data = DB::table('tprescriptionmedicament')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tprescriptionmedicament.refdetailCons')
        ->join('tconf_medicament','tconf_medicament.id','=','tprescriptionmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
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
        //MALADE
        ->select("tprescriptionmedicament.id",'refdetailCons',"tprescriptionmedicament.refmedicament",
        "quantite","dosage","detailprescription",
         "tprescriptionmedicament.author", "tprescriptionmedicament.created_at", 
         "tprescriptionmedicament.updated_at","nom_medicament","refcategoriemedicament","pu_medicament",
         "forme","nom_categoriemedicament","refEnteteCons","refTypeCons","plainte",
        "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
        "tdetailconsultation.author","tdetailconsultation.created_at","tdetailconsultation.updated_at",
        "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
        "dateExpiration_malade","PrixCons")
        ->where('refMouvement', $refMouvement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_besoinservice_episode($refMouvement)
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
        ->where('refMouvement', $refMouvement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }



    //============= LES STATISTIQUES ===================================================================================


    // function get_stat_femme_organisation(Request $request)
    // {

    //     $date1 = $request->get('date1');
    //     $date2 = $request->get('date2');
    //     $sexe_malade = 'Femme';

    //     $data = DB::table('tmouvement')            
    //     ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
    //     ->join('tclient','tclient.id','=','tmouvement.refMalade')
    //     ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    //     ->selectRaw('COUNT(tmouvement.id) as NombreFemme,organisationAbonne')
    //     ->where([
    //         ['datefacture','>=', $date1],
    //         ['datefacture','<=', $date2],
    //         ['sexe_malade','=', $sexe_malade]
    //     ])
    //     ->groupby('organisationAbonne')
    //     ->get();

    //     return response()->json([
    //     'data' => $data,
    //     ]);
    // }










}
