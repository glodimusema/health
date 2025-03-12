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
                      Elèment de reférence <v-spacer></v-spacer>
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
                                <v-text-field type="date" label="Date Elément" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.date_visite"></v-text-field>
                              </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                  <v-autocomplete label="Selectionnez la Période" prepend-inner-icon="home"
                                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.PeriodeList" item-text="name_periode"
                                  item-value="name_periode" dense outlined v-model="svData.typeCPN" chips clearable
                                  >
                                  </v-autocomplete>
                              </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Plaintes notés à l'évaluation rapide" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.plaintes_notes"></v-text-field>
                              </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                              <div class="mr-1">
                                <v-text-field label="Dépistage des complications / problèmes de santé" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                  v-model="svData.depistage"></v-text-field>
                              </div>
                          </v-flex>


                          
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Malnutrition
                            </v-input>
                          </div>
                        </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Peau sèche, hyper plissée" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.peauSeche">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Etat général (bon/mauvais)" :items="[
                              { designation: 'bon' },
                              { designation: 'mauvais' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.etatGenerale"></v-select>
                          </div>
                        </v-flex> 
                        
                        

                         <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids/kg" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.poids_detailCPN">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="PB" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.bP">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Présence de cécité nocturne (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.presence_cecite"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Présence d'un goitre (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.presence_goittre"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Infection
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Plaintes de fièvre (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.plaintes_fievre"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Témerature(valeur)" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.temps_valeur">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dysurie (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.duirese_oui_non"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Pertes liquidiennes anormale (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.pertes_liquidiennes"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Pré-éclampsie
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TA(mm Hg)" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ta_detailCPN">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Proteinurie (+/-)" :items="[
                              { designation: '+' },
                              { designation: '-' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.proteine_DetCPN"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Oedermes (+/-)" :items="[
                              { designation: '+' },
                              { designation: '-' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.oedemes_detCPN"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Anemi
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Coloration conjonctivale/palmaire (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.coloration_conjonctive"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (valeur)" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.paules_valeurs">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Seins
                            </v-input>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Etats des seins (normal oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.etatSein_normal"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Présence d'une masse (oui/non)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.presence_masse"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Etat du foetus
                            </v-input>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Age de grossesse" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ago_grossesse">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mouvement du foetus" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.mouvement_foetus">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hauteur utérine" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.hauteur_uterine_detCPN">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Battements du coeur foetal (BCF) (présent/absent)" :items="[
                              { designation: 'oui' },
                              { designation: 'non' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.BCF"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Risque chirurgical
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Présentation transversale du foetus à partir de la 36e semaine de grossesse" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pres_transversale">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Eclampsie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Bclampsie">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              IST
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Signes/sysmtomes : écoulement vaginal,prurit, ulcération" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.signes_symptomes">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Etat du col" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Etat_col_detCPN">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Conduite à tenir
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Conduite à tenir" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conduite_DetCpn">
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
                        <span>Ajouter Reference</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card :loading="loading" :disabled="loading">
                    <!-- ,'ValeurNormale2','observation2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Patient</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">Age</th>  
                              <th class="text-left">DateVisite</th> 
                              <th class="text-left">Poids</th>
                              <th class="text-left">Temperature</th>
                              <th class="text-left">Author</th>                                                                    
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.date_visite }}</td>
                              <td>{{ item.poids_detailCPN }}</td>
                              <td>{{ item.temps_valeur }}</td>
                              <td>{{ item.author }}</td>
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
        refCPN: 0, 

        svData: {
          id: '',
          refCPN: 0,
          typeCPN:"",  
          date_visite:"",        
          plaintes_notes:"",          
          depistage:"",
          peauSeche:"",
          etatGenerale:"",
          poids_detailCPN:"",
          bP:"",
          presence_cecite:"",
          presence_goittre:"",
          plaintes_fievre:"",
          temps_valeur:"",
          duirese_oui_non:"",
          pertes_liquidiennes:"",
          ta_detailCPN:"",
          proteine_DetCPN:"",
          oedemes_detCPN:"",
          coloration_conjonctive:"",
          paules_valeurs:"",
          etatSein_normal:"",
          presence_masse:"",
          ago_grossesse:"",
          mouvement_foetus:"",
          hauteur_uterine_detCPN:"",
          BCF:"",
          presentationFoetus_detCPN:"",
          pres_transversale:"",
          Bclampsie:"",
          signes_symptomes:"",
          Etat_col_detCPN:"",
          conduite_DetCpn:"",
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
            this.svData.refCPN= this.refCPN;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_detailCPN/${this.svData.id}`,
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
            this.svData.refCPN= this.refCPN;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_detailCPN`,
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
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailCPN/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refCPN = item.refCPN;
              this.svData.typeCPN = item.typeCPN;
              this.svData.plaintes_notes = item.plaintes_notes;  
              this.svData.date_visite = item.date_visite;
              this.svData.depistage = item.depistage;
              this.svData.peauSeche= item.peauSeche;
              this.svData.etatGenerale= item.etatGenerale;
              this.svData.poids_detailCPN= item.poids_detailCPN;
              this.svData.bP= item.bP;
              this.svData.presence_cecite= item.presence_cecite;
              this.svData.presence_goittre= item.presence_goittre;
              this.svData.plaintes_fievre= item.plaintes_fievre;
              this.svData.temps_valeur= item.temps_valeur;
              this.svData.duirese_oui_non= item.duirese_oui_non;
              this.svData.pertes_liquidiennes= item.pertes_liquidiennes;
              this.svData.ta_detailCPN= item.ta_detailCPN;
              this.svData.proteine_DetCPN= item.proteine_DetCPN;
              this.svData.oedemes_detCPN= item.oedemes_detCPN;
              this.svData.coloration_conjonctive= item.coloration_conjonctive;
              this.svData.paules_valeurs= item.paules_valeurs;
              this.svData.etatSein_normal= item.etatSein_normal;
              this.svData.presence_masse= item.presence_masse;
              this.svData.ago_grossesse= item.ago_grossesse;
              this.svData.mouvement_foetus= item.mouvement_foetus;
              this.svData.hauteur_uterine_detCPN= item.hauteur_uterine_detCPN;
              this.svData.BCF= item.BCF;
              this.svData.presentationFoetus_detCPN= item.presentationFoetus_detCPN;
              this.svData.pres_transversale= item.pres_transversale;
              this.svData.Bclampsie= item.Bclampsie;
              this.svData.signes_symptomes= item.signes_symptomes;
              this.svData.Etat_col_detCPN= item.Etat_col_detCPN;
              this.svData.conduite_DetCpn= item.conduite_DetCpn;
              this.svData.author = item.author;                        
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_detailCPN/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_detail_cpn_mere_entete/${this.refCPN}?page=`);      
      },      
      fetchListSelection() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_periode_cpn_mere2`).then(
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
  
  