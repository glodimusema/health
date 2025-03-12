<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\PersonneController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PaysController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\VilleController;
use App\Http\Controllers\CommuneController;
use App\Http\Controllers\QuartierController;
use App\Http\Controllers\AvenueController;
use App\Http\Controllers\AffetctationsController;
use App\Http\Controllers\tclientController;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// use App\Http\Controllers\PdfLogistiqueController;
use App\Http\Controllers\categorieclientController;
use App\Http\Controllers\telementproduitController;
use App\Http\Controllers\tDetailProduitController;

use App\Http\Controllers\Logistique\tcategorieproduitController;
use App\Http\Controllers\Logistique\tproduitController;

use App\Http\Controllers\SNIS\Pdf_StatExamenLaboController;
use App\Http\Controllers\SNIS\Pdf_StatCasDecesController;

use App\Http\Controllers\Logistique\tlog_entete_sortieController;
use App\Http\Controllers\Logistique\tlog_entete_requisitionController;
use App\Http\Controllers\Logistique\tlog_entete_entreeController;
use App\Http\Controllers\Logistique\tlog_detail_sortieController;
use App\Http\Controllers\Logistique\tlog_detail_requisitionController;
use App\Http\Controllers\Logistique\tlog_detail_entreeController;
use App\Http\Controllers\Logistique\PdfLogistiqueController;

//tfournisseurController

use App\Http\Controllers\Pharmacie\tfournisseurController;
use App\Http\Controllers\Pharmacie\tenteteentreeController;
use App\Http\Controllers\Pharmacie\tenteteventeController;
use App\Http\Controllers\Pharmacie\tentetesortieController;
use App\Http\Controllers\Pharmacie\tdetailentreeController;
use App\Http\Controllers\Pharmacie\tdetailventeController;
use App\Http\Controllers\Pharmacie\tdetailsortieController;


use App\Http\Controllers\Pharmacie\tmed_detail_usageserviceController;
use App\Http\Controllers\Pharmacie\tmed_detailbesoinController;
use App\Http\Controllers\Pharmacie\tmed_entete_usageserviceController;
use App\Http\Controllers\Pharmacie\tmed_entetebesoinController;

use App\Http\Controllers\Pharmacie\PdfVenteMedicamentController;
use App\Http\Controllers\Pharmacie\PdfSortieMedicamentController;
use App\Http\Controllers\Pharmacie\Pdf_FicheStockMedicamentController;

use App\Http\Controllers\Pharmacie\Pdf_FicheStockServiceController;

// use App\Http\Controllers\Phamarcie\Pdf_SortieMedicamentController;
// use App\Http\Controllers\Phamarcie\Pdf_VenteMedicamentController;

use App\Http\Controllers\tpaiementventeController;
use App\Http\Controllers\tCategorieSouscriptionController;
use App\Http\Controllers\tentetesouscriptionController;
use App\Http\Controllers\tdetailsouscriptionController;

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Role\RoleController;
use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\MakePdfController;
use App\Http\Controllers\FacturePdfController;
use App\Http\Controllers\FactureSousPdfController;
use App\Http\Controllers\Galery\GaleryController;
use App\Http\Controllers\Video\VideoController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\FormeJuridiqueController;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\BonEntreePdfController;
use App\Http\Controllers\RecuPdfController;
use App\Http\Controllers\Attestation\Pdf_AttestationsController;
use App\Http\Controllers\Attestation\Pdf_TransfertController;
use App\Http\Controllers\Attestation\Pdf_DossierMedicalController;
use App\Http\Controllers\Attestation\Pdf_OrdonancesController;
use App\Http\Controllers\Attestation\Pdf_BesoinServicesController;
use App\Http\Controllers\RecouvrementController;
use App\Http\Controllers\RecouvrementPdfController;
use App\Http\Controllers\tcompteController;
use App\Http\Controllers\tdepenseController;
use App\Http\Controllers\ttypemouvementController;
use App\Http\Controllers\BonSortieCaissePdfController;
use App\Http\Controllers\BonEntreeCaissePdfController;

use App\Http\Controllers\ttypemouvementMaladeController;
use App\Http\Controllers\tentetetriageController;
use App\Http\Controllers\tmouvementController;
use App\Http\Controllers\tdetailtriageController;
use App\Http\Controllers\Consultations\tdetailconsultationController;
use App\Http\Controllers\Consultations\tenteteconsulterController;
use App\Http\Controllers\Consultations\ttypeconsultationController;

use App\Http\Controllers\Laboratoire\tcategorieexamenController;
use App\Http\Controllers\Laboratoire\Pdf_SpermogrammeController;
use App\Http\Controllers\Laboratoire\StatistiquePatientPdfController;
//StatistiquePatientPdfController
use App\Http\Controllers\Laboratoire\tdetaillaboController;
use App\Http\Controllers\Laboratoire\tentetelaboController;
use App\Http\Controllers\Laboratoire\tlabo_annexeController;
use App\Http\Controllers\Laboratoire\texamenController;
use App\Http\Controllers\Laboratoire\tgcategorieexamenController;
use App\Http\Controllers\Laboratoire\tvaleurnormaleController;
use App\Http\Controllers\Laboratoire\tdetaillaboextController;
use App\Http\Controllers\Laboratoire\tentetelaboextController;
use App\Http\Controllers\Laboratoire\ttubeexamenController;
use App\Http\Controllers\Laboratoire\natureechantillonController;
use App\Http\Controllers\Laboratoire\methodeexamenController;
use App\Http\Controllers\Laboratoire\unitevaleurController;
use App\Http\Controllers\Laboratoire\categorievaleurController;

use App\Http\Controllers\Laboratoire\tlabo_categorie_echantillonController;
use App\Http\Controllers\Laboratoire\tlabo_examencoloreController;
use App\Http\Controllers\Laboratoire\tlabo_germeController;
use App\Http\Controllers\Laboratoire\tlabo_nature_echantillonController;
use App\Http\Controllers\Laboratoire\tlabo_detail_examencoloreController;
use App\Http\Controllers\Laboratoire\tlabo_detail_germeController;
use App\Http\Controllers\Laboratoire\tlabo_detail_prelevementController;
use App\Http\Controllers\Laboratoire\tlabo_entete_prelevementController;
use App\Http\Controllers\Laboratoire\tlabo_resultat_bacteriologieController;
use App\Http\Controllers\Laboratoire\tlabo_resultat_spermeController;

//tlabo_examencoloreController
use App\Http\Controllers\Medecins\tmedecinController;
use App\Http\Controllers\Medecins\tfonctionmedecinController;
use App\Http\Controllers\Medecins\tcategoriemedecinController;
use App\Http\Controllers\Medecins\tservicehopitalController;

use App\Http\Controllers\Parametres\SwotController;
use App\Http\Controllers\Laboratoire\BonExamensPdfController;

//Pdf_EnteteFactureController
use App\Http\Controllers\Finances\fraisController;
use App\Http\Controllers\Finances\modepaieController;
use App\Http\Controllers\Finances\typetarificationController;
use App\Http\Controllers\Finances\tentetepaieController;
use App\Http\Controllers\Finances\tdetailpaieController;
use App\Http\Controllers\Finances\Pdf_EnteteFactureController;


use App\Http\Controllers\Rendezvous\agendamedecinController;
//taffectationabonneController torganisationController
use App\Http\Controllers\Parametres\tcategoriemaladieController;

use App\Http\Controllers\Parametres\tconf_list_menuController;
use App\Http\Controllers\Parametres\tconf_affectation_menuController;
use App\Http\Controllers\Parametres\tconf_crud_accessController;

use App\Http\Controllers\Parametres\tcategoriemedicamentController;
use App\Http\Controllers\Parametres\tdetailmedicamentController;
use App\Http\Controllers\Parametres\tmaladieController;
use App\Http\Controllers\Parametres\tmedicamentController;
use App\Http\Controllers\Parametres\taffectationabonneController;
use App\Http\Controllers\Parametres\torganisationController;

use App\Http\Controllers\Consultations\tprescriptionmedicamentController;
use App\Http\Controllers\Consultations\tdiagnosticdefinitifController;
use App\Http\Controllers\Consultations\tmaladiechroniqueController;


use App\Http\Controllers\Hospitalisation\tdetailplansoinController;
use App\Http\Controllers\Hospitalisation\tdetailsortiehospitaliserController;
use App\Http\Controllers\Hospitalisation\thospitalisationController;
use App\Http\Controllers\Hospitalisation\tlitController;
use App\Http\Controllers\Hospitalisation\tplansoinController;
use App\Http\Controllers\Hospitalisation\tsalleController;
use App\Http\Controllers\Hospitalisation\tservicehospiController;
use App\Http\Controllers\Hospitalisation\tservicesoinController;
use App\Http\Controllers\Hospitalisation\tsoinhospitaliserController;
use App\Http\Controllers\Hospitalisation\tsortiehospitaliserController;
use App\Http\Controllers\Hospitalisation\tsuivihospitaliserController;
use App\Http\Controllers\Hospitalisation\ttraitementhospitaliserController;
//tconspresanesthesieController
use App\Http\Controllers\Chirurgie\ttypeanesthesieController;
use App\Http\Controllers\Chirurgie\trubriquesurveillanceController;
use App\Http\Controllers\Chirurgie\tinterventionController;
use App\Http\Controllers\Chirurgie\tentetesurveillanceController;
use App\Http\Controllers\Chirurgie\tenteteoperationController;
use App\Http\Controllers\Chirurgie\tenteteevaluationController;
use App\Http\Controllers\Chirurgie\tenteteconsomationopeController;
use App\Http\Controllers\Chirurgie\tenteteanesthesieController;
use App\Http\Controllers\Chirurgie\tconspresanesthesieController;
use App\Http\Controllers\Chirurgie\tdetailsurveillanceController;
use App\Http\Controllers\Chirurgie\tdetailoperationController;
use App\Http\Controllers\Chirurgie\tdetailevaluationController;
use App\Http\Controllers\Chirurgie\tdetailconsomationopeController;
use App\Http\Controllers\Chirurgie\tdetailconsoacteopeController;
use App\Http\Controllers\Chirurgie\tdepartementController;
use App\Http\Controllers\Chirurgie\tconsentementController;
use App\Http\Controllers\Chirurgie\taffectationoperationController;
use App\Http\Controllers\Chirurgie\taffectationanesthesieController;
use App\Http\Controllers\Chirurgie\tacteoperatoireController;
use App\Http\Controllers\Chirurgie\tdetailanesthesieController;

use App\Http\Controllers\Consultations\tactemedecinController;
use App\Http\Controllers\Consultations\tacteposemedecinController;
use App\Http\Controllers\Consultations\torientationconsController;
use App\Http\Controllers\Consultations\tresumecliniqueController;
use App\Http\Controllers\Consultations\tcons_retroinformationController;
use App\Http\Controllers\Consultations\tcons_transfertController;
use App\Http\Controllers\Consultations\tpatient_annexesController;

//tcons_retroinformationController

use App\Http\Controllers\Finances\tclasseController;
use App\Http\Controllers\Finances\tfin_cloture_comptabiliteController;
use App\Http\Controllers\Finances\tcomptefinController;
use App\Http\Controllers\Finances\tdepartementfinController;
use App\Http\Controllers\Finances\tdetailfacturationController;
use App\Http\Controllers\Finances\tentetefacturationController;
use App\Http\Controllers\Finances\tpaiefacturationController;
use App\Http\Controllers\Finances\tproduitfinController;
use App\Http\Controllers\Finances\tsouscomptefinController;
use App\Http\Controllers\Finances\tssouscomptefinController;
use App\Http\Controllers\Finances\ttypecompteController;
use App\Http\Controllers\Finances\ttypeoperationController;
use App\Http\Controllers\Finances\ttypepositionController;
use App\Http\Controllers\Finances\ttypeproduitController;
use App\Http\Controllers\Finances\tuniteproductionController;
use App\Http\Controllers\Finances\ttauxController;
use App\Http\Controllers\Finances\Pdf_DetailFactureController;
use App\Http\Controllers\Finances\Pdf_PaiementFactureController;
use App\Http\Controllers\Finances\Pdf_DetailFactureAbonneController;
use App\Http\Controllers\Finances\Pdf_ComptabiliteController;
use App\Http\Controllers\Finances\Pdf_EnteteFactureAbonneController;
use App\Http\Controllers\Finances\Pdf_FactureAbonneController;
use App\Http\Controllers\Finances\Pdf_FacturePriveeController;
use App\Http\Controllers\Finances\Pdf_FactureGroupePriveeController;
use App\Http\Controllers\Finances\Pdf_FactureAbonneGroupeController;
use App\Http\Controllers\Finances\tcloturecaisseController;
use App\Http\Controllers\Finances\Pdf_DetailFacturePriveeController;
use App\Http\Controllers\Finances\Pdf_EnteteFacturePriveeController;
use App\Http\Controllers\Finances\Pdf_PaiementFacturePriveeController;
use App\Http\Controllers\Finances\Pdf_PaiementFactureAbonneController;
use App\Http\Controllers\Finances\Pdf_BonEngagementController;
use App\Http\Controllers\Finances\tfin_categorie_societeController;
use App\Http\Controllers\Finances\tfin_entete_operationcompteController;
use App\Http\Controllers\Finances\tfin_detail_operationcompteController;

//------------------------IMAGERIE-------------------------------
use App\Http\Controllers\Imagerie\tanalyseController;
use App\Http\Controllers\Imagerie\Pdf_CardiologieController;
use App\Http\Controllers\Imagerie\Pdf_CardiologieExtController;
use App\Http\Controllers\Imagerie\tcardiologieController;
use App\Http\Controllers\Imagerie\tendoscopieController;
use App\Http\Controllers\Imagerie\timagerieController;
use App\Http\Controllers\Imagerie\ttypeanalyseController;
use App\Http\Controllers\Imagerie\tresultatimagerieController;
use App\Http\Controllers\Imagerie\timagerieextController;
use App\Http\Controllers\Imagerie\tendoscopieextController;
use App\Http\Controllers\Imagerie\tcardiologieextController;
use App\Http\Controllers\Imagerie\tresultatimagerieextController;
//----------------------DYALISE---------------------
use App\Http\Controllers\Dyalise\tdyal_categorie_vaccinController;
use App\Http\Controllers\Dyalise\tdyal_detail_ophtamologieController;
use App\Http\Controllers\Dyalise\tdyal_detail_surv_dyalController;
use App\Http\Controllers\Dyalise\tdyal_entetedyaliseController;
use App\Http\Controllers\Dyalise\tdyal_surveillance_dyaliseController;
use App\Http\Controllers\Dyalise\tdyal_typemarchineController;
use App\Http\Controllers\Dyalise\tdyal_vaccinationdyaliseController;
use App\Http\Controllers\Dyalise\tdyal_vaccindyaliseController;
use App\Http\Controllers\Dyalise\tdyal_dosecathetereController;

//--------------------REANIMATION----------------------
use App\Http\Controllers\Reanimation\trea_entete_reaController;
use App\Http\Controllers\Reanimation\trea_evolution_reaController;
use App\Http\Controllers\Reanimation\trea_observation_reaController;
use App\Http\Controllers\Reanimation\trea_surveillance_reaController;
use App\Http\Controllers\Reanimation\trea_traitementController;

//------------------HOSPITALISATION--------------------
use App\Http\Controllers\Hospitalisation\thospi_acte_infirmierController;
use App\Http\Controllers\Hospitalisation\thospi_actesmdecinController;
use App\Http\Controllers\Hospitalisation\thospi_appreciation_infirmierController;
use App\Http\Controllers\Hospitalisation\thospi_bilan_hydriqueController;
use App\Http\Controllers\Hospitalisation\thospi_detail_acteController;
use App\Http\Controllers\Hospitalisation\thospi_detail_bilan_hydriqueController;
use App\Http\Controllers\Hospitalisation\thospi_detail_surveillance_plaieController;
use App\Http\Controllers\Hospitalisation\thospi_detail_traitementController;
use App\Http\Controllers\Hospitalisation\thospi_diabetiquee_hospiController;
use App\Http\Controllers\Hospitalisation\thospi_observation_infirmierController;
use App\Http\Controllers\Hospitalisation\thospi_service_hospiController;
use App\Http\Controllers\Hospitalisation\thospi_signe_vitaux_surveilController;
use App\Http\Controllers\Hospitalisation\thospi_surveil_neonatologieController;
use App\Http\Controllers\Hospitalisation\thospi_surveillance_hospieController;
use App\Http\Controllers\Hospitalisation\thospi_transfusion_surveilController;
use App\Http\Controllers\Hospitalisation\thospi_type_plaieController;
use App\Http\Controllers\Hospitalisation\thospi_surveillance_plaieController;
use App\Http\Controllers\Hospitalisation\thospi_traitement_hospiController;


use App\Http\Controllers\Consultations\tcons_neonatologieController;
use App\Http\Controllers\Consultations\kinesiterapieController;
use App\Http\Controllers\Consultations\trapportmedicalController;
use App\Http\Controllers\Consultations\tcons_entete_ordonanceController;
use App\Http\Controllers\Consultations\tcons_detail_ordonanceController;

use App\Http\Controllers\Parametres\tbanqueController;
use App\Http\Controllers\tresorerie\tt_treso_blocController;
use App\Http\Controllers\tresorerie\tt_treso_categorie_rubriqueController;
use App\Http\Controllers\tresorerie\tt_treso_detail_angagementController;
use App\Http\Controllers\tresorerie\tt_treso_detail_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_entete_etatbesoinController;
use App\Http\Controllers\tresorerie\tt_treso_provenanceController;
use App\Http\Controllers\tresorerie\tt_treso_rubriqueController;
use App\Http\Controllers\tresorerie\ttreso_entete_angagementController;

use App\Http\Controllers\Attestation\tt_attest_aptitude_physiqueController;
use App\Http\Controllers\Attestation\tt_attest_certificat_decesController;
use App\Http\Controllers\Attestation\tt_attest_certificat_medicalController;
use App\Http\Controllers\Attestation\tt_attest_entete_attestationController;
use App\Http\Controllers\Attestation\CartePdfController;


//--------------------MATERNITE----------------------------------
use App\Http\Controllers\Maternite\partogrammeController;
use App\Http\Controllers\Maternite\tmat_surveillance_femmeController;
use App\Http\Controllers\Maternite\tmat_detail_affectionController;
use App\Http\Controllers\Maternite\tmat_surveillance_phaseController;
use App\Http\Controllers\Maternite\tmatapgarController;

//=====================MERE============= t_mere_periode_cpnController
use App\Http\Controllers\Mere\t_mere_consultation_prenataleController;
use App\Http\Controllers\Mere\t_mere_element_referenceController;
use App\Http\Controllers\Mere\t_mere_detailcpnController;
use App\Http\Controllers\Mere\t_mere_periode_cponController;
use App\Http\Controllers\Mere\t_mere_periode_spController;
use App\Http\Controllers\Mere\t_mere_periode_cpnController;
use App\Http\Controllers\Mere\t_mere_periode_vacciniereController;
use App\Http\Controllers\Mere\t_mere_rendez_vous_vac_mereController;
use App\Http\Controllers\Mere\t_mere_sp_mereController;
use App\Http\Controllers\Mere\t_mere_vaccination_mereController;
use App\Http\Controllers\Mere\t_merecponController;

//==============ENFANT=======================================
use App\Http\Controllers\Enfant\t_enfant_mode_attente_enfantController;
use App\Http\Controllers\Enfant\t_enfant_periode_c_p_sController;
use App\Http\Controllers\Enfant\t_enfant_strategieController;
use App\Http\Controllers\Enfant\tenfant_categorieController;
use App\Http\Controllers\Enfant\tenfant_cpsController;
use App\Http\Controllers\Enfant\tenfant_entete_vaccinationController;
use App\Http\Controllers\Enfant\tenfant_periode_vac_enfantController;
use App\Http\Controllers\Enfant\tenfant_rendevous_enfantController;
use App\Http\Controllers\Enfant\tenfant_vaccination_enfantController;
use App\Http\Controllers\Enfant\tenfant_vaccinController;
//=================NEUROLOGIE==================================
use App\Http\Controllers\Neurologie\tneuro_annxeController;
use App\Http\Controllers\Neurologie\tnero_type_rapport;
use App\Http\Controllers\Neurologie\tnero_protocole_neurologieController;
use App\Http\Controllers\Neurologie\tnero_type_rapportController;
//------------------------IMAGERIE-------------- tnero_type_rapportController
// use App\Http\Controllers\Imagerie\tanalyseController;
// use App\Http\Controllers\Imagerie\tcardiologieController;
// use App\Http\Controllers\Imagerie\tendoscopieController;
// use App\Http\Controllers\Imagerie\timagerieController;
// use App\Http\Controllers\Imagerie\ttypeanalyseController;
use App\Http\Controllers\Imagerie\tim_anuscopieController;
use App\Http\Controllers\Imagerie\tim_attestationController;
use App\Http\Controllers\Imagerie\tim_coloscopieController;
use App\Http\Controllers\Imagerie\tim_invervalController;
use App\Http\Controllers\Imagerie\tim_libelle_scoreController;
use App\Http\Controllers\Imagerie\tim_parametre_scoreController;
use App\Http\Controllers\Imagerie\tim_rectoscopieController;
use App\Http\Controllers\Imagerie\tim_rectosigmoidocopieController;
use App\Http\Controllers\Imagerie\tim_resultatecgController;
use App\Http\Controllers\Imagerie\tim_resultat_f_o_g_dController;
use App\Http\Controllers\Imagerie\tim_score_probabilite_scoreController;


use App\Http\Controllers\Imagerie\tim_anuscopie_extController;
use App\Http\Controllers\Imagerie\tim_coloscopie_extController;
use App\Http\Controllers\Imagerie\tim_rectoscopie_extController;
use App\Http\Controllers\Imagerie\tim_rectosigmoidocopie_extController;
use App\Http\Controllers\Imagerie\tim_resultatecgextController;
use App\Http\Controllers\Imagerie\tim_resultat_f_o_g_d_extController;
use App\Http\Controllers\Imagerie\tim_score_probabilite_score_extController;


use App\Http\Controllers\Imagerie\timagerieannexeextController;
use App\Http\Controllers\Imagerie\timagerieannexeController;
//----------------------DYALISE---------------------

use App\Http\Controllers\Dyalise\tdyal_rapport_med_dyalyseController;
use App\Http\Controllers\Dyalise\tdyal_deroulement_dyaliseController;
use App\Http\Controllers\Dyalise\tdyal_traitement_dyalController;


use App\Http\Controllers\Enfant\tenfant_detail_test_cutaneController;
use App\Http\Controllers\Enfant\tenfant_entete_test_cutaneController;
use App\Http\Controllers\Enfant\tenfant_type_testController;
use App\Http\Controllers\Enfant\tEnfantArchivageController;

use App\Http\Controllers\Mere\t_mere_peniController;
use App\Http\Controllers\Mere\t_periode_peni_mereController;


//Pdf_PersonnelController
//=====================PERSONNELLE===================================
use App\Http\Controllers\Personnel\tperso_affectation_agentController;
use App\Http\Controllers\Personnel\tperso_categorie_rubriqueController;
use App\Http\Controllers\Personnel\tperso_anneeController;
use App\Http\Controllers\Personnel\tperso_appreciation_agentController;
use App\Http\Controllers\Personnel\tperso_autre_congeController;
use App\Http\Controllers\Personnel\Pdf_PersonnelController;
use App\Http\Controllers\Personnel\tperso_categorie_agentController;
use App\Http\Controllers\Personnel\tperso_categorie_serviceController;
use App\Http\Controllers\Personnel\tperso_conge_annuelController;
use App\Http\Controllers\Personnel\tperso_conge_familialeController;
use App\Http\Controllers\Personnel\tperso_controle_congeController;
use App\Http\Controllers\Personnel\tperso_demande_soinController;
use App\Http\Controllers\Personnel\tperso_dependantConrtoller;
use App\Http\Controllers\Personnel\tperso_detail_affectation_ribriqueController;
use App\Http\Controllers\Personnel\tperso_detail_paiement_salController;
use App\Http\Controllers\Personnel\tperso_entete_congeController;
use App\Http\Controllers\Personnel\tperso_entete_paiementController;
use App\Http\Controllers\Personnel\tperso_fiche_paieController;
use App\Http\Controllers\Personnel\tperso_maladie_congeController;
use App\Http\Controllers\Personnel\tperso_materniteController;
use App\Http\Controllers\Personnel\tperso_moisController;
use App\Http\Controllers\Personnel\tperso_parametre_rubriqueController;
use App\Http\Controllers\Personnel\tperso_raison_familialeController;
use App\Http\Controllers\Personnel\tperso_rubriqueController;
use App\Http\Controllers\Personnel\tperso_service_personnelController;
use App\Http\Controllers\Personnel\tperso_sortie_agentController;
use App\Http\Controllers\Personnel\tperso_avance_salaireController;

use App\Http\Controllers\Parametres\tconf_historique_informationController;
//tconf_historique_informationController

use App\Http\Controllers\SimpleExcelController;

//tEnfantArchivageController



//t_mere_peniController t_periode_peni_mere

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['namespace'   =>  "Role"], function(){
    Route::get("fetch_role", [RoleController::class, 'index']);
    Route::get("fetch_single_role/{id}", [RoleController::class, 'edit']);
    Route::get("delete_role/{id}", [RoleController::class, 'destroy']);
    Route::post("insert_role", [RoleController::class, 'store']);
});

Route::group(['namespace'   =>  "User"], function(){
    Route::get("fetch_user", [UserController::class, 'index']);
    Route::get("fetch_user_2", [UserController::class, 'fetch_user_2']);
    Route::get("fetch_single_user/{id}", [UserController::class, 'edit']);
    Route::get("delete_user/{id}", [UserController::class, 'destroy']);
    Route::post("insert_user", [UserController::class, 'store']);
    Route::post("change_pwd_user", [UserController::class, 'ChangePassword']);
    Route::post("change_role_user", [UserController::class, 'ChangeRole']);
    Route::post("insertion_user", [UserController::class, 'insert_user']);
    // Route::post("insertion_user", [UserController::class, 'save_user']);
    Route::post("save_users", [UserController::class, 'store']);
    Route::post("update_users", [UserController::class, 'store']);


    //fetch_user_2
    // envoie de mail
    Route::post("send_mail", [UserController::class, '@send_mail']);
    // imprimmer sa carte 
    Route::get('print_bill',[UserController::class, 'printBill']);
    Route::post('edit_photo',[UserController::class, 'editPhoto']);
    Route::get("showUser/{id}", [UserController::class, 'showUser']);

    //modifier son mot de passe
    Route::post("ChangeMyPasswordSecure", [UserController::class, 'ChangeMyPasswordSecure']);
    Route::get("checkEtat_compte/{id}/{etat}", [UserController::class, 'checkEtat_Compte']);
    Route::get("fetch_user_ceo", [UserController::class, 'fetch_user_ceo']);
});

Route::group(['namespace'   =>  "Site"], function(){
    Route::get("fetch_site", [SiteController::class, 'index']);
    Route::get("fetch_single_site/{id}", [SiteController::class, 'edit']);
    Route::get("delete_site/{id}", [SiteController::class, 'destroy']);
    Route::post("insert_site", [SiteController::class, 'store']);   
    Route::post('edit_photo_site',[SiteController::class, 'editPhoto']);
    Route::get("pdf_client_data", [MakePdfController::class, 'pdf_client_data']); 
    Route::get("pdf_facture_data", [FacturePdfController::class, 'pdf_facture_data']); 
    Route::get("pdf_facturesous_data", [FactureSousPdfController::class, 'pdf_facture_data']); 
    Route::get("pdf_bonentree_data", [BonEntreePdfController::class, 'pdf_bonentree_data']);  
    Route::get("pdf_recu_data", [RecuPdfController::class, 'pdf_recu_data']); 
    Route::get("pdf_aptitudephysique_data", [Pdf_AttestationsController::class, 'pdf_aptitudephysique_data']); 
    Route::get("pdf_certificatmedical_data", [Pdf_AttestationsController::class, 'pdf_certificatmedical_data']); 
    Route::get("pdf_certificatdeces_data", [Pdf_AttestationsController::class, 'pdf_certificatdeces_data']); 
    Route::get("pdf_attestation_naissance_data", [Pdf_AttestationsController::class, 'pdf_attestation_naissance_data']); 

    Route::get("pdf_transfert_data", [Pdf_TransfertController::class, 'pdf_transfert_data']); 
    Route::get("pdf_retroinformation_data", [Pdf_TransfertController::class, 'pdf_retroinformation_data']); 

    // PARTIE RAPPORT SNIS

    Route::get("pdf_examen_labo_snis", [Pdf_StatExamenLaboController::class, 'pdf_examen_labo_snis']);
    Route::get("pdf_stat_cas_de_deces_snis", [Pdf_StatCasDecesController::class, 'pdf_stat_snis']); 

    //Pdf_StatCasDecesController

    //Pdf_TransfertController

    Route::get("pdf_billesortiehospitalisation_data", [Pdf_OrdonancesController::class, 'pdf_billesortiehospitalisation_data']);
    Route::get("pdf_billetorientation_data", [Pdf_OrdonancesController::class, 'pdf_billetorientation_data']);
    Route::get("pdf_ordonancemedicale_data", [Pdf_OrdonancesController::class, 'pdf_ordonancemedicale_data']);
    Route::get("pdf_testcutane_data", [Pdf_OrdonancesController::class, 'pdf_testcutane_data']);
    Route::get("pdf_rapport_triage_date", [Pdf_OrdonancesController::class, 'pdf_rapport_triage_date']);


    Route::get("pdf_besoinservices_data", [Pdf_BesoinServicesController::class, 'pdf_besoinservices_data']);
    Route::get("pdf_usageservices_data", [Pdf_BesoinServicesController::class, 'pdf_usageservices_data']);
    //Pdf_BesoinServicesController


    Route::get("pdf_rapport_laboratoire_examen_date", [Pdf_SpermogrammeController::class, 'pdf_rapport_laboratoire_examen_date']);
    Route::get("pdf_rapport_laboratoire_date", [Pdf_SpermogrammeController::class, 'pdf_rapport_laboratoire_date']);
    Route::get("pdf_rapport_laboratoire_categorie_date", [Pdf_SpermogrammeController::class, 'pdf_rapport_laboratoire_categorie_date']);


    Route::get("pdf_dossier_medical_data", [Pdf_DossierMedicalController::class, 'pdf_dossier_medical_data']);

    
    Route::get("pdf_protocoleimagerie_image_externe_data", [Pdf_AttestationsController::class, 'pdf_protocoleimagerie_image_externe_data']); 
    Route::get("pdf_protocoleimagerie_externe_data", [Pdf_AttestationsController::class, 'pdf_protocoleimagerie_externe_data']); 
    Route::get("pdf_protocoleimagerie_image_data", [Pdf_AttestationsController::class, 'pdf_protocoleimagerie_image_data']); 
    Route::get("pdf_protocoleimagerie_data", [Pdf_AttestationsController::class, 'pdf_protocoleimagerie_data']);
    Route::get("pdf_rapportmedical_data", [Pdf_AttestationsController::class, 'pdf_rapportmedical_data']); 
    Route::get("pdf_rapportmedical_neuro_data", [Pdf_AttestationsController::class, 'pdf_rapportmedical_neuro_data']); 
    Route::get("pdf_rapportmedical_dialyse_data", [Pdf_AttestationsController::class, 'pdf_rapportmedical_dialyse_data']); 

    //pdf_rapportmedical_dialyse_data

    Route::get("pdf_recouvrement_data", [RecouvrementPdfController::class, 'pdf_recouvrement_data']); 
    Route::get("pdf_bonsortie_data", [BonSortieCaissePdfController::class, 'pdf_bon_data']);
    Route::get("pdf_bonentree_data", [BonEntreeCaissePdfController::class, 'pdf_bon_data']); 
    Route::get("pdf_bonexamen_data", [BonExamensPdfController::class, 'pdf_bon_data']);
    Route::get("pdf_bonexamenext_data", [BonExamensPdfController::class, 'pdf_bon_ext_data']);  
    Route::get("pdf_facturelabo_data", [BonExamensPdfController::class, 'pdf_facturelabo_data']);  
    Route::get("pdf_facturelaboext_data", [BonExamensPdfController::class, 'pdf_facturelaboext_data']);  
    Route::get("fetch_rapport_labo_date", [BonExamensPdfController::class, 'fetch_rapport_labo_date']);
    Route::get("pdf_facturecons_data", [BonExamensPdfController::class, 'pdf_facturecons_data']); 
    Route::get("pdf_resultatlabo_data", [BonExamensPdfController::class, 'pdf_resultatlabo_data']);
    Route::get("pdf_resultatlaboext_data", [BonExamensPdfController::class, 'pdf_resultatlaboext_data']); 
    Route::get("pdf_recupaiement_data", [BonExamensPdfController::class, 'pdf_recupaiement_data']);  
    Route::get("pdf_billetlaboext_data", [BonExamensPdfController::class, 'pdf_billetlaboext_data']); 
    Route::get("pdf_billetlabo_data", [BonExamensPdfController::class, 'pdf_billetlabo_data']);               
});
//pdf_billetlabo_data
Route::group(['namespace'   =>  "Blog"], function(){
    Route::get("fetch_blog", [BlogController::class, 'index']);
    Route::get("fetch_single_blog/{id}", [BlogController::class, 'edit']);
    Route::get("delete_blog/{id}", [BlogController::class, 'destroy']);

    Route::get("checkEtat_blog/{id}/{etat}", [BlogController::class, 'checkEtat_blog']);
    Route::post("insert_blog", [BlogController::class, 'insertData']);
    Route::post("update_blog", [BlogController::class, 'updateData']);

});

