<template>

    <div>
    
      <v-row justify="center">
        <v-dialog v-model="etatModal" persistent max-width="1500px">
          <v-card>
            <!-- container  -->
    
            <v-card-title class="red">
              {{ titleComponent }} <v-spacer></v-spacer>
              <v-btn depressed text small fab @click="etatModal = false">
                <v-icon>close</v-icon>
              </v-btn>
            </v-card-title>
            <v-card-text>
              <!-- layout -->      
    
              <v-layout>
    
              <v-flex md12>
                <v-dialog v-model="dialog" max-width="900px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Triage <v-spacer></v-spacer>
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
                              <v-text-field type="number" label="Poids " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Poids">
                            </v-text-field>
                            </div>                    
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Taille " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Taille">
                            </v-text-field>
                            </div>                   
                          </v-flex>
    
    
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="text" label="Tension Artérielle(TA) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TA">
                            </v-text-field>
                            </div>
                          
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Température " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Temperature">
                            </v-text-field>
                            </div>                   
                          </v-flex>
    
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Frequence Cardiaque(FC) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FC">
                            </v-text-field>
                            </div>
                          
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Frequence Réspiratoire(FR) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FR">
                            </v-text-field>
                            </div>                   
                          </v-flex>
    
    
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Saturation en Oxygène " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oxygene">
                            </v-text-field>
                            </div>                    
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Type Episode Maladie" :items="[
                                { designation: 'Nouveau cas' },
                                { designation: 'Ancien cas' }
                              ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                item-text="designation" item-value="designation" v-model="svData.cas_triage"></v-select>
                            </div>
                          </v-flex>
    
    
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Plaintes"
                                prepend-inner-icon="draw" dense outlined
                                v-model="svData.plainte_triage">
                              </v-textarea>
                            </div>
                          </v-flex>
    
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Antécédent (Medicaux, Chirurgiecaux, etc.)"
                                prepend-inner-icon="draw" dense outlined
                                v-model="svData.antecedent_trige">
                              </v-textarea>
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
                <!-- <br /><br /> -->
    
                <v-dialog v-model="dialog2" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Création Consultation <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog2 = false" text fab depressed>
                                <v-icon>close</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Fermer</span>
                        </v-tooltip>
                      </v-card-title>
                      <v-card-text>
    
                        <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
                          item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                          @change="getSpecialiteMedecin(svData.refMedecin)">
                        </v-autocomplete>
    
                        <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_medecin">
                        </v-text-field>
    
                        <v-text-field readonly label="Fonction Medecin " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.fonction_medecin">
                        </v-text-field>
    
                        <v-autocomplete label="Type Orientation" :items="[
                          { designation: 'CONSULTATIONS' },
                          { designation: 'DENTISTERIE' }
                        ]" prepend-inner-icon="extension"
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                          item-value="designation" v-model="svData.TypeOrientation"></v-autocomplete>
    
    
    
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                        <v-btn color="#B72C2C" dark :loading="loading" @click="validate2">
                          {{ edit ? "Modifier" : "Ajouter" }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
    
    
    
    
                <v-dialog v-model="dialog3" max-width="400px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Orientation du Patient <v-spacer></v-spacer>
                        <v-tooltip bottom color="black">
                          <template v-slot:activator="{ on, attrs }">
                            <span v-bind="attrs" v-on="on">
                              <v-btn @click="dialog3 = false" text fab depressed>
                                <v-icon>close</v-icon>
                              </v-btn>
                            </span>
                          </template>
                          <span>Fermer</span>
                        </v-tooltip>
                      </v-card-title>
                      <v-card-text>
    
                        <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="mdi-map"
                          :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
                          item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                          @change="getSpecialiteMedecin(svData.refMedecin)">
                        </v-autocomplete>
    
                        <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_medecin">
                        </v-text-field>
    
                        <v-text-field readonly label="Fonction Medecin " prepend-inner-icon="event" dense
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.fonction_medecin">
                        </v-text-field>
    
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.SalleList"
                              item-text="nom_salle" item-value="id" dense outlined v-model="svData.refSalle" chips clearable
                              @change="getLit(svData.refSalle)">
                            </v-autocomplete>
                          </div>
                        </v-flex>
    
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Lit" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.LitList" item-text="nom_lit"
                              item-value="id" dense outlined v-model="svData.refLitUrgence" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>
    
                        <!-- <v-autocomplete label="Type Orientation" :items="[
                        { designation: 'URGENCES' }
                        ]" prepend-inner-icon="extension"
                          :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                          item-value="designation" v-model="svData.TypeOrientation"></v-autocomplete> -->
    
    
    
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                        <!-- <v-btn color="#B72C2C" dark :loading="loading" @click="validate2">
                          {{ edit ? "Modifier" : "Ajouter" }}
                        </v-btn> -->
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>
    
    
    
                <!-- <br /><br /> -->
                <v-layout>
                  <!--   -->
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
                              <!-- <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                                <v-icon>add</v-icon>
                              </v-btn> -->
                            </span>
                          </template>
                          <span>Ajouter le Detail</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card :loading="loading" :disabled="loading">
                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Poids</th>
                                <th class="text-left">Taille</th>
                                <th class="text-left">TA</th>
                                <th class="text-left">Température</th>
                                <th class="text-left">FC</th>
                                <th class="text-left">FR</th>
                                <th class="text-left">Oxygène</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.Poids }}</td>
                                <td>{{ item.Taille }}</td>
                                <td>{{ item.TA }}</td>
                                <td>{{ item.Temperature }}</td>
                                <td>{{ item.FC }}</td>
                                <td>{{ item.FR }}</td>
                                <td>{{ item.Oxygene }}</td>
                                <td>{{ item.author }}</td>
                                <td>
    
                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>
    
                                    <v-list dense width="">
    
                                      <v-list-item link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Info. Triage</v-list-item-title>
                                      </v-list-item>
    
                                      <!-- <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                      </v-list-item>
    
                                      <v-list-item link @click="showData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-needle</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer à la
                                          Consultation</v-list-item-title>
                                      </v-list-item>
    
                                      <v-list-item link @click="showDataUrgence(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-needle</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer aux Urgences</v-list-item-title>
                                      </v-list-item> -->
    
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
    
    
              <!-- fin -->
            </v-card-text>
    
            <!-- container -->
          </v-card>
        </v-dialog>
      </v-row>
       
    
    </div>
    
    
    
    
    
    </template>
    <script>
    import { mapGetters, mapActions } from "vuex";
    export default {
      data() {
        return {
          //,'plainte_triage','antecedent_trige','cas_triage'
          title: "Liste des Details",
          dialog: false,
          dialog2: false,
          dialog3: false,
          edit: false,
          loading: false,
          disabled: false,
          
          etatModal: false,
          titleComponent: '',
          refEnteteTriage:0,
    
          svData: {
            id: '',
            refEnteteTriage: 0,
            plainte_triage: "RAS",
            antecedent_trige: "RAS",
            cas_triage: "",
            Poids: 0,
            Taille: 0,
            TA: "",
            Temperature: 0,
            FC: 0,
            FR: 0,
            Oxygene: "Admin",
            author: "Admin",
            refDetailTriage: 0,
            refMedecin: 0,
            dateConsultation: '',
            TypeOrientation: '',
            specialite_medecin: '',
            fonction_medecin: '',
    
            refSalle: 0,
            refLitUrgence: 0,
            cloture: "NON",
    
          },
          fetchData: [],
          medecinList: [],
          stataData: {
            SalleList: [],
            LitList: []
          },
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
        // this.fetchListSelection();
        // this.fetchListSalle();
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
              this.svData.refEnteteTriage = this.refEnteteTriage;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/update_detailTriage/${this.svData.id}`,
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
              this.svData.refEnteteTriage = this.refEnteteTriage;
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_detailTriage`,
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
        validate2() {
          if (this.$refs.form.validate()) {
            this.isLoading(true);
            if (this.edit) {
    
            }
            else {
              this.svData.author = this.userData.name;
              this.insertOrUpdate(
                `${this.apiBaseURL}/insert_enteteconsultation`,
                JSON.stringify(this.svData)
              )
                .then(({ data }) => {
                  this.showMsg(data.data);
                  this.isLoading(false);
                  this.edit = false;
                  this.dialog3 = false;
                  this.dialog2 = false;
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
          window.open(`${this.apiBaseURL}/pdf_facture_data?id=` + id);
        },
    
        //'id','refEnteteTriage','Poids','Taille','TA','Temperature','FC','FR','Oxygene','author'
        editData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailTriage/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.id = item.id;
                this.svData.refEnteteTriage = item.refEnteteTriage;
                this.svData.plainte_triage = item.plainte_triage;
                this.svData.antecedent_trige = item.antecedent_trige;
                this.svData.cas_triage = item.cas_triage;
                this.svData.Poids = item.Poids;
                this.svData.Taille = item.Taille;
                this.svData.TA = item.TA;
                this.svData.Temperature = item.Temperature;
                this.svData.FC = item.FC;
                this.svData.FR = item.FR;
                this.svData.Oxygene = item.Oxygene;
                this.svData.author = item.author;
    
              });
    
              this.edit = true;
              this.dialog = true;
            }
          );
        },
        //'id','refEnteteTriage','Poids','Taille','TA','Temperature','FC','FR','Oxygene','author'
        showData(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailTriage/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.id = item.id;
                this.svData.refEnteteTriage = item.refEnteteTriage;
                this.svData.Poids = item.Poids;
                this.svData.Taille = item.Taille;
                this.svData.TA = item.TA;
                this.svData.Temperature = item.Temperature;
                this.svData.FC = item.FC;
                this.svData.FR = item.FR;
                this.svData.Oxygene = item.Oxygene;
                this.svData.author = item.author;
    
                this.svData.refDetailTriage = item.id;
                this.svData.dateConsultation = item.dateTriage;
                //this.svData.TypeOrientation = 'CONSULTATIONS';
                this.svData.cloture = 'NON';
    
              });
    
              //this.edit = true;
              this.dialog2 = true;
            }
          );
        },
    
        showDataUrgence(id) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailTriage/${id}`).then(
            ({ data }) => {
              var donnees = data.data;
              donnees.map((item) => {
                this.svData.id = item.id;
                this.svData.refEnteteTriage = item.refEnteteTriage;
                this.svData.Poids = item.Poids;
                this.svData.Taille = item.Taille;
                this.svData.TA = item.TA;
                this.svData.Temperature = item.Temperature;
                this.svData.FC = item.FC;
                this.svData.FR = item.FR;
                this.svData.Oxygene = item.Oxygene;
                this.svData.author = item.author;
    
                this.svData.refDetailTriage = item.id;
                this.svData.dateConsultation = item.dateTriage;
                this.svData.TypeOrientation = 'URGENCES';
                this.svData.cloture = 'NON';
    
              });
    
              //this.edit = true;
              this.dialog3 = true;
            }
          );
        }
        ,
        deleteData(id) {
          this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_detailTriage/${id}`).then(
              ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
              }
            );
          });
        },
        fetchDataList() {     
          this.fetch_data(`${this.apiBaseURL}/fetch_detailtriage_entete/${this.refEnteteTriage}?page=`);
        },
        fetchListSelection() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
            ({ data }) => {
              var donnees = data.data;
              this.medecinList = donnees;
    
            }
          );
        },
        getSpecialiteMedecin(idMedecin) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
            ({ data }) => {
              var donnees = data.data;
    
              donnees.map((item) => {
                this.svData.specialite_medecin = item.specialite_medecin;
                this.svData.fonction_medecin = item.fonction_medecin;
              });
    
            }
          );
        },
        fetchListSalle() {
          this.editOrFetch(`${this.apiBaseURL}/fetch_salle_2`).then(
            ({ data }) => {
              var donnees = data.data;
              this.stataData.SalleList = donnees;
    
            }
          );
        },
        getLit(refSalle) {
          this.editOrFetch(`${this.apiBaseURL}/fetch_lit_Salle2/${refSalle}`).then(
            ({ data }) => {
              var donnees = data.data;
              this.stataData.LitList = donnees;
    
            }
          );
        }
    
    
      },
      filters: {
    
      }
    }
    </script>
    
    