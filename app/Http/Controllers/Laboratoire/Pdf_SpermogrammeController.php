<?php

namespace App\Http\Controllers\Laboratoire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_SpermogrammeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;






    //=========================================================================================================================
    //====================== RESULTAT SPERMOGRAMME ================================================================================



    function pdf_resultatsperme_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoSpermogramme($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoSpermogramme($id)
    {

                $titres="RESULTAT SPERMOGRAMME";
                $nat="l'";

                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $numroRecu='';
                $codePreleve='';
                $codeDossier='';
                $sexe_malade='';
                $age_malade=0;
                $MedecinDemandeur='';                
                $dateprelevement='';

                $echantillons='';
                
                $data = DB::table('tlabo_entete_prelevement')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
                ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
                "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
                'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
                "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
                "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
                "sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tlabo_entete_prelevement.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;                    
                    $codeDossier=$row->codeDossier;                    
                    $sexe_malade=$row->sexe_malade;                    
                    $age_malade=$row->age_malade;                 
                    $numroRecu=$row->numroRecu;
                    $codePreleve=$row->codePreleve;                    
                    $MedecinDemandeur=$row->MedecinDemandeur;                
                    $dateprelevement=$row->dateprelevement;
                }


                $data2 = DB::table('tlabo_detail_prelevement')
                ->join('tconf_natureechantillon','tconf_natureechantillon.id','=','tlabo_detail_prelevement.refEchantillon')
                ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tlabo_detail_prelevement.refEntetePrelevement')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
                ->select("tconf_natureechantillon.designation")
                ->where('tlabo_detail_prelevement.refEntetePrelevement', $id)
                ->get();
                $output='';
                foreach ($data2 as $row) 
                { 
                    $temps=$row->designation;        
                    $echantillons= $echantillons.' - '.$temps;                  
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
                    <title>RESULTAT SPERMOGRAMME</title>
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:575px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:63px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:161px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:169px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="10" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="10" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="3" style="width:13px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:14px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:14px;"></td>
                        <td class="csE7D235EF" style="width:169px;height:14px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="16" style="width:694px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RESULTAT&nbsp;SPERMOGRAMME</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:7px;height:7px;"></td>
                        <td class="csA49D7241" style="width:1px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:68px;height:7px;"></td>
                        <td class="csA49D7241" style="width:33px;height:7px;"></td>
                        <td class="csA49D7241" colspan="3" style="width:240px;height:7px;"></td>
                        <td class="csA49D7241" style="width:25px;height:7px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:80px;height:7px;"></td>
                        <td class="csA49D7241" colspan="4" style="width:232px;height:7px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs388CADE" style="width:1px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:99px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;du&nbsp;Malade&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:238px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs388CADE" style="width:1px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs388CADE" style="width:1px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$age_malade.'&nbsp;Ans</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs388CADE" style="width:1px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.' - '.$organisationAbonne.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:78px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Demandeur&#160;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:230px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$MedecinDemandeur.'</td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs388CADE" style="width:1px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:66px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;de&nbsp;re&#231;u&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$numroRecu.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>ID&nbsp;Labo&#160;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$codePreleve.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:7px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&#160;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateprelevement.'</td>
                        <td class="cs388CADE" style="width:25px;height:22px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:232px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:7px;height:8px;"></td>
                        <td class="csC4190C00" style="width:1px;height:8px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:68px;height:8px;"></td>
                        <td class="csC4190C00" style="width:33px;height:8px;"></td>
                        <td class="csC4190C00" colspan="3" style="width:240px;height:8px;"></td>
                        <td class="csC4190C00" style="width:25px;height:8px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:80px;height:8px;"></td>
                        <td class="csC4190C00" colspan="4" style="width:232px;height:8px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:8px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="6" style="width:271px;height:22px;line-height:15px;text-align:left;vertical-align:top;">Nature&nbsp;de&nbsp;'.$nat.'&#233;chantillon&nbsp;:&nbsp;&nbsp;&nbsp;'.$echantillons.'</td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="7" style="width:325px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PARAMETRES</nobr></td>
                        <td class="cs36E0C1B8" colspan="5" style="width:170px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RESULTATS</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:199px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>VALEURS&nbsp;DE&nbsp;REFERENCES</nobr></td>
                    </tr>
                    ';                        
                                        $output .= $this->showResultatSperme($id);                        
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
                        <td class="cs76421F2" colspan="4" style="width:196px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>RESPONSABLE DE LABORATOIRE</nobr></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    function showResultatSperme($id)
    {
            $data = DB::table('tlabo_resultat_sperme')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_sperme.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tlabo_nature_echantillon','tlabo_nature_echantillon.id','=','tlabo_resultat_sperme.refNatureEchantillon')
            ->join('tlabo_categorie_echantillon','tlabo_categorie_echantillon.id','=','tlabo_nature_echantillon.refCategorieEchantillon')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
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
            ->join('avenues', 'avenues.id','=','tclient.refAvenue')
            ->join('quartiers','quartiers.id','=','avenues.idQuartier')
            ->join('communes','communes.id','=','quartiers.idCommune')
            ->join('villes','villes.id','=','communes.idVille')
            ->join('provinces','provinces.id','=','villes.idProvince')
            ->join('pays','pays.id','=','provinces.idPays')
            //MALADE
            ->select("tlabo_resultat_sperme.id",'refNatureEchantillon','tlabo_resultat_sperme.designation_valeur as resultat_sperme',
            'refDetailCons','tlabo_nature_echantillon.designation_valeur as designation_valeur',
            "refCategorieEchantillon","designation_nature","tlabo_categorie_echantillon.nom_categorieechantillon",
            "tentetelabo.refExamen","dateLabo", "tlabo_resultat_sperme.author",'refEntetePrelevement',
            'refService','dateprelevement','numroRecu','MedecinDemandeur','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement',"tlabo_resultat_sperme.created_at", 
            "tlabo_resultat_sperme.updated_at","texamen.designation as designationEx","refCatexamen",
            "tcategorieexament.designation as designationCatEx","refGrandCategorie",
            "tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","plainte",
            "historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
            "contactPersRef_malade","organisation_malade","numeroCarte_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refEntetePrelevement','=', $id)
            ->orderBy("tlabo_resultat_sperme.created_at", "asc")
            ->get();
            $output='';

            // designation_valeur

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csFBCBEF30" colspan="7" style="width:325px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$row->designation_nature.'</td>
                        <td class="csDC7EEB9" colspan="5" style="width:170px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->resultat_sperme.'</td>
                        <td class="csDC7EEB9" colspan="4" style="width:199px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->designation_valeur.'</td>
                    </tr>
                ';

        
    
            }

        return $output;

    }








    //=========================================================================================================================
    //====================== RESULTAT BACTERIOLOGIE ================================================================================



    function pdf_resultatbacteriologie_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInforBacteriologie($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInforBacteriologie($id)
    {

                $titres="RESULTAT BACTERIOLOGIE";
                $anal="l'analyse";

                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $numroRecu='';
                $codePreleve='';
                $codeDossier='';
                $sexe_malade='';
                $age_malade=0;
                $MedecinDemandeur='';                
                $datePreleveur='';
                $dateResultat='';

                $aspectmacro='';
                $autresGerme='';
                $examenFrais='';
                $autreColoration='';
                $Sensible='';
                $Intermediaire='';
                $resistant='';
                $technicien='';
                $directeurTechnique='';
                $adresses='';



                //'','','','','','','',''

                
                
                $data = DB::table('tlabo_resultat_bacteriologie')
                ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
                ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
                ->join('texamen','texamen.id','=','tentetelabo.refExamen')
                ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
                ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
                ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
                ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
                ->select("tlabo_resultat_bacteriologie.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
                'dateResultat','aspectmacro','examenFrais','autreColoration','autresGerme','Sensible','Intermediaire','resistant','technicien',
                'directeurTechnique','refEntetePrelevement','refDetailCons','refService','tlabo_entete_prelevement.dateprelevement as datePreleveur',
                'numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo","texamen.designation as designationEx",
                "refCatexamen","tcategorieexament.designation as designationCatEx",
                "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
                "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_resultat_bacteriologie.author",
                "tlabo_resultat_bacteriologie.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
                "tlabo_resultat_bacteriologie.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
                "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
                "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("Com.",nomCommune," ; Q.",nomQuartier," ; Av.",nomAvenue," ; N° : ",numeroMaison_malade) as adresses')
                ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('refEntetePrelevement', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;                    
                    $codeDossier=$row->codeDossier;                    
                    $sexe_malade=$row->sexe_malade;                    
                    $age_malade=$row->age_malade;                 
                    $numroRecu=$row->numroRecu;
                    $codePreleve=$row->codePreleve;                    
                    $MedecinDemandeur=$row->MedecinDemandeur;                
                    $datePreleveur=$row->datePreleveur;
                    $dateResultat=$row->dateResultat;
                    $adresses=$row->adresses;
                    //autreColoration
                    $aspectmacro=$row->aspectmacro;
                    $autresGerme=$row->autresGerme;
                    $examenFrais=$row->examenFrais;
                    $autreColoration=$row->autreColoration;
                    $Sensible=$row->Sensible;
                    $Intermediaire=$row->Intermediaire;
                    $resistant=$row->resistant;
                    $technicien=$row->technicien;
                    $directeurTechnique=$row->directeurTechnique;
                }


                $echantillons='';
                $data2 = DB::table('tlabo_detail_prelevement')
                ->join('tconf_natureechantillon','tconf_natureechantillon.id','=','tlabo_detail_prelevement.refEchantillon')
                ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tlabo_detail_prelevement.refEntetePrelevement')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
                ->select("tlabo_detail_prelevement.id",'refEntetePrelevement','refEchantillon','refDetailCons',
                'refService','dateprelevement','numroRecu','MedecinDemandeur',"tconf_natureechantillon.designation",
                "tlabo_detail_prelevement.author", "tlabo_detail_prelevement.created_at",
                'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
                "tlabo_detail_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
                "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
                'refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tlabo_detail_prelevement.refEntetePrelevement', $id)
                ->get();
                $output='';
                foreach ($data2 as $row) 
                {         
                    $echantillons=$echantillons.' - '.$row->designation;                  
                }

                $ech="L'ECHANTILLON";
                $execs="l'ex";

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
                    <title>RESULTAT BACTERIOLOGIE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs79DF234B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs990B052E {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs38AECAED {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs66EA1E29 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:890px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:68px;"></td>
                        <td style="height:0px;width:96px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:19px;"></td>
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
                        <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="16" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="16" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="16" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="16" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="16" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="16" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="24" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RESULTATS&nbsp;DES&nbsp;ANALYSES&nbsp;BACTERIOLOGIQUES</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:5px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:69px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:20px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:22px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:25px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:68px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:96px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:65px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:157px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:59px;height:6px;"></td>
                        <td class="cs62ED362D" colspan="2" style="width:25px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="6" style="width:114px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NOM&nbsp;/&nbsp;PRENOM&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="15" style="width:544px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>AGE&nbsp;(ans)&nbsp;:</nobr></td>
                        <td class="cs38AECAED" colspan="3" style="width:42px;height:22px;line-height:15px;text-align:center;vertical-align:top;">'.$age_malade.'</td>
                        <td class="cs12FE94AA" colspan="3" style="width:43px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="12" style="width:499px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:149px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>ADRESSE&nbsp;COMPLETE&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="13" style="width:509px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$adresses.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="12" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="12" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:198px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>NATURE&nbsp;DE&nbsp;'.$ech.'&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="10" style="width:460px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$echantillons.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;LABO&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="18" style="width:590px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$codePreleve.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs66EA1E29" colspan="21" style="width:660px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;du&nbsp;pr&#233;l&#232;vement&nbsp;&nbsp;:&nbsp;'.$datePreleveur.'&nbsp;&nbsp;&nbsp;Date&nbsp;du&nbsp;rendu&nbsp;des&nbsp;r&#233;sultats&nbsp;:&nbsp;'.$dateResultat.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:136px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Aspect&nbsp;macroscopique&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="14" style="width:522px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$aspectmacro.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="5" style="width:102px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Examen&nbsp;&#224;&nbsp;frais&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="7" style="width:101px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$examenFrais.'</td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:5px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:5px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:5px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:5px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:5px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:5px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:5px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:173px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Examen&nbsp;apr&#232;s&nbsp;coloration</nobr></td>
                        <td class="cs101A94F7" style="width:25px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    ';                        
                          $output .= $this->showExamenColore($id);                        
                          $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="21" style="width:660px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Autres&nbsp;colorations&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;'.$autreColoration.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="csCE72709D" colspan="14" style="width:283px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Germe&nbsp;(s)&nbsp;isol&#233;&nbsp;(s)&nbsp;&nbsp;apr&#232;s&nbsp;culture</nobr></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    ';                        
                          $output .= $this->showGerme($id);                        
                          $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:136px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Autres&nbsp;(&#224;&nbsp;pr&#233;ciser)&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="14" style="width:522px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$autresGerme.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:173px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Antibiogramme</nobr></td>
                        <td class="cs101A94F7" style="width:25px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:88px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sensible&nbsp;&#224;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="17" style="width:570px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$Sensible.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:88px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Interm&#233;diaire&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="17" style="width:570px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$Intermediaire.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:88px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>R&#233;sistant&nbsp;&#224;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="17" style="width:570px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$resistant.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:24px;"></td>
                        <td class="cs990B052E" colspan="4" style="width:206px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="12" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Technicien&nbsp;responsable&nbsp;de&nbsp;'.$execs.'&#233;cution</nobr></td>
                        <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="4" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Directeur&nbsp;Technique</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="12" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$technicien.'</td>
                        <td class="cs101A94F7" style="width:68px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="4" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$directeurTechnique.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:22px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:68px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:96px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:65px;height:26px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:157px;height:26px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:26px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:26px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:69px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:24px;"></td>
                        <td class="cs990B052E" colspan="16" style="width:503px;height:18px;line-height:16px;text-align:center;vertical-align:top;"><nobr>Merci&nbsp;pour&nbsp;nous&nbsp;avoir&nbsp;confi&#233;&nbsp;'.$anal.'&nbsp;de&nbsp;cet&nbsp;(ces)&nbsp;&#233;chantillons</nobr></td>
                        <td class="cs101A94F7" style="width:59px;height:24px;"></td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:5px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:69px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:20px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:22px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:25px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:68px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:96px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:65px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:157px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:59px;height:7px;"></td>
                        <td class="cs11B2FA6F" colspan="2" style="width:25px;height:7px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    function showExamenColore($id)
    {
            $data = DB::table('tlabo_detail_examencolore')
            ->join('tlabo_examencolore','tlabo_examencolore.id','=','tlabo_detail_examencolore.refExamenColore')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_examencolore.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_examencolore.id",'refEnteteLabo',"refEntetePrelevement",'tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refExamenColore','Resultatexamen','nom_examencolore',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_examencolore.author",
            "tlabo_detail_examencolore.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_examencolore.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refEntetePrelevement','=', $id)
            ->orderBy("tlabo_detail_examencolore.created_at", "asc")
            ->get();
            $output='';

            // designation_valeur

            foreach ($data as $row) 
            {
                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="21" style="width:656px;height:18px;line-height:15px;text-align:left;vertical-align:top;">'.$row->nom_examencolore.'&nbsp;:&nbsp;&nbsp;'.$row->Resultatexamen.'</td>
                        <td class="cs145AAE8A" colspan="2" style="width:25px;height:24px;"></td>
                    </tr>
                ';
            }

        return $output;

    }




    function showGerme($id)
    {
            $data = DB::table('tlabo_detail_germe')
            ->join('tlabo_germe','tlabo_germe.id','=','tlabo_detail_germe.refGerme')
            ->join('tlabo_resultat_bacteriologie','tlabo_resultat_bacteriologie.id','=','tlabo_detail_germe.refResultatBacterie')
            ->join('tentetelabo','tentetelabo.id','=','tlabo_resultat_bacteriologie.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')                    
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->join('tenteteconsulter','tenteteconsulter.id','=','tdetailconsultation.refEnteteCons')            
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
            ->select("tlabo_detail_germe.id",'refEnteteLabo','tlabo_resultat_bacteriologie.datePrelevement',
            'dateResultat','aspectmacro','refResultatBacterie','refGerme','nom_germe','nom_germe',
            'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','refDetailCons',
            'refService','tlabo_entete_prelevement.dateprelevement as datePreleveur','numroRecu','MedecinDemandeur', "tentetelabo.refExamen","dateLabo",
            "texamen.designation as designationEx","refCatexamen","tcategorieexament.designation as designationCatEx",
            "refGrandCategorie","tgcategorieexament.designation as designationGCatEx","PrixExam","refTube",
            "codeTube","designationTube","couleurTube","refEnteteCons","refTypeCons","tlabo_detail_germe.author",
            "tlabo_detail_germe.created_at",'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
            "tlabo_detail_germe.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
            "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
            "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade","PrixCons")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refEntetePrelevement','=', $id)
            ->orderBy("tlabo_detail_germe.created_at", "asc")
            ->get();
            $output='';

            // designation_valeur

            foreach ($data as $row) 
            {

                    $output .='<tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:5px;height:24px;"></td>
                    <td class="csE314B2A3" colspan="21" style="width:656px;height:18px;line-height:15px;text-align:left;vertical-align:top;">'.$row->nom_germe.'</td>
                    <td class="cs145AAE8A" colspan="2" style="width:25px;height:24px;"></td>
                </tr>';

            }

        return $output;

    }















//============================================================================================================================================
//============================ RAPPORT LABORATOIRE SELON LE ORGANISATION ===================================================================================


public function pdf_rapport_laboratoire_categorie_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('categorie_malade'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $categorie_malade = $request->get('categorie_malade');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListLaboCategorie($date1, $date2, $categorie_malade);       
        $html .='<script>window.print()</script>';
        echo($html);
    }
    else {
        // code...
    }
    
}



function printDataListLaboCategorie($date1, $date2, $categorie_malade)
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

                $datedebut=$date1;
                $datefin=$date2;                

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT LABORATOIRE</title>
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:949px;height:375px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:52px;"></td>
                <td style="height:0px;width:98px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:17px;"></td>
                <td style="height:0px;width:51px;"></td>
                <td style="height:0px;width:181px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:12px;"></td>
                <td style="height:0px;width:168px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="11" style="width:757px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="11" rowspan="2" style="width:757px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td class="csB6F858D0" colspan="13" style="width:935px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;MOUVEMENTS&nbsp;AU&nbsp;LABORATOIRE</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$datedebut.'&nbsp;&nbsp;au&nbsp;'.$datefin.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:602px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$categorie_malade.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:51px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs9FE9304F" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CODE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:215px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:49px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                <td class="cs9FE9304F" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGE</nobr></td>
                <td class="cs9FE9304F" style="width:180px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;&nbsp;-&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ECHANTIONS</nobr></td>
                <td class="csEAC52FCD" colspan="3" style="width:190px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>EXAMENS(RESULTATS)</nobr></td>
            </tr>
            ';
                                    
                 $output .= $this->showPrelevement($date1, $date2,$categorie_malade);
                                    
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
            </tr>
        </table>
        </body>
        </html>
            
        ';  
       
        return $output; 

}

function showPrelevement($date1, $date2,$categoriemaladiemvt)
{
    $count =0;
    $data=DB::table('tlabo_entete_prelevement')
    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
    ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
    "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
    'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
     "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
     "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
     "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
     'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
    "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin",
    "sexe_medecin","datenaissance_medecin",
    "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
    "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
    "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
    "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
    "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
    'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
    "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade","PrixCons")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
    ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
    ->where([
        ['tlabo_entete_prelevement.created_at','>=', $date1],
        ['tlabo_entete_prelevement.created_at','<=', $date2],
        ['organisationAbonne','=', $categoriemaladiemvt],
        ['preleveur','=', 'OUI']
    ])    
    ->orderBy("tlabo_entete_prelevement.id", "asc")
    ->get();


    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        
        $echantillons='';
        $data2 = DB::table('tlabo_detail_prelevement')
        ->join('tconf_natureechantillon','tconf_natureechantillon.id','=','tlabo_detail_prelevement.refEchantillon')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tlabo_detail_prelevement.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
        ->select("tconf_natureechantillon.designation")
        ->where('tlabo_detail_prelevement.refEntetePrelevement', $row->id)
        ->get();
        $output='';
        foreach ($data2 as $row1) 
        {         
            $echantillons=$echantillons.' - '.$row1->designation;                  
        }

        


        $examens='';
        $resultats='';

        $data3 = DB::table('tentetelabo')
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
        //MALADE
        ->select("tentetelabo.id","texamen.designation as designationEx")
        ->where('tentetelabo.refEntetePrelevement', $row->id)
        ->get();
        $output='';
        foreach ($data3 as $row2) 
        {         
            $examens=$examens.' - '.$row2->designationEx;    
            
            $data5 = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->select("tentetelabo.refExamen","tdetaillabo.observation as observation",
            "tdetaillabo.libelle as resultat","tdetaillabo.methode as methode",
            "tdetaillabo.commentaire as commentaire")
            ->where('tdetaillabo.refEnteteLabo', $row2->id)
            ->get();
            foreach ($data5 as $row5) 
            {         
                $resultats=$resultats.' - '.$row5->observation.' - ('.$row5->resultat.') - '.$row5->commentaire;                  
            }

        }
        // $count ++;

        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:35px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:51px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
                <td class="cs6E02D7D2" style="width:97px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeDossier.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:215px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:49px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->sexe_malade.'</td>
                <td class="cs6E02D7D2" style="width:50px;height:33px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->age_malade.'&nbsp;ans</nobr></td>
                <td class="cs6E02D7D2" style="width:180px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categoriemaladiemvt.' - '.$row->organisationAbonne.'</td>
                <td class="cs6E02D7D2" style="width:100px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$echantillons.'</td>
                <td class="cs6C28398D" colspan="3" style="width:190px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$examens.' ('.$resultats.')</td>
            </tr>
        ';       
       

    }

    return $output;

}







//============================================================================================================================================
//============================ RAPPORT LABORATOIRE SELON LE ORGANISATION ===================================================================================


public function pdf_rapport_laboratoire_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListLabo($date1, $date2);       
        $html .='<script>window.print()</script>';
        echo($html);
    }
    else {
        // code...
    }
    
}



function printDataListLabo($date1, $date2)
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

                $datedebut=$date1;
                $datefin=$date2;                

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT LABORATOIRE</title>
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:949px;height:375px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:52px;"></td>
                <td style="height:0px;width:98px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:17px;"></td>
                <td style="height:0px;width:51px;"></td>
                <td style="height:0px;width:181px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:12px;"></td>
                <td style="height:0px;width:168px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="11" style="width:757px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="11" rowspan="2" style="width:757px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td class="csB6F858D0" colspan="13" style="width:935px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;MOUVEMENTS&nbsp;AU&nbsp;LABORATOIRE</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$datedebut.'&nbsp;&nbsp;au&nbsp;'.$datefin.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:602px;height:20px;line-height:18px;text-align:left;vertical-align:top;">TOUS LES PATIENTS</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:51px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs9FE9304F" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CODE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:215px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:49px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                <td class="cs9FE9304F" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGE</nobr></td>
                <td class="cs9FE9304F" style="width:180px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;&nbsp;-&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>ECHANTIONS</nobr></td>
                <td class="csEAC52FCD" colspan="3" style="width:190px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>EXAMENS(RESULTATS)</nobr></td>
            </tr>
            ';
                                    
                 $output .= $this->showPrelevementAll($date1, $date2);
                                    
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
            </tr>
        </table>
        </body>
        </html>
            
        ';  
       
        return $output; 

}

function showPrelevementAll($date1, $date2)
{
    $count =0;
    $data=DB::table('tlabo_entete_prelevement')
    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
    ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
    ->select("tlabo_entete_prelevement.id",'refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur',
    "tlabo_entete_prelevement.author", "tlabo_entete_prelevement.created_at","statutprelevement","preleveur",
    'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',
     "tlabo_entete_prelevement.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent",
     "complementanamnese","examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author",
     "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
     'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author","tenteteconsulter.created_at",
     "tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
     "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin","contact_medecin",
     "mail_medecin","grade_medecin","fonction_medecin","specialite_medecin","Categorie_medecin","niveauEtude_medecin",
     "anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin","tmedecin.slug as slug_medecin",
     "refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene","refMouvement","dateTriage",
     "refMalade","refTypeMouvement","dateMouvement",'organisationAbonne','taux_prisecharge','pourcentageConvention',
     'nmbreJourConsMvt','categoriemaladiemvt',"numroBon","Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact","mail","refAvenue","refCategieClient",
    "tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue","idCommune","nomQuartier",
    "idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince","nomPays","sexe_malade",
    "dateNaissance_malade","etatcivil_malade","numeroMaison_malade","fonction_malade",'groupesanguin',
    "personneRef_malade","fonctioPersRef_malade","contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade","PrixCons")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
    ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
    ->where([
        ['tlabo_entete_prelevement.created_at','>=', $date1],
        ['tlabo_entete_prelevement.created_at','<=', $date2],
        ['preleveur','=', 'OUI']
    ])    
    ->orderBy("tlabo_entete_prelevement.id", "asc")
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        
        $echantillons='';
        $data2 = DB::table('tlabo_detail_prelevement')
        ->join('tconf_natureechantillon','tconf_natureechantillon.id','=','tlabo_detail_prelevement.refEchantillon')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tlabo_detail_prelevement.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
        ->select("tconf_natureechantillon.designation","refEntetePrelevement")
        ->where('tlabo_detail_prelevement.refEntetePrelevement', $row->id)
        ->get();
        // $output='';
        foreach ($data2 as $row1) 
        {         
            $echantillons=$echantillons.' - '.$row1->designation;                  
        }

        


        $examens='';
        $resultats = '';

        $data3 = DB::table('tentetelabo')
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
        //MALADE
        ->select("tentetelabo.id","texamen.designation as designationEx")
        ->where('tentetelabo.refEntetePrelevement', $row->id)
        ->get();
        // $output='';
        foreach ($data3 as $row2) 
        {

            $examens=$examens.' - '.$row2->designationEx;   
            
            $data5 = DB::table('tdetaillabo')
            ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
            ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
            ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
            ->join('texamen','texamen.id','=','tentetelabo.refExamen')
            ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
            ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
            ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
            ->select("tentetelabo.refExamen","tdetaillabo.observation as observation",
            "tdetaillabo.libelle as resultat","tdetaillabo.methode as methode",
            "tdetaillabo.commentaire as commentaire")
            ->where('tdetaillabo.refEnteteLabo', $row2->id)
            ->get();
            foreach ($data5 as $row5) 
            {         
                $resultats=$resultats.' - '.$row5->observation.' - ('.$row5->resultat.') - '.$row5->commentaire;                  
            }
            
        }
        
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:35px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:51px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
                <td class="cs6E02D7D2" style="width:97px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeDossier.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:215px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:49px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->sexe_malade.'</td>
                <td class="cs6E02D7D2" style="width:50px;height:33px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->age_malade.'&nbsp;ans</nobr></td>
                <td class="cs6E02D7D2" style="width:180px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categoriemaladiemvt.' - '.$row->organisationAbonne.'</td>
                <td class="cs6E02D7D2" style="width:100px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$echantillons.'</td>
                <td class="cs6C28398D" colspan="3" style="width:190px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$examens.' ('.$resultats.')</td>
            </tr>
        ';       
       

    }

    return $output;

}




