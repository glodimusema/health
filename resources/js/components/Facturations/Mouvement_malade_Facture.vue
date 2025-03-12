<template>
  <v-layout>



    <v-flex md12>

      <EnteteFacturation ref="EnteteFacturation" />
      <PaiementFacture ref="PaiementFacture" />

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

              <v-text-field type="date" label="Date Mouvement" prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateMouvement">
              </v-text-field>

              <v-text-field label="N° Bon (Abonné)" prepend-inner-icon="extension"
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numroBon"></v-text-field>


              <v-flex xs12 sm12 md6 lg6>
                <div class="mr-1">
                  <v-select label="Statut" :items="[
                    { designation: 'Encours' },
                    { designation: 'Sortie' }
                  ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    item-text="designation" item-value="designation" v-model="svData.Statut"></v-select>
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

      <v-dialog v-model="dialog4" max-width="500px" hide-overlay transition="dialog-bottom-transition">
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Effectuer le Paiement de la Consultation <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog4 = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip>
            </v-card-title>
            <v-card-text max-height="400px" background-color: white>
              <v-layout row wrap>


                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.DepartementList"
                      item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement" clearable
                      chips @change="Get_unite_for_Departement(svData.refDepartement)">
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
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                      item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" clearable chips>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Type de Produit" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeproduitList" item-text="nom_typeproduit"
                      item-value="id" dense outlined v-model="svData.refTypeProduit" clearable chips
                      @change="get_produit_for_typeproduit(svData.refTypeProduit, 'Privé(e)')">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="nom_produit"
                      item-value="id" dense outlined v-model="svData.refProduit" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <!-- <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList" item-text="designation"
                      item-value="designation" dense outlined v-model="svData.modepaie" chips clearable
                      @change="get_Banque(svData.modepaie)">
                    </v-autocomplete>
                  </div>
                </v-flex> -->

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList" item-text="nom_banque"
                      item-value="id" dense outlined v-model="svData.refBanque" chips clearable>
                    </v-autocomplete>
                  </div>
                </v-flex>


              </v-layout>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog4 = false"> Fermer </v-btn>
              <v-btn color="#B72C2C" dark :loading="loading" @click="validate_paiement_facture">
                {{ edit ? "Modifier" : "Ajouter" }}
              </v-btn>
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>


      <v-dialog v-model="dialog5" max-width="600px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Les Examens demandés par le Medecin <v-spacer></v-spacer>
              <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog5 = false" text fab depressed>
                      <v-icon>close</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Fermer</span>
              </v-tooltip>
            </v-card-title>
            <v-card-text>

              <v-textarea type="text" label="Les Examens demandés par le Medecin : " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.examens">
              </v-textarea>

              <v-textarea type="text" label="Les Actes Posés par le Medecin : " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.actes">
              </v-textarea>

              <v-textarea type="text" label="Les Analyses d'imagerie demandées par le Medecin : "
                prepend-inner-icon="event" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                v-model="svData.imageries">
              </v-textarea>

              <v-textarea type="text" label="Les Medicaments demandés par le Medecin : " prepend-inner-icon="event" dense
                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medicaments">
              </v-textarea>

            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn depressed text @click="dialog5 = false"> Fermer </v-btn>
              <!-- <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn> -->
            </v-card-actions>
          </v-form>
        </v-card>
      </v-dialog>


      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/facturation'">Facturations/Facturations</router-link>
            <v-layout row wrap class="mt-0">
              <!-- statistique -->
              <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                  <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                    <!-- card commence -->

                    <v-list-item three-line router to="/admin/malades">
                      <v-list-item-content>
                        <div class="text-overline mb-4">Facturés</div>
                        <v-list-item-title class="text-h5 mb-1">
                          {{ totalFacture }}$
                        </v-list-item-title>
                        <!-- <v-list-item-subtitle>dans le système</v-list-item-subtitle> -->
                      </v-list-item-content>

                      <v-list-item-avatar tile size="80" color="pink darken-1">
                        <v-icon size="60" color="white">devices</v-icon>
                      </v-list-item-avatar>

                    </v-list-item>
                    <!-- fin card -->
                  </v-card>
                </v-container>
              </v-flex>

              <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                  <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                    <!-- card commence -->
                    <v-list-item three-line router to="/admin/entete_consultation">
                      <v-list-item-content>
                        <div class="text-overline mb-4">Payés</div>
                        <v-list-item-title class="text-h5 mb-1">
                          {{ totalPaie }}$
                        </v-list-item-title>
                        <!-- <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        > -->
                      </v-list-item-content>

                      <v-list-item-avatar tile size="80" color="indigo">
                        <v-icon size="60" color="white">developer_board_off</v-icon>
                      </v-list-item-avatar>
                    </v-list-item>

                    <!-- fin card -->

                  </v-card>
                </v-container>
              </v-flex>

              <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                  <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                    <!-- card commence -->
                    <v-list-item three-line router to="/admin/entete_consultation">
                      <v-list-item-content>
                        <div class="text-overline mb-4">Restes</div>
                        <v-list-item-title class="text-h5 mb-1">
                          {{ TotalReste }}$
                        </v-list-item-title>
                        <!-- <v-list-item-subtitle
                        >Dans le système </v-list-item-subtitle
                        > -->
                      </v-list-item-content>

                      <v-list-item-avatar tile size="80" color="success">
                        <v-icon size="60" color="white">real_estate_agent</v-icon>
                      </v-list-item-avatar>
                    </v-list-item>



                    <!-- fin card -->
                  </v-card>
                </v-container>
              </v-flex>

              <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                  <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                    <v-list-item three-line router to="/admin/medecin">
                      <v-list-item-content>
                        <div class="text-overline mb-4">Depenses</div>
                        <v-list-item-title class="text-h5 mb-1">
                          {{ totalDepense }}$
                        </v-list-item-title>
                        <!-- <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        > -->
                      </v-list-item-content>

                      <v-list-item-avatar tile size="80" color="blue lighten-2">
                        <v-icon size="60" color="white">supervised_user_circle</v-icon>
                      </v-list-item-avatar>
                    </v-list-item>


                  </v-card>
                </v-container>
              </v-flex>

              <!-- fin statistique -->
            </v-layout>


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
              <!-- <v-tooltip bottom color="black">
                <template v-slot:activator="{ on, attrs }">
                  <span v-bind="attrs" v-on="on">
                    <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                      <v-icon>add</v-icon>
                    </v-btn>
                  </span>
                </template>
                <span>Ajouter un Mouvement</span>
              </v-tooltip> -->
            </v-flex>
          </v-layout>
          <br />
          <v-card>
            <v-card-text>
              <v-simple-table>
                <template v-slot:default>
                  <thead>
                    <tr>
                      <th class="text-left">Action</th>
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">N°Bon</th>
                      <th class="text-left">Date</th>
                      <th class="text-left">Mouvement</th>
                      <th class="text-left">Etat</th>
                      <th class="text-left">Auhtor</th>
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

                          <v-list>

                            <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                              @click="showCreatePaiement(item.id, item.noms, item.dateMouvement)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-cash-100</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Paiement de la Consultation(Envoie au Triage)
                              </v-list-item-title>
                            </v-list-item>


                            <v-list-item link @click="showEnteteFacturation(item.id, item.noms)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">mdi-cards</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Les Facturations
                              </v-list-item-title>
                            </v-list-item>


                            <v-list-item link @click="showDataMedcin(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Les Elements demadés par le
                                medecin</v-list-item-title>
                            </v-list-item>

                            <v-list-item link @click="insertPharmacie(
                              item.id,
                              item.dateMouvement
                            )
                              ">
                              <v-list-item-icon>
                                <v-icon>mdi-cash-100</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Envoyer à la
                                Pharmacie</v-list-item-title>
                            </v-list-item>


                            <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                              @click="printFacturePriveeGF(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Globale des Privé(e)s
                                (A4)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                              @click="printFacturePriveePF(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Globale des Privé(e)s
                                (A6)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link
                              @click="printFactureAbonneeGF(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Globale des Abonné(e)s
                                (A4)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link
                              @click="printFactureAbonneePF(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Globale des Abonné(e)s
                                (A6)</v-list-item-title>
                            </v-list-item>


                            <!-- SYNTHESE -->

                            <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                              @click="printFacturePriveeGF_Synthese(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Synthèse Globale des Privé(e)s
                                (A4)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                              @click="printFacturePriveePF_Synthese(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Synthèse Globale des Privé(e)s
                                (A6)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link
                              @click="printFactureAbonneeGF_Synthese(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Synthèse Globale des Abonné(e)s
                                (A4)</v-list-item-title>
                            </v-list-item>

                            <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link
                              @click="printFactureAbonneePF_Synthese(item.id)">
                              <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Facture Synthèse Globale des Abonné(e)s
                                (A6)</v-list-item-title>
                            </v-list-item>



                          </v-list>
                        </v-menu>

                      </td>
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.age_malade }}</td>
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
import EnteteFacturation from '../Finances/EnteteFacturation.vue';
import PaiementFacture from '../Finances/PaiementFacture.vue';


