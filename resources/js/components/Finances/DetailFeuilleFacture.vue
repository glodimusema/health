<template>
  <v-row justify="center">

    

    <v-dialog v-model="etatModal" persistent max-width="1200px">
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

          <v-layout>
             
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="600px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Details Facturation <v-spacer></v-spacer>
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
                          <v-autocomplete label="Selectionnez le Type de Produit" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeproduitList"
                            item-text="nom_typeproduit" item-value="id" dense outlined v-model="svData.refTypeProduit"
                            clearable chips @change="get_produit_for_typeproduit(svData.refTypeProduit,organisationAbonne)">
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="nom_produit"
                        item-value="id" dense outlined v-model="svData.refProduit" chips clearable
                        @change="getPrice(svData.refProduit)"
                        >
                      </v-autocomplete>

                      <v-text-field type="number" label="Quantité " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.quantite">
                      </v-text-field>

                      <v-text-field readonly type="number" label="Prix Unitaire ($) " prepend-inner-icon="event" dense
                        outlined v-model="svData.prixunitaire">
                      </v-text-field>

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
                  <v-card :loading="loading" :disabled="loading">
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Catégorie</th>
                              <th class="text-left">Produit</th>
                              <th class="text-left">Quantité</th>
                              <th class="text-left">PU($)</th>
                              <th class="text-left">PT($)</th>
                              <th class="text-left">Taux(FC)</th>
                              <!-- <th class="text-left">Action</th> -->
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.categoriemaladiemvt }}</td>
                              <td>{{ item.nom_produit }}</td>
                              <td>{{ item.quantite }}</td>
                              <td>{{ item.prixunitaire }}</td>
                              <td>{{ item.prixTotal }}</td>
                              <td>{{ item.montant_taux }}</td>
                              <!-- <td> -->

                                <!-- <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item v-if="item.totalPaie == 0 || item.totalPaie == null"  link @click="showDetailFacturation(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-briefcase-check</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Ajouter les details
                                        Facture
                                      </v-list-item-title>
                                    </v-list-item>
        
                                  </v-list>
                                </v-menu> -->

                              <!-- </td> -->
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
      refEnteteFacturation:0,
      organisationAbonne:'',
      svData: {
        id: '',
        refEnteteFacturation:0,        
        refProduit: "",
        quantite: 0,        
        author: "Admin",

        refMouvement: 0,
        categorieMalade: "",
        nom_typeproduit: "",
        refTypeProduit: 0,
        pourcentageConvention: 0
      },
      fetchData: [],
      produitList: [],
      typeproduitList: [],
      don: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
    // this.getRouteParam();
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
          this.svData.refEnteteFacturation = this.refEnteteFacturation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_detailfacturation/${this.svData.id}`,
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
          this.svData.refEnteteFacturation = this.refEnteteFacturation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detailfacturation`,
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

  

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailfacturation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteFacturation = item.refEnteteFacturation;
            this.svData.refProduit = item.refProduit;
            this.svData.quantite = item.quantite;            
            this.svData.author = item.author;
            this.svData.refTypeProduit = item.refTypeProduit;
          });
          this.get_produit_for_typeproduit(this.svData.refTypeProduit,this.organisationAbonne);
          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detailfacturation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {      
      this.fetch_data(`${this.apiBaseURL}/fetch_detailfacturation_entete/${this.refEnteteFacturation}?page=`);

    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeproduit_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeproduitList = donnees;
        }
      );
    },
    //fultrage de donnees
    async get_produit_for_typeproduit(refTypeProduit,organisationAbonne) {
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
    getRouteParam() {
    this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetefacturation/${this.refEnteteFacturation}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.categorieMalade = item.Categorie;
            this.svData.pourcentageConvention = item.pourcentageConvention;
          });
        }
      );
    },
    backPage() {
      this.$router.go(-1);
    },
    getPrice(refProduit) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${refProduit}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.prixunitaire = item.prix_produit;        
          });

        }
      );
    },




  },
  filters: {

  }
}
</script>