Route::group(['namespace'   =>  "Galery"], function(){
    Route::get("fetch_galery", [GaleryController::class, 'index']);
    Route::get("fetch_single_galery/{id}", [GaleryController::class, 'edit']);
    Route::get("delete_galery/{id}", [GaleryController::class, 'destroy']);
    Route::post("insert_galery", [GaleryController::class, 'insertData']);
    Route::post("update_galery", [GaleryController::class, 'updateData']);

});

Route::group(['namespace'   =>  "Video"], function(){
    Route::get("fetch_video", [VideoController::class, 'index']);
    Route::get("fetch_single_video/{id}", [VideoController::class, 'edit']);
    Route::get("delete_video/{id}", [VideoController::class, 'destroy']);
    Route::post("insert_video", [VideoController::class, 'store']);

});


//cloturer_Comptabilite;
Route::get('/fetch_depense', [tdepenseController::class, 'all']);
Route::get('/fetch_single_depense/{id}', [tdepenseController::class, 'fetch_single_depense']);
Route::get('/fetch_mouvement_depense', [tdepenseController::class, 'fetch_mouvement_depense']);
Route::get('/fetch_mouvement_entree', [tdepenseController::class, 'fetch_mouvement_entree']);        
Route::post('/insert_depense', [tdepenseController::class, 'insert_depense']);
Route::post('/update_depense/{id}', [tdepenseController::class, 'update_depense']);
Route::get('/delete_depense/{id}', [tdepenseController::class, 'delete_depense']);
Route::get('/fetch_compte_entree', [tdepenseController::class, 'fetch_compte_entree']);
Route::get('/fetch_compte_sortie', [tdepenseController::class, 'fetch_compte_sortie']);
Route::post('aquitter_depense/{id}', [tdepenseController::class, 'aquitter_depense']);
Route::post('approuver_depense/{id}', [tdepenseController::class, 'approuver_depense']);

//Compte
Route::get('/fetch_libelle', [tcompteController::class, 'all']);
Route::get('/fetch_single_libelle/{id}', [tcompteController::class, 'fetch_single_compte']);
Route::post('/insert_libelle', [tcompteController::class, 'insert_compte']);
Route::post('/update_libelle/{id}', [tcompteController::class, 'update_compte']);
Route::get('/delete_libelle/{id}', [tcompteController::class, 'delete_compte']);
Route::get('/fetch_typemouvement', [tcompteController::class, 'fetch_typemouvement']);



//secteur
Route::get("fetch_secteur", [SecteurController::class, 'index']);
Route::get("fetch_single_secteur/{id}", [SecteurController::class, 'edit']);
Route::get("delete_secteur/{id}", [SecteurController::class, 'destroy']);
Route::post("insert_secteur", [SecteurController::class, 'store']);
Route::get("fetch_secteur_2", [SecteurController::class, 'fetch_secteur_2']);

//forme_juridiques
Route::get("fetch_forme_juridiques", [FormeJuridiqueController::class, 'index']);
Route::get("fetch_single_forme_juridiques/{id}", [FormeJuridiqueController::class, 'edit']);
Route::get("delete_forme_juridiques/{id}", [FormeJuridiqueController::class, 'destroy']);
Route::post("insert_forme_juridiques", [FormeJuridiqueController::class, 'store']);
Route::get("fetch_forme_juridiques_2", [FormeJuridiqueController::class, 'fetch_forme_juridiques_2']);

//Entreprise
Route::get("fetch_entreprise", [EntrepriseController::class, 'index']);
Route::get("fetch_single_entreprise/{id}", [EntrepriseController::class, 'edit']);
Route::get("delete_entreprise/{id}/{connected}", [EntrepriseController::class, 'destroy']);
Route::post("insert_entreprise", [EntrepriseController::class, 'insertData']);
Route::post("update_entreprise", [EntrepriseController::class, 'updateData']);
Route::get("fetch_entreprise_deleted", [EntrepriseController::class, 'fetch_entreprise_deleted']);
Route::get("RestoreData/{id}/{connected}", [EntrepriseController::class, 'RestoreData']);
Route::get("fetch_entreprise_2", [EntrepriseController::class, 'fetch_entreprise_2']);
Route::get('get_project_infos/{slug}',[EntrepriseController::class, 'getEntrepriseDetails']);
Route::get("fetch_myentreprise/{ceo}", [EntrepriseController::class, 'fetch_myentreprise']);

//entreprise privee
Route::get("fetchEntrepriseCeo/{id}", [EntrepriseController::class, 'fetchEntrepriseCeo']);


Route::prefix('v1/')->group(function (){
    Route::get('customers',[CustomersController::class, 'all']);
    Route::post('customer',[CustomersController::class, 'createCustomer']);
    Route::get('customer/{id}',[CustomersController::class, 'getById']);
    Route::put('customer/{id}',[CustomersController::class, 'updateCustomer']);
    Route::delete('customer/{id}',[CustomersController::class, 'deleteCustomer']);
});

Route::prefix('p1/')->group(function (){
    Route::get('personnes',[PersonneController::class, 'all']);
    Route::post('personne',[PersonneController::class, 'createPersonne']);
    Route::get('personne/{id}',[PersonneController::class, 'getById']);
    Route::put('personne/{id}',[PersonneController::class, 'updatePersonne']);
    Route::delete('personne/{id}',[PersonneController::class, 'deletePersonne']);
});

Route::prefix('c1/')->group(function (){
    Route::get('clients',[ClientController::class, 'all']);
    Route::post('client',[ClientController::class, 'createClient']);
    Route::get('client/{id}',[ClientController::class, 'getById']);
    Route::put('client/{id}',[ClientController::class, 'updateClient']);
    Route::delete('client/{id}',[ClientController::class, 'deleteClient']);


    Route::get('/fetch_client', [ClientController::class, 'all']);
    Route::get('/fetch_single_client/{id}', [ClientController::class, 'fetch_single_client']);    
    Route::post('/insert_client', [ClientController::class, 'insert_client']);
    Route::post('/update_client/{id}', [ClientController::class, 'update_client']);
    Route::get('/delete_client/{id}', [ClientController::class, 'delete_client']);
    Route::get('/fetch_list_client', [ClientController::class, 'fetch_list_client']);

   
    

});

