<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
        <Lit ref="Lit" />
        <!-- modal -->
        <v-dialog v-model="dialog" max-width="400px" scrollable transition="dialog-bottom-transition">
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                {{ titleComponent }} <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog = false" text fab depressed>
                        <v-icon>close</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Fermer</span>
                </v-tooltip></v-card-title>
              <v-card-text>
                <v-text-field label="Designation" prepend-inner-icon="extension"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_salle"></v-text-field>

                <v-text-field type="number" label="Prix Salle($)" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PrixSalle">
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
        <br /><br />
        <!-- fin modal -->

        <!-- bande -->
        <v-layout>
          <v-flex md1>
            <v-tooltip bottom>
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn :loading="loading" fab @click="onPageChange">
                    <v-icon>autorenew</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Initialiser</span>
            </v-tooltip>
          </v-flex>
          <v-flex md6>
            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
              v-model="query" @keyup="onPageChange" clearable></v-text-field>
          </v-flex>

          <v-flex md4></v-flex>

          <v-flex md1>
            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="showModal" fab color="#B72C2C" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter une opération</span>
            </v-tooltip>
          </v-flex>
        </v-layout>
        <!-- bande -->

        <br />
        <v-card :loading="loading" :disabled="isloading">
          <v-card-text>
            <v-simple-table>
              <template v-slot:default>
                <thead>
                  <tr>
                    <th class="text-left">Designation</th>
                    <th class="text-left">Prix($)</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.nom_salle }}</td>
                    <td>{{ item.PrixSalle }}</td>
                    <td>
                      {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }}
                    </td>

                    <td>
                      <v-menu bottom rounded offset-y transition="scale-transition">
                        <template v-slot:activator="{ on }">
                          <v-btn icon v-on="on" small fab depressed text>
                            <v-icon>more_vert</v-icon>
                          </v-btn>
                        </template>

                        <v-list dense width="">

                          <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                            <v-list-item-icon>
                              <v-icon color="#B72C2C">edit</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                          </v-list-item>

                          <v-list-item v-if="(roless[0].delete=='OUI')" link @click="clearP(item.id)">
                            <v-list-item-icon>
                              <v-icon color="#B72C2C">delete</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                          </v-list-item>

                          <v-list-item link @click="showLit(item.id, item.nom_salle)">
                            <v-list-item-icon>
                              <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                            </v-list-item-icon>
                            <v-list-item-title style="margin-left: -20px">Ajouter les Lits
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

            <v-pagination color="#B72C2C" v-model="pagination.current" :length="pagination.total" @input="onPageChange"
              :total-visible="7"></v-pagination>
          </v-card-text>
        </v-card>
        <!-- component -->
        <!-- fin component -->
      </v-flex>
    </v-flex>
    <v-flex md2></v-flex>
  </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import Lit from './Lit.vue';

export default {
  components: {
    Lit
  },
  data() {
    return {
      title: "Categorie component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      svData: {
        id: "",
        nom_salle: "",
        PrixSalle: 0
      },
      fetchData: null,
      titreModal: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Salle";
      this.edit = false;
      this.resetObj(this.svData);
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

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.nom_salle;
      } else {
        this.titleComponent = "Ajout Salle ";
      }
    }
    ,

    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_salle?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_salle`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);
            this.onPageChange();

            this.dialog = false;
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });
      }
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_salle/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.nom_salle;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_salle/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },
    showLit(refSalle, name) {

      if (refSalle != '') {

        this.$refs.Lit.$data.etatModal = true;
        this.$refs.Lit.$data.refSalle = refSalle;
        this.$refs.Lit.$data.svData.refSalle = refSalle;
        this.$refs.Lit.fetchDataList();
        this.$refs.Lit.fetchAccess();
        this.fetchDataList();

        this.$refs.Lit.$data.titleComponent =
          "AJouter les lits de la salle " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },


  },
  created() {
    //this.getRole();
    this.testTitle();
    this.onPageChange();
     
  },
};
</script>