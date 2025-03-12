<template>
  <div>

    <v-layout>
      <!--   -->
      <v-flex md12>

        <!-- modal  -->
        <ResultatScanner ref="ResultatScanner" />
        <Cardiologie ref="Cardiologie" />
        <Endoscopie ref="Endoscopie" />
        <avatarAvatar ref="avatarAvatar" />



        <Anuscopie ref="Anuscopie" />
        <Coloscopie ref="Coloscopie" />
        <Rectoscopie ref="Rectoscopie" />
        <Rectosigmoidocopie ref="Rectosigmoidocopie" />
        <ResultatFOGD ref="ResultatFOGD" />
        <RapportMedicalCardio ref="RapportMedicalCardio" />
        <ResultatECG ref="ResultatECG" />
        <SCoreProbabiliste ref="SCoreProbabiliste" />
        <Annexe_Imageries ref="Annexe_Imageries" />
        <!-- fin modal -->

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
                        <th class="text-left">Action</th>
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

                              <v-list-item link @click="showRapportMedicalCardio(item.refDetailConst, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Rapport Medical(Plusieurs Medecins)
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showAnnexeImageries(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-multiplication-box</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Quelques Annxes des Documents
                                </v-list-item-title>
                              </v-list-item>


                              <v-list-item link @click="showCardiologie(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Résultat Echocardiographie
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printScoreProbaliste(item.id)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Fiche des Scores
                                  Probabilistes</v-list-item-title>
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
                                <v-list-item-title style="margin-left: -20px">Protocole
                                  Echocardiographie</v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="printAttestation(item.refDetailConst)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Attestation Medicale</v-list-item-title>
                              </v-list-item>

                              <v-divider></v-divider>
                              <v-subheader>Andoscopie</v-subheader>
                              <v-divider></v-divider>

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



                              <v-list-item link @click="printBill(item.refDetailConst)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">print</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Imprimer Fiche Imagerie</v-list-item-title>
                              </v-list-item>


                            </v-list>
                          </v-menu>

                        </td>
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
import ResultatScanner from './ResultatScanner.vue';
import Cardiologie from './Cardiologie.vue';
import Endoscopie from './Endoscopie.vue';


import Anuscopie from './Anuscopie.vue';
import Coloscopie from './Coloscopie.vue';
import RapportMedicalCardio from './RapportMedicalCardio.vue';
import Rectoscopie from './Rectoscopie.vue';
import Rectosigmoidocopie from './Rectosigmoidocopie.vue';
import ResultatECG from './ResultatECG.vue';
import ResultatFOGD from './ResultatFOGD.vue';
import SCoreProbabiliste from './SCoreProbabiliste.vue';
import Annexe_Imageries from './Annexe_Imageries.vue';


export default {
  components: {
    AvatarProfil,
    avatarAvatar,
    ResultatScanner,
    Cardiologie,
    Endoscopie,


    Anuscopie,
    Coloscopie,
    Rectoscopie,
    Rectosigmoidocopie,
    ResultatFOGD,
    RapportMedicalCardio,
    ResultatECG,
    SCoreProbabiliste,
    Annexe_Imageries
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
        refDetailConst: this.$route.params.id,
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
        author: "Admin",
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

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

    }
  },
  created() {

    this.getRouteParam();
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
            `${this.apiBaseURL}/update_Imagerie`,
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
          this.svData.refDetailConst = this.refDetailConst;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_Imagerie`,
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

      this.svData.refDetailConst = this.$route.params.id;
      this.svData.author = this.userData.name;
      axios
        .post(`${this.apiBaseURL}/update_statuteimagerie`, formData, config)
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
      window.open(`${this.apiBaseURL}/pdf_scoreprobabiliste_data?id=` + id);
    },
    printECG(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatECG_data?id=` + id);
    },

    printEchocardie(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatEchocardie_data?id=` + id);
    },

    printAttestation(id) {
      window.open(`${this.apiBaseURL}/pdf_attestation_medicale_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Imagerie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailConst = item.refDetailConst;
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
    editDataLabo(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Imagerie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailConst = item.refDetailConst;
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

          this.edit = true;
          this.dialog3 = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_Imagerie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      var id = this.$route.params.id;
      this.svData.refDetailConst = id;
      this.fetch_data(`${this.apiBaseURL}/fetch_all_Imagerie?page=`);
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
    getRouteParam() {
      var id = this.$route.params.id;
      this.refDetailConst = id;
    },
    // PARTIE DES COMPOSANTS===================================================================   


    showResultatScanner(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatScanner.$data.etatModal = true;
        this.$refs.ResultatScanner.$data.refImagerie = refImagerie;
        this.$refs.ResultatScanner.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatScanner.fetchDataList();
        this.fetchDataList();
        // this.$refs.ResultatScanner.getRouteParamMalade(refEnteteFacturation);

        this.$refs.ResultatScanner.$data.titleComponent =
          "Resultat Scanner pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCardiologie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Cardiologie.$data.etatModal = true;
        this.$refs.Cardiologie.$data.refImagerie = refImagerie;
        this.$refs.Cardiologie.$data.svData.refImagerie = refImagerie;
        this.$refs.Cardiologie.fetchDataList();
        this.fetchDataList();
        // this.$refs.Cardiologie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.Cardiologie.$data.titleComponent =
          "Cardiologie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEndoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Endoscopie.$data.etatModal = true;
        this.$refs.Endoscopie.$data.refImagerie = refImagerie;
        this.$refs.Endoscopie.$data.svData.refImagerie = refImagerie;
        this.$refs.Endoscopie.fetchDataList();
        this.fetchDataList();
        // this.$refs.Endoscopie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.Endoscopie.$data.titleComponent =
          "Endoscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAnuscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Anuscopie.$data.etatModal = true;
        this.$refs.Anuscopie.$data.refImagerie = refImagerie;
        this.$refs.Anuscopie.$data.svData.refImagerie = refImagerie;
        this.$refs.Anuscopie.fetchDataList();
        this.fetchDataList();

        this.$refs.Anuscopie.$data.titleComponent =
          "Anuscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showColoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Coloscopie.$data.etatModal = true;
        this.$refs.Coloscopie.$data.refImagerie = refImagerie;
        this.$refs.Coloscopie.$data.svData.refImagerie = refImagerie;
        this.$refs.Coloscopie.fetchDataList();
        this.fetchDataList();

        this.$refs.Coloscopie.$data.titleComponent =
          "Coloscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRapportMedicalCardio(refDetailConst, name) {

      if (refDetailConst != '') {

        this.$refs.RapportMedicalCardio.$data.etatModal = true;
        this.$refs.RapportMedicalCardio.$data.refDetailConst = refDetailConst;
        this.$refs.RapportMedicalCardio.$data.svData.refDetailConst = refDetailConst;
        this.$refs.RapportMedicalCardio.fetchDataList();
        this.$refs.RapportMedicalCardio.fetchListSelection();
        this.fetchDataList();

        this.$refs.RapportMedicalCardio.$data.titleComponent =
          "Rapport Medical pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRectoscopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Rectoscopie.$data.etatModal = true;
        this.$refs.Rectoscopie.$data.refImagerie = refImagerie;
        this.$refs.Rectoscopie.$data.svData.refImagerie = refImagerie;
        this.$refs.Rectoscopie.fetchDataList();
        this.fetchDataList();

        this.$refs.Rectoscopie.$data.titleComponent =
          "Rectoscopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRectosigmoidocopie(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.Rectosigmoidocopie.$data.etatModal = true;
        this.$refs.Rectosigmoidocopie.$data.refImagerie = refImagerie;
        this.$refs.Rectosigmoidocopie.$data.svData.refImagerie = refImagerie;
        this.$refs.Rectosigmoidocopie.fetchDataList();
        this.fetchDataList();

        this.$refs.Rectosigmoidocopie.$data.titleComponent =
          "Rectosigmoidocopie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResultatECG(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatECG.$data.etatModal = true;
        this.$refs.ResultatECG.$data.refImagerie = refImagerie;
        this.$refs.ResultatECG.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatECG.fetchDataList();
        this.$refs.ResultatECG.fetchListSelection1();
        this.fetchDataList();

        this.$refs.ResultatECG.$data.titleComponent =
          "Resultat ECG pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResultatFOGD(refImagerie, name) {

      if (refImagerie != '') {

        this.$refs.ResultatFOGD.$data.etatModal = true;
        this.$refs.ResultatFOGD.$data.refImagerie = refImagerie;
        this.$refs.ResultatFOGD.$data.svData.refImagerie = refImagerie;
        this.$refs.ResultatFOGD.fetchDataList();
        this.fetchDataList();

        this.$refs.ResultatFOGD.$data.titleComponent =
          "Resultat FOGD pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showSCoreProbabiliste(refImagerie, name, genre) {
      //Annexe_Imageries
      if (refImagerie != '') {

        this.$refs.SCoreProbabiliste.$data.etatModal = true;
        this.$refs.SCoreProbabiliste.$data.refImagerie = refImagerie;
        this.$refs.SCoreProbabiliste.$data.svData.refImagerie = refImagerie;
        this.$refs.SCoreProbabiliste.$data.genre = genre;
        this.$refs.SCoreProbabiliste.$data.svData.genre = genre;
        this.$refs.SCoreProbabiliste.fetchDataList();
        this.$refs.SCoreProbabiliste.fetchListLibelle();
        this.fetchDataList();

        this.$refs.SCoreProbabiliste.$data.titleComponent =
          "Score Probabiliste pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAnnexeImageries(refImagerie, name) {
      //Annexe_Imageries
      if (refImagerie != '') {

        this.$refs.Annexe_Imageries.$data.etatModal = true;
        this.$refs.Annexe_Imageries.$data.refImagerie = refImagerie;
        this.$refs.Annexe_Imageries.$data.svData.refImagerie = refImagerie;
        this.$refs.Annexe_Imageries.fetchDataList();
        this.fetchDataList();

        this.$refs.Annexe_Imageries.$data.titleComponent =
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
  
  