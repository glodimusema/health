<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="900px" fullscreen>
      <v-card>
        <!-- container -->

        <v-card-title class="red">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etatModal = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout -->

          <div>
            <v-layout>
              <!--   -->
              <v-flex md12>

                <DetailFeuilleFacture ref="DetailFeuilleFacture" />
                <PaiementFacture ref="PaiementFacture" />

                <v-dialog v-model="dialog" max-width="700px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Feuille de Facturation <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="closeForm" text fab depressed>
                                <v-icon>close</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Fermer</span>
                        </v-tooltip>
                      </v-card-title>
                      <v-card-text>

                        <v-layout row wrap>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.DepartementList"
                                item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement"
                                clearable chips @change="Get_unite_for_Departement(svData.refDepartement)">
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.UniteList"
                                item-text="nom_uniteproduction" item-value="id" dense outlined
                                v-model="svData.refUniteProduction" clearable chips>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.MedecinList"
                                item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin"
                                clearable chips>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                        </v-layout>

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
                <br /><br />

                <v-layout>

                  <v-flex md12>
                    <v-layout>
                      <v-flex md6>
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
                      </v-flex>
                      <v-flex md5>
                        <div>
                          <!-- {{ this.don }} -->
                        </div>
                      </v-flex>
                      <v-flex md1>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                                <v-icon>add</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Creer une Fauille de Facturation</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card :loading="loading" :disabled="loading">
                      <!-- ,'ValeurNormale2','observation2'  -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <!-- statutentetecons -->
                              <tr>
                                <th class="text-left">Action</th>
                                <th class="text-left">N°Facture</th>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Categorie</th>
                                <th class="text-left">DateFacture</th>
                                <th class="text-left">Services</th>
                                <th class="text-left">Medecin</th>
                                <th class="text-left">Departement</th>
                                <th class="text-left">SoldeFact.</th>
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

                                      <v-list-item link
                                        @click="showDetailFacturation(item.id, item.noms, item.organisationAbonne)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-briefcase-check</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Ajouter les details
                                          Facture
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="item.RestePaie != 0 || (modifier == 'OUI')" link
                                        @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="item.RestePaie != 0 || (supprimer == 'OUI')" link
                                        @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                      </v-list-item>
                                    </v-list>
                                  </v-menu>

                                </td>
                                <td>{{ item.codeFacture }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.categoriemaladiemvt }}</td>
                                <td>{{ item.datefacture }}</td>
                                <td>{{ item.nom_uniteproduction }}</td>
                                <td>{{ item.noms_medecin }}</td>
                                <td>{{ item.nom_departement }}</td>
                                <td>{{ item.RestePaie }}</td>

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
              <!--   -->
            </v-layout>

          </div>

          <!-- fin -->
        </v-card-text>

        <!-- container -->
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailFeuilleFacture from './DetailFeuilleFacture.vue';
import PaiementFacture from './PaiementFacture.vue';

export default {
  components: {
    DetailFeuilleFacture,
    PaiementFacture
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refMouvement: 0,
      //'id','refMouvement','refUniteProduction','refMedecin','datefacture','statut','author'
      svData: {
        id: '',
        refMouvement: 0,
        refDepartement: "",
        refUniteProduction: "",
        refMedecin: "",
        //datefacture: "", 
        statut: "",
        author: "",


      },
      fetchData: [],
      ModeList: [],
      don: [],
      query: "",
      stataData: {
        DepartementList: [],
        UniteList: [],
        produitList: [],
        typeproduitList: [],
        MedecinList: [],
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {
    // this.fetchDataList();
    // this.fetchListDepartement();
    // this.fetchListmedecin();

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
          this.svData.refMouvement = this.refMouvement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetefacturation/${this.svData.id}`,
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
          this.svData.refMouvement = this.refMouvement;
          this.svData.author = this.userData.name;

          if (this.$refs.form.validate()) {
            this.isLoading(true);
            //refService
            this.editOrFetch(`${this.apiBaseURL}/insert_entetefacturation?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}`).then(
              ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {
                  this.svData.refEnteteFacturation = item.id;
                  this.svData.noms = item.noms;
                  this.svData.organisationAbonne = item.organisationAbonne;
                });
                this.showDetailFacturation(this.svData.refEnteteFacturation, this.svData.noms, this.svData.organisationAbonne);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              }
            );
          }
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
    closeForm() {
      this.dialog = false;
      this.resetObj(this.svData);
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
    },
    //,'refMouvement','refUniteProduction','refMedecin','datefacture','statut','author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetefacturation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refUniteProduction = item.refUniteProduction;
            this.svData.refMedecin = item.refMedecin;
            // this.svData.datefacture = item.datefacture;
            this.svData.statut = item.statut;
          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetefacturation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entetefacturation_mouvement/${this.refMouvement}?page=`);
    },
    fetchListDepartement() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.DepartementList = donnees;

        }
      );
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MedecinList = donnees;

        }
      );
    }
    ,
    //fultrage de donnees
    async Get_unite_for_Departement(idDepartement) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_unite_Departement2/${idDepartement}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.UniteList = chart;
          } else {
            this.stataData.UniteList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    }


    ,
    // PARTIE DES COMPOSANTS===================================================================   


    showDetailFacturation(refEnteteFacturation, name, organisationAbonne) {

      if (refEnteteFacturation != '') {
        //organisationAbonne
        this.$refs.DetailFeuilleFacture.$data.etatModal = true;
        this.$refs.DetailFeuilleFacture.$data.refEnteteFacturation = refEnteteFacturation;
        this.$refs.DetailFeuilleFacture.$data.organisationAbonne = organisationAbonne;
        this.$refs.DetailFeuilleFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
        this.$refs.DetailFeuilleFacture.fetchListSelection();
        this.$refs.DetailFeuilleFacture.fetchDataList();
        this.$refs.DetailFeuilleFacture.getRouteParam();
        this.fetchDataList();
        // this.$refs.DetailFeuilleFacture.getRouteParamMalade(refEnteteFacturation);

        this.$refs.DetailFeuilleFacture.$data.titleComponent =
          "Détail de Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPaieFacturation(refEnteteFacturation, name) {

      if (refEnteteFacturation != '') {

        this.$refs.PaiementFacture.$data.etatModal = true;
        this.$refs.PaiementFacture.$data.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.fetchDataList();
        this.$refs.PaiementFacture.getInfoFacture(refEnteteFacturation);
        this.$refs.PaiementFacture.get_mode_Paiement();
        this.fetchDataList();

        this.$refs.PaiementFacture.$data.titleComponent =
          "Paiement de la Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }



  },
  filters: {

  }
}
</script>
  
  