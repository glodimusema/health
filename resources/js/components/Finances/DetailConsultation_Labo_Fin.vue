<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <Laboratoire_Finance ref="Laboratoire_Finance" />

        <v-dialog v-model="dialog" max-width="1200px" hide-overlay transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Detail Consultation <v-spacer></v-spacer>
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
              <v-card-text max-height="1500px" background-color: white>
                <v-layout row wrap>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date Consultation" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateDetailCons">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Type de Consultation" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeConsList" item-text="designation"
                        item-value="id" dense outlined v-model="svData.refTypeCons" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea label="Plaintes" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.plainte">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea type="textarea" label="Historique Maladie" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.historique">
                      </v-textarea>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea type="textarea" label="Entécédent" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.antecedent">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea type="textarea" label="Complément Anamnese" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.complementanamnese">
                      </v-textarea>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea type="textarea" label="Examen Physique" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.examenphysique">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-textarea type="textarea" label="Diagnostic de Presomption" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.diagnostiquePres"></v-textarea>
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
          <!--   -->
          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                  outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
              </v-flex>
              <v-flex md5>
                <div>

                </div>
              </v-flex>
              <v-flex md1>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <!-- <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                        <v-icon>add</v-icon>
                      </v-btn> -->
                    </span>
                  </template>
                  <span>Ajouter le Detail</span>
                </v-tooltip>
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
                        <th class="text-left">Malade</th>
                        <th class="text-left">TypeCons.</th>
                        <th class="text-left">Plainte</th>
                        <th class="text-left">Historique</th>
                        <th class="text-left">Antécedent</th>
                        <th class="text-left">Complements</th>
                        <th class="text-left">ExamenPhysique</th>
                        <th class="text-left">Diag.Presomption</th>
                        <th class="text-left">Date</th>
                        <th class="text-left">Author</th>

                      </tr>
                    </thead>
                    <!-- //'id','refEnteteCons','refTypeCons','plainte','historique','antecedent','complementanamnese','examenphysique','diagnostiquePres','dateDetailCons','author' -->
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

                              <v-list-item link @click="showLaboratoire(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-anchor</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Voir les Examens
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printBilletLabo(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Billet Laboratoire</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printFacture(item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Facture des Examens</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printResultat(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Rendu des Resultats</v-list-item-title>
                              </v-list-item>

                            </v-list>
                          </v-menu>

                        </td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.TypeConsultation }}</td>
                        <td>{{ item.plainte }}</td>
                        <td>{{ item.historique }}</td>
                        <td>{{ item.antecedent }}</td>
                        <td>{{ item.complementanamnese }}</td>
                        <td>{{ item.examenphysique }}</td>
                        <td>{{ item.diagnostiquePres }}</td>
                        <td>{{ item.dateDetailCons }}</td>
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

  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ImageriesFinance from '../Imageries/ImageriesFinance.vue';
import Laboratoire_Finance from "./Laboratoire_Finance.vue";

export default {
  components: {
    ImageriesFinance,
    Laboratoire_Finance
  },
  data() {
    return {
      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,

      svData: {
        id: '',
        refEnteteCons: this.$route.params.id,
        refTypeCons: 0,
        plainte: '',
        historique: '',
        Temperature: '',
        antecedent: '',
        complementanamnese: '',
        examenphysique: '',
        diagnostiquePres: '',
        dateDetailCons: '',
        author: "Admin",
      },
      fetchData: [],
      typeConsList: [],
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
    this.fetchListSelection();

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
            `${this.apiBaseURL}/update_detailconsultation/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_detailconsultation`,
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

    printBilletLabo(id) {
      window.open(`${this.apiBaseURL}/pdf_billetlabo_data?id=` + id);
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    printFacture(id) {
      window.open(`${this.apiBaseURL}/pdf_facturelabo_data?id=` + id);
    },

    printResultat(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatlabo_data?id=` + id);
    },

    //printResultat 'id','refEnteteCons','refTypeCons','plainte','historique','antecedent','complementanamnese','examenphysique','diagnostiquePres','dateDetailCons','author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailconsultation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteCons = item.refEnteteCons;
            this.svData.refTypeCons = item.refTypeCons;
            this.svData.plainte = item.plainte;
            this.svData.historique = item.historique;
            this.svData.antecedent = item.antecedent;
            this.svData.complementanamnese = item.complementanamnese;
            this.svData.examenphysique = item.examenphysique;
            this.svData.diagnostiquePres = item.diagnostiquePres;
            this.svData.dateDetailCons = item.dateDetailCons;
            this.svData.author = item.author;

          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detailconsultation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refEnteteCons = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_detailconsultation?page=`);

    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typeConsultation`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeConsList = donnees;
        }
      );
    },
    getRouteParam() {
      var id = this.$route.params.id;
      this.refEnteteCons = id;
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showLaboratoire(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Laboratoire_Finance.$data.etatModal = true;
        this.$refs.Laboratoire_Finance.$data.refDetailCons = refDetailCons;
        this.$refs.Laboratoire_Finance.$data.svData.refDetailCons = refDetailCons;
        this.$refs.Laboratoire_Finance.fetchDataList();
        this.$refs.Laboratoire_Finance.fetchListSelection();
        this.fetchDataList();

        this.$refs.Laboratoire_Finance.$data.titleComponent =
          "Voir les Examens pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>
  
  