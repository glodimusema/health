<template>
  <v-row justify="center">
    <DetailLabo ref="DetailLabo" />
    <ResultatSpermatique ref="ResultatSpermatique" />
    <Annexe_Laboratoire ref="Annexe_Laboratoire" />
    <ResultatBacteriologie ref="ResultatBacteriologie" />
    <v-dialog v-model="etatModal" persistent max-width="1500px">
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

                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Vente <v-spacer></v-spacer>
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

                        <v-text-field type="date" label="Date " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateLabo">
                        </v-text-field>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Grande Catégorie" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.GrandCategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refGrandCategorie"
                              chips clearable @change="get_categorie_for_GrandCat(svData.refGrandCategorie)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.CategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refCatexamen"
                              clearable chips @change="get_examen_for_Categorie(svData.refCatexamen)">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                              chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>




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

                <v-dialog v-model="dialog2" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Enregistrement des Resultats <v-spacer></v-spacer>
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
                      <v-card-text>

                        <v-autocomplete label="Selectionnez la Valeur Normale" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ValeurList"
                          item-text="designation" item-value="id" dense outlined v-model="svData.refValeur" chips
                          clearable>
                        </v-autocomplete>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Résultat" prepend-inner-icon="extension" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.libelle"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Methode Utilisée" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.MethodeList"
                              item-text="designation" item-value="designation" dense outlined v-model="svData.methode"
                              chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Nature des Echantillons" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.NatureList"
                              item-text="designation" item-value="designation" dense outlined
                              v-model="svData.natureechantillon" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-select label="Observation" :items="[
                              { designation: 'POSITIF' },
                              { designation: 'NEGATIF' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']"
                              outlined dense item-text="designation" item-value="designation"
                              v-model="svData.observation"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Commentaire" prepend-inner-icon="extension" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.commentaire"></v-text-field>
                          </div>
                        </v-flex>


                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                        <v-btn color="#B72C2C" dark :loading="loading" @click="validate2">
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

                        </div>
                      </v-flex>
                      <v-flex md1>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <!-- <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                              <v-icon>add</v-icon>
                            </v-btn> -->
                            </span>
                          </template>
                          <span>Affecter les Examens</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card :loading="loading" :disabled="loading">
                      <!-- {{ this.serviceProvenance }} -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Action</th>
                                <th class="text-left">N°Prélev.</th>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Examen</th>
                                <th class="text-left">Resultat</th>
                                <th class="text-left">Unité</th> 
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">Service(Orig.)</th>
                                <th class="text-left">GrandCat.</th>
                                <th class="text-left">Categorie</th>
                                <th class="text-left">Tube</th>                               
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

                                      <v-list-item link @click="showDetailLaboratire(item.id, item.noms,item.refEntetePrelevement,item.designationEx)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-anchor</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showResultatSperme(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Resultats Spermes
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showResultatBacteriologie(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Résultats des analyses
                                          Bactériologiques
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showAnnexeLaboratoire(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Les Annexes des Resultats
                                        </v-list-item-title>
                                      </v-list-item>


                                      <v-list-item link @click="printBill(item.refEntetePrelevement)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                                      </v-list-item>

                                    </v-list>
                                  </v-menu>

                                </td>
                                <td>{{ item.codePreleve }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.designationEx }}</td>
                                <td>{{ item.resultat2 }}  {{ item.commentaire2 }}</td>
                                <td>{{ item.unite2 }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.serviceProvenance }}</td>
                                <td>{{ item.designationGCatEx }}</td>
                                <td>{{ item.designationCatEx }}</td>
                                <td>

                                  <v-btn elevation="2" x-small class="white--text"
                                    :color="item.codeTube == 'S' ? '#ff3333' : item.codeTube == 'C' ? '#00B0F0' : item.codeTube == 'H' ? '#92D050' : item.codeTube == 'E' ? '#7030A0' : item.codeTube == 'F' ? '#A6A6A6' : 'error'"
                                    depressed>
                                    {{ item.codeTube == 'S' ? "S" : item.codeTube == 'C' ? "C" : item.codeTube == 'H' ? "H"
                                      : item.codeTube == 'E' ? "E" : item.codeTube == 'F' ? "F" : 'S' }}
                                  </v-btn>

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
import Annexe_Laboratoire from './Annexe_Laboratoire.vue';
import DetailLabo from './DetailLabo.vue';
import ResultatSpermatique from './ResultatSpermatique.vue';
import ResultatBacteriologie from './ResultatBacteriologie.vue';

export default {
  components: {
    DetailLabo,
    ResultatSpermatique,
    Annexe_Laboratoire,
    ResultatBacteriologie
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEntetePrelevement: 0,
      svData: {
        id: '',
        refEntetePrelevement: 0,
        refGrandCategorie: "",
        refCatexamen: "",
        refExamen: "",
        author: "Admin",
        serviceProvenance: "",
        dateLabo: "",

        paie: 0,
        refMouvement: 0,
        Categorie: "",

        refEnteteLabo: 0,
        refValeur: 0,
        libelle: '',
        observation: '',
        natureechantillon: "",
        methode: "",
        commentaire: ""

      },
      fetchData: [],
      NatureList: [],
      MethodeList: [],
      don: [],
      query: "",
      stataData: {
        GrandCategorieList: [],
        CategorieList: [],
        ExamenList: [],
        ValeurList: [],
        ServiceList: [],
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {

    // this.fetchDataList();
    // this.fetchListSelection();
    // this.get_methode_Examen();
    // this.get_nature_Echantillon();  
    // this.fetchListServices();  
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),
    async get_methode_Examen() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_methodeexamen_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.MethodeList = chart;
          } else {
            this.MethodeList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    async get_nature_Echantillon() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_natureechantillon_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.NatureList = chart;
          } else {
            this.NatureList = [];
          }

          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.refEntetePrelevement = this.refEntetePrelevement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetelaboratoire/${this.svData.id}`,
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
          this.svData.author = this.userData.name;
          this.svData.refEntetePrelevement = this.refEntetePrelevement;


          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entetelaboratoire`,
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
    validate2() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {

        }
        else {
          this.svData.author = this.userData.name;
          this.svData.refEntetePrelevement = this.refEntetePrelevement;


          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detaillaboratoire`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog2 = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });
        }

      }
    },

    async get_valeur_for_Examen(id_examen) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_ValeurForExam/${id_examen}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.ValeurList = chart;
          } else {
            this.stataData.ValeurList = [];
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntetePrelevement = item.refEntetePrelevement;
            this.svData.refExamen = item.refExamen;
            this.svData.serviceProvenance = item.serviceProvenance;
            // this.svData.qteVente = item.qteVente;
            // this.svData.designationProduit = item.designationProduit;              
          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    getDataPaie() {

      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.Categorie = item.Categorie;
          });

        }
      );

      this.editOrFetch(`${this.apiBaseURL}/get_paie_Labo/${this.svData.refMouvement}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.paie = item.total_paie;
          });

          this.edit = true;
          this.dialog = true;
        }
      );


    },
    showData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntetePrelevement = item.refEntetePrelevement;
            this.svData.refExamen = item.refExamen;
            this.svData.serviceProvenance = item.serviceProvenance;
            this.svData.refEnteteLabo = item.id;
          });

          this.get_valeur_for_Examen(this.svData.refExamen);
          //this.serviceProvenance = true;
          this.dialog2 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetelaboratoire/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entete_labo/${this.refEntetePrelevement}?page=`);

    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_GrandCategorie`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.GrandCategorieList = donnees;

        }
      );
    },
    //fultrage de donnees
    async get_categorie_for_GrandCat(id_Grandcat) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_CatexamenForGrandCat/${id_Grandcat}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.CategorieList = chart;
          } else {
            this.stataData.CategorieList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

    //fultrage de donnees
    async get_examen_for_Categorie(id_categorie) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_ExamenForCat/${id_categorie}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.ExamenList = chart;
          } else {
            this.stataData.ExamenList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    backPage() {
      this.$router.go(-1);
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showDetailLaboratire(refEnteteLabo, name, refEntetePrelevement, designationEx) {

      if (refEnteteLabo != '') {

        console.log(refEnteteLabo);

        this.$refs.DetailLabo.$data.etatModal = true;
        this.$refs.DetailLabo.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLabo.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLabo.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailLabo.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailLabo.fetchDataList();
        this.$refs.DetailLabo.get_methode_Examen();
        this.$refs.DetailLabo.get_nature_Echantillon();
        // this.$refs.DetailLabo.getDataEchantillon(refEntetePrelevement); 
        this.fetchDataList();

        this.$refs.DetailLabo.$data.titleComponent =
          "Compeleter les Resultats de l'examen "+designationEx+" pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResultatSperme(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.ResultatSpermatique.$data.etatModal = true;
        this.$refs.ResultatSpermatique.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatSpermatique.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatSpermatique.fetchDataList();
        this.$refs.ResultatSpermatique.fetchListSelection();
        this.fetchDataList();

        this.$refs.ResultatSpermatique.$data.titleComponent =
          "Resultats des Spermes pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    showAnnexeLaboratoire(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.Annexe_Laboratoire.$data.etatModal = true;
        this.$refs.Annexe_Laboratoire.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.Annexe_Laboratoire.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.Annexe_Laboratoire.fetchDataList();
        this.fetchDataList();

        this.$refs.Annexe_Laboratoire.$data.titleComponent =
          "Les annexe des Resultats pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    // fetchListServices
    showResultatBacteriologie(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.ResultatBacteriologie.$data.etatModal = true;
        this.$refs.ResultatBacteriologie.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatBacteriologie.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatBacteriologie.fetchDataList();
        this.$refs.ResultatBacteriologie.fetchListSelection1();
        this.fetchDataList();

        this.$refs.ResultatBacteriologie.$data.titleComponent =
          "Resultats des analyses Bacteriologiques pour " + name;

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
    }


  },
  filters: {

  }
}
</script>
  
  