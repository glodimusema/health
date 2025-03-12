<?php

namespace App\Http\Controllers\Medecins;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Medecins\{tmedecin};
use App\Traits\{GlobalMethod,Slug};
use DB;

class tmedecinController extends Controller
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
    }


    public function index(Request $request)
    {       

        if (!is_null($request->get('query'))) {
                # code...
                $query = $this->Gquery($request);

            $data = DB::table('tmedecin')            
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmedecin.id","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","photo","slug",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tmedecin.author","tmedecin.created_at","tmedecin.updated_at")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')
            ->where([['noms_medecin', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']])
            ->orWhere([['contact', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']])
            ->orWhere([['nomAvenue', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']])
            ->orWhere([['nomQuartier', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']])
            ->orWhere([['nomCommune', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']])
            ->orWhere([['nomProvince', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']]) 
            ->orWhere([['Categorie_medecin', 'like', '%'.$query.'%'],['tmedecin.deleted','NON']]) 

            ->orderBy("tmedecin.noms_medecin", "asc")
            ->paginate(80);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('tmedecin')            
            ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmedecin.id","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","photo","slug",
            "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
            "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
            "pays.nomPays","tmedecin.author","tmedecin.created_at","tmedecin.updated_at")
            ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')
            ->where([['tmedecin.deleted','NON']])
            ->orderBy("tmedecin.noms_medecin", "asc")
            ->paginate(80);
                    return response()->json([
                        'data'  => $data,
                    ]);
            }

        }
    
    public function Profiletmedecin($id, Request $request)
    {
        //
        $data = DB::table('tmedecin')            
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tmedecin.id","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","photo","slug",
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tmedecin.author","tmedecin.created_at","tmedecin.updated_at")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')
        ->where([
            ['tmedecin.id', $id]
        ])->get();

        return response()->json(['data'  =>  $data]);
        
    }

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {

            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/fichier'), $imageName);

            $stringToSlug=substr($formData->noms_medecin.''.$formData->noms_medecin,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tmedecin::create([
                'matricule_medecin'  =>  $formData->matricule_medecin,
                'noms_medecin'    =>  $formData->noms_medecin,
                'sexe_medecin'         =>  $formData->sexe_medecin,                
                'datenaissance_medecin'      =>  $formData->datenaissance_medecin,                
                'lieunaissnce_medecin'  =>  $formData->lieunaissnce_medecin, 
                'provinceOrigine_medecin'  =>  $formData->provinceOrigine_medecin,
                'etatcivil_medecin'  =>  $formData->etatcivil_medecin,
                'refAvenue_medecin'  =>  $formData->refAvenue_medecin,
                'contact_medecin'  =>  $formData->contact_medecin,
                'mail_medecin'  =>  $formData->mail_medecin,
                'grade_medecin'  =>  $formData->grade_medecin,
                'fonction_medecin'  =>  $formData->fonction_medecin,
                'specialite_medecin'  =>  $formData->specialite_medecin, 
                'Categorie_medecin'  =>  $formData->Categorie_medecin, 
                'niveauEtude_medecin'  =>  $formData->niveauEtude_medecin, 
                'anneeFinEtude_medecin'  =>  $formData->anneeFinEtude_medecin, 
                'Ecole_medecin'  =>  $formData->Ecole_medecin, 
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  $formData->author
                       
            ]);
//detailadresse_medecin
            return $this->msgJson('Information ajoutée avec succès');
//sexe_malade,dateNaissance_malade,etatcivil_malade,numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,contactPersRef_malade,organisation_malade,numeroCarte_malade,dateExpiration_malade
        }
        else{

            $formData = json_decode($_POST['data']);
            $stringToSlug=substr($formData->noms_medecin.''.$formData->noms_medecin,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
            tmedecin::create([
                'matricule_medecin'  =>  $formData->matricule_medecin,
                'noms_medecin'    =>  $formData->noms_medecin,
                'sexe_medecin'         =>  $formData->sexe_medecin,                
                'datenaissance_medecin'      =>  $formData->datenaissance_medecin,                
                'lieunaissnce_medecin'  =>  $formData->lieunaissnce_medecin, 
                'provinceOrigine_medecin'  =>  $formData->provinceOrigine_medecin,
                'etatcivil_medecin'  =>  $formData->etatcivil_medecin,
                'refAvenue_medecin'  =>  $formData->refAvenue_medecin,
                'contact_medecin'  =>  $formData->contact_medecin,
                'mail_medecin'  =>  $formData->mail_medecin,
                'grade_medecin'  =>  $formData->grade_medecin,
                'fonction_medecin'  =>  $formData->fonction_medecin,
                'specialite_medecin'  =>  $formData->specialite_medecin, 
                'Categorie_medecin'  =>  $formData->Categorie_medecin, 
                'niveauEtude_medecin'  =>  $formData->niveauEtude_medecin, 
                'anneeFinEtude_medecin'  =>  $formData->anneeFinEtude_medecin, 
                'Ecole_medecin'  =>  $formData->Ecole_medecin,              
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'author'         =>  $formData->author,
 
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

            $stringToSlug=substr($formData->noms_medecin.''.$formData->noms_medecin,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);
           
            tmedecin::where('id',$formData->id)->update([
                'matricule_medecin'  =>  $formData->matricule_medecin,
                'noms_medecin'    =>  $formData->noms_medecin,
                'sexe_medecin'         =>  $formData->sexe_medecin,                
                'datenaissance_medecin'      =>  $formData->datenaissance_medecin,                
                'lieunaissnce_medecin'  =>  $formData->lieunaissnce_medecin, 
                'provinceOrigine_medecin'  =>  $formData->provinceOrigine_medecin,
                'etatcivil_medecin'  =>  $formData->etatcivil_medecin,
                'refAvenue_medecin'  =>  $formData->refAvenue_medecin,
                'contact_medecin'  =>  $formData->contact_medecin,
                'mail_medecin'  =>  $formData->mail_medecin,
                'grade_medecin'  =>  $formData->grade_medecin,
                'fonction_medecin'  =>  $formData->fonction_medecin,
                'specialite_medecin'  =>  $formData->specialite_medecin, 
                'Categorie_medecin'  =>  $formData->Categorie_medecin, 
                'niveauEtude_medecin'  =>  $formData->niveauEtude_medecin, 
                'anneeFinEtude_medecin'  =>  $formData->anneeFinEtude_medecin, 
                'Ecole_medecin'  =>  $formData->Ecole_medecin,              
                'photo'         =>  $imageName,
                'slug'          =>  $slug,
                'author'         =>  $formData->author
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           
            $stringToSlug=substr($formData->noms_medecin.''.$formData->noms_medecin,0,16).'-'.$this->generateOpt(8);
            $slug =$this->makeSlug($stringToSlug);

            tmedecin::where('id',$formData->id)->update([
                'matricule_medecin'  =>  $formData->matricule_medecin,
                'noms_medecin'    =>  $formData->noms_medecin,
                'sexe_medecin'         =>  $formData->sexe_medecin,                
                'datenaissance_medecin'      =>  $formData->datenaissance_medecin,                
                'lieunaissnce_medecin'  =>  $formData->lieunaissnce_medecin, 
                'provinceOrigine_medecin'  =>  $formData->provinceOrigine_medecin,
                'etatcivil_medecin'  =>  $formData->etatcivil_medecin,
                'refAvenue_medecin'  =>  $formData->refAvenue_medecin,
                'contact_medecin'  =>  $formData->contact_medecin,
                'mail_medecin'  =>  $formData->mail_medecin,
                'grade_medecin'  =>  $formData->grade_medecin,
                'fonction_medecin'  =>  $formData->fonction_medecin,
                'specialite_medecin'  =>  $formData->specialite_medecin, 
                'Categorie_medecin'  =>  $formData->Categorie_medecin, 
                'niveauEtude_medecin'  =>  $formData->niveauEtude_medecin, 
                'anneeFinEtude_medecin'  =>  $formData->anneeFinEtude_medecin, 
                'Ecole_medecin'  =>  $formData->Ecole_medecin,              
                'photo'         =>  'avatar.png',
                'slug'          =>  $slug,
                'author'         =>  $formData->author
            ]);
            return $this->msgJson('Modifcation avec succès');

        }

    }

    function fetch_list_categorie()
    {
        $data = DB::table('tcategoriemedecin')->select("tcategoriemedecin.id","tcategoriemedecin.designation")->get();
        return response()->json([
            'data'  => $data,
        ]);
    }

    function fetch_list_fonction()
    {
        $data = DB::table('tfonctionmedecin')->select("tfonctionmedecin.id","tfonctionmedecin.designation")->get();
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
        $data = DB::table('tmedecin')
        ->join('avenues' , 'avenues.id','=','tmedecin.refAvenue_medecin')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        //MALADE
        ->select("tmedecin.id","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
        "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
        "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
        "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","photo","slug",
        "avenues.nomAvenue", "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier",
        "communes.idVille",
        "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
        "pays.nomPays","tmedecin.author","tmedecin.created_at","tmedecin.updated_at")
        ->selectRaw('TIMESTAMPDIFF(YEAR, datenaissance_medecin, CURDATE()) as age_medecin')
        ->where('tmedecin.id', $id)->get();

        
        return response()->json(['data'  =>  $data]);

    }

   

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $connected)
    {
        //
        $data = tmedecin::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');

        // $data = tmedecin::where("id", $id)->delete();

    }

     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    function RestoreDatatmedecin($id, $connected)
    {
        //
        $data = tmedecin::where('id',$id)->update([
            'statut'                =>  0,
            'id_user_delete'        =>  $connected,
        ]);
        return $this->msgJson('Restauration des données avec succès!!!');

    }





}
