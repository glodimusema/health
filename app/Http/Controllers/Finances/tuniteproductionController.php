<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_uniteproduction;
use DB;

class tuniteproductionController extends Controller
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

            $data = DB::table('tfin_uniteproduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')           
            ->where('nom_uniteproduction', 'like', '%'.$query.'%')            
            ->orderBy("tfin_uniteproduction.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_uniteproduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_unite_departement(Request $request,$refDepartement)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_uniteproduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')
            ->where([
                ['nom_uniteproduction', 'like', '%'.$query.'%'],
                ['refDepartement',$refDepartement]
            ])                    
            ->orderBy("nom_uniteproduction", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tfin_uniteproduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')         
            ->Where('refDepartement',$refDepartement)    
            ->orderBy("nom_uniteproduction", "asc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }  
    
    function fetch_unite_Departement2($refDepartement)
    {

        $data = DB::table('tfin_uniteproduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')                    
        ->where('refDepartement', $refDepartement)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function fetch_unite2()
    {

        $data = DB::table('tfin_uniteproduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')                    
        ->get();
        return response()->json([
        'data' => $data,
        ]);
    }

   function fetch_single_uniteDepartement($id)
    {

        $data = DB::table('tfin_uniteproduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->select('tfin_uniteproduction.id','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','tfin_uniteproduction.author')                     
        ->where('tfin_uniteproduction.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

   //'id','refDepartement','nom_uniteproduction',
    // 'code_uniteproduction','author'

    function insert_uniteproduction(Request $request)
    {
       
        $data = tfin_uniteproduction::create([
            'refDepartement'       =>  $request->refDepartement,
            'nom_uniteproduction'    =>  $request->nom_uniteproduction,
            'code_uniteproduction'    =>  $request->code_uniteproduction,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_uniteproduction(Request $request, $id)
    {
        $data = tfin_uniteproduction::where('id', $id)->update([
            'refDepartement'       =>  $request->refDepartement,
            'nom_uniteproduction'    =>  $request->nom_uniteproduction,
            'code_uniteproduction'    =>  $request->code_uniteproduction,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_uniteproduction($id)
    {
        $data = tfin_uniteproduction::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
