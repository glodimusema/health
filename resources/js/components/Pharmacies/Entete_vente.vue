<template>
  <v-layout>

    <v-flex md12>

      <!-- FeuilleFacturation -->
      <PrescriptionMedicament_VoirPharma ref="PrescriptionMedicament_VoirPharma" />
      <DetailVente ref="DetailVente" />
      <FeuilleFacturation ref="FeuilleFacturation" />

      <v-dialog v-model="dialog" max-width="600px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Création Vente<v-spacer></v-spacer>
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

              <v-text-field type="date" label="Date Vente" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateVente">
              </v-text-field>

              <v-text-field label="Exécutant" prepend-inner-icon="extension"
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Executant"></v-text-field>


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

      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'#'">Ventes Medicaments</router-link>
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
            <!-- <v-flex md1>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une affectation</span>
              </v-tooltip>
            </v-flex> -->
          </v-layout>
          <br />
          <v-card>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">N°</th>
                      <th class="text-left">Patient</th>
                      <th class="text-left">Téléphone</th>
                      <th class="text-left">Date Vente</th>
                      <!-- <th class="text-left">Montant($)</th> -->
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }} - {{ item.organisationAbonne }}</td>
                      <td>{{ item.contact }}</td>
                      <td>{{ item.dateVente | formatDate }}</td>
                      <!-- <td>{{ item.TotalVente }}</td> -->
                      <td>{{ item.author }}</td>
                      <td>

                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>



                          <v-list dense width="">


                            <v-list-item link @click="showPrescription(item.refMouvement, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-cards</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Voir les Préscriptions Médicales
                              </v-list-item-title>
                            </v-list-item>

                            <!-- <v-list-item link @click="showProfileModalclient(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">description</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail Sortie</v-list-item-title>
                            </v-list-item> -->

                            <v-list-item link @click="showDetailVente(item.id, item.noms,item.refMouvement)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail Sortie
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="showEnteteFacturation(item.refMouvement, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-cards</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Feuille de Facturations
                                Facture
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import PrescriptionMedicament_VoirPharma from '../Consultations/PrescriptionMedicament_VoirPharma.vue';
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import DetailVente from './DetailVente.vue';


export default {
  components: {
    PrescriptionMedicament_VoirPharma,
    DetailVente,
    FeuilleFacturation
  },
  data() {
    return {

      title: "Liste des Ventes",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refMouvement,dateVente,author
      svData: {
        id: '',
        refMouvement: this.$route.params.id,
        dateVente: "",
        author: ""
      },
      fetchData: [],
      clientList: [],
      personneList: [],
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
            `${this.apiBaseURL}/update_entetevente/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_entetevente`,
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
      window.open(`${this.apiBaseURL}/pdf_facture_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetevente/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.dateVente = item.dateVente;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetevente/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entetevente?page=`);
    },

    getRouteParam() {
      var id = this.$route.params.id;
      this.refMouvement = id;
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showPrescription(refMouvement, name) {

      if (refMouvement != '') {


        this.$refs.PrescriptionMedicament_VoirPharma.$data.etatModal = true;
        this.$refs.PrescriptionMedicament_VoirPharma.$data.refMouvement = refMouvement;
        this.$refs.PrescriptionMedicament_VoirPharma.fetchDataList();
        this.fetchDataList();

        this.$refs.PrescriptionMedicament_VoirPharma.$data.titleComponent =
          "Les Préscriptions Médicales pour le Patient : " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteFacturation(refMouvement, name) {
      //
      if (refMouvement != '') {

        this.$refs.FeuilleFacturation.$data.etatModal = true;
        this.$refs.FeuilleFacturation.$data.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.$data.svData.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.fetchDataList();
        this.$refs.FeuilleFacturation.fetchListDepartement();
        this.$refs.FeuilleFacturation.fetchListmedecin();
        this.fetchDataList();

        this.$refs.FeuilleFacturation.$data.titleComponent =
          "Création de la Feuille de Facturation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showDetailVente(refEnteteVente, name,refMouvement) {

      if (refEnteteVente != '') {

        this.$refs.DetailVente.$data.etatModal = true;
        this.$refs.DetailVente.$data.refEnteteVente = refEnteteVente;
        // this.$refs.DetailVente.$data.refMouvement = refMouvement;
        this.$refs.DetailVente.$data.svData.refEnteteVente = refEnteteVente;
        this.$refs.DetailVente.fetchDataList();
        this.$refs.DetailVente.fetchListSelection();        
        this.$refs.DetailVente.showDataMedicamentMedecin(refMouvement)
        this.$refs.DetailVente.showDataBesoinService(refMouvement)
        this.fetchDataList();

        this.$refs.DetailVente.$data.titleComponent =
          "Detail Vente pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>

