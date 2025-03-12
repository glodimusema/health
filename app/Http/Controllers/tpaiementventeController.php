<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tpaiementvente;
use App\Models\vPaiementVente;
use DB;

class tpaiementventeController extends Controller
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
      
        $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste']);
        
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
            $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste'])
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_paie_for_entete(Request $request,$refEntete)
    {   
        
        $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste'])
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
            $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste'])
            ->Where('refEnteteVente',$refEntete) 
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    function fetch_single_paie($id)
    {
        $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalPaie','Reste'])
        ->where('id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'id','refEnteteVente','montant','datePaie','libelle','author'
    function insert_paie(Request $request)
    {
       
        $data = tpaiementvente::create([
            'refEnteteVente'       =>  $request->refEnteteVente,            
            'montant'    =>  $request->montant,
            'datePaie'    =>  $request->datePaie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

    function update_paie(Request $request, $id)
    {
        $data = tpaiementvente::where('id', $id)->update([
            'refEnteteVente'       =>  $request->refEnteteVente,            
            'montant'    =>  $request->montant,
            'datePaie'    =>  $request->datePaie,
            'libelle'    =>  $request->libelle,
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_paie($id)
    {
        $data = tpaiementvente::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
