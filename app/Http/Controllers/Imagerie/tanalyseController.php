<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_analyse;
use DB;

class tanalyseController extends Controller
{


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

            $data = DB::table('tim_analyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->select("tim_analyse.id","nomAnalyse","tim_analyse.prix",
              "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse")
            ->where('nomAnalyse', 'like', '%'.$query.'%')            
            ->orderBy("tim_analyse.id", "desc")          
            ->paginate(5);

            return response()->json([
                'data'  => $data,
            ]);
           
        }
        else{
            $data = DB::table('tim_analyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->select("tim_analyse.id","nomAnalyse","tim_analyse.prix",
              "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse")           
            ->orderBy("tim_analyse.id", "desc")          
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }
   

   function fetch_single_analyse($id)
    {

        $data = DB::table('tim_analyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->select("tim_analyse.id","nomAnalyse","tim_analyse.prix",
          "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse")
        ->where('tim_analyse.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_analyse_for_typeanalyse($ReftypeAnalyse)
    {

        $data = DB::table('tim_analyse')
        ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
        ->select("tim_analyse.id","nomAnalyse","tim_analyse.prix",
          "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse")
        ->where('tim_analyse.ReftypeAnalyse', $ReftypeAnalyse)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

 

    function insert_analyse(Request $request)
    {
       
        $data = tim_analyse::create([
            'nomAnalyse'       =>  $request->nomAnalyse,
            'prix'             =>  $request->prix,
            'prixConvention'    =>  $request->prixConvention,
            'codeAnalyse'    =>  $request->codeAnalyse,
            'ReftypeAnalyse'    =>  $request->ReftypeAnalyse
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_analyse(Request $request, $id)
    {
        $data = tim_analyse::where('id', $id)->update([
            'nomAnalyse'       =>  $request->nomAnalyse,
            'prix'    =>  $request->prix,
            'prixConvention'    =>  $request->prixConvention,
            'codeAnalyse'    =>  $request->codeAnalyse,
            'ReftypeAnalyse'    =>  $request->ReftypeAnalyse,
            
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_analyse($id)
    {
        $data = tim_analyse::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
