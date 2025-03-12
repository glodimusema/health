<template>

<div>

  <v-layout>
    <!--   -->
    <v-flex md12>
      <v-dialog v-model="dialog" max-width="400px" persistent>
        <v-card :loading="loading">
          <v-form ref="form" lazy-validation>
            <v-card-title>
              Suivi Hospitalisation <v-spacer></v-spacer>
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
              
              <v-text-field type="date" label="Date Suivi" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                    v-model="svData.dateDetail"></v-text-field>             


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="Observation de l'Infirmier" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                        v-model="svData.observationsInfirmier">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Moment" :items="[
                          { designation: 'MATIN' }, 
                          { designation: 'MIDI' },
                          { designation: 'SOIR' }                                     
                          ]" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation" item-value="designation"
                        v-model="svData.moment"></v-select>
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
                      <th class="text-left">Malade</th>
                      <th class="text-left">Sexe</th>    
                      <th class="text-left">Age</th>  
                      <th class="text-left">DateSuivi</th> 
                      <th class="text-left">Salle</th>                                                                    
                      <th class="text-left">Lit</th>
                      <th class="text-left">DateEntrée</th>                      
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.noms }}</td>
                      <td>{{ item.sexe_malade }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.created_at | formatDate }}</td>
                      <td>{{ item.nom_salle }}</td>
                      <td>{{ item.nom_lit }}</td>
                      <td>{{ item.dateEntree | formatDate }}</td>
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

                        <!-- <v-list-item link router :to="'/admin/entete_labo/'+item.id">
                          <v-list-item-icon>
                            <v-icon>mdi-anchor</v-icon>
                          </v-list-item-icon>
                          <v-list-item-title style="margin-left: -20px">Complèter les Résultats
                          </v-list-item-title>
                        </v-list-item>-->
                    
                        <!-- <v-list-item link  @click="printBill(item.refHospitaliser)">
                          <v-list-item-icon>
                            <v-icon color="#B72C2C">print</v-icon>
                          </v-list-item-icon>
                          <v-list-item-title style="margin-left: -20px">Ordonances Medicaments</v-list-item-title>
                        </v-list-item>  -->
                    
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
// //'id','refHospitaliser','dateDetail','observationsInfirmierInfirmier','moment','author'
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,       
      svData: {
        id: '',
        refHospitaliser: this.$route.params.id,          
        dateDetail:"",
        moment:"",
        observationsInfirmier:"",
        author:""
      },
      fetchData: [],
      don:[],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''     
  
    }
  },
  created() {
    this.getRouteParam();
    this.fetchDataList();
     
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
          this.svData.refHospitaliser= this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_suivihospitaliser/${this.svData.id}`,
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
          this.svData.refHospitaliser= this.$route.params.id;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_suivihospitaliser`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              //this.dialog = false;
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_suivihospitaliser/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {  
            this.svData.id = item.id;
            this.svData.refHospitaliser = item.refHospitaliser;
            this.svData.dateDetail = item.dateDetail;
            this.svData.moment = item.moment;
            this.svData.observationsInfirmier = item.observationsInfirmier;                          
          });
          //getLit(this.svData.refSalle);
          this.edit = true;
          this.dialog = true;
         }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_suivihospitaliser/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.refHospitaliser = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_suivi_hospitaliser/${this.refHospitaliser}?page=`);
      
    }, 
    getRouteParam()
    {
      var id = this.$route.params.id;
      this.refHospitaliser = id;
    } 


  },
  filters: {

  }
}
</script>

