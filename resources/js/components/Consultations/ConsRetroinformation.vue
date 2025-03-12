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
                <!--   -->
                <v-flex md12>
                  <v-dialog v-model="dialog" max-width="1200px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Fiche de Retro-Information <v-spacer></v-spacer>
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
    
                          <v-layout row wrap>

                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date d'arrivée" prepend-inner-icon="draw" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_arrivee">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Heure d'arrivée" prepend-inner-icon="draw" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heure_arrivee">
                                </v-text-field>
                              </div>
                            </v-flex>


    
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-textarea label="Diagnostic retenu" prepend-inner-icon="draw" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnostic_retenu">
                                </v-textarea>
                              </div>
                            </v-flex>    
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-textarea type="textarea" label="Traitement reçu" prepend-inner-icon="draw" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.traitement_retenu">
                                </v-textarea>
                              </div>
                            </v-flex>


    
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-textarea type="textarea" label="Modalité de sortie"
                                  prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                  v-model="svData.modalite_sortie">
                                </v-textarea>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-textarea type="textarea" label="Recommandations et suggestions" prepend-inner-icon="draw" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.recommandations">
                                </v-textarea>
                              </div>
                            </v-flex>
    
    
    
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date de retro-Information" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_retro">
                                </v-text-field>
                              </div>
                            </v-flex>
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Hopital" prepend-inner-icon="event" dense
                                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.hopitals">
                                </v-text-field>
                              </div>
                            </v-flex>

    
   
                          </v-layout>
    
    
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
                            <span>Ajouter Infromation</span>
                          </v-tooltip>
                        </v-flex>
                      </v-layout>
                      <br />
                      <v-card>
                        <!-- ,'ValeurNormale2','observation2' -->
                        <v-card-text>
                          <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <tr>
                                  <th class="text-left">Action</th>
                                  <th class="text-left">Malade</th>
                                  <th class="text-left">Sexe</th>
                                  <th class="text-left">Age</th>
                                  <th class="text-left">DateArrivéé</th>
                                  <th class="text-left">DateRetro</th>
                                  <th class="text-left">Hopital</th>
                                  
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
    
                                        <v-list-item link @click="printBill(item.id)">
                                            <v-list-item-icon>
                                              <v-icon color="#B72C2C">print</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Voir la Fiche de Retro-Infromation</v-list-item-title>
                                        </v-list-item>
    
                                        <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>
    
                                        <v-list-item  v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                        </v-list-item>  

    
                                      </v-list>
                                    </v-menu>
    
                                  </td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.sexe_malade }}</td>
                                  <td>{{ item.age_malade }}</td>
                                  <td>{{ item.date_arrivee }} : {{ item.date_arrivee }}</td>
                                  <td>{{ item.date_retro }} </td>
                                  <td>{{ item.hopitals }}</td>

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
          refDetailCons: 0,

          ////id,refDetailCons,date_arrivee,heure_arrivee,diagnostic_retenu,
          //traitement_retenu,modalite_sortie,recommandations,date_retro,hopitals,author
          svData: {
            id: '',
            refDetailCons: 0,
            date_arrivee:'',
            heure_arrivee:'',
            diagnostic_retenu: "",
            traitement_retenu: "",
            modalite_sortie: "",
            recommandations: "",
            date_retro: "",
            hopitals:'',
            author: "",
    
            refMedecin:0,
    
            refPatient: "",
            Hopital:"",
            idHopital:1
          },
          fetchData: [],
          medecinList: [],
          don: [],
          query: "",
          inserer:'',
          modifier:'',
          supprimer:'',
          chargement:'',
    
    
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
    
        validate() {
          if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
              this.svData.refDetailCons = this.refDetailCons;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_retroinformation/${this.svData.id}`,
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
              this.svData.refDetailCons = this.refDetailCons;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_retroinformation`,
                JSON.stringify(this.svData)
              )
                .then(({ data }) => {
                  this.showMsg(data.data);
    
                  // this.validate2();
    
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
        fetchListSelection() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
            ({ data }) => {
              var donnees = data.data;
              this.medecinList = donnees;
    
            }
          );
    
        },
    
        getSpecialiteMedecin(idMedecin) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
            ({ data }) => {
              var donnees = data.data;
    
              donnees.map((item) => {
                this.svData.medecin_transfert = item.noms_medecin;
                this.svData.specialite_transfert = item.specialiteecin;
                this.svData.cnom_transfert = item.matricule_medecin;
    
              });
    
            }
          );
        },    
    
        printBill(id) {
          window.open(`${this.apiBaseURL}/pdf_retroinformation_data?id=` + id);
        },
    
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/fetch_single_retroinformation/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
  
            donnees.map((item) => {
              this.titleComponent = "Modification des données";
            });
  
            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
          }
        );
       },
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_retroinformation/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
        fetchDataList() {
          this.fetch_data(`${this.apiBaseURL}/fetch_retroinformation_cons/${this.refDetailCons}?page=`);
          //
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
      
      