//============================================================================================================================================
//============================ RAPPORT LABORATOIRE SELON LES EXAMENS ===================================================================================


public function pdf_rapport_laboratoire_examen_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('refExamen'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $refExamen = $request->get('refExamen');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListLaboExamen($date1, $date2, $refExamen);       
        $html .='<script>window.print()</script>';
        echo($html);
    }
    else {
        // code...
    }
    
}



function printDataListLaboExamen($date1, $date2, $refExamen)
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

                $datedebut=$date1;
                $datefin=$date2;
                
                $designationEx='';
                $data4 = DB::table('texamen')
                ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
                ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
                ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
                ->select("texamen.id","texamen.designation","refCatexamen","texamen.created_at",
                "texamen.updated_at","tcategorieexament.designation as designationCat","refGrandCategorie",
                "tgcategorieexament.designation as designationGCat","PrixExam","refTube","codeTube","designationTube","couleurTube")
                ->where('texamen.id', $refExamen)
                ->get();
                foreach ($data4 as $row4) 
                {                                
                    $designationEx=$row4->designation;
                }

                $echantillons='';
                $data2 = DB::table('tlabo_detail_prelevement')
                ->join('tconf_natureechantillon','tconf_natureechantillon.id','=','tlabo_detail_prelevement.refEchantillon')
                ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tlabo_detail_prelevement.refEntetePrelevement')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
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
                ->select("tconf_natureechantillon.designation")
                ->where('tlabo_detail_prelevement.refEntetePrelevement', $row->id)
                ->get();
                $output='';
                foreach ($data2 as $row1) 
                {         
                    $echantillons=$echantillons.' - '.$row1->designation;                  
                }
        
                            

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT LABORATOIRE</title>
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:949px;height:375px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:52px;"></td>
                <td style="height:0px;width:98px;"></td>
                <td style="height:0px;width:59px;"></td>
                <td style="height:0px;width:124px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:33px;"></td>
                <td style="height:0px;width:17px;"></td>
                <td style="height:0px;width:51px;"></td>
                <td style="height:0px;width:181px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:12px;"></td>
                <td style="height:0px;width:168px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="11" style="width:757px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="11" style="width:757px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="11" style="width:757px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:11px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="11" rowspan="2" style="width:757px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td class="csB6F858D0" colspan="13" style="width:935px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;JOURNALIER&nbsp;DES&nbsp;MOUVEMENTS&nbsp;AU&nbsp;LABORATOIRE</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$datedebut.'&nbsp;&nbsp;au&nbsp;'.$datefin.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:602px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$designationEx.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:51px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs9FE9304F" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CODE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:215px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:49px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                <td class="cs9FE9304F" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>AGE</nobr></td>
                <td class="cs9FE9304F" style="width:180px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;&nbsp;-&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>EXAMENS</nobr></td>
                <td class="csEAC52FCD" colspan="3" style="width:190px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>RESULTATS</nobr></td>
            </tr>
            ';
                                    
                 $output .= $this->showLaboratoireData($date1, $date2,$refExamen);
                                    
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
            </tr>
        </table>
        </body>
        </html>
            
        ';  
       
        return $output; 

}

