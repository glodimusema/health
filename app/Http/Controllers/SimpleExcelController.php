<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Spatie\SimpleExcel\SimpleExcelWriter;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\User;
use App\Traits\{GlobalMethod,Slug};
use DB;

class SimpleExcelController extends Controller
{
    //
    use GlobalMethod;

    // Exporter les données
    public function export (Request $request) {

    	// 1. Validation des informations du formulaire
    	// $this->validate($request, [ 
    	// 	'name' => 'bail|required|string',
    	// 	'extension' => 'bail|required|string|in:xlsx,csv'
    	// ]);

    	// 2. Le nom du fichier avec l'extension : .xlsx ou .csv
    	// $file_name = $request->name.".".$request->extension;
        $file_name = "FichierUser.xlsx";

    	// 3. On récupère données de la table "clients"
    	$clients = User::select("*")->get();

		// return response()->json([
		// 	'data'  => $clients,
		// ]);

    	// 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
    	$writer = SimpleExcelWriter::streamDownload($file_name);

 		// 5. On insère toutes les lignes au fichier Excel $file_name
    	$writer->addRows($clients->toArray());

        // 6. Lancer le téléchargement du fichier
        $writer->toBrowser();

    }



	public function ShowdetailfacturationAbonneeExcel(Request $request) {

		if ($request->get('date1') && $request->get('date2')&& $request->get('organisationAbonne')) {
			// code...
			$date1 = $request->get('date1');
			$date2 = $request->get('date2');
			$organisationAbonne = $request->get('organisationAbonne');
			
			// 2. Le nom du fichier avec l'extension : .xlsx ou .csv
			// $file_name = $request->name.".".$request->extension;
			// $file_name = "RapportAbonnee du ".$date1." au ".$date2." Pour ".$organisationAbonne.".xlsx";

			$file_name = "RapportAbonnee.xlsx";

			// 3. On récupère données de la table "clients"
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
			->select('noms as PATIENT','categoriemaladiemvt as CATEGORIE','organisationAbonne as ORGANISATION',
			'datefacture as DATE_FACTURE','nom_produit as ELEMENT','quantite as QTE','prixunitaire as PU_USD',
			DB::raw('(quantite*prixunitaire) as PT_USD'),
			DB::raw('ROUND((((quantite*prixunitaire)*taux_prisecharge)/100),0) as ORG_USD'),
			DB::raw('ROUND(((quantite*prixunitaire)-(((quantite*prixunitaire)*taux_prisecharge)/100)),0) as PATIENT_USD'),
			DB::raw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as FACTURE'))			
		   ->where([
			['datefacture','>=', $date1],
			['datefacture','<=', $date2],
			['organisationAbonne','=', $organisationAbonne],
			['categoriemaladiemvt','=', 'ABONNE(E)']
		   ])
		  ->orderBy("tfin_detailfacturation.created_at", "asc")
		  ->get();	
		  
		 $data = collect($data)->map(function($x){ return (array) $x; })->toArray(); 
		  
		// return response()->json([
		// 	'data'  => $data,
		// ]);
	
		// 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
		$writer = SimpleExcelWriter::streamDownload($file_name);

		// 5. On insère toutes les lignes au fichier Excel $file_name
		$writer->addRows($data);

		// 6. Lancer le téléchargement du fichier
		$writer->toBrowser();
			          
	
		} else {
			// code...
		}

 

    }


	public function ShowdetailfacturationPriveeExcel (Request $request) {

		if ($request->get('date1') && $request->get('date2')) {
			// code...
			$date1 = $request->get('date1');
			$date2 = $request->get('date2');
			
			// 2. Le nom du fichier avec l'extension : .xlsx ou .csv
			// $file_name = $request->name.".".$request->extension;
			//$file_name = "RapportPrivee du ".$date1." au ".$date2.".xlsx";
			$file_name = "RapportPrivee.xlsx";
			// 3. On récupère données de la table "clients"
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
			->select('noms as PATIENT','categoriemaladiemvt as CATEGORIE','organisationAbonne as ORGANISATION',
			'datefacture as DATE_FACTURE','nom_produit as ELEMENT','quantite as QTE','prixunitaire as PU_USD',
			DB::raw('(quantite*prixunitaire) as PT_USD'),
			DB::raw('CONCAT("F",YEAR(datefacture),"",MONTH(datefacture),"00",refEnteteFacturation) as FACTURE'))
			->where([
				['datefacture','>=', $date1],
				['datefacture','<=', $date2],
				['categoriemaladiemvt','=', 'PRIVE(E)']
			])
			->orderBy("tfin_detailfacturation.created_at", "asc")
			->get();

			$data = collect($data)->map(function($x){ return (array) $x; })->toArray(); 

			// 4. $writer : Objet Spatie\SimpleExcel\SimpleExcelWriter
			$writer = SimpleExcelWriter::streamDownload($file_name);

			// 5. On insère toutes les lignes au fichier Excel $file_name
			$writer->addRows($data);

			// 6. Lancer le téléchargement du fichier
			$writer->toBrowser();		          
		
			} 
			else {
				// code...
			}

 

    }


    


}
