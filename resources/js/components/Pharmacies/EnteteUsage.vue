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

                    <!-- FeuilleFacturation -->
                    <DetailUsage ref="DetailUsage" />

                    <v-dialog v-model="dialog" max-width="600px" persistent>
                    <v-card :loading="loading">
                        <v-form ref="form" lazy-validation>
                        <v-card-title>
                            Création Fiche de Consommation<v-spacer></v-spacer>
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

                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList" item-text="nom_service"
                            item-value="id" outlined dense v-model="svData.refService">
                        </v-autocomplete>

                        <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.SalleList"
                            item-text="nom_salle" item-value="id" dense outlined v-model="svData.refSalle" chips clearable>
                        </v-autocomplete>

                        <v-text-field type="date" label="Date Utilisation" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_usage">
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

                    <v-layout row wrap>
                    <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                        <router-link :to="'#'">Etat de Besoin</router-link>
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
                            <span>Ajouter un EB</span>
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
                                    <th class="text-left">Action</th>
                                    <th class="text-left">N°</th>
                                    <th class="text-left">Patient</th>
                                    <th class="text-left">Téléphone</th>
                                    <th class="text-left">DateEB</th>
                                    <th class="text-left">Service</th>
                                    <th class="text-left">Salle</th>
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
                                        <v-list dense width="">  

                                        <v-list-item link @click="showDetailUsage(item.id, item.noms)">
                                            <v-list-item-icon>
                                            <v-icon>mdi-cart-outline</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Detail Utilisation
                                            </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="printBill(item.id)">
                                            <v-list-item-icon>
                                            <v-icon>print</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Fiche d'Utilisation
                                            </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                                            <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
                                            <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                            </v-list-item-icon>
                                            <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                        </v-list-item>

                                        </v-list>
                                    </v-menu>
                                    </td>
                                    <td>{{ item.id }}</td>
                                    <td>{{ item.noms }} - {{ item.organisationAbonne }}</td>
                                    <td>{{ item.contact }}</td>
                                    <td>{{ item.date_usage | formatDate }}</td>
                                    <td>{{ item.nom_service }}</td>
                                    <td>{{ item.nom_salle }}</td>
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
  import DetailUsage from './DetailUsage.vue'; 
  
  
  export default {
    components: {
        DetailUsage
    },
    data() {
      return {
  
        title: "Liste des Ventes",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        refMouvement: 0,
        etatModal: false,
        titleComponent: '',
        //tmed_entete_usageservice id,refService,refMouvement,refSalle,date_usage,author
        svData: {
          id: '',
          refMouvement: 0,
          refService: 0,
          refSalle:0,
          date_usage: "",
          author: ""
        },
        fetchData: [],
        clientList: [],
        personneList: [],
        serviceList: [],
        SalleList: [],
        don: [],
        query: "",
  
        inserer: '',
        modifier: '',
        supprimer: '',
        chargement: ''
  
  
      }
    },
    created() {
      this.fetchDataList();
      this.fetchListService();
      this.fetchListSalle();
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
            this.svData.refMouvement=this.refMouvement;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_enteteusage_service/${this.svData.id}`,
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
            this.svData.author = this.userData.name;
            this.svData.refMouvement=this.refMouvement;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_enteteusage_service`,
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
        window.open(`${this.apiBaseURL}/pdf_usageservices_data?id=` + id);
      },
  
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteusage_service/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {

              this.svData.id = item.id;
              this.svData.refMouvement = item.refMouvement;
              this.svData.refService = item.refService;
              this.svData.refSalle = item.refSalle;
              this.svData.date_usage = item.date_usage;
              this.svData.author = item.author;
            });
  
            this.edit = true;
            this.dialog = true;
  
            // console.log(donnees);
          }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_enteteusage_service/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_usage_service_mouvement/${this.refMouvement}?page=`);
      },
    fetchListService() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_service`).then(
        ({ data }) => {
          var donnees = data.data;
          this.serviceList = donnees;
        }
      );
    },
    fetchListSalle() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_salle_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.SalleList = donnees;
        }
      );
    },
    showDetailUsage(refEnteteVente, name) {

      if (refEnteteVente != '') {

        this.$refs.DetailUsage.$data.etatModal = true;
        this.$refs.DetailUsage.$data.refEnteteVente = refEnteteVente;
        this.$refs.DetailUsage.$data.svData.refEnteteVente = refEnteteVente;
        this.$refs.DetailUsage.fetchDataList();
        this.$refs.DetailUsage.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailUsage.$data.titleComponent =
          "Detail Usage pour " + name;

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
  
  