<template>
  

  <v-row justify="center">

    <DetailCPS ref="DetailCPS" />
    <Rendevous_Enfant ref="Rendevous_Enfant" />
    <VaccinationEnfant ref="VaccinationEnfant" />

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
            <!--   -->
            <v-flex md12>
              <v-dialog v-model="dialog" max-width="900px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Consultation Prescolaire <v-spacer></v-spacer>
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
                            <v-text-field label="Nom du Père" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.NomPere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Nom de la Mère" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.NomMere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Teléphone du Père" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ContactPere">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Teléphone de la Mère" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ContactMere">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids à la Naissance" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PoidsNaissance">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Taille à a la Naissance" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TailleNaissance">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Zone de Santé" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ZoneSante">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Aire de Santé" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.AireSante">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Centre de Santé / Structure Sanitaire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CentreSante">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Est né à Domicile" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Estnedomicile"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              ATTENTION SPECIALE
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Orphelin de Mère" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.OrphelinMere"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Orphelin de Père" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.OrphelinPere"></v-select>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Frère ou soeur malnourri" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.FrereSoeur"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="La mère a plus de 5 enfants vivants" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Mere5Enfants"></v-select>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="L'enfant est un jumeau" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.EnfantJumeau"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Naissances rapprochées" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.NaissanceRapproche"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="La mère a moins de 18 ans" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Mere18ans"></v-select>
                          </div>
                        </v-flex>
                      

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              ACCOUCHEMENT
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Mode" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ModeAccouchement">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Apgar" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Apgar">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                            <v-select label="Névaripine co si mère PVV" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Nevaripine"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Mort né" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Mortne"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Mort avant 24h" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.Mort24h"></v-select>
                          </div>
                        </v-flex>
                        <!-- ComplicationAccouchement -->

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Réanimation de l'enfant" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ReanimationEnfant">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Complication post-partum" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ComplicatioPostPartum">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Vit. A à la mère" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.VitamineMere"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Fer à la mère" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.FerMere"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="CPON" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CPON">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="PF" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.PF">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="CPS" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CPS">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Complication a l'accouchement" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ComplicationAccouchement">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Type Accouchement" :items="[
                              { designation: 'Accouchements' },
                              { designation: 'Accouchements par personnel qualifié' },
                              { designation: 'Accouchées agées de <20ans' },
                              { designation: 'Accouchées référés HGR' },
                              { designation: 'Accouchée avec complications obtétricales' },
                              { designation: 'Naissances vivantes' },
                              { designation: 'Naissances vivantes a terme <2500g' },
                              { designation: 'Nouveaux nés prématurés' },
                              { designation: 'Nouveaux nés prématurés sous corticoide requis' },
                              { designation: 'Nouveaux nés méthode Kangourou' },
                              { designation: 'Nouveaux nés soins essentiels' },
                              { designation: 'Nouveaux nés allaités par heure'},
                              { designation: 'Nouveaux nés avec antibiotiques' },
                              { designation: 'Nouveaux nés béneficiant la réanimation' },
                              { designation: 'Mort-nés frais' },
                              { designation: 'Mort-nés macérés' }                   
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.TypeAccouchement"></v-select>
                          </div>
                        </v-flex> 
                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                            <v-select label="Acouchements hors FOSA" :items="[
                              { designation: 'Accouchements dans la communauté' },
                              { designation: 'Décés maternels dans la communauté' },
                              { designation: 'Autres' }                  
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.AccouchementFOSA"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="medecinList" item-text="noms_medecin"
                              item-value="id" dense outlined v-model="svData.refMedecin" chips clearable
                              @change="getSpecialiteMedecin(svData.refMedecin)">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialite_med">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM Medecin " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cnom">
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
                        <span>Ajouter CPS</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','observation2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Patient</th>
                              <th class="text-left">Sexe</th>    
                              <th class="text-left">DateNaissance</th>  
                              <th class="text-left">NomPere</th> 
                              <th class="text-left">NomMere</th>
                              <th class="text-left">PoidsNaiss.</th>                                                                    
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.dateNaissance_malade }}</td>
                              <td>{{ item.NomPere }}</td>
                              <td>{{ item.NomMere }}</td>
                              <td>{{ item.PoidsNaissance }}KG</td>
                              <td>


                                <v-menu bottom rounded offset-y transition="scale-transition">
                              <template v-slot:activator="{ on }">
                                <v-btn icon v-on="on" small fab depressed text>
                                  <v-icon>more_vert</v-icon>
                                </v-btn>
                              </template>
                            
                              <v-list dense width="">

                                <!-- <v-list-item link @click="printBill(item.id)">
                                  <v-list-item-icon>
                                <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Attestation de Naissance</v-list-item-title>
                                </v-list-item> -->

                                <v-list-item v-if="(roless[0].update=='OUI')" link @click="editData(item.id)">
                                  <v-list-item-icon>
                                <v-icon color="#B72C2C">edit</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                </v-list-item>

                                <v-list-item v-if="(roless[0].delete=='OUI')" link @click="deleteData(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">delete</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showRendezvousvaccin(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Voir les Rendez-vous
                                      </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showVaccinationEnfant(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Vaccination Enfant
                                      </v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="showDetailCPS(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Détail CPS
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
import DetailCPS from './DetailCPS.vue';
import Rendevous_Enfant from './Rendevous_Enfant.vue';
import VaccinationEnfant from './VaccinationEnfant.vue';

  export default {
    components: {
    DetailCPS,
    Rendevous_Enfant,
    VaccinationEnfant
  },
    data() {
      return {
  
        title: "Liste des Details",
        dialog: false,
        edit: false,
        loading: false,
        disabled: false,
        etatModal: false,
        titleComponent: '',
        refMouvement: 0, 
        svData: {
          id: '',
          refMouvement: 0,          
          refmaladie:"",
          NomPere:"",
          NomMere:"",
          ContactPere:"",
          ContactMere:"",
          dateEntete:"",
          numeroEnreg:"",
          PoidsNaissance:0,
          ZoneSante:"",
          AireSante:"",
          CentreSante:"",
          Estnedomicile:"",
          OrphelinMere:"",
          OrphelinPere:"",
          FrereSoeur:"",
          Mere5Enfants:"",
          EnfantJumeau:"",
          NaissanceRapproche:"",
          Mere18ans:"",
          ModeAccouchement:"",
          Apgar:"",
          Nevaripine:"",
          Mortne:"",
          Mort24h:"",
          ComplicationAccouchement:"",
          ReanimationEnfant:"",
          ComplicatioPostPartum:"",
          VitamineMere:"",
          FerMere:"",
          TailleNaissance:0,
          CPON:"",
          PF:"",
          CPS:"",
          TypeAccouchement:"",
          AccouchementFOSA:"",
          medecin:"",
          cnom:"",
          specialite_med:"",
          refMedecin:0,
          author:""
        },
        fetchData: [],
        medecinList: [],
        don:[],
        query: "",
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',
    
      }
    },
    created() {
      // this.fetchDataList();
      this.fetchListmedecin();
         
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
            this.svData.refMouvement= this.refMouvement;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/update_enteteVaccin/${this.svData.id}`,
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
            this.svData.refMouvement= this.refMouvement;
            this.svData.author = this.userData.name;
            this.insertOrUpdate(
              `${this.apiBaseURL}/insert_enteteVaccin`,
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

      fetchListmedecin() {
        this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
          ({ data }) => {
            var donnees = data.data;
            this.medecinList = donnees;

          }
        );

      },
      getSpecialiteMedecin(idMedecin) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
          ({ data }) => {
            var donnees = data.data;

            donnees.map((item) => {
              this.svData.medecin = item.noms_medecin;
              this.svData.specialite_med = item.specialite_medecin;
              this.svData.cnom = item.matricule_medecin;

            });

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
      
      printBill(id) {
        window.open(`${this.apiBaseURL}/pdf_attestation_naissance_data?id=` + id);
      },
   
      editData(id) {
        this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteVaccin/${id}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {  
              this.svData.id = item.id; 
              this.svData.refMouvement= item.refMouvement;          
              this.svData.refmaladie= item.refmaladie;
              this.svData.NomPere= item.NomPere;
              this.svData.NomMere= item.NomMere;
              this.svData.ContactPere= item.ContactPere;
              this.svData.ContactMere= item.ContactMere;
              this.svData.dateEntete= item.dateEntete;
              this.svData.numeroEnreg= item.numeroEnreg;
              this.svData.PoidsNaissance= item.PoidsNaissance;
              this.svData.ZoneSante= item.ZoneSante;
              this.svData.AireSante= item.AireSante;
              this.svData.CentreSante= item.CentreSante;
              this.svData.Estnedomicile= item.Estnedomicile;
              this.svData.OrphelinMere= item.OrphelinMere;
              this.svData.OrphelinPere= item.OrphelinPere;
              this.svData.FrereSoeur= item.FrereSoeur;
              this.svData.Mere5Enfants= item.Mere5Enfants;
              this.svData.EnfantJumeau= item.EnfantJumeau;
              this.svData.NaissanceRapproche= item.NaissanceRapproche;
              this.svData.Mere18ans= item.Mere18ans;
              this.svData.ModeAccouchement= item.ModeAccouchement;
              this.svData.Apgar= item.Apgar;
              this.svData.Nevaripine= item.Nevaripine;
              this.svData.Mortne= item.Mortne;
              this.svData.Mort24h= item.Mort24h;
              this.svData.ComplicationAccouchement= item.ComplicationAccouchement;
              this.svData.ReanimationEnfant= item.ReanimationEnfant;
              this.svData.ComplicatioPostPartum= item.ComplicatioPostPartum;
              this.svData.VitamineMere= item.VitamineMere;
              this.svData.FerMere= item.FerMere;
              this.svData.TailleNaissance= item.TailleNaissance;
              this.svData.CPON= item.CPON;
              this.svData.PF= item.PF;
              this.svData.CPS= item.CPS;
              this.svData.TypeAccouchement= item.TypeAccouchement;
              this.svData.AccouchementFOSA= item.AccouchementFOSA;
              this.svData.medecin= item.medecin;
              this.svData.cnom= item.cnom;
              this.svData.author= item.author;             
                      
            });
            this.edit = true;
            this.dialog = true;
           }
        );
      },
      deleteData(id) {
        this.confirmMsg().then(({ res }) => {
          this.delGlobal(`${this.apiBaseURL}/delete_enteteVaccin/${id}`).then(
            ({ data }) => {
              this.showMsg(data.data);
              this.fetchDataList();
            }
          );
        });
      },
      fetchDataList() {
        this.fetch_data(`${this.apiBaseURL}/fetch_enteteVaccin_mouvement/${this.refMouvement}?page=`);
        
      },
      showDetailCPS(refEnteteVac, name) {

          if (refEnteteVac != '') {

            this.$refs.DetailCPS.$data.etatModal = true;
            this.$refs.DetailCPS.$data.refEnteteVac = refEnteteVac;
            this.$refs.DetailCPS.$data.svData.refEnteteVac = refEnteteVac;
            this.$refs.DetailCPS.fetchDataList();
            this.$refs.DetailCPS.fetchListSelection();
            this.fetchDataList();
            
            this.$refs.DetailCPS.$data.titleComponent =
              "Detail CPS pour " + name;

          } else {
            this.showError("Personne n'a fait cette action");
          }

      },
      showRendezvousvaccin(refEnteteVac, name) {

          if (refEnteteVac != '') {

            this.$refs.Rendevous_Enfant.$data.etatModal = true;
            this.$refs.Rendevous_Enfant.$data.refEntete = refEnteteVac;
            this.$refs.Rendevous_Enfant.$data.svData.refEntete = refEnteteVac;
            this.$refs.Rendevous_Enfant.fetchDataList();
            this.$refs.Rendevous_Enfant.fetchListSelection();
            this.fetchDataList();
            
            this.$refs.Rendevous_Enfant.$data.titleComponent =
              "Rendez-vous Vaccin pour " + name;

          } else {
            this.showError("Personne n'a fait cette action");
          }

      },
      showVaccinationEnfant(refEnteteVac, name) {

          if (refEnteteVac != '') {

            this.$refs.VaccinationEnfant.$data.etatModal = true;
            this.$refs.VaccinationEnfant.$data.refEnteteVac = refEnteteVac;
            this.$refs.VaccinationEnfant.$data.svData.refEnteteVac = refEnteteVac;
            this.$refs.VaccinationEnfant.fetchDataList();
            this.$refs.VaccinationEnfant.fetchListPeriode();
            this.$refs.VaccinationEnfant.fetchListStrategie();
            this.$refs.VaccinationEnfant.fetchListModeAtteinte();            
            this.fetchDataList();
            
            this.$refs.VaccinationEnfant.$data.titleComponent =
              "Rendez-vous Vaccin pour " + name;

          } else {
            this.showError("Personne n'a fait cette action");
          }

      }
  
  //fetchListSelection
    },
    filters: {
  
    }
  }
  </script>
  
  