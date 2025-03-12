<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_EnteteFactureAbonneController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

//==================== RAPPORT DETAIL FACTURE SELON L'ORGANISATION =======================================



function printRapportDetailFacture_Organisation_all($date1, $date2)
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
         $totalFactPatient=0;
         $totalFactOrg=0;
         $totalPaie=0;
         $totalReste=0;
                 
         //(IFNULL(montant,0) - IFNULL(paie,0))
         //
         $data2 = DB::table('tfin_entetefacturation')
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
         
         ->selectRaw('ROUND(SUM(IFNULL(montant,0)),2) as TotalFacture')
         ->selectRaw('(ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2)) as TotalFactureOrg')
         ->selectRaw('(ROUND(SUM(IFNULL(montant,0)),2))-((ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2))) as TotalFacturePatient')
         ->selectRaw('ROUND(SUM(IFNULL(paie,0)),2) as TotalPaie')
         ->selectRaw('ROUND(SUM(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)),2) as TotalReste')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
            $totalFactPatient=$row->TotalFacturePatient;
            $totalFactOrg=$row->TotalFactureOrg;
            $totalPaie=$row->TotalPaie;
            $totalReste=$row->TotalReste;               
         }

                  

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>FACTURATION DES ABONNES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:931px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:93px;"></td>
                <td style="height:0px;width:80px;"></td>
                <td style="height:0px;width:83px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:43px;"></td>
                <td style="height:0px;width:13px;"></td>
                <td style="height:0px;width:77px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:22px;"></td>
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
                <td class="csFBB219FE" colspan="9" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
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
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>ABONNE(E)S</nobr></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT&nbsp;-&nbsp;CATEGORIE</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACT.</nobr></td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FACTURE($)</nobr></td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;PATIENT</nobr></td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOT.&nbsp;PAIE($)</nobr></td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RESTE($)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>OBS</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailFacturation_Organisation_all($date1, $date2); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="6" style="width:427px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">TOTAL&nbsp;($)&nbsp;:</td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.'$</td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactPatient.'$</td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactOrg.'$</td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPaie.'$</td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalReste.'$</td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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

function showDetailFacturation_Organisation_all($date1, $date2)
{
        $data = DB::table('tfin_entetefacturation')
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
         
            //MALADE
        ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
        "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge','pourcentageConvention',
        'categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('(((IFNULL(montant,0))*taux_prisecharge)/100) as totalFactureOrg')
        ->selectRaw('((IFNULL(montant,0))-(((IFNULL(montant,0))*taux_prisecharge)/100)) as totalFacturePatient')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)) as RestePaie')
       ->where([
        ['datefacture','>=', $date1],
        ['datefacture','<=', $date2],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_entetefacturation.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='  <tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeFacture.'</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->organisationAbonne.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->datefacture.'</td>
        <td class="cs6E02D7D2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacture.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacturePatient.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFactureOrg.'$</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalPaie.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->RestePaie.'$</nobr></td>
        <td class="cs6C28398D" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr> </nobr></td>
      </tr>';
           
   
    }

    return $output;

}

public function fetch_rapport_detailfacture_date_organisation_all(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailFacture_Organisation_all($date1, $date2);
       
        $html .='<script>window.print()</script>';

        echo($html);         

    } else {
        // code...
    }  
    
}




    
//==================== RAPPORT DETAIL FACTURE SELON L'ORGANISATION =======================================



function printRapportDetailFacture_Organisation($date1, $date2,$organisationAbonne)
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
         $totalFactPatient=0;
         $totalFactOrg=0;
         $totalPaie=0;
         $totalReste=0;
                 
         //
         $data2 = DB::table('tfin_entetefacturation')
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
          
         
         ->selectRaw('ROUND(SUM(IFNULL(montant,0)),2) as TotalFacture')
         ->selectRaw('(ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2)) as TotalFactureOrg')
         ->selectRaw('(ROUND(SUM(IFNULL(montant,0)),2))-((ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2))) as TotalFacturePatient')
         ->selectRaw('ROUND(SUM(IFNULL(paie,0)),2) as TotalPaie')
         ->selectRaw('ROUND(SUM(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)),2) as TotalReste')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['organisationAbonne','=', $organisationAbonne],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;
            $totalFactPatient=$row->TotalFacturePatient;
            $totalFactOrg=$row->TotalFactureOrg;
            $totalPaie=$row->TotalPaie;
            $totalReste=$row->TotalReste;               
         }

                  

        $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>FACTURATION DES ABONNES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:931px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:93px;"></td>
                <td style="height:0px;width:80px;"></td>
                <td style="height:0px;width:83px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:43px;"></td>
                <td style="height:0px;width:13px;"></td>
                <td style="height:0px;width:77px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:22px;"></td>
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
                <td class="csFBB219FE" colspan="9" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
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
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$organisationAbonne.'</nobr></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT&nbsp;-&nbsp;CATEGORIE</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACT.</nobr></td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FACTURE($)</nobr></td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;PATIENT</nobr></td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOT.&nbsp;PAIE($)</nobr></td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RESTE($)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>OBS</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailFacturation_Organisation($date1, $date2,$organisationAbonne); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="6" style="width:427px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">TOTAL&nbsp;($)&nbsp;:</td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.'$</td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactPatient.'$</td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactOrg.'$</td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPaie.'$</td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalReste.'$</td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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

