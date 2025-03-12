<template>
  <div>

    <v-layout>

      <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Analyse Imagerie <v-spacer></v-spacer>
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

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-select label="Genre" :items="[
                      { designation: 'Homme' },
                      { designation: 'Femme' }
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.genre"></v-select>
                  </div>
                </v-flex>

                <v-autocomplete label="Selectionnez le Libellé" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="libelleList" item-text="desi_libelle"
                  item-value="id" outlined v-model="svData.refLibelle">
                </v-autocomplete>

                <v-autocomplete label="Selectionnez l'Interval" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="intervalList" item-text="desi_interval"
                  item-value="id" outlined v-model="svData.refInterval">
                </v-autocomplete>

                <v-text-field type="number" label="Score" prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.score">
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
        <v-layout>

          <v-flex md12>
            <v-layout>
              <v-flex md6>
                <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                  outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
              </v-flex>
              <v-flex md5>


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
                  <span>Ajouter Analyse</span>
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
                        <th class="text-left">Genre</th>
                        <th class="text-left">Libellé</th>
                        <th class="text-left">Interval</th>
                        <th class="text-left">Score</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.genre }}</td>
                        <td>{{ item.desi_libelle }}</td>
                        <td>{{ item.desi_interval }}</td>
                        <td>{{ item.score }}</td>
                        <td>
                          <v-tooltip top v-if="(roless[0].update=='OUI')" color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="editData(item.id)" fab small>
                                  <v-icon color="#B72C2C">edit</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Modifier</span>
                          </v-tooltip>

                          <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="deleteData(item.id)" fab small>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Suppression</span>
                          </v-tooltip>

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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //id,refLibelle,refInterval,genre,score,author
      svData: {
        id: '',
        refLibelle: 0,
        refInterval: 0,
        genre: "",
        score: 0,
        author: ""
      },
      fetchData: [],
      libelleList: [],
      intervalList: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListLibelle();
    this.fetchListInsterval();
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
            `${this.apiBaseURL}/update_parametre_score/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_parametre_score`,
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

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_parametre_score/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.genre = item.genre;
            this.svData.refLibelle = item.refLibelle;
            this.svData.refInterval = item.refInterval;
            this.svData.score = item.score;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_parametre_score/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchListLibelle() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_libelleScore2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.libelleList = donnees;
        }

      );
      //console.print(data.data);
    },
    fetchListInsterval() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_IntervalSCore2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.intervalList = donnees;
        }

      );
      //console.print(data.data);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_parametre_score?page=`);
    }

  },
  filters: {

  }
}
</script>
  
  