<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <FeuilleFacturation ref="FeuilleFacturation" />
        <Imageries ref="Imageries" />
        <EnteteLabo ref="EnteteLabo" />

        <CosultationPreAnesthesique ref="CosultationPreAnesthesique" />
        <Consentement ref="Consentement" />
        <EnteteConsommationOpe ref="EnteteConsommationOpe" />
        <EnteteEvaluation ref="EnteteEvaluation" />
        <DetailOperation ref="DetailOperation" />
        <PoseActeMedecin ref="PoseActeMedecin" />
        <ConsPresAnesthesique ref="ConsPresAnesthesique" />

        <EnteteBesoin ref="EnteteBesoin" />
        <EnteteUsage ref="EnteteUsage" />
        <ResumeClinique ref="ResumeClinique" />

        <!-- ResumeClinique -->

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

        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Entete Chirurgie <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip>
              </v-card-title>
              <v-card-text>

                <!-- <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Maladie" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.MaladieList" item-text="nom_maladie"
                            item-value="id" dense outlined v-model="svData.dateeneteop" chips clearable
                            @change="getCategorie(svData.dateeneteop)">
                            </v-autocomplete>
                        </div>
                    </v-flex>
                    <v-text-field readonly label="Catégorie" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      v-model="svData.nom_categoriemaladie"></v-text-field> -->

              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>

        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'/admin/EnteteChirurgie'">Bloc Operatoire/Chirurgie</router-link>
            </div>
          </v-flex>
        </v-layout>

        <br /><br />
        <v-layout>

          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                  outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                  <span>Ajouter Diagnostics</span>
                </v-tooltip> -->
              </v-flex>
            </v-layout>
            <br />
            <v-card>
              <!-- ,'ValeurNormale2','observation2' -->
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Action</th>
                        <th class="text-left">Malade</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">DateTranfert</th>
                        <th class="text-left">Medecin</th>

                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>


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

                              <v-list-item link @click="showDetailOperation(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Details Chirurgie
                                </v-list-item-title>
                              </v-list-item>

                              <!-- CosultationPreAnesthesique -->

                              <v-list-item link @click="showConsultationPreAnesthesique(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Consultation Pré-Anesthesique
                                </v-list-item-title>
                              </v-list-item>

                              <!-- <v-list-item link @click="showConsPresAnesthesique(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Consultation Pré-Anesthesique
                                </v-list-item-title>
                              </v-list-item> -->

                              <v-list-item link @click="showConsentement(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Fiche de Consentement
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

                              <!-- <v-list-item link @click="showEnteteConsommationOpe(item.id,item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Consommations pendant la Chirurgie
                                </v-list-item-title>
                              </v-list-item> -->

                              <v-list-item link @click="showEnteteEvaluation(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Evaluation de la Chirurgie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showPoseActeMedecin(item.refDetailCons, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Actes Médicals
                                </v-list-item-title>
                              </v-list-item>


                              <v-list-item link @click="showCreatePrelevement(item.refDetailCons, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showEntetePrelevement(item.refDetailCons, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail sur les Examens du laboratoire
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showImagerie(item.refDetailCons, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Demander Analyses Imagerie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showResumeClinique(item.refDetailCons,item.noms)">
                                  <v-list-item-icon>
                                      <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Evolution medicale
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


                              <v-divider></v-divider>
                              <v-subheader>Autres Actions</v-subheader>
                              <v-divider></v-divider>


                              <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                              </v-list-item>

                              <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                              </v-list-item>
                            </v-list>
                          </v-menu>

                        </td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.dateeneteop }}</td>
                        <td>{{ item.author }}</td>

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

  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import Imageries from '../Imageries/Imageries.vue';
import EnteteLabo from '../Laboratoire/EnteteLabo.vue';


import Consentement from './Consentement.vue';
import CosultationPreAnesthesique from './CosultationPreAnesthesique.vue';
import EnteteConsommationOpe from './EnteteConsommationOpe.vue';
import EnteteEvaluation from './EnteteEvaluation.vue';
import DetailOperation from './DetailOperation.vue';
import PoseActeMedecin from '../Consultations/PoseActeMedecin.vue';
import ConsPresAnesthesique from './ConsPresAnesthesique.vue';
import EntetePrelevement from '../Laboratoire/EntetePrelevement.vue';

import EnteteBesoin from "../Pharmacies/EnteteBesoin.vue";
import EnteteUsage from "../Pharmacies/EnteteUsage.vue";
import ResumeClinique from "../Consultations/ResumeClinique.vue";



