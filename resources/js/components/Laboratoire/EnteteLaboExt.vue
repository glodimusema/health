<template>

<v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1500px">
      <v-card>
        <!-- container -->

        <v-card-title class="red">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etatModal = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout -->

          <div>

        <v-layout>
          <!--      -->
          <v-flex md12>

            <DetailLaboExt ref="DetailLaboExt" />

            <v-dialog v-model="dialog" max-width="700px" persistent>
              <v-card :loading="loading">
                <v-form ref="form" lazy-validation>
                  <v-card-title>
                    Details Examen <v-spacer></v-spacer>
                    <v-tooltip bottom color="black">
                      <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                          <v-btn @click="closeForm" text fab depressed>
                            <v-icon>close</v-icon>
                          </v-btn>
                        </span>
                      </template>
                      <span>Fermer</span>
                    </v-tooltip>
                  </v-card-title>
                  <v-card-text>

                    <v-layout row wrap>


                     
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Service de Provenance" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                            item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                            v-model="svData.serviceProvenance" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                                      
                    <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                                <v-autocomplete label="Selectionnez Examen" prepend-inner-icon="map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.ExamenList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refExamen" clearable
                                chips @change="getCategorie(svData.refExamen)">
                                </v-autocomplete>
                            </div>
                        </v-flex>


                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Catégorie Examen" prepend-inner-icon="extension"
                        dense  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationCat"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field readonly label="Grande Catégorie Examen" prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.designationGCat"></v-text-field>
                      </div>
                    </v-flex> 
                    
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Nom du Medecin Demandeur" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined v-model="svData.nommedecin">
                        </v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg6>
                      <div class="mr-1">
                        <v-text-field label="Nom du Centre Medical " prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nomcentremedical"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                      <div class="mr-1">
                        <v-text-field label="Adresse du Centre Medical" prepend-inner-icon="extension"
                        dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.adressecentre"></v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Adresse mail" prepend-inner-icon="draw" dense :rules="[
                                                              (v) => !!v || 'Ce champ est requis',
                                                              (v) =>
                                                                /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                                                            ]" outlined v-model="svData.mailmedecin"></v-text-field>
                      </div>
                    </v-flex>
                    
                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined v-model="svData.telephonemedecin">
                        </v-text-field>
                      </div>
                    </v-flex>


                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field label="Nom du Préléveur" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                          outlined v-model="svData.nompreleveur">
                        </v-text-field>
                      </div>
                    </v-flex>

                    <v-flex xs12 sm12 md6 lg6>
                      <div class="mr-1">
                        <v-text-field type="date" label="Date Prélévement " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateprelevement">
                    </v-text-field>
                      </div>
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
                  
              <v-flex md12>
                <v-layout>
                  <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo
                      outlined rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                  </v-flex>
                  <v-flex md5>
                  <div>
                    <!-- {{ this.don }} -->
                  </div>
                </v-flex>
                  <v-flex md1>
                    <v-tooltip bottom color="black">
                      <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                          <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                            <v-icon>add</v-icon>
                          </v-btn>
                        </span>
                      </template>
                      <span>Affecter les Examens</span>
                    </v-tooltip>
                  </v-flex>
                </v-layout>
                <br />
                <v-card :loading="loading" :disabled="loading">
                  <!-- ,'ValeurNormale2','observation2' -->
                  <v-card-text>
                    <v-simple-table>
                      <template v-slot:default>
                        <thead>
                          <tr>
                            <th class="text-left">Malade</th>
                            <th class="text-left">Sexe</th>    
                            <th class="text-left">Age</th> 
                            <th class="text-left">Service(Orig.)</th> 
                            <th class="text-left">Examen</th>
                            <th class="text-left">Categorie</th>
                            <th class="text-left">GrandCat.</th>
                            <th class="text-left">Resultat</th>  
                            <th class="text-left">Etat</th>                       
                            <th class="text-left">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr v-for="item in fetchData" :key="item.id">
                            <td>{{ item.noms }}</td>
                            <td>{{ item.sexe_malade }}</td>
                            <td>{{ item.age_malade }}</td>
                            <td>{{ item.serviceProvenance }}</td>
                            <td>{{ item.designationEx }}</td>
                            <td>{{ item.designationCatEx }}</td>
                            <td>{{ item.designationGCatEx }}</td>
                            <td>{{ item.ValeurNormale2 }}</td>
                            <td>{{ item.statutentetelaboext }}</td>
                            <td>


                              <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>
                          
                            <v-list dense width="">

                              <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                <v-list-item-icon>
                              <v-icon color="#B72C2C">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                              </v-list-item>

                              <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                              </v-list-item>

                              <v-list-item link  @click="printBill(item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
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
                      @input="fetchDataList"></v-pagination>
                  </v-card-text>
                </v-card>
              </v-flex>
                  
            </v-layout>
          </v-flex>
              
        </v-layout>

        </div>
                

          <!-- fin -->
        </v-card-text>

        <!-- container -->
      </v-card>
    </v-dialog>
  </v-row>

  

  
