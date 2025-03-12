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
              <v-dialog v-model="dialog" max-width="900px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Surveillance Signes Vitaux <v-spacer></v-spacer>
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
                            <v-select label="Heure" :items="[
                              { designation: '01H' },
                              { designation: '02H' },
                              { designation: '03H' },
                              { designation: '04H' },
                              { designation: '05H' },
                              { designation: '06H' },
                              { designation: '07H' },
                              { designation: '08H' },
                              { designation: '09H' },
                              { designation: '10H' },
                              { designation: '11H' },
                              { designation: '12H' },
                              { designation: '13H' },
                              { designation: '14H' },
                              { designation: '15H' },
                              { designation: '16H' },
                              { designation: '17H' },
                              { designation: '18H' },
                              { designation: '19H' },
                              { designation: '20H' },
                              { designation: '21H' },
                              { designation: '22H' },
                              { designation: '23H' },
                              { designation: '24H' }
                              
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.heure"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Température" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.temperatureSurv"></v-text-field>
                          </div>
                        </v-flex>                 

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Duirése" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.duirese"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Tension arterielle" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.TA"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Quantité Duirése" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qteDuirese"></v-text-field>
                          </div>
                        </v-flex>



                        <!--  -->

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Respiration (cycle/)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.respiration"></v-text-field>
                          </div>
                        </v-flex>                 

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Perfusion" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.perfusion"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Quantité Perfusion" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qtePerfusion"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pulsation (batt/)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.pulsation"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Quantité Pulsation (batt/)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qtepulsation"></v-text-field>
                          </div>
                        </v-flex>

                      


                        <!--  -->


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Etat de Conscience" :items="[
                              { designation: 'L' },
                              { designation: 'OB' },
                              { designation: 'S' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.etatconscience"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Abord Veineux" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.AborVeineux"></v-select>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mouvement" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.mouvement"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Glycemie" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.Glycemie"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Vomissement" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.vomissement"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Qté Vomissement" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qteVomissement"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Hémoragie" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.hemoragie"></v-select>
                          </div>
                        </v-flex>

          <!-- 
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Qté Pulsation" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qtepulsation"></v-text-field>
                          </div>
                        </v-flex> -->

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Oxygène (%)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.oxygene"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Diarhée" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.diarhee"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Pansement" :items="[
                              { designation: '+' },
                              { designation: '-' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.pensement"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Qté Diarhée" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.qteDiarhee"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Details Pansement" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.detailPensement"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Drain Gauche" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.drainGauche"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Drain Droite" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.drainDroite"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Observation Matin" prepend-inner-icon="extension"
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','heure2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Date</th>
                              <th class="text-left">Temperature</th>
                              <th class="text-left">TA</th>
                              <th class="text-left">Pulsation</th>
                              <th class="text-left">EtatConscience</th>                        
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.created_at }}</td> 
                              <td>{{ item.temperatureSurv }}</td>
                              <td>{{ item.TA }}</td>
                              <td>{{ item.pulsation }}</td>
                              <td>{{ item.etatconscience }}</td>
                                                    
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
      refSurvHospi: 0, 
     
      svData: {
        id: '',
        refSurvHospi: 0,
        heure: "",
        temperatureSurv: "",
        TA: "",
        respiration:"",
        pulsation:"",
        qtepulsation:"",
        etatconscience:"",
        mouvement:"",
        vomissement:"",
        qteVomissement:"",
        diarhee:"",
        qteDiarhee:"",
        drainGauche:"",
        drainDroite:"",
        duirese:"",
        qteDuirese:"",
        perfusion:"",
        qtePerfusion:"",
        AborVeineux:"",
        Glycemie:"",
        hemoragie:"",
        oxygene:"",
        pensement:"",
        detailPensement:"",
        observation:"",
        author: "",
      },
      fetchData: [],
      don: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

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
          this.svData.refSurvHospi = this.refSurvHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_signe_vitaux_surveil/${this.svData.id}`,
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
          this.svData.refSurvHospi = this.refSurvHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_signe_vitaux_surveil`,
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

      this.editOrFetch(`${this.apiBaseURL}/fetch_single_signe_vitaux_surveil/${id}`).then(
        ({ data }) => {
          var donnees = data.data;

          // donnees.map((item) => {
          // this.titleComponent = "modification des données";
          // });

          this.getSvData(this.svData, data.data[0]);
          this.edit = true;
          this.dialog = true;
        }
      );
//
      },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_signe_vitaux_surveil/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_signe_vitaux_surveil/${this.refSurvHospi}?page=`);
      //
    }
  },
  filters: {

  }
}
</script>
  
  