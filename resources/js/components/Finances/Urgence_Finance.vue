<template>
  <v-layout>

    <v-flex md12>

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

      <!-- <br /><br /> -->

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
                  <v-select label="Etat" :items="[
                    { designation: 'Attente' },
                    { designation: 'Validé' }
                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.statutentetecons"></v-select>
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

      <!-- <br/><br /> -->
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
              <!-- <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                        <v-icon>add</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Ajouter une affectation</span>
                </v-tooltip> -->
            </v-flex>
          </v-layout>
          <br />
          <v-card>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Action</th>
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Sexe</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">Groupe</th>
                      <th class="text-left">TypeOrientation</th>
                      <th class="text-left">DateOrientation</th>
                      <th class="text-left">Etat</th>
                      <th class="text-left">Auhtor</th>

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
                            <!-- <v-list-item link @click="fetchDataTriage(item.refDetailTriage)">
      <v-list-item-icon>
        <v-icon color="#B72C2C">edit</v-icon>
      </v-list-item-icon>
      <v-list-item-title style="margin-left: -20px">Info. Triage</v-list-item-title>
    </v-list-item> -->

                            <!-- <v-list-item link @click="showDataChronique(item.refMalade)">
      <v-list-item-icon>
        <v-icon color="#B72C2C">edit</v-icon>
      </v-list-item-icon>
      <v-list-item-title style="margin-left: -20px">Maladies Chroniques</v-list-item-title>
    </v-list-item> -->

                            <v-list-item link @click="editDataStatut(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-marker</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Autoriser l'Urgences</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Annuler</v-list-item-title>
                            </v-list-item>

                            </v-list>
                        </v-menu>

                      </td>
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.sexe_malade }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.groupesanguin }}</td>
                      <td>{{ item.TypeOrientation }}</td>
                      <td>{{ item.dateConsultation | formatDate }}</td>
                      <td>{{ item.statutentetecons }}</td>
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

      </v-layout>
    </v-flex>

  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {

      title: "Liste des Ventes",
      dialog: false,
      dialog2: false,
      dialog3: false,
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
        statutentetecons: "",

        Poids: 0,
        Taille: 0,
        TA: "",
        Temperature: 0,
        FC: 0,
        FR: 0,
        Oxygene: 0,
        author: "Admin",
        chroniques: ""
      },
      fetchData: [],
      clientList: [],
      medecinList: [],
      fetchTriage: [],
      donneesTriage: {},
      fetchChronique: {},
      don: [],
      query: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();

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
            `${this.apiBaseURL}/update_enteteconsultation/${this.svData.id}`,
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

    validateCons() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_statutconsultation/${this.svData.id}`,
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_facture_data?id=` + id);
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
            this.svData.statutentetecons = item.statutentetecons;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },

    editDataStatut(id) {
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
            this.svData.statutentetecons = item.statutentetecons;
          });

          this.edit = true;
          this.dialog3 = true;

          // console.log(donnees);
        }
      );
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
      this.fetch_data(`${this.apiBaseURL}/fetch_urgences_attente?page=`);
    },

    getRouteParam() {
      var id = this.$route.params.id;
      this.refDetailTriage = id;
    }


  },
  filters: {

  }
}
</script>
  
  