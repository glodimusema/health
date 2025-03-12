<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <!-- modal  -->
        <avatarAvatar ref="avatarAvatar" />
            <!-- fin modal -->

            <AvatarProfil ref="avatarPhoto" />

        <v-dialog v-model="dialog" max-width="900px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Analyse Imagerie <v-spacer></v-spacer>
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
                    <v-text-field type="date" label="Date Demande " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateImagerie">
                    </v-text-field>
                  </div>
                </v-flex>                 

                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-select label="Urgent" :items="[
                      { designation: 'Oui' },
                      { designation: 'Non' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      item-text="designation" item-value="designation" v-model="svData.urgent"></v-select>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Type d'analyse" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.TypeAnalyseList"
                      item-text="nomTypeAnalyse" item-value="id" dense outlined v-model="svData.ReftypeAnalyse" chips
                      clearable @change="get_analyse_for_TypeAnalyse(svData.ReftypeAnalyse)">
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez l'Analyse" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.AnalyseList"
                      item-text="nomAnalyse" item-value="id" dense outlined v-model="svData.refAnalyse" clearable chips>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Clinique" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.clinique">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="But" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined v-model="svData.but">
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

        <v-dialog v-model="dialog2" max-width="900px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Analyse Imagerie <v-spacer></v-spacer>
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
                <v-layout row wrap>

                  <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Demande " prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateImagerie">
                </v-text-field>
                  </div>
                </v-flex>              

                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-select label="Urgent" :items="[
                      { designation: 'Oui' },
                      { designation: 'Non' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      item-text="designation" item-value="designation" v-model="svData.urgent"></v-select>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Type d'analyse" prepend-inner-icon="home"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.TypeAnalyseList"
                      item-text="nomTypeAnalyse" item-value="id" dense outlined v-model="svData.ReftypeAnalyse" chips
                      clearable @change="get_analyse_for_TypeAnalyse(svData.ReftypeAnalyse)">
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez l'Analyse" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.AnalyseList"
                      item-text="nomAnalyse" item-value="id" dense outlined v-model="svData.refAnalyse" clearable chips>
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Clinique" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.clinique">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="But" prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                      outlined v-model="svData.but">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList" item-text="noms_medecin"
                      item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                      @change="getSpecialiteMedecin(svData.refMedecin)">
                    </v-autocomplete>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialiste">
                    </v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CNOM">
                    </v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Examen demandé" prepend-inner-icon="event" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.examenDemande">
                    </v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Technique/Indication" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.technique">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="Description" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.description">
                    </v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea label="En Conclusion" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conclusion">
                    </v-textarea>
                  </div>
                </v-flex>

                <!-- <v-flex xs12 sm12 md6 lg6class="mb-2">
                  <input class="form-control" type="file" id="photo_input" @change="onImageChange" required />
                  <br />
                  <img :style="{ height: style.height }" id="output" />
                </v-flex> -->


                </v-layout>
                
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>

        <!-- <br /><br /> -->

          <v-dialog v-model="dialog3" max-width="400px" persistent>
            <v-card :loading="loading">
              <v-form ref="form" lazy-validation>
                <v-card-title>
                  Valider les Analyses <v-spacer></v-spacer>
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

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-select label="Etat" :items="[
                        { designation: 'Attente' },
                        { designation: 'Validé' }
                      ]" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                        item-value="designation" v-model="svData.status"></v-select>
                    </div>
                  </v-flex>                
                <!--  -->
                </v-card-text>
                <v-card-actions>
                  <v-spacer></v-spacer>
                  <v-btn depressed text @click="dialog3 = false"> Fermer </v-btn>
                  <v-btn color="#B72C2C" dark :loading="loading" @click="validateLabo">
                    {{ edit ? "Modifier" : "Ajouter" }}
                  </v-btn>
                </v-card-actions>
              </v-form>
            </v-card>
          </v-dialog>


        <!-- <br /><br /> -->
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
                      <!-- <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                        <v-icon>add</v-icon>
                      </v-btn> -->
                    </span>
                  </template>
                  <span>Affecter les Examens</span>
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
                        <th class="text-left">Malade</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">Catégorie</th>                        
                        <th class="text-left">Analyse.</th>
                        <th class="text-left">MedecinDemandeur</th>
                        <th class="text-left">DateDemande</th>
                        <th class="text-left">MedecinProtocole</th>
                        <th class="text-left">Etat</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.categoriemaladiemvt }}</td>
                        <td>{{ item.nomAnalyse }} - {{ item.nomTypeAnalyse }}</td>
                        <td>{{ item.noms_medecin }}</td>
                        <td>{{ item.dateImagerie }}</td>
                        <td>{{ item.medecinProtocolaire }}</td>
                        <td>{{ item.status }}</td>
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
                              </v-list-item> -->

                              <v-list-item link @click="editDataLabo(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-marker</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Autoriser Cette Analyse</v-list-item-title>
                              </v-list-item>

                              <!-- <v-list-item link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Annuler</v-list-item-title>
                              </v-list-item> -->

                              <!-- <v-list-item link @click="printBill(item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Voir Resultat</v-list-item-title>
                              </v-list-item> -->

                              <!-- <v-list-item link router :to="'/admin/ResultatScanner/'+item.id">
                                <v-list-item-icon>
                                  <v-icon>mdi-format-align-justify</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Resultat Sacanner
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link router :to="'/admin/Cardiologie/'+item.id">
                                <v-list-item-icon>
                                  <v-icon>mdi-checkbox-marked-circle</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Cardiologie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link router :to="'/admin/Endoscopie/'+item.id">
                                <v-list-item-icon>
                                  <v-icon>mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Endoscopie
                                </v-list-item-title>
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

  </div>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "../AvatarProfil.vue"
