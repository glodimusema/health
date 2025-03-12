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
                      <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Grande Catégorie" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.GrandCategorieList" item-text="designation"
                              item-value="id" dense outlined v-model="svData.refGrandCategorie" chips clearable
                              @change="get_categorie_for_GrandCat(svData.refGrandCategorie)">
                              </v-autocomplete>
                          </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.CategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refCatexamen" clearable
                              chips>
                              </v-autocomplete>
                          </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                      
                          <v-text-field label="Designation Examen" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designation"></v-text-field>
                        </div>
                      </v-flex>

                      <!-- <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                      
                          <v-text-field type="number" label="Prix Examen($)" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PrixExam"></v-text-field>
                        </div>
                      </v-flex>                      -->


                      <v-flex xs12 sm12 md6 lg12>
                          <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Tube à Utiliser" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.TubeList"
                              item-text="designationTube" item-value="id" dense outlined v-model="svData.refTube" clearable
                              chips>
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
                    <th class="text-left">Examen</th>
                    <!-- <th class="text-left">Prix($)</th> -->
                    <th class="text-left">Tube</th>
                    <th class="text-left">CouleurTube</th>
                    <th class="text-left">Catégorie</th>
                    <th class="text-left">GrandCatégorie</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.designation }}</td>
                    <!-- <td>{{ item.PrixExam }}</td> -->
                    <td>{{ item.designationTube }}</td>
                    <td>
                      <v-btn
                            elevation="2"
                            x-small
                            class="white--text"
                            :color="item.codeTube == 'S' ? '#ff3333' : item.codeTube == 'C' ? '#00B0F0' :item.codeTube == 'H' ? '#92D050' :item.codeTube == 'E' ? '#7030A0' :item.codeTube == 'F' ? '#A6A6A6' :'error'"
                            depressed                            
                          >
                            {{ item.codeTube == 'S' ? "S" : item.codeTube == 'C' ? "C" :item.codeTube == 'H' ? "H" :item.codeTube == 'E' ? "E" :item.codeTube == 'F' ? "F" :'S' }}
                          </v-btn>
                    </td>                   
                    <td>{{ item.designationCat }}</td>
                    <td>{{ item.designationGCat }}</td>
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
          refTube: "",
          designation: "",
          PrixExam:0
        },
        
        fetchData: null,
        titreModal: "",
        stataData: {
          GrandCategorieList: [],
          CategorieList: [],
          TubeList: [],
        },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
  
      };
    },
    methods: {
     showModal() {
        this.dialog = true;
        this.titleComponent = "Ajout Examen ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification ";
        } else {
          this.titleComponent = "Ajout Examen ";
        }
      },
  
      // searchMember: _.debounce(function () {
      //   this.onPageChange();
      // }, 300)
      // ,
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_examen?page=`);
      },
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          this.svData.PrixExam=0;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_examen`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_examen/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "modification de " + item.designation;
              this.get_categorie_for_GrandCat(item.refGrandCategorie);
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
      },
  
      clearP(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_examen/${id}`).then(
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
      fetchListSelectionTube() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_Tube`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.TubeList = donnees;
  
          }
        );
      },
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
  
  
  
    },
    created() {
       
      this.fetchListSelection();
      this.testTitle();
      this.onPageChange();
      this.fetchListSelectionTube();

    },
  };
  </script>