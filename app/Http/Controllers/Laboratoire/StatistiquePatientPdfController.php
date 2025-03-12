<?php

namespace App\Http\Controllers\Laboratoire;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};

use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\User;
use App\Message;

class StatistiquePatientPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;
    
//============== STATISTIQUE DES MOUVEMENTS DES PATIENTS =================================================

//pdf_statistique_type_mouvement
//pdf_statistique_patient
//StatistiquePatientPdfController

function pdf_statistique_patient(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        
        $html = $this->getInfoStatistiquePatient($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{
    }    
}



function getInfoStatistiquePatient($date1,$date2)
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
           $busnessName='';
           $rccEse='';
           $pic2 = $this->displayImg("fichier", 'logo.png');

           $data1 = DB::table('entreprise') 
           ->join('users' , 'users.id','=','entreprise.ceo')
           ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
           ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
           ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
           ->join('pays' , 'pays.id','=','provinces.idPays')
           //MALADE
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
           }
          // 
            $totalFemme=0;  
            $totalHomme=0;
            $totalData=0;
            //
            $data2 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['sexe_malade','=', 'Femme']
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalFemme=$row2->Nombre;                           
            }

            $data3 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['sexe_malade','=', 'Homme']
            ])               
            ->get();

            foreach ($data3 as $row2) 
            {                                
               $totalHomme=$row2->Nombre;                           
            }

            $data4 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2]
            ])               
            ->get();

            foreach ($data4 as $row2) 
            {                                
               $totalData=$row2->Nombre;                           
            }


    
            $output=
            '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>STATISTIQUE_PATIENT</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs1BF5E715 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs247B7E6 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs169EA1F9 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:30px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:729px;height:387px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:379px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:95px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:97px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="3" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="4" style="width:523px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:170px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:170px;height:154px;">
                        <img alt="" src="'.$pic2.'" style="width:170px;height:154px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="4" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="4" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="4" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="4" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="4" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="4" rowspan="2" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
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
                    <td style="width:0px;height:13px;"></td>
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
                    <td style="width:0px;height:40px;"></td>
                    <td></td>
                    <td class="cs169EA1F9" colspan="8" style="width:718px;height:40px;line-height:35px;text-align:center;vertical-align:middle;"><nobr>STATISTIQUE&nbsp;SUR&nbsp;LES&nbsp;PATIENTS</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
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
                    <td class="cs1BF5E715" style="width:377px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Abonnement</nobr></td>
                    <td class="cs36E0C1B8" colspan="7" style="width:342px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nombre&nbsp;de&nbsp;Cas</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs247B7E6" style="width:377px;height:23px;"></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FEMININ</nobr></td>
                    <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MASCULIN</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td></td>
                </tr>
                ';
                                                                            
                      $output .= $this->showDetailOrganisation($date1,$date2); 
                                                                            
                  $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs58AC6944" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFemme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalHomme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalData.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs76421F2" colspan="6" style="width:221px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;Du '.$date1.' au '.$date2.'</nobr></td>
                </tr>
            </table>
            </body>
            </html>'; 

    return $output;

}   



function showDetailOrganisation($date1,$date2)
{
    $data1 = DB::table('tconf_organisationabone')
    ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
    ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
     'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
     'name_categorie_societe','author',"tconf_organisationabone.created_at")
    ->orderBy("tconf_organisationabone.nom_org", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $sommeFemme=0;        
        $sommeHomme=0;
        $totalG=0; 
        
        $data2 = DB::table('tmouvement')            
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->selectRaw('COUNT(tmouvement.id) as Nombre')
        ->where([
            ['dateMouvement','>=', $date1],
            ['dateMouvement','<=', $date2],
            ['idOrganisation','=', $row1->id],
            ['sexe_malade','=', 'Femme']
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $sommeFemme=$row2->Nombre;                           
        }

        $data3 = DB::table('tmouvement')            
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->selectRaw('COUNT(tmouvement.id) as Nombre')
        ->where([
            ['dateMouvement','>=', $date1],
            ['dateMouvement','<=', $date2],
            ['idOrganisation','=', $row1->id],
            ['sexe_malade','=', 'Homme']
        ])               
        ->get();
        foreach ($data3 as $row3) 
        {                                
           $sommeHomme=$row3->Nombre;                           
        }

        $data4 =   DB::select(
            'select (IFNULL(ROUND(:totalFemme,0),0) + IFNULL(ROUND(:totalHomme,0),0)) as totalGeneral from tconf_organisationabone  
             where (tconf_organisationabone.id = :idOrg)',
             ['idOrg' => $row1->id,'totalFemme' => $sommeFemme,'totalHomme'=>$sommeHomme]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalG=$row4->totalGeneral;                           
         }

         $output .='	
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs22DF2452" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row1->nom_org.'</nobr></td>
                <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeFemme.'</nobr></td>
                <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeHomme.'</nobr></td>
                <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalG.'</nobr></td>
                <td></td>
            </tr>';    
    }

    return $output;

}


//============ STATISTIQUE PAR MOUVEMENT ===============================================

