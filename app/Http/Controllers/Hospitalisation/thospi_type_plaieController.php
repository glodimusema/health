<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_type_plaie;
use DB;

class thospi_type_plaieController extends Controller
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

            $data = DB::table('thospi_type_plaie')
            ->select('thospi_type_plaie.id','nomTypePlaie','created_at')           
            ->where('nomTypePlaie', 'like', '%'.$query.'%')            
            ->orderBy("thospi_type_plaie.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('thospi_type_plaie')
            ->select('thospi_type_plaie.id','nomTypePlaie','created_at')            
            ->orderBy("thospi_type_plaie.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }

    function fetch_typeplaie_2()
    {
        $data = DB::table('thospi_type_plaie')
        ->select('thospi_type_plaie.id','nomTypePlaie','created_at') 
        ->orderBy("nomTypePlaie", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }



   function fetch_single_type_plaie($id)
    {

        $data = DB::table('thospi_type_plaie')
        ->select('thospi_type_plaie.id','nomTypePlaie','created_at')             
        ->where('thospi_type_plaie.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function insert_type_plaie(Request $request)
    {
       
        $data = thospi_type_plaie::create([
            'nomTypePlaie'=>  $request->nomTypePlaie
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_type_plaie(Request $request, $id)
    {
        $data = thospi_type_plaie::where('id', $id)->update([
            'nomTypePlaie' =>$request->nomTypePlaie
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_type_plaie($id)
    {
        $data = thospi_service_hospi::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
