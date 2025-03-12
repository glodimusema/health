<template>
  <v-layout>

    <v-flex md12>
      <DetailSortie ref="DetailSortie" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Création Sortie <v-spacer></v-spacer>
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

              <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                item-value="id" outlined dense v-model="svData.refService">
              </v-autocomplete>

              <v-autocomplete label="Selectionnez l'Agent" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="agentList" item-text="noms_medecin"
                item-value="noms_medecin" outlined dense v-model="svData.nom_agent">
              </v-autocomplete>

              <v-text-field type="date" label="Date Sortie" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSortie">
              </v-text-field>

              <v-text-field label="Libellé" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
              </v-text-field>


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
            <router-link :to="'#'">Sorties Medicaments</router-link>
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
                    <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter une affectation</span>
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
                      <th class="text-left">N°</th>
                      <th class="text-left">Service</th>
                      <th class="text-left">Agent</th>
                      <th class="text-left">DateSortie</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.nom_service }}</td>
                      <td>{{ item.nom_agent }}</td>
                      <td>{{ item.dateSortie | formatDate }}</td>
                      <td>{{ item.author }}</td>
                      <td>

                       <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="showDetailSortie(item.id, item.nom_agent)">
                              <v-list-item-icon>
                                <v-icon>mdi-cart-outline</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Detail Sortie
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon>delete</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Suppression
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailSortie from './DetailSortie.vue';

export default {
  components: {
    DetailSortie
  },
  data() {

    return {

      title: "Liste des Ventes",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refService,nom_agent,dateSortie,libelle,author
      svData: {
        id: '',
        refService: 0,
        nom_agent: "",
        dateSortie: "",
        libelle: "",
        author: ""
      },
      fetchData: [],
      serviceList: [],
      agentList: [],
      don: [],
      query: "",
        
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
  

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListService();
    this.fetchListAgent();
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
            `${this.apiBaseURL}/update_entetesortie/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_entetesortie`,
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
    fetchListService() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_service`).then(
        ({ data }) => {
          var donnees = data.data;
          this.serviceList = donnees;

        }
      );
    },
    fetchListAgent() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_agent`).then(
        ({ data }) => {
          var donnees = data.data;
          this.agentList = donnees;

        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_facture_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetesortie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refService = item.refService;
            this.svData.nom_agent = item.nom_agent;
            this.svData.libelle = item.libelle;
            this.svData.dateSortie = item.dateSortie;
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
        this.delGlobal(`${this.apiBaseURL}/delete_entetesortie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entetesortie?page=`);
    },
    showDetailSortie(refEnteteSortie, name) {

      if (refEnteteSortie != '') {

        this.$refs.DetailSortie.$data.etatModal = true;
        this.$refs.DetailSortie.$data.refEnteteSortie = refEnteteSortie;
        this.$refs.DetailSortie.$data.svData.refEnteteSortie = refEnteteSortie;
        this.$refs.DetailSortie.fetchDataList();
        this.$refs.DetailSortie.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailSortie.$data.titleComponent =
          "Detail Sortie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },


  },
  filters: {

  }
}
</script>

