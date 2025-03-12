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
              <!--    -->
              <v-flex md12>
                <DetailLabo ref="DetailLabo" />
                <ResultatSpermatique ref="ResultatSpermatique" />
                <Annexe_Laboratoire ref="Annexe_Laboratoire" />
                <ResultatBacteriologie ref="ResultatBacteriologie" />

                <!-- ResultatSpermatique,
      Annexe_Laboratoire -->

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

                        <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                                chips @change="getCategorie(svData.refExamen)">
                                </v-autocomplete>
                            </div>
                        </v-flex>


                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Catégorie Examen" prepend-inner-icon="extension"
                        dense  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationCat"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Grande Catégorie Examen" prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationGCat"></v-text-field>
                      </div>
                    </v-flex> 


                        <!-- <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                            item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                            v-model="svData.serviceProvenance" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex> -->

                        <!-- <v-flex xs12 sm12 md12 lg12>
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
                        </v-flex> -->




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

                <v-dialog v-model="dialog2" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Examen <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog2 = false" text fab depressed>
                                <v-icon>close</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Fermer</span>
                        </v-tooltip>
                      </v-card-title>
                      <v-card-text>

                        <!-- <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                                chips @change="getCategorie(svData.refExamen)">
                                </v-autocomplete>
                            </div>
                        </v-flex>


                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Catégorie Examen" prepend-inner-icon="extension"
                        dense  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationCat"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Grande Catégorie Examen" prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationGCat"></v-text-field>
                      </div>
                    </v-flex>  -->


                        <!-- <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                            item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                            v-model="svData.serviceProvenance" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex> -->

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Type Selection" :items="[
                            { designation: 'Selection par paquet' },
                            { designation: 'Selection partielle' }
                          ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.type_paquet"></v-select>
                        </div>
                      </v-flex>

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
                              clearable chips>
                              <!-- clearable chips @change="get_examen_for_Categorie(svData.refCatexamen)"> -->
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <!-- <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                              item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                              chips>
                            </v-autocomplete>
                          </div>
                        </v-flex> -->




                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
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

                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog2 = true" fab color="#B72C2C" dark>
                                <v-icon>mdi-account-multiple-plus</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Demander les examens par Pacquet</span>
                        </v-tooltip>
                        
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card :loading="loading" :disabled="loading">
                      <!-- ,'ValeurNormale2','observation2' -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Action</th>
                                <th class="text-left">N°Prélev.</th>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Examen</th>
                                <th class="text-left">Resultat</th>
                                <th class="text-left">Unité</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">Service(Orig.)</th>
                                <th class="text-left">Categorie</th>
                                <th class="text-left">GrandCat.</th>
                                <th class="text-left">Couleur</th>
                                <th class="text-left">Etat</th>                                
                              </tr>
                            </thead>
                            <tbody>

                              <!-- codePreleve -->
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>
                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showDetailLaboratire(item.id, item.noms,item.refEntetePrelevement,item.designationEx)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-anchor</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Voir détails sur les Résultats
                                      </v-list-item-title>
                                    </v-list-item>

                                      <v-list-item link @click="showResultatSperme(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Resultats Spermes
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link
                                        @click="showResultatBacteriologie(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Résultats des analyses Bactériologiques
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showAnnexeLaboratoire(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Les Annexes des Resultats
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

                                      <v-list-item link @click="printBill(item.refEntetePrelevement)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                                      </v-list-item>

                                    </v-list>
                                  </v-menu>

                                </td>
                                <td>{{ item.codePreleve }}</td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.designationEx }}</td>
                                <td>{{ item.resultat2 }}  {{ item.commentaire2 }}</td>
                                <td>{{ item.unite2 }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.serviceProvenance }}</td>
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
                                <td>{{ item.statutentetelabo }}</td>

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
import Annexe_Laboratoire from './Annexe_Laboratoire.vue';
import DetailLabo from './DetailLabo.vue';
import ResultatSpermatique from './ResultatSpermatique.vue';
import ResultatBacteriologie from './ResultatBacteriologie.vue';


export default {
  components: {
    DetailLabo,
    ResultatSpermatique,
    Annexe_Laboratoire,
    ResultatBacteriologie
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEntetePrelevement: 0,
      serviceProvenance: "",
      svData: {
        id: '',
        refEntetePrelevement: 0,
        refGrandCategorie: "",
        refCatexamen: "",
        refExamen: "",
        author: "Admin",
        dateLabo: "",
        serviceProvenance: "",
        type_paquet:'',        

        designationCat:"",
        designationGCat:"",
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        GrandCategorieList: [],
        CategorieList: [],
        ExamenList: [],
        ServiceList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    // this.fetchDataList();
    // this.fetchListSelection();
    // this.fetchListServices()
    // this.get_examen_all();

    this.fetchListGrandeCategorie();
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
          //serviceProvenance
          this.svData.refEntetePrelevement = this.refEntetePrelevement;
          this.svData.serviceProvenance = this.serviceProvenance;
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
          this.svData.serviceProvenance = this.serviceProvenance;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entetelaboratoire`,
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

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoire/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEntetePrelevement = item.refEntetePrelevement;
            this.svData.serviceProvenance = item.serviceProvenance;
            this.svData.refExamen = item.refExamen;
          });

          this.edit = true;
          this.dialog = true;
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
    fetchListGrandeCategorie() {
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
    }
    ,
    backPage() {
      this.$router.go(-1);
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showDetailLaboratire(refEnteteLabo, name, refEntetePrelevement, designationEx) {

      if (refEnteteLabo != '') {

        this.$refs.DetailLabo.$data.etatModal = true;
        this.$refs.DetailLabo.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLabo.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailLabo.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLabo.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailLabo.fetchDataList();
        this.$refs.DetailLabo.get_methode_Examen();
        this.$refs.DetailLabo.get_nature_Echantillon();
        
        // this.$refs.DetailLabo.getDataEchantillon(refEntetePrelevement);
        this.fetchDataList();

        this.$refs.DetailLabo.$data.titleComponent =
        "Voir les Resultats de l'examen "+designationEx+" pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    showResultatSperme(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.ResultatSpermatique.$data.etatModal = true;
        this.$refs.ResultatSpermatique.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatSpermatique.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatSpermatique.fetchDataList();
        this.$refs.ResultatSpermatique.fetchListSelection();
        this.fetchDataList();

        this.$refs.ResultatSpermatique.$data.titleComponent =
          "Resultats des Spermes pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    showAnnexeLaboratoire(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.Annexe_Laboratoire.$data.etatModal = true;
        this.$refs.Annexe_Laboratoire.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.Annexe_Laboratoire.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.Annexe_Laboratoire.fetchDataList();
        this.fetchDataList();

        this.$refs.Annexe_Laboratoire.$data.titleComponent =
          "Les annexe des Resultats pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    // fetchListServices
    showResultatBacteriologie(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.ResultatBacteriologie.$data.etatModal = true;
        this.$refs.ResultatBacteriologie.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatBacteriologie.$data.svData.refEnteteLabo = refEnteteLabo;
        this.$refs.ResultatBacteriologie.fetchDataList();
        this.$refs.ResultatBacteriologie.fetchListSelection1();
        this.fetchDataList();

        this.$refs.ResultatBacteriologie.$data.titleComponent =
          "Resultats des analyses Bacteriologiques pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }
    ,
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },
      //fultrage de donnees
      async get_examen_all() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_texamen_2`)
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
      getCategorie(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_examen/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.designationCat = item.designationCat; 
              this.svData.designationGCat = item.designationGCat; 
                           
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      }




  },
  filters: {

  }
}
</script>
  
  