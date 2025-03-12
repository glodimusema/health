<?php

namespace App\Http\Controllers\Hospitalisation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Hospitalisation\thospi_service_hospi;
use DB;

class thospi_service_hospiController extends Controller
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

            $data = DB::table('thospi_service_hospi')
            ->select('thospi_service_hospi.id','nomServiceHospi')           
            ->where('nomServiceHospi', 'like', '%'.$query.'%')            
            ->orderBy("thospi_service_hospi.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('thospi_service_hospi')
            ->select('thospi_service_hospi.id','nomServiceHospi')            
            ->orderBy("thospi_service_hospi.id", "desc")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }



   function fetch_single_service_hospi($id)
    {

        $data = DB::table('thospi_service_hospi')
        ->select('thospi_service_hospi.id','nomServiceHospi')             
        ->where('thospi_service_hospi.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function insert_service_hospi(Request $request)
    {
       
        $data = thospi_service_hospi::create([
            'nomServiceHospi'=>  $request->nomServiceHospi
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_service_hospi(Request $request, $id)
    {
        $data = thospi_service_hospi::where('id', $id)->update([
            'nomServiceHospi' =>$request->nomServiceHospi
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_service_hospi($id)
    {
        $data = thospi_service_hospi::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
