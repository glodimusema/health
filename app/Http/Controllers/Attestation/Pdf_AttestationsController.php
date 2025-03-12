<?php

namespace App\Http\Controllers\Attestation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\{GlobalMethod,Slug};
use DB;

class Pdf_AttestationsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_aptitudephysique_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoAptitude($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoAptitude($id)
    {

                $titres="CERTIFICAT D'APTITUDE PHYSIQUE";

                $thoracique='';
                $medecin='';
                $patient='';                
                $datecartificat='';
                $datenaissance='';
                $lieunaissance='';
                $taille='';
                $poids='';
                $indicePignet='';
                $etatsante='';
                $remarque='';
                $conclusion='';
                $datedebut='';
                $datefin='';
                $examination='';
                $codeOperation='';
                
                $data = DB::table('tt_attest_aptitude_physique')
                ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_aptitude_physique.refAttestation')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
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
    
                ->select("tt_attest_aptitude_physique.id","dateAttestation","thoracique","indiceDePignat",
                "etatDeSante","remarque","conclusion","DateDebut","DateFin","examination",
                "tt_attest_aptitude_physique.author","refAttestation","refDetailConst",
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tt_attest_aptitude_physique.created_at",
                "tt_attest_aptitude_physique.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature",
                "FC","FR","Oxygene",
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
                ->selectRaw('CONCAT("CAP",YEAR(tt_attest_aptitude_physique.created_at),"",MONTH(tt_attest_aptitude_physique.created_at),"00",tt_attest_aptitude_physique.id) as codeOperation')
                ->where('tt_attest_aptitude_physique.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {         
                    $thoracique=$row->thoracique;
                    $medecin=$row->examination;
                    $patient=$row->noms;                
                    $datecartificat=$row->created_at;
                    $datenaissance=$row->dateNaissance_malade;
                    $lieunaissance=$row->organisation_malade;
                    $taille=$row->Taille;
                    $poids=$row->Poids;
                    $indicePignet=$row->indiceDePignat;
                    $etatsante=$row->etatDeSante;
                    $remarque=$row->remarque;
                    $conclusion=$row->conclusion;
                    $datedebut=$row->DateDebut;
                    $datefin=$row->DateFin;
                    $examination=$row->examination;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csE2A75E99 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:745px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:219px;"></td>
                        <td style="height:0px;width:70px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:81px;"></td>
                        <td style="height:0px;width:57px;"></td>
                        <td style="height:0px;width:52px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:132px;"></td>
                        <td style="height:0px;width:42px;"></td>
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
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBF99781F" colspan="8" style="width:506px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td class="cs101A94F7" colspan="3" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                        </td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="8" style="width:506px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="8" style="width:506px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:506px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:506px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:506px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:506px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csE2A75E99" colspan="10" style="width:650px;height:33px;line-height:32px;text-align:center;vertical-align:middle;"><nobr>'.$titres.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="csE9F2AA97" colspan="11" style="width:692px;height:22px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Je&nbsp;soussign&#233;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$medecin.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M&#233;decin&nbsp;traitant&nbsp;&#224;&nbsp;la</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:694px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">'.$slogan.'&gt;&gt;&nbsp;en&nbsp;sigle,&nbsp;certifie&nbsp;avoir&nbsp;examin&#233;</td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:694px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Mme,Mlle,Mr&nbsp;&nbsp;&nbsp;&nbsp;'.$patient.'</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:694px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>N&#233;(e)&nbsp;&#224;&nbsp;&nbsp;'.$lieunaissance.'&nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;&nbsp;'.$datenaissance.'</nobr></td>
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
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="2" style="width:220px;height:23px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Taille:&nbsp;'.$taille.'&nbsp;Cm&nbsp;&nbsp;*Poids:&nbsp;&nbsp;'.$poids.'&nbsp;Kg</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:313px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Perimetre&nbsp;Thoracique:&nbsp;&nbsp;'.$thoracique.'&nbsp;cm</nobr></td>
                        <td></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="11" style="width:694px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Indice&nbsp;de&nbsp;Pignet:&nbsp;&nbsp;'.$indicePignet.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:694px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Etat&nbsp;de&nbsp;sante:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$etatsante.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="10" style="width:691px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Remarque:&nbsp;'.$remarque.'</td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="10" style="width:691px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Conclusion:&nbsp;'.$conclusion.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="3" style="width:290px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>&nbsp;Valable&nbsp;du&nbsp;'.$datedebut.'&nbsp;AU&nbsp;'.$datefin.'</nobr></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="7" style="width:378px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Fait&nbsp;&#224;&nbsp;Goma,&nbsp;&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="2" style="width:136px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Examinateur</nobr></td>
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
                        <td class="cs9E712815" colspan="7" style="width:378px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">'.$examination.'</td>
                    </tr>
                </table>
                </body>
                </html>
                ';
        return $output;

    }







    //===================== CERTIFICAT MEDICAL ====================================================================
    //===========================================================================================================================


    function pdf_certificatmedical_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoCertificatMedical($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoCertificatMedical($id)
    {

                $titres="CERTIFICAT MEDICAL DE BONNE SANTE";
                $signess="d'exposition";

                $thoracique='';
                $medecin='';
                $patient='';                
                $datecartificat='';
                $datenaissance='';
                $lieunaissance='';
                $taille='';
                $poids='';
                $indicePignet='';
                $etatsante='';
                $remarque='';
                $conclusion='';
                $datedebut='';
                $datefin='';
                $examination='';
                $codeOperation='';
                $indiceVerbaeck='';
                $SignesLesion='';
                
                $data = DB::table('tt_attest_certificat_medical')
                ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_certificat_medical.refAttestation')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
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
                
    
                ->select("tt_attest_certificat_medical.id","dateAttestation",
               
                "thoracique","indiceDePignat","indiceVerbaeck","SignesLesion","etetDeSante",
                "remarque","conclusion","DateDebut","DateFin","examination",
                "tt_attest_certificat_medical.author","refAttestation",
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tt_attest_certificat_medical.created_at",
                
                "tt_attest_certificat_medical.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin",
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
                ->selectRaw('CONCAT("CMED",YEAR(tt_attest_certificat_medical.created_at),"",MONTH(tt_attest_certificat_medical.created_at),"00",tt_attest_certificat_medical.id) as codeOperation')
                ->where('tt_attest_certificat_medical.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                { 
                    $thoracique=$row->thoracique;
                    $medecin=$row->examination;
                    $patient=$row->noms;                
                    $datecartificat=$row->created_at;
                    $datenaissance=$row->dateNaissance_malade;
                    $lieunaissance=$row->organisation_malade;
                    $taille=$row->Taille;
                    $poids=$row->Poids;
                    $indicePignet=$row->indiceDePignat;                    
                    $indiceVerbaeck=$row->indiceVerbaeck;
                    $SignesLesion=$row->SignesLesion;    
                    $etatsante=$row->etetDeSante;
                    $remarque=$row->remarque;
                    $conclusion=$row->conclusion;
                    $datedebut=$row->DateDebut;
                    $datefin=$row->DateFin;
                    $examination=$row->examination;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csE2A75E99 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:723px;height:795px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:223px;"></td>
                        <td style="height:0px;width:68px;"></td>
                        <td style="height:0px;width:23px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:2px;"></td>
                        <td style="height:0px;width:77px;"></td>
                        <td style="height:0px;width:62px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:17px;"></td>
                        <td style="height:0px;width:172px;"></td>
                        <td style="height:0px;width:3px;"></td>
                        <td style="height:0px;width:10px;"></td>
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
                        <td style="width:0px;height:3px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="8" style="width:175px;height:157px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:175px;height:157px;">
                            <img alt="" src="'.$pic2.'" style="width:175px;height:157px;" /></div>
                        </td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csBF99781F" colspan="8" style="width:503px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="8" style="width:503px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csCE72709D" colspan="8" style="width:503px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:503px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:503px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="8" style="width:503px;height:23px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:20px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="8" rowspan="2" style="width:503px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:2px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csE2A75E99" colspan="11" style="width:693px;height:33px;line-height:32px;text-align:center;vertical-align:middle;">'.$titres.'</td>
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
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td></td>
                        <td class="csE9F2AA97" colspan="11" style="width:693px;height:23px;line-height:18px;text-align:center;vertical-align:middle;"><nobr>Je&nbsp;soussign&#233;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$medecin.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;M&#233;decin&nbsp;traitant&nbsp;&#224;&nbsp;la</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:695px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>'.$slogan.' en&nbsp;sigle,&nbsp;certifie&nbsp;avoir&nbsp;examin&#233;</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:695px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Mme,Mlle,Mr&nbsp;&nbsp;&nbsp;&nbsp;'.$patient.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="11" style="width:695px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>N&#233;(e)&nbsp;&#224;&nbsp;&nbsp;'.$lieunaissance.'&nbsp;&nbsp;&nbsp;&nbsp;le&nbsp;&nbsp;'.$datenaissance.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" style="width:221px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Taille:&nbsp;'.$taille.'&nbsp;Cm&nbsp;&nbsp;*Poids:&nbsp;&nbsp;'.$poids.'&nbsp;Kg</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="4" style="width:313px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Perimetre&nbsp;Thoracique:&nbsp;&nbsp;'.$thoracique.'&nbsp;cm</nobr></td>
                        <td></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="13" style="width:706px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Indice&nbsp;de&nbsp;Pignet:&nbsp;&nbsp;'.$indicePignet.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="13" style="width:706px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Indice&nbsp;de&nbsp;verhaeck:&nbsp;&nbsp;&nbsp;'.$indiceVerbaeck.'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="13" style="width:706px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>*Etat&nbsp;des&nbsp;signes&nbsp;des&nbsp;l&#233;sions&nbsp;'.$signess.'&nbsp;&nbsp;:&nbsp;<textarea style="border:solid 0px black;">'.$SignesLesion.'</textarea></nobr></td>
                        <td></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="12" style="width:705px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Etat&nbsp;de&nbsp;sante: '.$etatsante.'</td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="12" style="width:705px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Remarque:<textarea style="border:solid 0px black;">'.$remarque.'</textarea></td>
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
                        <td></td>
                        <td class="cs9E712815" colspan="12" style="width:705px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Conclusion:&nbsp;<textarea style="border:solid 0px black;">'.$conclusion.'</textarea></td>
                        <td></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="3" style="width:290px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>&nbsp;Valable&nbsp;du&nbsp;'.$datedebut.'&nbsp;AU&nbsp;'.$datefin.'</nobr></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
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
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="7" style="width:378px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Fait&nbsp;&#224;&nbsp;Goma,&nbsp;&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="2" style="width:137px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Examinateur</nobr></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="6" style="width:378px;height:23px;line-height:18px;text-align:left;vertical-align:middle;">'.$examination.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
                </body>
                </html>                ';
        return $output;

    }


    //===================== CERTIFICAT DECES ====================================================================
    //===========================================================================================================================


    

    function pdf_certificatdeces_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoCertificatDeces($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoCertificatDeces($id)
    {

                $titres="CERTIFICAT DE DECES";
                $signess="d'exposition";

                $thoracique='';
                $medecin='';
                $patient='';                
                $datecertificat='';
                $heurecertificat='';
                $examination='';
                $codeOperation='';
                $SignesLesion='';
                
                $data = DB::table('tt_attest_certificat_deces')
                ->join('tt_attest_entete_attestation','tt_attest_entete_attestation.id','=','tt_attest_certificat_deces.refAttestation')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tt_attest_entete_attestation.refDetailConst')
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
        
    
                ->select("tt_attest_certificat_deces.id","dateAttestation","dateAdmise","heure",
                "tt_attest_certificat_deces.author","refAttestation","refDetailConst",
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tt_attest_certificat_deces.created_at",
                "tt_attest_certificat_deces.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"matricule_medecin","noms_medecin",
                "sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin",
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
                ->selectRaw('CONCAT("CD",YEAR(tt_attest_certificat_deces.created_at),"",MONTH(tt_attest_certificat_deces.created_at),"00",tt_attest_certificat_deces.id) as codeOperation')
                ->where('tt_attest_certificat_deces.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $medecin=$row->noms_medecin;
                    $patient=$row->noms;                
                    $datecartificat=$row->dateAdmise;
                    $heurecertificat=$row->heure;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csE2A75E99 {color:#000000;background-color:#D6E5F4;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:27px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;padding-right:2px;}
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs9E712815 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:474px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:346px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:87px;"></td>
                        <td style="height:0px;width:27px;"></td>
                        <td style="height:0px;width:90px;"></td>
                        <td style="height:0px;width:86px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBF99781F" colspan="4" style="width:480px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td></td>
                        <td class="cs101A94F7" colspan="2" rowspan="7" style="width:176px;height:144px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:176px;height:144px;">
                            <img alt="" src="'.$pic2.'" style="width:176px;height:144px;" /></div>
                        </td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="4" style="width:480px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csCE72709D" colspan="4" style="width:480px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="4" style="width:480px;height:23px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="4" style="width:480px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csFFC1C457" colspan="4" style="width:480px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs612ED82F" colspan="4" rowspan="2" style="width:480px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:38px;"></td>
                        <td></td>
                        <td></td>
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
                        <td class="csE2A75E99" colspan="2" style="width:349px;height:33px;line-height:32px;text-align:center;vertical-align:middle;"><nobr>CERTIFICAT&nbsp;DE&nbsp;DECES&nbsp;N&#176;</nobr></td>
                        <td class="csE2A75E99" colspan="5" style="width:328px;height:33px;line-height:32px;text-align:center;vertical-align:middle;">'.$codeOperation.'</td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="6" style="width:597px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Je&nbsp;soussign&#233;&nbsp;'.$medecin.'&nbsp;&nbsp;&nbsp;&nbsp;attester&nbsp;par</nobr></td>
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
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="6" style="width:597px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>le&nbsp;pr&#233;sent&nbsp;que&nbsp;Mr/&nbsp;Mme/Mlle&nbsp;&nbsp;&nbsp;&nbsp;'.$patient.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;est&nbsp;mort(e)&nbsp;&#224;</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="8" style="width:692px;height:22px;line-height:18px;text-align:left;vertical-align:middle;">Domicile&nbsp;et&nbsp;admis&nbsp;dans&nbsp;cet&nbsp;&#233;tat&nbsp;&#224;&nbsp;la&nbsp;<textarea style="border:solid 0px black;">'.$slogan.'</textarea></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs9E712815" colspan="8" style="width:692px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Le&nbsp;&nbsp;&nbsp;&nbsp;'.$datecartificat.'&nbsp;&nbsp;&nbsp;&nbsp;&#224;&nbsp;&nbsp;&nbsp;'.$heurecertificat.'&nbsp;&nbsp;&nbsp;qui&nbsp;est&nbsp;&nbsp;une&nbsp;mort&nbsp;naturelle</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:26px;"></td>
                        <td></td>
                        <td></td>
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
                        <td class="cs9E712815" colspan="7" style="width:346px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>Fait&nbsp;&#224;&nbsp;Goma,&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td></td>
                        <td class="cs9E712815" colspan="7" style="width:346px;height:22px;line-height:18px;text-align:left;vertical-align:middle;"><nobr>&nbsp;'.$examination.'</nobr></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }





     //===================== RAPPORT MEDICAL ====================================================================
    //===========================================================================================================================


    function pdf_rapportmedical_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoRapportMedical($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoRapportMedical($id)
    {

                $titres="RAPPORT MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $datenaissance='';
                $datemvt='';
                $lieunaissance='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $plaintes='';
                $historiques='';
                $antecedents='';
                $examenohysique='';
                $diagnostics='';
                $examenparacliniques='';
                $traitements='';
                $evolutions='';
                $conclusions='';
                $codeOperation='';
                
                
                $data = DB::table('tfin_rapportmedical')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tfin_rapportmedical.refDetailCons')
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
                ->select("tfin_rapportmedical.id",'refDetailCons','plainte_med','historique_med',
                'antecedent_med','examenphysique_med','diagnostic_med','examenparaclinique_med','traitement_med',
                'evolution_med','libelle_med','date_med','medecin_med','specialite_med','cnom_med',
                "tfin_rapportmedical.author", "tfin_rapportmedical.created_at",'statut_rapmed',
                 "tfin_rapportmedical.updated_at","refEnteteCons","refTypeCons","plainte","historique","antecedent","complementanamnese",
                 "examenphysique","diagnostiquePres","dateDetailCons","tdetailconsultation.author","tdetailconsultation.created_at",
                 "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature",
                "FC","FR","Oxygene",
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
                ->selectRaw('CONCAT("CD",YEAR(tfin_rapportmedical.created_at),"",MONTH(tfin_rapportmedical.created_at),"00",tfin_rapportmedical.id) as codeOperation')
                ->where('tfin_rapportmedical.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $datenaissance=$row->dateNaissance_malade;
                    $datemvt=$row->dateMouvement;
                    $lieunaissance=$row->organisation_malade;
                    $societe=$row->organisationAbonne;
                    $medecin=$row->medecin_med;
                    $speciaite=$row->specialite_med;
                    $cnom=$row->cnom_med;

                    $plaintes=$row->plainte_med;
                    $historiques=$row->historique_med;
                    $antecedents=$row->antecedent_med;
                    $examenohysique=$row->examenphysique_med;
                    $diagnostics=$row->diagnostic_med;
                    $examenparacliniques=$row->examenparaclinique_med;
                    $traitements=$row->traitement_med;
                    $evolutions=$row->evolution_med;
                    $conclusions=$row->libelle_med;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
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
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:891px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:100px;"></td>
                        <td style="height:0px;width:154px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:10px;"></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="9" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
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
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="9" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="9" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="9" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="14" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;MEDICAL</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:49px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:100px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:154px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:61px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:36px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:69px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:195px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs12FE94AA" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:147px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Lieu&nbsp;et&nbsp;Date&nbsp;Naissance&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$lieunaissance.' - '.$datenaissance.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:147px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;'.$signess.'&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$datemvt.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;PLAINTES&nbsp;PRINCIPALES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$plaintes.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>III.&nbsp;HISTORIQUE&nbsp;DE&nbsp;LA&nbsp;MALADIE</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$historiques.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>IV.&nbsp;ANTECEDENTS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$antecedents.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>V.&nbsp;EXAMEN&nbsp;PHYSIQUE</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$examenohysique.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VI.&nbsp;DIAGNOSTIC</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$diagnostics.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VII.&nbsp;EXAMENS&nbsp;PARACLINIQUES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$examenparacliniques.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VIII.&nbsp;TRAITEMENT</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$traitements.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>IX.&nbsp;EVOLUTIONS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$evolutions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="5" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>X.&nbsp;CONCLUSION</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:672px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:47px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:36px;height:47px;"></td>
                        <td class="cs101A94F7" style="width:69px;height:47px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:47px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:47px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:100px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:154px;height:25px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:49px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:100px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:154px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:61px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:36px;height:6px;"></td>
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
   
     //===================== PROTOCOLE IMAGERIE ====================================================================
    //===========================================================================================================================

 

    function pdf_protocoleimagerie_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoProtocoleImnagerie($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoProtocoleImnagerie($id)
    {

                $titres="SERVICE D'IMAGERIE MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $age=0;
                $dateimagerie='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $analyses='';
                $compterendu='';
                $conclusions='';
                $codeOperation='';
                
                
                $data = DB::table('tim_resultat_imagerie')
                ->join('tim_imagerie','tim_imagerie.id','=','tim_resultat_imagerie.refImagerie')
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
          
                ->select("tim_resultat_imagerie.id",'refImagerie','technique_res','description_res',
                'conclusion_res','image_res',"tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
                "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
                "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
                "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
                "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tim_resultat_imagerie.created_at",
                "tim_resultat_imagerie.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tim_resultat_imagerie.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
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
                ->selectRaw('CONCAT("IM",YEAR(tim_resultat_imagerie.created_at),"",MONTH(tim_resultat_imagerie.created_at),"00",tim_resultat_imagerie.id) as codeOperation')
                ->selectRaw('CONCAT("Technique",technique_res,". Description : ", description_res) as compterendu')
                ->where('tim_resultat_imagerie.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $age=$row->age_malade;
                    $dateimagerie=$row->dateImagerie;
                    $societe=$row->organisationAbonne;
                    $medecin=$row->medecinProtocolaire;
                    $speciaite=$row->specialiste;
                    $cnom=$row->CNOM;

                    $analyses=$row->nomAnalyse;
                    $compterendu=$row->compterendu;
                    $conclusions=$row->conclusion_res;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD4F2B537 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs55BEF77E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:757px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:76px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:127px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:16px;"></td>
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
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="10" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
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
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                        <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:10px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:10px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:10px;"></td>
                        <td class="csE7D235EF" style="width:169px;height:10px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:10px;"></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="15" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:53px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:76px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:40px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:127px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:97px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:53px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:195px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateimagerie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$age.'&nbsp;ans</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:43px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:43px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:43px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:43px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:43px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs55BEF77E" colspan="5" style="width:289px;height:23px;line-height:21px;text-align:center;vertical-align:top;">'.$analyses.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:127px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>COMPTE&nbsp;RENDU&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:665px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$compterendu.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:34px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:34px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:127px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CONCLUSION&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:665px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:19px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>SALUTATIONS&nbsp;CONFRATERNELLES</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:25px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;">'.$medecin.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$speciaite.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:8px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:8px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:8px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:8px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:53px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:76px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:40px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:127px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:19px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:97px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:53px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:19px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:195px;height:19px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:19px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }



         //===================== PROTOCOLE IMAGERIE AVEC IMAGE ====================================================================
    //===========================================================================================================================

   

    function pdf_protocoleimagerie_image_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoProtocoleImnagerie_Iamge($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoProtocoleImnagerie_Iamge($id)
    {

                $titres="SERVICE D'IMAGERIE MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $age=0;
                $dateimagerie='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $analyses='';
                $imagess='';
                $codeOperation='';
                
                
                $data = DB::table('tim_resultat_imagerie')
                ->join('tim_imagerie','tim_imagerie.id','=','tim_resultat_imagerie.refImagerie')
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
          
                ->select("tim_resultat_imagerie.id",'refImagerie','technique_res','description_res',
                'conclusion_res','image_res',"tim_imagerie.refDetailConst","tim_imagerie.refAnalyse",
                "refEnteteCons","refTypeCons","dateImagerie","clinique","but",'urgent',"CNOM","examenDemande",
                "tim_imagerie.specialiste","tim_imagerie.status","medecinProtocolaire",
                "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
                "ReftypeAnalyse","plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tim_resultat_imagerie.created_at",
                "tim_resultat_imagerie.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tim_resultat_imagerie.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
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
                ->selectRaw('CONCAT("IM",YEAR(tim_resultat_imagerie.created_at),"",MONTH(tim_resultat_imagerie.created_at),"00",tim_resultat_imagerie.id) as codeOperation')
                ->where('tim_resultat_imagerie.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $age=$row->age_malade;
                    $dateimagerie=$row->dateImagerie;
                    $societe=$row->organisationAbonne;
                    $medecin=$row->medecinProtocolaire;
                    $speciaite=$row->specialiste;
                    $cnom=$row->CNOM;

                    $analyses=$row->nomAnalyse;
                    $imagess=$this->displayImg("fichier", $row->image_res);
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs4C523F22 {color:#000000;background-color:transparent;border-left:transparent 1px solid;border-top:transparent 1px solid;border-right:transparent 1px solid;border-bottom:transparent 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD4F2B537 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs55BEF77E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:983px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:107px;"></td>
                        <td style="height:0px;width:136px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:56px;"></td>
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
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:169px;height:8px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:8px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="16" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:5px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:48px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:107px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:136px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:97px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:44px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:25px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:139px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:56px;height:2px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:9px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateimagerie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$age.'&nbsp;ans</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:23px;"></td>
                        <td class="cs55BEF77E" colspan="5" style="width:289px;height:23px;line-height:21px;text-align:center;vertical-align:top;">'.$analyses.'</td>
                        <td class="cs101A94F7" style="width:25px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:450px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:450px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:450px;"></td>
                        <td class="cs4C523F22" colspan="11" style="width:574px;height:448px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:574px;height:448px;">
                            <img alt="" src="'.$imagess.'" style="width:574px;height:448px;" /></div>
                        </td>
                        <td class="cs101A94F7" style="width:56px;height:450px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:450px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$medecin.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:25px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;">'.$cnom.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$speciaite.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:25px;"></td>
                        <td class="cs990B052E" colspan="9" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:48px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:107px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:136px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:97px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:44px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:25px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:139px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:56px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                ';
        return $output;

    }




         //===================== PROTOCOLE IMAGERIE EXTERNE ====================================================================
    //===========================================================================================================================


    
    
    function pdf_protocoleimagerie_externe_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoProtocoleImnagerieExt($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoProtocoleImnagerieExt($id)
    {

                $titres="SERVICE D'IMAGERIE MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $age=0;
                $dateimagerie='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $analyses='';
                $compterendu='';
                $conclusions='';
                $codeOperation='';
                
                
                $data = DB::table('tim_resultat_imagerie_ext')
                ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_imagerie_ext.refImagerie')
                ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
                ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
                ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
                ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
                ->join('tclient','tclient.id','=','tmouvement.refMalade')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
          
                ->select("tim_resultat_imagerie_ext.id",'refImagerie','technique_res','description_res',
                'conclusion_res','image_res',"tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
                "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande","organisationAbonne",
                "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire",
                "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
                "ReftypeAnalyse","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')  
                ->selectRaw('CONCAT("IM",YEAR(tim_resultat_imagerie_ext.created_at),"",MONTH(tim_resultat_imagerie_ext.created_at),"00",tim_resultat_imagerie_ext.id) as codeOperation')
                ->selectRaw('CONCAT("Technique",technique_res,". Description : ", description_res) as compterendu')
                ->where('tim_resultat_imagerie_ext.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $age=$row->age_malade;
                    $dateimagerie=$row->dateImagerie;
                    $societe=$row->organisationAbonne;
                    $medecin=$row->medecinProtocolaire;
                    $speciaite=$row->specialiste;
                    $cnom=$row->CNOM;

                    $analyses=$row->nomAnalyse;
                    $compterendu=$row->compterendu;
                    $conclusions=$row->conclusion_res;
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs8F84A210 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csD4F2B537 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs55BEF77E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:757px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:76px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:127px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:53px;"></td>
                        <td style="height:0px;width:16px;"></td>
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
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="10" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
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
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                        <td class="cs101A94F7" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:10px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:10px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:10px;"></td>
                        <td class="csE7D235EF" style="width:169px;height:10px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:10px;"></td>
                    </tr>
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
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="15" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:7px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:53px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:76px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:40px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:127px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:97px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:53px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:195px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateimagerie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$age.'&nbsp;ans</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:43px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:43px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:43px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:43px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:43px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:43px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs55BEF77E" colspan="5" style="width:289px;height:23px;line-height:21px;text-align:center;vertical-align:top;">'.$analyses.'</td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:127px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>COMPTE&nbsp;RENDU&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:665px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$compterendu.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:34px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:34px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:34px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:34px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:34px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:127px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>CONCLUSION&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                        <td class="cs8F84A210" colspan="12" style="width:665px;height:17px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusions.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:19px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>SALUTATIONS&nbsp;CONFRATERNELLES</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:25px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;">'.$medecin.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$speciaite.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:8px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:8px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:8px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:8px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:195px;height:8px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:8px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:53px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:76px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:127px;height:24px;"></td>
                        <td class="cs990B052E" colspan="8" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:7px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:53px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:76px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:40px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:127px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:19px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:97px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:53px;height:19px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:19px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:195px;height:19px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:19px;"></td>
                    </tr>
                </table>
                </body>
                </html>

                ';
        return $output;

    }



         //===================== PROTOCOLE IMAGERIE AVEC IMAGE ====================================================================
    //===========================================================================================================================


    function pdf_protocoleimagerie_image_externe_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoProtocoleImnagerie_Iamge_Ext($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoProtocoleImnagerie_Iamge_Ext($id)
    {

                $titres="SERVICE D'IMAGERIE MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $age=0;
                $dateimagerie='';
                $societe='';
                $medecin='';
                $speciaite='';
                $cnom='';

                $analyses='';
                $imagess='';
                $codeOperation='';
                
                
                $data = DB::table('tim_resultat_imagerie_ext')
                ->join('tim_imagerie_ext','tim_imagerie_ext.id','=','tim_resultat_imagerie_ext.refImagerie')
                ->join('tim_analyse','tim_analyse.id','=','tim_imagerie_ext.refAnalyse')
                ->join('tim_type_analyse','tim_type_analyse.id','=','tim_analyse.ReftypeAnalyse')
                ->join('tmouvement','tmouvement.id','=','tim_imagerie_ext.refMouvement')
                ->join('ttypemouvement_malade','ttypemouvement_malade.id','=','tmouvement.refTypeMouvement')
                ->join('tclient','tclient.id','=','tmouvement.refMalade')
                ->join('tcategorieclient' , 'tcategorieclient.id','=','tclient.refCategieClient')
                ->join('avenues' , 'avenues.id','=','tclient.refAvenue')
                ->join('quartiers' , 'quartiers.id','=','avenues.idQuartier')
                ->join('communes' , 'communes.id','=','quartiers.idCommune')
                ->join('villes' , 'villes.id','=','communes.idVille')
                ->join('provinces' , 'provinces.id','=','villes.idProvince')
                ->join('pays' , 'pays.id','=','provinces.idPays')
          
                ->select("tim_resultat_imagerie_ext.id",'refImagerie','technique_res','description_res',
                'conclusion_res','image_res',"tim_imagerie_ext.refMouvement","tim_imagerie_ext.refAnalyse",
                "dateImagerie","clinique","but",'urgent',"CNOM","examenDemande","organisationAbonne",
                "tim_imagerie_ext.specialiste","tim_imagerie_ext.status","medecinProtocolaire",
                "nomAnalyse","tim_analyse.prix","tim_analyse.prixConvention",'codeAnalyse','nomTypeAnalyse',
                "ReftypeAnalyse","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')  
                ->selectRaw('CONCAT("IM",YEAR(tim_resultat_imagerie_ext.created_at),"",MONTH(tim_resultat_imagerie_ext.created_at),"00",tim_resultat_imagerie_ext.id) as codeOperation')
                ->where('tim_resultat_imagerie_ext.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $age=$row->age_malade;
                    $dateimagerie=$row->dateImagerie;
                    $societe=$row->organisationAbonne;
                    $medecin=$row->medecinProtocolaire;
                    $speciaite=$row->specialiste;
                    $cnom=$row->CNOM;

                    $analyses=$row->nomAnalyse;
                    $imagess=$this->displayImg("fichier", $row->image_res);
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs4C523F22 {color:#000000;background-color:transparent;border-left:transparent 1px solid;border-top:transparent 1px solid;border-right:transparent 1px solid;border-bottom:transparent 1px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csD4F2B537 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
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
                        .cs55BEF77E {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:983px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:41px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:107px;"></td>
                        <td style="height:0px;width:136px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:71px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:25px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:113px;"></td>
                        <td style="height:0px;width:56px;"></td>
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
                        <td class="csFFC1C457" colspan="10" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
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
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="10" style="width:488px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:169px;height:8px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:8px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="16" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;">'.$titres.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:5px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:48px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:107px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:136px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:97px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:44px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:25px;height:2px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:139px;height:2px;"></td>
                        <td class="csDDFA3242" style="width:56px;height:2px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:2px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csCE72709D" colspan="6" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:9px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:9px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:9px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:9px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$dateimagerie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$sexe.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:58px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Age&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="3" style="width:257px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$age.'&nbsp;ans</td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:67px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="4" style="width:193px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:23px;"></td>
                        <td class="cs55BEF77E" colspan="5" style="width:289px;height:23px;line-height:21px;text-align:center;vertical-align:top;">'.$analyses.'</td>
                        <td class="cs101A94F7" style="width:25px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:450px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:450px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:450px;"></td>
                        <td class="cs4C523F22" colspan="11" style="width:574px;height:448px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:574px;height:448px;">
                            <img alt="" src="'.$imagess.'" style="width:574px;height:448px;" /></div>
                        </td>
                        <td class="cs101A94F7" style="width:56px;height:450px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:450px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$medecin.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:25px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;">'.$cnom.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:24px;"></td>
                        <td class="csD4F2B537" colspan="9" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$speciaite.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:97px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:44px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:25px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:139px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:56px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:48px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:107px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:136px;height:25px;"></td>
                        <td class="cs990B052E" colspan="9" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:48px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:107px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:136px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:97px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:44px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:25px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:139px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:56px;height:6px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:6px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                ';
        return $output;

    }





    //==================== RAPPORT MEDICAL NEURO ==================================================================================
    //=============================================================================================================================

    function pdf_rapportmedical_neuro_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoRapportNeuroMedical($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoRapportNeuroMedical($id)
    {

                $titres="RAPPORT MEDICAL";
                $signess="d'Hospitalisation";

                $patient='';
                $categorie='';
                $sexe='';                
                $datenaissance='';
                $datemvt='';
                $lieunaissance='';
                $societe='';
                
                //"developpement","traitementsRecus","conclusion","recomandation"

                $preambule='';
                $developpement='';
                $traitementsRecus='';
                $conclusion='';
                $recomandation='';

                $medecin1='';
                $specialite1='';
                $cnom1='';

                $medecin2='';
                $specialite2='';
                $cnom2='';

                $medecin3='';
                $specialite3='';
                $cnom3='';

                $name_typeRapport='';

                               
                
                $data = DB::table('tnero_protocole_neurologie')
                ->join('tnero_type_rapport','tnero_type_rapport.id','=','tnero_protocole_neurologie.reftyperapport')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tnero_protocole_neurologie.refdetailConst')
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
                ->select("tnero_protocole_neurologie.id","medecin1","medecin2","medecin3",
                "specialite1","cnom1","specialite2","cnom2","specialite3","cnom3","name_typeRapport",
                "preambule","developpement","traitementsRecus","conclusion","recomandation",
                "tnero_protocole_neurologie.author",'refdetailConst', "tnero_protocole_neurologie.created_at",
                "tnero_protocole_neurologie.updated_at","refEnteteCons","refTypeCons","plainte","historique",
                "antecedent","complementanamnese","examenphysique","diagnostiquePres","dateDetailCons",
                "tdetailconsultation.author","ttypeconsultation.designation as TypeConsultation",'refDetailTriage',
                'refMedecin','dateConsultation',"matricule_medecin","noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin","tmedecin.slug as slug_medecin","refEnteteTriage",
                "Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement",
                'organisationAbonne','taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
                "tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade","PrixCons")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')  
                ->selectRaw('CONCAT("CD",YEAR(tnero_protocole_neurologie.created_at),"",MONTH(tnero_protocole_neurologie.created_at),"00",tnero_protocole_neurologie.id) as codeOperation')
                ->where('tnero_protocole_neurologie.id', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $datenaissance=$row->dateNaissance_malade;
                    $datemvt=$row->dateMouvement;
                    $lieunaissance=$row->organisation_malade;
                    $societe=$row->organisationAbonne;

                    $preambule=$row->preambule;
                    $developpement=$row->developpement;
                    $traitementsRecus=$row->traitementsRecus;
                    $conclusion=$row->conclusion;
                    $recomandation=$row->recomandation;

                    $medecin1=$row->medecin1;
                    $specialite1=$row->specialite1;
                    $cnom1=$row->cnom1;

                    $medecin2=$row->medecin2;
                    $specialite2=$row->specialite2;
                    $cnom2=$row->cnom2;

                    $medecin3=$row->medecin3;
                    $specialite3=$row->specialite3;
                    $cnom3=$row->cnom3;

                    $name_typeRapport=$row->name_typeRapport;

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
                    <title>'.$name_typeRapport.'</title>
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
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:864px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:8px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:20px;"></td>
                        <td style="height:0px;width:80px;"></td>
                        <td style="height:0px;width:67px;"></td>
                        <td style="height:0px;width:14px;"></td>
                        <td style="height:0px;width:88px;"></td>
                        <td style="height:0px;width:1px;"></td>
                        <td style="height:0px;width:61px;"></td>
                        <td style="height:0px;width:10px;"></td>
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
                        <td class="csDDFA3242" colspan="12" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="12" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
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
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'<</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="12" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">Email&nbsp;:&nbsp;'.$emailEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="12" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="3" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="12" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
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
                        <td class="csE7D235EF" colspan="12" style="width:488px;height:6px;"></td>
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
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="18" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;">'.$name_typeRapport.'</td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:5px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:19px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:49px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:20px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:80px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:67px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:14px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:88px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:1px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:61px;height:19px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:71px;height:19px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:19px;"></td>
                        <td class="csDDFA3242" colspan="3" style="width:216px;height:19px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>I.&nbsp;INFORMATIONS&nbsp;PERSONNELLES</nobr></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:7px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:7px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:7px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:7px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:48px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="7" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="3" style="width:48px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Sexe&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="7" style="width:329px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$sexe.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="5" style="width:148px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Lieu&nbsp;et&nbsp;Date&nbsp;Naissance&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="5" style="width:229px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$datenaissance.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Categorie&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$categorie.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:68px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Soci&#232;t&#233;&nbsp;&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="6" style="width:309px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$societe.'</td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>II.&nbsp;PREAMBULES</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="15" style="width:674px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$preambule.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>III.&nbsp;DEVOLOPPEMENT&nbsp;(CONSTAT)</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="15" style="width:674px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$developpement.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:23px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:23px;line-height:16px;text-align:left;vertical-align:top;"><nobr>IV.&nbsp;TRAITEMENT&nbsp;RECUS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="15" style="width:674px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$traitementsRecus.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:13px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:13px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:13px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:13px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:13px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>V.&nbsp;CONCLUSION</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="15" style="width:674px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusion.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:14px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="csCE72709D" colspan="8" style="width:317px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>VI.&nbsp;RECOMMANDATIONS</nobr></td>
                        <td class="cs101A94F7" style="width:61px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="15" style="width:674px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$recomandation.'</textarea></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:25px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:25px;"></td>
                        <td class="cs990B052E" colspan="3" style="width:206px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:20px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:80px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:67px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:14px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:88px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:61px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:71px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="3" style="width:216px;height:16px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin1.'</td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin2.'</td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$medecin3.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite1.'</td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite2.'</td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;">'.$specialite3.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:5px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:1px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom1.'</nobr></td>
                        <td class="cs101A94F7" style="width:14px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="5" style="width:213px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom2.'</nobr></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs79DF234B" colspan="3" style="width:208px;height:16px;line-height:13px;text-align:left;vertical-align:top;"><nobr>CNOM&nbsp;'.$cnom3.'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:5px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:49px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:20px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:80px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:67px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:14px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:88px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:1px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:61px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:71px;height:7px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:7px;"></td>
                        <td class="csE7D235EF" colspan="3" style="width:216px;height:7px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
                    </tr>
                </table>
                </body>
                </html>
               
                ';
        return $output;

    }




    //==================== RAPPORT MEDICAL DIALYSE ==================================================================================
    //=============================================================================================================================

    function pdf_rapportmedical_dialyse_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoRapportDialyseMedical($id);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{

        }
        
        
    }

    function getInfoRapportDialyseMedical($id)
    {

                $titres="RAPPORT MEDICAL";
                $signess="l'h";
                $signe2="d'acc";

                $patient='';
                $categorie='';
                $sexe='';                
                $datenaissance='';
                $datemvt='';
                $lieunaissance='';
                $societe='';

                $rensMedicant='';
                $nephropatie='';
                $dateSeance='';
                $voieAcces='';
                $technineFonction='';

                $typeDialyse='';

                $Generateur='';
                $Dialyseur='';

                
                $joursDyalise='';
                $dureeDyalise='';
                $tempsDyalise='';
                $tempsDyalise='';
                $anticoagulation='';
                $poidsSec='';
                $prisePoids=''; 
                $UFMaxtolere='';  
                $debitPrompe='';
                $TAhabituelle='';
                $valeurDialysat='';
                $nA='';
                $k='';
                $ca='';
                $chloride='';
                $hco3='';
                $mg='';
                $acitate='';
                $evolution='';
                $conclusion='';
                $recommandation='';
                $traitement_dialyse='';
                $nb='';
                $dr='';
                $specialite='';
                $cNom='';


                $adresses='';
                $contact='';
                $fonction_malade='';
                $persref='';
                               
                
                $data = DB::table('tdyal_rapport_med_dyalyse')
                ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_rapport_med_dyalyse.refEnteteDyalise')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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
    
                ->select("tdyal_rapport_med_dyalyse.id","rensMedicant","nephropatie","dateSeance","Generateur",
                "Dialyseur","prisePoids","UFMaxtolere","traitement_dialyse",
                "voieAcces","technineFonction","typeDialyse","joursDyalise","dureeDyalise","tempsDyalise",
                "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
                "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
                "nb","dr","specialite","cNom","tdyal_rapport_med_dyalyse.author",
                "refEnteteDyalise","refDetailConst","plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin",
                "tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","categoriemaladiemvt","organisationAbonne","numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo",
                "tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')  
                ->selectRaw('CONCAT("CD",YEAR(tdyal_rapport_med_dyalyse.created_at),"",MONTH(tdyal_rapport_med_dyalyse.created_at),"00",tdyal_rapport_med_dyalyse.id) as codeOperation')
                ->selectRaw('CONCAT("Q.",nomQuartier,", Av.",nomAvenue,", N° : ",numeroMaison_malade) as adresses')
                ->selectRaw('CONCAT(personneRef_malade,"",contactPersRef_malade) as persref')
                ->where('tdyal_rapport_med_dyalyse.refEnteteDyalise', $id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    $patient=$row->noms;
                    $categorie=$row->categoriemaladiemvt;
                    $sexe=$row->sexe_malade;                
                    $datenaissance=$row->dateNaissance_malade;
                    $datemvt=$row->dateMouvement;
                    $lieunaissance=$row->organisation_malade;
                    $societe=$row->organisationAbonne;

                    $rensMedicant=$row->rensMedicant;
                    $nephropatie=$row->nephropatie;
                    $dateSeance=$row->dateSeance;
                    $voieAcces=$row->voieAcces;
                    $technineFonction=$row->technineFonction;

                    $Generateur=$row->Generateur;
                    $Dialyseur=$row->Dialyseur;
    
                    $typeDialyse=$row->typeDialyse;
                    $joursDyalise=$row->joursDyalise;
                    $dureeDyalise=$row->dureeDyalise;
                    $tempsDyalise=$row->tempsDyalise;
                    $tempsDyalise=$row->tempsDyalise;
                    $anticoagulation=$row->anticoagulation;
                    $poidsSec=$row->poidsSec;
                    $prisePoids=$row->prisePoids; 
                    $UFMaxtolere=$row->UFMaxtolere;                   
                    $debitPrompe=$row->debitPrompe;
                    $TAhabituelle=$row->TAhabituelle;
                    $valeurDialysat=$row->valeurDialysat;
                    $nA=$row->nA;
                    $k=$row->k;
                    $ca=$row->ca;
                    $chloride=$row->chloride;
                    $hco3=$row->hco3;
                    $mg=$row->mg;
                    $acitate=$row->acitate;
                    $evolution=$row->evolution;
                    $conclusion=$row->conclusion;
                    $recommandation=$row->recommandation;
                    $traitement_dialyse=$row->traitement_dialyse;
                    $nb=$row->nb;
                    $dr=$row->dr;
                    $specialite=$row->specialite;
                    $cNom=$row->cNom;

                    $adresses=$row->adresses; 
                    $contact=$row->contact;
                    $fonction_malade=$row->fonction_malade;
                    $persref=$row->persref;
                    //persref

                   
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
                    <title>'.$titres.'</title>
                    <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                    <style type="text/css">
                        .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs46B29C08 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs9EBB3764 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; text-decoration: underline;}
                        .csAD6D71D6 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .cs949E1716 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs990B052E {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs1C820FEC {color:#000000;background-color:transparent;border-left-style: none;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; }
                        .csF4FAFFB3 {color:#000000;background-color:transparent;border-left-style: none;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs66809DC0 {color:#000000;background-color:transparent;border-left-style: none;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; }
                        .csA586B1DD {color:#000000;background-color:transparent;border-left-style: none;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; }
                        .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .cs612ED82F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .csFFC1C457 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                        .csCE72709D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs12FE94AA {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                        .csC9493A0F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; text-decoration: underline;padding-left:2px;}
                        .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                        .cs7D52592D {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                        .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                        .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                    </style>
                </head>
                <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:1698px;position:relative;">
                    <tr>
                        <td style="width:0px;height:0px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:42px;"></td>
                        <td style="height:0px;width:26px;"></td>
                        <td style="height:0px;width:38px;"></td>
                        <td style="height:0px;width:11px;"></td>
                        <td style="height:0px;width:55px;"></td>
                        <td style="height:0px;width:10px;"></td>
                        <td style="height:0px;width:34px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:12px;"></td>
                        <td style="height:0px;width:31px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:49px;"></td>
                        <td style="height:0px;width:19px;"></td>
                        <td style="height:0px;width:7px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:13px;"></td>
                        <td style="height:0px;width:37px;"></td>
                        <td style="height:0px;width:24px;"></td>
                        <td style="height:0px;width:16px;"></td>
                        <td style="height:0px;width:9px;"></td>
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:109px;"></td>
                        <td style="height:0px;width:11px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="19" style="width:488px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:16px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="4" style="width:169px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:24px;"></td>
                        <td class="csFBB219FE" colspan="19" style="width:486px;height:24px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="4" rowspan="7" style="width:163px;height:149px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:149px;">
                            <img alt="" src="'.$pic2.'" style="width:163px;height:149px;" /></div>
                        </td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="19" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csCE72709D" colspan="19" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="19" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="19" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:22px;"></td>
                        <td class="csFFC1C457" colspan="19" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:21px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:21px;"></td>
                        <td class="cs612ED82F" colspan="19" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                        <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:1px;"></td>
                        <td></td>
                        <td class="csBDA79072" colspan="2" style="width:13px;height:1px;"></td>
                        <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                        <td class="cs101A94F7" colspan="4" style="width:169px;height:1px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="cs593B729A" colspan="2" style="width:13px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="19" style="width:488px;height:6px;"></td>
                        <td class="csE7D235EF" style="width:16px;height:6px;"></td>
                        <td class="csE7D235EF" colspan="4" style="width:169px;height:6px;"></td>
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
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:33px;"></td>
                        <td></td>
                        <td class="cs7D52592D" colspan="27" style="width:694px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>RAPPORT&nbsp;MEDICAL</nobr></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:9px;"></td>
                        <td></td>
                        <td class="csD24A75E0" style="width:6px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:49px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:26px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:38px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:55px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:10px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:34px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:24px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:12px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:31px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:19px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:49px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:26px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:24px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:13px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:37px;height:6px;"></td>
                        <td class="csDDFA3242" colspan="2" style="width:40px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:9px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:40px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:109px;height:6px;"></td>
                        <td class="csDDFA3242" style="width:11px;height:6px;"></td>
                        <td class="cs62ED362D" style="width:6px;height:6px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;:</nobr></td>
                        <td class="csCE72709D" colspan="14" style="width:346px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.$patient.'</td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="csCE72709D" colspan="2" style="width:47px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Goma,</nobr></td>
                        <td class="cs12FE94AA" colspan="2" style="width:118px;height:22px;line-height:15px;text-align:left;vertical-align:top;">'.date('Y-m-d').'</td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="9" style="width:234px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Renseignements&nbsp;Administratifs&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;de&nbsp;naissance</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$datenaissance.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Adresse</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$adresses.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$contact.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Profession</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$fonction_malade.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Couverture&nbsp;sociale</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$categorie.' - '.$societe.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="cs12FE94AA" colspan="4" style="width:111px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Personne&nbsp;&#224;&nbsp;pr&#233;venir</nobr></td>
                        <td class="cs12FE94AA" style="width:9px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs12FE94AA" colspan="19" style="width:543px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$persref.'</td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:11px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:11px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:11px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="9" style="width:234px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Renseignements&nbsp;M&#233;dicaux&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="24" style="width:663px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$rensMedicant.'</textarea></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:10px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:10px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:10px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:10px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:10px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:39px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:39px;"></td>
                        <td class="csC9493A0F" colspan="18" style="width:432px;height:39px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Renseignements&nbsp;en&nbsp;rapport&nbsp;avec&nbsp;'.$signess.'&#233;modialyse&nbsp;&#224;</nobr><br/><nobr>HOPITAL/GOMA&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:37px;height:39px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:39px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:39px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:39px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:39px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:39px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:39px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:14px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>N&#233;phropathie</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$nephropatie.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Date&nbsp;de&nbsp;la&nbsp;premi&#232;re&nbsp;s&#233;ance</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$dateSeance.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Voie&nbsp;'.$signe2.'&#232;s</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$voieAcces.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Technique&nbsp;de&nbsp;ponction</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$technineFonction.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Type&nbsp;de&nbsp;Dialyse</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$typeDialyse.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Generateur</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$Generateur.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Dialyseur&nbsp;habituel</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$Dialyseur.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Jours&nbsp;de&nbsp;dialyses</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$joursDyalise.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Duree&nbsp;de&nbsp;la&nbsp;dialyse</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$dureeDyalise.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Temps&nbsp;de&nbsp;dialyse&nbsp;habdomadaire</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$tempsDyalise.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Anticoagulation</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$anticoagulation.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Poids&nbsp;sec&nbsp;theorique</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$poidsSec.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Prise&nbsp;de&nbsp;poids&nbsp;inter&nbsp;dialytique</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$prisePoids.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>UF&nbsp;Max&nbsp;toleree</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$UFMaxtolere.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Debit&nbsp;pompe&nbsp;a&nbsp;sang</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$debitPrompe.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>TA&nbsp;habituelle&nbsp;debout</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$TAhabituelle.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs9EBB3764" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Valeurs&nbsp;dialysat</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="cs1C820FEC" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$valeurDialysat.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Na+</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$nA.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>K+</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$k.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Ca++</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$ca.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Chloride</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$chloride.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>HC03-</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$hco3.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Mg++</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$mg.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="6" style="width:173px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>Acetate</nobr></td>
                        <td class="csF4FAFFB3" style="width:7px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>:</nobr></td>
                        <td class="csF4FAFFB3" colspan="17" style="width:477px;height:18px;line-height:15px;text-align:left;vertical-align:middle;">'.$acitate.'</td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="10" style="width:258px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Deroulement&nbsp;de&nbsp;la&nbsp;d&#233;rni&#232;re&nbsp;s&#233;ance&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:14px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:14px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:14px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:14px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:14px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csAD6D71D6" colspan="2" style="width:43px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Heures</nobr></td>
                        <td class="cs66809DC0" style="width:23px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TA</nobr></td>
                        <td class="cs66809DC0" colspan="2" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>BP</nobr></td>
                        <td class="cs66809DC0" style="width:52px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>MAP</nobr></td>
                        <td class="cs66809DC0" colspan="2" style="width:41px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>HR</nobr></td>
                        <td class="cs66809DC0" colspan="3" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PA</nobr></td>
                        <td class="cs66809DC0" colspan="2" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>PV</nobr></td>
                        <td class="cs66809DC0" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>TMP</nobr></td>
                        <td class="cs66809DC0" colspan="3" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>QB</nobr></td>
                        <td class="cs66809DC0" colspan="2" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>QD</nobr></td>
                        <td class="cs66809DC0" colspan="3" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>UF&nbsp;Vol</nobr></td>
                        <td class="cs66809DC0" colspan="2" style="width:146px;height:18px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Observation</nobr></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    ';
                        
                        $output .= $this->showDeroulementSeance($id); 
                        
                        $output.='
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:17px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:17px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:17px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:17px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:17px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:17px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:17px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="10" style="width:258px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Evolution&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="24" style="width:663px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$evolution.'</textarea></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:19px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:19px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:19px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:19px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:19px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="csC9493A0F" colspan="10" style="width:258px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Conclusion&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:12px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="24" style="width:663px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$conclusion.'</textarea></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:18px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:18px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:18px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:18px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:18px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="10" style="width:258px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Recommandations&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="24" style="width:663px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$recommandation.'</textarea></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:16px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:16px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:16px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:16px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:16px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"></td>
                        <td class="csC9493A0F" colspan="10" style="width:258px;height:22px;line-height:18px;text-align:left;vertical-align:top;"><nobr>Traitement&nbsp;en&nbsp;cours&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:12px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:22px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:22px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:22px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="csE314B2A3" colspan="17" style="width:415px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$traitement_dialyse.'</textarea></td>
                        <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:15px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:15px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:15px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:15px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:15px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:23px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:23px;"></td>
                        <td class="csC9493A0F" colspan="2" style="width:47px;height:23px;line-height:18px;text-align:left;vertical-align:top;"><nobr>NB&nbsp;:</nobr></td>
                        <td class="cs101A94F7" style="width:26px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:23px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:23px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:23px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs46B29C08" colspan="24" style="width:663px;height:18px;line-height:15px;text-align:left;vertical-align:top;"><textarea style="border:solid 0px black;">'.$nb.'</textarea></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:32px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:19px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:49px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:26px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:37px;height:32px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:40px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:9px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:40px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:109px;height:32px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:32px;"></td>
                        <td class="cs145AAE8A" style="width:6px;height:32px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:25px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:25px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:25px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:25px;"></td>
                        <td class="cs990B052E" colspan="13" style="width:367px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                        <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:24px;"></td>
                        <td class="cs990B052E" colspan="13" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$dr.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:24px;"></td>
                        <td></td>
                        <td class="csBDA79072" style="width:6px;height:24px;"></td>
                        <td class="cs101A94F7" colspan="2" style="width:49px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:26px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:38px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:55px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:10px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:34px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:13px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:24px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:12px;height:24px;"></td>
                        <td class="cs101A94F7" style="width:31px;height:24px;"></td>
                        <td class="cs990B052E" colspan="13" style="width:367px;height:18px;line-height:16px;text-align:right;vertical-align:top;">'.$specialite.'</td>
                        <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:49px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:26px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:38px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:55px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:10px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:34px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:24px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:12px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:31px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:19px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:49px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:26px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:24px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:13px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:37px;height:8px;"></td>
                        <td class="csE7D235EF" colspan="2" style="width:40px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:9px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:40px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:109px;height:8px;"></td>
                        <td class="csE7D235EF" style="width:11px;height:8px;"></td>
                        <td class="cs11B2FA6F" style="width:6px;height:8px;"></td>
                    </tr>
                </table>
                </body>
                </html>
                    

                ';
        return $output;

    }

        function showDeroulementSeance($id)
        {
                $data = DB::table('tdyal_deroulement_dyalise')
                ->join('tdyal_entete_dyalise','tdyal_entete_dyalise.id','=','tdyal_deroulement_dyalise.refEnteteDyalise')
                ->join('tdetailconsultation','tdetailconsultation.id','=','tdyal_entete_dyalise.refDetailConst')
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

                ->select("tdyal_deroulement_dyalise.id",
                "heure","tdyal_deroulement_dyalise.ta as ta_deroulement","bP","mAp","hR","pA",
                "pV","tMP","qB","qD","uF","observation","tdyal_deroulement_dyalise.author",
                "tdyal_deroulement_dyalise.refEnteteDyalise",
            //=====================================
                "plainte","historique","antecedent","complementanamnese","examenphysique",
                "diagnostiquePres","dateDetailCons","tdetailconsultation.created_at",
                "tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",
                'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
                "tenteteconsulter.created_at","tenteteconsulter.updated_at","matricule_medecin",
                "noms_medecin","sexe_medecin","datenaissance_medecin",
                "lieunaissnce_medecin","provinceOrigine_medecin","etatcivil_medecin","refAvenue_medecin",
                "contact_medecin","mail_medecin","grade_medecin","fonction_medecin","specialite_medecin",
                "Categorie_medecin","niveauEtude_medecin","anneeFinEtude_medecin","Ecole_medecin","tmedecin.photo as photo_medecin",
                "tmedecin.slug as slug_medecin","refEnteteTriage","Poids","Taille","tdetailtriage.TA","Temperature","FC","FR","Oxygene",
                "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
                "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
                "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie",
                "tclient.photo","tclient.slug","nomAvenue",
                "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
                "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                "dateExpiration_malade")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->where('tdyal_deroulement_dyalise.refEnteteDyalise','=', $id)
                ->orderBy("tdyal_deroulement_dyalise.created_at", "desc")
                ->get();
                $output='';

                foreach ($data as $row) 
                {
                    $output .='
                            <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:24px;"></td>
                            <td class="cs949E1716" colspan="2" style="width:43px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->heure.'</td>
                            <td class="csA586B1DD" style="width:23px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->ta_deroulement.'</td>
                            <td class="csA586B1DD" colspan="2" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->bP.'</td>
                            <td class="csA586B1DD" style="width:52px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->mAp.'</td>
                            <td class="csA586B1DD" colspan="2" style="width:41px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->hR.'</td>
                            <td class="csA586B1DD" colspan="3" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->pA.'</td>
                            <td class="csA586B1DD" colspan="2" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->pV.'</td>
                            <td class="csA586B1DD" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->tMP.'</td>
                            <td class="csA586B1DD" colspan="3" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qB.'</td>
                            <td class="csA586B1DD" colspan="2" style="width:47px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->qD.'</td>
                            <td class="csA586B1DD" colspan="3" style="width:46px;height:18px;line-height:15px;text-align:center;vertical-align:middle;">'.$row->uF.'</td>
                            <td class="csA586B1DD" colspan="2" style="width:146px;height:18px;line-height:15px;text-align:left;vertical-align:middle;"><textarea style="border:solid 0px black;">'.$row->observation.'</textarea></td>
                            <td class="cs101A94F7" style="width:11px;height:24px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                        </tr>            
                    ';                 
        
                }

            return $output;

        }






        //============= ATTESTATION DE NAISSANCE ===================================================================================
        //======================================================================================================================



        function pdf_attestation_naissance_data(Request $request)
        {
    
            if ($request->get('id')) 
            {
                $id = $request->get('id');
                $html = $this->getInfoAttestationNaissance($id);
                $pdf = \App::make('dompdf.wrapper');
    
                // echo($html);
    
    
                $pdf->loadHTML($html);
                $pdf->loadHTML($html)->setPaper('a4');
                return $pdf->stream();
                
            }
            else{
    
            }
            
            
        }
    
        function getInfoAttestationNaissance($id)
        {
    
                    $titres="CERTIFICAT DE NAISSANCE";
    
                    $PoidsNaissance=0;
                    $noms='';
                    $sexe_malade='';
                    $dateNaissance_malade='';
                    $NomMere='';
                    $NomPere='';
                    $medecin='';
                    $cnom='';
                    $codeOperation='';
                    
                    $data = DB::table('tenfant_entete_vaccination')
                    ->join('tmouvement','tmouvement.id','=','tenfant_entete_vaccination.refMouvement')
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
                    ->select("tenfant_entete_vaccination.id","refMouvement","medecin","cnom","tenfant_entete_vaccination.author",
        
                    "NomPere","NomMere","ContactPere","ContactMere","dateEntete","numeroEnreg",
                    "PoidsNaissance","ZoneSante","AireSante","CentreSante","Estnedomicile","OrphelinMere",
                    "OrphelinPere","FrereSoeur","Mere5Enfants","EnfantJumeau","NaissanceRapproche","Mere18ans","ModeAccouchement",
                    "Apgar","Nevaripine","Mortne","Mort24h","ComplicationAccouchement","ReanimationEnfant","ComplicatioPostPartum",
                    "VitamineMere","FerMere","TailleNaissance","CPON","PF","CPS","TypeAccouchement","AccouchementFOSA",
        
                    "tenfant_entete_vaccination.created_at","tenfant_entete_vaccination.updated_at","refMalade",
                    "refTypeMouvement","dateMouvement","numroBon","Statut","dateSortieMvt",'organisationAbonne',
                    'taux_prisecharge','pourcentageConvention','categoriemaladiemvt',"motifSortieMvt","autoriseSortieMvt",
                    "ttypemouvement_malade.designation as Typemouvement","noms","contact",
                    "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","photo","slug","nomAvenue",
                    "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
                    "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
                    "numeroMaison_malade","fonction_malade","personneRef_malade","fonctioPersRef_malade",
                    "contactPersRef_malade","organisation_malade","numeroCarte_malade",
                    "dateExpiration_malade")
                    ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                    ->selectRaw('CONCAT("NAIS",YEAR(tenfant_entete_vaccination.created_at),"",MONTH(tenfant_entete_vaccination.created_at),"00",tenfant_entete_vaccination.id) as codeOperation')
                    ->where('tenfant_entete_vaccination.id', $id)
                    ->get();
                    $output='';
                    foreach ($data as $row) 
                    {         
                        $PoidsNaissance=$row->PoidsNaissance;
                        $noms=$row->noms;
                        $sexe_malade=$row->sexe_malade;
                        $dateNaissance_malade=$row->dateNaissance_malade;
                        $NomMere=$row->NomMere;
                        $NomPere=$row->NomPere;
                        $medecin=$row->medecin;
                        $cnom=$row->cnom;
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
                        <title>ATTESTATION DE NAISSANCE</title>
                        <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                        <style type="text/css">
                            .csD24A75E0 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs593B729A {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csBDA79072 {color:#000000;background-color:transparent;border-left:#A9CAE8 3px solid;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE314B2A3 {color:#000000;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs62ED362D {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csDDFA3242 {color:#000000;background-color:transparent;border-left-style: none;border-top:#A9CAE8 3px solid;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs11B2FA6F {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs145AAE8A {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right:#A9CAE8 3px solid;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .csE7D235EF {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom:#A9CAE8 3px solid;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs101A94F7 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:13px; font-weight:normal; font-style:normal; }
                            .cs71BA807F {color:#2B2E7D;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .csC5E816B3 {color:#2B2E7D;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs2FED7821 {color:#2B2E7D;background-color:transparent;border-left:transparent 3px solid;border-top:transparent 3px solid;border-right:transparent 3px solid;border-bottom:transparent 3px solid;font-family:Times New Roman; font-size:26px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                            .cs2A14C2BD {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .csF71F419E {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:12px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .csD284B7A7 {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs8D45AF77 {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:14px; font-weight:normal; font-style:normal; padding-left:2px;}
                            .csBF99781F {color:#2B2E7D;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                            .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                            .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                        </style>
                    </head>
                    <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
                    <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:708px;height:446px;position:relative;">
                        <tr>
                            <td style="width:0px;height:0px;"></td>
                            <td style="height:0px;width:10px;"></td>
                            <td style="height:0px;width:9px;"></td>
                            <td style="height:0px;width:7px;"></td>
                            <td style="height:0px;width:42px;"></td>
                            <td style="height:0px;width:317px;"></td>
                            <td style="height:0px;width:24px;"></td>
                            <td style="height:0px;width:105px;"></td>
                            <td style="height:0px;width:16px;"></td>
                            <td style="height:0px;width:97px;"></td>
                            <td style="height:0px;width:72px;"></td>
                            <td style="height:0px;width:9px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td class="cs739196BC" colspan="6" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:10px;"></td>
                            <td></td>
                            <td class="csD24A75E0" style="width:6px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:7px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:42px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:317px;height:7px;"></td>
                            <td class="csDDFA3242" colspan="2" style="width:129px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:16px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:97px;height:7px;"></td>
                            <td class="csDDFA3242" style="width:72px;height:7px;"></td>
                            <td class="cs62ED362D" style="width:6px;height:7px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:23px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:23px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:23px;"></td>
                            <td class="csBF99781F" colspan="4" style="width:486px;height:23px;line-height:21px;text-align:left;vertical-align:middle;">'.$nomEse.'</td>
                            <td class="cs101A94F7" style="width:16px;height:23px;"></td>
                            <td class="csE314B2A3" colspan="2" rowspan="7" style="width:163px;height:148px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:163px;height:148px;">
                                <img alt="" src="'.$pic2.'" style="width:163px;height:148px;" /></div>
                            </td>
                            <td class="cs145AAE8A" style="width:6px;height:23px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="csD284B7A7" colspan="4" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;">'.$busnessName.'</td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="csD284B7A7" colspan="4" style="width:486px;height:22px;line-height:15px;text-align:left;vertical-align:middle;"><nobr>RCCM'.$rccEse.'.&nbsp;ID-NAT.'.$numImpotEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="csF71F419E" colspan="4" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;">'.$adresseEse.'</td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="csF71F419E" colspan="4" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Email&nbsp;:&nbsp;'.$emailEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="csF71F419E" colspan="4" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>Site&nbsp;web&nbsp;:&nbsp;'.$siteEse.'</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:22px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:21px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:21px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:21px;"></td>
                            <td class="cs2A14C2BD" colspan="4" rowspan="2" style="width:486px;height:22px;line-height:13px;text-align:left;vertical-align:middle;"><nobr>T&#233;l&#233;phone&nbsp;:&nbsp;'.$Tel1Ese.'&nbsp;&nbsp;24h/24</nobr></td>
                            <td class="cs101A94F7" style="width:16px;height:21px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:21px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:1px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:1px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:1px;"></td>
                            <td class="cs101A94F7" style="width:16px;height:1px;"></td>
                            <td class="cs101A94F7" style="width:97px;height:1px;"></td>
                            <td class="cs101A94F7" style="width:72px;height:1px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:1px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:11px;"></td>
                            <td class="cs101A94F7" colspan="2" style="width:129px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:97px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:72px;height:11px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:38px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:38px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:38px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:38px;"></td>
                            <td class="cs2FED7821" colspan="5" style="width:549px;height:32px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>CERTIFICAT&nbsp;DE&nbsp;NAISSANCE</nobr></td>
                            <td class="cs101A94F7" style="width:72px;height:38px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:38px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:11px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:11px;"></td>
                            <td class="cs101A94F7" colspan="2" style="width:129px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:16px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:97px;height:11px;"></td>
                            <td class="cs101A94F7" style="width:72px;height:11px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:11px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs8D45AF77" colspan="8" style="width:678px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Je&nbsp;sousign&#233;,&nbsp;Docteur&nbsp;...'.$medecin.'....................certifie&nbsp;que</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs8D45AF77" colspan="8" style="width:678px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>le&nbsp;b&#233;b&#233;&nbsp;..'.$noms.'.........&nbsp;de&nbsp;sexe&nbsp;.'.$sexe_malade.'.</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs8D45AF77" colspan="8" style="width:678px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>pesant&nbsp;.100&nbsp;g,&nbsp;est&nbsp;n&#233;(e)&nbsp;&#224;&nbsp;Goma,&nbsp;ce&nbsp;'.$dateNaissance_malade.'&nbsp;dans&nbsp;notre&nbsp;formation&nbsp;m&#233;dicale,</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs8D45AF77" colspan="8" style="width:678px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>De&nbsp;la&nbsp;m&#232;re&nbsp;:&nbsp;&nbsp;'.$NomMere.'...............&nbsp;et</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs8D45AF77" colspan="8" style="width:678px;height:22px;line-height:16px;text-align:left;vertical-align:top;"><nobr>Du&nbsp;p&#232;re&nbsp;:&nbsp;&nbsp;'.$NomPere.'</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:7px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:7px;"></td>
                            <td class="cs101A94F7" colspan="2" style="width:129px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:16px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:97px;height:7px;"></td>
                            <td class="cs101A94F7" style="width:72px;height:7px;"></td>
                            <td class="cs145AAE8A" style="width:6px;height:7px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:24px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:24px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:24px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:24px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:24px;"></td>
                            <td class="csC5E816B3" colspan="5" style="width:304px;height:18px;line-height:16px;text-align:right;vertical-align:top;"><nobr>Fait&nbsp;&#224;&nbsp;Goma&nbsp;le&nbsp;&nbsp;'.date('Y-m-d').'</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:24px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:22px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:22px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:22px;"></td>
                            <td class="cs71BA807F" colspan="5" style="width:304px;height:16px;line-height:13px;text-align:right;vertical-align:top;"><nobr>Docteur&nbsp;:&nbsp;'.$medecin.'</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:22px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:25px;"></td>
                            <td></td>
                            <td class="csBDA79072" style="width:6px;height:25px;"></td>
                            <td class="cs101A94F7" style="width:7px;height:25px;"></td>
                            <td class="cs101A94F7" style="width:42px;height:25px;"></td>
                            <td class="cs101A94F7" style="width:317px;height:25px;"></td>
                            <td class="csC5E816B3" colspan="5" style="width:304px;height:19px;line-height:16px;text-align:right;vertical-align:top;"><nobr>CNOM&nbsp;:&nbsp;'.$cnom.'</nobr></td>
                            <td class="cs145AAE8A" style="width:6px;height:25px;"></td>
                        </tr>
                        <tr style="vertical-align:top;">
                            <td style="width:0px;height:10px;"></td>
                            <td></td>
                            <td class="cs593B729A" style="width:6px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:7px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:42px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:317px;height:7px;"></td>
                            <td class="csE7D235EF" colspan="2" style="width:129px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:16px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:97px;height:7px;"></td>
                            <td class="csE7D235EF" style="width:72px;height:7px;"></td>
                            <td class="cs11B2FA6F" style="width:6px;height:7px;"></td>
                        </tr>
                    </table>
                    </body>
                    </html>

                    ';
            return $output;
    
        }



    


    
    

    
}
