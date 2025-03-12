<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <EnteteLabo_Resultat ref="EnteteLabo_Resultat" />
        <DetailEchantillon ref="DetailEchantillon" />
        <EnteteBesoin ref="EnteteBesoin" />
        <EnteteUsage ref="EnteteUsage" />

        <v-dialog v-model="dialog" max-width="600px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Prelevement des Echantillons <v-spacer></v-spacer>
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

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                        item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refService" chips
                        clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Demandeur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList1"
                        item-text="noms_medecin" item-value="noms_medecin" dense outlined
                        v-model="svData.MedecinDemandeur" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date demande" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.dateprelevement"></v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Numéro reçu" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.numroRecu"></v-text-field>
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

        <v-dialog v-model="dialog3" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Valider les Analyses <v-spacer></v-spacer>
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
                    <v-select label="Prélevé" :items="[
                      { designation: 'OUI' },
                      { designation: 'NON' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      item-text="designation" item-value="designation" v-model="svData.preleveur"></v-select>
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
                      <v-btn @click="fetchDataList()" fab color="#B72C2C" dark>
                        <v-icon>mdi-refresh</v-icon>
                      </v-btn>
                    </span>
                  </template>
                  <span>Actualiser</span>
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
                        <th class="text-left">Patient</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">Catégorie</th>
                        <th class="text-left">ServiceDemandeur</th>
                        <th class="text-left">DateDemande</th>
                        <th class="text-left">MedecinMedandeur</th>
                        <th class="text-left">N°Réçu.</th>
                        <th class="text-left">Finance</th>
                        <th class="text-left">Prélévé(e)</th>                        
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>
                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <v-list-item link @click="showLaboratoire(item.id, item.noms, item.nom_uniteproduction)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Voir les examans
                                </v-list-item-title>
                              </v-list-item>


                              <v-list-item link @click="editDataLabo(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Envoyer les Echantillons</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showDetailEchantillon(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Les Echantillons
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showEnteteBesoin(item.refMouvement, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Faire un Etat de Besoin pour ce Patient
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showEnteteUsage(item.refMouvement, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Fiche de sortie des Produits
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                              </v-list-item>
                              <!-- /DiagnosticDef/:id -->
                              <v-list-item link @click="printBilletLabo(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Billet Laboratoire</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printResultat(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Rendu des Resultats</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printResultatSperme(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Resultats Spermogramme</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printResultatBacterie(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Resultats du Test Bacteriologique</v-list-item-title>
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
                        <td>{{ item.codePreleve }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.categoriemaladiemvt }} - {{ item.organisationAbonne }}</td>
                        <td>{{ item.nom_uniteproduction }}</td>
                        <td>{{ item.dateprelevement }}</td>
                        <td>{{ item.MedecinDemandeur }}</td>
                        <td>{{ item.numroRecu }}</td>
                        <td>{{ item.statutprelevement }}</td>
                        <td>{{ item.preleveur }}</td>

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

  <!--  -->
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import DetailEchantillon from './DetailEchantillon.vue';
import EnteteLabo_Resultat from './EnteteLabo_Resultat.vue';
import EnteteBesoin from "../Pharmacies/EnteteBesoin.vue";
import EnteteUsage from "../Pharmacies/EnteteUsage.vue";
export default {
  components: {
    EnteteLabo_Resultat,
    DetailEchantillon,
    EnteteBesoin,
    EnteteUsage
  },
  data() {
    return {
      //'id','refDetailCons','refService','dateprelevement','numroRecu','MedecinDemandeur','author'

      title: "Liste des Details",
      dialog: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refDetailCons: 0,
      svData: {
        id: '',
        refDetailCons: 0,
        refService: "",
        dateprelevement: "",
        numroRecu: "",
        MedecinDemandeur: "",
        author: "",
        preleveur: "",
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        ServiceList: [],
        medecinList1: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListSelection();
    this.fetchListSelection1();
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entete_prelevement/${this.svData.id}`,
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_entete_prelevement`,
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
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    printBilletLabo(id) {
      window.open(`${this.apiBaseURL}/pdf_billetlabo_data?id=` + id);
    },

    printResultat(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatlabo_data?id=` + id);
    },
    printResultatSperme(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatsperme_data?id=` + id);
    },
    printResultatBacterie(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatbacteriologie_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entete_prelevement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.refService = item.refService;
            this.svData.dateprelevement = item.dateprelevement;
            this.svData.numroRecu = item.numroRecu;
            this.svData.MedecinDemandeur = item.MedecinDemandeur;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },

    // 'id','refDetailCons','refService','dateprelevement','numroRecu',
    // 'MedecinDemandeur',"statutprelevement","preleveur",'author'
    editDataLabo(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entete_prelevement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.refService = item.refService;
            this.svData.dateprelevement = item.dateprelevement;
            this.svData.numroRecu = item.numroRecu;
            this.svData.MedecinDemandeur = item.MedecinDemandeur;
            this.svData.preleveur = item.preleveur;
          });

          this.edit = true;
          this.dialog3 = true;
        }
      );
    },

    validateLabo() {
      this.svData.author = this.userData.name;
      this.insertOrUpdate(
        `${this.apiBaseURL}/update_preleveur/${this.svData.id}`,
        JSON.stringify(this.svData)
      )
        .then(({ data }) => {
          this.showMsg(data.data);
          this.isLoading(false);
          this.edit = false;
          this.dialog3 = false;
          this.resetObj(this.svData);
          this.fetchDataList();
        })
        .catch((err) => {
          this.svErr(), this.isLoading(false);
        });
    },
    //
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entete_prelevement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_valide_prelevement?page=`);

    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },

    fetchListSelection1() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList1 = donnees;

        }
      );

    },
    // fetchListServices
    showLaboratoire(refEntetePrelevement, name, serviceProvenance) {

      if (refEntetePrelevement != '') {

        this.$refs.EnteteLabo_Resultat.$data.etatModal = true;
        this.$refs.EnteteLabo_Resultat.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo_Resultat.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo_Resultat.$data.serviceProvenance = serviceProvenance;
        this.$refs.EnteteLabo_Resultat.fetchDataList();
        this.$refs.EnteteLabo_Resultat.fetchListSelection();
        this.$refs.EnteteLabo_Resultat.fetchListServices();
        this.fetchDataList();

        this.$refs.EnteteLabo_Resultat.$data.titleComponent =
          "Les Resultats des analyses au Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    // fetchListServices
    showDetailEchantillon(refEntetePrelevement, name) {

      if (refEntetePrelevement != '') {

        this.$refs.DetailEchantillon.$data.etatModal = true;
        this.$refs.DetailEchantillon.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailEchantillon.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.DetailEchantillon.fetchDataList();
        this.$refs.DetailEchantillon.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailEchantillon.$data.titleComponent =
          "Les Echantillons pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteBesoin(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteBesoin.$data.etatModal = true;
        this.$refs.EnteteBesoin.$data.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.fetchDataList();
        this.$refs.EnteteBesoin.fetchListService();
        this.$refs.EnteteBesoin.fetchListSalle();
        this.fetchDataList();
 
        this.$refs.EnteteBesoin.$data.titleComponent =
          "Fiche d'Etat de Besoin pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteUsage(refMouvement, name) {

      if (refMouvement != '') {
        this.$refs.EnteteUsage.$data.etatModal = true;
        this.$refs.EnteteUsage.$data.refMouvement = refMouvement;
        this.$refs.EnteteUsage.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteUsage.fetchDataList();
        this.$refs.EnteteUsage.fetchListService();
        this.$refs.EnteteUsage.fetchListSalle();

        this.$refs.EnteteUsage.$data.titleComponent =
          "Fiche d'Utilisation pour " + name;

      } 
      else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>
  
  