export default {
  components: { EnteteFacturation, PaiementFacture },
  data() {
    return {
      title: "Liste des Mouvements",
      dialog: false,
      dialog2: false,
      dialog4: false,

      dialog5: false,
      edit: false,
      loading: false,
      disabled: false,

      totalDepense: 0,
      totalFacture: 0,
      totalPaie: 0,
      TotalReste: 0,

      //'refMouvement','dateTriage'
      //'id','refMalade','refTypeMouvement','dateMouvement','numroBon','Statut','dateSortieMvt','motifSortieMvt','autoriseSortieMvt','author'
      svData: {
        id: "",
        refMalade: this.$route.params.id,
        refTypeMouvement: "",
        dateMouvement: "",
        numroBon: "",
        Statut: "",
        author: "Admin",
        noms: "",
        Typemouvement: "",
        refMouvement: "",
        dateTriage: "",

        author: "Admin",
        noms: "",
        refMouvement: "",
        dateTriage: "",       


        refMouvement: 0,
        refDepartement: 0,
        refUniteProduction: 0,
        refProduit: 0,
        modepaie: '',
        refBanque: 0,
        refEnteteFacturation: 0,
        refTypeProduit: 0,
        refService: 0,
        noms: "",
        refMedecin: 0,
        refTypeCons: 0,
        refService: 0,
        examens: '',
        dateVente: '',

        actes: '',
        medicaments: '',
        imageries: '',

        
      },
      fetchData: [],
      typemouvementtList: [],
      clientList: [],
      personneList: [],

      ModeList: [],
      BanqueList: [],
      produitList: [],
      typeproduitList: [],
      stataData: {
        ServiceList: [],
        medecinList: [],
        DepartementList: [],
        UniteList: [],
      },
      don: [],
      query: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: '',
    };
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();
    this.fetchListSelection();

    this.fetchListmedecin();
    this.fetchListDepartement();
    this.fetchListTypeProduit();
    this.get_mode_Paiement();


    this.fetch_sommation_recette();
    this.fetch_sommation_depense();

    this.get_Banque("CASH");

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
          this.insertOrUpdate(`${this.apiBaseURL}/update_mouvement/${this.svData.id}`, JSON.stringify(this.svData))
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
          this.insertOrUpdate(`${this.apiBaseURL}/insert_mouvement`, JSON.stringify(this.svData))
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
    printFacturePriveeGF(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_groupe_privee_mouvement_data?id=` + id);
    },
    printFacturePriveePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_groupe_privee_mouvement_data?id=` + id);
    },
    printFactureAbonneeGF(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_groupe_abonnee_mouvement_data?id=` + id);
    },
    printFactureAbonneePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_groupe_abonnee_mouvement_data?id=` + id);
    },
    printFacturePriveeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_privee_mouvement_data?id=` + id);
    },
    printFacturePriveePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petite_facture_synthese_privee_mouvement_data?id=` + id);
    },
    printFactureAbonneeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_abonnee_mouvement_data?id=` + id);
    },
    printFactureAbonneePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_synthese_abonnee_mouvement_data?id=` + id);
    },
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.svData.id = item.id;
          this.svData.refMalade = item.refMalade;
          this.svData.noms = item.noms;
          this.svData.dateMouvement = item.dateMouvement;
          this.svData.Typemouvement = item.Typemouvement;
          this.svData.refTypeMouvement = item.refTypeMouvement;
          this.svData.author = item.author;
          this.svData.numroBon = item.noms;
          this.svData.Statut = item.noms;
        });
        this.edit = true;
        this.dialog = true;
        // console.log(donnees);
      });
    },
    insertTriage(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateTriage = dateMouvement;
      this.insertOrUpdate(`${this.apiBaseURL}/insert_enteteTriage`, JSON.stringify(this.svData))
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typemouvement`).then(({ data }) => {
        var donnees = data.data;
        this.typemouvementtList = donnees;
      });
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_mouvement/${id}`).then(({ data }) => {
          this.showMsg(data.data);
          this.fetchDataList();
        });
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refMalade = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_mouvement?page=`);
    },
    getRouteParam() {
      var id = this.$route.params.id;
      this.refMalade = id;
    },

    // PARTIE DES COMPOSANTS===================================================================   


    showEnteteFacturation(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteFacturation.$data.etatModal = true;
        this.$refs.EnteteFacturation.$data.refMouvement = refMouvement;
        this.$refs.EnteteFacturation.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteFacturation.fetchDataList();
        this.$refs.EnteteFacturation.fetchListDepartement();
        this.$refs.EnteteFacturation.fetchListmedecin();
        this.fetchDataList();

        this.$refs.EnteteFacturation.$data.titleComponent =
          "Création de la Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

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
    async get_mode_Paiement() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.ModeList = chart;
          } else {
            this.ModeList = [];
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
    async get_Banque(nom_mode) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.BanqueList = chart;
          } else {
            this.BanqueList = [];
          }
          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    fetchListDepartement() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.DepartementList = donnees;

        }
      );
    },

    fetchListTypeProduit() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeproduit_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeproduitList = donnees;
        }
      );
    },
    //fultrage de donnees
    async get_produit_for_typeproduit(refTypeProduit, organisationAbonne) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_produit_type3?refTypeProduit=${refTypeProduit}&organisationAbonne=${organisationAbonne}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.produitList = chart;
          } else {
            this.produitList = [];
          }

          chart.map((item) => {
            this.svData.nom_typeproduit = item.nom_typeproduit;
          });

          this.isLoading(false);

          //console.log(this.svData.nom_typeproduit);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
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
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },
    showPaieFacturation(refEnteteFacturation, name) {

      if (refEnteteFacturation != '') {

        this.$refs.PaiementFacture.$data.etatModal = true;
        this.$refs.PaiementFacture.$data.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.fetchDataList();
        this.$refs.PaiementFacture.getInfoFacture(refEnteteFacturation);
        this.$refs.PaiementFacture.get_mode_Paiement();

        this.$refs.PaiementFacture.$data.titleComponent =
          "Paiement de la Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    validate_paiement_facture() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.modepaie='CASH';
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_paiement_Mouvement?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refProduit=${this.svData.refProduit}&modepaie=${this.svData.modepaie}&refBanque=${this.svData.refBanque}`).then(
        // this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_paiement_Mouvement?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refProduit=${this.svData.refProduit}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEnteteFacturation = item.id;
              this.svData.dateEnteteTriage = item.datefacture;
            });
            this.showPaieFacturation(this.svData.refEnteteFacturation, this.svData.noms);
            this.insertTriage(this.svData.refMouvement, this.svData.dateEnteteTriage);
            this.dialog4 = false;
            this.isLoading(false);
          }
        );
      }
    },
    showCreatePaiement(id, noms, dateMouvement) {
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.svData.dateEnteteTriage = dateMouvement;
      this.dialog4 = true;

    },
    showDataExamenLaboMedecin(id) {
      this.svData.examens = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_examen_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.examens = this.svData.examens + "  --  " + item.designationEx;
          });

        }
        //
      );
    },
    showDataActesMedecin(id) {
      this.svData.actes = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_actes_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.actes = this.svData.actes + "  --  " + item.nom_acte;
          });
          // this.dialog5 = true;
        }
        //
      );
    },

    showDataMedicamentMedecin(id) {
      this.svData.medicaments = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_medicaments_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.medicaments = this.svData.medicaments + "  --  " + item.nom_medicament;
          });
          // this.dialog5 = true;
        }
        //
      );
    },

    showDataImagerieMedecin(id) {
      this.svData.imageries = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_imagerie_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.imageries = this.svData.imageries + "  --  " + item.nomAnalyse;
          });
          // this.dialog5 = true;
        }
        //
      );
    },
    showDataMedcin(id_data) {

      this.showDataExamenLaboMedecin(id_data);
      this.showDataActesMedecin(id_data);
      this.showDataMedicamentMedecin(id_data);
      this.showDataImagerieMedecin(id_data);

      this.dialog5 = true;

    }
    ,
    fetch_sommation_recette() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_sommation_recette`).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.totalFacture = item.totalFacture;
          this.totalPaie = item.totalPaie;
          this.TotalReste = item.TotalReste;
        });
      });
    },
    fetch_sommation_depense() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_sommation_depense`).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.totalDepense = item.totalDepense;
        });
      });
    }
  },
  filters: {},

}
</script>
  
  