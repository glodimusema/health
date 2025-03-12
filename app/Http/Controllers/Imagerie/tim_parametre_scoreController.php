<?php

namespace App\Http\Controllers\Imagerie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Imagerie\tim_parametre_score;
use App\Traits\{GlobalMethod,Slug};
use DB;


class tim_parametre_scoreController extends Controller
{
    use GlobalMethod, Slug;

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
            
            $data = DB::table('tim_parametre_score')
            ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
            ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
            ->select("tim_parametre_score.id","genre","score","desi_libelle","desi_interval",
            "tim_parametre_score.author",
            "refLibelle","refInterval")
            ->where([
                ['desi_libelle', 'like', '%'.$query.'%']
            ])           
            ->orderBy("tim_parametre_score.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
                  
            $data = DB::table('tim_parametre_score')
            ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
            ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
            ->select("tim_parametre_score.id","genre","score","desi_libelle","desi_interval",
            "tim_parametre_score.author","refLibelle","refInterval")
            ->orderBy("tim_parametre_score.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    function fetch_single($id)
    {
            
        $data = DB::table('tim_parametre_score')
        ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
        ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
        ->select("tim_parametre_score.id","genre","score","desi_libelle","desi_interval",
        "tim_parametre_score.author",
        "refLibelle","refInterval")
        ->where('tim_parametre_score.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_params_libelle(Request $request)
    {
        if($request->refLibelle != null && $request->genre)
        {
            $refLib=$request->refLibelle;
            $genre=$request->genre;

            $data = DB::table('tim_parametre_score')
            ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
            ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
            ->select("tim_parametre_score.id","genre","score","desi_libelle","desi_interval",
            "tim_parametre_score.author","refLibelle","refInterval")
            ->selectRaw('CONCAT(desi_interval,"=",score) as dataScore')
            ->where([
                ['refLibelle',$refLib],
                ['genre',$genre]
            ])
            ->get();

            return response()->json([
                'data'  => $data,
            ]);

        }
            
        
    }

    //id,refLibelle,refInterval,genre,score,author

    function insertData(Request $request)
    {
       
        $data = tim_parametre_score::create([
            'refLibelle'=>$request->refLibelle,
            'refInterval'       =>$request->refInterval,
            'genre'     =>  $request->genre,
            'score'         => $request->score,    
            'author'           =>$request->author  
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function updateData(Request $request, $id)
    {
        $data = tim_parametre_score::where('id', $id)->update([
            'refLibelle'=>$request->refLibelle,
            'refInterval'       =>$request->refInterval,
            'genre'     =>  $request->genre,
            'score'         => $request->score,    
            'author'           =>$request->author 
            
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
     $data = tim_parametre_score::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
