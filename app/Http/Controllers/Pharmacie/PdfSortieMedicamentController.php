<?php

namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;
class PdfSortieMedicamentController extends Controller
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

    
//==================== RAPPORT JOURNALIER DES SORTIES =================================

public function fetch_rapport_detailvente_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente($date1, $date2);       
        $html .='<script>window.print()</script>';
        echo($html);             

    } else {
        // code...
    }
    
    
}


function printRapportDetailVente($date1, $date2)
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


         $totalFact=0;
                 
         //
         $data2 =  DB::table('tmed_detail_sortie')
         ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
         ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
 
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:8px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:19px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
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
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailVente($date1,$date2); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente($date1, $date2)
{
    $data = DB::table('tmed_detail_sortie')
    ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
    ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
    ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
    ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
    ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
    ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
    'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
    "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
    'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
    ->selectRaw('(qteSortie*puSortie) as prixTotal')
    ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
    ->where([
        ['dateSortie','>=', $date1],
        ['dateSortie','<=', $date2]
    ])
    ->orderBy("tmed_detail_sortie.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->nom_service.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_medicament.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}
//==================== RAPPORT DETAIL FACTURE SELON LES ORGANISATIONS =======================================

public function fetch_rapport_detailvente_date_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refService = $request->get('refService');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Service($date1, $date2,$refService);       
        $html .='<script>window.print()</script>';
        echo($html);           

    } else {
        // code...
    }  
    
}



function printRapportDetailVente_Service($date1, $date2,$refService)
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


         $totalFact=0;
                 
         //
         $data2 = DB::table('tmed_detail_sortie')
         ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
         ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
        
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;                           
         }

         $nom_departement='';

         $data3=DB::table('tmed_detail_sortie')
         ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
         ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
         ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
         'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
         "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
         'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_departement=$row->nom_service;              
        }


          

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.01-822-N35172T</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:8px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;SORTIES</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:19px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_departement.'</td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;SORTIE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Service($date1,$date2,$refService); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente_Service($date1,$date2,$refService)
{
        $data = DB::table('tmed_detail_sortie')
        ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
        ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','dateexpiration',
        'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
        "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
        'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
        ->selectRaw('(qteSortie*puSortie) as prixTotal')
        ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
        ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refService','=', $refService]
        ])
        ->orderBy("tmed_detail_sortie.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->nom_service.'</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
                    <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_medicament.'</td>
                    <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
                    <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'</td>
                    <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                </tr>
            ';
           
   
    }

    return $output;

}

//==================== RAPPORT DETAIL SORTIE BY MEDICAMENT =======================================

public function fetch_rapport_detailvente_date_medicament(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refmedicament')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refmedicament = $request->get('refmedicament');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailVente_Medicament($date1, $date2,$refmedicament);       
        $html .='<script>window.print()</script>';
        echo($html);           

    } else {
        // code...
    }
    
}


function printRapportDetailVente_Medicament($date1, $date2,$refmedicament)
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


         $totalFact=0;
                 
         //
         $data2 = DB::table('tmed_detail_sortie')
         ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
         ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')       
         ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refmedicament','=', $refmedicament],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

         $nom_medicament='';
         $nom_categoriemedicament='';

         $data3=DB::table('tmed_detail_sortie')
         ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
         ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
         ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','refmedicament','dateexpiration',
         'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
         "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
         'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
         ->selectRaw('(qteSortie*puSortie) as prixTotal')
         ->selectRaw('CONCAT("S",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture') 
         ->where([
            ['dateSortie','>=', $date1],
            ['dateSortie','<=', $date2],
            ['refmedicament','=', $refmedicament],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_medicament=$row->nom_medicament;
            $nom_categoriemedicament=$row->nom_categoriemedicament;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.01-822-N35172T</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:8px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;VENTES</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:19px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_medicament.' - '.$nom_categoriemedicament.'</td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;VENTE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailVente_Medicament($date1,$date2,$refmedicament); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailVente_Medicament($date1, $date2,$refmedicament)
{
    $data = DB::table('tmed_detail_sortie')
    ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
    ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
    ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
    ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
    ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
    ->select('tmed_detail_sortie.id','refEnteteSortie','refDetailMed','refmedicament','dateexpiration',
    'puSortie','qteSortie','nom_service','nom_agent','dateSortie','libelle',"nom_medicament",
    "refcategoriemedicament","pu_medicament","forme","nom_categoriemedicament",
    'tmed_detail_sortie.author','tmed_detail_sortie.created_at')
    ->selectRaw('CONCAT("F",YEAR(dateSortie),"",MONTH(dateSortie),"00",refEnteteSortie) as codeFacture')
    ->selectRaw('(qteSortie*puSortie) as prixTotal')
    ->where([
                ['dateSortie','>=', $date1],
                ['dateSortie','<=', $date2],
                ['refmedicament','=', $refmedicament]
            ])
    ->orderBy("tmed_detail_sortie.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_agent.'&nbsp;-&nbsp;'.$row->nom_service.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateSortie.'</td>
                <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_medicament.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteSortie.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puSortie.'</td>
                <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            </tr>
        ';
           
   
    }

    return $output;

}


//==================== RAPPORT JOURNALIER DES ENTREES ===========================================================================

public function fetch_rapport_detailentree_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailEntree($date1, $date2);       
        $html .='<script>window.print()</script>';
        echo($html);              

    } else {
        // code...
    }
    
    
}


