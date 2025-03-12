<template>
  <v-row justify="center">



    <v-dialog v-model="etat" persistent max-width="1500px">
      <v-card>
        <!-- EnteteLaboExt -->

        <v-card-title class="red">
          {{ titleComponent }} <v-spacer></v-spacer>
          <v-btn depressed text small fab @click="etat = false">
            <v-icon>close</v-icon>
          </v-btn>
        </v-card-title>
        <v-card-text>
          <!-- layout -->

          <v-layout>

            <v-flex md12>
              <!-- PaiementFacture -->

              <ImageriesExt ref="ImageriesExt" />
              <Imageries ref="Imageries" />
              <EnteteLaboExt ref="EnteteLaboExt" />
              <EnteteLabo ref="EnteteLabo" />
              <EnteteCPS ref="EnteteCPS" />
              <PaiementFacture ref="PaiementFacture" />
              <AptitudePhysique ref="AptitudePhysique" />

              <!-- modal -->
              <v-dialog v-model="dialog" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Création Episode Maladie <v-spacer></v-spacer>
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
                      <v-autocomplete label="Selectionnez le Type de Mouvement" prepend-inner-icon="mdi-map"
                        :rules="[(v) => !!v || 'Ce champ est requis']" :items="typemouvementtList"
                        item-text="Typemouvement" item-value="id" dense outlined v-model="svData.refTypeMouvement" chips
                        clearable>
                      </v-autocomplete>

                      <!-- <v-text-field readonly label="Catégorie Maladie" prepend-inner-icon="extension" dense outlined
                        v-model="svData.categoriemaladiemvt"></v-text-field> -->

                      <!-- <v-text-field readonly label="Organisation" prepend-inner-icon="extension" dense outlined
                        v-model="svData.organisationAbonne"></v-text-field> -->

                      <v-text-field readonly label="N° Carte pour Abonné" prepend-inner-icon="extension" dense outlined
                        v-model="svData.numCartemvt"></v-text-field>

                      <!-- <v-text-field readonly label="Taux de Prise ne Charge (%)" prepend-inner-icon="extension" dense
                        outlined v-model="svData.taux_prisecharge"></v-text-field> -->

                      <!-- <v-text-field readonly type="number" label="Pourcentage Conventionnel (Abonné)"
                        prepend-inner-icon="extension" dense outlined
                        v-model="svData.pourcentageConvention"></v-text-field> -->

                      <!-- <v-text-field readonly type="number" label="Nombre de jour de Consultation (Abonné)"
                        prepend-inner-icon="extension" dense outlined v-model="svData.nmbreJourConsMvt"></v-text-field> -->

                      <v-text-field label="N° Bon (Abonné)" prepend-inner-icon="extension" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.numroBon"></v-text-field>

                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog = false">
                        Fermer
                      </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>
              <!-- modal -->

              <!-- <br /><br /> -->

              <v-dialog v-model="dialog3" max-width="500px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Envoyer au Laboratoire pour les Analyses <v-spacer></v-spacer>
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

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Type de Consultation" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeConsList" item-text="designation"
                              item-value="id" dense outlined v-model="svData.refTypeCons" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                      </v-layout>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog3 = false"> Fermer </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate_preleve">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>

              <!-- <br /><br /> -->

              <v-dialog v-model="dialog4" max-width="500px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Effectuer le Paiement de la Consultation <v-spacer></v-spacer>
                      <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog4 = false" text fab depressed>
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
                            <v-autocomplete label="Selectionnez Departement" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.DepartementList"
                              item-text="nom_departement" item-value="id" dense outlined v-model="svData.refDepartement"
                              clearable chips @change="Get_unite_for_Departement(svData.refDepartement)">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Service" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.UniteList"
                              item-text="nom_uniteproduction" item-value="id" dense outlined
                              v-model="svData.refUniteProduction" clearable chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin"
                              clearable chips>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Type de Produit" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeproduitList"
                              item-text="nom_typeproduit" item-value="id" dense outlined v-model="svData.refTypeProduit"
                              clearable chips @change="get_produit_for_typeproduit(svData.refTypeProduit, 'Privé(e)')">
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Produit" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="produitList" item-text="nom_produit"
                              item-value="id" dense outlined v-model="svData.refProduit" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>

                        <!-- <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Mode de Paiement" prepend-inner-icon="home"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.ModeList"
                              item-text="designation" item-value="designation" dense outlined v-model="svData.modepaie"
                              chips clearable @change="get_Banque(svData.modepaie)">
                            </v-autocomplete>
                          </div>
                        </v-flex> -->

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez la Banque" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="this.BanqueList"
                              item-text="nom_banque" item-value="id" dense outlined v-model="svData.refBanque" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                      </v-layout>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog4 = false"> Fermer </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate_paiement_facture">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>


              <!-- <br /><br /> -->

              <v-dialog v-model="dialog5" max-width="700px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Certificat d'Aptitudde Physique <v-spacer></v-spacer>
                      <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog5 = false" text fab depressed>
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

                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Type de Consultation" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeConsList" item-text="designation"
                              item-value="id" dense outlined v-model="svData.refTypeCons" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Poids">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Taille " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Taille">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="text" label="Tension Artérielle(TA) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TA">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Température " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Temperature">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Frequence Cardiaque(FC) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FC">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Frequence Réspiratoire(FR) " prepend-inner-icon="event"
                              dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FR">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Saturation en Oxygène " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oxygene">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Type Episode Maladie" :items="[
                              { designation: 'Nouveau cas' },
                              { designation: 'Ancien cas' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              dense item-text="designation" item-value="designation"
                              v-model="svData.cas_triage"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea type="textarea" label="Plaintes" prepend-inner-icon="draw" dense
                               outlined v-model="svData.plainte_triage">
                            </v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea type="textarea" label="Antécédent (Medicaux, Chirurgiecaux, etc.)"
                              prepend-inner-icon="draw" dense outlined
                              v-model="svData.antecedent_trige">
                            </v-textarea>
                          </div>
                        </v-flex>



                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Debut" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.DateDebut"></v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="date" label="Date Fin" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.DateFin"></v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Thoracique" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.thoracique"></v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Indice de Pignat" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.indiceDePignat"></v-textarea>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Etat de Santé *" :items="[
                              { designation: 'Médiocre' },
                              { designation: 'Assez-bon' },
                              { designation: 'Bon' },
                              { designation: 'Très bon' },
                              { designation: 'Excellent' },
                              { designation: 'Mauvais' }
                            ]" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                              item-value="designation" v-model="svData.etatDeSante"></v-select>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Examinateur" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="noms_medecin" dense outlined
                              v-model="svData.examination" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Rémarque" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.remarque"></v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea label="Conclusion" prepend-inner-icon="extension"
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                              v-model="svData.conclusion"></v-textarea>
                          </div>
                        </v-flex>

                      </v-layout>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog5 = false"> Fermer </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate_certificat_aptitude">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>

              <!-- <br /><br /> -->


              <!-- <br /><br /> -->

              <v-dialog v-model="dialog7" max-width="700px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Demande des Examens d'Imagerie par un Externe <v-spacer></v-spacer>
                      <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog7 = false" text fab depressed>
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
                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Medecin Protocolaire" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.medecinList"
                              item-text="noms_medecin" item-value="id" dense outlined v-model="svData.refMedecin" chips
                              clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez le Type de Consultation" prepend-inner-icon="mdi-map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="typeConsList" item-text="designation"
                              item-value="id" dense outlined v-model="svData.refTypeCons" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>
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
                              item-text="nomTypeAnalyse" item-value="id" dense outlined v-model="svData.ReftypeAnalyse"
                              chips clearable @change="get_analyse_for_TypeAnalyse(svData.ReftypeAnalyse)">
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md12 lg12>
                          <div class="mr-1">
                            <v-autocomplete label="Selectionnez l'Analyse" prepend-inner-icon="map"
                              :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.AnalyseList"
                              item-text="nomAnalyse" item-value="id" dense outlined v-model="svData.refAnalyse" clearable
                              chips>
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


                        <!--  -->
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
                      <v-btn depressed text @click="dialog5 = false"> Fermer </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate_imagerie_externe">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>

              <!-- <br /><br /> -->


              <!-- <br /><br /> -->

              <v-dialog v-model="dialog6" max-width="700px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Prélèvement des signes vitaux <v-spacer></v-spacer>
                      <v-tooltip bottom color="black">
                        <template v-slot:activator="{ on, attrs }">
                          <span v-bind="attrs" v-on="on">
                            <v-btn @click="dialog6 = false" text fab depressed>
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
                            <v-autocomplete label="Selectionnez le Medecin qui va consulter le patient"
                              prepend-inner-icon="mdi-map" :rules="[(v) => !!v || 'Ce champ est requis']"
                              :items="stataData.medecinList" item-text="noms_medecin" item-value="id" dense outlined
                              v-model="svData.refMedecin" chips clearable>
                            </v-autocomplete>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Poids " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Poids">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Taille " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Taille">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="text" label="Tension Artérielle(TA) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.TA">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Température " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Temperature">
                            </v-text-field>
                          </div>
                        </v-flex>

                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Frequence Cardiaque(FC) " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FC">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Frequence Réspiratoire(FR) " prepend-inner-icon="event"
                              dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.FR">
                            </v-text-field>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-text-field type="number" label="Saturation en Oxygène " prepend-inner-icon="event" dense
                              :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.Oxygene">
                            </v-text-field>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-select label="Type Episode Maladie" :items="[
                              { designation: 'Nouveau cas' },
                              { designation: 'Ancien cas' }
                            ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                              dense item-text="designation" item-value="designation"
                              v-model="svData.cas_triage"></v-select>
                          </div>
                        </v-flex>


                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea type="textarea" label="Plaintes" prepend-inner-icon="draw" dense
                               outlined v-model="svData.plainte_triage">
                            </v-textarea>
                          </div>
                        </v-flex>
                        <v-flex xs12 sm12 md6 lg6>
                          <div class="mr-1">
                            <v-textarea type="textarea" label="Antécédent (Medicaux, Chirurgiecaux, etc.)"
                              prepend-inner-icon="draw" dense outlined
                              v-model="svData.antecedent_trige">
                            </v-textarea>
                          </div>
                        </v-flex>

                    <v-autocomplete label="Type Orientation" :items="[
                      { designation: 'CONSULTATIONS' },
                      { designation: 'DENTISTERIE' },
                      { designation: 'MATERNITE' }
                    ]" prepend-inner-icon="extension"
                      :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense item-text="designation"
                      item-value="designation" v-model="svData.TypeOrientation"></v-autocomplete>


                      </v-layout>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog6 = false"> Fermer </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validate_detail_triage">
                        {{ edit ? "Modifier" : "Ajouter" }}
                      </v-btn>
                    </v-card-actions>
                  </v-form>
                </v-card>
              </v-dialog>

              <!-- <br /><br /> -->

              <v-dialog v-model="dialog2" max-width="400px" persistent>
                <v-card :loading="loading">
                  <v-form ref="form" lazy-validation>
                    <v-card-title>
                      Cloturer une Episode Malade <v-spacer></v-spacer>
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
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          refMalade: {{ refMalade }}
                        </div>
                      </v-flex>
                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-select label="Statut" :items="[
                            { designation: 'Encours' },
                            { designation: 'Sortie' },
                          ]" prepend-inner-icon="extension" :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                            dense item-text="designation" item-value="designation" v-model="svData.Statut"></v-select>
                        </div>
                      </v-flex>

                      <v-text-field type="date" label="Date Sortie" prepend-inner-icon="event" dense
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.dateSortieMvt">
                      </v-text-field>

                      <v-flex xs12 sm12 md12 lg12>
                        <div class="mr-1">
                          <v-textarea type="textarea" label="Motif Sortie" prepend-inner-icon="draw" dense
                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.motifSortieMvt">
                          </v-textarea>
                        </div>
                      </v-flex>

                      <v-text-field label="Autorisation (Medcin)" prepend-inner-icon="extension"
                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.autoriseSortieMvt">
                      </v-text-field>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      <v-btn depressed text @click="dialog2 = false">
                        Fermer
                      </v-btn>
                      <v-btn color="#B72C2C" dark :loading="loading" @click="validateSortie">
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
                        <span>Ajouter un Mouvement</span>
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
                              <th class="text-left">N°</th>
                              <th class="text-left">Malade</th>
                              <th class="text-left">Age</th>
                              <th class="text-left">Categorie</th>
                              <th class="text-left">N°Bon</th>
                              <th class="text-left">Date</th>
                              <th class="text-left">Mouvement</th>
                              <th class="text-left">Etat</th>
                              <th class="text-left">Auhtor</th>
                              <th class="text-left">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr v-for="item in fetchData" :key="item.id">
                              <td>{{ item.id }}</td>
                              <td>{{ item.noms }}</td>
                              <td>{{ item.age_malade }}</td>
                              <td>{{ item.categoriemaladiemvt }}</td>
                              <td>{{ item.numroBon }}</td>
                              <td>{{ item.dateMouvement | formatDate }}</td>
                              <td>{{ item.Typemouvement }}</td>
                              <td>
                                <v-badge bordered color="error" icon="person" overlap>
                                  <v-btn elevation="2" x-small class="white--text" :color="item.Statut == 'Encours'
                                    ? 'success'
                                    : 'error'
                                    " depressed>
                                    {{ item.Statut }}
                                  </v-btn>
                                </v-badge>
                              </td>
                              <td>{{ item.author }}</td>
                              <td>
                                <v-tooltip top v-if="(roless[0].update == 'OUI')" color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="editData(item.id)" fab small>
                                        <v-icon color="#B72C2C">edit</v-icon>
                                      </v-btn>
                                    </span>
                                  </template>
                                  <span>Modifier</span>
                                </v-tooltip>

                                <!-- <v-tooltip top v-if="(roless[0].delete == 'OUI')" color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="desactiverData(item.id,item.author,item.created_at,item.noms)" fab small>
                                        <v-icon color="#B72C2C">delete</v-icon>
                                      </v-btn>
                                    </span>
                                  </template>
                                  <span>Suppression</span>
                                </v-tooltip> -->

                                <v-tooltip top v-if="(roless[0].delete == 'OUI')" color="black">
                                  <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                      <v-btn @click="deleteData(item.id)" fab small>
                                        <v-icon color="#B72C2C">delete</v-icon>
                                      </v-btn>
                                    </span>
                                  </template>
                                  <span>Suppression</span>
                                </v-tooltip>

                                <v-menu bottom rounded offset-y transition="scale-transition">
                                  <template v-slot:activator="{ on }">
                                    <v-btn icon v-on="on" small fab depressed text>
                                      <v-icon color="#B72C2C">more_vert</v-icon>
                                    </v-btn>
                                  </template>

                                  <v-list dense width="">

                                    <v-list-item link
                                      @click="showCreateDetailTriage(item.id, item.noms, item.dateMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-cash-100</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Completez les signes vitaux
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item v-if="item.categoriemaladiemvt == 'PRIVE(E)'" link
                                      @click="showCreatePaiement(item.id, item.noms, item.dateMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-cash-100</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Paiement de la Consultation(Envoie au
                                        Triage)
                                      </v-list-item-title>
                                    </v-list-item>


                                    <v-list-item v-if="item.categoriemaladiemvt == 'ABONNE(E)'" link @click="insertTriage(
                                      item.id,
                                      item.dateMouvement
                                    )
                                      ">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer au Triage</v-list-item-title>
                                    </v-list-item>


                                    <v-list-item link
                                      @click="showCreateAptitudePhysique(item.id, item.noms, item.dateMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-cash-100</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Certificat d'aptitude physique
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="showCreatePrelevement(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-medical-bag</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                                      </v-list-item-title>
                                    </v-list-item>


                                    <!-- <v-list-item link @click="showLaboratoire(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer au Laboratoire
                                      </v-list-item-title>
                                    </v-list-item> -->

                                    <v-list-item link @click="showEnteteCPS(item.id, item.noms)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer à la CPS
                                      </v-list-item-title>
                                    </v-list-item>
