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
                      Surveillance Reanimation <v-spacer></v-spacer>
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
                            <v-text-field type="date" label="Date" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateTraiteRea">
                            </v-text-field>
                          </div>
                        </v-flex>

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
                              item-value="designation" v-model="svData.heureTraite"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="POULS" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pauls">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="PAS" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" 
                              outlined v-model="svData.PAS">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Diagnostic" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagosticRea">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="PAD" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PAD">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T°" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.temperatureTrait">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TA" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ta">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="PAM" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pam">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="SPO2(%)" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.spo2">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <!--  -->
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Score de glasgow" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.scareGlosgow">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Fonction Respiratoire
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mode Ventilatoire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.mode_vendilatoire">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fi02" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.fi02">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="vol.min(L.min)" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.volmin">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Féquence" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.frequence">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Peep" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.peep">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Fr_traitRea">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Temps pause" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tempsPause">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Temps insull" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tempsInstall">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Oxygène" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.oxygeneTraitRea">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Contre pression max" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.contrepressionMax">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Oxygène" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.oxygene">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pression de crete" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pressionCrate">
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','assistantMedical2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Date</th>
                              <th class="text-left">Heure</th>
                              <th class="text-left">Diagnostic</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateTraiteRea }}</td>
                              <td>{{ item.heureTraite }}</td>
                              <td>{{ item.diagosticRea }}</td>
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
      //
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,

      etatModal: false,
      titleComponent: '',
      refEnteteRea: 0,

      svData: {
        id: '',
        refEnteteRea: 0,
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
        auther:""
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
          this.svData.refEnteteRea = this.refEnteteRea;
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
          this.svData.refEnteteRea = this.refEnteteRea;
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_SurveillanceRea/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteRea = item.refEnteteRea;
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
       this.fetch_data(`${this.apiBaseURL}/fetch_surveillance_for_enteterea/${this.refEnteteRea}?page=`);
      //
    }

  },
  filters: {

  }
}
</script>
  
  