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
                                <v-date-picker v-model="dates" range></v-date-picker>
                            </v-col>
                            <v-col cols="12" sm="6">
                                <v-text-field v-model="dateRangeText" label="Date range" prepend-icon="mdi-calendar"
                                    readonly></v-text-field>

                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez Type de Produit" prepend-inner-icon="map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeProduitList"
                                            item-text="nom_typeproduit" item-value="id" dense outlined
                                            v-model="svData.refTypeProduit" clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>
                                <br>
                                <v-tooltip bottom color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                            <v-btn @click="showTarification" block color="#B72C2C" dark>
                                                <v-icon>print</v-icon> TARIFICATION
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
                            <v-autocomplete label="Selectionnez la Catégorie de Société" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="categorieSocieteList"
                                item-text="name_categorie_societe" item-value="id" dense outlined
                                v-model="svData.refCategorieSociete" clearable chips>
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
                refTypeProduit: 0,
                refCategorieSociete: 0,

            },
            stataData: {
            },
            fetchData: null,
            titreModal: "",
            categorieSocieteList: [],
            typeProduitList: [],
            filterValue: '',
            dates: [],
            showDate: false,
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
        fetchListCategorieSociete() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_tfin_categorie_societe_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.categorieSocieteList = donnees;

                }
            );
        }
        ,
        //fetch_fin_typeproduit_2
        async fetchTypeProduit() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeproduit_2`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.typeProduitList = donnees;

                }
            );
        },

        showTarification() {

            if (this.svData.refTypeProduit != 0 && this.svData.refCategorieSociete != 0) {
                window.open(`${this.apiBaseURL}/fetch_rapport_tarification?refTypeProduit=` + this.svData.refTypeProduit + "&refCategorieSociete=" + this.svData.refCategorieSociete);

            } else {
                this.showError("Veillez Seléctionner la Catégorie de Sté et le Type de Produit");
            }


        },


        rechargement() {
            this.onPageChange();

        },




    },
    created() {
        this.fetchListCategorieSociete();
        this.fetchTypeProduit();
        this.showDate = true;
    },
};
</script>