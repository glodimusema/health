<template>




<v-row justify="center">

  <DetailConsommationOpe ref="DetailConsommationOpe" />
  <DetailConsActes ref="DetailConsActes" />

<!--  -->

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
              <v-dialog v-model="dialog" max-width="1000px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Entete Chirurgie <v-spacer></v-spacer>
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
                                  <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.SalleList" item-text="nom_salle"
                                  item-value="id" dense outlined v-model="svData.refSalle" chips clearable
                                  @change="getLit(svData.refSalle)">
                                  </v-autocomplete>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez le Lit" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.LitList" item-text="nom_lit"
                                  item-value="id" dense outlined v-model="svData.refLit" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Services" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList" item-text="nom_uniteproduction"
                                  item-value="id" dense outlined v-model="svData.refServiceHopital" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>

                          
                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Type Intervention" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.InterventionList" item-text="nom_intervention"
                                  item-value="id" dense outlined v-model="svData.refIntervention" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field type="date" label="Date Intervention" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateIntervension">
                          </v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez l'Infirmier" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin" item-value="noms_medecin" dense
                            outlined v-model="svData.infirmier" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex> 
                      
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Chirurgien" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin" item-value="noms_medecin" dense
                            outlined v-model="svData.chirurgien" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez l'Anesthesiste " prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin" item-value="noms_medecin" dense
                            outlined v-model="svData.anesthesiste" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>            


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Diagnostic Opératoire" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.diagnosticOpe">
                          </v-textarea>
                        </div>
                      </v-flex>   

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Prise en Charge" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.priseenCharge">
                          </v-textarea>
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
                        <span>Ajouter Chirurgie</span>
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
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">Date</th> 
                              <th class="text-left">Chirurgien</th>
                              <th class="text-left">Anesthesiste</th>                                                                    
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateIntervension }}</td>
                              <td>{{ item.chirurgien }}</td>
                              <td>{{ item.anesthesiste }}</td>
                              <td>


                                <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>
                                                          
                              <v-list dense width="">

                                <v-list-item link @click="showDetailConsommationMed(item.id,item.noms)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-invert-colors</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Détail Consommation
                                    </v-list-item-title>
                                  </v-list-item>

                                  <v-list-item link @click="showDetailActes(item.id,item.noms)">
                                    <v-list-item-icon>
                                      <v-icon>mdi-invert-colors</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Les Actes posés
                                    </v-list-item-title>
                                  </v-list-item>

                                <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                  <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
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
import DetailConsActes from './DetailConsActes.vue';
import DetailConsommationOpe from './DetailConsommationOpe.vue';

export default {
  components: {
    DetailConsActes,
    DetailConsommationOpe
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,

      etatModal: false,
      titleComponent: '',
      refEnteteOpe: 0, 

      svData: {
        id: '',
        refEnteteOpe: 0,
        refIntervention:0,
        refServiceHopital:0,   
        refSalle:0,
        refLit:0,       
        dateIntervension:"",
        chirurgien:"", 
        infirmier:"",
        anesthesiste:"",
        diagnosticOpe:"",              
        priseenCharge:"",        
        author:"" 
      },
      fetchData: [],
      listeMedecin: [],
      don:[],
      query: "",
      stataData: {
        ServiceList: [],
        SalleList: [],
        LitList: [],
        InterventionList: []          
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
  
    }
  },
  created() {
    
    // this.fetchDataList();   
    // this.fetchListmedecin(); 
    // this.fetchListSalle(); 
    // this.fetchListIntervention(); 
    // this.fetchListServices();  
      
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
          this.svData.refEnteteOpe= this.refEnteteOpe;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_enteteconsomationope/${this.svData.id}`,
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
          this.svData.refEnteteOpe= this.refEnteteOpe;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_enteteconsomationope`,
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
    
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.listeMedecin = donnees;
        }
      );
    },
    //
    fetchListIntervention() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tope_intervention_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.InterventionList = donnees;
        }
      );
    },      
    fetchListSalle() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_salle_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.SalleList = donnees;

        }
      );
    },  
    getLit(refSalle) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_lit_Salle2/${refSalle}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.LitList = donnees;

        }
      );
    },      
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },  
    
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },
  //   'id','refEnteteOpe','dateIntervension','diagnosticOpe','anesthesiste','chirurgien',
    // 'assistant','infirmier','priseenCharge','perteSanguine','Complication',
    //'instructionPrescription',
    // 'author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteconsomationope/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
            this.svData.id = item.id;
            this.svData.refEnteteOpe = item.refEnteteOpe;
            this.svData.dateIntervension = item.dateIntervension;
            this.svData.diagnosticOpe = item.diagnosticOpe;
            this.svData.anesthesiste = item.anesthesiste;
            this.svData.chirurgien = item.chirurgien;
            this.svData.assistant = item.assistant;
            this.svData.infirmier = item.infirmier;
            this.svData.priseenCharge = item.priseenCharge;
            this.svData.author = item.author;                          
          });
          this.edit = true;
          this.dialog = true;
         }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteconsomationope/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_consomation_enteteoperation/${this.refEnteteOpe}?page=`);
      
    },
    showDetailConsommationMed(refEnteteConso, name) {

      //<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

      if (refEnteteConso != '') {

        this.$refs.DetailConsommationOpe.$data.etatModal = true;
        this.$refs.DetailConsommationOpe.$data.refEnteteConso = refEnteteConso;
        this.$refs.DetailConsommationOpe.$data.svData.refEnteteConso = refEnteteConso;
        this.$refs.DetailConsommationOpe.fetchDataList();
        this.$refs.DetailConsommationOpe.fetchListSelection();    
        this.fetchDataList();
        
        this.$refs.DetailConsommationOpe.$data.titleComponent =
          "Detail Consommation en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showDetailActes(refEnteteConso, name) {

      //<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

      if (refEnteteConso != '') {

        this.$refs.DetailConsActes.$data.etatModal = true;
        this.$refs.DetailConsActes.$data.refEnteteConso = refEnteteConso;
        this.$refs.DetailConsActes.$data.svData.refEnteteConso = refEnteteConso;
        this.$refs.DetailConsActes.fetchDataList();
        this.$refs.DetailConsActes.fetchListSelection();    
        this.fetchDataList();
        
        this.$refs.DetailConsActes.$data.titleComponent =
          "Detail des Actes en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>

