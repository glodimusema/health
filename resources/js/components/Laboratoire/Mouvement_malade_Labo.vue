<template>
  <v-layout>

    <v-flex md12>

      <EnteteLaboExt_Resultat ref="EnteteLaboExt_Resultat" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Création Episode Maladie <v-spacer></v-spacer>
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

              <v-autocomplete label="Selectionnez le Type de Mouvement" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="typemouvementtList" item-text="Typemouvement"
                item-value="id" dense outlined v-model="svData.refTypeMouvement" chips clearable>
              </v-autocomplete>

              <v-text-field type="date" label="Date Mouvement" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateMouvement">
              </v-text-field>

              <v-text-field label="N° Bon (Abonné)" prepend-inner-icon="extension"
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numroBon"></v-text-field>


              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-select label="Statut" :items="[
                      { designation: 'Encours' },
                      { designation: 'Sortie' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.Statut"></v-select>
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

      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/mouvement_labo'">Laboratoire/Ordonance</router-link>
            <!-- <a href="/admin/entete_consultation">
              <button></button>
            </a>                       -->
          </div>
        </v-flex>
      </v-layout>

      <br /><br />
      <v-layout>
        <!--       -->
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
                <span>Ajouter un Mouvement</span>
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
                      <th class="text-left">N°EpisodeM</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">N°Bon</th>
                      <th class="text-left">Date</th>
                      <th class="text-left">Mouvement</th>
                      <th class="text-left">Etat</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.Categorie }}</td>
                      <td>{{ item.numroBon }}</td>
                      <td>{{ item.dateMouvement | formatDate }}</td>
                      <td>{{ item.Typemouvement }}</td>
                      <td>
                        <v-badge bordered color="error" icon="person" overlap>
                          <v-btn elevation="2" x-small class="white--text"
                            :color="item.Statut == 'Encours' ? 'success' : 'error'" depressed>
                            {{ item.Statut }}
                          </v-btn>
                        </v-badge>

                      </td>
                      <td>{{ item.author }}</td>
                      <td>
                         <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link @click="showEnteteLaboratire(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-anchor</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Voir les Examens
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
                            <!-- printResultat -->
                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printResultat(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Rendu des Résultats</v-list-item-title>
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
import EnteteLaboExt_Resultat from './EnteteLaboExt_Resultat.vue';

export default {
  components: {
    EnteteLaboExt_Resultat
  },
  data() {
    return {

      title: "Liste des Mouvements",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      //'refMouvement','dateTriage'
      //'id','refMalade','refTypeMouvement','dateMouvement','numroBon','Statut','dateSortieMvt','motifSortieMvt','autoriseSortieMvt','author'
      svData: {
        id: '',
        refMalade: this.$route.params.id,
        refTypeMouvement: "",
        dateMouvement: "",
        numroBon: "",
        Statut: "",
        author: "Admin",
        noms: "",
        Typemouvement: "",
        refMouvement: "",
        dateTriage: ""

      },
      fetchData: [],
      typemouvementtList: [],
      clientList: [],
      personneList: [],
      don: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

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
            `${this.apiBaseURL}/update_mouvement/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_mouvement`,
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
      window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
    },
    //printResultat
    printResultat(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatlaboext_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refMalade = item.refMalade;
            this.svData.noms = item.noms;
            this.svData.dateMouvement = item.dateMouvement;
            this.svData.Typemouvement = item.Typemouvement;
            this.svData.refTypeMouvement = item.refTypeMouvement;
            this.svData.author = item.author;
            this.svData.numroBon = item.noms;
            this.svData.Statut = item.noms;

          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    insertTriage(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateTriage = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteTriage`,
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
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typemouvement`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typemouvementtList = donnees;
        }
      );
    }
    ,
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_mouvement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refMalade = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_mouvement?page=`);
    },

    getRouteParam() {
      var id = this.$route.params.id;
      this.refMalade = id;
    },

    // PARTIE DES COMPOSANTS===================================================================   
// fetchListServices

    showEnteteLaboratire(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteLaboExt_Resultat.$data.etatModal = true;
        this.$refs.EnteteLaboExt_Resultat.$data.refMouvement = refMouvement;
        this.$refs.EnteteLaboExt_Resultat.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteLaboExt_Resultat.fetchDataList();
        this.$refs.EnteteLaboExt_Resultat.get_methode_Examen();
        this.$refs.EnteteLaboExt_Resultat.get_nature_Echantillon();
        // this.$refs.EnteteLaboExt_Resultat.fetchListServices();
        this.fetchDataList();

        this.$refs.EnteteLaboExt_Resultat.$data.titleComponent =
          "Voir les Examens de Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>
  
  