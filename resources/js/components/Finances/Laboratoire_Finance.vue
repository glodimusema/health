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
              <!--   -->
              <v-flex md12>
                <v-dialog v-model="dialog" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Examen <v-spacer></v-spacer>
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

                        <v-text-field type="date" label="Date " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateLabo">
                        </v-text-field>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Grande Catégorie" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.GrandCategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refGrandCategorie"
                              chips clearable @change="get_categorie_for_GrandCat(svData.refGrandCategorie)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Catégorie" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.CategorieList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refCatexamen"
                              clearable chips @change="get_examen_for_Categorie(svData.refCatexamen)">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                              chips>
                            </v-autocomplete>
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


                <br /><br />

                <v-dialog v-model="dialog3" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Valider la consultation <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog3 = false" text fab depressed>
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
                            <v-select label="Etat" :items="[
                              { designation: 'Attente' },
                              { designation: 'Validé' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation"
                              v-model="svData.statutentetelabo"></v-select>
                          </div>
                        </v-flex>
                        <!--  -->
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog3 = false"> Fermer </v-btn>
                        <v-btn color="#B72C2C" dark :loading="loading" @click="validateLabo">
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
                          <span>Affecter les Examens</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card>
                      <!-- ,'ValeurNormale2','observation2' -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">Examen</th>
                                <th class="text-left">Categorie</th>
                                <th class="text-left">GrandCat.</th>
                                <th class="text-left">Couleur</th>
                                <th class="text-left">Resultat</th>
                                <th class="text-left">Unité</th>
                                <th class="text-left">Etat</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.designationEx }}</td>
                                <td>{{ item.designationCatEx }}</td>
                                <td>{{ item.designationGCatEx }}</td>
                                <td>

                                  <v-btn elevation="2" x-small class="white--text"
                                    :color="item.codeTube == 'S' ? '#ff3333' : item.codeTube == 'C' ? '#00B0F0' : item.codeTube == 'H' ? '#92D050' : item.codeTube == 'E' ? '#7030A0' : item.codeTube == 'F' ? '#A6A6A6' : 'error'"
                                    depressed>
                                    {{ item.codeTube == 'S' ? "S" : item.codeTube == 'C' ? "C" : item.codeTube == 'H' ? "H"
                                      : item.codeTube == 'E' ? "E" : item.codeTube == 'F' ? "F" : 'S' }}
                                  </v-btn>

                                </td>
                                <td>{{ item.resultat2 }}</td>
                                <td>{{ item.unite2 }}</td>
                                <td>{{ item.statutentetelabo }}</td>
                                <td>


                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>
                                    <!--  -->

                                    <v-list dense width="">

                                      <v-list-item link @click="validateLabo(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-marker</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Autoriser Cet
                                          Examen</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="printBill(item.refEntetePrelevement)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Annuler</v-list-item-title>
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
export default {
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEntetePrelevement: 0,
      serviceProvenance: "",
      //'refEntetePrelevement','refExamen','dateLabo','author'
      svData: {
        id: '',
        refEntetePrelevement: 0,
        refGrandCategorie: "",
        refCatexamen: "",
        refExamen: "",
        author: "Admin",
        dateLabo: "",
        statutentetelabo: "",
        serviceProvenance: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        GrandCategorieList: [],
        CategorieList: [],
        ExamenList: [],
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {
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
          this.svData.refEntetePrelevement = this.refEntetePrelevement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetelaboratoire/${this.svData.id}`,
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
          this.svData.refEntetePrelevement = this.refEntetePrelevement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entetelaboratoire`,
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
    getPrice(id) {
      this.editOrFetch(`${this.apiBaseURL}/a1/fetch_single_produit/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.puVente = item.pu;
            // console.log("prix unitaire:"+item.pu);               
          });
          // this.getSvData(this.svData, data.data[0]);           
        }
      );
    },

    validateLabo(code) {

      this.isLoading(true);
      this.svData.author = this.userData.name;
      this.svData.id = code;
      this.insertOrUpdate(
        `${this.apiBaseURL}/update_statutexamen/${this.svData.id}`,
        JSON.stringify(this.svData)
      )//
        .then(({ data }) => {
          this.showMsg(data.data);
          this.isLoading(false);
          this.edit = false;
          // this.dialog3 = false;
          this.resetObj(this.svData);
          this.fetchDataList();
        })
        .catch((err) => {
          this.svErr(), this.isLoading(false);
        });

    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntetePrelevement = item.refEntetePrelevement;
            this.svData.refExamen = item.refExamen;
            this.svData.statutentetelabo = item.statutentetelabo;
          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    editDataLabo(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntetePrelevement = item.refEntetePrelevement;
            this.svData.refExamen = item.refExamen;
            this.svData.statutentetelabo = item.statutentetelabo;
          });

          this.edit = true;
          this.dialog3 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetelaboratoire/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entete_labo_attente/${this.refEntetePrelevement}?page=`);

    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_GrandCategorie`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.GrandCategorieList = donnees;

        }
      );
    },
    //fultrage de donnees
    async get_categorie_for_GrandCat(id_Grandcat) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_CatexamenForGrandCat/${id_Grandcat}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.CategorieList = chart;
          } else {
            this.stataData.CategorieList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

    //fultrage de donnees
    async get_examen_for_Categorie(id_categorie) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_ExamenForCat/${id_categorie}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.ExamenList = chart;
          } else {
            this.stataData.ExamenList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    valider_Examen(code) {
      this.isLoading(true);
      this.svData.author = this.userData.name;
      this.svData.id = code;
      this.insertOrUpdate(
        `${this.apiBaseURL}/valider_divison/${this.svData.id}`,
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


  },
  filters: {

  }
}
</script>
  
  