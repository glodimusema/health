<template>
 

  <v-row justify="center">

    <EnteteSurveillanceOpe ref="EnteteSurveillanceOpe" />
    <AffectationTypeAnesthesie ref="AffectationTypeAnesthesie" />

    <!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

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
              <v-dialog v-model="dialog" max-width="1000px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Consultation Pre-Anesthesique <v-spacer></v-spacer>
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
                            <v-text-field type="date" label="Date" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateAnesthesie">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.stataData.ServiceList"
                              item-text="nom_uniteproduction" item-value="nom_uniteproduction" dense outlined
                              v-model="svData.serviceAnestesie" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>




                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Diagnostic Pré-Operatoire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnosticpreop">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Intervention Envisagée" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.interventionEnvisagee">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date prévue" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.datePrevue">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Programme" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.programme">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Urgence" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.urgence">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Reprise" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.reprise">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              II. ANTECEDENTS
                            </v-input>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="A. Chirurgie antérieur" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.chirurgieAnterieur">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="B. Anesthésie antérieur" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.anesthesieAnterieur">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Protocole" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.protocole">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Complications" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.complication">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="C. Pathologie Anterieur" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pathologieAnterieur">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Cardiopathe" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.cardiophatie"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Hypertension" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.hypertension"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Diabète" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.diabete"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Epileprie" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.epilepsie"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Asthme" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.asthme"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Allergie" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.alllergie"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dentisterie " :items="[
                              { designation: 'Extration dentaire' },
                              { designation: 'Prothese dentaire' },
                              { designation: 'Autres' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.denstisterie"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Tromato-orthopidi" :items="[
                              { designation: 'Plaque vicé' },
                              { designation: 'Cloud Satro-medilaire' },
                              { designation: 'Autres' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.tromato_orthopedi"></v-select>
                          </div>
                        </v-flex>
                        

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Chirugie Cardiopathe" :items="[
                              { designation: 'Peace maker' },
                              { designation: 'Valve metallique' },
                              { designation: 'Autres' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.chirurgie_cardiaque"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Detail sur l'allergie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.allergie_chirurgie">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Tabac" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.tabac"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Transfusion" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.transfusion"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Alcool" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.alcool"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Systèmes :
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Nerveux" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nerveux">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Rénal" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.renal">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <!-- Cardio-circ -->
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Cardio-circ" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cardio_circ">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Foie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.foie">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Pulmonaire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.pulmonaire">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autresysteme">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="DDR" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ddr">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="G" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.G_autres">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="P" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.P_autres">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="A" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.A_autres">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="D" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.D_autres">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Médicament/Drogues en cours" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.medicament_drogue">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              III. EXAMEN CLINIQUE
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Etat Général" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.etatgeneral">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Conscience" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conscience">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Force musculaire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.forcemusculaire">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Bouche" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.bouche">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mallampatie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.mallampatie">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Conjonctive" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conjonctive">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Rhume" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.rhume">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Toux" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.taux">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Respiration" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.respiration">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Choc de pointe" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.choc_de_pointe">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Expectoration" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.expectoration">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Auscultation" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.auscultation">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Poumon" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.poumon">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Coeurs" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.coeurs">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Abdomen" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.abdomen">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Dos" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dos">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Membres" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.membres">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Signes vitaux
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TA" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TA_Anest">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fréquence cardiaque" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FC_Anest">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Fréquence respiraoire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FR_Anest">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Autres" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.AutresSigneVitaux">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              V. EXAMENS PARACLINIQUES
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Hb" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.HB">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="GS" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.GS">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Rh" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.RH">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Ht" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.HT">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TS" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TS">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="TC" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TC">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Plaquette" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Plaquette">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="HIV" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.HIV">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              FL :
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="N" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FLN">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="L" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FLL">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="M" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FLM">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="E" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FLE">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="B" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FLB">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="GB" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.GB">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="GR" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.GR">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Biochimie :
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Urée" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Uree">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Créat" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Creat">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SGOT" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.SGOT">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SGPT" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.SGPT">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Lono" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Lono">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Glycémie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Glycemie">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T3" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.T3">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="T4" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.T4">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Albumines" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Albimines">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Emmel" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Emmel">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="SAO2" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.SAO2">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="RX" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.RX">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="ECG" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ECG">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Echo cardiaque" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.EhoCardiaque">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              RISQUE ASA :
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Patient" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Patient">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez Chirugie" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.Chirurgie" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez Anesthesie " prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.Anesthesie" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              VI. RECOMMANDATION PREOPERATOIRE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Jeune" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Jeune"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Rasage" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Rasage"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Lavement" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Lavement"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Autres (à préciser)" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.AutresCommandations"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Autres Recommandations" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.LibelleAutresCommandation">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              VII. PROTOCOLE ANESTHESIQUE ENVISAGE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Chirugien" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.Chirurgien" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Anesthesiste " prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.listeMedecin" item-text="noms_medecin"
                              item-value="noms_medecin" dense outlined v-model="svData.Anesthesiste" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              INFORMATION ET CONSENTEMENT ECLAIRE POUR CHIRURGIE ET ANESTHESIE
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Je sousigné Mme, Mlle, Mr " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.sousigne">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Signature " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSousigne">
                            </v-text-field>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Nom du Patient " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.nomPatient">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Temoins " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.temoins">
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
                        outlined rounded hide-ddialogetails v-model="query" @keyup="fetchDataList" clearable></v-text-field>
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
                        <span>Ajouter Chirurgie</span>
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
                              <th class="text-left">Malade</th>
                              <th class="text-left">Sexe</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Date</th>
                              <th class="text-left">Chrirurgie</th>
                              <th class="text-left">Anesthesiste</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.dateAnesthesie }}</td>
                              <td>{{ item.Chirurgien }}</td>
                              <td>{{ item.Anesthesiste }}</td>
                              <td>


                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon>more_vert</v-icon>
                                    </v-btn>
                                  </template>
                                 

                                  <v-list dense width="">

                                    <v-list-item link @click="showEnteteSurveillanceOpe(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-invert-colors</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Surveillance Salle de réveil
                                      </v-list-item-title>
                                    </v-list-item>

                                    <!-- <v-list-item link @click="showAffectationTypeAnesthesie(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-invert-colors</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Types d'Anesthesie Utilisés
                                      </v-list-item-title>
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
import AffectationTypeAnesthesie from './AffectationTypeAnesthesie.vue';
import EnteteSurveillanceOpe from './EnteteSurveillanceOpe.vue';

//<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

export default {
  components: {
    EnteteSurveillanceOpe,
    AffectationTypeAnesthesie
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
      refEnteteOpe: 0, 

      svData: {
        id: '',
        refEnteteOpe: 0,
        dateAnesthesie: "",
        diagnosticpreop: "",
        interventionEnvisagee: "",
        datePrevue: "",
        programme: "",
        urgence: "",
        reprise: "",
        chirurgieAnterieur: "",
        anesthesieAnterieur: "",
        protocole: "",
        complication: "",
        pathologieAnterieur: "",
        nerveux: "",
        renal: "",
        cardio_circ: "",
        pulmonaire: "",
        foie: "",
        denstisterie:"",
        tromato_orthopedi:"",
        chirurgie_cardiaque:"",
        allergie_chirurgie:"",
        autresysteme:"",
        respiration:"",
        choc_de_pointe:"",
        expectoration:"",
        auscultation:"",
        autresysteme: "",
        ddr: "",
        G_autres: "",
        P_autres: "",
        A_autres: "",
        D_autres: "",
        cardiophatie: "",
        diabete: "",
        asthme: "",
        tabac: "",
        alcool: "",
        hypertension: "",
        epilepsie: "",
        alllergie: "",
        transfusion: "",
        medicament_drogue: "",
        etatgeneral: "",
        conscience: "",
        forcemusculaire: "",
        bouche: "",
        mallampatie: "",
        conjonctive: "",
        rhume: "",
        taux: "",
        respiration: "",
        choc_de_pointe: "",
        expectoration: "",
        auscultation: "",
        poumon: "",
        coeurs: "",
        abdomen: "",
        dos: "",
        membres: "",
        TA_Anest: "",
        FC_Anest: "",
        FR_Anest: "",
        AutresSigneVitaux: "",
        HB: "",
        GS: "",
        RH: "",
        HT: "",
        TS: "",
        TC: "",
        Plaquette: "",
        HIV: "",
        FLN: "",
        FLL: "",
        FLM: "",
        FLE: "",
        FLB: "",
        GB: "",
        GR: "",
        Uree: "",
        Creat: "",
        SGOT: "",
        SGPT: "",
        Lono: "",
        Glycemie: "",
        T3: "",
        T4: "",
        Albimines: "",
        Emmel: "",
        SAO2: "",
        RX: "",
        ECG: "",
        EhoCardiaque: "",
        Patient: "",
        Anesthesie: "",
        Chirurgie: "",
        Jeune: "",
        Rasage: "",
        Lavement: "",
        AutresCommandations: "",
        LibelleAutresCommandation: "",
        Anesthesiste: "",
        Chirurgien: "",
        sousigne: "",
        dateSousigne: "",
        temoins: "",
        nomPatient: "",
        serviceAnestesie: "",
        author: ""
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        listeMedecin: [],
        ServiceList: []
      },
      
      inserer:'',
      modifier:'',
      supprimer:'',
      chargement:'',

    }
  },
  created() {
    // this.fetchDataList();
    // this.fetchListmedecin();
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
          this.svData.refEnteteOpe = this.refEnteteOpe;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_enteteanesthesie/${this.svData.id}`,
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
          this.svData.refEnteteOpe = this.refEnteteOpe;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_enteteanesthesie`,
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_enteteanesthesie/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteOpe = this.$route.params.id,
              this.svData.dateAnesthesie = item.dateAnesthesie;
            this.svData.diagnosticpreop = item.diagnosticpreop;
            this.svData.interventionEnvisagee = item.interventionEnvisagee;
            this.svData.datePrevue = item.datePrevue;
            this.svData.programme = item.programme;
            this.svData.urgence = item.urgence;
            this.svData.reprise = item.reprise;
            this.svData.chirurgieAnterieur = item.chirurgieAnterieur;
            this.svData.anesthesieAnterieur = item.anesthesieAnterieur;
            this.svData.protocole = item.protocole;
            this.svData.complication = item.complication;
            this.svData.pathologieAnterieur = item.pathologieAnterieur;
            this.svData.nerveux = item.nerveux;
            this.svData.renal = item.renal;
            this.svData.cardio_circ = item.cardio_circ;
            this.svData.pulmonaire = item.pulmonaire;
            this.svData.foie = item.foie;
            this.svData.denstisterie=item.denstisterie;
            this.svData.tromato_orthopedi=item.tromato_orthopedi;
            this.svData.chirurgie_cardiaque=item.chirurgie_cardiaque;
            this.svData.allergie_chirurgie=item.allergie_chirurgie;
            this.svData.respiration= item.respiration;
            this.svData.choc_de_pointe= item.choc_de_pointe;
            this.svData.expectoration= item.expectoration;
            this.svData.auscultation= item.auscultation;
            this.svData.autresysteme = item.autresysteme;
            this.svData.ddr = item.ddr;
            this.svData.G_autres = item.G_autres;
            this.svData.P_autres = item.P_autres;
            this.svData.A_autres = item.A_autres;
            this.svData.D_autres = item.D_autres;
            this.svData.cardiophatie = item.cardiophatie;
            this.svData.diabete = item.diabete;
            this.svData.asthme = item.asthme;
            this.svData.tabac = item.tabac;
            this.svData.alcool = item.alcool;
            this.svData.hypertension = item.hypertension;
            this.svData.epilepsie = item.epilepsie;
            this.svData.alllergie = item.alllergie;
            this.svData.transfusion = item.transfusion;
            this.svData.medicament_drogue = item.medicament_drogue;
            this.svData.etatgeneral = item.etatgeneral;
            this.svData.conscience = item.conscience;
            this.svData.forcemusculaire = item.forcemusculaire;
            this.svData.bouche = item.bouche;
            this.svData.mallampatie = item.mallampatie;
            this.svData.conjonctive = item.conjonctive;
            this.svData.rhume = item.rhume;
            this.svData.taux = item.taux;
            this.svData.respiration = item.respiration;
            this.svData.choc_de_pointe = item.choc_de_pointe;
            this.svData.expectoration = item.expectoration;
            this.svData.auscultation = item.auscultation;
            this.svData.poumon = item.poumon;
            this.svData.coeurs = item.coeurs;
            this.svData.abdomen = item.abdomen;
            this.svData.dos = item.dos;
            this.svData.membres = item.membres;
            this.svData.TA_Anest = item.TA;
            this.svData.FC_Anest = item.FC;
            this.svData.FR_Anest = item.FR;
            this.svData.AutresSigneVitaux = item.AutresSigneVitaux;
            this.svData.HB = item.HB;
            this.svData.GS = item.GS;
            this.svData.RH = item.RH;
            this.svData.HT = item.HT;
            this.svData.TS = item.TS;
            this.svData.TC = item.TC;
            this.svData.Plaquette = item.Plaquette;
            this.svData.HIV = item.HIV;
            this.svData.FLN = item.FLN;
            this.svData.FLL = item.FLL;
            this.svData.FLM = item.FLM;
            this.svData.FLE = item.FLE;
            this.svData.FLB = item.FLB;
            this.svData.GB = item.GB;
            this.svData.GR = item.GR;
            this.svData.Uree = item.Uree;
            this.svData.Creat = item.Creat;
            this.svData.SGOT = item.SGOT;
            this.svData.SGPT = item.SGPT;
            this.svData.Lono = item.Lono;
            this.svData.Glycemie = item.Glycemie;
            this.svData.T3 = item.T3;
            this.svData.T4 = item.T4;
            this.svData.Albimines = item.Albimines;
            this.svData.Emmel = item.Emmel;
            this.svData.SAO2 = item.SAO2;
            this.svData.RX = item.RX;
            this.svData.ECG = item.ECG;
            this.svData.EhoCardiaque = item.EhoCardiaque;
            this.svData.Patient = item.Patient;
            this.svData.Anesthesie = item.Anesthesie;
            this.svData.Chirurgie = item.Chirurgie;
            this.svData.Jeune = item.Jeune;
            this.svData.Rasage = item.Rasage;
            this.svData.Lavement = item.Lavement;
            this.svData.AutresCommandations = item.AutresCommandations;
            this.svData.LibelleAutresCommandation = item.LibelleAutresCommandation;
            this.svData.Anesthesiste = item.Anesthesiste;
            this.svData.Chirurgien = item.Chirurgien;
            this.svData.sousigne = item.sousigne;
            this.svData.dateSousigne = item.dateSousigne;
            this.svData.temoins = item.temoins;
            this.svData.nomPatient = item.nomPatient;
            this.svData.serviceAnestesie = item.serviceAnestesie;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_enteteanesthesie/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_anesthesie_enteteoperation/${this.refEnteteOpe}?page=`);

    },

    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.listeMedecin = donnees;
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
    showEnteteSurveillanceOpe(refAnesthesie, name) {

      //<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

      if (refAnesthesie != '') {

        this.$refs.EnteteSurveillanceOpe.$data.etatModal = true;
        this.$refs.EnteteSurveillanceOpe.$data.refAnesthesie = refAnesthesie;
        this.$refs.EnteteSurveillanceOpe.$data.svData.refAnesthesie = refAnesthesie;
        this.$refs.EnteteSurveillanceOpe.fetchDataList();
        this.$refs.EnteteSurveillanceOpe.fetchListmedecin();
        this.$refs.EnteteSurveillanceOpe.fetchListServices();       
        this.fetchDataList();
        
        this.$refs.EnteteSurveillanceOpe.$data.titleComponent =
          "Surveillance en Chirurgie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showAffectationTypeAnesthesie(refAnesthesie, name) {

      //<!-- EnteteSurveillanceOpe  AffectationTypeAnesthesie -->

      if (refAnesthesie != '') {

        this.$refs.AffectationTypeAnesthesie.$data.etatModal = true;
        this.$refs.AffectationTypeAnesthesie.$data.refAnesthesie = refAnesthesie;
        this.$refs.AffectationTypeAnesthesie.$data.svData.refAnesthesie = refAnesthesie;
        this.$refs.AffectationTypeAnesthesie.fetchDataList();
        this.$refs.AffectationTypeAnesthesie.fetchListSelection();    
        this.fetchDataList();
        
        this.$refs.AffectationTypeAnesthesie.$data.titleComponent =
          "Affectation Anesthesie pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }


  },
  filters: {

  }
}
</script>

