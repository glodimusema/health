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
                          
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showEnteteFactureByDate_Abonne" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORTS DE TOUS LES ABONNE(E)S(SYNT.)
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            <br>
                            <!-- showDetailFactureCreditAvanceByDate -->
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureCreditByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORT DES FACTURATIONS(CREDIT)
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->

                            <br>
                           
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureCreditAvanceByDate" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> RAPPORT DES FACTURATIONS(AVANCE)
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->

                            <br>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="departementList"
                                        item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement" clearable
                                        chips @change="Get_unite_for_Departement(svData.refDepartement)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <!-- <br> -->
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureByDate_Departement" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FACTURATIONS(SYNTHESE)/DEPARTEMENT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->
                            <br>

                            <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="map"
                                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="uniteproductionList"
                                        item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refUniteProduction" clearable
                                        chips>
                                        </v-autocomplete>
                                    </div>
                            </v-flex>
                            <br>
                            <!-- <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureByDate_Service" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FACTURATIONS(SYNTHESE)/SERVICE
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip> -->
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureByDate_Organisation" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FACTURATIONS(SYNTHESE)/ORGANISATION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showDetailFactureByDate_Organisation_Service" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> FACTURATIONS(SYNT.)/ORGANISATION-SERV
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showListePatientByOrganisation_Abonnee" block color="#B72C2C" dark>
                                            <v-icon>print</v-icon> LISTE DES PETIENTS/ORGANISATION
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>

                            <br>

                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <v-flex md3>
                       
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Organisation'" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="organisationList"
                                item-text="nom_org" item-value="nom_org" dense outlined v-model="svData.organisationAbonne"
                                chips clearable >
                            </v-autocomplete>
                        </div>
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
                refUniteProduction: "", 
                refDepartement:0,
                organisationAbonne:""                
            },
            stataData: {                
            },
            fetchData: null,            
            titreModal: "",
            departementList: [],
            uniteproductionList: [],
            organisationList: [],
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
           
        },      
      fetchListDepartement() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.departementList = donnees;

          }
        );
      },      
      fetchListOrganisation() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_organisation`).then(
          ({ data }) => {
            var donnees = data.data;
            this.organisationList = donnees;

          }
        );
      }
      ,
     //fultrage de donnees
      async Get_unite_for_Departement(idDepartement) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_unite_Departement2/${idDepartement}`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.uniteproductionList = chart;
              } else {
                  this.uniteproductionList = [];
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

        showDetailFactureByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_date?date1=` + date1+"&date2="+date2);           
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
           //fetch_rapport_detailfacture_credit_avance_date
           
        },
//
        showDetailFactureCreditByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_credit_date?date1=` + date1+"&date2="+date2);           
            
            } else {
            this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        
        
        },
//
        showDetailFactureCreditAvanceByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_detailfacture_credit_avance_date?date1=` + date1+"&date2="+date2);           
            
            } else {
            this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        
        
        },
        showListePatientByOrganisation_Abonnee() {
            if(this.svData.organisationAbonne!="")
            {
                window.open(`${this.apiBaseURL}/fetch_rapport_listePatientOrganisation?organisationAbonne=`+this.svData.organisationAbonne);
            }
            else
            {
               this.showError("Veillez selectionner l'Organisation svp");
            } 
        },
        showDetailFactureByDate_Organisation() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.organisationAbonne!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_par_organisation?date1=` + date1+"&date2="+date2+"&organisationAbonne="+this.svData.organisationAbonne);
                }else
                {
                    this.showError("Veillez selectionner le mdecin svp");
                }               
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailFactureByDate_Departement() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                if(this.svData.refDepartement!="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_date_departement?date1=` + date1+"&date2="+date2+"&refDepartement="+this.svData.refDepartement);
                }
                else
                {
                    this.showError("Veillez selectionner le departement svp");
                }
                  //fetch_rapport_entetefacture_date_organisation_all         
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showEnteteFactureByDate_Abonne() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_date_organisation_all?date1=` + date1+"&date2="+date2);      
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailFactureByDate_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                if(this.svData.refUniteProduction !="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_date_service?date1=` + date1+"&date2="+date2+"&refUniteProduction="+this.svData.refUniteProduction);
                }
                else
                {
                    this.showError("Veillez selectionner le service svp");
                }
                           
               
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        showDetailFactureByDate_Organisation_Service() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {

                if(this.svData.refUniteProduction !="" || this.svData.organisationAbonne !="")
                {
                    window.open(`${this.apiBaseURL}/fetch_rapport_entetefacture_par_organisation_service?date1=` + date1+"&date2="+date2+"&organisationAbonne="+this.svData.organisationAbonne+"&refUniteProduction="+this.svData.refUniteProduction);
                }
                else
                {
                    this.showError("Veillez selectionner le medecin et le service svp");
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

        this.fetchListOrganisation();
        this.fetchListDepartement();
        this.showDate=true;
    },
};
</script>