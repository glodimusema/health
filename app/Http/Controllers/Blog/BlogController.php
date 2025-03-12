<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Blog\{Blog};
use App\Traits\GlobalMethod;
use DB;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod;
    public function index(Request $request)
    {
        //
         $data = DB::table("blogs")
        ->select("blogs.id", "blogs.titre","blogs.description","blogs.photo","blogs.etat", "blogs.created_at");

        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);

            $data->where('blogs.titre', 'like', '%'.$query.'%')
            ->orWhere('blogs.description', 'like', '%'.$query.'%')
            ->orderBy("blogs.id", "desc");

            return $this->apiData($data->paginate(10));
           

        }
        return $this->apiData($data->paginate(10));
    }

    function checkEtat_blog($id, $etat)
    {
        if ($id !='' && $etat !='') {
            // code...
            if ($etat == 1) {
                // desactivation
                Blog::where('id',$id)->update([
                    'etat'         =>  0
                ]);
                return $this->msgJson('La donnée a été desactivée avec succès');

            } else {
                // activation
                Blog::where('id',$id)->update([
                    'etat'         =>  1
                ]);
                return $this->msgJson('La donnée a été activée avec succès');
            }
            
        }
    }


    function editPhoto(Request $request)
    {
      if (!is_null($request->image)) 
      {
        $formData = json_decode($_POST['data']);
        $imageName = time().'.'.$request->image->getClientOriginalExtension();

        // $request->image->move(storage_path('app/public/article/'), $imageName);
        $request->image->move(public_path('/article'), $imageName);

        Site::where('id',$formData->agentId)->update(['logo' => $imageName]);
        return $this->msgJson('Fichier ajouté avec succès');

      }
       
    }

    function insertData(Request $request)
    {

        if (!is_null($request->image)) 
        {
            $formData = json_decode($_POST['data']);
            $imageName = time().'.'.$request->image->getClientOriginalExtension();

            $request->image->move(public_path('/article'), $imageName);
            Blog::create([
                'titre'         =>  $formData->titre,
                'description'   =>  $formData->description,
                'photo'         =>  $imageName
            ]);

            return $this->msgJson('Information ajoutée avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
            Blog::create([
                'titre'         =>  $formData->titre,
                'etat'          =>  $formData->etat,
                'description'   =>  $formData->description,
                'photo'         =>  "vuetify.png"
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

            $request->image->move(public_path('/article'), $imageName);
           
            Blog::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description),
                'photo'         =>  $imageName
            ]);
            return $this->msgJson('Modifcation avec succès');

        }
        else{

            $formData = json_decode($_POST['data']);
           

            Blog::where('id',$formData->id)->update([
                'titre'         =>  $formData->titre,
                'description'   =>  htmlspecialchars($formData->description)
            ]);
            return $this->msgJson('Modifcation avec succès');

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
        $blog = Blog::where('id', $id)->get();
        $data = [];
        foreach ($blog as $row) {
            // code...
            array_push($data, array(
                'id'            =>  $row->id,
                'titre'         =>  $row->titre,
                'description'   =>  html_entity_decode($row->description),
                'photo'         =>  $row->photo
            ));
        }
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
        $data = Blog::where("id", $id)->delete();

        return response()->json(['data'  =>  "Suppression avec succès!!!"]);
    }
}
