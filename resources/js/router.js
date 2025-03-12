import Vue from 'vue'
import VueRouter from 'vue-router'

// import isNotAdmin from './app/middleware/isNotAdmin'
// import isNotUser from './app/middleware/isNotUser'
// import isNotMember from './app/middleware/isAdminOrSubAdmin'

import Dashoard from './components/Dashboard.vue'
import Client from './components/Client.vue'
import User from './components/User.vue'
import detail_client from './components/detail_client.vue'
import affectation from './components/Affectation.vue'

import Pays from './components/pays.vue'
import Province from './components/province.vue'
import Ville from './components/Ville.vue'
import Commune from './components/Commune.vue'
import Quartier from './components/Quartier.vue'
import Avenue from './components/Avenue.vue'
import Fournisseur from './components/Fournisseur.vue'
import CategorieClient from './components/CategorieClient.vue'
import Malades from './components/Malades.vue'
import Tabilation from './components/Consultations/Tabilation.vue'
//EnteteBesoinAll

import Elementproduit from './components/Elementproduit.vue'
import detail_medicament from './components/Pharmacies/DetailMedicament.vue'
import EnteteBesoinAll from './components/Pharmacies/EnteteBesoinAll.vue'
import entete_entree from './components/Pharmacies/EnteteEntree.vue'
import detail_entree from './components/Pharmacies/DetailEntree.vue'
import client_vente from './components/ClientVente.vue'
import entete_vente from './components/Pharmacies/Entete_vente.vue'
import detail_vente from './components/Pharmacies/DetailVente.vue'
import entete_sortie from './components/Pharmacies/Entete_sortie.vue'
import detail_sortie from './components/Pharmacies/DetailSortie.vue'
import paiement_vente from './components/PaiementVente.vue'
import CategorieSous from './components/CategorieSouscription.vue'
import entete_sous from './components/EnteteSouscription.vue'
import detail_sous from './components/DetailSouscription.vue'
import utilisateurs from './components/admin/crud.vue'
import entreprise from './components/Entreprise.vue'
import entrepriseDetail from './components/entrepriseDetail.vue'
import restaureEntrep from './components/RestoreEntreprise.vue'
import recouvrement from './components/Recouvrement.vue'
import compte from './components/Comptes.vue'
import depense from './components/Depenses.vue'
import recette from './components/Ressources.vue'
import mouvement_malade from './components/Mouvement_malade.vue'
import organisationabonne from './components/Facturations/OrganisationAbonne.vue'
import affectationabonne from './components/Facturations/AffectationAbonne.vue'
import type_mouvement_malade from './components/TypeMouvementMalade.vue'
import entete_triage from './components/Entete_triage.vue'
import detail_triage from './components/DetailTriage.vue'
import entete_consultation from './components/Consultations/Entete_Consultation.vue'
import detail_consultation from './components/Consultations/DetailConsultation.vue'
import type_consultation from './components/Consultations/TypeConsultation.vue'

import categorie_examen from './components/Laboratoire/CategorieExamen.vue'
import grand_categorie_examen from './components/Laboratoire/GCategorieExamen.vue'
import examen from './components/Laboratoire/Examen.vue'
import valeur_normale from './components/Laboratoire/ValeurNormale.vue'
import entete_labo from './components/Laboratoire/EnteteLabo.vue'
import detail_consultation_labo from './components/Laboratoire/DetailConsultation_Labo.vue'
import entete_labo_resultat from './components/Laboratoire/EnteteLabo_Resultat.vue'
import detail_labo from './components/Laboratoire/DetailLabo.vue'
import entete_labo_ext from './components/Laboratoire/EnteteLaboExt.vue'
import entete_labo_ext_resultat from './components/Laboratoire/EnteteLaboExt_Resultat.vue'
import mouvement_labo from './components/Laboratoire/Mouvement_malade_Labo.vue'
import detail_labo_ext from './components/Laboratoire/DetailLaboExt.vue'
import tube_examen from './components/Laboratoire/TubeExamen.vue'
import medecin from './components/Medecin.vue'
import categorie_medecin from './components/Medecins/CategorieMedecin.vue'
import fonction_medecin from './components/Medecins/FonctionMedecin.vue'
import service_hopital from './components/Medecins/ServiceHopital.vue'
import rapport_labo from './components/Rapports/Labo/RapportsJour.vue'
import unitevaleur from './components/Laboratoire/UniteValeur.vue'
import categorievaleur from './components/Laboratoire/CategorieValeur.vue'
import natureechantillon from './components/Laboratoire/NatureEchantillon.vue'
import methodeexamen from './components/Laboratoire/MethodeExamen.vue'
import facturation from './components/Facturations/Mouvement_malade_Facture.vue'

import typefrais from './components/Finances/TypeFrais.vue'
import typetarif from './components/Finances/TypeTarification.vue'
import modepaie from './components/Finances/ModePaiement.vue'
import entetepaie from './components/Finances/Entete_paiement.vue'
import detailpaie from './components/Finances/PaiementFacture.vue'
import CreateFacture from './components/Finances/CreateFacture.vue'
//

import agenda_medecin from './components/Rendezvous/AgendaMedecin.vue'
import agenda_reception from './components/Rendezvous/AgendaReception.vue'

import roles from './components/admin/role.vue'
import dashstatistique from './components/Dash/Dashbordstatistique_entreprise.vue'
import dashstatistiqueUser from './components/Dash/DashboardUser.vue'

//fetch_urgences
import CategorieMaladie from './components/Consultations/CategorieMaladie.vue'
import Maladie from './components/Consultations/Maladie.vue'
import DiagnosticDef from './components/Consultations/DiagnosticDef.vue'
import PrescriptionMedicament from './components/Consultations/PrescriptionMedicament.vue'
import MaladieChronique from './components/Consultations/MaladieChronique.vue'
import Urgences from './components/Consultations/Urgences.vue'

import CategorieMedicament from './components/Pharmacies/CategorieMedicament.vue'
import Medicament from './components/Pharmacies/Medicament.vue'


import DetailPlanSoin from './components/Hospitalisation/DetailPlanSoin.vue'
import DetailSortieHospi from './components/Hospitalisation/DetailSortieHospi.vue'
import Hospitalisation from './components/Hospitalisation/Hospitalisation.vue'
import HospitalisationAll from './components/Hospitalisation/HospitalisationAll.vue'
import Lit from './components/Hospitalisation/Lit.vue'
import PlanSoin from './components/Hospitalisation/PlanSoin.vue'
import Salle from './components/Hospitalisation/Salle.vue'
import ServiceHopi from './components/Hospitalisation/ServiceHopi.vue'
import ServiceSoin from './components/Hospitalisation/ServiceSoin.vue'
import SoinHospitalisation from './components/Hospitalisation/SoinHospitalisation.vue'
import SortieHospitalisation from './components/Hospitalisation/SortieHospitalisation.vue'
import SuiviHospitalisation from './components/Hospitalisation/SuiviHospitalisation.vue'
import TraitementHospitaliser from './components/Hospitalisation/TraitementHospitaliser.vue'

import EnteteChirurgie from './components/Chirurgie/EnteteChirurgie.vue'
import DetailChirurgie from './components/Chirurgie/DetailOperation.vue'

