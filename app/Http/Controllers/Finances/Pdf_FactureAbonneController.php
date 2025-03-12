<?php

namespace App\Http\Controllers\Finances;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_FactureAbonneController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    function pdf_grand_facture_abonnee_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFactureAbonnee($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFactureAbonnee($id)
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
                $totalPatient=0;
                $totalOrg=0;        
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
                ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                ->where('refEnteteFacturation','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                    $totalPatient=$row->TotalPatient;
                    $totalOrg=$row->TotalOrg;
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $organisationAbonne='';
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
                   $organisationAbonne=$row->organisationAbonne;
                   $dateMouvement=$row->dateMouvement; 
                   $codeFacture=$row->codeFacture;                                   
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_ABONNEE</title>
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:550px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:90px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:122px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:56px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:76px;"></td>
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
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="4" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="8" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="4" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="8" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="4" style="width:169px;height:39px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="9" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="13" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:12px;"></td>
                        <td class="csC4190C00" colspan="13" style="width:673px;height:12px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs58AC6944" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:269px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:61px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="cs36E0C1B8" style="width:38px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%Patient</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:84px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;Org</nobr></td>
                    </tr>
                    ';                
                        $output .= $this->showDetailGrandFactureAbonnee($id);                
                    $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" colspan="8" style="width:446px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'&nbsp;$</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>'; 

        return $output;

    }   


    function showDetailGrandFactureAbonnee($id)
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
        //MALADE
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
        ->selectRaw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),2) as prixTotalOrg')
        ->selectRaw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),2) as prixTotalPatient')
        ->where('refEnteteFacturation','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';

        foreach ($data as $row) 
        { 

            $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csFBCBEF30" colspan="2" style="width:75px;height:22px;"></td>
            <td class="csDC7EEB9" colspan="3" style="width:269px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
            <td class="csDC7EEB9" colspan="2" style="width:61px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
            <td class="csDC7EEB9" style="width:38px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
            <td class="csDC7EEB9" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            <td class="csDC7EEB9" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'</td>
            <td class="csDC7EEB9" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'</td>
          </tr>
            ';

            
           
        }

        return $output;

    }

    //=============== FACTURE GRAND FORMAT PAR MOUVEMENT =================================================================================================


    function pdf_grand_facture_abonnee_mouvement_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoGrandFactureAbonneeMouvement($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoGrandFactureAbonneeMouvement($id)
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
                $totalPatient=0;
                $totalOrg=0;        
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
                ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                ->where('refMouvement','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                    $totalPatient=$row->TotalPatient;
                    $totalOrg=$row->TotalOrg;
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $organisationAbonne='';
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
                   $organisationAbonne=$row->organisationAbonne;
                   $dateMouvement=$row->dateMouvement;    
                   $codeFacture=$row->codeFacture;                                
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_ABONNEE</title>
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:550px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:90px;"></td>
                        <td style="height:0px;width:58px;"></td>
                        <td style="height:0px;width:122px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:56px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:76px;"></td>
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
                        <td style="width:0px;height:35px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:488px;height:32px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                        <td class="csDDFA3242" colspan="4" style="width:169px;height:32px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:23px;"></td>
                        <td class="csFBB219FE" colspan="8" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="csF7560ECA" colspan="4" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:42px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="8" style="width:488px;height:39px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                        <td class="csE7D235EF" colspan="4" style="width:169px;height:39px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="9" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>FACTURE</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:9px;"></td>
                        <td class="csA49D7241" colspan="13" style="width:673px;height:9px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&#160;:&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="13" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:12px;"></td>
                        <td class="csC4190C00" colspan="13" style="width:673px;height:12px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:4px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs58AC6944" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:269px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:61px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="cs36E0C1B8" style="width:38px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%Patient</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:84px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;Org</nobr></td>
                    </tr>
                    ';                
                        $output .= $this->showDetailGrandFactureAbonneeMouvement($id);                
                    $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs91032837" colspan="8" style="width:446px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                        <td class="cs479D8C74" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'&nbsp;$</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                        <td class="cs479D8C74" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>'; 

        return $output;

    }   


    function showDetailGrandFactureAbonneeMouvement($id)
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
        //MALADE
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
        ->selectRaw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),2) as prixTotalOrg')
        ->selectRaw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),2) as prixTotalPatient')
        ->where('refMouvement','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';

        foreach ($data as $row) 
        { 

            $output .='
            <tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csFBCBEF30" colspan="2" style="width:75px;height:22px;"></td>
            <td class="csDC7EEB9" colspan="3" style="width:269px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
            <td class="csDC7EEB9" colspan="2" style="width:61px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
            <td class="csDC7EEB9" style="width:38px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
            <td class="csDC7EEB9" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
            <td class="csDC7EEB9" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'</td>
            <td class="csDC7EEB9" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'</td>
          </tr>
            ';

            
           
        }

        return $output;

    }





    //============ PETITE FACTURE POUR LES ABONEES =============================================================================


    function pdf_petite_facture_abonnee_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoPetiteFactureAbonnee($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a6');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoPetiteFactureAbonnee($id)
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
                $totalPatient=0;
                $totalOrg=0;        
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
                ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                ->where('refEnteteFacturation','=', $id)    
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                    $totalFact=$row->TotalFacture;
                    $totalPatient=$row->TotalPatient;
                    $totalOrg=$row->TotalOrg;
                }

                $noms='';
                $Categorie='';
                $dateMouvement='';
                $organisationAbonne='';
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
                   $organisationAbonne=$row->organisationAbonne;
                   $dateMouvement=$row->dateMouvement;  
                   $codeFacture=$row->codeFacture;                                  
               }
       
        
        
                $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>FACTURE_ABONNEE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:15px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:29px;"></td>
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
                        <td class="csA803F7DA" colspan="11" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
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
                        <td class="cs761EE787" colspan="11" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                        <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
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
                        <td class="cs10569A86" colspan="5" style="width:128px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                        <td class="csFB1220E1" style="width:23px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                        <td class="cs2AAE814A" style="width:31px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                        <td class="cs32E815B6" colspan="2" style="width:39px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                        <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Pat.</nobr></td>
                        <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Org</nobr></td>
                        <td></td>
                    </tr>
                    ';                
                                        $output .= $this->showDetailPetiteFactureAbonnee($id);                
                                    $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9B633122" colspan="7" style="width:188px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                        <td class="cs54BE9109" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                        <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                        <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                        <td class="csFFC1C457" colspan="8" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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

