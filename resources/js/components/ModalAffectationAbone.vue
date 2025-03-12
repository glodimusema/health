<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1200px">
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

          <v-layout>
             
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Création Abonnement <v-spacer></v-spacer>
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

                            <v-autocomplete label="Selectionnez l'Organisation'" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="OrganisationList" item-text="nom_org"
                              item-value="id" dense outlined v-model="svData.refOrganisation" chips clearable>
                            </v-autocomplete>

                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">

                            <v-text-field label="Taux de Prise en Charge (%)" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              v-model="svData.tauxcharge"></v-text-field>

                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Statut" :items="[
                              { designation: 'Encours' },
                              { designation: 'Sortie' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              dense item-text="designation" item-value="designation" v-model="svData.Statut"></v-select>
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
                        <span>Ajouter un Mouvement</span>
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
                              <th class="text-left">N°</th>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Categorie</th>
                              <th class="text-left">TauxCharge</th>
                              <th class="text-left">NbrJourCons</th>
                              <th class="text-left">Organisation</th>
                              <th class="text-left">Etat</th>
                              <th class="text-left">Auhtor</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.id }}</td>
                              <td>{{ item.noms }}</td>
                              <td>{{ item.Categorie }}</td>
                              <td>{{ item.tauxcharge }}</td>
                              <td>{{ item.nmbreJourCons }}</td>
                              <td>{{ item.nom_org }}</td>
                              <td>

                                <v-badge bordered color="error" icon="person" overlap>
                                  <v-btn elevation="2" x-small class="white--text"
                                    :color="item.Statut == 'Encours' ? 'success' : 'error'" depressed>
                                    {{ item.Statut }}
                                  </v-btn>
                                </v-badge>

                              </td>
                              <td>{{ item.author }}</td>
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

                                <!-- <v-tooltip top v-if="(roless[0].delete=='OUI')" color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="deleteData(item.id)" fab small>
                                        <v-icon color="#B72C2C">delete</v-icon>
                                      </v-btn>
                                    </span>
                                  </template>
                                  <span>Suppression</span>
                                </v-tooltip> -->

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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import TableModalAffectationAbone from './TableModalAffectationAbone.vue';

export default {
  components:{
    TableModalAffectationAbone,
  },
  data() {
    return {

      title: "Liste des Mouvements",
      dialog: false,
      dialog2: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refMalade: "",
      //'id','refMalade','refOrganisation', 'tauxcharge', 'statut', 'author'
      svData: {
        id: '',
        refMalade: '',
        refOrganisation: "",
        tauxcharge: "",
        Statut: "",
        author: "Admin",
      },
      fetchData: [],
      OrganisationList: [],
      clientList: [],
      personneList: [],
      don: [],
      query: ""

    }
  },
  created() {
     
    this.getRouteParam();
    // this.fetchDataList();
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
        this.svData.refMalade = this.refMalade

        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_affectationabone/${this.svData.id}`,
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_affectationabone`,
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

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_affectationabone/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.refMalade = item.refMalade;
            this.svData.refOrganisation = item.refOrganisation;
            this.svData.tauxcharge = item.tauxcharge;
            this.svData.Statut = item.Statut;
            this.svData.author = item.author;

          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_organisation`).then(
        ({ data }) => {
          var donnees = data.data;
          this.OrganisationList = donnees;
        }
      );
    }
    ,
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_affectationabone/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    chargement(){
      this.fetchDataList();
    },

    fetchDataList_all(refMalade) {
      this.fetch_data(`${this.apiBaseURL}/fetch_affectationabone_malade/${refMalade}?page=`);
    },
    fetchDataList() {
      var refMalade = this.refMalade;
      this.fetch_data(`${this.apiBaseURL}/fetch_affectationabone_malade/${refMalade}?page=`);
    },

    getRouteParam() {
      var id = this.refMalade;
      this.refMalade = id;
    }


  },
  filters: {

  }
}
</script>
  
  