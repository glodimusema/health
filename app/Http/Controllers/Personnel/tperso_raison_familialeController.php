<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_raison_familiale};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_raison_familialeController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_raison_familiale')
            ->select("tperso_raison_familiale.id","tperso_raison_familiale.name_raison_famille","tperso_raison_familiale.created_at")->where('name_raison_famille', 'like', '%'.$query.'%')
            ->orWhere('name_raison_famille', 'like', '%'.$query.'%')
            ->orderBy("tperso_raison_familiale.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tperso_raison_familiale')
            ->select("tperso_raison_familiale.id","tperso_raison_familiale.name_raison_famille","tperso_raison_familiale.created_at")
            ->orderBy("tperso_raison_familiale.id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_dropdown_2()
    {
        $data = DB::table('tperso_raison_familiale')
        ->select("tperso_raison_familiale.id","tperso_raison_familiale.name_raison_famille","tperso_raison_familiale.created_at")
        ->orderBy("id", "desc")->get();
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
        
        if ($request->id !='') 
        {
 
            $data = tperso_raison_familiale::where("id", $request->id)->update([
                'name_raison_famille' =>  $request->name_raison_famille
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_raison_familiale::create([

                'name_raison_famille' =>$request->name_raison_famille
            ]);

            return response()->json([
                'data'  =>  "Insertion avec succès!!!",
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
        $data = tperso_raison_familiale::where('id', $id)->get();
        return response()->json(['data' => $data]);
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
        $data = tperso_raison_familiale::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
