<template>
    <v-layout>
      <v-flex md12>
        <AvatarProfil ref="avatarPhoto" />
       
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
                        <td>{{ item.nom | subStrLong2 }}</td>
                        <td>{{ item.tel1 | subStrLong2 }}</td>
                        <td>
                            <v-chip  @click="showProfileModal(item.ceo, item.name,  item.created_at)">{{ item.name | subStrLong2 }}</v-chip>
                        </td>
                        <td>{{ item.adresse | subStrLong2 }}</td>
                        <td>{{ item.nomProvince | subStrLong2 }}</td>
                        <td>{{ item.nomForme | subStrLong2 }}</td>
                        <td>{{ item.nomSecteur | subStrLong2 }}</td>
                        
                        <td>
                          {{ item.created_at | formatDate }}
                          {{ item.created_at | formatHour }}
                        </td>
  
                        <td>
                         

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
                                        @click="RestoreData(item.id)"
                                        
                                    >
                                        <v-list-item-icon>
                                            <v-icon>create_new_folder</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >Restorer les données</v-list-item-title
                                        >
                                  </v-list-item>

                                  <v-list-item
                                        
                                        link
                                        @click="showProfileModal(item.id_user_insert, item.name, item.updated_at)"
                                        
                                    >
                                        <v-list-item-icon>
                                            <v-icon>person_remove</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px"
                                        >User deleted</v-list-item-title
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
  
                <v-pagination color="#B72C2C" v-model="pagination.current" 
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
          provinceList: [],
          formeList: [],
          secteurList: [],
         
  
        },
        fetchData: null,
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
        this.fetch_data(`${this.apiBaseURL}/fetch_entreprise_deleted?page=`);
      },
  
      
     
      RestoreData(id) {
        this.confirmMsg().then(({ res }) => {
          var connected = this.userData.id;
          this.delGlobal(`${this.apiBaseURL}/RestoreData/${id}/${connected}`).then(
            ({ data }) => {
              this.successMsg(data.data);
              this.onPageChange();
            }
          );
        });
      },
  
    
      

      showProfileModal(id, name, created) {
        
        if (id !=null) {

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
  
  
  
  
  
  
    },
    created() {
      this.onPageChange();
     
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