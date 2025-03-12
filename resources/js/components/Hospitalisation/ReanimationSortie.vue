<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>
        <v-dialog v-model="dialog" max-width="600px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Hospitalisation <v-spacer></v-spacer>
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

                <v-text-field type="date" label="Date Entrée" prepend-inner-icon="extension"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                  v-model="svData.dateEntree"></v-text-field>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Service Hospitalisation" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                      item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refServiceHospi"
                      chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.SalleList"
                      item-text="nom_salle" item-value="id" dense outlined v-model="svData.refSalle" chips clearable
                      @change="getLit(svData.refSalle)">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Lit" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.LitList" item-text="nom_lit"
                      item-value="id" dense outlined v-model="svData.refLit" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Diagnostic d'Entrée" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnosticEntree">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Observations" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observations">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Service d'Origine" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                      item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                      v-model="svData.serviceOrigine" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-select label="Type Orientation" :items="[
                      { designation: 'HOSPITALISATION' },
                      { designation: 'REANIMATION' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      item-text="designation" item-value="designation" v-model="svData.TypeOrientationHosp"></v-select>
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
        <!--  -->
        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'/admin/HospitalisationAll'">Hospitalisation/Hospitalisation</router-link>
            </div>
          </v-flex>
        </v-layout>

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
              <!-- <v-flex md1>
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
              </v-flex> -->
            </v-layout>
            <br />
            <v-card>
              <!-- ,'ValeurNormale2','observation2' -->
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Action</th>
                        <th class="text-left">Malade</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">DateEntrée</th>
                        <th class="text-left">ServiceOrigine</th>
                        <th class="text-left">Orientions</th>
                        <th class="text-left">Salle</th>
                        <th class="text-left">Lit</th>
                        <th class="text-left">Statut</th>
                        <!-- <th class="text-left">Date</th> -->

                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>

                          <!-- statutHospi -->
                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <v-divider></v-divider>
                              <v-subheader>Dossier Medical</v-subheader>
                              <v-divider></v-divider>
                            </v-list>
                          </v-menu>
                        </td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.dateEntree | formatDate }}</td>
                        <td>{{ item.serviceOrigine }}</td>
                        <td>{{ item.TypeOrientationHosp }}</td>
                        <td>{{ item.nom_salle }}</td>
                        <td>{{ item.nom_lit }}</td>
                        <td>{{ item.statutHospi }}</td>
                        <!-- <td>{{ item.created_at | formatDate }}</td> -->

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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "../AvatarProfil.vue"
import avatarAvatar from '../AvatarAction.vue'
export default {
  components: {
    AvatarProfil,
    avatarAvatar,
  },
  data() {
    return {
      //,'refServiceHospi','serviceOrigine'
      // //'id','refSalle','refLit','refDetailCons','dateEntree','diagnosticEntree','observations','dateHospi','author'
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      svData: {
        id: '',
        refDetailCons: this.$route.params.id,
        refSalle: 0,
        refLit: 0,
        dateEntree: "",
        diagnosticEntree: "",
        observations: "",
        author: "",
        refServiceHospi: 0,
        serviceOrigine: "",
        TypeOrientationHosp: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        ServiceList: [],
        SalleList: [],
        LitList: [],
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();
    this.fetchListSelection();
    this.fetchListServices();

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
          this.svData.refDetailCons = this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_hospitalisation/${this.svData.id}`,
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
          this.svData.refDetailCons = this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_hospitalisation`,
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
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_hospitalisation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.refSalle = item.refSalle;
            this.svData.refLit = item.refLit;
            this.svData.dateEntree = item.dateEntree;
            this.svData.diagnosticEntree = item.diagnosticEntree;
            this.svData.observations = item.observations;
            this.svData.refServiceHospi = item.refServiceHospi;
            this.svData.serviceOrigine = item.serviceOrigine;
          });
          this.getLit(this.svData.refSalle);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_hospitalisation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refDetailCons = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_reanimation_sortie?page=`);

    },
    fetchListSelection() {
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

    getRouteParam() {
      var id = this.$route.params.id;
      this.refDetailCons = id;
    },

    showProfileModalclient(id, name) {

      if (id != null) {

        this.$refs.avatarAvatar.$data.dialog = true;
        this.$refs.avatarAvatar.$data.svData.id = id;
        this.$refs.avatarAvatar.display_profile(id);

        this.$refs.avatarAvatar.$data.titleComponent =
          "Détail du Profile de " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>

