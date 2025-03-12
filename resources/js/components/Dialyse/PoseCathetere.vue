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
                      Pose Cathétere <v-spacer></v-spacer>
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
                            <v-select label="Shift" :items="[
                              { designation: 'MATIN' },
                              { designation: 'MIDI' },
                              { designation: 'SOIR' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.shifts"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Machine" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.MachineList"
                              item-text="nomTypeMachine" item-value="id" dense outlined v-model="svData.refTypeMachine" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Indication" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.indication"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input color="#1E1E1E" :success-messages="['']" success disabled>
                              Description du Cathetere
                            </v-input>
                          </div>
                        </v-flex>


                        <!-- Description du Cathetere -->

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="KT" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense v-model="svData.KT"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Dimension" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.Dimension"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="CM Marque" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.CM_marque"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Pose du KT
                            </v-input>
                          </div>
                        </v-flex>
                        <!--  -->

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date de Pose" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.dateDose"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Site actuel" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.siteactuel"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Lieu" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.lieu"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.autres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Equipe Technique
                            </v-input>
                          </div>
                        </v-flex>

                        <!-- Equipe Technique -->


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Operateur" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.MedecinList"
                              item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.operateur_Dr"
                              clearable chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Assistant" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.MedecinList"
                              item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.assistant"
                              clearable chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Infirmier" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.MedecinList"
                              item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.infirmier"
                              clearable chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Description de l'Operateur
                            </v-input>
                          </div>
                        </v-flex>


                        <!-- Description de l'Operateur -->

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Description" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.descriptionOperation"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Paramètres Clinique
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Avant la pose
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Après la pose
                            </v-input>
                          </div>
                        </v-flex>

                        <!-- Avant la pose                                Après la pose -->
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="PA (mm Hg)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.PA_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="PA (mm Hg)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.PA_apres"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (bat/min)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.pauls_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (bat/min)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.pauls_apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (C/min)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.FR_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (C/min)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.FR_Apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SaO2(%)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.saO2_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SaO2(%)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.saO2_apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (C°)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.to_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (C°)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.to_apres"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Plaquettes(elts/mm3)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.Plaquette_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Plaquettes(elts/mm3)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.Plaquette_apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Observation
                            </v-input>
                          </div>
                        </v-flex>


                        <!-- Observation -->

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Observation" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.observation"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Instruction" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.instruction"></v-textarea>
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
                    <!-- ,,'dateDose','KT','CM_marque','observation','infirmier' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">DatePose</th>
                              <th class="text-left">SiteActuel</th>
                              <th class="text-left">Lieu</th>
                              <th class="text-left">Operateur</th>
                              <th class="text-left">Assistant</th>
                              <th class="text-left">Infirmier</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.dateDose }}</td>
                              <td>{{ item.siteactuel }}</td>
                              <td>{{ item.lieu }}</td>
                              <td>{{ item.operateur_Dr }}</td>
                              <td>{{ item.assistant }}</td>
                              <td>{{ item.infirmier }}</td>
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

                                    <!-- <v-list-item link  @click="printBill(item.refEnteteDyalise)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
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
        refTypeMachine: 0,
        indication: "",
        dateDose: "",
        shifts: "",
        KT: "",
        CM_marque: "",
        Dimension: "",
        siteactuel: "",
        lieu: "",
        autres: "",
        operateur_Dr: "",
        assistant: "",
        infirmier: "",
        descriptionOperation: "",
        PA_avant: "",
        PA_apres: "",
        pauls_avant: "",
        pauls_apres: "",
        FR_avant: "",
        FR_Apres: "",
        saO2_avant: "",
        saO2_apres: "",
        to_avant: "",
        to_apres: "",
        Plaquette_avant: "",
        Plaquette_apres: "",
        observation: "",
        instruction: ""

      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        MachineList: [],
        MedecinList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    // this.fetchDataList();
    // this.fecchListMachine();
    // this.fetchListmedecin();
     
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
          this.svData.infirmier = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_doseCathetere/${this.svData.id}`,
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
          this.svData.infirmier = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_doseCathetere`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_doseCathetere/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteDyalise = item.refEnteteDyalise;
            this.svData.refTypeMachine = item.refTypeMachine;
            this.svData.indication = item.indication;
            this.svData.dateDose = item.dateDose;
            this.svData.shifts = item.shifts;
            this.svData.KT = item.KT;
            this.svData.CM_marque = item.CM_marque;
            this.svData.Dimension = item.Dimension;
            this.svData.lieu = item.lieu;
            this.svData.autres = item.autres;
            this.svData.operateur_Dr = item.operateur_Dr;
            this.svData.assistant = item.assistant;
            this.svData.infirmier = item.infirmier;
            this.svData.descriptionOperation = item.descriptionOperation;
            this.svData.PA_avant = item.PA_avant;
            this.svData.PA_apres = item.PA_apres;
            this.svData.pauls_avant = item.pauls_avant;
            this.svData.pauls_apres = item.pauls_apres;
            this.svData.FR_avant = item.FR_avant;
            this.svData.FR_Apres = item.FR_Apres;
            this.svData.saO2_avant = item.saO2_avant;
            this.svData.saO2_apres = item.saO2_apres;
            this.svData.to_avant = item.to_avant;
            this.svData.to_apres = item.to_apres;
            this.svData.Plaquette_avant = item.Plaquette_avant;
            this.svData.Plaquette_apres = item.Plaquette_apres;
            this.svData.observation = item.observation;
            this.svData.instruction = item.instruction;

          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_doseCathetere/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MedecinList = donnees;

        }
      );
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_posecathetere_dialyse/${this.refEnteteDyalise}?page=`);

    },
    fecchListMachine() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_type_machine2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MachineList = donnees;

        }
      );
    }


  },
  filters: {

  }
}
</script>
  
  