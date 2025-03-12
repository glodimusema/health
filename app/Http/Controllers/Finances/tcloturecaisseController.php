<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Finances\{tfin_cloture_caisse};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class tcloturecaisseController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //'id','refSscompte','date_cloture','montant_cloture','taux_dujour','author'
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tfin_cloture_caisse')
            ->join('tcompte','tcompte.id','=','tfin_cloture_caisse.refSsCompte')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

            ->select("tfin_cloture_caisse.id","tcompte.refMvt","tcompte.designation as Compte","refMvt",
            "tfin_cloture_caisse.date_cloture",
            "tfin_cloture_caisse.montant_cloture",'tfin_cloture_caisse.taux_dujour',"tfin_cloture_caisse.refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_cloture_caisse.author',
            'nom_typeposition',"nom_typecompte","tfin_cloture_caisse.created_at")
            ->where([
                ['date_cloture', 'like', '%'.$query.'%'],
                ['tfin_cloture_caisse.deleted','NON']
            ])            
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           //nom_mode

        }
        else{
            $data = DB::table('tfin_cloture_caisse')
            ->join('tcompte','tcompte.id','=','tfin_cloture_caisse.refSsCompte')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tcompte.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')

            ->select("tfin_cloture_caisse.id","tcompte.refMvt","tcompte.designation as Compte","refMvt",
            "tfin_cloture_caisse.date_cloture",
            "tfin_cloture_caisse.montant_cloture",'tfin_cloture_caisse.taux_dujour',"tfin_cloture_caisse.refSscompte",
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_cloture_caisse.author',
            'nom_typeposition',"nom_typecompte","tfin_cloture_caisse.created_at")
            ->where([['tfin_cloture_caisse.deleted','NON']])
            ->orderBy("id", "desc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }

   
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $data = tfin_cloture_caisse::where('id', $id)->get();
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
        $data = tfin_cloture_caisse::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    

}
