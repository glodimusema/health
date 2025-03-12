<template>
    <div>
        <v-layout row wrap>
            <v-flex xs12 md12 lg12 sm12>
                <v-navigation-drawer
                    v-model="drawer"
                    absolute
                    right
                    temporary
                    width="320"
                
                >

                    <v-list-item>
                        
                        <v-list-item-content>
                            <v-text-field
                                append-icon="search"
                                label="Recherche un ceo ..."
                                single-line
                                solo
                                outline
                                round
                                hide-details
                                v-model="query"
                                @keyup="this.onPageChangeCeoEntreprise"
                                clearable
                            ></v-text-field>
                            <br>
                        </v-list-item-content>
                    </v-list-item>

                    <v-divider></v-divider>

                
                    
                    <!--  liste ceo -->
                    <v-list dense>
                    
                        <v-subheader>Liste des Medecins</v-subheader>
                        <v-list-item
                        style="height: 60px"
                        v-for="data in fetchData"
                        :key="data.id"
                        
                        >
                           
                            <v-list-item-avatar>
                                <userImage :width="40" :height="40" :image="data.avatar" />
                            </v-list-item-avatar>
                            <v-list-item-content>
                                <v-list-item style="position: relative; left: -10px">
                                <b>{{ data.noms_medecin+"/"+data.fonction_medecin }}</b>
                                </v-list-item>
                                <div
                                    class="text--primary"  
                                    style="height: 20px;
                                        position: relative;
                                        top: -8px;
                                        padding: 2px;
                                    "
                                >
                                {{data.mail_medecin}}
                                </div>
                                
                            </v-list-item-content>
                            <v-list-item-action v-if="userData.id_role==1 ? true :false">
                                <v-btn
                                small
                                :disabled="loading"
                                fab
                                depressed
                                link
                                :to="'/admin/entreprise_detail/' + data.slug"
                                >
                                <v-icon>visibility</v-icon>
                                </v-btn>
                            </v-list-item-action>
                            
                        </v-list-item>
                       
                        
                    </v-list>
                    <v-divider></v-divider>
                    <!-- fin liste ceo -->

                    <v-flex xs12 md12 lg12 sm12>

                        <div class="text-center">
                            <v-pagination
                                color="#B72C2C"
                                v-model="pagination.current"
                                :length="pagination.total"
                                :total-visible="0"
                                @input="onPageChangeCeoEntreprise"
                            ></v-pagination>
                        </div>
                        
                    </v-flex>

                
                </v-navigation-drawer>
        </v-flex>
        </v-layout>
    </div>
</template>
<script>
//
import { mapGetters, mapActions } from "vuex";
import userImage from "./userImage.vue";
export default {
    props:["drawer"],
    components:{
        userImage,

    },
    data(){
        return{
            query: "",
            fetchData:null,
            ListMenu:null,
        }
    },
    computed: {
        ...mapGetters([
            "isloading",
            "paysList",
            "provinceList",
            "user2List",
            "formeJuridiqueList",
            "secteurList",
            "ListeEdition",

        ]),
    },
    methods:{

        ...mapActions([
            "getPays",
            "getProvince",
            "getUser2",
            "getFormejuridique",
            "getSecteurList"
        ]),

        // fetch ceo
        // searchMember: _.debounce(function () {
        // this.onPageChangeCeoEntreprise();
        // }, 300),
        onPageChangeCeoEntreprise() {
            this.fetch_data(`${this.apiBaseURL}/fetch_medecin?page=`);
        },
///
    },
    created(){
        this.onPageChangeCeoEntreprise();
    },
}
</script>

