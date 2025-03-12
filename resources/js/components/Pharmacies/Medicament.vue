<template>

<div>
          
          <v-layout>
            
            <v-flex md12>

              <DetailMedicament ref="DetailMedicament" />

              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Ajouter Medicament <v-spacer></v-spacer>
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

                      <v-text-field
                        label="Designation"
                        prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']"
                        outlined dense
                        v-model="svData.nom_medicament"
                      ></v-text-field>                 
                  
                      <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList" item-text="nom_categoriemedicament" item-value="id"
                        outlined dense v-model="svData.refcategoriemedicament">
                      </v-autocomplete> 

                      <!-- <v-text-field type="number" label="Prix Unitaire($)" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.pu_medicament"></v-text-field> -->

                      <v-text-field label="Unité de mesure" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.forme"></v-text-field>
                        
                        <v-text-field readonly type="number" label="Quantité" prepend-inner-icon="extension" outlined dense
                        v-model="svData.qtetot"></v-text-field>

                        <v-text-field type="number" label="Stock d'alerte" prepend-inner-icon="extension" outlined dense
                        v-model="svData.stock_alerte"></v-text-field>

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
                      <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                        outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                    </v-flex>
                    <v-flex md5>


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
                        <span>Ajouter Medicament</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Designation</th>
                              <th class="text-left">Unité</th>
                              <th class="text-left">Catégorie</th>
                              <th class="text-left">Qté</th>
                              <th class="text-left">StockAlerte</th>
                              <th class="text-left">Alerte</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.nom_medicament }}</td>
                              <td>{{ item.forme }}</td>
                              <td>{{ item.nom_categoriemedicament }}</td>
                              <td>{{ item.qtetot }}</td>
                              <td>{{ item.stock_alerte }}</td>
                              <td>
                                <!--  -->
                                <v-btn
                                  elevation="2"
                                  x-small
                                  class="white--text"
                                  :color="item.qtetot < item.stock_alerte ? '#F13D17' : item.qtetot > item.stock_alerte ? '#3DA60C' : item.qtetot = item.stock_alerte ? '#BFBF09' :'error'"
                                  depressed                            
                                >
                                  {{ item.qtetot < item.stock_alerte ? 'Fin stock' : item.qtetot > item.stock_alerte ? 'Bon Etat' : item.qtetot = item.stock_alerte ? 'Stock Alerte' :'error' }}
                                </v-btn>
                              </td>
                              <td>
                                
                              <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>

                              <v-list dense width="">
                                                                    
                                <v-list-item link @click="showDetailMedicament(item.id, item.nom_medicament)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Detail
                                </v-list-item-title>
                              </v-list-item>
                               
                              <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier
                                </v-list-item-title>
                              </v-list-item>
                               
                              <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Suppression
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

        </div>




  </template>
<script>
  import { mapGetters, mapActions } from "vuex";
  import DetailMedicament from './DetailMedicament.vue';

  export default {
    components:{
      DetailMedicament
    },
    data() {
      return {  
        title: "Liste des Maladies",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
      svData: {
          id: '',
          refcategoriemedicament: 0,
          nom_medicament: "",
          pu_medicament: 0,
          forme: "",
          qtetot:0,          
          author:"Admin",
          nom_categoriemedicament: "",
          qteTotal:0,
          stock_alerte:0           
        },
        fetchData: [],
        categorieList: [],
        query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
  
  
      }
    },
    created() {
       
      this.fetchDataList();
      this.fetchListSelection();      
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
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_medicament/${this.svData.id}`,
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
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_medicament`,
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
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_medicament/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.nom_medicament = item.nom_medicament;             
              this.svData.refcategoriemedicament = item.refcategoriemedicament;
              this.svData.pu_medicament = item.pu_medicament;
              this.svData.forme = item.forme; 
              this.svData.qtetot = item.qtetot;  
              this.svData.stock_alerte = item.stock_alerte;
              this.svData.author = item.author; 
              this.svData.nom_categoriemedicament = item.nom_categoriemedicament;           
            });
  
            this.edit = true;
            this.dialog = true;
            //stock_alerte
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_medicament/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_medicament?page=`);
      },
  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_categoriemedicament`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieList = donnees;
  
          }
        );
      },
    showDetailMedicament(refmedicament, name) {

      if (refmedicament != '') {

        this.$refs.DetailMedicament.$data.etatModal = true;
        this.$refs.DetailMedicament.$data.refmedicament = refmedicament;
        this.$refs.DetailMedicament.$data.svData.refmedicament = refmedicament;
        this.$refs.DetailMedicament.fetchDataList();
        this.fetchDataList();

        this.$refs.DetailMedicament.$data.titleComponent =
          "Detail Medicament pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }  
    //fetch_medicament_filtre
    ,
  
  getDataMedicament(refmedicament) {
    this.svData.qteTotal=0;
    this.editOrFetch(`${this.apiBaseURL}/fetch_medicament_filtre/${refmedicament}`).then(
      ({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.svData.qteTotal = this.svData.qteTotal + item.quantite;              
        });
      }
    );
    return this.svData.qteTotal;
  }
  
    },
    filters: {
  
    }
  }
  </script>
  
  