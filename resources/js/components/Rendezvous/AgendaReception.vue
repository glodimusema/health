<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>
        <v-dialog v-model="dialog" max-width="600px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Details Rendez-vous <v-spacer></v-spacer>
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

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Noms du Patient" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.noms"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Contact du Patient" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.contact"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field type="date" label="Date Rendez-vous" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateRDV"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-text-field label="Lieu Rendez-vous" prepend-inner-icon="extension" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.lieu"></v-text-field>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-textarea type="textarea" label="Motif du Rendez-vous" prepend-inner-icon="draw" dense
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motif"></v-textarea>
                  </div>
                </v-flex>

                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <v-select label="Statut" :items="[
                      { designation: 'Encours' },
                      { designation: 'Fini' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                      dense item-text="designation" item-value="designation" v-model="svData.statut"></v-select>
                  </div>
                </v-flex>

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
                <!-- <v-tooltip bottom color="black">
                    <template v-slot:activator="{ on, attrs }">
                      <span v-bind="attrs" v-on="on">
                        <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                          <v-icon>add</v-icon>
                        </v-btn>
                      </span>
                    </template>
                    <span>Ajouter le Rendez-vous</span>
                  </v-tooltip> -->
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
                        <th class="text-left">Contact</th>
                        <th class="text-left">DateRDV</th>
                        <th class="text-left">Durée</th>
                        <th class="text-left">Medecin</th>
                        <th class="text-left">Motif</th>
                        <th class="text-left">Lieu</th>
                        <th class="text-left">Statut</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <!-- id,refUser,dateRDV,noms,contact,lieu,motif,statut,author -->
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.noms }}</td>
                        <td>{{ item.contact }}</td>
                        <td>{{ item.dateRDV | formatDate }}</td>
                        <td>{{ item.duree }}</td>
                        <td>{{ item.author }}</td>
                        <td>{{ item.motif }}</td>
                        <td>{{ item.lieu }}</td>
                        <td>

                          <v-badge bordered color="error" icon="person" overlap>
                            <v-btn elevation="2" x-small class="white--text"
                              :color="item.statut == 'Encours' ? 'success' : 'error'" depressed>
                              {{ item.statut }}
                            </v-btn>
                          </v-badge>

                        </td>
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
                                <v-list-item-title style="margin-left: -20px">Voir Detail</v-list-item-title>
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
export default {
  data() {
    return {
      title: "Liste des Rendez-vous",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      svData: {
        id: '',
        refUser: "",
        dateRDV: "",
        noms: "",
        contact: "",
        lieu: "",
        motif: "",
        statut: "",
        author: "Admin",

      },
      fetchData: [],

      don: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    this.getRouteParam();
    this.fetchDataList();

  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"])
    ,
    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          // this.svData.author = this.userData.name;
          // this.svData.refUser=this.userData.id;
          // this.insertOrUpdate(
          //   `${this.apiBaseURL}/update_agenda/${this.svData.id}`,
          //   JSON.stringify(this.svData)
          // )
          //   .then(({ data }) => {
          //     this.showMsg(data.data);
          //     this.isLoading(false);
          //     this.edit = false;
          //     this.dialog = false;
          //     this.resetObj(this.svData);
          //     this.fetchDataList();
          //   })
          //   .catch((err) => {
          //     this.svErr(), this.isLoading(false);
          //   });

        }
        else {
          // this.svData.author = this.userData.name;
          // this.svData.refUser=this.userData.id;
          // this.insertOrUpdate(
          //   `${this.apiBaseURL}/insert_agenda`,
          //   JSON.stringify(this.svData)
          // )
          //   .then(({ data }) => {
          //     this.showMsg(data.data);
          //     this.isLoading(false);
          //     this.edit = false;
          //     this.dialog = false;
          //     this.resetObj(this.svData);
          //     this.fetchDataList();
          //   })
          //   .catch((err) => {
          //     this.svErr(), this.isLoading(false);
          //   });
        }

      }
    },

    //  //id,refUser,dateRDV,noms,contact,lieu,motif,statut,author
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_agenda/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refUser = item.refUser;
            this.svData.dateRDV = item.dateRDV;
            this.svData.noms = item.noms;
            this.svData.contact = item.contact;
            this.svData.lieu = item.lieu;
            this.svData.motif = item.motif;
            this.svData.statut = item.statut;

          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
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
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_agenda/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonentree_data?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_agenda?page=`);

    },
    getRouteParam() {
      var id = this.userData.id;
      this.refUser = id;
    }


  },
  filters: {

  }
}
</script>
  
  