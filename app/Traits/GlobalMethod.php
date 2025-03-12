<?php 
namespace App\Traits;
use DB;

trait GlobalMethod{

	//global query
    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    function f_date($date)
    {
      $date = new Date($date);
      return substr($date->format('d/m/Y'), 0,10);
    }

    function CreatedAt($date)
    {
       $created_at = nl2br(substr(date(DATE_RFC822, strtotime($date)), 0, 23));
       return $created_at; 
    }

    function apiData($data)
    {
      return response($data, 200);
    }


    function msgJson($message)
    {
        return response()->json(['data' => $message]);
    }

    function msgError($message)
    {
      return response()->json(['error'  => $message]);
    }


    function generateOpt($n)
  	{
  	    $generator="1234567890AZERTYUIOPQSDFGHJKLMWXCVBN";
  	    $result="";
  	    for ($i=0; $i <$n ; $i++)
  	    {
  	      $result.=substr($generator, (rand()%(strlen($generator))),1);
  	    }
  	    return $result;
  	}

      function displayImg($schema, $file)
      {
          $logo=base_path('public/'.$schema.'/'.$file);
          $f=file_get_contents($logo);
          $pic='data:image/png;base64,'.base64_encode($f);
          return $pic;
      }
  
      function displayImgDynamique($avatar)
      {
          $logo=base_path('public/storage/'.$avatar);
          $f=file_get_contents($logo);
          $pic='data:image/png;base64,'.base64_encode($f);
          return $pic;
      }

    /*
    ========================
    // mes scripts ajouts
    *=======================
    *
    *
    */
    // voir les nombre sur les tables 
    function showCountTableWhere($table,$column, $valeur)
    {
      $data = DB::table($table)->where($column,'=', $valeur)->count();
      return $data;
    }

    // voir les nombre sur les tables 
    function showCountTable($table)
    {
      $data = DB::table($table)->count();
      return $data;
    }

    // utulisateur en action connecté 
    function UsersActionConnected($id_user)
    {
        $contributions = DB::table("users")
        ->join('roles','users.id_role','=','roles.id')
        
        ->select('users.id','users.name','users.email','users.id_role','roles.role_name as role', 'users.created_at')
        ->where('users.id', '=', $id_user)->get();
        $data = [];
        foreach ($contributions as $row) {
            # code...
            array_push($data, array(
                'name'          =>  $row->name,
                'privilege'     =>  $row->role,
            ));

        }
        return $data;
    }

    function mesEmprunt($id_user, $table)
    {
        $credits = DB::table($table)->where('id_user', '=', $id_user)->get();
        $data = [];
        foreach ($credits as $row) {
            # code...
            array_push($data, array(
                'jour'          =>  $row->datejour,
                'montant'       =>  $row->montant,
                'created_at'    =>  $row->created_at,
                'connected'     =>  $this->UsersActionConnected($row->connected)
                
            ));

        }
        return $data;
    }

    // voir la somme de contributions ou de remboursement par utilisateur
    function showSumMontantUser($table,$column, $valeur, $money)
    {
        $somme = DB::table($table)->where($column, '=', $valeur)->sum($table.'.'.$money);
        return $somme;
    }

    function showSumMontantTable($table, $money)
    {
        $somme = DB::table($table)->sum($table.'.'.$money);
        return $somme;
    }

    function showNumberDataTableUser($table, $column, $valeur)
    {
       $tests = DB::table($table)->where([
            [$column,     '=', $valeur]

        ])->get();
        $count = $tests->count();

        return  $count;
    }

    function showNumberDataTable($table)
    {
       $tests = DB::table($table)->get();
       $count = $tests->count();

      return  $count;
    }

    function showCount($id, $table)
    {
        $demandes = DB::table($table)->where([
            ['id', '=', $id],
            ['etat', '=', 1]
        ])->get();

        $count = $demandes->count();
        return $count;

    }

    function getIdentifiantAgent($slug)
    {
        $data = DB::table('agents')
        
        ->select(
            "agents.id","agents.name","agents.slug", "agents.created_at"
        )
        ->where("agents.slug", $slug)
        ->get();
        $idAgent = '';
        foreach ($data as $row) {
            # code...
            $idAgent = $row->id;
        }

        return $idAgent;
    }

    function getNomAgent($slug)
    {
        $data = DB::table('agents')
        
        ->select(
             "agents.id","agents.name","agents.slug", "agents.created_at"
        )
        ->where("agents.slug", $slug)
        ->get();
        $idAgent = '';
        foreach ($data as $row) {
            # code...
            $idAgent = $row->name;
        }

        return $idAgent;
    }

    //test de roles
    function fetch_menu_roles_ok($refRole)
    {
        $data = DB::table('tconf_crud_access')
        ->join('roles','roles.id','=','tconf_crud_access.refRole')        
        ->select("tconf_crud_access.id" ,"roles.nom",'insert','update','delete','load','tconf_crud_access.author')
        ->where('tconf_crud_access.refRole', $refRole)
        ->get();

        return $data;
    }

    public function delete_data($id)
    {
        //
        $data= Ville::where('id', $id)->delete();

        $idmax=0; 
        $maxid = DB::table(''.$idmax.'')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')        
        ->selectRaw('MAX(tfin_entetefacturation.id) as code_entete_facture')
        ->where('tfin_entetefacturation.refMouvement', $request->refMouvement)
        ->get();
        foreach ($maxid as $list) {
            $idmax= $list->code_entete_facture;
        }
        

        $data2 = DB::update(
            'update tproduit set qte = qte - :qteSortie where id = :refProduit',
            ['qteSortie' => $qte,'refProduit' => $idDetail]
        );
        return $this->msgJson('Suppression avec succès!!!');
    }





    







}




?>