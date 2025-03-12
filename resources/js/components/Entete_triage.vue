<template>
  <v-layout>    
    <v-flex md12>
      <DetailTriage ref="DetailTriage" />
      <br /><br />
      <v-layout>        
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

            </v-flex>
          </v-layout>
          <br />
          <v-card :loading="loading" :disabled="loading">
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">DateTriage</th>
                      <th class="text-left">DateMouvement</th>
                      <th class="text-left">NumeroBon</th>
                      <th class="text-left">Statut</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.dateTriage | formatDate }}</td>
                      <td>{{ item.dateMouvement | formatDate }}</td>
                      <td>{{ item.numroBon }}</td>
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

                            <v-list-item link @click="showDetailTriage(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-account-star</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Complètez les signes vitaux
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="deleteData(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">delete</v-icon>
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
import DetailTriage from './DetailTriage.vue';

export default {
  components: {
    DetailTriage
  },
  data() {
    return {

      title: "Liste des Triages",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //'noms','contact','mail'
      svData: {
        id: '',
        dateTriage: "",
        refMouvement: ""
      },
      fetchData: [],
      clientList: [],
      personneList: [],
      don: [],
      query: "",

    }
  },
  created() {
    this.fetchDataList();
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {
    ...mapActions(["getCategory"]),
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteTriage/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.fetch_data(`${this.apiBaseURL}/fetch_entetetriage?page=`);
    },

    showDetailTriage(refEnteteTriage, name) {

      if (refEnteteTriage != '') {

        this.$refs.DetailTriage.$data.etatModal = true;
        this.$refs.DetailTriage.$data.refEnteteTriage = refEnteteTriage;
        this.$refs.DetailTriage.$data.svData.refEnteteTriage = refEnteteTriage;
        this.$refs.DetailTriage.fetchDataList();
        this.$refs.DetailTriage.fetchListSelection();
        this.$refs.DetailTriage.fetchListSalle();

        this.$refs.DetailTriage.$data.titleComponent =
          "Les Signes vitaux pour " + name;

          console.log("Signes pour "+this.$refs.DetailTriage.$data.titleComponent);

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>
  
  