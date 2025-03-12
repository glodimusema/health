<template>

<v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="900px">
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
                      <!-- <v-flex md1>
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
                      </v-flex> -->
                    </v-layout>
                    <br />
                    <v-card>
                      <!-- ,'ValeurNormale2','observation2' -->
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Sexe</th>    
                                <th class="text-left">Age</th>  
                                <th class="text-left">Medicament</th> 
                                <th class="text-left">Quantité/Jour</th>                                                                    
                                <th class="text-left">NombreJour</th>
                                <th class="text-left">Total</th>
                                <th class="text-left">Details</th> 
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.nom_medicament }}</td>
                                <td>{{ item.quantite }}</td>
                                <td>{{ item.dosage }}</td>
                                <td>{{ item.quantiteTotal }}</td>
                                <td>{{ item.detailprescription }}</td>
                                <td>


                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                <template v-slot:activator="{ on }">
                                  <v-btn icon v-on="on" small fab depressed text>
                                    <v-icon>more_vert</v-icon>
                                  </v-btn>
                                </template>
                              
                                <v-list dense width="">

                                  <!-- <v-list-item link @click="editData(item.id)">
                                    <v-list-item-icon>
                                  <v-icon color="#B72C2C">edit</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                  </v-list-item>

                                  <v-list-item link @click="deleteData(item.id)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">delete</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                  </v-list-item> -->

                                  <!-- <v-list-item link router :to="'/admin/entete_labo/'+item.id">
                                    <v-list-item-icon>
                                      <v-icon>mdi-anchor</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                                    </v-list-item-title>
                                  </v-list-item>-->
                              
                                  <v-list-item link  @click="printBill(item.refdetailCons)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">print</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Ordonances Medicaments</v-list-item-title>
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
  //quantite,dosage,detailprescription,author
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        refMouvement:0,       
        svData: {
          id: '',
          refdetailCons:0,          
          refmedicament:"",
          quantite:0,
          dosage:0,
          detailprescription:"",
          author:"",          
          quantiteDispo:0 
        },
        fetchData: [],
        don:[],
        query: "",
        stataData: {
          MedicamentList: [],
          
        },
    
      }
    },
    created() {      
      this.fetchDataList();
       
    },
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
   
      },  
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
      },  
      getCategorie(refmedicament) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_quantite_disponible/${refmedicament}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              if(item.quantiteDispo ==null)
              {
                this.svData.quantiteDispo = 0; 
              }else
              {
                this.svData.quantiteDispo = item.quantiteDispo; 
              }
             
              // console.log("prix unitaire:"+item.pu);               
            });
            // this.getSvData(this.svData, data.data[0]);           
          }
        );
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_prescription/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refdetailCons = item.refdetailCons;
              this.svData.refmedicament = item.refmedicament;
              this.svData.quantite = item.quantite;
              this.svData.dosage = item.dosage;
              this.svData.detailprescription = item.detailprescription;                          
            });
            getCategorie(this.svData.refmedicament);
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_prescription/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_prescription_mouvement/${this.refMouvement}?page=`);
        
      },
      backPage(){
        this.$router.go(-1);
      } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  