<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_entete_operationcompte;
use DB;
//tperso_entete_paiement
//tperso_detail_paiement_sal

class tfin_entete_operationcompteController extends Controller
{
    function Gquery($request)
    {
     return str_replace(" ", "%", $request->get('query'));
    }

    public function all(Request $request)
    { 
        //,'modepaie','refBanque'
                
        if (!is_null($request->get('query'))) 
        {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tfin_entete_operationcompte')          
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_entete_operationcompte.refTresorerie')  
            ->select("tfin_entete_operationcompte.id","libelleOperation","dateOpration",
            "numOpereation","refTresorerie","tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode','tauxdujour','tfin_entete_operationcompte.author')
            ->where([
                ['libelleOperation', 'like', '%'.$query.'%'],
                ['tfin_entete_operationcompte.deleted','NON']
            ])
            ->orderBy("tfin_entete_operationcompte.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data
            ]);
           

        }
        else{

            $data = DB::table('tfin_entete_operationcompte')          
            ->join('tconf_banque' , 'tconf_banque.id','=','tfin_entete_operationcompte.refTresorerie')  
            ->select("tfin_entete_operationcompte.id","libelleOperation","dateOpration",
            "numOpereation","refTresorerie","tconf_banque.nom_banque",
            "tconf_banque.numerocompte",'tconf_banque.nom_mode','tauxdujour','tfin_entete_operationcompte.author')
            ->where([['tfin_entete_operationcompte.deleted','NON']])
            ->orderBy("tfin_entete_operationcompte.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
        }

    }

    function fetch_single($id)
    {
        $data = DB::table('tfin_entete_operationcompte')          
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_entete_operationcompte.refTresorerie')  
        ->select("tfin_entete_operationcompte.id","libelleOperation","dateOpration",
        "numOpereation","refTresorerie","tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode','tauxdujour','tfin_entete_operationcompte.author')
        ->where('tfin_entete_operationcompte.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    //id","libelleOperation","dateOpration","numOpereation","refTresorerie",'tauxdujour','author'  tfin_entete_operationcompte

    function insert_data(Request $request)
    {
        $taux=0;
        $tauxList = DB::table('tfin_taux')
        ->select("tfin_taux.id","tfin_taux.montant_taux","tfin_taux.created_at")
        ->get();
        foreach ($tauxList as $listTaux) {
            $taux= $listTaux->montant_taux;
        }

        $data = tfin_entete_operationcompte::create([
            'libelleOperation'       =>   $request->libelleOperation,
            'dateOpration'       =>  $request->dateOpration,
            'numOpereation'    =>  $request->numOpereation,
            'refTresorerie'    =>  $request->refTresorerie,
            'tauxdujour'    =>  $taux,
            'author'    =>  $request->author   
        ]);

        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }



    function updateData(Request $request, $id)
    {
        $data = tfin_entete_operationcompte::where('id', $id)->update([
            'libelleOperation'       =>   $request->libelleOperation,
            'dateOpration'       =>  $request->dateOpration,
            'numOpereation'    =>  $request->numOpereation,
            'refTresorerie'    =>  $request->refTresorerie,
            'author'    =>  $request->author  
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
     $data = tfin_entete_operationcompte::where('id', $id)->delete();
     
     return response()->json([
        'data'  =>  "suppression avec succès",
    ]);
 }

}
