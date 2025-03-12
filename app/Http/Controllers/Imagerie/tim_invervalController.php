<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\{tim_inverval};
use App\Traits\{GlobalMethod,Slug};

use DB;


class tim_invervalController extends Controller
{

    use GlobalMethod, Slug;

    public function index(Request $request)
    {

        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table("tim_inverval")
            ->select("tim_inverval.id", "tim_inverval.desi_interval", "tim_inverval.created_at")
            ->where('desi_interval', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table("tim_inverval")
            ->select("tim_inverval.id", "tim_inverval.desi_interval", "tim_inverval.created_at")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    function fetch_IntervalSCore2()
    {
        $data = DB::table("tim_inverval")
        ->select("tim_inverval.id", "tim_inverval.desi_interval", "tim_inverval.created_at")
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
            $data = tim_inverval::where("id", $request->id)->update([
                'desi_interval' =>  $request->desi_interval
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!",
            ]);

        }
        else
        {
            $data = tim_inverval::create([
                'desi_interval' =>  $request->desi_interval
            ]);
            return response()->json([
                'data'  =>  "Insertion avec succès!!",
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
        $data = tim_inverval::where('id', $id)->get();
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
        $data = tim_inverval::where("id", $id)->delete();
        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
