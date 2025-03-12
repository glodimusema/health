<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_FacturePriveeController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    function pdf_grand_facture_privee_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFacturePrivee($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFacturePrivee($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refEnteteFacturation','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $codeFacture=''; 
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')                
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refEnteteFacturation','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement;   
                   $codeFacture=$row->codeFacture;                                  
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE PRIVEEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7560ECA {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:545px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:169px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:103px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:101px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="7" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="7" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="3" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="7" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="7" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:39px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:39px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="7" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="11" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:10px;"></td>
                        <td class="csC4190C00" colspan="11" style="width:673px;height:10px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:10px;"></td>
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
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:331px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Prix&nbsp;Unitaire($)</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Quantit&#233;</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Prix&nbsp;Total&nbsp;($)</nobr></td>
                    </tr>
                    ';
                
                            $output .= $this->showDetailGrandFacturePrivee($id); 
                
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs91032837" colspan="6" style="width:192px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:109px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
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
                    </tr>
                </table>
                </body>
                </html>'; 

        return $output;

    }   


    function showDetailGrandFacturePrivee($id)
    {
        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where('refEnteteFacturation','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csFBCBEF30" colspan="2" style="width:60px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$count.'</td>
                    <td class="csDC7EEB9" colspan="3" style="width:331px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                    <td class="csDC7EEB9" colspan="2" style="width:107px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                    <td class="csDC7EEB9" colspan="4" style="width:85px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                    <td class="csDC7EEB9" colspan="2" style="width:109px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                </tr>
            ';
        }

        return $output;

    }

    //========= GRANDE FACTURE PRIVEE SELON LE MOUVEMENT =============================================================================

    function pdf_grand_facture_privee_mouvement_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFacturePriveeMouvement($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFacturePriveeMouvement($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refMouvement','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $codeFacture=''; 
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refMouvement','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement; 
                   $codeFacture=$row->codeFacture;                                    
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE PRIVEEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7560ECA {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:545px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:169px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:103px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:101px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="7" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="7" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="3" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="7" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="7" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:39px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:39px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="7" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="11" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:10px;"></td>
                        <td class="csC4190C00" colspan="11" style="width:673px;height:10px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:10px;"></td>
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
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:331px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:107px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Prix&nbsp;Unitaire($)</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Quantit&#233;</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:109px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Prix&nbsp;Total&nbsp;($)</nobr></td>
                    </tr>
                    ';
                
                            $output .= $this->showDetailGrandFacturePriveeMouvement($id); 
                
                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs91032837" colspan="6" style="width:192px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:109px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
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
                    </tr>
                </table>
                </body>
                </html>'; 

        return $output;

    }   


    function showDetailGrandFacturePriveeMouvement($id)
    {
        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where('refMouvement','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csFBCBEF30" colspan="2" style="width:60px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$count.'</td>
                    <td class="csDC7EEB9" colspan="3" style="width:331px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                    <td class="csDC7EEB9" colspan="2" style="width:107px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                    <td class="csDC7EEB9" colspan="4" style="width:85px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                    <td class="csDC7EEB9" colspan="2" style="width:109px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                </tr>
            ';
        }

        return $output;

    }





    //============ PETITE FACTURE POUR LES PRIVEES =============================================================================


    function pdf_petit_facture_privee_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoPetitFacturePrivee($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoPetitFacturePrivee($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refEnteteFacturation','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $codeFacture=''; 
                $author='';
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refEnteteFacturation','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement; 
                   $codeFacture=$row->codeFacture;
                   $author=$row->author;                                    
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE PRIVEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csB2E87FF7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs2479F306 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs599477FD {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs3A663619 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs5B96C881 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:306px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:22px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:54px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:58px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="16" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="3" style="width:85px;height:72px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:85px;height:72px;">
                            <img alt="" src="'.$pic2.'" style="width:85px;height:72px;" /></div>
                        </td>
                        <td></td>
                        <td class="cs599477FD" colspan="10" style="width:250px;height:23px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs599477FD" colspan="10" style="width:250px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:28px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs761EE787" colspan="10" style="width:250px;height:28px;line-height:10px;text-align:center;vertical-align:middle;">'.$adresseEse.'</td>
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
                        <td class="cs3A663619" colspan="5" style="width:143px;height:33px;line-height:32px;text-align:left;vertical-align:middle;"><nobr>FACTURE</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="9" style="width:307px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:14px;"></td>
                        <td class="cs5B96C881" colspan="9" style="width:305px;height:14px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:15px;"></td>
                        <td class="cs5B96C881" colspan="9" style="width:305px;height:15px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:15px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:14px;"></td>
                        <td class="cs5B96C881" colspan="9" style="width:305px;height:14px;line-height:11px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:19px;"></td>
                        <td class="cs5B96C881" colspan="9" style="width:305px;height:19px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&nbsp;Maladie&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:19px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="9" style="width:307px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="csB2E87FF7" colspan="7" style="width:173px;height:13px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                        <td class="cs2479F306" colspan="2" style="width:24px;height:13px;line-height:11px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs54BE9109" style="width:49px;height:13px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="cs54BE9109" colspan="3" style="width:66px;height:13px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    ';                
                                         $output .= $this->showDetailPetitFacturePrivee($id);                
                                      $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs9B633122" colspan="10" style="width:252px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                        <td class="cs32E815B6" colspan="3" style="width:66px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="6" style="width:155px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="6" style="width:154px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Author&nbsp;:&nbsp;'.$author.'</nobr></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>'; 

        return $output;

    }   


    function showDetailPetitFacturePrivee($id)
    {
        $data = DB::table('tfin_detailfacturation')
        ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
        ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
        ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
        ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
        ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
        ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
        ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
        ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
        ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
        ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
        ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
        ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
        'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
        'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
        "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
        "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
        "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
        "dateMouvement",'organisationAbonne','taux_prisecharge',
        'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
        "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
        'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
        'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
        'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
        'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
        'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
        'nom_typeposition',"nom_typecompte")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
        ->selectRaw('(quantite*prixunitaire) as prixTotal')
        ->where('refEnteteFacturation','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';
        $count =0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:16px;"></td>
                    <td></td>
                    <td class="cs8F206BC7" colspan="7" style="width:173px;height:14px;line-height:11px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                    <td class="cs332624CE" colspan="2" style="width:22px;height:14px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                    <td class="cs332624CE" style="width:49px;height:14px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                    <td class="cs332624CE" colspan="3" style="width:66px;height:14px;line-height:11px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td></td>
                    <td></td>
                </tr>
            ';            
        }

        return $output;

    }


        //============ PETITE FACTURE POUR LES PRIVEES SELON LE MOUVEMENT =============================================================================


        function pdf_petit_facture_privee_mouvement_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitFacturePriveeMouvement($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetitFacturePriveeMouvement($id)
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
                    $data2 = DB::table('tfin_detailfacturation')
                    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                    ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
            
                    ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                    ->where('refMouvement','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                                        
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $codeFacture=''; 
           
                    $data3=DB::table('tfin_detailfacturation')
                    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                    ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                    ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                    'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                    'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                    "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                    "dateMouvement",'organisationAbonne','taux_prisecharge',
                    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                    "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                    'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                    'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                    'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                    'nom_typeposition',"nom_typecompte")
                    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                    ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                    ->selectRaw('(quantite*prixunitaire) as prixTotal')
                    ->where('refMouvement','=', $id)     
                   ->get();      
                   $output='';
                   foreach ($data3 as $row) 
                   {
                       $noms=$row->noms;
                       $Categorie=$row->categoriemaladiemvt;
                       $dateMouvement=$row->dateMouvement;   
                       $codeFacture=$row->codeFacture;                                  
                   }
           
            
            
                    $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>FACTURE PRIVEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csFB1220E1 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs2AAE814A {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs3A663619 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .csAAA9B5FF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:560px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:4px;"></td>
                            <td style="height:0px;width:5px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:21px;"></td>
                            <td style="height:0px;width:62px;"></td>
                            <td style="height:0px;width:27px;"></td>
                            <td style="height:0px;width:5px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:23px;"></td>
                            <td style="height:0px;width:20px;"></td>
                            <td style="height:0px;width:58px;"></td>
                            <td style="height:0px;width:3px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:78px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:72px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="4" style="width:100px;height:72px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:100px;height:72px;">
                                <img alt="" src="'.$pic2.'" style="width:100px;height:72px;" /></div>
                            </td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA803F7DA" colspan="11" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:27px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csAAA9B5FF" colspan="11" style="width:311px;height:27px;line-height:12px;text-align:center;vertical-align:middle;">'.$busnessName.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA803F7DA" colspan="11" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="11" style="width:311px;height:24px;line-height:10px;text-align:center;vertical-align:middle;">'.$adresseEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="11" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="11" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csAAA9B5FF" colspan="11" style="width:311px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs3A663619" colspan="6" style="width:142px;height:33px;line-height:32px;text-align:left;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                            <td style="width:0px;height:13px;"></td>
                            <td></td>
                            <td class="csD24A75E0" colspan="2" style="width:6px;height:10px;"></td>
                            <td class="csDDFA3242" colspan="9" style="width:307px;height:10px;"></td>
                            <td class="cs62ED362D" colspan="2" style="width:6px;height:10px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&nbsp;Maladie&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:15px;"></td>
                            <td></td>
                            <td class="cs593B729A" colspan="2" style="width:6px;height:12px;"></td>
                            <td class="csE7D235EF" colspan="9" style="width:307px;height:12px;"></td>
                            <td class="cs11B2FA6F" colspan="2" style="width:6px;height:12px;"></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs10569A86" colspan="5" style="width:173px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="csFB1220E1" style="width:24px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                            <td class="cs2AAE814A" colspan="4" style="width:49px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td></td>
                        </tr>
                        ';                
                             $output .= $this->showDetailPetitFacturePriveeMouvement($id);                
                          $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="10" style="width:252px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td></td>
                        </tr>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csFFC1C457" colspan="7" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
    
    
        function showDetailPetitFacturePriveeMouvement($id)
        {
            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')
            ->where('refMouvement','=', $id) 
            ->orderBy("nom_typeproduit", "asc")
            ->get();
    
            $output='';
            $count =0;
            foreach ($data as $row) 
            { 
                $count ++;
    
                $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8F206BC7" colspan="5" style="width:173px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                    <td class="cs332624CE" style="width:22px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                    <td class="cs332624CE" colspan="4" style="width:49px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                    <td class="cs332624CE" colspan="3" style="width:62px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td></td>
                </tr>
                ';            
            }
    
            return $output;
    
        }
    
    


        //============ PETITE RECU POUR LES PRIVEES =============================================================================


        function pdf_petit_recu_privee_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitRecuPrivee($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetitRecuPrivee($id)
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

                    $refEnteteFacturation=0;
                    $montantpaie =0;
                    $codeRecu=''; 
                    $codeFacture=''; 
                    $author =''; 
                    $data4 = DB::table('tfin_paiementfacture')
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
                        //MALADE
                    ->select("tfin_paiementfacture.id",'refEnteteFacturation','montantpaie','datepaie',
                    'modepaie','libellepaie','montant_taux','refMouvement','refUniteProduction','refMedecin',
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
                    ->selectRaw('CONCAT(YEAR(datepaie),"",MONTH(datepaie),"00",tfin_paiementfacture.id) as codeRecu')
                    ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                    ->where('tfin_paiementfacture.id','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data4 as $row) 
                    {                                
                        $refEnteteFacturation=$row->refEnteteFacturation;
                        $montantpaie=$row->montantpaie;  
                        $codeRecu=$row->codeRecu; 
                        $codeFacture=$row->codeFacture; 
                        $author=  $row->author;             
                    }            
       
                    $totalFact=0;
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
                                        
                    ->selectRaw('ROUND(SUM( IFNULL(montant,0)),2) as TotalFacture')
                    ->selectRaw('ROUND(SUM( IFNULL(paie,0)),2) as TotalPaie')
                    ->selectRaw('ROUND(SUM(( IFNULL(montant,0)- IFNULL(paie,0))),2) as TotalReste')
                    ->where('tfin_entetefacturation.id','=', $refEnteteFacturation)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                       $totalFact=$row->TotalFacture;
                       $totalPaie=$row->TotalPaie;
                       $totalReste=$row->TotalReste;
                                      
                    }
               
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $codeFacture=''; 
           
                    $data3=DB::table('tfin_detailfacturation')
                    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                    ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                    ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                    'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                    'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                    "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                    "dateMouvement",'organisationAbonne','taux_prisecharge',
                    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                    "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                    'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                    'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                    'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                    'nom_typeposition',"nom_typecompte")
                    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                    ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                    ->selectRaw('(quantite*prixunitaire) as prixTotal')
                    ->where('refEnteteFacturation','=', $refEnteteFacturation)     
                   ->get();      
                   $output='';
                   foreach ($data3 as $row) 
                   {
                       $noms=$row->noms;
                       $Categorie=$row->categoriemaladiemvt;
                       $dateMouvement=$row->dateMouvement;     
                       $codeFacture=$row->codeFacture;                                
                   }
           
            
            
                    $output='
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>RECU_PAIEMENT_PRIVEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .csB2E87FF7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .csC8EAD4A3 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs2479F306 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs599477FD {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csA2F7C04E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csDFEBE560 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs5B96C881 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:366px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:4px;"></td>
                            <td style="height:0px;width:5px;"></td>
                            <td style="height:0px;width:74px;"></td>
                            <td style="height:0px;width:1px;"></td>
                            <td style="height:0px;width:61px;"></td>
                            <td style="height:0px;width:35px;"></td>
                            <td style="height:0px;width:1px;"></td>
                            <td style="height:0px;width:27px;"></td>
                            <td style="height:0px;width:54px;"></td>
                            <td style="height:0px;width:54px;"></td>
                            <td style="height:0px;width:9px;"></td>
                            <td style="height:0px;width:4px;"></td>
                            <td style="height:0px;width:9px;"></td>
                            <td style="height:0px;width:65px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td class="cs739196BC" colspan="15" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                            <td></td>
                            <td class="cs101A94F7" colspan="2" rowspan="3" style="width:79px;height:73px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:79px;height:73px;">
                                <img alt="" src="'.$pic2.'" style="width:79px;height:73px;" /></div>
                            </td>
                            <td></td>
                            <td class="cs599477FD" colspan="9" style="width:250px;height:22px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs599477FD" colspan="9" style="width:250px;height:22px;line-height:11px;text-align:center;vertical-align:middle;">'.$busnessName.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:29px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="9" style="width:250px;height:29px;line-height:10px;text-align:center;vertical-align:middle;">'.$adresseEse.'</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:19px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA2F7C04E" colspan="12" style="width:330px;height:19px;line-height:16px;text-align:center;vertical-align:middle;"><nobr>PREUVE&nbsp;DE&nbsp;PAIEMENT</nobr></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:10px;"></td>
                            <td></td>
                            <td class="csD24A75E0" colspan="2" style="width:6px;height:7px;"></td>
                            <td class="csDDFA3242" colspan="8" style="width:307px;height:7px;"></td>
                            <td class="cs62ED362D" colspan="3" style="width:19px;height:7px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:14px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:14px;"></td>
                            <td class="csDFEBE560" colspan="8" style="width:305px;height:14px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Re&#231;u&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;R'.$codeRecu.'</nobr></td>
                            <td class="cs145AAE8A" colspan="3" style="width:19px;height:14px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:15px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:15px;"></td>
                            <td class="csDFEBE560" colspan="8" style="width:305px;height:15px;line-height:11px;text-align:left;vertical-align:top;"><nobr>Cfr&nbsp;Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                            <td class="cs145AAE8A" colspan="3" style="width:19px;height:15px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:17px;"></td>
                            <td class="cs12FE94AA" colspan="8" style="width:305px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                            <td class="cs145AAE8A" colspan="3" style="width:19px;height:17px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:17px;"></td>
                            <td class="cs12FE94AA" colspan="8" style="width:305px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                            <td class="cs145AAE8A" colspan="3" style="width:19px;height:17px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:6px;"></td>
                            <td></td>
                            <td class="cs593B729A" colspan="2" style="width:6px;height:3px;"></td>
                            <td class="csE7D235EF" colspan="8" style="width:307px;height:3px;"></td>
                            <td class="cs11B2FA6F" colspan="3" style="width:19px;height:3px;"></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:16px;"></td>
                            <td></td>
                            <td class="csB2E87FF7" colspan="7" style="width:177px;height:14px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="cs2479F306" style="width:24px;height:14px;line-height:12px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                            <td class="cs54BE9109" style="width:49px;height:14px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:14px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        ';                
                            $output .= $this->showDetailPetitRecuPrivee($refEnteteFacturation);                
                            $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC8EAD4A3" colspan="9" style="width:256px;height:15px;line-height:12px;text-align:right;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:15px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC8EAD4A3" colspan="9" style="width:256px;height:15px;line-height:12px;text-align:right;vertical-align:middle;"><nobr>Total&nbsp;d&#233;j&#224;&nbsp;pay&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:15px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalPaie.'$</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC8EAD4A3" colspan="9" style="width:256px;height:15px;line-height:12px;text-align:right;vertical-align:middle;"><nobr>Minimum&nbsp;&#224;&nbsp;payer</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:15px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:18px;"></td>
                            <td></td>
                            <td class="csC8EAD4A3" colspan="9" style="width:256px;height:16px;line-height:12px;text-align:right;vertical-align:middle;"><nobr>Reste&nbsp;&#224;&nbsp;payer</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:16px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalReste.'$</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:17px;"></td>
                            <td></td>
                            <td class="csC8EAD4A3" colspan="9" style="width:256px;height:15px;line-height:12px;text-align:right;vertical-align:middle;"><nobr>Montant&nbsp;&#224;&nbsp;pay&#233;&nbsp;en&nbsp;USD</nobr></td>
                            <td class="cs54BE9109" colspan="3" style="width:62px;height:15px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$montantpaie.'$</nobr></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs5B96C881" colspan="5" style="width:143px;height:22px;line-height:10px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                            <td></td>
                            <td class="cs5B96C881" colspan="5" style="width:143px;height:22px;line-height:10px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;la&nbsp;Caisse&nbsp;:&nbsp;'.$author.'</nobr></td>
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
    
    
        function showDetailPetitRecuPrivee($id)
        {
            $data = DB::table('tfin_detailfacturation')
            ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
            ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
            ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
            ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
            ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
            ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
            ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
            ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
            ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
            ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
            ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
            ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
            ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
            'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
            'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
            "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
            "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
            "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
            "dateMouvement",'organisationAbonne','taux_prisecharge',
            'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
            "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
            'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
            'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
            'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
            'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
            'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
            'nom_typeposition',"nom_typecompte")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
            ->selectRaw('(quantite*prixunitaire) as prixTotal')
            ->where('refEnteteFacturation','=', $id) 
            ->orderBy("nom_typeproduit", "asc")
            ->get();           
    
            $output='';

            $count=0;
    
            foreach ($data as $row) 
            { 
                $count ++;

                $output .='<tr style="vertical-align:top;">
                <td style="width:0px;height:17px;"></td>
                <td></td>
                <td class="cs8F206BC7" colspan="7" style="width:177px;height:15px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                <td class="cs332624CE" style="width:22px;height:15px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                <td class="cs332624CE" style="width:49px;height:15px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                <td class="cs332624CE" colspan="3" style="width:62px;height:15px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                <td></td>
                <td></td>
                </tr>'; 
       
            }
    
            return $output;
    
        }
    



//========= GRANDE FACTURE SYNTHESE PRIVEE SELON LE MOUVEMENT =============================================================================

    function pdf_grand_facture_synthese_privee_mouvement_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFactureSynthesePriveeMouvement($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFactureSynthesePriveeMouvement($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refMouvement','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $codeFacture=''; 
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refMouvement','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement;  
                   $codeFacture=$row->codeFacture;                                   
               }
       
        
        
                $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_SYNTHESE_PRIVEEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7560ECA {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:545px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:174px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:133px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="5" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="5" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="2" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="5" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="5" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:169px;height:39px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:39px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="5" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="8" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:10px;"></td>
                        <td class="csC4190C00" colspan="8" style="width:673px;height:10px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:10px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:441px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;($)</nobr></td>
                    </tr>
                     ';
                                
                                            $output .= $this->showDetailGrandFactureSynthesePriveeMouvement($id); 
                                
                                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" colspan="6" style="width:502px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:193px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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


    function showDetailGrandFactureSynthesePriveeMouvement($id)
    {
        $data = DB::select('select refEnteteFacturation,prixTotal,refMouvement,
        refUniteProduction,refMedecin,datefacture,tfin_entetefacturation.statut as statutMvt,
        matricule_medecin,noms_medecin,sexe_medecin,contact_medecin,mail_medecin,
        grade_medecin,fonction_medecin,specialite_medecin,refMalade,refTypeMouvement,
        dateMouvement,organisationAbonne,taux_prisecharge,pourcentageConvention,categoriemaladiemvt,
        numCartemvt,numroBon,tmouvement.Statut as StatutMvt,dateSortieMvt,motifSortieMvt,autoriseSortieMvt,
        ttypemouvement_malade.designation as Typemouvement,noms,contact,mail,refAvenue,refCategieClient,
        tcategorieclient.designation as Categorie,tclient.photo,tclient.slug,nomAvenue,
        idCommune,nomQuartier,idQuartier,idVille,nomCommune,idProvince,nomVille,idPays,nomProvince,
        nomPays,sexe_malade,dateNaissance_malade,etatcivil_malade,
        numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,
        contactPersRef_malade,organisation_malade,numeroCarte_malade,
        dateExpiration_malade,refTypeProduit,refDepartement,nom_uniteproduction,
        code_uniteproduction,nom_departement,code_departement,nom_typeproduit from vfin_detailfacturation
        
        inner join tfin_entetefacturation  on tfin_entetefacturation.id = vfin_detailfacturation.refEnteteFacturation
        inner join tmedecin on tmedecin.id = tfin_entetefacturation.refMedecin
        inner join tfin_uniteproduction on tfin_uniteproduction.id = tfin_entetefacturation.refUniteProduction
        inner join tfin_departement on tfin_departement.id = tfin_uniteproduction.refDepartement
        inner join tfin_typeproduit on tfin_typeproduit.id = vfin_detailfacturation.refTypeProduit
        inner join tmouvement on tmouvement.id = tfin_entetefacturation.refMouvement
        inner join ttypemouvement_malade on ttypemouvement_malade.id = tmouvement.refTypeMouvement
        inner join tclient on tclient.id = tmouvement.refMalade
        inner join tcategorieclient on   tcategorieclient.id = tclient.refCategieClient
        inner join avenues on   avenues.id = tclient.refAvenue
        inner join quartiers on   quartiers.id = avenues.idQuartier
        inner join communes on   communes.id = quartiers.idCommune
        inner join villes on   villes.id = communes.idVille
        inner join provinces on   provinces.id = villes.idProvince
        inner join pays on   pays.id = provinces.idPays        
        
        where refMouvement = ?', [$id]);
        
        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csFBCBEF30" colspan="2" style="width:60px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$count.'</td>
            <td class="csDC7EEB9" colspan="4" style="width:441px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
            <td class="csDC7EEB9" colspan="4" style="width:193px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
        </tr>
            ';   
        }

        return $output;

    }




    //========= GRANDE FACTURE SYNTHESE PRIVEE PAR ENTETE =============================================================================

    function pdf_grand_facture_synthese_privee_entete_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFactureSynthesePriveeEntete($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFactureSynthesePriveeEntete($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refEnteteFacturation','=', $id)    
                ->first(); 
                $output='';
                if ($data2) 
                {                                
                    $totalFact=$data2->TotalFacture;                                    
                }

                $codeFacture=''; 
                $data3 = DB::table('tfin_entetefacturation')
                ->selectRaw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",tfin_entetefacturation.id) as codeFacture')
                ->where('tfin_entetefacturation.id','=', $id)    
                ->get(); 
                $output='';
                foreach ($data3 as $row) 
                {                                
                    $codeFacture=$row->codeFacture;                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refEnteteFacturation','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement;   
                   $codeFacture=$row->codeFacture;                                  
               }
       
        
        
                $output='
                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_SYNTHESE_PRIVEEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs91032837 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csF7560ECA {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs479D8C74 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; }
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:545px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:46px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:174px;"></td>
                        <td style="height:0px;width:105px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:133px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="5" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="5" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="2" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="5" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="5" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="5" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:169px;height:39px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:39px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="5" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="8" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="8" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:10px;"></td>
                        <td class="csC4190C00" colspan="8" style="width:673px;height:10px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:10px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="2" style="width:60px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:441px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant&nbsp;($)</nobr></td>
                    </tr>
                     ';
                                
                                            $output .= $this->showDetailGrandFactureSynthesePriveeEntete($id); 
                                
                                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" colspan="6" style="width:502px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="4" style="width:193px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="3" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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


    function showDetailGrandFactureSynthesePriveeEntete($id)
    {
        $data = DB::select('select refEnteteFacturation,prixTotal,refMouvement,
        refUniteProduction,refMedecin,datefacture,tfin_entetefacturation.statut as statutMvt,
        matricule_medecin,noms_medecin,sexe_medecin,contact_medecin,mail_medecin,
        grade_medecin,fonction_medecin,specialite_medecin,refMalade,refTypeMouvement,
        dateMouvement,organisationAbonne,taux_prisecharge,pourcentageConvention,categoriemaladiemvt,
        numCartemvt,numroBon,tmouvement.Statut as StatutMvt,dateSortieMvt,motifSortieMvt,autoriseSortieMvt,
        ttypemouvement_malade.designation as Typemouvement,noms,contact,mail,refAvenue,refCategieClient,
        tcategorieclient.designation as Categorie,tclient.photo,tclient.slug,nomAvenue,
        idCommune,nomQuartier,idQuartier,idVille,nomCommune,idProvince,nomVille,idPays,nomProvince,
        nomPays,sexe_malade,dateNaissance_malade,etatcivil_malade,
        numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,
        contactPersRef_malade,organisation_malade,numeroCarte_malade,
        dateExpiration_malade,refTypeProduit,refDepartement,nom_uniteproduction,
        code_uniteproduction,nom_departement,code_departement,nom_typeproduit from vfin_detailfacturation
        
        inner join tfin_entetefacturation  on tfin_entetefacturation.id = vfin_detailfacturation.refEnteteFacturation
        inner join tmedecin on tmedecin.id = tfin_entetefacturation.refMedecin
        inner join tfin_uniteproduction on tfin_uniteproduction.id = tfin_entetefacturation.refUniteProduction
        inner join tfin_departement on tfin_departement.id = tfin_uniteproduction.refDepartement
        inner join tfin_typeproduit on tfin_typeproduit.id = vfin_detailfacturation.refTypeProduit
        inner join tmouvement on tmouvement.id = tfin_entetefacturation.refMouvement
        inner join ttypemouvement_malade on ttypemouvement_malade.id = tmouvement.refTypeMouvement
        inner join tclient on tclient.id = tmouvement.refMalade
        inner join tcategorieclient on   tcategorieclient.id = tclient.refCategieClient
        inner join avenues on   avenues.id = tclient.refAvenue
        inner join quartiers on   quartiers.id = avenues.idQuartier
        inner join communes on   communes.id = quartiers.idCommune
        inner join villes on   villes.id = communes.idVille
        inner join provinces on   provinces.id = villes.idProvince
        inner join pays on   pays.id = provinces.idPays        
        
        where refEnteteFacturation = ?', [$id]);
        
        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csFBCBEF30" colspan="2" style="width:60px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$count.'</td>
            <td class="csDC7EEB9" colspan="4" style="width:441px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
            <td class="csDC7EEB9" colspan="4" style="width:193px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            </tr>
            ';   
        }

        return $output;

    }





    //========= PETITE FACTURE SYNTHESE PRIVEE SELON LE MOUVEMENT =============================================================================

    function pdf_petite_facture_synthese_privee_mouvement_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoPetitFactureSynthesePriveeMouvement($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoPetitFactureSynthesePriveeMouvement($id)
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
                $data2 = DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
        
                ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                ->where('refMouvement','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                                    
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $codeFacture=''; 
       
                $data3=DB::table('tfin_detailfacturation')
                ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                "dateMouvement",'organisationAbonne','taux_prisecharge',
                'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                'nom_typeposition',"nom_typecompte")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as codeFacture')
                ->selectRaw('(quantite*prixunitaire) as prixTotal')
                ->where('refMouvement','=', $id)     
               ->get();      
               $output='';
               foreach ($data3 as $row) 
               {
                   $noms=$row->noms;
                   $Categorie=$row->categoriemaladiemvt;
                   $dateMouvement=$row->dateMouvement; 
                   $codeFacture=$row->codeFacture;                                    
               }
       
        
        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_SYNTHESE_PRIVEEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs3A663619 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csAAA9B5FF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:560px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:4px;"></td>
                        <td style="height:0px;width:5px;"></td>
                        <td style="height:0px;width:85px;"></td>
                        <td style="height:0px;width:21px;"></td>
                        <td style="height:0px;width:94px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:6px;"></td>
                        <td style="height:0px;width:78px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:72px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" style="width:100px;height:72px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:100px;height:72px;">
                            <img alt="" src="'.$pic2.'" style="width:100px;height:72px;" /></div>
                        </td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA803F7DA" colspan="9" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:27px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csAAA9B5FF" colspan="9" style="width:311px;height:27px;line-height:12px;text-align:center;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csA803F7DA" colspan="9" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs761EE787" colspan="9" style="width:311px;height:24px;line-height:10px;text-align:center;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs761EE787" colspan="9" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs761EE787" colspan="9" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csAAA9B5FF" colspan="9" style="width:311px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs3A663619" colspan="4" style="width:142px;height:33px;line-height:32px;text-align:left;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:6px;height:10px;"></td>
                        <td class="csDDFA3242" colspan="7" style="width:307px;height:10px;"></td>
                        <td class="cs62ED362D" colspan="2" style="width:6px;height:10px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&nbsp;Maladie&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:6px;height:12px;"></td>
                        <td class="csE7D235EF" colspan="7" style="width:307px;height:12px;"></td>
                        <td class="cs11B2FA6F" colspan="2" style="width:6px;height:12px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs10569A86" colspan="8" style="width:254px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                        <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Montant</nobr></td>
                        <td></td>
                    </tr>
                 ';
                                                
                                                            $output .= $this->showDetailPetitFactureSynthesePriveeMouvement($id); 
                                                
                                                            $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9B633122" colspan="8" style="width:252px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                        <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                        <td></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="5" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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


    function showDetailPetitFactureSynthesePriveeMouvement($id)
    {
        $data = DB::select('select refEnteteFacturation,prixTotal,refMouvement,
        refUniteProduction,refMedecin,datefacture,tfin_entetefacturation.statut as statutMvt,
        matricule_medecin,noms_medecin,sexe_medecin,contact_medecin,mail_medecin,
        grade_medecin,fonction_medecin,specialite_medecin,refMalade,refTypeMouvement,
        dateMouvement,organisationAbonne,taux_prisecharge,pourcentageConvention,categoriemaladiemvt,
        numCartemvt,numroBon,tmouvement.Statut as StatutMvt,dateSortieMvt,motifSortieMvt,autoriseSortieMvt,
        ttypemouvement_malade.designation as Typemouvement,noms,contact,mail,refAvenue,refCategieClient,
        tcategorieclient.designation as Categorie,tclient.photo,tclient.slug,nomAvenue,
        idCommune,nomQuartier,idQuartier,idVille,nomCommune,idProvince,nomVille,idPays,nomProvince,
        nomPays,sexe_malade,dateNaissance_malade,etatcivil_malade,
        numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,
        contactPersRef_malade,organisation_malade,numeroCarte_malade,
        dateExpiration_malade,refTypeProduit,refDepartement,nom_uniteproduction,
        code_uniteproduction,nom_departement,code_departement,nom_typeproduit from vfin_detailfacturation
        
        inner join tfin_entetefacturation  on tfin_entetefacturation.id = vfin_detailfacturation.refEnteteFacturation
        inner join tmedecin on tmedecin.id = tfin_entetefacturation.refMedecin
        inner join tfin_uniteproduction on tfin_uniteproduction.id = tfin_entetefacturation.refUniteProduction
        inner join tfin_departement on tfin_departement.id = tfin_uniteproduction.refDepartement
        inner join tfin_typeproduit on tfin_typeproduit.id = vfin_detailfacturation.refTypeProduit
        inner join tmouvement on tmouvement.id = tfin_entetefacturation.refMouvement
        inner join ttypemouvement_malade on ttypemouvement_malade.id = tmouvement.refTypeMouvement
        inner join tclient on tclient.id = tmouvement.refMalade
        inner join tcategorieclient on   tcategorieclient.id = tclient.refCategieClient
        inner join avenues on   avenues.id = tclient.refAvenue
        inner join quartiers on   quartiers.id = avenues.idQuartier
        inner join communes on   communes.id = quartiers.idCommune
        inner join villes on   villes.id = communes.idVille
        inner join provinces on   provinces.id = villes.idProvince
        inner join pays on   pays.id = provinces.idPays        
        
        where refMouvement = ?', [$id]);
        
        $output='';
        $count = 0;
        foreach ($data as $row) 
        { 
            $count ++;

            $output .='	
            <tr style="vertical-align:top;">
            <td style="width:0px;height:22px;"></td>
            <td></td>
            <td class="cs8F206BC7" colspan="8" style="width:254px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
            <td class="cs332624CE" colspan="3" style="width:62px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            <td></td>
        </tr>';
       
        }

        return $output;

    }



        //========= PETITE FACTURE SYNTHESE PRIVEE SELON L'ENTETE =============================================================================

        function pdf_petite_facture_synthese_privee_entete_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitFactureSynthesePriveeEntete($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetitFactureSynthesePriveeEntete($id)
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
                    $data2 = DB::table('tfin_detailfacturation')
                    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                    ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
            
                    ->select(DB::raw('ROUND(SUM(quantite*prixunitaire),2) as TotalFacture'))
                    ->where('refEnteteFacturation','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                                        
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $codeFacture=''; 
           
                    $data3=DB::table('tfin_detailfacturation')
                    ->join('tfin_entetefacturation','tfin_entetefacturation.id','=','tfin_detailfacturation.refEnteteFacturation')
                    ->join('tmedecin','tmedecin.id','=','tfin_entetefacturation.refMedecin')
                    ->join('tfin_produit','tfin_produit.id','=','tfin_detailfacturation.refProduit')
                    ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','tfin_entetefacturation.refUniteProduction')
                    ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
                    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
                    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
                    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
                    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
                    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
                    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
                    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
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
                    ->select("tfin_detailfacturation.id",'refEnteteFacturation','refProduit','quantite',
                    'prixunitaire','montant_taux','refMouvement','refUniteProduction','refMedecin','datefacture',
                    'tfin_entetefacturation.statut as statutMvt',"tfin_detailfacturation.author",
                    "tfin_detailfacturation.created_at","tfin_detailfacturation.updated_at",
                    "matricule_medecin","noms_medecin","sexe_medecin","contact_medecin","mail_medecin",
                    "grade_medecin","fonction_medecin","specialite_medecin","refMalade","refTypeMouvement",
                    "dateMouvement",'organisationAbonne','taux_prisecharge',
                    'pourcentageConvention','categoriemaladiemvt','numCartemvt',"numroBon",
                    "tmouvement.Statut as StatutMvt","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                    "dateExpiration_malade",'refTypeProduit','refSscompte','nom_produit',
                    'prix_produit','prix_convention','code_produit','refDepartement','nom_uniteproduction',
                    'code_uniteproduction','nom_departement','code_departement','nom_typeproduit',
                    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
                    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
                    'refTypecompte','refPosition','nom_classe','numero_classe','tfin_ssouscompte.author',
                    'nom_typeposition',"nom_typecompte")
                    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                    ->selectRaw('CONCAT(YEAR(datefacture),"",MONTH(datepaie),"00",refEnteteFacturation) as codeFacture')
                    ->selectRaw('(quantite*prixunitaire) as prixTotal')
                    ->where('refEnteteFacturation','=', $id)     
                   ->get();      
                   $output='';
                   foreach ($data3 as $row) 
                   {
                       $noms=$row->noms;
                       $Categorie=$row->categoriemaladiemvt;
                       $dateMouvement=$row->dateMouvement;  
                       $codeFacture=$row->codeFacture;                                   
                   }
           
            
            
                    $output='
    
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>FACTURE_SYNTHESE_PRIVEEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs3A663619 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .csAAA9B5FF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:11px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csA803F7DA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:560px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:4px;"></td>
                            <td style="height:0px;width:5px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:21px;"></td>
                            <td style="height:0px;width:94px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:23px;"></td>
                            <td style="height:0px;width:20px;"></td>
                            <td style="height:0px;width:58px;"></td>
                            <td style="height:0px;width:3px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:78px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:72px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs101A94F7" colspan="2" style="width:100px;height:72px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:100px;height:72px;">
                                <img alt="" src="'.$pic2.'" style="width:100px;height:72px;" /></div>
                            </td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA803F7DA" colspan="9" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$nomEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:27px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csAAA9B5FF" colspan="9" style="width:311px;height:27px;line-height:12px;text-align:center;vertical-align:middle;">'.$busnessName.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csA803F7DA" colspan="9" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="9" style="width:311px;height:24px;line-height:10px;text-align:center;vertical-align:middle;">'.$adresseEse.'</td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="9" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="cs761EE787" colspan="9" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td></td>
                            <td class="csAAA9B5FF" colspan="9" style="width:311px;height:22px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="cs3A663619" colspan="4" style="width:142px;height:33px;line-height:32px;text-align:left;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:13px;"></td>
                            <td></td>
                            <td class="csD24A75E0" colspan="2" style="width:6px;height:10px;"></td>
                            <td class="csDDFA3242" colspan="7" style="width:307px;height:10px;"></td>
                            <td class="cs62ED362D" colspan="2" style="width:6px;height:10px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Episode&nbsp;Maladie&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:15px;"></td>
                            <td></td>
                            <td class="cs593B729A" colspan="2" style="width:6px;height:12px;"></td>
                            <td class="csE7D235EF" colspan="7" style="width:307px;height:12px;"></td>
                            <td class="cs11B2FA6F" colspan="2" style="width:6px;height:12px;"></td>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs10569A86" colspan="8" style="width:254px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Montant</nobr></td>
                            <td></td>
                        </tr>
                     ';
                                                    
                                                                $output .= $this->showDetailPetitFactureSynthesePriveeEntete($id); 
                                                    
                                                                $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="8" style="width:252px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:62px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td></td>
                        </tr>
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
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csFFC1C457" colspan="5" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
    
    
        function showDetailPetitFactureSynthesePriveeEntete($id)
        {
            $data = DB::select('select refEnteteFacturation,prixTotal,refMouvement,
            refUniteProduction,refMedecin,datefacture,tfin_entetefacturation.statut as statutMvt,
            matricule_medecin,noms_medecin,sexe_medecin,contact_medecin,mail_medecin,
            grade_medecin,fonction_medecin,specialite_medecin,refMalade,refTypeMouvement,
            dateMouvement,organisationAbonne,taux_prisecharge,pourcentageConvention,categoriemaladiemvt,
            numCartemvt,numroBon,tmouvement.Statut as StatutMvt,dateSortieMvt,motifSortieMvt,autoriseSortieMvt,
            ttypemouvement_malade.designation as Typemouvement,noms,contact,mail,refAvenue,refCategieClient,
            tcategorieclient.designation as Categorie,tclient.photo,tclient.slug,nomAvenue,
            idCommune,nomQuartier,idQuartier,idVille,nomCommune,idProvince,nomVille,idPays,nomProvince,
            nomPays,sexe_malade,dateNaissance_malade,etatcivil_malade,
            numeroMaison_malade,fonction_malade,personneRef_malade,fonctioPersRef_malade,
            contactPersRef_malade,organisation_malade,numeroCarte_malade,
            dateExpiration_malade,refTypeProduit,refDepartement,nom_uniteproduction,
            code_uniteproduction,nom_departement,code_departement,nom_typeproduit from vfin_detailfacturation
            
            inner join tfin_entetefacturation  on tfin_entetefacturation.id = vfin_detailfacturation.refEnteteFacturation
            inner join tmedecin on tmedecin.id = tfin_entetefacturation.refMedecin
            inner join tfin_uniteproduction on tfin_uniteproduction.id = tfin_entetefacturation.refUniteProduction
            inner join tfin_departement on tfin_departement.id = tfin_uniteproduction.refDepartement
            inner join tfin_typeproduit on tfin_typeproduit.id = vfin_detailfacturation.refTypeProduit
            inner join tmouvement on tmouvement.id = tfin_entetefacturation.refMouvement
            inner join ttypemouvement_malade on ttypemouvement_malade.id = tmouvement.refTypeMouvement
            inner join tclient on tclient.id = tmouvement.refMalade
            inner join tcategorieclient on   tcategorieclient.id = tclient.refCategieClient
            inner join avenues on   avenues.id = tclient.refAvenue
            inner join quartiers on   quartiers.id = avenues.idQuartier
            inner join communes on   communes.id = quartiers.idCommune
            inner join villes on   villes.id = communes.idVille
            inner join provinces on   provinces.id = villes.idProvince
            inner join pays on   pays.id = provinces.idPays        
            
            where refEnteteFacturation = ?', [$id]);
            
            $output='';
            $count = 0;
            foreach ($data as $row) 
            { 
                $count ++;
    
                $output .='	
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8F206BC7" colspan="8" style="width:254px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
                <td class="cs332624CE" colspan="3" style="width:62px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                <td></td>
            </tr>';
           
            }
    
            return $output;
    
        }
    













    
    
}
