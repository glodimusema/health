<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tentetesouscription;
use App\Models\vEnteteSouscription;
use DB;

class tentetesouscriptionController extends Controller
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
      
        $data = vEnteteSouscription::select(['id','refClient','dateSous','dateExecution','Executant','author','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at']);
        
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
            $data = vEnteteSouscription::select(['id','refClient','dateSous','dateExecution','Executant','author','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at'])->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_entete_client(Request $request,$refClient)
    {     
        
        $data = vEnteteSouscription::select(['id','refClient','dateSous','dateExecution','Executant','author','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at'])
        ->Where('refClient',$refClient)        
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
            $data = vEnteteSouscription::select(['id','refClient','dateSous','dateExecution','Executant','author','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at'])
            ->Where('refClient',$refClient) 
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    //mes scripts
    function fetch_list_client()
    {

        $data = DB::table('tclient')->select("tclient.id","tclient.noms")->get();

        return response()->json([
            'data'  => $data,
        ]);
    }
    

    function fetch_single_entete($id)
    {

        $data = vEnteteSouscription::select(['id','refClient','dateSous','dateExecution','Executant','author','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at'])
        ->where('id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

   //'refClient','dateSous','dateExecution','Executant','Executant','author'
    function insert_entete(Request $request)
    {
       
        $data = tentetesouscription::create([
            'refClient'       =>  $request->refClient,
            'dateSous'    =>  $request->dateSous,
            'dateExecution'    =>  $request->dateExecution,
            'Executant'    =>  $request->Executant,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_entete(Request $request, $id)
    {
        $data = tentetesouscription::where('id', $id)->update([
            'refClient'       =>  $request->refClient,
            'dateSous'    =>  $request->dateSous,
            'dateExecution'    =>  $request->dateExecution,
            'Executant'    =>  $request->Executant,            
            'author'       =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_entete($id)
    {
        $data = tentetesouscription::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