function showDetailFacturation_Organisation($date1, $date2,$organisationAbonne)
{
        $data = DB::table('tfin_entetefacturation')
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
         
            //MALADE
        ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
        'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
        "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge','pourcentageConvention',
        'categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
        ->selectRaw('IFNULL(montant,0) as totalFacture')
        ->selectRaw('(((IFNULL(montant,0))*taux_prisecharge)/100) as totalFactureOrg')
        ->selectRaw('((IFNULL(montant,0))-(((IFNULL(montant,0))*taux_prisecharge)/100)) as totalFacturePatient')
        ->selectRaw('IFNULL(paie,0) as totalPaie')
        ->selectRaw('(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)) as RestePaie')
       ->where([
        ['datefacture','>=', $date1],
        ['datefacture','<=', $date2],
        ['organisationAbonne','=', $organisationAbonne],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_entetefacturation.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='  <tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeFacture.'</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->organisationAbonne.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->datefacture.'</td>
        <td class="cs6E02D7D2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacture.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacturePatient.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFactureOrg.'$</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalPaie.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->RestePaie.'$</nobr></td>
        <td class="cs6C28398D" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr> </nobr></td>
      </tr>';
           
   
    }

    return $output;

}

public function fetch_rapport_detailfacture_date_organisation(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')&& $request->get('organisationAbonne')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $organisationAbonne = $request->get('organisationAbonne');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailFacture_Organisation($date1, $date2,$organisationAbonne);
       
        $html .='<script>window.print()</script>';

        echo($html);          

    } else {
        // code...
    }  
    
}


//==================== RAPPORT DETAIL FACTURE SELON LE MEDECIN SERVICE =======================================



