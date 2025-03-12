<?php

namespace App\Http\Controllers\Mere;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Mere\{t_mere_periode_sp};
use App\Traits\{GlobalMethod,Slug};
use DB;



class t_mere_periode_spController extends Controller
{

    use GlobalMethod;

    public function index(Request $request)
    {
        //
        $data = DB::table("t_mere_periode_sp")
        ->select("t_mere_periode_sp.id", "t_mere_periode_sp.name_periode_Sp","dure_periode_sp" ,"t_mere_periode_sp.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('t_mere_periode_sp.name_periode_Sp', 'like', '%'.$query.'%')
            ->orWhere('t_mere_periode_sp.id', 'like', '%'.$query.'%')
            ->orderBy("t_mere_periode_sp.id", "asc")
            ->paginate(10);;

            return response()->json([
                'data'=>$data
        ]);           

        }
        $data = DB::table('t_mere_periode_sp')
        ->select("t_mere_periode_sp.id","t_mere_periode_sp.name_periode_Sp","t_mere_periode_sp.created_at")
        ->orderBy("id", "asc")->paginate(10);
        return response()->json(
            ['data'=>$data ]);                   

    }

    function fetch_periode_sp_mere2()
    {
        $data = DB::table('t_mere_periode_sp')
        ->select("t_mere_periode_sp.id","t_mere_periode_sp.name_periode_Sp","t_mere_periode_sp.created_at")
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
            $data = t_mere_periode_sp::where("id", $request->id)->update([
                'name_periode_Sp' =>  $request->name_periode_Sp,
                'dure_periode_sp'=> 0
            ]);
            //id,name_periode_Sp,dure_periode_sp


            return response()->json([
                'data'=>'modification avec succes!!'
              ]);           

        }
        else
        {
            // insertion 
            $data = t_mere_periode_sp::create([
                'name_periode_Sp' =>  $request->name_periode_Sp,
                'dure_periode_sp'=> 0
            ]);

            return response()->json([
                'data'=>'Insertion avec succes!!'
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
        $data = t_mere_periode_sp::where('id', $id)->get();
        return response()->json(['data'=>
            $data]);
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = t_mere_periode_sp::where("id", $id)->delete();

        return response()->json(['data'=>
          'Supression avec succes!!']);   

    }
}
