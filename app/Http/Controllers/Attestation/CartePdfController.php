<?php

namespace App\Http\Controllers\Attestation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};

use DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

use App\User;
use App\Message;

class CartePdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


//===============================================================================================================================================================================================
//===============================================================================================================================================================================================
//================ CARTE POUR ABONNE ==================================================================================================================================================

public function generateQrcode($text) {

    
    $qrc = QrCode::size(100)->generate($text);
    $qrcode='<img src="data:image/svg+xml;base64,'.base64_encode($qrc).'" 
    width="104" height="89">';
    // width="84" height="69">';
    return $qrcode;
}

function pdf_carte_medicale(Request $request)
    {
//
        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoCarteSoin($id);
            $pdf = \App::make('dompdf.wrapper');
            // echo($html);

            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();
            
        }
        else{
        }       
        
    }

    function getInfoCarteSoin($id)
    {
                //Info Malade
                $code='';
                $noms='';
                $genre='';
                $datenaissance='';
                $lieunaissance='';
                $contact='';
                $contact2='';
                $profession='';
                
                
                $data = DB::table('tclient')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
                //MALADE
                ->select("tclient.id","noms","contact","mail","refAvenue","refCategieClient",
                "tcategorieclient.designation as Categorie","photo","slug","author","avenues.nomAvenue",
                "quartiers.idCommune","quartiers.nomQuartier","quartiers.id as idQuartier","communes.idVille",
                "communes.nomCommune","villes.idProvince","villes.nomVille","provinces.idPays","provinces.nomProvince",
                "pays.nomPays","tclient.created_at","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->where('tclient.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {

                    $code=$row->id;
                    $noms=$row->noms;
                    $genre=$row->sexe_malade;
                    $datenaissance=$row->dateNaissance_malade;
                    $lieunaissance=$row->organisation_malade;
                    $contact=$row->contact;
                    $contact2=$row->contactPersRef_malade;
                    $profession=$row->fonction_malade;                   
                
                }

                $qrcode = $this->generateQrcode($id);

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
                $slogan='';
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
                    $slogan=$row->facebook;         
                }

                $typeconte='Content-Type';
                $formatss='text/html; charset=utf-8';

        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0014)about:internet -->
                <html>
                <head>
                    <title>CARTE MEDICALE</title>
                    <meta HTTP-EQUIV='.$typeconte.' CONTENT='.$formatss.'/>
                    <style type="text/css">
                        .csE75D3AE5 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csC3BBD80E {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD2198692 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE33A3B23 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs140EE778 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csA4A4F90C {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs914D1A68 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#000000 1px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs7384E3C7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs168BF375 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs40F84085 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:11px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs5B076041 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs5C175A84 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .cs58146D03 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:338px;height:171px;position:relative;">
                    <tr style="vertical-align:top;">
                        <td style="width:10px;height:10px;"></td>
                        <td style="width:7px;"></td>
                        <td style="width:1px;"></td>
                        <td style="width:40px;"></td>
                        <td style="width:3px;"></td>
                        <td style="width:1px;"></td>
                        <td style="width:10px;"></td>
                        <td style="width:11px;"></td>
                        <td style="width:15px;"></td>
                        <td style="width:10px;"></td>
                        <td style="width:98px;"></td>
                        <td style="width:10px;"></td>
                        <td style="width:109px;"></td>
                        <td style="width:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:9px;"></td>
                        <td class="csE75D3AE5" style="width:6px;height:8px;"></td>
                        <td class="cs140EE778" style="width:1px;height:8px;"></td>
                        <td class="cs140EE778" style="width:40px;height:8px;"></td>
                        <td class="cs140EE778" style="width:3px;height:8px;"></td>
                        <td class="cs140EE778" style="width:1px;height:8px;"></td>
                        <td class="cs140EE778" style="width:10px;height:8px;"></td>
                        <td class="cs140EE778" style="width:11px;height:8px;"></td>
                        <td class="cs140EE778" style="width:15px;height:8px;"></td>
                        <td class="cs140EE778" style="width:10px;height:8px;"></td>
                        <td class="cs140EE778" style="width:98px;height:8px;"></td>
                        <td class="cs140EE778" style="width:10px;height:8px;"></td>
                        <td class="cs140EE778" style="width:109px;height:8px;"></td>
                        <td class="csE33A3B23" style="width:12px;height:8px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:24px;"></td>
                        <td class="csD2198692" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="7" rowspan="3" style="width:81px;height:49px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:81px;height:49px;">
                            <img alt="" src="'.$pic.'" style="width:81px;height:49px;" /></div>
                        </td>
                        <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                        <td class="cs5C175A84" colspan="3" style="width:215px;height:24px;line-height:21px;text-align:left;vertical-align:top;"><nobr>CARTE&nbsp;MEDICALE</nobr></td>
                        <td class="cs914D1A68" style="width:12px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:16px;"></td>
                        <td class="csD2198692" style="width:6px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="3" style="width:215px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$nomEse.'</nobr></td>
                        <td class="cs914D1A68" style="width:12px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:9px;"></td>
                        <td class="csD2198692" style="width:6px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:9px;"></td>
                        <td class="cs58146D03" colspan="3" rowspan="2" style="width:215px;height:13px;line-height:10px;text-align:left;vertical-align:top;">'.$busnessName.'</td>
                        <td class="cs914D1A68" style="width:12px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:4px;"></td>
                        <td class="csD2198692" style="width:6px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:9px;"></td>
                        <td class="csD2198692" style="width:6px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:98px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:9px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:7px;"></td>
                        <td class="csD2198692" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:98px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:7px;"></td>
                        <td class="cs101A94F7" rowspan="11" style="width:109px;height:81px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:109px;height:81px;">
                        '.$qrcode.'</div>
                        </td>
                        <td class="cs914D1A68" style="width:12px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:13px;"></td>
                        <td class="csD2198692" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                        <td class="cs168BF375" style="width:38px;height:13px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="cs40F84085" colspan="7" rowspan="2" style="width:146px;height:15px;line-height:12px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs101A94F7" style="width:10px;height:13px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:2px;"></td>
                        <td class="csD2198692" style="width:6px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:2px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:14px;"></td>
                        <td class="csD2198692" style="width:6px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:14px;"></td>
                        <td class="cs168BF375" colspan="4" style="width:52px;height:14px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Naissance&nbsp;:</nobr></td>
                        <td class="cs5B076041" colspan="4" style="width:132px;height:14px;line-height:10px;text-align:left;vertical-align:top;">'.$lieunaissance.' - '.$datenaissance.'</td>
                        <td class="cs101A94F7" style="width:10px;height:14px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:13px;"></td>
                        <td class="csD2198692" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                        <td class="cs168BF375" colspan="5" style="width:63px;height:13px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Profession&nbsp;:</nobr></td>
                        <td class="cs40F84085" colspan="3" rowspan="2" style="width:121px;height:14px;line-height:12px;text-align:left;vertical-align:top;">'.$profession.'</td>
                        <td class="cs101A94F7" style="width:10px;height:13px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:1px;"></td>
                        <td class="csD2198692" style="width:6px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:13px;"></td>
                        <td class="csD2198692" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                        <td class="cs168BF375" colspan="3" rowspan="2" style="width:42px;height:14px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Genre&nbsp;:</nobr></td>
                        <td class="cs5B076041" colspan="5" style="width:142px;height:13px;line-height:10px;text-align:left;vertical-align:top;">'.$genre.'</td>
                        <td class="cs101A94F7" style="width:10px;height:13px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:1px;"></td>
                        <td class="csD2198692" style="width:6px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:98px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:12px;"></td>
                        <td class="csD2198692" style="width:6px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs168BF375" colspan="2" rowspan="2" style="width:41px;height:13px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Contact&nbsp;:</nobr></td>
                        <td class="cs5B076041" colspan="6" style="width:143px;height:12px;line-height:10px;text-align:left;vertical-align:top;">'.$contact.' , '.$contact2.'</td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:1px;"></td>
                        <td class="csD2198692" style="width:6px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:98px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:1px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:4px;"></td>
                        <td class="csD2198692" style="width:6px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:3px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:15px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:98px;height:4px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:4px;"></td>
                        <td class="cs914D1A68" style="width:12px;height:4px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="height:9px;"></td>
                        <td class="csC3BBD80E" style="width:6px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:1px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:40px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:3px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:1px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:10px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:11px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:15px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:10px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:98px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:10px;height:8px;"></td>
                        <td class="cs7384E3C7" style="width:109px;height:8px;"></td>
                        <td class="csA4A4F90C" style="width:12px;height:8px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                
                ';

                return $output;

    }



    


  
    
  


    


    


}
