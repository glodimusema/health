<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{tclient};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tclientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod, Slug;

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }


    public function index(Request $request)
    {       
//
        if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);

            $data = DB::table('tclient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['noms', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
            ->orWhere([['contact', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
            ->orWhere([['nomAvenue', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
            ->orWhere([['nomQuartier', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
            ->orWhere([['nomCommune', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
            ->orWhere([['nomProvince', 'like', '%'.$query.'%'],['tclient.deleted','NON']]) 
            ->orderBy("tclient.id", "desc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tclient')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
            "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where([['tclient.deleted','NON']])
            ->orderBy("tclient.id", "desc")
            ->paginate(80);
                    return response()->json([
                        'data'  => $data,
                    ]);
            }

        }

        public function searchMaladeTeste(Request $request)
        {
    
           
    
            if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);
                $data = DB::table('tclient')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                //MALADE
                ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
                "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
                "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
                "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
                "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->where([['noms', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
                ->orWhere([['contact', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
                ->orWhere([['nomAvenue', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
                ->orWhere([['nomQuartier', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
                ->orWhere([['nomCommune', 'like', '%'.$query.'%'],['tclient.deleted','NON']])
                ->orWhere([['nomProvince', 'like', '%'.$query.'%'],['tclient.deleted','NON']]) 
                ->orderBy("tclient.id", "desc")->take(100)->get();
    
                return response()->json([
                    'data'  => $data,
                ]);
               
    
            }
           
    
    
    
        }
    
    public function Profiletclient($id, Request $request)
    {
        //
        $data = DB::table('tclient')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
        "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where([
            ['tclient.id', $id]
        ])
        ->orderBy("tclient.id", "desc")
        ->get();

        return response()->json(['data'  =>  $data]);
        
    }

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tclient::create([
                'noms'          =>  $formData->noms,
                'contact'    =>  $formData->contact,
                'mail'         =>  $formData->mail,                
                'refAvenue'      =>  $formData->refAvenue,                
                'refCategieClient'  =>  $formData->refCategieClient,               
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  "Admin",
                'sexe_malade'    =>  $formData->sexe_malade,
                'dateNaissance_malade'    =>  $formData->dateNaissance_malade,
                'etatcivil_malade'    =>  $formData->etatcivil_malade,
                'numeroMaison_malade'    =>  $formData->numeroMaison_malade,
                'fonction_malade'    =>  $formData->fonction_malade,
                'groupesanguin'=>  $formData->groupesanguin,
                'personneRef_malade'    =>  $formData->personneRef_malade,
                'fonctioPersRef_malade'    =>  $formData->fonctioPersRef_malade,
                'contactPersRef_malade'    =>  $formData->contactPersRef_malade,
                'organisation_malade'    =>  $formData->organisation_malade,
                'numeroCarte_malade'    =>  $formData->numeroCarte_malade,
                'dateExpiration_malade'    =>  $formData->dateExpiration_malade         
            ]);

            return $this->msgJson('Information ajoutée avec succès');
//sexe_malade,dateNaissance_malade,etatcivil_malade,numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,contactPersRef_malade,organisation_malade,numeroCarte_malade,dateExpiration_malade
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            tclient::create([
                'noms'          =>  $formData->noms,
                'contact'    =>  $formData->contact,
                'mail'         =>  $formData->mail,                
                'refAvenue'      =>  $formData->refAvenue,                
                'refCategieClient'  =>  $formData->refCategieClient,               
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'author'         =>  "Admin", 
                'sexe_malade'    =>  $formData->sexe_malade,
                'dateNaissance_malade'    =>  $formData->dateNaissance_malade,
                'etatcivil_malade'    =>  $formData->etatcivil_malade,
                'numeroMaison_malade'    =>  $formData->numeroMaison_malade,
                'fonction_malade'    =>  $formData->fonction_malade,
                'groupesanguin'=>  $formData->groupesanguin,
                'personneRef_malade'    =>  $formData->personneRef_malade,
                'fonctioPersRef_malade'    =>  $formData->fonctioPersRef_malade,
                'contactPersRef_malade'    =>  $formData->contactPersRef_malade,
                'organisation_malade'    =>  $formData->organisation_malade,
                'numeroCarte_malade'    =>  $formData->numeroCarte_malade,
                'dateExpiration_malade'    =>  $formData->dateExpiration_malade 
            ]);
            return $this->msgJson('Information ajoutée avec succès');

        }

    }

    function updateData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tclient::where('id',$formData->id)->update([
                'noms'          =>  $formData->noms,
                'contact'    =>  $formData->contact,
                'mail'         =>  $formData->mail,                
                'refAvenue'      =>  $formData->refAvenue,                
                'refCategieClient'  =>  $formData->refCategieClient,               
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  "Admin",
                'sexe_malade'    =>  $formData->sexe_malade,
                'dateNaissance_malade'    =>  $formData->dateNaissance_malade,
                'etatcivil_malade'    =>  $formData->etatcivil_malade,
                'numeroMaison_malade'    =>  $formData->numeroMaison_malade,
                'fonction_malade'    =>  $formData->fonction_malade,
                'groupesanguin'=>  $formData->groupesanguin,
                'personneRef_malade'    =>  $formData->personneRef_malade,
                'fonctioPersRef_malade'    =>  $formData->fonctioPersRef_malade,
                'contactPersRef_malade'    =>  $formData->contactPersRef_malade,
                'organisation_malade'    =>  $formData->organisation_malade,
                'numeroCarte_malade'    =>  $formData->numeroCarte_malade,
                'dateExpiration_malade'    =>  $formData->dateExpiration_malade  
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->noms.''.$formData->noms,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tclient::where('id',$formData->id)->update([
                'noms'          =>  $formData->noms,
                'contact'    =>  $formData->contact,
                'mail'         =>  $formData->mail,                
                'refAvenue'      =>  $formData->refAvenue,                
                'refCategieClient'  =>  $formData->refCategieClient,           
                'slug'          =>  $slug,
                'author'         =>  "Admin",
                'sexe_malade'    =>  $formData->sexe_malade,
                'dateNaissance_malade'    =>  $formData->dateNaissance_malade,
                'etatcivil_malade'    =>  $formData->etatcivil_malade,
                'numeroMaison_malade'    =>  $formData->numeroMaison_malade,
                'fonction_malade'    =>  $formData->fonction_malade,
                'groupesanguin'=>  $formData->groupesanguin,
                'personneRef_malade'    =>  $formData->personneRef_malade,
                'fonctioPersRef_malade'    =>  $formData->fonctioPersRef_malade,
                'contactPersRef_malade'    =>  $formData->contactPersRef_malade,
                'organisation_malade'    =>  $formData->organisation_malade,
                'numeroCarte_malade'    =>  $formData->numeroCarte_malade,
                'dateExpiration_malade'    =>  $formData->dateExpiration_malade
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }



    function fetch_list_categorie()
    {
        $data = DB::table('tcategorieclient')->select("tcategorieclient.id","tcategorieclient.designation")->get();
        return response()->json([
            'data'  => $data,
        ]);
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
        $data = DB::table('tclient')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
        "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
        "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->where('tclient.id', $id)->get();

        
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
        $data = tclient::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tclient::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreDatatclient($id, $connected)
    {
        //
        $data = tclient::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }





}
