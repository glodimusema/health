<template>
  <v-layout>
    <FeuilleFacturation ref="FeuilleFacturation" />
    <Imageries ref="Imageries" />
    <EnteteLabo ref="EnteteLabo" />

    <EnteteBesoin ref="EnteteBesoin" />
    <EnteteUsage ref="EnteteUsage" />

    <PoseCathetere ref="PoseCathetere" />
    <SurveillanceDialyse ref="SurveillanceDialyse" />
    <VaccinationDialyse ref="VaccinationDialyse" />

    <AutresOrientations ref="AutresOrientations" />

    <DeroulementDialyse ref="DeroulementDialyse" />
    <RapportMedicalDialyse ref="RapportMedicalDialyse" />
    <PrescriptionMedicament ref="PrescriptionMedicament" />

    <EntetePrelevement ref="EntetePrelevement" />

    <v-dialog v-model="dialog2" max-width="500px" hide-overlay transition="dialog-bottom-transition">
      <v-card :loading="loading">
        <v-form ref="form" lazy-validation>
          <v-card-title>
            Envoyer au Laboratoire pour les Analyses <v-spacer></v-spacer>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="dialog2 = false" text fab depressed>
                    <v-icon>close</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Fermer</span>
            </v-tooltip>
          </v-card-title>
          <v-card-text max-height="400px" background-color: white>
            <v-layout row wrap>


              <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                    item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refService" chips
                    clearable>
                  </v-autocomplete>
                </div>
              </v-flex>

            </v-layout>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
            <v-btn color="#B72C2C" dark :loading="loading" @click="validate_preleve">
              {{ edit ? "Modifier" : "Ajouter" }}
            </v-btn>
          </v-card-actions>
        </v-form>
      </v-card>
    </v-dialog>

    <v-flex md12>
      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/EnteteDialyse'">Dialyse/Dialyse</router-link>
          </div>
        </v-flex>
      </v-layout>
      <br /><br />
      <v-layout>
        <!--   -->
        <v-flex md12>
          <v-layout>
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
            </v-flex>
            <v-flex md5>
              <div>
                <!-- {{ this.don }} -->
              </div>
            </v-flex>
            <v-flex md1>
              <!-- <v-tooltip bottom color="black">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                        <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                          <v-icon>add</v-icon>
                        </v-btn>
                      </span>
                    </template>
                    <span>Ajouter une affectation</span>
                  </v-tooltip> -->
            </v-flex>
          </v-layout>
          <br />
          <v-card>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">DateDemande</th>
                      <th class="text-left">DateMouvement</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">Statut</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.dateDemande | formatDate }}</td>
                      <td>{{ item.dateMouvement | formatDate }}</td>
                      <td>{{ item.categoriemaladiemvt }}</td>
                      <td>
                        <v-badge bordered color="error" icon="person" overlap>
                          <v-btn elevation="2" x-small class="white--text"
                            :color="item.Statut == 'Encours' ? 'success' : 'error'" depressed>
                            {{ item.Statut }}
                          </v-btn>
                        </v-badge>

                      </td>
                      <td>{{ item.auther }}</td>
                      <td>
                        <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="deleteData(item.id)" fab small>
                                <v-icon color="#B72C2C">delete</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Suppression</span>
                        </v-tooltip>


                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-divider></v-divider>
                            <v-subheader>Dossier Medical</v-subheader>
                            <v-divider></v-divider>

                            <v-list-item link @click="showRapportMedicaleDialyse(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Rapport Medical en Dialyse
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showEnteteBesoin(item.refMouvement, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Faire un Etat de Besoin pour ce Patient
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showEnteteUsage(item.refMouvement, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Fiche de sortie des Produits
                                </v-list-item-title>
                              </v-list-item>


                            <v-divider></v-divider>
                            <v-subheader>Traitement</v-subheader>
                            <v-divider></v-divider>


                            <v-list-item link @click="showPoseCathetere(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Pose Catheter
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showDeroulementDialyse(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Deroulement de la dernière séance
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showSurveillanceDialyse(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Feuille de Surveillance 4000
                              </v-list-item-title>
                            </v-list-item>


                            <v-list-item link @click="showVaccinationDialyse(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Feuille de Vaccination
                              </v-list-item-title>
                            </v-list-item>
                            <!-- refEnteteCons -->

                            <v-list-item link @click="showAutresOrientations(item.refDetailConst, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Autres Orientations
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showPrescriptionMedicament(item.refDetailConst, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Prescription Medicaments
                              </v-list-item-title>
                            </v-list-item>
                            <!--  -->
                            <v-list-item link @click="showCreatePrelevement(item.refDetailConst, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showEntetePrelevement(item.refDetailConst, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail sur les Examens du laboratoire
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showImagerie(item.refDetailConst, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Demander Analyses Imagerie
                              </v-list-item-title>
                            </v-list-item>




                            <v-divider></v-divider>
                            <v-subheader>Feuille de facturation</v-subheader>
                            <v-divider></v-divider>


                            <v-list-item link @click="showEnteteFacturation(item.refMouvement, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-cards</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Feuille de Facturations
                                Facture
                              </v-list-item-title>
                            </v-list-item>
                          </v-list>
                        </v-menu>

                      </td>
                    </tr>
                  </tbody>
                </template>
              </v-simple-table>
              <hr />

              <v-pagination color="#B72C2C" v-model="pagination.current" :length="pagination.total"
                @input="fetchDataList"></v-pagination>
            </v-card-text>
          </v-card>
        </v-flex>

      </v-layout>
    </v-flex>

  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import Imageries from '../Imageries/Imageries.vue';
import EnteteLabo from '../Laboratoire/EnteteLabo.vue';
import PoseCathetere from './PoseCathetere.vue';
import SurveillanceDialyse from './SurveillanceDialyse.vue';
import VaccinationDialyse from './VaccinationDialyse.vue';
import AutresOrientations from '../Consultations/AutresOrientations.vue';

import DeroulementDialyse from './DeroulementDialyse.vue';
import RapportMedicalDialyse from './RapportMedicalDialyse.vue';
import PrescriptionMedicament from '../Consultations/PrescriptionMedicament.vue';

import EnteteBesoin from "../Pharmacies/EnteteBesoin.vue";
import EnteteUsage from "../Pharmacies/EnteteUsage.vue";

import EntetePrelevement from "../Laboratoire/EntetePrelevement.vue";

export default {
  components: {
    FeuilleFacturation,
    Imageries,
    EnteteLabo,

    PoseCathetere,
    SurveillanceDialyse,
    VaccinationDialyse,
    AutresOrientations,
    DeroulementDialyse,
    RapportMedicalDialyse,
    PrescriptionMedicament,

    EntetePrelevement,

    EnteteBesoin,
    EnteteUsage
  },
  data() {
    return {

      title: "Liste des Triages",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      serviceProvenance:"",
      svData: {
        id: '',
        dateDemande: "",
        refDetailConst: "",
        auther: "",
//

        refDetailCons: "",
        refService:0,
        numroRecu:"",        
        noms:"",
        author:""
      },
      fetchData: [],
      don: [],
      stataData: {          
          ServiceList: []
        },
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    this.fetchDataList();
    this.fetchListServices();
     
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {
    ...mapActions(["getCategory"]),
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_EnteteDyalise/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
      fetchAccess() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_crud_access_roles_one/${this.userData.id_role}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
          this.inserer = item.insert;
          this.modifier = item.update;
          this.supprimer = item.delete;
          this.chargement = item.load;
        });

          console.log(donnees);
        }
      );
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_EnteteDyalise?page=`);
    },
    showPrescriptionMedicament(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.PrescriptionMedicament.$data.etatModal = true;
        this.$refs.PrescriptionMedicament.$data.refdetailCons = refDetailCons;
        this.$refs.PrescriptionMedicament.$data.svData.refdetailCons = refDetailCons;
        this.$refs.PrescriptionMedicament.fetchDataList();
        this.$refs.PrescriptionMedicament.fetchListSelection();
        this.fetchDataList();

        this.$refs.PrescriptionMedicament.$data.titleComponent =
          "Préscription Medicale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showEnteteFacturation(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.FeuilleFacturation.$data.etatModal = true;
        this.$refs.FeuilleFacturation.$data.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.$data.svData.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.fetchDataList();
        this.$refs.FeuilleFacturation.fetchListDepartement();
        this.$refs.FeuilleFacturation.fetchListmedecin();
        this.fetchDataList();

        this.$refs.FeuilleFacturation.$data.titleComponent =
          "Création de la Feuille de Facturation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    // PARTIE DES COMPOSANTS===================================================================   


    showImagerie(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Imageries.$data.etatModal = true;
        this.$refs.Imageries.$data.refDetailConst = refDetailCons;
        this.$refs.Imageries.$data.svData.refDetailConst = refDetailCons;
        this.$refs.Imageries.fetchDataList();
        this.$refs.Imageries.fetchListTypeAnalyse();
        this.$refs.Imageries.fetchListSelection();
        this.$refs.Imageries.fetchListServices();
        this.fetchDataList();

        this.$refs.Imageries.$data.titleComponent =
          "Demander les analyses d'Imagerie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPoseCathetere(refEnteteDyalise, name) {

      if (refEnteteDyalise != '') {

        this.$refs.PoseCathetere.$data.etatModal = true;
        this.$refs.PoseCathetere.$data.refEnteteDyalise = refEnteteDyalise;
        this.$refs.PoseCathetere.$data.svData.refEnteteDyalise = refEnteteDyalise;
        this.$refs.PoseCathetere.fetchDataList();
        this.$refs.PoseCathetere.fecchListMachine();
        this.$refs.PoseCathetere.fetchListmedecin();
        this.fetchDataList();

        this.$refs.PoseCathetere.$data.titleComponent =
          "Pose Cathetere pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showSurveillanceDialyse(refEnteteDyalise, name) {

      if (refEnteteDyalise != '') {

        this.$refs.SurveillanceDialyse.$data.etatModal = true;
        this.$refs.SurveillanceDialyse.$data.refEnteteDyalise = refEnteteDyalise;
        this.$refs.SurveillanceDialyse.$data.svData.refEnteteDyalise = refEnteteDyalise;
        this.$refs.SurveillanceDialyse.fetchDataList();
        this.$refs.SurveillanceDialyse.fecchListMachine();
        this.$refs.SurveillanceDialyse.fetchListmedecin();
        this.fetchDataList();

        this.$refs.SurveillanceDialyse.$data.titleComponent =
          "Surveillance Dialyse pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showVaccinationDialyse(refEnteteDyalise, name) {

      if (refEnteteDyalise != '') {

        this.$refs.VaccinationDialyse.$data.etatModal = true;
        this.$refs.VaccinationDialyse.$data.refEnteteDyalise = refEnteteDyalise;
        this.$refs.VaccinationDialyse.$data.svData.refEnteteDyalise = refEnteteDyalise;
        this.$refs.VaccinationDialyse.fetchDataList();
        this.$refs.VaccinationDialyse.fecchListMachine();
        this.$refs.VaccinationDialyse.fecchListCategorieVaccin();
        this.fetchDataList();

        this.$refs.VaccinationDialyse.$data.titleComponent =
          "Vaccination en Dialyse pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showAutresOrientations(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.AutresOrientations.$data.etatModal = true;
        this.$refs.AutresOrientations.$data.refDetailCons = refDetailCons;
        this.$refs.AutresOrientations.$data.svData.refDetailCons = refDetailCons;
        this.$refs.AutresOrientations.fetchDataList();
        // this.$refs.AutresOrientations.fetchListSelection();
        this.fetchDataList();

        this.$refs.AutresOrientations.$data.titleComponent =
          "Autres Orientations pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRapportMedicaleDialyse(refEnteteDyalise, name) {

      if (refEnteteDyalise != '') {

        this.$refs.RapportMedicalDialyse.$data.etatModal = true;
        this.$refs.RapportMedicalDialyse.$data.refEnteteDyalise = refEnteteDyalise;
        this.$refs.RapportMedicalDialyse.$data.svData.refEnteteDyalise = refEnteteDyalise;
        this.$refs.RapportMedicalDialyse.fetchDataList();
        this.$refs.RapportMedicalDialyse.fetchListSelection();
        this.fetchDataList();

        this.$refs.RapportMedicalDialyse.$data.titleComponent =
          "Rapport Medical en Dialyse pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showDeroulementDialyse(refEnteteDyalise, name) {

      if (refEnteteDyalise != '') {

        this.$refs.DeroulementDialyse.$data.etatModal = true;
        this.$refs.DeroulementDialyse.$data.refEnteteDyalise = refEnteteDyalise;
        this.$refs.DeroulementDialyse.$data.svData.refEnteteDyalise = refEnteteDyalise;
        this.$refs.DeroulementDialyse.fetchDataList();
        this.$refs.DeroulementDialyse.fetchListSelection();
        this.fetchDataList();

        this.$refs.DeroulementDialyse.$data.titleComponent =
          "Deroulement de la dernière séance pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },        
    showCreatePrelevement(id,noms)
    {
      this.dialog2=true;
      this.svData.id=id;
      this.svData.noms=noms;
      this.svData.author=this.userData.name;
    },
    showEntetePrelevement(refDetailCons, name) {

        if (refDetailCons != '') {

          this.$refs.EntetePrelevement.$data.etatModal = true;
          this.$refs.EntetePrelevement.$data.refDetailCons = refDetailCons;
          this.$refs.EntetePrelevement.$data.svData.refDetailCons = refDetailCons;
          this.$refs.EntetePrelevement.fetchDataList();
          this.$refs.EntetePrelevement.fetchListSelection();
          this.$refs.EntetePrelevement.fetchListSelection1();
          this.fetchDataList();
          
          this.$refs.EntetePrelevement.$data.titleComponent =
            "Les Prélevements pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    validate_preleve() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
            this.svData.author=this.userData.name;
            
            //serviceProvenance
            this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_prelevement_Cons?id=${this.svData.id}&author=${this.svData.author}&refService=${this.svData.refService}`).then(
            ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {
                this.svData.refEntetePrelevement = item.id;
                this.serviceProvenance = item.nom_uniteproduction;
                });
                this.showLaboratoire(this.svData.refEntetePrelevement, this.svData.noms,this.serviceProvenance);
                this.dialog2=false;
                this.isLoading(false);
            }
            ); 
            
        }
    },
// fetchListServices
     showLaboratoire(refEntetePrelevement, name,serviceProvenance) {

      if (refEntetePrelevement != '') {

        this.$refs.EnteteLabo.$data.etatModal = true;
        this.$refs.EnteteLabo.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo.$data.serviceProvenance = serviceProvenance;
        this.$refs.EnteteLabo.fetchDataList();
        this.$refs.EnteteLabo.get_examen_all();
        this.$refs.EnteteLabo.fetchListServices();
        this.fetchDataList();
        
        this.$refs.EnteteLabo.$data.titleComponent =
          "Demander les Examens de Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteBesoin(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteBesoin.$data.etatModal = true;
        this.$refs.EnteteBesoin.$data.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.fetchDataList();
        this.$refs.EnteteBesoin.fetchListService();
        this.$refs.EnteteBesoin.fetchListSalle();
        this.fetchDataList();
 
        this.$refs.EnteteBesoin.$data.titleComponent =
          "Fiche d'Etat de Besoin pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteUsage(refMouvement, name) {

      if (refMouvement != '') {
        this.$refs.EnteteUsage.$data.etatModal = true;
        this.$refs.EnteteUsage.$data.refMouvement = refMouvement;
        this.$refs.EnteteUsage.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteUsage.fetchDataList();
        this.$refs.EnteteUsage.fetchListService();
        this.$refs.EnteteUsage.fetchListSalle();

        this.$refs.EnteteUsage.$data.titleComponent =
          "Fiche d'Utilisation pour " + name;

      } 
      else {
        this.showError("Personne n'a fait cette action");
      }

    } 






  },
  filters: {

  }
}
</script>
  
  