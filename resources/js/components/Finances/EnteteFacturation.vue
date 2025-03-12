<template>

<v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="900px" fullscreen>
      <v-card>
        <!-- container -->

        <v-card-title class="red">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etatModal = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout  -->

          <div>
              <v-layout>
                <!--   -->
                <v-flex md12>

                  <DetailFacturation ref="DetailFacturation" />
                  <PaiementFacture ref="PaiementFacture" />

                  <v-dialog v-model="dialog" max-width="700px" persistent>
                    <v-card :loading="loading">
                      <v-form ref="form" lazy-validation>
                        <v-card-title>
                          Création d'une Facture <v-spacer></v-spacer>
                          <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="closeForm" text fab depressed>
                                  <v-icon>close</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Fermer</span>
                          </v-tooltip>
                        </v-card-title>
                        <v-card-text>

                          <v-layout row wrap>

                            <!-- <v-text-field type="date" label="Date " prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.datefacture">
                          </v-text-field> -->


                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.DepartementList"
                                  item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement"
                                  clearable chips @change="Get_unite_for_Departement(svData.refDepartement)">
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.UniteList"
                                  item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refUniteProduction"
                                  clearable chips>
                                </v-autocomplete>
                              </div>
                            </v-flex>

                            <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="map"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.MedecinList"
                                  item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" clearable
                                  chips>
                                </v-autocomplete>
                              </div>
                            </v-flex>