export default {
  components: {
    FeuilleFacturation,
    Imageries,
    EnteteLabo,
    ResumeClinique,

    CosultationPreAnesthesique,
    Consentement,
    EnteteConsommationOpe,
    EnteteEvaluation,
    DetailOperation,
    PoseActeMedecin,
    ConsPresAnesthesique,
    EntetePrelevement,
    EnteteBesoin,
    EnteteUsage
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      dialog2: false,
      serviceProvenance: "",
      svData: {
        id: '',
        refDetailCons: this.$route.params.id,
        dateeneteop: "",
        author: "",

        nom_categoriemaladie: "",

        refService: 0,
        numroRecu: "",
        noms: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        ServiceList: []
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: '',

    }
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();
    this.fetchListServices();

  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.refDetailCons = this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_enteteoperation/${this.svData.id}`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });

        }
        else {
          this.svData.refDetailCons = this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_enteteoperation`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }

      }
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteoperation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.dateeneteop = item.dateeneteop;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteoperation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refDetailCons = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_enteteoperation?page=`);

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
    showResumeClinique(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.ResumeClinique.$data.etatModal = true;
        this.$refs.ResumeClinique.$data.refDetailCons = refDetailCons;
        this.$refs.ResumeClinique.$data.svData.refDetailCons = refDetailCons;
        this.$refs.ResumeClinique.fetchDataList();
        this.fetchDataList();

        this.$refs.ResumeClinique.$data.titleComponent =
          "Evolution Medicale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showDetailOperation(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.DetailOperation.$data.etatModal = true;
        this.$refs.DetailOperation.$data.refEnteteOpe = refEnteteOpe;
        this.$refs.DetailOperation.$data.svData.refEnteteOpe = refEnteteOpe;
        this.$refs.DetailOperation.fetchDataList();
        this.$refs.DetailOperation.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailOperation.$data.titleComponent =
          "Detail Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showConsultationPreAnesthesique(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.CosultationPreAnesthesique.$data.etatModal = true;
        this.$refs.CosultationPreAnesthesique.$data.refEnteteOpe = refEnteteOpe;
        this.$refs.CosultationPreAnesthesique.$data.svData.refEnteteOpe = refEnteteOpe;
        this.$refs.CosultationPreAnesthesique.fetchDataList();
        this.$refs.CosultationPreAnesthesique.fetchListmedecin();
        this.$refs.CosultationPreAnesthesique.fetchListServices();
        this.fetchDataList();

        this.$refs.CosultationPreAnesthesique.$data.titleComponent =
          "Consultation Pre-anesthesique pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showConsentement(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.Consentement.$data.etatModal = true;
        this.$refs.Consentement.$data.refEnteteOpe = refEnteteOpe;
        this.$refs.Consentement.$data.svData.refEnteteOpe = refEnteteOpe;
        this.$refs.Consentement.fetchDataList();
        this.$refs.Consentement.fetchListmedecin();
        this.$refs.Consentement.fetchListIntervention();
        this.fetchDataList();

        this.$refs.Consentement.$data.titleComponent =
          "Consentement pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteConsommationOpe(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.EnteteConsommationOpe.$data.etatModal = true;
        this.$refs.EnteteConsommationOpe.$data.refEnteteOpe = refEnteteOpe;
        this.$refs.EnteteConsommationOpe.$data.svData.refEnteteOpe = refEnteteOpe;
        this.$refs.EnteteConsommationOpe.fetchDataList();
        this.$refs.EnteteConsommationOpe.fetchListmedecin();
        this.$refs.EnteteConsommationOpe.fetchListSalle();
        this.$refs.EnteteConsommationOpe.fetchListIntervention();
        this.$refs.EnteteConsommationOpe.fetchListServices();
        this.fetchDataList();

        this.$refs.EnteteConsommationOpe.$data.titleComponent =
          "Consommation en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteEvaluation(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.EnteteEvaluation.$data.etatModal = true;
        this.$refs.EnteteEvaluation.$data.refEnteteOpe = refEnteteOpe;
        this.$refs.EnteteEvaluation.$data.svData.refEnteteOpe = refEnteteOpe;
        this.$refs.EnteteEvaluation.fetchDataList();
        this.$refs.EnteteEvaluation.fetchListmedecin();
        this.fetchDataList();

        this.$refs.EnteteEvaluation.$data.titleComponent =
          "Evaluation en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPoseActeMedecin(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.PoseActeMedecin.$data.etatModal = true;
        this.$refs.PoseActeMedecin.$data.refDetailCons = refDetailCons;
        this.$refs.PoseActeMedecin.$data.svData.refDetailCons = refDetailCons;
        this.$refs.PoseActeMedecin.fetchDataList();
        this.$refs.PoseActeMedecin.fetchListSelection();
        this.fetchDataList();

        this.$refs.PoseActeMedecin.$data.titleComponent =
          "Les Actes Posés sur " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showConsPresAnesthesique(refEnteteOpe, name) {

      if (refEnteteOpe != '') {

        this.$refs.ConsPresAnesthesique.$data.etatModal = true;
        this.$refs.ConsPresAnesthesique.$data.refEnteteOperation = refEnteteOpe;
        this.$refs.ConsPresAnesthesique.$data.svData.refEnteteOperation = refEnteteOpe;
        this.$refs.ConsPresAnesthesique.fetchDataList();
        this.fetchDataList();

        this.$refs.ConsPresAnesthesique.$data.titleComponent =
          "Consultation Pre-anesthesique pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    //CosultationPreAnesthesique,   Consentement,  EnteteConsommationOpe,    EnteteEvaluation,
    getRouteParam() {
      var id = this.$route.params.id;
      this.refDetailCons = id;
    },
    showCreatePrelevement(id, noms) {
      this.dialog2 = true;
      this.svData.id = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
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
        this.svData.author = this.userData.name;

        //serviceProvenance
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_prelevement_Cons?id=${this.svData.id}&author=${this.svData.author}&refService=${this.svData.refService}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEntetePrelevement = item.id;
              this.serviceProvenance = item.nom_uniteproduction;
            });
            this.showLaboratoire(this.svData.refEntetePrelevement, this.svData.noms, this.serviceProvenance);
            this.dialog2 = false;
            this.isLoading(false);
          }
        );

      }
    },
    // fetchListServices
    showLaboratoire(refEntetePrelevement, name, serviceProvenance) {

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
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
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

      } else {
        this.showError("Personne n'a fait cette action");
      }

    } 



  },
  filters: {

  }
}
</script>
  
  