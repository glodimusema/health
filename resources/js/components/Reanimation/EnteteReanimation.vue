<template>
  <v-layout>
     
    <v-flex md12>
      <br /><br />
      <v-layout>
        <!--   -->
        <v-flex md12>
          <v-layout>
            <v-flex md6>
              <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                    <span>Ajouter une affectation</span>
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
                      <th class="text-left">N°</th>
                      <th class="text-left">Malade</th>
                      <th class="text-left">Age</th>
                      <th class="text-left">DateTransfert</th>
                      <th class="text-left">DateMouvement</th>
                      <th class="text-left">Categorie</th>
                      <th class="text-left">Statut</th>
                      <th class="text-left">Auhtor</th>
                      <th class="text-left">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="item in fetchData" :key="item.id">
                      <td>{{ item.id }}</td>
                      <td>{{ item.noms }}</td>
                      <td>{{ item.age_malade }}</td>
                      <td>{{ item.created_at | formatDate }}</td>
                      <td>{{ item.dateMouvement | formatDate }}</td>
                      <td>{{ item.categoriemaladiemvt }}</td>
                      <td>
                        <v-badge bordered color="error" icon="person" overlap>
                          <v-btn elevation="2" x-small class="white--text"
                            :color="item.Statut == 'Encours' ? 'success' : 'error'" depressed>
                            {{ item.Statut }}
                          </v-btn>
                        </v-badge>

                      </td>
                      <td>{{ item.auther }}</td>
                      <td>
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


                        <v-menu bottom rounded offset-y transition="scale-transition">
                          <template v-slot:activator="{ on }">
                            <v-btn icon v-on="on" small fab depressed text>
                              <v-icon>more_vert</v-icon>
                            </v-btn>
                          </template>

                          <v-list dense width="">

                            <v-list-item link router :to="'/admin/VaccinationDialyse/' + item.id">
                              <v-list-item-icon>
                                <v-icon>mdi-checkbox-multiple-marked-circle</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Traitements
                              </v-list-item-title>
                            </v-list-item>


                            <v-list-item link router :to="'/admin/PoseCathetere/' + item.id">
                              <v-list-item-icon>
                                <v-icon>mdi-account-key</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Surveillances
                              </v-list-item-title>
                            </v-list-item>

                            <v-list-item link router :to="'/admin/SurveillanceDialyse/' + item.id">
                              <v-list-item-icon>
                                <v-icon>mdi-sofa</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Evolutions
                              </v-list-item-title>
                            </v-list-item>  
                            
                            <v-list-item link router :to="'/admin/SurveillanceDialyse/' + item.id">
                              <v-list-item-icon>
                                <v-icon>mdi-checkbox-multiple-marked-circle</v-icon>
                              </v-list-item-icon>
                              <v-list-item-title style="margin-left: -20px">Obeservations
                              </v-list-item-title>
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  data() {
    return {

      title: "Liste des Reanimations",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //'id','dateDemande','refDetailConst','auther'
      svData: {
        id: '',       
        refDetailConst: "",
        auther: ""
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
     
    this.fetchDataList();
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {
    ...mapActions(["getCategory"]),
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_EnteteRea/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_EnteteRea?page=`);
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
    }

  },
  filters: {

  }
}
</script>
  
  