<template>
  <v-row justify="center">
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
                      Surveillance Transfusionnelle <v-spacer></v-spacer>
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
                            <v-text-field type="date" label="Date" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.dateTransfusion"></v-text-field>
                          </div>
                        </v-flex> 

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Demandeur" prepend-inner-icon="mdi-map"
                              :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="id" dense outlined
                              v-model="svData.refMedecin" chips clearable
                              @change="getSpecialiteMedecin(svData.refMedecin)">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-text-field readonly label="Medecin Demandeur" prepend-inner-icon="event" dense
                              outlined v-model="svData.medecinDemandeur">
                          </v-text-field>
                        </div>
                      </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="Specialité Medecin " prepend-inner-icon="event" dense
                              outlined v-model="svData.specialiste">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field readonly label="CNOM" prepend-inner-icon="event" dense
                              outlined v-model="svData.CNOM">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Debut" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.heureDebut"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Fin" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.heureFin"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="N° Poche" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.Nmpoche"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date de Peremption" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.dateperemption"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Nbre" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.nombre"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Réaction transfusionnelle ant." :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.reatianTransttut"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              PRECAUTIONS A PRENDRE AVANT LA TRANSFUSION SANGUINE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              1. Détecter les signes cliniques de la décompensation ou intolérance de l'anémie tels que :
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dyspnée" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.dysphee1"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Exptrémités cyanosées" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.ExtrenateCyanosee"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Tachycardie (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.tachycardie"></v-text-field>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Paleur cutanéo-muqueuse " :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.paleurcutaneo"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Extrémités froides " :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.extremitesfoides"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TA (mm/mg)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TA"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Agitation" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.agitation"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres1"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="2. Indication de la transfusion" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.indicationTransf"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              3. Avant la transfusion sanguine
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hb (g%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.Hb_avant"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hct (%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.hct_avant"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              4. Hb désiré Après la transfusion sanguine
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hb (g%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.Hb_apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hct (%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.hct_apres"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Qté du sang à transfuser (Unité(s))" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.qteSangTransfuse"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-select label="Nature" :items="[
                              { designation: 'Concentré Erythrocytaire' },
                              { designation: 'Sang Total' },
                              { designation: 'Plasma frois congelé' },
                              { designation: 'Concentré Leucocytaire' },
                              { designation: 'Concentré Plaquetaire' },
                              { designation: 'Autres' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.nature"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              4. Hb juste Après la transfusion
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hb transfusion (g%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.hbTransfusion"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hct (%)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.hct_transfusion"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Formule
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Si Sang total : Q = (Hb désiré - Hb du patient)*3*poids du patient
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Avant la pause de la transfusion
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Test de compatibilité ultime au lit du patient
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Campatibilité" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.compatible"></v-select>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Préparer la trousse d'urgences, produits tels
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T°" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.temperatureSurv"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.FRtraitSurv"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FC" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.FCtraitSurv"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T.A" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TAtraitSurv"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres2"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              De 1 à 15 min
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              NB : - Surveillance très rapprochée du patient et du débit                       
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                            - Noter les réactions per transfusionelles telle :
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Rash cutané" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.rashCutane"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Trouble de rythme" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.troubleRythme"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Frisson" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.frisson"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Nausée et Vomissement" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.nausee"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (°C)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.temperature2"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Oedeme larynge" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.oedemelaynge1"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TA (mmmgh)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TA2"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Diarhée" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.diarhee"></v-select>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.pouls_0a15min"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Oedeme larynge" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.oedemelaynge2"></v-select>
                          </div>
                        </v-flex>

                          
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (cycle/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.FR2"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dyspnées" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.dysphee2"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Précordialgie" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.precardialge"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Lombalgie" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.lambelgue"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Douleurs abdominales" :items="[
                              { designation: 'Oui' },
                              { designation: 'Non' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.douleurabdominal"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres3"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              De 15 à 30 min
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T.A (mmgh)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TA_15a30"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.pauls_15a30"></v-text-field>
                          </div>
                        </v-flex>               

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (°C)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.temperature_15a30"></v-text-field>
                          </div>
                        </v-flex>
                      
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (cycle/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.fr_15a30"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres4"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Observation" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.observation1"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              De 30 à 1h
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T.A (mmgh)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.ta_30a1_heure"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.pauls_30a1heure"></v-text-field>
                          </div>
                        </v-flex>               

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (°C)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.tempera_30a1_heure"></v-text-field>
                          </div>
                        </v-flex>
                      
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (cycle/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.fr_30a1heure"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres5"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Observation" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.observation2"></v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              De 1h à 2h
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T.A (mmgh)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TA_1a2h"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.Pouls_1a2h"></v-text-field>
                          </div>
                        </v-flex>               

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (°C)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.Temperature_1a2h"></v-text-field>
                          </div>
                        </v-flex>
                      
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (cycle/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.FR_1a2h"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres_1a2h"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Observation" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.observations_1a2h"></v-textarea>
                          </div>
                        </v-flex>






                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              De 2h à 3h / 3h à 4h
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T.A (mmgh)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.TA_2ha3h"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pouls (batt/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.pauls_2ha3h"></v-text-field>
                          </div>
                        </v-flex>               

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T° (°C)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.temperature_2ha3h"></v-text-field>
                          </div>
                        </v-flex>
                      
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FR (cycle/min)" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.fr_2ha3h"></v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.autres_2ha3h"></v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="OBSERVATION" prepend-inner-icon="extension"
                                outlined dense
                              v-model="svData.observation3"></v-textarea>
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
                        <span>Ajouter Resumé</span>
                      </v-tooltip>
                    </v-flex>
                  </v-layout>
                  <br />
                  <v-card>
                    <!-- ,'ValeurNormale2','heure2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">DateTransf</th>
                              <th class="text-left">HeureDebut</th>
                              <th class="text-left">HeureFin</th>                                                
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateTransfusion }}</td> 
                              <td>{{ item.heureDebut }}</td>
                              <td>{{ item.heureFin }}</td>
                                                                          
                              <td>
                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

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
      refSurvHospi: 0, 

      svData: {
        id: '',       
        refSurvHospi: 0,
        dateTransfusion:"",
        heureDebut:"",
        heureFin:"",
        status:"",
        Nmpoche:"",
        dateperemption:"",
        medecinDemandeur:"",
        nombre:"",
        reatianTransttut:"",
        dysphee1:"",
        ExtrenateCyanosee:"",
        tachycardie:"",
        paleurcutaneo:"",
        extremitesfoides:"",
        TA_transf:"",
        agitation:"",
        autres1:"",
        indicationTransf:"",
        Hb_avant:"",
        hct_avant:"",
        Hb_apres:"",
        hct_apres:"",
        qteSangTransfuse:"",
        nature:"",
        hbTransfusion:"",
        hct_transfusion:"",
        compatible:"",
        temperatureSurv:"",
        FRtraitSurv:"",
        FCtraitSurv:"",
        TAtraitSurv:"",
        autres2:"",
        rashCutane:"",
        frisson:"",
        troubleRythme:"",
        nausee:"",
        temperature2:"",
        TA2:"",
        FR2:"",
        oedemelaynge1:"",
        diarhee:"",
        pouls_0a15min:"",
        oedemelaynge2:"",
        dysphee2:"",
        precardialge:"",
        lambelgue:"",
        douleurabdominal:"",
        TA_15a30:"",
        temperature_15a30:"",
        pauls_15a30:"",
        fr_15a30:"",
        autres3:"",
        observation1:"",
        ta_30a1_heure:"",
        tempera_30a1_heure:"",
        pauls_30a1heure:"",
        fr_30a1heure:"",
        autres4:"",
        observation2:"",
        TA_1a2h:"",
        Pouls_1a2h:"",
        Temperature_1a2h:"",
        FR_1a2h:"",
        autres_1a2h:"",
        observations_1a2h:"",
        TA_2ha3h:"",
        temperature_2ha3h:"",
        pauls_2ha3h:"",
        fr_2ha3h:"",
        observation3:"",
        autres5:"",
        autres_2ha3h:"",
        observationsGenol:"",
        author:"",
        refMedecin:0,
        CNOM: "",
        specialite_medecin: '',
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        medecinList: []
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
          this.svData.refSurvHospi = this.refSurvHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_transfusion_surveil/${this.svData.id}`,
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
          this.svData.refSurvHospi = this.refSurvHospi;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_transfusion_surveil`,
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
    //
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
            this.svData.medecinDemandeur = item.noms_medecin;
            this.svData.specialiste = item.specialite_medecin;
            this.svData.CNOM = item.matricule_medecin;
          });

        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_transfusion_surveil/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refSurvHospi = item.refSurvHospi;
            this.svData.dateTransfusion = item.dateTransfusion;
            this.svData.heureDebut = item.heureDebut;
            this.svData.heureFin = item.heureFin;
            this.svData.status = item.status;
            this.svData.Nmpoche = item.Nmpoche;
            this.svData.dateperemption = item.dateperemption;
            this.svData.medecinDemandeur = item.medecinDemandeur;
            this.svData.nombre = item.nombre;
            this.svData.reatianTransttut = item.reatianTransttut;
            this.svData.dysphee1 = item.dysphee1;
            this.svData.ExtrenateCyanosee = item.ExtrenateCyanosee;
            this.svData.TA_transf = item.TA_transf;
            this.svData.agitation = item.agitation;
            this.svData.autres1 = item.autres1;
            this.svData.indicationTransf = item.indicationTransf;
            this.svData.Hb_avant = item.Hb_avant;
            this.svData.hct_avant = item.hct_avant;
            // this.svData.Hb_apres = item.Hb_apres;
            this.svData.hct_apres = item.hct_apres;
            this.svData.qteSangTransfuse = item.qteSangTransfuse;
            this.svData.nature = item.nature;
            this.svData.hbTransfusion = item.hbTransfusion;
            this.svData.compatible = item.compatible;
            this.svData.temperatureSurv = item.temperatureSurv;
            this.svData.FRtraitSurv = item.FRtraitSurv;
            this.svData.FCtraitSurv = item.FCtraitSurv;
            this.svData.TAtraitSurv = item.TAtraitSurv;
            this.svData.autres2 = item.autres2;
            this.svData.rashCutane = item.rashCutane;
            this.svData.frisson = item.frisson;
            this.svData.troubleRythme = item.troubleRythme;
            this.svData.nausee = item.nausee;
            this.svData.temperature2 = item.temperature2;
            this.svData.TA2 = item.TA2;
            this.svData.FR2 = item.FR2;
            this.svData.oedemelaynge1 = item.oedemelaynge1;
            this.svData.diarhee = item.diarhee;
            this.svData.oedemelaynge2 = item.oedemelaynge2;
            this.svData.dysphee2 = item.dysphee2;
            this.svData.precardialge = item.precardialge;
            this.svData.lambelgue = item.lambelgue;
            this.svData.TA_15a30 = item.TA_15a30;
            this.svData.temperature_15a30 = item.temperature_15a30;
            this.svData.pauls_15a30 = item.pauls_15a30;
            this.svData.fr_15a30 = item.fr_15a30;
            this.svData.autres3 = item.autres3;
            this.svData.observation1 = item.observation1;
            this.svData.ta_30a1_heure = item.ta_30a1_heure;
            this.svData.tempera_30a1_heure = item.tempera_30a1_heure;
            this.svData.pauls_30a1heure = item.pauls_30a1heure;
            this.svData.fr_30a1heure = item.fr_30a1heure;
            this.svData.autres4 = item.autres4;
            this.svData.observation2 = item.observation2;
            this.svData.TA_1a2h= item.TA_1a2h;
            this.svData.Pouls_1a2h= item.Pouls_1a2h;
            this.svData.Temperature_1a2h= item.Temperature_1a2h;
            this.svData.FR_1a2h= item.FR_1a2h;
            this.svData.autres_1a2h= item.autres_1a2h;
            this.svData.observations_1a2h= item.observations_1a2h;
            this.svData.TA_2ha3h = item.TA_2ha3h;
            this.svData.temperature_2ha3h = item.temperature_2ha3h;
            this.svData.pauls_2ha3h = item.pauls_2ha3h;
            this.svData.fr_2ha3h = item.fr_2ha3h;
            this.svData.observation3 = item.observation3;
            this.svData.autres5 = item.autres5;
            this.svData.observationsGenol = item.observationsGenol;

            this.svData.tachycardie = item.tachycardie;
            this.svData.paleurcutaneo = item.paleurcutaneo;
            this.svData.extremitesfoides = item.extremitesfoides;
            this.svData.TA = item.TA;
            this.svData.Hb_apres = item.Hb_apres;
            this.svData.hct_transfusion=item.hct_transfusion;
            this.svData.autres_2ha3h=item.autres_2ha3h;
            this.svData.pouls_0a15min=item.pouls_0a15min;
            this.svData.douleurabdominal=item.douleurabdominal;

            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_transfusion_surveil/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_transfusion_for_surveil/${this.refSurvHospi}?page=`);
      //
    }

  },
  filters: {

  }
}
</script>
  
  