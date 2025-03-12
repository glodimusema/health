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
            <!--   -->
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Details Laboratoire <v-spacer></v-spacer>
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
                      
                      <v-autocomplete label="Selectionnez la Valeur Normale" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ValeurList" item-text="designation" item-value="id" dense
                        outlined v-model="svData.refValeur" chips clearable>
                      </v-autocomplete>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Résultat" prepend-inner-icon="extension"  dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.libelle"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez la Methode Utilisée" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.MethodeList" item-text="designation"
                                  item-value="designation" dense outlined v-model="svData.methode" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez la Nature des Echantillons" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.NatureList" item-text="designation"
                                  item-value="designation" dense outlined v-model="svData.natureechantillon" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>
                      
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Observation" :items="[
                                  { designation: 'POSITIF' }, 
                                  { designation: 'NEGATIF' }         
                                  ]" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation" item-value="designation"
                            v-model="svData.observation"></v-select>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Commentaire" prepend-inner-icon="extension" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.commentaire"></v-text-field>
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
                  <v-card :loading="loading" :disabled="loading">
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Action</th>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Observation</th>
                              <th class="text-left">Echantillon</th>
                              <th class="text-left">GrandCatégorie</th>                              
                              <th class="text-left">Catégorie</th>
                              <th class="text-left">Examen</th>
                              <th class="text-left">Resultat</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
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

                              <v-tooltip top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="printBill(item.refMouvement)" fab small
                                    ><v-icon color="blue">print</v-icon></v-btn
                                  >
                                </span>
                              </template>
                              <span>Imprimer Bon</span>
                            </v-tooltip>
                              
                              </td>
                              <td>{{ item.noms }}</td>
                              <td>{{ item.age_malade }}</td>
                              
                              <td>{{ item.libelle }}</td>
                              <td>{{ item.natureechantillon }}</td>
                              <td>{{ item.designationGCatEx }}</td>
                              <td>{{ item.designationCatEx }}</td>
                              <td>{{ item.designationEx }}</td>  
                              <td>{{ item.Valeurnormale }}</td>

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
        refEnteteLabo: 0,
        //refEnteteLabo,refValeur,libelle,observation,author
        svData: {
          id: '',
          refEnteteLabo: 0,
          refValeur:0,          
          author:"Admin",
          libelle: "",
          observation: "",
          refExamen:0,
          natureechantillon:"",
          methode:"",
          commentaire:""
        },
        fetchData: [],        
        ValeurList: [],
        NatureList: [],
        MethodeList: [],
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
      // this.get_methode_Examen();
      // this.get_nature_Echantillon();          
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"])
      ,   
      showData(id) {        
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoireext/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEnteteLabo = item.id; 
              this.svData.refExamen = item.refExamen;             
            });             
            this.get_valeur_for_Examen(this.svData.refExamen); 
            this.dialog2 = true;
            //console.log('IdExamen = '+this.svData.refExamen);
           
           }
        );
      },
      async get_valeur_for_Examen(refExamen) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_ValeurForExam/${refExamen}`)
              .then((res) => {
              var chart = res.data.data;              
              if (chart) {
                  this.ValeurList = chart;
              } else {
                  this.ValeurList = [];
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

              //   console.log(this.stataData.car_optionList);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      }
      ,
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.refEnteteLabo=this.refEnteteLabo;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_detaillaboratoireext/${this.svData.id}`,
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
            this.svData.refEnteteLabo=this.refEnteteLabo;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_detaillaboratoireext`,
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
  
      // s'id','refEnteteLabo','refValeur','puEntree','qteEntree','author'
      //   this.fetchDataList();
      // }, 300),
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_detaillaboratoireext/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refEnteteLabo = item.refEnteteLabo;
              this.svData.refValeur = item.refValeur;
              this.svData.libelle = item.libelle;              
              this.svData.observation = item.observation;    
              this.svData.natureechantillon = item.natureechantillon; 
              this.svData.methode = item.methode; 
              this.svData.commentaire = item.commentaire;               
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_detaillaboratoireext/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_detail_entetelaboratoireext/${this.refEnteteLabo}?page=`);
        this.showData(this.refEnteteLabo); 
        
      }
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  