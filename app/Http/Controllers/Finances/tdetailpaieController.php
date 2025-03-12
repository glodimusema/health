<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tdetailpaiement;
use DB;

class tdetailpaieController extends Controller
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
        $data = DB::table('tdetailpaiement')
        ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
        ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
        ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
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
        ->select("tdetailpaiement.id","refEntetepaie","refFrais","montantpaie","modepaie",
        "typetarif","datedetailpaie","tdetailpaiement.author",
        "tdetailpaiement.created_at","tdetailpaiement.updated_at","tconf_frais.designation as Frais","libelle",
        "refMouvement","dateentetepaie","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade');
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tdetailpaiement.deleted','NON']
            ])            
            ->orderBy("tdetailpaiement.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdetailpaiement')
            ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
            ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
            ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
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
            ->select("tdetailpaiement.id","refEntetepaie","refFrais","montantpaie","modepaie",
            "typetarif","datedetailpaie","tdetailpaiement.author",
            "tdetailpaiement.created_at","tdetailpaiement.updated_at","tconf_frais.designation as Frais","libelle",
            "refMouvement","dateentetepaie","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tdetailpaiement.deleted','NON']])
            ->orderBy("tdetailpaiement.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {   
        
        $data = DB::table('tdetailpaiement')
        ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
        ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
        ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
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
        ->select("tdetailpaiement.id","refEntetepaie","refFrais","montantpaie","modepaie",
        "typetarif","datedetailpaie","tdetailpaiement.author",
        "tdetailpaiement.created_at","tdetailpaiement.updated_at","tconf_frais.designation as Frais","libelle",
        "refMouvement","dateentetepaie","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where('refEntetepaie',$refEntete)        
        ->paginate(10);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where([
                ['noms', 'like', '%'.$query.'%'],
                ['tdetailpaiement.deleted','NON']
            ])           
            ->orderBy("tdetailpaiement.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdetailpaiement')
            ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
            ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
            ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
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
            ->select("tdetailpaiement.id","refEntetepaie","refFrais","montantpaie","modepaie",
            "typetarif","datedetailpaie","tdetailpaiement.author",
            "tdetailpaiement.created_at","tdetailpaiement.updated_at","tconf_frais.designation as Frais","libelle",
            "refMouvement","dateentetepaie","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->Where([
                ['refEntetepaie',$refEntete],
                ['tdetailpaiement.deleted','NON']
            ]) 
            ->orderBy("tdetailpaiement.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    
    

    function fetch_single_detail($id)
    {
        $data = DB::table('tdetailpaiement')
        ->join('tconf_frais','tconf_frais.id','=','tdetailpaiement.refFrais')
        ->join('tentetepaiement','tentetepaiement.id','=','tdetailpaiement.refEntetepaie')
        ->join('tmouvement','tmouvement.id','=','tentetepaiement.refMouvement')
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
        ->select("tdetailpaiement.id","refEntetepaie","refFrais","montantpaie","modepaie",
        "typetarif","datedetailpaie","tdetailpaiement.author",
        "tdetailpaiement.created_at","tdetailpaiement.updated_at","tconf_frais.designation as Frais","libelle",
        "refMouvement","dateentetepaie","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tdetailpaiement.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //refEntetepaie,refFrais,montantpaie,modepaie,typetarif,datedetailpaie,author,libelle
    function insert_detail(Request $request)
    {
       
        $data = tdetailpaiement::create([
            'refEntetepaie'       =>  $request->refEntetepaie,
            'refFrais'    =>  $request->refFrais,
            'montantpaie'    =>  $request->montantpaie,
            'modepaie'    =>  $request->modepaie,
            'typetarif'    =>  $request->typetarif,
            'datedetailpaie'    =>  $request->datedetailpaie,                                
            'author'       =>  $request->author,                                
            'libelle'       =>  $request->libelle
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tdetailpaiement::where('id', $id)->update([
            'refEntetepaie'       =>  $request->refEntetepaie,
            'refFrais'    =>  $request->refFrais,
            'montantpaie'    =>  $request->montantpaie,
            'modepaie'    =>  $request->modepaie,
            'typetarif'    =>  $request->typetarif,
            'datedetailpaie'    =>  $request->datedetailpaie,                                
            'author'       =>  $request->author,                                
            'libelle'       =>  $request->libelle
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tdetailpaiement::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
