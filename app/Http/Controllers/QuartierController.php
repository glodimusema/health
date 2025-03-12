<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{Quartier};
use App\Traits\{GlobalMethod,Slug};
use DB;
class QuartierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        if (!is_null($request->get('query'))) {
            # code...
        $query = $this->Gquery($request);

        $data = DB::table('quartiers')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
        ->orWhere([['nomQuartier', 'like', '%'.$query.'%']])
        ->orWhere([['nomCommune', 'like', '%'.$query.'%']])
        ->orWhere([['nomVille', 'like', '%'.$query.'%']])
        ->orWhere([['nomProvince', 'like', '%'.$query.'%']])
        ->orWhere([['nomPays', 'like', '%'.$query.'%']]) 
        ->orderBy("nomQuartier", "asc")
        ->paginate(80);

        return response()->json([
            'data'  => $data,
        ]);
       

    }
    else{
        $data = DB::table('quartiers')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
        ->orderBy("nomQuartier", "asc")
        ->paginate(80);
                return response()->json([
                    'data'  => $data,
                ]);
        }

    }


    function fetch_quartier_tug_commune($idCommune)
    {
        //
        $data = DB::table('quartiers')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
        ->where("quartiers.idCommune", $idCommune)
        ->get();

        return response()->json(['data'  =>  $data]);
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
            $data = Quartier::where("id", $request->id)->update([
                'idCommune'              =>  $request->idCommune,
                'nomQuartier'            =>  $request->nomQuartier
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = Quartier::create([
                'idCommune'              =>  $request->idCommune,
                'nomQuartier'            =>  $request->nomQuartier
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
        $data = DB::table('quartiers')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')
        
        ->select('quartiers.id','quartiers.idCommune','quartiers.nomQuartier',
            'communes.idVille','communes.nomCommune',
            'villes.nomVille','villes.idProvince',
            'provinces.nomProvince','provinces.idPays','pays.nomPays', 'quartiers.created_at')
        ->where("quartiers.id", $id)
        ->get();

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
        $data= Quartier::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }


}