Route::prefix('a1/')->group(function (){
    Route::get('affetctations',[AffetctationsController::class, 'all']);
    Route::get('/fetch_affectation', [AffetctationsController::class, 'all']);
    Route::get('/fetch_single_affectation/{id}', [AffetctationsController::class, 'fetch_single_affectation']);
    Route::get('/fetch_client_affectation/{refClient}', [AffetctationsController::class, 'fetch_client_affectation']);        
    Route::post('/insert_affectation', [AffetctationsController::class, 'insert_affectation']);
    Route::post('/update_affectation/{id}', [AffetctationsController::class, 'update_affectation']);
    Route::get('/delete_affectation/{id}', [AffetctationsController::class, 'delete_affectation']);
    Route::get('/fetch_list_client', [AffetctationsController::class, 'fetch_list_client']);
    Route::get('/fetch_list_personne', [AffetctationsController::class, 'fetch_list_personne']);


    Route::get('detailproduits',[tDetailProduitController::class, 'all']);
    Route::get('/fetch_detailproduit', [tDetailProduitController::class, 'all']);
    Route::get('/fetch_single_detailproduit/{id}', [tDetailProduitController::class, 'fetch_single_detail']);
    Route::get('/fetch_produit_detailproduit/{reftproduit}', [tDetailProduitController::class, 'fetch_tproduit_detail']);        
    Route::post('/insert_detailproduit', [tDetailProduitController::class, 'insert_detail']);
    Route::post('/update_detailproduit/{id}', [tDetailProduitController::class, 'update_detail']);
    Route::get('/delete_detailproduit/{id}', [tDetailProduitController::class, 'delete_detail']);
    Route::get('/fetch_list_produit', [tDetailProduitController::class, 'fetch_list_produit']);
    Route::get('/fetch_list_element', [tDetailProduitController::class, 'fetch_list_elementproduit']);


    Route::get('log_produits',[tproduitController::class, 'all']);
    Route::get('/fetch_log_produit', [tproduitController::class, 'all']);
    Route::get('/fetch_list_produit2', [tproduitController::class, 'fetch_list_produit2']);
    Route::get('/fetch_single_log_produit/{id}', [tproduitController::class, 'fetch_single_produit']);
    Route::post('/insert_log_produit', [tproduitController::class, 'insert_produit']);
    Route::post('/update_log_produit/{id}', [tproduitController::class, 'update_produit']);
    Route::get('/delete_log_produit/{id}', [tproduitController::class, 'delete_produit']);
    Route::get('/fetch_list_log_categorie', [tproduitController::class, 'fetch_list_categorie']);

 //fetch_list_produit2
    
    Route::get('/fetch_paievente', [tpaiementventeController::class, 'all']);
    Route::get('/fetch_single_paievente/{id}', [tpaiementventeController::class, 'fetch_single_paie']);
    Route::get('/fetch_paie_entetevente/{refEntete}', [tpaiementventeController::class, 'fetch_paie_for_entete']);        
    Route::post('/insert_paievente', [tpaiementventeController::class, 'insert_paie']);
    Route::post('/update_paievente/{id}', [tpaiementventeController::class, 'update_paie']);
    Route::get('/delete_paievente/{id}', [tpaiementventeController::class, 'delete_paie']);


    Route::get("fetch_categoriesous", [tCategorieSouscriptionController::class, 'index']);
    Route::get("fetch_single_categoriesous/{id}",[tCategorieSouscriptionController::class,'edit']);
    Route::get("delete_categoriesous/{id}", [tCategorieSouscriptionController::class,'destroy']);
    Route::post("insert_categoriesous", [tCategorieSouscriptionController::class,'store']);    
    Route::get("destroyMessage/{id}", [tCategorieSouscriptionController::class, 'destroyMessage']);


    Route::get('enetesouscriptions',[tentetesouscriptionController::class, 'all']);
    Route::get('/fetch_entetesouscription', [tentetesouscriptionController::class, 'all']);
    Route::get('/fetch_single_entetesouscription/{id}', [tentetesouscriptionController::class, 'fetch_single_entete']);
    Route::get('/fetch_entete_client/{refClient}', [tentetesouscriptionController::class, 'fetch_entete_client']);        
    Route::post('/insert_entetesouscription', [tentetesouscriptionController::class, 'insert_entete']);
    Route::post('/update_entetesouscription/{id}', [tentetesouscriptionController::class, 'update_entete']);
    Route::get('/delete_entetesouscription/{id}', [tentetesouscriptionController::class, 'delete_entete']);
    Route::get('/fetch_list_client', [tentetesouscriptionController::class, 'fetch_list_client']);


    Route::get('detailsouscriptions',[tdetailsouscriptionController::class, 'all']);
    Route::get('/fetch_detailsouscription', [tdetailsouscriptionController::class, 'all']);
    Route::get('/fetch_single_detailsouscription/{id}', [tdetailsouscriptionController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_entetesouscription/{refEntete}', [tdetailsouscriptionController::class, 'fetch_detail_for_entete']);        
    Route::post('/insert_detailsouscription', [tdetailsouscriptionController::class, 'insert_detail']);
    Route::post('/update_detailsouscription/{id}', [tdetailsouscriptionController::class, 'update_detail']);
    Route::get('/delete_detailsouscription/{id}', [tdetailsouscriptionController::class, 'delete_detail']);
    Route::get('/fetch_list_produit_souscription', [tdetailsouscriptionController::class, 'fetch_list_produit']);
    Route::get('/fetch_list_categorie_souscription', [tdetailsouscriptionController::class, 'fetch_list_categoriesouscription']);
    
});

Route::prefix('ad1/')->group(function(){

    Route::get("fetch_pays", [PaysController::class, 'index']);
    Route::get("fetch_single_pays/{id}",[PaysController::class,'edit']);
    Route::get("delete_pays/{id}", [PaysController::class,'destroy']);
    Route::post("insert_pays", [PaysController::class,'store']);
    Route::get("fetch_pays_2", [PaysController::class, 'fetch_pays_2']);
    Route::get("destroyMessage/{id}", [PaysController::class, 'destroyMessage']);
    

    //provinces
    Route::get("fetch_province", [ProvinceController::class, 'index']);
    Route::get("fetch_single_province/{id}", [ProvinceController::class, 'edit']);
    Route::get("delete_province/{id}", [ProvinceController::class, 'destroy']);
    Route::post("insert_province", [ProvinceController::class, 'store']);
    Route::get("fetch_province_2", [ProvinceController::class, 'fetch_province_2']);
    Route::get("fetch_province_tug_pays/{idPays}", [ProvinceController::class, 'fetch_province_tug_pays']);

    

    //Ville
    Route::get("fetch_ville", [VilleController::class, 'index']);
    Route::get("fetch_single_ville/{id}", [VilleController::class, 'edit']);
    Route::get("delete_ville/{id}", [VilleController::class, 'destroy']);
    Route::post("insert_ville", [VilleController::class, 'store']);
    Route::get("fetch_ville_tug_pays/{idProvince}", [VilleController::class, 'fetch_ville_tug_pays']);
    

    //Commune
    Route::get("fetch_commune", [CommuneController::class, 'index']);
    Route::get("fetch_single_commune/{id}", [CommuneController::class, 'edit']);
    Route::get("delete_commune/{id}", [CommuneController::class, 'destroy']);
    Route::post("insert_commune", [CommuneController::class, 'store']);
    Route::get("fetch_commune_tug_ville/{idVille}", [CommuneController::class, 'fetch_commune_tug_ville']);

    //Quartier
    Route::get("fetch_quartier", [QuartierController::class, 'index']);
    Route::get("fetch_single_quartier/{id}", [QuartierController::class, 'edit']);
    Route::get("delete_quartier/{id}", [QuartierController::class, 'destroy']);
    Route::post("insert_quartier", [QuartierController::class, 'store']);
    Route::get("fetch_quartier_tug_commune/{idVille}", [QuartierController::class, 'fetch_quartier_tug_commune']);

    //Avenue
    Route::get("fetch_avenue", [AvenueController::class, 'index']);
    Route::get("fetch_single_avenue/{id}", [AvenueController::class, 'edit']);
    Route::get("delete_avenue/{id}", [AvenueController::class, 'destroy']);
    Route::post("insert_avenue", [AvenueController::class, 'store']);
    Route::get("getAvenueTug/{idQuartier}", [AvenueController::class, 'getAvenueTug']); 
    
    

    Route::get("fetch_fournisseur", [tfournisseurController::class, 'index']);
    Route::get("fetch_single_fournisseur/{id}",[tfournisseurController::class,'edit']);
    Route::get("delete_fournisseur/{id}", [tfournisseurController::class,'destroy']);
    Route::post("insert_fournisseur", [tfournisseurController::class,'store']);
    Route::get("fetch_fournisseur_2", [tfournisseurController::class, 'fetch_pays_2']);
    Route::get("destroyMessage/{id}", [tfournisseurController::class, 'destroyMessage']);

    Route::get("fetch_categorieclient", [categorieclientController::class, 'index']);
    Route::get("fetch_single_categorieclient/{id}",[categorieclientController::class,'edit']);
    Route::get("delete_categorieclient/{id}", [categorieclientController::class,'destroy']);
    Route::post("insert_categorieclient", [categorieclientController::class,'store']);
    Route::get("fetch_categorieclient_2", [categorieclientController::class, 'fetch_pays_2']);
    Route::get("destroyMessage/{id}", [categorieclientController::class, 'destroyMessage']);


    Route::get("fetch_client", [tclientController::class, 'index']);
    //recherche de malade test
    Route::get("searchMaladeTeste", [tclientController::class, 'searchMaladeTeste']);
    //recherche de malade test
    
    Route::get("fetch_list_categorie", [tclientController::class, 'fetch_list_categorie']);
    Route::get("fetch_single_client/{id}", [tclientController::class, 'edit']);
    Route::get("delete_client/{id}", [tclientController::class, 'destroy']);
    Route::post("insert_client", [tclientController::class, 'insertData']);
    Route::post("update_client", [tclientController::class, 'updateData']);
    Route::get("ProfiletClient/{id}", [tclientController::class, 'ProfiletClient']);
    Route::get("Recouvrement", [RecouvrementController::class, 'index']);

    Route::get("fetch_categorie_log_produit", [tcategorieproduitController::class, 'index']);
    Route::get("fetch_single_categorie_log_produit/{id}",[tcategorieproduitController::class,'edit']);
    Route::get("delete_categorie_log_produit/{id}", [tcategorieproduitController::class,'destroy']);
    Route::post("insert_categorie_log_produit", [tcategorieproduitController::class,'store']);
    Route::get("fetch_categorie_log_produit_2", [tcategorieproduitController::class, 'fetch_pays_2']);

    Route::get("fetch_elementproduit", [telementproduitController::class, 'index']);
    Route::get("fetch_single_elementproduit/{id}",[telementproduitController::class,'edit']);
    Route::get("delete_elementproduit/{id}", [telementproduitController::class,'destroy']);
    Route::post("insert_elementproduit", [telementproduitController::class,'store']);
    Route::get("fetch_elementproduit_2", [telementproduitController::class, 'fetch_pays_2']);
    Route::get("destroyMessage/{id}", [telementproduitController::class, 'destroyMessage']);

});



// PARTIE HOPITAl

//Depense;/

Route::get('/fetch_mouvement', [tmouvementController::class, 'all']);
Route::get('/fetch_liste_mouvement', [tmouvementController::class, 'fetch_liste_mouvement']);
Route::get('/fetch_single_mouvement/{id}', [tmouvementController::class, 'fetch_single_mouvement']);
Route::get('/fetch_mouvement_malade/{refMalade}', [tmouvementController::class, 'fetch_mouvement_malade']);        
Route::post('/insert_mouvement', [tmouvementController::class, 'insert_mouvement']);
Route::post('/update_mouvement/{id}', [tmouvementController::class, 'update_mouvement']);
Route::post('/update_sortie/{id}', [tmouvementController::class, 'update_sortie']);
Route::post('/update_statut/{id}', [tmouvementController::class, 'update_statut']);
Route::get('/delete_mouvement/{id}', [tmouvementController::class, 'delete_mouvement']);
Route::get('/fetch_list_typemouvement', [tmouvementController::class, 'fetch_list_typemouvement']);

Route::get('/fetch_examen_episode/{id}', [tmouvementController::class, 'fetch_examen_episode']);
Route::get('/fetch_actes_episode/{id}', [tmouvementController::class, 'fetch_actes_episode']);
Route::get('/fetch_imagerie_episode/{id}', [tmouvementController::class, 'fetch_imagerie_episode']);
Route::get('/fetch_medicaments_episode/{id}', [tmouvementController::class, 'fetch_medicaments_episode']);
Route::get('/fetch_besoinservice_episode/{id}', [tmouvementController::class, 'fetch_besoinservice_episode']);
//fetch_besoinservice_episode


Route::get('/fetch_entetetriage', [tentetetriageController::class, 'all']);
Route::get('/fetch_single_enteteTriage/{id}', [tentetetriageController::class, 'fetch_single_enteteTriage']);
Route::get('/fetch_triage_mouvement/{refMouvement}', [tentetetriageController::class, 'fetch_triage_mouvement']);        
Route::post('/insert_enteteTriage', [tentetetriageController::class, 'insert_enteteTriage']);
Route::post('/update_enteteTriage/{id}', [tentetetriageController::class, 'update_enteteTriage']);
Route::get('/delete_enteteTriage/{id}', [tentetetriageController::class, 'delete_enteteTriage']);

Route::get('/fetch_detailtriage', [tdetailtriageController::class, 'all']);
Route::get('/fetch_max_adetail_triage', [tdetailtriageController::class, 'fetch_max_adetail_triage']);
Route::get('/fetch_single_detailTriage/{id}', [tdetailtriageController::class, 'fetch_single_detailTriage']);
Route::get('/fetch_detailtriage_entete/{refEnteteTriage}', [tdetailtriageController::class, 'fetch_detailtriage_entete']); 
Route::get('/fetch_entete_detailTriage2/{refEnteteTriage}', [tdetailtriageController::class, 'fetch_entete_detailTriage2']);               
Route::post('/insert_detailTriage', [tdetailtriageController::class, 'insert_detailTriage']);
Route::post('/update_detailTriage/{id}', [tdetailtriageController::class, 'update_detailTriage']);
Route::get('/delete_detailTriage/{id}', [tdetailtriageController::class, 'delete_detailTriage']);

//fetch_max_adetail_triage

Route::get("fetch_typemouvementmalade", [ttypemouvementMaladeController::class, 'index']);
Route::get("fetch_single_typemouvementmalade/{id}",[ttypemouvementMaladeController::class,'edit']);
Route::get("delete_typemouvementmalade/{id}", [ttypemouvementMaladeController::class,'destroy']);
Route::post("insert_typemouvementmalade", [ttypemouvementMaladeController::class,'store']);
Route::get("fetch_ttypemouvement_malade_2", [ttypemouvementMaladeController::class, 'fetch_ttypemouvement_malade_2']);
Route::get("destroyMessage/{id}", [ttypemouvementMaladeController::class, 'destroyMessage']);


// PARTIE CONSULTATION urgences========================================================
//urgences_jour
Route::get('/fetch_enteteconsultation', [tenteteconsulterController::class, 'all']);
Route::get('/fetch_enteteconsultation_attente', [tenteteconsulterController::class, 'all_attente']);
Route::get('/fetch_enteteconsultation_jour', [tenteteconsulterController::class, 'all_jour']);
Route::get('/fetch_enteteconsultation_attente_jour', [tenteteconsulterController::class, 'all_attente_jour']);

Route::get('/fetch_enteteconsultation_filter', [tenteteconsulterController::class, 'filter_all']);
Route::get('/fetch_enteteconsultation_attente_filter', [tenteteconsulterController::class, 'filter_all_attente']);
Route::get('/fetch_enteteconsultation_jour_filter', [tenteteconsulterController::class, 'filter_all_jour']);
Route::get('/fetch_enteteconsultation_attente_jour_filter', [tenteteconsulterController::class, 'filter_all_attente_jour']);

Route::get('/fetch_urgences', [tenteteconsulterController::class, 'urgences']);
Route::get('/fetch_urgences_jour', [tenteteconsulterController::class, 'urgences_jour']);
Route::get('/fetch_urgences_attente', [tenteteconsulterController::class, 'urgences_attente']);
Route::get('/fetch_single_enteteconsultation/{id}', [tenteteconsulterController::class, 'fetch_single_entete']);
Route::get('/fetch_entete_triage/{refDetailTriage}', [tenteteconsulterController::class, 'fetch_entete_triage']);        
Route::post('/insert_enteteconsultation', [tenteteconsulterController::class, 'insert_entete']);
//update_entete_medecin
Route::post('/update_enteteconsultation/{id}', [tenteteconsulterController::class, 'update_entete']);
Route::post('/update_medecinconsultation/{id}', [tenteteconsulterController::class, 'update_entete_medecin']);
Route::post('/update_statutconsultation/{id}', [tenteteconsulterController::class, 'update_statutcons']);
Route::post('/update_cloture/{id}', [tenteteconsulterController::class, 'update_cloture']);
Route::post('/update_fin_urgence/{id}', [tenteteconsulterController::class, 'update_fin_urgence']);
Route::get('/delete_enteteconsultation/{id}', [tenteteconsulterController::class, 'delete_entete']);
Route::get('/fetch_list_medecin', [tenteteconsulterController::class, 'fetch_list_medecin']);

//fetch_detail_for_entete_byid


Route::get('/fetch_detailconsultation', [tdetailconsultationController::class, 'all']);
Route::get('/fetch_single_detailconsultation/{id}', [tdetailconsultationController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteconsultation/{refEntete}', [tdetailconsultationController::class, 'fetch_detail_for_entete']); 
Route::get('/fetch_detail_for_entete_byid/{idDetailCons}', [tdetailconsultationController::class, 'fetch_detail_for_entete_byid']);        
Route::post('/insert_detailconsultation', [tdetailconsultationController::class, 'insert_detail']);
Route::post('/update_detailconsultation/{id}', [tdetailconsultationController::class, 'update_detail']);
Route::get('/delete_detailconsultation/{id}', [tdetailconsultationController::class, 'delete_detail']);
Route::get('/fetch_list_typeConsultation', [tdetailconsultationController::class, 'fetch_list_TypeConsultation']);

Route::get("fetch_typeconsultation", [ttypeconsultationController::class, 'index']);
Route::get("fetch_single_typeconsultation/{id}",[ttypeconsultationController::class,'edit']);
Route::get("delete_typeconsultation/{id}", [ttypeconsultationController::class,'destroy']);
Route::post("insert_typeconsultation", [ttypeconsultationController::class,'store']);
Route::get("fetch_typeconsultation_2", [ttypeconsultationController::class, 'fetch_pays_2']);
Route::get("destroyMessage/{id}", [ttypeconsultationController::class, 'destroyMessage']);

Route::get("fetch_categoriemaladie", [tcategoriemaladieController::class, 'index']);
Route::get("fetch_tconf_categoriemaladie_2", [tcategoriemaladieController::class, 'fetch_tconf_categoriemaladie_2']);
Route::get("fetch_single_categoriemaladie/{id}",[tcategoriemaladieController::class,'edit']);
Route::get("delete_categoriemaladie/{id}", [tcategoriemaladieController::class,'destroy']);
Route::post("insert_categoriemaladie", [tcategoriemaladieController::class,'store']);

Route::get("fetch_liste_menu", [tconf_list_menuController::class, 'index']);
Route::get("fetch_tconf_list_menu_2", [tconf_list_menuController::class, 'fetch_tconf_list_menu_2']);
Route::get("fetch_single_liste_menu/{id}",[tconf_list_menuController::class,'edit']);
Route::get("delete_liste_menu/{id}", [tconf_list_menuController::class,'destroy']);
Route::post("insert_liste_menu", [tconf_list_menuController::class,'store']);

Route::get("fetch_categoriemedicament", [tcategoriemedicamentController::class, 'index']);
Route::get("fetch_tconf_categoriemedicament_2", [tcategoriemedicamentController::class, 'fetch_tconf_categoriemedicament_2']);
Route::get("fetch_single_categoriemedicament/{id}",[tcategoriemedicamentController::class,'edit']);
Route::get("delete_categoriemedicament/{id}", [tcategoriemedicamentController::class,'destroy']);
Route::post("insert_categoriemedicament", [tcategoriemedicamentController::class,'store']);
Route::get("destroyMessage/{id}", [tcategoriemedicamentController::class, 'destroyMessage']);

//activer_data

Route::get("fetch_historique_information", [tconf_historique_informationController::class, 'index']);
Route::get("fetch_tconf_historique_information_2", [tconf_historique_informationController::class, 'fetch_tconf_historique_information_2']);
Route::get("desactiver_data", [tconf_historique_informationController::class, 'desactiver_data']);
Route::get("activer_data", [tconf_historique_informationController::class, 'activer_data']);
Route::get("fetch_historique_information_deleted", [tconf_historique_informationController::class, 'fetch_historique_information_deleted']);
Route::get("fetch_single_historique_information/{id}",[tconf_historique_informationController::class,'edit']);
Route::get("delete_historique_information/{id}", [tconf_historique_informationController::class,'destroy']);
Route::post("insert_historique_information", [tconf_historique_informationController::class,'store']);
Route::get("restore_historique_information/{id}", [tconf_historique_informationController::class,'restore']);
Route::get("restoreAll_historique_information/{id}", [tconf_historique_informationController::class,'restoreAll']);

Route::get('/fetch_detailmedicament', [tdetailmedicamentController::class, 'all']);
//fetch_medicament_detail($refmedicament)
Route::get('/fetch_detail_medicament/{refmedicament}', [tdetailmedicamentController::class, 'fetch_detail_medicament']);
Route::get('/fetch_medicament_detail/{id}', [tdetailmedicamentController::class, 'fetch_single_detail']);
Route::get('/fetch_medicament_filtre/{refmedicament}', [tdetailmedicamentController::class, 'fetch_medicament_filtre']);        
Route::post('/insert_detailmedicament', [tdetailmedicamentController::class, 'insert_detail']);
Route::post('/update_detailmedicament/{id}', [tdetailmedicamentController::class, 'update_detail']);
Route::get('/delete_detailmedicament/{id}', [tdetailmedicamentController::class, 'delete_detail']);
Route::get('/fetch_list_categoriemaladie', [tdetailmedicamentController::class, 'fetch_list_categoriemaladie']);


Route::get('/fetch_affectationrole', [tconf_affectation_menuController::class, 'all']);
Route::get('/fetch_single_affectationrole/{id}', [tconf_affectation_menuController::class, 'fetch_single_detail']);
Route::get('/fetch_affaction_role/{refRole}', [tconf_affectation_menuController::class, 'fetch_affaction_role']);   
Route::get('/fetch_menu_roles/{refRole}', [tconf_affectation_menuController::class, 'fetch_menu_roles']);        
Route::post('/insert_affectationrole', [tconf_affectation_menuController::class, 'insert_detail']);
Route::post('/update_affectationrole/{id}', [tconf_affectation_menuController::class, 'update_detail']);
Route::get('/delete_affectationrole/{id}', [tconf_affectation_menuController::class, 'delete_detail']);

Route::get('/fetch_crud_access', [tconf_crud_accessController::class, 'all']);
Route::get('/fetch_single_crud_access/{id}', [tconf_crud_accessController::class, 'fetch_single_detail']);
Route::get('/fetch_crud_access_role/{refRole}', [tconf_crud_accessController::class, 'fetch_affaction_role']);   
Route::get('/fetch_crud_access_roles_one/{refRole}', [tconf_crud_accessController::class, 'fetch_menu_roles']);        
Route::post('/insert_crud_access', [tconf_crud_accessController::class, 'insert_detail']);
Route::post('/update_crud_access/{id}', [tconf_crud_accessController::class, 'update_detail']);
Route::get('/delete_crud_access/{id}', [tconf_crud_accessController::class, 'delete_detail']);

////tconf_crud_accessController
Route::get('/fetch_maladie', [tmaladieController::class, 'all']);
Route::get('/fetch_single_maladie/{id}', [tmaladieController::class, 'fetch_single_maladie']);
Route::get('/fetch_maladie_categorie/{refcategoriemaladie}', [tmaladieController::class, 'fetch_maladie_categorie']);        
Route::post('/insert_maladie', [tmaladieController::class, 'insert_maladie']);
Route::post('/update_maladie/{id}', [tmaladieController::class, 'update_maladie']);
Route::get('/delete_maladie/{id}', [tmaladieController::class, 'delete_maladie']);
Route::get('/fetch_list_categoriemaladie', [tmaladieController::class, 'fetch_list_categoriemaladie']);

Route::get('/fetch_medicament', [tmedicamentController::class, 'all']);
Route::get('/fetch_single_medicament/{id}', [tmedicamentController::class, 'fetch_single_medicament']);
Route::get('/fetch_medicament_categorie/{refcategoriemedicament}', [tmedicamentController::class, 'fetch_medicament_categorie']);        
Route::post('/insert_medicament', [tmedicamentController::class, 'insert_medicament']);
Route::post('/update_medicament/{id}', [tmedicamentController::class, 'update_medicament']);
Route::get('/delete_medicament/{id}', [tmedicamentController::class, 'delete_medicament']);
Route::get('/fetch_list_categoriemedicament', [tmedicamentController::class, 'fetch_list_categoriemedicament']);
Route::get('/fetch_list_medicament', [tmedicamentController::class, 'fetch_list_medicament']);

Route::get('/fetch_diagnosticdfinitif', [tdiagnosticdefinitifController::class, 'all']);
Route::get('/fetch_single_diagnostic/{id}', [tdiagnosticdefinitifController::class, 'fetch_single_diagnostic']);
Route::get('/fetch_diagnostic_cons/{refdetailCons}', [tdiagnosticdefinitifController::class, 'fetch_diagnostic_cons']);        
Route::post('/insert_diagnostic', [tdiagnosticdefinitifController::class, 'insert_diagnostic']);
Route::post('/update_diagnostic/{id}', [tdiagnosticdefinitifController::class, 'update_diagnostic']);
Route::get('/delete_diagnostic/{id}', [tdiagnosticdefinitifController::class, 'delete_diagnostic']);
Route::get('/fetch_list_maladie', [tdiagnosticdefinitifController::class, 'fetch_list_maladie']);
//fetch_prescription_mouvement
Route::get('/fetch_prescriptionmedicament', [tprescriptionmedicamentController::class, 'all']);
Route::get('/fetch_single_prescription/{id}', [tprescriptionmedicamentController::class, 'fetch_single_prescription']);
Route::get('/fetch_prescription_cons/{refdetailCons}', [tprescriptionmedicamentController::class, 'fetch_prescription_cons']);  
Route::get('/fetch_prescription_mouvement/{refMouvement}', [tprescriptionmedicamentController::class, 'fetch_prescription_mouvement']);              
Route::post('/insert_prescription', [tprescriptionmedicamentController::class, 'insert_prescription']);
Route::post('/update_prescription/{id}', [tprescriptionmedicamentController::class, 'update_prescription']);
Route::get('/delete_prescription/{id}', [tprescriptionmedicamentController::class, 'delete_prescription']);
Route::get('/fetch_quantite_disponible/{refMedicament}', [tprescriptionmedicamentController::class, 'fetch_quantite_disponible']);        

Route::get('/fetch_chronique', [tmaladiechroniqueController::class, 'all']);
Route::get('/fetch_single_chronique/{id}', [tmaladiechroniqueController::class, 'fetch_single_chronique']);
Route::get('/fetch_chronique_malade/{refMalade}', [tmaladiechroniqueController::class, 'fetch_chronique_malade']); 
Route::get('/fetch_chronique_malade2/{refMalade}', [tmaladiechroniqueController::class, 'fetch_chronique_malade2']);               
Route::post('/insert_chronique', [tmaladiechroniqueController::class, 'insert_chronique']);
Route::post('/update_chronique/{id}', [tmaladiechroniqueController::class, 'update_chronique']);
Route::get('/delete_chronique/{id}', [tmaladiechroniqueController::class, 'delete_chronique']);
Route::get('/fetch_list_maladiechronique', [tmaladiechroniqueController::class, 'fetch_list_maladiechronique']);





Route::get('/fetch_actemedecin', [tactemedecinController::class, 'all']);
Route::get('/fetch_single_actemedecin/{id}', [tactemedecinController::class, 'fetch_single_acte']);
Route::post('/insert_actemedecin', [tactemedecinController::class, 'insert_acte']);
Route::post('/update_actemedecin/{id}', [tactemedecinController::class, 'update_acte']);
Route::get('/delete_actemedecin/{id}', [tactemedecinController::class, 'delete_acte']);

Route::get('/fetch_poseactemedecin', [tacteposemedecinController::class, 'all']);
Route::get('/fetch_single_poseactemedecin/{id}', [tacteposemedecinController::class, 'fetch_single_poseacte']);
Route::get('/fetch_poseactemedecin_cons/{refDetailCons}', [tacteposemedecinController::class, 'fetch_poseacte_cons']);        
Route::post('/insert_poseactemedecin', [tacteposemedecinController::class, 'insert_poseacte']);
Route::post('/update_poseactemedecin/{id}', [tacteposemedecinController::class, 'update_poseacte']);
Route::get('/delete_poseactemedecin/{id}', [tacteposemedecinController::class, 'delete_poseacte']);
Route::get('/fetch_list_actemdecin', [tacteposemedecinController::class, 'fetch_list_acte']);

Route::get('/fetch_orientationcons', [torientationconsController::class, 'all']);
Route::get('/fetch_single_orientationcons/{id}', [torientationconsController::class, 'fetch_single_orientations']);
Route::get('/fetch_orientations_cons/{refDetailCons}', [torientationconsController::class, 'fetch_orientations_cons']);        
Route::post('/insert_orientationcons', [torientationconsController::class, 'insert_orientations']);
Route::post('/update_orientationcons/{id}', [torientationconsController::class, 'update_orientations']);
Route::get('/delete_orientationcons/{id}', [torientationconsController::class, 'delete_orientations']);



Route::get('/fetch_entete_ordonance', [tcons_entete_ordonanceController::class, 'all']);
Route::get('/fetch_max_enteteOrdonance_Cons', [tcons_entete_ordonanceController::class, 'fetch_max_enteteOrdonance_Cons']);
Route::get('/fetch_single_entete_ordonance/{id}', [tcons_entete_ordonanceController::class, 'fetch_single_orientations']);
Route::get('/fetch_entete_ordonance_cons/{refDetailCons}', [tcons_entete_ordonanceController::class, 'fetch_orientations_cons']);        
Route::post('/insert_entete_ordonance', [tcons_entete_ordonanceController::class, 'insert_orientations']);
Route::post('/update_entete_ordonance/{id}', [tcons_entete_ordonanceController::class, 'update_orientations']);
Route::get('/delete_entete_ordonance/{id}', [tcons_entete_ordonanceController::class, 'delete_orientations']);

Route::get('/fetch_detail_ordonance', [tcons_detail_ordonanceController::class, 'all']);
Route::get('/fetch_single_detail_ordonance/{id}', [tcons_detail_ordonanceController::class, 'fetch_single_orientations']);
Route::get('/fetch_detail_ordonance_entete/{refEnteteOrdonance}', [tcons_detail_ordonanceController::class, 'fetch_orientations_cons']);        
Route::post('/insert_detail_ordonance', [tcons_detail_ordonanceController::class, 'insert_orientations']);
Route::post('/update_detail_ordonance/{id}', [tcons_detail_ordonanceController::class, 'update_orientations']);
Route::get('/delete_detail_ordonance/{id}', [tcons_detail_ordonanceController::class, 'delete_orientations']);



Route::get('/fetch_resumeclinique', [tresumecliniqueController::class, 'all']);
Route::get('/fetch_single_resumeclinique/{id}', [tresumecliniqueController::class, 'fetch_single_resumeclinique']);
Route::get('/fetch_resumeclinique_cons/{refDetailCons}', [tresumecliniqueController::class, 'fetch_resumeclinique_cons']);        
Route::post('/insert_resumeclinique', [tresumecliniqueController::class, 'insert_resumeclinique']);
Route::post('/update_resumeclinique/{id}', [tresumecliniqueController::class, 'update_resumeclinique']);
Route::get('/delete_resumeclinique/{id}', [tresumecliniqueController::class, 'delete_resumeclinique']);
//

Route::get('/fetch_transfert', [tcons_transfertController::class, 'all']);
Route::get('/fetch_single_transfert/{id}', [tcons_transfertController::class, 'fetch_single_data']);
Route::get('/fetch_transfert_cons/{refDetailCons}', [tcons_transfertController::class, 'fetch_data_entete']);        
Route::post('/insert_transfert', [tcons_transfertController::class, 'insert_data']);
Route::post('/update_transfert/{id}', [tcons_transfertController::class, 'update_data']);
Route::get('/delete_transfert/{id}', [tcons_transfertController::class, 'delete_data']);

Route::get('/fetch_retroinformation', [tcons_retroinformationController::class, 'all']);
Route::get('/fetch_single_retroinformation/{id}', [tcons_retroinformationController::class, 'fetch_single_data']);
Route::get('/fetch_retroinformation_cons/{refDetailCons}', [tcons_retroinformationController::class, 'fetch_data_entete']);        
Route::post('/insert_retroinformation', [tcons_retroinformationController::class, 'insert_data']);
Route::post('/update_retroinformation/{id}', [tcons_retroinformationController::class, 'update_data']);
Route::get('/delete_retroinformation/{id}', [tcons_retroinformationController::class, 'delete_data']);

//update_statutrapmed
Route::get('/fetch_rapportmedical', [trapportmedicalController::class, 'all']);
Route::get('/fetch_single_rapportmedical/{id}', [trapportmedicalController::class, 'fetch_single_rapportmedical']);
Route::get('/fetch_rapportmedical_cons/{refDetailCons}', [trapportmedicalController::class, 'fetch_rapportmedical_cons']);        
Route::post('/insert_rapportmedical', [trapportmedicalController::class, 'insert_rapportmedical']);
Route::post('/update_rapportmedical/{id}', [trapportmedicalController::class, 'update_rapportmedical']);
Route::post('/update_statutrapmed/{id}', [trapportmedicalController::class, 'update_statutrapmed']);
Route::get('/delete_rapportmedical/{id}', [trapportmedicalController::class, 'delete_rapportmedical']);

//fecth_kine_valide
Route::get('/fecth_kine_valide_jour', [kinesiterapieController::class, 'fecth_kine_valide_jour']);
Route::get('/fetch_kine_all', [kinesiterapieController::class, 'all']);
Route::get('/fetch_kine_valide', [kinesiterapieController::class, 'all_valide']);
Route::get('/fetch_single_kinesiterapie/{id}', [kinesiterapieController::class, 'fetch_single_kinesiterapie']);
Route::get('/fetch_kinesiterapie_cons/{refDetailCons}', [kinesiterapieController::class, 'fetch_kinesiterapie_cons']);        
Route::post('/insert_kinesiterapie', [kinesiterapieController::class, 'insert_kinesiterapie']);
Route::post('/update_kinesiterapie/{id}', [kinesiterapieController::class, 'update_kinesiterapie']);
Route::post('/update_kinesiterapie_result/{id}', [kinesiterapieController::class, 'update_kinesiterapie_result']);
Route::post('/update_statutkine/{id}', [kinesiterapieController::class, 'update_statutkine']);
Route::get('/delete_kinesiterapie/{id}', [kinesiterapieController::class, 'delete_kinesiterapie']);


//update_kinesiterapie_result


// PARTIE LABORATOIRE========================================================
//fetch_examen_episode
Route::get('/fetch_entetelaboratoire', [tentetelaboController::class, 'all']);
Route::get('/fetch_single_entetelaboratoire/{id}', [tentetelaboController::class, 'fetch_single_entete']);
Route::get('/fetch_entete_labo/{refEntetePrelevement}', [tentetelaboController::class, 'fetch_entete_labo']);  
Route::get('/fetch_entete_labo_attente/{refEntetePrelevement}', [tentetelaboController::class, 'fetch_entete_labo_medecin']);      
Route::post('/insert_entetelaboratoire', [tentetelaboController::class, 'insert_entete']);
Route::post('/update_entetelaboratoire/{id}', [tentetelaboController::class, 'update_entete']);
Route::post('/update_statutexamen/{id}', [tentetelaboController::class, 'update_statutexamen']);
Route::get('/delete_entetelaboratoire/{id}', [tentetelaboController::class, 'delete_entete']);
Route::get('/fetch_list_ValeurForExam/{refExamen}', [tentetelaboController::class, 'fetch_list_ValeurForExam']);
Route::get('/fetch_list_ExamenForCat/{refCatexamen}', [tentetelaboController::class, 'fetch_list_ExamenForCat']);
Route::get('/fetch_list_CatexamenForGrandCat/{refGrandCategorie}', [tentetelaboController::class, 'fetch_list_CatexamenForGrandCat']);
Route::get('/fetch_list_GrandCategorie', [tentetelaboController::class, 'fetch_list_GrandCategorie']);
Route::get('/fetch_detaillaboratoire', [tdetaillaboController::class, 'all']);
Route::get('/fetch_single_detaillaboratoire/{id}', [tdetaillaboController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entetelaboratoire/{refEntete}', [tdetaillaboController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detaillaboratoire', [tdetaillaboController::class, 'insert_detail']);
Route::post('/update_detaillaboratoire/{id}', [tdetaillaboController::class, 'update_detail']);
Route::get('/delete_detaillaboratoire/{id}', [tdetaillaboController::class, 'delete_detail']);
Route::get('/get_paie_Labo/{refMouvement}', [tdetaillaboController::class, 'get_paie_Labo']);


Route::get("fetch_categorieexamen", [tcategorieexamenController::class, 'index']);
Route::get("fetch_single_categorieexamen/{id}",[tcategorieexamenController::class,'edit']);
Route::get("delete_categorieexamen/{id}", [tcategorieexamenController::class,'destroy']);
Route::post('/insert_categorieexamen', [tcategorieexamenController::class, 'insert_categorie']);
Route::post('/update_categorieexamen/{id}', [tcategorieexamenController::class, 'update_categorie']);
Route::get("destroyMessage/{id}", [tcategorieexamenController::class, 'destroyMessage']);

Route::get("fetch_grandcategorieexamen", [tgcategorieexamenController::class, 'index']);
Route::get("fetch_single_grandcategorieexamen/{id}",[tgcategorieexamenController::class,'edit']);
Route::get("delete_grandcategorieexamen/{id}", [tgcategorieexamenController::class,'destroy']);
Route::post("insert_grandcategorieexamen", [tgcategorieexamenController::class,'store']);
Route::get("destroyMessage/{id}", [tgcategorieexamenController::class, 'destroyMessage']);




Route::get("fetch_categorie_echantillon", [tlabo_categorie_echantillonController::class, 'index']);
Route::get("fetch_tlabo_categorie_echantillon_2", [tlabo_categorie_echantillonController::class, 'fetch_tlabo_categorie_echantillon_2']);
Route::get("fetch_single_categorie_echantillon/{id}",[tlabo_categorie_echantillonController::class,'edit']);
Route::get("delete_categorie_echantillon/{id}", [tlabo_categorie_echantillonController::class,'destroy']);
Route::post("insert_categorie_echantillon", [tlabo_categorie_echantillonController::class,'store']);

Route::get("fetch_germe_labo", [tlabo_germeController::class, 'index']);
Route::get("fetch_tlabo_germe_2", [tlabo_germeController::class, 'fetch_tlabo_germe_2']);
Route::get("fetch_single_germe_labo/{id}",[tlabo_germeController::class,'edit']);
Route::get("delete_germe_labo/{id}", [tlabo_germeController::class,'destroy']);
Route::post("insert_germe_labo", [tlabo_germeController::class,'store']);

Route::get("fetch_examencolore_labo", [tlabo_examencoloreController::class, 'index']);
Route::get("fetch_tlabo_examencolore_2", [tlabo_examencoloreController::class, 'fetch_tlabo_examencolore_2']);
Route::get("fetch_single_examencolore_labo/{id}",[tlabo_examencoloreController::class,'edit']);
Route::get("delete_examencolore_labo/{id}", [tlabo_examencoloreController::class,'destroy']);
Route::post("insert_examencolore_labo", [tlabo_examencoloreController::class,'store']);

Route::get("fetch_nature_echantillon", [tlabo_nature_echantillonController::class, 'index']);
Route::get("fetch_tlabo_nature_echantillon_2", [tlabo_nature_echantillonController::class, 'fetch_tlabo_nature_echantillon_2']);
Route::get("fetch_single_nature_echantillon/{id}",[tlabo_nature_echantillonController::class,'edit']);
Route::get("delete_nature_echantillon/{id}", [tlabo_nature_echantillonController::class,'destroy']);
Route::post("insert_nature_echantillon", [tlabo_nature_echantillonController::class,'store']);




// ==fetch_texamen_2
Route::get("fetch_examen", [texamenController::class, 'index']);
Route::get("fetch_single_examen/{id}",[texamenController::class,'fetch_single_examen']);
Route::get("delete_examen/{id}", [texamenController::class,'destroy']);
Route::post("insert_examen", [texamenController::class,'store']);
Route::get("destroyMessage/{id}", [texamenController::class, 'destroyMessage']);
Route::get('/fetch_list_Tube', [texamenController::class, 'fetch_list_Tube']);
Route::get("fetch_texamen_2", [texamenController::class, 'fetch_texamen_2']);

Route::get("fetch_valeurnormale", [tvaleurnormaleController::class, 'index']);
Route::get("fetch_single_valeurnormale/{id}",[tvaleurnormaleController::class,'edit']);
Route::get("delete_valeurnormale/{id}", [tvaleurnormaleController::class,'destroy']);
Route::post("insert_valeurnormale", [tvaleurnormaleController::class,'store']);
Route::get("destroyMessage/{id}", [tvaleurnormaleController::class, 'destroyMessage']);

//fetch_max_entete_prelevement_mouvement
Route::get("fetch_entete_prelevement", [tlabo_entete_prelevementController::class, 'all']);
Route::get("fetch_max_entete_prelevement_Cons", [tlabo_entete_prelevementController::class, 'fetch_max_entete_prelevement_Cons']);
Route::get("fetch_valide_prelevement", [tlabo_entete_prelevementController::class, 'fetch_valide_prelevement']);
Route::get("fetch_valide_finance", [tlabo_entete_prelevementController::class, 'fetch_valide_finance']);
Route::get("fetch_valide_labo", [tlabo_entete_prelevementController::class, 'fetch_valide_labo']);
Route::get("fetch_single_entete_prelevement/{id}", [tlabo_entete_prelevementController::class, 'fetch_single_data']);
Route::get("fetch_data_entete_prelevement/{refDetailCons}", [tlabo_entete_prelevementController::class, 'fetch_data_entete']);
Route::post("insert_entete_prelevement", [tlabo_entete_prelevementController::class, 'insert_data']);
Route::post("update_entete_prelevement/{id}", [tlabo_entete_prelevementController::class, 'update_data']);
Route::post("update_statutprelevement/{id}", [tlabo_entete_prelevementController::class, 'update_statutprelevement']);
Route::post("update_preleveur/{id}", [tlabo_entete_prelevementController::class, 'update_preleveur']);
Route::get("delete_entete_prelevement/{id}", [tlabo_entete_prelevementController::class, 'delete_data']);
Route::get("fetch_max_entete_prelevement_mouvement", [tlabo_entete_prelevementController::class, 'fetch_max_entete_prelevement_mouvement']);

Route::get("fetch_detail_prelevement", [tlabo_detail_prelevementController::class, 'all']);
Route::get("fetch_single_detail_prelevement/{id}", [tlabo_detail_prelevementController::class, 'fetch_single_data']);
Route::get("fetch_echantillon_prelevement/{refEntetePrelevement}", [tlabo_detail_prelevementController::class, 'fetch_echantillon_prelevement']);
Route::get("fetch_data_detail_prelevement/{refEntetePrelevement}", [tlabo_detail_prelevementController::class, 'fetch_data_entete']);
Route::post("insert_detail_prelevement", [tlabo_detail_prelevementController::class, 'insert_data']);
Route::post("update_detail_prelevement/{id}", [tlabo_detail_prelevementController::class, 'update_data']);
Route::get("delete_detail_prelevement/{id}", [tlabo_detail_prelevementController::class, 'delete_data']);

//fetch_echantillon_prelevement($refEntetePrelevement)

Route::get("fetch_detail_examencolore", [tlabo_detail_examencoloreController::class, 'all']);
Route::get("fetch_single_detail_examencolore/{id}", [tlabo_detail_examencoloreController::class, 'fetch_single_data']);
Route::get("fetch_data_detail_examencolore/{refResultatBacterie}", [tlabo_detail_examencoloreController::class, 'fetch_data_entete']);
Route::post("insert_detail_examencolore", [tlabo_detail_examencoloreController::class, 'insert_data']);
Route::post("update_detail_examencolore/{id}", [tlabo_detail_examencoloreController::class, 'update_data']);
Route::get("delete_detail_examencolore/{id}", [tlabo_detail_examencoloreController::class, 'delete_data']);

Route::get("fetch_detail_germe", [tlabo_detail_germeController::class, 'all']);
Route::get("fetch_single_detail_germe/{id}", [tlabo_detail_germeController::class, 'fetch_single_data']);
Route::get("fetch_data_detail_germe/{refResultatBacterie}", [tlabo_detail_germeController::class, 'fetch_data_entete']);
Route::post("insert_detail_germe", [tlabo_detail_germeController::class, 'insert_data']);
Route::post("update_detail_germe/{id}", [tlabo_detail_germeController::class, 'update_data']);
Route::get("delete_detail_germe/{id}", [tlabo_detail_germeController::class, 'delete_data']);

Route::get("fetch_resultat_bacterie", [tlabo_resultat_bacteriologieController::class, 'all']);
Route::get("fetch_single_resultat_bacterie/{id}", [tlabo_resultat_bacteriologieController::class, 'fetch_single_data']);
Route::get("fetch_data_resultat_bacterie_prelevement/{refEnteteLabo}", [tlabo_resultat_bacteriologieController::class, 'fetch_data_entete']);
Route::post("insert_resultat_bacterie", [tlabo_resultat_bacteriologieController::class, 'insert_data']);
Route::post("update_resultat_bacterie/{id}", [tlabo_resultat_bacteriologieController::class, 'update_data']);
Route::get("delete_resultat_bacterie/{id}", [tlabo_resultat_bacteriologieController::class, 'delete_data']);

Route::get("fetch_resultat_sperme", [tlabo_resultat_spermeController::class, 'all']);
Route::get("fetch_single_resultat_sperme/{id}", [tlabo_resultat_spermeController::class, 'fetch_single_detail']);
Route::get("fetch_data_resultat_sperme/{refEntete}", [tlabo_resultat_spermeController::class, 'fetch_detail_for_entete']);
Route::post("insert_resultat_sperme", [tlabo_resultat_spermeController::class, 'insert_data']);
Route::post("update_resultat_sperme/{id}", [tlabo_resultat_spermeController::class, 'update_data']);
Route::get("delete_resultat_sperme/{id}", [tlabo_resultat_spermeController::class, 'delete_data']);











Route::get("fetch_entetelaboratoireext", [tentetelaboextController::class, 'all']);
Route::get("fetch_single_entetelaboratoireext/{id}", [tentetelaboextController::class, 'fetch_single_entete']);
Route::get("fetch_entete_laboext/{refMouvement}", [tentetelaboextController::class, 'fetch_entete_labo']);
Route::get("fetch_entete_labo_attenteext/{refMouvement}", [tentetelaboextController::class, 'fetch_entete_labo_attente']);        
Route::post("insert_entetelaboratoireext", [tentetelaboextController::class, 'insert_entete']);
Route::post("update_entetelaboratoireext/{id}", [tentetelaboextController::class, 'update_entete']);
Route::post("update_statutexamenext/{id}", [tentetelaboextController::class, 'update_statutexamenext']);
Route::get("delete_entetelaboratoireext/{id}", [tentetelaboextController::class, 'delete_entete']);


Route::get('/fetch_detaillaboratoireext', [tdetaillaboextController::class, 'all']);
Route::get('/fetch_single_detaillaboratoireext/{id}', [tdetaillaboextController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entetelaboratoireext/{refEntete}', [tdetaillaboextController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detaillaboratoireext', [tdetaillaboextController::class, 'insert_detail']);
Route::post('/update_detaillaboratoireext/{id}', [tdetaillaboextController::class, 'update_detail']);
Route::get('/delete_detaillaboratoireext/{id}', [tdetaillaboextController::class, 'delete_detail']);


Route::get("fetch_tubeExamen", [ttubeexamenController::class, 'index']);
Route::get("fetch_single_tubeExamen/{id}",[ttubeexamenController::class,'edit']);
Route::get("delete_tubeExamen/{id}", [ttubeexamenController::class,'destroy']);
Route::post("insert_tubeExamen", [ttubeexamenController::class,'store']);
Route::get("destroyMessage/{id}", [ttubeexamenController::class, 'destroyMessage']);



Route::get("fetch_natureechantillon", [natureechantillonController::class, 'index']);
Route::get("fetch_single_natureechantillon/{id}",[natureechantillonController::class,'edit']);
Route::get("delete_natureechantillon/{id}", [natureechantillonController::class,'destroy']);
Route::post("insert_natureechantillon", [natureechantillonController::class,'store']);
Route::get("fetch_tconf_natureechantillon_2", [natureechantillonController::class, 'fetch_tconf_natureechantillon_2']);
Route::get("destroyMessage/{id}", [natureechantillonController::class, 'destroyMessage']);

Route::get("fetch_methodeexamen", [methodeexamenController::class, 'index']);
Route::get("fetch_single_methodeexamen/{id}",[methodeexamenController::class,'edit']);
Route::get("delete_methodeexamen/{id}", [methodeexamenController::class,'destroy']);
Route::post("insert_methodeexamen", [methodeexamenController::class,'store']);
Route::get("fetch_tconf_methodeexamen_2", [methodeexamenController::class, 'fetch_tconf_methodeexamen_2']);
Route::get("destroyMessage/{id}", [methodeexamenController::class, 'destroyMessage']);

Route::get("fetch_unitevaleur", [unitevaleurController::class, 'index']);
Route::get("fetch_single_unitevaleur/{id}",[unitevaleurController::class,'edit']);
Route::get("delete_unitevaleur/{id}", [unitevaleurController::class,'destroy']);
Route::post("insert_unitevaleur", [unitevaleurController::class,'store']);
Route::get("fetch_tconf_unitevaleur_2", [unitevaleurController::class, 'fetch_tconf_unitevaleur_2']);
Route::get("destroyMessage/{id}", [unitevaleurController::class, 'destroyMessage']);

Route::get("fetch_categorievaleur", [categorievaleurController::class, 'index']);
Route::get("fetch_single_categorievaleur/{id}",[categorievaleurController::class,'edit']);
Route::get("delete_categorievaleur/{id}", [categorievaleurController::class,'destroy']);
Route::post("insert_categorievaleur", [categorievaleurController::class,'store']);
Route::get("fetch_tconf_categorievaleur_2", [categorievaleurController::class, 'fetch_tconf_categorievaleur_2']);
Route::get("destroyMessage/{id}", [categorievaleurController::class, 'destroyMessage']);

// PARTIE FINANCE=============================================================


Route::get("fetch_categorie_societe", [tfin_categorie_societeController::class, 'index']);
Route::get("fetch_single_categorie_societe/{id}",[tfin_categorie_societeController::class,'edit']);
Route::get("delete_categorie_societe/{id}", [tfin_categorie_societeController::class,'destroy']);
Route::post("insert_categorie_societe", [tfin_categorie_societeController::class,'store']);
Route::get("fetch_tfin_categorie_societe_2", [tfin_categorie_societeController::class, 'fetch_tfin_categorie_societe_2']);

Route::get("fetch_typefrais", [fraisController::class, 'index']);
Route::get("fetch_single_typefrais/{id}",[fraisController::class,'edit']);
Route::get("delete_typefrais/{id}", [fraisController::class,'destroy']);
Route::post("insert_typefrais", [fraisController::class,'store']);
Route::get("fetch_tconf_typefrais_2", [fraisController::class, 'fetch_tconf_frais_2']);
Route::get("destroyMessage/{id}", [fraisController::class, 'destroyMessage']);


Route::get("fetch_modepaie", [modepaieController::class, 'index']);
Route::get("fetch_single_modepaie/{id}",[modepaieController::class,'edit']);
Route::get("delete_modepaie/{id}", [modepaieController::class,'destroy']);
Route::post("insert_modepaie", [modepaieController::class,'store']);
Route::get("fetch_tconf_modepaie_2", [modepaieController::class, 'fetch_tconf_modepaiement_2']);
Route::get("destroyMessage/{id}", [modepaieController::class, 'destroyMessage']);

Route::get("fetch_typetarif", [typetarificationController::class, 'index']);
Route::get("fetch_single_typetarif/{id}",[typetarificationController::class,'edit']);
Route::get("delete_typetarif/{id}", [typetarificationController::class,'destroy']);
Route::post("insert_typetarif", [typetarificationController::class,'store']);
Route::get("fetch_tconf_typetarif_2", [typetarificationController::class, 'fetch_tconf_tarification_2']);
Route::get("destroyMessage/{id}", [typetarificationController::class, 'destroyMessage']);

Route::get("fetch_entetepaie", [tentetepaieController::class, 'all']);
Route::get("fetch_single_entetepaie/{id}", [tentetepaieController::class, 'fetch_single_entete']);
Route::get("fetch_entete_mouvement/{refMouvement}", [tentetepaieController::class, 'fetch_entete_mouvement']);        
Route::post("insert_entetepaie", [tentetepaieController::class, 'insert_entete']);
Route::post("update_entetepaie/{id}", [tentetepaieController::class, 'update_entete']);
Route::get("delete_entetepaie/{id}", [tentetepaieController::class, 'delete_entete']);

Route::get('/fetch_detailpaie', [tdetailpaieController::class, 'all']);
Route::get('/fetch_single_detailpaie/{id}', [tdetailpaieController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entetepaie/{refEntete}', [tdetailpaieController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detailpaie', [tdetailpaieController::class, 'insert_detail']);
Route::post('/update_detailpaie/{id}', [tdetailpaieController::class, 'update_detail']);
Route::get('/delete_detailpaie/{id}', [tdetailpaieController::class, 'delete_detail']);




Route::get("fetch_classecompte", [tclasseController::class, 'index']);
Route::get("fetch_single_classecompte/{id}",[tclasseController::class,'edit']);
Route::get("delete_classecompte/{id}", [tclasseController::class,'destroy']);
Route::post("insert_classecompte", [tclasseController::class,'store']);
Route::get("fetch_fin_classe_2", [tclasseController::class, 'fetch_tfin_classe_2']);

Route::get("fetch_typecompte", [ttypecompteController::class, 'index']);
Route::get("fetch_single_typecompte/{id}",[ttypecompteController::class,'edit']);
Route::get("delete_typecompte/{id}", [ttypecompteController::class,'destroy']);
Route::post("insert_typecompte", [ttypecompteController::class,'store']);
Route::get("fetch_fin_typecompte_2", [ttypecompteController::class, 'fetch_tfin_typecompte_2']);

Route::get("fetch_typeposition", [ttypepositionController::class, 'index']);
Route::get("fetch_single_typeposition/{id}",[ttypepositionController::class,'edit']);
Route::get("delete_typeposition/{id}", [ttypepositionController::class,'destroy']);
Route::post("insert_typeposition", [ttypepositionController::class,'store']);
Route::get("fetch_fin_typeposition_2", [ttypepositionController::class, 'fetch_tfin_typeposition_2']);

Route::get("fetch_taux", [ttauxController::class, 'index']);
Route::get("fetch_single_taux/{id}",[ttauxController::class,'edit']);
Route::get("delete_taux/{id}", [ttauxController::class,'destroy']);
Route::post("insert_taux", [ttauxController::class,'store']);
Route::get("fetch_tfin_taux_2", [ttauxController::class, 'fetch_tfin_taux_2']);

Route::get("fetch_typeproduit", [ttypeproduitController::class, 'index']);
Route::get("fetch_single_typeproduit/{id}",[ttypeproduitController::class,'edit']);
Route::get("delete_typeproduit/{id}", [ttypeproduitController::class,'destroy']);
Route::post("insert_typeproduit", [ttypeproduitController::class,'store']);
Route::get("fetch_fin_typeproduit_2", [ttypeproduitController::class, 'fetch_tfin_typeproduit_2']);

Route::get("fetch_departementfin", [tdepartementfinController::class, 'index']);
Route::get("fetch_single_departementfin/{id}",[tdepartementfinController::class,'edit']);
Route::get("delete_departementfin/{id}", [tdepartementfinController::class,'destroy']);
Route::post("insert_departementfin", [tdepartementfinController::class,'store']);
Route::get("fetch_fin_departement_2", [tdepartementfinController::class, 'fetch_tfin_departement_2']);

Route::get("fetch_typeoperation", [ttypeoperationController::class, 'index']);
Route::get("fetch_single_typeoperation/{id}",[ttypeoperationController::class,'edit']);
Route::get("delete_typeoperation/{id}", [ttypeoperationController::class,'destroy']);
Route::post("insert_typeoperation", [ttypeoperationController::class,'store']);
Route::get("fetch_fin_typeoperation_2", [ttypeoperationController::class, 'fetch_tfin_typeoperation_2']);

Route::get('/fetch_uniteDepartement', [tuniteproductionController::class, 'all']);
Route::get('/fetch_single_uniteDepartement/{id}', [tuniteproductionController::class, 'fetch_single_uniteDepartement']);
Route::get('/fetch_unite_departement/{refDepartement}', [tuniteproductionController::class, 'fetch_unite_departement']);   
Route::get('/fetch_unite_Departement2/{refDepartement}', [tuniteproductionController::class, 'fetch_unite_Departement2']);  
Route::get('/fetch_unite2', [tuniteproductionController::class, 'fetch_unite2']);                
Route::post('/insert_uniteproduction', [tuniteproductionController::class, 'insert_uniteproduction']);
Route::post('/update_uniteproduction/{id}', [tuniteproductionController::class, 'update_uniteproduction']);
Route::get('/delete_uniteproduction/{id}', [tuniteproductionController::class, 'delete_uniteproduction']);
//fetch_unite2
Route::get('/fetch_comptefin', [tcomptefinController::class, 'all']);
Route::get('/fetch_single_compte/{id}', [tcomptefinController::class, 'fetch_single_compte']);
Route::get('/fetch_compte_classe/{refClasse}', [tcomptefinController::class, 'fetch_compte_classe']);   
Route::get('/fetch_compte_classe2/{refClasse}', [tcomptefinController::class, 'fetch_compte_classe2']); 
Route::get('/fetch_compte2', [tcomptefinController::class, 'fetch_compte2']);         
Route::post('/insert_comptefin', [tcomptefinController::class, 'insert_compte']);
Route::post('/update_comptefin/{id}', [tcomptefinController::class, 'update_compte']);
Route::get('/delete_comptefin/{id}', [tcomptefinController::class, 'delete_compte']);

Route::get('/fetch_souscomptefin', [tsouscomptefinController::class, 'all']);
Route::get('/fetch_single_souscompte/{id}', [tsouscomptefinController::class, 'fetch_single_souscompte']);
Route::get('/fetch_souscompte_compte/{refCompte}', [tsouscomptefinController::class, 'fetch_souscompte_compte']);   
Route::get('/fetch_souscompte_compte2/{refCompte}', [tsouscomptefinController::class, 'fetch_souscompte_compte2']);         
Route::post('/insert_souscomptefin', [tsouscomptefinController::class, 'insert_souscompte']);
Route::post('/update_souscomptefin/{id}', [tsouscomptefinController::class, 'update_souscompte']);
Route::get('/delete_souscomptefin/{id}', [tsouscomptefinController::class, 'delete_souscompte']);

Route::get('/fetch_ssouscomptefin', [tssouscomptefinController::class, 'all']);
Route::get('/fetch_single_ssouscompte/{id}', [tssouscomptefinController::class, 'fetch_single_ssouscompte']);
Route::get('/fetch_ssouscompte_sous/{refSousCompte}', [tssouscomptefinController::class, 'fetch_ssouscompte_sous']);   
Route::get('/fetch_ssouscompte_sous2/{refSousCompte}', [tssouscomptefinController::class, 'fetch_ssouscompte_sous2']);         
Route::post('/insert_ssouscomptefin', [tssouscomptefinController::class, 'insert_ssouscompte']);
Route::post('/update_ssouscomptefin/{id}', [tssouscomptefinController::class, 'update_ssouscompte']);
Route::get('/delete_ssouscomptefin/{id}', [tssouscomptefinController::class, 'delete_ssouscompte']);
//fetch_produit_type4
Route::get('/fetch_produitfin', [tproduitfinController::class, 'all']);
Route::get('/fetch_single_produit/{id}', [tproduitfinController::class, 'fetch_single_produit']);
Route::get('/fetch_produit_type/{refTypeProduit}', [tproduitfinController::class, 'fetch_produit_type']);   
Route::get('/fetch_produit_type2/{refTypeProduit}', [tproduitfinController::class, 'fetch_produit_type2']);
Route::get('/fetch_produit_type3', [tproduitfinController::class, 'fetch_produit_type3']);
Route::get('/fetch_produit_type4', [tproduitfinController::class, 'fetch_produit_type4']);    
Route::get('/fetch_produit2', [tproduitfinController::class, 'fetch_produit2']);       
Route::post('/insert_produitfin', [tproduitfinController::class, 'insert_produit']);
Route::post('/update_produitfin/{id}', [tproduitfinController::class, 'update_produit']);
Route::get('/delete_produitfin/{id}', [tproduitfinController::class, 'delete_produit']);

Route::get('/fetch_entetefacturation', [tentetefacturationController::class, 'all']);
Route::get('/fetch_sommation_recette', [tentetefacturationController::class, 'fetch_sommation_recette']);
Route::get('/fetch_sommation_depense', [tentetefacturationController::class, 'fetch_sommation_depense']);
Route::get('/fetch_max_entete_paiement_Mouvement', [tentetefacturationController::class, 'fetch_max_entete_paiement_Mouvement']);
Route::get('/fetch_single_entetefacturation/{id}', [tentetefacturationController::class, 'fetch_single_entete']);
Route::get('/fetch_entetefacturation_mouvement/{refMouvement}', [tentetefacturationController::class, 'fetch_entete_mouvement']);
Route::get('/insert_entetefacturation', [tentetefacturationController::class, 'insert_entete']);
Route::post('/update_entetefacturation/{id}', [tentetefacturationController::class, 'update_entete']);
Route::get('/delete_entetefacturation/{id}', [tentetefacturationController::class, 'delete_entete']);

Route::get('/fetch_detailfacturation', [tdetailfacturationController::class, 'all']);
Route::get('/fetch_single_detailfacturation/{id}', [tdetailfacturationController::class, 'fetch_single_entete']);
Route::get('/fetch_detailfacturation_entete/{refEnteteFacturation}', [tdetailfacturationController::class, 'fetch_detail_entete']);
Route::get('/fetch_detailfacture_for_entete/{refEnteteFacturation}', [tdetailfacturationController::class, 'fetch_detailfacture_for_entete']);
Route::post('/insert_detailfacturation', [tdetailfacturationController::class, 'insert_entete']);
Route::post('/update_detailfacturation/{id}', [tdetailfacturationController::class, 'update_entete']);
Route::get('/delete_detailfacturation/{id}', [tdetailfacturationController::class, 'delete_entete']);

Route::post("insert_detailfacturation_globale", [tdetailfacturationController::class, 'insert_dataGlobal']);
Route::post("insert_detailfacturation_cash/{id}", [tdetailfacturationController::class, 'insert_paiement_cash']);
Route::post("insert_detailfacturation_globale_cash", [tdetailfacturationController::class, 'insert_dataGlobalCash']);

Route::get('/fetch_paiefacturation', [tpaiefacturationController::class, 'all']);
Route::get('/fetch_single_paiefacturation/{id}', [tpaiefacturationController::class, 'fetch_single_paie']);
Route::get('/fetch_paie_facturation/{refEnteteFacturation}', [tpaiefacturationController::class, 'fetch_paie_facturation']);
Route::post('/insert_paiefacturation', [tpaiefacturationController::class, 'insert_paie']);
Route::post('/insert_paiefacturation_direct', [tpaiefacturationController::class, 'insert_paie_direct']);
Route::post('/update_paiefacturation/{id}', [tpaiefacturationController::class, 'update_paie']);
Route::get('/delete_paiefacturation/{id}', [tpaiefacturationController::class, 'delete_paie']);
Route::post('/cloturer_Caisse', [tpaiefacturationController::class, 'cloturer_Caisse']);
//insert_paie_direct
// PARTIE MEDECIN ==================================================================

Route::get("fetch_fonctionmedecin", [tfonctionmedecinController::class, 'index']);
Route::get("fetch_single_fonctionmedecin/{id}",[tfonctionmedecinController::class,'edit']);
Route::get("delete_fonctionmedecin/{id}", [tfonctionmedecinController::class,'destroy']);
Route::post("insert_fonctionmedecin", [tfonctionmedecinController::class,'store']);
Route::get("destroyMessage/{id}", [tfonctionmedecinController::class, 'destroyMessage']);

Route::get("fetch_servicehopital", [tservicehopitalController::class, 'index']);
Route::get("fetch_single_servicehopital/{id}",[tservicehopitalController::class,'edit']);
Route::get("delete_servicehopital/{id}", [tservicehopitalController::class,'destroy']);
Route::post("insert_servicehopital", [tservicehopitalController::class,'store']);

Route::get("fetch_categoriemedecin", [tcategoriemedecinController::class, 'index']);
Route::get("fetch_single_categoriemedecin/{id}",[tcategoriemedecinController::class,'edit']);
Route::get("delete_categoriemedecin/{id}", [tcategoriemedecinController::class,'destroy']);
Route::post("insert_categoriemedecin", [tcategoriemedecinController::class,'store']);
Route::get("destroyMessage/{id}", [tcategoriemedecinController::class, 'destroyMessage']);

Route::get("fetch_medecin", [tmedecinController::class, 'index']);
Route::get("fetch_list_categoriemedecin", [tmedecinController::class, 'fetch_list_categorie']);
Route::get("fetch_list_fonctionmedecin", [tmedecinController::class, 'fetch_list_fonction']);
Route::get("fetch_single_medecin/{id}", [tmedecinController::class, 'edit']);
Route::get("delete_medecin/{id}", [tmedecinController::class, 'destroy']);
Route::post("insert_medecin", [tmedecinController::class, 'insertData']);
Route::post("update_medecin", [tmedecinController::class, 'updateData']);
Route::get("Profiletmedecin/{id}", [tmedecinController::class, 'ProfiletClient']);



// PARTIE AGENDA======================================================================


Route::get('/fetch_agenda', [agendamedecinController::class, 'index']);
Route::get('/fetch_single_agenda/{id}', [agendamedecinController::class, 'fetch_single_agenda']);
Route::get('/fetch_agenda_for_medecin/{refEntete}', [agendamedecinController::class, 'fetch_agenda_for_medecin']);        
Route::post('/insert_agenda', [agendamedecinController::class, 'insert_agenda']);
Route::post('/update_agenda/{id}', [agendamedecinController::class, 'update_agenda']);
Route::post('/update_statut_agenda/{id}', [agendamedecinController::class, 'update_statut_agenda']);
Route::get('/delete_agenda/{id}', [agendamedecinController::class, 'delete_agenda']);


// PARTIE HOSPITALISATION =====================================================================

Route::get('/fetch_detailplansoin', [tdetailplansoinController::class, 'all']);
Route::get('/fetch_single_detailplansoin/{id}', [tdetailplansoinController::class, 'fetch_single_detailplansoin']);
Route::get('/fetch_detail_plan/{refPlanSoin}', [tdetailplansoinController::class, 'fetch_detail_plan']);        
Route::post('/insert_detailplansoin', [tdetailplansoinController::class, 'insert_detailplansoin']);
Route::post('/update_detailplansoin/{id}', [tdetailplansoinController::class, 'update_detailplansoin']);
Route::get('/delete_detailplansoin/{id}', [tdetailplansoinController::class, 'delete_detailplansoin']);

Route::get('/fetch_detailsortie', [tdetailsortiehospitaliserController::class, 'all']);
Route::get('/fetch_single_detailsortiehospitaliser/{id}', [tdetailsortiehospitaliserController::class, 'fetch_single_detailsortiehospitaliser']);
Route::get('/fetch_detail_sortie/{refSortriHospi}', [tdetailsortiehospitaliserController::class, 'fetch_detail_sortie']);        
Route::post('/insert_detailsortiehospitaliser', [tdetailsortiehospitaliserController::class, 'insert_detailsortiehospitaliser']);
Route::post('/update_detailsortiehospitaliser/{id}', [tdetailsortiehospitaliserController::class, 'update_detailsortiehospitaliser']);
Route::get('/delete_detailsortiehospitaliser/{id}', [tdetailsortiehospitaliserController::class, 'delete_detailsortiehospitaliser']);

Route::get('/fetch_hospitalisation', [thospitalisationController::class, 'all']);
Route::get('/fetch_reanimation', [thospitalisationController::class, 'fetch_reanimation']);

Route::get('/fetch_hospitalisation_sortie', [thospitalisationController::class, 'fetch_hospitalisation_sortie']);
Route::get('/fetch_reanimation_sortie', [thospitalisationController::class, 'fetch_reanimation_sortie']);

Route::get('/fetch_single_hospitalisation/{id}', [thospitalisationController::class, 'fetch_single_hospitalisation']);
Route::get('/fetch_hospitalisation_cons/{refDetailCons}', [thospitalisationController::class, 'fetch_hospitalisation_cons']);        
Route::post('/insert_hospitalisation', [thospitalisationController::class, 'insert_hospitalisation']);
Route::post('/update_hospitalisation/{id}', [thospitalisationController::class, 'update_hospitalisation']);
Route::get('/delete_hospitalisation/{id}', [thospitalisationController::class, 'delete_hospitalisation']);

Route::get('/fetch_lit', [tlitController::class, 'all']);
Route::get('/fetch_single_lit/{id}', [tlitController::class, 'fetch_single_lit']);
Route::get('/fetch_lit_Salle2/{refSalle}', [tlitController::class, 'fetch_lit_Salle2']);
Route::get('/fetch_lit_salle/{refSalle}', [tlitController::class, 'fetch_lit_salle']);        
Route::post('/insert_lit', [tlitController::class, 'insert_lit']);
Route::post('/update_lit/{id}', [tlitController::class, 'update_lit']);
Route::get('/delete_lit/{id}', [tlitController::class, 'delete_lit']);

Route::get('/fetch_plansoin', [tplansoinController::class, 'all']);
Route::get('/fetch_single_plansoin/{id}', [tplansoinController::class, 'fetch_single_plansoin']);
Route::get('/fetch_plan_hospitaliser/{refHospitaliser}', [tplansoinController::class, 'fetch_plan_hospitaliser']);        
Route::post('/insert_plansoin', [tplansoinController::class, 'insert_plansoin']);
Route::post('/update_plansoin/{id}', [tplansoinController::class, 'update_plansoin']); 
Route::get('/delete_plansoin/{id}', [tplansoinController::class, 'delete_plansoin']);

Route::get("fetch_salle", [tsalleController::class, 'index']);
Route::get("fetch_single_salle/{id}",[tsalleController::class,'edit']);
Route::get("delete_salle/{id}", [tsalleController::class,'destroy']);
Route::post("insert_salle", [tsalleController::class,'store']);
Route::get("fetch_salle_2", [tsalleController::class, 'fetch_salle_2']);

Route::get("fetch_servicehospi", [tservicehospiController::class, 'index']);
Route::get("fetch_single_servicehospi/{id}",[tservicehospiController::class,'edit']);
Route::get("delete_servicehospi/{id}", [tservicehospiController::class,'destroy']);
Route::post("insert_servicehospi", [tservicehospiController::class,'store']);
Route::get("fetch_servicehospi_2", [tservicehospiController::class, 'fetch_servicehospi_2']);

Route::get("fetch_servicesoin", [tservicesoinController::class, 'index']);
Route::get("fetch_single_servicesoin/{id}",[tservicesoinController::class,'edit']);
Route::get("delete_servicesoin/{id}", [tservicesoinController::class,'destroy']);
Route::post("insert_servicesoin", [tservicesoinController::class,'store']);
Route::get("fetch_servicesoin_2", [tservicesoinController::class, 'fetch_servicesoin_2']);

Route::get('/fetch_soinhospitaliser', [tsoinhospitaliserController::class, 'all']);
Route::get('/fetch_single_soinhospitaliser/{id}', [tsoinhospitaliserController::class, 'fetch_single_soinhospitaliser']);
Route::get('/fetch_soin_hospitaliser/{refHospitaliser}', [tsoinhospitaliserController::class, 'fetch_soin_hospitaliser']);        
Route::post('/insert_soinhospitaliser', [tsoinhospitaliserController::class, 'insert_soinhospitaliser']);
Route::post('/update_soinhospitaliser/{id}', [tsoinhospitaliserController::class, 'update_soinhospitaliser']);
Route::get('/delete_soinhospitaliser/{id}', [tsoinhospitaliserController::class, 'delete_soinhospitaliser']);
      
Route::get('/fetch_sortiehospitaliser', [tsortiehospitaliserController::class, 'all']);
Route::get('/fetch_single_sortiehospitaliser/{id}', [tsortiehospitaliserController::class, 'fetch_single_sortiehospitaliser']);
Route::get('/fetch_sortie_hospitaliser/{refHospitaliser}', [tsortiehospitaliserController::class, 'fetch_sortie_hospitaliser']);        
Route::post('/insert_sortiehospitaliser', [tsortiehospitaliserController::class, 'insert_sortiehospitaliser']);
Route::post('/update_sortiehospitaliser/{id}', [tsortiehospitaliserController::class, 'update_sortiehospitaliser']);
Route::get('/delete_sortiehospitaliser/{id}', [tsortiehospitaliserController::class, 'delete_sortiehospitaliser']);

Route::get('/fetch_suivihospitaliser', [tsuivihospitaliserController::class, 'all']);
Route::get('/fetch_single_suivihospitaliser/{id}', [tsuivihospitaliserController::class, 'fetch_single_suivihospitaliser']);
Route::get('/fetch_suivi_hospitaliser/{refHospitaliser}', [tsuivihospitaliserController::class, 'fetch_suivi_hospitaliser']);        
Route::post('/insert_suivihospitaliser', [tsuivihospitaliserController::class, 'insert_suivihospitaliser']);
Route::post('/update_suivihospitaliser/{id}', [tsuivihospitaliserController::class, 'update_suivihospitaliser']);
Route::get('/delete_suivihospitaliser/{id}', [tsuivihospitaliserController::class, 'delete_suivihospitaliser']);

Route::get('/fetch_traitementhospitaliser', [ttraitementhospitaliserController::class, 'all']);
Route::get('/fetch_single_traitementhospitaliser/{id}', [ttraitementhospitaliserController::class, 'fetch_single_traitementhospitaliser']);
Route::get('/fetch_traitement_hospitaliser/{refHospitaliser}', [ttraitementhospitaliserController::class, 'fetch_traitement_hospitaliser']);        
Route::post('/insert_traitementhospitaliser', [ttraitementhospitaliserController::class, 'insert_traitementhospitaliser']);
Route::post('/update_traitementhospitaliser/{id}', [ttraitementhospitaliserController::class, 'update_traitementhospitaliser']);
Route::get('/delete_traitementhospitaliser/{id}', [ttraitementhospitaliserController::class, 'delete_traitementhospitaliser']);

//=========== PARTIE PHARMACIE ================================================================================

    Route::get('/fetch_entetebesoin', [tmed_entetebesoinController::class, 'all']);
    Route::get('/fetch_single_entetebesoin/{id}', [tmed_entetebesoinController::class, 'fetch_single_entete']);
    Route::get('/fetch_besoin_mouvement/{refMouvement}', [tmed_entetebesoinController::class, 'fetch_entete_mouvement']);        
    Route::post('/insert_entetebesoin', [tmed_entetebesoinController::class, 'insert_entete']);
    Route::post('/update_entetebesoin/{id}', [tmed_entetebesoinController::class, 'update_entete']);
    Route::get('/delete_entetebesoin/{id}', [tmed_entetebesoinController::class, 'delete_entete']);

    Route::get('/fetch_enteteusage_service', [tmed_entete_usageserviceController::class, 'all']);
    Route::get('/fetch_single_enteteusage_service/{id}', [tmed_entete_usageserviceController::class, 'fetch_single_entete']);
    Route::get('/fetch_usage_service_mouvement/{refMouvement}', [tmed_entete_usageserviceController::class, 'fetch_entete_mouvement']);        
    Route::post('/insert_enteteusage_service', [tmed_entete_usageserviceController::class, 'insert_entete']);
    Route::post('/update_enteteusage_service/{id}', [tmed_entete_usageserviceController::class, 'update_entete']);
    Route::get('/delete_enteteusage_service/{id}', [tmed_entete_usageserviceController::class, 'delete_entete']);

    Route::get('/fetch_detail_besoin', [tmed_detailbesoinController::class, 'all']);
    Route::get('/fetch_single_detail_besoin/{id}', [tmed_detailbesoinController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_entete_besoin/{refEntete}', [tmed_detailbesoinController::class, 'fetch_detail_for_entete']);        
    Route::post('/insert_detail_besoin', [tmed_detailbesoinController::class, 'insert_detail']);
    Route::post('/update_detail_besoin/{id}', [tmed_detailbesoinController::class, 'update_detail']);
    Route::get('/delete_detail_besoin/{id}', [tmed_detailbesoinController::class, 'delete_detail']);

    Route::get('/fetch_detail_usage_service', [tmed_detail_usageserviceController::class, 'all']);
    Route::get('/fetch_single_detail_usage_service/{id}', [tmed_detail_usageserviceController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_entete_usage_service/{refEntete}', [tmed_detail_usageserviceController::class, 'fetch_detail_for_entete']);        
    Route::post('/insert_detail_usage_service', [tmed_detail_usageserviceController::class, 'insert_detail']);
    Route::post('/update_detail_usage_service/{id}', [tmed_detail_usageserviceController::class, 'update_detail']);
    Route::get('/delete_detail_usage_service/{id}', [tmed_detail_usageserviceController::class, 'delete_detail']);

    Route::get('/fetch_enteteentree', [tenteteentreeController::class, 'all']);
    Route::get('/fetch_single_enteteentree/{id}', [tenteteentreeController::class, 'fetch_single_entete']);
    Route::get('/fetch_entete_fournisseur/{refFournisseur}', [tenteteentreeController::class, 'fetch_entete_fournisseur']);        
    Route::post('/insert_enteteentree', [tenteteentreeController::class, 'insert_entete']);
    Route::post('/update_enteteentree/{id}', [tenteteentreeController::class, 'update_entete']);
    Route::get('/delete_enteteentree/{id}', [tenteteentreeController::class, 'delete_entete']);
    Route::get('/fetch_list_fournisseur', [tenteteentreeController::class, 'fetch_list_fournisseur']);
    
    Route::get('/fetch_entetevente', [tenteteventeController::class, 'all']);
    Route::get('/fetch_single_entetevente/{id}', [tenteteventeController::class, 'fetch_single_entete']);
    Route::get('/fetch_vente_mouvement/{refMouvement}', [tenteteventeController::class, 'fetch_entete_mouvement']);        
    Route::post('/insert_entetevente', [tenteteventeController::class, 'insert_entete']);
    Route::post('/update_entetevente/{id}', [tenteteventeController::class, 'update_entete']);
    Route::get('/delete_entetevente/{id}', [tenteteventeController::class, 'delete_entete']);
    
    Route::get('/fetch_detailentree', [tdetailentreeController::class, 'all']);
    Route::get('/fetch_single_detailentree/{id}', [tdetailentreeController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_enteteentree/{refEntete}', [tdetailentreeController::class, 'fetch_detail_for_entete']);  
    Route::get('/fetch_single_medicament2/{id}', [tdetailentreeController::class, 'fetch_single_medicament2']);      
    Route::post('/insert_detailentree', [tdetailentreeController::class, 'insert_detail']);
    Route::post('/update_detailentree/{id}', [tdetailentreeController::class, 'update_detail']);
    Route::get('/delete_detailentree/{id}', [tdetailentreeController::class, 'delete_detail']);
    Route::get('/fetch_list_medicament2', [tdetailentreeController::class, 'fetch_list_medicament2']);

    Route::get('/fetch_detailvente', [tdetailventeController::class, 'all']);
    Route::get('/fetch_single_detailvente/{id}', [tdetailventeController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_entetevente/{refEntete}', [tdetailventeController::class, 'fetch_detail_for_entete']);        
    Route::post('/insert_detailvente', [tdetailventeController::class, 'insert_detail']);
    Route::post('/update_detailvente/{id}', [tdetailventeController::class, 'update_detail']);
    Route::get('/delete_detailvente/{id}', [tdetailventeController::class, 'delete_detail']);
    Route::get('/fetch_list_detail_medicament2/{refmedicament}', [tdetailventeController::class, 'fetch_list_detail_medicament2']);

    Route::get('/fetch_entetesortie', [tentetesortieController::class, 'all']);
    Route::get('/fetch_single_entetesortie/{id}', [tentetesortieController::class, 'fetch_single_entete']);
    Route::get('/fetch_entete_service/{refService}', [tentetesortieController::class, 'fetch_entete_service']);        
    Route::post('/insert_entetesortie', [tentetesortieController::class, 'insert_entete']);
    Route::post('/update_entetesortie/{id}', [tentetesortieController::class, 'update_entete']);
    Route::get('/delete_entetesortie/{id}', [tentetesortieController::class, 'delete_entete']);
    Route::get('/fetch_list_service', [tentetesortieController::class, 'fetch_list_service']);
    Route::get('/fetch_list_agent', [tentetesortieController::class, 'fetch_list_agent']);

    Route::get('/fetch_detailsortie', [tdetailsortieController::class, 'all']);
    Route::get('/fetch_single_detailsortie/{id}', [tdetailsortieController::class, 'fetch_single_detail']);
    Route::get('/fetch_detail_entetesortie/{refEntete}', [tdetailsortieController::class, 'fetch_detail_for_entete']);        
    Route::post('/insert_detailsortie', [tdetailsortieController::class, 'insert_detail']);
    Route::post('/update_detailsortie/{id}', [tdetailsortieController::class, 'update_detail']);
    Route::get('/delete_detailsortie/{id}', [tdetailsortieController::class, 'delete_detail']);
   
    
//======== PARTIE CHIRURGIE ====================================================

Route::get("fetch_acteoperatoire", [tacteoperatoireController::class, 'index']);
Route::get("fetch_tope_acteoperatoire_2", [tacteoperatoireController::class, 'fetch_tope_acteoperatoire_2']);
Route::get("fetch_single_acteoperatoire/{id}",[tacteoperatoireController::class,'edit']);
Route::get("delete_acteoperatoire/{id}", [tacteoperatoireController::class,'destroy']);
Route::post("insert_acteoperatoire", [tacteoperatoireController::class,'store']);

Route::get('/fetch_affectationanesthesie', [taffectationanesthesieController::class, 'all']);
Route::get('/fetch_single_affectationanesthesie/{id}', [taffectationanesthesieController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_anesthesie/{refDetailOpe}', [taffectationanesthesieController::class, 'fetch_detail_entete']);        
Route::post('/insert_affectationanesthesie', [taffectationanesthesieController::class, 'insert_detail']);
Route::post('/update_affectationanesthesie/{id}', [taffectationanesthesieController::class, 'update_detail']);
Route::get('/delete_affectationanesthesie/{id}', [taffectationanesthesieController::class, 'delete_detail']);

Route::get('/fetch_affectacteoperatoire', [taffectationoperationController::class, 'all']);
Route::get('/fetch_single_affectacteoperatoire/{id}', [taffectationoperationController::class, 'fetch_single_detail']);
Route::get('/fetch_acte_detailoperation/{refDetailOpe}', [taffectationoperationController::class, 'fetch_detail_entete']);        
Route::post('/insert_affectacteoperatoire', [taffectationoperationController::class, 'insert_detail']);
Route::post('/update_affectacteoperatoire/{id}', [taffectationoperationController::class, 'update_detail']);
Route::get('/delete_affectacteoperatoire/{id}', [taffectationoperationController::class, 'delete_detail']);

Route::get('/fetch_consentement', [tconsentementController::class, 'all']);
Route::get('/fetch_single_consentement/{id}', [tconsentementController::class, 'fetch_single_detail']);
Route::get('/fetch_consentement_detailoperation/{refDetailOpe}', [tconsentementController::class, 'fetch_detail_entete']);        
Route::post('/insert_consentement', [tconsentementController::class, 'insert_detail']);
Route::post('/update_consentement/{id}', [tconsentementController::class, 'update_detail']);
Route::get('/delete_consentement/{id}', [tconsentementController::class, 'delete_detail']);

Route::get("fetch_departement", [tdepartementController::class, 'index']);
Route::get("fetch_tope_departement_2", [tdepartementController::class, 'fetch_tope_departement_2']);
Route::get("fetch_single_departement/{id}",[tdepartementController::class,'edit']);
Route::get("delete_departement/{id}", [tdepartementController::class,'destroy']);
Route::post("insert_departement", [tdepartementController::class,'store']);

Route::get('/fetch_detailanesthesie', [tdetailanesthesieController::class, 'all']);
Route::get('/fetch_single_detailanesthesie/{id}', [tdetailanesthesieController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_anesthesie/{refAnesthesie}', [tdetailanesthesieController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailanesthesie', [tdetailanesthesieController::class, 'insert_detail']);
Route::post('/update_detailanesthesie/{id}', [tdetailanesthesieController::class, 'update_detail']);
Route::get('/delete_detailanesthesie/{id}', [tdetailanesthesieController::class, 'delete_detail']);

Route::get('/fetch_detailconsacteoperatoire', [tdetailconsoacteopeController::class, 'all']);
Route::get('/fetch_single_detailconsacteoperatoire/{id}', [tdetailconsoacteopeController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_consomationacteope/{refEnteteCons}', [tdetailconsoacteopeController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailconsacteoperatoire', [tdetailconsoacteopeController::class, 'insert_detail']);
Route::post('/update_detailconsacteoperatoire/{id}', [tdetailconsoacteopeController::class, 'update_detail']);
Route::get('/delete_detailconsacteoperatoire/{id}', [tdetailconsoacteopeController::class, 'delete_detail']);

Route::get('/fetch_detailconsomationope', [tdetailconsomationopeController::class, 'all']);
Route::get('/fetch_single_detailconsomationope/{id}', [tdetailconsomationopeController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteconsomationope/{refEnteteConso}', [tdetailconsomationopeController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailconsomationope', [tdetailconsomationopeController::class, 'insert_detail']);
Route::post('/update_detailconsomationope/{id}', [tdetailconsomationopeController::class, 'update_detail']);
Route::get('/delete_detailconsomationope/{id}', [tdetailconsomationopeController::class, 'delete_detail']);

Route::get('/fetch_detailevaluationope', [tdetailevaluationController::class, 'all']);
Route::get('/fetch_single_detailevaluationope/{id}', [tdetailevaluationController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteevaluationope/{refEnteteEva}', [tdetailevaluationController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailevaluationope', [tdetailevaluationController::class, 'insert_detail']);
Route::post('/update_detailevaluationope/{id}', [tdetailevaluationController::class, 'update_detail']);
Route::get('/delete_detailevaluationope/{id}', [tdetailevaluationController::class, 'delete_detail']);
//fetch_tope_medecin_2
Route::get('/fetch_detailoperation', [tdetailoperationController::class, 'all']);
Route::get('/fetch_tope_medecin_2', [tdetailoperationController::class, 'fetch_tope_medecin_2']);
Route::get('/fetch_single_detailoperation/{id}', [tdetailoperationController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteoperation/{refEnteteOpe}', [tdetailoperationController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailoperation', [tdetailoperationController::class, 'insert_detail']);
Route::post('/update_detailoperation/{id}', [tdetailoperationController::class, 'update_detail']);
Route::get('/delete_detailoperation/{id}', [tdetailoperationController::class, 'delete_detail']);

Route::get('/fetch_detailsurveillance', [tdetailsurveillanceController::class, 'all']);
Route::get('/fetch_single_detailsurveillance/{id}', [tdetailsurveillanceController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entetesurveillance/{refEnteteSurv}', [tdetailsurveillanceController::class, 'fetch_detail_entete']);        
Route::post('/insert_detailsurveillance', [tdetailsurveillanceController::class, 'insert_detail']);
Route::post('/update_detailsurveillance/{id}', [tdetailsurveillanceController::class, 'update_detail']);
Route::get('/delete_detailsurveillance/{id}', [tdetailsurveillanceController::class, 'delete_detail']);

Route::get('/fetch_enteteanesthesie', [tenteteanesthesieController::class, 'all']);
Route::get('/fetch_single_enteteanesthesie/{id}', [tenteteanesthesieController::class, 'fetch_single_detail']);
Route::get('/fetch_anesthesie_enteteoperation/{refEnteteOpe}', [tenteteanesthesieController::class, 'fetch_detail_entete']);        
Route::post('/insert_enteteanesthesie', [tenteteanesthesieController::class, 'insert_detail']);
Route::post('/update_enteteanesthesie/{id}', [tenteteanesthesieController::class, 'update_detail']);
Route::get('/delete_enteteanesthesie/{id}', [tenteteanesthesieController::class, 'delete_detail']);


Route::get('/fetch_cons_preanesthesique', [tconspresanesthesieController::class, 'all']);
Route::get('/fetch_single_cons_preanesthesique/{id}', [tconspresanesthesieController::class, 'fetch_single_detail']);
Route::get('/fetch_cons_preanesthesique_enteteoperation/{refEnteteOperation}', [tconspresanesthesieController::class, 'fetch_detail_entete']);        
Route::post('/insert_cons_preanesthesique', [tconspresanesthesieController::class, 'insert_detail']);
Route::post('/update_cons_preanesthesique/{id}', [tconspresanesthesieController::class, 'update_detail']);
Route::get('/delete_cons_preanesthesique/{id}', [tconspresanesthesieController::class, 'delete_detail']);

Route::get('/fetch_enteteconsomationope', [tenteteconsomationopeController::class, 'all']);
Route::get('/fetch_single_enteteconsomationope/{id}', [tenteteconsomationopeController::class, 'fetch_single_detail']);
Route::get('/fetch_consomation_enteteoperation/{refEnteteOpe}', [tenteteconsomationopeController::class, 'fetch_detail_entete']);        
Route::post('/insert_enteteconsomationope', [tenteteconsomationopeController::class, 'insert_detail']);
Route::post('/update_enteteconsomationope/{id}', [tenteteconsomationopeController::class, 'update_detail']);
Route::get('/delete_enteteconsomationope/{id}', [tenteteconsomationopeController::class, 'delete_detail']);

Route::get('/fetch_enteteevaluationope', [tenteteevaluationController::class, 'all']);
Route::get('/fetch_single_enteteevaluationope/{id}', [tenteteevaluationController::class, 'fetch_single_detail']);
Route::get('/fetch_evaluation_enteteoperation/{refEnteteOpe}', [tenteteevaluationController::class, 'fetch_detail_entete']);        
Route::post('/insert_enteteevaluationope', [tenteteevaluationController::class, 'insert_detail']);
Route::post('/update_enteteevaluationope/{id}', [tenteteevaluationController::class, 'update_detail']);
Route::get('/delete_enteteevaluationope/{id}', [tenteteevaluationController::class, 'delete_detail']);


//fecth_enteteoperatoin_jour
Route::get('/fecth_enteteoperation_jour', [tenteteoperationController::class, 'fecth_enteteoperatoin_jour']);
Route::get('/fetch_enteteoperation', [tenteteoperationController::class, 'all']);
Route::get('/fetch_single_enteteoperation/{id}', [tenteteoperationController::class, 'fetch_single_enteteoperation']);
Route::get('/fetch_operation_detailconsultation/{refDetailCons}', [tenteteoperationController::class, 'fetch_operation_cons']);        
Route::post('/insert_enteteoperation', [tenteteoperationController::class, 'insert_enteteoperation']);
Route::post('/update_enteteoperation/{id}', [tenteteoperationController::class, 'update_enteteoperation']);
Route::get('/delete_enteteoperation/{id}', [tenteteoperationController::class, 'delete_enteteoperation']);
//
Route::get('/fetch_entetesurveillanceope', [tentetesurveillanceController::class, 'all']);
Route::get('/fetch_single_entetesurveillanceope/{id}', [tentetesurveillanceController::class, 'fetch_single_detail']);
Route::get('/fetch_surveillance_anesthesie/{refAnesthesie}', [tentetesurveillanceController::class, 'fetch_detail_entete']);        
Route::post('/insert_entetesurveillanceope', [tentetesurveillanceController::class, 'insert_detail']);
Route::post('/update_entetesurveillanceope/{id}', [tentetesurveillanceController::class, 'update_detail']);
Route::get('/delete_entetesurveillanceope/{id}', [tentetesurveillanceController::class, 'delete_detail']);

Route::get("fetch_intervention", [tinterventionController::class, 'index']);
Route::get("fetch_tope_intervention_2", [tinterventionController::class, 'fetch_tope_intervention_2']);
Route::get("fetch_single_intervention/{id}",[tinterventionController::class,'edit']);
Route::get("delete_intervention/{id}", [tinterventionController::class,'destroy']);
Route::post("insert_intervention", [tinterventionController::class,'store']);

Route::get("fetch_rubriquesurveillance", [trubriquesurveillanceController::class, 'index']);
Route::get("fetch_tope_rubriquesurveillance_2", [trubriquesurveillanceController::class, 'fetch_tope_rubriquesurveillance_2']);
Route::get("fetch_single_rubriquesurveillance/{id}",[trubriquesurveillanceController::class,'edit']);
Route::get("delete_rubriquesurveillance/{id}", [trubriquesurveillanceController::class,'destroy']);
Route::post("insert_rubriquesurveillance", [trubriquesurveillanceController::class,'store']);

Route::get("fetch_typeanesthesie", [ttypeanesthesieController::class, 'index']);
Route::get("fetch_tope_typeanesthesie_2", [ttypeanesthesieController::class, 'fetch_tope_typeanesthesie_2']);
Route::get("fetch_single_typeanesthesie/{id}",[ttypeanesthesieController::class,'edit']);
Route::get("delete_typeanesthesie/{id}", [ttypeanesthesieController::class,'destroy']);
Route::post("insert_typeanesthesie", [ttypeanesthesieController::class,'store']);


//taffectationabonneController torganisationController  fetch_list_organisation

Route::get("fetch_organisationabone", [torganisationController::class, 'index']);
Route::get("fetch_tconf_organisationabone_2", [torganisationController::class, 'fetch_tconf_organisationabone_2']);
Route::get("fetch_single_organisationabone/{id}",[torganisationController::class,'edit']);
Route::get("delete_organisationabone/{id}", [torganisationController::class,'destroy']);
Route::post("insert_organisationabone", [torganisationController::class,'store']);


Route::get('/fetch_affectationabone', [taffectationabonneController::class, 'all']);
Route::get('/fetch_list_organisation', [taffectationabonneController::class, 'fetch_list_organisation']);
Route::get('/fetch_affectationabone_mvt', [taffectationabonneController::class, 'fetch_affectationabone_mvt']);
Route::get('/fetch_single_affectationabone/{id}', [taffectationabonneController::class, 'fetch_single_affectationabone']);
Route::get('/fetch_affectationabone_malade/{refMalade}', [taffectationabonneController::class, 'fetch_affectationabone_malade']);        
Route::post('/insert_affectationabone', [taffectationabonneController::class, 'insert_affectationabone']);
Route::post('/update_affectationabone/{id}', [taffectationabonneController::class, 'update_affectationabone']);
Route::get('/delete_affectationabone/{id}', [taffectationabonneController::class, 'delete_affectationabone']);


Route::get("fetch_banque", [tbanqueController::class, 'index']);
Route::get("fetch_list_mode", [tbanqueController::class, 'fetch_list_mode']);
Route::get("fetch_tconf_banque_2", [tbanqueController::class, 'fetch_tconf_banque_2']);
Route::get('/fetch_list_banque/{nom_mode}', [tbanqueController::class, 'fetch_list_banque']);
Route::get("fetch_single_banque/{id}",[tbanqueController::class,'edit']);
Route::get("delete_banque/{id}", [tbanqueController::class,'destroy']);
Route::post("insert_banque", [tbanqueController::class,'store']);

Route::get("fetch_cloture_caisse", [tcloturecaisseController::class, 'index']);
Route::get("fetch_single_cloture_caisse/{id}",[tcloturecaisseController::class,'edit']);
Route::get("delete_cloture_caisse/{id}", [tcloturecaisseController::class,'destroy']);
Route::post("insert_cloture_caisse", [tcloturecaisseController::class,'store']);

//========= PARTIE RAPPORT =================================================================================
////fetch_rapport_detailfacture_date_caissier
Route::get("fetch_rapport_detailfacture_date_caissier", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date_caissier']);
Route::get("fetch_rapport_detailfacture_date", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date']);
Route::get("fetch_rapport_detailfacture_date_departement", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date_departement']);
Route::get("fetch_rapport_detailfacture_date_service", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date_service']);
Route::get("fetch_rapport_detailfacture_date_medecin", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date_medecin']);
Route::get("fetch_rapport_detailfacture_date_medecin_service", [Pdf_DetailFactureController::class, 'fetch_rapport_detailfacture_date_medecin_service']);

Route::get("fetch_rapport_detailfactureprivee_date_caissier", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date_caissier']);
Route::get("fetch_rapport_detailfactureprivee_date", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date']);
Route::get("fetch_rapport_detailfactureprivee_date_departement", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date_departement']);
Route::get("fetch_rapport_detailfactureprivee_date_service", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date_service']);
Route::get("fetch_rapport_detailfactureprivee_date_medecin", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date_medecin']);
Route::get("fetch_rapport_detailfactureprivee_date_medecin_service", [Pdf_DetailFacturePriveeController::class, 'fetch_rapport_detailfacture_date_medecin_service']);

Route::get("fetch_rapport_paiementfacture_date_caissier", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date_caissier']);
Route::get("fetch_rapport_paiementfacture_date", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date']);
Route::get("fetch_rapport_paiementfacture_date_departement", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date_departement']);
Route::get("fetch_rapport_paiementfacture_date_service", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date_service']);
Route::get("fetch_rapport_paiementfacture_date_banque", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date_banque']);
Route::get("fetch_rapport_paiementfacture_date_banque_service", [Pdf_PaiementFactureController::class, 'fetch_rapport_paiementfacture_date_banque_service']);


Route::get("fetch_rapport_paiementfactureprivee_date_caissier", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date_caissier']);
Route::get("fetch_rapport_paiementfactureprivee_date", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date']);
Route::get("fetch_rapport_paiementfactureprivee_date_departement", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date_departement']);
Route::get("fetch_rapport_paiementfactureprivee_date_service", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date_service']);
Route::get("fetch_rapport_paiementfactureprivee_date_banque", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date_banque']);
Route::get("fetch_rapport_paiementfactureprivee_date_banque_service", [Pdf_PaiementFacturePriveeController::class, 'fetch_rapport_paiementfacture_date_banque_service']);

Route::get("fetch_rapport_paiementfactureabonnee_date_caissier_organisation", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_caissier_organisation']);
Route::get("fetch_rapport_paiementfactureabonnee_date_caissier", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_caissier']);
Route::get("fetch_rapport_paiementfactureabonnee_date", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date']);
Route::get("fetch_rapport_paiementfactureabonnee_date_departement", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_departement']);
Route::get("fetch_rapport_paiementfactureabonnee_date_service", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_service']);
Route::get("fetch_rapport_paiementfactureabonnee_date_banque", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_banque']);
Route::get("fetch_rapport_paiementfactureabonnee_date_banque_service", [Pdf_PaiementFactureAbonneController::class, 'fetch_rapport_paiementfacture_date_banque_service']);

Route::get("fetch_rapport_sortie_compte_date", [BonSortieCaissePdfController::class, 'fetch_rapport_sortie_compte_date']);
Route::get("fetch_rapport_entree_compte_date", [BonEntreeCaissePdfController::class, 'fetch_rapport_entree_compte_date']); 


Route::get("pdf_bon_engagement", [Pdf_BonEngagementController::class, 'pdf_bon_engagement']);
Route::get("pdf_bon_etatdebesoin", [Pdf_BonEngagementController::class, 'pdf_bon_etatdebesoin']);

//fetch_rapport_paiementfacture_date_caissier
Route::get("fetch_rapport_entetefacture_date", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date']);
Route::get("fetch_rapport_detailfacture_credit_date", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_credit_date']);
Route::get("fetch_rapport_detailfacture_credit_avance_date", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_credit_avance_date']);
Route::get("fetch_rapport_entetefacture_date_departement", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date_departement']);
Route::get("fetch_rapport_entetefacture_date_service", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date_service']);
Route::get("fetch_rapport_entetefacture_date_medecin", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date_medecin']);
Route::get("fetch_rapport_entetefacture_date_medecin_service", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date_medecin_service']);
Route::get("fetch_rapport_entetefacture_date_caissier", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_date_caissier']);
Route::get("fetch_rapport_entetefacture_credit_date_caissier", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_credit_date_caissier']);
Route::get("fetch_rapport_entetefacture_Cash_date_caissier", [Pdf_EnteteFactureController::class, 'fetch_rapport_detailfacture_Cash_date_caissier']);


Route::get("fetch_rapport_entetefactureprivee_date", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date']);
Route::get("fetch_rapport_detailfactureprivee_credit_date", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_credit_date']);
Route::get("fetch_rapport_detailfactureprivee_credit_avance_date", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_credit_avance_date']);
Route::get("fetch_rapport_entetefactureprivee_date_departement", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date_departement']);
Route::get("fetch_rapport_entetefactureprivee_date_service", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date_service']);
Route::get("fetch_rapport_entetefactureprivee_date_medecin", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date_medecin']);
Route::get("fetch_rapport_entetefactureprivee_date_medecin_service", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date_medecin_service']);
Route::get("fetch_rapport_entetefactureprivee_date_caissier", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_date_caissier']);
Route::get("fetch_rapport_entetefactureprivee_credit_date_caissier", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_credit_date_caissier']);
Route::get("fetch_rapport_entetefactureprivee_Cash_date_caissier", [Pdf_EnteteFacturePriveeController::class, 'fetch_rapport_detailfacture_Cash_date_caissier']);

Route::get("fetch_rapport_detailfacture_par_organisation", [Pdf_DetailFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation']);
Route::get("fetch_rapport_detailfacture_date_organisation_all", [Pdf_DetailFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation_all']);
Route::get("fetch_rapport_detailfacture_par_organisation_service", [Pdf_DetailFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation_service']);
Route::get("fetch_rapport_detailfacture_date_produit", [Pdf_DetailFactureAbonneController::class, 'fetch_rapport_detailfacture_date_produit']);


Route::get("fetch_rapport_detailfacture_date_compte_cash", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_cash']);
Route::get("fetch_rapport_detailfacture_date_compte_credit", [Pdf_ComptabiliteController::class, 'fetch_rapport_detailfacture_date_compte_credit']);
Route::get("fetch_rapport_journal_caisse", [Pdf_ComptabiliteController::class, 'fetch_rapport_journal_caisse']);
Route::get("fetch_rapport_bilan", [Pdf_ComptabiliteController::class, 'fetch_rapport_bilan']);
Route::get("pdf_livre_caisse", [Pdf_ComptabiliteController::class, 'pdf_livre_caisse']);
Route::get("pdf_livre_banque", [Pdf_ComptabiliteController::class, 'pdf_livre_banque']);

Route::get("fetch_rapport_entetefacture_date_organisation_all", [Pdf_EnteteFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation_all']);
Route::get("fetch_rapport_entetefacture_par_organisation", [Pdf_EnteteFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation']);
Route::get("fetch_rapport_entetefacture_par_organisation_service", [Pdf_EnteteFactureAbonneController::class, 'fetch_rapport_detailfacture_date_organisation_service']);

Route::get("pdf_grand_facture_groupe_privee_data", [Pdf_FactureGroupePriveeController::class, 'pdf_grand_facture_groupe_privee_data']);
Route::get("pdf_petit_facture_groupe_privee_mouvement_data", [Pdf_FactureGroupePriveeController::class, 'pdf_petit_facture_groupe_privee_mouvement_data']);
Route::get("pdf_petit_facture_groupe_privee_data", [Pdf_FactureGroupePriveeController::class, 'pdf_petit_facture_groupe_privee_data']);
Route::get("pdf_grand_facture_groupe_privee_mouvement_data", [Pdf_FactureGroupePriveeController::class, 'pdf_grand_facture_groupe_privee_mouvement_data']);


Route::get("pdf_grand_facture_groupe_abonnee_data", [Pdf_FactureAbonneGroupeController::class, 'pdf_grand_facture_groupe_abonnee_data']);
Route::get("pdf_petit_facture_groupe_abonnee_data", [Pdf_FactureAbonneGroupeController::class, 'pdf_petit_facture_groupe_abonnee_data']);
Route::get("pdf_petit_facture_groupe_abonnee_mouvement_data", [Pdf_FactureAbonneGroupeController::class, 'pdf_petit_facture_groupe_abonnee_mouvement_data']);
Route::get("pdf_grand_facture_groupe_abonnee_mouvement_data", [Pdf_FactureAbonneGroupeController::class, 'pdf_grand_facture_groupe_abonnee_mouvement_data']);

Route::get("pdf_grand_facture_privee_data", [Pdf_FacturePriveeController::class, 'pdf_grand_facture_privee_data']);
Route::get("pdf_petit_facture_privee_data", [Pdf_FacturePriveeController::class, 'pdf_petit_facture_privee_data']);
Route::get("pdf_petit_recu_privee_data", [Pdf_FacturePriveeController::class, 'pdf_petit_recu_privee_data']);
Route::get("pdf_petit_facture_privee_mouvement_data", [Pdf_FacturePriveeController::class, 'pdf_petit_facture_privee_mouvement_data']);
Route::get("pdf_grand_facture_privee_mouvement_data", [Pdf_FacturePriveeController::class, 'pdf_grand_facture_privee_mouvement_data']);
Route::get("pdf_grand_facture_synthese_privee_mouvement_data", [Pdf_FacturePriveeController::class, 'pdf_grand_facture_synthese_privee_mouvement_data']);
Route::get("pdf_grand_facture_synthese_privee_mouvement_data", [Pdf_FacturePriveeController::class, 'pdf_grand_facture_synthese_privee_mouvement_data']);
Route::get("pdf_grand_facture_synthese_privee_entete_data", [Pdf_FacturePriveeController::class, 'pdf_grand_facture_synthese_privee_entete_data']);
Route::get("pdf_petite_facture_synthese_privee_mouvement_data", [Pdf_FacturePriveeController::class, 'pdf_petite_facture_synthese_privee_mouvement_data']);
Route::get("pdf_petite_facture_synthese_privee_entete_data", [Pdf_FacturePriveeController::class, 'pdf_petite_facture_synthese_privee_entete_data']);

//fetch_rapport_listePatientOrganisation
Route::get("fetch_rapport_listePatientOrganisation", [Pdf_FactureAbonneController::class, 'fetch_rapport_listePatientOrganisation']);
Route::get("fetch_rapport_tarification", [Pdf_FactureAbonneController::class, 'fetch_rapport_tarification']);
Route::get("pdf_grand_facture_abonnee_data", [Pdf_FactureAbonneController::class, 'pdf_grand_facture_abonnee_data']);
Route::get("pdf_petite_facture_abonnee_data", [Pdf_FactureAbonneController::class, 'pdf_petite_facture_abonnee_data']);
Route::get("pdf_petit_recu_abonnee_data", [Pdf_FactureAbonneController::class, 'pdf_petit_recu_abonnee_data']);
Route::get("pdf_grand_facture_abonnee_mouvement_data", [Pdf_FactureAbonneController::class, 'pdf_grand_facture_abonnee_mouvement_data']);
Route::get("pdf_petite_facture_abonnee_mouvement_data", [Pdf_FactureAbonneController::class, 'pdf_petite_facture_abonnee_mouvement_data']);
Route::get("pdf_grand_facture_synthese_abonnee_data", [Pdf_FactureAbonneController::class, 'pdf_grand_facture_synthese_abonnee_data']);
Route::get("pdf_grand_facture_synthese_abonnee_mouvement_data", [Pdf_FactureAbonneController::class, 'pdf_grand_facture_synthese_abonnee_mouvement_data']);
Route::get("pdf_petit_facture_synthese_abonnee_data", [Pdf_FactureAbonneController::class, 'pdf_petit_facture_synthese_abonnee_data']);
Route::get("pdf_petit_facture_synthese_abonnee_mouvement_data", [Pdf_FactureAbonneController::class, 'pdf_petit_facture_synthese_abonnee_mouvement_data']);
//pdf_petite_facture_abonnee_mouvement_data






//===================CONSULTATIONNEONATOLOGIE== =========================
Route::get('/fetch_consult_neo', [tcons_neonatologieController::class, 'all']);
Route::get('/fetch_single_consult_neo/{id}', [tcons_neonatologieController::class, 'fetch_single_consultneo']);
Route::get('/fetch_consult_neo_for_Hospi/{refHospi}', [tcons_neonatologieController::class, 'fetch_consultNeo']);               
Route::post('/insert_consult_neo', [tcons_neonatologieController::class, 'insert_consult_neo']);
Route::post('/update_consult_neo/{id}', [tcons_neonatologieController::class, 'update_consult_neo']);
Route::get('/delete_consult_neo/{id}', [tcons_neonatologieController::class, 'delete_consult_neo']);

//====================HOSPITALISATION===============
Route::get('/fetch_acte_infirmier', [thospi_acte_infirmierController::class, 'fetch_acte_infirmier']);
Route::get('/fetch_single_acte_infirmier/{id}', [thospi_acte_infirmierController::class, 'fetch_single_acte_infirmier']);
Route::get('/fetch_acte_infirmier/{refHospi}', [thospi_acte_infirmierController::class, 'fetch_acte_infirmier']);        
Route::post('/insert_acte_infirmier', [thospi_acte_infirmierController::class, 'insert_acte_infirmier']);
Route::post('/update_acte_infirmier/{id}', [thospi_acte_infirmierController::class, 'update_acte_infirmier']);
Route::get('/delete_acte_infirmier/{id}', [thospi_acte_infirmierController::class, 'delete_acte_infirmier']);

Route::get('/fetch_acte_medecin', [thospi_actesmdecinController::class, 'all']);
Route::get('/fetch_single_acte_medecin/{id}', [thospi_actesmdecinController::class, 'fetch_single_acte_medecin']);      
Route::post('/insert_acte_medecin', [thospi_actesmdecinController::class, 'insert_acte_medecin']);
Route::post('/update_acte_medecin/{id}', [thospi_actesmdecinController::class, 'update_acte_medecin']);
Route::get('/delete_acte_medecin/{id}', [thospi_actesmdecinController::class, 'delete_acte_medecin']);


Route::get('/fetch_appreciation_infirmier', [thospi_appreciation_infirmierController::class, 'all']);
Route::get('/fetch_single_appreciation_infirmier/{id}', [thospi_appreciation_infirmierController::class, 'fetch_single_appreciation_infirmier']);
Route::get('/fetch_appreciation_infirmier/{refHospi}', [thospi_appreciation_infirmierController::class, 'fetch_appreciation_infirmier']);        
Route::post('/insert_appreciation_infirmier', [thospi_appreciation_infirmierController::class, 'insert_appreciation_infirmier']);
Route::post('/update_appreciation_infirmier/{id}', [thospi_appreciation_infirmierController::class, 'update_appreciation_infirmier']);
Route::get('/delete_appreciation_infirmier/{id}', [thospi_appreciation_infirmierController::class, 'delete_appreciation_infirmier']);

Route::get('/fetch_bilan_hydrique', [thospi_bilan_hydriqueController::class, 'all']);
Route::get('/fetch_single_bilan_hydrique/{id}', [thospi_bilan_hydriqueController::class, 'fetch_single_bilan_hydrique']);
Route::get('/fetch_bilan_hydrique_hospi/{refHospi}', [thospi_bilan_hydriqueController::class, 'fetch_bilan_hydrique']);        
Route::post('/insert_bilan_hydrique', [thospi_bilan_hydriqueController::class, 'insert_bilan_hydrique']);
Route::post('/update_bilan_hydrique/{id}', [thospi_bilan_hydriqueController::class, 'update_bilan_hydrique']);
Route::get('/delete_thospi_bilan_hydrique/{id}', [thospi_bilan_hydriqueController::class, 'delete_thospi_bilan_hydrique']);

//fetch_detaitlacte_traitement

Route::get('/fetch_detail_acte', [thospi_detail_acteController::class, 'all']);
Route::get('/fetch_single_detail_acte/{id}', [thospi_detail_acteController::class, 'fetch_single_detail_acte']); 
Route::get('/fetch_detaitlacte_traitement/{refTraitem}', [thospi_detail_acteController::class, 'fetch_detaitlacte_traitement']);           
Route::post('/insert_detail_acte', [thospi_detail_acteController::class, 'insert_detail_acte']);
Route::post('/update_detail_acte/{id}', [thospi_detail_acteController::class, 'update_detail_acte']);
Route::get('/delete_detail_acte/{id}', [thospi_detail_acteController::class, 'destroy']);

Route::get('/fetch_Dbilan_hydrique', [thospi_detail_bilan_hydriqueController::class, 'all']);
Route::get('/fetch_single_detail_bilan_hydrique/{id}', [thospi_detail_bilan_hydriqueController::class, 'fetch_single_bilan_hydrique']);
Route::get('/fetch_Dbilan_hydrique_Entete/{refBilan}', [thospi_detail_bilan_hydriqueController::class, 'fetch_bilan_hydrique']);        
Route::post('/insert_Dbilan_hydrique', [thospi_detail_bilan_hydriqueController::class, 'insert_bilan_hydrique']);
Route::post('/update_Dbilan_hydrique/{id}', [thospi_detail_bilan_hydriqueController::class, 'update_bilan_hydrique']); 
Route::get('/delete_Dbilan_hydrique/{id}', [thospi_detail_bilan_hydriqueController::class, 'delete_thospi_bilan_hydrique']);

Route::get("fetch_Dsurveillance_plaie", [thospi_detail_surveillance_plaieController::class, 'all']);
Route::get("fetch_single_Dsurveillance_plaie/{id}",[thospi_detail_surveillance_plaieController::class,'fetch_single_surveillance_plaie']);
Route::get('/fetch_Dsurveillance_plaie/{refSurvPlaie}', [thospi_detail_surveillance_plaieController::class, 'fetch_surveillance_plaie']);        
Route::get("delete_Dsurveillance_plaie/{id}", [thospi_detail_surveillance_plaieController::class,'delete_surveillance_plaie']);
Route::post("insert_Dsurveillance_plaie", [thospi_detail_surveillance_plaieController::class,'insert_surveillance_plaie']);
Route::post("update_Dsurveillance_plaie/{id}", [thospi_detail_surveillance_plaieController::class,'update_surveillance_plaie']);

//fetch_detailtraitement_hospi
Route::get("fetch_Dtraitement", [thospi_detail_traitementController::class, 'all']);
Route::get("fetch_detailtraitement_hospi/{refTraitem}",[thospi_detail_traitementController::class,'fetch_detailtraitement_hospi']);
Route::get("fetch_single_Dtraitement/{id}",[thospi_detail_traitementController::class,'fetch_single_traitement']);
Route::post("insert_detail_Dtraitement", [thospi_detail_traitementController::class,'insert_detail_traitement']);
Route::post("updatethospi_detail_Dtraitement/{id}", [thospi_detail_traitementController::class,'updatethospi_detail_traitement']);
Route::get("delete_detail_Dtraitement/{id}", [thospi_detail_traitementController::class,'destroy']);

Route::get("fetch_diabetique_hospie", [thospi_diabetiquee_hospiController::class, 'all']);
Route::get("fetch_single_diabetique/{id}",[thospi_diabetiquee_hospiController::class,'fetch_single_diabetique']);
Route::get("fetch_diabetique_survaillance/{refSurvHospi}",[thospi_diabetiquee_hospiController::class,'fetch_diabetique_hospie']);
Route::post("insert_diabetique_hospie", [thospi_diabetiquee_hospiController::class,'insert_diabetique_hospie']);
Route::post("update_diabetique_hospie/{id}", [thospi_diabetiquee_hospiController::class, 'update_diabetique_hospie']);
Route::get("delete_diabetique_hospie/{id}", [thospi_diabetiquee_hospiController::class,'delete_diabetique_hospie']);


Route::get('/fetch_observation_infirmier', [thospi_observation_infirmierController::class, 'all']);
Route::get('/fetch_single_observation_infirmier/{id}', [thospi_observation_infirmierController::class, 'fetch_single_observation_infirmier']);
Route::get('/fetch_observation_hospitalisation/{refHospi}', [thospi_observation_infirmierController::class, 'fetch_observation_hospitalisation']);        
Route::post('/insert_observation_infirmier', [thospi_observation_infirmierController::class, 'insert_observation_infirmier']);
Route::post('/update_observation_infirmier/{id}', [thospi_observation_infirmierController::class, 'update_observation_infirmier']);
Route::get('/delete_observation_infirmier/{id}', [thospi_observation_infirmierController::class, 'delete_observation_infirmier']);
      
Route::get('/fetch_service_hospi', [thospi_service_hospiController::class, 'all']);
Route::get('/fetch_single_service_hospi/{id}', [thospi_service_hospiController::class, 'fetch_single_service_hospi']);
Route::post('/insert_service_hospi', [thospi_service_hospiController::class, 'insert_service_hospi']);
Route::post('/update_service_hospi/{id}', [thospi_service_hospiController::class, 'update_service_hospi']);
Route::get('/delete_service_hospi/{id}', [thospi_service_hospiController::class, 'delete_service_hospi']);

Route::get('/fetch_vitaux_surveil', [thospi_signe_vitaux_surveilController::class, 'all']);
Route::get('/fetch_single_signe_vitaux_surveil/{id}', [thospi_signe_vitaux_surveilController::class, 'fetch_single_signe_vitaux_surveil']);
Route::get('/fetch_signe_vitaux_surveil/{refSurvHospi}', [thospi_signe_vitaux_surveilController::class, 'fetch_signe_vitaux_surveil']);        
Route::post('/insert_signe_vitaux_surveil', [thospi_signe_vitaux_surveilController::class, 'insert_signe_vitaux_surveil']);
Route::post('/update_signe_vitaux_surveil/{id}', [thospi_signe_vitaux_surveilController::class, 'update_signe_vitaux_surveil']);
Route::get('/delete_signe_vitaux_surveil/{id}', [thospi_signe_vitaux_surveilController::class, 'delete_signe_vitaux_surveil']);

Route::get('/fetch_surveil_neonatologie', [thospi_surveil_neonatologieController::class, 'all']);
Route::get('/fetch_single_surveil_neonatologie/{id}', [thospi_surveil_neonatologieController::class, 'fetch_single_surveil_neonatologie']);
Route::get('/fetch_surveil_neonatologie_Hospi/{refHospi}', [thospi_surveil_neonatologieController::class, 'fetch_surveil_neonatologie']);        
Route::post('/insert_surveillance_Neo', [thospi_surveil_neonatologieController::class, 'insert_surveillance_plaie']);
Route::post('/update_surveil_neonatologie/{id}', [thospi_surveil_neonatologieController::class, 'update_surveil_neonatologie']);
Route::get('/delete_surveil_neonatologie/{id}', [thospi_surveil_neonatologieController::class, 'delete_surveil_neonatologie']);
      
Route::get('/fetch_surveillance_hospie', [thospi_surveillance_hospieController::class, 'all']);
Route::get('/fetch_single_surveillance_hospie/{id}', [thospi_surveillance_hospieController::class, 'fetch_single_surveillance_hospie']);
Route::get('/fetch_surveillance_for_hospie/{refHospi}', [thospi_surveillance_hospieController::class, 'fetch_surveillance_hospie']);        
Route::post('/insert_surveillance_hospie', [thospi_surveillance_hospieController::class, 'insert_surveillance_hospie']);
Route::post('/update_surveillance_hospie/{id}', [thospi_surveillance_hospieController::class, 'update_surveillance_hospie']);
Route::get('/delete_surveillance_hospie/{id}', [thospi_surveillance_hospieController::class, 'delete_surveillance_hospie']);


Route::get('/fetch_surveillance_plaie', [thospi_surveillance_plaieController::class, 'all']);
Route::get('/fetch_single_surveillance_plaie/{id}', [thospi_surveillance_plaieController::class, 'fetch_single_surveillance_plaie']);
Route::get('/fetch_surveillance_plaie/{refHospi}', [thospi_surveillance_plaieController::class, 'fetch_surveillance_plaie']);        
Route::post('/insert_surveillance_plaie', [thospi_surveillance_plaieController::class, 'insert_surveillance_plaie']);
Route::post('/update_surveillance_plaie/{id}', [thospi_surveillance_plaieController::class, 'update_surveillance_plaie']);
Route::get('/delete_surveillance_plaie/{id}', [thospi_surveillance_plaieController::class, 'delete_surveillance_plaie']);


Route::get('/fetch_traitement_hospie', [thospi_traitement_hospiController::class, 'all']);
Route::get('/fetch_single_traitement_hospi/{id}', [thospi_traitement_hospiController::class, 'fetch_single_traitement_hospi']);
Route::get('/fetch_traitement_hospie/{refHospi}', [thospi_traitement_hospiController::class, 'fetch_traitement_hospie']);        
Route::post('/insert_traitement_hospi', [thospi_traitement_hospiController::class, 'insert_traitement_hospi']);
Route::post('/update_traitement_hospi/{id}', [thospi_traitement_hospiController::class, 'update_traitement_hospi']);
Route::get('/delete_traitement_hospi/{id}', [thospi_traitement_hospiController::class, 'delete_traitement_hospi']);



Route::get('/fetch_transfusion_surveil', [thospi_transfusion_surveilController::class, 'all']);
Route::get('/fetch_single_transfusion_surveil/{id}', [thospi_transfusion_surveilController::class, 'fetch_single_transfusion_surveil']);
Route::get('/fetch_transfusion_for_surveil/{refSurvHospi}', [thospi_transfusion_surveilController::class, 'fetch_transfusion_surveil']);        
Route::post('/insert_transfusion_surveil', [thospi_transfusion_surveilController::class, 'insert_transfusion_surveil']);
Route::post('/update_transfusion_surveil/{id}', [thospi_transfusion_surveilController::class, 'update_transfusion_surveil']);
Route::get('/delete_transfusion_surveil/{id}', [thospi_transfusion_surveilController::class, 'delete_transfusion_surveil']);

Route::get('/fetch_type_plaie', [thospi_type_plaieController::class, 'all']);
Route::get('/fetch_typeplaie_2', [thospi_type_plaieController::class, 'fetch_typeplaie_2']);
Route::get('/fetch_single_type_plaie/{id}', [thospi_type_plaieController::class, 'fetch_single_type_plaie']);        
Route::post('/insert_type_plaie', [thospi_type_plaieController::class, 'insert_type_plaie']);
Route::post('/update_type_plaie/{id}', [thospi_type_plaieController::class, 'update_type_plaie']);
Route::get('/delete_type_plaie/{id}', [thospi_type_plaieController::class, 'delete_type_plaie']);

//fetch_typeplaie_2
//============================ partie IMAGERIE====================================
//fetch_single_analyse_for_typeanalyse
//=========analyse===============
Route::get("fetch_all_analyse", [tanalyseController::class, 'all']);
Route::get("fetch_single_analyse/{id}",[tanalyseController::class,'fetch_single_analyse']);
Route::get("fetch_analyse_for_typeanalyse/{ReftypeAnalyse}",[tanalyseController::class,'fetch_analyse_for_typeanalyse']);
Route::post('insert_analyse', [tanalyseController::class, 'insert_analyse']);
Route::post('update_analyse/{id}', [tanalyseController::class, 'update_analyse']);
Route::get("delete_analyse/{id}", [tanalyseController::class, 'delete_analyse']);
//=========_resultatScan===============ok
Route::get("fetch_all_ResultatImage", [tresultatimagerieController::class, 'all']);
Route::get("fetch_single_ResultatImage/{id}",[tresultatimagerieController::class,'fetch_single_ResultatImage']);
Route::get("fetch_resultat_imagerie/{refImagerie}",[tresultatimagerieController::class,'fetch_resultat_imagerie']);
Route::post('insert_ResultatImage', [tresultatimagerieController::class, 'insertData']);
Route::post('update_ResultatImage', [tresultatimagerieController::class, 'updateData']);
Route::get("delete_ResultatImage/{id}", [tresultatimagerieController::class, 'destroy']);

Route::get("fetch_all_ResultatImage_ext", [tresultatimagerieextController::class, 'all']);
Route::get("fetch_single_ResultatImage_ext/{id}",[tresultatimagerieextController::class,'fetch_single_ResultatImage']);
Route::get("fetch_resultat_imagerie_valide_ext/{refImagerie}",[tresultatimagerieextController::class,'fetch_resultat_imagerie_valide']);
Route::get("fetch_resultat_imagerie_ext/{refImagerie}",[tresultatimagerieextController::class,'fetch_resultat_imagerie']);
Route::post('insert_ResultatImage_ext', [tresultatimagerieextController::class, 'insertData']);
Route::post('update_ResultatImage_ext', [tresultatimagerieextController::class, 'updateData']);
Route::get("delete_ResultatImage_ext/{id}", [tresultatimagerieextController::class, 'destroy']);
//=========_cardiologie===============ok
Route::get("fetch_all_Cardiologie", [tcardiologieController::class, 'all']);
Route::get("fetch_single_CardiologieImage/{id}",[tcardiologieController::class,'fetch_single_CardiologieImage']);
Route::get("fetch_cardiologie_imagerie_valide/{refImagerie}",[tcardiologieController::class,'fetch_cardiologie_imagerie_valide']);
Route::get("fetch_cardiologie_imagerie/{refImagerie}",[tcardiologieController::class,'fetch_cardiologie_imagerie']);
Route::post('insert_Cardiologie', [tcardiologieController::class, 'insertData']);
Route::post('update_Cardiologie', [tcardiologieController::class, 'updateData']);
Route::get("delete_Cardiologie/{id}", [tcardiologieController::class, 'destroy']);

Route::get("fetch_all_Cardiologie_ext", [tcardiologieextController::class, 'all']);
Route::get("fetch_single_CardiologieImage_ext/{id}",[tcardiologieextController::class,'fetch_single_CardiologieImage']);
Route::get("fetch_cardiologie_imagerie_valide_ext/{refImagerie}",[tcardiologieextController::class,'fetch_cardiologie_imagerie_valide']);
Route::get("fetch_cardiologie_imagerie_ext/{refImagerie}",[tcardiologieextController::class,'fetch_cardiologie_imagerie']);
Route::post('insert_Cardiologie_ext', [tcardiologieextController::class, 'insertData']);
Route::post('update_Cardiologie_ext', [tcardiologieextController::class, 'updateData']);
Route::get("delete_Cardiologie_ext/{id}", [tcardiologieextController::class, 'destroy']);
//=========Endoscopie===============
Route::get("fetch_all_Endoscopie", [tendoscopieController::class, 'all']);
Route::get("fetch_single_EndoscopieImage/{id}",[tendoscopieController::class,'fetch_single_EndoscopieImage']);
Route::get("fetch_endoscopie_imagerie_valide/{refImagerie}",[tendoscopieController::class,'fetch_endoscopie_imagerie_valide']);
Route::get("fetch_endoscopie_imagerie/{refImagerie}",[tendoscopieController::class,'fetch_endoscopie_imagerie']);
Route::post('insert_Endoscopie', [tendoscopieController::class, 'insertData']);
Route::post('update_Endoscopie', [tendoscopieController::class, 'updateData']);
Route::get("delete_Endoscopie/{id}", [tendoscopieController::class, 'destroy']);


Route::get("fetch_all_Endoscopie_ext", [tendoscopieextController::class, 'all']);
Route::get("fetch_single_EndoscopieImage_ext/{id}",[tendoscopieextController::class,'fetch_single_EndoscopieImage']);
Route::get("fetch_endoscopie_imagerie_valide_ext/{refImagerie}",[tendoscopieextController::class,'fetch_endoscopie_imagerie_valide']);
Route::get("fetch_endoscopie_imagerie_ext/{refImagerie}",[tendoscopieextController::class,'fetch_endoscopie_imagerie']);
Route::post('insert_Endoscopie_ext', [tendoscopieextController::class, 'insertData']);
Route::post('update_Endoscopie_ext', [tendoscopieextController::class, 'updateData']);
Route::get("delete_Endoscopie_ext/{id}", [tendoscopieextController::class, 'destroy']);
//=========Imagerie=============== fetch_fiance  //fetch_max_imagerie_externe
Route::get("fetch_all_Imagerie", [timagerieController::class, 'all'])->name('fetch_all_Imagerie');
Route::get("fetch_finance", [timagerieController::class, 'fetch_finance'])->name('fetch_finance');
Route::get("fetch_max_imagerie_externe", [timagerieController::class, 'fetch_max_imagerie_externe'])->name('fetch_max_imagerie_externe');
Route::get("fetch_single_Imagerie/{id}",[timagerieController::class,'fetch_single_Imagerie'])->name('fetch_single_Imagerie');
Route::get("fetch_imagerie_consultation_valide/{refDetailConst}",[timagerieController::class,'fetch_imagerie_consultation_valide']);
Route::get("fetch_imagerie_consultation/{refDetailConst}",[timagerieController::class,'fetch_imagerie_consultation']);
Route::post('insert_Imagerie', [timagerieController::class, 'insertData'])->name('insert_Imagerie');
Route::post('update_Imagerie', [timagerieController::class, 'updateData'])->name('update_Imagerie');
Route::post('update_statuteimagerie/{id}', [timagerieController::class, 'update_statuteimagerie']);
Route::get("delete_Imagerie/{id}", [timagerieController::class, 'destroy'])->name('delete_Imagerie');

Route::get("fetch_all_Imagerie_Ext", [timagerieextController::class, 'all']);
Route::get("fetch_finance_Ext", [timagerieextController::class, 'fetch_finance']);
Route::get("fetch_single_Imagerie_Ext/{id}",[timagerieextController::class,'fetch_single_Imagerie']);
Route::get("fetch_imagerie_mouvement_valide_Ext/{refMouvement}",[timagerieextController::class,'fetch_imagerie_mouvement_valide']);
Route::get("fetch_imagerie_mouvement_Ext/{refMouvement}",[timagerieextController::class,'fetch_imagerie_mouvement']);
Route::post('insert_Imagerie_Ext', [timagerieextController::class, 'insertData']);
Route::post('update_Imagerie_Ext', [timagerieextController::class, 'updateData']);
Route::post('update_statuteimagerie_Ext/{id}', [timagerieextController::class, 'update_statuteimagerie']);
Route::get("delete_Imagerie_Ext/{id}", [timagerieextController::class, 'destroy']);



//=========TYPEANALYSE================
Route::get("fetch_all_TypeAnalyse", [ttypeanalyseController::class, 'index'])->name('fetch_all_TypeAnalyse');
Route::get("fetch_ttypeanalyseimagerie2", [ttypeanalyseController::class, 'fetch_ttypeanalyseimagerie2'])->name('fetch_ttypeanalyseimagerie2');
Route::get("fetch_single_TypeAnalyse/{id}",[ttypeanalyseController::class,'edit'])->name('fetch_single_TypeAnalyse');
Route::post('insert_TypeAnalyse', [ttypeanalyseController::class, 'store'])->name('insert_TypeAnalyse');
Route::post('update_TypeAnalyse/{id}', [ttypeanalyseController::class, 'store'])->name('update_TypeAnalyse');
Route::get("delete_TypeAnalyse/{id}", [ttypeanalyseController::class, 'destroy'])->name('delete_TypeAnalyse');

//fetch_ttypeanalyseimagerie2
//============================ partie DYALISE====================================

//===========typeMarchine==============================fetch_type_machine2
Route::get("fetch_all_typeMarchine", [tdyal_typemarchineController::class, 'index'])->name('fetch_all_typeMarchine');
Route::get("fetch_type_machine2", [tdyal_typemarchineController::class, 'fetch_type_machine2'])->name('fetch_type_machine2');
Route::get("fetch_sigle_typeMarchine/{id}",[tdyal_typemarchineController::class,'edit'])->name('edit_typeMarchine');
Route::post('inserttypeMarchine', [tdyal_typemarchineController::class, 'store'])->name('insert_typeMarchine');
Route::post('update_typeMarchine/{id}', [tdyal_typemarchineController::class, 'store'])->name('update_typeMarchine');
Route::get("delete_typeMarchine/{id}", [tdyal_typemarchineController::class, 'destroy'])->name('delete_typeMarchine');
//==========categorieVaccin==============fetch_tdyal_categorievaccin
Route::get("fetch_all_categorieVaccin", [tdyal_categorie_vaccinController::class, 'index'])->name('fetch_all_categorieVaccine');
Route::get("fetch_categorievaccin2", [tdyal_categorie_vaccinController::class, 'fetch_categorievaccin2'])->name('fetch_categorievaccin2');
Route::get("fetch_sigle_categorieVaccin/{id}",[tdyal_categorie_vaccinController::class,'edit'])->name('edit_categorieVaccin');
Route::post('insertcategorieVaccin', [tdyal_categorie_vaccinController::class, 'store'])->name('insert_categorieVaccin');
Route::post('update_categorieVaccin/{id}', [tdyal_categorie_vaccinController::class, 'store'])->name('update_categorieVaccin');
Route::get("delete_categorieVaccin/{id}", [tdyal_categorie_vaccinController::class, 'destroy'])->name('delete_categorieVaccin');
//=========ophtamologie=============== fetch_ophtamologie_cons
Route::get("fetch_all_ophta", [tdyal_detail_ophtamologieController::class, 'all'])->name('fetch_all_ophta');
Route::get("fetch_single_ophta/{id}",[tdyal_detail_ophtamologieController::class,'fetch_single_detail'])->name('fetch_single_ophta');
Route::get("fetch_ophtamologie_cons/{refDetailConst}",[tdyal_detail_ophtamologieController::class,'fetch_ophtamologie_cons']);
Route::post('insert_ophta', [tdyal_detail_ophtamologieController::class, 'insert_detail'])->name('insert_ophta');
Route::post('update_ophta/{id}', [tdyal_detail_ophtamologieController::class, 'update_detail'])->name('update_ophta');
Route::get("delete_ophta/{id}", [tdyal_detail_ophtamologieController::class, 'destroy'])->name('delete_ophta');
//=========DetailSurveillance=============== fetch_detail_for_surveillancedialyse
Route::get("fetch_all_Dsurveillance", [tdyal_detail_surv_dyalController::class, 'all'])->name('fetch_all_Dsurveillance');
Route::get("fetch_single_Dsurveillance/{id}",[tdyal_detail_surv_dyalController::class,'fetch_single_detail']);
Route::get("fetch_detail_for_surveillancedialyse/{refSurvDyalise}",[tdyal_detail_surv_dyalController::class,'fetch_detail_for_surveillancedialyse']);
Route::post('insert_Dsurveillance', [tdyal_detail_surv_dyalController::class, 'insertData'])->name('insert_Dsurveillance');
Route::post('update_Dsurveillance/{id}', [tdyal_detail_surv_dyalController::class, 'updateData'])->name('update_Dsurveillance');
Route::get("delete_Dsurveillance/{id}", [tdyal_detail_surv_dyalController::class, 'destroy'])->name('delete_Dsurveillance');
//=========doseCathetere===============fetch_posecathetere_dialyse
Route::get("fetch_all_doseCathetere", [tdyal_dosecathetereController::class, 'all'])->name('fetch_all_doseCathetere');
Route::get("fetch_posecathetere_dialyse/{refEnteteDyalise}",[tdyal_dosecathetereController::class,'fetch_posecathetere_dialyse']);
Route::get("fetch_single_doseCathetere/{id}",[tdyal_dosecathetereController::class,'fetch_singleData'])->name('fetch_single_doseCathetere');
Route::post('insert_doseCathetere', [tdyal_dosecathetereController::class, 'insertData'])->name('insert_doseCathetere');
Route::post('update_doseCathetere/{id}', [tdyal_dosecathetereController::class, 'updateData'])->name('update_doseCathetere');
Route::get("delete_doseCathetere/{id}", [tdyal_dosecathetereController::class, 'destroy'])->name('delete_doseCathetere');
//=========EnteteDyalise===============
//fetch_entete_dialyse_jour
Route::get("fetch_entete_dialyse_jour", [tdyal_entetedyaliseController::class, 'fetch_entete_dialyse_jour'])->name('fetch_entete_dialyse_jour');
Route::get("fetch_all_EnteteDyalise", [tdyal_entetedyaliseController::class, 'all'])->name('fetch_all_EnteteDyalise');
Route::get("fetch_single_EnteteDyalise/{id}",[tdyal_entetedyaliseController::class,'fetch_single_enteteDyalise'])->name('fetch_single_EnteteDyalise');
Route::post('insert_EnteteDyalise', [tdyal_entetedyaliseController::class, 'insert_entete'])->name('insert_EnteteDyalise');
Route::post('update_EnteteDyalise/{id}', [tdyal_entetedyaliseController::class, 'update_entete'])->name('update_EnteteDyalise');
Route::get("delete_EnteteDyalise/{id}", [tdyal_entetedyaliseController::class, 'destroy'])->name('delete_EnteteDyalise');

//==========SurveillanceDyalise==============fetch_sureillance_for_dialyse
Route::get("fetch_all_SurveillanceDyalise", [tdyal_surveillance_dyaliseController::class, 'all'])->name('fetch_all_SurveillanceDyalise');
Route::get("fetch_single_SurveillanceDyalise/{id}",[tdyal_surveillance_dyaliseController::class,'fetch_single_SurveilDyalyse']);
Route::get("fetch_sureillance_for_dialyse/{refEnteteDyalise}",[tdyal_surveillance_dyaliseController::class,'fetch_sureillance_for_dialyse']);
Route::post('insert_SurveillanceDyalise', [tdyal_surveillance_dyaliseController::class, 'insertdata'])->name('insert_SurveillanceDyalise');
Route::post('update_SurveillanceDyalise/{id}', [tdyal_surveillance_dyaliseController::class, 'updateData'])->name('update_SurveillanceDyalise');
Route::get("delete_SurveillanceDyalise/{id}", [tdyal_surveillance_dyaliseController::class, 'destroy'])->name('delete_SurveillanceDyalise');
//===============vaccinationDyalise=========  fetch_vaccination_dialyse
Route::get("fetch_all_vaccinationDyalise", [tdyal_vaccinationdyaliseController::class, 'all'])->name('fetch_all_vaccinationDyalise');
Route::get("fetch_single_vaccinationDyalise/{id}",[tdyal_vaccinationdyaliseController::class,'fetch_single_VaccinationDyalise'])->name('fetch_single_VaccinationDyalise');
Route::get("fetch_vaccination_dialyse/{refEnteteDyalise}",[tdyal_vaccinationdyaliseController::class,'fetch_vaccination_dialyse'])->name('fetch_vaccination_dialyse');
Route::post('insert_vaccinationDyalise', [tdyal_vaccinationdyaliseController::class, 'insertData'])->name('insert_vaccinationDyalise');
Route::post('update_vaccinationDyalise/{id}', [tdyal_vaccinationdyaliseController::class, 'updateData'])->name('update_vaccinationDyalise');
Route::get("delete_vaccinationDyalise/{id}", [tdyal_vaccinationdyaliseController::class, 'destroy'])->name('delete_vaccinationDyalise');
//=========vaccinDyalise===============fetch_vaccin_categorie2
Route::get("fetch_all_vaccinDyalise", [tdyal_vaccindyaliseController::class, 'all'])->name('fetch_all_vaccinDyalise');
Route::get("fetch_single_vaccinDyalise/{id}",[tdyal_vaccindyaliseController::class,'fetch_single_data'])->name('fetch_single_vaccinDyalise');
Route::get("fetch_vaccin_categorie2/{refcategorieVac}",[tdyal_vaccindyaliseController::class,'fetch_vaccin_categorie2'])->name('fetch_vaccin_categorie2');
Route::post('insert_vaccinDyalise', [tdyal_vaccindyaliseController::class, 'insert_data'])->name('insert_vaccinDyalise');
Route::post('update_vaccinDyalise/{id}', [tdyal_vaccindyaliseController::class, 'updateData'])->name('update_vaccinDyalise');
Route::get("delete_vaccinDyalise/{id}", [tdyal_vaccindyaliseController::class, 'destroy'])->name('delete_vaccinDyalise');



//============================ partie REANIMATION====================================

//=========EnteteRea===============
Route::get("fetch_all_EnteteRea", [trea_entete_reaController::class, 'all'])->name('fetch_all_EnteteRea');
Route::get("fetch_single_EnteteRea/{id}",[trea_entete_reaController::class,'fetch_single_enteteRea'])->name('fetch_single_EnteteRea');
Route::post('insert_EnteteRea', [trea_entete_reaController::class, 'insert_entete'])->name('insert_EnteteRea');
Route::post('update_EnteteRea/{id}', [trea_entete_reaController::class, 'update_entete'])->name('update_EnteteRea');
Route::get("delete_EnteteRea/{id}", [trea_entete_reaController::class, 'destroy'])->name('delete_EnteteRea');

//=========evolutionRea===============
Route::get("fetch_all_evolutionRea", [trea_evolution_reaController::class, 'all'])->name('fetch_all_evolutionRea');
Route::get("fetch_single_evolutionRea/{id}",[trea_evolution_reaController::class,'fetch_single_evoRea']);
Route::get("fetch_evolution_for_enteterea/{refHospi}",[trea_evolution_reaController::class,'fetch_evolution_for_enteterea']);
Route::post('insert_evolutionRea', [trea_evolution_reaController::class, 'insert_revolutionRea'])->name('insert_evolutionRea');
Route::post('update_evolutionRea/{id}', [trea_evolution_reaController::class, 'update_revolutionRea'])->name('update_evolutionRea');
Route::get("delete_evolutionRea/{id}", [trea_evolution_reaController::class, 'destroy'])->name('delete_evolutionRea');

//==========observationREA==============***********
Route::get("fetch_all_observationREA", [trea_observation_reaController::class, 'all'])->name('fetch_all_observationREA');
Route::get("fetch_single_observationREA/{id}",[trea_observation_reaController::class,'fetch_single_observationRea']);
Route::get("fetch_observation_for_enteterea/{refEnteteRea}",[trea_observation_reaController::class,'fetch_observation_for_enteterea']);
Route::post('insert_observationREA', [trea_observation_reaController::class, 'insert_observationRea'])->name('insert_observationRea');
Route::post('update_observationREA/{id}', [trea_observation_reaController::class, 'update_observationRea'])->name('update_observationRea');
Route::get("delete_observationREA/{id}", [trea_observation_reaController::class, 'destroy'])->name('delete_observationREA');


//=========SurveillanceRea===============
Route::get("fetch_all_SurveillanceRea", [trea_surveillance_reaController::class, 'all'])->name('fetch_all_SurveillanceRea');
Route::get("fetch_single_SurveillanceRea/{id}",[trea_surveillance_reaController::class,'fetch_single_SurveillanceRea']);
Route::get("fetch_surveillance_for_enteterea/{refEnteteRea}",[trea_surveillance_reaController::class,'fetch_surveillance_for_enteterea']);
Route::post('insert_SurveillanceRea', [trea_surveillance_reaController::class, 'insert_SurveillanceRea'])->name('insert_SurveillanceRea');
Route::post('update_SurveillanceRea/{id}', [trea_surveillance_reaController::class, 'update_SurveillanceRea'])->name('update_SurveillanceRea');
Route::get("delete_SurveillanceRea/{id}", [trea_surveillance_reaController::class, 'destroy'])->name('delete_SurveillanceRea');

//=========traitement===============
Route::get("fetch_all_traitement", [trea_traitementController::class, 'all'])->name('fetch_all_traitement');
Route::get("fetch_single_traitement/{id}",[trea_traitementController::class,'fetch_single_traitement']);
Route::get("fetch_traitement_for_enteterea/{refEnteteRea}",[trea_traitementController::class,'fetch_traitement_for_enteterea']);
Route::post('insert_traitement', [trea_traitementController::class, 'insert_traitement'])->name('insert_traitement');
Route::post('update_traitement/{id}', [trea_traitementController::class, 'update_traitement'])->name('update_traitement');
Route::get("delete_traitement/{id}", [trea_traitementController::class, 'destroy'])->name('delete_traitement');

//===================CONSULTATIONNEONATOLOGIE== =========================
Route::get('/fetch_consult_neo', [tcons_neonatologieController::class, 'all']);
Route::get('/fetch_single_consult_neo/{id}', [tcons_neonatologieController::class, 'fetch_single_consultneo']);
Route::get('/fetch_consult_neo/{refHospi}', [tcons_neonatologieController::class, 'fetch_consultNeo']);               
Route::post('/insert_consult_neo', [tcons_neonatologieController::class, 'insert_consult_neo']);
Route::post('/update_consult_neo/{id}', [tcons_neonatologieController::class, 'update_consult_neo']);
Route::get('/delete_consult_neo/{id}', [tcons_neonatologieController::class, 'delete_consult_neo']);


//======== PARTIE TRESORERIE ========================================================================

//=========EnteteBON D'ANGAGEMENT===============
Route::get("fetch_all_bonAngagement", [ttreso_entete_angagementController::class, 'index']);
Route::get("fetch_single_bonAngagement/{id}",[ttreso_entete_angagementController::class,'edit']);
Route::post('insert_bonAngagement', [ttreso_entete_angagementController::class, 'store']);
Route::post('update_bonAngagement/{id}', [ttreso_entete_angagementController::class, 'store']);

Route::post('valider_divison/{id}', [ttreso_entete_angagementController::class, 'valider_divison']);
Route::post('attester_divison/{id}', [ttreso_entete_angagementController::class, 'attester_divison']);

Route::post('valider_tresorerie/{id}', [ttreso_entete_angagementController::class, 'valider_tresorerie']);
Route::post('attester_tresorerie/{id}', [ttreso_entete_angagementController::class, 'attester_tresorerie']);

Route::post('valider_administration/{id}', [ttreso_entete_angagementController::class, 'valider_administration']);
Route::post('attester_administration/{id}', [ttreso_entete_angagementController::class, 'attester_administration']);

Route::post('valider_direction/{id}', [ttreso_entete_angagementController::class, 'valider_direction']);
Route::post('attester_direction/{id}', [ttreso_entete_angagementController::class, 'attester_direction']);

Route::post('valider_gerant/{id}', [ttreso_entete_angagementController::class, 'valider_gerant']);
Route::post('attester_gerant/{id}', [ttreso_entete_angagementController::class, 'attester_gerant']);

Route::get("delete_bonAngagement/{id}", [ttreso_entete_angagementController::class, 'destroy']);

//=========DetailBON D'ANGAGEMENT=======================
Route::get("fetch_all_DbonAngagement", [tt_treso_detail_angagementController::class, 'index']);
Route::get('/fetch_detail_enteteengagement/{refEntete}', [tt_treso_detail_angagementController::class, 'fetch_detail_for_entete']);
Route::get("fetch_single_DbonAngagement/{id}",[tt_treso_detail_angagementController::class,'edit']);
Route::post('insert_DbonAngagement', [tt_treso_detail_angagementController::class, 'store']);
Route::post('update_DbonAngagement/{id}', [tt_treso_detail_angagementController::class, 'store']);
Route::get("delete_DbonAngagement/{id}", [tt_treso_detail_angagementController::class, 'destroy']);
//==========PROVENANCE==============***********
Route::get("fetch_all_provenance", [tt_treso_provenanceController::class, 'index']);
Route::get("fetch_provenance2", [tt_treso_provenanceController::class, 'fetch_provenance2']);
Route::get("fetch_single_provenance/{id}",[tt_treso_provenanceController::class,'edit']);
Route::post('insert_provenance', [tt_treso_provenanceController::class, 'store']);
Route::post('update_provenance/{id}', [tt_treso_provenanceController::class, 'store']);
Route::get("delete_provenance/{id}", [tt_treso_provenanceController::class, 'destroy']);
//fetch_provenance2
//=========RUBRIQUEDEPENSE===============
Route::get("fetch_all_rubrique", [tt_treso_rubriqueController::class, 'index']);
Route::get("fetch_rubrique2", [tt_treso_rubriqueController::class, 'fetch_rubrique2']);
Route::get("fetch_single_rubrique/{id}",[tt_treso_rubriqueController::class,'edit']);
Route::post('insert_rubrique', [tt_treso_rubriqueController::class, 'store']);
Route::post('update_rubrique/{id}', [tt_treso_rubriqueController::class, 'store']);
Route::get("delete_rubrique/{id}", [tt_treso_rubriqueController::class, 'destroy']);
//=========CATEGORIERUBRIQUE=====================================================
//fetch_categorie_rubrique2
Route::get("fetch_all_catRubrique", [tt_treso_categorie_rubriqueController::class, 'index']);
Route::get("fetch_categorie_rubrique2", [tt_treso_categorie_rubriqueController::class, 'fetch_categorie_rubrique2']);
Route::get("fetch_single_catRubrique/{id}",[tt_treso_categorie_rubriqueController::class,'edit']);
Route::post('insert_catRubrique', [tt_treso_categorie_rubriqueController::class, 'store']);
Route::post('update_catRubrique/{id}', [tt_treso_categorie_rubriqueController::class, 'store']);
Route::get("delete_catRubrique/{id}", [tt_treso_categorie_rubriqueController::class, 'destroy']);
//=========ENTETE_ETATDEBESOIN===============
Route::get("fetch_all_etatBesoin", [tt_treso_entete_etatbesoinController::class, 'index']);
Route::get("fetch_single_etatBesoin/{id}",[tt_treso_entete_etatbesoinController::class,'edit']);
Route::post('insert_etatBesoin', [tt_treso_entete_etatbesoinController::class, 'store']);
Route::post('update_etatBesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'store']);
Route::post('aquitter_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'aquitter_etatbesoin']);
Route::post('approuver_etatbesoin/{id}', [tt_treso_entete_etatbesoinController::class, 'approuver_etatbesoin']);
Route::get("delete_etatBesoin/{id}", [tt_treso_entete_etatbesoinController::class, 'destroy']);
//=========DETAIL_ETATDEBESOIN===============
Route::get("fetch_all_DetatBesoin", [tt_treso_detail_etatbesoinController::class, 'index']);
Route::get('/fetch_detail_enteteetatbesoin/{refEntete}', [tt_treso_detail_etatbesoinController::class, 'fetch_detail_for_entete']);
Route::get("fetch_single_DetatBesoin/{id}",[tt_treso_detail_etatbesoinController::class,'edit']);
Route::post('insert_DetatBesoin', [tt_treso_detail_etatbesoinController::class, 'store']);
Route::post('update_DetatBesoin/{id}', [tt_treso_detail_etatbesoinController::class, 'store']);
Route::get("delete_DetatBesoin/{id}", [tt_treso_detail_etatbesoinController::class, 'destroy']);
//=========BLOCS===============
Route::get("fetch_all_bloc", [tt_treso_blocController::class, 'index']);
Route::get("fetch_bloc2", [tt_treso_blocController::class, 'fetch_bloc2']);
Route::get("fetch_single_bloc/{id}",[tt_treso_blocController::class,'edit']);
Route::post('insert_bloc', [tt_treso_blocController::class, 'store']);
Route::post('update_bloc/{id}', [tt_treso_blocController::class, 'store']);
Route::get("delete_bloc/{id}", [tt_treso_blocController::class, 'destroy']);


//fetch_bloc2

//============================ partie attestation====================================

//=========aptitute physique===============
//fetch_max_aptitude_physique
Route::get("fetch_all_AptPhysique", [tt_attest_aptitude_physiqueController::class, 'all']);
Route::get("fetch_max_aptitude_physique", [tt_attest_aptitude_physiqueController::class, 'fetch_max_aptitude_physique']);
Route::get("fetch_single_AptPhysique/{id}",[tt_attest_aptitude_physiqueController::class,'fetch_single_aptPhysique']);
Route::get("fetch_aptitudephysique_entete/{refAttestation}",[tt_attest_aptitude_physiqueController::class,'fetch_aptitudephysique_entete']);
Route::post('insert_AptPhysique', [tt_attest_aptitude_physiqueController::class, 'insertdata']);
Route::post('update_AptPhysique/{id}', [tt_attest_aptitude_physiqueController::class, 'updateData']);
Route::get("delete_AptPhysique/{id}", [tt_attest_aptitude_physiqueController::class, 'destroy']);

//=========certificat_deces=======================
Route::get("fetch_all_certDeces", [tt_attest_certificat_decesController::class, 'all']);
Route::get("fetch_single_certDeces/{id}",[tt_attest_certificat_decesController::class,'fetch_single_certificat']);
Route::get("fetch_certificatdeces_entete/{refAttestation}",[tt_attest_certificat_decesController::class,'fetch_certificatdeces_entete']);
Route::post('insert_certDeces', [tt_attest_certificat_decesController::class, 'insertdata']);
Route::post('update_certDeces/{id}', [tt_attest_certificat_decesController::class, 'updateData']);
Route::get("delete_certDeces/{id}", [tt_attest_certificat_decesController::class, 'destroy']);
//==========certificat_medical==============***********
Route::get("fetch_all_certificat_medical", [tt_attest_certificat_medicalController::class, 'all']);
Route::get("fetch_single_certificat_medical/{id}",[tt_attest_certificat_medicalController::class,'fetch_single_certiMedical']);
Route::get("fetch_certificatmedical_entete/{refAttestation}",[tt_attest_certificat_medicalController::class,'fetch_certificatmedical_entete']);
Route::post('insert_certificat_medical', [tt_attest_certificat_medicalController::class, 'insertdata']);
Route::post('update_certificat_medical/{id}', [tt_attest_certificat_medicalController::class, 'updateData']);
Route::get("delete_certificat_medical/{id}", [tt_attest_certificat_medicalController::class, 'destroy']);

//=========eneteteAttestation===============
Route::get("fetch_all_enteteAttestion", [tt_attest_entete_attestationController::class, 'all']);
Route::get("fetch_single_enteteAttestion/{id}",[tt_attest_entete_attestationController::class,'fetch_single_Attestation']);
Route::post('insert_enteteAttestion', [tt_attest_entete_attestationController::class, 'insertdata']);
Route::post('update_enteteAttestion/{id}', [tt_attest_entete_attestationController::class, 'updateData']);
Route::get("delete_enteteAttestion/{id}", [tt_attest_entete_attestationController::class, 'destroy']);


//============= carte medicale ==================================================================================

Route::get("pdf_carte_medicale", [CartePdfController::class, 'pdf_carte_medicale']);




//=======================ANUSCOPIE==================
Route::get("fetch_all_anuscopie", [tim_anuscopieController::class, 'all']);
Route::get("fetch_single_anuscopie/{id}",[tim_anuscopieController::class,'fetch_single']);
Route::get("fetch_anuscopie_imagerie/{refImagerie}",[tim_anuscopieController::class,'fetch_anuscopie_imagerie']);
Route::post('insert_anuscopie', [tim_anuscopieController::class, 'insertData']);
Route::post('update_anuscopie/{id}', [tim_anuscopieController::class, 'updateData']);
Route::get("delete_anuscopie/{id}", [tim_anuscopieController::class, 'destroy']);
//=======================ATTESTATATION==================
Route::get("fetch_imagerie_all_attestation", [tim_attestationController::class, 'all']);
Route::get("fetch_imagerie_single_attestation{id}",[tim_attestationController::class,'fetch_single']);
Route::get("fetch_imagerie_attestation_cons/{refDetailConst}",[tim_attestationController::class,'fetch_attestation_cons']);
Route::post('insert_imagerie_attestation', [tim_attestationController::class, 'insertData']);
Route::post('update_imagerie_attestation/{id}', [tim_attestationController::class, 'updateData']);
Route::get("delete_imagerie_attestation/{id}", [tim_attestationController::class, 'delete_attestation']);
//=======================COLOSCOPIE==================
Route::get("fetch_all_coloscopi", [tim_coloscopieController::class, 'all']);
Route::get("fetch_single_coloscopi{id}",[tim_coloscopieController::class,'fetch_single']);
Route::get("fetch_coloscopie_imagerie/{refImagerie}",[tim_coloscopieController::class,'fetch_coloscopie_imagerie']);
Route::post('insert_coloscopi', [tim_coloscopieController::class, 'insertData']);
Route::post('update_coloscopi/{id}', [tim_coloscopieController::class, 'updateData']);
Route::get("delete_coloscopi/{id}", [tim_coloscopieController::class, 'destroy']);
//=======================INTERVALLE==================
Route::get("fetch_all_intervalle", [tim_invervalController::class, 'index']);
Route::get("fetch_IntervalSCore2", [tim_invervalController::class, 'fetch_IntervalSCore2']);
Route::get("fetch_single_intervalle{id}",[tim_invervalController::class,'edit']);
Route::post('insert_intervalle', [tim_invervalController::class, 'store']);
Route::post('update_intervalle/{id}', [tim_invervalController::class, 'store']);
Route::get("delete_intervalle/{id}", [tim_invervalController::class, 'destroy']);
//=======================LIBELLE================== fetch_IntervalSCore2   fetch_libelleScore2
Route::get("fetch_all_libelle_score", [tim_libelle_scoreController::class, 'index']);
Route::get("fetch_libelleScore2", [tim_libelle_scoreController::class, 'fetch_libelleScore2']);
Route::get("fetch_single_libelle_score{id}",[tim_libelle_scoreController::class,'edit']);
Route::post('insert_libelle_score', [tim_libelle_scoreController::class, 'store']);
Route::post('update_libelle_score/{id}', [tim_libelle_scoreController::class, 'store']);
Route::get("delete_libelle_score/{id}", [tim_libelle_scoreController::class, 'destroy']);
//=======================PARAMETRE SCORE================== fetch_params_libelle
Route::get("fetch_all_parametre_score", [tim_parametre_scoreController::class, 'all']);
Route::get("fetch_params_libelle", [tim_parametre_scoreController::class, 'fetch_params_libelle']);
Route::get("fetch_single_parametre_score{id}",[tim_parametre_scoreController::class,'fetch_single']);
Route::post('insert_parametre_score', [tim_parametre_scoreController::class, 'insertData']);
Route::post('update_parametre_score/{id}', [tim_parametre_scoreController::class, 'updateData']);
Route::get("delete_parametre_score/{id}", [tim_parametre_scoreController::class, 'destroy']);
//==========================RECTOSCOPIE============
Route::get("fetch_all_rectoscopie", [tim_rectoscopieController::class, 'all']);
Route::get("fetch_single_rectoscopie/{id}",[tim_rectoscopieController::class,'fetch_single']);
Route::get("fetch_rectoscopie_imagerie/{refImagerie}",[tim_rectoscopieController::class,'fetch_rectoscopie_imagerie']);
Route::post('insert_rectoscopie', [tim_rectoscopieController::class, 'insertData']);
Route::post('update_rectoscopie/{id}', [tim_rectoscopieController::class, 'updateData']);
Route::get("delete_rectoscopie/{id}", [tim_rectoscopieController::class, 'destroy']);
//================RECTOSIGMOIDOPIE============
Route::get("fetch_all_rectosigmoidocopie", [tim_rectosigmoidocopieController::class, 'all']);
Route::get("fetch_single_rectosigmoidocopie/{id}",[tim_rectosigmoidocopieController::class,'fetch_single']);
Route::get("fetch_rectosigmoidocopie_imagerie/{refImagerie}",[tim_rectosigmoidocopieController::class,'fetch_rectosigmoidocopie_imagerie']);
Route::post('insert_rectosigmoidocopie', [tim_rectosigmoidocopieController::class, 'insertData']);
Route::post('update_rectosigmoidocopie/{id}', [tim_rectosigmoidocopieController::class, 'updateData']);
Route::get("delete_rectosigmoidocopie/{id}", [tim_rectosigmoidocopieController::class, 'destroy']);
//================RESULTAT BCG============  
Route::get("fetch_all_resultat_ECG", [tim_resultatecgController::class, 'all']);
Route::get("fetch_single_resultat_ECG{id}",[tim_resultatecgController::class,'fetch_single_resultat_ecg']);
Route::get("fetch_resultat_imagerie_ECG/{refImagerie}",[tim_resultatecgController::class,'fetch_result_ecg_imagerie']);
Route::post('insert_resultat_ECG', [tim_resultatecgController::class, 'insertData']);
Route::post('update_resultat_ECG/{id}', [tim_resultatecgController::class, 'updateData']);
Route::get("delete_resultat_ECG/{id}", [tim_resultatecgController::class, 'destroy']);
//================RESULTAT FOG============
Route::get("fetch_all_resultat_f_o_g", [tim_resultat_f_o_g_dController::class, 'all']);
Route::get("fetch_single_resultat_f_o_g{id}",[tim_resultat_f_o_g_dController::class,'fetch_single']);
Route::get("fetch_resultat_imagerie_FOG/{refImagerie}",[tim_resultat_f_o_g_dController::class,'fetch_result_imagerie']);
Route::post('insert_resultat_f_o_g', [tim_resultat_f_o_g_dController::class, 'insertData']);
Route::post('update_resultat_f_o_g/{id}', [tim_resultat_f_o_g_dController::class, 'updateData']);
Route::get("delete_resultat_f_o_g/{id}", [tim_resultat_f_o_g_dController::class, 'destroy']);
//================SCORE PROBABILITE============
Route::get("fetch_all_probaScore", [tim_score_probabilite_scoreController::class, 'all']);
Route::get("fetch_single_probaScore{id}",[tim_score_probabilite_scoreController::class,'fetch_single']);
Route::get("fetch_probaScore_imagerie/{refImagerie}",[tim_score_probabilite_scoreController::class,'fetch_score_imagerie']);
Route::post('insert_probaScore', [tim_score_probabilite_scoreController::class, 'insertData']);
Route::post('update_probaScore/{id}', [tim_score_probabilite_scoreController::class, 'updateData']);
Route::get("delete_probaScore/{id}", [tim_score_probabilite_scoreController::class, 'destroy']);









//

//========== POUR LES EXTERNES =================================================================================

//=======================ANUSCOPIE==================
Route::get("fetch_all_anuscopie_ext", [tim_anuscopie_extController::class, 'all']);
Route::get("fetch_single_anuscopie_ext/{id}",[tim_anuscopie_extController::class,'fetch_single']);
Route::get("fetch_anuscopie_imagerie_ext/{refImagerie}",[tim_anuscopie_extController::class,'fetch_anuscopie_imagerie']);
Route::post('insert_anuscopie_ext', [tim_anuscopie_extController::class, 'insertData']);
Route::post('update_anuscopie_ext/{id}', [tim_anuscopie_extController::class, 'updateData']);
Route::get("delete_anuscopie_ext/{id}", [tim_anuscopie_extController::class, 'destroy']);
//=======================COLOSCOPIE==================
Route::get("fetch_all_coloscopi_ext", [tim_coloscopie_extController::class, 'all']);
Route::get("fetch_single_coloscopi_ext{id}",[tim_coloscopie_extController::class,'fetch_single']);
Route::get("fetch_coloscopie_imagerie_ext/{refImagerie}",[tim_coloscopie_extController::class,'fetch_coloscopie_imagerie']);
Route::post('insert_coloscopi_ext', [tim_coloscopie_extController::class, 'insertData']);
Route::post('update_coloscopi_ext/{id}', [tim_coloscopie_extController::class, 'updateData']);
Route::get("delete_coloscopi_ext/{id}", [tim_coloscopie_extController::class, 'destroy']);
//==========================RECTOSCOPIE============
Route::get("fetch_all_rectoscopie_ext", [tim_rectoscopie_extController::class, 'all']);
Route::get("fetch_single_rectoscopie_ext/{id}",[tim_rectoscopie_extController::class,'fetch_single']);
Route::get("fetch_rectoscopie_imagerie_ext/{refImagerie}",[tim_rectoscopie_extController::class,'fetch_rectoscopie_imagerie']);
Route::post('insert_rectoscopie_ext', [tim_rectoscopie_extController::class, 'insertData']);
Route::post('update_rectoscopie_ext/{id}', [tim_rectoscopie_extController::class, 'updateData']);
Route::get("delete_rectoscopie_ext/{id}", [tim_rectoscopie_extController::class, 'destroy']);
//================RECTOSIGMOIDOPIE============
Route::get("fetch_all_rectosigmoidocopie_ext", [tim_rectosigmoidocopie_extController::class, 'all']);
Route::get("fetch_single_rectosigmoidocopie_ext/{id}",[tim_rectosigmoidocopie_extController::class,'fetch_single']);
Route::get("fetch_rectosigmoidocopie_imagerie_ext/{refImagerie}",[tim_rectosigmoidocopie_extController::class,'fetch_rectosigmoidocopie_imagerie']);
Route::post('insert_rectosigmoidocopie_ext', [tim_rectosigmoidocopie_extController::class, 'insertData']);
Route::post('update_rectosigmoidocopie_ext/{id}', [tim_rectosigmoidocopie_extController::class, 'updateData']);
Route::get("delete_rectosigmoidocopie_ext/{id}", [tim_rectosigmoidocopie_extController::class, 'destroy']);
//================RESULTAT BCG============  
Route::get("fetch_all_resultat_ECG_ext", [tim_resultatecgextController::class, 'all']);
Route::get("fetch_single_resultat_ECG_ext{id}",[tim_resultatecgextController::class,'fetch_single_resultat_ecg']);
Route::get("fetch_resultat_imagerie_ECG_ext/{refImagerie}",[tim_resultatecgextController::class,'fetch_result_ecg_imagerie']);
Route::post('insert_resultat_ECG_ext', [tim_resultatecgextController::class, 'insertData']);
Route::post('update_resultat_ECG_ext/{id}', [tim_resultatecgextController::class, 'updateData']);
Route::get("delete_resultat_ECG_ext/{id}", [tim_resultatecgextController::class, 'destroy']);
//================RESULTAT FOG============
Route::get("fetch_all_resultat_f_o_g_ext", [tim_resultat_f_o_g_d_extController::class, 'all']);
Route::get("fetch_single_resultat_f_o_g_ext{id}",[tim_resultat_f_o_g_d_extController::class,'fetch_single']);
Route::get("fetch_resultat_imagerie_FOG_ext/{refImagerie}",[tim_resultat_f_o_g_d_extController::class,'fetch_result_imagerie']);
Route::post('insert_resultat_f_o_g_ext', [tim_resultat_f_o_g_d_extController::class, 'insertData']);
Route::post('update_resultat_f_o_g_ext/{id}', [tim_resultat_f_o_g_d_extController::class, 'updateData']);
Route::get("delete_resultat_f_o_g_ext/{id}", [tim_resultat_f_o_g_d_extController::class, 'destroy']);
//================SCORE PROBABILITE============
Route::get("fetch_all_probaScore_ext", [tim_score_probabilite_score_extController::class, 'all']);
Route::get("fetch_single_probaScore_ext{id}",[tim_score_probabilite_score_extController::class,'fetch_single']);
Route::get("fetch_probaScore_imagerie_ext/{refImagerie}",[tim_score_probabilite_score_extController::class,'fetch_score_imagerie']);
Route::post('insert_probaScore_ext', [tim_score_probabilite_score_extController::class, 'insertData']);
Route::post('update_probaScore_ext/{id}', [tim_score_probabilite_score_extController::class, 'updateData']);
Route::get("delete_probaScore_ext/{id}", [tim_score_probabilite_score_extController::class, 'destroy']);















//========================================dyalise===========

//=============================rapportdyalise============================
Route::get("fetch_all_rapport", [tdyal_rapport_med_dyalyseController::class, 'all']);
Route::get("fetch_single_rapport_med_dialyse/{id}",[tdyal_rapport_med_dyalyseController::class,'fetch_single']);
Route::get("fetch_rapport_medicale_dyalyse/{refEnteteDyalise}",[tdyal_rapport_med_dyalyseController::class,'fetch_rapport_medicale_dyalyse']);
Route::post('insert_rapport_med_dialyse', [tdyal_rapport_med_dyalyseController::class, 'insertData']);
Route::post('update_rapport_med_dialyse/{id}', [tdyal_rapport_med_dyalyseController::class, 'updateData']);
Route::get("delete_rapport_med_dialyse/{id}", [tdyal_rapport_med_dyalyseController::class, 'destroy']);
//=============================deroulement============================
Route::get("fetch_all_deroulement", [tdyal_deroulement_dyaliseController::class, 'all']);
Route::get("fetch_single_deroulement/{id}",[tdyal_deroulement_dyaliseController::class,'fetch_single']);
Route::get("fetch_deroulement_dialyse/{refEnteteDyalise}",[tdyal_deroulement_dyaliseController::class,'fetch_deroulement_dyanalise']);
Route::post('insert_deroulement', [tdyal_deroulement_dyaliseController::class, 'insertData']);
Route::post('update_deroulement/{id}', [tdyal_deroulement_dyaliseController::class, 'updateData']);
Route::get("delete_deroulement/{id}", [tdyal_deroulement_dyaliseController::class, 'destroy']);
//=============================Traitement============================
Route::get("fetch_all_traitement_dyal", [tdyal_traitement_dyalController::class, 'all']);
Route::get("fetch_single_traitement_dyal/{id}",[tdyal_traitement_dyalController::class,'fetch_single']);
Route::get("fetch_rapport_traitement_dyal/{refRapport}",[tdyal_traitement_dyalController::class,'fetch_traitement_rapport']);
Route::post('insert_traitement_dyal', [tdyal_traitement_dyalController::class, 'insert_data']);
Route::post('update_traitement_dyal/{id}', [tdyal_traitement_dyalController::class, 'updateData']);
Route::get("delete_traitement_dyal/{id}", [tdyal_traitement_dyalController::class, 'destroy']);






//=========MATERNITE==============================================

//=========PARTOGRAMME===============
Route::get("fetch_partogramme",[partogrammeController::class, 'all']);
Route::get("fetch_single_partogramme/{id}",[partogrammeController::class,'fetch_single_patrogramme']);
Route::post('insert_partogramme', [partogrammeController::class, 'insertData']);
Route::post('update_partogramme/{id}', [partogrammeController::class, 'updateData']);
Route::get("delete_partogramme/{id}", [PartogrammeController::class, 'destroy']);
//=========SURVEILLANCE FEMME===============
Route::get("fetch_Surveil_femme",[tmat_surveillance_femmeController::class, 'all']);
Route::get("fetch_single_Surveil_femme/{id}",[tmat_surveillance_femmeController::class,'fetch_single_SurveillanceF']);
Route::post('insert_Surveil_femme', [tmat_surveillance_femmeController::class, 'insertData']);
Route::post('update_Surveil_femme/{id}', [tmat_surveillance_femmeController::class, 'updateData']);
Route::get("delete_Surveil_femme/{id}", [tmat_surveillance_femmeController::class, 'destroy']);

//=========SURVEILLANCE PHASE===============
Route::get("fetch_Surveil_phase",[tmat_surveillance_phaseController::class, 'all']);
Route::get("fetch_single_Surveil_phase/{id}",[tmat_surveillance_phaseController::class,'fetch_single_SurveillanceP']);
Route::post('insert_Surveil_phase', [tmat_surveillance_phaseController::class, 'insertData']);
Route::post('update_Surveil_phase/{id}', [tmat_surveillance_phaseController::class, 'updateData']);
Route::get("delete_Surveil_phase/{id}", [tmat_surveillance_phaseController::class, 'destroy']);


//=========tmatapgar=======================
Route::get("fetch_apgar",[tmatapgarController::class, 'all']);
Route::get("fetch_single_apgar/{id}",[tmatapgarController::class,'fetch_single_pgar']);
Route::post('insert_apgar', [tmatapgarController::class, 'insertData']);
Route::post('update_apgar/{id}', [tmatapgarController::class, 'updateData']);
Route::get("delete_apgar/{id}", [tmatapgarController::class, 'destroy']);

//=========MERE=======================
//=========CONSULTATION PRENATALE======================= fetch_CPN_for_cons
Route::get("fetch_CPN",[t_mere_consultation_prenataleController::class, 'all']);
Route::get("fetch_CPN_for_cons/{refDetailConst}",[t_mere_consultation_prenataleController::class,'fetch_CPN_for_cons']);
Route::get("fetch_single_CPN/{id}",[t_mere_consultation_prenataleController::class,'fetch_single_CPN']);
Route::post('insert_CPN', [t_mere_consultation_prenataleController::class, 'insertData']);
Route::post('update_CPN/{id}', [t_mere_consultation_prenataleController::class, 'updateData']);
Route::get("delete_CPN/{id}", [t_mere_consultation_prenataleController::class, 'destroy']);

//=========ELEMENTS DES REFERENCES=======================
Route::get("fetch_element_ref",[t_mere_element_referenceController::class, 'all']);
Route::get("fetch_single_element_ref/{id}",[t_mere_element_referenceController::class,'fetch_single']);
Route::get("fetch_element_reference_mere_entete/{refCPN}",[t_mere_element_referenceController::class,'fetch_detail_entete']);
Route::post('insert_element_ref', [t_mere_element_referenceController::class, 'insertData']);
Route::post('update_element_ref/{id}', [t_mere_element_referenceController::class, 'updateData']);
Route::get("delete_element_ref/{id}", [t_mere_element_referenceController::class, 'destroy']);

//=========DETAIL CPN=======================
Route::get("fetch_detailCPN",[t_mere_detailcpnController::class, 'all']);
Route::get("fetch_single_detailCPN/{id}",[t_mere_detailcpnController::class,'fetch_single_DetailCPN']);
Route::get("fetch_detail_cpn_mere_entete/{refCPN}",[t_mere_detailcpnController::class,'fetch_detail_entete']);
Route::post('insert_detailCPN', [t_mere_detailcpnController::class, 'insertData']);
Route::post('update_detailCPN/{id}', [t_mere_detailcpnController::class, 'updateData']);
Route::get("delete_detailCPN/{id}", [t_mere_detailcpnController::class, 'destroy']);

//=========PERIODE_CPON======================= fetch_periode_cpon_mere2
Route::get("fetch_periode_CPON",[t_mere_periode_cponController::class, 'index']);
Route::get("fetch_periode_cpon_mere2",[t_mere_periode_cponController::class, 'fetch_periode_cpon_mere2']);
Route::get("fetch_single_periode_CPON/{id}",[t_mere_periode_cponController::class,'edit']);
Route::post('insert_periode_CPON', [t_mere_periode_cponController::class, 'store']);
Route::post('update_periode_CPON/{id}', [t_mere_periode_cponController::class, 'store']);
Route::get("delete_periode_CPON/{id}", [t_mere_periode_cponController::class, 'destroy']);

Route::get("fetch_periode_CPN",[t_mere_periode_cpnController::class, 'index']);
Route::get("fetch_periode_cpn_mere2",[t_mere_periode_cpnController::class, 'fetch_periode_cpn_mere2']);
Route::get("fetch_single_periode_CPN/{id}",[t_mere_periode_cpnController::class,'edit']);
Route::post('insert_periode_CPN', [t_mere_periode_cpnController::class, 'store']);
Route::post('update_periode_CPN/{id}', [t_mere_periode_cpnController::class, 'store']);
Route::get("delete_periode_CPN/{id}", [t_mere_periode_cpnController::class, 'destroy']);

Route::get("fetch_periode_Peni",[t_periode_peni_mereController::class, 'index']);
Route::get("fetch_periode_peni_mere2",[t_periode_peni_mereController::class, 'fetch_periode_peni_mere2']);
Route::get("fetch_single_periode_Peni/{id}",[t_periode_peni_mereController::class,'edit']);
Route::post('insert_periode_Peni', [t_periode_peni_mereController::class, 'store']);
Route::post('update_periode_Peni/{id}', [t_periode_peni_mereController::class, 'store']);
Route::get("delete_periode_Peni/{id}", [t_periode_peni_mereController::class, 'destroy']);

//=========PERIODE_CPON=======================
Route::get("fetch_periode_sp",[t_mere_periode_spController::class, 'index']);
Route::get("fetch_periode_sp_mere2",[t_mere_periode_spController::class, 'fetch_periode_sp_mere2']);
Route::get("fetch_single_periode_sp/{id}",[t_mere_periode_spController::class,'edit']);
Route::post('insert_periode_sp', [t_mere_periode_spController::class, 'store']);
Route::post('update_periode_sp/{id}', [t_mere_periode_spController::class, 'store']);
Route::get("delete_periode_sp/{id}", [t_mere_periode_spController::class, 'destroy']);


//=========PERIODE_vacciniere=======================
Route::get("fetch_periode_vacciniere",[t_mere_periode_vacciniereController::class, 'index']);
Route::get("fetch_periode_vaccin_mere2",[t_mere_periode_vacciniereController::class, 'fetch_periode_vaccin_mere2']);
Route::get("fetch_single_periode_vacciniere/{id}",[t_mere_periode_vacciniereController::class,'edit']);
Route::post('insert_periode_vacciniere', [t_mere_periode_vacciniereController::class, 'store']);
Route::post('update_periode_vacciniere/{id}', [t_mere_periode_vacciniereController::class, 'store']);
Route::get("delete_periode_vacciniere/{id}", [t_mere_periode_vacciniereController::class, 'destroy']);

//=========PERIODE_rendevous-vac======================= fetch_rdv_mere
Route::get("fetch_rdv_mere",[t_mere_rendez_vous_vac_mereController::class, 'fetch_rdv_mere']);
Route::get("fetch_rendezvous_vac_mere",[t_mere_rendez_vous_vac_mereController::class, 'all']);
Route::get("fetch_single_rendezvous_vac_mere/{id}",[t_mere_rendez_vous_vac_mereController::class,'fetch_single']);
Route::get("fetch_rdv_vaccin_mere_entete/{refCPN}",[t_mere_rendez_vous_vac_mereController::class,'fetch_detail_entete']);
Route::post('insert_rendezvous_vac_mere', [t_mere_rendez_vous_vac_mereController::class, 'insertData']);
Route::post('update_rendezvous_vac_mere/{id}', [t_mere_rendez_vous_vac_mereController::class, 'updateData']);
Route::get("delete_rendezvous_vac_mere/{id}", [t_mere_rendez_vous_vac_mereController::class, 'destroy']);


//=========SP_MERE======================
Route::get("fetch_sp_mere",[t_mere_sp_mereController::class, 'all']);
Route::get("fetch_single_sp_mere/{id}",[t_mere_sp_mereController::class,'fetch_single']);
Route::get("fetch_sp_mere_entete/{refCPN}",[t_mere_sp_mereController::class,'fetch_detail_entete']);
Route::post('insert_sp_mere', [t_mere_sp_mereController::class, 'insertData']);
Route::post('update_sp_mere/{id}', [t_mere_sp_mereController::class, 'updateData']);
Route::get("delete_sp_mere/{id}", [t_mere_sp_mereController::class, 'destroy']);

//=========vaccination_mere====================== 
Route::get("fetch_vaccination_mere",[t_mere_vaccination_mereController::class, 'all']);
Route::get("fetch_single_vaccination_mere/{id}",[t_mere_vaccination_mereController::class,'fetch_single']);
Route::get("fetch_vaccinationmere_entete/{refCPN}",[t_mere_vaccination_mereController::class,'fetch_detail_entete']);
Route::post('insert_vaccination_mere', [t_mere_vaccination_mereController::class, 'insertData']);
Route::post('update_vaccination_mere/{id}', [t_mere_vaccination_mereController::class, 'updateData']);
Route::get("delete_vaccination_mere", [t_mere_vaccination_mereController::class, 'destroy']);

//=========vaccination_mere====================== fetch_detail_entete
Route::get("fetch_cpon_mere",[t_merecponController::class, 'all']);
Route::get("fetch_single_cpon_mere/{id}",[t_merecponController::class,'fetch_single']);
Route::get("fetch_cponmere_entete/{refCPN}",[t_merecponController::class,'fetch_detail_entete']);
Route::post('insert_cpon_mere', [t_merecponController::class, 'insertData']);
Route::post('update_cpon_mere/{id}', [t_merecponController::class, 'updateData']);
Route::get("delete_cpon_mere/{id}", [t_merecponController::class, 'destroy']);


Route::get("fetch_peni_mere",[t_mere_peniController::class, 'all']);
Route::get("fetch_single_peni_mere/{id}",[t_mere_peniController::class,'fetch_single']);
Route::get("fetch_peni_mere_entete/{refCPN}",[t_mere_peniController::class,'fetch_detail_entete']);
Route::post('insert_peni_mere', [t_mere_peniController::class, 'insertData']);
Route::post('update_peni_mere/{id}', [t_mere_peniController::class, 'updateData']);
Route::get("delete_peni_mere/{id}", [t_mere_peniController::class, 'destroy']);

//=========NEUROLOGIE======================
//
//=========annexe_neurologie======================
Route::get("fetch_all_annexe_neurologie", [tneuro_annxeController::class, 'all']);
Route::get("fetch_single_annexe_neurologie/{id}",[tneuro_annxeController::class,'fetch_single_annexe_neurologie']);
Route::get("downloadfile/{filenamess}",[tneuro_annxeController::class,'downloadfile']);
Route::get("fetch_annexe_neuro_protocole/{refProtocole}",[tneuro_annxeController::class,'fetch_annexe_neuro_protocole']);
Route::post('insert_annexe_neurologie', [tneuro_annxeController::class, 'insertData']);
Route::post('update_annexe_neurologie', [tneuro_annxeController::class, 'updateData']);
Route::get("delete_annexe_neurologie/{id}", [tneuro_annxeController::class, 'delete_annexe']);

Route::get("fetch_all_annexe_laboratoire", [tlabo_annexeController::class, 'all']);
Route::get("fetch_single_annexe_laboratoire/{id}",[tlabo_annexeController::class,'fetch_single_data']);
Route::get("downloadfile_labo/{filenamess}",[tlabo_annexeController::class,'downloadfile']);
Route::get("fetch_annexe_laboratoire_labo/{refEnteteLabo}",[tlabo_annexeController::class,'fetch_date_entete']);
Route::post('insert_annexe_laboratoire', [tlabo_annexeController::class, 'insertData']);
Route::post('update_annexe_laboratoire', [tlabo_annexeController::class, 'updateData']);
Route::get("delete_annexe_laboratoire/{id}", [tlabo_annexeController::class, 'delete_entete']);

Route::get("fetch_all_annexe_patient", [tpatient_annexesController::class, 'all']);
Route::get("fetch_single_annexe_patient/{id}",[tpatient_annexesController::class,'fetch_single_annexe_patient']);
Route::get("downloadfile_patient/{filenamess}",[tpatient_annexesController::class,'downloadfile']);
Route::get("fetch_annexe_patient/{refPatient}",[tpatient_annexesController::class,'fetch_annexe_patient']);
Route::post('insert_annexe_patient', [tpatient_annexesController::class, 'insertData']);
Route::post('update_annexe_patient', [tpatient_annexesController::class, 'updateData']);
Route::get("delete_annexe_patient/{id}", [tpatient_annexesController::class, 'delete_annexe']);

Route::get("fetch_all_annexe_imagerie", [timagerieannexeController::class, 'all']);
Route::get("fetch_single_annexe_imagerie/{id}",[timagerieannexeController::class,'fetch_single_annexe_imagerie']);
Route::get("downloadfile_imagerie/{filenamess}",[timagerieannexeController::class,'downloadfile']);
Route::get("fetch_annexe_imagerie/{refImagerie}",[timagerieannexeController::class,'fetch_annexe_imagerie']);
Route::post('insert_annexe_imagerie', [timagerieannexeController::class, 'insertData']);
Route::post('update_annexe_imagerie', [timagerieannexeController::class, 'updateData']);
Route::get("delete_annexe_imagerie/{id}", [timagerieannexeController::class, 'delete_annexe']);

Route::get("fetch_all_archivage", [tEnfantArchivageController::class, 'all']);
Route::get("fetch_single_archivage/{id}",[tEnfantArchivageController::class,'fetch_single_archivage']);
// Route::get("downloadfile_imagerie/{filenamess}",[tEnfantArchivageController::class,'downloadfile']);
Route::post('insert_archivage', [tEnfantArchivageController::class, 'insertData']);
Route::post('update_archivage', [tEnfantArchivageController::class, 'updateData']);
Route::get("delete_archivage/{id}", [tEnfantArchivageController::class, 'delete_annexe']);

Route::get("fetch_all_annexe_imagerie_ext", [timagerieannexeextController::class, 'all']);
Route::get("fetch_single_annexe_imagerie_ext/{id}",[timagerieannexeextController::class,'fetch_single_annexe_imagerie']);
Route::get("downloadfile_imagerie_ext/{filenamess}",[timagerieannexeextController::class,'downloadfile']);
Route::get("fetch_annexe_imagerie_ext/{refImagerie}",[timagerieannexeextController::class,'fetch_annexe_imagerie_ext']);
Route::post('insert_annexe_imagerie_ext', [timagerieannexeextController::class, 'insertData']);
Route::post('update_annexe_imagerie_ext', [timagerieannexeextController::class, 'updateData']);
Route::get("delete_annexe_imagerie_ext/{id}", [timagerieannexeextController::class, 'delete_annexe']);
//=========protocoleNeulogie======================
Route::get("fetch_protocoleNero",[tnero_protocole_neurologieController::class, 'all']);
Route::get("fetch_single_protocoleNero/{id}",[tnero_protocole_neurologieController::class,'fetch_single_protocole_neuro']);
Route::get("fetch_protocoleNero_cons/{refDetailConst}",[tnero_protocole_neurologieController::class,'fetch_protocole_cons']);
Route::post('insert_protocoleNero',[tnero_protocole_neurologieController::class, 'insertData']);
Route::post('update_protocoleNero/{id}', [tnero_protocole_neurologieController::class, 'updateData']);
Route::get("delete_protocoleNero/{id}", [tnero_protocole_neurologieController::class, 'destroy']);
//=========Type rapport======================
Route::get("fetch_type_rapport",[tnero_type_rapportController::class, 'all']);
Route::get("fetch_typerapportneuro_2",[tnero_type_rapportController::class, 'fetch_typerapportneuro_2']);
Route::get("fetch_single_type_rapport/{id}",[tnero_type_rapportController::class,'edit']);
Route::post('insert_type_rapport',[tnero_type_rapportController::class, 'store']);
Route::post('update_type_rapport/{id}', [tnero_type_rapportController::class, 'store']);
Route::get("delete_type_rapport/{id}", [tnero_type_rapportController::class, 'destroy']);
//=========ENFANT======================
//========enfant en mode attente====================== fetch_mode_vac_enfant2
Route::get("fetch_attente",[t_enfant_mode_attente_enfantController::class, 'index']);
Route::get("fetch_mode_vac_enfant2",[t_enfant_mode_attente_enfantController::class, 'fetch_mode_vac_enfant2']);
Route::get("fetch_single_attente/{id}",[t_enfant_mode_attente_enfantController::class,'edit']);
Route::post('insert_attente',[t_enfant_mode_attente_enfantController::class, 'store']);
Route::post('update_attente/{id}', [t_enfant_mode_attente_enfantController::class, 'store']);
Route::get("delete_attente/{id}", [t_enfant_mode_attente_enfantController::class, 'destroy']);
//========periode cps====================== fetch_periode_cps2
Route::get("fetch_periodeCps",[t_enfant_periode_c_p_sController::class, 'index']);
Route::get("fetch_periode_cps2",[t_enfant_periode_c_p_sController::class, 'fetch_periode_cps2']);
Route::get("fetch_single_periodeCps{id}",[t_enfant_periode_c_p_sController::class,'edit']);
Route::post('insert_periodeCps',[t_enfant_periode_c_p_sController::class, 'store']);
Route::post('update_periodeCps/{id}', [t_enfant_periode_c_p_sController::class, 'store']);
Route::get("delete_periodeCps/{id}", [t_enfant_periode_c_p_sController::class, 'destroy']);
//========strategie====================== fetch_strategie_vac_enfant2
Route::get("fetch_strategie",[t_enfant_strategieController::class, 'index']);
Route::get("fetch_strategie_vac_enfant2",[t_enfant_strategieController::class, 'fetch_strategie_vac_enfant2']);
Route::get("fetch_single_strategie{id}",[t_enfant_strategieController::class,'edit']);
Route::post('insert_strategie',[t_enfant_strategieController::class, 'store']);
Route::post('update_strategie/{id}', [t_enfant_strategieController::class, 'store']);
Route::get("delete_strategie/{id}", [t_enfant_strategieController::class, 'destroy']);
//========categorie====================== 
Route::get("fetch_categorieEf",[tenfant_categorieController::class, 'index']);
Route::get("fetch_categorie_vac_enfant2",[tenfant_categorieController::class, 'fetch_categorie_vac_enfant2']);
Route::get("fetch_single_categorieEfe{id}",[tenfant_categorieController::class,'edit']);
Route::post('insert_categorieEf',[tenfant_categorieController::class, 'store']);
Route::post('update_categorieEf/{id}', [tenfant_categorieController::class, 'store']);
Route::get("delete_categorieEf/{id}", [tenfant_categorieController::class, 'destroy']);
//========CPS======================
Route::get("fetch_cps",[tenfant_cpsController::class, 'all']);
Route::get("fetch_single_cps{id}",[tenfant_cpsController::class,'fetch_single']);
Route::get("fetch_cps_entetevac/{refEnteteVac}",[tenfant_cpsController::class,'fetch_cps_entetevac']);
Route::post('insert_cps', [tenfant_cpsController::class, 'insertData']);
Route::post('update_cps/{id}', [tenfant_cpsController::class, 'updateData']);
Route::get("delete_cps/{id}", [tenfant_cpsController::class, 'destroy']);
//=========entete vaccin======================
Route::get("fetch_enteteVaccin",[tenfant_entete_vaccinationController::class, 'all']);
Route::get("fetch_single_enteteVaccin/{id}",[tenfant_entete_vaccinationController::class,'fetch_single']);
Route::get("fetch_enteteVaccin_mouvement/{refMouvement}",[tenfant_entete_vaccinationController::class,'fetch_entete_mouvement']);
Route::post('insert_enteteVaccin',[tenfant_entete_vaccinationController::class, 'insertData']);
Route::post('update_enteteVaccin/{id}', [tenfant_entete_vaccinationController::class, 'updateData']);
Route::get("delete_enteteVaccin/{id}", [tenfant_entete_vaccinationController::class, 'destroy']);
//========enfant en mode attente======================  fetch_periode_vac_enfant2
Route::get("fetch_periodeVac",[tenfant_periode_vac_enfantController::class, 'index']);
Route::get("fetch_periode_vac_enfant2",[tenfant_periode_vac_enfantController::class, 'fetch_periode_vac_enfant2']);
Route::get("fetch_single_periodeVac/{id}",[tenfant_periode_vac_enfantController::class,'edit']);
Route::post('insert_periodeVac',[tenfant_periode_vac_enfantController::class, 'store']);
Route::post('update_periodeVac/{id}', [tenfant_periode_vac_enfantController::class, 'store']);
Route::get("delete_periodeVac/{id}", [tenfant_periode_vac_enfantController::class, 'destroy']);
//=========Rendez-vous Enfant====================== fetch_rdv_patient
Route::get("fetch_rendezvous",[tenfant_rendevous_enfantController::class, 'all']);
Route::get("fetch_rdv_patient",[tenfant_rendevous_enfantController::class, 'fetch_rdv_patient']);
Route::get("fetch_single_rendezvous/{id}",[tenfant_rendevous_enfantController::class,'fetch_single']);
Route::get("fetch_rendezvous_vaccination/{refEntete}",[tenfant_rendevous_enfantController::class,'fetch_rendezvous_vaccination']);
Route::post('insert_rendezvous',[tenfant_rendevous_enfantController::class, 'insertData']);
Route::post('update_rendezvous/{id}', [tenfant_rendevous_enfantController::class, 'updateData']);
Route::get("delete_rendezvous/{id}", [tenfant_rendevous_enfantController::class, 'destroy']);
//=========Vaccination enfant======================
Route::get("fetch_vaccinationEnfant",[tenfant_vaccination_enfantController::class, 'all']);
Route::get("fetch_single_vaccinationEnfant/{id}",[tenfant_vaccination_enfantController::class,'fetch_single']);
Route::get("fetch_vacination_enfant_entete/{refEnteteVac}",[tenfant_vaccination_enfantController::class,'fetch_vacination_entete']);
Route::post('insert_vaccinationEnfant',[tenfant_vaccination_enfantController::class, 'insertData']);
Route::post('update_vaccinationEnfant/{id}', [tenfant_vaccination_enfantController::class, 'updateData']);
Route::get("delete_vaccinationEnfant", [tenfant_vaccination_enfantController::class, 'destroy']);
//========Vaccin enfant================================================================
Route::get("fetch_vaccin",[tenfant_vaccinController::class, 'all']);
Route::get("fetch_single_vaccin/{id}",[tenfant_vaccinController::class,'fetch_single']);
Route::post('insert_vaccin',[tenfant_vaccinController::class, 'insertData']);
Route::post('update_vaccin/{id}', [tenfant_vaccinController::class, 'updateData']);
Route::get("delete_vaccin/{id}", [tenfant_vaccinController::class, 'destroy']);
//===========TEST CUTANE=====================
Route::get("fetch_detailTest",[tenfant_detail_test_cutaneController::class, 'all']);
Route::get("fetch_single_detailTest/{id}",[tenfant_detail_test_cutaneController::class,'fetch_single_test']);
Route::get("fetch_detail_for_entete/{refEnteteTest}",[tenfant_detail_test_cutaneController::class,'fetch_detail_for_entete']);
Route::post('insert_detailTest',[tenfant_detail_test_cutaneController::class, 'insertData']);
Route::post('update_detailTest/{id}', [tenfant_detail_test_cutaneController::class, 'updateData']);
Route::get("delete_detailTest/{id}", [tenfant_detail_test_cutaneController::class, 'destroy']);
//=====================Entete_Test=====================
Route::get("fetch_enteteTest",[tenfant_entete_test_cutaneController::class, 'all']);
Route::get("fetch_single_enteteTest/{id}",[tenfant_entete_test_cutaneController::class,'fetch_single_test']);
Route::get("fetch_detail_for_entete/{refDetailCons}",[tenfant_entete_test_cutaneController::class,'fetch_testCutane_for_cons']);
Route::post('insert_enteteTest',[tenfant_entete_test_cutaneController::class, 'insertData']);
Route::post('update_enteteTest/{id}', [tenfant_entete_test_cutaneController::class, 'updateData']);
Route::get("delete_enteteTest/{id}", [tenfant_entete_test_cutaneController::class, 'destroy']);
//========type test===================== fetch_type_test_cutane2
Route::get("fetch_typeTest",[tenfant_type_testController::class, 'index']);
Route::get("fetch_type_test_cutane2",[tenfant_type_testController::class, 'fetch_type_test_cutane2']);
Route::get("fetch_single_typeTest/{id}",[tenfant_type_testController::class,'edit']);
Route::post('insert_typeTest',[tenfant_type_testController::class, 'store']);
Route::post('update_typeTest/{id}', [tenfant_type_testController::class, 'store']);
Route::get("delete_typeTest/{id}", [tenfant_type_testController::class, 'destroy']);

//===================== GESTION LOGISTIQUE ========================================================================================
//
Route::get('/fetch_entete_log_sortie', [tlog_entete_sortieController::class, 'all']);
Route::get('/fetch_single_entete_log_sortie/{id}', [tlog_entete_sortieController::class, 'fetch_single_entete']);
Route::get('/fetch_entete_log_sortie_service/{refService}', [tlog_entete_sortieController::class, 'fetch_entete_service']);        
Route::post('/insert_entete_log_sortie', [tlog_entete_sortieController::class, 'insert_entete']);
Route::post('/update_entete_log_sortie/{id}', [tlog_entete_sortieController::class, 'update_entete']);
Route::get('/delete_entete_log_sortie/{id}', [tlog_entete_sortieController::class, 'delete_entete']);

Route::get('/fetch_detail_log_sortie', [tlog_detail_sortieController::class, 'all']);
Route::get('/fetch_single_detail_log_sortie/{id}', [tlog_detail_sortieController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entete_log_sortie/{refEntete}', [tlog_detail_sortieController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detail_log_sortie', [tlog_detail_sortieController::class, 'insert_detail']);
Route::post('/update_detail_log_sortie/{id}', [tlog_detail_sortieController::class, 'update_detail']);
Route::get('/delete_detail_log_sortie/{id}', [tlog_detail_sortieController::class, 'delete_detail']);

Route::get('/fetch_entete_log_entree', [tlog_entete_entreeController::class, 'all']);
Route::get('/fetch_single_entete_log_entree/{id}', [tlog_entete_entreeController::class, 'fetch_single_entete']);
Route::get('/fetch_entete_log_entree_fournisseur/{refFournisseur}', [tlog_entete_entreeController::class, 'fetch_entete_fournisseur']);        
Route::post('/insert_entete_log_entree', [tlog_entete_entreeController::class, 'insert_entete']);
Route::post('/update_entete_log_entree/{id}', [tlog_entete_entreeController::class, 'update_entete']);
Route::get('/delete_entete_log_entree/{id}', [tlog_entete_entreeController::class, 'delete_entete']);

Route::get('/fetch_detail_log_entree', [tlog_detail_entreeController::class, 'all']);
Route::get('/fetch_single_detail_log_entree/{id}', [tlog_detail_entreeController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entete_log_entree/{refEntete}', [tlog_detail_entreeController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detail_log_entree', [tlog_detail_entreeController::class, 'insert_detail']);
Route::post('/update_detail_log_entree/{id}', [tlog_detail_entreeController::class, 'update_detail']);
Route::get('/delete_detail_log_entree/{id}', [tlog_detail_entreeController::class, 'delete_detail']);

Route::get('/fetch_entete_log_requisition', [tlog_entete_requisitionController::class, 'all']);
Route::get('/fetch_single_entete_log_requisition/{id}', [tlog_entete_requisitionController::class, 'fetch_single_entete']);
Route::get('/fetch_entete_log_requisition_fournisseur/{refFournisseur}', [tlog_entete_requisitionController::class, 'fetch_entete_fournisseur']);        
Route::post('/insert_entete_log_requisition', [tlog_entete_requisitionController::class, 'insert_entete']);
Route::post('/update_entete_log_requisition/{id}', [tlog_entete_requisitionController::class, 'update_entete']);
Route::get('/delete_entete_log_requisition/{id}', [tlog_entete_requisitionController::class, 'delete_entete']);

Route::get('/fetch_detail_log_requisition', [tlog_detail_requisitionController::class, 'all']);
Route::get('/fetch_single_detail_log_requisition/{id}', [tlog_detail_requisitionController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_entete_log_requisition/{refEntete}', [tlog_detail_requisitionController::class, 'fetch_detail_for_entete']);        
Route::post('/insert_detail_log_requisition', [tlog_detail_requisitionController::class, 'insert_detail']);
Route::post('/update_detail_log_requisition/{id}', [tlog_detail_requisitionController::class, 'update_detail']);
Route::get('/delete_detail_log_requisition/{id}', [tlog_detail_requisitionController::class, 'delete_detail']);

//=================================================================================================================================


//=====================GESTION PERSONNELLE===================================

//=====================AffectationAgent===================================
Route::get("fetch_all_AffectationAgent",[tperso_affectation_agentController::class, 'all']);
Route::get("fetch_affectation_agent",[tperso_affectation_agentController::class, 'fetch_affectation_agent']);
Route::get("fetch_AffectationAgent/{refAgent}",[tperso_affectation_agentController::class, 'fetch_affect_agent']);
Route::get("fetch_single_AffectationAgent/{id}",[tperso_affectation_agentController::class,'fetch_single']);
Route::post('insert_AffectationAgent',[tperso_affectation_agentController::class, 'insert_data']);
Route::post('update_AffectationAgent/{id}', [tperso_affectation_agentController::class, 'update_data']);
Route::get("delete_AffectationAgent/{id}", [tperso_affectation_agentController::class, 'delete_data']);
//=====================annee===================================
Route::get("fetch_all_annee",[tperso_anneeController::class, 'index']);
Route::get("fetch_annee2",[tperso_anneeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_annee/{id}",[tperso_anneeController::class,'edit']);
Route::post('insert_annee',[tperso_anneeController::class, 'store']);
Route::post('update_annee/{id}', [tperso_anneeController::class, 'store']);
Route::get("delete_annee/{id}", [tperso_anneeController::class, 'destroy']);
//=====================appreciationAgent===================================
Route::get("fetch_all_appreciation_agent",[tperso_appreciation_agentController::class, 'all']);
Route::get("fetch_appreciation_agent/{refAffectation}",[tperso_appreciation_agentController::class, 'fetch_affect_appreciation']);
Route::get("fetch_single_appreciation_agent/{id}",[tperso_appreciation_agentController::class,'fetch_single']);
Route::post('insert_appreciation_agentt',[tperso_appreciation_agentController::class, 'insert_data']);
Route::post('update_appreciation_agent/{id}', [tperso_appreciation_agentController::class, 'update_data']);
Route::get("delete_appreciation_agent/{id}", [tperso_appreciation_agentController::class, 'delete_data']);
//=====================RAPPORT PERSONNELS===================================   
Route::get("pdf_bon_soin",[Pdf_PersonnelController::class, 'pdf_bon_soin']);
Route::get("pdf_bon_sortie_agent",[Pdf_PersonnelController::class, 'pdf_bon_sortie_agent']);
Route::get("pdf_fiche_appreciation_agent",[Pdf_PersonnelController::class, 'pdf_fiche_appreciation_agent']);
Route::get("pdf_conge_annuel",[Pdf_PersonnelController::class, 'pdf_conge_annuel']);
Route::get("pdf_autres_conges",[Pdf_PersonnelController::class, 'pdf_autres_conges']);
Route::get("pdf_conge_maladie",[Pdf_PersonnelController::class, 'pdf_conge_maladie']);
Route::get("pdf_conge_famillial",[Pdf_PersonnelController::class, 'pdf_conge_famillial']);
Route::get("pdf_conge_maternite",[Pdf_PersonnelController::class, 'pdf_conge_maternite']);
Route::get("fetch_rapport_paiement_date_mois",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois']);
Route::get("pdf_bulletin_paie",[Pdf_PersonnelController::class, 'pdf_bulletin_paie']);
Route::get("fetch_rapport_paiement_date_mois_rubrique",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_mois_rubrique']);
Route::get("fetch_rapport_paiement_date",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date']);
Route::get("fetch_rapport_paiement_date_service",[Pdf_PersonnelController::class, 'fetch_rapport_paiement_date_service']);
//fetch_rapport_paiement_date_mois_rubrique
//=====================autreConge===================================
Route::get("fetch_all_autreConge",[tperso_autre_congeController::class, 'all']);
Route::get("fetch_autreConge/{refEnteteConge}",[tperso_autre_congeController::class, 'fetch_affect_autreConge']);
Route::get("fetch_single_autreConge/{id}",[tperso_autre_congeController::class,'fetch_single']);
Route::post('insert_autreConge',[tperso_autre_congeController::class, 'insert_data']);
Route::post('update_autreConge/{id}', [tperso_autre_congeController::class, 'update_data']);
Route::get("delete_autreConge/{id}", [tperso_autre_congeController::class, 'delete_data']);
//=====================categorieAgent===================================
Route::get("fetch_all_categorie_agent",[tperso_categorie_agentController::class, 'index']);
Route::get("fetch_dopdown_categorie_agent",[tperso_categorie_agentController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_agent/{id}",[tperso_categorie_agentController::class,'edit']);
Route::post('insert_categorie_agent',[tperso_categorie_agentController::class, 'store']);
Route::post('update_categorie_agent/{id}', [tperso_categorie_agentController::class, 'store']);
Route::get("delete_categorie_agent/{id}", [tperso_categorie_agentController::class, 'destroy']);
//=====================categorieRubrique===================================
Route::get("fetch_all_categorie_rubrique_pers",[tperso_categorie_rubriqueController::class, 'index']);
Route::get("fetch_dopdown_categorie_rubrique_pers",[tperso_categorie_rubriqueController::class,'fetch_dropdown_2']);
Route::get("fetch_single_categorie_rubrique_pers/{id}",[tperso_categorie_rubriqueController::class,'edit']);
Route::post('insert_categorie_rubrique_pers',[tperso_categorie_rubriqueController::class, 'store']);
Route::post('update_categorie_rubrique_pers/{id}', [tperso_categorie_rubriqueController::class, 'store']);
Route::get("delete_categorie_rubrique_pers/{id}", [tperso_categorie_rubriqueController::class, 'destroy']);
//=====================categorieService===================================
Route::get("fetch_all_categorie_service_pers",[tperso_categorie_serviceController::class, 'index']);
Route::get("fetch_categorie_service_personnel_2",[tperso_categorie_serviceController::class,'fetch_categorie_service_2']);
Route::get("fetch_single_categorie_service_pers/{id}",[tperso_categorie_serviceController::class,'edit']);
Route::post('insert_categorie_service_pers',[tperso_categorie_serviceController::class, 'store']);
Route::post('update_categorie_service_pers/{id}', [tperso_categorie_serviceController::class, 'store']);
Route::get("delete_categorie_service_pers/{id}", [tperso_categorie_serviceController::class, 'destroy']);
//=====================conge annuel===================================
Route::get("fetch_all_congeAnnuel",[tperso_conge_annuelController::class, 'all']);
Route::get("fetch_congeAnnuel/{refEnteteConge}",[tperso_conge_annuelController::class, 'fetch_entete_congeAnnuel']);
Route::get("fetch_single_congeAnnuel/{id}",[tperso_conge_annuelController::class,'fetch_single']);
Route::post('insert_congeAnnuel',[tperso_conge_annuelController::class, 'insert_data']);
Route::post('update_congeAnnuel/{id}', [tperso_conge_annuelController::class, 'update_data']);
Route::get("delete_congeAnnuel/{id}", [tperso_conge_annuelController::class, 'delete_data']);
//=====================conge famililiale===================================
Route::get("fetch_all_conge_familiale",[tperso_conge_familialeController::class, 'all']);
Route::get("fetch_conge_familiale/{refEnteteConge}",[tperso_conge_familialeController::class, 'fetch_entete_congeFamiliale']);
Route::get("fetch_single_conge_familiale/{id}",[tperso_conge_familialeController::class,'fetch_single']);
Route::post('insert_conge_familiale',[tperso_conge_familialeController::class, 'insert_data']);
Route::post('update_conge_familiale/{id}', [tperso_conge_familialeController::class, 'update_data']);
Route::get("delete_conge_familiale/{id}", [tperso_conge_familialeController::class, 'delete_data']);


Route::get("fetch_all_avance_salaire",[tperso_avance_salaireController::class, 'all']);
Route::get("fetch_avance_salaire/{refAffectation}",[tperso_avance_salaireController::class, 'fetch_affect_controle']);
Route::get("fetch_single_avance_salaire/{id}",[tperso_avance_salaireController::class,'fetch_single']);
Route::post('insert_avance_salaire',[tperso_avance_salaireController::class, 'insert_data']);
Route::post('update_avance_salaire/{id}', [tperso_avance_salaireController::class, 'update_data']);
Route::get("delete_avance_salaire/{id}", [tperso_avance_salaireController::class, 'delete_data']);
//=====================controleConge===================================
Route::get("fetch_all_controleConge",[tperso_controle_congeController::class, 'all']);
Route::get("fetch_controleConge/{refAffectation}",[tperso_controle_congeController::class, 'fetch_affect_controle']);
Route::get("fetch_single_controleConge/{id}",[tperso_controle_congeController::class,'fetch_single']);
Route::post('insert_controleConge',[tperso_controle_congeController::class, 'insert_data']);
Route::post('update_controleConge/{id}', [tperso_controle_congeController::class, 'update_data']);
Route::get("delete_controleConge/{id}", [tperso_controle_congeController::class, 'delete_data']);
//=====================demande soin===================================
Route::get("fetch_all_demandeSoin",[tperso_demande_soinController::class, 'all']);
Route::get("fetch_demandeSoin_agent/{refAffectation}",[tperso_demande_soinController::class, 'fetch_affect_dmdSoin']);
Route::get("fetch_single_demandeSoin/{id}",[tperso_demande_soinController::class,'fetch_single']);
Route::post('insert_demandeSoin',[tperso_demande_soinController::class, 'insert_data']);
Route::post('update_demandeSoin/{id}', [tperso_demande_soinController::class, 'update_data']);
Route::get("delete_demandeSoin/{id}", [tperso_demande_soinController::class, 'delete_data']);
//=======================perso_dependant==============================================
Route::get("fetch_all_perso_dependant",[tperso_dependantConrtoller::class, 'all']);
Route::get("fetch_perso_dependant_agent/{refAgent}",[tperso_dependantConrtoller::class, 'fetch_depend_agent']);
Route::get("fetch_single_perso_dependant/{id}",[tperso_dependantConrtoller::class,'fetch_single']);
Route::post('insert_perso_dependant',[tperso_dependantConrtoller::class, 'insert_data']);
Route::post('update_perso_dependant/{id}', [tperso_dependantConrtoller::class, 'update_data']);
Route::get("delete_perso_dependant/{id}", [tperso_dependantConrtoller::class, 'delete_data']);
//==================== DetailAffectationRubrique==============================================
Route::get("fetch_detail_affectation_affect_agent/{refAffectation}",[tperso_detail_affectation_ribriqueController::class, 'fetch_detail_affectation_affect_agent']);
Route::get("fetch_all_DetailAffectationRubrique",[tperso_detail_affectation_ribriqueController::class, 'all']);
Route::get("fetch_DetailAffectationRubrique/{refAffectation}",[tperso_detail_affectation_ribriqueController::class,'fetch_affect_detail']);
Route::get("fetch_single_DetailAffectationRubrique/{id}",[tperso_detail_affectation_ribriqueController::class,'fetch_single']);
Route::post('insert_DetailAffectationRubriquet',[tperso_detail_affectation_ribriqueController::class, 'insert_data']);
Route::post('update_DetailAffectationRubrique{id}', [tperso_detail_affectation_ribriqueController::class, 'update_data']);
Route::get("delete_DetailAffectationRubrique/{id}", [tperso_detail_affectation_ribriqueController::class, 'delete_data']);

//fetch_detail_affectation_affect_agent
//==================== DetailPaiement==============================================
Route::get("fetch_all_DetailPaiement",[tperso_detail_paiement_salController::class, 'all']);
Route::get("fetch_DetailPaiement/{refEntetePaie}",[tperso_detail_paiement_salController::class,'fetch_entete_Detail']);
Route::get("fetch_single_DetailPaiement/{id}",[tperso_detail_paiement_salController::class,'fetch_single']);
Route::post('insert_DetailPaiement',[tperso_detail_paiement_salController::class, 'insert_data']);
Route::post('update_DetailPaiement{id}', [tperso_detail_paiement_salController::class, 'update_data']);
Route::get("delete_DetailPaiement/{id}", [tperso_detail_paiement_salController::class, 'delete_data']);
//====================EnteteConge==============================================
Route::get("fetch_all_EnteteConge",[tperso_entete_congeController::class, 'all']);
Route::get("fetch_EnteteConge/{refAffectation}",[tperso_entete_congeController::class,'fetch_affect_enteteConge']);
Route::get("fetch_single_EnteteConge/{id}",[tperso_entete_congeController::class,'fetch_single']);
Route::post('insert_EnteteConge',[tperso_entete_congeController::class, 'insert_data']);
Route::post('update_EnteteConge/{id}', [tperso_entete_congeController::class, 'update_data']);
Route::get("delete_EnteteConge/{id}", [tperso_entete_congeController::class, 'delete_data']);

//====================Entetepaiement==============================================
Route::get("fetch_all_Entetepaiement",[tperso_entete_paiementController::class, 'all']);
Route::get("fetch_entete_paiement_fiche/{refFichePaie}",[tperso_entete_paiementController::class,'fetch_entete_paiement_fiche']);
Route::get("fetch_single_Entetepaiement/{id}",[tperso_entete_paiementController::class,'fetch_single']);
Route::post('insert_Entetepaiement',[tperso_entete_paiementController::class, 'insert_data']);
Route::post('update_Entetepaiement{id}', [tperso_entete_paiementController::class, 'update_data']);
Route::get("delete_Entetepaiement/{id}", [tperso_entete_paiementController::class, 'delete_data']);
//=====================FichePaie=================================== insert_gobal_data
Route::get("fetch_all_FichePaie",[tperso_fiche_paieController::class, 'all']);
Route::get("fetch_single_FichePaie/{id}",[tperso_fiche_paieController::class,'fetch_single']);
Route::post('insert_FichePaie',[tperso_fiche_paieController::class, 'insert_data']);
Route::post('insert_Global_FichePaie',[tperso_fiche_paieController::class, 'insert_global_data']);
Route::post('update_FichePaie/{id}', [tperso_fiche_paieController::class, 'updateData']);
Route::get("delete_FichePaie/{id}", [tperso_fiche_paieController::class, 'destroy']);

//====================maladieConge==============================================
Route::get("fetch_all_maladieConge",[tperso_maladie_congeController::class, 'all']);
Route::get("fetch_maladieConge/{refEnteteConge}",[tperso_maladie_congeController::class,'fetch_entete_maladieConge']);
Route::get("fetch_single_maladieConge/{id}",[tperso_maladie_congeController::class,'fetch_single']);
Route::post('insert_maladieConge',[tperso_maladie_congeController::class, 'insert_data']);
Route::post('update_maladieConge/{id}', [tperso_maladie_congeController::class, 'update_data']);
Route::get("delete_maladieConge/{id}", [tperso_maladie_congeController::class, 'delete_data']);
//====================maternite==============================================
Route::get("fetch_all_maternite",[tperso_materniteController::class, 'all']);
Route::get("fetch_maternite/{refEnteteConge}",[tperso_materniteController::class,'fetch_entete_maternite']);
Route::get("fetch_single_maternite/{id}",[tperso_materniteController::class,'fetch_single']);
Route::post('insert_maternite',[tperso_materniteController::class, 'insert_data']);
Route::post('update_maternite/{id}', [tperso_materniteController::class, 'update_data']);
Route::get("delete_maternite/{id}", [tperso_materniteController::class, 'delete_data']);

//=====================mois===================================
Route::get("fetch_all_mois",[tperso_moisController::class, 'index']);
Route::get("fetch_dopdown_mois",[tperso_moisController::class,'fetch_dropdown_2']);
Route::get("fetch_single_mois/{id}",[tperso_moisController::class,'edit']);
Route::post('insert_mois',[tperso_moisController::class, 'store']);
Route::post('update_mois/{id}', [tperso_moisController::class, 'store']);
Route::get("delete_mois/{id}", [tperso_moisController::class, 'destroy']);

//====================parametreRubrique==============================================
//fetch_parametre_categorie_agent($refCategorieAgent)
Route::get("fetch_all_parametre_rubrique",[tperso_parametre_rubriqueController::class, 'all']);
Route::get("fetch_parametre_categorie_agent/{refCategorieAgent}",[tperso_parametre_rubriqueController::class, 'fetch_parametre_categorie_agent']);
Route::get("fetch_single_parametre_rubrique/{id}",[tperso_parametre_rubriqueController::class,'fetch_single']);
Route::post('insert_parametre_rubrique',[tperso_parametre_rubriqueController::class, 'insert_data']);
Route::post('update_parametre_rubrique/{id}', [tperso_parametre_rubriqueController::class, 'update_data']);
Route::get("delete_parametre_rubrique/{id}", [tperso_parametre_rubriqueController::class, 'delete_data']);
//=====================raisonFamiliale===================================
Route::get("fetch_all_raisonFamiliale",[tperso_raison_familialeController::class, 'index']);
Route::get("fetch_dopdown_raisonFamiliale",[tperso_raison_familialeController::class,'fetch_dropdown_2']);
Route::get("fetch_single_raisonFamiliale/{id}",[tperso_raison_familialeController::class,'edit']);
Route::post('insert_raisonFamiliale',[tperso_raison_familialeController::class, 'store']);
Route::post('update_raisonFamiliale/{id}', [tperso_raison_familialeController::class, 'store']);
Route::get("delete_raisonFamiliale/{id}", [tperso_raison_familialeController::class, 'destroy']);

//=====================Rubrique===================================
Route::get("fetch_all_Rubrique",[tperso_rubriqueController::class, 'all']);
Route::get("fetch_dopdown_Rubrique",[tperso_rubriqueController::class,'fetch_dropdown_2']);
Route::get("fetch_single_Rubrique/{id}",[tperso_rubriqueController::class,'fetch_single']);
Route::post('insert_Rubrique',[tperso_rubriqueController::class, 'insert_data']);
Route::post('update_Rubrique/{id}', [tperso_rubriqueController::class, 'update_data']);
Route::get("delete_Rubrique/{id}", [tperso_rubriqueController::class, 'destroy']);
//=====================Service Personnel===================================
//fetch_service_personnel_categorie
Route::get("fetch_all_servicePerso",[tperso_service_personnelController::class, 'all']);
Route::get("fetch_service_personnel2",[tperso_service_personnelController::class,'fetch_service_personnel2']);
Route::get("fetch_service_personnel_categorie/{refCatService}",[tperso_service_personnelController::class,'fetch_service_personnel_categorie']);
Route::get("fetch_single_servicePerso/{id}",[tperso_service_personnelController::class,'fetch_single']);
Route::post('insert_servicePerso',[tperso_service_personnelController::class, 'insert_data']);
Route::post('update_servicePerso/{id}', [tperso_service_personnelController::class, 'update_data']);
Route::get("delete_servicePerso/{id}", [tperso_service_personnelController::class, 'destroy']);
//====================sortie_agent==============================================
Route::get("fetch_all_sortieAgent",[tperso_sortie_agentController::class, 'all']);
Route::get("fetch_sortieAgent/{refAffectation}",[tperso_sortie_agentController::class,'fetch_sortieAgent_affect']);
Route::get("fetch_single_sortieAgent/{id}",[tperso_sortie_agentController::class,'fetch_single']);
Route::post('insert_sortieAgent',[tperso_sortie_agentController::class, 'insert_data']);
Route::post('update_sortieAgent/{id}', [tperso_sortie_agentController::class, 'update_data']);
Route::get("delete_sortieAgent/{id}", [tperso_sortie_agentController::class, 'delete_data']);

////pdf_statistique_type_mouvement
//pdf_statistique_patient
//StatistiquePatientPdfController


Route::get("pdf_statistique_type_mouvement", [StatistiquePatientPdfController::class, 'pdf_statistique_type_mouvement']); 
Route::get("pdf_statistique_patient", [StatistiquePatientPdfController::class, 'pdf_statistique_patient']); 

Route::get("pdf_resultatsperme_data", [Pdf_SpermogrammeController::class, 'pdf_resultatsperme_data']); 
Route::get("pdf_resultatbacteriologie_data", [Pdf_SpermogrammeController::class, 'pdf_resultatbacteriologie_data']); 

Route::get("pdf_scoreprobabiliste_data", [Pdf_CardiologieController::class, 'pdf_scoreprobabiliste_data']); 
Route::get("pdf_bon_analyse_imagerie_data", [Pdf_CardiologieController::class, 'pdf_bon_analyse_data']); 
Route::get("pdf_resultatECG_data", [Pdf_CardiologieController::class, 'pdf_resultatECG_data']); 
Route::get("pdf_resultatEchocardie_data", [Pdf_CardiologieController::class, 'pdf_resultatEchocardie_data']); 
Route::get("pdf_attestation_medicale_data", [Pdf_CardiologieController::class, 'pdf_attestation_medicale_data']); 

//fetch_rapport_detailentree_date
Route::get("fetch_pdf_rapport_detailentree_date", [PdfSortieMedicamentController::class, 'fetch_rapport_detailentree_date']); 
Route::get("fetch_pdf_rapport_detailsortie_date_medicament", [PdfSortieMedicamentController::class, 'fetch_rapport_detailvente_date_medicament']); 
Route::get("fetch_pdf_rapport_detailsortie_date_service", [PdfSortieMedicamentController::class, 'fetch_rapport_detailvente_date_service']); 
Route::get("fetch_pdf_rapport_detailsortie_date", [PdfSortieMedicamentController::class, 'fetch_rapport_detailvente_date']);

Route::get("fetch_pdf_fiche_stock_medicament_date", [Pdf_FicheStockMedicamentController::class, 'pdf_fiche_stock_produit']); 
Route::get("fetch_pdf_fiche_stock_medicament_categorie_date", [Pdf_FicheStockMedicamentController::class, 'pdf_fiche_stock_produit_categorie']); 

Route::get("pdf_fiche_stock_produit_service", [Pdf_FicheStockServiceController::class, 'pdf_fiche_stock_produit_service']); 

//Pdf_FicheStockServiceController

Route::get("fetch_pdf_rapport_detail_log_sortie_date", [PdfLogistiqueController::class, 'fetch_rapport_detailvente_date']); 
Route::get("fetch_pdf_rapport_detail_log_sortie_date_service", [PdfLogistiqueController::class, 'fetch_rapport_detailvente_date_service']); 
Route::get("fetch_pdf_rapport_detail_log_sortie_date_produit", [PdfLogistiqueController::class, 'fetch_rapport_detailvente_date_produit']); 
Route::get("fetch_pdf_rapport_detail_log_entree_date", [PdfLogistiqueController::class, 'fetch_rapport_detailentree_date']); 
Route::get("fetch_pdf_rapport_detail_log_cmd_date", [PdfLogistiqueController::class, 'fetch_rapport_detailcmd_date']); 

Route::get('fetch_pdf_rapport_detailvente_date_medicament', [PdfVenteMedicamentController::class, 'fetch_rapport_detailvente_date_medicament']); 
Route::get('fetch_pdf_rapport_detailvente_date_organisation', [PdfVenteMedicamentController::class, 'fetch_rapport_detailvente_date_organisation']); 
Route::get('fetch_pdf_rapport_detailvente_date', [PdfVenteMedicamentController::class, 'fetch_rapport_detailvente_date']); 

Route::get("pdf_scoreprobabiliste_data_ext", [Pdf_CardiologieExtController::class, 'pdf_scoreprobabiliste_data']); 
Route::get("pdf_resultatECG_data_ext", [Pdf_CardiologieExtController::class, 'pdf_resultatECG_data']); 
Route::get("pdf_resultatEchocardie_data_ext", [Pdf_CardiologieExtController::class, 'pdf_resultatEchocardie_data']); 



Route::get("fetch_all_enteteoperationcomptable",[tfin_entete_operationcompteController::class, 'all']);
Route::get("fetch_single_enteteoperationcomptable/{id}",[tfin_entete_operationcompteController::class,'fetch_single']);
Route::post('insert_enteteoperationcomptable',[tfin_entete_operationcompteController::class, 'insert_data']);
Route::post('update_enteteoperationcomptable/{id}', [tfin_entete_operationcompteController::class, 'updateData']);
Route::get("delete_enteteoperationcomptable/{id}", [tfin_entete_operationcompteController::class, 'destroy']);

Route::get('/fetch_detail_operationcomptable', [tfin_detail_operationcompteController::class, 'all']);
Route::get('/fetch_single_detail_operationcomptable/{id}', [tfin_detail_operationcompteController::class, 'fetch_single_detail']);
Route::get('/fetch_detail_enteteoperationcomptable/{refEnteteOperation}', [tfin_detail_operationcompteController::class, 'fetch_detail_entete']);
Route::post('/insert_detailoperationcomptable', [tfin_detail_operationcompteController::class, 'insert_detail']);
Route::post('/update_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'update_detail']);
Route::get('/delete_detailoperationcomptable/{id}', [tfin_detail_operationcompteController::class, 'delete_detail']);


Route::get("fetch_cloture_comptabilite", [tfin_cloture_comptabiliteController::class, 'index']);
Route::get("fetch_single_cloture_comptabilite/{id}",[tfin_cloture_comptabiliteController::class,'edit']);
Route::get("delete_cloture_comptabilite/{id}", [tfin_cloture_comptabiliteController::class,'destroy']);
Route::post("insert_cloture_comptabilite", [tfin_cloture_comptabiliteController::class,'store']);
Route::post('cloturer_Comptabilite', [tdepenseController::class, 'cloturer_Comptabilite']);
Route::get("fetch_tfin_cloture_comptabilite_2", [tfin_cloture_comptabiliteController::class, 'fetch_tfin_cloture_comptabilite_2']);



//========== PARTIE DASH BOARD ===================================================================================

Route::get("fetch_week", [SwotController::class, 'indexMotSemaine']);
Route::get("fetch_single_week/{id}", [SwotController::class, 'editMotSemaine']);
Route::get("delete_week/{id}", [SwotController::class, 'destroyMotSemaine']);
Route::post("insert_week", [SwotController::class, 'storeMotSemaine']);
Route::get("fetch_latest_week", [SwotController::class, 'showLatestweek']);
Route::get("fetch_latest_users", [SwotController::class, 'getListUsersLatest']);

Route::get('stat_consultation_genre',[SwotController::class, 'stat_consultation_genre']);

Route::get("showCountDashbord", [SwotController::class, 'showCountDashbord']);
Route::get('stat_users',[SwotController::class, 'stat_users']);
Route::get('pnudShowLineChartAssuranceAuto',[SwotController::class, 'pnudShowLineChartAssuranceAuto']);
Route::get('stat_users_sexe_ceo',[SwotController::class, 'stat_users_sexe_ceo']);

Route::get('stat_ordonance_genre',[SwotController::class, 'stat_ordonance_genre']);
Route::get('statEntreprise',[SwotController::class, 'statEntreprise']);
Route::get('statEntrepriseSecteur',[SwotController::class, 'statEntrepriseSecteur']);
//Route::get('statEntreprisePrint',[SwotController::class, 'statEntreprisePrint']);
Route::get("showCountDashbord_tug/{ceo}", [SwotController::class, 'showCountDashbord_tug']);


//================= EXCEL =======================================================================================

// Route::get("exportation", [SimpleExcelController::class, 'export'])->name('exportation');
// Route::get("ShowdetailfacturationAbonneeExcel", [SimpleExcelController::class, 'ShowdetailfacturationAbonneeExcel'])->name('ShowdetailfacturationAbonneeExcel');
// Route::get("ShowdetailfacturationPriveeExcel", [SimpleExcelController::class, 'ShowdetailfacturationPriveeExcel'])->name('ShowdetailfacturationPriveeExcel');

