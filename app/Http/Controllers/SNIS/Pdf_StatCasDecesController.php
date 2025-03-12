<?php
namespace App\Http\Controllers\SNIS;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\{GlobalMethod,Slug};
use DB;


class Pdf_StatCasDecesController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    use GlobalMethod,Slug;

    public function index()
    {
        return 'hello';
    }

    function Gquery($request)
    {
      return str_replace(" ", "%", $request->get('query'));
      // return $request->get('query');
    }

    //=================================================================================================================================
//==================== FICHE DE STOCK ========================================================================================================



function pdf_stat_snis(Request $request)
{

    if ($request->get('date1') && $request->get('date2')) {
        // code...
        $date1 = $request->get('date1');
        $date2 = $request->get('date2');
        
        $html = $this->getInfoSNIS($date1,$date2);
        $pdf = \App::make('dompdf.wrapper');

        $pdf->loadHTML($html);
        $pdf->loadHTML($html)->setPaper('a4', 'landscape');
        return $pdf->stream();
        
    }
    else{
    }    
}

function getInfoSNIS($date1,$date2)
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
   
               // 
            $total28Jours=0; 
            $total11Mois=0;  
            $total39Mois=0;
            $total5Ans=0;
            $total15Ans=0;


            // 

            $data3 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total28Jours'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_jourmvt','>=', 3],
                ['tmouvement.age_jourmvt','<=', 28]                
            ])               
            ->get();

            foreach ($data3 as $row3) 
            {                                
               $total28Jours=$row3->total28Jours;                           
            }


            $data4 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total11Mois'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_moismvt','>=', 0],
                ['tmouvement.age_moismvt','<=', 11]                
            ])              
            ->get();

            foreach ($data4 as $row4) 
            {                                
               $total11Mois=$row4->total11Mois;                           
            }


            $data5 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total39Mois'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_moismvt','>=', 12],
                ['tmouvement.age_moismvt','<=', 39]                
            ])              
            ->get();

            foreach ($data5 as $row5) 
            {                                
               $total39Mois=$row5->total39Mois;                           
            }


            $data6 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total5Ans'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.agemvt','>=', 5],
                ['tmouvement.agemvt','<=', 15]                
            ])              
            ->get();

            foreach ($data6 as $row6) 
            {                                
               $total5Ans=$row6->total5Ans;                        
            }


            $data7 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total15Ans'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.agemvt','>', 15]               
            ])              
            ->get();

            foreach ($data7 as $row7) 
            {                                
               $total15Ans=$row7->total15Ans;                        
            }



            $deces28Jours=0; 
            $deces11Mois=0;  
            $deces39Mois=0;
            $deces5Ans=0;
            $deces15Ans=0;


            $data33 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces28Jours'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_jourmvt','>=', 3],
                ['tmouvement.age_jourmvt','<=', 28],
                ['conclusion_maladie','=', 'Décés']                
            ])               
            ->get();

            foreach ($data33 as $row33) 
            {                                
               $deces28Jours=$row33->deces28Jours;                           
            }


            $data44 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces11Mois'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_moismvt','>=', 0],
                ['tmouvement.age_moismvt','<=', 11],
                ['conclusion_maladie','=', 'Décés']                
            ])              
            ->get();

            foreach ($data44 as $row44) 
            {                                
               $deces11Mois=$row44->deces11Mois;                           
            }


            $data55 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces39Mois'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.age_moismvt','>=', 12],
                ['tmouvement.age_moismvt','<=', 39],
                ['conclusion_maladie','=', 'Décés']                
            ])              
            ->get();

            foreach ($data55 as $row55) 
            {                                
               $deces39Mois=$row55->deces39Mois;                           
            }


            $data66 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces5Ans'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.agemvt','>=', 5],
                ['tmouvement.agemvt','<=', 15],
                ['conclusion_maladie','=', 'Décés']                
            ])              
            ->get();

            foreach ($data66 as $row66) 
            {                                
               $deces5Ans=$row66->deces5Ans;                        
            }


            $data77 = DB::table('tdiagnosticdefinitif')
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
            ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces15Ans'))
            ->where([
                ['tdetailconsultation.created_at','>=', $date1],
                ['tdetailconsultation.created_at','<=', $date2],
                ['tmouvement.agemvt','>', 15],
                ['conclusion_maladie','=', 'Décés']               
            ])              
            ->get();

            foreach ($data77 as $row77) 
            {                                
               $deces15Ans=$row77->deces15Ans;                        
            }




            $infoss="'information";




    
            $output=' 

            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <!-- saved from url=(0016)http://localhost -->
            <html>
            <head>
                <title>rpt_StatCasDeces</title>
                <meta HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8"/>
                <style type="text/css">
                    .cs3E8B39A7 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csC224BBBC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;}
                    .cs8F9A46BC {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:10px; font-weight:normal; font-style:normal; padding-left:2px;padding-right:2px;}
                    .cs9B633122 {color:#000000;background-color:transparent;border-left:#000000 1px solid;border-top:#000000 1px solid;border-right:#000000 1px solid;border-bottom:#000000 1px solid;font-family:Times New Roman; font-size:13px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csE9F2AA97 {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:16px; font-weight:bold; font-style:normal; padding-left:2px;padding-right:2px;}
                    .csFBB219FE {color:#000000;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Times New Roman; font-size:18px; font-weight:bold; font-style:normal; padding-left:2px;}
                    .cs739196BC {color:#5C5C5C;background-color:transparent;border-left-style: none;border-top-style: none;border-right-style: none;border-bottom-style: none;font-family:Segoe UI; font-size:11px; font-weight:normal; font-style:normal; }
                    .csF7D3565D {height:0px;width:0px;overflow:hidden;font-size:0px;line-height:0px;}
                </style>
            </head>
            <body leftMargin=10 topMargin=10 rightMargin=10 bottomMargin=10 style="background-color:#FFFFFF">
            <table cellpadding="0" cellspacing="0" border="0" style="border-width:0px;empty-cells:show;width:873px;height:182px;position:relative;">
                <tr>
                    <td style="width:0px;height:0px;"></td>
                    <td style="height:0px;width:48px;"></td>
                    <td style="height:0px;width:309px;"></td>
                    <td style="height:0px;width:18px;"></td>
                    <td style="height:0px;width:34px;"></td>
                    <td style="height:0px;width:33px;"></td>
                    <td style="height:0px;width:47px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:21px;"></td>
                    <td style="height:0px;width:30px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:45px;"></td>
                    <td style="height:0px;width:51px;"></td>
                    <td style="height:0px;width:45px;"></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:23px;"></td>
                    <td class="cs739196BC" colspan="4" style="width:409px;height:23px;line-height:14px;text-align:center;vertical-align:middle;"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
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
                    <td style="width:0px;height:23px;"></td>
                    <td></td>
                    <td></td>
                    <td class="csFBB219FE" colspan="7" style="width:247px;height:23px;line-height:21px;text-align:left;vertical-align:top;"><nobr>1.&nbsp;Notification&nbsp;des&nbsp;cas&nbsp;et&nbsp;D&#233;c&#233;s</nobr></td>
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
                    <td class="csE9F2AA97" colspan="14" style="width:821px;height:22px;line-height:18px;text-align:center;vertical-align:top;"><nobr>Syst&#232;me&nbsp;National&nbsp;d'.$infoss.'&nbsp;Sanitaire/Surveillance&nbsp;int&#233;g&#233;e&nbsp;des&nbsp;maladies</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:22px;"></td>
                    <td></td>
                    <td class="csE9F2AA97" colspan="14" style="width:821px;height:22px;line-height:18px;text-align:center;vertical-align:top;"><nobr>R&#233;l&#233;v&#233;&nbsp;Epid&#233;miologique&nbsp;Hebdomadaire (Du '.$date1.' au '.$date2.')</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:21px;"></td>
                    <td></td>
                    <td class="cs9B633122" colspan="2" rowspan="2" style="width:321px;height:39px;line-height:15px;text-align:center;vertical-align:middle;"><nobr>Maladies</nobr></td>
                    <td class="cs9B633122" colspan="3" style="width:108px;height:19px;line-height:15px;text-align:center;vertical-align:top;"><nobr>3&nbsp;&#224;&nbsp;28&nbsp;jours</nobr></td>
                    <td class="cs9B633122" colspan="2" style="width:90px;height:19px;line-height:15px;text-align:center;vertical-align:top;"><nobr>0&nbsp;-&nbsp;11&nbsp;mois</nobr></td>
                    <td class="cs9B633122" colspan="3" style="width:90px;height:19px;line-height:15px;text-align:center;vertical-align:top;"><nobr>12&nbsp;-&nbsp;39&nbsp;mois</nobr></td>
                    <td class="cs9B633122" colspan="2" style="width:90px;height:19px;line-height:15px;text-align:center;vertical-align:top;"><nobr>5&nbsp;-&nbsp;15&nbsp;ans</nobr></td>
                    <td class="cs9B633122" colspan="2" style="width:90px;height:19px;line-height:15px;text-align:center;vertical-align:top;"><nobr>&gt;&nbsp;15&nbsp;ans</nobr></td>
                </tr>
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs9B633122" colspan="2" style="width:61px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Cas</nobr></td>
                    <td class="cs9B633122" style="width:41px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>D&#233;c&#233;s</nobr></td>
                    <td class="cs9B633122" style="width:45px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Cas</nobr></td>
                    <td class="cs9B633122" style="width:39px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>D&#233;c&#233;s</nobr></td>
                    <td class="cs9B633122" colspan="2" style="width:45px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Cas</nobr></td>
                    <td class="cs9B633122" style="width:39px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>D&#233;c&#233;s</nobr></td>
                    <td class="cs9B633122" style="width:45px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Cas</nobr></td>
                    <td class="cs9B633122" style="width:39px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>D&#233;c&#233;s</nobr></td>
                    <td class="cs9B633122" style="width:45px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>Cas</nobr></td>
                    <td class="cs9B633122" style="width:39px;height:18px;line-height:15px;text-align:center;vertical-align:top;"><nobr>D&#233;c&#233;s</nobr></td>
                </tr>
            ';
                                                                                                                
                                             $output .= $this->ShowDetailStatSNIS($date1,$date2); 
                                                                                                                
                                            $output.='
                <tr style="vertical-align:top;">
                    <td style="width:0px;height:20px;"></td>
                    <td></td>
                    <td class="cs3E8B39A7" colspan="2" style="width:321px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>TOTAL</nobr></td>
                    <td class="cs3E8B39A7" colspan="2" style="width:61px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total28Jours.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:41px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces28Jours.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:45px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total11Mois.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:39px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces11Mois.'</nobr></td>
                    <td class="cs3E8B39A7" colspan="2" style="width:45px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total39Mois.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:39px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces39Mois.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:45px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total5Ans.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:39px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces5Ans.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:45px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total15Ans.'</nobr></td>
                    <td class="cs3E8B39A7" style="width:39px;height:18px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces15Ans.'</nobr></td>
                </tr>
            </table>
            </body>
            </html>


            '; 

    return $output;

}  

function ShowDetailStatSNIS($date1,$date2)
{
    $data1 = DB::table('tconf_maladie')           
    ->join('tconf_categoriemaladie','tconf_categoriemaladie.id','=','tconf_maladie.refcategoriemaladie')        
    ->select("tconf_maladie.id","nom_maladie","refcategoriemaladie","nom_categoriemaladie",
    "tconf_maladie.created_at","tconf_maladie.author")
    ->orderBy("tconf_maladie.nom_maladie", "asc")
    ->get();

    $output='';

    foreach ($data1 as $row1) 
    {
        $total28Jours=0; 
        $total11Mois=0;  
        $total39Mois=0;
        $total5Ans=0;
        $total15Ans=0;   
        
        // ['texamen.id','=', $row1->id]


        $data3 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total28Jours'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_jourmvt','>=', 3],
            ['tmouvement.age_jourmvt','<=', 28],
            ['tconf_maladie.id','=', $row1->id]                
        ])               
        ->get();

        foreach ($data3 as $row3) 
        {                                
           $total28Jours=$row3->total28Jours;                           
        }


        $data4 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total11Mois'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_moismvt','>=', 0],
            ['tmouvement.age_moismvt','<=', 11],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data4 as $row4) 
        {                                
           $total11Mois=$row4->total11Mois;                           
        }


        $data5 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total39Mois'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_moismvt','>=', 12],
            ['tmouvement.age_moismvt','<=', 39],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data5 as $row5) 
        {                                
           $total39Mois=$row5->total39Mois;                           
        }


        $data6 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total5Ans'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.agemvt','>=', 5],
            ['tmouvement.agemvt','<=', 15],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data6 as $row6) 
        {                                
           $total5Ans=$row6->total5Ans;                        
        }


        $data7 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as total15Ans'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.agemvt','>', 15],
            ['tconf_maladie.id','=', $row1->id]               
        ])              
        ->get();

        foreach ($data7 as $row7) 
        {                                
           $total15Ans=$row7->total15Ans;                        
        }


        $deces28Jours=0; 
        $deces11Mois=0;  
        $deces39Mois=0;
        $deces5Ans=0;
        $deces15Ans=0;


        $data33 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces28Jours'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_jourmvt','>=', 3],
            ['tmouvement.age_jourmvt','<=', 28],
            ['conclusion_maladie','=', 'Décés'],
            ['tconf_maladie.id','=', $row1->id]                
        ])               
        ->get();

        foreach ($data33 as $row33) 
        {                                
           $deces28Jours=$row33->deces28Jours;                           
        }


        $data44 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces11Mois'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_moismvt','>=', 0],
            ['tmouvement.age_moismvt','<=', 11],
            ['conclusion_maladie','=', 'Décés'],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data44 as $row44) 
        {                                
           $deces11Mois=$row44->deces11Mois;                           
        }


        $data55 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces39Mois'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.age_moismvt','>=', 12],
            ['tmouvement.age_moismvt','<=', 39],
            ['conclusion_maladie','=', 'Décés'],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data55 as $row55) 
        {                                
           $deces39Mois=$row55->deces39Mois;                           
        }


        $data66 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces5Ans'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.agemvt','>=', 5],
            ['tmouvement.agemvt','<=', 15],
            ['conclusion_maladie','=', 'Décés'],
            ['tconf_maladie.id','=', $row1->id]                
        ])              
        ->get();

        foreach ($data66 as $row66) 
        {                                
           $deces5Ans=$row66->deces5Ans;                        
        }


        $data77 = DB::table('tdiagnosticdefinitif')
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
        ->select(DB::raw('ROUND(COUNT(tdiagnosticdefinitif.id),0) as deces15Ans'))
        ->where([
            ['tdetailconsultation.created_at','>=', $date1],
            ['tdetailconsultation.created_at','<=', $date2],
            ['tmouvement.agemvt','>', 15],
            ['conclusion_maladie','=', 'Décés'],
            ['tconf_maladie.id','=', $row1->id]               
        ])              
        ->get();

        foreach ($data77 as $row77) 
        {                                
           $deces15Ans=$row77->deces15Ans;                        
        }

        $output .='
        <tr style="vertical-align:top;">
            <td style="width:0px;height:21px;"></td>
            <td></td>
            <td class="csC224BBBC" colspan="2" style="width:323px;height:19px;line-height:11px;text-align:left;vertical-align:middle;">'.$row1->nom_maladie.'</td>
            <td class="cs8F9A46BC" colspan="2" style="width:61px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total28Jours.'</nobr></td>
            <td class="cs8F9A46BC" style="width:41px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces28Jours.'</nobr></td>
            <td class="cs8F9A46BC" style="width:45px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total11Mois.'</nobr></td>
            <td class="cs8F9A46BC" style="width:39px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces11Mois.'</nobr></td>
            <td class="cs8F9A46BC" colspan="2" style="width:45px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total39Mois.'</nobr></td>
            <td class="cs8F9A46BC" style="width:39px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces39Mois.'</nobr></td>
            <td class="cs8F9A46BC" style="width:45px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total5Ans.'</nobr></td>
            <td class="cs8F9A46BC" style="width:39px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces5Ans.'</nobr></td>
            <td class="cs8F9A46BC" style="width:45px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$total15Ans.'</nobr></td>
            <td class="cs8F9A46BC" style="width:39px;height:19px;line-height:11px;text-align:center;vertical-align:middle;"><nobr>'.$deces15Ans.'</nobr></td>
        </tr>
        ';      
    
    }

    return $output;

}

    

    
}
