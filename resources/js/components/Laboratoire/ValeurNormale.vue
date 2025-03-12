<template>
  <v-layout>
     
     <v-flex md12>
      <v-flex md12>
        <!-- modal -->
        <v-dialog
          v-model="dialog"
          max-width="700px"
          scrollable
          transition="dialog-bottom-transition"
        >
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                {{ titleComponent }} <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip></v-card-title
              >
              <v-card-text>

                  <v-layout row wrap>


                    <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                                chips @change="getCategorie(svData.refExamen)">
                                </v-autocomplete>
                            </div>
                        </v-flex>


                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Catégorie Examen" prepend-inner-icon="extension"
                        dense  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationCat"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Grande Catégorie Examen" prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationGCat"></v-text-field>
                      </div>
                    </v-flex> 




                      <!-- <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Grande Catégorie" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.GrandCategorieList" item-text="designation"
                              item-value="id" dense outlined v-model="svData.refGrandCategorie" chips clearable
                              @change="get_categorie_for_GrandCat(svData.refGrandCategorie)">
                              </v-autocomplete>
                          </div>
                      </v-flex>
                      <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.CategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refCatexamen" clearable
                              chips @change="get_examen_for_Categorie(svData.refCatexamen)">
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
                      </v-flex>  -->

                      <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Designation(Interval des Valeurs)" prepend-inner-icon="extension" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.designation"></v-text-field>
                          </div>
                      </v-flex>
                      

                      <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez Unité" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.UniteList" item-text="designation"
                              item-value="designation" dense outlined v-model="svData.unite" chips clearable
                              >
                              </v-autocomplete>
                          </div>
                      </v-flex>
                 
                      
                      <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Catégorie de la Valeur" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CategorieValeurList" item-text="designation"
                              item-value="designation" dense outlined v-model="svData.detailValeur" chips clearable
                              >
                              </v-autocomplete>
                          </div>
                      </v-flex>

                     

                  </v-layout>  
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn
                  color="#B72C2C"
                  dark
                  :loading="loading"
                  @click="validate"
                >
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <br /><br />
        <!-- fin modal -->

        <!-- bande -->
        <v-layout>
          <v-flex md1>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn :loading="loading" fab @click="onPageChange">
                    <v-icon>autorenew</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Initialiser</span>
            </v-tooltip>
          </v-flex>
          <v-flex md5>
            <v-text-field
              append-icon="search"
              label="Recherche..."
              single-line
              solo
              outlined
              rounded
              hide-details
              v-model="query"
              @keyup="onPageChange"
              clearable
            ></v-text-field>
          </v-flex>

          <v-flex md5></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="#B72C2C" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Valeur</th>
                    <th class="text-left">Examen</th>
                    <th class="text-left">Catégorie</th>
                    <th class="text-left">GrandCatégorie</th>
                    <th class="text-left">DetailValeur</th>
                    <th class="text-left">Unité</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.designation }}</td>
                    <td>{{ item.Examen }}</td>
                    <td>{{ item.designationCat }}</td>
                    <td>{{ item.designationGCat }}</td>
                    <td>{{ item.detailValeur }}</td>
                    <td>{{ item.unite }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-tooltip top v-if="(roless[0].update=='OUI')" color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small
                              ><v-icon color="#B72C2C">edit</v-icon></v-btn
                            >
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small
                              ><v-icon color="#B72C2C">delete</v-icon></v-btn
                            >
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip>
                    </td>
                  </tr>
                </tbody>
              </template>
            </v-simple-table>
            <hr />

            <v-pagination
              color="#B72C2C"
              v-model="pagination.current"
              :length="pagination.total"
              :total-visible="7"
              @input="onPageChange"
            ></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
     
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  components: {},
  data() {
    return {
      title: "Pays component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        refGrandCategorie: "",
        refCatexamen: "",
        refExamen:"",
        designation: "",
        detailValeur:"",
        unite:"",

        designationCat:"",
        designationGCat:"",
      },
      
      fetchData: null,
      titreModal: "",
      stataData: {
        GrandCategorieList: [],
        CategorieList: [],
        ExamenList: [],
        UniteList: [],
        CategorieValeurList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    };
  },
    computed: {
      ...mapGetters(["roleList", "isloading"]),
    },
  methods: {
   showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Valeur Normale ";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification ";
      } else {
        this.titleComponent = "Ajout Valeur Normale ";
      }
    },

    // searchMember: _.debounce(function () {
    //   this.onPageChange();
    // }, 300)
    // ,
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_valeurnormale?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_valeurnormale`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_valeurnormale/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.designation;
            // this.get_examen_all();
            // this.get_examen_for_Categorie(item.refCatexamen);
            // this.get_categorie_for_GrandCat(item.refGrandCategorie);
            
          });

          this.getSvData(this.svData, data.data[0]);
          this.getCategorie(this.svData.refExamen);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_valeurnormale/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_GrandCategorie`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.GrandCategorieList = donnees;

        }
      );
    },
    fetchListSelectionUnite() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tconf_unitevaleur_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.UniteList = donnees;

        }
      );
    }  ,
    fetchListSelectionCategorieUnite() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tconf_categorievaleur_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.CategorieValeurList = donnees;

        }
      );
    }  
    ,
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
      //fultrage de donnees
      async get_examen_all() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_texamen_2`)
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
      getCategorie(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_examen/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.designationCat = item.designationCat; 
              this.svData.designationGCat = item.designationGCat; 
                           
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      },    



  },
  created() {
     
    this.fetchListSelectionCategorieUnite();
    this.fetchListSelectionUnite();
    this.get_examen_all();
    // this.fetchListSelection();
    this.testTitle();
    this.onPageChange();

  },
};
</script>