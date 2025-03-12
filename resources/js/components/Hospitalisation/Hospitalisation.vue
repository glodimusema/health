<template>
  

  <v-row justify="center">

        <FeuilleFacturation ref="FeuilleFacturation" />
        <Imageries ref="Imageries" />
        <EnteteLabo ref="EnteteLabo" />

        <EnteteBesoin ref="EnteteBesoin" />
        <EnteteUsage ref="EnteteUsage" />

        <AutresOrientations ref="AutresOrientations" />
        <DiagnosticDef ref="DiagnosticDef" />
        <Kinesitherapie ref="Kinesitherapie" />
        <PoseActeMedecin ref="PoseActeMedecin" />
        <PrescriptionMedicament ref="PrescriptionMedicament" />
        <RapportMedical ref="RapportMedical" />

        <Hospi_ConsultationNeo ref="Hospi_ConsultationNeo" />
        <Hospi_Evolutions ref="Hospi_Evolutions" />
        <SortieHospitalisation ref="SortieHospitalisation" />
        <Hospi_SurveillanceNeo ref="Hospi_SurveillanceNeo" />
        <Hospi_SurveillanceHospi ref="Hospi_SurveillanceHospi" />
        <Hospi_Traitement ref="Hospi_Traitement" />
        <Hospi_BilanHydrique ref="Hospi_BilanHydrique" />
        <Hospi_SurveillancePlaie ref="Hospi_SurveillancePlaie" />
        <Hospi_PoseActeInfirmier ref="Hospi_PoseActeInfirmier" />
        <Hospi_Observations ref="Hospi_Observations" />
        <Hospi_Appreciations ref="Hospi_Appreciations" />


        <EntetePrelevement ref="EntetePrelevement" />
        <ResumeClinique ref="ResumeClinique" />
        <Annexe_Patient ref="Annexe_Patient" />

        

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
            item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refService" chips
            clearable>
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
              
              <v-dialog v-model="dialog" max-width="600px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Hospitalisation <v-spacer></v-spacer>
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

                      <v-text-field type="date" label="Date Entrée" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        v-model="svData.dateEntree"></v-text-field>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Service Hospitalisation" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                            item-text="nom_uniteproduction" item-value="id" dense outlined v-model="svData.refServiceHospi"
                            chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez la Salle" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.SalleList"
                            item-text="nom_salle" item-value="id" dense outlined v-model="svData.refSalle" chips clearable
                            @change="getLit(svData.refSalle)">
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Selectionnez le Lit" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.LitList" item-text="nom_lit"
                            item-value="id" dense outlined v-model="svData.refLit" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Diagnostic d'Entrée" prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnosticEntree">
                          </v-textarea>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea label="Observations" prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.observations">
                          </v-textarea>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-autocomplete label="Service d'Origine" prepend-inner-icon="home"
                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                            item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                            v-model="svData.serviceOrigine" chips clearable>
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-select label="Type Orientation" :items="[
                            { designation: 'HOSPITALISATION' },
                            { designation: 'REANIMATION' }
                          ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                            item-text="designation" item-value="designation" v-model="svData.TypeOrientationHosp"></v-select>
                        </div>
                      </v-flex>

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
                        <span>Ajouter Diagnostics</span>
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
                              <th class="text-left">Action</th>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">DateEntrée</th>
                              <th class="text-left">ServiceOrigine</th>
                              <th class="text-left">Orientions</th>
                              <th class="text-left">Salle</th>
                              <th class="text-left">Lit</th>
                              <th class="text-left">Date</th>                              
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

                                    <v-divider></v-divider>
                                    <v-subheader>Dossier Medical</v-subheader>
                                    <v-divider></v-divider>

                                    <v-list-item link @click="printBill(item.refMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Info Générales
                                        Malade</v-list-item-title>
                                    </v-list-item>
                                    <!-- showResumeClinique -->

                                    <v-list-item link @click="showPrescriptionMedicament(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Prescriptions médicales
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showPoseActeMedecin(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Actes posés
                                      </v-list-item-title>
                                    </v-list-item>
                                        
                                    <v-list-item link @click="showCreatePrelevement(item.refDetailCons, item.noms)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                                    </v-list-item-title>
                                  </v-list-item>

                                  <v-list-item link @click="showEntetePrelevement(item.refDetailCons, item.noms)">
                                    <v-list-item-icon>
                                      <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                    </v-list-item-icon>
                                    <v-list-item-title style="margin-left: -20px">Detail sur les Examens du laboratoire
                                    </v-list-item-title>
                                  </v-list-item>

                                    <v-list-item link @click="showImagerie(item.refDetailCons, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Demander Analyses Imagerie
                                      </v-list-item-title>
                                    </v-list-item> 

                                    <v-list-item link @click="showResumeClinique(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Tour des Salles
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showConsultationNeo(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Consultation Néonatologie
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showEvolutions(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Evolutions Médicales
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showAutresOrientations(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Autres Orientations
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="insertChirurgie(item.refDetailCons, item.dateDetailCons)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Bloc Opératoire</v-list-item-title>
                                    </v-list-item>


                                    <v-list-item link @click="showKinesitherapie(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Kinesitherapie
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showDiagnosticsDef(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-alert</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Diagnostics
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showRapportMedical(item.refDetailCons,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Certification/Attestation
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showSortieHospitalisation(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Sortie Hospitalisation
                                      </v-list-item-title>
                                    </v-list-item>


                                    <v-divider></v-divider>
                                    <v-subheader>Dossier Infirmnier</v-subheader>
                                    <v-divider></v-divider>

                                    <v-list-item link @click="showEnteteBesoin(item.refMouvement, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Faire un Etat de Besoin pour ce Patient
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showEnteteUsage(item.refMouvement, item.noms)">
                                        <v-list-item-icon>
                                          <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                        </v-list-item-icon>
                                        <v-list-item-title style="margin-left: -20px">Fiche de sortie des Produits
                                        </v-list-item-title>
                                      </v-list-item>

                                      <v-list-item link @click="showAnnexe_Patient(item.refMalade, item.noms)">
                                         <v-list-item-icon>
                                             <v-icon color="#B72C2C">edit</v-icon>
                                         </v-list-item-icon>
                                         <v-list-item-title style="margin-left: -20px">Les Docuements en Annxe pour le Patient
                                         </v-list-item-title>
                                     </v-list-item>

                                    <v-list-item link @click="showSurveillanceNeo(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Feuille de Surveillance Néonatologie
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showSurveillanceHospi(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Feuille de Surveillance
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showTraitementHospi(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Feuille de Traitement
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showBilanHydrique(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Bilan Hydrique
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showSurveillancePlaie(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Surveillance Plaie
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showPoseActeInfirmier(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Actes et Soins Infirmier
                                      </v-list-item-title>
                                    </v-list-item>                                      

                                    <v-list-item link @click="showEnteteFacturation(item.refMouvement, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-cards</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Feuille de Facturations
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showObservations(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Observations Infirmiers
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showAppreciations(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Feuille d'aprréciations
                                      </v-list-item-title>
                                    </v-list-item>

                                  </v-list>

                                  
                                </v-menu>

                              </td>
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateEntree | formatDate }}</td>
                              <td>{{ item.serviceOrigine }}</td>
                              <td>{{ item.TypeOrientationHosp }}</td>
                              <td>{{ item.nom_salle }}</td>
                              <td>{{ item.nom_lit }}</td>
                              <td>{{ item.created_at | formatDate }}</td>

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

import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "../AvatarProfil.vue"
import avatarAvatar from '../AvatarAction.vue'
import FeuilleFacturation from '../Finances/FeuilleFacturation.vue';
import Imageries from '../Imageries/Imageries.vue';
import EnteteLabo from '../Laboratoire/EnteteLabo.vue';

import AutresOrientations from '../Consultations/AutresOrientations.vue';
import DiagnosticDef from '../Consultations/DiagnosticDef.vue';
import Kinesitherapie from '../Consultations/Kinesitherapie.vue';
import PoseActeMedecin from '../Consultations/PoseActeMedecin.vue';
import PrescriptionMedicament from '../Consultations/PrescriptionMedicament.vue';
import RapportMedical from '../Consultations/RapportMedical.vue';

import Hospi_ConsultationNeo from './Hospi_ConsultationNeo.vue';
import Hospi_Evolutions from './Hospi_Evolutions.vue';
import SortieHospitalisation from './SortieHospitalisation.vue';
import Hospi_SurveillanceNeo from './Hospi_SurveillanceNeo.vue';
import Hospi_SurveillanceHospi from './Hospi_SurveillanceHospi.vue';
import Hospi_Traitement from './Hospi_Traitement.vue';
import Hospi_BilanHydrique from './Hospi_BilanHydrique.vue';
import Hospi_SurveillancePlaie from './Hospi_SurveillancePlaie.vue';
import Hospi_PoseActeInfirmier from './Hospi_PoseActeInfirmier.vue';
import Hospi_Observations from './Hospi_Observations.vue';
import Hospi_Appreciations from './Hospi_Appreciations.vue';

import EntetePrelevement from '../Laboratoire/EntetePrelevement.vue';
import EnteteBesoin from "../Pharmacies/EnteteBesoin.vue";
import EnteteUsage from "../Pharmacies/EnteteUsage.vue";
import ResumeClinique from "../Consultations/ResumeClinique.vue";
import Annexe_Patient from "../Consultations/Annexe_Patient.vue";





export default {
  components: {
    AvatarProfil,
    avatarAvatar,
    FeuilleFacturation,
    Imageries,
    EnteteLabo,
    Annexe_Patient,

    AutresOrientations,
    DiagnosticDef,
    Kinesitherapie,
    PoseActeMedecin,
    PrescriptionMedicament,
    RapportMedical,

    Hospi_ConsultationNeo,
    Hospi_Evolutions,
    SortieHospitalisation,
    Hospi_SurveillanceNeo,
    Hospi_SurveillanceHospi,
    Hospi_Traitement,
    Hospi_BilanHydrique,
    Hospi_SurveillancePlaie,
    Hospi_PoseActeInfirmier,
    Hospi_Observations,
    Hospi_Appreciations,
    EntetePrelevement,
    EnteteBesoin,
    EnteteUsage,
    ResumeClinique
  },
  data() {
    return {
      //,'refServiceHospi','serviceOrigine'
      // //'id','refSalle','refLit','refDetailCons','dateEntree','diagnosticEntree','observations','dateHospi','author'
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refDetailCons: 0, 
      dialog2: false,
      serviceProvenance:"",
      svData: {
        id: '',
        refDetailCons: 0,
        refSalle: 0,
        refLit: 0,
        dateEntree: "",
        diagnosticEntree: "",
        observations: "",
        author: "",
        refServiceHospi: 0,
        serviceOrigine: "",
        TypeOrientationHosp: "",

        dateeneteop:"",

        refService:0,
        numroRecu:"",        
        noms:"",
        author:""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        ServiceList: [],
        SalleList: [],
        LitList: [],
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:''

    }
  },
  created() {
     
    // this.fetchDataList();
    // this.fetchListSelection();
    // this.fetchListServices();
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_hospitalisation/${this.svData.id}`,
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
          this.svData.refDetailCons = this.refDetailCons;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_hospitalisation`,
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_dossier_medical_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_hospitalisation/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailCons = item.refDetailCons;
            this.svData.refSalle = item.refSalle;
            this.svData.refLit = item.refLit;
            this.svData.dateEntree = item.dateEntree;
            this.svData.diagnosticEntree = item.diagnosticEntree;
            this.svData.observations = item.observations;
            this.svData.refServiceHospi = item.refServiceHospi;
            this.svData.serviceOrigine = item.serviceOrigine;
          });
          this.getLit(this.svData.refSalle);
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_hospitalisation/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_hospitalisation_cons/${this.refDetailCons}?page=`);

    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_salle_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.SalleList = donnees;

        }
      );
    },
    getLit(refSalle) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_lit_Salle2/${refSalle}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.LitList = donnees;

        }
      );
    },
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
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

// PARTIE DES COMPOSANTS===================================================================   



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
    showConsultationNeo(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_ConsultationNeo.$data.etatModal = true;
          this.$refs.Hospi_ConsultationNeo.$data.refHospi = refHospi;
          this.$refs.Hospi_ConsultationNeo.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_ConsultationNeo.fetchDataList();
          this.$refs.Hospi_ConsultationNeo.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_ConsultationNeo.$data.titleComponent =
            "Consultation Neonatoligie pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showEvolutions(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_Evolutions.$data.etatModal = true;
          this.$refs.Hospi_Evolutions.$data.refHospi = refHospi;
          this.$refs.Hospi_Evolutions.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_Evolutions.fetchDataList();
          // this.$refs.Hospi_Evolutions.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_Evolutions.$data.titleComponent =
            "Evolution en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showSortieHospitalisation(refHospi, name) {

        if (refHospi != '') {

          this.$refs.SortieHospitalisation.$data.etatModal = true;
          this.$refs.SortieHospitalisation.$data.refHospitaliser = refHospi;
          this.$refs.SortieHospitalisation.$data.svData.refHospitaliser = refHospi;
          this.$refs.SortieHospitalisation.fetchDataList();
          // this.$refs.SortieHospitalisation.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.SortieHospitalisation.$data.titleComponent =
            "Sortie en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showSurveillanceNeo(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_SurveillanceNeo.$data.etatModal = true;
          this.$refs.Hospi_SurveillanceNeo.$data.refHospi = refHospi;
          this.$refs.Hospi_SurveillanceNeo.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_SurveillanceNeo.fetchDataList();
          this.$refs.Hospi_SurveillanceNeo.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveillanceNeo.$data.titleComponent =
            "Surveillence Neonatologie pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showSurveillanceHospi(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_SurveillanceHospi.$data.etatModal = true;
          this.$refs.Hospi_SurveillanceHospi.$data.refHospi = refHospi;
          this.$refs.Hospi_SurveillanceHospi.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_SurveillanceHospi.fetchDataList();
          this.$refs.Hospi_SurveillanceHospi.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveillanceNeo.$data.titleComponent =
            "Surveillence Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showTraitementHospi(refHospi, name) {

      if (refHospi != '') {

        this.$refs.Hospi_Traitement.$data.etatModal = true;
        this.$refs.Hospi_Traitement.$data.refHospi = refHospi;
        this.$refs.Hospi_Traitement.$data.svData.refHospi = refHospi;
        this.$refs.Hospi_Traitement.fetchDataList();
        this.$refs.Hospi_Traitement.showDataMedcin(refMouvement)
        this.fetchDataList();

        this.$refs.Hospi_Traitement.$data.titleComponent =
          "Traitement en Hospitalisation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showBilanHydrique(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_BilanHydrique.$data.etatModal = true;
          this.$refs.Hospi_BilanHydrique.$data.refHospi = refHospi;
          this.$refs.Hospi_BilanHydrique.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_BilanHydrique.fetchDataList();
          // this.$refs.Hospi_BilanHydrique.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_BilanHydrique.$data.titleComponent =
            "Bilan hydrique pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showSurveillancePlaie(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_SurveillancePlaie.$data.etatModal = true;
          this.$refs.Hospi_SurveillancePlaie.$data.refHospi = refHospi;
          this.$refs.Hospi_SurveillancePlaie.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_SurveillancePlaie.fetchDataList();
          this.$refs.Hospi_SurveillancePlaie.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_SurveillancePlaie.$data.titleComponent =
            "Surveillance de Plaie pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showPoseActeInfirmier(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_PoseActeInfirmier.$data.etatModal = true;
          this.$refs.Hospi_PoseActeInfirmier.$data.refHospi = refHospi;
          this.$refs.Hospi_PoseActeInfirmier.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_PoseActeInfirmier.fetchDataList();
          this.$refs.Hospi_PoseActeInfirmier.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_PoseActeInfirmier.$data.titleComponent =
            "Les Actes de l'Infirmier pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showObservations(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_Observations.$data.etatModal = true;
          this.$refs.Hospi_Observations.$data.refHospi = refHospi;
          this.$refs.Hospi_Observations.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_Observations.fetchDataList();
          // this.$refs.Hospi_Observations.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_Observations.$data.titleComponent =
            "Observation en Hospitalisation pour " + name;

        } else {
          this.showError("Personne n'a fait cette action");
        }

    },
    showAppreciations(refHospi, name) {

        if (refHospi != '') {

          this.$refs.Hospi_Appreciations.$data.etatModal = true;
          this.$refs.Hospi_Appreciations.$data.refHospi = refHospi;
          this.$refs.Hospi_Appreciations.$data.svData.refHospi = refHospi;
          this.$refs.Hospi_Appreciations.fetchDataList();
          // this.$refs.Hospi_Appreciations.fetchListSelection();
          this.fetchDataList();
          
          this.$refs.Hospi_Appreciations.$data.titleComponent =
            "Appreciations en Hospitalisation pour " + name;

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
          "Evolution Medicale pour " + name;

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
    showCreatePrelevement(id,noms)
    {
      this.dialog2=true;
      this.svData.id=id;
      this.svData.noms=noms;
      this.svData.author=this.userData.name;
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
    validate_preleve() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
            this.svData.author=this.userData.name;
            
            //serviceProvenance
            this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_prelevement_Cons?id=${this.svData.id}&author=${this.svData.author}&refService=${this.svData.refService}`).then(
            ({ data }) => {
                var donnees = data.data;
                donnees.map((item) => {
                this.svData.refEntetePrelevement = item.id;
                this.serviceProvenance = item.nom_uniteproduction;
                });
                this.showLaboratoire(this.svData.refEntetePrelevement, this.svData.noms,this.serviceProvenance);
                this.dialog2=false;
                this.isLoading(false);
            }
            ); 
            
        }
    },
    showAnnexe_Patient(refPatient, name) {

            if (refPatient != '') {

                this.$refs.Annexe_Patient.$data.etatModal = true;
                this.$refs.Annexe_Patient.$data.refPatient = refPatient;
                this.$refs.Annexe_Patient.$data.svData.refPatient = refPatient;
                this.$refs.Annexe_Patient.fetchDataList();

                this.$refs.Annexe_Patient.$data.titleComponents =
                    "Les Annexes pour  " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },
     showLaboratoire(refEntetePrelevement, name,serviceProvenance) {

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
    showEnteteBesoin(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteBesoin.$data.etatModal = true;
        this.$refs.EnteteBesoin.$data.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteBesoin.fetchDataList();
        this.$refs.EnteteBesoin.fetchListService();
        this.$refs.EnteteBesoin.fetchListSalle();
        this.fetchDataList();
 
        this.$refs.EnteteBesoin.$data.titleComponent =
          "Fiche d'Etat de Besoin pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showEnteteUsage(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteUsage.$data.etatModal = true;
        this.$refs.EnteteUsage.$data.refMouvement = refMouvement;
        this.$refs.EnteteUsage.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteUsage.fetchDataList();
        this.$refs.EnteteUsage.fetchListService();
        this.$refs.EnteteUsage.fetchListSalle();

        this.$refs.EnteteUsage.$data.titleComponent =
          "Fiche d'Utilisation pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }




  },
  filters: {

  }
}
</script>

