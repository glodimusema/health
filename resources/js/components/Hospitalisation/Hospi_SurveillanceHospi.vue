<template>
  
  

  <v-row justify="center">

    <Hospi_SurveilleDiabetique ref="Hospi_SurveilleDiabetique" />
    <Hospi_SurveilleSigneVitaux ref="Hospi_SurveilleSigneVitaux" />
    <Hospi_SurveilleTransfusion ref="Hospi_SurveilleTransfusion" />

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
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Surveillance Hospi <v-spacer></v-spacer>
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

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Medecin Assistant" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList" item-text="noms_medecin"
                            item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                            @change="getSpecialiteMedecin(svData.refMedecin)">
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field readonly label="Medecin Assistant" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medecinAssistant">
                          </v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_medecin">
                          </v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CNOM">
                          </v-text-field>
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','medecinAssistant2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">MedecinAssistant</th>                                                                                         
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.medecinAssistant }}</td>
                          <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>
                            
                              <v-list dense width="">

                              <v-list-item link @click="showSurveillanceSignesVitaux(item.id,item.noms)">
                                <v-list-item-icon>
                                  <v-icon>mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Signes vitaux
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showSurveillanceTransfusionnelle(item.id,item.noms)">
                                <v-list-item-icon>
                                  <v-icon>mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Transfusionnelle
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showSurveillanceDiabete(item.id,item.noms)">
                                <v-list-item-icon>
                                  <v-icon>mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Diabètique
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
  import Hospi_SurveilleDiabetique from './Hospi_SurveilleDiabetique.vue';
  import Hospi_SurveilleSigneVitaux from './Hospi_SurveilleSigneVitaux.vue';
  import Hospi_SurveilleTransfusion from './Hospi_SurveilleTransfusion.vue';


  export default {
    components: {
      Hospi_SurveilleDiabetique,
      Hospi_SurveilleSigneVitaux,
      Hospi_SurveilleTransfusion
  },

    data() {
      return {
  //
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
          medecinAssistant:"",
          author:"",
          refMedecin:0, 
          CNOM: "",
          specialite_medecin: '',
          fonction_medecin: '',
        },
        fetchData: [],
        don:[],
        query: "",
      stataData: {       
        medecinList: []
      },
      
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
            this.svData.refHospi= this.refHospi;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_surveillance_hospie/${this.svData.id}`,
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
              `${this.apiBaseURL}/insert_surveillance_hospie`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_surveillance_hospie/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refHospi = item.refHospi;
              this.svData.medecinAssistant = item.medecinAssistant;                          
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_surveillance_hospie/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_surveillance_for_hospie/${this.refHospi}?page=`);
        //
      },

      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.medecinList = donnees;

          }
        );
      },
      getSpecialiteMedecin(idMedecin) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.svData.medecinAssistant=item.noms_medecin;
              this.svData.specialite_medecin = item.specialite_medecin;
              this.svData.CNOM = item.matricule_medecin;
            });

          }
        );
      },
    showSurveillanceSignesVitaux(refSurvHospi, name) {

        if (refSurvHospi != '') {

          this.$refs.Hospi_SurveilleSigneVitaux.$data.etatModal = true;
          this.$refs.Hospi_SurveilleSigneVitaux.$data.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleSigneVitaux.$data.svData.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleSigneVitaux.fetchDataList();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveilleSigneVitaux.$data.titleComponent =
            "Surveillance des signes vitaux en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }
    },
    showSurveillanceTransfusionnelle(refSurvHospi, name) {

        if (refSurvHospi != '') {

          this.$refs.Hospi_SurveilleTransfusion.$data.etatModal = true;
          this.$refs.Hospi_SurveilleTransfusion.$data.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleTransfusion.$data.svData.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleTransfusion.fetchDataList();
          this.$refs.Hospi_SurveilleTransfusion.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveilleTransfusion.$data.titleComponent =
            "Surveillance Transfusionnelle en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showSurveillanceDiabete(refSurvHospi, name) {

        if (refSurvHospi != '') {

          this.$refs.Hospi_SurveilleDiabetique.$data.etatModal = true;
          this.$refs.Hospi_SurveilleDiabetique.$data.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleDiabetique.$data.svData.refSurvHospi = refSurvHospi;
          this.$refs.Hospi_SurveilleDiabetique.fetchDataList();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveilleDiabetique.$data.titleComponent =
            "Surveillance de Diabetique en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    }
      
      


    },
    filters: {
  
    }
  }
  </script>
  
  