import ActeMedecin from './components/Consultations/ActeMedecin.vue'
import PoseActeMedecin from './components/Consultations/PoseActeMedecin.vue'
import ResumeClinique from './components/Consultations/ResumeClinique.vue'
import AutresOrientations from './components/Consultations/AutresOrientations.vue'


import RapportsDetailFactureAbonne from './components/Rapports/Finances/RapportsDetailFactureAbonne.vue'
import RapportsEnteteFactureAbonne from './components/Rapports/Finances/RapportsEnteteFactureAbonne.vue'


import DepartementFin from './components/Finances/DepartementFin.vue'
import ClassesFin from './components/Finances/Classes.vue'
import CompteFin from './components/Finances/CompteFin.vue'
import DetailFacturation from './components/Finances/DetailFacturation.vue'
import EnteteFacturation from './components/Finances/EnteteFacturation.vue'
import PaiementFacture from './components/Finances/PaiementFacture'
import ProduitFin from './components/Finances/ProduitFin.vue'
import SousCompte from './components/Finances/SousCompte.vue'
import SSousCompte from './components/Finances/SSousCompte.vue'
import TypeCompte from './components/Finances/TypeCompte.vue'
import TypeOperation from './components/Finances/TypeOperation.vue'
import TypePosition from './components/Finances/TypePosition.vue'
import TypeProduit from './components/Finances/TypeProduit.vue'
import UniteProduction from './components/Finances/UniteProduction.vue'
import Consultation_Finance from './components/Finances/Consultation_Finance.vue'
import Urgence_Finance from './components/Finances/Urgence_Finance.vue'
import Laboratoire_Finance from './components/Finances/Laboratoire_Finance.vue'
import DetailConsultation_Labo_Fin from './components/Finances/DetailConsultation_Labo_Fin.vue'

import Mvt_malade_Labo_Finance from './components/Finances/Mvt_malade_Labo_Finance.vue'
import EnteteLaboExt_Finance from './components/Finances/EnteteLaboExt_Finance.vue'
import TTaux from './components/Finances/TTaux.vue'
import RapportsDetailFacture from './components/Rapports/Finances/RapportsDetailFacture.vue'
import RapportsEnteteFacture from './components/Rapports/Finances/RapportsEnteteFacture.vue'
import RapportsPaiementFacture from './components/Rapports/Finances/RapportsPaiementFacture.vue'
import RechercheFacture from './components/Finances/RechercheFacture.vue'
import RechercheRecu from './components/Finances/RechercheRecu.vue'
import Banque from './components/Finances/Banque.vue'

//RapportsPaiementFacture
//Banque
import TypeAnalyse from './components/Imageries/TypeAnalyse.vue'
import AnalyseImagerie from './components/Imageries/AnalyseImagerie.vue'
import Imageries from './components/Imageries/Imageries.vue'
import ImageriesResultat from './components/Imageries/ImageriesResultat.vue'
import ImageriesFinance from './components/Imageries/ImageriesFinance.vue'
import Cardiologie from './components/Imageries/Cardiologie.vue'
import Endoscopie from './components/Imageries/Endoscopie.vue'
import ResultatScanner from './components/Imageries/ResultatScanner.vue'


import CategorieVaccin from './components/Dialyse/CategorieVaccin.vue'
import EnteteDialyse from './components/Dialyse/EnteteDialyse.vue'
import TypeMachine from './components/Dialyse/TypeMachine.vue'
import VaccinationDialyse from './components/Dialyse/VaccinationDialyse.vue'
import Vaccins from './components/Dialyse/Vaccins.vue'
import PoseCathetere from './components/Dialyse/PoseCathetere.vue'
import SurveillanceDialyse from './components/Dialyse/SurveillanceDialyse.vue'
import DetailSurveillanceDialyse from './components/Dialyse/DetailSurveillanceDialyse.vue'
import Ophtamologie from './components/Consultations/Ophtamologie.vue'

import Kinesitherapie from './components/Consultations/Kinesitherapie.vue'
import Kinesitherapie_result from './components/Consultations/Kinesitherapie_result.vue'
import Kinesitherapie_finance from './components/Consultations/Kinesitherapie_finance.vue'
import RapportMedical from './components/Consultations/RapportMedical.vue'
import RapportMedical_Finance from './components/Consultations/RapportMedical_Finance.vue'
import RapportMedical_Secretariat from './components/Consultations/RapportMedical_Secretariat.vue'

import EnteteReanimation from './components/Reanimation/EnteteReanimation.vue'

import Hospi_Appreciations from './components/Hospitalisation/Hospi_Appreciations.vue'
import Hospi_Evolutions from './components/Hospitalisation/Hospi_Evolutions.vue'
import Hospi_Observations from './components/Hospitalisation/Hospi_Observations.vue'
import Hospi_PoseActeInfirmier from './components/Hospitalisation/Hospi_PoseActeInfirmier.vue'
import Hospi_TypePlaie from './components/Hospitalisation/Hospi_TypePlaie.vue'
import Hospi_BilanHydrique from './components/Hospitalisation/Hospi_BilanHydrique.vue'
import Hospi_ConsultationNeo from './components/Hospitalisation/Hospi_ConsultationNeo.vue'
import Hospi_DetailActeTraitement from './components/Hospitalisation/Hospi_DetailActeTraitement.vue'
import Hospi_DetailBilanHydrique from './components/Hospitalisation/Hospi_DetailBilanHydrique.vue'
import Hospi_DetailMedicamentTraitement from './components/Hospitalisation/Hospi_DetailMedicamentTraitement.vue'
import Hospi_DetailSurveillancePlaie from './components/Hospitalisation/Hospi_DetailSurveillancePlaie.vue'
import Hospi_SurveillanceHospi from './components/Hospitalisation/Hospi_SurveillanceHospi.vue'
import Hospi_SurveillanceNeo from './components/Hospitalisation/Hospi_SurveillanceNeo.vue'
import Hospi_SurveillancePlaie from './components/Hospitalisation/Hospi_SurveillancePlaie.vue'
import Hospi_SurveillanceRea from './components/Hospitalisation/Hospi_SurveillanceRea.vue'
import Hospi_SurveilleDiabetique from './components/Hospitalisation/Hospi_SurveilleDiabetique.vue'
import Hospi_SurveilleSigneVitaux from './components/Hospitalisation/Hospi_SurveilleSigneVitaux.vue'
import Hospi_SurveilleTransfusion from './components/Hospitalisation/Hospi_SurveilleTransfusion.vue'
import Hospi_Traitement from './components/Hospitalisation/Hospi_Traitement.vue'


import HospitalisationSortie from './components/Hospitalisation/HospitalisationSortie.vue'
import ReanimationEncours from './components/Hospitalisation/ReanimationEncours.vue'
import ReanimationSortie from './components/Hospitalisation/ReanimationSortie.vue'


import EnteteConsommationOpe from './components/Chirurgie/EnteteConsommationOpe.vue'
import AffectationTypeAnesthesie from './components/Chirurgie/AffectationTypeAnesthesie.vue'
import Consentement from './components/Chirurgie/Consentement.vue'
import CosultationPreAnesthesique from './components/Chirurgie/CosultationPreAnesthesique.vue'
import DetailConsActes from './components/Chirurgie/DetailConsActes.vue'
import DetailConsommationOpe from './components/Chirurgie/DetailConsommationOpe.vue'
import DetailEvaluation from './components/Chirurgie/DetailEvaluation.vue'
import DetailSurveillanceOpe from './components/Chirurgie/DetailSurveillanceOpe.vue'
import EnteteEvaluation from './components/Chirurgie/EnteteEvaluation.vue'
import EnteteSurveillanceOpe from './components/Chirurgie/EnteteSurveillanceOpe.vue'
import Intervention from './components/Chirurgie/Intervention.vue'
import PoseActeChirurgie from './components/Chirurgie/PoseActeChirurgie.vue'
import RubriqueSurveillance from './components/Chirurgie/RubriqueSurveillance.vue'