//
    function showDetailPetiteFactureAbonnee($id)
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
        //MALADE
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
        ->selectRaw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),2) as prixTotalOrg')
        ->selectRaw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),2) as prixTotalPatient')
        ->where('refEnteteFacturation','=', $id) 
        ->orderBy("nom_typeproduit", "asc")
        ->get();

        $output='';

        foreach ($data as $row) 
        { 
            $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs8F206BC7" colspan="5" style="width:128px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                <td class="cs332624CE" style="width:21px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                <td class="cs332624CE" style="width:31px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</</td>
                <td class="cs332624CE" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                <td class="csB318F1BB" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                <td class="csB318F1BB" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                <td></td>
            </tr>
            ';           
           
        }

        return $output;

    }



        //============ PETITE FACTURE POUR LES ABONEES SELON LE MOUVEMENT =============================================================================

//
        function pdf_petite_facture_abonnee_mouvement_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetiteFactureAbonneeMouvement($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetiteFactureAbonneeMouvement($id)
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
                    $totalPatient=0;
                    $totalOrg=0;        
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
                    ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                    ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                    ->where('refMouvement','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                        $totalPatient=$row->TotalPatient;
                        $totalOrg=$row->TotalOrg;
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $organisationAbonne='';
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
                       $organisationAbonne=$row->organisationAbonne;
                       $dateMouvement=$row->dateMouvement;  
                       $codeFacture=$row->codeFacture;                                  
                   }
           
            
            
                    $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>FACTURE_ABONNEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:23px;"></td>
                            <td style="height:0px;width:26px;"></td>
                            <td style="height:0px;width:36px;"></td>
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:29px;"></td>
                            <td style="height:0px;width:49px;"></td>
                            <td style="height:0px;width:29px;"></td>
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
                            <td class="csA803F7DA" colspan="11" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
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
                            <td class="cs761EE787" colspan="11" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
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
                            <td class="cs10569A86" colspan="5" style="width:128px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="csFB1220E1" style="width:23px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                            <td class="cs2AAE814A" style="width:31px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                            <td class="cs32E815B6" colspan="2" style="width:39px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Pat.</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Org</nobr></td>
                            <td></td>
                        </tr>
                        ';                
                                            $output .= $this->showDetailPetiteFactureAbonneeMouvement($id);                
                                        $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="7" style="width:188px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                            <td class="csFFC1C457" colspan="8" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
    
    //
        function showDetailPetiteFactureAbonneeMouvement($id)
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
            //MALADE
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
            ->selectRaw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),2) as prixTotalOrg')
            ->selectRaw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),2) as prixTotalPatient')
            ->where('refMouvement','=', $id) 
            ->orderBy("nom_typeproduit", "asc")
            ->get();
    
            $output='';
    
            foreach ($data as $row) 
            { 
                $output .='
                    <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8F206BC7" colspan="5" style="width:128px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                    <td class="cs332624CE" style="width:21px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                    <td class="cs332624CE" style="width:31px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</</td>
                    <td class="cs332624CE" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td class="csB318F1BB" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                    <td class="csB318F1BB" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                    <td></td>
                </tr>
                ';           
               
            }
    
            return $output;
    
        }
    



        //============ PETITE RECU POUR LES ABONNEES =============================================================================


        function pdf_petit_recu_abonnee_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitRecuAbonnee($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }            
            
        }
    
        function getInfoPetitRecuAbonnee($id)
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
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $organisationAbonne='';
                    $author='';
                    $codeRecu='';
                    $codeFacture='';

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
                        $noms=$row->noms;
                        $Categorie=$row->categoriemaladiemvt;
                        $dateMouvement=$row->dateMouvement;
                        $organisationAbonne=$row->organisationAbonne; 
                        $author=$row->author;  
                        $codeRecu=$row->codeRecu; 
                        $codeFacture=$row->codeFacture;              
                    }            
       //codeFacture

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
                                        
                    ->selectRaw('ROUND(SUM( IFNULL(montant,0)),2) as TotalFacture')
                    ->selectRaw('(ROUND((SUM(((( IFNULL(montant,0))*taux_prisecharge)/100))),2)) as TotalFactureOrg')
                    ->selectRaw('(ROUND(SUM( IFNULL(montant,0)),2))-((ROUND((SUM(((( IFNULL(montant,0))*taux_prisecharge)/100))),2))) as TotalFacturePatient')
                    ->selectRaw('ROUND(SUM( IFNULL(paie,0)),2) as TotalPaie')
                    ->selectRaw('ROUND(SUM(( IFNULL(montant,0)- IFNULL(paie,0))),2) as TotalReste')
                    ->where('tfin_entetefacturation.id','=', $refEnteteFacturation)    
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
    
                    $output='
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>RECU_PAIEMENT_ABONNEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                            .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs761EE787 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:9px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:409px;height:644px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:6px;"></td>
                            <td style="height:0px;width:4px;"></td>
                            <td style="height:0px;width:5px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:23px;"></td>
                            <td style="height:0px;width:26px;"></td>
                            <td style="height:0px;width:36px;"></td>
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:29px;"></td>
                            <td style="height:0px;width:38px;"></td>
                            <td style="height:0px;width:40px;"></td>
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
                            <td class="csA803F7DA" colspan="11" style="width:311px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
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
                            <td class="cs761EE787" colspan="11" style="width:311px;height:22px;line-height:10px;text-align:center;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                            <td class="cs3A663619" colspan="6" style="width:142px;height:33px;line-height:32px;text-align:left;vertical-align:middle;"><nobr>RECU</nobr></td>
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
                            <td style="width:0px;height:18px;"></td>
                            <td></td>
                            <td class="csD24A75E0" colspan="2" style="width:6px;height:15px;"></td>
                            <td class="csDDFA3242" colspan="9" style="width:307px;height:15px;"></td>
                            <td class="cs62ED362D" colspan="2" style="width:6px;height:15px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="csCE72709D" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Re&#231;u&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;R'.$codeRecu.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" colspan="2" style="width:6px;height:22px;"></td>
                            <td class="csCE72709D" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Cfr&nbsp;Facture&nbsp;n&#176;&#160;:&nbsp;&nbsp;&nbsp;F'.$codeFacture.'</nobr></td>
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
                            <td class="cs12FE94AA" colspan="9" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                            <td class="cs145AAE8A" colspan="2" style="width:6px;height:22px;"></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:10px;"></td>
                            <td></td>
                            <td class="cs593B729A" colspan="2" style="width:6px;height:7px;"></td>
                            <td class="csE7D235EF" colspan="9" style="width:307px;height:7px;"></td>
                            <td class="cs11B2FA6F" colspan="2" style="width:6px;height:7px;"></td>
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
                            <td class="cs10569A86" colspan="5" style="width:128px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="csFB1220E1" style="width:23px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Qt&#233;</nobr></td>
                            <td class="cs2AAE814A" style="width:31px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PU</nobr></td>
                            <td class="cs32E815B6" colspan="2" style="width:39px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Pat.</nobr></td>
                            <td class="cs32E815B6" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Org</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td></td>
                        </tr>
                        </tr>
                         ';                
                              $output .= $this->showDetailPetitRecuAbonnee($refEnteteFacturation);                
                         $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="7" style="width:188px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$totalFactPatient.'$</td>
                            <td class="cs32E815B6" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$totalFactPatient.'$</td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$totalFactOrg.'$</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="10" style="width:270px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Total&nbsp;d&#233;j&#224;&nbsp;pay&#233;</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$totalPaie.'$</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="10" style="width:270px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Minimum&nbsp;&#224;&nbsp;payer</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$totalPaie.'$</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="10" style="width:270px;height:21px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Reste&nbsp;&#224;&nbsp;payer</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:21px;line-height:13px;text-align:center;vertical-align:middle;">'.$totalReste.'$</td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="10" style="width:270px;height:20px;line-height:15px;text-align:right;vertical-align:middle;"><nobr>Montant&nbsp;&#224;&nbsp;pay&#233;&nbsp;en&nbsp;USD</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$montantpaie.'$</td>
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
                            <td class="csFFC1C457" colspan="8" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'  Par '.$author.'</nobr></td>
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
    
    
        function showDetailPetitRecuAbonnee($refEnteteFacturation)
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
            //MALADE
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
            ->selectRaw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),2) as prixTotalOrg')
            ->selectRaw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),2) as prixTotalPatient')
            ->where('refEnteteFacturation','=', $refEnteteFacturation) 
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
                <td class="cs8F206BC7" colspan="5" style="width:128px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_produit.' : '.$row->nom_typeproduit.'</td>
                <td class="cs332624CE" style="width:21px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->quantite.'</td>
                <td class="cs332624CE" style="width:31px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixunitaire.'$</td>
                <td class="cs332624CE" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                <td class="csB318F1BB" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                <td class="csB318F1BB" colspan="3" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                <td></td>
              </tr>
                ';        
       
            }
    
            return $output;
    
        }




        //============ GRAND FACTURE SYNTHESE POUR LES ABONNEES===============================================================================================


        function pdf_grand_facture_synthese_abonnee_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoGrandFactureSyntheseAbonnee($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a4');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoGrandFactureSyntheseAbonnee($id)
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
                    $totalPatient=0;
                    $totalOrg=0;        
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
                    ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                    ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                    ->where('refEnteteFacturation','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                        $totalPatient=$row->TotalPatient;
                        $totalOrg=$row->TotalOrg;
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $organisationAbonne='';
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
                       $organisationAbonne=$row->organisationAbonne;
                       $dateMouvement=$row->dateMouvement; 
                       $codeFacture=$row->codeFacture;                                   
                   }
           
            
            
                    $output='
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>rpt_FactureSyntheseAbonnee</title>
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
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:550px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:10px;"></td>
                            <td style="height:0px;width:16px;"></td>
                            <td style="height:0px;width:61px;"></td>
                            <td style="height:0px;width:90px;"></td>
                            <td style="height:0px;width:58px;"></td>
                            <td style="height:0px;width:174px;"></td>
                            <td style="height:0px;width:49px;"></td>
                            <td style="height:0px;width:56px;"></td>
                            <td style="height:0px;width:16px;"></td>
                            <td style="height:0px;width:9px;"></td>
                            <td style="height:0px;width:27px;"></td>
                            <td style="height:0px;width:57px;"></td>
                            <td style="height:0px;width:76px;"></td>
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
                            <td class="csDDFA3242" colspan="6" style="width:488px;height:32px;"></td>
                            <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                            <td class="csDDFA3242" colspan="4" style="width:169px;height:32px;"></td>
                            <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:23px;"></td>
                            <td class="csFBB219FE" colspan="6" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                            <td class="csF7560ECA" colspan="4" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                                <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                            </td>
                            <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:22px;"></td>
                            <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:22px;"></td>
                            <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:22px;"></td>
                            <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:22px;"></td>
                            <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:22px;"></td>
                            <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:21px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:21px;"></td>
                            <td class="cs612ED82F" colspan="6" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:13px;height:1px;"></td>
                            <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                            <td class="cs101A94F7" colspan="4" style="width:169px;height:1px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:42px;"></td>
                            <td></td>
                            <td class="cs593B729A" style="width:13px;height:39px;"></td>
                            <td class="csE7D235EF" colspan="6" style="width:488px;height:39px;"></td>
                            <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                            <td class="csE7D235EF" colspan="4" style="width:169px;height:39px;"></td>
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
                            <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                            <td class="cs671B350" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs8339304C" style="width:13px;height:22px;"></td>
                            <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                            <td class="cs671B350" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:15px;"></td>
                            <td></td>
                            <td class="cs572BC00D" style="width:13px;height:12px;"></td>
                            <td class="csC4190C00" colspan="11" style="width:673px;height:12px;"></td>
                            <td class="csAAE7D8C6" style="width:6px;height:12px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:4px;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
                            <td class="cs58AC6944" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                            <td class="cs36E0C1B8" colspan="4" style="width:370px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                            <td class="cs36E0C1B8" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant</nobr></td>
                            <td class="cs36E0C1B8" colspan="2" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%Patient</nobr></td>
                            <td class="cs36E0C1B8" colspan="2" style="width:84px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;Org</nobr></td>
                        </tr>
                        ';                
                                                $output .= $this->showDetailGrandFactureSyntheseAbonnee($id);                
                                            $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="cs91032837" colspan="6" style="width:446px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                            <td class="cs479D8C74" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'&nbsp;$</nobr></td>
                            <td class="cs479D8C74" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                            <td class="cs479D8C74" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                    </html>
                    '; 
    
            return $output;
    
        }   
    
    
        function showDetailGrandFactureSyntheseAbonnee($id)
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
            code_uniteproduction,nom_departement,code_departement,nom_typeproduit,
            ROUND((((prixTotal)*taux_prisecharge)/100),2) as prixTotalOrg,
            ROUND(((prixTotal)-(((prixTotal)*taux_prisecharge)/100)),2) as prixTotalPatient
             from vfin_detailfacturation
            
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
    
            foreach ($data as $row) 
            { 

                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csFBCBEF30" colspan="2" style="width:75px;height:22px;"></td>
                        <td class="csDC7EEB9" colspan="4" style="width:370px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
                        <td class="csDC7EEB9" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                        <td class="csDC7EEB9" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                        <td class="csDC7EEB9" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                    </tr>
                ';    
             
            }
    
            return $output;
    
        }
    
         //============ GRAND FACTURE SYNTHESE POUR LES ABONNEES SELON LE MOUVEMENT===============================================================================================


         function pdf_grand_facture_synthese_abonnee_mouvement_data(Request $request)
         {
     
             if ($request->get('id')) 
             {
                 $id = $request->get('id');
                 $html = $this->getInfoGrandFactureSyntheseAbonneeMouvement($id);
                 $pdf = \App::make('dompdf.wrapper');
     
                 // echo($html);
     
     
                 $pdf->loadHTML($html);
                 $pdf->loadHTML($html)->setPaper('a4');
                 return $pdf->stream();
                 
             }
             else{
     
             }
             
             
         }
     
         function getInfoGrandFactureSyntheseAbonneeMouvement($id)
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
                     $totalPatient=0;
                     $totalOrg=0;        
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
                     ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                     ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                     ->where('refMouvement','=', $id)    
                     ->get(); 
                     $output='';
                     foreach ($data2 as $row) 
                     {                                
                         $totalFact=$row->TotalFacture;
                         $totalPatient=$row->TotalPatient;
                         $totalOrg=$row->TotalOrg;
                     }
     
                     $noms='';
                     $Categorie='';
                     $dateMouvement='';
                     $organisationAbonne='';
                     $codeFacture=0;
            
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
                        $organisationAbonne=$row->organisationAbonne;
                        $dateMouvement=$row->dateMouvement;   
                        $codeFacture=$row->codeFacture;                                 
                    }
            
             
             
                     $output='
                     <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                     <!-- saved from url=(0016)http://localhost -->
                     <html>
                     <head>
                         <title>rpt_FactureSyntheseAbonnee</title>
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
                     <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:550px;position:relative;">
                         <tr>
                             <td style="width:0px;height:0px;"></td>
                             <td style="height:0px;width:10px;"></td>
                             <td style="height:0px;width:16px;"></td>
                             <td style="height:0px;width:61px;"></td>
                             <td style="height:0px;width:90px;"></td>
                             <td style="height:0px;width:58px;"></td>
                             <td style="height:0px;width:174px;"></td>
                             <td style="height:0px;width:49px;"></td>
                             <td style="height:0px;width:56px;"></td>
                             <td style="height:0px;width:16px;"></td>
                             <td style="height:0px;width:9px;"></td>
                             <td style="height:0px;width:27px;"></td>
                             <td style="height:0px;width:57px;"></td>
                             <td style="height:0px;width:76px;"></td>
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
                             <td class="csDDFA3242" colspan="6" style="width:488px;height:32px;"></td>
                             <td class="csDDFA3242" style="width:16px;height:32px;"></td>
                             <td class="csDDFA3242" colspan="4" style="width:169px;height:32px;"></td>
                             <td class="cs62ED362D" style="width:6px;height:32px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:23px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:23px;"></td>
                             <td class="csFBB219FE" colspan="6" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                             <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                             <td class="csF7560ECA" colspan="4" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                                 <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                             </td>
                             <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:22px;"></td>
                             <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                             <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:22px;"></td>
                             <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                             <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:22px;"></td>
                             <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                             <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:22px;"></td>
                             <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                             <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:22px;"></td>
                             <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                             <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:21px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:21px;"></td>
                             <td class="cs612ED82F" colspan="6" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                             <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:1px;"></td>
                             <td></td>
                             <td class="csBDA79072" style="width:13px;height:1px;"></td>
                             <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                             <td class="cs101A94F7" colspan="4" style="width:169px;height:1px;"></td>
                             <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:42px;"></td>
                             <td></td>
                             <td class="cs593B729A" style="width:13px;height:39px;"></td>
                             <td class="csE7D235EF" colspan="6" style="width:488px;height:39px;"></td>
                             <td class="csE7D235EF" style="width:16px;height:39px;"></td>
                             <td class="csE7D235EF" colspan="4" style="width:169px;height:39px;"></td>
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
                             <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                             <td class="cs671B350" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:22px;"></td>
                             <td></td>
                             <td class="cs8339304C" style="width:13px;height:22px;"></td>
                             <td class="cs12FE94AA" colspan="11" style="width:671px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&#160;:&nbsp;&nbsp;'.$dateMouvement.'</nobr></td>
                             <td class="cs671B350" style="width:6px;height:22px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:15px;"></td>
                             <td></td>
                             <td class="cs572BC00D" style="width:13px;height:12px;"></td>
                             <td class="csC4190C00" colspan="11" style="width:673px;height:12px;"></td>
                             <td class="csAAE7D8C6" style="width:6px;height:12px;"></td>
                         </tr>
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:4px;"></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
                             <td></td>
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
                             <td class="cs58AC6944" colspan="2" style="width:75px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                             <td class="cs36E0C1B8" colspan="4" style="width:370px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>El&#233;ment</nobr></td>
                             <td class="cs36E0C1B8" colspan="3" style="width:80px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Montant</nobr></td>
                             <td class="cs36E0C1B8" colspan="2" style="width:83px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%Patient</nobr></td>
                             <td class="cs36E0C1B8" colspan="2" style="width:84px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>%&nbsp;Org</nobr></td>
                         </tr>
                         ';                
                                                 $output .= $this->showDetailGrandFactureSyntheseAbonneeMouvement($id);                
                                             $output.='
                         <tr style="vertical-align:top;">
                             <td style="width:0px;height:24px;"></td>
                             <td></td>
                             <td class="cs91032837" colspan="6" style="width:446px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;($)</nobr></td>
                             <td class="cs479D8C74" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'&nbsp;$</nobr></td>
                             <td class="cs479D8C74" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                             <td class="cs479D8C74" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                     </html>
                     '; 
     
             return $output;
     
         }   
     
     
         function showDetailGrandFactureSyntheseAbonneeMouvement($id)
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
             code_uniteproduction,nom_departement,code_departement,nom_typeproduit,
             ROUND((((prixTotal)*taux_prisecharge)/100),2) as prixTotalOrg,
             ROUND(((prixTotal)-(((prixTotal)*taux_prisecharge)/100)),2) as prixTotalPatient
              from vfin_detailfacturation
             
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
     
             foreach ($data as $row) 
             { 
 
                 $output .='
                         <tr style="vertical-align:top;">
                         <td style="width:0px;height:24px;"></td>
                         <td></td>
                         <td class="csFBCBEF30" colspan="2" style="width:75px;height:22px;"></td>
                         <td class="csDC7EEB9" colspan="4" style="width:370px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
                         <td class="csDC7EEB9" colspan="3" style="width:80px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                         <td class="csDC7EEB9" colspan="2" style="width:83px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                         <td class="csDC7EEB9" colspan="2" style="width:84px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                     </tr>
                 ';    
              
             }
     
             return $output;
     
         }
     
    

    //============ PETIT FACTURE SYNTHESE POUR LES ABONNEES===============================================================================================


        function pdf_petit_facture_synthese_abonnee_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitFactureSyntheseAbonnee($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetitFactureSyntheseAbonnee($id)
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
                    $totalPatient=0;
                    $totalOrg=0;        
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
                    ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                    ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                    ->where('refEnteteFacturation','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                        $totalPatient=$row->TotalPatient;
                        $totalOrg=$row->TotalOrg;
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $organisationAbonne='';
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
                       $organisationAbonne=$row->organisationAbonne;
                       $dateMouvement=$row->dateMouvement;   
                       $codeFacture=$row->codeFacture;                                 
                   }
           
            
            
                    $output='
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>FACTURE_SYNTHESE_ABONNEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:29px;"></td>
                            <td style="height:0px;width:49px;"></td>
                            <td style="height:0px;width:29px;"></td>
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
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
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
                            <td class="cs10569A86" colspan="5" style="width:190px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="cs32E815B6" colspan="2" style="width:39px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Pat.</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Org</nobr></td>
                            <td></td>
                        </tr>
                        ';                
                                                                    $output .= $this->showDetailPetitFactureSyntheseAbonnee($id);                
                                                                $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="5" style="width:188px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                            <td class="csFFC1C457" colspan="6" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
    
    
        function showDetailPetitFactureSyntheseAbonnee($id)
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
            code_uniteproduction,nom_departement,code_departement,nom_typeproduit,
            ROUND((((prixTotal)*taux_prisecharge)/100),2) as prixTotalOrg,
            ROUND(((prixTotal)-(((prixTotal)*taux_prisecharge)/100)),2) as prixTotalPatient
             from vfin_detailfacturation
            
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
    
            foreach ($data as $row) 
            { 
                $output .='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8F206BC7" colspan="5" style="width:190px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
                    <td class="cs332624CE" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td class="csB318F1BB" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                    <td class="csB318F1BB" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                    <td></td>
                </tr>

                ';                
             
            }
    
            return $output;
    
        }



        //============ PETIT FACTURE SYNTHESE POUR LES ABONNEES SELON MOUVEMENT=================================================================


        function pdf_petit_facture_synthese_abonnee_mouvement_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoPetitFactureSyntheseAbonneeMouvement($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a6');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoPetitFactureSyntheseAbonneeMouvement($id)
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
                    $totalPatient=0;
                    $totalOrg=0;        
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
                    ->selectRaw('ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2) as TotalOrg')
                    ->selectRaw('((ROUND(SUM(quantite*prixunitaire),2))-(ROUND(SUM((((quantite*prixunitaire)*taux_prisecharge)/100)),2))) as TotalPatient')
                    ->where('refMouvement','=', $id)    
                    ->get(); 
                    $output='';
                    foreach ($data2 as $row) 
                    {                                
                        $totalFact=$row->TotalFacture;
                        $totalPatient=$row->TotalPatient;
                        $totalOrg=$row->TotalOrg;
                    }
    
                    $noms='';
                    $Categorie='';
                    $dateMouvement='';
                    $organisationAbonne='';
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
                       $organisationAbonne=$row->organisationAbonne;
                       $dateMouvement=$row->dateMouvement;   
                       $codeFacture=$row->codeFacture;                                 
                   }
           
            
            
                    $output='
                    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                    <!-- saved from url=(0016)http://localhost -->
                    <html>
                    <head>
                        <title>FACTURE_SYNTHESE_ABONNEE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .cs8F206BC7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .cs10569A86 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs54BE9109 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs332624CE {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Microsoft Sans Serif; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs32E815B6 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csB318F1BB {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
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
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:85px;"></td>
                            <td style="height:0px;width:15px;"></td>
                            <td style="height:0px;width:29px;"></td>
                            <td style="height:0px;width:49px;"></td>
                            <td style="height:0px;width:29px;"></td>
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
                            <td class="cs12FE94AA" colspan="7" style="width:305px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CATEGORIE&#160;:&nbsp;'.$Categorie.'&nbsp;&nbsp;-&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
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
                            <td class="cs10569A86" colspan="5" style="width:190px;height:20px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Element</nobr></td>
                            <td class="cs32E815B6" colspan="2" style="width:39px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>PT</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Pat.</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>%Org</nobr></td>
                            <td></td>
                        </tr>
                        ';                
                                                                    $output .= $this->showDetailPetitFactureSyntheseAbonneeMouvement($id);                
                                                                $output.='
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="cs9B633122" colspan="5" style="width:188px;height:20px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Total&nbsp;factur&#233;</nobr></td>
                            <td class="cs54BE9109" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;"><nobr>'.$totalFact.'$</nobr></td>
                            <td class="cs32E815B6" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalPatient.'$</nobr></td>
                            <td class="cs32E815B6" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$totalOrg.'$</nobr></td>
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
                            <td class="csFFC1C457" colspan="6" style="width:207px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
    
    
        function showDetailPetitFactureSyntheseAbonneeMouvement($id)
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
            code_uniteproduction,nom_departement,code_departement,nom_typeproduit
            ,ROUND((((prixTotal)*taux_prisecharge)/100),2) as prixTotalOrg,
            ROUND(((prixTotal)-(((prixTotal)*taux_prisecharge)/100)),2) as prixTotalPatient
             from vfin_detailfacturation
            
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
    
            foreach ($data as $row) 
            { 
                $output .='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8F206BC7" colspan="5" style="width:190px;height:20px;line-height:12px;text-align:left;vertical-align:middle;">'.$row->nom_typeproduit.'</td>
                    <td class="cs332624CE" colspan="2" style="width:39px;height:20px;line-height:12px;text-align:center;vertical-align:middle;">'.$row->prixTotal.'$</td>
                    <td class="csB318F1BB" style="width:44px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalPatient.'$</td>
                    <td class="csB318F1BB" colspan="3" style="width:33px;height:20px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->prixTotalOrg.'$</td>
                    <td></td>
                </tr>

                ';                
             
            }
    
            return $output;
    
        }



//=====================================================================================================
//============ RAPPORT TARIFICATION ==============================================================

public function fetch_rapport_tarification(Request $request)
{
    //

    if ($request->get('refTypeProduit') && $request->get('refCategorieSociete')) {
        // code...
        $refTypeProduit = $request->get('refTypeProduit');
        $refCategorieSociete = $request->get('refCategorieSociete');

        //$html .="".$this->printRapportTarification($refTypeProduit, $refCategorieSociete);   

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportTarification($refTypeProduit, $refCategorieSociete);
       
        $html .='<script>window.print()</script>';

        echo($html);

        $pdf = \App::make('dompdf.wrapper');

        

        




        // $pdf->loadHTML($html)->setPaper('a4');
        // return $pdf->stream();            

    } else {
        // code...
    }
    
}

function printRapportTarification($refTypeProduit, $refCategorieSociete)
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


        

        
         $nom_typeproduit='';
         $name_categorie_societe='';
        
         set_time_limit(6000);
         $data3=DB::table('tfin_produit')   
         ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
         ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
         ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
         ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
         ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
         ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
         ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
         ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
         ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
         'prix_produit','prix_convention','code_produit','nom_typeproduit',
         'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
         'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
         'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
         'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
         ->where([
            ['refCategorieSociete','=', $refCategorieSociete],          
            ['refTypeProduit','=', $refTypeProduit]
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_typeproduit=$row->nom_typeproduit;
            $name_categorie_societe=$row->name_categorie_societe;                   
        }
    

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>TARIFICATIONS</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs169EA1F9 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:30px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:712px;height:366px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:6px;"></td>
                <td style="height:0px;width:140px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:80px;"></td>
                <td style="height:0px;width:130px;"></td>
                <td style="height:0px;width:42px;"></td>
                <td style="height:0px;width:93px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:170px;"></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td class="cs739196BC" colspan="6" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                <td class="csFBB219FE" colspan="7" style="width:523px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" rowspan="7" style="width:170px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:170px;height:154px;">
                    <img alt="" src="'.$pic2.'" style="width:170px;height:154px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="7" rowspan="2" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
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
                <td></td>
                <td></td>
                <td class="cs169EA1F9" colspan="5" style="width:370px;height:40px;line-height:35px;text-align:center;vertical-align:middle;"><nobr>TARIFICATIONS</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" style="width:138px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>CAREGORIE&nbsp;:</nobr></td>
                <td class="cs6105B8F3" colspan="3" style="width:219px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$name_categorie_societe.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" style="width:138px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>TYPE&nbsp;PRODUIT&nbsp;:</nobr></td>
                <td class="cs6105B8F3" colspan="3" style="width:219px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$nom_typeproduit.'</td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs58AC6944" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;PRODUIT</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:264px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PRODUIT</nobr></td>
                <td class="cs36E0C1B8" colspan="3" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MONTANT&nbsp;($)</nobr></td>
            </tr>
            ';
        
                    $output .= $this->showTarification($refTypeProduit, $refCategorieSociete); 
        
                    $output.='
        </table>
        </body>
        </html>
        ';  
       
        return $output; 

}

function showTarification($refTypeProduit, $refCategorieSociete)
{
    $count=0;

    set_time_limit(60000);
    $data = DB::table('tfin_produit')   
    ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tfin_produit.refCategorieSociete')         
    ->join('tfin_typeproduit','tfin_typeproduit.id','=','tfin_produit.refTypeProduit')
    ->join('tfin_ssouscompte','tfin_ssouscompte.id','=','tfin_produit.refSscompte')
    ->join('tfin_souscompte','tfin_souscompte.id','=','tfin_ssouscompte.refSousCompte')
    ->join('tfin_compte','tfin_compte.id','=','tfin_souscompte.refCompte')
    ->join('tfin_classe','tfin_classe.id','=','tfin_compte.refClasse')
    ->join('tfin_typecompte','tfin_typecompte.id','=','tfin_compte.refTypecompte')
    ->join('tfin_typeposition','tfin_typeposition.id','=','tfin_compte.refPosition')
    ->select('tfin_produit.id','refTypeProduit','refSscompte','nom_produit',
    'prix_produit','prix_convention','code_produit','nom_typeproduit',
    'refSousCompte','nom_ssouscompte','numero_ssouscompte','nom_souscompte',
    'numero_souscompte','refCompte','nom_compte','numero_compte','refClasse',
    'refTypecompte','refPosition','nom_classe','numero_classe','tfin_produit.author',
    'nom_typeposition',"nom_typecompte",'refCategorieSociete','name_categorie_societe')
    ->where([
       ['refTypeProduit','=', $refTypeProduit],          
       ['refCategorieSociete','=', $refCategorieSociete]
   ])    
   ->orderBy("nom_produit", "asc")  
    ->get();
//
    $output='';

    foreach ($data as $row) 
    {
        $count ++; 
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs22DF2452" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">('.$count.') - '.$row->nom_typeproduit.'</td>
                <td class="cs6E02D7D2" colspan="3" style="width:264px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->nom_produit.'</td>
                <td class="cs36E0C1B8" colspan="3" style="width:209px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->prix_produit.'$</td>
            </tr>
        ';     
   
    }

    return $output;

}






//================================================================================================================================
//==============================================================================================================================================
//============= LISTE DES BONNEES PAR ORGANISATION =========================================================================


public function fetch_rapport_listePatientOrganisation(Request $request)
{
    //

    if ($request->get('organisationAbonne')) {
        // code...
        $organisationAbonne = $request->get('organisationAbonne');
        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printRapportListePatient($organisationAbonne);       
        $html .='<script>window.print()</script>';
        echo($html);
    } else {
        // code...
    }
    
}

function printRapportListePatient($organisationAbonne)
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


        $refOrganisation='';

        $data5=DB::table('tconf_organisationabone')
        ->join('tfin_categorie_societe','tfin_categorie_societe.id','=','tconf_organisationabone.refCategorieSociete')
        ->select("tconf_organisationabone.id",'nom_org', 'adresse_org', 'contact_org',
        'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons','refCategorieSociete',
        'name_categorie_societe','author',"tconf_organisationabone.created_at")
        ->where('tconf_organisationabone.nom_org','=', $organisationAbonne)      
        ->get();      
        $output='';
        foreach ($data5 as $row) 
        {
            $refOrganisation=$row->id;               
        }
          

        
         $nom_org='';
         $adresse_org='';
         $contact_org='';

         $data3=DB::table('tconf_affectationabone')            
         ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
         ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
         ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
         ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
         ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
         ->join('communes' , 'communes.id','=','quartiers.idCommune')
         ->join('villes' , 'villes.id','=','communes.idVille')
         ->join('provinces' , 'provinces.id','=','villes.idProvince')
         ->join('pays' , 'pays.id','=','provinces.idPays')
         //MALADE
         ->select("tconf_affectationabone.id","refMalade","refOrganisation",
         "Statut","tauxcharge","tconf_affectationabone.author",
         "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
         'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
         "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
         "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
         "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
         "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
         "contactPersRef_malade","organisation_malade","numeroCarte_malade",
         "dateExpiration_malade")
         ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
         ->where([
            ['refOrganisation','=', $refOrganisation],          
            ['Statut','=', 'Encours']
        ])      
        ->get();      
        $output='';
        foreach ($data3 as $row) 
        {
            $nom_org=$row->nom_org;
            $adresse_org=$row->adresse_org; 
            $contact_org=$row->contact_org;                   
        }
    

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>LISTE DES PATIENT_'.$nom_org.'</title>
            <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
            <style type="text/css">
                .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs22DF2452 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                .cs6E02D7D2 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                .cs8A513397 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                .cs933BB7D6 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:30px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
            </style>
        </head>
        <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:712px;height:395px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:6px;"></td>
                <td style="height:0px;width:75px;"></td>
                <td style="height:0px;width:48px;"></td>
                <td style="height:0px;width:279px;"></td>
                <td style="height:0px;width:1px;"></td>
                <td style="height:0px;width:88px;"></td>
                <td style="height:0px;width:5px;"></td>
                <td style="height:0px;width:29px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:113px;"></td>
                <td style="height:0px;width:57px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:23px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="7" style="width:523px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:170px;height:154px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:170px;height:154px;">
                    <img alt="" src="'.$pic2.'" style="width:170px;height:154px;" /></div>
                </td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="7" style="width:523px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="7" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:21px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="7" rowspan="2" style="width:523px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:40px;"></td>
                <td></td>
                <td class="cs933BB7D6" colspan="10" style="width:702px;height:40px;line-height:35px;text-align:center;vertical-align:middle;"><nobr>LISTE&nbsp;DES&nbsp;PATIENTS&nbsp;PAR&nbsp;ORGANISATION</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="2" style="width:121px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>ORGANISATION&nbsp;:</nobr></td>
                <td class="cs8A513397" colspan="4" style="width:371px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$nom_org.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="2" style="width:121px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>ADRESSE&nbsp;:</nobr></td>
                <td class="cs8A513397" colspan="4" style="width:371px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$adresse_org.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="2" style="width:121px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>CONTACT&nbsp;:</nobr></td>
                <td class="cs8A513397" colspan="4" style="width:371px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$contact_org.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs58AC6944" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;</nobr></td>
                <td class="cs36E0C1B8" colspan="2" style="width:326px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs36E0C1B8" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                <td class="cs36E0C1B8" colspan="4" style="width:157px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TAUX&nbsp;(%)</nobr></td>
                <td></td>
            </tr>
             ';
                
                $output .= $this->showListePatient($refOrganisation); 
                
                $output.='
        </table>
        </body>
        </html>
        ';  
       
        return $output; 

}

