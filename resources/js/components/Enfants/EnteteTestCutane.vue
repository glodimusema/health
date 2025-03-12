<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <!-- modal  -->
        <DetailTestCutane ref="DetailTestCutane" />

        <!-- fin modal -->

        <AvatarProfil ref="avatarPhoto" />

        <v-dialog v-model="dialog2" max-width="900px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Demande Test Cutané <v-spacer></v-spacer>
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
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateTest">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Demandeur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                        item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.medecinDemandeur" chips
                        clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="Conclusion du Test" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conclusionTest">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Clinique" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.clinique">
                      </v-text-field>
                    </div>
                  </v-flex>
                  

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Examinateur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                        item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" chips
                        clearable @change="getSpecialiteMedecin(svData.refMedecin)">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cNom">
                      </v-text-field>
                    </div>
                  </v-flex>

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


        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'/admin/EnteteTestCutane'">Test Cutané</router-link>
            </div>
          </v-flex>
        </v-layout>

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
                        <th class="text-left">Catégorie</th>                        
                        <th class="text-left">MedecinDemandeur</th>
                        <th class="text-left">DateDemande</th>
                        <th class="text-left">Examinateur</th>
                        <th class="text-left">Clinique</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.categoriemaladiemvt }}</td>
                        <td>{{ item.medecinDemandeur }}</td>
                        <td>{{ item.dateTest }}</td>
                        <td>{{ item.examinateur }}</td>
                        <td>{{ item.clinique }}</td>
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
                                <v-list-item-title style="margin-left: -20px">Ajouter les détails</v-list-item-title>
                              </v-list-item>   
                              
                              <v-list-item link @click="showDetailTest(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Detail sur le test Cutané
                                      </v-list-item-title>
                                </v-list-item>

                              <v-list-item link @click="printBill(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer Fiche</v-list-item-title>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "../AvatarProfil.vue"
import avatarAvatar from '../AvatarAction.vue'
import DetailTestCutane from './DetailTestCutane.vue';



export default {
  components: {
    AvatarProfil,
    avatarAvatar,
    DetailTestCutane    
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      style: {
        height: "0px",
      },
      //id,refDetailCons,dateTest,medecinDemandeur,conclusionTest,clinique,examinateur,specialite,cNom,author
      svData: {
        id: '',
        refDetailCons: 0,
        dateTest: "",
        medecinDemandeur:"", 
        conclusionTest: "",
        clinique: "",       
        examinateur: "",        
        specialite: "",
        cNom: "",       
        author: "",

        refMedecin: 0
       
      },
      fetchData: [],
      image: "",
      editor: ClassicEditor,
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
    this.fetchDataList();
    this.fetchListSelection();
       
  },
  computed: {
    ...mapGetters(["categoryList", "ListeEdition", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),
  
  validate() {
    if (this.$refs.form.validate()) {
      this.isLoading(true);
      if (this.edit) {
        this.svData.author = this.userData.name;
        this.insertOrUpdate(
          `${this.apiBaseURL}/update_enteteTest/${this.svData.id}`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            this.dialog2 = false;
            this.resetObj(this.svData);
            this.fetchDataList();
          })
          .catch((err) => {
            this.svErr(), this.isLoading(false);
          });

      }
      else {
        this.svData.author = this.userData.name;
        this.insertOrUpdate(
          `${this.apiBaseURL}/insert_enteteTest`,
          JSON.stringify(this.svData)
        )
          .then(({ data }) => {
            this.showMsg(data.data);
            this.isLoading(false);
            this.edit = false;
            //this.dialog = false;
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
      window.open(`${this.apiBaseURL}/pdf_testcutane_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteTest/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.dateTest= item.dateTest;
            this.svData.medecinDemandeur= item.medecinDemandeur; 
            this.svData.conclusionTest= item.conclusionTest;
            this.svData.clinique= item.clinique;       
            this.svData.examinateur= item.examinateur;        
            this.svData.specialite= item.specialite;
            this.svData.cNom= item.cNom;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog2 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteTest/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {      
      this.fetch_data(`${this.apiBaseURL}/fetch_enteteTest?page=`);
      //
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
            this.svData.examinateur = item.noms_medecin;
            this.svData.specialite = item.specialite_medecin;
            this.svData.cNom = item.matricule_medecin;
          });

        }
      );
    },
    // ,
    // // PARTIE DES COMPOSANTS===================================================================   


    showDetailTest(refEnteteTest, name) {

      if (refEnteteTest != '') {

        this.$refs.DetailTestCutane.$data.etatModal = true;
        this.$refs.DetailTestCutane.$data.refEnteteTest = refEnteteTest;
        this.$refs.DetailTestCutane.$data.svData.refEnteteTest = refEnteteTest;
        this.$refs.DetailTestCutane.fetchDataList();
        this.$refs.DetailTestCutane.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailTestCutane.$data.titleComponent =
          "Resultat test Cutané pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

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
  
  