<template>
  <div>

    <v-layout>
      <CPNElementRef ref="CPNElementRef" />
      <DetailCPN ref="DetailCPN" />
      <MereCPON ref="MereCPON" />
      <MerePeni ref="MerePeni" />
      <MereSP ref="MereSP" />
      <Rendevous_Mere ref="Rendevous_Mere" />
      <VaccinationMere ref="VaccinationMere" />
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


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        CONSULTATION PRENATALE
                      </v-input>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Rh" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.rh">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Electrophorèse" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.electropherese">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Personne à contacter en d'urgence" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.personne_contact">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Adresse/Tel" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.adresse_personne_ref">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field type="date" label="DDR" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_DDr">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field type="date" label="DPA" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_DPA">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Primipare de 19 ans ou moins" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.primipare"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="35 ans ou plus" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.plus_35"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        ANTECEDENTS
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        1. Médicaux : (cocher)
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="TBC" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.tbc"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="HTA" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.hta"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="SCA/SS" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.sca"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="DBT" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.dbt"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="CAR" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.car"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="MGF" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.mef"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="RAA" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.raa"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="SYPHYLIS" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.syphylis"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="VIH/SIDA" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.vIH_sida"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="VVS" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.vvS"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="PEP" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.pEP"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        2. Gynécologiques et Chirugicaux (cocher)
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Césarienne" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.cesarienne"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Cerciage" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.cerciage"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Fibrome utérin" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.fibrame"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Fracture bassin" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.fature_bassin"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="GEU" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.gEU"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Fistule" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.fistule"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Utérus Cicatriciel" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.uterus_cicotricile"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Traitement pour stérilité" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.traitement_sterilite"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        3. Obstétricaux
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Parité" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.parite">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Gestité" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.gestile">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Enfant en vie" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.EnfantEnvie">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Avortements" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Avortement">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Dystocie" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dystocie">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Eutocie" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.eutocie">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Plus gros poids de naissance (g)" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.plusGrosPoids">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Plus de 4 kg (nbre)" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.plus4kg">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Prématuré" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.premature"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Post-maturé" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.poste_mature"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Mort-né" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.mort_ne"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Mort avant 7 jours" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.mort_avant_7j"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Dernier accouchement date" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.DernierAcouchement">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Intervalle < 2 ans" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.interval2ans"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Complications post-partum (Oui)" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.compl_post_oui"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Complications post-partum (Non)" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation"
                        v-model="svData.complication_post_non"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-text-field label="Si Oui, lesquelles" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Si_oui_lesquelles">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        Eléments de référence de la femme
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Malnutrition sévère oui sans appétit" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.malnutrition"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Goitre" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.goitre"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Conjonctives pales et Hb moins de 7 g %" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.conjoctives7g">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Conjonctives ictériques" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation"
                        v-model="svData.conjoctivesIcterifars"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="TA systolique > 140" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.TA_systolique"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="TA diastolique > 90" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.TA_diastolique1"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="TA diastolique > 90" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.TA_diastolique2"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="et ++ protéunirie" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.proteine"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Fistule réparée" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.fistule"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Discordance HU avec l'age de grossesse" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.discondance"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="BCF nég à partir de 5 mois (20 semaines)" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.BCF"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Mouvements foetaux négatifs à partir de la 36e semaines de grossesse" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.mouvementFoctaux"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Présentation transversale (a partir de la 36e semaines de la grossesse)" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.pres_transversale"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Bassin rétréci" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.bassin_aetreci"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Masse suspecte de sein" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.masse_supecte"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Maladie chronique" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.maladie_chronique">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Drépanocytose" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.drepanocytose"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Autres Raisons" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Autres_raisons">
                      </v-text-field>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_references">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md12 lg12>
                    <div class="mr-1">
                      <v-input :success-messages="['']" success disabled>
                        Mesures préventives
                      </v-input>
                    </div>
                  </v-flex>

                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field type="date" label="Date du début pour CTX" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_du_debutCTX">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="AZT" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.aZT">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="TAR" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.tAR">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="CD4" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.cd4">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Dort sous MII Oui" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.dors_mil_oui"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Si non, donner MII" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.donner_MII"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Supplementation Fer-Acide folique-avant accouchement" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.fer_acide"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Après accouchement" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.apres_Accouchement"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Vermifuge:Mebendazole au 2e trim." :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.vermifuge"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="RPR" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.Rpr"></v-select>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="RPR positif oui" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.rPR_positif_oui"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Résultat du dépistage du cancer du col" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.depistage_cancer">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Dépistage TBC" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.depistage_TBc">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Traiment TBC" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.traitement_TBc">
                      </v-text-field>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Conseils PF" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.conseilsPF"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Méthode de PF choisie" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.methodePFchoisie">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="DCIP : la femme - date conseil" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dCIP">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Code PTME" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.pTME"></v-select>
                    </div>
                  </v-flex>


                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Résultat Test" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.resultat_test1"></v-select>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Date Annonce" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_annonce1">
                      </v-text-field>
                    </div>
                  </v-flex>



                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Partenaire - date conseil" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.partenaire_date1">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Résultats Test" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.resultat_test2"></v-select>
                    </div>
                  </v-flex>




                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-text-field label="Date annonce" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.date_annonce2">
                      </v-text-field>
                    </div>
                  </v-flex>
                  <v-flex xs12 sm12 md6 lg6>
                    <div class="mr-1">
                      <v-select label="Plan d'accouchement discuté" :items="[
                        { designation: 'OUI' },
                        { designation: 'NON' }
                      ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                        item-text="designation" item-value="designation" v-model="svData.plau_accouchement"></v-select>
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
                <!-- <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">
                <span v-bind="attrs" v-on="on">
                  <v-btn @click="dialog = true" fab color="#B72C2C" dark>
                    <v-icon>add</v-icon>
                  </v-btn>
                </span>
              </template>
              <span>Ajouter CPS</span>
            </v-tooltip> -->
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
                        <th class="text-left">Patient</th>
                        <th class="text-left">Sexe</th>
                        <th class="text-left">Age</th>
                        <th class="text-left">Taille/cm</th>
                        <th class="text-left">DDR</th>
                        <th class="text-left">DPA</th>
                        <th class="text-left">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr v-for="item in fetchData" :key="item.id">
                        <td>{{ item.noms }}</td>
                        <td>{{ item.sexe_malade }}</td>
                        <td>{{ item.age_malade }}</td>
                        <td>{{ item.Taille }}</td>
                        <td>{{ item.date_DDr }}</td>
                        <td>{{ item.date_DPA }}</td>
                        <td>


                          <v-menu bottom rounded offset-y transition="scale-transition">
                            <template v-slot:activator="{ on }">
                              <v-btn icon v-on="on" small fab depressed text>
                                <v-icon>more_vert</v-icon>
                              </v-btn>
                            </template>

                            <v-list dense width="">

                              <v-list-item link @click="showRendezvousvaccin(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Voir les Rendez-vous Mère
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showVaccinationMere(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Vaccination Mère
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showDetailPeni(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail Péni Mère
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showDetailCPN(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail CPN
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showMereCPON(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail CPON
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showMereSP(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail SP
                                </v-list-item-title>
                              </v-list-item>

                              <v-list-item link @click="showCPNElementRef(item.id, item.noms)">
                                <v-list-item-icon>
                                  <v-icon color="#B72C2C">description</v-icon>
                                </v-list-item-icon>
                                <v-list-item-title style="margin-left: -20px">Détail Elements de refernces
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
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import CPNElementRef from './CPNElementRef.vue';
import DetailCPN from './DetailCPN.vue';
import MereCPON from './MereCPON.vue';
import MerePeni from './MerePeni.vue';
import MereSP from './MereSP.vue';
import Rendevous_Mere from './Rendevous_Mere.vue';
import VaccinationMere from './VaccinationMere.vue';

export default {
  components: {
    CPNElementRef,
    DetailCPN,
    MereCPON,
    MerePeni,
    MereSP,
    Rendevous_Mere,
    VaccinationMere
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
      refDetailConst: 0,
      svData: {
        id: '',
        refDetailConst: 0,
        rh: '',
        electropherese: '',
        date_debut: '',
        personne_contact: '',
        adresse_personne_ref: '',
        date_DDr: '',
        date_DPA: '',
        primipare: '',
        plus_35: '',
        tbc: '',
        hta: '',
        sca: '',
        dbt: '',
        car: '',
        mef: '',
        raa: '',
        syphylis: '',
        vIH_sida: '',
        vvS: '',
        pEP: '',
        cesarienne: '',
        cerciage: '',
        fibrame: '',
        fature_bassin: '',
        gEU: '',
        fistule: '',
        uterus_cicatrice: '',
        traitement_sterilite: '',
        parite: '',
        gestile: '',
        EnfantEnvie: '',
        Avortement: '',
        dystocie: '',
        eutocie: '',
        plusGrosPoids: '',
        plus4kg: '',
        premature: '',
        poste_mature: '',
        mort_ne: '',
        mort_avant_7j: '',
        DernierAcouchement: '',
        interval2ans: '',
        complication_post_non: '',
        compl_post_oui: '',
        Si_oui_lesquelles: '',
        malnutrition: '',
        goitre: '',
        conjoctives7g: '',
        conjoctivesIcterifars: '',
        TA_systolique: '',
        TA_diastolique1: '',
        TA_diastolique2: '',
        proteine: '',
        festule_reparee: '',
        discondance: '',
        bcf: '',
        mouvementFoctaux: '',
        pres_transversale: '',
        bassin_aetreci: '',
        bassin_limite: '',
        anomalie: '',
        uterus_cicotricile: '',
        masse_supecte: '',
        maladie_chronique: '',
        drepanocytose: '',
        Autres_raisons: '',
        date_references: '',
        date_du_debutCTX: '',
        aZT: '',
        tAR: '',
        cd4: '',
        dors_mil_oui: '',
        donner_MII: '',
        fer_acide: '',
        apres_Accouchement: '',
        vermifuge: '',
        Rpr: '',
        rPR_positif_oui: '',
        depistage_cancer: '',
        depistage_TBc: '',
        traitement_TBc: '',
        conseilsPF: '',
        methodePFchoisie: '',
        dCIP: '',
        pTME: '',
        resultat_test1: '',
        date_annonce1: '',
        partenaire_date1: '',
        resultat_test2: '',
        date_annonce2: '',
        plau_accouchement: '',
        author: ""
      },

      //id,refDetailConst,NomPere,NomMere,ContactPere,ContactMere,dateEntete,numeroEnreg,
      //PoidsNaissance,ZoneSante,AireSante,CentreSante,Estnedomicile,OrphelinMere,
      //OrphelinPere,FrereSoeur,Mere5Enfants,EnfantJumeau,NaissanceRapproche,Mere18ans,ModeAccouchement,
      //Apgar,Nevaripine,Mortne,Mort24h,ComplicationAccouchement,ReanimationEnfant,ComplicatioPostPartum,
      //VitamineMere,FerMere,TailleNaissance,CPON,PF,CPS,TypeAccouchement,AccouchementFOSA,author
      fetchData: [],
      don: [],
      query: "",
        
        inserer:'',
        modifier:'',
        supprimer:'',
        chargement:''

    }
  },
  created() {
     
    this.fetchDataList();
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
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_CPN/${this.svData.id}`,
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
          this.svData.refDetailConst = this.refDetailConst;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_CPN`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_CPN/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refDetailConst = item.refDetailConst;
            this.svData.rh = item.rh;
            this.svData.electropherese = item.electropherese;
            this.svData.date_debut = item.date_debut;
            this.svData.personne_contact = item.personne_contact;
            this.svData.adresse_personne_ref = item.adresse_personne_ref;
            this.svData.date_DDr = item.date_DDr;
            this.svData.date_DPA = item.date_DPA;
            this.svData.primipare = item.primipare;
            this.svData.plus_35 = item.plus_35;
            this.svData.tbc = item.tbc;
            this.svData.hta = item.hta;
            this.svData.sca = item.sca;
            this.svData.dbt = item.dbt;
            this.svData.car = item.car;
            this.svData.mef = item.mef;
            this.svData.raa = item.raa;
            this.svData.syphylis = item.syphylis;
            this.svData.vIH_sida = item.vIH_sida;
            this.svData.vvS = item.vvS;
            this.svData.pEP = item.pEP;
            this.svData.cesarienne = item.cesarienne;
            this.svData.cerciage = item.cerciage;
            this.svData.fibrame = item.fibrame;
            this.svData.fature_bassin = item.fature_bassin;
            this.svData.gEU = item.gEU;
            this.svData.fistule = item.fistule;
            this.svData.uterus_cicatrice = item.uterus_cicatrice;
            this.svData.traitement_sterilite = item.traitement_sterilite;
            this.svData.parite = item.parite;
            this.svData.gestile = item.gestile;
            this.svData.EnfantEnvie = item.EnfantEnvie;
            this.svData.Avortement = item.Avortement;
            this.svData.dystocie = item.dystocie;
            this.svData.eutocie = item.eutocie;
            this.svData.plusGrosPoids = item.plusGrosPoids;
            this.svData.plus4kg = item.plus4kg;
            this.svData.premature = item.premature;
            this.svData.poste_mature = item.poste_mature;
            this.svData.mort_ne = item.mort_ne;
            this.svData.mort_avant_7j = item.mort_avant_7j;
            this.svData.DernierAcouchement = item.DernierAcouchement;
            this.svData.interval2ans = item.interval2ans;
            this.svData.complication_post_non = item.complication_post_non;
            this.svData.compl_post_oui = item.compl_post_oui;
            this.svData.Si_oui_lesquelles = item.Si_oui_lesquelles;
            this.svData.malnutrition = item.malnutrition;
            this.svData.goitre = item.goitre;
            this.svData.conjoctives7g = item.conjoctives7g;
            this.svData.conjoctivesIcterifars = item.conjoctivesIcterifars;
            this.svData.TA_systolique = item.TA_systolique;
            this.svData.TA_diastolique1 = item.TA_diastolique1;
            this.svData.TA_diastolique2 = item.TA_diastolique2;
            this.svData.proteine = item.proteine;
            this.svData.festule_reparee = item.festule_reparee;
            this.svData.discondance = item.discondance;
            this.svData.bcf = item.bcf;
            this.svData.mouvementFoctaux = item.mouvementFoctaux;
            this.svData.pres_transversale = item.pres_transversale;
            this.svData.bassin_aetreci = item.bassin_aetreci;
            this.svData.bassin_limite = item.bassin_limite;
            this.svData.anomalie = item.anomalie;
            this.svData.uterus_cicotricile = item.uterus_cicotricile;
            this.svData.masse_supecte = item.masse_supecte;
            this.svData.maladie_chronique = item.maladie_chronique;
            this.svData.drepanocytose = item.drepanocytose;
            this.svData.Autres_raisons = item.Autres_raisons;
            this.svData.date_references = item.date_references;
            this.svData.date_du_debutCTX = item.date_du_debutCTX;
            this.svData.aZT = item.aZT;
            this.svData.tAR = item.tAR;
            this.svData.cd4 = item.cd4;
            this.svData.dors_mil_oui = item.dors_mil_oui;
            this.svData.donner_MII = item.donner_MII;
            this.svData.fer_acide = item.fer_acide;
            this.svData.apres_Accouchement = item.apres_Accouchement;
            this.svData.vermifuge = item.vermifuge;
            this.svData.Rpr = item.Rpr;
            this.svData.rPR_positif_oui = item.rPR_positif_oui;
            this.svData.depistage_cancer = item.depistage_cancer;
            this.svData.depistage_TBc = item.depistage_TBc;
            this.svData.traitement_TBc = item.traitement_TBc;
            this.svData.conseilsPF = item.conseilsPF;
            this.svData.methodePFchoisie = item.methodePFchoisie;
            this.svData.dCIP = item.dCIP;
            this.svData.pTME = item.pTME;
            this.svData.resultat_test1 = item.resultat_test1;
            this.svData.date_annonce1 = item.date_annonce1;
            this.svData.partenaire_date1 = item.partenaire_date1;
            this.svData.resultat_test2 = item.resultat_test2;
            this.svData.date_annonce2 = item.date_annonce2;
            this.svData.plau_accouchement = item.plau_accouchement;
            this.svData.author = item.author;

          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_CPN/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_CPN?page=`);

    },

    showMereCPON(refCPN, name) {

      if (refCPN != '') {

        this.$refs.MereCPON.$data.etatModal = true;
        this.$refs.MereCPON.$data.refCPN = refCPN;
        this.$refs.MereCPON.$data.svData.refCPN = refCPN;
        this.$refs.MereCPON.fetchDataList();
        this.$refs.MereCPON.fetchListSelection();
        this.fetchDataList();

        this.$refs.MereCPON.$data.titleComponent =
          "CPON pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showRendezvousvaccin(refCPN, name) {

      if (refCPN != '') {

        this.$refs.Rendevous_Mere.$data.etatModal = true;
        this.$refs.Rendevous_Mere.$data.refCPN = refCPN;
        this.$refs.Rendevous_Mere.$data.svData.refCPN = refCPN;
        this.$refs.Rendevous_Mere.fetchDataList();
        this.$refs.Rendevous_Mere.fetchListSelection();
        this.fetchDataList();

        this.$refs.Rendevous_Mere.$data.titleComponent =
          "Rendez-vous Vaccin pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    showVaccinationMere(refCPN, name) {

      if (refCPN != '') {

        this.$refs.VaccinationMere.$data.etatModal = true;
        this.$refs.VaccinationMere.$data.refCPN = refCPN;
        this.$refs.VaccinationMere.$data.svData.refCPN = refCPN;
        this.$refs.VaccinationMere.fetchDataList();
        this.$refs.VaccinationMere.fetchListPeriode();
        this.fetchDataList();

        this.$refs.VaccinationMere.$data.titleComponent =
          "Vaccinination à la CPN pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showDetailCPN(refCPN, name) {

      if (refCPN != '') {

        this.$refs.DetailCPN.$data.etatModal = true;
        this.$refs.DetailCPN.$data.refCPN = refCPN;
        this.$refs.DetailCPN.$data.svData.refCPN = refCPN;
        this.$refs.DetailCPN.fetchDataList();
        this.$refs.DetailCPN.fetchListSelection();
        this.fetchDataList();

        this.$refs.DetailCPN.$data.titleComponent =
          "Detils CPN pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showDetailPeni(refCPN, name) {

      if (refCPN != '') {

        this.$refs.MerePeni.$data.etatModal = true;
        this.$refs.MerePeni.$data.refCPN = refCPN;
        this.$refs.MerePeni.$data.svData.refCPN = refCPN;
        this.$refs.MerePeni.fetchDataList();
        this.$refs.MerePeni.fetchListSelection();
        this.fetchDataList();

        this.$refs.MerePeni.$data.titleComponent =
          "Detail CPN pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showMereSP(refCPN, name) {

      if (refCPN != '') {

        this.$refs.MereSP.$data.etatModal = true;
        this.$refs.MereSP.$data.refCPN = refCPN;
        this.$refs.MereSP.$data.svData.refCPN = refCPN;
        this.$refs.MereSP.fetchDataList();
        this.$refs.MereSP.fetchListSelection();
        this.fetchDataList();

        this.$refs.MereSP.$data.titleComponent =
          "SP pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },

    showCPNElementRef(refCPN, name) {

      if (refCPN != '') {

        this.$refs.CPNElementRef.$data.etatModal = true;
        this.$refs.CPNElementRef.$data.refCPN = refCPN;
        this.$refs.CPNElementRef.$data.svData.refCPN = refCPN;
        this.$refs.CPNElementRef.fetchDataList();
        this.fetchDataList();

        this.$refs.CPNElementRef.$data.titleComponent =
          "Detail sur les Elements de references pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }

  },
  filters: {

  }
}
</script>
  
  