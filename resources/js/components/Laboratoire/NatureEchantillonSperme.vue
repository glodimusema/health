<template>
  <v-layout>
    <v-flex md2></v-flex>
    <v-flex md8>
      <v-flex md12>
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

                <v-layout row wrap>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Designation" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.designation_nature"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Veleur" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.designation_valeur"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieList"
                        item-text="nom_categorieechantillon" item-value="id" outlined
                        v-model="svData.refCategorieEchantillon">
                      </v-autocomplete>
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
                    <th class="text-left">Valeur</th>
                    <th class="text-left">Catégorie</th>
                    <th class="text-left">Author</th>
                    <th class="text-left">Mise à jour</th>
                    <th class="text-left">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in fetchData" :key="item.id">
                    <td>{{ item.designation_nature }}</td>
                    <td>{{ item.designation_valeur }}</td>
                    <td>{{ item.nom_categorieechantillon }}</td>
                    <td>{{ item.author }}</td>
                    <td>
                      {{ item.created_at}}
                      <!-- {{ item.created_at | formatDate }}
                      {{ item.created_at | formatHour }} -->
                    </td>

                    <td>
                      <v-tooltip top v-if="(roless[0].update=='OUI')" color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="editData(item.id)" fab small><v-icon color="#B72C2C">edit</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Modifier</span>
                      </v-tooltip>

                      <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="clearP(item.id)" fab small><v-icon color="#B72C2C">delete</v-icon></v-btn>
                          </span>
                        </template>
                        <span>Supprimer</span>
                      </v-tooltip>
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
export default {
  components: {},
  data() {
    return {
      title: "Pays component",
      header: "Crud operation",
      titleComponent: "",
      query: "",
      dialog: false,
      loading: false,
      disabled: false,
      edit: false,
      //'id','designation_nature','designation_valeur','refCategorieEchantillon','author'
      svData: {
        id: "",
        designation_nature: "",
        designation_valeur: "",
        refCategorieEchantillon: 0,
        author: "",
      },
      fetchData: null,
      titreModal: "",
      categorieList: [],
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''
    };
  },
  computed: {
    ...mapGetters(["roleList", "isloading"]),
  },
  methods: {
    ...mapActions(["getRole"]),

    showModal() {
      this.dialog = true;
      this.titleComponent = "Ajout Nature Echantillon";
      this.edit = false;
      this.resetObj(this.svData);
    },

    testTitle() {
      if (this.edit == true) {
        this.titleComponent = "modification de " + item.designation_nature;
      } else {
        this.titleComponent = "Ajout pays ";
      }
    }
    ,

    //   searchMember: _.debounce(function () {
    //     this.onPageChange();
    //   }, 300),
    onPageChange() {
      this.fetch_data(`${this.apiBaseURL}/fetch_nature_echantillon?page=`);
    },

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.author = this.userData.name;
        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_nature_echantillon`,
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
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_nature_echantillon/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.titleComponent = "modification de " + item.designation_nature;
          });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    clearP(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_nature_echantillon/${id}`).then(
          ({ data }) => {
            this.successMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_tlabo_categorie_echantillon_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.categorieList = donnees;

        }
      );
    },


  },
  created() {
     
    this.testTitle();
    this.onPageChange();
    this.fetchListSelection();
  },
};
</script>