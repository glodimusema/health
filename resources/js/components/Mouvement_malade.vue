<template>
  <v-layout>

    <v-flex md12>

      <ImageriesExt ref="ImageriesExt" />

      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Création Episode Maladie <v-spacer></v-spacer>
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

              <v-autocomplete label="Selectionnez le Type de Mouvement" prepend-inner-icon="mdi-map"
                :rules="[(v) => !!v || 'Ce champ est requis']" :items="typemouvementtList" item-text="Typemouvement"
                item-value="id" dense outlined v-model="svData.refTypeMouvement" chips clearable>
              </v-autocomplete>
              <!-- categoriemaladiemvt -->
              <v-text-field readonly label="Catégorie Maladie" prepend-inner-icon="extension" dense outlined
                v-model="svData.categoriemaladiemvt"></v-text-field>

              <v-text-field readonly label="Organisation" prepend-inner-icon="extension" dense outlined
                v-model="svData.organisationAbonne"></v-text-field>

              <v-text-field readonly label="N° Carte pour Abonné" prepend-inner-icon="extension" dense outlined
                v-model="svData.numCartemvt"></v-text-field>

              <v-text-field readonly label="Taux de Prise ne Charge (%)" prepend-inner-icon="extension" dense outlined
                v-model="svData.taux_prisecharge"></v-text-field>

              <v-text-field type="number" label="Pourcentage Conventionnel (Abonné)" prepend-inner-icon="extension" dense
                outlined v-model="svData.pourcentageConvention"></v-text-field>

              <v-text-field label="N° Bon (Abonné)" prepend-inner-icon="extension" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numroBon"></v-text-field>

              <!-- <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-select label="Statut" :items="[
                    { designation: 'Encours' },
                    { designation: 'Sortie' }
                  ]" prepend-inner-icon="extension"
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                    item-value="designation" v-model="svData.Statut"></v-select>
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



      <br /><br />


      <v-dialog v-model="dialog2" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Cloturer une Episode Malade <v-spacer></v-spacer>
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

              <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-select label="Statut" :items="[
                    { designation: 'Encours' },
                    { designation: 'Sortie' }
                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.Statut"></v-select>
                </div>
              </v-flex>

              <v-text-field type="date" label="Date Sortie" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSortieMvt">
              </v-text-field>

              <v-flex xs12 sm12 md12 lg12>
                <div class="mr-1">
                  <v-textarea type="textarea" label="Motif Sortie" prepend-inner-icon="draw" dense
                    :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motifSortieMvt">
                  </v-textarea>
                </div>
              </v-flex>

              <v-text-field label="Autorisation (Medcin)" prepend-inner-icon="extension"
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autoriseSortieMvt">
              </v-text-field>


            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
              <v-btn color="#B72C2C" dark :loading="loading" @click="validateSortie">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>

      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/malades'">Recéption/Malades</router-link>
            <router-link :to="'/admin/mouvement_malade/' + this.svData.refMalade">/Creer une Episode Maladie</router-link>
          </div>
        </v-flex>
      </v-layout>
      <br /><br />
      <v-layout>
        <!--   -->
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
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter un Mouvement</span>
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
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">N°Bon</th>
                      <th class="text-left">Date</th>
                      <th class="text-left">Mouvement</th>
                      <th class="text-left">Etat</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.categoriemaladiemvt }}</td>
                      <td>{{ item.numroBon }}</td>
                      <td>{{ item.dateMouvement | formatDate }}</td>
                      <td>{{ item.Typemouvement }}</td>
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


                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">
                            <v-list-item link @click="insertTriage(item.id, item.dateMouvement)">
                              <v-list-item-icon>
                                <v-icon>description</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer au Triage</v-list-item-title>
                            </v-list-item>

                            <v-list-item link router :to="'/admin/entete_labo_ext/' + item.id">
                              <v-list-item-icon>
                                <v-icon>mdi-anchor</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                              </v-list-item-title>
                            </v-list-item>

                            <!-- <v-list-item link @click="insertPaiement(item.id, item.dateMouvement)">
                              <v-list-item-icon>
                                <v-icon>mdi-cash-100</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer à la Caisse</v-list-item-title>
                            </v-list-item> -->

                            <v-list-item link @click="insertPharmacie(item.id, item.dateMouvement)">
                              <v-list-item-icon>
                                <v-icon>mdi-cash-100</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer à la Pharmacie</v-list-item-title>
                            </v-list-item>


                            <v-list-item link @click="showImagerie(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer aux Imageries
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="sortieData(item.id)">
                              <v-list-item-icon>
                                <v-icon>description</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Cloturer une Episode
                                Maladie</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBill(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printFacture(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Factures des Examens</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printResultat(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Rendu des Résultats </v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="printBilletLabo(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Billet de Laboratoire </v-list-item-title>
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
import ImageriesExt from './Imageries/ImageriesExt.vue';

export default {
  components: {
    ImageriesExt
  },
  data() {
    return {

      title: "Liste des Mouvements",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      //,'organisationAbonne','taux_prisecharge'
      //'id','refMalade','refTypeMouvement','dateMouvement','numroBon','Statut','dateSortieMvt','motifSortieMvt','autoriseSortieMvt','author'
      svData: {
        id: '',
        refMalade: this.$route.params.id,
        refTypeMouvement: "",
        numroBon: "",
        Statut: "",
        author: "Admin",
        noms: "",
        Typemouvement: "",
        refMouvement: "",
        dateTriage: "",
        dateentetepaie: "",
        dateVente: "",

        dateSortieMvt: "",
        motifSortieMvt: "",
        autoriseSortieMvt: "",

        organisationAbonne: "",
        taux_prisecharge: "",
        pourcentageConvention: "",
        categoriemaladiemvt: "",
        numCartemvt: "",
      },
      fetchData: [],
      typemouvementtList: [],
      clientList: [],
      personneList: [],
      don: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
    
    this.svData.numroBon = '0000';
    this.svData.organisationAbonne = 'Privé(e)';
    this.svData.taux_prisecharge = 0;
    this.svData.pourcentageConvention = 0;
    this.svData.categoriemaladiemvt = 'PRIVE(E)';

     
    //Categorie
    this.getRouteParam();
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
          // this.svData.Statut='Encours';
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_mouvement/${this.svData.id}`,
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
          this.svData.Statut = 'Encours';
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_mouvement`,
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

    validateSortie() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_statut/${this.svData.id}`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog2 = false;
              this.resetObj(this.svData);
              this.fetchDataList();
            })
            .catch((err) => {
              this.svErr(), this.isLoading(false);
            });

        }
        else {

        }

      }
    },
    //printBilletLabo
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
    },
    //printResultat
    printFacture(id) {
      window.open(`${this.apiBaseURL}/pdf_facturelaboext_data?id=` + id);
    },
    //printResultat
    printBilletLabo(id) {
      window.open(`${this.apiBaseURL}/pdf_billetlaboext_data?id=` + id);
    },
    //printResultat
    printResultat(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatlaboext_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refMalade = item.refMalade;
            this.svData.noms = item.noms;
            this.svData.Typemouvement = item.Typemouvement;
            this.svData.refTypeMouvement = item.refTypeMouvement;
            this.svData.author = item.author;
            this.svData.numroBon = item.numroBon;
            this.svData.Statut = item.Statut;

            this.svData.organisationAbonne = item.organisationAbonne;
            this.svData.taux_prisecharge = item.taux_prisecharge;
            this.svData.pourcentageConvention = item.pourcentageConvention;
            this.svData.categoriemaladiemvt = item.categoriemaladiemvt;
            this.svData.numCartemvt = item.numCartemvt;

          });

          this.edit = true;
          this.dialog = true;

          // pourcentageConvention
        }
      );
    },

    sortieData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.dateSortieMvt = item.dateSortieMvt;
            this.svData.motifSortieMvt = item.motifSortieMvt;
            this.svData.autoriseSortieMvt = item.autoriseSortieMvt;
            this.svData.author = item.author;
            this.svData.Statut = item.Statut;

          });

          this.edit = true;
          this.dialog2 = true;

          // console.log(donnees);
        }
      );
    },
    insertTriage(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateTriage = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteTriage`,
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

    },
    insertPaiement(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateentetepaie = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_entetepaie`,
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
    },
    insertPharmacie(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateVente = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_entetevente`,
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
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typemouvement`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typemouvementtList = donnees;
        }
      );
    }
    ,
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_mouvement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refMalade = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_mouvement_malade/${this.refMalade}?page=`);
      this.getAbonnement(this.refMalade, 'Encours');
    },

    getRouteParam() {
      var id = this.$route.params.id;
      this.refMalade = id;
    },
    getAbonnement(refMalade, Statut) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_affectationabone_mvt?refMalade=${refMalade}&Statut=${Statut}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.taux_prisecharge = item.tauxcharge;
            this.svData.organisationAbonne = item.nom_org;
            this.svData.pourcentageConvention = item.pourcentageConvention;
            this.svData.categoriemaladiemvt = item.Categorie;
            this.svData.numCartemvt = item.numeroCarte_malade;
          });
        }
      );
    },
    showImagerie(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.ImageriesExt.$data.etatModal = true;
        this.$refs.ImageriesExt.$data.refMouvement = refMouvement;
        this.$refs.ImageriesExt.$data.svData.refMouvement = refMouvement;
        this.$refs.ImageriesExt.fetchDataList();
        this.fetchDataList();
        // this.$refs.Endoscopie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.ImageriesExt.$data.titleComponent =
          "Transfert Imagrie du Patient : " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>
  
  