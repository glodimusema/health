<template>
  
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Surveillance Réanimation <v-spacer></v-spacer>
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

                  <v-textarea label="Description" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      v-model="svData.description"></v-textarea>
              
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
                  <span>Ajouter Evolutions</span>
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
                        <th class="text-left">Description</th>                                                                                         
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.description }}</td>
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
          refEnteteRea: this.$route.params.id,
          dateTraiteRea:"",
          pauls:"",
          heureTraite:"",
          PAS:"",
          diagosticRea:"",
          PAD:"",
          temperatureTrait:"",
          ta:"",
          pam:"",
          spo2:"",
          scareGlosgow:"",
          mode_vendilatoire:"",
          volmin:"",
          fi02:"",
          frequence:"",
          peep:"",
          Fr_traitRea:"",
          tempsInstall:"",
          tempsPause:"",
          oxygeneTraitRea:"",
          contrepressionMax:"",
          oxygene:"",
          pressionCrate:"",
          auther:"", 
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
      this.dialog = true;     
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
    computed: {
      ...mapGetters(["categoryList", "isloading"]),
    },
    methods: {
  
      ...mapActions(["getCategory"]),
  
      validate() {
        if (this.$refs.form.validate()) {
          this.isLoading(true);
          if (this.edit) {
            this.svData.refEnteteRea= this.$route.params.id;
            this.svData.auther = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_SurveillanceRea/${this.svData.id}`,
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
            this.svData.refEnteteRea= this.$route.params.id;
            this.svData.auther = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_SurveillanceRea`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_SurveillanceRea/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.dateTraiteRea= item.dateTraiteRea;
              this.svData.pauls= item.pauls;
              this.svData.heureTraite= item.heureTraite;
              this.svData.PAS= item.PAS;
              this.svData.diagosticRea= item.diagosticRea;
              this.svData.PAD= item.PAD;
              this.svData.temperatureTrait= item.temperatureTrait;
              this.svData.ta= item.ta;
              this.svData.pam= item.pam;
              this.svData.spo2= item.spo2;
              this.svData.scareGlosgow= item.scareGlosgow;
              this.svData.mode_vendilatoire= item.mode_vendilatoire;
              this.svData.volmin= item.volmin;
              this.svData.fi02= item.fi02;
              this.svData.frequence= item.frequence;
              this.svData.peep= item.peep;
              this.svData.Fr_traitRea= item.Fr_traitRea;
              this.svData.tempsInstall= item.tempsInstall;
              this.svData.tempsPause= item.tempsPause;
              this.svData.oxygeneTraitRea= item.oxygeneTraitRea;
              this.svData.contrepressionMax= item.contrepressionMax;
              this.svData.oxygene= item.oxygene;
              this.svData.pressionCrate= item.pressionCrate;
              this.svData.auther= item.auther;                                 
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_SurveillanceRea/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        var id = this.$route.params.id;
        this.refEnteteRea = id;
        this.fetch_data(`${this.apiBaseURL}/fetch_surveillance_for_enteterea/${this.refEnteteRea}?page=`);
        //
      },
   
      getRouteParam()
      {
        var id = this.$route.params.id;
        this.refEnteteRea = id;
      } 
  
  
    },
    filters: {
  
    }
  }
  </script>
  
  