<!--  -->

                                    <v-list-item link @click="insertPharmacie(
                                      item.id,
                                      item.dateMouvement
                                    )
                                      ">
                                      <v-list-item-icon>
                                        <v-icon>mdi-cash-100</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer à la
                                        Pharmacie</v-list-item-title>
                                    </v-list-item>


                                    <v-list-item link @click="showCreateImagerieExterne(item.id, item.noms, item.dateMouvement)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">mdi-checkbox-marked-circle</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Envoyer aux Imageries
                                      </v-list-item-title>
                                    </v-list-item>


                                    <v-list-item link @click="sortieData(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">description</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Cloturer une Episode
                                        Maladie</v-list-item-title>
                                    </v-list-item>

                                    <!-- <v-list-item link @click="printBill(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Bon des Examens</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="printFacture(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Factures des
                                        Examens</v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="printResultat(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Rendu des Résultats
                                      </v-list-item-title>
                                    </v-list-item>

                                    <v-list-item link @click="printBilletLabo(item.id)">
                                      <v-list-item-icon>
                                        <v-icon color="#B72C2C">print</v-icon>
                                      </v-list-item-icon>
                                      <v-list-item-title style="margin-left: -20px">Billet de Laboratoire
                                      </v-list-item-title>
                                    </v-list-item> -->
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
          <!-- fin -->
        </v-card-text>

        <!-- container -->
      </v-card>
    </v-dialog>
  </v-row>
</template>
<script>
import { mapGetters, mapActions } from "vuex";
import EnteteCPS from './Enfants/EnteteCPS.vue';
import PaiementFacture from './Finances/PaiementFacture.vue';
import ImageriesExt from './Imageries/ImageriesExt.vue';
import EnteteLabo from './Laboratoire/EnteteLabo.vue';
import EnteteLaboExt from './Laboratoire/EnteteLaboExt.vue';
import AptitudePhysique from "./Attestations/AptitudePhysique.vue";
import Imageries from './Imageries/Imageries.vue';


export default {
  components: {
    ImageriesExt,
    EnteteLaboExt,
    EnteteCPS,
    EnteteLabo,
    PaiementFacture,
    AptitudePhysique,
    Imageries
  },
  data() {
    return {
      title: "Liste des Mouvements",
      etat: false,
      dialog: false,
      dialog2: false,
      dialog3: false,
      dialog4: false,
      dialog5: false,
      dialog6: false,
      dialog7: false,
      edit: false,
      loading: false,
      disabled: false,
      titleComponent: "bonjour",
      refMalade: "",
      serviceProvenance: "",
      // agemvt:0,
      //,'organisationAbonne','taux_prisecharge'
      //'id','refMalade','refTypeMouvement','dateMouvement','numroBon','Statut','dateSortieMvt','motifSortieMvt','autoriseSortieMvt','author'
      svData: {
        id: "",
        refMalade: "",
        refTypeMouvement: "",
        numroBon: "",
        Statut: "",
        author: "Admin",
        noms: "",
        Typemouvement: "",
        refMouvement: "",
        dateTriage: "",
        dateentetepaie: "",
        dateVente: "",
        TypeOrientation: "",

        dateSortieMvt: "",
        motifSortieMvt: "",
        autoriseSortieMvt: "",

        numroBon: "0000",
        organisationAbonne: "Privé(e)",
        taux_prisecharge: 0,
        pourcentageConvention: 0,
        categoriemaladiemvt: "PRIVE(E)",
        numCartemvt: "0000000",
        nmbreJourConsMvt: 30,


        refMouvement: 0,
        refEntetePrelevement: 0,
        serviceProvenance: '',

        refDepartement: 0,
        refUniteProduction: 0,
        refProduit: 0,
        modepaie: '',
        refBanque: 0,

        refEnteteFacturation: 0,
        //
        refTypeProduit: 0,
        refService: 0,
        noms: "",
        refMedecin: 0,
        refTypeCons: 0,
        refService: 0,

        dateEnteteTriage: 0,


        plainte_triage: 'RAS',
        antecedent_trige: 'RAS',
        cas_triage: '',
        Poids: '',
        Taille: '',
        TA: '',
        Temperature: '',
        FC: '',
        FR: '',
        Oxygene: '',
        //Aptitude physique ============================
        refAttestation: 0,
        thoracique: '',
        indiceDePignat: '',
        etatDeSante: '',
        remarque: '',
        conclusion: '',
        DateDebut: '',
        DateFin: '',
        examination: '',
        //Imagerie Externe ===================================

        ReftypeAnalyse: "",
        refAnalyse: "",
        dateImagerie: "",
        clinique: "",
        but: "",
        urgent: "",
        medecindemandeur: "",
        medecinProtocolaire: "",
        specialiste: "",
        CNOM: "",
        examenDemande: "",
        status: "",
        evaluation_plan: "",
        specialite_medecin: '',
        fonction_medecin: '',
        matricule_medecin: "",
        refDetailConst: 0,

        // agemvt:0
      },
      fetchData: [],
      typemouvementtList: [],
      clientList: [],
      personneList: [],
      don: [],
      query: "",
      typeConsList: [],

      ModeList: [],
      BanqueList: [],
      produitList: [],
      typeproduitList: [],
      stataData: {
        TypeAnalyseList: [],
        AnalyseList: [],
        ServiceList: [],
        medecinList: [],
        DepartementList: [],
        UniteList: [],
      },
    };
  },
  created() {
    // this.fetchListSelection();
    // this.fetchListServices();
    // this.fetchListmedecin();
    // this.fetchListtypeconsultation();
    // this.fetchListDepartement();
    // this.fetchListTypeProduit();
    // this.get_mode_Paiement();
    this.fetchListTypeAnalyse();
    this.get_Banque("CASH");
  },
  computed: {
    ...mapGetters(["categoryList", "isloading"]),
  },
  methods: {
    ...mapActions(["getCategory"]),

    validate() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        this.svData.refMalade = this.refMalade;

        if (this.edit) {
          // this.svData.Statut='Encours';
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_mouvement/${this.svData.id}`,
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
        } else {

          this.svData.Statut = "Encours";
          this.svData.author = this.userData.name;
          // this.svData.agemvt = this.agemvt;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_mouvement`,
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
    async get_mode_Paiement() {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_tconf_modepaie_2`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.ModeList = chart;
          } else {
            this.ModeList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    async get_Banque(nom_mode) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_list_banque/${nom_mode}`)
        .then((res) => {
          var chart = res.data.data;
          if (chart) {
            this.BanqueList = chart;
          } else {
            this.BanqueList = [];
          }
          this.isLoading(false);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    fetchListDepartement() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_departement_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.DepartementList = donnees;

        }
      );
    },

    fetchListTypeProduit() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_fin_typeproduit_2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeproduitList = donnees;
        }
      );
    },
    //fultrage de donnees
    async get_produit_for_typeproduit(refTypeProduit, organisationAbonne) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_produit_type3?refTypeProduit=${refTypeProduit}&organisationAbonne=${organisationAbonne}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.produitList = chart;
          } else {
            this.produitList = [];
          }

          chart.map((item) => {
            this.svData.nom_typeproduit = item.nom_typeproduit;
          });

          this.isLoading(false);

          //console.log(this.svData.nom_typeproduit);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    //fultrage de donnees
    async Get_unite_for_Departement(idDepartement) {
      this.isLoading(true);
      await axios
        .get(`${this.apiBaseURL}/fetch_unite_Departement2/${idDepartement}`)
        .then((res) => {
          var chart = res.data.data;

          if (chart) {
            this.stataData.UniteList = chart;
          } else {
            this.stataData.UniteList = [];
          }

          this.isLoading(false);

          //   console.log(this.stataData.car_optionList);
        })
        .catch((err) => {
          this.errMsg();
          this.makeFalse();
          reject(err);
        });
    },
    fetchListmedecin() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medecin`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.medecinList = donnees;

        }
      );
    },
    fetchListtypeconsultation() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typeConsultation`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typeConsList = donnees;
        }
      );
    },
    validate_preleve() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        //refService
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_prelevement_mouvement?refMouvement=${this.svData.refMouvement}&author=${this.svData.author}&refMedecin=${this.svData.refMedecin}&refTypeCons=${this.svData.refTypeCons}&refService=${this.svData.refService}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEntetePrelevement = item.id;
              this.serviceProvenance = item.nom_uniteproduction;
            });
            this.showLaboratoire(this.svData.refEntetePrelevement, this.svData.noms, this.serviceProvenance);
            this.dialog3 = false;
            this.isLoading(false);
          }
        );
      }
    },
    validate_paiement_facture() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        this.svData.modepaie='CASH';
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_paiement_Mouvement?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refProduit=${this.svData.refProduit}&modepaie=${this.svData.modepaie}&refBanque=${this.svData.refBanque}`).then(
        // this.editOrFetch(`${this.apiBaseURL}/fetch_max_entete_paiement_Mouvement?refMouvement=${this.svData.refMouvement}&refUniteProduction=${this.svData.refUniteProduction}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refProduit=${this.svData.refProduit}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refEnteteFacturation = item.id;
              this.svData.dateEnteteTriage = item.datefacture;
            });
            this.showPaieFacturation(this.svData.refEnteteFacturation, this.svData.noms);
            this.insertTriage(this.svData.refMouvement, this.svData.dateEnteteTriage);
            this.dialog4 = false;
            this.isLoading(false);
          }
        );
      }
    },
    showAptitudePhysique(refAttestation, name) {

      if (refAttestation != '') {

        this.$refs.AptitudePhysique.$data.etatModal = true;
        this.$refs.AptitudePhysique.$data.refAttestation = refAttestation;
        this.$refs.AptitudePhysique.$data.svData.refAttestation = refAttestation;
        this.$refs.AptitudePhysique.fetchDataList();
        this.fetchDataList();

        this.$refs.AptitudePhysique.$data.titleComponent =
          "Création du Certificat d'aptitude physique pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    validate_certificat_aptitude() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        //refService
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_aptitude_physique?refMouvement=
        ${this.svData.refMouvement}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refTypeCons=
        ${this.svData.refTypeCons}&refService=${this.svData.refService}&plainte_triage=${this.svData.plainte_triage}&antecedent_trige=
        ${this.svData.antecedent_trige}&cas_triage=${this.svData.cas_triage}&Poids=
        ${this.svData.Poids}&Taille=${this.svData.Taille}&TA=${this.svData.TA}&Temperature=${this.svData.Temperature}&FC=
        ${this.svData.FC}&FR=${this.svData.FR}&Oxygene=${this.svData.Oxygene}&thoracique=${this.svData.thoracique}&indiceDePignat=
        ${this.svData.indiceDePignat}&etatDeSante=${this.svData.etatDeSante}&remarque=${this.svData.remarque}&conclusion=
        ${this.svData.conclusion}&DateDebut=${this.svData.DateDebut}&DateFin=${this.svData.DateFin}&examination=${this.svData.examination}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refAttestation = item.refAttestation;
              this.svData.noms = item.noms;
            });
            this.showAptitudePhysique(this.svData.refAttestation, this.svData.noms);
            this.dialog5 = false;
            this.isLoading(false);
          }
        );
      }
    },
    validate_imagerie_externe() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        //refService
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_imagerie_externe?refMouvement=
        ${this.svData.refMouvement}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&refTypeCons=
        ${this.svData.refTypeCons}&refService=${this.svData.refService}&refAnalyse=${this.svData.refAnalyse}&dateImagerie=
        ${this.svData.dateImagerie}&clinique=${this.svData.clinique}&but=
        ${this.svData.but}&urgent=${this.svData.urgent}&serviceProvenance=${this.svData.serviceProvenance}&medecindemandeur=${this.svData.medecindemandeur}&medecinProtocolaire=
        ${this.svData.medecinProtocolaire}&specialiste=${this.svData.specialiste}&CNOM=${this.svData.CNOM}&examenDemande=${this.svData.examenDemande}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refDetailConst = item.refDetailConst;
              this.svData.noms = item.noms;
            });
            this.showImagerie(this.svData.refDetailConst, this.svData.noms);
            this.dialog7 = false;
            this.isLoading(false);
          }
        );
      }
    },
    validate_detail_triage() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);

        //refService
        this.editOrFetch(`${this.apiBaseURL}/fetch_max_adetail_triage?refMouvement=
        ${this.svData.refMouvement}&refMedecin=${this.svData.refMedecin}&author=${this.svData.author}&plainte_triage=
        ${this.svData.plainte_triage}&antecedent_trige=
        ${this.svData.antecedent_trige}&cas_triage=${this.svData.cas_triage}&Poids=
        ${this.svData.Poids}&Taille=${this.svData.Taille}&TA=${this.svData.TA}&Temperature=${this.svData.Temperature}&FC=
        ${this.svData.FC}&FR=${this.svData.FR}&Oxygene=${this.svData.Oxygene}&TypeOrientation=${this.svData.TypeOrientation}`).then(
          ({ data }) => {
            var donnees = data.data;
            donnees.map((item) => {
              this.svData.refMouvement = item.refMouvement;
              this.svData.noms = item.noms;
            });
            // this.showAptitudePhysique(this.svData.refAttestation, this.svData.noms);
            this.dialog6 = false;
            this.isLoading(false);
            this.showMsg('Le Patient est envoyé chez le medecin avec succès');
          }
        );
      }
    },
    showPaieFacturation(refEnteteFacturation, name) {

      if (refEnteteFacturation != '') {

        this.$refs.PaiementFacture.$data.etatModal = true;
        this.$refs.PaiementFacture.$data.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.$data.svData.refEnteteFacturation = refEnteteFacturation;
        this.$refs.PaiementFacture.fetchDataList();
        this.$refs.PaiementFacture.getInfoFacture(refEnteteFacturation);
        this.$refs.PaiementFacture.get_mode_Paiement();

        this.$refs.PaiementFacture.$data.titleComponent =
          "Paiement de la Facture pour " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    }
    ,
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
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.dialog3 = true;
      // 
    },
    showCreatePaiement(id, noms, dateMouvement) {
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.svData.dateEnteteTriage = dateMouvement;
      this.dialog4 = true;

    },
    showCreateAptitudePhysique(id, noms, dateMouvement) {
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.svData.dateEnteteTriage = dateMouvement;
      this.dialog5 = true;

    },
    showCreateImagerieExterne(id, noms, dateMouvement) {
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.svData.dateEnteteTriage = dateMouvement;
      this.dialog7 = true;

    },
    showCreateDetailTriage(id, noms, dateMouvement) {
      this.svData.refMouvement = id;
      this.svData.noms = noms;
      this.svData.author = this.userData.name;
      this.svData.dateEnteteTriage = dateMouvement;
      this.dialog6 = true;

    },
    fetchListServices() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_unite2`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.ServiceList = donnees;

        }
      );
    },

    validateSortie() {
      if (this.$refs.form.validate()) {
        this.isLoading(true);
        if (this.edit) {
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/update_statut/${this.svData.id}`,
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
        } else {
        }
      }
    },
    //printBilletLabo
    printBill(id) {
      window.open(`${this.apiBaseURL}/pdf_bonexamenext_data?id=` + id);
    },
    //printResultat
    printFacture(id) {
      window.open(`${this.apiBaseURL}/pdf_facturelaboext_data?id=` + id);
    },
    //printResultat
    printBilletLabo(id) {
      window.open(`${this.apiBaseURL}/pdf_billetlaboext_data?id=` + id);
    },
    //printResultat
    printResultat(id) {
      window.open(`${this.apiBaseURL}/pdf_resultatlaboext_data?id=` + id);
    },

    editData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refMalade = item.refMalade;
            this.svData.noms = item.noms;
            this.svData.Typemouvement = item.Typemouvement;
            this.svData.refTypeMouvement = item.refTypeMouvement;
            this.svData.author = item.author;
            this.svData.numroBon = item.numroBon;
            this.svData.Statut = item.Statut;

            this.svData.organisationAbonne = item.organisationAbonne;
            this.svData.taux_prisecharge = item.taux_prisecharge;
            this.svData.pourcentageConvention = item.pourcentageConvention;
            this.svData.categoriemaladiemvt = item.categoriemaladiemvt;
            this.svData.nmbreJourConsMvt = item.nmbreJourConsMvt;
            this.svData.numCartemvt = item.numCartemvt;
          });

          this.edit = true;
          this.dialog = true;

          // pourcentageConvention
        }
      );
    },

    sortieData(id) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_mouvement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.dateSortieMvt = item.dateSortieMvt;
            this.svData.motifSortieMvt = item.motifSortieMvt;
            this.svData.autoriseSortieMvt = item.autoriseSortieMvt;
            this.svData.author = item.author;
            this.svData.Statut = item.Statut;
          });

          this.edit = true;
          this.dialog2 = true;

          // console.log(donnees);
        }
      );
    },
    insertTriage(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateTriage = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_enteteTriage`,
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
    insertPaiement(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateentetepaie = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_entetepaie`,
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
    insertPharmacie(id, dateMouvement) {
      this.svData.author = this.userData.name;
      this.svData.refMouvement = id;
      this.svData.dateVente = dateMouvement;
      this.insertOrUpdate(
        `${this.apiBaseURL}/insert_entetevente`,
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
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_typemouvement`).then(
        ({ data }) => {
          var donnees = data.data;
          this.typemouvementtList = donnees;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_mouvement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    desactiverData(valeurs, user_created, date_entree, noms) {

      var tables = 'tmouvement';
      var user_name = this.userData.name;
      var user_id = this.userData.id;
      var detail_information = "Suppression d'une episode maladie pour " + noms + " par l'utilisateur " + user_name + "";

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(
        `${this.apiBaseURL}/fetch_mouvement_malade/${this.refMalade}?page=`
      );
      this.getAbonnement(this.refMalade, "Encours");
    },

    getRouteParam() {
      var id = this.refMalade;
      this.refMalade = id;
    },
    getRouteParamMalade(refMalade) {
      this.svData.refMalade = refMalade;
      this.fetch_data(
        `${this.apiBaseURL}/fetch_mouvement_malade/${refMalade}?page=`
      );
    },
    getAbonnement(refMalade, Statut) {
      this.editOrFetch(
        `${this.apiBaseURL}/fetch_affectationabone_mvt?refMalade=${refMalade}&Statut=${Statut}`
      ).then(({ data }) => {
        var donnees = data.data;
        donnees.map((item) => {
          this.svData.taux_prisecharge = item.tauxcharge;
          this.svData.organisationAbonne = item.nom_org;
          this.svData.pourcentageConvention = item.pourcentageConvention;
          this.svData.nmbreJourConsMvt = item.nmbreJourCons;
          this.svData.categoriemaladiemvt = item.Categorie;
          this.svData.numCartemvt = item.numeroCarte_malade;         

          //nmbreJourConsMvt
        });
      });
    },
    showImagerie(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.ImageriesExt.$data.etatModal = true;
        this.$refs.ImageriesExt.$data.refMouvement = refMouvement;
        this.$refs.ImageriesExt.$data.svData.refMouvement = refMouvement;
        this.$refs.ImageriesExt.fetchDataList();
        this.$refs.ImageriesExt.fetchListTypeAnalyse();
        this.$refs.ImageriesExt.fetchListSelection();
        this.$refs.ImageriesExt.fetchListServices();
        this.fetchDataList();

        this.$refs.ImageriesExt.$data.titleComponent =
          "Transfert Imagrie du Patient : " + name;

      } else {
        this.showError("Personne n'a fait cette action");
      }

    },
    // showLaboratoire(refMouvement, name) {

    //   if (refMouvement != '') {

    //     this.$refs.EnteteLaboExt.$data.etatModal = true;
    //     this.$refs.EnteteLaboExt.$data.refMouvement = refMouvement;
    //     this.$refs.EnteteLaboExt.$data.svData.refMouvement = refMouvement;
    //     this.$refs.EnteteLaboExt.fetchDataList();
    //     this.$refs.EnteteLaboExt.get_examen_all();
    //     this.$refs.EnteteLaboExt.fetchListServices();
    //     this.fetchDataList();
    //     // this.$refs.Endoscopie.getRouteParamMalade(refEnteteFacturation);
    //     //fetchListServices()
    //     this.$refs.EnteteLaboExt.$data.titleComponent =
    //       "Demander les Examens de Laboratoire pour le Patient : " + name;

    //   } else {
    //     this.showError("Personne n'a fait cette action");
    //   }

    // },
    showEnteteCPS(refMouvement, name) {

      if (refMouvement != '') {

        this.$refs.EnteteCPS.$data.etatModal = true;
        this.$refs.EnteteCPS.$data.refMouvement = refMouvement;
        this.$refs.EnteteCPS.$data.svData.refMouvement = refMouvement;
        this.$refs.EnteteCPS.fetchDataList();
        this.fetchDataList();
        // this.$refs.Endoscopie.getRouteParamMalade(refEnteteFacturation);

        this.$refs.EnteteCPS.$data.titleComponent =
          "Consultation Près-Scolaire pour : " + name;

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
    getSpecialiteMedecin(idMedecin) {
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_medecin/${idMedecin}`).then(
        ({ data }) => {
          var donnees = data.data;

          donnees.map((item) => {
            this.svData.medecinProtocolaire=item.noms_medecin;
            this.svData.specialiste = item.specialite_medecin;
            this.svData.CNOM = item.matricule_medecin;
          });

        }
      );
    },

  },
  filters: {},
};
</script>
  
  