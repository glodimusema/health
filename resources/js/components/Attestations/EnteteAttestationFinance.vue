<template>
  <v-layout>
    <FeuilleFacturation ref="FeuilleFacturation" />
    <CertificatDecesFinance ref="CertificatDecesFinance" />
    <CertificatMedicalFinance ref="CertificatMedicalFinance" />
    <AptitudePhysiqueFinance ref="AptitudePhysiqueFinance" />
    <v-flex md12>
      <v-layout row wrap>
        <v-flex xs12 sm12 md6 lg6>
          <div class="mr-1">
            <router-link :to="'/admin/EnteteAttestationFinance'">Attestation</router-link>                               
          </div>
        </v-flex>
        </v-layout>
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
                      <th class="text-left">DateDemande</th>
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
                      <td>{{ item.dateAttestation | formatDate }}</td>
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
                      <td>{{ item.author }}</td>
                      <td>
                        <v-tooltip v-if="(roless[0].delete=='OUI')" top color="black">
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


                            <v-divider></v-divider>
                              <v-subheader>Traitement</v-subheader>
                              <v-divider></v-divider>

                              <v-list-item link @click="showAptitudePhysique(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Certficat d'Aptitude Physique
                                </v-list-item-title>
                              </v-list-item> 
                              
                              
                              <v-list-item link @click="showCertificatDeces(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Certificat de Décés
                                </v-list-item-title>
                              </v-list-item> 

                              
                              <v-list-item link @click="showCertificatMedical(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Certificat Médical
                                </v-list-item-title>
                              </v-list-item> 

                            
                             <v-divider></v-divider>
                              <v-subheader>Feuille de facturation</v-subheader>
                              <v-divider></v-divider>                         
                            
                              <v-list-item link @click="showEnteteFacturation(item.refMouvement, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-cards</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Feuille de Facturations
                                  Facture
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
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import AptitudePhysiqueFinance from './AptitudePhysiqueFinance.vue';
import CertificatDecesFinance from './CertificatDecesFinance.vue';
import CertificatMedicalFinance from "./CertificatMedicalFinance.vue";


export default {
  components: {
    AptitudePhysiqueFinance,
    CertificatDecesFinance,
    CertificatMedicalFinance,
    FeuilleFacturation
  },
  data() {
    return {

      title: "Liste des Triages",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      //'id','dateDemande','refDetailConst','auther'
      svData: {
        id: '',
        dateDemande: "",
        refDetailConst: "",
        auther: ""
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
    this.fetchDataList();
     
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {
    ...mapActions(["getCategory"]),
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteAttestion/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
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
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_enteteAttestion?page=`);
    },

// PARTIE DES COMPOSANTS===================================================================   


    showAptitudePhysique(refAttestation, name) {

      if (refAttestation != '') {

        this.$refs.AptitudePhysiqueFinance.$data.etatModal = true;
        this.$refs.AptitudePhysiqueFinance.$data.refAttestation = refAttestation;
        this.$refs.AptitudePhysiqueFinance.$data.svData.refAttestation = refAttestation;
        this.$refs.AptitudePhysiqueFinance.fetchDataList();
        this.fetchDataList();
        
        this.$refs.AptitudePhysiqueFinance.$data.titleComponent =
          "Création du Certificat d'Aptitude physique pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCertificatMedical(refAttestation, name) {

    if (refAttestation != '') {

      this.$refs.CertificatMedicalFinance.$data.etatModal = true;
      this.$refs.CertificatMedicalFinance.$data.refAttestation = refAttestation;
      this.$refs.CertificatMedicalFinance.$data.svData.refAttestation = refAttestation;
      this.$refs.CertificatMedicalFinance.fetchDataList();
      this.fetchDataList();
      
      this.$refs.CertificatMedicalFinance.$data.titleComponent =
        "Création Certificat Medical pour " + name;

    } else {
      this.showError("Personne n'a fait cette action");
    }

    },
    showCertificatDeces(refAttestation, name) {

    if (refAttestation != '') {

      this.$refs.CertificatDecesFinance.$data.etatModal = true;
      this.$refs.CertificatDecesFinance.$data.refAttestation = refAttestation;
      this.$refs.CertificatDecesFinance.$data.svData.refAttestation = refAttestation;
      this.$refs.CertificatDecesFinance.fetchDataList();
      this.fetchDataList();
      
      this.$refs.CertificatDecesFinance.$data.titleComponent =
        "Création Certificat de Décés pour " + name;

    } else {
      this.showError("Personne n'a fait cette action");
    }

    },    
      showEnteteFacturation(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.FeuilleFacturation.$data.etatModal = true;
        this.$refs.FeuilleFacturation.$data.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.$data.svData.refMouvement = refMouvement;
        this.$refs.FeuilleFacturation.fetchDataList();
        this.$refs.FeuilleFacturation.fetchListDepartement();
        this.$refs.FeuilleFacturation.fetchListmedecin();
        this.fetchDataList();
        
        this.$refs.FeuilleFacturation.$data.titleComponent =
          "Création de la Feuille de Facturation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

      }

  },
  filters: {

  }
}
</script>
  
  