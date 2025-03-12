<template>
  
  <v-layout>
      <!--   -->
      <v-flex md12>
        <v-dialog v-model="dialog" max-width="500px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Paiement Facture <v-spacer></v-spacer>
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
                  <span>Ajouter le Detail</span>
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
                        
                        <th class="text-left">N°Reçcu</th>
                        <th class="text-left">Malade</th>
                        <th class="text-left">Montant($)</th>
                        <th class="text-left">ModePaie</th>
                        <th class="text-left">DatePaie</th>
                        <th class="text-left">Taux(FC)</th>
                        <th class="text-left">Author</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">                       
                        <td>{{ item.codeRecu }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.montantpaie }}$</td>
                        <td>{{ item.modepaie }}</td>
                        <td>{{ item.datepaie }}</td>
                        <td>{{ item.montant_taux }}</td>
                        <td>{{ item.author }}</td>
                        <td>



                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                             <!-- <v-list-item v-if="item.RestePaie == 0" link @click="editData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">edit</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                              </v-list-item>

                              <v-list-item v-if="item.RestePaie == 0" link @click="deleteData(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">delete</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                              </v-list-item> -->

                              <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printRecuPrivee(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer Reçu des Privé(e)s</v-list-item-title>
                              </v-list-item>

                              <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printRecuAbonnee(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer Reçu des Aboné(e)s</v-list-item-title>
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
      <!--   -->
    </v-layout>
  
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
      refEnteteFacturation:0,
      //'id','refEnteteFacturation','montantpaie','datepaie','modepaie','libellepaiepaie','author'
      svData: {
        id: '',
        refEnteteFacturation:0,
        montantpaie: 0,
        datepaie: "",
        modepaie: "",
        libellepaie: "",
        author: "Admin",


        totalFacture: 0,
        totalPaie: 0,
        RestePaie: 0
      },
      fetchData: [],
      ModeList: [],
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

    ...mapActions(["getCategory"])
    ,

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_paiefacturation/${this.svData.id}`,
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
            `${this.apiBaseURL}/insert_paiefacturation`,
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

    // s'id','refEnteteFacturation','refFrais','puEntree','qteEntree','author'
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_paiefacturation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteFacturation = item.refEnteteFacturation;
            this.svData.montantpaie = item.montantpaie;
            this.svData.modepaie = item.modepaie;
            this.svData.datepaie = item.datepaie;
            this.svData.libellepaie = item.libellepaie;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_paiefacturation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    printRecuPrivee(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_recu_privee_data?id=` + id);
    },
    printRecuAbonnee(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_recu_abonnee_data?id=` + id);
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_paiefacturation?page=`);
    },
    backPage() {
      this.$router.go(-1);
    }


  },
  filters: {

  }
}
</script>
  
  