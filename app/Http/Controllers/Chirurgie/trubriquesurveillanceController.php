<?php

namespace App\Http\Controllers\Chirurgie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Chirurgie\{tope_rubriquesurveillance};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class trubriquesurveillanceController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tope_rubriquesurveillance')
            ->select("tope_rubriquesurveillance.id","tope_rubriquesurveillance.nom_rubliquesurv","tope_rubriquesurveillance.created_at")
            ->where('nom_rubliquesurv', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tope_rubriquesurveillance')
            ->select("tope_rubriquesurveillance.id","tope_rubriquesurveillance.nom_rubliquesurv","tope_rubriquesurveillance.created_at")->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_tope_rubriquesurveillance_2()
    {
        $data = DB::table('tope_rubriquesurveillance')
        ->select("tope_rubriquesurveillance.id","tope_rubriquesurveillance.nom_rubliquesurv",
        "tope_rubriquesurveillance.created_at")->orderBy("id", "desc")->get();
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
            $data = tope_rubriquesurveillance::where("id", $request->id)->update([
                'nom_rubliquesurv' =>  $request->nom_rubliquesurv
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tope_rubriquesurveillance::create([

                'nom_rubliquesurv' =>  $request->nom_rubliquesurv
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
        $data = tope_rubriquesurveillance::where('id', $id)->get();
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
        $data = tope_rubriquesurveillance::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
