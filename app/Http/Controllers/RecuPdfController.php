<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\vPaiementVente;
use App\Models\vEntreprise;
use App\Traits\{GlobalMethod,Slug};
use DB;

class RecuPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_recu_data(Request $request)
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

                $numFacture='';
                $noms='';
                $telephone='';
                $adresse='';
                $datePaiement='';
                $numRecu='';
                $montantPaie='';
                $total=0;
                $reste=0;
                $montantFacture=0;                

                $data = vPaiementVente::select(['id','refEnteteVente','montant','datePaie','libelle','author','refClient','dateVente','dateExecution','Executant','noms','contact','mail','refAvenue','refCategieClient','CategorieClient','photo','slug','nomAvenue','idCommune','nomQuartier','idQuartier','idVille','nomCommune','idProvince','nomVille','idPays','nomProvince','nomPays','created_at','TotalVente','TotalPaie','Reste'])
                ->Where('id',$id) 
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    //'TotalPaie','Reste'
                    $numRecu=$row->id;
                    $numFacture=$row->refEnteteVente;              
                    $noms=$row->noms; 
                    $telephone=$row->contact; 
                    $adresse=$row->nomQuartier; 
                    $datePaiement=$row->datePaie;                    
                    $montantPaie=$row->montant;
                    $total=$row->TotalPaie;
                    $reste=$row->Reste;
                    $montantFacture=$row->TotalVente;
                    $libelle=$row->libelle;
                
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
                    <title>RecuPaiement</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csB71AFD2A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:normal; font-style:normal; padding-left:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:642px;height:673px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:168px;"></td>
                        <td style="height:0px;width:68px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:171px;"></td>
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
                        <td class="csEA03B9BF" colspan="2" style="width:234px;height:29px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Cuisine&nbsp;propre&nbsp;pour&nbsp;Tous</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs4376205" colspan="5" style="width:316px;height:29px;line-height:28px;text-align:left;vertical-align:top;"><nobr>AFRICA&nbsp;MOTO&nbsp;RDC&nbsp;SARL</nobr></td>
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
                        <td></td>
                        <td class="csFBB219FE" colspan="2" style="width:76px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Client</nobr></td>
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
                        <td></td>
                        <td class="csCE72709D" colspan="2" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;:</nobr></td>
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
                        <td></td>
                        <td class="csCE72709D" colspan="2" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&nbsp;:</nobr></td>
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
                        <td></td>
                        <td class="csCE72709D" colspan="2" style="width:76px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>T&#233;l&#233;phone&nbsp;:</nobr></td>
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
                        <td class="csA7C33414" colspan="3" style="width:262px;height:35px;line-height:28px;text-align:left;vertical-align:top;"><nobr>Re&#231;u&nbsp;N&#176;&nbsp;000&nbsp;'.$numRecu.'</nobr></td>
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
                        <td class="csB71AFD2A" colspan="5" style="width:302px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;Facture&nbsp;:&nbsp;&nbsp;'.$numFacture.'</nobr></td>
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
                        <td class="csB71AFD2A" colspan="5" style="width:302px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>Montant&nbsp;Facture&nbsp;:&nbsp;'.$montantFacture.'&nbsp;$</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:37px;"></td>
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
                        <td class="cs8384F652" style="width:166px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Paiement</nobr></td>
                        <td class="cs488EAAEC" colspan="3" style="width:126px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;Pay&#233;&nbsp;USD</nobr></td>
                        <td class="cs488EAAEC" colspan="5" style="width:155px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Libellé</nobr></td>
                        <td class="cs488EAAEC" style="width:170px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>Reste&nbsp;USD</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs22DF2452" style="width:166px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$datePaiement.'</nobr></td>
                        <td class="cs6E02D7D2" colspan="3" style="width:126px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$montantPaie.'</nobr></td>
                        <td class="cs6E02D7D2" colspan="5" style="width:155px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$libelle.'</nobr></td>
                        <td class="cs6E02D7D2" style="width:170px;height:22px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>'.$reste.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:249px;"></td>
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



    


    
    

    
}
