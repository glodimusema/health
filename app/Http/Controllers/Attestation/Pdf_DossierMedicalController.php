<?php

namespace App\Http\Controllers\Attestation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_DossierMedicalController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    //=========================================================================================================================
    //====================== DOSSIER MEDICAL ================================================================================



    function pdf_dossier_medical_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');           
            $html = $this->getInfoDossierMedical($id); 
            echo($html);         
        }
        else{

        }
        
        
    }

    function getInfoDossierMedical($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $codeDossier='';
                $dateNaissance_malade='';
                $sexe_malade='';
                $numroBon='';
                $groupesanguin='';
                $dateMouvement='';
                
                $data = DB::table('tmouvement')            
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
                ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
                "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
                "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tmouvement.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;                    
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;
                    $sexe_malade=$row->sexe_malade;
                    $numroBon=$row->numroBon;
                    $age_malade=$row->age_malade;
                    $groupesanguin=$row->groupesanguin;
                    $dateMouvement=$row->dateMouvement;
                   
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
                $siege='';
                $busnessName='';
                $slogan='';
                $pic='';
                $pic2 = $this->displayImg("fichier", 'logo.png');
                $logo='';
                $sigs="s'est";
        
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

        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>DOSSIER MEDICAL</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB6F858D0 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs49AA1D99 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs20251968 {color:#000000;background-color:#E0E0E0;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs9FE9304F {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csEAC52FCD {color:#000000;background-color:#E0E0E0;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csCCF52DC3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs6C28398D {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right-style: none;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csC9583F41 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:15px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs207690C3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:951px;height:1918px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:48px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:30px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:18px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:95px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:3px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csFBB219FE" colspan="41" rowspan="2" style="width:719px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                        <td class="cs101A94F7" colspan="4" rowspan="7" style="width:169px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:169px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:169px;height:144px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="41" style="width:719px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="41" style="width:719px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="41" style="width:719px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="41" style="width:719px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="41" style="width:719px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="41" rowspan="2" style="width:719px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csB6F858D0" colspan="47" style="width:896px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>DOSSIER MEDICAL</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:43px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csCE72709D" colspan="14" style="width:317px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="17" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="4" style="width:98px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:176px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="17" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="4" style="width:98px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:176px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="4" style="width:112px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Groupe&nbsp;Sanguin&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="15" style="width:264px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$groupesanguin.'</td>
                        <td></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="4" style="width:98px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;DOSSIER&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="9" style="width:176px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$codeDossier.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="6" style="width:147px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Naissance&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="13" style="width:229px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$dateNaissance_malade.'  ('.$age_malade.' ans)</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="6" style="width:147px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&nbsp;Maladie&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="13" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateMouvement.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs207690C3" colspan="29" style="width:510px;height:32px;line-height:28px;text-align:center;vertical-align:top;"><nobr>LES&nbsp;MALADIES&nbsp;CHRONIQUES</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="17" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Maladie&nbsp;Chronique</nobr></td>
                        <td class="csEAC52FCD" colspan="12" style="width:168px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    ';                        
                                        $output .= $this->showMaladieChronique($id);                        
                                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs207690C3" colspan="28" style="width:512px;height:32px;line-height:28px;text-align:center;vertical-align:top;"><nobr>LES&nbsp;SIGNES&nbsp;VITAUX&nbsp;AU&nbsp;TRIAGE</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td class="cs9FE9304F" colspan="5" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Poids</nobr></td>
                        <td class="cs9FE9304F" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Taille</nobr></td>
                        <td class="cs9FE9304F" colspan="6" style="width:106px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TA</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>T&#176;</nobr></td>
                        <td class="cs9FE9304F" colspan="7" style="width:78px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FC</nobr></td>
                        <td class="cs9FE9304F" colspan="2" style="width:77px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>FR</nobr></td>
                        <td class="cs9FE9304F" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SaO2</nobr></td>
                        <td class="csEAC52FCD" colspan="8" style="width:119px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Type&nbsp;Episode</nobr></td>
                        <td class="cs20251968" colspan="9" style="width:235px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                    </tr>
                    ';                        
                                        $output .= $this->showSigneVitaux($id);                        
                                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs207690C3" colspan="28" style="width:512px;height:32px;line-height:28px;text-align:center;vertical-align:top;"><nobr>ANAMNES</nobr></td>
                        <td></td>
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
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9FE9304F" colspan="7" style="width:138px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Plaintes</nobr></td>
                        <td class="cs9FE9304F" colspan="7" style="width:109px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Historique</nobr></td>
                        <td class="cs9FE9304F" colspan="6" style="width:119px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Antecedent</nobr></td>
                        <td class="cs9FE9304F" colspan="5" style="width:112px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Complement</nobr><br/><nobr>Anamnese</nobr></td>
                        <td class="cs9FE9304F" colspan="6" style="width:106px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Examen&nbsp;Physique</nobr></td>
                        <td class="cs9FE9304F" colspan="7" style="width:113px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Diagnostic&nbsp;de</nobr><br/><nobr>Presomption</nobr></td>
                        <td class="csEAC52FCD" colspan="6" style="width:97px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Autres</nobr><br/><nobr>Diagnostiques</nobr></td>
                        <td class="cs20251968" colspan="3" style="width:138px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                    </tr>
                    ';                        
                                        $output .= $this->showConsultations($id);                        
                                     $output.='
                     <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Prescriptions&nbsp;Medicales</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Medicaments</nobr></td>
                        <td class="cs9FE9304F" colspan="5" style="width:55px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Quantit&#233;</nobr></td>
                        <td class="csEAC52FCD" colspan="10" style="width:210px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                     ';                        
                                        $output .= $this->showPrescriptionMedicale($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Actes&nbsp;medicaux</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Actes</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                     ';                        
                                        $output .= $this->showActeMedicale($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:341px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Diagnostic&nbsp;definitifs</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:343px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Maladie</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    ';                        
                                        $output .= $this->showDiagnosticDefinit($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:341px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Resum&#233;&nbsp;clinique</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:343px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Description</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                 ';                        
                           $output .= $this->showResumeClinique($id);                        
                           $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:20px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Autres&nbsp;Orientations</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Description</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    ';                        
                                        $output .= $this->showAutresOrientations($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Examens&nbsp;au&nbsp;laboratoire</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="21" style="width:400px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Designation</nobr></td>
                        <td class="cs9FE9304F" colspan="13" style="width:277px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Categorie&nbsp;Examens</nobr></td>
                        <td class="csEAC52FCD" colspan="11" style="width:257px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                    </tr>
                   ';                        
                                        $output .= $this->showExamenLabo($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Analyses&nbsp;Imagerie</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="20" style="width:399px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Designation</nobr></td>
                        <td class="cs9FE9304F" colspan="14" style="width:278px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Categorie&nbsp;Analyse</nobr></td>
                        <td class="csEAC52FCD" colspan="10" style="width:256px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                    </tr>
                       ';                        
                                        $output .= $this->showAnalyseImagerie($id);                        
                                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs207690C3" colspan="28" style="width:512px;height:32px;line-height:28px;text-align:center;vertical-align:top;"><nobr>HOSPITALISATION</nobr></td>
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
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9FE9304F" colspan="8" style="width:186px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Diagnostic&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs9FE9304F" colspan="4" style="width:83px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Date&nbsp;Entr&#233;e</nobr></td>
                        <td class="cs9FE9304F" colspan="8" style="width:129px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Service&nbsp;Origine</nobr></td>
                        <td class="cs9FE9304F" colspan="5" style="width:112px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Service</nobr><br/><nobr>Hospitalisation</nobr></td>
                        <td class="cs9FE9304F" colspan="7" style="width:118px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Salle</nobr></td>
                        <td class="cs9FE9304F" colspan="4" style="width:69px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Lit</nobr></td>
                        <td class="csEAC52FCD" colspan="6" style="width:97px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Statut</nobr></td>
                        <td class="cs20251968" colspan="3" style="width:138px;height:40px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                    </tr>
                       ';                        
                                        $output .= $this->showHospitalisation($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Evolution&nbsp;Medicale</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Description</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                       ';                        
                                        $output .= $this->showEvolutionMedicale($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:20px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Actes&nbsp;et&nbsp;Soins&nbsp;Infirmiers</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Description</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                       ';                        
                                        $output .= $this->showActeInfirmier($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Observations&nbsp;Infirmiers</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Description</nobr></td>
                        <td class="csEAC52FCD" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                   ';                        
                                        $output .= $this->showObservationInfirmier($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="csC9583F41" colspan="16" style="width:342px;height:19px;line-height:17px;text-align:center;vertical-align:top;"><nobr>Appreciations</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs49AA1D99" colspan="11" style="width:244px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Degre&nbsp;de&nbsp;Satisfaction</nobr></td>
                        <td class="cs9FE9304F" colspan="12" style="width:253px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Remarques</nobr></td>
                        <td class="cs9FE9304F" colspan="17" style="width:235px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Suggestions</nobr></td>
                        <td class="csEAC52FCD" colspan="5" style="width:203px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Author</nobr></td>
                    </tr>
                       ';                        
                                        $output .= $this->showAppreciationInfirmier($id);                        
                                     $output.='
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs12FE94AA" colspan="12" style="width:207px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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

    function showMaladieChronique($id)
    {
            $idmalade=0;
            $listmax = DB::table('tmouvement')            
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
            ->select("tmouvement.id","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt","tmouvement.author",
            "tmouvement.created_at","tmouvement.updated_at",'numCartemvt',
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
            "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('tmouvement.id', $id)
            ->get();
            foreach ($listmax as $listm) {
                $idmalade= $listm->refMalade;
            } 



            $data = DB::table('tmaladiechronique')           
            ->join('tconf_maladie','tconf_maladie.id','=','tmaladiechronique.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tclient','tclient.id','=','tmaladiechronique.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //MALADE
            ->select("tmaladiechronique.id",'refMalade',"tmaladiechronique.refmaladie",
             "tmaladiechronique.author", "tmaladiechronique.created_at", "tmaladiechronique.updated_at",
             "nom_maladie","refcategoriemaladie","nom_categoriemaladie","autredetail","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('tmaladiechronique.refMalade','=', $idmalade)
            ->orderBy("tmaladiechronique.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
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
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs22DF2452" colspan="17" style="width:344px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->nom_maladie.'</td>
                <td class="cs6C28398D" colspan="12" style="width:168px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
                ';          
    
            }

        return $output;

    }




    function showSigneVitaux($id)
    {

            $data = DB::table('tdetailtriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tdetailtriage.id","refEnteteTriage",'plainte_triage','antecedent_trige','cas_triage',
            "Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            'plainte_triage','antecedent_trige','cas_triage',
            "tdetailtriage.author","tdetailtriage.created_at","tdetailtriage.updated_at",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tdetailtriage.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {

                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs6E02D7D2" colspan="5" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->Poids.'&nbsp;Kg</nobr></td>
                        <td class="cs6E02D7D2" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->Taille.'</nobr></td>
                        <td class="cs6E02D7D2" colspan="6" style="width:106px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->TA.'</td>
                        <td class="cs6E02D7D2" colspan="2" style="width:71px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->Temperature.'</td>
                        <td class="cs6E02D7D2" colspan="7" style="width:78px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->FC.'</td>
                        <td class="cs6E02D7D2" colspan="2" style="width:77px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->FR.'</td>
                        <td class="cs6E02D7D2" colspan="4" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->Oxygene.'</td>
                        <td class="cs6C28398D" colspan="8" style="width:119px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->cas_triage.'</td>
                        <td class="csCCF52DC3" colspan="9" style="width:235px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                    </tr>
                ';    
            }

        return $output;

    }



    function showConsultations($id)
    {

            $data = DB::table('tdetailconsultation')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tdetailconsultation.id","refEnteteCons","refTypeCons","plainte","historique",
            "antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons",'AutresDiagnostics',"tdetailconsultation.author","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin","noms_medecin",
            "sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tdetailconsultation.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {

                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:83px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs6E02D7D2" colspan="7" style="width:138px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->plainte.'</td>
                        <td class="cs6E02D7D2" colspan="7" style="width:109px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->historique.'</td>
                        <td class="cs6E02D7D2" colspan="6" style="width:119px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->antecedent.'</td>
                        <td class="cs6E02D7D2" colspan="5" style="width:112px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->complementanamnese.'</td>
                        <td class="cs6E02D7D2" colspan="6" style="width:106px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->examenphysique.'</td>
                        <td class="cs6E02D7D2" colspan="7" style="width:113px;height:81px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->diagnostiquePres.'</td>
                        <td class="cs6C28398D" colspan="6" style="width:97px;height:81px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->AutresDiagnostics.'</td>
                        <td class="csCCF52DC3" colspan="3" style="width:138px;height:81px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                    </tr>   
                
                ';
   
            }

        return $output;

    }



    function showPrescriptionMedicale($id)
    {

            $data = DB::table('tprescriptionmedicament')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tprescriptionmedicament.refdetailCons')
            ->join('tconf_medicament','tconf_medicament.id','=','tprescriptionmedicament.refmedicament')
            ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tprescriptionmedicament.id",'refdetailCons',"tprescriptionmedicament.refmedicament",
            "quantite","dosage","detailprescription",
             "tprescriptionmedicament.author", "tprescriptionmedicament.created_at", 
             "tprescriptionmedicament.updated_at","nom_medicament","refcategoriemedicament","pu_medicament",
             "forme","nom_categoriemedicament","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(quantite*dosage) as quantiteTotal')
            ->where('refMouvement', $id)
            ->orderBy("tprescriptionmedicament.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_medicament.'</td>
                        <td class="cs6E02D7D2" colspan="5" style="width:55px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->quantiteTotal.'</td>
                        <td class="cs6C28398D" colspan="10" style="width:210px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                ';   
            }

        return $output;

    }





    function showActeMedicale($id)
    {

            $data = DB::table('tfin_actesposemedecin')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tfin_actesposemedecin.refDetailCons')
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','tfin_actesposemedecin.refActemedecin')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tfin_actesposemedecin.id",'refDetailCons',"tfin_actesposemedecin.refActemedecin",'descriptionacte',
            "tfin_actesposemedecin.author", "tfin_actesposemedecin.created_at","tfin_actesposemedecin.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe',
            'nom_typeposition',"nom_typecompte","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
            'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tfin_actesposemedecin.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_acte.'</td>
                <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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
                ';   
            }

        return $output;

    }



    function showDiagnosticDefinit($id)
    {

            $data = DB::table('tdiagnosticdefinitif')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tdiagnosticdefinitif.refdetailCons')
            ->join('tconf_maladie','tconf_maladie.id','=','tdiagnosticdefinitif.refmaladie')
            ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tdiagnosticdefinitif.id",'refdetailCons',"tdiagnosticdefinitif.refmaladie",'descriptiondiagnostic',
             "tdiagnosticdefinitif.author", "tdiagnosticdefinitif.created_at", "tdiagnosticdefinitif.updated_at","nom_maladie",
            "refcategoriemaladie","nom_categoriemaladie","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tdiagnosticdefinitif.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs22DF2452" colspan="16" style="width:343px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_maladie.'</td>
                        <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                ';   
            }

        return $output;

    }



    function showResumeClinique($id)
    {

            $data = DB::table('tfin_resumeclinique')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tfin_resumeclinique.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tfin_resumeclinique.id",'refDetailCons','detailresume',"tfin_resumeclinique.author",
             "tfin_resumeclinique.created_at",
             "tfin_resumeclinique.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
             'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tfin_resumeclinique.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs22DF2452" colspan="16" style="width:343px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->detailresume.'</td>
                        <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                ';   
            }

        return $output;

    }






    function showAutresOrientations($id)
    {

            $data = DB::table('tfin_orientationcons')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tfin_orientationcons.refDetailCons')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("tfin_orientationcons.id",'refDetailCons','detailorientation',"tfin_orientationcons.author", "tfin_orientationcons.created_at",
             "tfin_orientationcons.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
             "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
             "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tfin_orientationcons.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->detailorientation.'</td>
                    <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'obr></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr> ';   
            }

        return $output;

    }




    function showExamenLabo($id)
    {

            $data = DB::table('tentetelabo')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')            
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
            ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            //MALADE
            ->select("tentetelabo.id","refEntetePrelevement","tentetelabo.refExamen","serviceProvenance","dateLabo",
            'statutentetelabo', "tentetelabo.author", "tentetelabo.created_at",'refDetailCons','refService','dateprelevement',
            'numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tentetelabo.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin',
            'dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at","tenteteconsulter.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
            "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
            "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tentetelabo.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='

                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td class="cs22DF2452" colspan="21" style="width:400px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designationEx.'</td>
                <td class="cs6E02D7D2" colspan="13" style="width:277px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designationCatEx.'</td>
                <td class="cs6C28398D" colspan="11" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                <td></td>
            </tr>

                ';   
            }

        return $output;

    }


    function showAnalyseImagerie($id)
    {

            $data = DB::table('tim_imagerie')
            ->join('tim_analyse','tim_analyse.id','=','tim_imagerie.refAnalyse')
            ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_imagerie.refDetailConst')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons') 
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons') 
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
      
            ->select("tim_imagerie.id","tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_imagerie.author",
            "tim_imagerie.created_at","tim_imagerie.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("tim_imagerie.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='

                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs22DF2452" colspan="20" style="width:399px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nomAnalyse.'</td>
                        <td class="cs6E02D7D2" colspan="14" style="width:278px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nomTypeAnalyse.'</td>
                        <td class="cs6C28398D" colspan="10" style="width:256px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                    </tr>

                ';   
            }

        return $output;

    }





    function showHospitalisation($id)
    {

            $data = DB::table('thospitalisation')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','thospitalisation.refServiceHospi')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
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
            ->select("thospitalisation.id",'dateEntree','diagnosticEntree','thospitalisation.observations','statutHospi',
            'dateHospi','refDetailCons',"refLit",'nom_lit','refSalle','refServiceHospi','serviceOrigine',
            'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons",'TypeOrientationHosp')
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("thospitalisation.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs6E02D7D2" colspan="8" style="width:186px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->diagnosticEntree.'</td>
                        <td class="cs6E02D7D2" colspan="4" style="width:83px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->dateEntree.'</td>
                        <td class="cs6E02D7D2" colspan="8" style="width:129px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->serviceOrigine.'</td>
                        <td class="cs6E02D7D2" colspan="5" style="width:112px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->nom_uniteproduction.'</td>
                        <td class="cs6E02D7D2" colspan="7" style="width:118px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->nom_lit.'</td>
                        <td class="cs6E02D7D2" colspan="4" style="width:69px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->nom_lit.'</td>
                        <td class="cs6C28398D" colspan="6" style="width:97px;height:40px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->statutHospi.'</td>
                        <td class="csCCF52DC3" colspan="3" style="width:138px;height:40px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                    </tr>
                ';   
            }

        return $output;

    }




    function showEvolutionMedicale($id)
    {

            $data = DB::table('trea_evolution_rea')
            ->join('thospitalisation','thospitalisation.id','=','trea_evolution_rea.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //
            ->select("trea_evolution_rea.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',
            "refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "trea_evolution_rea.author","trea_evolution_rea.created_at","trea_evolution_rea.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin',
            'dateConsultation',"matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
            "tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("trea_evolution_rea.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->observation.'</td>
                        <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                ';   
            }

        return $output;

    }






    function showActeInfirmier($id)
    {

            $data = DB::table('thospi_acte_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_acte_infirmier.refHospi')           
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')           
            ->join('tfin_actesmedecin','tfin_actesmedecin.id','=','thospi_acte_infirmier.refActeMedical')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_actesmedecin.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //
            ->select("thospi_acte_infirmier.id","thospi_acte_infirmier.Description","thospi_acte_infirmier.auther",
             "thospi_acte_infirmier.created_at","thospi_acte_infirmier.updated_at",
            'refSscompte','nom_acte','prix_acte','prix_convention','code_acte',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte","refHospi","refActeMedical",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospitalisation.author","thospitalisation.created_at","thospitalisation.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("thospi_acte_infirmier.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                    $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->nom_acte.'</td>
                    <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
             ';   
            }

        return $output;

    }


    function showObservationInfirmier($id)
    {

            $data = DB::table('thospi_observation_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_observation_infirmier.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //
            ->select("thospi_observation_infirmier.id","observation","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi',
            'refDetailCons',"refLit",'nom_lit','refSalle',
            "nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "thospi_observation_infirmier.author","thospi_observation_infirmier.created_at",
            "thospi_observation_infirmier.updated_at",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin',
            'dateConsultation',"matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("thospi_observation_infirmier.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                    $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="16" style="width:344px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->observation.'</td>
                    <td class="cs6C28398D" colspan="15" style="width:266px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
             ';   
            }

        return $output;

    }





    function showAppreciationInfirmier($id)
    {

            $data = DB::table('thospi_appreciation_infirmier')
            ->join('thospitalisation','thospitalisation.id','=','thospi_appreciation_infirmier.refHospi')
            ->join('tdetailconsultation','tdetailconsultation.id','=','thospitalisation.refDetailCons')
            ->join('tlit','tlit.id','=','thospitalisation.refLit')
            ->join('tsalle','tsalle.id','=','tlit.refSalle')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')
            ->join('ttypeconsultation','ttypeconsultation.id','=','tdetailconsultation.refTypeCons')
            ->join('tmedecin','tmedecin.id','=','tenteteconsulter.refMedecin')
            ->join('tdetailtriage','tdetailtriage.id','=','tenteteconsulter.refDetailTriage')
            ->join('tentetetriage','tentetetriage.id','=','tdetailtriage.refEnteteTriage')
            ->join('tmouvement','tmouvement.id','=','tentetetriage.refMouvement')
            ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
            ->join('tclient','tclient.id','=','tmouvement.refMalade')
            ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
            ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
            ->join('communes' , 'communes.id','=','quartiers.idCommune')
            ->join('villes' , 'villes.id','=','communes.idVille')
            ->join('provinces' , 'provinces.id','=','villes.idProvince')
            ->join('pays' , 'pays.id','=','provinces.idPays')
            //
            ->select("thospi_appreciation_infirmier.id","degreSatisfaction","remarques","infirmier","sugestion","refHospi",
            'dateEntree','diagnosticEntree','thospitalisation.observations','dateHospi','refDetailCons',"refLit",
            'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
            "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
            "thospi_appreciation_infirmier.infirmier as author","thospi_appreciation_infirmier.created_at",
            "thospi_appreciation_infirmier.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refMouvement', $id)
            ->orderBy("thospi_appreciation_infirmier.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                    $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:51px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs22DF2452" colspan="11" style="width:244px;height:49px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->degreSatisfaction.'</td>
                    <td class="cs6E02D7D2" colspan="12" style="width:253px;height:49px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->remarques.'</td>
                    <td class="cs6E02D7D2" colspan="17" style="width:235px;height:49px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->sugestion.'</td>
                    <td class="cs6C28398D" colspan="5" style="width:203px;height:49px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->author.'</td>
                </tr>             ';   
            }

        return $output;

    }








}