function showLaboratoireData($date1, $date2,$refExamen)
{
    $count =0;
    $data=DB::table('tentetelabo')
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
    // ->leftjoin('tdetaillabo','tdetaillabo.refEnteteLabo','=','tentetelabo.id')
    // ->leftjoin('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
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
    "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
    "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
    "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
    "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
    "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
    "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
    "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
    'organisationAbonne','taux_prisecharge','pourcentageConvention','nmbreJourConsMvt','categoriemaladiemvt',"numroBon",
    "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade","PrixCons")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
    ->selectRaw('CONCAT("",YEAR(tlabo_entete_prelevement.created_at),"",MONTH(tlabo_entete_prelevement.created_at),"00",tlabo_entete_prelevement.id) as codePreleve')
    ->where([
        ['tlabo_entete_prelevement.created_at','>=', $date1],
        ['tlabo_entete_prelevement.created_at','<=', $date2],
        ['tentetelabo.refExamen','=', $refExamen],
        ['preleveur','=', 'OUI']
    ])    
    ->orderBy("tentetelabo.id", "asc")
    ->get();


    $output='';

    foreach ($data as $row) 
    {
        $count ++;


        $resultats = '';

        $data5 = DB::table('tdetaillabo')
        ->join('tvaleurnormale','tvaleurnormale.id','=','tdetaillabo.refValeur')
        ->join('tentetelabo','tentetelabo.id','=','tdetaillabo.refEnteteLabo')
        ->join('tlabo_entete_prelevement','tlabo_entete_prelevement.id','=','tentetelabo.refEntetePrelevement')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tlabo_entete_prelevement.refService')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tdetailconsultation','tdetailconsultation.id','=','tlabo_entete_prelevement.refDetailCons')
        ->join('texamen','texamen.id','=','tentetelabo.refExamen')
        ->join('tcategorieexament','tcategorieexament.id','=','texamen.refCatexamen')
        ->join('tgcategorieexament','tgcategorieexament.id','=','tcategorieexament.refGrandCategorie')
        ->join('ttubeexamen','ttubeexamen.id','=','texamen.refTube')
        ->select("tentetelabo.refExamen","tdetaillabo.observation as observation",
        "tdetaillabo.libelle as resultat","tdetaillabo.methode as methode",
        "tdetaillabo.commentaire as commentaire")
        ->where('tdetaillabo.refEnteteLabo', $row->id)
        ->get();
        foreach ($data5 as $row5) 
        {         
            $resultats=$resultats.' - '.$row5->observation.' - ('.$row5->resultat.') - '.$row5->commentaire;                  
        }


        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:35px;"></td>
                <td></td>
                <td class="cs6E02D7D2" style="width:51px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
                <td class="cs6E02D7D2" style="width:97px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeDossier.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:215px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:49px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->sexe_malade.'</td>
                <td class="cs6E02D7D2" style="width:50px;height:33px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->age_malade.'&nbsp;ans</nobr></td>
                <td class="cs6E02D7D2" style="width:180px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categoriemaladiemvt.' - '.$row->organisationAbonne.'</td>
                <td class="cs6E02D7D2" style="width:100px;height:33px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->designationEx.' - '.$row->designationCatEx.'</td>
                <td class="cs6C28398D" colspan="3" style="width:190px;height:33px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->designationEx.' ('.$resultats.')</td>
            </tr>
        ';       
       

    }

    return $output;

}






}
