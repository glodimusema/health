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
            <!--   -->
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Rendez-Vous <v-spacer></v-spacer>
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

                      <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez la Période" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.PeriodeList" item-text="name_periode"
                                  item-value="id" dense outlined v-model="svData.refPeriode" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="date" label="Date Rendez-vous" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.dateRdv"></v-text-field>
                              </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                              <div class="mr-1">
                                <v-text-field type="number" label="Poids" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.dateRdv"></v-text-field>
                              </div>
                          </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-select label="Etat RDV" :items="[
                              { designation: '0' },
                              { designation: '1' }                 
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.etatRdv"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-select label="Compteur" :items="[
                              { designation: '1' },
                              { designation: '2' },
                              { designation: '3' },
                              { designation: '4' },
                              { designation: '5' }                 
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.compteurRandezvous"></v-select>
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
                        <span>Ajouter Diagnostics</span>
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
                              <th class="text-left">Patient</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">Periode</th> 
                              <th class="text-left">Poids</th>
                              <th class="text-left">DateRecu</th>                                                                    
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.name_periode_cps }}</td>
                              <td>{{ item.compteurRandezvous }}</td>
                              <td>{{ item.dateRdv }}</td>
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
        

          <!-- fin -->
        </v-card-text>

        <!-- container -->
      </v-card>
    </v-dialog>
  </v-row>

  
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
        etatModal: false,
        titleComponent: '',
        refEntete: 0, 

         // //id,refEntete,refPeriode,dateRdv,etatRdv,compteurRandezvous,author

        svData: {
          id: '',
          refEntete: 0,          
          refPeriode:"",
          dateRdv:"",
          etatRdv:0,
          compteurRandezvous:0,
          author:""
        },
        fetchData: [],
        don:[],
        query: "",
        stataData: {
          PeriodeList: [],        
        },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
    
      }
    },
    created() {
      // this.fetchDataList();
      // this.fetchListSelection();
         
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
            this.svData.refEntete= this.refEntete;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_rendezvous/${this.svData.id}`,
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
            this.svData.refEntete= this.refEntete;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_rendezvous`,
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
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_rendezvous/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refEntete = item.refEntete;
              this.svData.refPeriode = item.refPeriode;
              this.svData.etatRdv = item.etatRdv;  
              this.svData.compteurRandezvous = item.compteurRandezvous;
              this.svData.author = item.author;                        
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_rendezvous/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_rendezvous_vaccination/${this.refEntete}?page=`);
        
      },      
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_periode_vac_enfant2`).then(
          ({ data }) => {
            var donnees = data.data;
            this.stataData.PeriodeList = donnees;
          }
        );
      }
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  