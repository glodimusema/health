<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_actesmdecin;
use DB;

class thospi_actesmdecinController extends Controller
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

    //        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('thospi_actesmdecin')
            ->select('thospi_actesmdecin.id','nom_acte',"prix_acte","prix_convention","code_acte","refUnite",
            "refSscompte","author")           
            ->where('nom_acte', 'like', '%'.$query.'%')            
            ->orderBy("thospi_actesmdecin.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('thospi_actesmdecin')
            ->select('thospi_actesmdecin.id','nom_acte',"prix_acte","prix_convention","code_acte","refUnite",
            "refSscompte","author")             
            ->orderBy("thospi_actesmdecin.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }



   function fetch_single_acte_medecin($id)
    {

        $data = DB::table('thospi_actesmdecin')
            ->select('thospi_actesmdecin.id','nom_acte',"prix_acte","prix_convention","code_acte","refUnite",
            "refSscompte","author")              
        ->where('thospi_actesmdecin.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function insert_acte_medecin(Request $request)
    {      

        $data = thospi_actesmdecin::create([
            'refUnite'=>  $request->refUnite,
            'refSscompte'=>  $request->refSscompte,
            'nom_acte'=>  $request->nom_acte,
            'prix_acte'=>  $request->prix_acte,
            'prix_convention'=>  $request->prix_convention,
            'code_acte'=>  $request->code_acte,
            'author'=>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_acte_medecin(Request $request, $id)
    {
        $data = thospi_actesmdecin::where('id', $id)->update([
            'refUnite'=>  $request->refUnite,
            'refSscompte'=>  $request->refSscompte,
            'nom_acte'=>  $request->nom_acte,
            'prix_acte'=>  $request->prix_acte,
            'prix_convention'=>  $request->prix_convention,
            'code_acte'=>  $request->code_acte,
            'author'=>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_acte_medecin($id)
    {
        $data = thospi_actesmdecin::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
