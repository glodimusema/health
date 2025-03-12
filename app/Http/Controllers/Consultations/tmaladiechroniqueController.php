<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultations\tmaladiechronique;
use DB;

class tmaladiechroniqueController extends Controller
{
    public function index()
    {
        return 'hello';
    }
//
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 
        
    //
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tmaladiechronique.deleted','NON']
                ])            
            ->orderBy("tmaladiechronique.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tmaladiechronique.deleted','NON']])
            ->orderBy("tmaladiechronique.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_chronique_malade(Request $request,$refMalade)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([
                ['noms', 'like', '%'.$query.'%'],
                ['refMalade',$refMalade],
                ['tmaladiechronique.deleted','NON']
            ])                    
            ->orderBy("tmaladiechronique.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([
                ['refMalade',$refMalade],
                ['tmaladiechronique.deleted','NON']
                ])    
            ->orderBy("tmaladiechronique.id", "desc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }    


    public function fetch_chronique_malade2($refMalade)
    {  
        //       
        $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where('refMalade',$refMalade)    
            ->orderBy("tmaladiechronique.id", "desc")
            ->get();
            return response()->json([
                    'data'  => $data,
                ]);
    }    

    //mes scripts
    function fetch_list_maladiechronique()
    {
        $search='CHRONIQUE';
        $data = DB::table('tconf_maladie')           
        ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
        ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
        "tconf_maladie.created_at","tconf_maladie.author")
        ->where('nom_categoriemaladie', 'like', '%'.$search.'%')
        ->orderBy("nom_maladie", "asc")
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_single_chronique($id)
    {

        $data = DB::table('tmaladiechronique')           
        ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
        ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
        ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
         "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
         "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tmaladiechronique.id', $id)
            ->get();

            return response()->json([
            'data' => $data,
            ]);
    }

   //id,refMalade,refmaladie,autredetail,author
    function insert_chronique(Request $request)
    {
       
        $data = tmaladiechronique::create([
            'refMalade'       =>  $request->refMalade,
            'refmaladie'    =>  $request->refmaladie,
            'autredetail'    =>  $request->autredetail,                            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_chronique(Request $request, $id)
    {
        $data = tmaladiechronique::where('id', $id)->update([
            'refMalade'       =>  $request->refMalade,
            'refmaladie'    =>  $request->refmaladie,
            'autredetail'    =>  $request->autredetail,                            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_chronique($id)
    {
        $data = tmaladiechronique::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
