<template>
  <v-simple-table>
    <template v-slot:default>
      <thead>
        <tr>
          <th class="text-left">N°</th>
          <th class="text-left">Malade</th>
          <th class="text-left">Categorie</th>
          <th class="text-left">TauxCharge</th>
          <th class="text-left">Organisation</th>
          <th class="text-left">Etat</th>
          <th class="text-left">Auhtor</th>
          <th class="text-left">Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in dataTable" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.noms }}</td>
          <td>{{ item.Categorie }}</td>
          <td>{{ item.tauxcharge }}</td>
          <td>{{ item.nom_org }}</td>
          <td>

            <v-badge bordered color="error" icon="person" overlap>
              <v-btn elevation="2" x-small class="white--text" :color="item.Statut == 'Encours' ? 'success' : 'error'"
                depressed>
                {{ item.Statut }}
              </v-btn>
            </v-badge>

          </td>
          <td>{{ item.author }}</td>
          <td>
            <v-tooltip top color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="editData(item.id)" fab small>
                    <v-icon color="#B72C2C">edit</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Modifier</span>
            </v-tooltip>

            <v-tooltip top color="black">
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
export default {
  props:['dataTable'],
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
      query: "",

    }
  },
  created() {
    
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),

    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_affectationabone/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.$emit('chargement');
          }
        );
      });
    },

   

  },
  filters: {

  }
}
</script>
  
  