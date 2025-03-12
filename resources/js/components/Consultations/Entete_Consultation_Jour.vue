<template>
  <v-layout>
    <!-- DetailTriage  -->
    <v-flex md12>

      <DetailConsultation ref="DetailConsultation" />
      <DetailTriageData ref="DetailTriageData" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Details Triage <v-spacer></v-spacer>
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


              <v-text-field type="number" label="Poids " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Poids">
              </v-text-field>

              <v-text-field type="number" label="Taille " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Taille">
              </v-text-field>

              <v-text-field type="text" label="Tension Artérielle(TA) " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TA">
              </v-text-field>

              <v-text-field type="number" label="Température " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Temperature">
              </v-text-field>

              <v-text-field type="number" label="Frequence Cardiaque(FC) " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FC">
              </v-text-field>

              <v-text-field type="number" label="Frequence Réspiratoire(FR) " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FR">
              </v-text-field>

              <v-text-field type="number" label="Saturation en Oxygène " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oxygene">
              </v-text-field>

            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
              <!-- <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn> -->
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>

      <!-- <br /><br /> -->

      <v-dialog v-model="dialog2" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Maladies Chroniques <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog2 = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip>
            </v-card-title>
            <v-card-text>

              <v-textarea type="text" label="Les Maladies Chroniques : " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.chroniques">
              </v-textarea>

            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
              <!-- <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn> -->
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>



      <v-dialog v-model="dialog3" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Valider la consultation <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog3 = false" text fab depressed>
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
                  <v-select label="Voulez-vous Cloturer ce Dossier ?" :items="[
                    { designation: 'OUI' },
                    { designation: 'NON' }
                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.cloture"></v-select>
                </div>
              </v-flex>
              <!--  -->
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog3 = false"> Fermer </v-btn>
              <v-btn color="#B72C2C" dark :loading="loading" @click="validateCons">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>

      <v-dialog v-model="dialog5" max-width="600px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Modifier une Orientation <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog5 = false" text fab depressed>
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
                  <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="mdi-map"
                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
                    item-value="id" dense outlined v-model="svData.refMedecin" chips clearable>
                  </v-autocomplete>
                </div>
              </v-flex>

              <!-- @change="getSpecialiteMedecin(svData.refMedecin)" -->
              <!-- <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_medecin">
                  </v-text-field>
                </div>
              </v-flex>

              <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-text-field readonly label="Fonction Medecin " prepend-inner-icon="event" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.fonction_medecin">
                  </v-text-field>
                </div>
              </v-flex> -->
              <!--  -->
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog5 = false"> Fermer </v-btn>
              <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>



      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/entete_consultation'">Consultation/Consultation</router-link>
            <!-- <a href="/admin/entete_consultation">
              <button></button>
            </a>                       -->
          </div>
        </v-flex>
      </v-layout>


      <br /><br />

      <v-layout>
        <!--   -->
        <v-flex md12>
          <v-layout>
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                    <v-btn @click="fetchDataList()" fab color="#B72C2C" dark>
                      <v-icon>mdi-refresh</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Actualiser</span>
              </v-tooltip>
            </v-flex>
          </v-layout>
          <br />
          <v-card :loading="loading" :disabled="loading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Action</th>
                      <th class="text-left">N°EpisodeM</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Sexe</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">Groupe</th>
                      <th class="text-left">Catégorie</th>
                      <th class="text-left">Mouvement</th>
                      <th class="text-left">TypeOrientation</th>
                      <th class="text-left">DateOrientation</th>
                      <th class="text-left">Durée</th>
                      <th class="text-left">Etat</th>
                      <th class="text-left">Cloture</th>
                      <th class="text-left">Medecin</th>
                      <th class="text-left">Specialite</th>
                      <th class="text-left">Author</th>

                      <!-- duree -->
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">


                            <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showDetailTriage(item.refEnteteTriage, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-account-star</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Voir les signes vitaux
                              </v-list-item-title>
                            </v-list-item>

                            <!-- <v-list-item link @click="fetchDataTriage(item.refDetailTriage)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Info. Triage</v-list-item-title>
                            </v-list-item> -->

                            <v-list-item link @click="showDataChronique(item.refMalade)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Maladies Chroniques</v-list-item-title>
                            </v-list-item>


                            <v-list-item v-if="(item.cloture == 'NON' && item.duree <= item.nmbreJourConsMvt) || userData.id_role == 2" link
                              @click="showDetailConsultation(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-needle</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Anamnèse
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBill(item.refMouvement)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Info. sur le Dossier</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="(item.cloture == 'NON' && item.duree <= item.nmbreJourConsMvt) || userData.id_role == 2" link
                              @click="editDataCloture(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-marker</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Cloturer ce Dossier</v-list-item-title>
                            </v-list-item>

                            <v-list-item
                              v-if="(item.cloture == 'NON' && item.duree <= item.nmbreJourConsMvt) || userData.id_role == 2 || (roless[0].delete == 'OUI')"
                              link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                            </v-list-item>

                          </v-list>
                        </v-menu>

                      </td>
                      <td>{{ item.refMouvement }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.sexe_malade }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.groupesanguin }}</td>
                      <td>{{ item.categoriemaladiemvt }} - {{ item.organisationAbonne }}</td>
                      <td>
                        <v-btn elevation="2" x-small class="white--text"
                          :color="item.parcours == 'Consultation' ? '#00B0F0' : item.parcours == 'Laboratoire' ? '#92D050' : item.parcours == 'Imagerie' ? '#92D050' : item.parcours == 'Kinesitherapie' ? '#7030A0' : item.parcours == 'Dialyse' ? '#ff3333' : item.parcours == 'Pediatrie' ? '#A6A6A6' : item.parcours == 'Hospitalisation' ? '#ff3333' : item.parcours == 'Resultats' ? '#A6A6A6' : 'error'"
                          depressed>
                          {{ item.parcours }}
                        </v-btn>
                      </td>
                      <td>{{ item.TypeOrientation }}</td>
                      <td>{{ item.created_at | formatDate }}</td>
                      <td>
                        <v-badge>
                          <v-btn elevation="2" x-small class="white--text"
                            :color="(((item.duree <= item.nmbreJourConsMvt) && (item.categoriemaladiemvt == 'ABONNE(E)')) || ((item.duree <= item.nmbreJourConsMvt) && (item.categoriemaladiemvt == 'PRIVE(E)'))) ? 'success' : 'error'"
                            depressed>
                            {{ item.duree }}
                          </v-btn>
                        </v-badge>
                        <!-- nmbreJourConsMvt -->
                      </td>
                      <td>{{ item.statutentetecons }}</td>
                      <td>{{ item.cloture }}</td>
                      <td>{{ item.noms_medecin }}</td>
                      <td>{{ item.specialite_medecin }}</td>
                      <td>{{ item.author }}</td>

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
        <!--   -->
      </v-layout>
    </v-flex>
    <!--   -->
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailConsultation from './DetailConsultation.vue';
import DetailTriageData from "../DetailTriageData.vue";

