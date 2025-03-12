<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_PaiementFactureAbonneController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    
//==================== RAPPORT JOURNALIER DES FACTURES =================================



function printRapportPaieFacture($date1, $date2)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;
                           
         }

           

        $output='
        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>DEPARTEMENT</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaieFacturation($date1,$date2); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>
        ';  
       
        return $output; 

}

function showPaieFacturation($date1, $date2)
{
    $data = DB::table('tfin_paiementfacture')
    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
    ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
    ->join('tclient','tclient.id','=','tmouvement.refMalade')
    ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        //MALADE
    ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
    'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
    "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe',
    'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
    'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
    'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
    "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
    "dateMouvement",'organisationAbonne','taux_prisecharge',
    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
    "tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
    ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
    ->where([
        ['datepaie','>=', $date1],
        ['datepaie','<=', $date2],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_paiementfacture.created_at", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .='
        <tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
		<td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
		<td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
		<td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
		<td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
		<td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
		<td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
		<td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
		<td></td>
	</tr>
        ';        
   
    }

    return $output;

}

public function fetch_rapport_paiementfacture_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaieFacture($date1, $date2);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }
    
    
}




//==================== RAPPORT DETAIL FACTURE SELON LE DEPARTEMENT =======================================



function printRapportPaiementFacture_Departement($date1, $date2,$refDepartement)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refDepartement','=', $refDepartement],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;                           
         }

         $nom_departement='';
         $code_departement='';

         $data3=DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
             //MALADE
         ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
         'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
         "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe',
         'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
         "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
         "tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refDepartement','=', $refDepartement],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_departement=$row->nom_departement;
            $code_departement=$row->code_departement;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_departement.'  -  '.$code_departement.'</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Departement($date1, $date2,$refDepartement); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Departement($date1, $date2,$refDepartement)
{
        $data = DB::table('tfin_paiementfacture')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
        'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
        "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refDepartement','=', $refDepartement],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])
        ->orderBy("tfin_paiementfacture.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
                ';            
   
        }

    return $output;

}

public function fetch_rapport_paiementfacture_date_departement(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refDepartement')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refDepartement = $request->get('refDepartement');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Departement($date1, $date2,$refDepartement);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}






//==================== RAPPORT DETAIL FACTURE SELON LE SERVICE =======================================



function printRapportPaiementFacture_Service($date1, $date2,$refUniteProduction)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refUniteProduction','=', $refUniteProduction],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;
                           
         }

         $nom_uniteproduction='';
         $code_uniteproduction='';

         $data3=DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
             //MALADE
         ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
         'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
         "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe',
         'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
         "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
         "tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture') 
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refUniteProduction','=', $refUniteProduction],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_uniteproduction=$row->nom_uniteproduction;
            $code_uniteproduction=$row->code_uniteproduction;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$nom_uniteproduction.'  - '.$code_uniteproduction.'</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Service($date1, $date2,$refUniteProduction); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Service($date1, $date2,$refUniteProduction)
{
    $data = DB::table('tfin_paiementfacture')
    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
    ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
    ->join('tclient','tclient.id','=','tmouvement.refMalade')
    ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        //MALADE
    ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
    'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
    "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe',
    'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
    'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
    'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
    "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
    "dateMouvement",'organisationAbonne','taux_prisecharge',
    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
    "tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
    ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
    ->where([
        ['datepaie','>=', $date1],
        ['datepaie','<=', $date2],
        ['refUniteProduction','=', $refUniteProduction],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_paiementfacture.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
        ';
           
   
    }

    return $output;

}

public function fetch_rapport_paiementfacture_date_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refUniteProduction')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refUniteProduction = $request->get('refUniteProduction');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Service($date1, $date2,$refUniteProduction);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}





//==================== RAPPORT DETAIL FACTURE SELON LE MEDECIN =======================================



function printRapportPaiementFacture_Banque($date1, $date2,$refBanque)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))

         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refBanque','=', $refBanque],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;
                           
         }

         $nom_banque='';
         $numero_ssouscompte='';

         $data3=DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
             //MALADE
         ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
         'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
         "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe',
         'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
         "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
         "tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['refBanque','=', $refBanque],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_banque=$row->nom_banque;
            $numero_ssouscompte=$row->numero_ssouscompte;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$nom_banque.'  : '.$numero_ssouscompte.'</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Banque($date1, $date2,$refBanque); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Banque($date1, $date2,$refBanque)
{
        $data = DB::table('tfin_paiementfacture')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
        'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
        "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->where([
           ['datepaie','>=', $date1],
           ['datepaie','<=', $date2],
           ['refBanque','=', $refBanque],
           ['categoriemaladiemvt','=', 'ABONNE(E)'],
       ])
       ->orderBy("tfin_paiementfacture.created_at", "asc")
       ->get();
       $output='';

    foreach ($data as $row) 
    {
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
        '; 
           
   
    }

    return $output;

}

