<?php

namespace App\Http\Controllers\Parametres;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Parametres\{tconf_organisationabone};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class torganisationController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('tconf_organisationabone')
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
            ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
             'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
             'name_categorie_societe','author',"tconf_organisationabone.created_at")
            ->where('nom_org', 'like', '%'.$query.'%')
            ->orderBy("nom_org", "asc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tconf_organisationabone')
            ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
            ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
             'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
             'name_categorie_societe','author',"tconf_organisationabone.created_at")
            ->orderBy("nom_org", "asc")->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }

//'refCategorieSociete' =>  $request->refCategorieSociete,
    function fetch_tconf_organisationabone_2()
    {
        $data = DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
         'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
         'name_categorie_societe','author',"tconf_organisationabone.created_at")
        ->orderBy("tconf_organisationabone.nom_org", "asc")
        ->paginate(10);
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
        //'id','nom_org', 'adresse_org', 'contact_org', 'rccm_org', 'idnat_org', 'author'
        if ($request->id !='') 
        {
            # code...
            // update ,'refCategorieSociete'
            $data = tconf_organisationabone::where("id", $request->id)->update([
                'nom_org' =>  $request->nom_org,
                'adresse_org' =>  $request->adresse_org,
                'contact_org' =>  $request->contact_org,
                'rccm_org' =>  $request->rccm_org,
                'idnat_org' =>  $request->idnat_org,
                'pourcentageConvention' =>  $request->pourcentageConvention,
                'nmbreJourCons' =>  $request->nmbreJourCons,
                'refCategorieSociete' =>  $request->refCategorieSociete,
                'author' =>  $request->author
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = tconf_organisationabone::create([
                'nom_org' =>  $request->nom_org,
                'adresse_org' =>  $request->adresse_org,
                'contact_org' =>  $request->contact_org,
                'rccm_org' =>  $request->rccm_org,
                'idnat_org' =>  $request->idnat_org,
                'pourcentageConvention' =>  $request->pourcentageConvention,
                'nmbreJourCons' =>  $request->nmbreJourCons,
                'refCategorieSociete' =>  $request->refCategorieSociete,
                'author' =>  $request->author
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
        $data = tconf_organisationabone::where('id', $id)->get();
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
        $data = tconf_organisationabone::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
