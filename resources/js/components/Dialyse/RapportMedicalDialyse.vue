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
              <v-dialog v-model="dialog" max-width="1200px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Rapport Medical Dialyse <v-spacer></v-spacer>
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


                        <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="mdi-map"
                            :items="stataData.medecinList" item-text="noms_medecin"
                            item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                            @change="getSpecialiteMedecin(svData.refMedecin)">
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field readonly label="Medecin" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dr">
                          </v-text-field>
                        </div>
                      </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cNom">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <!--                                
                          //     "refEnteteDyalise","rensMedicant","nephropatie","dateSeance",
                          //     "voieAcces","technineFonction","typeDialyse","Generateur","Dialyseur","joursDyalise","dureeDyalise",
                          //     "tempsDyalise","anticoagulation","poidsSec","debitPrompe","TAhabituelle","valeurDialysat",
                          //     "nA","k","ca","chloride","hco3","mg","acitate","evolution","conclusion","recommandation",
                          //     "nb","author"
                         -->

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Renseignements médicaux" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.rensMedicant"></v-textarea>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Renseignements en rapport avec l'hémodialyse à HOPITAL/GOMA
                            </v-input>
                          </div>
                        </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Néphropathie" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.nephropatie"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field type="date" label="Date de la première séance" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dateSeance"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Voie d'accès" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.voieAcces"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Technique de ponction" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.technineFonction"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Type de Dialyse" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.typeDialyse"></v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Générateur" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.Generateur"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Dialyseur habituel" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.Dialyseur"></v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Jours de la dialyse" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.joursDyalise"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Durée de la dialyse" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.dureeDyalise"></v-text-field>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Temps de dialyse hebdomadaire" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.tempsDyalise"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Poids sec théorique" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.poidsSec"></v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field label="Anticoagulation" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.anticoagulation"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Prise de poids inter dialytique" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.prisePoids"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="UF Max tolérée" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.UFMaxtolere"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Débit pompe à sang" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.debitPrompe"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="TA habituelle debout" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.TAhabituelle"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Valeurs dialyse" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.valeurDialysat"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Na+" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.nA"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="K+" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.k"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Ca++" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.ca"></v-text-field>
                        </div>
                      </v-flex>



                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Chloride" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.chloride"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="HCO3" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.hco3"></v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Mg++" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.mg"></v-text-field>
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-text-field label="Acetate" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.acitate"></v-text-field>
                        </div>
                      </v-flex>


                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Evolution" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.evolution"></v-textarea>
                        </div>
                      </v-flex>
                      
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Conclution" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.conclusion"></v-textarea>
                        </div>
                      </v-flex>
                      
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Recommandations" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.recommandation"></v-textarea>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Traitements" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.traitement_dialyse"></v-textarea>
                        </div>
                      </v-flex>
                      
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="NB :" prepend-inner-icon="extension"
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            v-model="svData.nb"></v-textarea>
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
                        <span>Ajouter Rapports</span>
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
                              <th class="text-left">Date</th>
                              <th class="text-left">Medecin</th>
                              <th class="text-left">Spécialité</th>
                              <th class="text-left">CNOM</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.created_at }}</td>
                              <td>{{ item.dr }}</td>
                              <td>{{ item.specialite }}</td>
                              <td>{{ item.cNom }}</td>                              
                              <td>


                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link @click="printBill(item.refEnteteDyalise)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">print</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Imprimer Rapport Medical</v-list-item-title>
                                  </v-list-item>

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
        rensMedicant:"",
        nephropatie: "",
        dateSeance: "",
        voieAcces: "",
        technineFonction:"",
        typeDialyse:"",
        Generateur:"",
        Dialyseur:"",
        joursDyalise:"",
        dureeDyalise:"",
        tempsDyalise:"",
        anticoagulation:"",
        poidsSec:"",
        prisePoids :"",
        UFMaxtolere: "",
        debitPrompe:"",
        TAhabituelle:"",
        valeurDialysat:"",
        nA:"",
        k:"",
        ca:"",
        chloride:"",
        hco3:"",
        mg:"",
        acitate:"",
        evolution:"",
        conclusion:"",
        recommandation:"",
        traitement_dialyse:"",
        nb:"",
        dr:"",
        specialite:"",
        cNom:"",
        author: "",

        refMedecin:0
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        medecinList: []
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
          this.svData.refEnteteDyalise = this.refEnteteDyalise;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_rapport_med_dialyse/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_rapport_med_dialyse`,
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
      window.open(`${this.apiBaseURL}/pdf_rapportmedical_dialyse_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_rapport_med_dialyse/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteDyalise = item.refEnteteDyalise;
            this.svData.rensMedicant = item.rensMedicant;
            this.svData.nephropatie = item.nephropatie;
            this.svData.dateSeance = item.dateSeance;
            this.svData.voieAcces = item.voieAcces;
            this.svData.technineFonction = item.technineFonction;
            this.svData.typeDialyse = item.typeDialyse;
            this.svData.Generateur = item.Generateur;
            this.svData.Dialyseur = item.Dialyseur;
            this.svData.joursDyalise = item.joursDyalise;
            this.svData.dureeDyalise = item.dureeDyalise;

            this.svData.tempsDyalise = item.tempsDyalise;
            this.svData.anticoagulation = item.anticoagulation;
            this.svData.poidsSec = item.poidsSec;
            this.svData.prisePoids  = item.prisePoids;
            this.svData.UFMaxtolere = item.UFMaxtolere;
            this.svData.debitPrompe = item.debitPrompe;
            this.svData.TAhabituelle = item.TAhabituelle;
            this.svData.valeurDialysat = item.valeurDialysat;
            this.svData.nA = item.nA;
            this.svData.k = item.k;
            this.svData.ca = item.ca;
            this.svData.chloride = item.chloride;
            this.svData.hco3 = item.hco3;
            this.svData.mg = item.mg;
            this.svData.acitate = item.acitate;
            this.svData.evolution = item.evolution;
            this.svData.conclusion = item.conclusion;
            this.svData.recommandation = item.recommandation;
            this.svData.traitement_dialyse = item.traitement_dialyse;
            this.svData.nb = item.nb;
            this.svData.dr = item.dr;
            this.svData.specialite = item.specialite;
            this.svData.cNom = item.cNom;

          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_rapport/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_rapport_medicale_dyalyse/${this.refEnteteDyalise}?page=`);
    },
    //
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },
    getSpecialiteMedecin(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.dr = item.noms_medecin;
            this.svData.specialite = item.specialite_medecin;
            this.svData.cNom = item.matricule_medecin;
          });

        }
      );
    }


  },
  filters: {

  }
}
</script>
  
  