<template>
    <v-layout wrap row>
        
        <v-flex md12>
            <v-flex md12>
                <!-- modal  -->
                <!-- <detailLotModal v-on:chargement="rechargement" ref="detailLotModal" /> -->
                <!-- fin modal -->
                <!-- modal -->
               <br><br>
                <!-- fin modal -->

                <!-- bande -->
                <v-layout>
                    <v-flex md1>
                        <v-tooltip bottom>
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn :loading="loading" fab @click="onPageChange">
                                        <v-icon>autorenew</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Initialiser</span>
                        </v-tooltip>
                    </v-flex>
                    <v-flex md7>

                        <v-row v-show="showDate">
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-date-picker
                                v-model="dates"
                                range color="#B72C2C"
                            ></v-date-picker>
                            </v-col>
                            <v-col
                            cols="12"
                            sm="6"
                            >
                            <v-text-field
                                v-model="dateRangeText"
                                label="Date range"
                                prepend-icon="mdi-calendar"
                                readonly
                            ></v-text-field>
                          
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailVenteByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE TOUTES LES VENTES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailSortieByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES SORTIES DES SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailDetailEntreeByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES APPROVISONNEMENTS
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_Organisation" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES/ORGANISATION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Medicament" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="medicamentList"
                                        item-text="nom_medicament" item-value="id" dense outlined v-model="svData.refmedicament" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailVenteByDate_Medicament" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES VENTES/MEDICAMENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_Medicament" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES SORTIES SERV./MEDICAMENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Service Medical" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="serviceList"
                                        item-text="nom_service" item-value="id" dense outlined v-model="svData.refService" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <br>

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailSortieByDate_Service" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DES SORTIES SERV./SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br> -->

                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> IMPRIMER FICHE DE STOCK
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>                           
                            <br>                                -->
                                <!-- <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la Catégorie Produit" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieProList"
                                        item-text="nom_categoriemedicament" item-value="id" dense outlined v-model="svData.idCategorie" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                            <br>   
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Categorie" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/CATEGORIE PRODUIT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>  -->
                            
                            <br>   
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showFicheStockByDate_Service" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FICHE DE STOCK/SERVICES
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> 
                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <v-flex md3>
                       
                        <!-- <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Organisation'" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="organisationList"
                                item-text="nom_org" item-value="nom_org" dense outlined v-model="svData.organisationAbonne"
                                chips clearable >
                            </v-autocomplete>
                        </div> -->
                    </v-flex>

                    <v-flex md1>
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="showDate = !showDate" fab color="#B72C2C" dark>
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Voir les Rapports</span>
                        </v-tooltip>
                    </v-flex>
                </v-layout>
                <!-- bande -->

                
            </v-flex>
        </v-flex>
        
    </v-layout>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
// import detailLotModal from './detailLotModal.vue'
export default {
    components: {
        // detailLotModal,
    },
    data() {
        return {
            title: "Pays component",
            header: "Crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            svData: {
                id: "",                
                refmedicament: "", 
                refService:0,
                organisationAbonne:"",
                idCategorie:0
                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            serviceList: [],
            medicamentList: [],
            organisationList: [],
            categorieProList: [],
            filterValue:'',
            dates:[],
            showDate:false,
        };
    },
    computed: {
        
        dateRangeText () {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "modification de Tarification ";
            } else {
                this.titleComponent = "Ajout Tarification ";
            }
        },

        searchMember: _.debounce(function () {
            this.onPageChange();
        }, 300),

        
        onPageChange() {           
           fetchListOrganisation
        },      
      fetchListService() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_service`).then(
          ({ data }) => {
            var donnees = data.data;
            this.serviceList = donnees;

          }
        );
      },      
      fetchListOrganisation() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_organisation`).then(
          ({ data }) => {
            var donnees = data.data;
            this.organisationList = donnees;
//
          }
        );
      },      
      fetchListCategorieProduit() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_categoriemedicament`).then(
          ({ data }) => {
            var donnees = data.data;
            this.categorieProList = donnees;

          }
        );
      }
      ,
     //fultrage de donnees
      async GetMedicament() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_medicament2`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.medicamentList = chart;
              } else {
                  this.medicamentList = [];
              }

              this.isLoading(false);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
              //fetch_pdf_rapport_detailentree_date
      },
        showDetailDetailVenteByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailvente_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailEntreeByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailentree_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailDetailSortieByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailsortie_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_Organisation() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.organisationAbonne!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailvente_date_organisation?date1=` + date1+"&date2="+date2+"&organisationAbonne="+this.svData.organisationAbonne);
                }else
                {
                    this.showError("Veillez selectionner l'Organisation svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailVenteByDate_Medicament() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refmedicament!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailvente_date_medicament?date1=` + date1+"&date2="+date2+"&refmedicament="+this.svData.refmedicament);
                }else
                {
                    this.showError("Veillez selectionner le Medicament svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refService!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailsortie_date_service?date1=` + date1+"&date2="+date2+"&refService="+this.svData.refService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refService!="")
                {
                    window.open(`${this.apiBaseURL}/pdf_fiche_stock_produit_service?date1=` + date1+"&date2="+date2+"&refService="+this.svData.refService);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailSortieByDate_Medicament() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refmedicament!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_rapport_detailsortie_date_medicament?date1=` + date1+"&date2="+date2+"&refmedicament="+this.svData.refmedicament);
                }else
                {
                    this.showError("Veillez selectionner le Medicament svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showFicheStockByDate() {

            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                window.open(`${this.apiBaseURL}/fetch_pdf_fiche_stock_medicament_date?date1=` + date1+"&date2="+date2);              
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }

       },
        showFicheStockByDate_Categorie() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.idCategorie!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_pdf_fiche_stock_medicament_categorie_date?date1=` + date1+"&date2="+date2+"&idCategorie="+this.svData.idCategorie);
                }else
                {
                    this.showError("Veillez selectionner le service svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {
        this.fetchListCategorieProduit();
        this.fetchListOrganisation();
        this.fetchListService();
        this.GetMedicament();
        this.showDate=true;
    },
};
</script>