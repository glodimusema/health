<template>

<v-row justify="center">
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
            
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Details Sortie <v-spacer></v-spacer>
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
                      <v-autocomplete label="Selectionnez le Medicament" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="medicamentList" item-text="nom_medicament"
                        item-value="id" dense outlined v-model="svData.refmedicament" chips clearable
                        @change="getDetailMedicament(svData.refmedicament)">
                      </v-autocomplete>

                      <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.qteSortie">
                      </v-text-field>

                      <v-text-field type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.puSortie">
                      </v-text-field>

                      <v-autocomplete label="Selectionnez (Date Expiration - Quantité))" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="detailmedicamentList" item-text="dateqte"
                        item-value="id" dense outlined v-model="svData.refDetailMed" chips clearable>
                      </v-autocomplete>

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
                              <th class="text-left">Medicament</th>
                              <th class="text-left">Quantité</th>
                              <th class="text-left">PU($)</th>
                              <th class="text-left">PT($)</th>
                              <th class="text-left">N°Sortie</th>
                              <th class="text-left">Service</th>
                              <th class="text-left">Agent</th>
                              <th class="text-left">DateSortie</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.nom_medicament }}</td>
                              <td>{{ item.qteSortie }}</td>
                              <td>{{ item.puSortie }}</td>
                              <td>{{ item.PTVente }}</td>
                              <td>{{ item.refEnteteSortie }}</td>
                              <td>{{ item.nom_service }}</td>
                              <td>{{ item.nom_agent }}</td>
                              <td>{{ item.dateSortie | formatDate }}</td>
                              <td>
                                <!-- <v-tooltip top color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="editData(item.id)" fab small>
                                        <v-icon color="#B72C2C">edit</v-icon>
                                      </v-btn>
                                    </span>
                                  </template>
                                  <span>Modifier</span>
                                </v-tooltip> -->

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

                                <!-- <v-tooltip top color="black">
                              <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                  <v-btn @click="printBill(item.refEnteteSortie)" fab small
                                    ><v-icon color="blue">print</v-icon></v-btn
                                  >
                                </span>
                              </template>
                              <span>Imprimer Facture</span>
                            </v-tooltip> -->

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
export default {
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEnteteSortie: 0,
      svData: {
        id: '',
        refEnteteSortie: 0,
        refDetailMed: 0,
        refmedicament: 0,
        puSortie: 0,
        qteSortie: 0,
        author: "",

      },
      fetchData: [],
      medicamentList: [],
      detailmedicamentList: [],
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
    // this.fetchListSelection();
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
          this.svData.refEnteteSortie = this.refEnteteSortie;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_detailsortie/${this.svData.id}`,
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
          this.svData.refEnteteSortie = this.refEnteteSortie;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detailsortie`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              // this.dialog = false;
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
    getPrice(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medicament2/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.puSortie = item.pu_medicament;
            // console.log("prix unitaire:"+item.pu);               
          });
          // this.getSvData(this.svData, data.data[0]);           
        }
      );
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailsortie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteSortie = item.refEnteteSortie;
            this.svData.refDetailMed = item.refDetailMed;
            this.svData.puSortie = item.puSortie;
            this.svData.qteSortie = item.qteSortie;
          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detailsortie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_detail_entetesortie/${this.refEnteteSortie}?page=`);

    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medicament2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medicamentList = donnees;
        }
      );
    },

    getDetailMedicament(refmedicament) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_detail_medicament2/${refmedicament}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.detailmedicamentList = donnees;

          donnees.map((item) => {
            this.svData.puSortie = item.pu_medicament;
            // console.log("prix unitaire:"+item.pu);               
          });

        }
      );
    }


  },
  filters: {

  }
}
</script>

