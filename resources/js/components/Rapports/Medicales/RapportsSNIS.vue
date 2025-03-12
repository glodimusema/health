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
                            <v-col cols="12" sm="6">
                                <v-date-picker v-model="dates" range color="#B72C2C"></v-date-picker>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field v-model="dateRangeText" label="Date range" prepend-icon="mdi-calendar"
                                    readonly></v-text-field>

                                <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowStatAgeByDate" block color="#B72C2C" dark>
                                                <v-icon>print</v-icon> RAPPORT STATISTIQUE DES MALADES
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>
                                <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowStatOrganisationByDate" block color="#B72C2C" dark>
                                                <v-icon>print</v-icon> RAPPORT STATISTIQUE DES MALADES(ORG.)
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>
                                <br>
                                
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowStatLaboByDate" block color="#B72C2C" dark>
                                                <v-icon>print</v-icon> STATISTIQUE EXAMENS
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>
                                <br>

                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="PrintshowStatCasDecesByDate" block color="#B72C2C" dark>
                                                <v-icon>print</v-icon> STATISTIQUE CAS DES DECES
                                            </v-btn>
                                        </span>
                                    </template>
                                    <span>Imprimer le rapport</span>
                                </v-tooltip>


                            </v-col>
                        </v-row>

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
                id_agent: [],
                remise: 0,
                ceo: "",
                selectionAgent: [],
                refCompte: "",
                refTrajectoire: 0,
                refTypetarification: 0,
                refBanque: 0,
                nom_mode: "",
                cas_triage:""

            },
            stataData: {
                entrepriseList: [],
                agentList: [],


            },
            fetchData: null,
            BanqueList: [],
            ModeList: [],
            titreModal: "",
            typetarifList: [],
            trajectoireList: [],
            compteList: [],
            filterValue: '',
            dates: [],
            showDate: true,

        };
    },
    computed: {

        dateRangeText() {
            return this.dates.join(' ~ ')
        },
    },
    methods: {
        showModal() {
            this.dialog = true;
            this.titleComponent = "Ajout Tarification ";
            this.edit = false;
            this.resetObj(this.svData);
            this.svData.id_agent = [];
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
        PrintshowStatLaboByDate() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/pdf_examen_labo_snis?date1=` + date1 + "&date2=" + date2);               
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowStatCasDecesByDate() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/pdf_stat_cas_de_deces_snis?date1=` + date1 + "&date2=" + date2);               
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowStatOrganisationByDate() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/pdf_statistique_patient?date1=` + date1 + "&date2=" + date2);               
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },
        PrintshowStatAgeByDate() {

            var date1 = this.dates[0];
            var date2 = this.dates[1];
            if (date1 <= date2) {
                window.open(`${this.apiBaseURL}/pdf_statistique_type_mouvement?date1=` + date1 + "&date2=" + date2);               
            } else {
                this.showError("Veillez vérifier les dates car la date debit doit être inférieure à la date de fin");
            }
        },


        showDetailModalLot(codeR) {

            if (codeR != null) {

            } else {
                this.showError("Aucune action  n'a été faite!!! prière de selectionner un lot de commande");
            }

        },


        rechargement() {
            this.onPageChange();

        },




    },
    created() {
       
    },
};
</script>