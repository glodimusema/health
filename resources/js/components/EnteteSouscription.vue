<template>
    
   
    <v-layout>
         
        <v-flex md12>
          <v-dialog v-model="dialog" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Création Facture <v-spacer></v-spacer>
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
                   
                  <v-text-field type="date" label="Date Souscription" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSous">
                  </v-text-field>

                  <v-text-field type="date" label="Date Execution" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateExecution">
                  </v-text-field>

                  <v-text-field
                    label="Exécutant"
                    prepend-inner-icon="extension"
                    :rules="[(v) => !!v || 'Ce champ est requis']"
                    outlined
                    v-model="svData.Executant"
                  ></v-text-field>

  
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
            <!--   -->
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
                    <span>Ajouter une Souscription</span>
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
                          <th class="text-left">N° Sous.</th>  
                          <th class="text-left">Client</th>
                          <th class="text-left">Téléphone</th>
                          <th class="text-left">Date Sous.</th>
                          <th class="text-left">Date Execution</th>
                          <th class="text-left">Executant</th>
                          <th class="text-left">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in fetchData" :key="item.id">
                          <td>{{ item.id }}</td>
                          <td>{{ item.noms }}</td>
                          <td>{{ item.contact }}</td>
                          <td>{{ item.dateSous | formatDate}}</td>
                          <td>{{ item.dateExecution | formatDate}}</td>
                          <td>{{ item.Executant }}</td>
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

                            
                            <v-menu bottom rounded offset-y transition="scale-transition">
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on" small fab depressed text>
                                                            <v-icon>more_vert</v-icon>
                                                        </v-btn>
                                                    </template>

                                                    <v-list dense width="">
                                                        <v-list-item link
                                                            @click="showProfileModalclient(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon>description</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Detail Facture</v-list-item-title>
                                                        </v-list-item>


                                                        <v-list-item link @click="printBill(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon>print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">PDF Facture
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <v-divider></v-divider>
                                                        <v-subheader>Autres Details</v-subheader>
                                                        <v-divider></v-divider>

                                                        <v-list-item link
                                                            router :to="'/admin/detail_sous/'+item.id">
                                                            <v-list-item-icon>
                                                                <v-icon>mdi-cart-outline</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Detail Souscription
                                                            </v-list-item-title>
                                                        </v-list-item>
                                                        <!-- <v-list-item link
                                                            router :to="'/admin/paiement_vente/'+item.id">
                                                            <v-list-item-icon>
                                                                <v-icon>mdi-cash-100</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Paiement Facture
                                                            </v-list-item-title>
                                                        </v-list-item> -->

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
    
  </template>
  <script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    data() {
      return {
  
        title: "Liste des Souscriptions",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        //'noms','contact','mail'
        svData: {
          id: '',
          refClient: this.$route.params.id,
          dateSous: "",
          dateExecution: "",
          Executant: "",
          author: "Admin",
          noms: "",
          contact: ""
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
              `${this.apiBaseURL}/a1/fetch_entetesouscription/${this.svData.id}`,
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
              `${this.apiBaseURL}/a1/insert_entetesouscription`,
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
        this.editOrFetch(`${this.apiBaseURL}/a1/fetch_single_entetesouscription/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
  
              this.svData.id = item.id;
              this.svData.refClient = item.refClient;
              this.svData.dateSous = item.dateSous;
              this.svData.dateExecution = item.dateExecution;
              this.svData.Executant = item.Executant;
              this.svData.author = item.author;
              this.svData.noms = item.noms;
              this.svData.contact = item.contact;
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_facturesous_data?id=` + id);
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/a1/delete_entetesouscription/${id}`).then(
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
        this.fetch_data(`${this.apiBaseURL}/a1/fetch_entete_client/${this.refClient}?page=`);        
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
  
  