<template>
  <v-row justify="center">
    <v-dialog v-model="etatModal" persistent max-width="1500px" fullscreen>
      <v-card>
        <!-- container -->

        <v-card-title class="red" dark>
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

                <!-- EnteteCPN  -->

                <FeuilleFacturation ref="FeuilleFacturation" />
                <Imageries ref="Imageries" />
                <EnteteLabo ref="EnteteLabo" />

                <AutresOrientations ref="AutresOrientations" />
                <DiagnosticDef ref="DiagnosticDef" />
                <Kinesitherapie ref="Kinesitherapie" />
                <Ophtamologie ref="Ophtamologie" />
                <PoseActeMedecin ref="PoseActeMedecin" />
                <PrescriptionMedicament ref="PrescriptionMedicament" />
                <RapportMedical ref="RapportMedical" />
                <ResumeClinique ref="ResumeClinique" />
                <Hospitalisation ref="Hospitalisation" />
                <AgendaMedecin ref="AgendaMedecin" />
                <RapportMedicalNeuro ref="RapportMedicalNeuro" />
                <EnteteCPN ref="EnteteCPN" />
                <DetailOrdonances ref="DetailOrdonances" />
                <EnteteOrdonances ref="EnteteOrdonances" />
                <EntetePrelevement ref="EntetePrelevement" />


                <!-- EntetePrelevement,
    EnteteOrdonances -->


                <v-dialog v-model="dialog" max-width="1200px" hide-overlay transition="dialog-bottom-transition">
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Detail Consultation <v-spacer></v-spacer>
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
                      <v-card-text max-height="1500px" background-color: white>
                        <v-layout row wrap>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Type de Consultation" prepend-inner-icon="mdi-map"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeConsList"
                                item-text="designation" item-value="id" dense outlined v-model="svData.refTypeCons" chips
                                clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Plaintes" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.plainte">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Historique Maladie" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.historique">
                              </v-textarea>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Antécédent (Medicaux, Chirurgiecaux, etc.)"
                                prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.antecedent">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Complément Anamnese" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.complementanamnese">
                              </v-textarea>
                            </div>
                          </v-flex>
                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Examen Physique" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.examenphysique">
                              </v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Diagnostic de Presomption" prepend-inner-icon="draw"
                                dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.diagnostiquePres"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea type="textarea" label="Autres Diagnostics" prepend-inner-icon="draw" dense
                                :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                v-model="svData.AutresDiagnostics"></v-textarea>
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


                <v-dialog v-model="dialog2" max-width="500px" hide-overlay transition="dialog-bottom-transition">
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Envoyer au Laboratoire pour les Analyses <v-spacer></v-spacer>
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
                      <v-card-text max-height="400px" background-color: white>
                        <v-layout row wrap>


                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Service de Provanance" prepend-inner-icon="home"
                                :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                                item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refService"
                                chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                        </v-layout>
                      </v-card-text>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn depressed text @click="dialog2 = false"> Fermer </v-btn>
                        <v-btn color="#B72C2C" dark :loading="loading" @click="validate_preleve">
                          {{ edit ? "Modifier" : "Ajouter" }}
                        </v-btn>
                      </v-card-actions>
                    </v-form>
                  </v-card>
                </v-dialog>

                <br /><br />

                <v-layout>
                  <!--   -->

                  <v-flex md12>
                    <v-layout>
                      <v-flex md6>
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
                      </v-flex>
                      <v-flex md5>
                        <div>

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
                          <span>Ajouter le Detail</span>
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
                                <th class="text-left">Malade</th>
                                <th class="text-left">TypeCons.</th>
                                <th class="text-left">Plainte</th>
                                <th class="text-left">Historique</th>
                                <th class="text-left">Antécedent</th>
                                <th class="text-left">Complements</th>
                                <th class="text-left">ExamenPhysique</th>
                                <th class="text-left">Diag.Presomption</th>
                                <th class="text-left">Date</th>
                                <th class="text-left">Author</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <!-- //'id','refEnteteCons','refTypeCons','plainte','historique','antecedent','complementanamnese','examenphysique','diagnostiquePres','dateDetailCons','author' -->
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>{{ item.noms }}</td>
                                <td>{{ item.TypeConsultation }}</td>
                                <td>{{ item.plainte }}</td>
                                <td>{{ item.historique }}</td>
                                <td>{{ item.antecedent }}</td>
                                <td>{{ item.complementanamnese }}</td>
                                <td>{{ item.examenphysique }}</td>
                                <td>{{ item.diagnostiquePres }}</td>
                                <td>{{ item.dateDetailCons }}</td>
                                <td>{{ item.author }}</td>
                                <td>

                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

                                      <v-list-item link @click="showCreatePrelevement(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showEntetePrelevement(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Detail sur les Examens du
                                          laboratoire
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showImagerie(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Demander Analyses Imagerie
                                        </v-list-item-title>
                                      </v-list-item>


                                      <v-list-item link @click="showDiagnosticsDef(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-alert</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Diagnostic Définitif
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showPrescriptionMedicament(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Prescription Medicaments
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showCreateOrdonance(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Créer une Ordonance médicale
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showEnteteOrdonance(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Voir les Ordonances médicales
                                        </v-list-item-title>
                                      </v-list-item>

                                      <!-- Kinesitherapie -->
                                      <v-list-item link @click="showOphtamologie(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Ophtamologie
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showKinesitherapie(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Kinesitherapie
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showHospitalisation(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Hospitalisation du Malade
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showHospitalisation(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer à la Réanimation
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="insertChirurgie(item.id, item.dateDetailCons)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer au Bloc
                                          Operatoire</v-list-item-title>
                                      </v-list-item>
                                      <!-- insertReanimation -->
                                      <v-list-item link @click="insertDialyse(item.id, item.dateDetailCons)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer à la
                                          Dialyse</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="insertTestCutanee(item.id, item.dateDetailCons)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer au Test
                                          Cutané</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="insertAttestation(item.id, item.dateDetailCons)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Envoyer au
                                          Sécrétariat(Attestation)</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showResumeClinique(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Resumé Clinique
                                        </v-list-item-title>
                                      </v-list-item>

                                      <!-- Ophtamologie -->

                                      <v-list-item link @click="showAutresOrientations(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Autres Orientations
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showPoseActeMedecin(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Actes Medicaux
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showAgendaMedecin()">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Donner un Rendez-vous
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showRapportMedical(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Rapport Medical
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showRapportMedicalNeuro(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Rapports Neuro-Psychiatrie
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showConsultationPrenatale(item.id, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Consultation Près-natale
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showEnteteFacturation(item.refMouvement, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-cards</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Feuille de Facturations
                                          Facture
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="(roless[0].update == 'OUI')" link @click="editData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">edit</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Modifier</v-list-item-title>
                                      </v-list-item>

                                      <v-list-item v-if="(roless[0].delete == 'OUI')" link @click="deleteData(item.id)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">delete</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Supprimer</v-list-item-title>
                                      </v-list-item>

                                    </v-list>
                                  </v-menu>

                                </td>
                              </tr>
                            </tbody>
                          </template>
                        </v-simple-table>
                        <hr />
                        <!-- //agenda_medecin -->
                        <v-pagination color="#B72C2C" v-model="pagination.current" :length="pagination.total"
                          @input="fetchDataList"></v-pagination>


                      </v-card-text>
                    </v-card>
                  </v-flex>

                </v-layout>
              </v-flex>

            </v-layout>


            <!-- mes scripts de tabs -->
            <v-layout row wrap>
              <v-flex xs12 sm12 md12 lg12>


                <v-tabs orizontal>


                  <v-tab>
                    <v-icon >mdi-phone</v-icon>
                    Resumé clinique
                  </v-tab>

                  <v-tab>
                    <v-icon left> mdi-home </v-icon>
                    Diagnostics définitifs
                  </v-tab>


                  <!-- item 1 -->
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        <ResumeCliniqueCons ref="ResumeCliniqueCons" v-bind:id="id" />
                        
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <!-- fin -->

                  <!-- item 2 -->
                  <v-tab-item>
                    <v-card flat>
                      <v-card-text>
                        <!-- <BasicAvatar /> -->
                        <DiagnosticDefCons ref="DiagnosticDefCons"  v-bind:refdetailCons="id"/>
                      </v-card-text>
                    </v-card>
                  </v-tab-item>
                  <!-- fin -->
                </v-tabs>

               
              </v-flex>
            </v-layout>
            <!-- fin scripts de tabs -->

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
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import Hospitalisation from '../Hospitalisation/Hospitalisation.vue';
import Imageries from '../Imageries/Imageries.vue';
import EnteteLabo from '../Laboratoire/EnteteLabo.vue';
import EntetePrelevement from '../Laboratoire/EntetePrelevement.vue';
import EnteteCPN from '../Meres/EnteteCPN.vue';
import AgendaMedecin from '../Rendezvous/AgendaMedecin.vue';

import AutresOrientations from './AutresOrientations.vue';
import DetailOrdonances from './DetailOrdonances.vue';
import DiagnosticDef from './DiagnosticDef.vue';



import EnteteOrdonances from './EnteteOrdonances.vue';
import Kinesitherapie from './Kinesitherapie.vue';
import Ophtamologie from './Ophtamologie.vue';
import PoseActeMedecin from './PoseActeMedecin.vue';
import PrescriptionMedicament from './PrescriptionMedicament.vue';
import RapportMedical from './RapportMedical.vue';
import RapportMedicalNeuro from './RapportMedicalNeuro.vue';
import ResumeClinique from "./ResumeClinique.vue";


//autres composants
import DiagnosticDefCons from './DiagnosticDefCons.vue';
import ResumeCliniqueCons from "./ResumeCliniqueCons.vue";


export default {
  components: {
    FeuilleFacturation,
    Imageries,
    EnteteLabo,
    AutresOrientations,
    DiagnosticDef,
    Kinesitherapie,
    Ophtamologie,
    PoseActeMedecin,
    PrescriptionMedicament,
    RapportMedical,
    ResumeClinique,
    
    Hospitalisation,
    AgendaMedecin,
    RapportMedicalNeuro,
    EnteteCPN,
    DetailOrdonances,
    EnteteOrdonances,
    EntetePrelevement,
    //autres
    ResumeCliniqueCons,
    DiagnosticDefCons,
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

      etatModal: false,
      titleComponent: '',
      id: 0,
      serviceProvenance: "",
      svData: {
        id: '',
        refEnteteCons: 0,
        refTypeCons: 0,
        plainte: '',
        historique: '',
        Temperature: '',
        antecedent: '',
        complementanamnese: '',
        examenphysique: '',
        diagnostiquePres: '',
        AutresDiagnostics: '',
        author: "",
        dateeneteop: '',
        refDetailCons: 0,

        dateAttestation: "",
        dateDemande: "",
        refDetailConst: 0,
        dateTest: "",
        medecinDemandeur: "",
        auther: "",

        refEnteteOrdonance: 0,
        userOrdo: "",

        refService: 0,
        numroRecu: "",
        noms: ""
      },
      fetchData: [],
      typeConsList: [],
      stataData: {
        ServiceList: []
      },
      don: [],
      query: "",

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: '',
      //'id','dateDemande','refDetailConst','auther'

      tab: null,
      text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.',
    }
  },
  created() {
    // this.fetchDataList();
    // this.fetchListSelection();

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
          this.svData.refEnteteCons = this.refEnteteCons
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_detailconsultation/${this.svData.id}`,
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
          this.svData.refEnteteCons = this.refEnteteCons
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detailconsultation`,
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
      //refDetailCons 
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
    validate_preleve() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.author = this.userData.name;

        //serviceProvenance
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_prelevement_Cons?id=${this.svData.id}&author=${this.svData.author}&refService=${this.svData.refService}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEntetePrelevement = item.id;
              this.serviceProvenance = item.nom_uniteproduction;
            });
            this.showLaboratoire(this.svData.refEntetePrelevement, this.svData.noms, this.serviceProvenance);
            this.dialog2 = false;
            this.isLoading(false);
          }
        );

      }
      //
    },
    // fetchListServices
    showLaboratoire(refEntetePrelevement, name, serviceProvenance) {

      if (refEntetePrelevement != '') {

        this.$refs.EnteteLabo.$data.etatModal = true;
        this.$refs.EnteteLabo.$data.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo.$data.svData.refEntetePrelevement = refEntetePrelevement;
        this.$refs.EnteteLabo.$data.serviceProvenance = serviceProvenance;
        this.$refs.EnteteLabo.fetchDataList();
        this.$refs.EnteteLabo.get_examen_all();
        this.$refs.EnteteLabo.fetchListServices();
        this.fetchDataList();

        this.$refs.EnteteLabo.$data.titleComponent =
          "Demander les Examens de Laboratoire pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCreatePrelevement(id, noms) {
      this.dialog2 = true;
      this.svData.id = id;
      this.svData.noms = noms;
    },
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },
    insertChirurgie(id, dateDetailCons) {
      this.svData.author = this.userData.name;
      this.svData.refDetailCons = id;
      this.svData.dateeneteop = dateDetailCons;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteoperation`,
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

    },
    insertTestCutanee(id, dateDetailCons) {
      this.svData.author = this.userData.name;
      this.svData.refDetailCons = id;
      this.svData.dateTest = dateDetailCons;
      this.svData.medecinDemandeur = this.userData.name;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteTest`,
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

    },
    insertDialyse(id, dateDetailCons) {
      this.svData.auther = this.userData.name;
      this.svData.refDetailConst = id;
      this.svData.dateDemande = dateDetailCons;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_EnteteDyalise`,
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

    },
    insertAttestation(id, dateDetailCons) {
      this.svData.author = this.userData.name;
      this.svData.refDetailConst = id;
      this.svData.dateAttestation = dateDetailCons;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteAttestion`,
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

    },
    insertReanimation(id) {
      this.svData.auther = this.userData.name;
      this.svData.refDetailConst = id;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_EnteteRea`,
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

    },

    //'id','refEnteteCons','refTypeCons','plainte','historique','antecedent','complementanamnese','examenphysique','diagnostiquePres','dateDetailCons','author'
    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_detailconsultation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteCons = item.refEnteteCons;
            this.svData.refTypeCons = item.refTypeCons;
            this.svData.plainte = item.plainte;
            this.svData.historique = item.historique;
            this.svData.antecedent = item.antecedent;
            this.svData.complementanamnese = item.complementanamnese;
            this.svData.examenphysique = item.examenphysique;
            this.svData.diagnostiquePres = item.diagnostiquePres;
            this.svData.AutresDiagnostics = item.AutresDiagnostics;
            this.svData.author = item.author;

          });
          //AutresDiagnostics
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detailconsultation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_detail_for_entete_byid/${this.id}?page=`);

    },
    fetchListtypeconsultation() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typeConsultation`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeConsList = donnees;
        }
      );
    },
    fetchListSelection() {
      this.fetchListtypeconsultation();
      this.fetchListServices();
    },

    // PARTIE DES COMPOSANTS===================================================================   


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

    },

    // PARTIE DES COMPOSANTS===================================================================   


    showImagerie(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Imageries.$data.etatModal = true;
        this.$refs.Imageries.$data.refDetailConst = refDetailCons;
        this.$refs.Imageries.$data.svData.refDetailConst = refDetailCons;
        this.$refs.Imageries.fetchDataList();
        this.$refs.Imageries.fetchListTypeAnalyse();
        this.$refs.Imageries.fetchListSelection();
        this.$refs.Imageries.fetchListServices();
        this.fetchDataList();

        this.$refs.Imageries.$data.titleComponent =
          "Demander les analyses d'Imagerie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showAutresOrientations(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.AutresOrientations.$data.etatModal = true;
        this.$refs.AutresOrientations.$data.refDetailCons = refDetailCons;
        this.$refs.AutresOrientations.$data.svData.refDetailCons = refDetailCons;
        this.$refs.AutresOrientations.fetchDataList();
        // this.$refs.AutresOrientations.fetchListSelection();
        this.fetchDataList();

        this.$refs.AutresOrientations.$data.titleComponent =
          "Autres Orientations pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showDiagnosticsDef(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.DiagnosticDef.$data.etatModal = true;
        this.$refs.DiagnosticDef.$data.refdetailCons = refDetailCons;
        this.$refs.DiagnosticDef.$data.svData.refdetailCons = refDetailCons;
        this.$refs.DiagnosticDef.fetchDataList();
        this.$refs.DiagnosticDef.fetchListSelection();
        this.fetchDataList();

        this.$refs.DiagnosticDef.$data.titleComponent =
          "Diagnostics définitifs pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showKinesitherapie(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Kinesitherapie.$data.etatModal = true;
        this.$refs.Kinesitherapie.$data.refDetailCons = refDetailCons;
        this.$refs.Kinesitherapie.$data.svData.refDetailCons = refDetailCons;
        this.$refs.Kinesitherapie.fetchDataList();
        // this.$refs.Kinesitherapie.fetchListSelection();
        this.fetchDataList();

        this.$refs.Kinesitherapie.$data.titleComponent =
          "Kinesitherapie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showOphtamologie(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Ophtamologie.$data.etatModal = true;
        this.$refs.Ophtamologie.$data.refDetailConst = refDetailCons;
        this.$refs.Ophtamologie.$data.svData.refDetailConst = refDetailCons;
        this.$refs.Ophtamologie.fetchDataList();
        // this.$refs.Ophtamologie.fetchListSelection();
        this.fetchDataList();

        this.$refs.Ophtamologie.$data.titleComponent =
          "Ophtamologie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPoseActeMedecin(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.PoseActeMedecin.$data.etatModal = true;
        this.$refs.PoseActeMedecin.$data.refDetailCons = refDetailCons;
        this.$refs.PoseActeMedecin.$data.svData.refDetailCons = refDetailCons;
        this.$refs.PoseActeMedecin.fetchDataList();
        this.$refs.PoseActeMedecin.fetchListSelection();
        this.fetchDataList();

        this.$refs.PoseActeMedecin.$data.titleComponent =
          "Les Actes Posés sur " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }
      //EntetePrelevement
    },
    showEntetePrelevement(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.EntetePrelevement.$data.etatModal = true;
        this.$refs.EntetePrelevement.$data.refDetailCons = refDetailCons;
        this.$refs.EntetePrelevement.$data.svData.refDetailCons = refDetailCons;
        this.$refs.EntetePrelevement.fetchDataList();
        this.$refs.EntetePrelevement.fetchListSelection();
        this.$refs.EntetePrelevement.fetchListSelection1();
        this.fetchDataList();

        this.$refs.EntetePrelevement.$data.titleComponent =
          "Les Prélevements pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showPrescriptionMedicament(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.PrescriptionMedicament.$data.etatModal = true;
        this.$refs.PrescriptionMedicament.$data.refdetailCons = refDetailCons;
        this.$refs.PrescriptionMedicament.$data.svData.refdetailCons = refDetailCons;
        this.$refs.PrescriptionMedicament.fetchDataList();
        this.$refs.PrescriptionMedicament.fetchListSelection();
        this.fetchDataList();

        this.$refs.PrescriptionMedicament.$data.titleComponent =
          "Préscription Medicale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showCreateOrdonance(id, noms) {
      this.svData.userOrdo = this.userData.name;

      this.editOrFetch(`${this.apiBaseURL}/fetch_max_enteteOrdonance_Cons?id=${id}&author=${this.svData.userOrdo}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.refEnteteOrdonance = item.id;
          });
          this.showDetailOrdonance(this.svData.refEnteteOrdonance, noms);
        }
      );


    },
    showDetailOrdonance(refEnteteOrdonance, name) {

      if (refEnteteOrdonance != '') {

        this.$refs.DetailOrdonances.$data.etatModal = true;
        this.$refs.DetailOrdonances.$data.refEnteteOrdonance = refEnteteOrdonance;
        this.$refs.DetailOrdonances.$data.svData.refEnteteOrdonance = refEnteteOrdonance;
        this.$refs.DetailOrdonances.fetchDataList();
        this.$refs.DetailOrdonances.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailOrdonances.$data.titleComponent =
          "Ordonance Médicale Medicale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRapportMedical(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.RapportMedical.$data.etatModal = true;
        this.$refs.RapportMedical.$data.refDetailCons = refDetailCons;
        this.$refs.RapportMedical.$data.svData.refDetailCons = refDetailCons;
        this.$refs.RapportMedical.fetchDataList();
        this.$refs.RapportMedical.fetchListSelection();
        this.fetchDataList();

        this.$refs.RapportMedical.$data.titleComponent =
          "Rapport Medical pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showResumeClinique(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.ResumeClinique.$data.etatModal = true;
        this.$refs.ResumeClinique.$data.refDetailCons = refDetailCons;
        this.$refs.ResumeClinique.$data.svData.refDetailCons = refDetailCons;
        this.$refs.ResumeClinique.fetchDataList();
        this.fetchDataList();

        this.$refs.ResumeClinique.$data.titleComponent =
          "Résumé Clinique pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteOrdonance(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.EnteteOrdonances.$data.etatModal = true;
        this.$refs.EnteteOrdonances.$data.refDetailCons = refDetailCons;
        this.$refs.EnteteOrdonances.$data.svData.refDetailCons = refDetailCons;
        this.$refs.EnteteOrdonances.fetchDataList();
        this.fetchDataList();

        this.$refs.EnteteOrdonances.$data.titleComponent =
          "Ordonance medicale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showHospitalisation(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.Hospitalisation.$data.etatModal = true;
        this.$refs.Hospitalisation.$data.refDetailCons = refDetailCons;
        this.$refs.Hospitalisation.$data.svData.refDetailCons = refDetailCons;
        this.$refs.Hospitalisation.fetchDataList();
        this.$refs.Hospitalisation.fetchListSelection();
        this.$refs.Hospitalisation.fetchListServices();
        this.fetchDataList();

        this.$refs.Hospitalisation.$data.titleComponent =
          "Hospoitalisation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAgendaMedecin() {

      this.$refs.AgendaMedecin.$data.etatModal = true;
      this.$refs.AgendaMedecin.fetchDataList();
      this.$refs.AgendaMedecin.getRouteParam();
      this.fetchDataList();

      this.$refs.AgendaMedecin.$data.titleComponent =
        "Donner de Rendez-vous ";

    },
    showRapportMedicalNeuro(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.RapportMedicalNeuro.$data.etatModal = true;
        this.$refs.RapportMedicalNeuro.$data.refDetailConst = refDetailCons;
        this.$refs.RapportMedicalNeuro.$data.svData.refDetailConst = refDetailCons;
        this.$refs.RapportMedicalNeuro.fetchDataList();
        this.$refs.RapportMedicalNeuro.fetchListSelection();
        this.$refs.RapportMedicalNeuro.fetchListTypeRapport();
        this.fetchDataList();

        this.$refs.RapportMedicalNeuro.$data.titleComponent =
          "Rapport Medical Neuro-Psychiatrie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showConsultationPrenatale(refDetailCons, name) {

      if (refDetailCons != '') {

        this.$refs.EnteteCPN.$data.etatModal = true;
        this.$refs.EnteteCPN.$data.refDetailConst = refDetailCons;
        this.$refs.EnteteCPN.$data.svData.refDetailConst = refDetailCons;
        this.$refs.EnteteCPN.fetchDataList();
        this.fetchDataList();

        this.$refs.EnteteCPN.$data.titleComponent =
          "Consultation près-natale pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }



  },
  filters: {

  }
}
</script>
  
  