<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tdetailsouscription;
use App\Models\vDetailSouscription;
use DB;

class tdetailsouscriptionController extends Controller
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
      
        $data = vDetailSouscription::select(['id','refEnteteVente','refProduit','refSouscription','statut','author','refClient','dateSous','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','designationProduit','pu','unite','refCategorie','categorieProduit','categorieSouscription','prix','created_at']);
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')            
            ->orderBy("id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = vDetailSouscription::select(['id','refEnteteVente','refProduit','refSouscription','statut','author','refClient','dateSous','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','designationProduit','pu','unite','refCategorie','categorieProduit','categorieSouscription','prix','created_at'])
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_detail_for_entete(Request $request,$refEntete)
    {   
        
        $data = vDetailSouscription::select(['id','refEnteteVente','refProduit','refSouscription','statut','author','refClient','dateSous','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','designationProduit','pu','unite','refCategorie','categorieProduit','categorieSouscription','prix','created_at'])
        ->Where('refEnteteVente',$refEntete)        
        ->paginate(10);

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('noms', 'like', '%'.$query.'%')           
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = vDetailSouscription::select(['id','refEnteteVente','refProduit','refSouscription','statut','author','refClient','dateSous','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','designationProduit','pu','unite','refCategorie','categorieProduit','categorieSouscription','prix','created_at'])
            ->Where('refEnteteVente',$refEntete) 
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_produit()
    {

        $data = DB::table('tproduit')->select("tproduit.id","tproduit.designation")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_categoriesouscription()
    {

        $data = DB::table('tcategoriesouscription')->select("tcategoriesouscription.id","tcategoriesouscription.designation","tcategoriesouscription.prix")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_detail($id)
    {
        $data = vDetailSouscription::select(['id','refEnteteVente','refProduit','refSouscription','statut','author','refClient','dateSous','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','designationProduit','pu','unite','refCategorie','categorieProduit','categorieSouscription','prix','created_at'])
        ->where('id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refEnteteVente','refProduit','refSouscription','statut','author' 
    function insert_detail(Request $request)
    {
       
        $data = tdetailsouscription::create([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'refSouscription'    =>  $request->refSouscription,
            'statut'    =>  $request->statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_detail(Request $request, $id)
    {
        $data = tdetailsouscription::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,
            'refProduit'    =>  $request->refProduit,
            'refSouscription'    =>  $request->refSouscription,
            'statut'    =>  $request->statut,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_detail($id)
    {
        $data = tdetailsouscription::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
