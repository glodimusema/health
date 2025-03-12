<?php

namespace App\Http\Controllers\Attestation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_OrdonancesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;


    function pdf_billesortiehospitalisation_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBilletsortie($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBilletsortie($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $dateEntree='';
                $dateSortie='';
                $NombreJour=0;
                $medecin1='';
                $specialite1='';
                $cnom1='';
                $medecin2='';
                $specialite2='';
                $cnom2='';
                $medecin3='';
                $specialite3='';
                $cnom3='';
                $dateRDV='';
                $heureSortieHosp='';
                $codeDossier='';
                $dateNaissance_malade='';
                $sexe_malade='';
                $numroBon='';
                $nom_uniteproduction='';
                $nom_salle='';

              
                $codeOperation='';
                
                $data = DB::table('tsortiehospitaliser')
                ->join('thospitalisation','thospitalisation.id','=','tsortiehospitaliser.refHospitaliser')
                ->join('tfin_uniteproduction','tfin_uniteproduction.id','=','thospitalisation.refServiceHospi')
                ->join('tfin_departement','tfin_departement.id','=','tfin_uniteproduction.refDepartement')
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
                //MALADE
                ->select("tsortiehospitaliser.id",'refHospitaliser',"medecin1","specialite1","cnom1","medecin2",
                "specialite2","cnom2","medecin3","specialite3","cnom3","dateRDV","heureSortieHosp",
                'dateSortie','diagnosticSortie','autreDetails',
                'dateEntree','diagnosticEntree','refDepartement','nom_uniteproduction','code_uniteproduction',
                'nom_departement','code_departement','thospitalisation.observations','dateHospi',
                'refDetailCons',"refLit",'nom_lit','refSalle',"nom_salle","PrixSalle","refEnteteCons","refTypeCons","plainte",
                "historique","antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
                "tsortiehospitaliser.author","tsortiehospitaliser.created_at","tsortiehospitaliser.updated_at",
                "ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
                ->selectRaw('((TIMESTAMPDIFF(DAY, dateEntree, dateSortie))*PrixSalle) as montantSalle')
                ->selectRaw('(TIMESTAMPDIFF(DAY, dateEntree, dateSortie)) as NombreJour')
                ->selectRaw('CONCAT("SH",YEAR(tsortiehospitaliser.created_at),"",MONTH(tsortiehospitaliser.created_at),"00",tsortiehospitaliser.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tsortiehospitaliser.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;
                    $diagnosticEntree=$row->diagnosticEntree;
                    $dateEntree=$row->dateEntree;
                    $dateSortie=$row->dateSortie;
                    $NombreJour=$row->NombreJour;
                    $medecin1=$row->medecin1;
                    $specialite1=$row->specialite1;
                    $cnom1=$row->cnom1;
                    $medecin2=$row->medecin2;
                    $specialite2=$row->specialite2;
                    $cnom2=$row->cnom2;
                    $medecin3=$row->medecin3;
                    $specialite3=$row->specialite3;
                    $cnom3=$row->cnom3;
                    $dateRDV=$row->dateRDV;
                    $heureSortieHosp=$row->heureSortieHosp;
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;
                    $sexe_malade=$row->sexe_malade;
                    $numroBon=$row->numroBon;
                    $nom_uniteproduction=$row->nom_uniteproduction;
                    $nom_salle=$row->nom_salle;             
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
                    <title>BILLET DE SORTIE HOSPI</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs79DF234B {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs4B114620 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs4617EE35 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
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
                        .cs3D084EF5 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs150491EC {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:911px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:88px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:59px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:153px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:105px;"></td>
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
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="8" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="8" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="8" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td class="csE7D235EF" colspan="8" style="width:488px;height:6px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs150491EC" colspan="13" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>BILLET&nbsp;DE&nbsp;SORTIE&nbsp;POUR&nbsp;HOSPITALISATION</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:21px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:95px;height:21px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:21px;"></td>
                        <td class="csDDFA3242" style="width:59px;height:21px;"></td>
                        <td class="csDDFA3242" style="width:49px;height:21px;"></td>
                        <td class="csDDFA3242" style="width:153px;height:21px;"></td>
                        <td class="csDDFA3242" style="width:19px;height:21px;"></td>
                        <td class="csDDFA3242" colspan="4" style="width:292px;height:21px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:153px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:153px;"></td>
                        <td class="cs12FE94AA" colspan="11" style="width:678px;height:153px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Je&nbsp;sousign&#233;&nbsp;,&nbsp;&nbsp;&nbsp;&nbsp;'.$medecin1.'&nbsp;&nbsp;&nbsp;&nbsp;atteste&nbsp;par&nbsp;la&nbsp;pr&#233;sente&nbsp;avoir&nbsp;suivi&nbsp;en</nobr><br/><br/><nobr>Hospitalisation&nbsp;Mr,&nbsp;Mme,&nbsp;Mlle&nbsp;'.$noms.'</nobr><br/><br/><nobr>Pour&nbsp;&nbsp;'.$diagnosticEntree.'&nbsp;&nbsp;&nbsp;Du&nbsp;'.$dateEntree.'&nbsp;Au&nbsp;'.$dateSortie.'&nbsp;&nbsp;&nbsp;&nbsp;soit&nbsp;&nbsp;&nbsp;'.$NombreJour.'&nbsp;&nbsp;jours&nbsp;ou&nbsp;mois.</nobr><br/><br/><nobr>Son&nbsp;&#233;tat&nbsp;de&nbsp;sant&#233;&nbsp;'.$sigs.'&nbsp;am&#233;lior&#233;.</nobr><br/><br/><nobr>Rendez-vous&nbsp;pour&nbsp;un&nbsp;suivi&nbsp;est&nbsp;pris&nbsp;le&nbsp;'.$dateRDV.'&nbsp;&nbsp;&nbsp;&nbsp;par&nbsp;'.$medecin2.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:153px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:12px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:12px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:12px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:12px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="4" style="width:165px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Cooedonn&#233;es&nbsp;du&nbsp;Patient</nobr></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs4617EE35" colspan="11" style="width:672px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$noms.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:14px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs4617EE35" colspan="11" style="width:672px;height:18px;line-height:16px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;Dossier&nbsp;:&nbsp;'.$codeDossier.'&nbsp;&nbsp;&nbsp;Date&nbsp;de&nbsp;naissance&nbsp;:&nbsp;&nbsp;'.$dateNaissance_malade.'&nbsp;&nbsp;&nbsp;&nbsp;Sexe&nbsp;:&nbsp;'.$sexe_malade.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:17px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:17px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="3" style="width:106px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie</nobr></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs4617EE35" colspan="7" style="width:380px;height:18px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie&nbsp;:&nbsp;&nbsp;'.$categoriemaladiemvt.'</nobr></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs4617EE35" colspan="7" style="width:380px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Organisation&nbsp;:&nbsp;&nbsp;'.$organisationAbonne.'</nobr></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:25px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:583px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;R&#233;f&#233;rence&nbsp;:&nbsp;&nbsp;$numroBon</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:10px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs3D084EF5" colspan="3" style="width:106px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;la&nbsp;sortie</nobr></td>
                        <td class="cs101A94F7" style="width:59px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:9px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs4617EE35" colspan="11" style="width:672px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;de&nbsp;sortie&nbsp;&nbsp;:&nbsp;'.$dateSortie.'&nbsp;&nbsp;&nbsp;&nbsp;Heure&nbsp;de&nbsp;sortie&nbsp;:&nbsp;'.$heureSortieHosp.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs4617EE35" colspan="11" style="width:672px;height:18px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Service&nbsp;&nbsp;:&nbsp;'.$nom_uniteproduction.'&nbsp;&nbsp;&nbsp;&nbsp;Chambre&nbsp;:&nbsp;'.$nom_salle.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:20px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:20px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:20px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:20px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Medecin&nbsp;Traitant</nobr></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs4B114620" colspan="5" rowspan="2" style="width:303px;height:19px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Pour&nbsp;le&nbsp;service&nbsp;de&nbsp;facturation&nbsp;et&nbsp;Recouvrement</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:3px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:3px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:3px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:3px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:15px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:15px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin1.'</td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs4B114620" colspan="5" rowspan="2" style="width:303px;height:18px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;,&nbsp;date&nbsp;et&nbsp;Signature</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:2px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:2px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite1.'</td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs990B052E" colspan="5" rowspan="2" style="width:301px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:2px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:59px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:2px;"></td>
                        <td class="cs101A94F7" style="width:153px;height:2px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom1.'</nobr></td>
                        <td class="cs101A94F7" style="width:153px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:292px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:95px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:59px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:49px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:153px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:19px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="4" style="width:292px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }


    //=========================================================================================================================
    //====================== BILLE ORIENTATION ================================================================================



    function pdf_billetorientation_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoBilletOrientation($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoBilletOrientation($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $medecin1='';
                $codeDossier='';
                $dateNaissance_malade='';
                $sexe_malade='';
                $numroBon='';
                $detailorientation='';

              
                $codeOperation='';
                
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
                ->select("tfin_orientationcons.id",'refDetailCons','detailorientation',"tfin_orientationcons.author",
                 "tfin_orientationcons.created_at",
                 "tfin_orientationcons.updated_at","refEnteteCons","refTypeCons","plainte","historique",
                 "antecedent","complementanamnese",
                 "examenphysique","diagnostiquePres","dateDetailCons","ttypeconsultation.designation as TypeConsultation",
                 'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin","noms_medecin",
                 "sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("SH",YEAR(tfin_orientationcons.created_at),"",MONTH(tfin_orientationcons.created_at),"00",tfin_orientationcons.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tfin_orientationcons.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;
                    $medecin1=$row->author;
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;
                    $sexe_malade=$row->sexe_malade;
                    $numroBon=$row->numroBon;
                    $detailorientation=$row->detailorientation;           
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
                    <title>BILLET ORIENTATIONS</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBD92D79 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:820px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:35px;"></td>
                        <td style="height:0px;width:214px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:47px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:105px;"></td>
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
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="9" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="9" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="9" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="3" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="9" style="width:488px;height:6px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="15" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>AUTRES&nbsp;ORIENTATIONS&nbsp;POUR&nbsp;PATIENT</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:5px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:19px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:49px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:20px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:35px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:214px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:47px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:19px;"></td>
                        <td class="csDDFA3242" colspan="4" style="width:300px;height:19px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:35px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:214px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:48px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:48px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe_malade.'</nobr></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="5" style="width:103px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;Naissance&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:274px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateNaissance_malade.'</td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="5" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="5" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:35px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:214px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;DECRIPTION</nobr></td>
                        <td class="cs101A94F7" style="width:47px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:225px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:225px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:225px;"></td>
                        <td class="cs12FE94AA" colspan="12" style="width:678px;height:225px;line-height:16px;text-align:left;vertical-align:top;">'.$detailorientation.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:225px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:58px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:58px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:35px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:214px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:58px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:58px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:300px;height:58px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:58px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:35px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:214px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:25px;"></td>
                        <td class="cs990B052E" colspan="5" style="width:304px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:35px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:214px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:47px;height:22px;"></td>
                        <td class="csBD92D79" colspan="5" style="width:304px;height:16px;line-height:13px;text-align:right;vertical-align:top;">'.$medecin1.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:5px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:23px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:49px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:20px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:35px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:214px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:47px;height:23px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:23px;"></td>
                        <td class="csE7D235EF" colspan="4" style="width:300px;height:23px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:23px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }



    //=========================================================================================================================
    //====================== ORDONANCE MEDICALE ================================================================================



    function pdf_ordonancemedicale_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoOrdonanceMedicale($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoOrdonanceMedicale($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";


                $noms='';
                $categoriemaladiemvt='';
                $organisationAbonne='';
                $diagnosticEntree='';
                $medecin1='';
                $codeDossier='';
                $dateNaissance_malade='';
                $sexe_malade='';
                $numroBon='';
                $age_malade=0;
                $Poids=0;              
                $codeOperation='';
                
                $data = DB::table('tcons_entete_ordonance')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tcons_entete_ordonance.refDetailCons')
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
                ->select("tcons_entete_ordonance.id",'refDetailCons','date_ordonance',"tcons_entete_ordonance.author", "tcons_entete_ordonance.created_at",
                 "tcons_entete_ordonance.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
                 "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
                 "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->selectRaw('CONCAT("OM",YEAR(tcons_entete_ordonance.created_at),"",MONTH(tcons_entete_ordonance.created_at),"00",tcons_entete_ordonance.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tcons_entete_ordonance.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $noms=$row->noms;
                    $categoriemaladiemvt=$row->categoriemaladiemvt;
                    $organisationAbonne=$row->organisationAbonne;
                    $medecin1=$row->author;
                    $codeDossier=$row->codeDossier;
                    $dateNaissance_malade=$row->dateNaissance_malade;
                    $sexe_malade=$row->sexe_malade;
                    $numroBon=$row->numroBon;
                    $age_malade=$row->age_malade;
                    $Poids=$row->Poids;  
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
                        <td class="cs7D52592D" colspan="11" style="width:385px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>ORDONNANCE&nbsp;MEDICALE</nobr></td>
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
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe_malade.'</nobr></td>
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
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$age_malade.'&nbsp;ans</nobr></td>
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
                        <td class="cs12FE94AA" style="width:44px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Poids&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="4" style="width:244px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$Poids.'&nbsp;Kg</nobr></td>
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
                        $output .= $this->showDetailOrdonance($id);                        
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

    function showDetailOrdonance($id)
    {
            $data = DB::table('tcons_detail_ordonance')
            ->join('tcons_entete_ordonance','tcons_entete_ordonance.id','=','tcons_detail_ordonance.refEnteteOrdonance')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tcons_entete_ordonance.refDetailCons')
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
            ->select("tcons_detail_ordonance.id","refEnteteOrdonance","medicaments","posologie","autresdetails",
            'refDetailCons','date_ordonance',"tcons_detail_ordonance.author",
             "tcons_detail_ordonance.created_at","tcons_detail_ordonance.updated_at","refEnteteCons","refTypeCons",
             "plainte","historique","antecedent","complementanamnese","examenphysique","diagnostiquePres",
             "dateDetailCons","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
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
            ->where('tcons_detail_ordonance.refEnteteOrdonance','=', $id)
            ->orderBy("tcons_detail_ordonance.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:24px;"></td>
                <td class="csFBCBEF30" colspan="2" style="width:94px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->date_ordonance.'</td>
                <td class="csDC7EEB9" colspan="2" style="width:93px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->posologie.'</td>
                <td class="csDC7EEB9" colspan="7" style="width:260px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->medicaments.'</td>
                <td class="csDC7EEB9" colspan="5" style="width:221px;height:22px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->noms_medecin.' ('.$row->matricule_medecin.')</td>
                <td class="cs671B350" style="width:6px;height:24px;"></td>
            </tr>            
                ';                 
    
            }

        return $output;

    }





        //=========================================================================================================================
    //====================== TEST CUTANE ================================================================================



    function pdf_testcutane_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoTestCutane($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoTestCutane($id)
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
                $age_malade=0;
                $Poids=0;              
                $codeOperation='';
                $clinique='';
                $examinateur='';
                $specialite='';
                $cNom='';
                $dateTest='';
                $medecinDemandeur='';
                $conclusionTest='';
                
                $data = DB::table('tenfant_entete_test_cutane')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tenfant_entete_test_cutane.refDetailCons')
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
                ->select("tenfant_entete_test_cutane.id","dateTest","medecinDemandeur","conclusionTest",
                "clinique","examinateur","specialite","cNom","tenfant_entete_test_cutane.author","refDetailCons",
                //--------------------------------                
                "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade') 
                ->selectRaw('CONCAT("OM",YEAR(tenfant_entete_test_cutane.created_at),"",MONTH(tenfant_entete_test_cutane.created_at),"00",tenfant_entete_test_cutane.id) as codeOperation')
                ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
                ->where('tenfant_entete_test_cutane.id', $id)
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
                    $Poids=$row->Poids;  
                    $codeOperation=$row->codeOperation;

                    $dateTest=$row->dateTest;
                    $medecinDemandeur=$row->medecinDemandeur;
                    $conclusionTest=$row->conclusionTest;
                    $clinique=$row->clinique;
                    $examinateur=$row->examinateur;
                    $specialite=$row->specialite;
                    $cNom=$row->cNom;          
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
                    <title>TEST CUTANE</title>
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
                        .cs4D1EA70F {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top-style: none;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:700px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:76px;"></td>
                        <td style="height:0px;width:36px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:129px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:73px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:29px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:7px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="13" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="13" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="13" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="13" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="13" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="13" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="13" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="13" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:13px;height:14px;"></td>
                        <td class="csE7D235EF" colspan="13" style="width:488px;height:14px;"></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="17" style="width:694px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>TEST&nbsp;CUTANE&nbsp;ALLERGOLOGIQUE(PRICK-TEST)</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="cs9D95F7CD" style="width:13px;height:11px;"></td>
                        <td class="csA49D7241" style="width:76px;height:11px;"></td>
                        <td class="csA49D7241" style="width:36px;height:11px;"></td>
                        <td class="csA49D7241" colspan="2" style="width:30px;height:11px;"></td>
                        <td class="csA49D7241" colspan="5" style="width:254px;height:11px;"></td>
                        <td class="csA49D7241" style="width:29px;height:11px;"></td>
                        <td class="csA49D7241" colspan="4" style="width:79px;height:11px;"></td>
                        <td class="csA49D7241" style="width:169px;height:11px;"></td>
                        <td class="cs755F1C83" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:110px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;du&nbsp;Patient&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="7" style="width:282px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$noms.'</td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="csCE72709D" colspan="4" style="width:77px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Cat&#233;gorie&#160;:</nobr></td>
                        <td class="cs12FE94AA" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categoriemaladiemvt.'</td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" style="width:74px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="8" style="width:318px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe_malade.'</td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="csCE72709D" colspan="4" style="width:77px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&#160;:</nobr></td>
                        <td class="cs12FE94AA" style="width:167px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$organisationAbonne.'</td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" style="width:74px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="8" style="width:318px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$age_malade.'&nbsp;ans</nobr></td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:79px;height:22px;"></td>
                        <td class="cs388CADE" style="width:169px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" style="width:74px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Clinique&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="8" style="width:318px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$clinique.'</td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:79px;height:22px;"></td>
                        <td class="cs388CADE" style="width:169px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" style="width:74px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="8" style="width:318px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateTest.'</td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:79px;height:22px;"></td>
                        <td class="cs388CADE" style="width:169px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="4" style="width:140px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Medecin&nbsp;demandeur&nbsp;:</nobr></td>
                        <td class="cs12FE94AA" colspan="5" style="width:252px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$medecinDemandeur.'</td>
                        <td class="cs388CADE" style="width:29px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:79px;height:22px;"></td>
                        <td class="cs388CADE" style="width:169px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:10px;"></td>
                        <td class="csC4190C00" style="width:76px;height:10px;"></td>
                        <td class="csC4190C00" style="width:36px;height:10px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:30px;height:10px;"></td>
                        <td class="csC4190C00" colspan="5" style="width:254px;height:10px;"></td>
                        <td class="csC4190C00" style="width:29px;height:10px;"></td>
                        <td class="csC4190C00" colspan="4" style="width:79px;height:10px;"></td>
                        <td class="csC4190C00" style="width:169px;height:10px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:10px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:126px;height:10px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:145px;height:10px;"></td>
                        <td class="cs388CADE" style="width:8px;height:10px;"></td>
                        <td class="cs388CADE" style="width:73px;height:10px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:10px;"></td>
                        <td class="cs388CADE" style="width:49px;height:10px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:10px;"></td>
                        <td class="cs671B350" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:36px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:36px;"></td>
                        <td class="cs58AC6944" colspan="6" style="width:277px;height:34px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PNEUMALLERENES</nobr></td>
                        <td class="cs36E0C1B8" style="width:72px;height:34px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Taille&nbsp;de&nbsp;la</nobr><br/><nobr>papule</nobr></td>
                        <td class="cs36E0C1B8" colspan="5" style="width:128px;height:34px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Lecture</nobr></td>
                        <td class="cs36E0C1B8" colspan="3" style="width:191px;height:34px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Evaluation</nobr></td>
                        <td class="cs671B350" style="width:6px;height:36px;"></td>
                    </tr>
                    ';                        
                        $output .= $this->showTestCutane($id);                        
                     $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:11px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:126px;height:11px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:145px;height:11px;"></td>
                        <td class="cs388CADE" style="width:8px;height:11px;"></td>
                        <td class="cs388CADE" style="width:73px;height:11px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:11px;"></td>
                        <td class="cs388CADE" style="width:49px;height:11px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:11px;"></td>
                        <td class="cs671B350" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="3" style="width:124px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CONCLUSION</nobr></td>
                        <td class="cs388CADE" colspan="2" style="width:145px;height:22px;"></td>
                        <td class="cs388CADE" style="width:8px;height:22px;"></td>
                        <td class="cs388CADE" style="width:73px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" style="width:49px;height:22px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:51px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:51px;"></td>
                        <td class="cs12FE94AA" colspan="15" style="width:671px;height:51px;line-height:15px;text-align:left;vertical-align:top;">'.$conclusionTest.'</td>
                        <td class="cs671B350" style="width:6px;height:51px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:16px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:126px;height:16px;"></td>
                        <td class="cs388CADE" colspan="2" style="width:145px;height:16px;"></td>
                        <td class="cs388CADE" style="width:8px;height:16px;"></td>
                        <td class="cs388CADE" style="width:73px;height:16px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:16px;"></td>
                        <td class="cs388CADE" style="width:49px;height:16px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:16px;"></td>
                        <td class="cs671B350" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs4D1EA70F" colspan="5" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:top;">'.$examinateur.'</td>
                        <td class="cs388CADE" style="width:8px;height:22px;"></td>
                        <td class="cs388CADE" style="width:73px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:22px;"></td>
                        <td class="cs76421F2" colspan="4" style="width:237px;height:22px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs4D1EA70F" colspan="5" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite.'</td>
                        <td class="cs388CADE" style="width:8px;height:22px;"></td>
                        <td class="cs388CADE" style="width:73px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" style="width:49px;height:22px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:13px;height:22px;"></td>
                        <td class="cs4D1EA70F" colspan="5" style="width:263px;height:19px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cNom.'</nobr></td>
                        <td class="cs388CADE" style="width:8px;height:22px;"></td>
                        <td class="cs388CADE" style="width:73px;height:22px;"></td>
                        <td class="cs388CADE" colspan="4" style="width:80px;height:22px;"></td>
                        <td class="cs388CADE" style="width:49px;height:22px;"></td>
                        <td class="cs388CADE" colspan="3" style="width:192px;height:22px;"></td>
                        <td class="cs671B350" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:12px;"></td>
                        <td></td>
                        <td class="cs572BC00D" style="width:13px;height:9px;"></td>
                        <td class="csC4190C00" colspan="3" style="width:126px;height:9px;"></td>
                        <td class="csC4190C00" colspan="2" style="width:145px;height:9px;"></td>
                        <td class="csC4190C00" style="width:8px;height:9px;"></td>
                        <td class="csC4190C00" style="width:73px;height:9px;"></td>
                        <td class="csC4190C00" colspan="4" style="width:80px;height:9px;"></td>
                        <td class="csC4190C00" style="width:49px;height:9px;"></td>
                        <td class="csC4190C00" colspan="3" style="width:192px;height:9px;"></td>
                        <td class="csAAE7D8C6" style="width:6px;height:9px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                ';
        return $output;

    }

    function showTestCutane($id)
    {
            $data = DB::table('tenfant_detail_test_cutane')
            ->join('tenfant_entete_test_cutane','tenfant_entete_test_cutane.id','=','tenfant_detail_test_cutane.refEnteteTest')
            ->join('tenfant_type_test','tenfant_type_test.id','=','tenfant_detail_test_cutane.refTypeTest')
            ->join('tdetailconsultation','tdetailconsultation.id','=','tenfant_entete_test_cutane.refDetailCons')
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

            ->select("tenfant_detail_test_cutane.id","tenfant_detail_test_cutane.taille","lecture","evaluation",
            "Designation_typeTest","refTypeTest", "refEnteteTest","tenfant_detail_test_cutane.author",
            "dateTest","medecinDemandeur","conclusionTest",
            "clinique","examinateur","specialite","cNom","refDetailCons",
            //--------------------------------                
            "refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese","examenphysique",
            "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
            "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
            "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
            "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
            "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
            "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
            "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","tdetailtriage.Taille","TA","Temperature","FC","FR","Oxygene",
            "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
            'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
            "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
            "ttypemouvement_malade.designation as Typemouvement","noms","contact",
            "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
            "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
            "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
            "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
            "contactPersRef_malade","organisation_malade","numeroCarte_malade",
            "dateExpiration_malade")
            ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
            ->where('tenfant_detail_test_cutane.refEnteteTest','=', $id)
            ->orderBy("tenfant_detail_test_cutane.created_at", "asc")
            ->get();
            $output='';

            foreach ($data as $row) 
            {
                $output .='
                <tr style="vertical-align:top;">
                <td style="width:0px;height:45px;"></td>
                <td></td>
                <td class="cs8339304C" style="width:13px;height:45px;"></td>
                <td class="csFBCBEF30" colspan="6" style="width:277px;height:43px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->Designation_typeTest.'</td>
                <td class="csDC7EEB9" style="width:72px;height:43px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->taille.'</td>
                <td class="csDC7EEB9" colspan="5" style="width:128px;height:43px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->lecture.'</td>
                <td class="csDC7EEB9" colspan="3" style="width:191px;height:43px;line-height:13px;text-align:center;vertical-align:middle;">'.$row->evaluation.'</td>
                <td class="cs671B350" style="width:6px;height:45px;"></td>
            </tr>
                ';          
    
            }

        return $output;

    }



//============================================================================================================================================
//============================ RAPPORT TRIAGE SELON LE CAS ===================================================================================


public function pdf_rapport_triage_date(Request $request)
{
    //

    if ($request->get('date1') && $request->get('date2') && $request->get('cas_triage'))  {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        $cas_triage = $request->get('cas_triage');

        $html ='<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>';
        $html .= $this->printDataListTriage($date1, $date2, $cas_triage);       
        $html .='<script>window.print()</script>';
        echo($html); 
    }
    else {
        // code...
    }
    
}



function printDataListTriage($date1, $date2, $cas_triage)
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
                $typeCas='';

                $data3=DB::table('tdetailtriage')
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
                ->where([
                    ['dateTriage','>=', $date1],
                    ['dateTriage','<=', $date2],
                    ['tdetailtriage.cas_triage','=', $cas_triage]
                ])      
                ->get();      
                $output='';
                foreach ($data3 as $row) 
                {
                    $typeCas=$row->cas_triage;                 
                }

//

    //

        $output='

        <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <!-- saved from url=(0016)http://localhost -->
        <html>
        <head>
            <title>RAPPORT TRIAGE</title>
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
        <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:912px;height:377px;position:relative;">
            <tr>
                <td style="width:0px;height:0px;"></td>
                <td style="height:0px;width:10px;"></td>
                <td style="height:0px;width:86px;"></td>
                <td style="height:0px;width:123px;"></td>
                <td style="height:0px;width:93px;"></td>
                <td style="height:0px;width:31px;"></td>
                <td style="height:0px;width:20px;"></td>
                <td style="height:0px;width:46px;"></td>
                <td style="height:0px;width:4px;"></td>
                <td style="height:0px;width:182px;"></td>
                <td style="height:0px;width:101px;"></td>
                <td style="height:0px;width:34px;"></td>
                <td style="height:0px;width:11px;"></td>
                <td style="height:0px;width:53px;"></td>
                <td style="height:0px;width:115px;"></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:1px;"></td>
                <td></td>
                <td class="csFBB219FE" colspan="10" rowspan="2" style="width:718px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td></td>
                <td class="cs101A94F7" colspan="2" rowspan="7" style="width:168px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:168px;height:144px;">
                    <img alt="" src="'.$pic2.'" style="width:168px;height:144px;" /></div>
                </td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="10" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csCE72709D" colspan="10" style="width:718px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="10" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="10" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;infoc'.$emailEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="csFFC1C457" colspan="10" style="width:718px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                <td></td>
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:12px;"></td>
                <td></td>
                <td class="cs612ED82F" colspan="10" rowspan="2" style="width:718px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                <td style="width:0px;height:32px;"></td>
                <td></td>
                <td class="csB6F858D0" colspan="13" style="width:895px;height:32px;line-height:28px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;DES&nbsp;MOUVEMENTS&nbsp;DES&nbsp;PATIENTS&nbsp;AU&nbsp;TRIAGE</nobr></td>
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs56F73198" colspan="4" style="width:329px;height:20px;line-height:18px;text-align:left;vertical-align:top;"><nobr>&nbsp;PERIODE&nbsp;:&nbsp;&nbsp;Du&nbsp;&nbsp;'.$datedebut.'&nbsp;&nbsp;au&nbsp;'.$datefin.'</nobr></td>
                <td class="cs56F73198" colspan="9" style="width:562px;height:20px;line-height:18px;text-align:left;vertical-align:top;">'.$typeCas.'</td>
                <td></td>
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
                <td></td>
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:24px;"></td>
                <td></td>
                <td class="cs9FE9304F" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:215px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PATIENT</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>SEXE</nobr></td>
                <td class="cs9FE9304F" colspan="2" style="width:49px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Age</nobr></td>
                <td class="cs9FE9304F" style="width:181px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>CATEGORIE&nbsp;&nbsp;-&nbsp;ORG.</nobr></td>
                <td class="cs9FE9304F" style="width:100px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TYPE&nbsp;EPISODE</nobr></td>
                <td class="cs9FE9304F" colspan="3" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>N&#176;&nbsp;DOSSIER</nobr></td>
                <td class="csEAC52FCD" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>DATE - AUTHOR</nobr></td>
            </tr>
            ';
                            
                  $output .= $this->showDetailTriage($date1, $date2,$cas_triage);
                            
                   $output.='
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
            </tr>
            <tr style="vertical-align:top;">
                <td style="width:0px;height:22px;"></td>
                <td></td>
                <td class="cs12FE94AA" colspan="2" style="width:207px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
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

function showDetailTriage($date1, $date2,$cas_triage)
{
    $refMvt=2;
    $data=DB::table('tdetailtriage')
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
    "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
    'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
    "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
    "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
    "dateExpiration_malade")
    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
    ->selectRaw('CONCAT("PA",YEAR(tclient.created_at),"",MONTH(tclient.created_at),"00",tclient.id) as codeDossier')
    ->where([
        ['dateTriage','>=', $date1],
        ['dateTriage','<=', $date2],
        ['tdetailtriage.cas_triage','=', $cas_triage]
    ])    
    ->orderBy("tdetailtriage.id", "asc")
    ->get();

    $count = 0;

    $output='';

    foreach ($data as $row) 
    {
        $count ++;
        $output .='
        <tr style="vertical-align:top;">
		<td style="width:0px;height:24px;"></td>
		<td></td>
		<td class="cs6E02D7D2" style="width:85px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$count.'</td>
		<td class="cs6E02D7D2" colspan="2" style="width:215px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->noms.'</td>
		<td class="cs6E02D7D2" colspan="2" style="width:50px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->sexe_malade.'</td>
		<td class="cs6E02D7D2" colspan="2" style="width:49px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>'.$row->age_malade.'&nbsp;ans</nobr></td>
		<td class="cs6E02D7D2" style="width:181px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->categoriemaladiemvt.' - '.$row->organisationAbonne.'</td>
		<td class="cs6E02D7D2" style="width:100px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->cas_triage.'</td>
		<td class="cs6E02D7D2" colspan="3" style="width:97px;height:22px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->codeDossier.'</td>
		<td class="cs6C28398D" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$row->dateTriage.' - '.$row->author.'</td>
	</tr>
        ';

    }

    return $output;

}







}
