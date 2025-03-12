<template>


  <v-row justify="center">

    <Hospi_DetailBilanHydrique ref="Hospi_DetailBilanHydrique" />

    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- container -->

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
            <!--   -->
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="600px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Bilan Hydrique <v-spacer></v-spacer>
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

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              TOTAL ENTREE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              TOTAL SORTIE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.dateBilan"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Par 24h00" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.totalEntree"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Par 24h00" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.totalSortie"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Hydrique (BH = IN - OUT)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.hydrique"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.poids"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly type="number" label="SC (((4*poids)+7)/(90 + poids))"
                              prepend-inner-icon="extension" outlined dense
                              v-model="svData.sc"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly type="number" label="Pertes Insensible (pi = SC * 500 ml)"
                              prepend-inner-icon="extension"  outlined dense
                              v-model="svData.PertesInsensible"></v-text-field>
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
                
                <v-flex md12>
                  <v-layout>
                    <v-flex md6>
                      <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                        outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','dateBilan2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Date</th>
                              <th class="text-left">Hydrique</th>
                              <th class="text-left">Poids</th>
                              <th class="text-left">SC</th>
                              <th class="text-left">Perte_Ins.</th>
                              <th class="text-left">author</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateBilan }}</td>
                              <td>{{ item.hydrique }}</td>
                              <td>{{ item.poidsHydrique }}</td>
                              <td>{{ item.sc }}</td>
                              <td>{{ item.PertesInsensible }}</td>
                              <td>{{ item.author }}</td>
                              <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">


                                    <v-list-item link @click="showDetailBilan(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-anchor</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Details Bilan
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
import Hospi_DetailBilanHydrique from './Hospi_DetailBilanHydrique.vue';

export default {
  components: {
    Hospi_DetailBilanHydrique
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
      refHospi: 0,
      svData: {
        id: '',
        refHospi: 0,
        dateBilan: "",
        totalEntree: "",
        totalSortie: "",
        hydrique: "",
        poids: 0,
        author: "",
      },
      fetchData: [],
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
          this.svData.refHospi = this.refHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_bilan_hydrique/${this.svData.id}`,
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
          this.svData.refHospi = this.refHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_bilan_hydrique`,
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
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_bilan_hydrique/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refHospi = item.refHospi;
            this.svData.dateBilan = item.dateBilan;
            this.svData.totalEntree = item.totalEntree;
            this.svData.totalSortie = item.totalSortie;
            this.svData.hydrique = item.hydrique;
            this.svData.poids = item.poids;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_thospi_bilan_hydrique/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_bilan_hydrique_hospi/${this.refHospi}?page=`);
      //
    },
    showDetailBilan(refBilan, name) {

        if (refBilan != '') {

          this.$refs.Hospi_DetailBilanHydrique.$data.etatModal = true;
          this.$refs.Hospi_DetailBilanHydrique.$data.refBilan = refBilan;
          this.$refs.Hospi_DetailBilanHydrique.$data.svData.refBilan = refBilan;
          this.$refs.Hospi_DetailBilanHydrique.fetchDataList();
          this.fetchDataList();
          
          this.$refs.Hospi_DetailBilanHydrique.$data.titleComponent =
            "Detail Bilan Hydrique pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    }

  },
  filters: {

  }
}
</script>
  
  