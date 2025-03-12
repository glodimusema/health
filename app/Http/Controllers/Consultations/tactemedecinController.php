<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Consultations\tfin_actesmedecin;
use DB;

class tactemedecinController extends Controller
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
            $data = DB::table('tfin_actesmedecin')            
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_actesmedecin.id','refSscompte','nom_acte',
            'prix_acte','prix_convention','code_acte','refSousCompte','nom_ssouscompte','numero_ssouscompte',
            'nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")           
            ->where('nom_ssouscompte', 'like', '%'.$query.'%')            
            ->orderBy("tfin_actesmedecin.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tfin_actesmedecin')            
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->select('tfin_actesmedecin.id','refSscompte','nom_acte',
            'prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->paginate(10);
                return response()->json([
                    'data'  => $data,
                ]);
            }

    }
    
    
   function fetch_single_acte($id)
    {

        $data =  DB::table('tfin_actesmedecin')            
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_actesmedecin.refUnite')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->select('tfin_actesmedecin.id','refSscompte','nom_acte',
        'prix_acte','prix_convention','code_acte',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")                    
        ->where('tfin_actesmedecin.id', $id)
        ->get();

        return response()->json([
        'data' => $data,
        ]);
    }

    //'id','refUnite','refTypeProduit','refSscompte','nom_acte',
    //'prix_acte','prix_convention','code_acte','author'

    function insert_acte(Request $request)
    {
       
        $data = tfin_actesmedecin::create([                 
            'refSscompte'    =>  $request->refSscompte,
            'refUnite'    =>  $request->refUnite,
            'nom_acte'    =>  $request->nom_acte,
            'prix_acte'    =>  $request->prix_acte,
            'prix_convention'    =>  $request->prix_convention,
            'code_acte'    =>  $request->code_acte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Insertion avec succès!!!",
        ]);
    }


    function update_acte(Request $request, $id)
    {
        $data = tfin_actesmedecin::where('id', $id)->update([                     
            'refSscompte'    =>  $request->refSscompte,
            'refUnite'    =>  $request->refUnite,
            'nom_acte'    =>  $request->nom_acte,
            'prix_acte'    =>  $request->prix_acte,
            'prix_convention'    =>  $request->prix_convention,
            'code_acte'    =>  $request->code_acte,
            'author'    =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function delete_acte($id)
    {
        $data = tfin_actesmedecin::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }
}
