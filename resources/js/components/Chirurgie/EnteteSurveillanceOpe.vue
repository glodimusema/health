<template>
  

  <v-row justify="center">

    <DetailSurveillanceOpe ref="DetailSurveillanceOpe" />

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
                      Surveillance Anesthesie <v-spacer></v-spacer>
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
                            <v-autocomplete label="Selectionnez le Departement" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                              item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refDepartement"
                              chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Surveillance" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSurveillance">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure d'admission Salle" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureAdmiSalle">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Debut Intervention" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureDebutInterv">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Chirurgien" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.chirurgien" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Anesthesiste " prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.anesthesiste" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Diagnostic Opératoire" prepend-inner-icon="draw" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnosticOpe">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Acte Opératoire" prepend-inner-icon="draw" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.acteOpe">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'InfirmierSalle" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.infirmierSalle" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Fin Intervention" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.heureFin">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres Commentaires" prepend-inner-icon="draw" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autresCommentaires">
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
                              <td>{{ item.dateSurveillance }}</td>
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

                                    <v-list-item link @click="showDetailSurveillance(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-invert-colors</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Détail sur la Surveillance
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
import DetailSurveillanceOpe from './DetailSurveillanceOpe.vue';

export default {
  components: {
    DetailSurveillanceOpe
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
      refAnesthesie: 0, 

      svData: {
        id: '',
        refAnesthesie: 0,
        refDepartement: 0,
        dateSurveillance: "",
        chirurgien: "",
        anesthesiste: "",
        infirmierSalle: "",
        heureAdmiSalle: "",
        heureDebutInterv: "",
        diagnosticOpe: "",
        acteOpe: "",
        heureFin: "",
        autresCommentaires: "",
        author: ""
      },
      fetchData: [],
      listeMedecin: [],
      don: [],
      query: "",
      stataData: {
        ServiceList: []
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
          this.svData.refAnesthesie = this.refAnesthesie;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetesurveillanceope/${this.svData.id}`,
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
          this.svData.refAnesthesie = this.refAnesthesie;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entetesurveillanceope`,
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
    
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetesurveillanceope/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAnesthesie = item.refAnesthesie;
            this.svData.dateSurveillance = item.dateSurveillance;
            this.svData.diagnosticOpe = item.diagnosticOpe;
            this.svData.anesthesiste = item.anesthesiste;
            this.svData.chirurgien = item.chirurgien;
            this.svData.assistant = item.assistant;
            this.svData.infirmierSalle = item.infirmierSalle;
            this.svData.autresCommentaires = item.autresCommentaires;
            this.svData.heureAdmiSalle = item.heureAdmiSalle;
            this.svData.heureDebutInterv = item.heureDebutInterv;
            this.svData.heureFin = item.heureFin;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetesurveillanceope/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_surveillance_anesthesie/${this.refAnesthesie}?page=`);

    },
    showDetailSurveillance(refEnteteSurv, name) {

      //<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

      if (refEnteteSurv != '') {

        this.$refs.DetailSurveillanceOpe.$data.etatModal = true;
        this.$refs.DetailSurveillanceOpe.$data.refEnteteSurv = refEnteteSurv;
        this.$refs.DetailSurveillanceOpe.$data.svData.refEnteteSurv = refEnteteSurv;
        this.$refs.DetailSurveillanceOpe.fetchDataList();   
        this.fetchDataList();
        
        this.$refs.DetailSurveillanceOpe.$data.titleComponent =
          "Detail Surveillance en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>

