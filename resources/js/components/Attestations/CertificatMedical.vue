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
                        Certificat Medical <v-spacer></v-spacer>
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

                        <!--//id,refAttestation,thoracique,indiceDePignat,etetDeSante,remarque,conclusion,DateDebut,DateFin,examination,author -->

                        <v-layout row wrap>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Debut" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.DateDebut"></v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date Fin" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.DateFin"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Thoracique" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.thoracique"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Indice de Pignat" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.indiceDePignat"></v-textarea>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Indice de verhaeck" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.indiceVerbaeck"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Etat des signes des lésions d'exposition" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.SignesLesion"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Etat de Santé *" :items="[
                                            { designation: 'Médiocre' },
                                            { designation: 'Assez-bon' },
                                            { designation: 'Bon' },
                                            { designation: 'Très bon' },
                                            { designation: 'Excellent' },
                                            { designation: 'Mauvais' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.etetDeSante"></v-select>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                <div class="mr-1">
                                  <v-autocomplete label="Selectionnez l'Examinateur" prepend-inner-icon="mdi-map"
                                    :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                                    item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.examination" chips
                                    clearable>
                                  </v-autocomplete>
                                </div>
                              </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Rémarque" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.remarque"></v-textarea>
                            </div>
                          </v-flex>                         

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Conclusion" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                v-model="svData.conclusion"></v-textarea>
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
                          <span>Ajouter Diagnostics</span>
                        </v-tooltip>
                      </v-flex>
                    </v-layout>
                    <br />
                    <v-card>

                      <v-card-text>
                        <v-simple-table>
                          <template v-slot:default>
                            <thead>
                              <tr>
                                <th class="text-left">Patient</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Thoracique</th>
                                <th class="text-left">IndicePignat</th>
                                <th class="text-left">EtatSante</th>
                                <th class="text-left">Remarque</th>
                                <th class="text-left">Conclusion</th>
                                <th class="text-left">DateDebut</th>
                                <th class="text-left">DateFin</th>
                                <th class="text-left">Examination</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.thoracique }}</td>
                                <td>{{ item.indiceDePignat }}</td>
                                <td>{{ item.etetDeSante }}</td>
                                <td>{{ item.remarque }}</td>
                                <td>{{ item.conclusion }}</td>
                                <td>{{ item.DateDebut }}</td>
                                <td>{{ item.DateFin }}</td>
                                <td>{{ item.examination }}</td>
                                <td>{{ item.author }}</td>
                                <td>


                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">
<!-- 
                                       <v-list-item link @click="printBill(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">print</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Imprimer le Certificat</v-list-item-title>
                                      </v-list-item> -->

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
      refAttestation: 0,
      etatModal: false,
      titleComponent: '',
      svData: {
        id: '',
        refAttestation: 0,
        thoracique: "",
        indiceDePignat: "",
        indiceVerbaeck:"",
        SignesLesion:"",
        etetDeSante: "",
        remarque: "",
        conclusion: "",
        DateDebut: "",
        DateFin: "",
        examination: "",
        author: ""
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
    this.fetchDataList();
    this.fetchListSelection();
     
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
          this.svData.refAttestation = this.refAttestation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_certificat_medical/${this.svData.id}`,
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
          this.svData.refAttestation = this.refAttestation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_certificat_medical`,
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
      window.open(`${this.apiBaseURL}/pdf_certificatmedical_data?id=` + id);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_certificat_medical/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAttestation = item.refAttestation;
            this.svData.thoracique = item.thoracique;
            this.svData.indiceDePignat = item.indiceDePignat;
            this.svData.indiceVerbaeck=item.indiceVerbaeck,
            this.svData.SignesLesion=item.SignesLesion,
            this.svData.etetDeSante = item.etetDeSante;
            this.svData.remarque = item.remarque;
            this.svData.conclusion = item.conclusion;
            this.svData.DateDebut = item.DateDebut;
            this.svData.DateFin = item.DateFin;
            this.svData.examination = item.examination;
            this.svData.author = item.author;

          });

          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_certificat_medical/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_certificatmedical_entete/${this.refAttestation}?page=`);

    }


  },
  filters: {

  }
}
</script>
  
  