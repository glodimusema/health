<template>
  <v-row justify="center">

    <AppreciationAgent ref="AppreciationAgent" />
    <ControleConge ref="ControleConge" />
    <DemandeSoinAgent ref="DemandeSoinAgent" />
    <DemandeSortieAgent ref="DemandeSortieAgent" />
    <EnteteConge ref="EnteteConge" />
    <DetailAffectationRubrique ref="DetailAffectationRubrique" />
    <AvanceSurSalaire ref="AvanceSurSalaire" />

    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- DetailAffectationRubrique -->

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

              <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Affectation Agent <v-spacer></v-spacer>
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
                              <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                item-text="name_serv_perso" item-value="id" dense outlined
                                v-model="svData.refServicePerso" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                                item-text="name_categorie_agent" item-value="id" dense outlined
                                v-model="svData.refCategorieAgent" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Affectation" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateAffectation">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="N° HOPITAL " prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCimak">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="N° CNSS" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCNSS">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="N° Impot" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numImpot">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="N° Compte Bancaire" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numcpteBanque">
                              </v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                                item-text="nom_banque" item-value="nom_banque" dense outlined v-model="svData.BanqueAgant"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Autres Détails" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autresDetail">
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
                  <!--   -->
                  <v-flex md12>
                    <v-layout>
                      <v-flex md6>
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
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
                          <span>Ajouter le Detail</span>
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
                                <th class="text-left">Agent</th>
                                <th class="text-left">Service</th>
                                <th class="text-left">Catégorie</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">N°HOPITAL</th>
                                <th class="text-left">N°CNSS</th>
                                <th class="text-left">N°Impot</th>
                                <th class="text-left">N°Compte</th>
                                <th class="text-left">Banque</th>
                                <th class="text-left">AutresDetails</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_medecin }}</td>
                                <td>{{ item.name_serv_perso }}</td>
                                <td>{{ item.name_categorie_agent }}</td>
                                <td>{{ item.dateAffectation }}</td>
                                <td>{{ item.numCimak }}</td>
                                <td>{{ item.numCNSS }}</td>
                                <td>{{ item.numImpot }}</td>
                                <td>{{ item.numcpteBanque }}</td>
                                <td>{{ item.BanqueAgant }}</td>
                                <td>{{ item.autresDetail }}</td>
                                <td>

                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showAvanceSurSalaire(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Avance sur Salaire
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showAppreciationAgent(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Appreciations sur l'Agent
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showControleConge(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Congé annuel(Nombre)
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showDemandeSoinAgent(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Demande de soin Medicaux
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showDemandeSortieAgent(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Demande de sortie
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showEnteteConge(item.id, item.noms_medecin)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Demande de Congé
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link
                                        @click="showDetailAffectationRubrique(item.id, item.noms_medecin, item.refCategorieAgent)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Les Rubriques Salariales
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer
                                        </v-list-item-title>
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
import AppreciationAgent from './AppreciationAgent.vue';
import AvanceSurSalaire from './AvanceSurSalaire.vue';
import ControleConge from './ControleConge.vue';
import DemandeSoinAgent from './DemandeSoinAgent.vue';
import DemandeSortieAgent from './DemandeSortieAgent.vue';
import DetailAffectationRubrique from './DetailAffectationRubrique.vue';
import EnteteConge from './EnteteConge.vue';


export default {
  components: {
    AppreciationAgent,
    ControleConge,
    DemandeSoinAgent,
    DemandeSortieAgent,
    EnteteConge,
    DetailAffectationRubrique,
    AvanceSurSalaire
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
      refAgent: 0,
      //// ,"numcpteBanque","numImpot","BanqueAgant"
      // id,refAgent,refServicePerso,refCategorieAgent,dateAffectation,numCimak,numCNSS,autresDetail,author

      svData: {
        id: '',
        refAgent: 0,
        refServicePerso: 0,
        refCategorieAgent: 0,
        dateAffectation: '',
        numCimak: '',
        numCNSS: '',
        numImpot: '',
        numcpteBanque: '',
        BanqueAgant: '',
        autresDetail: '',
        author: "Admin",
      },
      fetchData: [],
      serviceList: [],
      categorieList: [],
      BanqueList: [],
      don: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    // this.fetchDataList();
    // this.fetchListService();
    // this.fetchListCategorie();
    // this.get_Banque();
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
          this.svData.refAgent = this.refAgent;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_AffectationAgent/${this.svData.id}`,
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
          this.svData.refAgent = this.refAgent;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_AffectationAgent`,
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

    // s'id','refAgent','refServicePerso','dateAffectation','numCimak','author'
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_AffectationAgent/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAgent = item.refAgent;
            this.svData.refServicePerso = item.refServicePerso;
            this.svData.refCategorieAgent = item.refCategorieAgent;
            this.svData.dateAffectation = item.dateAffectation;
            this.svData.numCimak = item.numCimak;
            this.svData.numCNSS = item.numCNSS;
            this.svData.autresDetail = item.autresDetail;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_AffectationAgent/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_AffectationAgent/${this.refAgent}?page=`);
    },

    fetchListService() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_service_personnel2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.serviceList = donnees;
        }
      );
    },
    fetchListCategorie() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_dopdown_categorie_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.categorieList = donnees;
        }
      );
    },
    showAppreciationAgent(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.AppreciationAgent.$data.etatModal = true;
        this.$refs.AppreciationAgent.$data.refAffectation = refAffectation;
        this.$refs.AppreciationAgent.$data.svData.refAffectation = refAffectation;
        this.$refs.AppreciationAgent.fetchDataList();
        this.$refs.AppreciationAgent.fetchListSelection();
        this.fetchDataList();

        this.$refs.AppreciationAgent.$data.titleComponent =
          "Appreciation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showControleConge(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.ControleConge.$data.etatModal = true;
        this.$refs.ControleConge.$data.refAffectation = refAffectation;
        this.$refs.ControleConge.$data.svData.refAffectation = refAffectation;
        this.$refs.ControleConge.fetchDataList();
        this.$refs.ControleConge.fetchListSelection();
        this.fetchDataList();

        this.$refs.ControleConge.$data.titleComponent =
          "Controle de Congé annuel pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showAvanceSurSalaire(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.AvanceSurSalaire.$data.etatModal = true;
        this.$refs.AvanceSurSalaire.$data.refAffectation = refAffectation;
        this.$refs.AvanceSurSalaire.$data.svData.refAffectation = refAffectation;
        this.$refs.AvanceSurSalaire.fetchDataList();
        this.$refs.AvanceSurSalaire.fetchListSelection();
        this.$refs.AvanceSurSalaire.fetchListMois();
        this.fetchDataList();

        this.$refs.AvanceSurSalaire.$data.titleComponent =
          "Avance sur Salaire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showDemandeSoinAgent(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.DemandeSoinAgent.$data.etatModal = true;
        this.$refs.DemandeSoinAgent.$data.refAffectation = refAffectation;
        this.$refs.DemandeSoinAgent.$data.svData.refAffectation = refAffectation;
        this.$refs.DemandeSoinAgent.fetchDataList();
        this.$refs.DemandeSoinAgent.fetchListSelection();
        this.fetchDataList();

        this.$refs.DemandeSoinAgent.$data.titleComponent =
          "Demande de soin pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showDemandeSortieAgent(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.DemandeSortieAgent.$data.etatModal = true;
        this.$refs.DemandeSortieAgent.$data.refAffectation = refAffectation;
        this.$refs.DemandeSortieAgent.$data.svData.refAffectation = refAffectation;
        this.$refs.DemandeSortieAgent.fetchDataList();
        this.$refs.DemandeSortieAgent.fetchListSelection();
        this.fetchDataList();

        this.$refs.DemandeSortieAgent.$data.titleComponent =
          "Demande de sortie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showEnteteConge(refAffectation, name) {

      if (refAffectation != '') {

        this.$refs.EnteteConge.$data.etatModal = true;
        this.$refs.EnteteConge.$data.refAffectation = refAffectation;
        this.$refs.EnteteConge.$data.svData.refAffectation = refAffectation;
        this.$refs.EnteteConge.fetchDataList();
        this.$refs.EnteteConge.fetchListAnnee();
        this.$refs.EnteteConge.fetchListAgent();
        this.$refs.EnteteConge.fetchDataList();

        this.$refs.EnteteConge.$data.titleComponent =
          "Congé pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    showDetailAffectationRubrique(refAffectation, name, refCategorieAgent) {

      if (refAffectation != '') {

        this.$refs.DetailAffectationRubrique.$data.etatModal = true;
        this.$refs.DetailAffectationRubrique.$data.refAffectation = refAffectation;
        this.$refs.DetailAffectationRubrique.$data.refCategorieAgent = refCategorieAgent;
        this.$refs.DetailAffectationRubrique.$data.svData.refAffectation = refAffectation;
        this.$refs.DetailAffectationRubrique.fetchDataList();
        this.$refs.DetailAffectationRubrique.fetchListSelection();
        this.$refs.DetailAffectationRubrique.$data.titleComponent =
          "Affectation Rubrique de Paiement pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
    },
    async get_Banque() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_banque_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.BanqueList = chart;
          } else {
            this.BanqueList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    }

    //fetchListCategorie
  },
  filters: {

  }
}
</script>
  
  