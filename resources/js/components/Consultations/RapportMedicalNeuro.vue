<template>

<v-row justify="center">

  <Annexe_Neurologie ref="Annexe_Neurologie" />

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
                      Rapport Medical en Neuro <v-spacer></v-spacer>
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
                                  <v-autocomplete label="Selectionnez le Type de Rapport" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.typerapportList" item-text="name_typeRapport"
                                  item-value="id" dense outlined v-model="svData.reftyperapport" chips clearable>
                                  </v-autocomplete>
                              </div>
                          </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Préambule (Introduction)" prepend-inner-icon="draw" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.preambule">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Developpement" prepend-inner-icon="draw" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.developpement">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Traitement reçus"
                              prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.traitementsRecus">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Conclusion" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conclusion">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Recomandations" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.recomandation">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
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
                            <v-autocomplete label="Selectionnez le Medecin n°2" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
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
                            <v-autocomplete label="Selectionnez le Medecin n°3" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
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
                        <span>Ajouter Resumé</span>
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
                              <th class="text-left">DateHospi</th>
                              <th class="text-left">Medecin</th>
                              <th class="text-left">Medecin2</th>
                              <th class="text-left">Medecin3</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.created_at }}</td>
                              <td>{{ item.medecin1 }}</td>
                              <td>{{ item.medecin2 }}</td>
                              <td>{{ item.medecin3 }}</td>
                              <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link @click="showAnnexes(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-bookmark-plus</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Ajouter quelques Documents en Annexe
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="printBill(item.id)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">print</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Rapport Medical</v-list-item-title>
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
import Annexe_Neurologie from './Annexe_Neurologie.vue';

export default {
  components: {
    Annexe_Neurologie
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
      refDetailConst: 0,

      svData: {
        id: '',
        refDetailConst: 0,
        reftyperapport: "",
        medecin1:"",
        specialite1:"",
        cnom1:"",
        medecin2:"",
        specialite2:"",
        cnom2:"",
        medecin3:"",
        specialite3:"",
        cnom3:"",
        preambule: "",
        developpement: "",
        traitementsRecus: "",
        conclusion: "",
        recomandation: "",        
        author: "",

        refMedecin1:0,
        refMedecin2:0,
        refMedecin3:0
      },
      fetchData: [],
      medecinList: [],
      typerapportList: [],
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
    // this.fetchListSelection();
    // this.fetchListTypeRapport()
     
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
          this.svData.refDetailConst = this.refDetailConst;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_protocoleNero/${this.svData.id}`,
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
          this.svData.refDetailConst = this.refDetailConst;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_protocoleNero`,
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
//typerapportList
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

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

        }
      );

    },

    fetchListTypeRapport() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_typerapportneuro_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typerapportList = donnees;

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
  },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_rapportmedical_neuro_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_protocoleNero/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailConst = item.refDetailConst;
            this.svData.reftyperapport = item.reftyperapport;
            this.svData.preambule = item.preambule;
            this.svData.developpement = item.developpement;
            this.svData.traitementsRecus = item.traitementsRecus;
            this.svData.conclusion = item.conclusion;
            this.svData.recomandation = item.recomandation;
            this.svData.traitement_med = item.traitement_med;
            this.svData.evolution_med = item.evolution_med;
            this.svData.libelle_med = item.libelle_med;
            this.svData.date_med = item.date_med;
            this.svData.medecin_med = item.medecin_med;
            this.svData.specialite_med = item.specialite_med;
            this.svData.cnom_med = item.cnom_med;
            this.svData.statut_rapmed = item.statut_rapmed;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_protocoleNero/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_protocoleNero_cons/${this.refDetailConst}?page=`);
      //
    },
    showAnnexes(refProtocole, name) {

        if (refProtocole != '') {

          this.$refs.Annexe_Neurologie.$data.etatModal = true;
          this.$refs.Annexe_Neurologie.$data.refProtocole = refProtocole;
          this.$refs.Annexe_Neurologie.$data.svData.refProtocole = refProtocole;
          this.$refs.Annexe_Neurologie.fetchDataList();
          this.fetchDataList();
          
          this.$refs.Annexe_Neurologie.$data.titleComponent =
            "Quelques annexes des documents pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    }


  },
  filters: {

  }
}
</script>
  
  