import FeuilleFacturation from './components/Finances/FeuilleFacturation.vue'
import Entete_Consultation_Jour from './components/Consultations/Entete_Consultation_Jour.vue'
import Urgences_Jour from './components/Consultations/Urgences_Jour.vue'

import role from './components/admin/role.vue'

import Cloture_Caisse from './components/Finances/Cloture_Caisse.vue'

import Blocs from './components/Tresorerie/Blocs.vue'
import CategorieRubrique from './components/Tresorerie/CategorieRubrique.vue'
import EnteteEtatBesoin from './components/Tresorerie/EnteteEtatBesoin.vue'
import Provenance from './components/Tresorerie/Provenance.vue'
import Rubriques from './components/Tresorerie/Rubriques.vue'
import EnteteBonEngagement from './components/Tresorerie/EnteteBonEngagement.vue'

import RapportsDetailFacturePrivee from './components/Rapports/Finances/RapportsDetailFacturePrivee.vue'
import RapportsEnteteFacturePrivee from './components/Rapports/Finances/RapportsEnteteFacturePrivee.vue'
import RapportsPaiementFacturePrivee from './components/Rapports/Finances/RapportsPaiementFacturePrivee.vue'
import RapportsPaiementFactureAbonnee from './components/Rapports/Finances/RapportsPaiementFactureAbonnee.vue'
import RapportsJour_Caisse from './components/Rapports/Finances/RapportsJour_Caisse.vue'
import RapportsComptabilite from './components/Rapports/Finances/RapportsComptabilite.vue'
//RapportsComptabilite

import ImageriesExt from './components/Imageries/ImageriesExt.vue'
import ImageriesFinanceExt from './components/Imageries/ImageriesFinanceExt.vue'
import ImageriesResultatExt from './components/Imageries/ImageriesResultatExt.vue'
import EnteteAttestation from './components/Attestations/EnteteAttestation.vue'


import EnteteDialyse_jour from './components/Dialyse/EnteteDialyse_jour.vue'
import EnteteChirurgie_jour from './components/Chirurgie/EnteteChirurgie_jour.vue'
import Kinesitherapie_result_jour from './components/Consultations/Kinesitherapie_result_jour.vue'

import Typedocumentneuro from './components/Consultations/Typedocumentneuro.vue'

import IntervalScore from './components/Imageries/IntervalScore.vue'
import LibelleScore from './components/Imageries/LibelleScore.vue'
import ParametreScore from './components/Imageries/ParametreScore.vue'


import Archivages from './components/Enfants/Archivages.vue'
import CategorieVacEnfant from './components/Enfants/CategorieVacEnfant.vue'
import EnteteCPS_Resultat from './components/Enfants/EnteteCPS_Resultat.vue'
import EnteteTestCutane from './components/Enfants/EnteteTestCutane.vue'
import ModeAtteinteEnfant from './components/Enfants/ModeAtteinteEnfant.vue'
import PeriodeCPS from './components/Enfants/PeriodeCPS.vue'
import PeriodeVaccinEnfant from './components/Enfants/PeriodeVaccinEnfant.vue'
import StrategieVaccin from './components/Enfants/StrategieVaccin.vue'
import TypeTestCutane from './components/Enfants/TypeTestCutane.vue'
import VaccinEnfant from './components/Enfants/VaccinEnfant.vue'


import PeriodeCPON from './components/Meres/PeriodeCPON.vue'
import PeriodePeni from './components/Meres/PeriodePeni.vue'
import PeriodeSP from './components/Meres/PeriodeSP.vue'
import PeriodeVaccinMere from './components/Meres/PeriodeVaccinMere.vue'
import EnteteCPN_Resultat from './components/Meres/EnteteCPN_Resultat.vue'
import PeriodeCPN from './components/Meres/PeriodeCPN.vue'
import HistoriqueData from './components/Parametres/HistoriqueData.vue'

//HistoriqueData
import CategorieEchantillonSperme from './components/Laboratoire/CategorieEchantillonSperme.vue'
import NatureEchantillonSperme from './components/Laboratoire/NatureEchantillonSperme.vue'
import ExamenColore from './components/Laboratoire/ExamenColore.vue'
import GermeColore from './components/Laboratoire/GermeColore.vue'
import EntetePrelevement_Analyse from './components/Laboratoire/EntetePrelevement_Analyse.vue'
import EntetePrelevement_Finance from './components/Laboratoire/EntetePrelevement_Finance.vue'
import EntetePrelevement_Preleveur from './components/Laboratoire/EntetePrelevement_Preleveur.vue'

import EnteteAttestationFinance from './components/Attestations/EnteteAttestationFinance.vue'

import RapportsJour_Patient from './components/Rapports/Medicales/RapportsJour_Patient.vue'
import RapportsJour_Laboratoire from './components/Rapports/Medicales/RapportsJour_Laboratoire.vue'
import RapportsJour_Pharmacie from './components/Rapports/Medicales/RapportsJour_Pharmacie.vue'
import RapportsJour_Logistique from './components/Rapports/Medicales/RapportsJour_Logistique.vue'
import SortieHospitalisationFinance from './components/Hospitalisation/SortieHospitalisationFinance.vue'

import RapportsJour_StockService from './components/Rapports/Medicales/RapportsJour_StockService.vue'
import RapportsSNIS from './components/Rapports/Medicales/RapportsSNIS'

//RapportsSNIS

//RapportsJour_StockService
import CategorieProduit from './components/Logistique/CategorieProduit.vue'
import Produits from './components/Logistique/Produits.vue'

import LogEnteteEntree from './components/Logistique/LogEnteteEntree.vue'
import LogEnteteRequisition from './components/Logistique/LogEnteteRequisition.vue'
import LogEnteteSortie from './components/Logistique/LogEnteteSortie.vue'

import CategorieAgent from './components/Personnels/CategorieAgent.vue'
import CategorieRubriquePers from './components/Personnels/CategorieRubriquePers.vue'
import CategorieServicePers from './components/Personnels/CategorieServicePers.vue'
import ServicePersonnel from './components/Personnels/ServicePersonnel.vue'
import Annee from './components/Personnels/Annee.vue'
import Mois from './components/Personnels/Mois.vue'
import RaisonFamilliale from './components/Personnels/RaisonFamilliale.vue'
import RubriquePaie from './components/Personnels/RubriquePaie.vue'
import ParametreRubrique from './components/Personnels/ParametreRubrique.vue'
import FichePaie from './components/Personnels/FichePaie.vue'
import FichePaieGlobale from './components/Personnels/FichePaieGlobale.vue'
import CategorieSociete from './components/Finances/CategorieSociete.vue'
import RapportTarification from './components/Rapports/Finances/RapportTarification.vue'
import RapportsJour_Personnel from './components/Rapports/Medicales/RapportsJour_Personnel.vue'
import ListeMenu from './components/Parametres/ListeMenu.vue'
import EnteteOperationComptable from './components/Finances/EnteteOperationComptable.vue'
import ClotureComptabilite from './components/Finances/ClotureComptabilite.vue'
import EnteteCPS_Finance from './components/Enfants/EnteteCPS_Finance.vue'

