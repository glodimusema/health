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
          <EnteteBesoin ref="EnteteBesoin" /> 
          <EnteteUsage ref="EnteteUsage" />

          <div>

          <v-layout>
            <!--   -->
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Kinesitherapie <v-spacer></v-spacer>
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

                      <v-textarea label="Observation du Medecin" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.observationmedesin"></v-textarea>

                      <v-text-field type="number" label="Nomnbre de Seance" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.nombreseance"></v-text-field>

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
                    <!-- ,'ValeurNormale2','observation2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Observation</th>
                              <th class="text-left">Statut</th>
                              <th class="text-left">Commentaires</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.observationmedesin }}</td>
                              <td>{{ item.statutkine }}</td>
                              <td>{{ item.commentaire }}</td>
                              <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link @click="showEnteteBesoin(item.refMouvement, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Faire un Etat de Besoin pour ce Patient
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showEnteteUsage(item.refMouvement, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Fiche de sortie des Produits
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
import EnteteBesoin from "../Pharmacies/EnteteBesoin.vue";
import EnteteUsage from "../Pharmacies/EnteteUsage.vue";

export default {
  components: {
    EnteteBesoin,
    EnteteUsage
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
      refDetailCons: 0, 
      svData: {
        id: '',
        refDetailCons: 0,
        observationmedesin: "",
        nombreseance: 0,
        commentaire: "",
        statutkine: "",
        author: "",
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_kinesiterapie/${this.svData.id}`,
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_kinesiterapie`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_kinesiterapie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.observationmedesin = item.observationmedesin;
            this.svData.nombreseance = item.nombreseance;
            this.svData.statutkine = item.statutkine;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_kinesiterapie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_kinesiterapie_cons/${this.refDetailCons}?page=`);
      //
    },
    showEnteteBesoin(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteBesoin.$data.etatModal = true;
        this.$refs.EnteteBesoin.$data.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.fetchDataList();
        this.$refs.EnteteBesoin.fetchListService();
        this.$refs.EnteteBesoin.fetchListSalle();
        this.fetchDataList();

        this.$refs.EnteteBesoin.$data.titleComponent =
          "Fiche d'Etat de Besoin pour " + name +" : "+ refMouvement;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteUsage(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteUsage.$data.etatModal = true;
        this.$refs.EnteteUsage.$data.refMouvement = refMouvement;
        this.$refs.EnteteUsage.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteUsage.fetchDataList();
        this.$refs.EnteteUsage.fetchListService();
        this.$refs.EnteteUsage.fetchListSalle();

        this.$refs.EnteteUsage.$data.titleComponent =
          "Fiche d'Utilisation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }



  },
  filters: {

  }
}
</script>
  
  