<template>
  <v-row justify="center">

    <DetailExamenColore ref="DetailExamenColore" />
    <DetailGerme ref="DetailGerme" />

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
                <v-dialog v-model="dialog" max-width="600px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Resultat Bacteriologie <v-spacer></v-spacer>
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
                              <v-text-field type="date" label="Date Prélevement" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.datePrelevement"></v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Résultat" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.dateResultat"></v-text-field>
                            </div>
                          </v-flex>

                          <!-- this.svData.autreColoration = item.autreColoration; -->

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Aspect Macro" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.aspectmacro"></v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Examen Frais" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.examenFrais"></v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Autres Colorations" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.autreColoration"></v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Autres Germe (à preéciser)" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.autresGerme"></v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-input :success-messages="['']" success disabled>
                                Antibiogramme
                              </v-input>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Sensible" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.Sensible"></v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Intermediaire" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.Intermediaire"></v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field label="Resistant" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.resistant"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Technicien" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList1"
                                item-text="noms_medecin" item-value="noms_medecin" dense outlined
                                v-model="svData.technicien" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Directeur Technique" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList1"
                                item-text="noms_medecin" item-value="noms_medecin" dense outlined
                                v-model="svData.directeurTechnique" chips clearable>
                              </v-autocomplete>
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
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
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
                          <span>Ajouter Resultat</span>
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
                                <th class="text-left">Services</th>
                                <th class="text-left">DatePrelevement</th>
                                <th class="text-left">DateResultat</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.nom_uniteproduction }}</td>
                                <td>{{ item.datePrelevement }}</td>
                                <td>{{ item.dateResultat }}</td>
                                <td>


                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showDetailExamenColore(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Examens après Coloration
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showDetailGerme(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Germes(s) isolé(s) après culture
                                        </v-list-item-title>
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
import DetailExamenColore from './DetailExamenColore.vue';
import DetailGerme from './DetailGerme.vue';

export default {
  components: {
    DetailExamenColore,
    DetailGerme
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refEnteteLabo: 0,
      //''id','refEnteteLabo','datePrelevement','dateResultat','aspectmacro',
      //'examenFrais','autresGerme','Sensible','Intermediaire','resistant','technicien','directeurTechnique','author'
      svData: {
        id: '',
        refEnteteLabo: 0,
        datePrelevement: "",
        dateResultat: "",
        aspectmacro: "",
        examenFrais: "",
        autreColoration:"",
        autresGerme: "",
        Sensible: "",
        Intermediaire: "",
        resistant: "",
        technicien: "",
        directeurTechnique: "",
        author: "",
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        medecinList1: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    // this.fetchDataList();
    // this.fetchListSelection1();
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
          this.svData.refEnteteLabo = this.refEnteteLabo;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_resultat_bacterie/${this.svData.id}`,
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
          this.svData.refEnteteLabo = this.refEnteteLabo;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_resultat_bacterie`,
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
//autreColoration
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_resultat_bacterie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteLabo = item.refEnteteLabo;
            this.svData.datePrelevement = item.datePrelevement;
            this.svData.dateResultat = item.dateResultat;
            this.svData.aspectmacro = item.aspectmacro;
            this.svData.examenFrais = item.examenFrais;
            this.svData.autreColoration = item.autreColoration;
            this.svData.autresGerme = item.autresGerme;
            this.svData.Sensible = item.Sensible;
            this.svData.Intermediaire = item.Intermediaire;
            this.svData.resistant = item.resistant;
            this.svData.technicien = item.technicien;
            this.svData.directeurTechnique = item.directeurTechnique;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_resultat_bacterie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_data_resultat_bacterie_prelevement/${this.refEnteteLabo}?page=`);
    },

    fetchListSelection1() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList1 = donnees;

        }
      );

    },
    showDetailExamenColore(refResultatBacterie, name) {

      if (refResultatBacterie != '') {

        this.$refs.DetailExamenColore.$data.etatModal = true;
        this.$refs.DetailExamenColore.$data.refResultatBacterie = refResultatBacterie;
        this.$refs.DetailExamenColore.$data.svData.refResultatBacterie = refResultatBacterie;
        this.$refs.DetailExamenColore.fetchDataList();
        this.$refs.DetailExamenColore.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailExamenColore.$data.titleComponent =
          "Detail des Examens Colorés pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    },
    showDetailGerme(refResultatBacterie, name) {

      if (refResultatBacterie != '') {

        this.$refs.DetailGerme.$data.etatModal = true;
        this.$refs.DetailGerme.$data.refResultatBacterie = refResultatBacterie;
        this.$refs.DetailGerme.$data.svData.refResultatBacterie = refResultatBacterie;
        this.$refs.DetailGerme.fetchDataList();
        this.$refs.DetailGerme.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailGerme.$data.titleComponent =
          "Detail des Germes pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //
    }


  },
  filters: {

  }
}
</script>
  
  