function showListePatient($refOrganisation)
{
    $data = DB::table('tconf_affectationabone')            
    ->join('tconf_organisationabone','tconf_organisationabone.id','=','tconf_affectationabone.refOrganisation')
    ->join('tclient','tclient.id','=','tconf_affectationabone.refMalade')
    ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
    ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
    ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
    ->join('communes' , 'communes.id','=','quartiers.idCommune')
    ->join('villes' , 'villes.id','=','communes.idVille')
    ->join('provinces' , 'provinces.id','=','villes.idProvince')
    ->join('pays' , 'pays.id','=','provinces.idPays')
    //MALADE
    ->select("tconf_affectationabone.id","refMalade","refOrganisation",
    "Statut","tauxcharge","tconf_affectationabone.author",
    "tconf_affectationabone.created_at","tconf_affectationabone.updated_at",'nom_org', 'adresse_org',
    'contact_org', 'rccm_org', 'idnat_org','pourcentageConvention','nmbreJourCons',"noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille",
    "idPays","nomProvince","nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->where([
       ['refOrganisation','=', $refOrganisation],          
       ['Statut','=', 'Encours']
   ])     
    ->get();

    $count=0;

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs22DF2452" style="width:73px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:326px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
                <td class="cs6E02D7D2" colspan="2" style="width:88px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->sexe_malade.'</td>
                <td class="cs36E0C1B8" colspan="4" style="width:157px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->tauxcharge.'%</td>
                <td></td>
            </tr>
        ';   
   
    }

    return $output;

}









    
    
}
