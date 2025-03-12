<template>
  <div>

    <v-layout>
       
       <v-flex md12>
        <v-dialog v-model="dialog" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Client <v-spacer></v-spacer>
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
                <v-text-field label="Nom du client" prepend-inner-icon="person"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.name">
                </v-text-field>

                <v-text-field label="N° de téléphone" prepend-inner-icon="call"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.phone"></v-text-field>

                <v-text-field label="Adresse" prepend-inner-icon="extension"
                  :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.address"></v-text-field>


                <v-select label="Selectionnez le Pays" prepend-inner-icon="mdi-map"
                  :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList" item-text="name" item-value="id"
                  outlined v-model="svData.idclient">
                </v-select>

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
                  <span>Ajouter une categorie</span>
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
                        <th class="text-left">Nom</th>
                        <th class="text-left">Adresse</th>
                        <th class="text-left">Téléphone</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>{{ item.address }}</td>
                        <td>{{ item.phone }}</td>
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

                          <v-tooltip top color="black">
                            <template v-slot:activator="{ on, attrs }">
                              <span v-bind="attrs" v-on="on">
                                <v-btn router :to="'/admin/detail_client/'+item.id" fab small>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-btn>
                              </span>
                            </template>
                            <span>Detail</span>
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

      title: "liste des clients",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,

      svData: {
        id: '',
        name: "",
        address: "",
        phone: "",
        idclient: "",

      },
      fetchData: [],
      clientList: [],
      query: "",

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

          this.insertOrUpdate(
            `${this.apiBaseURL}/c1/update_client/${this.svData.id}`,
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

          this.insertOrUpdate(
            `${this.apiBaseURL}/c1/insert_client`,
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

    // searchMember: _.debounce(function () {
    //   this.fetchDataList();
    // }, 300),

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/c1/fetch_single_client/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {

            this.svData.id = item.id;
            this.svData.name = item.name;
            this.svData.address = item.address;
            this.svData.phone = item.phone;
          });

          this.edit = true;
          this.dialog = true;

          // console.log(donnees);
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/c1/delete_client/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/c1/clients?page=`);
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/c1/fetch_list_client`).then(
        ({ data }) => {
          var donnees = data.data;
          this.clientList = donnees;


          // console.log(this.clientList);
        }
      );
    }



  },
  filters: {

  }
}
</script>

