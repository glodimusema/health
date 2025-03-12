<?php
namespace App\Http\Controllers\Pharmacie;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_FicheStockServiceController extends Controller
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



function pdf_fiche_stock_produit_service(Request $request)
{

    if ($request->get('date1') && $request->get('date2')&& $request->get('refService')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refService = $request->get('refService');
        
        $html = $this->getInfoFicheStockService($date1,$date2,$refService);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoFicheStockService($date1,$date2,$refService)
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
            $totalVente=0; 
            $totalSortie=0;  
            $nom_service='';
            // 

            $data3 = DB::table('tmed_detail_sortie')
            ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
            ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
            ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')
            ->select(DB::raw('ROUND(SUM(qteSortie*puSortie),0) as TotalFacture'))
            ->where([
                ['tmed_entete_sortie.dateSortie','>=', $date1],
                ['tmed_entete_sortie.dateSortie','<=', $date2],
                ['tmed_entete_sortie.refService','=', $refService]
            ])               
            ->get();

            foreach ($data3 as $row2) 
            {                                
               $totalSortie=$row2->TotalFacture;                           
            }


            $data44 = DB::table('tservice_hopital')
            ->select("tservice_hopital.id","tservice_hopital.nom_service","tservice_hopital.created_at")
            ->where([
                ['tservice_hopital.id','=', $refService]
            ])               
            ->get();

            foreach ($data44 as $row44) 
            {                                
               $nom_service=$row44->nom_service;                           
            }

    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>FicheStock</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs1B222893 {color:#000000;background-color:#D6E5F4;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs6F7E55AC {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE0D816CD {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs8F59FFB2 {color:#000000;background-color:#F5F5F5;border-left:#004000 1px solid;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csF3AA49E4 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csE78F4A6 {color:#000000;background-color:#F5F5F5;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs4B928201 {color:#000000;background-color:#FFFFFF;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .cs2C96DE68 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:italic; padding-left:2px;}
                    .csE71035DC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csAB3AA82A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csC73F4F41 {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                    .csD149F8AB {color:#000000;background-color:transparent;border-left-style: none;border-top:#004000 1px solid;border-right:#004000 1px solid;border-bottom:#004000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:958px;height:352px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:4px;"></td>
                    <td style="height:0px;width:163px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:59px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:22px;"></td>
                    <td style="height:0px;width:88px;"></td>
                    <td style="height:0px;width:77px;"></td>
                    <td style="height:0px;width:89px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:86px;"></td>
                    <td style="height:0px;width:36px;"></td>
                    <td style="height:0px;width:132px;"></td>
                    <td style="height:0px;width:2px;"></td>
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
                    <td style="width:0px;height:3px;"></td>
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
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="10" rowspan="2" style="width:690px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                        <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                    </td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csCE72709D" colspan="10" style="width:690px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="10" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="10" rowspan="2" style="width:690px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:14px;"></td>
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
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:34px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs1B222893" colspan="6" style="width:437px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE&nbsp;DE&nbsp;STOCK</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:7px;"></td>
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
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csE71035DC" colspan="10" style="width:676px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SERVICE :</nobr></td>
                    <td class="csAB3AA82A" colspan="5" style="width:273px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$nom_service.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SI</nobr></td>
                    <td class="csF3AA49E4" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ENTREE</nobr></td>
                    <td class="csC73F4F41" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="csF3AA49E4" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SORTIE</nobr></td>
                    <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SF</nobr></td>
                    <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU(USD)</nobr></td>
                    <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT(USD)</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs2C96DE68" colspan="15" style="width:948px;height:20px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$date1.'</nobr></td>
                </tr>
                ';
                                                                
                   $output .= $this->showCategorieFicheStockService($date1,$date2,$refService); 
                                                                
                 $output.='
            </table>
            </body>
            </html>

            '; 

    return $output;

}  


function showCategorieFicheStockService($date1,$date2,$refService)
{
    $data = DB::table('tconf_categoriemedicament')
    ->select("tconf_categoriemedicament.id","tconf_categoriemedicament.nom_categoriemedicament",
    "tconf_categoriemedicament.created_at")
    ->orderBy("tconf_categoriemedicament.nom_categoriemedicament", "asc")
    ->get();
    
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csE0D816CD" colspan="15" style="width:948px;height:22px;line-height:17px;text-align:center;vertical-align:middle;">'.$row->nom_categoriemedicament.'</td>
            </tr>
            ';
                                                    
                $output .= $this->showDetailFicheStock($date1,$date2,$row->id,$refService);                                                     
                $output.='
        ';      
    }

    return $output;

}


function showDetailFicheStock($date1,$date2,$refCategorie,$refService)
{
    $data1 = DB::table('tconf_medicament')           
    ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')        
    ->select("tconf_medicament.id","nom_medicament","refcategoriemedicament","pu_medicament","forme","qtetot",
    "nom_categoriemedicament","tconf_medicament.created_at","stock_alerte","tconf_medicament.author")
    ->where([
        ['tconf_medicament.refcategoriemedicament','=', $refCategorie]
    ])
    ->orderBy("tconf_medicament.nom_medicament", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $totalSI=0;        
        $totalEntree=0;
        $totalSortie=0;  
        $totalVente=0;  
        $totalG=0;              
        $totalSF=0;
        $totalPT=0;
        $totalPU=0; 
        $ventess=0;
        $entreess=0;
        $sortiess=0;
        $puVente=0; 
        $TGSortie=0; 
        //
        $data2 = DB::table('tmed_detail_sortie')
        ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalEntree'))
        ->where([               
            ['tmed_entete_sortie.dateSortie','<', $date1],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_sortie.refService','=', $refService]
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $totalEntree=$row2->totalEntree;                           
        }

        $data3 = DB::table('tmed_detail_usageservice')
        //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
        ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select(DB::raw('IFNULL(ROUND(SUM(qte_usage),0),0) as totalSortie'))
        ->where([               
            ['tmed_entete_usageservice.date_usage','<', $date1],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_usageservice.refService','=', $refService]
        ])->get(); 
        
        foreach ($data3 as $row3) 
        {                                
           $totalVente=$row3->totalSortie;                           
        }            
       

        $data12 = DB::table('tmed_detail_usageservice')
        //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
        ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select(DB::raw('IFNULL(ROUND(SUM(qte_usage),0),0) as totalSortie'))
        ->where([               
            ['tmed_entete_usageservice.date_usage','<', $date1],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_usageservice.refService','=', $refService]
        ])->get(); 
        
        foreach ($data12 as $row3) 
        {                                
           $totalSortie=$row3->totalSortie;                           
        }            


        $data4 =   DB::select(
            'select (IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SI from tconf_medicament  
             where (tconf_medicament.id = :idPro)',
             ['idPro' => $row1->id,'quanteEntree' => $totalEntree,'quanteSortie'=>$totalSortie]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalSI=$row4->SI;                           
         }

         $data5 = DB::table('tmed_detail_usageservice')
         //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
         ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
         ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
         ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
         ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
         ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
         ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select(DB::raw('IFNULL(ROUND(SUM(qte_usage),0),0) as totalSortie'))
        ->where([               
            ['tmed_entete_usageservice.date_usage','>=', $date1],
            ['tmed_entete_usageservice.date_usage','<=', $date2],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_usageservice.refService','=', $refService]
        ])->get(); 
        
        foreach ($data5 as $row5) 
        {                                
           $ventess=$row5->totalSortie;                           
        }

        $data13 = DB::table('tmed_detail_usageservice')
        //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
        ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
       ->select(DB::raw('IFNULL(ROUND(SUM(qte_usage),0),0) as totalSortie'))
        ->where([               
            ['tmed_entete_usageservice.date_usage','>=', $date1],
            ['tmed_entete_usageservice.date_usage','<=', $date2],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_usageservice.refService','=', $refService]
        ])->get(); 
        
        foreach ($data13 as $row13) 
        {                                
            $sortiess=$row13->totalSortie;                           
        }


        $data6 = DB::table('tmed_detail_sortie')
        ->join('tconf_detailmedicament','tconf_detailmedicament.id','=','tmed_detail_sortie.refDetailMed')
        ->join('tconf_medicament','tconf_medicament.id','=','tconf_detailmedicament.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_sortie','tmed_entete_sortie.id','=','tmed_detail_sortie.refEnteteSortie')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_sortie.refService')

        ->select(DB::raw('IFNULL(ROUND(SUM(qteSortie),0),0) as totalEntree'))
        ->where([
            ['tmed_entete_sortie.dateSortie','>=', $date1],
            ['tmed_entete_sortie.dateSortie','<=', $date2],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_sortie.refService','=', $refService]
        ])
        ->get();        
        foreach ($data6 as $row6) 
        {                                
           $entreess=$row6->totalEntree;                           
        }

        $data7 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0)) as totalG from tconf_medicament  
             where (tconf_medicament.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$entreess]
        );         
        foreach ($data7 as $row7) 
        {                                
           $totalG=$row7->totalG;                           
        }

        $data8 =   DB::select(
            'select (IFNULL(ROUND(:SI,0),0) + IFNULL(ROUND(:quanteEntree,0),0) - IFNULL(ROUND(:quanteSortie,0),0)) as SF from tconf_medicament  
             where (tconf_medicament.id = :idPro)',
             ['idPro' => $row1->id,'SI' => $totalSI,'quanteEntree'=>$entreess,'quanteSortie'=>$sortiess]
        );         
        foreach ($data8 as $row8) 
        {                                
           $totalSF=$row8->SF;                           
        }
  
        $data9 = DB::table('tmed_detail_usageservice')
        //tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
        ->join('tconf_medicament','tconf_medicament.id','=','tmed_detail_usageservice.refmedicament')
        ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
        ->join('tmed_entete_usageservice','tmed_entete_usageservice.id','=','tmed_detail_usageservice.refEnteteVente')
        ->join('tsalle','tsalle.id','=','tmed_entete_usageservice.refSalle')
        ->join('tservice_hopital','tservice_hopital.id','=','tmed_entete_usageservice.refService')
        ->join('tmouvement','tmouvement.id','=','tmed_entete_usageservice.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->select(DB::raw('IFNULL(ROUND(SUM(qte_usage*pu_usage),0),0) as PTVente'))
        ->where([               
            ['tmed_entete_usageservice.date_usage','>=', $date1],
            ['tmed_entete_usageservice.date_usage','<=', $date2],
            ['tconf_medicament.id','=', $row1->id],
            ['tmed_entete_usageservice.refService','=', $refService]
        ])->get(); 
        
        foreach ($data9 as $row9) 
        {                                
           $totalPT=$row9->PTVente;                           
        }
        
        $data10 =   DB::select(
            'select ((IFNULL(ROUND(:PTVente,0),0)) / (IFNULL(ROUND(:quantiteVente,0),0))) as PU from tconf_medicament  
             where tconf_medicament.id = :idPro',
             ['PTVente'=>$totalPT,'quantiteVente'=>$ventess,'idPro' => $row1->id]
        );         
        foreach ($data10 as $row10) 
        { 
           $puVente=$row10->PU;                         
        }

        $data14 =   DB::select(
            'select (IFNULL(ROUND(:quanteSortie,0),0) + IFNULL(ROUND(:quanteVente,0),0)) as TGSortie from tconf_medicament  
             where (tconf_medicament.id = :idPro)',
             ['idPro' => $row1->id,'quanteVente'=>$ventess,'quanteSortie'=>$sortiess]
        );         
        foreach ($data14 as $row14) 
        { 
            $TGSortie=$row14->TGSortie;                         
        }

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8F59FFB2" colspan="2" style="width:165px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row1->nom_medicament.'</td>
                <td class="cs6F7E55AC" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSI.'</td>
                <td class="csE78F4A6" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$entreess.'</td>
                <td class="csD149F8AB" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalG.'</td>
                <td class="csE78F4A6" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$sortiess.'</td>
                <td class="cs4B928201" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalSF.'</td>
                <td class="cs4B928201" colspan="3" style="width:139px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$puVente.'</td>
                <td class="cs6F7E55AC" colspan="2" style="width:133px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPT.'$</td>
            </tr>
        ';     
    }

    return $output;

}

    

    
}