function printRapportDetailFacture_Organisation_Service($date1, $date2,$organisationAbonne,$refUniteProduction)
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
         $totalFactPatient=0;
         $totalFactOrg=0;
         $totalPaie=0;
         $totalReste=0;
                 
         //
         $data2 = DB::table('tfin_entetefacturation')
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
          
         
         ->selectRaw('ROUND(SUM(IFNULL(montant,0)),2) as TotalFacture')
         ->selectRaw('(ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2)) as TotalFactureOrg')
         ->selectRaw('(ROUND(SUM(IFNULL(montant,0)),2))-((ROUND((SUM((((IFNULL(montant,0))*taux_prisecharge)/100))),2))) as TotalFacturePatient')
         ->selectRaw('ROUND(SUM(IFNULL(paie,2)),0) as TotalPaie')
         ->selectRaw('ROUND(SUM(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)),2) as TotalReste')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['organisationAbonne','<=', $organisationAbonne],
            ['refUniteProduction','=', $refUniteProduction],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
        ])    
         ->get(); 
         $output='';
         foreach ($data2 as $row) 
         {                                
            $totalFact=$row->TotalFacture;  
            $totalFactPatient=$row->TotalFacturePatient;
            $totalFactOrg=$row->TotalFactureOrg;  
            $totalPaie=$row->TotalPaie;
            $totalReste=$row->TotalReste;
         }

         $nom_uniteproduction='';
         $code_uniteproduction='';

         $data3 = DB::table('tfin_entetefacturation')
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
          
             //MALADE
         ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
         'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
         'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
         "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
         "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
         "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
         "dateMouvement",'organisationAbonne','taux_prisecharge','pourcentageConvention',
         'categoriemaladiemvt','numCartemvt',"numroBon",
         "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
         "ttypemouvement_malade.designation as Typemouvement","noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
         "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
         ->selectRaw('IFNULL(montant,0) as totalFacture')
         ->selectRaw('(((IFNULL(montant,0))*taux_prisecharge)/100) as totalFactureOrg')
         ->selectRaw('((IFNULL(montant,0))-(((IFNULL(montant,0))*taux_prisecharge)/100)) as totalFacturePatient')
         ->selectRaw('IFNULL(paie,0) as totalPaie')
         ->selectRaw('(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)) as RestePaie')
         ->where([
            ['datefacture','>=', $date1],
            ['datefacture','<=', $date2],
            ['organisationAbonne','<=', $organisationAbonne],
            ['refUniteProduction','<=', $refUniteProduction],
            ['categoriemaladiemvt','=', 'ABONNE(E)']
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
            <title>FACTURATION DES ABONNES</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:931px;height:383px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:102px;"></td>
                <td style="height:0px;width:36px;"></td>
                <td style="height:0px;width:71px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:66px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:93px;"></td>
                <td style="height:0px;width:80px;"></td>
                <td style="height:0px;width:83px;"></td>
                <td style="height:0px;width:40px;"></td>
                <td style="height:0px;width:43px;"></td>
                <td style="height:0px;width:13px;"></td>
                <td style="height:0px;width:77px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:22px;"></td>
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
                <td class="csFBB219FE" colspan="9" style="width:682px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                <td></td>
                <td class="cs101A94F7" colspan="4" rowspan="7" style="width:175px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:175px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="9" style="width:682px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$idNatEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="9" style="width:682px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="9" rowspan="2" style="width:682px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td class="csB6F858D0" colspan="9" style="width:625px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;FACTURATIONS</nobr></td>
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
                <td class="cs56F73198" colspan="4" style="width:329px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$date1.'&nbsp;&nbsp;au&nbsp;'.$date2.'</nobr></td>
                <td class="cs56F73198" colspan="10" style="width:562px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><nobr>'.$organisationAbonne.' - '.$nom_uniteproduction.'</nobr></td>
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
                <td class="cs9FE9304F" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;FACTURE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT&nbsp;-&nbsp;CATEGORIE</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE&nbsp;FACT.</nobr></td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FACTURE($)</nobr></td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;PATIENT</nobr></td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TOT.&nbsp;PAIE($)</nobr></td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RESTE($)</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>OBS</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showDetailFacturation_Organisation_Service($date1, $date2,$organisationAbonne,$refUniteProduction); 
        
                    $output.='
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" colspan="6" style="width:427px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">TOTAL&nbsp;($)&nbsp;:</td>
                <td class="cs9FE9304F" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFact.'$</td>
                <td class="cs9FE9304F" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactPatient.'$</td>
                <td class="cs9FE9304F" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalFactOrg.'$</td>
                <td class="cs9FE9304F" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalPaie.'$</td>
                <td class="cs9FE9304F" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$totalReste.'$</td>
                <td class="csEAC52FCD" colspan="2" style="width:64px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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

function showDetailFacturation_Organisation_Service($date1, $date2,$organisationAbonne,$refUniteProduction)
{
    $data = DB::table('tfin_entetefacturation')
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
        //MALADE
    ->select("tfin_entetefacturation.id",'refMouvement','refUniteProduction','refMedecin',
    'datefacture','tfin_entetefacturation.statut as statutFact','refDepartement','nom_uniteproduction',
    'code_uniteproduction','nom_departement','code_departement',"tfin_entetefacturation.author",
    "tfin_entetefacturation.created_at","tfin_entetefacturation.updated_at",
    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
    "dateMouvement",'organisationAbonne','taux_prisecharge','pourcentageConvention',
    'categoriemaladiemvt',"numroBon",
    "tmouvement.Statut as statutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
    ->selectRaw('IFNULL(montant,0) as totalFacture')
    ->selectRaw('(((IFNULL(montant,0))*taux_prisecharge)/100) as totalFactureOrg')
    ->selectRaw('((IFNULL(montant,0))-(((IFNULL(montant,0))*taux_prisecharge)/100)) as totalFacturePatient')
    ->selectRaw('IFNULL(paie,0) as totalPaie')
    ->selectRaw('(IFNULL((IFNULL(montant,0) - IFNULL(paie,0)),0)) as RestePaie')
       ->where([ //refUniteProduction
        ['datefacture','>=', $date1],
        ['datefacture','<=', $date2],
        ['organisationAbonne','=', $organisationAbonne],
        ['refUniteProduction','=', $refUniteProduction],
        ['categoriemaladiemvt','=', 'ABONNE(E)']
    ])
    ->orderBy("tfin_entetefacturation.created_at", "asc")
    ->get();
    $output='';

    foreach ($data as $row) 
    {
        $output .='  <tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="cs6E02D7D2" style="width:101px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->codeFacture.'</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->noms.'&nbsp;-&nbsp;'.$row->organisationAbonne.'</td>
        <td class="cs6E02D7D2" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->datefacture.'</td>
        <td class="cs6E02D7D2" style="width:92px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacture.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:79px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFacturePatient.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:82px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalFactureOrg.'$</nobr></td>
        <td class="cs6E02D7D2" colspan="3" style="width:95px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->totalPaie.'$</nobr></td>
        <td class="cs6E02D7D2" style="width:76px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->RestePaie.'$</nobr></td>
        <td class="cs6C28398D" colspan="2" style="width:64px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr> </nobr></td>
      </tr>';
           
   
    }

    return $output;

}

public function fetch_rapport_detailfacture_date_organisation_service(Request $request)
{
    //refDepartement

    if ($request->get('date1') && $request->get('date2')
    && $request->get('organisationAbonne')&& $request->get('refUniteProduction')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $organisationAbonne = $request->get('organisationAbonne');
        $refUniteProduction = $request->get('refUniteProduction');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportDetailFacture_Organisation_Service($date1, $date2,$organisationAbonne,$refUniteProduction);
       
        $html .='<script>window.print()</script>';

        echo($html);               

    } else {
        // code...
    }  
    
}















    
    

    
}
