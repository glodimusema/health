<template>
    
    <div>
  
      <v-layout>
         
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
                  
                  <v-select label="Selectionnez le Produit" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="produittList" item-text="designation" item-value="id"
                    outlined v-model="svData.refProduit">
                  </v-select>

                  <v-select label="Selectionnez le Type de Souscription" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="sousList" item-text="designation" item-value="id"
                    outlined v-model="svData.refSouscription">
                  </v-select>

                  <v-select label="Statut" :items="[
                        { designation: 'Encours' }, 
                        { designation: 'Finie' }                                        
                        ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                           item-text="designation" item-value="designation"
                           v-model="svData.statut"></v-select>
                
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
                    <span>Ajouter le Detail</span>
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
                          <th class="text-left">Produit</th>
                          <th class="text-left">Type Sous.</th>    
                          <th class="text-left">Prix($)</th>  
                          <th class="text-left">Statut</th>
                          <th class="text-left">N°Sous.</th>
                          <th class="text-left">Client</th>
                          <th class="text-left">Date Sous.</th>                         
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.designationProduit }}</td>
                          <td>{{ item.categorieSouscription}}</td>
                          <td>{{ item.prix }}</td>
                          <td>{{ item.statut }}</td>
                          <td>{{ item.refEnteteVente }}</td>
                          <td>{{ item.noms }}</td>
                          <td>{{ item.dateSous | formatDate }}</td>
                          <td>
                            <v-tooltip top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="editData(item.id)" fab small>
                                    <v-icon color="#B72C2C">edit</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Modifier</span>
                            </v-tooltip>
  
                            <v-tooltip top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="deleteData(item.id)" fab small>
                                    <v-icon color="#B72C2C">delete</v-icon>
                                  </v-btn>
                                </span>
                              </template>
                              <span>Suppression</span>
                            </v-tooltip> 
                           
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
  export default {
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  
        svData: {
          id: '',
          refEnteteVente: this.$route.params.id,
          refProduit:0,
          refSouscription:0,
          statut:0,          
          author:"Admin",
          dateVente: "",
          designationProduit: "",
          noms: "",
          CategorieProduit:"",  
        },
        fetchData: [],        
        produittList: [],
        sousList: [],
        don:[],
        query: "",
  
      }
    },
    created() {
      this.getRouteParam();
      this.fetchDataList();
      this.fetchListSelection();
      this.fetchListSelectionSous();
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
              `${this.apiBaseURL}/a1/update_detailsouscription/${this.svData.id}`,
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
              `${this.apiBaseURL}/a1/insert_detailsouscription`,
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
  
      // s'id','refEnteteVente','refProduit','puVente','qteVente','author'
      //   this.fetchDataList();
      // }, 300),
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_single_detailsouscription/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refEnteteVente = item.refEnteteVente;
              this.svData.refProduit = item.refProduit;
              this.svData.refSouscription = item.refSouscription;
              this.svData.statut = item.statut;
              this.svData.designationProduit = item.designationProduit;              
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/a1/delete_detailsouscription/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        var id = this.$route.params.id;
        this.refEnteteVente = id;
        this.fetch_data(`${this.apiBaseURL}/a1/fetch_detail_entetesouscription/${this.refEnteteVente}?page=`);
        
      },
  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_list_produit_souscription`).then(
          ({ data }) => {
            var donnees = data.data;
            this.produittList = donnees;
          }
        );
      },
  
  fetchListSelectionSous() {
    this.editOrFetch(`${this.apiBaseURL}/a1/fetch_list_categorie_souscription`).then(
      ({ data }) => {
        var donnees = data.data;
        this.sousList = donnees;
      }
    );
  },
      getRouteParam()
      {
        var id = this.$route.params.id;
        this.refEnteteVente = id;
      } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  