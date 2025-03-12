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

              <v-flex md12>
                <v-dialog v-model="dialog" max-width="600px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Demande de Soin <v-spacer></v-spacer>
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
                                  <v-text-field label="Noms" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.malade">
                            </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Sexe" :items="[
                                { designation: 'Homme' },
                                { designation: 'Femme' }
                              ]" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.sexe"></v-select>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Age" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.datenaissance">
                              </v-text-field>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Dégré de Parenté" :items="[
                                { designation: 'ENFANT' },
                                { designation: 'EPOUX' },
                                { designation: 'EPOUSE' }
                              ]" prepend-inner-icon="extension"
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.degreparente"></v-select>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Medecin Consultant" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.medecinConsultant"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>



                           <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Division RH" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.divRH"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez l'AG" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList"
                                item-text="noms_medecin" item-value="noms_medecin" dense outlined v-model="svData.AG"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>
                          
                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-text-field type="date" label="Date demande" prepend-inner-icon="event" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateDemande">
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
                  <!--   -->
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
                          <span>Ajouter le Detail</span>
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
                                <th class="text-left">Agent</th>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">DegréP.</th>
                                <th class="text-left">MedecinCons.</th>
                                <th class="text-left">DivRH</th>
                                <th class="text-left">AG</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms_medecin }}</td>
                                <td>{{ item.malade }}</td>
                                <td>{{ item.sexe }}</td>
                                <td>{{ item.datenaissance }}</td>
                                <td>{{ item.degreparente }}</td>
                                <td>{{ item.medecinConsultant }}</td>
                                <td>{{ item.divRH }}</td>
                                <td>{{ item.AG }}</td>
                                <td>
                                  <v-tooltip top v-if="(roless[0].update=='OUI')" color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="editData(item.id)" fab small>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-btn>
                                      </span>
                                    </template>
                                    <span>Modifier</span>
                                  </v-tooltip>

                                  <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="deleteData(item.id)" fab small>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-btn>
                                      </span>
                                    </template>
                                    <span>Suppression</span>
                                  </v-tooltip>

                                  <v-tooltip top color="black">
                                    <template v-slot:activator="{ on, attrs }">
                                      <span v-bind="attrs" v-on="on">
                                        <v-btn @click="printBill(item.id)" fab small><v-icon
                                            color="blue">print</v-icon></v-btn>
                                      </span>
                                    </template>
                                    <span>Imprimer Bon de Soin</span>
                                  </v-tooltip>

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
      refAffectation: 0,

      //id,refAffectation,malade,sexe,datenaissance,medecinConsultant,divRH,AG,dateDemande,author

      svData: {
        id: '',
        refAffectation: 0,
        malade: '',
        sexe: '',
        datenaissance: '',
        degreparente:'',
        medecinConsultant: '',
        divRH: '',
        AG: '',
        dateDemande: '',
        author: '',
      },
      fetchData: [],
      medecinList: [],
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
          this.svData.refAffectation = this.refAffectation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_demandeSoin/${this.svData.id}`,
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
          this.svData.refAffectation = this.refAffectation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_demandeSoin`,
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
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.medecinList = donnees;

        }
      );

    },
    editData(id) { //degreparente
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_demandeSoin/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refAffectation = item.refAffectation;
            this.svData.malade = item.malade;
            this.svData.sexe = item.sexe;
            this.svData.datenaissance = item.datenaissance;
            this.svData.degreparente = item.degreparente;
            this.svData.medecinConsultant = item.medecinConsultant;
            this.svData.divRH = item.divRH;
            this.svData.AG = item.AG;
            this.svData.dateDemande = item.dateDemande;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_demandeSoin/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bon_soin?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_demandeSoin_agent/${this.refAffectation}?page=`);
    }
  },
  filters: {

  }
}
</script>
  
  