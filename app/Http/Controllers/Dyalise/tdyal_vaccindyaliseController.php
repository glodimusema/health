<?php

namespace App\Http\Controllers\Dyalise;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Dyalise\tdyal_vaccin_dyalise;
use DB;


class tdyal_vaccindyaliseController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
                

        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tdyal_vaccin_dyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=',
            'tdyal_vaccin_dyalise.refcategorieVac')
            ->select("tdyal_vaccin_dyalise.id","nomVaccinDyal","nomCategorieVac","auther",
            "tdyal_vaccin_dyalise.created_at","refcategorieVac")
            ->where('nomCategorieVac', 'like', '%'.$query.'%')
            ->orWhere('nomVaccinDyal', 'like', '%'.$query.'%')
            ->orderBy("tdyal_vaccin_dyalise.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{

            $data = DB::table('tdyal_vaccin_dyalise')
            ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=',
            'tdyal_vaccin_dyalise.refcategorieVac')
            ->select("tdyal_vaccin_dyalise.id","nomVaccinDyal","nomCategorieVac","auther",
            "tdyal_vaccin_dyalise.created_at","refcategorieVac")
            ->orderBy("tdyal_vaccin_dyalise.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    function fetch_single_data($id)
    {
        $data = DB::table('tdyal_vaccin_dyalise')
        ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=',
        'tdyal_vaccin_dyalise.refcategorieVac')
        ->select("tdyal_vaccin_dyalise.id","nomVaccinDyal","nomCategorieVac","auther",
        "tdyal_vaccin_dyalise.created_at","refcategorieVac")
        ->where('tdyal_vaccin_dyalise.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_vaccin_categorie2($refcategorieVac)
    {
        $data = DB::table('tdyal_vaccin_dyalise')
        ->join('tdyal_categorie_vaccin','tdyal_categorie_vaccin.id','=',
        'tdyal_vaccin_dyalise.refcategorieVac')
        ->select("tdyal_vaccin_dyalise.id","nomVaccinDyal","nomCategorieVac","auther",
        "tdyal_vaccin_dyalise.created_at","refcategorieVac")
        ->where('refcategorieVac', $refcategorieVac)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    

 
    function insert_data(Request $request)
    {
       

        $data = tdyal_vaccin_dyalise::create([
            'refcategorieVac'       =>  $request->refcategorieVac,
            'nomVaccinDyal'    =>  $request->nomVaccinDyal,                               
            'auther'       =>  $request->auther
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function updateData(Request $request, $id)
    {
        $data = tdyal_vaccin_dyalise::where('id', $id)->update([
            'refcategorieVac'       =>  $request->refcategorieVac,
            'nomVaccinDyal'    =>  $request->nomVaccinDyal,                               
            'auther'       =>  $request->auther
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }
 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
     //
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
 }

 /**
  * Display the specified resource.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function show($id)
 {
     //
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
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, $id)
 {
     //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
 public function destroy($id)
 {
     $data = tdyal_vaccin_dyalise::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