public function fetch_rapport_paiementfacture_date_banque(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('refBanque')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refBanque = $request->get('refBanque');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Banque($date1, $date2,$refBanque);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}


//==================== RAPPORT DETAIL FACTURE SELON LE MEDECIN SERVICE =======================================



function printRapportPaiementFacture_Banque_Service($date1, $date2,$refBanque,$refUniteProduction)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refMedecin','=', $refBanque],
            ['refUniteProduction','=', $refUniteProduction]
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;    
         }

        $nom_banque='';
        $numero_ssouscompte='';
        $nom_uniteproduction='';
        $code_uniteproduction=''; 

         $data3=DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
             //MALADE
         ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
         'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
         "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe',
         'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
         "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
         "tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['refMedecin','=', $refBanque],
            ['refUniteProduction','=', $refUniteProduction]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_banque=$row->nom_banque;
            $numero_ssouscompte=$row->numero_ssouscompte;
            $nom_uniteproduction=$row->nom_uniteproduction;
            $code_uniteproduction=$row->code_uniteproduction;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_banque.' : '.$numero_ssouscompte.' - '.$nom_uniteproduction.'</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Banque_Service($date1, $date2,$refBanque,$refUniteProduction); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Banque_Service($date1, $date2,$refBanque,$refUniteProduction)
{
    $data = DB::table('tfin_paiementfacture')
    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
    ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
    ->join('tclient','tclient.id','=','tmouvement.refMalade')
    ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        //MALADE
    ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
    'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
    "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe',
    'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
    'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
    'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
    "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
    "dateMouvement",'organisationAbonne','taux_prisecharge',
    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
    "tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
    ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
       ->where([ //refUniteProduction
        ['datepaie','>=', $date1],
        ['datepaie','<=', $date2],
        ['refBanque','=', $refBanque],
        ['refUniteProduction','=', $refUniteProduction],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_paiementfacture.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                        <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                        <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                        <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                        <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                        <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                        <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                        <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                        <td></td>
                    </tr>
                '; 
           
   
    }

    return $output;

}

public function fetch_rapport_paiementfacture_date_banque_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')
    && $request->get('refBanque')&& $request->get('refUniteProduction')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refBanque = $request->get('refBanque');
        $refUniteProduction = $request->get('refUniteProduction');
        
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Banque_Service($date1, $date2,$refBanque,$refUniteProduction);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}






//================= GESTION DES CAISSIERS =====================================================================================
//=============================================================================================================================



//==================== RAPPORT DETAIL FACTURE SELON LE CAISSIER =======================================



function printRapportPaiementFacture_Caissier($date1, $date2,$author)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['tfin_paiementfacture.author','=', $author],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;                           
         }

         $nom_caissier='';

         $data3=DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
             //MALADE
         ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
         'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
         "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe',
         'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
         "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge',
         'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
         "tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['tfin_paiementfacture.author','=', $author],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_caissier=$row->author;                   
        }



           

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$nom_caissier.'</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Caissier($date1, $date2,$author); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Caissier($date1, $date2,$author)
{
        $data = DB::table('tfin_paiementfacture')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
        'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
        "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['tfin_paiementfacture.author','=', $author],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])
        ->orderBy("tfin_paiementfacture.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
                ';            
   
        }

    return $output;

}

