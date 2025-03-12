<template>
    <v-layout>
        <v-flex md12>

            <!-- modal  -->
            <avatarAvatar ref="avatarAvatar" />
            <!-- fin modal -->

            <AvatarProfil ref="avatarPhoto" />


            <v-dialog v-model="dialog" max-width="500px" scrollable hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                        <v-card-title>
                            {{ titleComponent }} <v-spacer></v-spacer>
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
                        <v-card-text max-height="1000px">
                            <v-layout row wrap>

                                <v-flex xs12 sm12 md12 lg12>
                                    <v-select label="Selectionnez la Categorie" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="designation" item-value="id"
                                    outlined v-model="svData.refCategieClient">
                                    </v-select>  
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12>
                                    <v-text-field label="Nom complet" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.noms"></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse mail" prepend-inner-icon="draw" dense :rules="[
                                          (v) => !!v || 'Ce champ est requis',
                                          (v) =>
                                            /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                                        ]" outlined v-model="svData.mail"></v-text-field>
                                    </div>
                                </v-flex>                               

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.contact">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                 <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList"
                                            item-text="nomPays" item-value="id" dense outlined v-model="svData.idPays"
                                            chips clearable @change="get_data_tug_pays(svData.idPays)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.provinceList" item-text="nomProvince" item-value="id"
                                            dense outlined v-model="svData.idProvince" clearable chips
                                            @change="get_data_tug_province(svData.idProvince)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.villeList"
                                            item-text="nomVille" item-value="id" dense outlined v-model="svData.idVille"
                                            clearable chips @change="get_data_tug_commune(svData.idVille)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la commune" prepend-inner-icon="push_pin"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.communeList" item-text="nomCommune" item-value="id" dense
                                            outlined v-model="svData.idCommune" clearable
                                            @change="get_data_tug_quartier(svData.idCommune)" chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                            :rules="[(v) => !!v || 'Ce champ est requis']"
                                            :items="stataData.quartierList" item-text="nomQuartier" item-value="id"
                                            dense outlined v-model="svData.idQuartier"
                                            @change="get_data_tug_Avenue(svData.idQuartier)" clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>

                                    <div class="mr-1">

                                        <v-autocomplete label="Selectionnez l'avenue" prepend-inner-icon="domain"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.avenueList"
                                            item-text="nomAvenue" item-value="id" dense outlined
                                            v-model="svData.refAvenue" clearable chips>
                                        </v-autocomplete>

                                    </div>

                                </v-flex>

                                  <v-flex xs12 md12 sm12 lg12 class="mb-2">
                                    <input class="form-control" type="file" id="photo_input" @change="onImageChange"
                                        required />
                                    <br />
                                    <img :style="{ height: style.height }" id="output" />


                                </v-flex>
                            </v-layout>
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
                <v-layout>
                     
                     <v-flex md12></v-flex>
                     
                </v-layout>

                <v-flex md12>
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
                        <v-flex md4>
                            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                                hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                        </v-flex>

                        <v-flex md6></v-flex>

                        <v-flex md1>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showModal" fab color="#B72C2C" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Ajouter une opération</span>
                            </v-tooltip>
                        </v-flex>
                    </v-layout>
                    <!-- bande -->

                    <br />
                    <v-card :loading="loading" :disabled="isloading">
                        <v-card-text>
                            <v-simple-table>
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th class="text-left">Nom</th>
                                            <th class="text-left">Contacts</th>
                                            <th class="text-left">E-mail</th>
                                            <th class="text-left">Adresse</th>
                                            <th class="text-left">DateAchat</th>
                                            <th class="text-left">NombreJours</th>
                                            <th class="text-left">Observation</th>                                            

                                            <th>Mise à jour</th>

                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>

                                                <!-- image -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="
                                                  item.photo == null
                                                    ? `${baseURL}/fichier/avatar.png`
                                                    : `${baseURL}/fichier/` + item.photo
                                                " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.noms}}
                                            </td>
                                            <td>
                                                <a :href="'tel:'+item.contact">{{item.contact}}</a> 
                                            </td>
                                            <td>
                                                <a :href="'mailto:'+item.mail">
                                                    {{ item.mail}}
                                                </a>
                                            </td>
                                            <td>{{ item.nomQuartier+"-"+item.nomAvenue}}</td>
                                            <td>
                                                {{ item.dateVente | formatDate }}                                                
                                            </td>
                                            <td>{{ item.NombreJour}}</td>
                                            <td>{{ item.Observation}}</td>

                                            <td>                                              
                                               
                                                <v-menu bottom rounded offset-y transition="scale-transition">
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on" small fab depressed text>
                                                            <v-icon>more_vert</v-icon>
                                                        </v-btn>
                                                    </template>

                                                    <v-list dense width="">
                                                      
                                                        <v-list-item link @click="printBill(item.Observation)">
                                                            <v-list-item-icon>
                                                                <v-icon>print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">PDF Fiche
                                                            </v-list-item-title>
                                                        </v-list-item>
                                                    </v-list>
                                                </v-menu>


                                            </td>
                                        </tr>
                                    </tbody>
                                </template>
                            </v-simple-table>
                            <hr />

                            <v-pagination color="#B72C2C" v-model="pagination.current" :length="pagination.total"
                                :total-visible="7" @input="onPageChange"></v-pagination>
                        </v-card-text>
                    </v-card>
                    <!-- les composants -->

                    <!-- fin des composants -->
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>
    
