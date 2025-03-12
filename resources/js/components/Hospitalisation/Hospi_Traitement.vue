<template>
   <v-row justify="center">

    <Hospi_DetailMedicamentTraitement ref="Hospi_DetailMedicamentTraitement" />
    <Hospi_DetailActeTraitement ref="Hospi_DetailActeTraitement" />

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
              <v-dialog v-model="dialog" max-width="600px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Traitements <v-spacer></v-spacer>
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

                        <v-textarea label="Kiné" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.kine"></v-textarea>

                        <v-textarea label="Alimentation" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.alimentation"></v-textarea>

                        <v-textarea label="Observation" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.observation"></v-textarea>
                    
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','kine2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">Satisfaction</th>
                              <th class="text-left">Remarque</th>
                              <th class="text-left">Suggestion</th>
                              <th class="text-left">author</th>                                                                                         
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.kine }}</td>
                              <td>{{ item.alimentation }}</td>
                              <td>{{ item.observation }}</td>
                              <td>{{ item.author }}</td>
                          <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>
                            
                              <v-list dense width="">

                                <v-list-item link @click="showDetailMedicament(item.id,item.noms,item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon>mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Les Medicaments
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showDetailActes(item.id,item.noms,item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon>mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Les Actes
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
 import Hospi_DetailActeTraitement from './Hospi_DetailActeTraitement.vue';
 import Hospi_DetailMedicamentTraitement from './Hospi_DetailMedicamentTraitement.vue';

  export default {
    components: {
      Hospi_DetailActeTraitement,
      Hospi_DetailMedicamentTraitement
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
        refHospi: 0, 

        svData: {
          id: '',
          refHospi: 0,          
          kine:"",
          alimentation:"",
          observation:"",
          author:"", 
        },
        fetchData: [],
        don:[],
        query: ""
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
            this.svData.refHospi= this.refHospi;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_traitement_hospi/${this.svData.id}`,
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
            this.svData.refHospi= this.refHospi;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_traitement_hospi`,
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
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_traitement_hospi/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refHospi = item.refHospi;
              this.svData.kine = item.kine;
              this.svData.alimentation = item.alimentation;
              this.svData.observation = item.observation;
              this.svData.author = item.author;                          
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_traitement_hospi/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_traitement_hospie/${this.refHospi}?page=`);
        //
      },
    showDetailMedicament(refTraitem, name,refMouvement) {

        if (refTraitem != '') {

          this.$refs.Hospi_DetailMedicamentTraitement.$data.etatModal = true;
          this.$refs.Hospi_DetailMedicamentTraitement.$data.refTraitem = refTraitem;
          this.$refs.Hospi_DetailMedicamentTraitement.$data.svData.refTraitem = refTraitem;
          this.$refs.Hospi_DetailMedicamentTraitement.fetchDataList();
          this.$refs.Hospi_DetailMedicamentTraitement.fetchListSelection();
          this.$refs.Hospi_DetailMedicamentTraitement.showDataMedcin(refMouvement)
          this.fetchDataList();
          
          this.$refs.Hospi_DetailMedicamentTraitement.$data.titleComponent =
            "Traitement en Hopitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showDetailActes(refTraitem, name,refMouvement) {

        if (refTraitem != '') {

          this.$refs.Hospi_DetailActeTraitement.$data.etatModal = true;
          this.$refs.Hospi_DetailActeTraitement.$data.refTraitem = refTraitem;
          this.$refs.Hospi_DetailActeTraitement.$data.svData.refTraitem = refTraitem;
          this.$refs.Hospi_DetailActeTraitement.fetchDataList();
          this.$refs.Hospi_DetailActeTraitement.fetchListSelection();
          this.$refs.Hospi_DetailActeTraitement.showDataMedcin(refMouvement)
          this.fetchDataList();
          
          this.$refs.Hospi_DetailActeTraitement.$data.titleComponent =
            "Actes en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }
      }
  
    },
    filters: {
  
    }
  }
  </script>
  
  