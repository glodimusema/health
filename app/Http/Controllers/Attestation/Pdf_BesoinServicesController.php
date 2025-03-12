<?php

namespace App\Http\Controllers\Attestation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_BesoinServicesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;




    //=========================================================================================================================
    //====================== BESOIN SERVICE ================================================================================



    function pdf_besoinservices_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBesoinServices($id);
            $pdf = \App::make('dompdf.wrapper');
            // echo($html);
            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBesoinServices($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $age_malade=0;
                $nom_service='';
                $nom_salle='';
                $sexe_malade='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $medecin1='';
                $codeDossier='';
                $dateNaissance_malade='';
                $numroBon='';                
                $Poids=0;              
                $codeOperation='';
                
                $data = DB::table('tmed_entetebesoin')
                ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
                ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
                ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
                ->select("tmed_entetebesoin.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
                'PrixSalle',"date_besoin","tmed_entetebesoin.author","tmed_entetebesoin.created_at",
                "tmed_entetebesoin.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
                "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
                "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
                "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
                "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("OM",YEAR(tmed_entetebesoin.created_at),"",MONTH(tmed_entetebesoin.created_at),"00",tmed_entetebesoin.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tmed_entetebesoin.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $age_malade=$row->age_malade;
                    $nom_service=$row->nom_service;
                    $nom_salle=$row->nom_salle;
                    $sexe_malade=$row->sexe_malade;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;
                    $medecin1=$row->author;
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;                    
                    $numroBon=$row->numroBon;                    
                    // $Poids=$row->Poids;  
                    $codeOperation=$row->codeOperation;            
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
                    <title>OrdonnanceMedicale</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs388CADE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:627px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:102px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:81px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="12" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="12" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="12" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="12" style="width:488px;height:14px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:14px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:14px;"></td>
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
                        <td class="cs7D52592D" colspan="11" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>ETAT DE BESOIN POUR MALADE</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:5px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9D95F7CD" style="width:13px;height:7px;"></td>
                        <td class="csA49D7241" style="width:46px;height:7px;"></td>
                        <td class="csA49D7241" colspan="3" style="width:144px;height:7px;"></td>
                        <td class="csA49D7241" style="width:102px;height:7px;"></td>
                        <td class="csA49D7241" style="width:52px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:68px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:24px;height:7px;"></td>
                        <td class="csA49D7241" colspan="5" style="width:156px;height:7px;"></td>
                        <td class="csA49D7241" style="width:81px;height:7px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:25px;"></td>
                        <td class="cs388CADE" style="width:46px;height:25px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:25px;"></td>
                        <td class="cs388CADE" style="width:102px;height:25px;"></td>
                        <td class="cs388CADE" style="width:52px;height:25px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:25px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:25px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:25px;"></td>
                        <td class="cs388CADE" style="width:81px;height:25px;"></td>
                        <td class="cs671B350" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie&#160;:</nobr></td>
                        <td class="cs12FE94AA" colspan="7" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe_malade.' - Age : '.$age_malade.' ans   </nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&#160;:</nobr></td>
                        <td class="cs12FE94AA" colspan="7" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$organisationAbonne.'</nobr></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Service&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nom_service.'&nbsp;</nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Salle&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nom_salle.'&nbsp;</nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:8px;"></td>
                        <td class="cs388CADE" style="width:46px;height:8px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:8px;"></td>
                        <td class="cs388CADE" style="width:102px;height:8px;"></td>
                        <td class="cs388CADE" style="width:52px;height:8px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:8px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:8px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:8px;"></td>
                        <td class="cs388CADE" style="width:81px;height:8px;"></td>
                        <td class="cs671B350" style="width:6px;height:8px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" style="width:46px;height:22px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N.&nbsp;R&#233;f&nbsp;:&nbsp;'.$codeOperation.'</nobr></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:6px;"></td>
                        <td class="csC4190C00" style="width:46px;height:6px;"></td>
                        <td class="csC4190C00" colspan="3" style="width:144px;height:6px;"></td>
                        <td class="csC4190C00" style="width:102px;height:6px;"></td>
                        <td class="csC4190C00" style="width:52px;height:6px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:68px;height:6px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:24px;height:6px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:156px;height:6px;"></td>
                        <td class="csC4190C00" style="width:81px;height:6px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:10px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:10px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:10px;"></td>
                        <td class="cs671B350" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:24px;"></td>
                        <td class="cs58AC6944" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>QTE</nobr></td>
                        <td class="cs36E0C1B8" colspan="7" style="width:260px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUITS</nobr></td>
                        <td class="cs36E0C1B8" colspan="5" style="width:221px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MEDECIN(CNOM)</nobr></td>
                        <td class="cs671B350" style="width:6px;height:24px;"></td>
                    </tr>
                    ';                        
                        $output .= $this->showDetailBesoin($id);                        
                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:21px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:21px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:21px;"></td>
                        <td class="cs671B350" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:22px;"></td>
                        <td class="cs38AECAED" colspan="7" style="width:237px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>'.$medecin1.' : Signature</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:7px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:7px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:7px;"></td>
                        <td class="cs671B350" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:22px;"></td>
                        <td class="cs76421F2" colspan="7" style="width:237px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:96px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:94px;height:38px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:242px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:19px;height:38px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:222px;height:38px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:38px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    function showDetailBesoin($id)
    {
            $data = DB::table('tmed_detailbesoin')
            //tmed_detailbesoin id,refEnteteVente,refmedicament,qte_besoin,pu_besoin,observation_besoin,author
             ->join('tconf_medicament','tconf_medicament.id','=','tmed_detailbesoin.refmedicament')
             ->join('tconf_categoriemedicament','tconf_categoriemedicament.id','=','tconf_medicament.refcategoriemedicament')
             ->join('tmed_entetebesoin','tmed_entetebesoin.id','=','tmed_detailbesoin.refEnteteVente')
             ->join('tsalle','tsalle.id','=','tmed_entetebesoin.refSalle')
             ->join('tservice_hopital','tservice_hopital.id','=','tmed_entetebesoin.refService')
             ->join('tmouvement','tmouvement.id','=','tmed_entetebesoin.refMouvement')
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
             ->select("tmed_detailbesoin.id",'refEnteteVente','refmedicament','pu_besoin','qte_besoin',
             'observation_besoin',"refMouvement","refService","refSalle","nom_service",'nom_salle',
             'PrixSalle',"date_besoin","nom_medicament","refcategoriemedicament","pu_medicament",
             "forme","nom_categoriemedicament","tmed_detailbesoin.author","tmed_detailbesoin.created_at",
             "tmed_detailbesoin.updated_at","refMalade","refTypeMouvement","dateMouvement",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
             "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
             "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
             "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
             "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
             "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
             "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
             "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_besoin*pu_besoin) as PTVente')
            ->where('tmed_detailbesoin.refEnteteVente','=', $id)
            ->orderBy("tmed_detailbesoin.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:24px;"></td>
                <td class="csFBCBEF30" colspan="2" style="width:94px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->date_besoin.'</td>
                <td class="csDC7EEB9" colspan="2" style="width:93px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->qte_besoin.'</td>
                <td class="csDC7EEB9" colspan="7" style="width:260px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_medicament.'</td>
                <td class="csDC7EEB9" colspan="5" style="width:221px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs671B350" style="width:6px;height:24px;"></td>
            </tr>            
                ';                 
    
            }

        return $output;

    }



//=========================================================================================================================
//====================== UTILISATION SERVICE ================================================================================



    function pdf_usageservices_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoUsageServices($id);
            $pdf = \App::make('dompdf.wrapper');
            // echo($html);
            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoUsageServices($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $age_malade=0;
                $nom_service='';
                $nom_salle='';
                $sexe_malade='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $medecin1='';
                $codeDossier='';
                $dateNaissance_malade='';
                $numroBon='';                
                $Poids=0;              
                $codeOperation='';
                
                $data = DB::table('tmed_entete_usageservice')
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
                //MALADE
                ->select("tmed_entete_usageservice.id","refMouvement","refService","refSalle","nom_service",'nom_salle',
                'PrixSalle',"date_usage","tmed_entete_usageservice.author","tmed_entete_usageservice.created_at",
                "tmed_entete_usageservice.updated_at","refMalade","refTypeMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"dateMouvement","numroBon","Statut",
                "dateSortieMvt","motifSortieMvt","autoriseSortieMvt","ttypemouvement_malade.designation as Typemouvement",
                "noms","contact","mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo",
                "slug","nomAvenue","idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
                "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade","dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("OM",YEAR(tmed_entete_usageservice.created_at),"",MONTH(tmed_entete_usageservice.created_at),"00",tmed_entete_usageservice.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tmed_entete_usageservice.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $age_malade=$row->age_malade;
                    $nom_service=$row->nom_service;
                    $nom_salle=$row->nom_salle;
                    $sexe_malade=$row->sexe_malade;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;
                    $medecin1=$row->author;
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;                    
                    $numroBon=$row->numroBon;                    
                    // $Poids=$row->Poids;  
                    $codeOperation=$row->codeOperation;            
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
                    <title>OrdonnanceMedicale</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs755F1C83 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csA49D7241 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAAE7D8C6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs671B350 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csC4190C00 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs388CADE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:627px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:102px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:81px;"></td>
                        <td style="height:0px;width:9px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="12" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="12" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="12" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="12" style="width:488px;height:14px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:14px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:14px;"></td>
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
                        <td class="cs7D52592D" colspan="11" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FICHE USAGES DES PRODUITS</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:5px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9D95F7CD" style="width:13px;height:7px;"></td>
                        <td class="csA49D7241" style="width:46px;height:7px;"></td>
                        <td class="csA49D7241" colspan="3" style="width:144px;height:7px;"></td>
                        <td class="csA49D7241" style="width:102px;height:7px;"></td>
                        <td class="csA49D7241" style="width:52px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:68px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:24px;height:7px;"></td>
                        <td class="csA49D7241" colspan="5" style="width:156px;height:7px;"></td>
                        <td class="csA49D7241" style="width:81px;height:7px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:25px;"></td>
                        <td class="cs388CADE" style="width:46px;height:25px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:25px;"></td>
                        <td class="cs388CADE" style="width:102px;height:25px;"></td>
                        <td class="cs388CADE" style="width:52px;height:25px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:25px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:25px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:25px;"></td>
                        <td class="cs388CADE" style="width:81px;height:25px;"></td>
                        <td class="cs671B350" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie&#160;:</nobr></td>
                        <td class="cs12FE94AA" colspan="7" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe_malade.' - Age : '.$age_malade.' ans   </nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&#160;:</nobr></td>
                        <td class="cs12FE94AA" colspan="7" style="width:178px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$organisationAbonne.'</nobr></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Service&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nom_service.'&nbsp;</nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Salle&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nom_salle.'&nbsp;</nobr></td>
                        <td class="cs388CADE" style="width:52px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:8px;"></td>
                        <td class="cs388CADE" style="width:46px;height:8px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:8px;"></td>
                        <td class="cs388CADE" style="width:102px;height:8px;"></td>
                        <td class="cs388CADE" style="width:52px;height:8px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:68px;height:8px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:24px;height:8px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:8px;"></td>
                        <td class="cs388CADE" style="width:81px;height:8px;"></td>
                        <td class="cs671B350" style="width:6px;height:8px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" style="width:46px;height:22px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:144px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N.&nbsp;R&#233;f&nbsp;:&nbsp;'.$codeOperation.'</nobr></td>
                        <td class="cs388CADE" colspan="5" style="width:156px;height:22px;"></td>
                        <td class="cs388CADE" style="width:81px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:6px;"></td>
                        <td class="csC4190C00" style="width:46px;height:6px;"></td>
                        <td class="csC4190C00" colspan="3" style="width:144px;height:6px;"></td>
                        <td class="csC4190C00" style="width:102px;height:6px;"></td>
                        <td class="csC4190C00" style="width:52px;height:6px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:68px;height:6px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:24px;height:6px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:156px;height:6px;"></td>
                        <td class="csC4190C00" style="width:81px;height:6px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:10px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:10px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:10px;"></td>
                        <td class="cs671B350" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:24px;"></td>
                        <td class="cs58AC6944" colspan="2" style="width:94px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:93px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>QTE</nobr></td>
                        <td class="cs36E0C1B8" colspan="7" style="width:260px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUITS</nobr></td>
                        <td class="cs36E0C1B8" colspan="5" style="width:221px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MEDECIN(CNOM)</nobr></td>
                        <td class="cs671B350" style="width:6px;height:24px;"></td>
                    </tr>
                    ';                        
                        $output .= $this->showDetailUsage($id);                        
                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:21px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:21px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:21px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:21px;"></td>
                        <td class="cs671B350" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:22px;"></td>
                        <td class="cs38AECAED" colspan="7" style="width:237px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>'.$medecin1.' : Signature</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:7px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:7px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:19px;height:7px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:222px;height:7px;"></td>
                        <td class="cs671B350" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:96px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:94px;height:22px;"></td>
                        <td class="cs388CADE" colspan="5" style="width:242px;height:22px;"></td>
                        <td class="cs76421F2" colspan="7" style="width:237px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:41px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:96px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:94px;height:38px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:242px;height:38px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:19px;height:38px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:222px;height:38px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:38px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    function showDetailUsage($id)
    {
            $data = DB::table('tmed_detail_usageservice')
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
            //MALADE
            ->select("tmed_detail_usageservice.id",'refEnteteVente','refmedicament','pu_usage','qte_usage',
            'observation_usage',"refMouvement","refService","refSalle","nom_service",'nom_salle',
            'PrixSalle',"date_usage","nom_medicament","refcategoriemedicament","pu_medicament",
            "forme","nom_categoriemedicament","tmed_detail_usageservice.author","tmed_detail_usageservice.created_at",
            "tmed_detail_usageservice.updated_at","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',
            "numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
            "tcategorieclient.designation as Categorie","photo","slug","nomAvenue","idCommune","nomQuartier",
            "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
            "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
            "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade",
            "numeroCarte_malade","dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('(qte_usage*pu_usage) as PTVente')
            ->where('tmed_detail_usageservice.refEnteteVente','=', $id)
            ->orderBy("tmed_detail_usageservice.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:24px;"></td>
                <td class="csFBCBEF30" colspan="2" style="width:94px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->date_usage.'</td>
                <td class="csDC7EEB9" colspan="2" style="width:93px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->qte_usage.'</td>
                <td class="csDC7EEB9" colspan="7" style="width:260px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_medicament.'</td>
                <td class="csDC7EEB9" colspan="5" style="width:221px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->author.'</td>
                <td class="cs671B350" style="width:6px;height:24px;"></td>
            </tr>            
                ';                 
    
            }

        return $output;

    }








}