<script>
import { mapGetters, mapActions } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "./AvatarProfil.vue"
import avatarAvatar from './AvatarAction.vue'

export default {
    components: {
        AvatarProfil,
        avatarAvatar,
    },
    data() {
        return {
            header: "crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,
            style: {
                height: "0px",
            },
            svData: {
                id: "",
                noms: "",
                contact: "",                
                mail: "",
                refAvenue: "",
                refCategieClient: "",
                author: "",
                Categorie:"",
                idPays: "",
                idProvince: "",
                idVille: "",
                idCommune: "",
                idQuartier: "",
                author:"Admin",
            },
            stataData: {                
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList: [],
                quartierList: [],
                avenueList: [],


            },
            fetchData: null,
            titreModal: "",
            image: "",
            clientList: [],            
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },
        };
    },

    computed: {
        ...mapGetters(["basicList", "paysList",
            "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic", "getPays","getCategorie",
            "getProvince", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement du Client ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification du Client ";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Client ";
                this.style.height = "0px";
            }
        },

        // searchMember: _.debounce(function () {
        //     this.onPageChange();
        // }, 300),
        onPageChange() {
            //var connected = this.userData.id;
            this.fetch_data(`${this.apiBaseURL}/ad1/Recouvrement?page=`);            
        },

        onImageChange(e) {
            this.image = e.target.files[0];
            let output = document.getElementById("output");
            output.src = URL.createObjectURL(e.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src);
                this.style.height = "240px"; // free memory
            };
        },  
      
      printBill(observation) {
        window.open(`${this.apiBaseURL}/pdf_recouvrement_data?observation=` + observation);
      },
        fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_list_categorie`).then(
          ({ data }) => {
            var donnees = data.data;
            this.clientList = donnees;
  
          }
        );
      },
        updatePhoto() {
            const config = {
                headers: { "content-type": "multipart/form-data" },
            };

            let formData = new FormData();
            formData.append("data", JSON.stringify(this.svData));
            formData.append("image", this.image);

            if (this.edit == true) {
                axios
                    .post(`${this.apiBaseURL}/ad1/update_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();

                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            } else {
                axios
                    .post(`${this.apiBaseURL}/ad1/insert_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();
                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            }
        },

        validate() {
            if (this.$refs.form.validate()) {
                // this.isLoading(true);

                if (this.edit) {
                    this.updatePhoto();
                } else {
                    this.updatePhoto();
                }
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_single_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;


                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification de  formation de l'entreprise ";
                        this.get_data_tug_pays(item.idPays);
                        this.get_data_tug_province(item.idProvince);
                        this.get_data_tug_commune(item.idVille);
                        this.get_data_tug_quartier(item.idCommune);
                        this.get_data_tug_Avenue(item.idQuartier)
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                var connected = this.userData.id;
                this.delGlobal(`${this.apiBaseURL}/ad1/delete_client/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_single_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification de  client de l'entreprise";
                    });
                }
            );
        },

        //les operation commence
        //fultrage de donnees
        async get_data_tug_pays(id_pays) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_province_tug_pays/${id_pays}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.provinceList = chart;
                    } else {
                        this.stataData.provinceList = [];
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

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.villeList = chart;
                    } else {
                        this.stataData.villeList = [];
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

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.communeList = chart;
                    } else {
                        this.stataData.communeList = [];
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

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_quartier_tug_commune/${idCommune}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.quartierList = chart;
                    } else {
                        this.stataData.quartierList = [];
                    }

                    this.isLoading(false);

                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        async get_data_tug_Avenue(idQuartier) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/getAvenueTug/${idQuartier}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.avenueList = chart;
                    } else {
                        this.stataData.avenueList = [];
                    }

                    this.isLoading(false);

                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },



        initialisation() {
            this.fetch_province_2();
        },

        showProfileModal(id, name, created) {

            if (id != null) {

                this.$refs.avatarPhoto.$data.dialog = true;
                this.$refs.avatarPhoto.$data.svData.id = id;
                this.$refs.avatarPhoto.$data.svData.created = created;
                this.$refs.avatarPhoto.display_profile(id);

                this.$refs.avatarPhoto.$data.titleComponent =
                    "Détail du Profile  ";

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },

        // printBill(slug) {
        //     window.open(`${this.apiBaseURL}/pdf_client_data?slug=` + slug);
        // },

        showProfileModalclient(id, name) {

            if (id != null) {

                this.$refs.avatarAvatar.$data.dialog = true;
                this.$refs.avatarAvatar.$data.svData.id = id;
                this.$refs.avatarAvatar.display_profile(id);

                this.$refs.avatarAvatar.$data.titleComponent =
                    "Détail du Profile de " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },        


    },
    created() {
        this.onPageChange();
        // this.testTitle();
        // this.onPageChange();
        // this.getPays();
        // this.getCategorie();
        // this.fetchListSelection();
             
    },
};
</script>
    
<style scoped>
.mb-2 {
    margin-top: 10px;
}

.form-control {
    display: block;
    width: 100%;
    height: calc(1.5em + .75rem + 2px);
    padding: .375rem .75rem;
    font-size: 1rem;
    font-weight: 400;
    line-height: 1.5;
    color: #495057;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}
</style>