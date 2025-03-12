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
                      Sortie Hospitalisation <v-spacer></v-spacer>
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
                            <v-text-field type="date" label="Date Sortie" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dateSortie"></v-text-field> 
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">                            
                            <v-text-field label="Heure de Sortie" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.heureSortieHosp"></v-text-field> 
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Diagnostique à la Sortie" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.diagnosticSortie">
                              </v-textarea>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Autres details" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.autreDetails">
                              </v-textarea>
                            </div>
                          </v-flex>  



                          <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Traitant" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList1" item-text="noms_medecin"
                              item-value="id" dense outlined v-model="svData.refMedecin1" chips clearable
                              @change="getSpecialiteMedecin1(svData.refMedecin1)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Medecin Intervenant N°1" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medecin1">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin N°1" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite1">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM Medecin N°1" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cnom1">
                            </v-text-field>
                          </div>
                        </v-flex>





                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin pour le Rendez-vous" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList1" item-text="noms_medecin"
                              item-value="id" dense outlined v-model="svData.refMedecin2" chips clearable
                              @change="getSpecialiteMedecin2(svData.refMedecin2)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Medecin Intervenant N°2" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medecin2">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin N°2" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite2">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM Medecin N°2" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cnom2">
                            </v-text-field>
                          </div>
                        </v-flex>





                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez un autre Medecin Intervenant" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList1" item-text="noms_medecin"
                              item-value="id" dense outlined v-model="svData.refMedecin3" chips clearable
                              @change="getSpecialiteMedecin3(svData.refMedecin3)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Medecin Intervenant N°3" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medecin3">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin N°3" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite3">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM Medecin N°3" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cnom3">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">                            
                            <v-text-field label="Date Rendez-vous" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dateRDV"></v-text-field> 
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
                        <span>Ajouter Diagnostics</span>
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
                              <th class="text-left">DateEntree</th>
                              <th class="text-left">DateSortie</th> 
                              <th class="text-left">NbrJours</th>                                    
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateEntree | formatDate }}</td>
                              <td>{{ item.dateSortie | formatDate }}</td>
                              <td>{{ item.NombreJour }}</td>                 
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
                            
                                <!-- <v-list-item link  @click="printBill(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Bon de Sortie Hospitalisation</v-list-item-title>
                                </v-list-item>  -->
                            
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
//  //'id','refHospitaliser','dateSortie','diagnosticSortie','autreDetails','author'
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false, 
      
      etatModal: false,
      titleComponent: '',
      refHospitaliser: 0, 
      svData: {
        id: '',
        refHospitaliser: 0,          
        dateSortie:"",
        diagnosticSortie:"",
        autreDetails:"",
        medecin1:"",
        specialite1:"",
        cnom1:"",
        medecin2:"",
        specialite2:"",
        cnom2:"",
        medecin3:"",
        specialite3:"",
        cnom3:"",
        dateRDV:"",
        heureSortieHosp:"",
        author:"",


        refMedecin1:0,
        refMedecin2:0,
        refMedecin3:0,
      },
      fetchData: [],
      don:[],
      query: "",
      medecinList1: [],
      medecinList2: [],
      medecinList3: [],
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''     
  
    }
  },
  created() {
    this.fetchDataList();
    this.fetchListSelection1();
     
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
          this.svData.refHospitaliser= this.refHospitaliser;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_sortiehospitaliser/${this.svData.id}`,
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
          this.svData.refHospitaliser= this.refHospitaliser;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_sortiehospitaliser`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              //this.dialog = false;
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
      window.open(`${this.apiBaseURL}/pdf_billesortiehospitalisation_data?id=` + id);
    },
 
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_sortiehospitaliser/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
            this.svData.id = item.id;
            this.svData.refHospitaliser = item.refHospitaliser;
            this.svData.dateSortie = item.dateSortie;
            this.svData.diagnosticSortie = item.diagnosticSortie;
            this.svData.autreDetails = item.autreDetails;
            this.svData.medecin1= item.medecin1;
            this.svData.specialite1= item.specialite1;
            this.svData.cnom1= item.cnom1;
            this.svData.medecin2= item.medecin2;
            this.svData.specialite2= item.specialite2;
            this.svData.cnom2= item.cnom2;
            this.svData.medecin3= item.medecin3;
            this.svData.specialite3= item.specialite3;
            this.svData.cnom3= item.cnom3;
            this.svData.dateRDV= item.dateRDV;
            this.svData.heureSortieHosp= item.heureSortieHosp;                          
          });
          //getLit(this.svData.refSalle);
          this.edit = true;
          this.dialog = true;
         }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_sortiehospitaliser/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
     this.fetch_data(`${this.apiBaseURL}/fetch_sortie_hospitaliser/${this.refHospitaliser}?page=`);
      
    },

  fetchListSelection1() {
    this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
      ({ data }) => {
        var donnees = data.data;
              this.medecinList1 = donnees;

            }
          );

      },

      getSpecialiteMedecin1(idMedecin) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.svData.medecin1 = item.noms_medecin;
              this.svData.specialite1 = item.specialite_medecin;
              this.svData.cnom1 = item.matricule_medecin;

            });

          }
        );
      },

      getSpecialiteMedecin2(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
      ({ data }) => {
        var donnees = data.data;

        donnees.map((item) => {
          this.svData.medecin2 = item.noms_medecin;
          this.svData.specialite2 = item.specialite_medecin;
          this.svData.cnom2 = item.matricule_medecin;

        });

      }
      );
      },

      getSpecialiteMedecin3(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.medecin3 = item.noms_medecin;
            this.svData.specialite3 = item.specialite_medecin;
            this.svData.cnom3 = item.matricule_medecin;

          });

        }
      );
      }


  },
  filters: {

  }
}
</script>

