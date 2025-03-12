<template>
    


    <v-row justify="center">
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
              
              <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Detail Medicament <v-spacer></v-spacer>
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
                        
                      <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.quantite">
                        </v-text-field>

                        <v-text-field type="date" label="Date Expiration " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateexpiration">
                        </v-text-field>
                      
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                        <v-btn color="#B72C2C" dark :loading="loading" @click="validateexpiration">
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
                                <th class="text-left">Medicament</th>
                                <th class="text-left">DateExpiration</th>    
                                <th class="text-left">Quantité</th>                          
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.nom_medicament }}</td>
                                <td>{{ item.dateexpiration }}</td>   
                                <td>{{ item.quantite }}</td>                          
                                <td>
                                  <v-tooltip top v-if="(roless[0].update=='OUI')" color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="editData(item.id)" fab small>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-btn>
                                      </span>
                                    </template>
                                    <span>Modifier</span>
                                  </v-tooltip>

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
  export default {

    data() {
      return {  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        refmedicament: 0,
        svData: {
          id: '',
          refmedicament: 0,
          quantite:0,
          dateexpiration: "",
          author: ""
        },
        fetchData: [],        
        don:[],
        query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
  
  
      }
    },
    created() {
       
      // this.fetchDataList();      
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validateexpiration() {
        if (this.$refs.form.validateexpiration()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.refmedicament= this.refmedicament;
            this.svData.author = this.userData.name;
            this.insertOrUpdateexpiration(
              `${this.apiBaseURL}/update_detailmedicament/${this.svData.id}`,
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
            this.svData.refmedicament= this.refmedicament;
            this.svData.author = this.userData.name;
            this.insertOrUpdateexpiration(
              `${this.apiBaseURL}/insert_detailmedicament`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailmedicament/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refmedicament = item.refmedicament;
              this.svData.quantite = item.quantite;
              this.svData.dateexpiration = item.dateexpiration;                        
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_detailmedicament/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {        
        this.fetch_data(`${this.apiBaseURL}/fetch_detail_medicament/${this.refmedicament}?page=`);
        
      } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  