import avatarAvatar from '../AvatarAction.vue'
export default {
  components: {
    AvatarProfil,
    avatarAvatar,
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      style: {
          height: "0px",
      },
      svData: {
        id: '',
        refMouvement: this.$route.params.id,
        ReftypeAnalyse: "",
        refAnalyse: "",
        dateImagerie: "",
        clinique: "",
        but: "",
        urgent: "",
        medecinProtocolaire: "",
        refMedecin: 0,
        specialiste: "",
        CNOM: "",
        examenDemande: "",
        technique: "",
        description: "",
        conclusion: "",
        status: "",
        evaluation_plan: "",
        author: "Admin",
        specialite_medecin: '',
        fonction_medecin: '',
        matricule_medecin: ""
      },
      fetchData: [],
      image: "",
      editor: ClassicEditor,
      don: [],
      query: "",
      stataData: {
        TypeAnalyseList: [],
        AnalyseList: [],
        medecinList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    this.getRouteParam();
    this.fetchDataList();
    this.fetchListTypeAnalyse();
    this.fetchListSelection();
  },
  computed: {
    ...mapGetters(["categoryList", "ListeEdition", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),

    updatePhoto() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("data", JSON.stringify(this.svData));
      formData.append("image", this.image);

      if (this.edit == true) {
        this.svData.refMouvement = this.$route.params.id;
        this.svData.author = this.userData.name;
        axios
          .post(`${this.apiBaseURL}/update_Imagerie_Ext`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.showMsg(data.data);

            this.fetchDataList();
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);            

            this.dialog = false;

            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
      } 
      else {
        this.svData.refMouvement = this.$route.params.id;
        this.svData.author = this.userData.name;
        axios
          .post(`${this.apiBaseURL}/insert_Imagerie_Ext`, formData, config)
          .then(({ data }) => {
            this.image = "";
            this.showMsg(data.data);

            this.fetchDataList();
            this.isLoading(false);
            this.edit = false;
            this.resetObj(this.svData);            
            this.dialog = false;

            // setTimeout(() => window.location.reload(), 2000);
            document.getElementById("photo_input").value = "";
            document.getElementById("output").src = "";
          })
          .catch((err) => this.svErr());
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

    validate() {
      if (this.$refs.form.validate()) {
        // this.isLoading(true);

        if (this.edit) {
          this.updatePhoto();
          this.dialog2=false;
        } else {
          this.updatePhoto();
          this.dialog=false;
        }
      }
    },
  
      validateLabo() {
        this.svData.author = this.userData.name;
        this.insertOrUpdate(
          `${this.apiBaseURL}/update_statuteimagerie_Ext/${this.svData.id}`,
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
        },

    showProfileModal(id, name, created) {

      if (id != null) {

        this.$refs.avatarPhoto.$data.dialog = true;
        this.$refs.avatarPhoto.$data.svData.id = id;
        this.$refs.avatarPhoto.$data.svData.created = created;
        this.$refs.avatarPhoto.display_profile(id);

        this.$refs.avatarPhoto.$data.titleComponent =
          "Détail du Profile  ";

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showProfileModalclient(id, name) {

      if (id != null) {

        this.$refs.avatarAvatar.$data.dialog = true;
        this.$refs.avatarAvatar.$data.svData.id = id;
        this.$refs.avatarAvatar.display_profile(id);

        this.$refs.avatarAvatar.$data.titleComponent =
          "Détail du Profile de " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Imagerie_Ext/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refAnalyse = item.refAnalyse;
            this.svData.ReftypeAnalyse = item.ReftypeAnalyse;
            this.svData.dateImagerie = item.dateImagerie;
            this.svData.clinique = item.clinique;
            this.svData.but = item.but;
            this.svData.urgent = item.urgent;
            this.svData.medecinProtocolaire = item.medecinProtocolaire;
            this.svData.specialiste = item.specialiste;
            this.svData.CNOM = item.CNOM;
            this.svData.examenDemande = item.nomAnalyse;
            this.svData.technique = item.technique;
            this.svData.description = item.description;
            this.svData.conclusion = item.conclusion;
            this.svData.status = item.status;
            this.svData.evaluation_plan = item.evaluation_plan;
            this.svData.author = item.author;
          });

          this.get_analyse_for_TypeAnalyse(this.svData.ReftypeAnalyse)

          this.edit = true;
          this.dialog2 = true;
        }
      );
    },   
      editDataLabo(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_Imagerie_Ext/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id;
              this.svData.refMouvement = item.refMouvement;
              this.svData.refAnalyse = item.refAnalyse;
              this.svData.ReftypeAnalyse = item.ReftypeAnalyse;
              this.svData.dateImagerie = item.dateImagerie;
              this.svData.clinique = item.clinique;
              this.svData.but = item.but;
              this.svData.urgent = item.urgent;
              this.svData.medecinProtocolaire = item.medecinProtocolaire;
              this.svData.specialiste = item.specialiste;
              this.svData.CNOM = item.CNOM;
              this.svData.examenDemande = item.nomAnalyse;
              this.svData.technique = item.technique;
              this.svData.description = item.description;
              this.svData.conclusion = item.conclusion;
              this.svData.status = item.status;
              this.svData.evaluation_plan = item.evaluation_plan;
              this.svData.author = item.author;                        
            });
  
            this.edit = true;
            this.dialog3 = true;
           }
        );
      },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_Imagerie_Ext/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {     
      this.fetch_data(`${this.apiBaseURL}/fetch_finance_Ext?page=`);
      //
    },
    fetchListTypeAnalyse() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_ttypeanalyseimagerie2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.TypeAnalyseList = donnees;

        }
      );
    },
    //fultrage de donnees
    async get_analyse_for_TypeAnalyse(id_TypeAnalyse) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_single_analyse_for_typeanalyse/${id_TypeAnalyse}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.AnalyseList = chart;
          } else {
            this.stataData.AnalyseList = [];
          }
          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

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
            this.svData.medecinProtocolaire=item.noms_medecin;
            this.svData.specialiste = item.specialite_medecin;
            this.svData.CNOM = item.matricule_medecin;
          });

        }
      );
    },
    getRouteParam() {
      var id = this.$route.params.id;
      this.refMouvement = id;
    }


  },
  filters: {

  }
}
</script>
<style scoped>
.mb-2 {
  margin-top: 10px;
}

.form-control {
  display: block;
  width: 100%;
  height: calc(1.5em + .75rem + 2px);
  padding: .375rem .75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}
</style>
  
  