function pdf_statistique_type_mouvement(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        
        $html = $this->getInfoStatistiqueTypeMouvement($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{
    }    
}



function getInfoStatistiqueTypeMouvement($date1,$date2)
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
           $busnessName='';
           $rccEse='';
           $pic2 = $this->displayImg("fichier", 'logo.png');

           $data1 = DB::table('entreprise') 
           ->join('users' , 'users.id','=','entreprise.ceo')
           ->join('secteurs' , 'secteurs.id','=','entreprise.idSecteur')
           ->join('forme_juridiques' , 'forme_juridiques.id','=','entreprise.idForme')
           ->join('provinces' , 'provinces.id','=','entreprise.idProvince')
           ->join('pays' , 'pays.id','=','provinces.idPays')
           //MALADE
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
           }
          // 
            $totalFemme=0;  
            $totalHomme=0;
            $totalData=0;
            //
            $data2 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['sexe_malade','=', 'Femme']
            ])               
            ->get();

            foreach ($data2 as $row2) 
            {                                
               $totalFemme=$row2->Nombre;                           
            }

            $data3 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['sexe_malade','=', 'Homme']
            ])               
            ->get();

            foreach ($data3 as $row2) 
            {                                
               $totalHomme=$row2->Nombre;                           
            }

            $data4 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2]
            ])               
            ->get();

            foreach ($data4 as $row2) 
            {                                
               $totalData=$row2->Nombre;                           
            }



            $sommeFemmeMoins=0;        
            $sommeHommeMoins=0;
            $totalGMoins=0; 
        
            $sommeFemmePlus=0;        
            $sommeHommePlus=0;
            $totalGPlus=0; 
            
            $data5 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['agemvt','<=', 5],
                ['sexe_malade','=', 'Femme']
            ])               
            ->get();
            foreach ($data5 as $row2) 
            {                                
               $sommeFemmeMoins=$row2->Nombre;                           
            }
        
            $data6 = DB::table('tmouvement')            
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->selectRaw('COUNT(tmouvement.id) as Nombre')
            ->where([
                ['dateMouvement','>=', $date1],
                ['dateMouvement','<=', $date2],
                ['agemvt','<=', 5],
                ['sexe_malade','=', 'Homme']
            ])               
            ->get();
            foreach ($data6 as $row3) 
            {                                
               $sommeHommeMoins=$row3->Nombre;                           
            }
        
        
        
             $data7 = DB::table('tmouvement')            
             ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
             ->join('tclient','tclient.id','=','tmouvement.refMalade')
             ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
             ->selectRaw('COUNT(tmouvement.id) as Nombre')
             ->where([
                 ['dateMouvement','>=', $date1],
                 ['dateMouvement','<=', $date2],
                 ['agemvt','>', 5],
                 ['sexe_malade','=', 'Femme']
             ])               
             ->get();
             foreach ($data7 as $row2) 
             {                                
                $sommeFemmePlus=$row2->Nombre;                           
             }
         
             $data8 = DB::table('tmouvement')            
             ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
             ->join('tclient','tclient.id','=','tmouvement.refMalade')
             ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
             ->selectRaw('COUNT(tmouvement.id) as Nombre')
             ->where([
                 ['dateMouvement','>=', $date1],
                 ['dateMouvement','<=', $date2],
                 ['agemvt','>', 5],
                 ['sexe_malade','=', 'Homme']
             ])               
             ->get();
             foreach ($data8 as $row3) 
             {                                
                $sommeHommePlus=$row3->Nombre;                           
             }
         
             $totalGPlus=$sommeFemmePlus + $sommeHommePlus;
             $totalGMoins=$sommeFemmeMoins+$sommeHommeMoins;
    
            $output=
            '
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>RAPPORT_STATISTIQUE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs1BF5E715 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs247B7E6 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csA67C9637 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:729px;height:584px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:6px;"></td>
                    <td style="height:0px;width:225px;"></td>
                    <td style="height:0px;width:20px;"></td>
                    <td style="height:0px;width:134px;"></td>
                    <td style="height:0px;width:24px;"></td>
                    <td style="height:0px;width:95px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:11px;"></td>
                    <td style="height:0px;width:73px;"></td>
                    <td style="height:0px;width:97px;"></td>
                    <td style="height:0px;width:16px;"></td>
                    <td style="height:0px;width:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="5" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="6" style="width:523px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                    <td></td>
                    <td class="cs101A94F7" colspan="2" rowspan="7" style="width:170px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:170px;height:154px;">
                        <img alt="" src="'.$pic2.'" style="width:170px;height:154px;" /></div>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="6" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" colspan="6" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="6" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>'.$adresseEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="6" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csFFC1C457" colspan="6" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs612ED82F" colspan="6" rowspan="2" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td></td>
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
                    <td style="width:0px;height:13px;"></td>
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
                    <td style="width:0px;height:40px;"></td>
                    <td></td>
                    <td class="csA67C9637" colspan="10" style="width:718px;height:40px;line-height:21px;text-align:center;vertical-align:middle;"><nobr>RAPPORTS&nbsp;DES&nbsp;STATISTIQUES&nbsp;MALADE&nbsp;DU&nbsp;'.$date1.'&nbsp;au&nbsp;'.$date2.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csCE72709D" style="width:223px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>A.&nbsp;Statistique&nbsp;Par&nbsp;Age</nobr></td>
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
                    <td class="cs1BF5E715" colspan="3" style="width:377px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESCRIPTION</nobr></td>
                    <td class="cs36E0C1B8" colspan="7" style="width:342px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nombre&nbsp;de&nbsp;Cas</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs247B7E6" colspan="3" style="width:377px;height:23px;"></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FEMININ</nobr></td>
                    <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MASCULIN</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Inferieur&nbsp;ou&nbsp;&#233;gale&nbsp;&#224;&nbsp;5&nbsp;ans</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeFemmeMoins.'</nobr></td>
                    <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeHommeMoins.'</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalGMoins.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Sperieur&nbsp;&#224;&nbsp;5&nbsp;ans</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeFemmePlus.'</nobr></td>
                    <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeHommePlus.'</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalGPlus.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs58AC6944" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFemme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalHomme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalData.'</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:33px;"></td>
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
                    <td class="csCE72709D" colspan="2" style="width:243px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>B.&nbsp;Statistique&nbsp;&nbsp;par&nbsp;Type&nbsp;Abonnement</nobr></td>
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
                    <td class="cs1BF5E715" colspan="3" style="width:377px;height:23px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DESCRIPTION</nobr></td>
                    <td class="cs36E0C1B8" colspan="7" style="width:342px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Nombre&nbsp;de&nbsp;Cas</nobr></td>
                    <td></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs247B7E6" colspan="3" style="width:377px;height:23px;"></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FEMININ</nobr></td>
                    <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MASCULIN</nobr></td>
                    <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td></td>
                </tr>
                ';
                                                                                        
                     $output .= $this->showDetailTypeAbonnement($date1,$date2); 
                                                                                        
                    $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs58AC6944" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalFemme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalHomme.'</nobr></td>
                    <td class="cs36E0C1B8" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalData.'</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs76421F2" colspan="6" style="width:221px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                </tr>
            </table>
            </body>
            </html>
            '; 

    return $output;

}   