//EnteteCPS_Finance.vue


Vue.use(VueRouter)

export default new VueRouter({
    mode: 'history',
    routes: [

        //start elise
        {
            path: '/admin/dashboard',
            name: 'admin',
            component: Dashoard,
        },
        {
            path: '/admin/client',
            name: 'client',
            component: Client,
        },

        {
            path: '/admin/user',
            name: 'user',
            component: User,
        },
        {
            path: '/admin/detail_client/:id',
            name: 'detail_client',
            component: detail_client,
        },
        {
            path: '/admin/affectation',
            name: 'affectation',
            component: affectation,
        },
        {
            path: '/admin/pays',
            name: 'pays',
            component: Pays,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/province',
            name: 'province',
            component: Province,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/ville',
            name: 'ville',
            component: Ville,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/commune',
            name: 'commune',
            component: Commune,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/quartier',
            name: 'quartier',
            component: Quartier,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/avenue',
            name: 'avenue',
            component: Avenue,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/Fournisseur',
            name: 'Fournisseur',
            component: Fournisseur,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/categorieclient',
            name: 'categorieclient',
            component: CategorieClient,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/malades',
            name: 'membres',
            component: Malades,
            //meta: { middleware: [isNotAdmin] }
        },



        {
            path: '/admin/categorieproduit',
            name: 'categorieproduit',
            component: CategorieProduit,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/elementproduit',
            name: 'elementproduit',
            component: Elementproduit,
            //meta: { middleware: [isNotAdmin] }
        },

        {
            path: '/admin/Produits',
            name: 'Produits',
            component: Produits,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/detail_medicament/:id',
            name: 'detail_medicament',
            component: detail_medicament,
        },
        {
            path: '/admin/entete_entree',
            name: 'entete_entree',
            component: entete_entree,
        },
        {
            path: '/admin/RapportsSNIS',
            name: 'RapportsSNIS',
            component: RapportsSNIS,
        },
        {
            path: '/admin/detail_entree/:id',
            name: 'detail_entree',
            component: detail_entree,
        },
        {
            path: '/admin/client_vente',
            name: 'client_vente',
            component: client_vente,
        },
        {
            path: '/admin/entete_vente',
            name: 'entete_vente',
            component: entete_vente,
        },
        {
            path: '/admin/detail_vente/:id',
            name: 'detail_vente',
            component: detail_vente,
        },
        {
            path: '/admin/entete_sortie',
            name: 'entete_sortie',
            component: entete_sortie,
        },
        {
            path: '/admin/detail_sortie/:id',
            name: 'detail_sortie',
            component: detail_sortie,
        },
        {
            path: '/admin/paiement_vente/:id',
            name: 'paiement_vente',
            component: paiement_vente,
        },

        {
            path: '/admin/categoriesous',
            name: 'categoriesous',
            component: CategorieSous,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/entete_sous/:id',
            name: 'entete_sous',
            component: entete_sous,
        },
        {
            path: '/admin/detail_sous/:id',
            name: 'detail_sous',
            component: detail_sous,
        },
        {
            path: '/admin/utilisateurs',
            name: 'utilisateurs',
            component: utilisateurs,
        },
        {
            path: '/admin/entreprise',
            name: 'entreprise',
            component: entreprise,
        },
        {
            path: '/admin/restaureEntrep',
            name: 'restaureEntrep',
            component: restaureEntrep,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: "/admin/entreprise_detail/:slug",
            name: "entreprise_detail_home",
            component: entrepriseDetail,
            // meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/recouvrement',
            name: 'recouvrement',
            component: recouvrement,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/compte',
            name: 'compte',
            component: compte,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/depense',
            name: 'depense',
            component: depense,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/recette',
            name: 'recette',
            component: recette,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/mouvement_malade/:id',
            name: 'mouvement_malade',
            component: mouvement_malade,
        },
        {
            path: '/admin/affectationabonne/:id',
            name: 'affectationabonne',
            component: affectationabonne,
        },
        {
            path: '/admin/organisationabonne',
            name: 'organisationabonne',
            component: organisationabonne,
        },
        {
            path: '/admin/type_mouvement_malade',
            name: 'type_mouvement_malade',
            component: type_mouvement_malade,
        },
        {
            path: '/admin/entete_triage',
            name: 'entete_triage',
            component: entete_triage,
        },
        {
            path: '/admin/detail_triage/:id',
            name: 'detail_triage',
            component: detail_triage,
        },
        {
            path: '/admin/entete_consultation',
            name: 'entete_consultation',
            component: entete_consultation,
        },
        {
            path: '/admin/Entete_Consultation_Jour',
            name: 'Entete_Consultation_Jour',
            component: Entete_Consultation_Jour,
        },
        {
            path: '/admin/detail_consultation/:id',
            name: 'detail_consultation',
            component: detail_consultation,
        },
        {
            path: '/admin/type_consultation',
            name: 'type_consultation',
            component: type_consultation,
        },
        {
            path: '/admin/categorie_examen',
            name: 'categorie_examen',
            component: categorie_examen,
        },
        {
            path: '/admin/grand_categorie_examen',
            name: 'grand_categorie_examen',
            component: grand_categorie_examen,
        },
        {
            path: '/admin/examen',
            name: 'examen',
            component: examen,
        },
        {
            path: '/admin/valeur_normale',
            name: 'valeur_normale',
            component: valeur_normale,
        },
        {
            path: '/admin/entete_labo/:id',
            name: 'entete_labo',
            component: entete_labo,
        },
        { //DetailConsultation_Labo_Fin
            path: '/admin/Laboratoire_Finance/:id',
            name: 'Laboratoire_Finance',
            component: Laboratoire_Finance,
        },
        { //DetailConsultation_Labo_Fin
            path: '/admin/DetailConsultation_Labo_Fin',
            name: 'DetailConsultation_Labo_Fin',
            component: DetailConsultation_Labo_Fin,
        },
        {
            path: '/admin/entete_labo_ext/:id',
            name: 'entete_labo_ext',
            component: entete_labo_ext,
        },
        {
            path: '/admin/detail_consultation_labo',
            name: 'detail_consultation_labo',
            component: detail_consultation_labo,
        },
        {
            path: '/admin/mouvement_labo',
            name: 'mouvement_labo',
            component: mouvement_labo,
        },
        {
            path: '/admin/entete_labo_resultat/:id',
            name: 'entete_labo_resultat',
            component: entete_labo_resultat,
        },
        {
            path: '/admin/entete_labo_ext_resultat/:id',
            name: 'entete_labo_ext_resultat',
            component: entete_labo_ext_resultat,
        },
        {
            path: '/admin/detail_labo/:id',
            name: 'detail_labo',
            component: detail_labo,
        },
        {
            path: '/admin/detail_labo_ext/:id',
            name: 'detail_labo_ext',
            component: detail_labo_ext,
        },
        {
            path: '/admin/medecin',
            name: 'medecin',
            component: medecin,
        },
        {
            path: '/admin/fonction_medecin',
            name: 'fonction_medecin',
            component: fonction_medecin,
        },
        {
            path: '/admin/service_hopital',
            name: 'service_hopital',
            component: service_hopital,
        },
        {
            path: '/admin/categorie_medecin',
            name: 'categorie_medecin',
            component: categorie_medecin,
        },
        {
            path: '/admin/tube_examen',
            name: 'tube_examen',
            component: tube_examen,
        },
        {
            path: '/admin/rapport_labo',
            name: 'rapport_labo',
            component: rapport_labo,
        },
        {
            path: '/admin/natureechantillon',
            name: 'natureechantillon',
            component: natureechantillon,
        },
        {
            path: '/admin/methodeexamen',
            name: 'methodeexamen',
            component: methodeexamen,
        },
        {
            path: '/admin/categorievaleur',
            name: 'categorievaleur',
            component: categorievaleur,
        },
        {
            path: '/admin/unitevaleur',
            name: 'unitevaleur',
            component: unitevaleur,
        },
        {
            path: '/admin/facturation',
            name: 'facturation',
            component: facturation,
        },
        {
            path: '/admin/modepaie',
            name: 'modepaie',
            component: modepaie,
        },
        {
            path: '/admin/typefrais',
            name: 'typefrais',
            component: typefrais,
        },
        {
            path: '/admin/typetarif',
            name: 'typetarif',
            component: typetarif,
        },
        {
            path: '/admin/entetepaie',
            name: 'entetepaie',
            component: entetepaie,
        },
        { //CreateFacture
            path: '/admin/detailpaie/:id',
            name: 'detailpaie',
            component: detailpaie,
        },
        { //
            path: '/admin/CreateFacture',
            name: 'CreateFacture',
            component: CreateFacture,
        },
        {
            path: '/admin/agenda_medecin',
            name: 'agenda_medecin',
            component: agenda_medecin,
        },
        {
            path: '/admin/agenda_reception',
            name: 'agenda_reception',
            component: agenda_reception,
        },
        {
            path: '/admin/roles',
            name: 'roles',
            component: roles,
        },
        {
            path: '/admin/dashstatistique',
            name: 'dashstatistique',
            component: dashstatistique,
        },
        {
            path: '/admin/CategorieMaladie',
            name: 'CategorieMaladie',
            component: CategorieMaladie,
        },
        {
            path: '/admin/Maladie',
            name: 'Maladie',
            component: Maladie,
        },
        {
            path: '/admin/DiagnosticDef/:id',
            name: 'DiagnosticDef',
            component: DiagnosticDef,
        },
        {
            path: '/admin/CategorieMedicament',
            name: 'CategorieMedicament',
            component: CategorieMedicament,
        },
        {
            path: '/admin/Medicament',
            name: 'Medicament',
            component: Medicament,
        },
        {
            path: '/admin/PrescriptionMedicament/:id',
            name: 'PrescriptionMedicament',
            component: PrescriptionMedicament,
        },
        {
            path: '/admin/MaladieChronique/:id',
            name: 'MaladieChronique',
            component: MaladieChronique,
        },
        {
            path: '/admin/Salle',
            name: 'Salle',
            component: Salle,
        },
        {
            path: '/admin/Lit/:id',
            name: 'Lit',
            component: Lit,
        },
        {
            path: '/admin/ServiceHopi',
            name: 'ServiceHopi',
            component: ServiceHopi,
        },
        {
            path: '/admin/ServiceSoin',
            name: 'ServiceSoin',
            component: ServiceSoin,
        },
        {
            path: '/admin/HospitalisationAll',
            name: 'HospitalisationAll',
            component: HospitalisationAll,
        },
        {
            path: '/admin/Hospitalisation/:id',
            name: 'Hospitalisation',
            component: Hospitalisation,
        },
        {
            path: '/admin/SuiviHospitalisation/:id',
            name: 'SuiviHospitalisation',
            component: SuiviHospitalisation,
        },
        {
            path: '/admin/SoinHospitalisation/:id',
            name: 'SoinHospitalisation',
            component: SoinHospitalisation,
        },
        {
            path: '/admin/TraitementHospitaliser/:id',
            name: 'TraitementHospitaliser',
            component: TraitementHospitaliser,
        },
        {
            path: '/admin/SortieHospitalisation/:id',
            name: 'SortieHospitalisation',
            component: SortieHospitalisation,
        },
        {
            path: '/admin/DetailSortieHospi/:id',
            name: 'DetailSortieHospi',
            component: DetailSortieHospi,
        },
        {
            path: '/admin/PlanSoin/:id',
            name: 'PlanSoin',
            component: PlanSoin,
        },
        {
            path: '/admin/DetailPlanSoin/:id',
            name: 'DetailPlanSoin',
            component: DetailPlanSoin,
        },
        {
            path: '/admin/EnteteChirurgie',
            name: 'EnteteChirurgie',
            component: EnteteChirurgie,
        },
        {
            path: '/admin/DetailChirurgie/:id',
            name: 'DetailChirurgie',
            component: DetailChirurgie,
        },
        {
            path: '/admin/urgences',
            name: 'urgences',
            component: Urgences,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/urgences_jour',
            name: 'urgences_jour',
            component: Urgences_Jour,
            //meta: { middleware: [isNotAdmin] }
        },
        {
            path: '/admin/PoseActeMedecin/:id',
            name: 'PoseActeMedecin',
            component: PoseActeMedecin,
        },
        {
            path: '/admin/AutresOrientations/:id',
            name: 'AutresOrientations',
            component: AutresOrientations,
        },
        {
            path: '/admin/ResumeClinique/:id',
            name: 'ResumeClinique',
            component: ResumeClinique,
        },
        {
            path: '/admin/ClassesFin',
            name: 'ClassesFin',
            component: ClassesFin,
        },
        {
            path: '/admin/CompteFin',
            name: 'CompteFin',
            component: CompteFin,
        },
        {
            path: '/admin/DepartementFin',
            name: 'DepartementFin',
            component: DepartementFin,
        },
        {
            path: '/admin/DetailFacturation/:id',
            name: 'DetailFacturation',
            component: DetailFacturation,
        },
        {
            path: '/admin/EnteteFacturation/:id',
            name: 'EnteteFacturation',
            component: EnteteFacturation,
        },
        {
            path: '/admin/PaiementFacture/:id',
            name: 'PaiementFacture',
            component: PaiementFacture,
        },
        {
            path: '/admin/ProduitFin',
            name: 'ProduitFin',
            component: ProduitFin,
        },
        {
            path: '/admin/SousCompte',
            name: 'SousCompte',
            component: SousCompte,
        },
        {
            path: '/admin/SSousCompte',
            name: 'SSousCompte',
            component: SSousCompte,
        },
        {
            path: '/admin/TypeCompte',
            name: 'TypeCompte',
            component: TypeCompte,
        },
        {
            path: '/admin/TypeOperation',
            name: 'TypeOperation',
            component: TypeOperation,
        },
        {
            path: '/admin/TypePosition',
            name: 'TypePosition',
            component: TypePosition,
        },
        {
            path: '/admin/TypeProduit',
            name: 'TypeProduit',
            component: TypeProduit,
        },
        {
            path: '/admin/UniteProduction',
            name: 'UniteProduction',
            component: UniteProduction,
        },
        {
            path: '/admin/ActeMedecin',
            name: 'ActeMedecin',
            component: ActeMedecin,
        },
        {
            path: '/admin/Consultation_Finance',
            name: 'Consultation_Finance',
            component: Consultation_Finance,
        },
        {
            path: '/admin/Mvt_malade_Labo_Finance',
            name: 'Mvt_malade_Labo_Finance',
            component: Mvt_malade_Labo_Finance,
        },
        {
            path: '/admin/EnteteLaboExt_Finance/:id',
            name: 'EnteteLaboExt_Finance',
            component: EnteteLaboExt_Finance,
        },
        {
            path: '/admin/Urgence_Finance',
            name: 'Urgence_Finance',
            component: Urgence_Finance,
        },
        {
            path: '/admin/TTaux',
            name: 'TTaux',
            component: TTaux,
        },
        {
            path: '/admin/RapportsDetailFacture',
            name: 'RapportsDetailFacture',
            component: RapportsDetailFacture,
        },
        {
            path: '/admin/RapportsEnteteFacture',
            name: 'RapportsEnteteFacture',
            component: RapportsEnteteFacture,
        },
        {
            path: '/admin/TypeAnalyse',
            name: 'TypeAnalyse',
            component: TypeAnalyse,
        },
        {
            path: '/admin/AnalyseImagerie',
            name: 'AnalyseImagerie',
            component: AnalyseImagerie,
        },
        {
            path: '/admin/Imageries/:id',
            name: 'Imageries',
            component: Imageries,
        },
        {
            path: '/admin/ImageriesResultat',
            name: 'ImageriesResultat',
            component: ImageriesResultat,
        },
        {
            path: '/admin/ImageriesFinance',
            name: 'ImageriesFinance',
            component: ImageriesFinance,
        },
        {
            path: '/admin/Cardiologie/:id',
            name: 'Cardiologie',
            component: Cardiologie,
        },
        {
            path: '/admin/Endoscopie/:id',
            name: 'Endoscopie',
            component: Endoscopie,
        },
        {
            path: '/admin/ResultatScanner/:id',
            name: 'ResultatScanner',
            component: ResultatScanner,
        },
        {
            path: '/admin/VaccinationDialyse/:id',
            name: 'VaccinationDialyse',
            component: VaccinationDialyse,
        },
        {
            path: '/admin/PoseCathetere/:id',
            name: 'PoseCathetere',
            component: PoseCathetere,
        },
        {
            path: '/admin/CategorieVaccin',
            name: 'CategorieVaccin',
            component: CategorieVaccin,
        },
        {
            path: '/admin/EnteteDialyse',
            name: 'EnteteDialyse',
            component: EnteteDialyse,
        },
        {
            path: '/admin/TypeMachine',
            name: 'TypeMachine',
            component: TypeMachine,
        },
        {
            path: '/admin/Vaccins',
            name: 'Vaccins',
            component: Vaccins,
        },
        {
            path: '/admin/SurveillanceDialyse/:id',
            name: 'SurveillanceDialyse',
            component: SurveillanceDialyse,
        },
        {
            path: '/admin/DetailSurveillanceDialyse/:id',
            name: 'DetailSurveillanceDialyse',
            component: DetailSurveillanceDialyse,
        },
        {
            path: '/admin/Ophtamologie/:id',
            name: 'Ophtamologie',
            component: Ophtamologie,
        },
        {
            path: '/admin/Kinesitherapie/:id',
            name: 'Kinesitherapie',
            component: Kinesitherapie,
        },
        {
            path: '/admin/Kinesitherapie_result',
            name: 'Kinesitherapie_result',
            component: Kinesitherapie_result,
        },
        {
            path: '/admin/Kinesitherapie_finance',
            name: 'Kinesitherapie_finance',
            component: Kinesitherapie_finance,
        },
        {
            path: '/admin/RapportMedical/:id',
            name: 'RapportMedical',
            component: RapportMedical,
        },
        {
            path: '/admin/RapportMedical_Finance',
            name: 'RapportMedical_Finance',
            component: RapportMedical_Finance,
        },
        {
            path: '/admin/RapportMedical_Secretariat',
            name: 'RapportMedical_Secretariat',
            component: RapportMedical_Secretariat,
        },
        {
            path: '/admin/EnteteReanimation',
            name: 'EnteteReanimation',
            component: EnteteReanimation,
        },
        {
            path: '/admin/Hospi_TypePlaie',
            name: 'Hospi_TypePlaie',
            component: Hospi_TypePlaie,
        },
        {
            path: '/admin/Hospi_Appreciations/:id',
            name: 'Hospi_Appreciations',
            component: Hospi_Appreciations,
        },
        {
            path: '/admin/Hospi_Evolutions/:id',
            name: 'Hospi_Evolutions',
            component: Hospi_Evolutions,
        },
        {
            path: '/admin/Hospi_Observations/:id',
            name: 'Hospi_Observations',
            component: Hospi_Observations,
        },
        {
            path: '/admin/Hospi_PoseActeInfirmier/:id',
            name: 'Hospi_PoseActeInfirmier',
            component: Hospi_PoseActeInfirmier,
        },
        {
            path: '/admin/Hospi_BilanHydrique/:id',
            name: 'Hospi_BilanHydrique',
            component: Hospi_BilanHydrique,
        },
        {
            path: '/admin/Hospi_ConsultationNeo/:id',
            name: 'Hospi_ConsultationNeo',
            component: Hospi_ConsultationNeo,
        },
        {
            path: '/admin/Hospi_DetailActeTraitement/:id',
            name: 'Hospi_DetailActeTraitement',
            component: Hospi_DetailActeTraitement,
        },
        {
            path: '/admin/Hospi_DetailBilanHydrique/:id',
            name: 'Hospi_DetailBilanHydrique',
            component: Hospi_DetailBilanHydrique,
        },
        {
            path: '/admin/Hospi_DetailMedicamentTraitement/:id',
            name: 'Hospi_DetailMedicamentTraitement',
            component: Hospi_DetailMedicamentTraitement,
        },
        {
            path: '/admin/Hospi_DetailSurveillancePlaie/:id',
            name: 'Hospi_DetailSurveillancePlaie',
            component: Hospi_DetailSurveillancePlaie,
        },
        {
            path: '/admin/Hospi_SurveillanceHospi/:id',
            name: 'Hospi_SurveillanceHospi',
            component: Hospi_SurveillanceHospi,
        },
        {
            path: '/admin/Hospi_SurveillanceNeo/:id',
            name: 'Hospi_SurveillanceNeo',
            component: Hospi_SurveillanceNeo,
        },
        {
            path: '/admin/Hospi_SurveillancePlaie/:id',
            name: 'Hospi_SurveillancePlaie',
            component: Hospi_SurveillancePlaie,
        },
        {
            path: '/admin/Hospi_SurveillanceRea/:id',
            name: 'Hospi_SurveillanceRea',
            component: Hospi_SurveillanceRea,
        },
        {
            path: '/admin/Hospi_SurveilleDiabetique/:id',
            name: 'Hospi_SurveilleDiabetique',
            component: Hospi_SurveilleDiabetique,
        },
        {
            path: '/admin/Hospi_SurveilleSigneVitaux/:id',
            name: 'Hospi_SurveilleSigneVitaux',
            component: Hospi_SurveilleSigneVitaux,
        },
        {
            path: '/admin/Hospi_SurveilleTransfusion/:id',
            name: 'Hospi_SurveilleTransfusion',
            component: Hospi_SurveilleTransfusion,
        },
        {
            path: '/admin/Hospi_Traitement/:id',
            name: 'Hospi_Traitement',
            component: Hospi_Traitement,
        }



        ,
        {
            path: '/admin/EnteteConsommationOpe/:id',
            name: 'EnteteConsommationOpe',
            component: EnteteConsommationOpe,
        },
        {
            path: '/admin/AffectationTypeAnesthesie/:id',
            name: 'AffectationTypeAnesthesie',
            component: AffectationTypeAnesthesie,
        },
        {
            path: '/admin/Consentement/:id',
            name: 'Consentement',
            component: Consentement,
        },
        {
            path: '/admin/CosultationPreAnesthesique/:id',
            name: 'CosultationPreAnesthesique',
            component: CosultationPreAnesthesique,
        },
        {
            path: '/admin/DetailConsActes/:id',
            name: 'DetailConsActes',
            component: DetailConsActes,
        },
        {
            path: '/admin/DetailConsommationOpe/:id',
            name: 'DetailConsommationOpe',
            component: DetailConsommationOpe,
        },
        {
            path: '/admin/DetailEvaluation/:id',
            name: 'DetailEvaluation',
            component: DetailEvaluation,
        },
        {
            path: '/admin/DetailSurveillanceOpe/:id',
            name: 'DetailSurveillanceOpe',
            component: DetailSurveillanceOpe,
        },
        {
            path: '/admin/EnteteEvaluation/:id',
            name: 'EnteteEvaluation',
            component: EnteteEvaluation,
        },
        {
            path: '/admin/EnteteSurveillanceOpe/:id',
            name: 'EnteteSurveillanceOpe',
            component: EnteteSurveillanceOpe,
        },
        {
            path: '/admin/Intervention',
            name: 'Intervention',
            component: Intervention,
        },
        {
            path: '/admin/PoseActeChirurgie/:id',
            name: 'PoseActeChirurgie',
            component: PoseActeChirurgie,
        },
        {
            path: '/admin/RubriqueSurveillance',
            name: 'RubriqueSurveillance',
            component: RubriqueSurveillance,
        },
        {
            path: '/admin/FeuilleFacturation/:id',
            name: 'FeuilleFacturation',
            component: FeuilleFacturation,
        },
        {
            path: '/admin/HospitalisationSortie',
            name: 'HospitalisationSortie',
            component: HospitalisationSortie,
        },
        {
            path: '/admin/ReanimationEncours',
            name: 'ReanimationEncours',
            component: ReanimationEncours,
        },
        {
            path: '/admin/ReanimationSortie',
            name: 'ReanimationSortie',
            component: ReanimationSortie,
        },
        {
            path: '/admin/RapportsDetailFactureAbonne',
            name: 'RapportsDetailFactureAbonne',
            component: RapportsDetailFactureAbonne,
        },
        {
            path: '/admin/RapportsEnteteFactureAbonne',
            name: 'RapportsEnteteFactureAbonne',
            component: RapportsEnteteFactureAbonne,
        },
        {
            path: '/admin/role',
            name: 'role',
            component: role,
        },
        {
            path: '/admin/RechercheFacture',
            name: 'RechercheFacture',
            component: RechercheFacture,
        },
        {
            path: '/admin/RechercheRecu',
            name: 'RechercheRecu',
            component: RechercheRecu,
        },
        {
            path: '/admin/Banque',
            name: 'Banque',
            component: Banque,
        },
        {
            path: '/admin/RapportsPaiementFacture',
            name: 'RapportsPaiementFacture',
            component: RapportsPaiementFacture,
        },
        {
            path: '/admin/Cloture_Caisse',
            name: 'Cloture_Caisse',
            component: Cloture_Caisse,
        },
        {
            path: '/admin/CategorieRubrique',
            name: 'CategorieRubrique',
            component: CategorieRubrique,
        },
        {
            path: '/admin/EnteteEtatBesoin',
            name: 'EnteteEtatBesoin',
            component: EnteteEtatBesoin,
        },
        {
            path: '/admin/Provenance',
            name: 'Provenance',
            component: Provenance,
        },
        {
            path: '/admin/Rubriques',
            name: 'Rubriques',
            component: Rubriques,
        },
        {
            path: '/admin/EnteteBonEngagement',
            name: 'EnteteBonEngagement',
            component: EnteteBonEngagement,
        },
        {
            path: '/admin/Blocs',
            name: 'Blocs',
            component: Blocs,
        },
        {
            path: '/admin/RapportsDetailFacturePrivee',
            name: 'RapportsDetailFacturePrivee',
            component: RapportsDetailFacturePrivee,
        },
        {
            path: '/admin/RapportsEnteteFacturePrivee',
            name: 'RapportsEnteteFacturePrivee',
            component: RapportsEnteteFacturePrivee,
        },
        {
            path: '/admin/RapportsPaiementFacturePrivee',
            name: 'RapportsPaiementFacturePrivee',
            component: RapportsPaiementFacturePrivee,
        },
        {
            path: '/admin/RapportsPaiementFactureAbonnee',
            name: 'RapportsPaiementFactureAbonnee',
            component: RapportsPaiementFactureAbonnee,
        },
        {
            path: '/admin/RapportsJour_Caisse',
            name: 'RapportsJour_Caisse',
            component: RapportsJour_Caisse,
        },
        {
            path: '/admin/ImageriesExt',
            name: 'ImageriesExt',
            component: ImageriesExt,
        },
        {
            path: '/admin/ImageriesFinanceExt',
            name: 'ImageriesFinanceExt',
            component: ImageriesFinanceExt,
        },
        {
            path: '/admin/ImageriesResultatExt',
            name: 'ImageriesResultatExt',
            component: ImageriesResultatExt,
        },
        {
            path: '/admin/EnteteAttestation',
            name: 'EnteteAttestation',
            component: EnteteAttestation,
        },
        {
            path: '/admin/EnteteDialyse_jour',
            name: 'EnteteDialyse_jour',
            component: EnteteDialyse_jour,
        },
        {
            path: '/admin/EnteteChirurgie_jour',
            name: 'EnteteChirurgie_jour',
            component: EnteteChirurgie_jour,
        },
        {
            path: '/admin/Kinesitherapie_result_jour',
            name: 'Kinesitherapie_result_jour',
            component: Kinesitherapie_result_jour,
        },
        {
            path: '/admin/Typedocumentneuro',
            name: 'Typedocumentneuro',
            component: Typedocumentneuro,
        },
        {
            path: '/admin/IntervalScore',
            name: 'IntervalScore',
            component: IntervalScore,
        },
        {
            path: '/admin/LibelleScore',
            name: 'LibelleScore',
            component: LibelleScore,
        },
        {
            path: '/admin/ParametreScore',
            name: 'ParametreScore',
            component: ParametreScore,
        },
        {
            path: '/admin/VaccinEnfant',
            name: 'VaccinEnfant',
            component: VaccinEnfant,
        },
        {
            path: '/admin/TypeTestCutane',
            name: 'TypeTestCutane',
            component: TypeTestCutane,
        },
        {
            path: '/admin/StrategieVaccin',
            name: 'StrategieVaccin',
            component: StrategieVaccin,
        },
        {
            path: '/admin/PeriodeVaccinEnfant',
            name: 'PeriodeVaccinEnfant',
            component: PeriodeVaccinEnfant,
        },
        {
            path: '/admin/PeriodeCPS',
            name: 'PeriodeCPS',
            component: PeriodeCPS,
        },
        {
            path: '/admin/ModeAtteinteEnfant',
            name: 'ModeAtteinteEnfant',
            component: ModeAtteinteEnfant,
        },
        {
            path: '/admin/EnteteTestCutane',
            name: 'EnteteTestCutane',
            component: EnteteTestCutane,
        },
        {
            path: '/admin/EnteteCPS_Resultat',
            name: 'EnteteCPS_Resultat',
            component: EnteteCPS_Resultat,
        },
        {
            path: '/admin/CategorieVacEnfant',
            name: 'CategorieVacEnfant',
            component: CategorieVacEnfant,
        },
        {
            path: '/admin/Archivages',
            name: 'Archivages',
            component: Archivages,
        },
        {
            path: '/admin/PeriodeCPON',
            name: 'PeriodeCPON',
            component: PeriodeCPON,
        },
        {
            path: '/admin/PeriodePeni',
            name: 'PeriodePeni',
            component: PeriodePeni,
        },
        {
            path: '/admin/PeriodeSP',
            name: 'PeriodeSP',
            component: PeriodeSP,
        },
        {
            path: '/admin/PeriodeVaccinMere',
            name: 'PeriodeVaccinMere',
            component: PeriodeVaccinMere,
        },
        {
            path: '/admin/EnteteCPN_Resultat',
            name: 'EnteteCPN_Resultat',
            component: EnteteCPN_Resultat,
        },
        {
            path: '/admin/PeriodeCPN',
            name: 'PeriodeCPN',
            component: PeriodeCPN,
        },
        {
            path: '/admin/RapportsJour_Patient',
            name: 'RapportsJour_Patient',
            component: RapportsJour_Patient,
        },
        {
            path: '/admin/EnteteAttestationFinance',
            name: 'EnteteAttestationFinance',
            component: EnteteAttestationFinance,
        },
        {
            path: '/admin/SortieHospitalisationFinance',
            name: 'SortieHospitalisationFinance',
            component: SortieHospitalisationFinance,
        },
        {
            //
            path: '/admin/CategorieEchantillonSperme',
            name: 'CategorieEchantillonSperme',
            component: CategorieEchantillonSperme,
        },
        {
            path: '/admin/NatureEchantillonSperme',
            name: 'NatureEchantillonSperme',
            component: NatureEchantillonSperme,
        },
        {
            path: '/admin/ExamenColore',
            name: 'ExamenColore',
            component: ExamenColore,
        },
        {
            path: '/admin/GermeColore',
            name: 'GermeColore',
            component: GermeColore,
        },
        {
            path: '/admin/EntetePrelevement_Analyse',
            name: 'EntetePrelevement_Analyse',
            component: EntetePrelevement_Analyse,
        },
        {
            path: '/admin/EntetePrelevement_Finance',
            name: 'EntetePrelevement_Finance',
            component: EntetePrelevement_Finance,
        },
        {
            path: '/admin/EntetePrelevement_Preleveur',
            name: 'EntetePrelevement_Preleveur',
            component: EntetePrelevement_Preleveur,
        },
        {
            path: '/admin/RapportsJour_Laboratoire',
            name: 'RapportsJour_Laboratoire',
            component: RapportsJour_Laboratoire,
        },
        {
            path: '/admin/RapportsJour_Pharmacie',
            name: 'RapportsJour_Pharmacie',
            component: RapportsJour_Pharmacie,
        },
        {
            path: '/admin/RapportsJour_StockService',
            name: 'RapportsJour_StockService',
            component: RapportsJour_StockService,
        },
        { //RapportsJour_StockService
            path: '/admin/LogEnteteEntree',
            name: 'LogEnteteEntree',
            component: LogEnteteEntree,
        },
        { //EnteteBesoinAll
            path: '/admin/EnteteBesoinAll',
            name: 'EnteteBesoinAll',
            component: EnteteBesoinAll,
        },
        {
            path: '/admin/LogEnteteRequisition',
            name: 'LogEnteteRequisition',
            component: LogEnteteRequisition,
        },
        {
            path: '/admin/LogEnteteSortie',
            name: 'LogEnteteSortie',
            component: LogEnteteSortie,
        },
        {
            path: '/admin/CategorieAgent',
            name: 'CategorieAgent',
            component: CategorieAgent,
        },
        {
            path: '/admin/CategorieRubriquePers',
            name: 'CategorieRubriquePers',
            component: CategorieRubriquePers,
        },
        {
            path: '/admin/CategorieServicePers',
            name: 'CategorieServicePers',
            component: CategorieServicePers,
        },
        {
            path: '/admin/ServicePersonnel',
            name: 'ServicePersonnel',
            component: ServicePersonnel,
        },
        {
            path: '/admin/RapportsJour_Logistique',
            name: 'RapportsJour_Logistique',
            component: RapportsJour_Logistique,
        },
        {
            path: '/admin/Annee',
            name: 'Annee',
            component: Annee,
        },
        {
            path: '/admin/Mois',
            name: 'Mois',
            component: Mois,
        },
        {
            path: '/admin/RaisonFamilliale',
            name: 'RaisonFamilliale',
            component: RaisonFamilliale,
        },
        {
            path: '/admin/RubriquePaie',
            name: 'RubriquePaie',
            component: RubriquePaie,
        },
        {
            path: '/admin/ParametreRubrique',
            name: 'ParametreRubrique',
            component: ParametreRubrique,
        },
        {
            path: '/admin/FichePaie',
            name: 'FichePaie',
            component: FichePaie,
        },
        {
            path: '/admin/FichePaieGlobale',
            name: 'FichePaieGlobale',
            component: FichePaieGlobale,
        },
        {
            path: '/admin/CategorieSociete',
            name: 'CategorieSociete',
            component: CategorieSociete,
        },
        {
            path: '/admin/RapportTarification',
            name: 'RapportTarification',
            component: RapportTarification,
        },
        {
            path: '/admin/ListeMenu',
            name: 'ListeMenu',
            component: ListeMenu,
        },
        {
            path: '/admin/RapportsJour_Personnel',
            name: 'RapportsJour_Personnel',
            component: RapportsJour_Personnel,
        },
        {
            path: '/admin/EnteteOperationComptable',
            name: 'EnteteOperationComptable',
            component: EnteteOperationComptable,
        },
        {
            path: '/admin/ClotureComptabilite',
            name: 'ClotureComptabilite',
            component: ClotureComptabilite,
        },
        {
            path: '/admin/RapportsComptabilite',
            name: 'RapportsComptabilite',
            component: RapportsComptabilite,
        },
        {
            path: '/admin/EnteteCPS_Finance',
            name: 'EnteteCPS_Finance',
            component: EnteteCPS_Finance,
        },
        {
            path: '/admin/HistoriqueData',
            name: 'HistoriqueData',
            component: HistoriqueData,
        },
        {
            path: '/admin/Tabilation',
            name: 'Tabilation',
            component: Tabilation,
        }
    ],
});

//Tabilation   Mois  RaisonFamilliale