export default {
  components: {
    DetailConsultation,
    DetailTriageData
  },
  data() {
    return {

      title: "Liste des Ventes",
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog5: false,
      edit: false,
      loading: false,
      disabled: false,
      //'refDetailTriage','refMedecin','dateConsultation','author'
      svData: {
        id: '',
        refDetailTriage: this.$route.params.id,
        refMedecin: 0,
        dateConsultation: "",
        author: "Admin",
        noms: "",
        noms_medecin: "",

        Poids: 0,
        Taille: 0,
        TA: "",
        Temperature: 0,
        FC: 0,
        FR: 0,
        Oxygene: 0,
        author: "Admin",
        chroniques: "",
        cloture: ""
      },
      fetchData: [],
      clientList: [],
      medecinList: [],
      fetchTriage: [],
      donneesTriage: {},
      fetchChronique: {},
      don: [],
      query: ""

    }
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();
    this.fetchListMedecin();
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_medecinconsultation/${this.svData.id}`,
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_enteteconsultation`,
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
      window.open(`${this.apiBaseURL}/pdf_dossier_medical_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteconsultation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refDetailTriage = item.refDetailTriage;
            this.svData.dateConsultation = item.dateConsultation;
            this.svData.refMedecin = item.refMedecin;
            this.svData.noms = item.noms;
            this.svData.noms_medecin = item.noms_medecin;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog5 = true;

          // console.log(donnees);
        }
      );
    },
    showDetailTriage(refEnteteTriage, name) {

      if (refEnteteTriage != '') {

        this.$refs.DetailTriageData.$data.etatModal = true;
        this.$refs.DetailTriageData.$data.refEnteteTriage = refEnteteTriage;
        this.$refs.DetailTriageData.$data.svData.refEnteteTriage = refEnteteTriage;
        this.$refs.DetailTriageData.fetchDataList();
        this.$refs.DetailTriageData.fetchListSelection();
        this.$refs.DetailTriageData.fetchListSalle();

        this.$refs.DetailTriageData.$data.titleComponent =
          "Les Signes vitaux pour " + name;

          console.log("Signes pour "+this.$refs.DetailTriageData.$data.titleComponent);

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showDataChronique(id) {
      this.svData.chroniques = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_chronique_malade2/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.chroniques = this.svData.chroniques + " ; " + item.nom_maladie;
          });
          this.dialog2 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteconsultation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    fetchDataTriage(id) {

      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailTriage/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.Poids = item.Poids;
            this.svData.Taille = item.Taille;
            this.svData.TA = item.TA;
            this.svData.Temperature = item.Temperature;
            this.svData.FC = item.FC;
            this.svData.FR = item.FR;
            this.svData.Oxygene = item.Oxygene;


          });

          this.edit = true;
          this.dialog = true;
        }
      );

    },
    fetchDataChronique(idMalade) {
      this.fetch_data(`${this.apiBaseURL}/fetch_chronique_malade/${idMalade}?page=`);

    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refDetailTriage = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_enteteconsultation_jour?page=`);
    },

    getRouteParam() {
      var id = this.$route.params.id;
      this.refDetailTriage = id;
    },

    editDataCloture(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteconsultation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refDetailTriage = item.refDetailTriage;
            this.svData.dateConsultation = item.dateConsultation;
            this.svData.refMedecin = item.refMedecin;
            this.svData.noms = item.noms;
            this.svData.noms_medecin = item.noms_medecin;
            this.svData.author = item.author;
            this.svData.cloture = item.cloture;
          });

          this.edit = true;
          this.dialog3 = true;

          // console.log(donnees);
        }
      );
    },

    validateCons() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_cloture/${this.svData.id}`,
            JSON.stringify(this.svData)
          )//
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog3 = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });

        }
        else {
        }

      }
    },
    showDetailConsultation(refEnteteCons, name) {

      if (refEnteteCons != '') {

        this.$refs.DetailConsultation.$data.etatModal = true;
        this.$refs.DetailConsultation.$data.refEnteteCons = refEnteteCons;
        this.$refs.DetailConsultation.$data.svData.refEnteteCons = refEnteteCons;
        this.$refs.DetailConsultation.fetchDataList();
        this.$refs.DetailConsultation.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailConsultation.$data.titleComponent =
          "Dossier Médical pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    fetchListMedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

        }
      );
    },
    getSpecialiteMedecin(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.specialite_medecin = item.specialite_medecin;
            this.svData.fonction_medecin = item.fonction_medecin;
          });

        }
      );
    }


  },
  filters: {

  }
}
</script>
  
  