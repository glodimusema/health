<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <!-- modal  -->
        <ResultatScannerExt ref="ResultatScannerExt" />
        <CardiologieExt ref="CardiologieExt" />
        <EndoscopieExt ref="EndoscopieExt" />
        <avatarAvatar ref="avatarAvatar" />
        <!-- fin modal -->


        <AnuscopieExt ref="AnuscopieExt" />
        <ColoscopieExt ref="ColoscopieExt" />
        <RectoscopieExt ref="RectoscopieExt" />
        <RectosigmoidocopieExt ref="RectosigmoidocopieExt" />
        <ResultatFOGDExt ref="ResultatFOGDExt" />
        <ResultatECGExt ref="ResultatECGExt" />
        <SCoreProbabilisteExt ref="SCoreProbabilisteExt" />
        <Annexe_Imageries_Ext ref="Annexe_Imageries_Ext" />

        <AvatarProfil ref="avatarPhoto" />

        <v-dialog v-model="dialog" max-width="900px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Analyse Imagerie <v-spacer></v-spacer>
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
                      <v-text-field type="date" label="Date Demande " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateImagerie">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Urgent" :items="[
                        { designation: 'Oui' },
                        { designation: 'Non' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.urgent"></v-select>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Type d'analyse" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.TypeAnalyseList"
                        item-text="nomTypeAnalyse" item-value="id" dense outlined v-model="svData.ReftypeAnalyse" chips
                        clearable @change="get_analyse_for_TypeAnalyse(svData.ReftypeAnalyse)">
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez l'Analyse" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.AnalyseList"
                        item-text="nomAnalyse" item-value="id" dense outlined v-model="svData.refAnalyse" clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="Clinique" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.clinique">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="But" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.but">
                      </v-textarea>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Demandeur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                        item-text="noms_medecin" item-value="noms_medecin" dense outlined
                        v-model="svData.medecindemandeur" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                        item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                        v-model="svData.serviceProvenance" chips clearable>
                      </v-autocomplete>
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
        <!-- <br /><br /> -->

        <v-dialog v-model="dialog2" max-width="900px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Analyse Imagerie <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog2 = false" text fab depressed>
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
                      <v-text-field type="date" label="Date Demande " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateImagerie">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Urgent" :items="[
                        { designation: 'Oui' },
                        { designation: 'Non' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.urgent"></v-select>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Type d'analyse" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.TypeAnalyseList"
                        item-text="nomTypeAnalyse" item-value="id" dense outlined v-model="svData.ReftypeAnalyse" chips
                        clearable @change="get_analyse_for_TypeAnalyse(svData.ReftypeAnalyse)">
                      </v-autocomplete>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez l'Analyse" prepend-inner-icon="map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.AnalyseList"
                        item-text="nomAnalyse" item-value="id" dense outlined v-model="svData.refAnalyse" clearable chips>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="Clinique" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.clinique">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-textarea label="But" prepend-inner-icon="draw" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.but">
                      </v-textarea>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Demandeur" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                        item-text="noms_medecin" item-value="noms_medecin" dense outlined
                        v-model="svData.medecindemandeur" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                        item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                        v-model="svData.serviceProvenance" chips clearable>
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                        item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" chips
                        clearable @change="getSpecialiteMedecin(svData.refMedecin)">
                      </v-autocomplete>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.specialiste">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.CNOM">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Examen demandé" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.examenDemande">
                      </v-text-field>
                    </div>
                  </v-flex>



                </v-layout>

              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>

        <br /><br />

        <v-dialog v-model="dialog3" max-width="400px" persistent>
          <v-card :loading="loading">
            <v-form ref="form" lazy-validation>
              <v-card-title>
                Valider les Analyses <v-spacer></v-spacer>
                <v-tooltip bottom color="black">
                  <template v-slot:activator="{ on, attrs }">
                    <span v-bind="attrs" v-on="on">
                      <v-btn @click="dialog3 = false" text fab depressed>
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
                    <v-select label="Etat" :items="[
                      { designation: 'Attente' },
                      { designation: 'Validé' }
                    ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                      item-text="designation" item-value="designation" v-model="svData.status"></v-select>
                  </div>
                </v-flex>
                <!--  -->
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn depressed text @click="dialog3 = false"> Fermer </v-btn>
                <v-btn color="#B72C2C" dark :loading="loading" @click="validateLabo">
                  {{ edit ? "Modifier" : "Ajouter" }}
                </v-btn>
              </v-card-actions>
            </v-form>
          </v-card>
        </v-dialog>

        <v-layout row wrap>
          <v-flex xs12 sm12 md6 lg6>
            <div class="mr-1">
              <router-link :to="'/admin/ImageriesResultat'">Imageries/Imageries</router-link>
            </div>
          </v-flex>
        </v-layout>

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
                      <!-- <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                        <v-icon>add</v-icon>
                      </v-btn> -->
                    </span>
                  </template>
                  <span>Affecter les Examens</span>
                </v-tooltip>
              </v-flex>
            </v-layout>
            <br />
            <v-card :loading="loading" :disabled="loading">
              <!-- ,'ValeurNormale2','observation2' -->
              <v-card-text>
                <v-simple-table>
                  <template v-slot:default>
                    <thead>
                      <tr>
                        <th class="text-left">N°EpisodeM</th>
                        <th class="text-left">Malade</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">Catégorie</th>
                        <th class="text-left">Analyse.</th>
                        <th class="text-left">MedecinDemandeur</th>
                        <th class="text-left">Service(Prov.)</th>
                        <th class="text-left">DateDemande</th>
                        <th class="text-left">MedecinProtocole</th>
                        <th class="text-left">Etat</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.refMouvement }}</td>
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.categoriemaladiemvt }}</td>
                        <td>{{ item.nomAnalyse }} - {{ item.nomTypeAnalyse }}</td>
                        <td>{{ item.medecindemandeur }}</td>
                        <td>{{ item.serviceProvenance }}</td>
                        <td>{{ item.dateImagerie }}</td>
                        <td>{{ item.medecinProtocolaire }}</td>
                        <td>{{ item.status }}</td>
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
                                <v-list-item-title style="margin-left: -20px">Ajouter les détails</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showResultatScanner(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-format-align-justify</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Resultat Sacanner
                                </v-list-item-title>
                              </v-list-item>

                              <v-divider></v-divider>
                              <v-subheader>Cardiologie</v-subheader>
                              <v-divider></v-divider>


                              <v-list-item link @click="showCardiologie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Cardiologie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showResultatECG(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Resultat ECG
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showSCoreProbabiliste(item.id, item.noms, item.sexe_malade)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Score Probabiliste
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showAnnexeImageries(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Quelques Annxes des Documents
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printScoreProbaliste(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Fiche des Scores Probabilistes</v-list-item-title>
                              </v-list-item>
                                    
                                <v-list-item link @click="printECG(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Protocole d'ECG</v-list-item-title>
                                </v-list-item>

                                <v-list-item link @click="printEchocardie(item.id)">
                                  <v-list-item-icon>
                                    <v-icon color="#B72C2C">print</v-icon>
                                  </v-list-item-icon>
                                  <v-list-item-title style="margin-left: -20px">Protocole Echocardiographie</v-list-item-title>
                                </v-list-item>


                              <v-divider></v-divider>
                              <v-subheader>Andoscopie</v-subheader>
                              <v-divider></v-divider>

                              <v-list-item link @click="showEndoscopie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Endoscopie
                                </v-list-item-title>
                              </v-list-item>


                              <v-list-item link @click="showAnuscopie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat Anuscopie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showColoscopie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat Coloscopie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showRectoscopie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat Rectoscopie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showRectosigmoidocopie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat Rectosigmoidocopie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showResultatFOGD(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat FOGD
                                </v-list-item-title>
                              </v-list-item>




                              <v-list-item link @click="printBill(item.refMouvement)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer Fiche Imagerie</v-list-item-title>
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
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "../AvatarProfil.vue"
import avatarAvatar from '../AvatarAction.vue'
import ResultatScannerExt from './ResultatScannerExt.vue';
import CardiologieExt from './CardiologieExt.vue';
import EndoscopieExt from './EndoscopieExt.vue';


import AnuscopieExt from './AnuscopieExt.vue';
import ColoscopieExt from './ColoscopieExt.vue';
import RectoscopieExt from './RectoscopieExt.vue';
import RectosigmoidocopieExt from './RectosigmoidocopieExt.vue';
import ResultatECGExt from './ResultatECGExt.vue';
import ResultatFOGDExt from './ResultatFOGDExt.vue';
import SCoreProbabilisteExt from './SCoreProbabilisteExt.vue';
import Annexe_Imageries_Ext from './Annexe_Imageries_Ext.vue';


export default {
  components: {
    AvatarProfil,
    avatarAvatar,
    ResultatScannerExt,
    CardiologieExt,
    EndoscopieExt,


    AnuscopieExt,
    ColoscopieExt,
    RectoscopieExt,
    RectosigmoidocopieExt,
    ResultatFOGDExt,
    ResultatECGExt,
    SCoreProbabilisteExt,
    Annexe_Imageries_Ext
  },
  data() {
    return {

      title: "Liste des Details",
      dialog: false,
      dialog2: false,
      dialog3: false,
      edit: false,
      loading: false,
      disabled: false,
      style: {
        height: "0px",
      },
      svData: {
        id: '',
        refMouvement: this.$route.params.id,
        ReftypeAnalyse: "",
        refAnalyse: "",
        dateImagerie: "",
        clinique: "",
        but: "",
        urgent: "",
        serviceProvenance: "",
        medecindemandeur: "",
        medecinProtocolaire: "",
        refMedecin: 0,
        specialiste: "",
        CNOM: "",
        examenDemande: "",
        technique: "",
        description: "",
        conclusion: "",
        status: "",
        evaluation_plan: "",
        author: "",
        specialite_medecin: '',
        fonction_medecin: '',
        matricule_medecin: ""
      },
      fetchData: [],
      image: "",
      editor: ClassicEditor,
      don: [],
      query: "",
      stataData: {
        TypeAnalyseList: [],
        AnalyseList: [],
        medecinList: [],
        ServiceList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
    this.fetchListTypeAnalyse();
    this.fetchListSelection();
    this.fetchListServices();
  },
  computed: {
    ...mapGetters(["categoryList", "ListeEdition", "isloading"]),
  },
  methods: {

    ...mapActions(["getCategory"]),

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_Imagerie_Ext`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              this.dialog2 = false;
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
            `${this.apiBaseURL}/insert_Imagerie_Ext`,
            JSON.stringify(this.svData)
          )
            .then(({ data }) => {
              this.showMsg(data.data);
              this.isLoading(false);
              this.edit = false;
              //this.dialog = false;
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

    validateLabo() {
      const config = {
        headers: { "content-type": "multipart/form-data" },
      };

      let formData = new FormData();
      formData.append("data", JSON.stringify(this.svData));
      formData.append("image", this.image);
      axios
        .post(`${this.apiBaseURL}/update_statuteimagerie_Ext`, formData, config)
        .then(({ data }) => {
          this.image = "";
          this.showMsg(data.data);

          this.fetchDataList();
          this.isLoading(false);
          this.edit = false;
          this.resetObj(this.svData);


          this.dialog3 = false;

          // setTimeout(() => window.location.reload(), 2000);
          document.getElementById("photo_input").value = "";
          document.getElementById("output").src = "";
        })
      //.catch((err) => this.svErr());

    },

    onImageChange(e) {
      this.image = e.target.files[0];
      let output = document.getElementById("output");
      output.src = URL.createObjectURL(e.target.files[0]);
      output.onload = function () {
        URL.revokeObjectURL(output.src);
        this.style.height = "240px"; // free memory
      };
    },

    showProfileModal(id, name, created) {

      if (id != null) {

        this.$refs.avatarPhoto.$data.dialog = true;
        this.$refs.avatarPhoto.$data.svData.id = id;
        this.$refs.avatarPhoto.$data.svData.created = created;
        this.$refs.avatarPhoto.display_profile(id);

        this.$refs.avatarPhoto.$data.titleComponent =
          "Détail du Profile  ";

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showProfileModalclient(id, name) {

      if (id != null) {

        this.$refs.avatarAvatar.$data.dialog = true;
        this.$refs.avatarAvatar.$data.svData.id = id;
        this.$refs.avatarAvatar.display_profile(id);
        this.$refs.avatarAvatar.$data.titleComponent =
          "Détail du Profile de " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },
    printScoreProbaliste(id) {
      window.open(`${this.apiBaseURL}/pdf_scoreprobabiliste_data_ext?id=` + id);
    },
    printECG(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatECG_data_ext?id=` + id);
    },

    printEchocardie(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatEchocardie_data_ext?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Imagerie_Ext/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMouvement = item.refMouvement;
            this.svData.refAnalyse = item.refAnalyse;
            this.svData.ReftypeAnalyse = item.ReftypeAnalyse;
            this.svData.dateImagerie = item.dateImagerie;
            this.svData.clinique = item.clinique;
            this.svData.but = item.but;
            this.svData.urgent = item.urgent;
            this.svData.medecindemandeur = item.medecindemandeur;
            this.svData.serviceProvenance = item.serviceProvenance;
            this.svData.medecinProtocolaire = item.medecinProtocolaire;
            this.svData.specialiste = item.specialiste;
            this.svData.CNOM = item.CNOM;
            this.svData.examenDemande = item.nomAnalyse;
            this.svData.technique = item.technique;
            this.svData.description = item.description;
            this.svData.conclusion = item.conclusion;
            this.svData.status = item.status;
            this.svData.evaluation_plan = item.evaluation_plan;
            this.svData.author = item.author;
          });

          this.get_analyse_for_TypeAnalyse(this.svData.ReftypeAnalyse)

          this.edit = true;
          this.dialog2 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_Imagerie_Ext/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_all_Imagerie_Ext?page=`);
      //
    },
    fetchListTypeAnalyse() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_ttypeanalyseimagerie2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.TypeAnalyseList = donnees;

        }
      );
    },
    //fultrage de donnees
    async get_analyse_for_TypeAnalyse(id_TypeAnalyse) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_analyse_for_typeanalyse/${id_TypeAnalyse}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.AnalyseList = chart;
          } else {
            this.stataData.AnalyseList = [];
          }
          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },

    getSpecialiteMedecin(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.medecinProtocolaire = item.noms_medecin;
            this.svData.specialiste = item.specialite_medecin;
            this.svData.CNOM = item.matricule_medecin;
          });

        }
      );
    },
    // PARTIE DES COMPOSANTS===================================================================   


    showResultatScanner(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatScannerExt.$data.etatModal = true;
        this.$refs.ResultatScannerExt.$data.refImagerie = refImagerie;
        this.$refs.ResultatScannerExt.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatScannerExt.fetchDataList();
        this.fetchDataList();
        // this.$refs.ResultatScanner.getRouteParamMalade(refEnteteFacturation);

        this.$refs.ResultatScannerExt.$data.titleComponent =
          "Resultat Scanner pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCardiologie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.CardiologieExt.$data.etatModal = true;
        this.$refs.CardiologieExt.$data.refImagerie = refImagerie;
        this.$refs.CardiologieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.CardiologieExt.fetchDataList();
        this.fetchDataList();
        // this.$refs.Cardiologie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.CardiologieExt.$data.titleComponent =
          "Cardiologie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEndoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.EndoscopieExt.$data.etatModal = true;
        this.$refs.EndoscopieExt.$data.refImagerie = refImagerie;
        this.$refs.EndoscopieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.EndoscopieExt.fetchDataList();
        this.fetchDataList();
        // this.$refs.Endoscopie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.EndoscopieExt.$data.titleComponent =
          "Endoscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAnuscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.AnuscopieExt.$data.etatModal = true;
        this.$refs.AnuscopieExt.$data.refImagerie = refImagerie;
        this.$refs.AnuscopieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.AnuscopieExt.fetchDataList();
        this.fetchDataList();

        this.$refs.AnuscopieExt.$data.titleComponent =
          "Anuscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showColoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ColoscopieExt.$data.etatModal = true;
        this.$refs.ColoscopieExt.$data.refImagerie = refImagerie;
        this.$refs.ColoscopieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.ColoscopieExt.fetchDataList();
        this.fetchDataList();

        this.$refs.ColoscopieExt.$data.titleComponent =
          "Coloscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRectoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.RectoscopieExt.$data.etatModal = true;
        this.$refs.RectoscopieExt.$data.refImagerie = refImagerie;
        this.$refs.RectoscopieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.RectoscopieExt.fetchDataList();
        this.fetchDataList();

        this.$refs.RectoscopieExt.$data.titleComponent =
          "Rectoscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRectosigmoidocopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.RectosigmoidocopieExt.$data.etatModal = true;
        this.$refs.RectosigmoidocopieExt.$data.refImagerie = refImagerie;
        this.$refs.RectosigmoidocopieExt.$data.svData.refImagerie = refImagerie;
        this.$refs.RectosigmoidocopieExt.fetchDataList();
        this.fetchDataList();

        this.$refs.RectosigmoidocopieExt.$data.titleComponent =
          "Rectosigmoidocopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResultatECG(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatECGExt.$data.etatModal = true;
        this.$refs.ResultatECGExt.$data.refImagerie = refImagerie;
        this.$refs.ResultatECGExt.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatECGExt.fetchDataList();
        this.$refs.ResultatECGExt.fetchListSelection1();
        this.fetchDataList();

        this.$refs.ResultatECGExt.$data.titleComponent =
          "Resultat ECG pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResultatFOGD(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatFOGDExt.$data.etatModal = true;
        this.$refs.ResultatFOGDExt.$data.refImagerie = refImagerie;
        this.$refs.ResultatFOGDExt.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatFOGDExt.fetchDataList();
        this.fetchDataList();

        this.$refs.ResultatFOGDExt.$data.titleComponent =
          "Resultat FOGD pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showSCoreProbabiliste(refImagerie, name, genre) {
      //Annexe_Imageries
      if (refImagerie != '') {

        this.$refs.SCoreProbabilisteExt.$data.etatModal = true;
        this.$refs.SCoreProbabilisteExt.$data.refImagerie = refImagerie;
        this.$refs.SCoreProbabilisteExt.$data.svData.refImagerie = refImagerie;
        this.$refs.SCoreProbabilisteExt.$data.genre = genre;
        this.$refs.SCoreProbabilisteExt.$data.svData.genre = genre;
        this.$refs.SCoreProbabilisteExt.fetchDataList();
        this.$refs.SCoreProbabilisteExt.fetchListLibelle();
        this.fetchDataList();

        this.$refs.SCoreProbabilisteExt.$data.titleComponent =
          "Score Probabiliste pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAnnexeImageries(refImagerie, name) {
      //Annexe_Imageries
      if (refImagerie != '') {

        this.$refs.Annexe_Imageries_Ext.$data.etatModal = true;
        this.$refs.Annexe_Imageries_Ext.$data.refImagerie = refImagerie;
        this.$refs.Annexe_Imageries_Ext.$data.svData.refImagerie = refImagerie;
        this.$refs.Annexe_Imageries_Ext.fetchDataList();
        this.fetchDataList();

        this.$refs.Annexe_Imageries_Ext.$data.titleComponent =
          "Annxe documents imagerie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    }



  },
  filters: {

  }
}
</script>
<style scoped>
.mb-2 {
  margin-top: 10px;
}

.form-control {
  display: block;
  width: 100%;
  height: calc(1.5em + .75rem + 2px);
  padding: .375rem .75rem;
  font-size: 1rem;
  font-weight: 400;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  background-clip: padding-box;
  border: 1px solid #ced4da;
  border-radius: .25rem;
  transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out
}
</style>
  
  