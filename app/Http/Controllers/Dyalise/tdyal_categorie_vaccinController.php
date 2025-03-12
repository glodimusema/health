<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Dyalise\{tdyal_categorie_vaccin};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tdyal_categorie_vaccinController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tdyal_categorie_vaccin')->select("tdyal_categorie_vaccin.id","tdyal_categorie_vaccin.nomCategorieVac","tdyal_categorie_vaccin.created_at")->where('nomCategorieVac', 'like', '%'.$query.'%')
            ->orWhere('nomCategorieVac', 'like', '%'.$query.'%')
            ->orderBy("tdyal_categorie_vaccin.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdyal_categorie_vaccin')
            ->select("tdyal_categorie_vaccin.id","tdyal_categorie_vaccin.nomCategorieVac","tdyal_categorie_vaccin.created_at")
            ->orderBy("tdyal_categorie_vaccin.id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_categorievaccin2()
    {
        $data = DB::table('tdyal_categorie_vaccin')
        ->select("tdyal_categorie_vaccin.id","tdyal_categorie_vaccin.nomCategorieVac",
        "tdyal_categorie_vaccin.created_at")
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
            $data = tdyal_categorie_vaccin::where("id", $request->id)->update([
                'nomCategorieVac' =>  $request->nomCategorieVac
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tdyal_categorie_vaccin::create([

                'nomCategorieVac' =>$request->nomCategorieVac
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
        $data = tdyal_categorie_vaccin::where('id', $id)->get();
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
        $data = tdyal_categorie_vaccin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
