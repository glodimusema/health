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
              <v-dialog v-model="dialog" max-width="1000px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Detail Surveillance Anesthesie <v-spacer></v-spacer>
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
                                  <v-autocomplete label="Selectionnez Rubrique de Surveillance" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.RubriqueList" item-text="nom_rubliquesurv"
                                  item-value="id" dense outlined v-model="svData.refRubrique" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Libre" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libres">
                          </v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Encombnre" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.encombres">
                          </v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Ample Regulière" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ampleERugiliere">
                          </v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Disphée" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.disphee">
                          </v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Lucide" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.lucide">
                          </v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Narcose" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.marcose">
                          </v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Propre" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.propre">
                          </v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Souille" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.souille">
                          </v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Normale" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.normale">
                          </v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Non Retablie" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nonretablie">
                          </v-text-field>
                        </div>
                      </v-flex>
                                
                    
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Observation" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.observationSurv">
                          </v-textarea>
                        </div>
                      </v-flex>  
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Observation1" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.Observe1">
                          </v-textarea>
                        </div>
                      </v-flex>  
                      
                      
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Observation2" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.Observe2">
                          </v-textarea>
                        </div>
                      </v-flex>  
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-textarea label="Observation3" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            v-model="svData.Observe3">
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
                              <td>{{ item.libres }}</td>
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
      refEnteteSurv: 0, 

      svData: {
        id: '',
        refEnteteSurv: 0,
        refRubrique:0,               
        libres:"",
        encombres:"",
        ampleERugiliere:"",        
        disphee:"",
        lucide:"",
        marcose:"",
        propre:"",
        souille:"",
        normale:"",
        nonretablie:"",              
        observationSurv:"",
        Observe1:"",
        Observe2:"",
        Observe3:"",        
        author:"" 
      },
      fetchData: [],
      listeMedecin: [],
      don:[],
      query: "",
      stataData: {
        RubriqueList: []      
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
  
    }
  },
  created() {
    // this.fetchDataList();    
    // this.fetchListRubriques();  
      
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
          this.svData.refEnteteSurv= this.refEnteteSurv;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_detailsurveillance/${this.svData.id}`,
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
          this.svData.refEnteteSurv= this.refEnteteSurv;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detailsurveillance`,
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
    fetchListRubriques() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tope_rubriquesurveillance_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.RubriqueList = donnees;

        }
      );
    },  
    
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },
  //   'id','refEnteteSurv','libres','disphee','anesthesiste','chirurgien',
    // 'assistant','infirmierSalle','observationSurv','perteSanguine','Complication',
    //'instructionPrescription',
    // 'author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailsurveillance/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
            this.svData.id = item.id;
            this.svData.refEnteteSurv = item.refEnteteSurv;
            this.svData.refRubrique= item.refRubrique;              
            this.svData.libres= item.libres;
            this.svData.encombres= item.encombres;
            this.svData.ampleERugiliere= item.ampleERugiliere;        
            this.svData.disphee= item.disphee;
            this.svData.lucide= item.lucide;
            this.svData.marcose= item.marcose;
            this.svData.propre= item.propre;
            this.svData.souille= item.souille;
            this.svData.normale= item.normale;
            this.svData.nonretablie= item.nonretablie;              
            this.svData.observationSurv= item.observationSurv;
            this.svData.Observe1= item.Observe1;
            this.svData.Observe2= item.Observe2;
            this.svData.Observe3= item.Observe3;
            this.svData.author = item.author;                          
          });
          this.edit = true;
          this.dialog = true;
         }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detailsurveillance/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
     this.fetch_data(`${this.apiBaseURL}/fetch_detail_entetesurveillance/${this.refEnteteSurv}?page=`);
      
    }


  },
  filters: {

  }
}
</script>