function printRapportDetailEntree($date1, $date2)
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


         $totalFact=0;
                 
         //
         $data2 =  DB::table('tmed_detail_entree')
         ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
         ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
 
         ->select(DB::raw('ROUND(SUM(qteEntree*puEntree),0) as TotalFacture'))
         ->where([
            ['dateEntree','>=', $date1],
            ['dateEntree','<=', $date2]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
                           
         }

           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_Rapportdetailfacture</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:909px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:179px;"></td>
                <td style="height:0px;width:64px;"></td>
                <td style="height:0px;width:28px;"></td>
                <td style="height:0px;width:2px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:112px;"></td>
                <td style="height:0px;width:10px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
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
                <td class="cs101A94F7" colspan="3" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <!--[if lt IE 7]><img alt="" src="'.$pic2.'" style="width:175px;height:144px;filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(src="",sizingMethod="");" /><div style="display:none"><![endif]--><img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /><!--[if lt IE 7]></div><![endif]--></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="8" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="8" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="8" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:8px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;ENTREES</nobr></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:19px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
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
                <td style="width:0px;height:9px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FOURNISSEUR</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;ENTREE</nobr></td>
                <td class="cs9FE9304F" style="width:178px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ELEMENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qte</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
            </tr>
            ';

            $output .= $this->showDetailEntree($date1,$date2); 

            $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs49AA1D99" colspan="5" style="width:155px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.' $</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showDetailEntree($date1, $date2)
{
    $data = DB::table('tmed_detail_entree')
    ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_entree.refmedicament')
    ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
    ->join('tmed_entete_entree','tmed_entete_entree.id','=','tmed_detail_entree.refEnteteEntree')
    ->join('tfournisseur','tfournisseur.id','=','tmed_entete_entree.refFournisseur')
    ->select('tmed_detail_entree.id','refEnteteEntree','refmedicament','dateExpiration',
    'numeroLot','puEntree','qteEntree','noms','contact','mail','adresse','dateEntree',
    'libelle',"nom_medicament","refcategoriemedicament","pu_medicament","forme",
    "nom_categoriemedicament",'tmed_detail_entree.author','tmed_detail_entree.created_at')
    ->selectRaw('(qteEntree*puEntree) as prixTotal')
    ->selectRaw('CONCAT("BE",YEAR(dateEntree),"",MONTH(dateEntree),"00",refEnteteEntree) as codeFacture')
    ->where([
        ['dateEntree','>=', $date1],
        ['dateEntree','<=', $date2]
    ])
    ->orderBy("tmed_detail_entree.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    { 
        $output .='<tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateEntree.'</td>
        <td class="cs6E02D7D2" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_medicament.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:91px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qteEntree.'</td>
        <td class="cs6E02D7D2" colspan="3" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->puEntree.'$</td>
        <td class="cs6C28398D" colspan="2" style="width:122px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
    </tr>';      
   
    }

    return $output;

}














}
