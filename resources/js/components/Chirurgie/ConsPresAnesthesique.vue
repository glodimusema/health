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


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-text-field label="Type d'intervention" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TypeIntervension">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Diagnostic pré-opératoire" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.diagnostic_preoperatoire">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Examens Cliniques
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Antécédents
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Antécédent" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.antecedents_cpa">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Signes fonctionnels et examens physiques
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Système repiratoire
                            </v-input>
                          </div>
                        </v-flex>   
                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Rhume" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.rhume"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dyspnée" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.dyspnee_1"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Toux" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Toux"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="SpO2" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.spo2_1"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Craches" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.crachats"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Examen des poumons" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Examen_Poumons">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Système Cardio-vasculaire
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Palputations" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Palpitations"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dyspnée" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.dyspnee_2"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Dyspnée" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.dyspnee_3"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="SpO2" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.spo2_2"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Précodialgies" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Precodialgies"></v-select>
                          </div>
                        </v-flex>
                      
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Examen du Coeur" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ExamenduCoeur">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Système Digestif
                            </v-input>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Nausées" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Nausees"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Epigastralgie" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Epigastralgie"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Vomissements" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Vomissements"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Pyrosis" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Pyrasis"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Diarrhées" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Diarrhees"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Ulcére G-D" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.UlceresGD"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Anamnèse Hemostatique" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Anamnèse">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Reins et Metabolisme
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Diurèse" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Diures">
                            </v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Autres1">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Système nerveux" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Systeme_nerveux">
                            </v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Autres2">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Traitements en cours" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TraitementEncours">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Intubation
                            </v-input>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Malformations maxillo-Faciales" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Malformations"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Prothèse dentaire" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Prothese"></v-select>
                          </div>
                        </v-flex>


                        
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Obesité" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Obesite"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Estomac plein" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Estomac_plein"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Ouverture Buccale" :items="[
                              { designation: '>=35mm' },
                              { designation: '<35mm' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Ouverture_Bucale"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Distance Thyro-mentonier" :items="[
                              { designation: '>=6cm' },
                              { designation: '<6cm' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Distance_thyro"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field label="Mobilité cervicale" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Mobilite_cervicale">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Lips Test" :items="[
                              { designation: 'OUI' },
                              { designation: 'NON' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Lips_Test"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Mallampati" :items="[
                              { designation: '1' },
                              { designation: '2' },
                              { designation: '3' },
                              { designation: '4' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Mallampatie"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Prédiction de l'intubation" :items="[
                              { designation: 'facile' },
                              { designation: '+/- facile' },
                              { designation: 'difficile' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Prediction_intubation"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Consultations" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Consculsion_CPA">
                            </v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Protocole anesthesique
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Prémedication" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Premedication">
                            </v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Type d'anesthésie" :items="[
                              { designation: 'Générale' },
                              { designation: 'Rachi' },
                              { designation: 'Bloc' },
                              { designation: 'Local' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              item-text="designation" item-value="designation" v-model="svData.Typeanesthesie"></v-select>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Autres type Anesthésie" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.AutresTypeAnesthesie">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Protocole d'analgesie post operatoire
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Protocole" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Protocole_CPA">
                            </v-textarea>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-input :success-messages="['']" success disabled>
                              Consentement eclairé
                            </v-input>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-textarea label="Consentement eclairé" prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.ConsentementEclaire">
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
                              <th class="text-left">Anesthesie</th>
                              <th class="text-left">Intervension</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.noms }}</td>
                              <td>{{ item.sexe_malade }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.created_at }}</td>
                              <td>{{ item.Typeanesthesie }}</td>
                              <td>{{ item.TypeIntervension }}</td>
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

                                    <v-list-item link @click="showAffectationTypeAnesthesie(item.id,item.noms)">
                                      <v-list-item-icon>
                                        <v-icon>mdi-invert-colors</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Types d'Anesthesie Utilisés
                                      </v-list-item-title>
                                    </v-list-item>

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

    // id,refEnteteOperation,TypeIntervension,diagnostic_preoperatoire,antecedents_cpa,rhume,dyspnee_1,
        // Toux,spo2_1,crachats,Examen_Poumons,Palpitations,dyspnee_2,dyspnee_3,spo2_2,Precodialgies,ExamenduCoeur,
        // Nausees,Epigastralgie,Vomissements,Pyrasis,Diarrhees,UlceresGD,Diures,Autres1,Systeme_nerveux,Autres2,
        // TraitementEncours,Malformations,Prothese,Obesite,Estomac_plein,Ouverture_Bucale,Distance_thyro,
        // Mobilite_cervicale,Lips_Test,Mallampatie,Prediction_intubation,Consculsion_CPA,Premedication,
        // Typeanesthesie,AutresTypeAnesthesie,Protocole_CPA,ConsentementEclaire,
        // author
    return {
      title: "Liste des Details",
      dialog: false,
      edit: false,
      loading: false,
      disabled: false,

      etatModal: false,
      titleComponent: '',
      refEnteteOperation: 0, 

      svData: {
        id: '',
        refEnteteOperation: 0,
        TypeIntervension: "",
        diagnostic_preoperatoire:"",
        antecedents_cpa:"",
        rhume:"",
        dyspnee_1:"",
        Toux:"",
        spo2_1:"",
        crachats:"",
        Examen_Poumons:"",
        Palpitations:"",
        dyspnee_2:"",
        dyspnee_3:"",
        spo2_2:"",
        Precodialgies:"",
        ExamenduCoeur:"",
        Nausees:"",
        Epigastralgie:"",
        Vomissements:"",
        Pyrasis:"",
        Diarrhees:"",
        UlceresGD:"",
        Diures:"",
        Autres1:"",
        Systeme_nerveux:"",
        Autres2:"",
        TraitementEncours:"",
        Malformations:"",
        Prothese:"",
        Obesite:"",
        Estomac_plein:"",
        Ouverture_Bucale:"",
        Distance_thyro:"",
        Mobilite_cervicale:"",
        Lips_Test:"",
        Mallampatie:"",
        Prediction_intubation:"",
        Consculsion_CPA:"",
        Premedication:"",
        Typeanesthesie:"",
        AutresTypeAnesthesie:"",
        Protocole_CPA:"",
        ConsentementEclaire:"",
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
          this.svData.refEnteteOperation = this.refEnteteOperation;
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
          this.svData.refEnteteOperation = this.refEnteteOperation;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_cons_preanesthesique`,
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

    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamen_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_cons_preanesthesique/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refEnteteOperation = this.$route.params.refEnteteOperation;
            this.svData.TypeIntervension= this.$route.params.TypeIntervension;
            this.svData.diagnostic_preoperatoire= this.$route.params.diagnostic_preoperatoire;
            this.svData.antecedents_cpa= this.$route.params.antecedents_cpa;
            this.svData.rhume= this.$route.params.rhume;
            this.svData.dyspnee_1= this.$route.params.dyspnee_1;
            this.svData.Toux= this.$route.params.Toux;
            this.svData.spo2_1= this.$route.params.spo2_1;
            this.svData.crachats= this.$route.params.crachats;
            this.svData.Examen_Poumons= this.$route.params.Examen_Poumons;
            this.svData.Palpitations= this.$route.params.Palpitations;
            this.svData.dyspnee_2= this.$route.params.dyspnee_2;
            this.svData.dyspnee_3= this.$route.params.dyspnee_3;
            this.svData.spo2_2= this.$route.params.spo2_2;
            this.svData.Precodialgies= this.$route.params.Precodialgies;
            this.svData.ExamenduCoeur= this.$route.params.ExamenduCoeur;
            this.svData.Nausees= this.$route.params.Nausees;
            this.svData.Epigastralgie= this.$route.params.Epigastralgie;
            this.svData.Vomissements= this.$route.params.Vomissements;
            this.svData.Pyrasis= this.$route.params.Pyrasis;
            this.svData.Diarrhees= this.$route.params.Diarrhees;
            this.svData.UlceresGD= this.$route.params.UlceresGD;
            this.svData.Diures= this.$route.params.Diures;
            this.svData.Autres1= this.$route.params.Autres1;
            this.svData.Systeme_nerveux= this.$route.params.Systeme_nerveux;
            this.svData.Autres2= this.$route.params.Autres2;
            this.svData.TraitementEncours= this.$route.params.TraitementEncours;
            this.svData.Malformations= this.$route.params.Malformations;
            this.svData.Prothese= this.$route.params.Prothese;
            this.svData.Obesite= this.$route.params.Obesite;
            this.svData.Estomac_plein= this.$route.params.Estomac_plein;
            this.svData.Ouverture_Bucale= this.$route.params.Ouverture_Bucale;
            this.svData.Distance_thyro= this.$route.params.Distance_thyro;
            this.svData.Mobilite_cervicale= this.$route.params.Mobilite_cervicale;
            this.svData.Lips_Test= this.$route.params.Lips_Test;
            this.svData.Mallampatie= this.$route.params.Mallampatie;
            this.svData.Prediction_intubation= this.$route.params.Prediction_intubation;
            this.svData.Consculsion_CPA= this.$route.params.Consculsion_CPA;
            this.svData.Premedication= this.$route.params.Premedication;
            this.svData.Typeanesthesie= this.$route.params.Typeanesthesie;
            this.svData.AutresTypeAnesthesie= this.$route.params.AutresTypeAnesthesie;
            this.svData.Protocole_CPA= this.$route.params.Protocole_CPA;
            this.svData.ConsentementEclaire= this.$route.params.ConsentementEclaire;
            this.svData.author = item.author;
          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_cons_preanesthesique/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_cons_preanesthesique_enteteoperation/${this.refEnteteOperation}?page=`);

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
        this.$refs.AffectationTypeAnesthesie.$data.refEnteteAnesthesie = refAnesthesie;
        this.$refs.AffectationTypeAnesthesie.$data.svData.refEnteteAnesthesie = refAnesthesie;
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

