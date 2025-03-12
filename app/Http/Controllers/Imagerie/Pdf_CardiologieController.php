<?php

namespace App\Http\Controllers\Imagerie;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_CardiologieController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    //=========================================================================================================================
    //====================== SCORE PROBABILISTE ================================================================================



    function pdf_scoreprobabiliste_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoScroreProbabiliste($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoScroreProbabiliste($id)
    {

                $titres="SCORE PROBABILISTE";
                $nat="l'";

                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $codeDossier='';
                $sexe_malade='';
                $age_malade=0;
                $medecinProtocolaire='';
                $specialiste='';

                $totalScore=0;
                
                $data = DB::table('tim_score_probabilite_score')
                ->join('tim_imagerie','tim_imagerie.id','=','tim_score_probabilite_score.refImagerie')
                ->join('tim_parametre_score','tim_parametre_score.id','=','tim_score_probabilite_score.refparamScore')
                ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
                ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
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
        
                ->select("tim_score_probabilite_score.id","genre","score","desi_libelle","desi_interval",
                "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
                "refEnteteCons","refTypeCons","dateImagerie","clinique","but","CNOM","examenDemande",
                 "tim_imagerie.specialiste" , "tim_imagerie.status","medecinProtocolaire",
                 'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
                "refLibelle","refInterval","refImagerie","refparamScore",
                //----------------------------------------------------
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',
                "tenteteconsulter.author",
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
                 "sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tim_score_probabilite_score.refImagerie', $id)
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
                    $medecinProtocolaire=$row->medecinProtocolaire;     
                    $specialiste =$row->specialiste;         
                    
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



                $data2 = DB::table('tim_score_probabilite_score')
                ->join('tim_imagerie','tim_imagerie.id','=','tim_score_probabilite_score.refImagerie')
                ->join('tim_parametre_score','tim_parametre_score.id','=','tim_score_probabilite_score.refparamScore')
                ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
                ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
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
        
                ->select(DB::raw('ROUND(SUM(score),0) as totalScore'))
                ->where('tim_score_probabilite_score.refImagerie', $id)   
                ->get(); 
                $output='';
                foreach ($data2 as $row) 
                {                                
                   $totalScore=$row->totalScore;
                                  
                }


                $etats="d'effort";
                $epreuve="l'Epreuve&nbsp;d'effort";
                $hommes="l'homme";
        
                $output='

                <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <!-- saved from url=(0016)http://localhost -->
                <html>
                <head>
                    <title>SCORE PROBABILISTE</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .cs12A5537E {color:#000000;background-color:#000000;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDC7EEB9 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                        .cs36E0C1B8 {color:#000000;background-color:transparent;border-left-style: none;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs388CADE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:709px;height:691px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:100px;"></td>
                        <td style="height:0px;width:176px;"></td>
                        <td style="height:0px;width:88px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:43px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:97px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:1px;"></td>
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
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="6" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="6" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="6" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="6" style="width:488px;height:14px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:169px;height:14px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:14px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="12" style="width:694px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>SCORE&nbsp;DE&nbsp;PROBABILITE&nbsp;DE&nbsp;CORONAROPATHIE</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="2" style="width:115px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;Post&nbsp;nom&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="10" style="width:579px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:36px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="12" style="width:696px;height:36px;line-height:15px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;Pr&#233;cordialgie&nbsp;typique&nbsp;&nbsp;/&nbsp;2.&nbsp;Pr&#233;cordialgie&nbsp;atypique&nbsp;/&nbsp;3.&nbsp;Diab&#233;tique&nbsp;de&nbsp;10&nbsp;ans&nbsp;ou&nbsp;plus&nbsp;&nbsp;/&nbsp;4.&nbsp;Autres&nbsp;(Evaluation&nbsp;de</nobr><br/><nobr>cardiopathie,&nbsp;Malaise&nbsp;;&nbsp;syncope&nbsp;...)</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="9" style="width:580px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Score&nbsp;de&nbsp;probabilit&#233;&nbsp;de&nbsp;coronarophathie&nbsp;,&nbsp;modifi&#233;&nbsp;selon&nbsp;Ashley&nbsp;&#224;&nbsp;'.$epreuve.'</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="cs58AC6944" colspan="3" style="width:290px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Libell&#233;</nobr></td>
                        <td class="cs36E0C1B8" style="width:87px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Sexe</nobr></td>
                        <td class="cs36E0C1B8" colspan="6" style="width:211px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Inteval</nobr></td>
                        <td class="cs36E0C1B8" colspan="2" style="width:105px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Score</nobr></td>
                        <td></td>
                    </tr>
                    ';                        
                       $output .= $this->showScoreProbabiliste($id);                        
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="2" style="width:114px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>TOTAL&nbsp;:&nbsp;&nbsp;&nbsp;'.$totalScore.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs12A5537E" colspan="12" style="width:698px;height:1px;"></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="cs388CADE" colspan="12" style="width:698px;height:1px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="12" style="width:696px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>EE&nbsp;:&nbsp;&#233;preuve&nbsp;'.$etats.';&nbsp;&nbsp;FCM&nbsp;:&nbsp;fr&#233;quence&nbsp;cadiaque&nbsp;maximale&nbsp;;&nbsp;&nbsp;NA&nbsp;:&nbsp;non&nbsp;applicable.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="12" style="width:696px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Risque&nbsp;de&nbsp;maladie&nbsp;coronaire&nbsp;chez&nbsp;'.$hommes.'&nbsp;:&nbsp;SCORE&nbsp;&lt;&nbsp;40&nbsp;=&nbsp;probabilit&#233;&nbsp;faible&nbsp;;&nbsp;40&nbsp;-&nbsp;60&nbsp;=&nbsp;Probabilit&#233;&nbsp;interm&#233;diaire&nbsp;;&nbsp;&gt;&nbsp;60</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="12" style="width:696px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>=&nbsp;Probabilite&nbsp;&#233;lev&#233;e.</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="13" style="width:697px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Risque&nbsp;de&nbsp;maladie&nbsp;coronaire&nbsp;chez&nbsp;la&nbsp;femme&nbsp;:&nbsp;SCORE&nbsp;&lt;&nbsp;37&nbsp;=&nbsp;probabilit&#233;&nbsp;faible&nbsp;;&nbsp;37&nbsp;-&nbsp;57&nbsp;=&nbsp;Probabilit&#233;&nbsp;intermediaire;&nbsp;&gt;&nbsp;57</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs12FE94AA" colspan="12" style="width:696px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>=&nbsp;Probabilite&nbsp;&#233;lev&#233;e</nobr></td>
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
                        <td class="cs12FE94AA" colspan="7" style="width:236px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.('Y-m-d').'</nobr></td>
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
                        <td class="csCE72709D" colspan="7" style="width:236px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecinProtocolaire.'</td>
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
                        <td class="csCE72709D" colspan="7" style="width:236px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$specialiste.'</td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    function showScoreProbabiliste($id)
    {
            $data = DB::table('tim_score_probabilite_score')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_score_probabilite_score.refImagerie')
            ->join('tim_parametre_score','tim_parametre_score.id','=','tim_score_probabilite_score.refparamScore')
            ->join('tim_inverval','tim_inverval.id','=','tim_parametre_score.refInterval')
            ->join('tim_libelle_score','tim_libelle_score.id','=','tim_parametre_score.refLibelle')
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
    
            ->select("tim_score_probabilite_score.id","genre","score","desi_libelle","desi_interval",
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but","CNOM","examenDemande",
             "tim_imagerie.specialiste" , "tim_imagerie.status","medecinProtocolaire",
             'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
            "refLibelle","refInterval","refImagerie","refparamScore",
            //----------------------------------------------------
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_score_probabilite_score.created_at",
            "tim_score_probabilite_score.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_score_probabilite_score.author",
            "matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
             "sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('refImagerie','=', $id)
            ->orderBy("tim_score_probabilite_score.created_at", "asc")
            ->get();
            $output='';

            // designation_valeur

            foreach ($data as $row) 
            {

                $output .='
                        <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csFBCBEF30" colspan="3" style="width:290px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$row->desi_libelle.'</td>
                        <td class="csDC7EEB9" style="width:87px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->genre.'</td>
                        <td class="csDC7EEB9" colspan="6" style="width:211px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->desi_interval.' = '.$row->score.'</td>
                        <td class="csDC7EEB9" colspan="2" style="width:105px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->score.'</td>
                        <td></td>
                    </tr>
                ';                   

        
    
            }

        return $output;

    }

//=========================================================================================================================
//====================== RESULTAT ECG ================================================================================



    function pdf_resultatECG_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoECG($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoECG($id)
    {

                $titres="PROTOCOLE D' ECG";
                $nat="l'";

                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $codeDossier='';
                $sexe_malade='';
                $age_malade=0;
                $dateECG='';

                $rythme='';
                $ondee='';
                $segmentSt='';
                $axe=0;
                $ondeT='';
                $pR='';
                $oRS='';
                $indices='';
                $conclusion='';

                $medecin1='';
                $specialite1='';
                $cnom1='';
                $medecin2='';
                $specialite2='';
                $cnom2='';

                $totalScore=0;
                
                $data = DB::table('tim_resultat_b_c_g')
                ->join('tim_imagerie','tim_imagerie.id','=','tim_resultat_b_c_g.refImagerie')
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
              
                ->select("tim_resultat_b_c_g.id","refImagerie","rythme","ondee","segmentSt","axe","ondeT","pR",
                "oRS","indices","conclusion","medecin1","specialite1","cnom1","medecin2",
                "specialite2","cnom2","medecin3","specialite3","cnom3","medecin4","specialite4","cnom4","tim_resultat_b_c_g.author",
        
                "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
                "refEnteteCons","refTypeCons","dateImagerie","clinique","but","CNOM","examenDemande",
                "tim_imagerie.specialiste" , "tim_imagerie.status","medecinProtocolaire",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',
                //----------------------------------------------------
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tim_resultat_b_c_g.created_at",
                "tim_resultat_b_c_g.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
                'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
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
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tim_resultat_b_c_g.refImagerie', $id)
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
                    
                    $dateECG=$row->created_at;

                    $rythme=$row->rythme;
                    $ondee=$row->ondee;
                    $segmentSt=$row->segmentSt;
                    $axe=$row->axe;
                    $ondeT=$row->ondeT;
                    $pR=$row->pR;
                    $oRS=$row->oRS;
                    $indices=$row->indices;
                    $conclusion=$row->conclusion;
    
                    $medecin1=$row->medecin1;
                    $specialite1=$row->specialite1;
                    $cnom1=$row->cnom1;
                    $medecin2=$row->medecin2;
                    $specialite2=$row->specialite2;
                    $cnom2=$row->cnom2;
                             
                    
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
                    <title>RESULTAT ECG</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csAED0326D {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Microsoft Sans Serif; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csEF71EB8E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs76421F2 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs188E5F6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs5371FE36 {color:#1E90FF;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .cs9359E6D5 {color:#FF0000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Microsoft Sans Serif; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:812px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:50px;"></td>
                        <td style="height:0px;width:118px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:33px;"></td>
                        <td style="height:0px;width:153px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:32px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:114px;"></td>
                        <td style="height:0px;width:55px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="10" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="10" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="2" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:169px;height:6px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs188E5F6F" colspan="16" style="width:694px;height:33px;line-height:28px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:57px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:118px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:19px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:33px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:153px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:36px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:37px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:32px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:140px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:55px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Patient&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:321px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:321px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:55px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:321px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$age_malade.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:321px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateECG.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:57px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:118px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:33px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:32px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csEF71EB8E" colspan="13" style="width:623px;height:22px;line-height:17px;text-align:left;vertical-align:top;">1.&nbsp;Rythme&nbsp;:&nbsp;&nbsp;'.$rythme.'</td>
                        <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">2.&nbsp;Onde&nbsp;P&nbsp;&nbsp;:&nbsp;&nbsp;'.$ondee.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">3.&nbsp;Segment&nbsp;ST&nbsp;:&nbsp;'.$segmentSt.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:26px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:20px;line-height:17px;text-align:left;vertical-align:top;">4.&nbsp;Axe&nbsp;:&nbsp;'.$axe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:26px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">5.&nbsp;Onde&nbsp;T&nbsp;:&nbsp;'.$ondeT.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">6.&nbsp;PR&nbsp;:&nbsp;&nbsp;'.$pR.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">7.&nbsp;ORS&nbsp;:&nbsp;'.$oRS.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs9359E6D5" colspan="4" style="width:192px;height:22px;line-height:17px;text-align:left;vertical-align:top;">8.&nbsp;Indices&nbsp;:&nbsp;'.$indices.'</td>
                        <td class="cs101A94F7" style="width:33px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:57px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:118px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:33px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csEF71EB8E" colspan="14" style="width:678px;height:22px;line-height:17px;text-align:left;vertical-align:top;"><nobr>Conclusion&nbsp;:</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="csAED0326D" colspan="14" style="width:672px;height:19px;line-height:17px;text-align:left;vertical-align:top;">'.$conclusion.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:57px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:118px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:33px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:20px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:225px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecin1.'</td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:225px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecin2.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:225px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$specialite1.'</td>
                        <td class="cs101A94F7" style="width:153px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:225px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$specialite2.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:63px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:63px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:57px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:118px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:33px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:63px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:32px;height:63px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:140px;height:63px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:63px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:63px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs5371FE36" colspan="3" style="width:173px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Salutations&nbsp;confraternelles</nobr></td>
                        <td class="cs101A94F7" style="width:19px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:33px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="cs76421F2" colspan="5" style="width:223px;height:23px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:57px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:118px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:19px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:33px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:153px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:36px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:37px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:32px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:140px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:55px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }




//=========================================================================================================================
//====================== RESULTAT ECHOCARDIE DOPPER ==========================================================================



function pdf_resultatEchocardie_data(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfonEchocardie($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfonEchocardie($id)
{

            $titres="ECHOCARDIOGRAPHIE";
            $nat="l'";

            $noms='';
            $categoriemaladiemvt='';
            $organisationAbonne='';
            $codeDossier='';
            $sexe_malade='';
            $age_malade=0;

            $indication='';
            $ventriculeGauche='';
            $ventriculeDroite='';
            $oreillette=''; 
            $valve='';
            $oesophage='';
            $autres='';
            $conclusionCardio='';
            $imageCardio='';
            
            $medecindemandeur='';
            $medecinProtocolaire='';
            $specialiste='';
            $CNOM='';
                        
            $data = DB::table('tim_cardiologie')
            ->join('tim_imagerie','tim_imagerie.id','=','tim_cardiologie.refImagerie')
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
      
            ->select("tim_cardiologie.id",'refImagerie','indication','ventriculeGauche','ventriculeDroite',
            'oreillette', 'valve','oesophage','autres','conclusionCardio','imageCardio',
            "tim_imagerie.refDetailConst","tim_imagerie.refAnalyse","refEnteteCons","medecindemandeur","refTypeCons",
            "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
            "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
            "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tim_cardiologie.created_at",
            "tim_cardiologie.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tim_cardiologie.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
            "noms_medecin","sexe_medecin","datenaissance_medecin",
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
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
            ->where('tim_cardiologie.refImagerie', $id)
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
                
                $indication=$row->indication;
                $ventriculeGauche=$row->ventriculeGauche;
                $ventriculeDroite=$row->ventriculeDroite;
                $oreillette=$row->oreillette; 
                $valve=$row->valve;
                $oesophage=$row->oesophage;
                $autres=$row->autres;
                $conclusionCardio=$row->conclusionCardio;
                $imageCardio=$row->imageCardio;
                
                $medecindemandeur=$row->medecindemandeur;
                $medecinProtocolaire=$row->medecinProtocolaire;
                $specialiste=$row->specialiste;
                $CNOM=$row->CNOM;
                         
                
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
                <title>RESULTAT ECHOCARDIOGRAPHIE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs3D084EF5 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                    .cs18C2C98 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs207690C3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:24px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csE65A8CE5 {color:#800080;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:799px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:50px;"></td>
                    <td style="height:0px;width:27px;"></td>
                    <td style="height:0px;width:65px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:144px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:1px;"></td>
                    <td style="height:0px;width:26px;"></td>
                    <td style="height:0px;width:69px;"></td>
                    <td style="height:0px;width:10px;"></td>
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
                    <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="11" style="width:488px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                    <td class="csFBB219FE" colspan="11" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="csE314B2A3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                        <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="11" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="11" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="11" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="11" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="11" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                    <td class="cs612ED82F" colspan="11" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="2" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="11" style="width:488px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:169px;height:6px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:33px;"></td>
                    <td></td>
                    <td class="cs207690C3" colspan="16" style="width:694px;height:33px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>ECHOCARDIOGRAPHIE&nbsp;DOPPER&nbsp;TRANS-THORACIQUE</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:57px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:27px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:65px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:26px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:144px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:61px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:9px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:27px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:69px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:195px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Identit&#233;&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="5" style="width:321px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="2" style="width:55px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="5" style="width:321px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs12FE94AA" colspan="4" style="width:147px;height:23px;line-height:15px;text-align:left;vertical-align:top;">Age(ans)</td>
                    <td class="csCE72709D" colspan="3" style="width:229px;height:23px;line-height:15px;text-align:left;vertical-align:top;">'.$age_malade.'</td>
                    <td class="cs101A94F7" style="width:9px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:23px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:23px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="3" style="width:82px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Demandeur&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="4" style="width:294px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecindemandeur.'</td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="3" style="width:82px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Indication&nbsp;:</nobr></td>
                    <td class="csCE72709D" colspan="4" style="width:294px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$indication.'</td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:10px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:57px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:27px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:65px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:144px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:61px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:10px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:10px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:10px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:10px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:10px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VENTRICULE&nbsp;GAUCHE</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$ventriculeGauche.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VENTRICULE&nbsp;DROIT</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:24px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$ventriculeDroite.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>OREILLETES</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$oreillette.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VALVES</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$valve.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>GROS&nbsp;VAISSEAUX</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:24px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$oesophage.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs3D084EF5" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>AUTRES</nobr></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$autres.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs18C2C98" colspan="14" style="width:676px;height:22px;line-height:16px;text-align:center;vertical-align:top;"><nobr>CONCLUSION</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"></td>
                    <td class="cs8F84A210" colspan="14" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusionCardio.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:57px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:27px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:65px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:144px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:61px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:27px;height:20px;"></td>
                    <td class="cs101A94F7" style="width:69px;height:20px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:195px;height:20px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="csE65A8CE5" colspan="5" style="width:173px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Salutations&nbsp;confraternelles</nobr></td>
                    <td class="cs101A94F7" style="width:144px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="cs12FE94AA" colspan="6" style="width:289px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.('Y-m-d').'</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:57px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:65px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:144px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="csCE72709D" colspan="6" style="width:289px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecinProtocolaire.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:57px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:27px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:65px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:26px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:144px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                    <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                    <td class="csCE72709D" colspan="6" style="width:289px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$specialiste.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:6px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:57px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:27px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:65px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:26px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:144px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:61px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:9px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:27px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:69px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:195px;height:6px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                </tr>
            </table>
            </body>
            </html>

            ';
    return $output;

}







//=========================================================================================================================
//====================== ATTESTATION MEDICALE CARDIOLOGIE ==========================================================================



function pdf_attestation_medicale_data(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoAttestationMedicale($id);
        $pdf = \App::make('dompdf.wrapper');

        // echo($html);


        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{

    }
    
    
}

function getInfoAttestationMedicale($id)
{

            $titres="ATTESTATION MEDICALE";
            $nat="l'";

            $noms='';
            $categoriemaladiemvt='';
            $organisationAbonne='';
            $codeDossier='';
            $sexe_malade='';
            $age_malade=0;

            $descriptionAttest='';
            $conclusionAttest='';           
            
            $medecin1='';
            $specialiste1='';
            $cnom1='';

            $medecin2='';
            $specialiste2='';
            $cnom2='';
            $codeOperation='';

            $medecin3='';
            $specialiste3='';
            $cnom3='';
                        
            $data = DB::table('tim_attestation')            
            ->join('tdetailconsultation','tdetailconsultation.id','=','tim_attestation.refDetailConst')
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

            ->select("tim_attestation.id","refDetailConst","descriptionAttest","conclusionAttest",
            "medecin1","specialite1","cnom1","medecin2","specialite2","cnom2","medecin3","specialite3",
            "cnom3","medecin4","specialite4","cnom4","datelivraison","tim_attestation.author",
            //-------------------------------------------------
            "tim_attestation.author", "tim_attestation.created_at", "tim_attestation.updated_at",
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
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
            ->selectRaw('CONCAT("AM",YEAR(tim_attestation.created_at),"",MONTH(tim_attestation.created_at),"00",tim_attestation.id) as codeOperation')
            ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
            ->where('tim_attestation.refDetailConst', $id)
            //refImagerie
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

                $codeOperation=$row->codeOperation;
                
                $descriptionAttest=$row->descriptionAttest;
                $conclusionAttest=$row->conclusionAttest;           
                
                $medecin1=$row->medecin1;
                $specialite1=$row->specialite1;
                $cnom1=$row->cnom1;

    
                $medecin2=$row->medecin2;
                $specialite2=$row->specialite2;
                $cnom2=$row->cnom2;
    
                $medecin3=$row->medecin3;
                $specialite3=$row->specialite3;
                $cnom3=$row->cnom3;
                         
                
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
                <title>ATTETATION MEDICALE</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs79DF234B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs949E1716 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs990B052E {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csF1C8F74D {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; }
                    .cs86E5B993 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:16px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:552px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:7px;"></td>
                    <td style="height:0px;width:209px;"></td>
                    <td style="height:0px;width:14px;"></td>
                    <td style="height:0px;width:160px;"></td>
                    <td style="height:0px;width:61px;"></td>
                    <td style="height:0px;width:13px;"></td>
                    <td style="height:0px;width:31px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="6" style="width:488px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                    <td class="csFBB219FE" colspan="6" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                    <td class="csE314B2A3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                        <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                    </td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csCE72709D" colspan="6" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                    <td class="csFFC1C457" colspan="6" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                    <td class="cs612ED82F" colspan="6" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                    <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:1px;"></td>
                    <td></td>
                    <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                    <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" colspan="2" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="6" style="width:488px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:169px;height:6px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:33px;"></td>
                    <td></td>
                    <td class="cs7D52592D" colspan="11" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>ATTESTATION&nbsp;MEDICALE&nbsp;N&#176;&nbsp;'.$codeOperation.'</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:216px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:14px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="2" style="width:221px;height:6px;"></td>
                    <td class="csDDFA3242" style="width:13px;height:6px;"></td>
                    <td class="csDDFA3242" colspan="3" style="width:216px;height:6px;"></td>
                    <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:25px;"></td>
                    <td class="cs949E1716" colspan="9" style="width:674px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$descriptionAttest.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:216px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:221px;height:24px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:216px;height:24px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:27px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:27px;"></td>
                    <td class="csF1C8F74D" colspan="9" style="width:674px;height:21px;line-height:18px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusionAttest.'</textarea></td>
                    <td class="cs145AAE8A" style="width:6px;height:27px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:21px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:216px;height:21px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:21px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:221px;height:21px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:21px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:216px;height:21px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:26px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:26px;"></td>
                    <td class="cs86E5B993" colspan="9" style="width:672px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>La&nbsp;pr&#233;sente&nbsp;attestation&nbsp;lui&nbsp;est&nbsp;d&#233;livr&#233;e&nbsp;pour&nbsp;servir&nbsp;&#224;&nbsp;toute&nbsp;fin&nbsp;utile</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:26px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:33px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:33px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:216px;height:33px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:33px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:221px;height:33px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:33px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:216px;height:33px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:33px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:25px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:25px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:216px;height:25px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:25px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:221px;height:25px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:25px;"></td>
                    <td class="cs990B052E" colspan="3" style="width:206px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.('Y-m-d').'</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:30px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:30px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:216px;height:30px;"></td>
                    <td class="cs101A94F7" style="width:14px;height:30px;"></td>
                    <td class="cs101A94F7" colspan="2" style="width:221px;height:30px;"></td>
                    <td class="cs101A94F7" style="width:13px;height:30px;"></td>
                    <td class="cs101A94F7" colspan="3" style="width:216px;height:30px;"></td>
                    <td class="cs145AAE8A" style="width:6px;height:30px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin1.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin2.'</td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin3.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialiste1.'</td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialiste2.'</td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialiste3.'</td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom1.'</nobr></td>
                    <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="2" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom2.'</nobr></td>
                    <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                    <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom3.'</nobr></td>
                    <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:6px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:216px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:14px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="2" style="width:221px;height:6px;"></td>
                    <td class="csE7D235EF" style="width:13px;height:6px;"></td>
                    <td class="csE7D235EF" colspan="3" style="width:216px;height:6px;"></td>
                    <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                </tr>
            </table>
            </body>
            </html>

            ';
    return $output;

}








//================================================================================================================================
//================ BON DE DEMANDE D'IMAGERIE =====================================================================================



function pdf_bon_analyse_data(Request $request)
{

    if ($request->get('id')) 
    {
        $id = $request->get('id');
        $html = $this->getInfoBonImagerie($id);
        $pdf = \App::make('dompdf.wrapper');
        // echo($html);

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4');
        return $pdf->stream();
        
    }
    else{
    }       
    
}

function getInfoBonImagerie($id)
{
            //Info Malade
            $code_malade='';
            $noms_malade='';
            $sexe_malade='';
            $datenaiss_malade='';
            $telephone_malade='';
            $mail_malade='';
            $adresse_malade='';
            $telephonerefrence_malade=''; 
            
            
            //Info Medecin
            $code_medecin='';
            $noms_medecin='';
            $sexe_medecin='';
            $datenaiss_medecin='';
            $telephone_medecin='';
            $mail_medecin='';
            $adresse_medecin='';
            $telephonerefrence_medecin=''; 
            $fonction_medecin='';


            $serviceProvenance='';
            $dateImagerie='';

            $ana="D'ANALYSES";

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
            "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance','medecindemandeur',"CNOM","examenDemande",
            "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
            "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
            "plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
            'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
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
            ->where('refDetailConst', $id)
            ->get();
            $output='';
            foreach ($data as $row) 
            {

                $code_malade=$row->refMalade;
                $noms_malade=$row->noms;
                $sexe_malade=$row->sexe_malade;
                $datenaiss_malade=$row->dateNaissance_malade;
                $telephone_malade=$row->contact;
                $mail_malade=$row->mail;
                $adresse_malade=$row->nomCommune;
                $telephonerefrence_malade=$row->contactPersRef_malade;

                $code_medecin=$row->refMalade;
                $noms_medecin=$row->noms_medecin;
                $sexe_medecin=$row->sexe_medecin;
                $datenaiss_medecin=$row->datenaissance_medecin;
                $telephone_medecin=$row->contact_medecin;
                $mail_medecin=$row->mail_medecin;
                $adresse_medecin=$row->provinceOrigine_medecin;
                $fonction_medecin=$row->specialite_medecin; 
                
                $dateImagerie=$row->dateImagerie;
            
            }
            $nomEse='';
            $adresseEse='';
            $Tel1Ese='';
            $Tel2Ese='';
            $siteEse='';
            $emailEse='';
            $idNatEse='';
            $numImpotEse='';
            $rccEse='';
//
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
                $rccmEse=$row->rccm;
                $pic = $this->displayImg("fichier", $row->logo);
            
            }

    
            $output='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>BonExamen</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs7DC47A5E {color:#000000;background-color:#98FB98;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFBCBEF30 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; }
                    .cs58AC6944 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                    .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs9D95F7CD {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs572BC00D {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs8339304C {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
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
                    .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                    .cs6105B8F3 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs388CADE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                    .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:687px;height:530px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:109px;"></td>
                    <td style="height:0px;width:90px;"></td>
                    <td style="height:0px;width:12px;"></td>
                    <td style="height:0px;width:28px;"></td>
                    <td style="height:0px;width:95px;"></td>
                    <td style="height:0px;width:19px;"></td>
                    <td style="height:0px;width:10px;"></td>
                    <td style="height:0px;width:9px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:108px;"></td>
                    <td style="height:0px;width:143px;"></td>
                    <td style="height:0px;width:2px;"></td>
                    <td style="height:0px;width:25px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csD24A75E0" style="width:6px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csDDFA3242" style="width:109px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csDDFA3242" colspan="3" style="width:130px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csDDFA3242" style="width:95px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csDDFA3242" colspan="2" style="width:29px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csD24A75E0" rowspan="2" style="width:6px;height:14px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csDDFA3242" colspan="3" rowspan="2" style="width:269px;height:14px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs62ED362D" colspan="2" rowspan="2" style="width:24px;height:14px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="8" style="width:6px;height:115px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" rowspan="8" style="width:109px;height:115px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" rowspan="8" style="width:130px;height:115px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:130px;height:115px;">
                        <img alt="" src="'.$pic.'" style="width:130px;height:115px;" /></div>
                    </td>
                    <td class="cs101A94F7" rowspan="8" style="width:95px;height:115px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="2" rowspan="8" style="width:29px;height:115px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:23px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" style="width:267px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;du&nbsp;Patient&#160;:&nbsp;&nbsp;&nbsp;'.$noms_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:23px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:269px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&#160;:&nbsp;&nbsp;'.$sexe_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:269px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;de&nbsp;Naissance&#160;:&nbsp;&nbsp;'.$datenaiss_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:13px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:269px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:5px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="3" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" rowspan="3" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&nbsp;Domicile&#160;:&nbsp;'.$adresse_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" rowspan="3" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:9px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" style="width:109px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:130px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" style="width:95px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:8px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="3" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="5" rowspan="3" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$nomEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" rowspan="3" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:269px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:11px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" rowspan="2" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;de&nbsp;T&#233;l&#233;phone&#160;:&nbsp;&nbsp;'.$telephone_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" rowspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:19px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="5" rowspan="2" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>RCCM&nbsp;'.$rccEse.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:3px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" rowspan="2" style="width:269px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" rowspan="2" style="width:24px;height:13px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="5" rowspan="2" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$Tel1Ese.' - '.$Tel2Ese.'</nobr></td>
                    <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" rowspan="2" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&nbsp;Mail&#160;:&nbsp;'.$mail_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" rowspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="csBDA79072" rowspan="2" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="5" rowspan="2" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$emailEse.'xrLabel1</nobr></td>
                    <td class="cs101A94F7" colspan="2" rowspan="2" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:12px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:12px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs101A94F7" colspan="3" style="width:269px;height:12px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:12px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="5" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$adresseEse.'</td>
                    <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csBDA79072" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs6105B8F3" colspan="3" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;Dossier:&nbsp;&nbsp;'.$code_malade.'</nobr></td>
                    <td class="cs145AAE8A" colspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="cs593B729A" style="width:6px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csE7D235EF" style="width:109px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csE7D235EF" colspan="3" style="width:130px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csE7D235EF" style="width:95px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csE7D235EF" colspan="2" style="width:29px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs593B729A" style="width:6px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csE7D235EF" colspan="3" style="width:269px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs11B2FA6F" colspan="2" style="width:24px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                    <td style="width:0px;height:33px;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="cs7DC47A5E" colspan="8" style="width:295px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>BON&nbsp;DES ANALYSES</nobr></td>
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
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:11px;"></td>
                    <td></td>
                    <td class="cs9D95F7CD" style="width:6px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csA49D7241" colspan="6" style="width:353px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csA49D7241" style="width:10px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs9D95F7CD" style="width:6px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csA49D7241" colspan="4" style="width:271px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs755F1C83" style="width:22px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;">Noms&nbsp;du&nbsp;M&#233;decin&nbsp;Demandeur&#160;:&nbsp;&nbsp;&nbsp;DR.&nbsp;'.$noms_medecin.'</td>
                    <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="4" style="width:269px;height:22px;line-height:15px;text-align:left;vertical-align:top;">Service de Provenance :&nbsp;'.$serviceProvenance.'</td>
                    <td class="cs671B350" style="width:22px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Spécialité du Medecin :&nbsp;&nbsp;'.$fonction_medecin.'</nobr></td>
                    <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csFFC1C457" colspan="4" style="width:269px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;et&nbsp;Heure&nbsp;de&nbsp;Pr&#233;l&#232;vement&#160;:&nbsp;'.$dateImagerie.'</nobr></td>
                    <td class="cs671B350" style="width:22px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:6px;height:23px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="6" style="width:351px;height:23px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&#160;:&nbsp;'.$adresse_medecin.'</nobr></td>
                    <td class="cs388CADE" style="width:10px;height:23px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs572BC00D" rowspan="4" style="width:6px;height:74px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csC4190C00" colspan="4" rowspan="4" style="width:271px;height:74px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csAAE7D8C6" rowspan="4" style="width:22px;height:74px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;de&nbsp;T&#233;l&#233;phone&#160;:&nbsp;&nbsp;'.$telephone_medecin.'</nobr></td>
                    <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Adresse&nbsp;Mail&#160;:&nbsp;'.$mail_medecin.'</nobr></td>
                    <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:10px;"></td>
                    <td></td>
                    <td class="cs572BC00D" style="width:6px;height:7px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csC4190C00" colspan="6" style="width:353px;height:7px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    <td class="csC4190C00" style="width:10px;height:7px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                    <td style="width:0px;height:24px;"></td>
                    <td></td>
                    <td class="cs58AC6944" colspan="4" style="width:218px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">Analyse</td>
                    <td class="cs36E0C1B8" colspan="7" style="width:286px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">Cat&#233;gorie&nbsp;-&nbsp;Groupe</td>
                    <td class="cs36E0C1B8" colspan="3" style="width:169px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">But</td>
                </tr>
                ';

                    $output .= $this->showDetail($id); 

                    $output.='
            </table>
            </body>
            </html>';

    return $output;

}






function showDetail($id)
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
    "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent','serviceProvenance','medecindemandeur',"CNOM","examenDemande",
    "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire","nomAnalyse","tim_analyse.prix",
    "tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',"ReftypeAnalyse",
    "plainte","historique","antecedent","complementanamnese","examenphysique",
    "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
    "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
    'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
    "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
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
    ->Where('tim_imagerie.refDetailConst',$id) 
    ->get();

    $output='';

    foreach ($data as $row) 
    {
        $output .=' <tr style="vertical-align:top;">
        <td style="width:0px;height:24px;"></td>
        <td></td>
        <td class="csFBCBEF30" colspan="4" style="width:218px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nomAnalyse.'</td>
        <td class="csDC7EEB9" colspan="7" style="width:286px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->nomTypeAnalyse.'</td>
        <td class="csDC7EEB9" colspan="3" style="width:169px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->but.'</td>
    </tr>';

             
    }

    return $output;

}





















}