<!-- 
                            <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-select label="Etat" :items="[
                                  { designation: 'CASH'},
                                  { designation: 'CREDIT'}
                                ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  item-text="designation" item-value="designation" v-model="svData.statut"></v-select>
                              </div>
                            </v-flex> -->

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
                            <span>Ajouter</span>
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
                                <!-- statutentetecons codeFacture -->
                                <tr>
                                  <th class="text-left">Action</th>
                                  <th class="text-left">N°Facture</th>
                                  <th class="text-left">Malade</th>
                                  <th class="text-left">Categorie</th>
                                  <th class="text-left">DateFacture</th>
                                  <th class="text-left">Services</th>
                                  <th class="text-left">Medecin</th>
                                  <th class="text-left">Departement</th>
                                  <th class="text-left">SoldeFact.</th>                                  
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

                                        <v-list-item v-if="item.totalPaie == 0 || item.totalPaie == null"  link @click="showDetailFacturation(item.id, item.noms,item.organisationAbonne,item.refMouvement)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">mdi-briefcase-check</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Ajouter les details
                                            Facture
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="showPaieFacturation(item.id,item.noms)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">mdi-cards</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Enregistrer Paiement
                                            Facture</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Annuler la Facture</v-list-item-title>
                                        </v-list-item>

                                        <!-- <v-list-item v-if="item.RestePaie != 0 || item.totalPaie == null || (modifier=='OUI')" link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.RestePaie != 0 || item.totalPaie == null || (supprimer=='OUI')" link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Annuler la Facture</v-list-item-title>
                                        </v-list-item> -->

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveeGF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Privé(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveePF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Privé(e)s (A6)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneeGF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Abonné(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneePF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Abonné(e)s (A6)</v-list-item-title>
                                        </v-list-item>

                                        <!-- SYNTHESE -->

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveeGF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Privé(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveePF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Privé(e)s (A6)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneeGF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Abonné(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneePF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Abonné(e)s (A6)</v-list-item-title>
                                        </v-list-item>


                                      </v-list>
                                    </v-menu>

                                  </td>                   
                                  <td>{{ item.codeFacture }}</td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.categoriemaladiemvt }}</td>
                                  <td>{{ item.datefacture }}</td>
                                  <td>{{ item.nom_uniteproduction }}</td>
                                  <td>{{ item.noms_medecin }}</td>
                                  <td>{{ item.nom_departement }}</td>
                                  <td>{{ item.RestePaie }}</td>
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
<!--  -->
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
import DetailFacturation from './DetailFacturation.vue';
import PaiementFacture from './PaiementFacture.vue';

export default {
  components: {
    DetailFacturation,
    PaiementFacture
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refMouvement:0,
      //'id','refMouvement','refUniteProduction','refMedecin','datefacture','statut','author'
      svData: {
        id: '',
        refMouvement: 0,
        refDepartement: "",
        refUniteProduction: "",
        refMedecin: "",
        //datefacture: "", 
        statut: "",
        author: "",

        // Partie Detail Facture
        refEnteteFacturation: "",
        refProduit: 0,
        quantite: 0,
        prixunitaire: 0,
        refMouvement: 0,
        categorieMalade: "",
        refTypeProduit: 0,
        organisationAbonne:"",

        // Partie Paement
        montantpaie: 0,
        datepaie: "",
        modepaie: "",
        libellepaie: "",
      },
      fetchData: [],
      ModeList: [],
      don: [],
      query: "",
      stataData: {
        DepartementList: [],
        UniteList: [],
        produitList: [],
        typeproduitList: [],
        MedecinList: [],
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
    // this.fetchDataList();
    // this.fetchListDepartement();
    // this.fetchListmedecin();
       
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
          this.svData.refMouvement=this.refMouvement;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_entetefacturation/${this.svData.id}`,
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
          this.svData.refMouvement=this.refMouvement;
          this.svData.author = this.userData.name;

          if (this.$refs.form.validate()) {
          this.isLoading(true);
          //refService
          this.editOrFetch(`${this.apiBaseURL}/insert_entetefacturation?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.refEnteteFacturation = item.id;
                this.svData.noms=item.noms;
                this.svData.organisationAbonne=item.organisationAbonne;
              });
              this.showDetailFacturation(this.svData.refEnteteFacturation, this.svData.noms, this.svData.organisationAbonne,this.refMouvement);
              this.isLoading(false);
              this.edit = false;
              this.dialog = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            }
          );
        }

        }

      }
    },
    closeForm() {
      this.dialog = false;
      this.resetObj(this.svData);
    },
    printFacturePriveeGF(id) {
      //window.open(`${this.apiBaseURL}/pdf_grand_facture_groupe_privee_data?id=` + id);
      window.open(`${this.apiBaseURL}/pdf_grand_facture_privee_data?id=` + id);
    },
    printFacturePriveePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_privee_data?id=` + id);
    },
    printFactureAbonneeGF(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_abonnee_data?id=` + id);
    },
    printFactureAbonneePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_abonnee_data?id=` + id);
    },
    printFacturePriveeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_privee_entete_data?id=` + id);
    },
    printFacturePriveePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petite_facture_synthese_privee_entete_data?id=` + id);
    },
    printFactureAbonneeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_abonnee_data?id=` + id);
    },
    printFactureAbonneePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_synthese_abonnee_data?id=` + id);
    },
    //,'refMouvement','refUniteProduction','refMedecin','datefacture','statut','author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetefacturation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refUniteProduction = item.refUniteProduction;
            this.svData.refMedecin = item.refMedecin;
            // this.svData.datefacture = item.datefacture;
            this.svData.statut = item.statut;
          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_entetefacturation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_entetefacturation_mouvement/${this.refMouvement}?page=`);

    },
    fetchListDepartement() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.DepartementList = donnees;
        }
      );
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MedecinList = donnees;
        }
      );
    },
    //fultrage de donnees
    async Get_unite_for_Departement(idDepartement) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_unite_Departement2/${idDepartement}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.UniteList = chart;
          } else {
            this.stataData.UniteList = [];
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

    // PARTIE DES COMPOSANTS===================================================================   
     
//
    showDetailFacturation(refEnteteFacturation, name,organisationAbonne,refMouvement) {

      if (refEnteteFacturation != '') {

        this.$refs.DetailFacturation.$data.etatModal = true;
        this.$refs.DetailFacturation.$data.refEnteteFacturation = refEnteteFacturation;        
        this.$refs.DetailFacturation.$data.organisationAbonne = organisationAbonne;
        this.$refs.DetailFacturation.$data.svData.refEnteteFacturation = refEnteteFacturation;
        this.$refs.DetailFacturation.$data.refMouvement = refMouvement;
        this.$refs.DetailFacturation.fetchListSelection();
        this.$refs.DetailFacturation.fetchDataList();
        this.$refs.DetailFacturation.getRouteParam();
        this.$refs.DetailFacturation.showDataMedcin(refMouvement)
        this.fetchDataList();
        // this.$refs.DetailFacturation.getRouteParamMalade(refEnteteFacturation);
        

        this.$refs.DetailFacturation.$data.titleComponent =
          "Détail de Facture pour " + name+""+organisationAbonne;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPaieFacturation(refEnteteFacturation, name) {

          if (refEnteteFacturation != '') {

            this.$refs.PaiementFacture.$data.etatModal = true;
            this.$refs.PaiementFacture.$data.refEnteteFacturation = refEnteteFacturation;
            this.$refs.PaiementFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
            this.$refs.PaiementFacture.fetchDataList();            
            this.$refs.PaiementFacture.get_mode_Paiement();
            this.$refs.PaiementFacture.getInfoFacture(refEnteteFacturation);
            this.fetchDataList();
           
            this.$refs.PaiementFacture.$data.titleComponent =
              "Paiement de la Facture pour " + name;

          } else {
            this.showError("Personne n'a fait cette action");
          }

}


  },
  filters: {

  }
}
</script>
  
  