<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\tlit;
use DB;

class tlitController extends Controller
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

            $data = DB::table('tlit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')           
            ->where('nom_lit', 'like', '%'.$query.'%')            
            ->orderBy("tlit.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tlit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')            
            ->orderBy("tlit.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_lit_salle(Request $request,$refSalle)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tlit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')            
            ->where([
                ['nom_lit', 'like', '%'.$query.'%'],
                ['refSalle',$refSalle]
            ])                    
            ->orderBy("nom_lit", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tlit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')            
            ->Where('refSalle',$refSalle)    
            ->orderBy("nom_lit", "asc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }  
    
    function fetch_lit_Salle2($refSalle)
    {

        $data = DB::table('tlit')
        ->join('tsalle','tsalle.id','=','tlit.refSalle')
        ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')             
        ->where('refSalle', $refSalle)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

   function fetch_single_lit($id)
    {

        $data = DB::table('tlit')
        ->join('tsalle','tsalle.id','=','tlit.refSalle')
        ->select('tlit.id','nom_lit','refSalle','nom_salle','PrixSalle')             
        ->where('tlit.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

   //'id','nom_lit','refSalle'

    function insert_lit(Request $request)
    {
       
        $data = tlit::create([
            'nom_lit'       =>  $request->nom_lit,
            'refSalle'    =>  $request->refSalle
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_lit(Request $request, $id)
    {
        $data = tlit::where('id', $id)->update([
            'nom_lit'       =>  $request->nom_lit,
            'refSalle'    =>  $request->refSalle
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_lit($id)
    {
        $data = tlit::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
