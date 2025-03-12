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
                                range
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
                                        <v-btn @click="onPageChange" block color="#B72C2C">
                                            <v-icon>mdi-calendar</v-icon> VALIDER
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Soumettre la requête</span>
                            </v-tooltip>
                            <br>

                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="PrintshowCardByDate" block color="#B72C2C">
                                            <v-icon>print</v-icon> PDF RAPPORT
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Imprimer le rapport</span>
                            </v-tooltip>
                            
                            </v-col>
                        </v-row>
                      
                    </v-flex>
                   

                    <v-flex md3>
                       

                    </v-flex>

                    <v-flex md1>
                        <v-tooltip bottom color="black">
                            <template v-slot:activator="{ on, attrs }">
                                <span v-bind="attrs" v-on="on">
                                    <v-btn @click="showDate = !showDate" fab color="#B72C2C">
                                        <v-icon>mdi-calendar</v-icon>
                                    </v-btn>
                                </span>
                            </template>
                            <span>Ajouter une opération</span>
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
                idEntreprise: "",
                id_tarif: "",
                id_agent:[],
                remise: 0,
                ceo: "",
                selectionAgent:[],
                
                
            },
            stataData: {
                entrepriseList: [],
                agentList: [],

            },
            fetchData: null,
            titreModal: "",
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
            this.svData.id_agent=[];
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
            if (this.dates.length >= 1) {
                this.showCardByDate();
            } else {
                this.fetch_data(`${this.apiBaseURL}/fetch_abonnement_carte?page=`);                
            }
           
        },

        showCardByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                this.fetch_data(`${this.apiBaseURL}/fetch_rapport_labo_date/${date1}/${date2}?page=`);
                //this.getLotListAdmin(); 
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
           
           
        },

        PrintshowCardByDate() {
            var date1 =  this.dates[0] ;
            var date2 =  this.dates[1] ;
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/fetch_rapport_labo_date?date1=` + date1+"&date2="+date2);
            } else {
               this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
           
           
        },

       

        printCard(codePrint) {
            window.open(`${this.apiBaseURL}/print_pdf_card2?codePrint=` + codePrint);
        },

    
        //fultrage de donnees
        async getEntrepriseByCeo(ceo) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/getEntrepriseByCeo/${ceo}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.entrepriseList = chart;
                    } else {
                        this.stataData.entrepriseList = [];
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

        //chargement des agents
        searchTugAgent: _.debounce(function () {
            this.getAgentByEntreprise();
        }, 300),

        async getAgentByEntreprise() {
            this.isLoading(true);
            // this.svData.id_agent=[];

            var id_entreprise = this.svData.idEntreprise ;

            this.fetch_data2(`${this.apiBaseURL}/ProfileAgentTugEntreprise/${id_entreprise}?page=`);

        },

       
        //fin chargement des agents

        showDetailModalLot(codeR) {
        
            if (codeR !=null) {

                // this.$refs.detailLotModal.$data.dialog = true;
                // this.$refs.detailLotModal.$data.svData.codeR = codeR;
                // this.$refs.detailLotModal.display_profile(codeR);
                // this.$refs.detailLotModal.display_dataEntreprise(codeR);
                // this.$refs.detailLotModal.onPageChange();
                

                // this.$refs.detailLotModal.$data.titleComponent =
                //     "Détail du lot de commande pour l'obtension de carte "+codeR;
                
            } else {
                this.showError("Aucune action  n'a été faite!!! prière de selectionner un lot de commande");
            }
    
        },
        

        rechargement()
        {
            this.onPageChange();
            
        },

       


    },
    created() {
        // this.getUser2();
        // this.getTarif();
        // this.testTitle();
        //this.onPageChange();
        // this.getLotListAdmin();
       
    },
};
</script>