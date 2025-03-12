<template>
    
    <v-layout>
        <v-flex md12>

            <DetailFacturation ref="DetailFacturation" />
            <PaiementFacture ref="PaiementFacture" />

            

            <v-form ref="form" v-model="valid" lazy-validation>

              <v-layout row wrap>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <!-- <router-link :to="'/#'">Facturations/Facturations</router-link> -->
                    <v-layout row wrap class="mt-0">
                      <!-- statistique -->
                      <v-flex md3 lg3 xs12 class="mb-2">
                        <v-container>
                          <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                            <!-- card commence -->

                            <v-list-item three-line router to="/#">
                              <v-list-item-content>
                                <div class="text-overline mb-4">Facturés</div>
                                <v-list-item-title class="text-h5 mb-1">
                                  {{ totalFacture }}$
                                </v-list-item-title>
                                <!-- <v-list-item-subtitle>dans le système</v-list-item-subtitle> -->
                              </v-list-item-content>

                              <v-list-item-avatar tile size="80" color="pink darken-1">
                                <v-icon size="60" color="white">devices</v-icon>
                              </v-list-item-avatar>

                            </v-list-item>
                            <!-- fin card -->
                          </v-card>
                        </v-container>
                      </v-flex>

                      <v-flex md3 lg3 xs12 class="mb-2">
                        <v-container>
                          <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                            <!-- card commence -->
                            <v-list-item three-line router to="/#">
                              <v-list-item-content>
                                <div class="text-overline mb-4">Payés</div>
                                <v-list-item-title class="text-h5 mb-1">
                                  {{ totalPaie }}$
                                </v-list-item-title>
                                <!-- <v-list-item-subtitle
                                >Dans le système</v-list-item-subtitle
                                > -->
                              </v-list-item-content>

                              <v-list-item-avatar tile size="80" color="indigo">
                                <v-icon size="60" color="white">developer_board_off</v-icon>
                              </v-list-item-avatar>
                            </v-list-item>

                            <!-- fin card -->

                          </v-card>
                        </v-container>
                      </v-flex>

                      <v-flex md3 lg3 xs12 class="mb-2">
                        <v-container>
                          <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                            <!-- card commence -->
                            <v-list-item three-line router to="/#">
                              <v-list-item-content>
                                <div class="text-overline mb-4">Restes</div>
                                <v-list-item-title class="text-h5 mb-1">
                                  {{ TotalReste }}$
                                </v-list-item-title>
                                <!-- <v-list-item-subtitle
                                >Dans le système </v-list-item-subtitle
                                > -->
                              </v-list-item-content>

                              <v-list-item-avatar tile size="80" color="success">
                                <v-icon size="60" color="white">real_estate_agent</v-icon>
                              </v-list-item-avatar>
                            </v-list-item>



                            <!-- fin card -->
                          </v-card>
                        </v-container>
                      </v-flex>

                      <v-flex md3 lg3 xs12 class="mb-2">
                        <v-container>
                          <v-card class="mx-auto" :loading="loading" :disabled="isloading" outlined tile max-width="344">
                            <v-list-item three-line router to="/#">
                              <v-list-item-content>
                                <div class="text-overline mb-4">Depenses</div>
                                <v-list-item-title class="text-h5 mb-1">
                                  {{ totalDepense }}$
                                </v-list-item-title>
                                <!-- <v-list-item-subtitle
                                >Dans le système</v-list-item-subtitle
                                > -->
                              </v-list-item-content>

                              <v-list-item-avatar tile size="80" color="blue lighten-2">
                                <v-icon size="60" color="white">supervised_user_circle</v-icon>
                              </v-list-item-avatar>
                            </v-list-item>


                          </v-card>
                        </v-container>
                      </v-flex>

                      <!-- fin statistique -->
                    </v-layout>


                  </div>
                </v-flex>
              </v-layout>  

              <v-layout row wrap>
                <v-flex xs12 sm12 md12 lg12>
                  <div class="mr-1">
                    <label for="inputId" style="font-weight: bold; text-decoration: underline; font-size: 24px;">Création d'une Facture</label>
                    <input type="text" id="inputId" />
                  </div>
                </v-flex>
                <br>  
                <br>             
              </v-layout>

            <v-layout row wrap>  
              
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-autocomplete label="Selectionnez le Patient" prepend-inner-icon="mdi-map"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="patientList" item-text="data_malade"
                            item-value="id" outlined dense v-model="svData.refMouvement">
                        </v-autocomplete>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="MedecinList"
                      item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" clearable
                      chips>
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="DepartementList"
                      item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement"
                      clearable chips @change="Get_unite_for_Departement(svData.refDepartement)">
                    </v-autocomplete>
                  </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                  <div class="mr-1">
                    <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="map"
                      :rules="[(v) => !!v || 'Ce champ est requis']" :items="UniteList"
                      item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refUniteProduction"
                      clearable chips>
                    </v-autocomplete>
                  </div>
                </v-flex>             
                

                <!-- <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field type="date" label="Date Facture" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.datefacture">
                        </v-text-field>
                    </div>
                </v-flex>
                <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                        <v-text-field label="Libellé" prepend-inner-icon="event" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.libelle">
                        </v-text-field>
                    </div>
                </v-flex> -->

            </v-layout>

            <v-simple-table>
                <thead>
                    <tr>
                        <th>TypeProduit</th>
                        <th>Produit</th>
                        <th>Pu($)</th> 
                        <th>Qté</th>                        
                        <th>PT($)</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(item, index) in svData.detailData" :key="index">
                        <td class="long-cell">
                            <v-autocomplete v-model="item.refTypeProduit" :items="typeproduitList"
                                label="Selectionnez le Type de Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="nom_typeproduit" item-value="id"
                                @change="get_produit_for_typeproduit(item.refTypeProduit, svData.refMouvement)"></v-autocomplete>
                        </td>
                        <td class="long-cell">
                            <v-autocomplete v-model="item.refProduit" :items="produitList"
                                label="Selectionnez le Produit" :rules="[(v) => !!v || 'Ce champ est requis']"
                                hide-no-data hide-selected item-text="nom_produit" item-value="id"
                                @change="updateUnite(index)"></v-autocomplete>
                        </td>                         
                        <td class="short-cell">
                            <v-text-field v-model="item.prixunitaire" type="number" label="PU" :rules="[rules.required]"
                                required ></v-text-field>
                        </td>  
                        <td class="short-cell">
                            <v-text-field v-model="item.quantite" type="number" label="Qté" :rules="[rules.required]"
                                required @change="updatePT(index)"></v-text-field>
                        </td>                   
                        <td>{{ item.pt }}</td>
                        <td>
                            <v-btn @click="removeItem(index)" icon>
                                <v-icon color="red">mdi-delete</v-icon>
                            </v-btn>
                        </td>
                    </tr>
                </tbody>
            </v-simple-table>

            <v-btn @click="addItem()" color="primary">Ajouter<v-icon color="white">mdi-cart-plus</v-icon></v-btn>
            <div style="text-align: right; margin-top: 20px;"><strong>Total : {{ svData.totalInvoice }} $</strong></div>

            <table>
                <tr>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate" color="success">Enregistrer</v-btn></div>
                    </td>
                    <td>
                        <div style="text-align: right; margin-top: 20px;"> <v-btn @click="validate2" color="success">Payer Cash</v-btn></div>                       
                    </td>
                </tr>
            </table>

            

            <v-flex md12>
                <!-- <v-layout>
                    <v-flex md6>
                    <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line solo outlined
                        rounded hide-details v-model="query" @keyup="fetchDataList" clearable></v-text-field>
                    </v-flex>
                    <v-flex md5>


                    </v-flex>
                    <v-flex md1>
                    <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                        <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog = true" fab color="  blue" dark>
                            <v-icon>add</v-icon>
                            </v-btn>
                        </span>
                        </template>
                        <span>Ajouter un Produit</span>
                    </v-tooltip>
                    </v-flex>
                </v-layout> -->
                <br />
                <v-card>
                    <v-card-text>
                        <v-simple-table>
                            <template v-slot:default>
                              <thead>
                                <!-- statutentetecons codeFacture -->
                                <tr>
                                  <th class="text-left">Action</th>
                                  <th class="text-left">N°Facture</th>
                                  <th class="text-left">Malade</th>
                                  <th class="text-left">Categorie</th>
                                  <th class="text-left">DateFacture</th>
                                  <th class="text-left">Services</th>
                                  <th class="text-left">Medecin</th>
                                  <th class="text-left">Departement</th>
                                  <th class="text-left">SoldeFact.</th>    
                                  <th class="text-left">Payer Cash</th>                              
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-for="item in fetchData" :key="item.id">    
                                  <td>
                                    <v-menu bottom rounded offset-y transition="scale-transition">
                                      <template v-slot:activator="{ on }">
                                        <v-btn icon v-on="on" small fab depressed text>
                                          <v-icon>more_vert</v-icon>
                                        </v-btn>
                                      </template>

                                      <v-list dense width="">

                                        <v-list-item v-if="item.totalPaie == 0 || item.totalPaie == null"  link @click="showDetailFacturation(item.id, item.noms,item.organisationAbonne,item.refMouvement)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">mdi-briefcase-check</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Ajouter les details
                                            Facture
                                          </v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="showPaieFacturation(item.id,item.noms)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">mdi-cards</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Enregistrer Paiement
                                            Facture</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Annuler la Facture</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item link @click="payer_cash(item.id, item.dateVente)">
                                        <v-list-item-icon>
                                            <v-icon>mdi-cards</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Payer Cash
                                        </v-list-item-title>
                                        </v-list-item>

                                        <!-- <v-list-item v-if="item.RestePaie != 0 || item.totalPaie == null || (modifier=='OUI')" link @click="editData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">edit</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.RestePaie != 0 || item.totalPaie == null || (supprimer=='OUI')" link @click="deleteData(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">delete</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Annuler la Facture</v-list-item-title>
                                        </v-list-item> -->

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveeGF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Privé(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveePF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Privé(e)s (A6)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneeGF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Abonné(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneePF(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture des Abonné(e)s (A6)</v-list-item-title>
                                        </v-list-item>

                                        <!-- SYNTHESE -->

                                        <!-- <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveeGF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Privé(e)s (A4)</v-list-item-title>
                                        </v-list-item>

                                        <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link @click="printFacturePriveePF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Privé(e)s (A6)</v-list-item-title>
                                        </v-list-item> -->

                                        <!-- <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneeGF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Abonné(e)s (A4)</v-list-item-title>
                                        </v-list-item> -->

                                        <!-- <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="printFactureAbonneePF_Synthese(item.id)">
                                          <v-list-item-icon>
                                            <v-icon color="#B72C2C">print</v-icon>
                                          </v-list-item-icon>
                                          <v-list-item-title style="margin-left: -20px">Facture Synthèse des Abonné(e)s (A6)</v-list-item-title>
                                        </v-list-item> -->


                                      </v-list>
                                    </v-menu>

                                  </td>                   
                                  <td>{{ item.codeFacture }}</td>
                                  <td>{{ item.noms }}</td>
                                  <td>{{ item.categoriemaladiemvt }}</td>
                                  <td>{{ item.datefacture }}</td>
                                  <td>{{ item.nom_uniteproduction }}</td>
                                  <td>{{ item.noms_medecin }}</td>
                                  <td>{{ item.nom_departement }}</td>
                                  <td>{{ item.RestePaie }}</td>
                                  <td>
                                    <v-tooltip top color="black">
                                      <template v-slot:activator="{ on, attrs }">
                                        <span v-bind="attrs" v-on="on">
                                          <v-btn @click="payer_cash(item.id, item.dateVente)" fab small><v-icon
                                              color="blue">mdi-cards</v-icon></v-btn>
                                        </span>
                                      </template>
                                      <span>Payer Cash</span>
                                    </v-tooltip>
                                </td>
                                </tr>
                              </tbody>
                            </template>
                          </v-simple-table>
                    <hr />

                    <v-pagination color="  blue" v-model="pagination.current" :length="pagination.total"
                        @input="fetchDataList"></v-pagination>
                    </v-card-text>
                </v-card>
                </v-flex>

            </v-form>
        </v-flex>
    </v-layout>   
</template>

<script>
import { mapGetters, mapActions } from "vuex";
import DetailFacturation from './DetailFacturation.vue';
import PaiementFacture from './PaiementFacture.vue';

export default {
    components:{
    DetailFacturation,
    PaiementFacture,
  },
    data() {
        return {

            title: "Liste des Requisitions",
            dialog: false,
            dialog2: false,
            edit: false,
            loading: false,
            disabled: false,

            totalDepense: 0,
            totalFacture: 0,
            totalPaie: 0,
            TotalReste: 0,

            svData: {
                id: '',
                refMouvement: 0,
                datefacture: "",
                refDepartement: "",
                refUniteProduction: "",
                refMedecin: "",
                statut: "",
                author: "",
                totalInvoice:0,
                indexEncours:0,

                detailData: [{
                    refTypeProduit:0,
                    refProduit: 0,
                    quantite: 0,
                    prixunitaire: 0,
                    pt:0
                }],                
            },
            DepartementList: [],
            UniteList: [],
            MedecinList: [],
            fetchData: [],
            produitList: [],
            typeproduitList: [],
            patientList: [],

            query: "",

            valid: false,
            customerName: '',
            items: [{ name: '', description: '', quantity: 1, price: 0 }],            
            rules: {
                required: value => !!value || 'Required.',
            },
        };
    },
    created() {
        this.fetchDataList();
        this.fetchListPatient();
        this.fetchListTypeProduit();
        this.fetchListDepartement();
        this.fetchListmedecin();

        this.fetch_sommation_recette();
        this.fetch_sommation_depense();
    },
    computed: {
        ...mapGetters(["categoryList", "isloading"]),   
    },
    methods: {
        addItem() {  
            this.updateTotal();         
            this.svData.detailData.push({                
                refProduit: 0,
                quantite: 0,
                prixunitaire: 0,
                pt:0
            });
        },
        async updateUnite(index) { 
                try {
                    // Fetch the unit detail for the specified reference
                    const response = await this.editOrFetch(`${this.apiBaseURL}/fetch_single_produit/${this.svData.detailData[index].refProduit}`);
                    // Extract data from the response
                    const donnees = response.data.data; 
                    // Assuming you want to get the first item nom_unite
                    if (donnees.length > 0) {
                        this.svData.detailData[index].prixunitaire = donnees[0].prix_produit; // Update price per unit
                    } else {
                        console.warn('No data found for the specified unit.');
                    }
                } catch (error) {
                } 
        },
        async updatePT(index)
            {
                try {
                    this.svData.detailData[index].pt = ((this.svData.detailData[index].prixunitaire *this.svData.detailData[index].quantite)); // Dummy price
                } catch (error) {
                    // console.error('Error updating unit:', error);
                    // Handle error appropriately, e.g., show a notification
                } 
        },
        updateTotal() {          

            this.svData.totalInvoice = this.svData.detailData.reduce((accumulator, current) => {
                return accumulator + current.pt;
            }, 0);          
        },
        removeItem(index) {
            this.svData.totalInvoice = this.svData.totalInvoice - this.svData.detailData[index].pt;
            this.svData.detailData.splice(index, 1);
        },
        resetForm() {
                this.svData.detailData = [{
                    refProduit: 0,
                    quantite: 0,
                    prixunitaire: 0,
                    pt:0
            }];
            this.$refs.form.reset(); // Reset the form validation state            

        },
        validate() {
            if (this.$refs.form.validate()) {
            this.isLoading(true);
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_detailfacturation_globale`,
                JSON.stringify(this.svData)
                )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                    this.resetForm();
                    this.svData.libelle = "Ventes des produits";
                })
                .catch((err) => {
                    this.svErr(), this.isLoading(false);
                });
    
            }
        },
        validate2() {
            if (this.$refs.form.validate()) {
            this.isLoading(true);
                this.svData.author = this.userData.name;
                this.insertOrUpdate(
                `${this.apiBaseURL}/insert_detailfacturation_globale_cash`,
                JSON.stringify(this.svData)
                )
                .then(({ data }) => {
                    this.showMsg(data.data);
                    this.isLoading(false);
                    this.edit = false;
                    this.dialog = false;
                    this.resetObj(this.svData);
                    this.fetchDataList();
                    this.resetForm();
                    this.svData.libelle = "Ventes des produits";
                })
                .catch((err) => {
                    this.svErr(), this.isLoading(false);
                });
    
            }
        },
        fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_entetefacturation?page=`);
        },
        fetchListPatient() {
            this.editOrFetch(`${this.apiBaseURL}/fetch_liste_mouvement`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.patientList = donnees;
                }
            );
        },
        editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_entetefacturation/${id}`).then(
            ({ data }) => {

            this.titleComponent = "modification des informations";

            this.getSvData(this.svData, data.data[0]);
            this.edit = true;
            this.dialog = true;
            }
        );
        },
        deleteData(id) {
        this.confirmMsg().then(({ res }) => {
            this.delGlobal(`${this.apiBaseURL}/delete_entetefacturation/${id}`).then(
            ({ data }) => {
                this.showMsg(data.data);
                this.fetchDataList();
            }
            );
        });
        },
        showDetailFacturation(refEnteteFacturation, name) {

        if (refEnteteFacturation != '') { 

            this.$refs.DetailFacturation.$data.etatModal = true;
            this.$refs.DetailFacturation.$data.refEnteteFacturation = refEnteteFacturation;
            this.$refs.DetailFacturation.$data.svData.refEnteteFacturation = refEnteteFacturation;
            this.$refs.DetailFacturation.fetchDataList();
            this.$refs.DetailFacturation.fetchListSelection();
            this.fetchDataList();

            this.$refs.DetailFacturation.$data.titleComponent =
            "Detail Vente pour " + name;

        } else {
            this.showError("Personne n'a fait cette action");
        }
        // 

        },
        showPaieFacturation(refEnteteFacturation, name) {

            if (refEnteteFacturation != '') {

                this.$refs.PaiementFacture.$data.etatModal = true;
                this.$refs.PaiementFacture.$data.refEnteteFacturation = refEnteteFacturation;
                this.$refs.PaiementFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
                this.$refs.PaiementFacture.fetchDataList();            
                this.$refs.PaiementFacture.get_mode_Paiement();
                this.$refs.PaiementFacture.getInfoFacture(refEnteteFacturation);
                this.fetchDataList();
            
                this.$refs.PaiementFacture.$data.titleComponent =
                "Paiement de la Facture pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },    
        payer_cash(code,datefacture) 
        {
            this.isLoading(true);
            this.svData.id=code;
            this.svData.author = this.userData.name;
            this.svData.datefacture = datefacture;
            this.insertOrUpdate(
                `${this.apiBaseURL}/insert_detailfacturation_cash/${this.svData.id}`,
                JSON.stringify(this.svData)
            )
                .then(({ data }) => {
                this.showMsg(data.data);
                this.isLoading(false);
                this.edit = false;                
                this.resetObj(this.svData);
                this.fetchDataList();
                })
                .catch((err) => {
                this.svErr(), this.isLoading(false);
                });
        },
    fetchListTypeProduit() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeproduit_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeproduitList = donnees;
        }
      );
    },
    async get_produit_for_typeproduit(refTypeProduit, refMouvement) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_produit_type4?refTypeProduit=${refTypeProduit}&refMouvement=${refMouvement}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.produitList = chart;
          } else {
            this.produitList = [];
          }

        //   chart.map((item) => {
        //     this.svData.nom_typeproduit = item.nom_typeproduit;
        //   });

          this.isLoading(false);

          //console.log(this.svData.nom_typeproduit);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    fetchListDepartement() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.DepartementList = donnees;
        }
      );
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.MedecinList = donnees;
        }
      );
    },
    //fultrage de donnees
    async Get_unite_for_Departement(idDepartement) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_unite_Departement2/${idDepartement}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.UniteList = chart;
          } else {
            this.UniteList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    printFacturePriveeGF(id) {
      //window.open(`${this.apiBaseURL}/pdf_grand_facture_groupe_privee_data?id=` + id);
      window.open(`${this.apiBaseURL}/pdf_grand_facture_privee_data?id=` + id);
    },
    printFacturePriveePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_privee_data?id=` + id);
    },
    printFactureAbonneeGF(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_abonnee_data?id=` + id);
    },
    printFactureAbonneePF(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_abonnee_data?id=` + id);
    },
    printFacturePriveeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_privee_entete_data?id=` + id);
    },
    printFacturePriveePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petite_facture_synthese_privee_entete_data?id=` + id);
    },
    printFactureAbonneeGF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_grand_facture_synthese_abonnee_data?id=` + id);
    },
    printFactureAbonneePF_Synthese(id) {
      window.open(`${this.apiBaseURL}/pdf_petit_facture_synthese_abonnee_data?id=` + id);
    },
    fetch_sommation_recette() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_sommation_recette`).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.totalFacture = item.totalFacture;
          this.totalPaie = item.totalPaie;
          this.TotalReste = item.TotalReste;
        });
      });
    },
    fetch_sommation_depense() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_sommation_depense`).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.totalDepense = item.totalDepense;
        });
      });
    },


        // VISUALISATION DES DONNEES DES COMMANDES============================================================



    },
};
</script>

<style scoped>
/* Add any necessary styles here */
.short-cell {
        width: 100px;
    }

    .medium-cell {
        width: 200px;
    }

    .long-cell {
        width: 400px;
    }

    table {
        table-layout: auto;
        width: 100%;
    }

    td {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>