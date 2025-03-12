<?php

namespace App\Http\Controllers\Laboratoire;
use Illuminate\Http\Request;
use App\Models\Laboratoire\vEnteteLabo;
use App\Models\Laboratoire\vDetailLabo;
use App\Models\vEntreprise;
use App\Traits\{GlobalMethod,Slug};
use DB;

class BonExamenPdfController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    function pdf_bon_data(Request $request)
    {

        if ($request->get('id')) 
        {
            $id = $request->get('id');
            $html = $this->getInfoFactureTug($id);
            $pdf = \App::make('dompdf.wrapper');
            // echo($html);

            $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4');
            return $pdf->stream();
            
        }
        else{
        }       
        
    }

    function getInfoFactureTug($id)
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


                $nom_laborantin='';
                $date_prelement='';
                
                // 
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
                "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
                "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
                "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
                "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->where('id', $id)
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

//'noms','contact','mail'
                    $code_medecin=$row->refMalade;
                    $noms_medecin=$row->noms_medecin;
                    $sexe_medecin=$row->sexe_medecin;
                    $datenaiss_medecin=$row->datenaissance_medecin;
                    $telephone_medecin=$row->contact_medecin;
                    $mail_medecin=$row->mail_medecin;
                    $adresse_medecin=$row->nomCommune_medecin;
                    $fonction_medecin=$row->fonction_medecin;                  
                
                }



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
                "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
                "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
                "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
                "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
                ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
                ->Where('id',$id)
                ->get();
                $output='';
                foreach ($data as $row) 
                {
                    //'author','created_at'
                    $nom_laborantin='Encours';
                    $date_prelement=$row->created_at;
                    
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
                        <td style="height:0px;width:40px;"></td>
                        <td style="height:0px;width:44px;"></td>
                        <td style="height:0px;width:51px;"></td>
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
                        <td class="csDDFA3242" colspan="2" style="width:130px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csDDFA3242" colspan="2" style="width:95px;height:6px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                        <td class="cs101A94F7" colspan="2" rowspan="8" style="width:130px;height:115px;text-align:left;vertical-align:top;"><div style="overflow:hidden;width:130px;height:115px;">
                            <img alt="" src="'.$pic.'" style="width:130px;height:115px;" /></div>
                        </td>
                        <td class="cs101A94F7" colspan="2" rowspan="8" style="width:95px;height:115px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                        <td class="cs101A94F7" colspan="2" style="width:130px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs101A94F7" colspan="2" style="width:95px;height:9px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                        <td class="cs6105B8F3" colspan="5" rowspan="2" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$emailEse.'</nobr></td>
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
                        <td class="cs6105B8F3" colspan="5" style="width:332px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>'.$adresseEse.'</nobr></td>
                        <td class="cs101A94F7" colspan="2" style="width:29px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csBDA79072" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs6105B8F3" colspan="3" style="width:267px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>N&#176;&nbsp;Dossier :&nbsp;&nbsp;'.$code_malade.'</nobr></td>
                        <td class="cs145AAE8A" colspan="2" style="width:24px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:11px;"></td>
                        <td></td>
                        <td class="cs593B729A" style="width:6px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csE7D235EF" style="width:109px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csE7D235EF" colspan="2" style="width:130px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csE7D235EF" colspan="2" style="width:95px;height:8px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
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
                        <td class="cs7DC47A5E" colspan="8" style="width:295px;height:33px;line-height:31px;text-align:center;vertical-align:middle;"><nobr>BON&nbsp;DES&nbsp;EXAMENS</nobr></td>
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
                        <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;du&nbsp;M&#233;decin&nbsp;Demandeur&#160;:&nbsp;&nbsp;&nbsp;DR.&nbsp;'.$noms_medecin.'</nobr></td>
                        <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs12FE94AA" colspan="4" style="width:269px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Noms&nbsp;du&nbsp;Pr&#233;leveur&#160;:&nbsp;'.$nom_laborantin.'</nobr></td>
                        <td class="cs671B350" style="width:22px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                    </tr>
                    <tr style="vertical-align:top;">
                        <td style="width:0px;height:22px;"></td>
                        <td></td>
                        <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs12FE94AA" colspan="6" style="width:351px;height:22px;line-height:15px;text-align:left;vertical-align:top;"><nobr>Nom&nbsp;du&nbsp;Centre&nbsp;ou&nbsp;H&#244;pital&#160;:&nbsp;&nbsp;'.$fonction_medecin.'</nobr></td>
                        <td class="cs388CADE" style="width:10px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="cs8339304C" style="width:6px;height:22px;"><!--[if lte IE 7]><div class="csF7D3565D"></div><![endif]--></td>
                        <td class="csFFC1C457" colspan="4" style="width:269px;height:22px;line-height:13px;text-align:left;vertical-align:top;"><nobr>Date&nbsp;et&nbsp;Heure&nbsp;de&nbsp;Pr&#233;l&#232;vement&#160;:&nbsp;'.$date_prelement.'</nobr></td>
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
                        <td class="cs58AC6944" colspan="5" style="width:290px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Examen</nobr></td>
                        <td class="cs36E0C1B8" colspan="9" style="width:384px;height:22px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Cat&#233;gorie&nbsp;-&nbsp;Groupe</nobr></td>
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
        "tdetailconsultation.created_at","tdetailconsultation.updated_at","ttypeconsultation.designation as TypeConsultation",'refDetailTriage','refMedecin','dateConsultation',"tenteteconsulter.author",
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
        "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale2",
        "tdetaillabo.observation as observation2","tdetaillabo.libelle as resultat2","tdetaillabo.natureechantillon as natureechantillon2",
        "tdetaillabo.methode as methode2","tdetaillabo.commentaire as commentaire2","tvaleurnormale.unite as unite2")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->Where('id',$id) 
        ->get();

        $output='';

        foreach ($data as $row) 
        {

            $output .='<tr style="vertical-align:top;">
            <td style="width:0px;height:24px;"></td>
            <td></td>
            <td class="csFBCBEF30" colspan="5" style="width:290px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->designationEx.'</nobr></td>
            <td class="csDC7EEB9" colspan="9" style="width:384px;height:22px;line-height:13px;text-align:center;vertical-align:middle;"><nobr>'.$row->designationGCatEx.' - '.$row->designationCatEx.'</nobr></td>
        </tr>';          
        }

        return $output;

    }
    

    
    function printDataList($date1, $date2)
    {

        $data = DB::table('tdetaillabo')
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
        ->select("tdetaillabo.id",'refDetailCons',"tentetelabo.refExamen","dateLabo", "tdetaillabo.author"
        ,"tdetaillabo.created_at", "tdetaillabo.updated_at","refEntetePrelevement","serviceProvenance",
        'statutentetelabo','refService','dateprelevement','numroRecu','MedecinDemandeur',"statutprelevement","preleveur",
        'refDepartement','nom_uniteproduction','code_uniteproduction','nom_departement','code_departement',      
        
        "texamen.designation as designationEx","refCatexamen",
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
        "refMouvement","dateTriage","refMalade","refTypeMouvement","dateMouvement","numroBon",
        "Statut","dateSortieMvt","motifSortieMvt","autoriseSortieMvt",
        "ttypemouvement_malade.designation as Typemouvement","noms","contact",
        "mail","refAvenue","refCategieClient","tcategorieclient.designation as Categorie","tclient.photo","tclient.slug","nomAvenue",
        "idCommune","nomQuartier","idQuartier","idVille","nomCommune","idProvince","nomVille","idPays","nomProvince",
        "nomPays","sexe_malade","dateNaissance_malade","etatcivil_malade",
        "numeroMaison_malade","fonction_malade",'groupesanguin',"personneRef_malade","fonctioPersRef_malade",
        "contactPersRef_malade","organisation_malade","numeroCarte_malade",
        "dateExpiration_malade","PrixCons","tvaleurnormale.designation as ValeurNormale",
        "tdetaillabo.observation as observation","tdetaillabo.libelle as resultat","tdetaillabo.natureechantillon as natureechantillon",
        "tdetaillabo.methode as methode","tdetaillabo.libelle as libelle","tdetaillabo.commentaire as commentaire","tvaleurnormale.unite as unite")
        ->selectRaw('TIMESTAMPDIFF(YEAR, dateNaissance_malade, CURDATE()) as age_malade')
        ->whereBetween('created_at', array($date1,$date2))        
        ->orderBy("id", "desc")->get();

            $output='';
            $output.='
            <div style="border:1px solid black;padding:0px;">
             <h3 align="center" style="color:blue;">CENTRE DE DÉPISTAGE LE MAGNOLIA <br/> RAPPORT DU LABORATOIRE DU '.$this->CreatedAt($date1).' JUSQU\'AU '.$this->CreatedAt($date2).' <br/> </h3>
            
               <br/><br/>
            <table align="center" cellpadding="7" cellspacing="0" border="1" width="99%">
              <tr style="font-weight:bold; background:#ccc;" >
                <td colspan="1">N°</td>
                <td colspan="1">Avatar</td>
                <td colspan="1">NON PATIENT</td>
                <td colspan="1">SEXE</td>
                <td colspan="1">AGE</td>
                <td colspan="1">MEDECIN.D</td>
                <td colspan="1">EXAMEN</td>
                <td colspan="1">CATEGORIE</td>
                <td colspan="1">TUBE</td>
                <td colspan="1">RESULTAT</td>
                
              </tr>';

            

            $count=0;
            foreach ($data as $row) {
                $count ++;
                $pic = $this->displayImg("fichier", $row->photo);
                 // code...
                $output .=' 
                <tr>
                    <td colspan="1">'.$count.'</td>
                    <td>
                        <img src="'.$pic.'"  width="75" />
                    </td>
                    <td colspan="1">'.$row->noms.'</td>
                    <td colspan="1">'.$row->sexe_malade.'</td>
                    <td colspan="1">'.$row->age_malade.'</td>
                    <td colspan="1">'.$row->noms_medecin.' </td>
                    <td colspan="1">'.$row->designationEx.' </td>
                    <td colspan="1">'.$row->designationCatEx.' - '.$row->designationGCatEx.' $</td>
                    <td colspan="1">'.$row->designationTube.' - '.$row->couleurTube.'</td>
                    <td colspan="1">'.$row->Valeurnormale.' - '.$row->detailValeur.'</td>
                    
                </tr>
                ';
            }



           

            $output.='</table>';

            $output .='
            <p>
            <br />
            </p>
                <p style="position:relative;left:500px;">

                  Fait à Goma le '.date('Y-m-d').'
                   <br>
               
                </p>

            <br /><br /></div>
            ';
           
            return $output; 

    }


    public function fetch_rapport_labo_date(Request $request)
    {
        //

        if ($request->get('date1') && $request->get('date2')) {
            // code...
            $date1 = $request->get('date1');
            $date2 = $request->get('date2');

            $html = $this->printDataList($date1, $date2);
            $pdf = \App::make('dompdf.wrapper');

            // echo($html);


            // $pdf->loadHTML($html);
            $pdf->loadHTML($html)->setPaper('a4', 'landscape');
            return $pdf->stream();            

        } else {
            // code...
        }
        
    }

    
}
