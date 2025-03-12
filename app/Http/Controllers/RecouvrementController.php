<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{vRecouvrement};
use App\Traits\{GlobalMethod,Slug};
use DB;

class RecouvrementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }


    public function index(Request $request)
    {       

        if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);

                $data=vRecouvrement::select(['id','noms','contact','mail','refAvenue','refCategieClient','Categorie','photo','slug','author','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','idVenteMax','dateVente','NombreJour','Observation'])
                ->Where('Observation', 'like', '%'.$query.'%')
                ->orWhere('noms', 'like', '%'.$query.'%') 
                ->orderBy("noms", "asc")
                ->paginate(10);
                
            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data=vRecouvrement::select(['id','noms','contact','mail','refAvenue','refCategieClient','Categorie','photo','slug','author','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','idVenteMax','dateVente','NombreJour','Observation'])
            ->orderBy("noms", "asc")
            ->paginate(10);
              return response()->json([
                'data'  => $data,
              ]);
            }

        }
    
    

}
