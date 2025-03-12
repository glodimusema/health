<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\{tim_type_analyse};
use App\Traits\GlobalMethod;
use DB;



class ttypeanalyseController extends Controller
{

    use GlobalMethod;

    public function index(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tim_type_analyse")
            ->select("tim_type_analyse.id", "tim_type_analyse.nomTypeAnalyse", "tim_type_analyse.created_at")
            ->where('nomTypeAnalyse', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("tim_type_analyse")
            ->select("tim_type_analyse.id", "tim_type_analyse.nomTypeAnalyse", "tim_type_analyse.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }       
    }

    function fetch_ttypeanalyseimagerie2()
    {
        $data = DB::table("tim_type_analyse")
        ->select("tim_type_analyse.id", "tim_type_analyse.nomTypeAnalyse", "tim_type_analyse.created_at")
        ->orderBy("id", "desc")
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
            $data = tim_type_analyse::where("id", $request->id)->update([
                'nomTypeAnalyse' =>  $request->nomTypeAnalyse
            ]);
            return response()->json(['data'  =>  "Modification avec succès!!!"]);

        }
        else
        {
            // insertion 
            $data = tim_type_analyse::create([
                'nomTypeAnalyse' =>  $request->nomTypeAnalyse
            ]);
            return response()->json(['data'  =>  "Insertion avec succès!!!"]);       

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
        $data = tim_type_analyse::where('id', $id)->get();
        return response()->json(['data'  =>  $data]);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $data = tim_type_analyse::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