public function fetch_rapport_paiementfacture_date_caissier(Request $request)
{
   

    if ($request->get('date1') && $request->get('date2')&& $request->get('author')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $author = $request->get('author');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Caissier($date1, $date2,$author);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}






//==================== RAPPORT RAPPORT PAIEMENT SELON LES ORGANISATIONS =======================================



function printRapportPaiementFacture_Caissier_Organisation($date1, $date2,$Organisation)
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


         $totalPaie=0;
                 
         //
         $data2 = DB::table('tfin_paiementfacture')
         ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
         ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
         ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
         ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
         ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
         ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
         ->join('tclient','tclient.id','=','tmouvement.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
 
         ->select(DB::raw('ROUND(SUM(montantpaie),2) as TotalPaie'))
         ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['organisationAbonne','=', $Organisation],
            ['categoriemaladiemvt','=', 'ABONNE(E)'],
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalPaie=$row->TotalPaie;                           
         }

        

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>rpt_RapportPaiement</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs3DB3E5A1 {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .cs691A15EF {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; }
                .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                .cs56F73198 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs3B0DD49A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
                .cs803D2C52 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:11px; font-weight:normal; font-style:normal; }
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:946px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:50px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:23px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:110px;"></td>
                <td style="height:0px;width:127px;"></td>
                <td style="height:0px;width:89px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:9px;"></td>
                <td style="height:0px;width:55px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:59px;"></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="9" style="width:723px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:723px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:723px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:723px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;PAIEMENTS</nobr></td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="5" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:597px;height:21px;line-height:18px;text-align:left;vertical-align:top;">'.$Organisation.'</td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3DB3E5A1" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                <td class="cs3DB3E5A1" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>AGENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;PAIEMENT</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs3DB3E5A1" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>LIBELLE</nobr></td>
                <td class="cs3DB3E5A1" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs3DB3E5A1" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>MONTANT($)</nobr></td>
                <td class="cs3DB3E5A1" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>TAUX</nobr></td>
                <td class="cs691A15EF" colspan="2" style="width:61px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>COMPTE</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showPaiementFacturation_Caissier_Organisation($date1, $date2,$Organisation); 
        
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
                <td class="cs49AA1D99" colspan="2" style="width:214px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOTAL&nbsp;($)&nbsp;:</nobr></td>
                <td class="csEAC52FCD" colspan="5" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.' $</nobr></td>
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
                <td></td>
            </tr>
        </table>
        </body>
        </html>';  
       
        return $output; 

}

function showPaiementFacturation_Caissier_Organisation($date1, $date2,$Organisation)
{
        $data = DB::table('tfin_paiementfacture')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_paiementfacture.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tmouvement','tmouvement.id','=','tfin_entetefacturation.refMouvement')
        ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
        ->join('tclient','tclient.id','=','tmouvement.refMalade')
        ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
        ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
        ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
        ->join('communes' , 'communes.id','=','quartiers.idCommune')
        ->join('villes' , 'villes.id','=','communes.idVille')
        ->join('provinces' , 'provinces.id','=','villes.idProvince')
        ->join('pays' , 'pays.id','=','provinces.idPays')
        ->join('tconf_banque' , 'tconf_banque.id','=','tfin_paiementfacture.refBanque')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tconf_banque.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            //MALADE
        ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
        'modepaie','libellepaie','montant_taux','refBanque','numeroBordereau',"tconf_banque.nom_banque",
        "tconf_banque.numerocompte",'tconf_banque.nom_mode',"refSscompte",
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe',
        'nom_typeposition',"nom_typecompte",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_paiementfacture.author",
        "tfin_paiementfacture.created_at","tfin_paiementfacture.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
        "tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("R",YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->where([
            ['datepaie','>=', $date1],
            ['datepaie','<=', $date2],
            ['organisationAbonne','=', $Organisation],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])
        ->orderBy("tfin_paiementfacture.created_at", "asc")
        ->get();
        $output='';

        foreach ($data as $row) 
        {
            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs3B0DD49A" style="width:87px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->datepaie.'</td>
                <td class="cs3B0DD49A" colspan="2" style="width:120px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs3B0DD49A" style="width:100px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeRecu.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:198px;height:22px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->categoriemaladiemvt.'</td>
                <td class="cs3B0DD49A" style="width:126px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'&nbsp;:&nbsp;'.$row->noms.'</td>
                <td class="cs3B0DD49A" style="width:88px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->codeFacture.'</td>
                <td class="cs3B0DD49A" colspan="3" style="width:96px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montantpaie.'$</td>
                <td class="cs3B0DD49A" style="width:52px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->montant_taux.'</td>
                <td class="cs803D2C52" style="width:59px;height:22px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->numero_ssouscompte.'</td>
                <td></td>
            </tr>
                ';            
   
        }

    return $output;

}

public function fetch_rapport_paiementfacture_date_caissier_organisation(Request $request)
{
   

    if ($request->get('date1') && $request->get('date2')&& $request->get('Organisation')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $Organisation = $request->get('Organisation');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportPaiementFacture_Caissier_Organisation($date1, $date2,$Organisation);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }  
    
}













    
    

    
}
