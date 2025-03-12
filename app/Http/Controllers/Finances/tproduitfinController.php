<?php

namespace App\Http\Controllers\Finances;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Finances\tfin_produit;
use DB;

class tproduitfinController extends Controller
{
    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    public function all(Request $request)
    { 
        
    //        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);
            //tfin_souscompte
            $data = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
            'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')           
            ->where('nom_produit', 'like', '%'.$query.'%')            
            ->orderBy("tfin_produit.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
            'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }


    public function fetch_produit_type(Request $request,$refTypeProduit)
    { 

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
            'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
            ->where([
                ['nom_produit', 'like', '%'.$query.'%'],
                ['refTypeProduit',$refTypeProduit]
            ])                    
            ->orderBy("nom_produit", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tfin_produit')   
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
            'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')        
            ->Where('refTypeProduit',$refTypeProduit)    
            ->orderBy("nom_produit", "asc")
            ->paginate(10);
            return response()->json([
                    'data'  => $data,
                ]);
        }

    }  
    
    function fetch_produit_type2($refTypeProduit)
    {

        $data = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')                     
        ->Where('refTypeProduit',$refTypeProduit)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function fetch_produit_type3(Request $request)
    {
        $refTypeProduit = $request->get('refTypeProduit');
        $organisationAbonne=$request->get('organisationAbonne');
        $refCategorieSociete=0;

        $data3 = DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select('refCategorieSociete')
        ->where('nom_org', $organisationAbonne)         
        ->get();
        foreach ($data3 as $list) {
           $refCategorieSociete= $list->refCategorieSociete;
        }

        $data = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')   
        ->where([
            ['refCategorieSociete',$refCategorieSociete],
            ['refTypeProduit',$refTypeProduit]
        ])
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function fetch_produit_type4(Request $request)
    {
        $refTypeProduit = $request->get('refTypeProduit');
        $refMouvement = $request->get('refMouvement');

        $organisationAbonne='';
        $mouvementList = DB::table('tmouvement')            
        ->select('organisationAbonne')
        ->where([
            ['tmouvement.id',$refMouvement]
        ])
        ->first();
        if ($mouvementList) {
            $organisationAbonne = $mouvementList->organisationAbonne;
        }        
        $refCategorieSociete=0;

        $data3 = DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select('refCategorieSociete')
        ->where('nom_org', $organisationAbonne)         
        ->get();
        foreach ($data3 as $list) {
           $refCategorieSociete= $list->refCategorieSociete;
        }

        $data = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')   
        ->where([
            ['refCategorieSociete',$refCategorieSociete],
            ['refTypeProduit',$refTypeProduit]
        ])
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function fetch_produit2()
    {

        $data = DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')                     
        ->get();
        return response()->json([
        'data' => $data,
        ]);
    }


   function fetch_single_produit($id)
    {

        $data =  DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')                    
        ->where('tfin_produit.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }


    function fetch_produit_typeproduit($refTypeProduit)
    {
//
        $data =  DB::table('tfin_produit')   
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
        'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')                    
        ->where('tfin_produit.refTypeProduit', $refTypeProduit)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    function insert_produit(Request $request)
    {
       
        $data = tfin_produit::create([                     
            'refTypeProduit'    =>  $request->refTypeProduit,
            'refSscompte'    =>  $request->refSscompte,
            'nom_produit'    =>  $request->nom_produit,
            'prix_produit'    =>  $request->prix_produit,
            'prix_convention'    =>  $request->prix_produit,
            'code_produit'    =>  $request->code_produit,
            'refCategorieSociete'    =>  $request->refCategorieSociete,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }

//refUnite
    function update_produit(Request $request, $id)
    {
        $data = tfin_produit::where('id', $id)->update([                       
            'refTypeProduit'    =>  $request->refTypeProduit,
            'refSscompte'    =>  $request->refSscompte,
            'nom_produit'    =>  $request->nom_produit,
            'prix_produit'    =>  $request->prix_produit,
            'prix_convention'    =>  $request->prix_produit,
            'code_produit'    =>  $request->code_produit,
            'refCategorieSociete'    =>  $request->refCategorieSociete,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_produit($id)
    {
        $data = tfin_produit::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
