<?php

namespace App\Http\Controllers\Enfant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Enfant\{tenfant_type_test};
use App\Traits\{GlobalMethod,Slug};
use DB;


class tenfant_type_testController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {

         
        //
        $data = DB::table("tenfant_type_test")
        ->select("tenfant_type_test.id", "tenfant_type_test.Designation_typeTest","tenfant_type_test.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('tenfant_type_test.Designation_typeTest', 'like', '%'.$query.'%')
            ->orWhere('tenfant_type_test.id', 'like', '%'.$query.'%')
            ->orderBy("tenfant_type_test.id", "asc")
            ->paginate(10);

            return response()->json([
                'data'=>$data
               ]);
        }else{
            $data = DB::table('tenfant_type_test')
            ->select("tenfant_type_test.id","tenfant_type_test.Designation_typeTest","tenfant_type_test.created_at")
            ->orderBy("id", "asc")->paginate(10);

            return response()->json([
                'data'=>$data
               ]);
        }

        
    }


    function fetch_type_test_cutane2()
    {
        $data =DB::table('tenfant_type_test')
        ->select("tenfant_type_test.id","tenfant_type_test.Designation_typeTest",
        "tenfant_type_test.created_at")
        ->orderBy("id", "asc")
        ->get();
        return response()->json([
            'data'  => $data,
        ]);

    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if ($request->id !='') 
        {
            # code...
            // update 
            $data = tenfant_type_test::where("id", $request->id)->update([
                'Designation_typeTest' =>  $request->Designation_typeTest
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);

        }
        else
        {
            // insertion 
            $data = tenfant_type_test::create([
                'Designation_typeTest' =>  $request->Designation_typeTest
            ]);
            return response()->json([
                'data'  =>  "Insertion  avec succès!!!",
            ]);

        }
    }   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tenfant_type_test::where('id', $id)->get();
        return response()->json([
            'data'  =>  "supression  avec succès!!!",
        ]);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = tenfant_type_test::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
