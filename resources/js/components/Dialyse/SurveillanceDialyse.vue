<template>
 

  <v-row justify="center">

    <DetailSurveillanceDialyse ref="DetailSurveillanceDialyse" />

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
              <v-dialog v-model="dialog" max-width="900px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Surveillance Dialyse <v-spacer></v-spacer>
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

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Machine" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.MachineList"
                              item-text="nomTypeMachine" item-value="id" dense outlined v-model="svData.refTypeMachine" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="EPO" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense v-model="svData.Bpo"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fer" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense v-model="svData.fer"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Bolus" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.balus"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Infusion" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.infusion"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Dialyseur" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.dialiseur"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Dialysate" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.dialysate"></v-text-field>
                          </div>
                        </v-flex>
                      </v-layout>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Poids Sec" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.poidsSec"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Poids avant" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.poidsAvant"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Poids après" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.poidsApres"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Clairence Urée" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.claurenceUree"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Volume Sang" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.volumeSang"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Kt/V tinal" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.kttinal"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Instructions" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.instruction"></v-textarea>
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
                        <span>Ajouter Diagnostics</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,,'dateDose','dialiseur','poidsSec','observation','author' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Dialyseur</th>
                              <th class="text-left">Dialysate</th>
                              <th class="text-left">PoidsSec</th>
                              <th class="text-left">PoidsAvant</th>
                              <th class="text-left">PoidsApres</th>
                              <th class="text-left">author</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.dialiseur }}</td>
                              <td>{{ item.dialysate }}</td>
                              <td>{{ item.poidsSec }}</td>
                              <td>{{ item.poidsAvant }}</td>
                              <td>{{ item.poidsApres }}</td>
                              <td>{{ item.author }}</td>
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

                                    <v-list-item link @click="showDetailSurvaillanceDialyse(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-anchor</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Detail Surveillance
                                      </v-list-item-title>
                                    </v-list-item>

                                    <!-- <v-list-item link  @click="printBill(item.refEnteteDyalise)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
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
import DetailSurveillanceDialyse from './DetailSurveillanceDialyse.vue';


export default {
  components: {
    DetailSurveillanceDialyse
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
      refEnteteDyalise: 0,

      svData: {
        id: '',
        refEnteteDyalise: 0,
        refTypeMachine: 0,
        Bpo: "",
        balus: "",
        dialiseur: "",
        poidsSec: "",
        poidsApres: "",
        poidsAvant: "",
        fer: "",
        kttinal: "",
        infusion: "",
        dialysate: "",
        claurenceUree: "",
        volumeSang: "",
        dialiseurtinal: "",
        instruction: "",
        author: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        MachineList: [],
        MedecinList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    // this.fetchDataList();
    // this.fecchListMachine();
    // this.fetchListmedecin();
     
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_SurveillanceDyalise/${this.svData.id}`,
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_SurveillanceDyalise`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_SurveillanceDyalise/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteDyalise = item.refEnteteDyalise;
            this.svData.refTypeMachine = item.refTypeMachine;
            this.svData.Bpo = item.Bpo;
            this.svData.poidsSec = item.poidsSec;
            this.svData.poidsApres = item.poidsApres;
            this.svData.poidsAvant = item.poidsAvant;
            this.svData.fer = item.fer;
            this.svData.kttinal = item.kttinal;
            this.svData.infusion = item.infusion;
            this.svData.dialysate = item.dialysate;
            this.svData.claurenceUree = item.claurenceUree;
            this.svData.volumeSang = item.volumeSang;
            this.svData.dialiseurtinal = item.dialiseurtinal;
            this.svData.instruction = item.instruction;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_SurveillanceDyalise/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MedecinList = donnees;

        }
      );
    },
    fetchDataList() {
     this.fetch_data(`${this.apiBaseURL}/fetch_sureillance_for_dialyse/${this.refEnteteDyalise}?page=`);

    },
    fecchListMachine() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_type_machine2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MachineList = donnees;

        }
      );
    },
    showDetailSurvaillanceDialyse(refSurvDyalise, name) {

      if (refSurvDyalise != '') {

        this.$refs.DetailSurveillanceDialyse.$data.etatModal = true;
        this.$refs.DetailSurveillanceDialyse.$data.refSurvDyalise = refSurvDyalise;
        this.$refs.DetailSurveillanceDialyse.$data.svData.refSurvDyalise = refSurvDyalise;
        this.$refs.DetailSurveillanceDialyse.fetchDataList();
        this.fetchDataList();
        
        this.$refs.DetailSurveillanceDialyse.$data.titleComponent =
          "Detail Surveillance Dialyse pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>
  
  