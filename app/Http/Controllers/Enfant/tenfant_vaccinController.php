<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\tenfant_vaccin;
use App\Traits\{GlobalMethod,Slug};
use DB;

class tenfant_vaccinController extends Controller
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

            $data = DB::table('tenfant_vaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')
            ->select("tenfant_vaccin.id","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode")
            ->where([
                ['name_vaccin', 'like', '%'.$query.'%'],               
            ])            
            ->orderBy("tenfant_vaccin.id", "asc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tenfant_vaccin')
            ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
            ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')
            ->select("tenfant_vaccin.id","name_vaccin","name_categorie",
            "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode")
            ->orderBy("tenfant_vaccin.id", "asc")  
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
            }

    }


 

    function fetch_single($id)
    {
        $data = DB::table('tenfant_vaccin')
        ->join('tenfant_categorie','tenfant_categorie.id','=','tenfant_vaccin.refCategorie')
        ->join('tenfant_periode_vac_enfant','tenfant_periode_vac_enfant.id','=','tenfant_vaccin.refPeriode')
        ->select("tenfant_vaccin.id","name_vaccin","name_categorie",
        "tenfant_periode_vac_enfant.name_periode","duree_periode","refCategorie","refPeriode")
        ->where('tenfant_vaccin.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //id,refCategorie,refPeriode,name_vaccin

    function insertData(Request $request)
    {
             
        $data = tenfant_vaccin::create([
            'refCategorie'       =>  $request->refCategorie,
            'refPeriode'    =>  $request->refPeriode,                           
            'name_vaccin'       =>  $request->name_vaccin
        ]);
        return response()->json([
            'data'  =>  "Insertion  avec succès!!!"
        ]);
    }




    function updateData(Request $request,$id)
    {       
        $data = tenfant_vaccin::where('id', $id)->update([
            'refCategorie'       =>  $request->refCategorie,
            'refPeriode'    =>  $request->refPeriode,                           
            'name_vaccin'       =>  $request->name_vaccin
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!"
        ]);
   }


    function destroy($id)
    {
        $data = tenfant_entete_vaccination::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