</template>
<script>
  import { mapGetters, mapActions } from "vuex";
import DetailLaboExt from './DetailLaboExt.vue';

  export default {
    components: {
      DetailLaboExt
  },
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        refMouvement: 0,
        svData: {
          id: '',
          refMouvement: 0,
          refGrandCategorie: "",
          refCatexamen: "",
          refExamen:"",          
          author:"Admin",
          dateLabo: "",
          
          nommedecin: "",
          nomcentremedical: "",
          adressecentre: "",
          telephonemedecin: "",
          mailmedecin: "",
          nompreleveur: "",
          dateprelevement: "",
//
          designationCat:"",
          designationGCat:"",
          serviceProvenance:"", 
        },
        fetchData: [],
        don:[],
        query: "",
        stataData: {
          GrandCategorieList: [],
          CategorieList: [],
          ExamenList: [],
          ServiceList: []
        },
      
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''
    
      }
    },
    created() {
       
      // this.fetchDataList();
      // this.get_examen_all();
      // this.fetchListServices()
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.refMouvement=this.refMouvement;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_entetelaboratoireext/${this.svData.id}`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                this.dialog = false;
                this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
  
          }
          else {
            this.svData.refMouvement=this.refMouvement;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_entetelaboratoireext`,
              JSON.stringify(this.svData)
            )
              .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;
                //this.dialog = false;
                //this.resetObj(this.svData);
                this.fetchDataList();
              })
              .catch((err) => {
                this.svErr(), this.isLoading(false);
              });
          }
  
        }
      },
      fetchAccess() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_crud_access_roles_one/${this.userData.id_role}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
          this.inserer = item.insert;
          this.modifier = item.update;
          this.supprimer = item.delete;
          this.chargement = item.load;
        });

          console.log(donnees);
        }
      );
    },
      closeForm()
      {
        this.dialog = false;
        this.resetObj(this.svData);
      }
      ,  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
      },  
      getCategorie(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_examen/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.designationCat = item.designationCat; 
              this.svData.designationGCat = item.designationGCat; 
                           
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetelaboratoireext/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refMouvement = item.refMouvement;
              this.svData.refExamen = item.refExamen; 
              this.svData.nommedecin = item.nommedecin;
              this.svData.nomcentremedical = item.nomcentremedical;
              this.svData.adressecentre = item.adressecentre; 
              this.svData.telephonemedecin = item.telephonemedecin; 
              this.svData.mailmedecin = item.mailmedecin;              
              this.svData.nompreleveur = item.nompreleveur; 
              this.svData.dateprelevement = item.dateprelevement;
              this.svData.serviceProvenance = item.serviceProvenance;                          
            });

            // serviceProvenance
  
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_entetelaboratoireext/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_entete_labo_attenteext/${this.refMouvement}?page=`);
        
      },      
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_GrandCategorie`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.GrandCategorieList = donnees;

          }
        );
      },
     //fultrage de donnees
      async get_categorie_for_GrandCat(id_Grandcat) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_CatexamenForGrandCat/${id_Grandcat}`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.stataData.CategorieList = chart;
              } else {
                  this.stataData.CategorieList = [];
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
      //fultrage de donnees
      async get_examen_for_Categorie(id_categorie) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_list_ExamenForCat/${id_categorie}`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.stataData.ExamenList = chart;
              } else {
                  this.stataData.ExamenList = [];
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
      //fultrage de donnees
      async get_examen_all() {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_texamen_2`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.stataData.ExamenList = chart;
              } else {
                  this.stataData.ExamenList = [];
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
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    } ,

// PARTIE DES COMPOSANTS===================================================================   


    showDetailLaboratire(refEnteteLabo, name) {

      if (refEnteteLabo != '') {

        this.$refs.DetailLaboExt.$data.etatModal = true;
        this.$refs.DetailLaboExt.$data.refEnteteLabo = refEnteteLabo;
        this.$refs.DetailLaboExt.$data.svData.refEnteteLabo= refEnteteLabo;
        this.$refs.DetailLaboExt.fetchDataList();
        this.$refs.DetailLaboExt.get_methode_Examen();
        this.$refs.DetailLaboExt.get_nature_Echantillon();
        this.fetchDataList();
        
        this.$refs.DetailLaboExt.$data.titleComponent =
          "Compeleter les Resultats de Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  