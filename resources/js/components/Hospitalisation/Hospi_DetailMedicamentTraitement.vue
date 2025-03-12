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
                <v-dialog v-model="dialog" max-width="500px" persistent>
                  <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                      <v-card-title>
                        Details Traitement <v-spacer></v-spacer>
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

                        <v-textarea v-if="examens != '  --  ' || examens != '' || examens != '--'" readonly type="text" label="Les Medicaments prescrits par le Medecin : " prepend-inner-icon="event"
                           dense outlined v-model="examens">
                        </v-textarea>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-autocomplete label="Selectionnez le Medicament" prepend-inner-icon="home"
                                :items="this.stataData.MedicamentList" item-text="nom_medicament" item-value="id" dense
                                outlined v-model="svData.refMedicament" chips clearable>
                              </v-autocomplete>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Posologie" prepend-inner-icon="extension" outlined dense
                                v-model="svData.posologie"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-textarea label="Voie" prepend-inner-icon="extension" outlined dense
                                v-model="svData.vait"></v-textarea>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 08h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait08h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 08h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte08h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 09h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait09h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 09h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte09h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 10h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait10h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 10h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte10h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 11h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait11h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 11h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte11h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 12h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait12h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 12h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte12h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 13h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait13h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 13h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte13h"></v-text-field>
                            </div>
                          </v-flex>



                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 14h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait14h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 14h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte14h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 15h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait15h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 15h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte15h"></v-text-field>
                            </div>
                          </v-flex>




                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 16h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait16h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 16h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte16h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 17h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait17h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 17h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte17h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 18h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait18h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 18h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte18h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 19h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait19h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 19h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte19h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 20h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait20h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 20h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte20h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 21h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait21h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 21h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte21h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 22h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait22h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 22h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte22h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 23h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait23h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 23h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte23h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 24h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait24h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 24h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte24h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 01h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait01h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 01h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte01h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 02h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait02h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 02h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte02h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 03h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait03h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 03h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte03h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 04h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait04h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 04h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte04h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 05h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait05h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 05h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte05h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 06h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait06h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 06h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte06h"></v-text-field>
                            </div>
                          </v-flex>


                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-select label="Fait à 07h" :items="[
      { designation: 'Oui' },
      { designation: 'Non' }
    ]" prepend-inner-icon="extension" outlined dense item-text="designation"
                                item-value="designation" v-model="svData.fait07h"></v-select>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md6 lg6>
                            <div class="mr-1">
                              <v-text-field type="number" label="Qté à 07h" prepend-inner-icon="extension" outlined
                                dense v-model="svData.qte07h"></v-text-field>
                            </div>
                          </v-flex>

                          <v-flex xs12 sm12 md12 lg12>
                            <div class="mr-1">
                              <v-textarea label="Observation" prepend-inner-icon="extension" outlined dense
                                v-model="svData.observation"></v-textarea>
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
                        <v-text-field placeholder="recherche..." append-icon="search" label="Recherche..." single-line
                          solo outlined rounded hide-details v-model="query" @keyup="fetchDataList"
                          clearable></v-text-field>
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
                          <span>Ajouter Acte</span>
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
                                <th class="text-left">DateTrait</th>
                                <th class="text-left">Malade</th>
                                <th class="text-left">Sexe</th>
                                <th class="text-left">Age</th>
                                <th class="text-left">Medicament</th>
                                <th class="text-left">posologie</th>
                                <th class="text-left">Observation</th>
                                <th class="text-left">Action</th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr v-for="item in fetchData" :key="item.id">
                                <td>
                                  {{ item.created_at | formatDate }}
                                  {{ item.created_at | formatHour }}
                                </td>
                                <td>{{ item.noms }}</td>
                                <td>{{ item.sexe_malade }}</td>
                                <td>{{ item.age_malade }}</td>
                                <td>{{ item.nom_medicament }}</td>
                                <td>{{ item.posologie }}</td>
                                <td>{{ item.observation }}</td>
                                <td>


                                  <v-menu bottom rounded offset-y transition="scale-transition">
                                    <template v-slot:activator="{ on }">
                                      <v-btn icon v-on="on" small fab depressed text>
                                        <v-icon>more_vert</v-icon>
                                      </v-btn>
                                    </template>

                                    <v-list dense width="">

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

      examens: '',

      etatModal: false,
      titleComponent: '',
      refTraitem: 0,

      svData: {
        id: '',
        refTraitem: 0,
        refMedicament: "",
        posologie: "",
        vait: "",
        fait08h: "",
        qte08h: "",
        fait09h: "",
        qte09h: "",
        fait10h: "",
        qte10h: "",
        fait11h: "",
        qte11h: "",
        fait12h: "",
        qte12h: "",
        fait13h: "",
        qte13h: "",
        fait14h: "",
        qte14h: "",
        fait15h: "",
        qte15h: "",
        fait16h: "",
        qte16h: "",
        fait17h: "",
        qte17h: "",
        fait18h: "",
        qte18h: "",
        fait19h: "",
        qte19h: "",
        fait20h: "",
        qte20h: "",
        fait21h: "",
        qte21h: "",
        fait22h: "",
        qte22h: "",
        fait23h: "",
        qte23h: "",
        fait24h: "",
        qte24h: "",
        fait01h: "",
        qte01h: "",
        fait02h: "",
        qte02h: "",
        fait03h: "",
        qte03h: "",
        fait04h: "",
        qte04h: "",
        fait05h: "",
        qte05h: "",
        fait06h: "",
        qte06h: "",
        fait07h: "",
        qte07h: "",
        observation: "",
        author: "",        
      },
      fetchData: [],
      don: [],
      query: "",
      stataData: {
        MedicamentList: [],
      },

      inserer: '',
      modifier: '',
      supprimer: '',
      chargement: ''

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
          this.svData.refTraitem = this.refTraitem;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/updatethospi_detail_Dtraitement/${this.svData.id}`,
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
          this.svData.refTraitem = this.refTraitem;
          this.svData.author = this.userData.name;
          this.insertOrUpdate(
            `${this.apiBaseURL}/insert_detail_Dtraitement`,
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
      this.editOrFetch(`${this.apiBaseURL}/fetch_single_Dtraitement/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.svData.id = item.id;
            this.svData.refTraitem = item.refTraitem;
            this.svData.refMedicament = item.refMedicament;
            this.svData.posologie = item.posologie;
            this.svData.fait08h = item.fait08h;
            this.svData.qte08h = item.qte08h;
            this.svData.fait09h = item.fait09h;
            this.svData.qte09h = item.qte09h;
            this.svData.fait10h = item.fait10h;
            this.svData.qte10h = item.qte10h;
            this.svData.fait11h = item.fait11h;
            this.svData.qte11h = item.qte11h;
            this.svData.fait12h = item.fait12h;
            this.svData.qte12h = item.qte12h;
            this.svData.fait13h = item.fait13h;
            this.svData.qte13h = item.qte13h;
            this.svData.fait14h = item.fait14h;
            this.svData.qte14h = item.qte14h;
            this.svData.fait15h = item.fait15h;
            this.svData.qte15h = item.qte15h;
            this.svData.fait16h = item.fait16h;
            this.svData.qte16h = item.qte16h;
            this.svData.fait17h = item.fait17h;
            this.svData.qte17h = item.qte17h;
            this.svData.fait18h = item.fait18h;
            this.svData.qte18h = item.qte18h;
            this.svData.fait19h = item.fait19h;
            this.svData.qte19h = item.qte19h;
            this.svData.fait20h = item.fait20h;
            this.svData.qte20h = item.qte20h;
            this.svData.fait21h = item.fait21h;
            this.svData.qte21h = item.qte21h;
            this.svData.fait22h = item.fait22h;
            this.svData.qte22h = item.qte22h;
            this.svData.fait23h = item.fait23h;
            this.svData.qte23h = item.qte23h;
            this.svData.fait24h = item.fait24h;
            this.svData.qte24h = item.qte24h;
            this.svData.fait01h = item.fait01h;
            this.svData.qte01h = item.qte01h;
            this.svData.fait02h = item.fait02h;
            this.svData.qte02h = item.qte02h;
            this.svData.fait03h = item.fait03h;
            this.svData.qte03h = item.qte03h;
            this.svData.fait04h = item.fait04h;
            this.svData.qte04h = item.qte04h;
            this.svData.fait05h = item.fait05h;
            this.svData.qte05h = item.qte05h;
            this.svData.fait06h = item.fait06h;
            this.svData.qte06h = item.qte06h;
            this.svData.fait07h = item.fait07h;
            this.svData.qte07h = item.qte07h;
            this.svData.observation = item.observation;
            this.svData.author = item.author;

          });
          this.edit = true;
          this.dialog = true;
        }
      );
    },
    deleteData(id) {
      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/delete_detail_Dtraitement/${id}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.fetchDataList();
          }
        );
      });
    },
    fetchDataList() {
      this.fetch_data(`${this.apiBaseURL}/fetch_detailtraitement_hospi/${this.refTraitem}?page=`);
    },
    fetchListSelection() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_list_medicament`).then(
        ({ data }) => {
          var donnees = data.data;
          this.stataData.MedicamentList = donnees;

        }
      );
    },
    showDataExamenLaboMedecin(id) {
      this.examens = "";
      this.editOrFetch(`${this.apiBaseURL}/fetch_examen_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.examens = " ; Examens demandés"+this.examens + "  --  "+ item.designationEx;
          });
        }
      );
    },
    showDataMedicamentMedecin(id) {
      // this.examens = this.examens + " ; ";
      this.editOrFetch(`${this.apiBaseURL}/fetch_medicaments_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.examens =  this.examens + " ; Medicaments Prescrits : "+ "  --  " + item.nom_medicament;
            // this.medicaments = this.medicaments + "  --  " + item.nom_medicament;
          });
          // this.dialog5 = true;
        }
        //
      );
    },
    showDataImagerieMedecin(id) {
      // this.examens = this.examens + " ; ";
      this.editOrFetch(`${this.apiBaseURL}/fetch_imagerie_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.examens =  this.examens+ " ; Analyses demandées : "+ + "  --  " + item.nomAnalyse;
            // this.imageries = this.imageries + "  --  " + item.nomAnalyse;
          });
          // this.dialog5 = true;
        }
        //
      );
    },
    showDataActesMedecin(id) {
      // this.examens = this.examens + " ; ";
      this.editOrFetch(`${this.apiBaseURL}/fetch_actes_episode/${id}`).then(
        ({ data }) => {
          var donnees = data.data;
          donnees.map((item) => {
            this.examens =  this.examens + " ; Actes Posés" + "  --  " + item.nom_acte;
          });
          // this.dialog5 = true;
        }
        //
      );
    },
    showDataMedcin(id_data) {
      // this.showDataExamenLaboMedecin(id_data);
      this.showDataMedicamentMedecin(id_data);
      // this.showDataImagerieMedecin(id_data);
      // this.showDataActesMedecin(id_data); 
    }


  },
  filters: {

  }
}
</script>