<?php

namespace App\Http\Controllers\Attestation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_TransfertController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_transfert_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoTransfert($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoTransfert($id)
    {

        //id, refDetailCons,date_admission,heure_admission,diagnostic_tranfert,bilan_tranfert,
        //traitement_tranfert,motif_tranfert,date_transfert,heure_transfert,medecin,specialite,cnom,author
                $admin="'adminition";

                $codeOperation='';
                $noms='';     
                $sexe_malade='';
                $age_malade='';           
                $date_admission='';
                $heure_admission='';
                $diagnostic_tranfert='';
                $bilan_tranfert='';
                $traitement_tranfert='';
                $motif_tranfert='';
                $date_transfert='';
                $heure_transfert='';
                $hopital_transfert='';
                $medecin_transfert='';
                $specialite_transfert='';
                $cnom_transfert='';
                
                $data = DB::table('tcons_transfert')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tcons_transfert.refDetailCons')
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
                ->select("tcons_transfert.id",'refDetailCons','date_admission','hopital_transfert','heure_admission','diagnostic_tranfert',
                'bilan_tranfert','traitement_tranfert','motif_tranfert','date_transfert','heure_transfert','medecin_transfert',
                'specialite_transfert','cnom_transfert',"tcons_transfert.author", "tcons_transfert.created_at",
                 "tcons_transfert.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
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
                ->selectRaw('CONCAT("",tcons_transfert.id,"/DOCS/",YEAR(tcons_transfert.created_at)) as codeOperation')
                ->where('tcons_transfert.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                { 
                    $codeOperation=$row->codeOperation;
                    $noms=$row->noms;     
                    $sexe_malade=$row->sexe_malade;
                    $age_malade=$row->age_malade;           
                    $date_admission=$row->date_admission;
                    $heure_admission=$row->heure_admission;
                    $diagnostic_tranfert=$row->diagnostic_tranfert;
                    $bilan_tranfert=$row->bilan_tranfert;
                    $traitement_tranfert=$row->traitement_tranfert;
                    $motif_tranfert=$row->motif_tranfert;
                    $date_transfert=$row->date_transfert;
                    $heure_transfert=$row->heure_transfert;
                    $hopital_transfert=$row->hopital_transfert;
                    $medecin_transfert=$row->medecin_transfert;
                    $specialite_transfert=$row->specialite_transfert;
                    $cnom_transfert=$row->cnom_transfert;
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
                    <title>FicheTransfert</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs79DF234B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs4617EE35 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs981B4586 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:466px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:28px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:39px;"></td>
                        <td style="height:0px;width:211px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:91px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:95px;"></td>
                        <td style="height:0px;width:74px;"></td>
                        <td style="height:0px;width:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="11" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:41px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:28px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:25px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:39px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:225px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:91px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:95px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:74px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="10" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="2" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>'.$busnessName.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="10" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:21px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="10" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:39px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:225px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:91px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:33px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:33px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:33px;"></td>
                        <td class="cs981B4586" colspan="11" style="width:548px;height:27px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>NOTE&nbsp;DE&nbsp;TRANSFERT&nbsp;N&#176;&nbsp;'.$codeOperation.'</nobr></td>
                        <td class="cs101A94F7" style="width:74px;height:33px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:33px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:6px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:39px;height:6px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:225px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:91px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:6px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:6px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="14" style="width:678px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;Post-nom&nbsp;:&nbsp;...'.$noms.'..................</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="14" style="width:678px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;:&nbsp;'.$age_malade.'&nbsp;ans...&nbsp;&nbsp;Sexe&nbsp;:&nbsp;'.$sexe_malade.'&nbsp;.........&nbsp;Date&nbsp;d'.$admin.'&nbsp;:&nbsp;'.$date_admission.'&nbsp;.....&nbsp;Heure&nbsp;:&nbsp;'.$heure_admission.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="4" style="width:71px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Diagnostic&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="10" style="width:605px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$diagnostic_tranfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="5" style="width:99px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Bilans&nbsp;demand&#233;s&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="9" style="width:577px;height:17px;line-height:13px;text-align:left;vertical-align:top;">'.$bilan_tranfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="5" style="width:99px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Traitement&nbsp;re&#231;u&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="9" style="width:577px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$traitement_tranfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="7" style="width:138px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Structure&nbsp;de&nbsp;Provenance&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:538px;height:17px;line-height:13px;text-align:left;vertical-align:top;">'.$hopital_transfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="6" style="width:113px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Motif&nbsp;de&nbsp;traitement&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="8" style="width:563px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$motif_tranfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="3" style="width:59px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Specialit&#233;&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="11" style="width:617px;height:17px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite_transfert.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="14" style="width:678px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;de&nbsp;transfert&nbsp;:&nbsp;'.$date_transfert.'&nbsp;.....&nbsp;Heure&nbsp;:&nbsp;'.$heure_transfert.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:28px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:39px;height:25px;"></td>
                        <td class="cs4617EE35" colspan="2" style="width:217px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs101A94F7" style="width:91px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:25px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="8" style="width:171px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;Signature&nbsp;du&nbsp;Medecin&nbsp;:</nobr></td>
                        <td class="cs79DF234B" colspan="6" style="width:493px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>'.$medecin_transfert.'.........................................................................</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:41px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:28px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:25px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:39px;height:13px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:225px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:91px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:95px;height:13px;"></td>
                        <td class="csE7D235EF" style="width:74px;height:13px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:13px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }




    function pdf_retroinformation_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoRetroInformation($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoRetroInformation($id)
    {

        //id,refDetailCons,date_arrivee,heure_arrivee,diagnostic_retenu,traitement_retenu,modalite_sortie,
        //recommandations,date_retro,hopitals,author
                $admin="'arrivée";
                $hop="'Hopital";

                $codeOperation='';
                $noms='';     
                $sexe_malade='';
                $age_malade='';           
                $date_arrivee='';
                $heure_arrivee='';
                $diagnostic_retenu='';
                $traitement_retenu='';
                $modalite_sortie='';
                $recommandations='';
                $date_retro='';
                $hopitals='';
                
                $data = DB::table('tcons_retroinformation')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tcons_retroinformation.refDetailCons')
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
                ->select("tcons_retroinformation.id",'refDetailCons','date_arrivee','heure_arrivee','diagnostic_retenu',
                'traitement_retenu','modalite_sortie','recommandations','date_retro','hopitals',"tcons_retroinformation.author", "tcons_retroinformation.created_at",
                 "tcons_retroinformation.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
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
                ->selectRaw('CONCAT("",tcons_retroinformation.id,"/DOCS/",YEAR(tcons_retroinformation.created_at)) as codeOperation')
                ->where('tcons_retroinformation.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                { 
                    $codeOperation=$row->codeOperation;
                    $noms=$row->noms;     
                    $sexe_malade=$row->sexe_malade;
                    $age_malade=$row->age_malade;           
                    $date_arrivee=$row->date_arrivee;
                    $heure_arrivee=$row->heure_arrivee;
                    $diagnostic_retenu=$row->diagnostic_retenu;
                    $traitement_retenu=$row->traitement_retenu;
                    $modalite_sortie=$row->modalite_sortie;
                    $recommandations=$row->recommandations;
                    $date_retro=$row->date_retro;
                    $hopitals=$row->hopitals;
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
                    <title>FicheRetroInformation</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBD92D79 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs981B4586 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:22px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:452px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:67px;"></td>
                        <td style="height:0px;width:209px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:95px;"></td>
                        <td style="height:0px;width:74px;"></td>
                        <td style="height:0px;width:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td class="cs739196BC" colspan="8" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
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
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:41px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:55px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:67px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:280px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:34px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:95px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:74px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="7" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;"><nobr>'.$nomEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="2" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="7" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="7" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:21px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="7" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:280px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:33px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:33px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:33px;"></td>
                        <td class="cs981B4586" colspan="8" style="width:548px;height:27px;line-height:25px;text-align:center;vertical-align:middle;"><nobr>RETRO-INFORMATION</nobr></td>
                        <td class="cs101A94F7" style="width:74px;height:33px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:33px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:280px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="11" style="width:678px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;et&nbsp;Post-nom&nbsp;:&nbsp;...'.$noms.'..................</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="11" style="width:678px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;:&nbsp;'.$age_malade.'&nbsp;ans...&nbsp;&nbsp;Sexe&nbsp;:&nbsp;'.$sexe_malade.'&nbsp;.........&nbsp;Date&nbsp;d'.$admin.'&#233;e&nbsp;:&nbsp;'.$date_arrivee.'&nbsp;.....&nbsp;Heure&nbsp;:&nbsp;'.$heure_arrivee.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="3" style="width:101px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Diagnostic&nbsp;retenu&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="8" style="width:575px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$diagnostic_retenu.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="3" style="width:101px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Traitement&nbsp;re&#231;u&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="8" style="width:575px;height:17px;line-height:13px;text-align:left;vertical-align:top;">'.$traitement_retenu.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="4" style="width:112px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Modalit&#233;s&nbsp;de&nbsp;sortie&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="7" style="width:564px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$modalite_sortie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs612ED82F" colspan="5" style="width:179px;height:17px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Recommandation&nbsp;et&nbsp;suggestions&nbsp;:</nobr></td>
                        <td class="csFFC1C457" colspan="6" style="width:497px;height:17px;line-height:13px;text-align:left;vertical-align:top;">'.$recommandations.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs612ED82F" colspan="11" style="width:678px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;de&nbsp;retro-information&nbsp;:&nbsp;'.$date_retro.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:280px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:95px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:74px;height:12px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:41px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:280px;height:22px;"></td>
                        <td class="csBD92D79" colspan="4" style="width:209px;height:16px;line-height:13px;text-align:right;vertical-align:top;"><nobr>Sceau&nbsp;et&nbsp;Signature&nbsp;de&nbsp;l'.$hop.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:47px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:41px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:55px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:67px;height:44px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:280px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:34px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:95px;height:44px;"></td>
                        <td class="csE7D235EF" style="width:74px;height:44px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:44px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }

    


    
    

    
}
