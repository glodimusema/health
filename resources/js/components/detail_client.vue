<template>
    
    <div>
  
      <v-layout>
         
         <v-flex md12>
          <v-dialog v-model="dialog" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Client <v-spacer></v-spacer>
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
                    <!-- <div>
                        id client: {{ this.refClient }}

                    </div> -->
                <!-- <v-text-field label="N° Client" prepend-inner-icon="person"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.refClient">
                </v-text-field> -->

                  <v-select label="Selectionnez la Personne" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="personneList" item-text="name" item-value="id"
                    outlined v-model="svData.refPersonne">
                  </v-select>

                  <v-text-field type="date" label="Date affectation" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Date">
                  </v-text-field>

  
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
                    <span>Ajouter une affectation</span>
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
                          <th class="text-left">Client</th>
                          <th class="text-left">Personne</th>
                          <th class="text-left">Date</th>
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.nomClient }}</td>
                          <td>{{ item.nomPersonne }}</td>
                          <td>{{ item.Date | formatDate}}</td>
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
  
        title: "Liste des Affectations",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
  
        svData: {
          id: '',
          refClient: this.$route.params.id,
          refPersonne:0,
          Date: "",
          nomClient: "",
          nomPersonne: "",
  
        },
        fetchData: [],
        clientList: [],
        personneList: [],
        don:[],
        query: "",
  
      }
    },
    created() {
      this.getRouteParam();
      this.fetchDataList();
      //this.fetchListSelection();
      this.fetchListSelectionP();
      
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
  
            this.insertOrUpdate(
              `${this.apiBaseURL}/a1/update_affectation/${this.svData.id}`,
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
  
            this.insertOrUpdate(
              `${this.apiBaseURL}/a1/insert_affectation`,
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
  
      // searchMember: _.debounce(function () {
      //   this.fetchDataList();
      // }, 300),
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_single_affectation/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.refClient = item.refClient;
              this.svData.refPersonne = item.refPersonne;
              this.svData.nomClient = item.nomClient;
              this.svData.nomPersonne = item.nomPersonne;
              this.svData.Date = item.Date;
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/a1/delete_affectation/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        var id = this.$route.params.id;
        this.refClient = id;
        this.fetch_data(`${this.apiBaseURL}/a1/fetch_client_affectation/${this.refClient}?page=`);
        
      },
  
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_list_client`).then(
          ({ data }) => {
            var donnees = data.data;
            this.clientList = donnees;
          }
        );
      },

      fetchListSelectionP() {
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_list_personne`).then(
          ({ data }) => {
            var donnees = data.data;
            this.personneList = donnees;
          }
        );
      },

      getRouteParam()
      {
        var id = this.$route.params.id;
        this.refClient = id;
      } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  