<?php

namespace App\Http\Controllers\Personnel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Personnel\{tperso_categorie_service};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tperso_categorie_serviceController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tperso_categorie_service')
            ->select("tperso_categorie_service.id","tperso_categorie_service.name_categorie_service","tperso_categorie_service.created_at")->where('name_categorie_service', 'like', '%'.$query.'%')
            ->orWhere('name_categorie_service', 'like', '%'.$query.'%')
            ->orderBy("tperso_categorie_service.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tperso_categorie_service')
            ->select("tperso_categorie_service.id","tperso_categorie_service.name_categorie_service","tperso_categorie_service.created_at")
            ->orderBy("tperso_categorie_service.id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_categorie_service_2()
    {
        $data = DB::table('tperso_categorie_service')
        ->select("tperso_categorie_service.id","tperso_categorie_service.name_categorie_service",
        "tperso_categorie_service.created_at")
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
        
        if ($request->id !='') 
        {
 
            $data = tperso_categorie_service::where("id", $request->id)->update([
                'name_categorie_service' =>  $request->name_categorie_service
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!"
            ]);
        }
        else
        {
     
            $data = tperso_categorie_service::create([

                'name_categorie_service' =>$request->name_categorie_service
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
        $data = tperso_categorie_service::where('id', $id)->get();
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
        $data = tperso_categorie_service::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
