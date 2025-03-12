<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\{vDetailEntree};
use App\Models\vEnteteEntree;
use App\Models\vEntreprise;
use App\Traits\{GlobalMethod,Slug};
use DB;

class BonEntreePdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_bonentree_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoFactureTug($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoFactureTug($id)
    {

                $numEntree='';
                $noms='';
                $telephone='';
                $adresse='';
                $dateEntree='';
                $dateExecution='';
                $Executant='';
                $TotalEntree='';
                

                $data = vEnteteEntree::select(['id','refFournisseur','noms','contact','mail','adresse','dateEntree','author','created_at','TotalEntree'])
                ->Where('id',$id) 
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $numEntree=$row->id;              
                    $noms=$row->noms; 
                    $telephone=$row->contact; 
                    $adresse=$row->adresse; 
                    $dateEntree=$row->dateEntree;                    
                    $TotalEntree=$row->TotalEntree;
                
                }


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

                $data1 = vEntreprise::select(['id','nomSecteur','nomForme','name','email_user','telephone','avatar','idProvince', 'ceo','nom','email','adresse','tel1','tel2','siteweb','facebook','twitter','linkedin','idnational','rccm','numImpot','logo','id_user_insert','id_user_update', 'id_user_delete', 'busnessName','codeBusness','idSecteur','contactNumCode','anneeFondation','numCaisseSocial','numInpp','idForme','slug','numPersonneJuridique','statut','nomPays','nomProvince','idPays','created_at','updated_at'])
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
                    $rccmEse=$row->rccm;
                
                }

        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>rpt_Facture</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csA7C33414 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csEA03B9BF {color:#A0522D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs4376205 {color:#A0522D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs8384F652 {color:#FFFFFF;background-color:#FFC080;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs488EAAEC {color:#FFFFFF;background-color:#FFC080;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:642px;height:628px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:236px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:88px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:29px;"></td>
                        <td></td>
                        <td class="csEA03B9BF" style="width:234px;height:29px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Cuisine&nbsp;propre&nbsp;pour&nbsp;Tous</nobr></td>
                        <td></td>
                        <td></td>
                        <td class="cs4376205" colspan="7" style="width:316px;height:29px;line-height:28px;text-align:left;vertical-align:top;"><nobr>AFRICA&nbsp;MOTO&nbsp;RDC&nbsp;SARL</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:29px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="3" style="width:76px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Fournisseur</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="3" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="2" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$noms.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="3" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="2" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$adresse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="3" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>T&#233;l&#233;phone&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="2" style="width:200px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$telephone.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csA7C33414" colspan="2" style="width:262px;height:35px;line-height:28px;text-align:left;vertical-align:top;"><nobr>APPROVISIONNEMENT&nbsp;N&#176;&nbsp;000&nbsp;'.$numEntree.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csFBB219FE" colspan="2" style="width:262px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:&nbsp;'.$dateEntree.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8384F652" colspan="3" style="width:302px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Designation&nbsp;des&nbsp;produits&nbsp;ou&nbsp;prestations</nobr></td>
                        <td class="cs488EAAEC" colspan="3" style="width:65px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Quantit&#233;</nobr></td>
                        <td class="cs488EAAEC" colspan="3" style="width:137px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Prix&nbsp;Unitaire&nbsp;USD</nobr></td>
                        <td class="cs488EAAEC" style="width:113px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;USD</nobr></td>
                        <td></td>
                    </tr>
                    ';

                        $output .= $this->showDetail($id); 

                        $output.='<tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs8384F652" colspan="3" style="width:136px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;USD</nobr></td>
                        <td class="cs36E0C1B8" style="width:113px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$TotalEntree.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:30px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="4" style="width:337px;height:22px;line-height:18px;text-align:left;vertical-align:top;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="4" style="width:337px;height:22px;line-height:18px;text-align:left;vertical-align:top;"></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="4" style="width:337px;height:22px;line-height:18px;text-align:left;vertical-align:top;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:117px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csA803F7DA" colspan="11" style="width:628px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$adresseEse.','.$Tel1Ese.','.$Tel2Ese.',&nbsp;Site&nbsp;web:'.$siteEse.',</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csA803F7DA" colspan="11" style="width:628px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp'.$emailEse.',&nbsp;Id.&nbsp;Nat:'.$idNatEse.',&nbsp;NumImpot:&nbsp;'.$numImpotEse.'</nobr></td>
                    </tr>
                </table>
                </body>
                </html>';            
               

          


        return $output;

    }



    


    function showDetail($id)
    {
        $data = vDetailEntree::select(['id','refEnteteEntree','refProduit','designationProduit','pu','unite','refCategorie','CategorieProduit','puEntree','qteEntree','author','refFournisseur','noms','contact','mail','adresse','dateEntree','created_at','TotalEntree','PT'])
        ->Where('refEnteteEntree',$id) 
        ->get();

        $output='';

        foreach ($data as $row) 
        {
           $output .=' <tr style="vertical-align:top;">
           <td style="width:0px;height:24px;"></td>
           <td></td>
           <td class="cs22DF2452" colspan="3" style="width:302px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->designationProduit.'</nobr></td>
           <td class="cs6E02D7D2" colspan="3" style="width:65px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->qteEntree.'</nobr></td>
           <td class="cs6E02D7D2" colspan="3" style="width:137px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->puEntree.'</nobr></td>
           <td class="cs6E02D7D2" style="width:113px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->PT.'</nobr></td>
           <td></td>
       </tr>';

          
        }

        return $output;

    }
    

    
}
