<template>
  <div>

    <v-layout>
       
       <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Ajouter Analyse Imagerie <v-spacer></v-spacer>
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

                <v-text-field label="Designation" prepend-inner-icon="extension" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nomAnalyse"></v-text-field>

                <v-autocomplete label="Selectionnez le type Analyse" prepend-inner-icon="mdi-map" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeanalyseList" item-text="nomTypeAnalyse"
                  item-value="id" outlined v-model="svData.ReftypeAnalyse">
                </v-autocomplete>

                <v-text-field type="number" label="Prix Unitaire " prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prix">
                </v-text-field>

                <v-text-field type="number" label="Prix Conventionné " prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.prixConvention">
                </v-text-field>

                <v-text-field label="Code Analyse " prepend-inner-icon="event" dense
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.codeAnalyse">
                </v-text-field>


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
                  <span>Ajouter Analyse</span>
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
                        <th class="text-left">Designation</th>
                        <th class="text-left">TypeAnalyse</th>
                        <th class="text-left">CodeAnalyse</th>
                        <th class="text-left">PrixUnitaire</th>
                        <th class="text-left">PrixConvention</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.nomAnalyse }}</td>
                        <td>{{ item.nomTypeAnalyse }}</td>
                        <td>{{ item.codeAnalyse }}</td>
                        <td>{{ item.prix }}</td>
                        <td>{{ item.prixConvention }}</td>
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

      title: "Liste des Produits",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //'id','nomAnalyse','prix','prixConvention','codeAnalyse','ReftypeAnalyse'
      svData: {
        id: '',
        ReftypeAnalyse: 0,
        nomAnalyse: "",
        prix: 0,
        prixConvention: 0,
        codeAnalyse: "",
        author: "Admin"
      },
      fetchData: [],
      typeanalyseList: [],
      query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_analyse/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_analyse`,
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

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_analyse/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.nomAnalyse = item.nomAnalyse;
            this.svData.ReftypeAnalyse = item.ReftypeAnalyse;
            this.svData.prix = item.prix;
            this.svData.prixConvention = item.prixConvention;
            this.svData.codeAnalyse = item.codeAnalyse;
            this.svData.author = item.author;
          });

          this.edit = true;
          this.dialog = true;

        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_analyse/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_ttypeanalyseimagerie2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeanalyseList = donnees;
        }
        
      );
      //console.print(data.data);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_analyse?page=`);
    }

  },
  filters: {

  }
}
</script>
  
  