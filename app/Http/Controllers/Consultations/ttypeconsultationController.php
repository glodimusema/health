<?php

namespace App\Http\Controllers\Consultations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Consultations\{ttypeconsultation};
use App\Traits\{GlobalMethod,Slug};
use DB;

use App\User;
use App\Message;

class ttypeconsultationController extends Controller
{
    use GlobalMethod;
    use Slug;
    public function index(Request $request)
    {
        //
        
        if (!is_null($request->get('query'))) {
            # code...
            $query = $this->Gquery($request);
            $data = DB::table('ttypeconsultation')->select("ttypeconsultation.id","ttypeconsultation.designation","ttypeconsultation.created_at","PrixCons")->where('designation', 'like', '%'.$query.'%')
            ->orWhere('designation', 'like', '%'.$query.'%')
            ->orderBy("id", "desc")
            ->paginate(10);

            return response()->json([
                'data'  => $data,
            ]);
           

        }
        else{
            $data = DB::table('ttypeconsultation')->select("ttypeconsultation.id","ttypeconsultation.designation","ttypeconsultation.created_at","PrixCons")
            ->orderBy("id", "desc")
            ->paginate(10);
            return response()->json([
                'data'  => $data,
            ]);
        }
    }


    function fetch_ttypeconsultation_2()
    {
        $data = DB::table('ttypeconsultation')->select("ttypeconsultation.id","ttypeconsultation.designation","ttypeconsultation.created_at","PrixCons")
        ->orderBy("id", "desc")
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
        //
        if ($request->id !='') 
        {
            # PrixCons...
            // update 
            $data = ttypeconsultation::where("id", $request->id)->update([
                'designation' =>  $request->designation,
                'PrixCons' =>  $request->PrixCons
            ]);
            return $this->msgJson('Modification avec succès!!!');

        }
        else
        {
            // insertion 
            $data = ttypeconsultation::create([

                'designation' =>  $request->designation,
                'PrixCons' =>  $request->PrixCons
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
        $data = ttypeconsultation::where('id', $id)->get();
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
        $data = ttypeconsultation::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

    public function destroyMessage($id)
    {
        //
        $data = Message::where('id', $id)->delete();
        return $this->msgJson('Suppression avec succès!!!');
    }

}
