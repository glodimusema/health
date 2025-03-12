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
              <v-dialog v-model="dialog" max-width="800px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Vaccination Enfant <v-spacer></v-spacer>
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
                                  <v-autocomplete label="Selectionnez la Période" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.PeriodeList" item-text="name_periode"
                                  item-value="id" dense outlined v-model="svData.refPeriode" chips clearable
                                  @change="getRendevous(svData.refPeriode)"
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly label="Alerte Rendez-vous" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.EtatRDV"></v-text-field>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field readonly type="date" label="Date Prévue" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.dateprevue"></v-text-field>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Reçu" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.dateRecu"></v-text-field>
                              </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Poids" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.poids"></v-text-field>
                              </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field type="number" label="Taille" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.taille"></v-text-field>
                              </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez la Strategie" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.StrategieList" item-text="name_strategie"
                                  item-value="id" dense outlined v-model="svData.refStrategie" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez le mode d'Atteinte" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ModeAtteinteList" item-text="name_mode"
                                  item-value="id" dense outlined v-model="svData.refModeAtteinte" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-textarea label="Observations" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.observation"></v-textarea>
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
                        <span>Ajouter Vaccication</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','nombrejourretard' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Patient</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">Periode</th> 
                              <th class="text-left">Vaccin</th>
                              <th class="text-left">DatePrevue</th>
                              <th class="text-left">DateRecu</th> 
                              <th class="text-left">Poids</th> 
                              <!-- <th class="text-left">Retard</th>                                                                    -->
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.name_periode }}</td>
                              <td>{{ item.name_vaccin }}</td>
                              <td>{{ item.dateprevue }}</td>
                              <td>{{ item.dateRecu }}</td>
                              <!-- <td>{{ item.poids }}KG</td>  -->
                              <td>{{ item.nombrejourretard }}Jours</td>                             
                              <td>

                                <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>
                            
                              <v-list dense width="">

                                <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                  <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id,item.refEnteteVac,item.refPeriode)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">delete</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
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
        refEnteteVac: 0, 

        //id,refEnteteVac,refPeriode,refStrategie,refModeAtteinte,dateprevue,dateRecu,poids,observation,taille,author

        svData: {
          id: '',
          refEnteteVac: 0,          
          refPeriode:"",
          refStrategie:0,
          refModeAtteinte:0,
          dateprevue:"",
          dateRecu:"",
          poids:0,
          observation:"",
          taille:0,

          EtatRDV:"",
          TestRDV:"",
          Testdateprevue:"",
          author:""
        },
        fetchData: [],
        don:[],
        query: "",
        stataData: {
          PeriodeList: [], 
          StrategieList: [], 
          ModeAtteinteList: [],        
        },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
    
      }
    },
    created() {
      // this.fetchDataList();
      // this.fetchListPeriode();
      // this.fetchListStrategie();
      // this.fetchListModeAtteinte();
         
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
            this.svData.refEnteteVac= this.refEnteteVac;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_vaccinationEnfant/${this.svData.id}`,
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
            this.svData.refEnteteVac= this.refEnteteVac;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_vaccinationEnfant`,
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
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_vaccinationEnfant/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refEnteteVac = item.refEnteteVac;
              this.svData.refPeriode = item.refPeriode;  
              this.svData.refStrategie= item.refStrategie
              this.svData.refModeAtteinte= item.refModeAtteinte
              this.svData.dateprevue= item.dateprevue
              this.svData.dateRecu= item.dateRecu
              this.svData.poids = item.poids;
              this.svData.observation= item.observation;
              this.svData.taille= item.taille;
              this.svData.author = item.author;                        
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id,refEnteteVac,refPeriode) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_vaccinationEnfant?id=${id}&refEnteteVac=${refEnteteVac}&refPeriode=${refPeriode}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_vacination_enfant_entete/${this.refEnteteVac}?page=`);
        
      },      
      fetchListPeriode() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_periode_vac_enfant2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.PeriodeList = donnees;

          }
        );
      },      
      fetchListStrategie() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_strategie_vac_enfant2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.StrategieList = donnees;

          }
        );
      },      
      fetchListModeAtteinte() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_mode_vac_enfant2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.ModeAtteinteList = donnees;

          }
        );
      },
      

    getRendevous(refPeriode) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_rdv_patient?refEntete=${this.refEnteteVac}&refPeriode=${refPeriode}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {            
            this.svData.Testdateprevue = item.dateRdv;
            this.svData.TestRDV = item.etatRdv;
          });
          if(this.svData.TestRDV == 1)
          {
            this.svData.EtatRDV="L'enfant a déja reçu ce vaccin svp";
            this.showError("L'enfant a déja reçu ce vaccin svp");            
          }
          else
          {
            this.svData.dateprevue=this.svData.Testdateprevue;
            this.svData.EtatRDV="Enfant peut recevoir ce vaccin";
          }

        }
      );
    }
  
      // this.fetchListStrategie();
      // this.fetchListModeAtteinte();
  
    },
    filters: {
  
    }
  }
  </script>
  
  