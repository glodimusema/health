<template>
  
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>
        <v-dialog v-model="dialog" max-width="600px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Actes Medicals <v-spacer></v-spacer>
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
              <v-card-text>

                <v-text-field label="Designation Acte " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nom_acte">
                </v-text-field>

                <!-- <v-text-field type="number" label="Prix Unitaire " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_acte">
                </v-text-field> -->

                <!-- <v-text-field type="number" label="Prix Conventionné " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix_convention">
                </v-text-field> -->

                <v-text-field label="Code Acte " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.code_acte">
                </v-text-field>

                <!-- <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Compte" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.CompteList" item-text="nom_compte"
                            item-value="id" dense outlined v-model="svData.refCompte" chips clearable
                            @change="get_souscompte_for_compte(svData.refCompte)">
                            </v-autocomplete>
                        </div>
                    </v-flex>
                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Sous-Compte" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SousCompteList"
                            item-text="nom_souscompte" item-value="id" dense outlined v-model="svData.refSousCompte" clearable
                            chips @change="get_sscompte_for_souscompte(svData.refSousCompte)">
                            </v-autocomplete>
                        </div>
                    </v-flex>

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Sous Sous-Compte" prepend-inner-icon="map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.SSousCompteList"
                            item-text="nom_ssouscompte" item-value="id" dense outlined v-model="svData.refSscompte" clearable
                            chips>
                            </v-autocomplete>
                        </div>
                    </v-flex> -->

                    <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.Unitelist" item-text="nom_uniteproduction"
                            item-value="id" dense outlined v-model="svData.refUnite" chips clearable
                           >
                            </v-autocomplete>
                        </div>
                    </v-flex>



              
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
            <v-card>
              <!-- ,'ValeurNormale2','observation2' -->
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">Designation</th>
                        <!-- <th class="text-left">Prix</th>    
                        <th class="text-left">PrixConvention</th>   -->
                        <th class="text-left">CodeProduit</th>
                        <!-- <th class="text-left">Services</th>                         -->
                        <!-- <th class="text-left">SSCompte</th>
                        <th class="text-left">N°SSCompte</th> -->
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.nom_acte }}</td>
                        <!-- <td>{{ item.prix_acte }}</td> -->
                        <!-- <td>{{ item.prix_convention }}</td> -->
                        <td>{{ item.code_acte }}</td>
                        <!-- <td>{{ item.nom_uniteproduction }}</td>                        -->
                        <!-- <td>{{ item.nom_ssouscompte }}</td>
                        <td>{{ item.numero_ssouscompte }}</td> -->
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
  
</template>
<script>
  import { mapGetters, mapActions } from "vuex";
  export default {
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        svData: {
          id: '',
          refUnite: 0,          
          refCompte: "",
          refSousCompte: "",
          refSscompte:"",
          nom_acte:"",
          prix_acte:0,
          prix_convention:0,
          code_acte:"",          
          author:"Admin"
        },
        fetchData: [],
        don:[],
        query: "",
        stataData: {
          CompteList: [],
          SousCompteList: [],
          SSousCompteList: [],
          Unitelist: []
        },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
    
      }
    },
    created() {
      
      this.fetchDataList();
      this.fetchListCompte();
      this.fetchListUniteProduction();
       
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
            this.svData.author = this.userData.name;
            this.svData.prix_acte=0;
            this.svData.prix_convention=0;
            this.svData.refSscompte=1;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_actemedecin/${this.svData.id}`,
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
            this.svData.author = this.userData.name;
            this.svData.prix_acte=0;
            this.svData.prix_convention=0;
            this.svData.refSscompte=1;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_actemedecin`,
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
  
        }
      },  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
      },
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_actemedecin/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refUnite = item.refUnite;
              this.svData.refSscompte = item.refSscompte;
              this.svData.nom_acte = item.nom_acte;
              this.svData.prix_acte = item.prix_acte;
              this.svData.prix_convention = item.prix_convention;
              this.svData.code_acte = item.code_acte;
              this.svData.author = item.author;                          
            });
  
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_actemedecin/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {       
        this.fetch_data(`${this.apiBaseURL}/fetch_actemedecin?page=`);        
      },      
      fetchListCompte() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_compte2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.CompteList = donnees;

          }
        );
      },     
         
      fetchListUniteProduction() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.Unitelist = donnees;

          }
        );
      },
     //fultrage de donnees
      async get_souscompte_for_compte(refCompte) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_souscompte_compte2/${refCompte}`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.stataData.SousCompteList = chart;
              } else {
                  this.stataData.SousCompteList = [];
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
      async get_sscompte_for_souscompte(refSousCompte) {
          this.isLoading(true);
          await axios
              .get(`${this.apiBaseURL}/fetch_ssouscompte_sous2/${refSousCompte}`)
              .then((res) => {
              var chart = res.data.data;

              if (chart) {
                  this.stataData.SSousCompteList = chart;
              } else {
                  this.stataData.SSousCompteList = [];
              }

              this.isLoading(false);

              //   console.log(this.stataData.car_optionList);
              })
              .catch((err) => {
              this.errMsg();
              this.makeFalse();
              reject(err);
              });
      }
  
    },
    filters: {
  
    }
  }
  </script>
  
  