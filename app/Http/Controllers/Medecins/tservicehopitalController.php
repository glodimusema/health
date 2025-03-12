<?php

namespace App\Http\Controllers\Medecins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Medecins\{tservice_hopital};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tservicehopitalController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tservice_hopital')
            ->select("tservice_hopital.id","tservice_hopital.nom_service","tservice_hopital.created_at")
            ->where('nom_service', 'like', '%'.$query.'%')
            ->orWhere('nom_service', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tservice_hopital')->select("tservice_hopital.id","tservice_hopital.nom_service","tservice_hopital.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tservice_hopital_2()
    {
        $data = DB::table('tservice_hopital')->select("tservice_hopital.id","tservice_hopital.nom_service","tservice_hopital.created_at")->orderBy("id", "desc")->paginate(10);
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
            $data = tservice_hopital::where("id", $request->id)->update([
                'nom_service' =>  $request->nom_service
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tservice_hopital::create([

                'nom_service' =>  $request->nom_service
            ]);

            return $this->msgJson('Insertion avec succès!!!');
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
        $data = tservice_hopital::where('id', $id)->get();
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
        $data = tservice_hopital::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
