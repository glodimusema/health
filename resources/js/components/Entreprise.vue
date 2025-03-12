<template>
    <v-layout>
      <v-flex md12>
        <AvatarProfil ref="avatarPhoto" />
        <v-dialog v-model="dialog" max-width="830px"  hide-overlay transition="dialog-bottom-transition">
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
                <v-container>
                  <v-layout row wrap>

                        <v-flex xs12 sm6 md6 lg6>
                            <div class="mr-1">
                            <v-autocomplete
                                label="Liste des ceo"
                                prepend-inner-icon="person"
                                :rules="[(v) => !!v || 'Ce champ est requis']"
                                :items="coList"
                                item-text="name"
                                item-value="user_id"                                
                                outlined
                                clearable
                                v-model="svData.ceo"
                                chips
                                dense
                                
                            >
                                <template v-slot:item="data">
                                
                                <template>
                                    <v-list-item-avatar>
                                    <img
                                        :src="
                                            data.item.avatar == null
                                            ? `${baseURL}/images/avatar.png`
                                            : `${baseURL}/images/` + data.item.avatar
                                        "
                                        alt="alt"
                                    />
                                    </v-list-item-avatar>
                                
                                    <v-list-item-content>
                                    <!-- <v-list-item-title
                                        v-html="data.item.name"
                                    ></v-list-item-title> -->
                                    <!-- <v-list-item-subtitle
                                        v-html="data.item.email"
                                    ></v-list-item-subtitle> -->
                                    </v-list-item-content>
                                </template>
                                </template>
                            </v-autocomplete>
                            </div> 
                        </v-flex> 

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Nom de l'entreprise" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Adresse mail" prepend-inner-icon="draw" dense
                        :rules="[
                          (v) => !!v || 'Ce champ est requis',
                          (v) =>
                            /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                        ]" outlined v-model="svData.email"></v-text-field>
                       </div>
                      </v-flex>
  
                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="N° de téléphone principale" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tel1"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Autre N° de téléphone" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tel2"></v-text-field>
                       </div>
                      </v-flex>
  
                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Adresse domicile" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.adresse"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Identification nationale" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.idnational"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Numéro d'impôt" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numImpot"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="RCCM" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.rccm"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Busnness name" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.busnessName"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Code du busness" prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.codeBusness"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="numéro de Contact " prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.contactNumCode"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                       <div class="mr-1">
                        <v-text-field label="Année de création " prepend-inner-icon="draw" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.anneeFondation"></v-text-field>
                       </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Numéro de la caisse sociale " prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numCaisseSocial"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Numéro INPP " prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numInpp"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Numéro de personnalité juridique " prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numPersonneJuridique"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Lien de votre Site web" prepend-inner-icon="public" dense
                             outlined v-model="svData.siteweb"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Lien de votre page facebook" prepend-inner-icon="public" dense
                             outlined v-model="svData.facebook"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Lien de votre page twitter" prepend-inner-icon="public" dense
                             outlined v-model="svData.twitter"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-text-field label="Lien de votre page linkedin" prepend-inner-icon="public" dense
                             outlined v-model="svData.linkedin"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la forme juridique" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="formesList"
                            item-text="nomForme" item-value="id" dense outlined v-model="svData.idForme" clearable
                            chips>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le secteur d'activité" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="secteursList"
                            item-text="nomSecteur" item-value="id" dense outlined v-model="svData.idSecteur" clearable
                            chips>
                          </v-autocomplete>
                        </div>
                      </v-flex>
  
                     
  
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList" item-text="nomPays"
                            item-value="id" dense outlined v-model="svData.idPays" chips clearable
                            @change="get_data_tug_pays(svData.idPays)">
                          </v-autocomplete>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la province" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.provinceList"
                            item-text="nomProvince" item-value="id" dense outlined v-model="svData.idProvince" clearable
                            chips>
                          </v-autocomplete>
                        </div>
                      </v-flex>
  
                    
  
  
  
                    <v-flex xs12 md12 sm12 lg12 class="mb-2">
                     <div class="mr-1">
                        <input class="form-control" type="file" id="photo_input" @change="onImageChange" required />
                        <br />
                        <img :style="{ height: style.height }" id="output" />
  
                     </div>
  
                    </v-flex>
                  </v-layout>
                </v-container>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog = false"> Fermer </v-btn>
                <v-btn color="primary" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>
        <br />
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
                <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded hide-details
                  v-model="query" @keyup="searchMember" clearable></v-text-field>
              </v-flex>
  
              <v-flex md6></v-flex>
  
              <v-flex md1>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="showModal" fab color="primary">
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
                        <th>Logo</th>
                        <th class="text-left">Nom</th>
                        
                        <th class="text-left">Téléphone</th>
                        <th class="text-left">PDG</th>
                        <th class="text-left">Adresse</th>
                        <th class="text-left">Province</th>
                        <th class="text-left">Forme juridique</th>
                        <th class="text-left">Secteur d'activité</th>
  
                        <th>Mise à jour</th>
  
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>
  
                          <!-- image -->
                          <img style="border-radius: 50px; width: 50px; height: 50px" :src="
                            item.logo == null
                              ? `${baseURL}/fichier/avatar.png`
                              : `${baseURL}/fichier/` + item.logo
                          " />
                          <!-- images -->
                        </td>
                        <td>{{ item.nom}}</td>
                        <td>{{ item.tel1}}</td>
                        <td>
                            <v-chip  @click="showProfileModal(item.ceo, item.name,  item.created_at)">{{ item.name }}</v-chip>
                        </td>
                        <td>{{ item.adresse}}</td>
                        <td>{{ item.nomProvince}}</td>
                        <td>{{ item.nomForme}}</td>
                        <td>{{ item.nomSecteur}}</td>
                        
                        <td>
                          {{ item.created_at | formatDate }}
                          {{ item.created_at | formatHour }}
                        </td>
  
                        <td>
                          <v-tooltip top color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="editData(item.id)" fab small>
                                  <v-icon color="primary">edit</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Modifier</span>
                          </v-tooltip>
  
                          <v-tooltip top color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn @click="clearP(item.id)" fab small>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Supprimer</span>
                          </v-tooltip>

                          <v-menu
                                bottom
                                rounded
                                offset-y
                                transition="scale-transition"
                            >
                                <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                    <v-icon>more_vert</v-icon>
                                </v-btn>
                                </template>

                                <v-list dense width="">
                                    <v-list-item
                                        link
                                        :to="userData.id_role==1 || userData.id_role==3 ? 
                                        '/admin/entreprise_detail/'+ item.slug: '/user/entreprise_detail/' + item.slug"
                                    >
                                        <v-list-item-icon>
                                        <v-icon>description</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >Detail de l'entreprise</v-list-item-title
                                        >
                                    </v-list-item>


                                    <!-- <v-list-item
                                        
                                        link
                                        @click="printBill(item.slug)"
                                        
                                    >
                                        <v-list-item-icon>
                                            <v-icon>print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >PDF Rapport</v-list-item-title
                                        >
                                    </v-list-item> -->

                                    <v-divider></v-divider>
                                    <v-subheader>Utilisateur action</v-subheader>
                                    <v-divider></v-divider>

                                    <v-list-item
                                        
                                        link
                                        @click="showProfileModal(item.id_user_insert, item.name, item.created_at)"
                                        
                                    >
                                        <v-list-item-icon>
                                            <v-icon>person_add</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >User insert</v-list-item-title
                                        >
                                    </v-list-item>
                                    <v-list-item
                                        
                                        link
                                        @click="showProfileModal(item.id_user_update, item.name,  item.updated_at)"
                                        
                                    >
                                        <v-list-item-icon>
                                            <v-icon>assignment_ind</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >User Updated</v-list-item-title
                                        >
                                    </v-list-item>
                                
                                </v-list>
                            </v-menu>


                        </td>
                      </tr>
                    </tbody>
                  </template>
                </v-simple-table>
                <hr />
  
                <v-pagination color="primary" v-model="pagination.current" 
                :length="pagination.total" :total-visible="7"
                  @input="onPageChange"></v-pagination>
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
  
  export default {
    components: {
        AvatarProfil,
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
          idProvince: "",
          ceo: "",
          nom: "",
          email: "",
          adresse: "",
          tel1: "",
          tel2: "",
          siteweb: "",
          facebook: "",
          twitter: "",
          linkedin: "",
          idnational: "",
          rccm: "",
          numImpot: "",
          busnessName: "",
          codeBusness: "",
          idSecteur: "",
          contactNumCode: "",
          anneeFondation: "",
          numCaisseSocial: "",
          numInpp: "",
          idForme: "",
          numPersonneJuridique: "",
          connected:"",
          
        },
        stataData: {  
          paysList: [],
          provinceList: [] 
        },
        fetchData: null,
        formesList: [],
        secteursList: [],
        coList: [],
        titreModal: "",
        image: "",
        editor: ClassicEditor,
        editorConfig: {
          // The configuration of the editor.
          //  toolbar: [ 'bold', 'italic', '|', 'link' ]
        },
      };
    },
  
    computed: {
      ...mapGetters(["basicList", "paysList",
        "provinceList", "ListeEdition","formeJuridiqueList",
        "secteurList","user2List", "isloading"]),
    },
    methods: {
      ...mapActions(["getBasic", "getPays",
        "getProvince", "getFormejuridique",
        "getSecteurList", "getUser2",]),
  
  
      showModal() {
        this.dialog = true;
        this.titleComponent = "Paramètrage de Agent de l'entreprise ";
        this.edit = false;
        this.resetObj(this.svData);
      },
  
      testTitle() {
        if (this.edit == true) {
          this.titleComponent = "modification de  Agent de l'entreprise ";
          this.style.height = "0px";
        } else {
          this.titleComponent = "Paramètrage de Agent de l'entreprise ";
          this.style.height = "0px";
        }
      },
  
      searchMember: _.debounce(function () {
        this.onPageChange();
      }, 300),
      onPageChange() {
        this.fetch_data(`${this.apiBaseURL}/fetch_entreprise?page=`);
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
  
      updatePhoto() {
        const config = {
          headers: { "content-type": "multipart/form-data" },
        };
  
        let formData = new FormData();
        formData.append("data", JSON.stringify(this.svData));
        formData.append("image", this.image);
  
        if (this.edit == true) {
          axios
            .post(`${this.apiBaseURL}/update_entreprise`, formData, config)
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
            .post(`${this.apiBaseURL}/insert_entreprise`, formData, config)
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

          this.isLoading(true);

          this.svData.connected = this.userData.id;
  
          if (this.edit) {
            this.updatePhoto();
          } else {
            this.updatePhoto();
          }
        }
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_entreprise/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            
  
            donnees.map((item) => {
              this.svData.id = item.id;
              this.titleComponent = "modification de  formation de l'entreprise ";
              this.get_data_tug_pays(item.idPays);
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
          this.delGlobal(`${this.apiBaseURL}/delete_entreprise/${id}/${connected}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
      editTitleModal(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_entreprise/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.titleComponent = "modification de  Agent de l'entreprise";
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
  
       //visualisation de
      async fetch_province_2() {
        this.isLoading(true);
        await axios
          .get(`${this.apiBaseURL}/fetch_province_2`)
          .then((res) => {
            this.isLoading(false);
            var chart = res.data.data;
  
            if (chart) {
              this.stataData.provinceList = chart;
            } else {
              this.stataData.provinceList = [];
            }
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
        
        if (id !=null) {

            this.$refs.avatarPhoto.$data.dialog = true;
            this.$refs.avatarPhoto.$data.svData.id = id;
            this.$refs.avatarPhoto.$data.svData.created = created;
            this.$refs.avatarPhoto.display_profile(id);

            this.$refs.avatarPhoto.$data.titleComponent =
                "Détail du Profile";
            
        } else {
            this.showError("Personne n'a fait cette action");
        }
       
      },
  
      fetchListSecteur() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_secteur_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.secteursList = donnees;
          }
        );
      },
  
      fetchListForme() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_forme_juridiques_2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.formesList = donnees;
          }
        );
      },
      
      fetchListCO() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_user_ceo`).then(
          ({ data }) => {
            var donnees = data.data;
            this.coList = donnees;
          }
        );
      },
  
  
  
  
  
  
    },
    created() {
      this.onPageChange();
      this.testTitle();
      this.fetchListCO();
      this.fetchListForme();
      this.fetchListSecteur();
      this.getPays();
      

      // console.log(this.secteurList);
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