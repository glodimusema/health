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
                          Details Informations <v-spacer></v-spacer>
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
    
   
                          <v-autocomplete label="Selectionnez le Medicament" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="medicamentList" item-text="nom_medicament"
                            item-value="id" dense outlined v-model="svData.refmedicament" chips clearable
                           >
                          </v-autocomplete>
    
                          <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qte_usage">
                          </v-text-field>
    
                          <!-- <v-text-field type="number" label="Prix Unitaire ($)" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pu_usage">
                          </v-text-field> -->


                          <v-text-field label="Observation" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observation_usage">
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
                                  <th class="text-left">Action</th>
                                  <th class="text-left">Medicament</th>
                                  <th class="text-left">Quantité</th>
                                  <th class="text-left">Observation</th>                                  
                                  <th class="text-left">N°EB</th>
                                  <th class="text-left">Patient</th>
                                  <th class="text-left">DateUsage</th>
                                  
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">
                                  <td>
                                    <!-- <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="editData(item.id)" fab small>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-btn>
                                        </span>
                                      </template>
                                      <span>Modifier</span>
                                    </v-tooltip> -->
    
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
    
                                    <v-tooltip top color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="printBill(item.refEnteteVente)" fab small
                                        ><v-icon color="blue">print</v-icon></v-btn
                                      >
                                    </span>
                                  </template>
                                  <span>Imprimer Facture</span>
                                </v-tooltip>
    
                                  </td>
                                  <td>{{ item.nom_medicament }}</td>
                                  <td>{{ item.qte_usage }}</td>
                                  <td>{{ item.observation_usage }}</td>
                                  <td>{{ item.refEnteteVente }}</td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.date_usage | formatDate }}</td>

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
          refEnteteVente: 0,
          ////tmed_detail_usageservice id,refEnteteVente,refmedicament,qte_usage,pu_usage,observation_usage,author
          svData: {
            id: '',
            refEnteteVente: 0,
            refmedicament: 0,
            qte_usage: 0,
            pu_usage: 0,            
            observation_usage:'',
            author: "",
    // 
          },
          fetchData: [],
          medicamentList: [],
          don: [],
          query: "",
            
          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:'' 
    
        }
      },
      created() {
         
        // this.fetchDataList();
        // this.fetchListSelection();
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
              this.svData.refEnteteVente = this.refEnteteVente;
              this.svData.author = this.userData.name;
              this.svData.pu_usage=0;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_detail_usage_service/${this.svData.id}`,
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
              this.svData.refEnteteVente = this.refEnteteVente;
              this.svData.author = this.userData.name;
              this.svData.pu_usage=0;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_detail_usage_service`,
                JSON.stringify(this.svData)
              )
                .then(({ data }) => {
                  this.showMsg(data.data);
                  this.isLoading(false);
                  this.edit = false;
                  // this.dialog = false;
                  this.resetObj(this.svData);
                  this.fetchDataList();
                })
                .catch((err) => {
                  this.svErr(), this.isLoading(false);
                });
            }
    
          }
        },
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_usageservices_data?id=` + id);
        },
    
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_detail_usage_service/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.id = item.id;
                this.svData.refEnteteVente = item.refEnteteVente;
                this.svData.refmedicament = item.refmedicament;
                this.svData.pu_usage = item.pu_usage;
                this.svData.qte_usage = item.qte_usage;
                this.svData.observation_usage = item.observation_usage;
              });
    
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_detail_usage_service/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_detail_entete_usage_service/${this.refEnteteVente}?page=`);
    
        },
    
        fetchListSelection() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_list_medicament2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.medicamentList = donnees;
            }
          );
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
    
    