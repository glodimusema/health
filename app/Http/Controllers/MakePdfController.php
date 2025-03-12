<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\{tclient};
use App\Traits\{GlobalMethod,Slug};
use DB;

class MakePdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_client_data(Request $request)
    {

        if ($request->get('slug')) 
        {
            $slug = $request->get('slug');
            $html = $this->getInfoAgentTug($slug);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoAgentTug($slug)
    {
        $nomProjet = "AFRICA MOTO";
        $idProjet = "1";
        $data=DB::table("tclient")
                ->join('avenues','avenues.id','=','tclient.refAvenue')
                ->join('quartiers','quartiers.id','=','avenues.idQuartier')
                ->join('communes','communes.id','=','quartiers.idCommune')
                ->join('villes','villes.id','=','communes.idVille')
                ->join('provinces','provinces.id','=','villes.idProvince')
                ->join('pays','pays.id','=','provinces.idPays')
        
                ->join('tcategorieclient','tcategorieclient.id','=','tclient.refCategieClient')
        
                ->select("tclient.id", "tclient.noms","tclient.contact","tclient.mail","tclient.photo","tclient.slug",
                     'tclient.refAvenue','tcategorieclient.designation as Categorie','tclient.refCategieClient',
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays','tclient.refAvenue',
                //fin localisation
                "tclient.created_at","tclient.updated_at")
                ->where("tclient.slug", $slug)
                ->get();

                $output='
                <div style="border:1px solid black;padding:0px;">
                <h3 align="center" style="color:blue;">REPUBLIQUE DEMOCRATIQUE DU CONGO <br/> FICHE D\'ENREGISTREMENT DES CLIENTS <br/> <span style="text-decoration:underline;">COMPANY APP SYSTEM </span></h3>
                
                <div align="center"> DETAIL DE LA FICHE DU CLIENT  '.$nomProjet.' </div>
                <br/><br/>
                <table align="center" cellpadding="7" cellspacing="0" border="1" width="98%">
                '
                ;

          

        $count=1;

      

        $output .='
            <tr style="font-weight:bold; background:#ccc;" >
                <td colspan="9">Les Cordonnées du travailleur</td>
            </tr> 
        ';

        

        $output .='
            <tr style="font-weight:bold; background:#ccc;" >
                <td colspan="1">Nom</td>
                <td colspan="1">Telephone</td>
                <td colspan="1">E-mail</td>                
            </tr> 
        ';

        $output .= $this->showAgentDetail1($slug); 

        $output .='
            <tr style="font-weight:bold; background:#ccc;" >
                <td colspan="1">Pays</td>
                <td colspan="1">Province</td>
                <td colspan="1">Ville</td>
                <td colspan="1">Commune</td>
                <td colspan="1">Quartier</td>
                <td colspan="1">Avenue</td>               
            </tr> 
        ';

        $output .= $this->showAgentDetail_4($slug); 

        $output.='</table>';

        $output .='
        <p>
        <br />
        </p>
            <p style="position:relative;left:500px;">

              Fait à Goma le '.date('Y-m-d').'
            </p>
        <br /><br /></div>
        ';
       
        return $output; 

    }


    function showAgentDetail1($slug)
    {
        $data=DB::table("tclient")
                ->join('avenues','avenues.id','=','tclient.refAvenue')
                ->join('quartiers','quartiers.id','=','avenues.idQuartier')
                ->join('communes','communes.id','=','quartiers.idCommune')
                ->join('villes','villes.id','=','communes.idVille')
                ->join('provinces','provinces.id','=','villes.idProvince')
                ->join('pays','pays.id','=','provinces.idPays')
        
                ->join('tcategorieclient','tcategorieclient.id','=','tclient.refCategieClient')
        
                ->select("tclient.id", "tclient.noms","tclient.contact","tclient.mail","tclient.photo","tclient.slug",
                     'tclient.refAvenue','tcategorieclient.designation as Categorie','tclient.refCategieClient',
                //localisation
                'avenues.idQuartier','avenues.nomAvenue',
                'quartiers.idCommune','quartiers.nomQuartier',
                'communes.idVille','communes.nomCommune',
                'villes.nomVille','villes.idProvince',
                'provinces.nomProvince','provinces.idPays','pays.nomPays','tclient.refAvenue',
                //fin localisation
                "tclient.created_at","tclient.updated_at")
        ->where("tclient.slug", $slug)
        ->get();

        $output='';

        foreach ($data as $row) 
        {
            $output .='
                <tr>
                    <td colspan="1">'.$row->noms.' </td>
                    <td colspan="1">'.$row->contact.'</td>
                    <td colspan="1">'.$row->mail.'</td>                    
                </tr> 
            ';
           
        }

        return $output;

    }

    function showAgentDetail_4($slug)
    {
        $data=DB::table("tclient")
        ->join('avenues','avenues.id','=','tclient.refAvenue')
        ->join('quartiers','quartiers.id','=','avenues.idQuartier')
        ->join('communes','communes.id','=','quartiers.idCommune')
        ->join('villes','villes.id','=','communes.idVille')
        ->join('provinces','provinces.id','=','villes.idProvince')
        ->join('pays','pays.id','=','provinces.idPays')

        ->join('tcategorieclient','tcategorieclient.id','=','tclient.refCategieClient')

        ->select("tclient.id", "tclient.noms","tclient.contact","tclient.mail","tclient.photo","tclient.slug",
             'tclient.refAvenue','tcategorieclient.designation as Categorie','tclient.refCategieClient',
        //localisation
        'avenues.idQuartier','avenues.nomAvenue',
        'quartiers.idCommune','quartiers.nomQuartier',
        'communes.idVille','communes.nomCommune',
        'villes.nomVille','villes.idProvince',
        'provinces.nomProvince','provinces.idPays','pays.nomPays','tclient.refAvenue',
        //fin localisation
        "tclient.created_at","tclient.updated_at")
        ->where("tclient.slug", $slug)
        ->get();

        $output='';

        foreach ($data as $row) 
        {
           

            $output .='
                <tr>
                    <td colspan="1">'.$row->nomPays.'</td>
                    <td colspan="1">'.$row->nomProvince.'</td>
                    <td colspan="1">'.$row->nomVille.'</td>
                    <td colspan="1">'.$row->nomCommune.'</td>
                    <td colspan="1">'.$row->nomQuartier.'</td>
                    <td colspan="1">'.$row->nomAvenue.'</td>                   
                </tr> 
            ';


           
        }

        return $output;

    }

     
   


     








    



    
}