function showDetailTypeAbonnement($date1,$date2)
{
    $data1 = DB::table('tcategorieclient')
    ->select("tcategorieclient.id","tcategorieclient.designation","tcategorieclient.created_at")
    ->orderBy("tcategorieclient.designation", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $sommeFemme=0;        
        $sommeHomme=0;
        $totalG=0; 
        
        $data2 = DB::table('tmouvement')            
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->selectRaw('COUNT(tmouvement.id) as Nombre')
        ->where([
            ['dateMouvement','>=', $date1],
            ['dateMouvement','<=', $date2],
            ['categoriemaladiemvt','=', $row1->designation],
            ['sexe_malade','=', 'Femme']
        ])               
        ->get();
        foreach ($data2 as $row2) 
        {                                
           $sommeFemme=$row2->Nombre;                           
        }

        $data3 = DB::table('tmouvement')            
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->selectRaw('COUNT(tmouvement.id) as Nombre')
        ->where([
            ['dateMouvement','>=', $date1],
            ['dateMouvement','<=', $date2],
            ['categoriemaladiemvt','=', $row1->designation],
            ['sexe_malade','=', 'Homme']
        ])               
        ->get();
        foreach ($data3 as $row3) 
        {                                
           $sommeHomme=$row3->Nombre;                           
        }

        $data4 =   DB::select(
            'select (IFNULL(ROUND(:totalFemme,0),0) + IFNULL(ROUND(:totalHomme,0),0)) as totalGeneral from tcategorieclient  
             where (tcategorieclient.id = :idCat)',
             ['idCat' => $row1->id,'totalFemme' => $sommeFemme,'totalHomme'=>$sommeHomme]
        );         
         foreach ($data4 as $row4) 
         {                                
            $totalG=$row4->totalGeneral;                           
         }

         $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs22DF2452" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row1->designation.'</nobr></td>
                <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeFemme.'</nobr></td>
                <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeHomme.'</nobr></td>
                <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalG.'</nobr></td>
                <td></td>
            </tr>
         ';  
    }

    return $output;

}



// function showDetailParAge($date1,$date2)
// {
//     $output='';

 



//      $output .='
//             <tr style="vertical-align:top;">
//             <td style="width:0px;height:24px;"></td>
//             <td></td>
//             <td class="cs22DF2452" colspan="3" style="width:377px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row1->designation.'</nobr></td>
//             <td class="cs6E02D7D2" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeFemme.'</nobr></td>
//             <td class="cs6E02D7D2" colspan="3" style="width:110px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$sommeHomme.'</nobr></td>
//             <td class="cs6E02D7D2" colspan="2" style="width:112px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalG.'</nobr></td>
//             <td></td>
//         </tr>
//      ';   

//     return $output;


// }




    


}
