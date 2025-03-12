<?php
namespace App\Http\Controllers\SNIS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;


class Pdf_StatExamenLaboController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    //=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================



function pdf_examen_labo_snis(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->getInfoExamenloboSNIS($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoExamenloboSNIS($date1,$date2)
{
           //Info Entreprise
           $nomEse='';
           $adresseEse='';
           $Tel1Ese='';
           $Tel2Ese='';
           $siteEse='';
           $emailEse='';
           $idNatEse='';
           $numImpotEse='';
           $rccEse='';
           $siege='';
           $busnessName='';
           $pic='';
           $pic2 = $this->displayImg("fichier", 'logo.png');
           $logo='';
   
           $data1 = DB::table('entreprise') 
           ->join('users' , 'users.id','=','entreprise.ceo')
           ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
           ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
           ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
           ->join('pays' , 'pays.id','=','provinces.idPays')
           
           ->select("entreprise.id","secteurs.nomSecteur","forme_juridiques.nomForme",
           "users.name","users.email as email_user","users.telephone","users.avatar",
           "entreprise.idProvince", "entreprise.ceo","entreprise.nom","entreprise.email",
           "entreprise.adresse","entreprise.tel1", "entreprise.tel2","entreprise.siteweb",
           "entreprise.facebook","entreprise.twitter","entreprise.linkedin",
           "entreprise.idnational","entreprise.rccm","entreprise.numImpot","entreprise.logo",
           "entreprise.id_user_insert","entreprise.id_user_update","entreprise.id_user_delete",
           "entreprise.busnessName","entreprise.codeBusness","entreprise.idSecteur",
           "entreprise.contactNumCode", "entreprise.anneeFondation", "entreprise.numCaisseSocial",
           "entreprise.numInpp","entreprise.idForme","entreprise.slug","entreprise.numPersonneJuridique",
           "entreprise.statut","pays.nomPays","provinces.nomProvince","provinces.idPays",
           "entreprise.created_at","entreprise.updated_at")
           ->get();
            $output='';
            foreach ($data1 as $row) 
            {                                
                $nomEse=$row->nom;
                $adresseEse=$row->adresse;
                $Tel1Ese=$row->tel1;
                $Tel2Ese=$row->tel2;
                $siteEse=$row->siteweb;
                $emailEse=$row->email;
                $idNatEse=$row->idnational;
                $numImpotEse=$row->numImpot;
                $busnessName=$row->busnessName;
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", $row->logo);
                $siege=$row->numPersonneJuridique;         
            }
   
               // 
            $totalExamen=0; 
            $totalPositif=0;  
            // 

            $data3 = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->select(DB::raw('ROUND(COUNT(tdetaillabo.id),0) as totalExamen'))
            ->where([
                ['tentetelabo.created_at','>=', $date1],
                ['tentetelabo.created_at','<=', $date2],
            ])               
            ->get();

            foreach ($data3 as $row3) 
            {                                
               $totalExamen=$row3->totalExamen;                           
            }


            $data4 = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->select(DB::raw('ROUND(COUNT(tdetaillabo.id),0) as totalPositif'))
            ->where([
                ['tentetelabo.created_at','>=', $date1],
                ['tentetelabo.created_at','<=', $date2],
                ['tdetaillabo.observation','=', 'POSITIF'],
            ])               
            ->get();

            foreach ($data4 as $row4) 
            {                                
               $totalPositif=$row4->totalPositif;                           
            }


    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>StatExamenLabo</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs275E312D {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs253B7FA2 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs82D98BB6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs3AF473BB {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:545px;height:170px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:189px;"></td>
                    <td style="height:0px;width:198px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:60px;"></td>
                    <td style="height:0px;width:54px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="3" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs3AF473BB" style="width:187px;height:22px;line-height:17px;text-align:left;vertical-align:top;"><nobr>&nbsp;LABORATOIRE&nbsp;(Du '.$date1.' au '.$date2.')</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                ';
                                                                                                    
                                 $output .= $this->showStatExamenLabo($date1,$date2); 
                                                                                                    
                                $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs275E312D" colspan="3" style="width:407px;height:22px;line-height:15px;text-align:center;vertical-align:top;"><nobr>TOTAL</nobr></td>
                    <td class="csAB3AA82A" style="width:59px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalExamen.'</nobr></td>
                    <td class="csAB3AA82A" style="width:53px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPositif.'</nobr></td>
                </tr>
            </table>
            </body>
            </html>


            '; 

    return $output;

}  


function showStatExamenLabo($date1,$date2)
{
    $data = DB::table('tcategorieexament')
    ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
    ->select("tcategorieexament.id","tcategorieexament.refGrandCategorie",
    "tcategorieexament.designation as designation","tgcategorieexament.designation as designationGCat")
    ->orderBy("tcategorieexament.designation", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8A513397" colspan="5" style="width:521px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$row->designation.'</td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:34px;"></td>
                <td></td>
                <td class="cs253B7FA2" colspan="3" style="width:405px;height:33px;"></td>
                <td class="cs253B7FA2" style="width:56px;height:33px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Examens</nobr><br/><nobr>r&#233;alis&#233;s</nobr></td>
                <td class="cs253B7FA2" style="width:50px;height:33px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Examens</nobr><br/><nobr>positifs</nobr></td>
            </tr>
            ';
                                                    
            $output .= $this->ShowDetailStatExamen($date1,$date2,$row->id);                                                     
            $output.='
        ';
    
    }

    return $output;

}


function ShowDetailStatExamen($date1,$date2,$refCategorie)
{
    $data1 = DB::table('texamen')
    ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
    ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
    ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
    ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
    "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
    "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube",
    "designationTube","couleurTube")
    ->where([
        ['texamen.refCatexamen','=', $refCategorie]
    ])
    ->orderBy("texamen.designation", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $Examens=0;        
        $Positifs=0;

        //

       


        $data5 = DB::table('tdetaillabo')
        ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select(DB::raw('ROUND(COUNT(tdetaillabo.id),0) as totalExamen'))
        ->where([               
            ['tentetelabo.created_at','>=', $date1],
            ['tentetelabo.created_at','<=', $date2],
            ['texamen.id','=', $row1->id]
        ])->get(); 
        
        foreach ($data5 as $row5) 
        {                                
           $Examens=$row5->totalExamen;                           
        }

        $data13 = DB::table('tdetaillabo')
        ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->select(DB::raw('ROUND(COUNT(tdetaillabo.id),0) as totalPositifs'))
        ->where([               
            ['tentetelabo.created_at','>=', $date1],
            ['tentetelabo.created_at','<=', $date2],
            ['texamen.id','=', $row1->id],
            ['tdetaillabo.observation','=', 'POSITIF'],
        ])->get(); 
        
        foreach ($data13 as $row13) 
        {                                
            $Positifs=$row13->totalPositifs;                           
        }
        
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="csE71035DC" colspan="3" style="width:407px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$row1->designation.'</td>
                <td class="cs82D98BB6" style="width:59px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$Examens.'</td>
                <td class="cs82D98BB6" style="width:53px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$Positifs.'</td>
            </tr>
        ';        
    
    }

    return $output;

}

    

    
}
