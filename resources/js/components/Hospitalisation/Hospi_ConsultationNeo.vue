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
              <v-dialog v-model="dialog" max-width="1200px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Consultation Neonatologie <v-spacer></v-spacer>
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


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              IDENTITE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Accouchement" prepend-inner-icon="event" dense
                                outlined v-model="svData.dateAcouchement">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Nom mère" prepend-inner-icon="event" dense
                                outlined v-model="svData.nomMere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Accouchement" prepend-inner-icon="event" dense
                                outlined v-model="svData.heureAcouchemnt">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Nom père" prepend-inner-icon="event" dense
                                outlined v-model="svData.nomPere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Transfert" prepend-inner-icon="event" dense
                                outlined v-model="svData.dateTransfert">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Adresse" prepend-inner-icon="event" dense
                                outlined v-model="svData.adresse">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Transfert" prepend-inner-icon="event" dense
                                outlined v-model="svData.heureTransfert">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Téléphone" prepend-inner-icon="event" dense
                                outlined v-model="svData.telephone">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Admission" prepend-inner-icon="event" dense
                                outlined v-model="svData.dateAdmission">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Admnission" prepend-inner-icon="event" dense
                                outlined v-model="svData.heureAdmission">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              MOTIF D'APPEL
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Motif d'appel" prepend-inner-icon="event" dense
                                outlined v-model="svData.motifAppel">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              MERE
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Age" prepend-inner-icon="event" dense
                                outlined v-model="svData.ageMere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Avortement" prepend-inner-icon="event" dense
                                outlined v-model="svData.avortement">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids" prepend-inner-icon="event" dense
                                outlined v-model="svData.poidsMere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Décès" prepend-inner-icon="event" dense
                                outlined v-model="svData.deces">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Taille" prepend-inner-icon="event" dense
                                outlined v-model="svData.tailleMere">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Transfert" prepend-inner-icon="event" dense
                                outlined v-model="svData.dateTransfert2">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Gastrite" prepend-inner-icon="event" dense
                                outlined v-model="svData.gastrite">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Groupe Sanguin *" :items="[
                              { designation: 'O+' },
                              { designation: 'A+' },
                              { designation: 'B+' },
                              { designation: 'AB+' },
                              { designation: 'O-' },
                              { designation: 'A-' },
                              { designation: 'B-' },
                              { designation: 'AB-' }
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.groupeSanguin"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Parité" prepend-inner-icon="event" dense
                                outlined v-model="svData.partie">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Antecédent" prepend-inner-icon="event" dense
                                outlined v-model="svData.antecedante">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              GROSSESSE
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Serologie
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="DDR" prepend-inner-icon="event" dense
                                outlined v-model="svData.DDR">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="VIH" prepend-inner-icon="event" dense
                                outlined v-model="svData.vih">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="DPA" prepend-inner-icon="event" dense
                                outlined v-model="svData.DRA">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="AgHbs" prepend-inner-icon="event" dense
                                outlined v-model="svData.agHbs">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="FIV" prepend-inner-icon="event" dense
                                outlined v-model="svData.fiv">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hepatite C" prepend-inner-icon="event" dense
                                outlined v-model="svData.hepatheC">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Nbre CPN" prepend-inner-icon="event" dense
                                outlined v-model="svData.nbrCPN">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Syphilis" prepend-inner-icon="event" dense
                                outlined v-model="svData.syphilis">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Acide Folique" prepend-inner-icon="event" dense
                                outlined v-model="svData.acideFolique">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Toxo" prepend-inner-icon="event" dense
                                outlined v-model="svData.toxo">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="VAT" prepend-inner-icon="event" dense
                                outlined v-model="svData.VAT">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Rubeole" prepend-inner-icon="event" dense
                                outlined v-model="svData.rubeole">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="DPA" prepend-inner-icon="event" dense
                                outlined v-model="svData.DPA">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="event" dense
                                outlined v-model="svData.autresNEO">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SP" prepend-inner-icon="event" dense
                                outlined v-model="svData.SP">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mebendazole" prepend-inner-icon="event" dense
                                outlined v-model="svData.mebesdazole">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Pathologie pdt la grossesse
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="HTA" prepend-inner-icon="event" dense
                                outlined v-model="svData.HTA">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Diabète" prepend-inner-icon="event" dense
                                outlined v-model="svData.diabet">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Obestie" prepend-inner-icon="event" dense
                                outlined v-model="svData.obesite">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Notion d'infection urogénital dans les 2 semaines " :items="[
                              { designation: '+' },
                              { designation: '-' }                      
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.urogenital"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Paludisme" prepend-inner-icon="event" dense
                                outlined v-model="svData.paludisme">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Toxemie" prepend-inner-icon="event" dense
                                outlined v-model="svData.toxenule">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="event" dense
                                outlined v-model="svData.autres">
                            </v-text-field>
                          </div>
                        </v-flex>

              
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Echographie
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Nombre Echo" prepend-inner-icon="event" dense
                                outlined v-model="svData.nbrECHO">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Protocole" prepend-inner-icon="event" dense
                                outlined v-model="svData.protocole">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1"> 
                            <v-textarea label="DPA selon Echo" prepend-inner-icon="event" dense
                                outlined v-model="svData.DPASebuecho">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Traitement" prepend-inner-icon="event" dense
                                outlined v-model="svData.traitemesvats">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              ACCOUCHEMENT
                            </v-input>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Naissance" prepend-inner-icon="event" dense
                                outlined v-model="svData.datenaissance">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Heure Naissance" prepend-inner-icon="event" dense
                                outlined v-model="svData.Hnaissance">
                            </v-text-field>
                          </div>
                        </v-flex>


                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="RPM" prepend-inner-icon="event" dense
                                outlined v-model="svData.RPM">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Si fièvre resultat" prepend-inner-icon="event" dense
                                outlined v-model="svData.sifievreResultat">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Terme selon DDR" prepend-inner-icon="event" dense
                                outlined v-model="svData.termeSeonDDR">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Notion de fièvre péri partale" prepend-inner-icon="event" dense
                                outlined v-model="svData.notionFievre">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Terme selon Echo" prepend-inner-icon="event" dense
                                outlined v-model="svData.termeSeonEcho">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Terme selon Score" prepend-inner-icon="event" dense
                                outlined v-model="svData.termeSeionScore">
                            </v-textarea>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Aspect du LA" :items="[
                              { designation: 'Clair' },
                              { designation: 'Teinte' },
                              { designation: 'Meconail' },
                              { designation: 'Autres' }                      
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.aspestDuLA"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="event" dense
                                outlined v-model="svData.autresAccouchement">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Durée du travail" prepend-inner-icon="event" dense
                                outlined v-model="svData.dureeTravail">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Présentation" prepend-inner-icon="event" dense
                                outlined v-model="svData.presentation">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Mode d'accouchement" :items="[
                              { designation: '+' },
                              { designation: '-' }                     
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.modeAcouchement"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="T° Maternelle" prepend-inner-icon="event" dense
                                outlined v-model="svData.tempsMaternel">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Peridurale" prepend-inner-icon="event" dense
                                outlined v-model="svData.peridurable">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Corticotherapie antenatale" :items="[
                              { designation: 'Betamethasone' },
                              { designation: 'Dexamethasone' }                     
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.carticotherapie"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Cesarienne Indication" prepend-inner-icon="event" dense
                                outlined v-model="svData.cesarieneIndicat">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Medicaments recus" prepend-inner-icon="event" dense
                                outlined v-model="svData.MedicamentRecus">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Présence Pediatre" prepend-inner-icon="event" dense
                                outlined v-model="svData.presencePediatre">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Sulfate de Mg" prepend-inner-icon="event" dense
                                outlined v-model="svData.surfaceMg">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Ralisé à" prepend-inner-icon="event" dense
                                outlined v-model="svData.RealiserPar">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="APGAR M1" prepend-inner-icon="event" dense
                                outlined v-model="svData.apgarm1">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                        <div class="mr-1">
                          <v-autocomplete label="Par Dr" prepend-inner-icon="mdi-map"
                              :items="stataData.medecinList" item-text="noms_medecin"
                            item-value="noms_medecin" dense outlined v-model="svData.parDr" chips clearable
                            >
                          </v-autocomplete>
                        </div>
                      </v-flex>

                      <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="APGAR M5" prepend-inner-icon="event" dense
                                outlined v-model="svData.apgarm5">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Sexe" :items="[
                              { designation: 'M' },
                              { designation: 'F' }                     
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.sexe"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="APGAR M10" prepend-inner-icon="event" dense
                                outlined v-model="svData.apgarm10">
                            </v-text-field>
                          </div>
                        </v-flex>


                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids" prepend-inner-icon="event" dense
                                outlined v-model="svData.poids">
                            </v-text-field>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Cri M1" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                     
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.criM1"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Taille" prepend-inner-icon="event" dense
                                outlined v-model="svData.taille_2">
                            </v-text-field>
                          </div>
                        </v-flex>

                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Cri M5" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }                     
                            ]" prepend-inner-icon="extension"
                                outlined dense item-text="designation"
                              item-value="designation" v-model="svData.criM5"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="PC" prepend-inner-icon="event" dense
                                outlined v-model="svData.pc">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Reanimation neonatale" prepend-inner-icon="event" dense
                                outlined v-model="svData.reanimationNeo">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="PT" prepend-inner-icon="event" dense
                                outlined v-model="svData.pt">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Durée" prepend-inner-icon="event" dense
                                outlined v-model="svData.duree">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="SaO2" prepend-inner-icon="event" dense
                                outlined v-model="svData.saOxygeneNeo">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Glycémie" prepend-inner-icon="event" dense
                                outlined v-model="svData.glicemie">
                            </v-text-field>
                          </div>
                        </v-flex>






                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Cyanose" prepend-inner-icon="event" dense
                                outlined v-model="svData.cyanose">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Abdomen" prepend-inner-icon="event" dense
                                outlined v-model="svData.abdoman">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fc" prepend-inner-icon="event" dense
                                outlined v-model="svData.Fc_2">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Organes Génitaux externes" prepend-inner-icon="event" dense
                                outlined v-model="svData.organes_genitaux">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fr" prepend-inner-icon="event" dense
                                outlined v-model="svData.frNeo">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Membres" prepend-inner-icon="event" dense
                                outlined v-model="svData.membres">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T°" prepend-inner-icon="event" dense
                                outlined v-model="svData.tempeNeo">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Ailleurs" prepend-inner-icon="event" dense
                                outlined v-model="svData.ailleurs">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TRC" prepend-inner-icon="event" dense
                                outlined v-model="svData.trcNeo">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Examen Neurologique" prepend-inner-icon="event" dense
                                outlined v-model="svData.examenNerologique">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Conjonctives bulbaires" prepend-inner-icon="event" dense
                                outlined v-model="svData.conjonctivebaion">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Coeur et Poumons" prepend-inner-icon="event" dense
                                outlined v-model="svData.coeurPoumon">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="BAN" prepend-inner-icon="event" dense
                                outlined v-model="svData.ban">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TIC" prepend-inner-icon="event" dense
                                outlined v-model="svData.tic">
                            </v-text-field>
                          </div>
                        </v-flex>


                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TSC" prepend-inner-icon="event" dense
                                outlined v-model="svData.tsc">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Enfoncement xiphoide" prepend-inner-icon="event" dense
                                outlined v-model="svData.enfance">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Balancement thoraco-abd" prepend-inner-icon="event" dense
                                outlined v-model="svData.balenceMautxiphoide">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Score de Sylveman" prepend-inner-icon="event" dense
                                outlined v-model="svData.scareSylverman">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Comportement
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Vigilsnce" prepend-inner-icon="event" dense
                                outlined v-model="svData.vigilance">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Cri" prepend-inner-icon="event" dense
                                outlined v-model="svData.criNeo">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Motilite Spontané" prepend-inner-icon="event" dense
                                outlined v-model="svData.matiliste_spautaue">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Relativité" prepend-inner-icon="event" dense
                                outlined v-model="svData.relativite">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Tonus
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Reflexes
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Attitude" prepend-inner-icon="event" dense
                                outlined v-model="svData.attitude">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SD" prepend-inner-icon="event" dense
                                outlined v-model="svData.sd">
                            </v-text-field>
                          </div>
                        </v-flex>




                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Echarpe" prepend-inner-icon="event" dense
                                outlined v-model="svData.echarpe">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Moro" prepend-inner-icon="event" dense
                                outlined v-model="svData.maro">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Talon, Oreillée" prepend-inner-icon="event" dense
                                outlined v-model="svData.talonOreilles">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Grasping" prepend-inner-icon="event" dense
                                outlined v-model="svData.grosping">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Actif" prepend-inner-icon="event" dense
                                outlined v-model="svData.actif">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              CONCLUSION
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Conclusion" prepend-inner-icon="event" dense
                                outlined v-model="svData.conclusionNeo">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              CONDUITE A TENIR
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Conduite à tenir " prepend-inner-icon="event" dense
                                outlined v-model="svData.conclusionTenarNeo">
                            </v-textarea>
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
                    <!-- ,'ValeurNormale2','assistantMedical2' -->
                    <v-card-text>
                      <v-simple-table>
                        <template v-slot:default>
                          <thead>
                            <tr>
                              <th class="text-left">Patient</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">NomMère</th>
                              <th class="text-left">NomPère</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.nomMere }}</td>
                              <td>{{ item.nomPere }}</td>
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
      //
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,
      etatModal: false,
      titleComponent: '',
      refHospi: 0, 
      svData: {
        id: '',
        refHospi: 0,
        nomPere: "",
        nomMere: "",
        adresse: "",
        telephone: "",
        dateAcouchement: "",
        heureAcouchemnt: "",
        dateTransfert: "",
        heureTransfert: "",
        dateAdmission: "",
        heureAdmission: "",
        motifAppel: "",
        ageMere: "",
        poidsMere: "",
        tailleMere: "",
        gastrite: "",
        partie: "",
        avortement: "",
        deces: "",
        dateTransfert2: "",
        gestite: "OK",
        groupeSanguin: "",
        antecedante: "",
        DDR: "",
        DRA: "",
        nbrCPN: "",
        fiv: "",
        VAT: "",
        DPA: "",
        SP: "",
        acideFolique: "",
        vih: "",
        agHbs: "",
        hepatheC: "",
        syphilis: "",
        toxo: "",
        rubeole: "",
        mebesdazole: "",
        autres: "",
        HTA: "",
        diabet: "",
        obesite: "",
        urogenital: "",
        paludisme: "",
        toxenule: "",
        nbrECHO: "",
        protocole: "",
        DPASebuecho: "",
        traitemesvats: "",
        datenaissance: "",
        Hnaissance: "",
        termeSeonDDR: "",
        termeSeonEcho: "",
        termeSeionScore: "",
        RPM: "",
        notionFievre: "",
        sifievreResultat: "",
        aspestDuLA: "",
        autresNEO: "",
        autresAccouchement:"",
        dureeTravail: "",
        presentation: "",
        modeAcouchement: "",
        peridurable: "",
        cesarieneIndicat: "",
        tempsMaternel: "",
        carticotherapie: "",
        surfaceMg: "",
        MedicamentRecus: "",
        presencePediatre: "",
        RealiserPar: "",
        parDr: "",
        sexe: "",
        poids: "",
        taille_2:0,
        pc: "",
        pt: "",
        saOxygeneNeo: "",
        glicemie: "",
        apgarm1: "",
        apgarm5: "",
        apgarm10: "",
        criM1: "",
        criM5: "",
        reanimationNeo: "",
        duree: "",
        cyanose: "",
        abdoman: "",
        frNeo: "",
        tempeNeo: "",
        trcNeo: "",
        conjonctivebaion: "",
        membres: "",
        examenNerologique: "",
        Fc_2:0, 
        organes_genitaux:"", 
        ailleurs:"",
        coeurPoumon: "",
        ban: "",
        tic: "",
        tsc: "",
        enfance: "",
        balenceMautxiphoide: "",
        scareSylverman: "",
        vigilance: "",
        attitude: "",
        sd: "",
        criNeo: "",
        echarpe: "",
        maro: "",
        matiliste_spautaue: "",
        talonOreilles: "",
        grosping: "",
        relativite: "",
        actif: "",
        conclusionNeo: "",
        conclusionTenarNeo: "",
        auther: "",
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
          this.svData.refHospi = this.refHospi;
          this.svData.auther = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_consult_neo/${this.svData.id}`,
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
          this.svData.refHospi = this.refHospi;
          this.svData.auther = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_consult_neo`,
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

    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_consult_neo/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refHospi = item.refHospi;
            this.svData.nomPere = item.nomPere;
            this.svData.nomMere = item.nomMere;
            this.svData.adresse = item.adresse;
            this.svData.telephone = item.telephone;
            this.svData.dateAcouchement = item.dateAcouchement;
            this.svData.heureAcouchemnt = item.heureAcouchemnt;
            this.svData.dateTransfert = item.dateTransfert;
            this.svData.heureTransfert = item.heureTransfert;
            this.svData.dateAdmission = item.dateAdmission;
            this.svData.heureAdmission = item.heureAdmission;
            this.svData.motifAppel = item.motifAppel;
            this.svData.ageMere = item.ageMere;
            
            this.svData.tailleMere = item.tailleMere;            
            this.svData.partie = item.partie;
            this.svData.avortement = item.avortement;
            this.svData.deces = item.deces;
            this.svData.dateTransfert2 = item.dateTransfert2;
            this.svData.groupeSanguin = item.groupeSanguin;
            this.svData.antecedante = item.antecedante;
            this.svData.DDR = item.DDR;
            this.svData.DRA = item.DRA;
            this.svData.nbrCPN = item.nbrCPN;
            this.svData.fiv = item.fiv;
            this.svData.VAT = item.VAT;
            this.svData.DPA = item.DPA;
            this.svData.SP = item.SP;
            this.svData.acideFolique = item.acideFolique;
            this.svData.vih = item.vih;
            this.svData.agHbs = item.agHbs;
            this.svData.hepatheC = item.hepatheC;
            this.svData.syphilis = item.syphilis;
            this.svData.toxo = item.toxo;
            this.svData.rubeole = item.rubeole;
            this.svData.mebesdazole = item.mebesdazole;
            this.svData.autres = item.autres;
            this.svData.HTA = item.HTA;
            this.svData.diabet = item.diabet;
            this.svData.urogenital = item.urogenital;
            this.svData.paludisme = item.paludisme;
            this.svData.toxenule = item.toxenule;
            this.svData.nbrECHO = item.nbrECHO;
            this.svData.protocole = item.protocole;
            this.svData.DPASebuecho = item.DPASebuecho;
            this.svData.traitemesvats = item.traitemesvats;            
            this.svData.Hnaissance = item.Hnaissance;
            this.svData.termeSeonDDR = item.termeSeonDDR;
            this.svData.termeSeonEcho = item.termeSeonEcho;
            this.svData.termeSeionScore = item.termeSeionScore;
            this.svData.RPM = item.RPM;
            this.svData.notionFievre = item.notionFievre;
            this.svData.sifievreResultat = item.sifievreResultat;
            this.svData.aspestDuLA = item.aspestDuLA;
            this.svData.autresNEO = item.autresNEO;
            this.svData.dureeTravail = item.dureeTravail;
            this.svData.presentation = item.presentation;
            this.svData.modeAcouchement = item.modeAcouchement;
            this.svData.peridurable = item.peridurable;
            this.svData.cesarieneIndicat = item.cesarieneIndicat;
            this.svData.tempsMaternel = item.tempsMaternel;
            this.svData.carticotherapie = item.carticotherapie;
            this.svData.surfaceMg = item.surfaceMg;
            this.svData.MedicamentRecus = item.MedicamentRecus;
            this.svData.presencePediatre = item.presencePediatre;
            this.svData.RealiserPar = item.RealiserPar;
            this.svData.parDr = item.parDr;
            this.svData.sexe = item.sexe;
            
            this.svData.pc = item.pc;
            this.svData.pt = item.pt;
            this.svData.saOxygeneNeo = item.saOxygeneNeo;
            this.svData.glicemie = item.glicemie;
            this.svData.apgarm1 = item.apgarm1;
            this.svData.apgarm5 = item.apgarm5;
            this.svData.apgarm10 = item.apgarm10;
            this.svData.criM1 = item.criM1;
            this.svData.criM5 = item.criM5;
            this.svData.reanimationNeo = item.reanimationNeo;
            this.svData.duree = item.duree;
            this.svData.cyanose = item.cyanose;
            this.svData.abdoman = item.abdoman;
            this.svData.frNeo = item.frNeo;
            this.svData.tempeNeo = item.tempeNeo;
            this.svData.trcNeo = item.trcNeo;
            this.svData.conjonctivebaion = item.conjonctivebaion;
            this.svData.membres = item.membres;
            this.svData.examenNerologique = item.examenNerologique;
            this.svData.coeurPoumon = item.coeurPoumon;
            this.svData.ban = item.ban;
            this.svData.tic = item.tic;
            this.svData.tsc = item.tsc;
            this.svData.enfance = item.enfance;
            this.svData.balenceMautxiphoide = item.balenceMautxiphoide;
            this.svData.scareSylverman = item.scareSylverman;
            this.svData.vigilance = item.vigilance;
            this.svData.attitude = item.attitude;
            this.svData.sd = item.sd;
            this.svData.criNeo = item.criNeo;
            this.svData.echarpe = item.echarpe;
            this.svData.maro = item.maro;
            this.svData.matiliste_spautaue = item.matiliste_spautaue;
            this.svData.talonOreilles = item.talonOreilles;
            this.svData.grosping = item.grosping;
            this.svData.relativite = item.relativite;
            this.svData.actif = item.actif;
            this.svData.conclusionNeo = item.conclusionNeo;
            this.svData.conclusionTenarNeo = item.conclusionTenarNeo;
            this.svData.auther = item.auther;


            this.svData.gastrite = item.gastrite;
            this.svData.obesite = item.obesite;
            this.svData.datenaissance = item.datenaissanceNeo;

            this.svData.autresAccouchement = item.autresAccouchement;
            this.svData.poids = item.poids_neo;
            this.svData.taille_2 = item.taille_2;

            this.svData.poidsMere = item.poidsMere;
            this.svData.criM5 = item.criM5;


            this.svData.Fc_2 = item.Fc_2;
            this.svData.organes_genitaux = item.organes_genitaux;
            this.svData.ailleurs = item.ailleurs;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_consult_neo/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_consult_neo_for_Hospi/${this.refHospi}?page=`);
      //
    }
    //

  },
  filters: {

  }
}
</script>
  
  