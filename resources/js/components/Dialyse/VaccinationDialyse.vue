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
              <v-dialog v-model="dialog" max-width="700px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Vaccination Dialyse <v-spacer></v-spacer>
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
                          <v-text-field type="date" label="Dates" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dateVaccin"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Machine" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.MeterielList"
                            item-text="nomTypeMachine" item-value="id" dense outlined v-model="svData.refTypeMachine" chips
                            clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Catégorie du Vaccin" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CategorieVaccinList"
                            item-text="nomCategorieVac" item-value="id" dense outlined v-model="svData.refcategorieVac" chips
                            clearable @change="get_vaccin_for_Categorie(svData.refcategorieVac)">
                          </v-autocomplete>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Vaccin" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.VaccinList"
                            item-text="nomVaccinDyal" item-value="id" dense outlined v-model="svData.refVaccinDyalise" clearable
                            chips>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Dose" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dose"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Dosage du litre" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dosageLitre"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Observation" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.observation"></v-text-field>
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
                        <span>Ajouter Diagnostics</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,,'dateVaccin','dose','dosageLitre','observation','infirmier' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Dates</th>
                              <th class="text-left">Vaccin</th>
                              <th class="text-left">Dose</th>
                              <th class="text-left">DoseLitre</th>
                              <th class="text-left">Observation</th>
                              <th class="text-left">Infirmier</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.dateVaccin }}</td>
                              <td>{{ item.nomVaccinDyal }}</td>
                              <td>{{ item.dose }}</td>
                              <td>{{ item.dosageLitre }}</td>
                              <td>{{ item.observation }}</td>
                              <td>{{ item.infirmier }}</td>
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

                                    <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">delete</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                    </v-list-item>

                                    <!-- <v-list-item link router :to="'/admin/entete_labo/'+item.id">
                                  <v-list-item-icon>
                                    <v-icon>mdi-anchor</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                                  </v-list-item-title>
                                </v-list-item>-->

                                    <!-- <v-list-item link  @click="printBill(item.refEnteteDyalise)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                                </v-list-item>  -->

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
      edit: false,
      loading: false,
      disabled: false,

      etatModal: false,
      titleComponent: '',
      refEnteteDyalise: 0,

      svData: {
        id: '',
        refEnteteDyalise: 0,
        refTypeMachine: 0,
        refVaccinDyalise: 0,
        dateVaccin: "",
        dose: "",
        dosageLitre: "",
        observation: "",
        infirmier: "",
        auther: "",
        refcategorieVac: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        MeterielList: [],
        CategorieVaccinList: [],
        VaccinList: [],
        medecinList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    // this.fetchDataList();
    // this.fecchListMachine();
    // this.fecchListCategorieVaccin();
     
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.auther = this.userData.name;
          this.svData.infirmier=this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_vaccinationDyalise/${this.svData.id}`,
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.auther = this.userData.name;
          this.svData.infirmier=this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_vaccinationDyalise`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_vaccinationDyalise/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteDyalise = item.refEnteteDyalise;
            this.svData.refTypeMachine = item.refTypeMachine;
            this.svData.dose = item.dose;
            this.svData.dosageLitre = item.dosageLitre;
            this.svData.observation = item.observation;
            this.svData.refVaccinDyalise = item.refVaccinDyalise;

          });
          this.get_vaccin_for_Categorie(this.svData.refcategorieVac);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_vaccinationDyalise/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_vaccination_dialyse/${this.refEnteteDyalise}?page=`);

    },
    fecchListMachine() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_type_machine2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MeterielList = donnees;

        }
      );
    },
    fecchListCategorieVaccin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_categorievaccin2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.CategorieVaccinList = donnees;
        }
      );
    },
    async get_vaccin_for_Categorie(id_CatgorieVaccin) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_vaccin_categorie2/${id_CatgorieVaccin}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.VaccinList = chart;
          } else {
            this.stataData.VaccinList = [];
          }

          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    }


  },
  filters: {

  }
}
</script>
  
  