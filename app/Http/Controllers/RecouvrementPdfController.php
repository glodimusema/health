<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\{vDetailVente};
use App\Models\vRecouvrement;
use App\Models\vEntreprise;
use App\Traits\{GlobalMethod,Slug};
use DB;

class RecouvrementPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_recouvrement_data(Request $request)
    {

        if ($request->get('observation')) 
        {
            $observation = $request->get('observation');
            $html = $this->getInfoFactureTug($observation);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoFactureTug($observation)
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
                    <title>FicheRecouvrement</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csAE0FCAA5 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csEA03B9BF {color:#A0522D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs4376205 {color:#A0522D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs8384F652 {color:#FFFFFF;background-color:#FFC080;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs488EAAEC {color:#FFFFFF;background-color:#FFC080;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:898px;height:408px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:227px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:112px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:79px;"></td>
                        <td style="height:0px;width:77px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:72px;"></td>
                        <td style="height:0px;width:168px;"></td>
                        <td style="height:0px;width:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
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
                        <td style="width:0px;height:10px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:29px;"></td>
                        <td></td>
                        <td class="csEA03B9BF" colspan="2" style="width:234px;height:29px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Cuisine&nbsp;propre&nbsp;pour&nbsp;Tous</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs4376205" colspan="5" style="width:315px;height:29px;line-height:28px;text-align:left;vertical-align:top;"><nobr>AFRICA&nbsp;MOTO&nbsp;RDC&nbsp;SARL</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csAE0FCAA5" colspan="5" style="width:343px;height:35px;line-height:28px;text-align:left;vertical-align:top;"><nobr>FICHE&nbsp;DE&nbsp;RECOUVREMENT</nobr></td>
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
                        <td class="cs8384F652" style="width:225px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>NOMS&nbsp;DES&nbsp;CLIENTS</nobr></td>
                        <td class="cs488EAAEC" colspan="3" style="width:137px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;CLIENT</nobr></td>
                        <td class="cs488EAAEC" colspan="2" style="width:112px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>TELEPHONE</nobr></td>
                        <td class="cs488EAAEC" colspan="3" style="width:134px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>DERNIER&nbsp;ACHAT</nobr></td>
                        <td class="cs488EAAEC" colspan="2" style="width:90px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>NBR.&nbsp;JOURS</nobr></td>
                        <td class="cs488EAAEC" colspan="2" style="width:183px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>OBSERVATION</nobr></td>
                    </tr>
                    ';

                        $output .= $this->showDetail($observation); 

                        $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:150px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csA803F7DA" colspan="10" style="width:628px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>34,&nbsp;Kyeshero,&nbsp;C/&nbsp;Goma,&nbsp;Nord-Kivu,&nbsp;RD.&nbsp;Congo,&nbsp;T&#233;l:&nbsp;(243)&nbsp;992&nbsp;557&nbsp;354,&nbsp;(+243)&nbsp;824&nbsp;437&nbsp;790,&nbsp;Site&nbsp;web:www.africamoto.org,</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csA803F7DA" colspan="10" style="width:628px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;info@africamoto.net,&nbsp;Id.&nbsp;Nat:5-83-N58274C,&nbsp;NumImpot:&nbsp;A2032988E</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>';            
               

          


        return $output;

    }



    


    function showDetail($observation)
    {
        $data=vRecouvrement::select(['id','noms','contact','mail','refAvenue','refCategieClient','Categorie','photo','slug','author','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','idVenteMax','dateVente','NombreJour','Observation'])
        ->Where('Observation',$observation) 
        ->get();

        $output='';

        foreach ($data as $row) 
        {
           $output .=' <tr style="vertical-align:top;">
           <td style="width:0px;height:24px;"></td>
           <td></td>
           <td class="cs22DF2452" style="width:225px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->noms.'</nobr></td>
           <td class="cs6E02D7D2" colspan="3" style="width:137px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->Categorie.'</nobr></td>
           <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->contact.'</nobr></td>
           <td class="cs6E02D7D2" colspan="3" style="width:134px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->dateVente.'</nobr></td>
           <td class="cs6E02D7D2" colspan="2" style="width:90px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->NombreJour.'</nobr></td>
           <td class="cs6E02D7D2" colspan="2" style="width:183px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$row->Observation.'</nobr></td>
       </tr>';

          
        }

        return $output;

    }
    

    
}
