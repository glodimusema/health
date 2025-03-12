<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tdepense;
use App\Models\vDepenses;
use App\Models\Finances\tfin_entete_operationcompte;
use App\Models\Finances\tfin_detail_operationcompte;
use App\Models\Finances\{tfin_cloture_comptabilite};
use DB;

class tdepenseController extends Controller
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
        
        if (!is_null($request->get('query'))) {
            # code..s.
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where('motif', 'like', '%'.$query.'%')
            ->orwhere('Compte', 'like', '%'.$query.'%')            
            ->orderBy("tdepense.id", "desc")          
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }


    public function fetch_mouvement_depense(Request $request)
    {     
        
       
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['motif', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '2']
            ])         
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour', "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->Where('tdepense.refMvt','2')   
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    


    public function fetch_mouvement_entree(Request $request)
    {     
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
            'taux_dujour', "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at","numeroBE")
            ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->where([
                ['motif', 'like', '%'.$query.'%'],
                ['tdepense.refMvt', '1']
            ])         
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);          

        }
        else{
            $data = DB::table('tdepense')
            ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
            ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
            ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
    
            ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
            "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau','taux_dujour',
            "AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
            ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
            "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
            "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
            "tdepense.created_at","tdepense.updated_at",'numeroBE')
            ->selectRaw('CONCAT("BENT",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
            ->Where('tdepense.refMvt','1')   
            ->orderBy("tdepense.id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }

    }    

    function fetch_single_depense($id)
    {

        $data = DB::table('tdepense')
        ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
        ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
        ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  

        ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
        "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
        'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
        ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
        "tconf_banque.refSscompte",'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
        "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
        "tdepense.created_at","tdepense.updated_at","numeroBE")
        ->selectRaw('CONCAT("BS",YEAR(dateOperation),"",MONTH(dateOperation),"00",tdepense.id) as codeOperation')
        ->where('tdepense.id', $id)
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }


    function insert_depense(Request $request)
    {

        $datetest='';
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateOperation)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateOperation)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {
            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
           
             $data = tdepense::create([
                 'montant'       =>  $request->montant,
                 'montantLettre'    =>  $request->montantLettre,
                 'motif'    =>  $request->motif,
                 'dateOperation'    =>  $request->dateOperation,
                 'refMvt'    =>  $request->refMvt,
                 'refCompte'    =>  $request->refCompte,
                 'modepaie'    =>  $request->modepaie,
                 'refBanque'    =>  $request->refBanque,
                 'numeroBordereau'    =>  $request->numeroBordereau,
                 'taux_dujour'    =>  $montant_taux,
                 'AcquitterPar'    =>  'Encours',
                 'StatutAcquitterPar'    =>  'NON',
                 'DateAcquitterPar'    =>  date('Y-m-d'),
                 'ApproCoordi'    =>  'Encours',
                 'StatutApproCoordi'    =>  'NON',
                 'DateApproCoordi'    =>  date('Y-m-d'),
                 'numeroBE'    =>  $request->numeroBE,
                 'author'       =>  $request->author
             ]);
             return response()->json([
                 'data'  =>  "Insertion avec succès!!!",
             ]); 
       }

    //    $table->string('AcquitterPar'); 
    //    $table->string('StatutAcquitterPar'); 
    //    $table->date('DateAcquitterPar'); 
    //    $table->string('ApproCoordi'); 
    //    $table->string('StatutApproCoordi'); 
    //    $table->date('DateApproCoordi'); 

    }

    function update_depense(Request $request, $id)
    {

        $datetest='';
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateCloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateCloture)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp !!! Veuillez prendre la date du jour suivant !!!",
            ]);
       }
       else
       {
            $montant_taux=0;
            $taux = DB::table('tfin_taux')->get();
    
            foreach ($taux as $tau) {
                $montant_taux= $tau->montant_taux;
            }
    
   
            $data = tdepense::where('id', $id)->update([
                'montant'       =>  $request->montant,
                'montantLettre'    =>  $request->montantLettre,
                'motif'    =>  $request->motif,
                'dateOperation'    =>  $request->dateOperation,
                'refMvt'    =>  $request->refMvt,
                'refCompte'    =>  $request->refCompte,
                'modepaie'    =>  $request->modepaie,
                'refBanque'    =>  $request->refBanque,
                'numeroBordereau'    =>  $request->numeroBordereau,
                'taux_dujour'    =>  $montant_taux,
                'numeroBE'    =>  $request->numeroBE,
                'author'       =>  $request->author
            ]);
            return response()->json([
                'data'  =>  "Modification  avec succès!!!",
            ]);
       }

    }

    function delete_depense($id)
    {
        $data = tdepense::where('id',$id)->delete();
        return response()->json([
            'data'  =>  "suppression avec succès",
        ]);
        
    }


    function fetch_compte_entree()
    {

        $data = DB::table('tcompte')->select("tcompte.id","tcompte.designation","tcompte.refMvt")
        ->where('tcompte.refMvt', '1')
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_compte_sortie()
    {

        $data = DB::table('tcompte')->select("tcompte.id","tcompte.designation","tcompte.refMvt")
        ->where('tcompte.refMvt', '2')
        ->get();

        return response()->json([
            'data'  => $data,
        ]);
    }

    function aquitter_depense(Request $request, $id)
    {
        $data = tdepense::where('id', $id)->update([
            'DateAcquitterPar' =>  date('Y-m-d'),
            'StatutAcquitterPar' =>  'OUI',
            'AcquitterPar' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }

    function approuver_depense(Request $request, $id)
    {
        $data = tdepense::where('id', $id)->update([
            'DateApproCoordi' =>  date('Y-m-d'),
            'StatutApproCoordi' =>  'OUI',
            'ApproCoordi' =>  $request->author
        ]);
        return response()->json([
            'data'  =>  "Modification  avec succès!!!",
        ]);
    }





    function cloturer_Comptabilite(Request $request)
    {
        $datetest='';
        $taux=0;
        $author= $request->author;
        $data3 = DB::table('tfin_cloture_comptabilite')
       ->select('dateCloture')
       ->where('dateCloture','=', $request->dateCloture)         
       ->get();    
       foreach ($data3 as $row) 
       {                           
          $datetest=$row->dateCloture;          
       }

       if($datetest == $request->dateCloture)
       {
            return response()->json([
                'data'  =>  "La Comptabilité est déja cloturée pour cette date svp!!! Veuillez prendre la date du jour suivant!!!",
            ]);
       }
       else
       {
                $data6 = DB::table('tdepense')
                ->join('tcompte','tcompte.id','=','tdepense.refCompte')        
                ->join('ttypemouvement','ttypemouvement.id','=','tdepense.refMvt') 
                ->join('tconf_banque' , 'tconf_banque.id','=','tdepense.refBanque')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')  
        
                ->select("tdepense.id","montant","montantLettre","motif","dateOperation",
                "tdepense.refMvt","tdepense.refCompte","tdepense.author",'modepaie','refBanque','numeroBordereau',
                'taux_dujour',"AcquitterPar","StatutAcquitterPar","DateAcquitterPar","ApproCoordi","StatutApproCoordi"
                ,"DateApproCoordi","tconf_banque.nom_banque","tconf_banque.numerocompte",'tconf_banque.nom_mode',
                "tconf_banque.refSscompte as refSscompteBanque","tcompte.refSscompte as refSscompteLibelle",
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','tfin_souscompte.refCompte as refCompteBanque','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','nom_typeposition',"nom_typecompte",
                "tcompte.designation as Compte","ttypemouvement.designation as TypeMouvement",
                "tdepense.created_at","tdepense.updated_at","numeroBE")
                ->where('dateOperation','=', $request->dateCloture)                  
                ->get(); 
                foreach ($data6 as $row6) 
                { 
                    $taux=$row6->taux_dujour;
                    //refBanque

                    $data = tfin_entete_operationcompte::create([
                        'libelleOperation'       =>   $row6->Compte,
                        'dateOpration'       =>  $row6->dateOperation,
                        'numOpereation'    =>  $row6->id,
                        'refTresorerie'    =>  $row6->refBanque,
                        'tauxdujour'    =>  $row6->taux_dujour,
                        'author'    =>  $row6->author   
                    ]);

                    $idmax_entete=0;
                    $maxid_entete = DB::table('tfin_entete_operationcompte')        
                    ->selectRaw('MAX(tfin_entete_operationcompte.id) as code_entete')
                    ->where([
                        ['tfin_entete_operationcompte.numOpereation',$row6->id]
                    ])
                    ->get();
                    foreach ($maxid_entete as $list_entete) {
                        $idmax_entete= $list_entete->code_entete;
                    }


                    if($row6->refMvt == 2)
                    {
                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteLibelle,
                            'typeOperation'       =>  'DEBIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteBanque,
                            'typeOperation'       =>  'CREDIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                    }
                    if($row6->refMvt == 1)
                    {
                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteBanque,
                            'typeOperation'       =>  'DEBIT',
                            'montantOpration'       =>  $row6->montant
                        ]);

                        $data = tfin_detail_operationcompte::create([
                            'refEnteteOperation'       =>  $idmax_entete,
                            'refSscompte'       =>  $row6->refSscompteLibelle,
                            'typeOperation'       =>  'CREDIT',
                            'montantOpration'       =>  $row6->montant
                        ]);
                    }                  
                }
    
                $data = tfin_cloture_comptabilite::create([
                    'dateCloture' =>  $request->dateCloture,
                    'tauxdujour' =>  $taux,
                    'numerOperation' => 0,
                    'author' =>  $author
                ]);
            return response()->json([
                    'data'  =>  "La COmptabilité est cloturée pour cette date avec succès!!!",
            ]);

       }



    }













    

}
