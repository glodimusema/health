<template>
    <div>
        <!-- composent -->
        <v-layout
            row
            wrap
            class="mt-0"
            >
            <!-- statistique -->
            <v-flex md3 lg3 xs12 class="mb-2">
                <v-container>
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->

                    <!-- <v-list-item three-line router to="/admin/malades">  -->
                    <v-list-item three-line router to="#">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Total Malades</div>
                        <v-list-item-title class="text-h5 mb-1">
                            {{svData.NombreMaladeTotal}}
                        </v-list-item-title>
                        <v-list-item-subtitle>dans le système</v-list-item-subtitle>
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
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <!-- <v-list-item three-line router to="/admin/entete_consultation"> -->
                    <v-list-item three-line router to="#">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Consultations</div>
                        <v-list-item-title class="text-h5 mb-1">
                         {{svData.NombreConsultation}} 
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        >
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
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <!-- <v-list-item three-line router to="/admin/entete_consultation"> -->
                        <v-list-item three-line router to="#">
                    <v-list-item-content>
                        <div class="text-overline mb-4">Ordonances</div>
                        <v-list-item-title class="text-h5 mb-1">
                         {{svData.NombreOrdonance}}  
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système </v-list-item-subtitle
                        >
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
                <v-card
                    class="mx-auto"
                    :loading="loading"
                    :disabled="isloading"
                    outlined
                    tile
                    max-width="344"
                >
                    <!-- card commence -->
                    <v-list-item three-line router to="#">
                    <!-- <v-list-item three-line router to="/admin/medecin"> -->
                    <!-- <v-list-item three-line @click.stop="showPDGNavigation()"> -->
                    <v-list-item-content>
                        <div class="text-overline mb-4">Medecins</div>
                        <v-list-item-title class="text-h5 mb-1">
                        {{svData.NombreMedecin}}
                        </v-list-item-title>
                        <v-list-item-subtitle
                        >Dans le système</v-list-item-subtitle
                        >
                    </v-list-item-content>

                    <v-list-item-avatar tile size="80" color="blue lighten-2">
                        <v-icon size="60" color="white">supervised_user_circle</v-icon>
                    </v-list-item-avatar>
                    </v-list-item>

                   

                    <!-- fin card -->
                </v-card>
                </v-container>
            </v-flex>

            <!-- fin statistique -->
            </v-layout>

           

            <v-layout row wrap>
                <v-flex md6 xs12 sm12  lg6 class="mb-0">
                    <v-container>
                        <stat_ordonance_genre v-bind:typechart="stat.typechart2" />
                        
                    </v-container>
                </v-flex>

                <v-flex md6 xs12 sm12  lg6 class="mb-0">
                    <v-container>
                        <statBlog v-bind:typechart="stat.typechart2" /> 
                    </v-container>
                </v-flex>
           
            </v-layout>

            <v-layout row wrap>
                <v-flex xs12 lg12 md12 sm12>

                    <div class="text-center">
                        <v-bottom-sheet
                        v-model="sheet"
                        persistent
                    
                    
                        >
                        
                        <v-sheet
                            class="text-center"
                            height="350px"
                        
                            
                        >
                            <v-btn
                            class="mt-6"
                            text
                            color="error"
                            @click="sheet = !sheet"
                            >
                            Fermer
                            </v-btn>
                            <div class="py-3">
                                
                            

                            <v-layout row wrap>

                                <v-flex xs12 sm12 md5 lg5>
                                    <v-container class="ml-0">

                                        <StatMontantEntrantYeba />
                                        
                                    </v-container>
                                </v-flex>
                                <v-flex xs12 sm12 md5 lg5>
                                    <v-container class="ml-0">

                                        <SexeDashCeo v-bind:typechart="stat.typechart3" />
                                        
                                    </v-container>
                                </v-flex>

                                <v-flex xs12 sm12 md2 lg2>
                                   
                                </v-flex>
                            </v-layout>


                            </div>
                        </v-sheet>
                        </v-bottom-sheet>
                    </div>
                    
                </v-flex>
            </v-layout>


            <ListeCeo v-bind:drawer="drawer" />

    </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ListeCeo from "./ListeCeo.vue";

import dashEntreprise from './dashEntreprise.vue'
import SexeDashCeo from "./sexeDashCeo.vue";
import StatMontantEntrantYeba from './statMontantEntrantYeba.vue'
import stat_ordonance_genre from "./stat_ordonance_genre.vue";
import statBlog from './statBlog.vue';


export default {
    components:{
        dashEntreprise,
        ListeCeo,
        SexeDashCeo,
        StatMontantEntrantYeba,
        stat_ordonance_genre,
        statBlog

    },
    data(){
        return{
            titre: "Statistique",
            team: [],
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            drawer:null,

            stateData:{
                
                titre:'',
                list:[],
                titre2:'',
                listSecteur:[],
                listEdition:[],
            },

           
            fav: false,
            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },

            svData: {
                NombreTotalUtilisateur: '',
                NombreMedecin:'',
                NombreMembre:'',
                NombreAdmin:'',

                NombreEntrepriseActif:'',
                NombreEntrepriseInactif:'',
                NombreOrdonance:'',
                NombreConsultation:"",
                NombreMaladeTotal:"",
                
            },

            sheet: false,

            picker: new Date(Date.now() - new Date().getTimezoneOffset() * 60000)
                .toISOString()
                .substr(0, 10),
            
            query: "",
            fetchData: null,
            stat: {
                options: null,
                series: null,
                typechart1: "line",
                typechart2: "area",
                typechart3: "bar",
                typechart4: "donut",
            },
            

        }

    },
    
    computed: {
        ...mapGetters(["roleList","isloading"]),
    },
    methods: {

         ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),

        showPDGNavigation()
        {
            this.drawer = !this.drawer;
        },
        showCountNotification() {
            var id_user = this.userData.id;
            this.editOrFetch(
                `${this.apiBaseURL}/showCountDashbord`
            ).then(({ data }) => {
                var donnees = data.data;

                this.getSvData(this.svData, data.data[0]);

            });
        },

        showfiltrage(){
            this.loading = true;
            this.editOrFetch(`${this.apiBaseURL}/statEntreprise`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.stateData.list = donnees;
                    this.loading = false;
                    this.stateData.titre="Statistique des entreprises par rapport à l'Edition";

                }
            );

        },
        showfiltrageSecteur(){
            this.loading = true;
            this.editOrFetch(`${this.apiBaseURL}/statEntrepriseSecteur`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.stateData.listSecteur = donnees;
                    this.loading = false;
                    this.stateData.titre2="Statistique des entreprises par rapport aux secteurs d'activité";
                   
                }
            );
        },

        // showfiltrageEditionPrint(){
        //     this.loading = true;
        //     this.editOrFetch(`${this.apiBaseURL}/statEntreprisePrint`).then(
        //         ({ data }) => {
        //             var donnees = data.data;
        //             this.stateData.listEdition = donnees;
                   
        //         }
        //     );
        // },

        printBill(edition) {
            window.open(`${this.apiBaseURL}/pdf_liste_entreprise_morale?edition=` + edition);
        },

        

        

        
    },
    created() {
        this.showCountNotification();
        this.showfiltrage();
        this.showfiltrageSecteur();
        //this.showfiltrageEditionPrint();

    },

}
</script>
<style scoped>
#views {
  max-height: 470px;
  overflow: scroll;
}
#views2 {
  max-height: 250px;
  overflow: scroll;
}


</style>
