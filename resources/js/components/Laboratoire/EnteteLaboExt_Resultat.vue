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
            <!--     -->
            <v-flex md12>
              <DetailLaboExt ref="DetailLaboExt" />
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Les Examens <v-spacer></v-spacer>
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
                            item-text="designation" item-value="id" dense outlined v-model="svData.refGrandCategorie" chips
                            clearable @change="get_categorie_for_GrandCat(svData.refGrandCategorie)">
                          </v-autocomplete>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.CategorieList"
                            item-text="designation" item-value="id" dense outlined v-model="svData.refCatexamen" clearable chips
                            @change="get_examen_for_Categorie(svData.refCatexamen)">
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList" item-text="designation"
                            item-value="id" dense outlined v-model="svData.refExamen" clearable chips>
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
                        item-text="designation" item-value="id" dense outlined v-model="svData.refValeur" chips clearable>
                      </v-autocomplete>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Résultat" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Methode Utilisée" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.MethodeList" item-text="designation"
                            item-value="designation" dense outlined v-model="svData.methode" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Nature des Echantillons" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.NatureList" item-text="designation"
                            item-value="designation" dense outlined v-model="svData.natureechantillon" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Observation" :items="[
                              { designation: 'POSITIF' },
                              { designation: 'NEGATIF' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            dense item-text="designation" item-value="designation" v-model="svData.observation"></v-select>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Commentaire" prepend-inner-icon="extension" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.commentaire"></v-text-field>
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

              <v-layout row wrap>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <router-link :to="'/admin/mouvement_labo'">Laboratoire/Ordonance</router-link>
                    <router-link :to="'/admin/entete_labo_ext_resultat/' + this.svData.ref">/Voir les Examens</router-link>
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
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Examen</th>
                              <th class="text-left">Resultat</th>
                              <th class="text-left">Unité</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Service(Orig.)</th>
                              <th class="text-left">Categorie</th>
                              <th class="text-left">GrandCat.</th>
                              <th class="text-left">Etat</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.designationEx }}</td>
                              <td>{{ item.resultat2 }}</td>
                              <td>{{ item.unite2 }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.serviceProvenance }}</td>                             
                              <td>{{ item.designationCatEx }}</td>
                              <td>{{ item.designationGCatEx }}</td>                              
                              <td>{{ item.statutentetelaboext }}</td>
                              <td>


                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link @click="showDetailLaboratire(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-anchor</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showDetailLaboratire(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-anchor</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="printBill(item.refMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
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
import DetailLaboExt from './DetailLaboExt.vue';
export default {
  components: {
    DetailLaboExt
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
      refMouvement: 0,
      svData: {
        id: '',
        refMouvement: 0,
        refGrandCategorie: "",
        refCatexamen: "",
        refExamen: "",
        author: "Admin",
        dateLabo: "",

        nommedecin: "",
        nomcentremedical: "",
        adressecentre: "",
        telephonemedecin: "",
        mailmedecin: "",
        nompreleveur: "",
        dateprelevement: "",

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
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    // this.fetchDataList();
    // this.fetchListSelection();
    // this.get_methode_Examen();
    // this.get_nature_Echantillon();
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

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.refMouvement=this.refMouvement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetelaboratoireext/${this.svData.id}`,
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
          this.svData.refMouvement=this.refMouvement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entetelaboratoireext`,
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
    validate2() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {

        }
        else {
          this.svData.refMouvement=this.refMouvement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detaillaboratoireext`,
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
      window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
    },
    getPrice(id) {
      this.editOrFetch(`${this.apiBaseURL}/a1/fetch_single_produit/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.puVente = item.pu;
            // console.log("prix unitaire:"+item.pu);               
          });
          // this.getSvData(this.svData, data.data[0]);           
        }
      );
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoireext/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refExamen = item.refExamen;
            this.svData.nommedecin = item.nommedecin;
            this.svData.nomcentremedical = item.nomcentremedical;
            this.svData.adressecentre = item.adressecentre;
            this.svData.telephonemedecin = item.telephonemedecin;
            this.svData.mailmedecin = item.mailmedecin;
            this.svData.nompreleveur = item.nompreleveur;
            this.svData.dateprelevement = item.dateprelevement;
          });

          this.edit = true;
          this.dialog = true;
        }
        //,nommedecin,nomcentremedical, adressecentre, telephonemedecin, mailmedecin, nompreleveur, dateprelevement
      );
    },
    showData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoireext/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refExamen = item.refExamen;

            this.svData.refEnteteLabo = item.id;
          });

          this.get_valeur_for_Examen(this.svData.refExamen);
          //this.edit = true;
          this.dialog2 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetelaboratoireext/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entete_laboext/${this.refMouvement}?page=`);

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

    // PARTIE DES COMPOSANTS===================================================================   


    showDetailLaboratire(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.DetailLaboExt.$data.etatModal = true;
        this.$refs.DetailLaboExt.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLaboExt.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLaboExt.fetchDataList();
        this.$refs.DetailLaboExt.get_methode_Examen();
        this.$refs.DetailLaboExt.get_nature_Echantillon();
        this.fetchDataList();

        this.$refs.DetailLaboExt.$data.titleComponent =
          "Compeleter les Resultats de Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>
  
  