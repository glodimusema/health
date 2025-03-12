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
              <v-dialog v-model="dialog" max-width="700px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Deroulement Dialyse <v-spacer></v-spacer>
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

                      <v-layout row wrap>

                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Heure" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.heure"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="TA" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.ta"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="BP" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.bP"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="MAP" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.mAp"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="HR" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.hR"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="PA" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.pA"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="PV" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.pV"></v-text-field>
                        </div>
                      </v-flex>
                      <!-- qB,qD,uF,observation,author -->

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="TMP" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.tMP"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="QB" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.qB"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="QD" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.qD"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="UF" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.uF"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Observation" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.observation"></v-textarea>
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
                        <span>Ajouter Diagnostics</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- //refEnteteDyalise,heure,ta,bP,mAp,hR,pA,pV,tMP,qB,qD,uF,observation,author -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Heure</th>
                              <th class="text-left">TA</th>
                              <th class="text-left">BP</th>
                              <th class="text-left">MAP</th>
                              <th class="text-left">Observation</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.heure }}</td>
                              <td>{{ item.ta }}</td>
                              <td>{{ item.bP }}</td>
                              <td>{{ item.mAp }}</td>
                              <td>{{ item.observation }}</td>
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
      refEnteteDyalise: 0,     

      svData: {
        id: '',
        refEnteteDyalise: 0,
        heure: "",
        ta: "",
        bP: "",
        mAp:"",
        hR:"",
        pA:"",
        pV:"",
        tMP:"",
        qB:"",
        qD:"",
        uF:"",
        observation: "",
        author: ""
      },
      fetchData: [],
      don: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    // this.fetchDataList();
     
    
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_deroulement/${this.svData.id}`,
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.author = this.userData.name;          
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_deroulement`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_deroulement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteDyalise = item.refEnteteDyalise;
            this.svData.ta = item.ta;
            this.svData.bP = item.bP;
            this.svData.mAp= item.mAp
            this.svData.hR= item.hR
            this.svData.pA= item.pA
            this.svData.pV= item.pV
            this.svData.tMP= item.tMP
            this.svData.qB= item.qB
            this.svData.qD= item.qD
            this.svData.uF= item.uF
            this.svData.observation = item.observation;           

          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_deroulement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_deroulement_dialyse/${this.refEnteteDyalise}?page=`);

    }


  },
  filters: {

  }
}
</script>
  
  