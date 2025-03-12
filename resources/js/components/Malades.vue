<template>
    <v-layout>
        <v-flex md12>

            <!-- Annexe_Patient  -->
            <avatarAvatar ref="avatarAvatar" />
            <ModalMouvement_malade ref="ModalMouvement_malade" />
            <ModelAffectationAbonne ref="ModelAffectationAbonne" />
            <MaladieChronique ref="MaladieChronique" />
            <Annexe_Patient ref="Annexe_Patient" />
            <AvatarProfil ref="avatarPhoto" />

            <v-dialog v-model="dialog" max-width="900px" hide-overlay transition="dialog-bottom-transition">
                <v-card :loading="loading">
                    <v-form ref="form" lazy-validation>
                        <v-card-title>
                            {{ titleComponent }} <v-spacer></v-spacer>
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

                                <v-flex xs12 sm12 md12 lg12>
                                    <v-text-field label="Nom complet" prepend-inner-icon="draw" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined v-model="svData.noms"
                                        @keyup="onPageTexteSearch(svData.noms)"></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm12 md12 lg12 v-if="etatSearch==true" id="etatSearch">
                                    <v-list three-line>
                                        <template>

                                            <v-subheader @click="updateEtat()">Liste de malade ayant le même nom </v-subheader>
                                            <!-- {{ JSON.stringify(maladeList) }} -->

                                            <v-divider></v-divider>

                                            <v-list-item v-for="item in maladeList" :key="item.id" @click="setNom(item.noms)" persistent>
                                                <v-list-item-avatar>
                                                    <img :src="item.photo == null
                                                        ? `${baseURL}/fichier/avatar.png`
                                                        : `${baseURL}/fichier/` + item.photo
                                                        " alt="" style="width: 50px; height: 50px; border-radius: 50%;">
                                                </v-list-item-avatar>

                                                <v-list-item-content>
                                                    <v-list-item-title>
                                                        {{ item.noms }}
                                                    </v-list-item-title>
                                                    <v-list-item-subtitle>
                                                        {{ item.contact }}
                                                    </v-list-item-subtitle>
                                                </v-list-item-content>
                                            </v-list-item>
                                            <v-divider></v-divider>
                                        </template>
                                    </v-list>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Naissance" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.dateNaissance_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="text" label="Lieu de Naissance" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.organisation_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Sexe" :items="[
                                            { designation: 'Homme' },
                                            { designation: 'Femme' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.sexe_malade"  @change="updateEtat()"></v-select>
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
                                            { designation: 'AB-' },
                                            { designation: 'En attente' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.groupesanguin"></v-select>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Adresse mail" prepend-inner-icon="draw" dense :rules="[
                                            (v) => !!v || 'Ce champ est requis',
                                            (v) =>
                                                /.+@.+\..+/.test(v) || 'L\'email doit être valide',
                                        ]" outlined v-model="svData.mail"></v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.contact">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-select label="Etat Civil" :items="[
                                            { designation: 'Marié(e)' },
                                            { designation: 'Célibataire' },
                                            { designation: 'Divocé(3)' },
                                            { designation: 'Veuf(ve)' }
                                        ]" prepend-inner-icon="extension"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined dense
                                            item-text="designation" item-value="designation"
                                            v-model="svData.etatcivil_malade"></v-select>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="text" label="Profession" prepend-inner-icon="event" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.fonction_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">


                                        <v-autocomplete label="Selectionnez la Categorie" prepend-inner-icon="mdi-map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="clientList"
                                            item-text="designation" item-value="id" dense outlined
                                            v-model="svData.refCategieClient" chips clearable>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6>
                                    <v-text-field label="Personne de Référence" prepend-inner-icon="draw" dense
                                        :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                        v-model="svData.personneRef_malade"></v-text-field>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="Profession Personne de Référence" prepend-inner-icon="draw"
                                            dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.fonctioPersRef_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Téléphone Personne de Référence"
                                            prepend-inner-icon="draw" dense :rules="[(v) => !!v || 'Ce champ est requis']"
                                            outlined v-model="svData.contactPersRef_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>




                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le Pays" prepend-inner-icon="home"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="paysList"
                                            item-text="nomPays" item-value="id" dense outlined v-model="svData.idPays" chips
                                            clearable @change="get_data_tug_pays(svData.idPays)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la province" prepend-inner-icon="map"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.provinceList"
                                            item-text="nomProvince" item-value="id" dense outlined
                                            v-model="svData.idProvince" clearable chips
                                            @change="get_data_tug_province(svData.idProvince)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la ville" prepend-inner-icon="explore"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.villeList"
                                            item-text="nomVille" item-value="id" dense outlined v-model="svData.idVille"
                                            clearable chips @change="get_data_tug_commune(svData.idVille)">
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez la commune" prepend-inner-icon="push_pin"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.communeList"
                                            item-text="nomCommune" item-value="id" dense outlined v-model="svData.idCommune"
                                            clearable @change="get_data_tug_quartier(svData.idCommune)" chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez le quartier" prepend-inner-icon="navigation"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.quartierList"
                                            item-text="nomQuartier" item-value="id" dense outlined
                                            v-model="svData.idQuartier" @change="get_data_tug_Avenue(svData.idQuartier)"
                                            clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-autocomplete label="Selectionnez l'avenue" prepend-inner-icon="domain"
                                            :rules="[(v) => !!v || 'Ce champ est requis']" :items="stataData.avenueList"
                                            item-text="nomAvenue" item-value="id" dense outlined v-model="svData.refAvenue"
                                            clearable chips>
                                        </v-autocomplete>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° Maison" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.numeroMaison_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>



                                <v-flex xs12 sm12 md6 lg6class="mb-2">
                                    <input class="form-control" type="file" id="photo_input" @change="onImageChange"
                                        required />
                                    <br />
                                    <img :style="{ height: style.height }" id="output" />
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field label="N° de Carte" prepend-inner-icon="draw" dense
                                            :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.numeroCarte_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>

                                <v-flex xs12 sm12 md6 lg6>
                                    <div class="mr-1">
                                        <v-text-field type="date" label="Date Expiration Carte" prepend-inner-icon="event"
                                            dense :rules="[(v) => !!v || 'Ce champ est requis']" outlined
                                            v-model="svData.dateExpiration_malade">
                                        </v-text-field>
                                    </div>
                                </v-flex>


                                <v-flex xs12 sm12 md12 lg12>
                                    <div class="mr-1">
                                        <div id="app" class="web-camera-container">
                                            <div class="camera-button">
                                                <button type="button" class="button is-rounded"
                                                    :class="{ 'is-primary': !isCameraOpen, 'is-danger': isCameraOpen }"
                                                    @click="toggleCamera">
                                                    <span v-if="!isCameraOpen">Open Camera</span>
                                                    <span v-else>Close Camera</span>
                                                </button>
                                            </div>

                                            <div v-show="isCameraOpen && isLoading2" class="camera-loading">
                                                <ul class="loader-circle">
                                                    <li></li>
                                                    <li></li>
                                                    <li></li>
                                                </ul>
                                            </div>

                                            <div v-if="isCameraOpen" v-show="!isLoading2" class="camera-box"
                                                :class="{ 'flash': isShotPhoto }">

                                                <div class="camera-shutter" :class="{ 'flash': isShotPhoto }"></div>

                                                <video v-show="!isPhotoTaken" ref="camera" :width="450" :height="337.5"
                                                    autoplay></video>

                                                <canvas v-show="isPhotoTaken" id="photoTaken" ref="canvas" :width="450"
                                                    :height="337.5"></canvas>
                                            </div>

                                            <div v-if="isCameraOpen && !isLoading2" class="camera-shoot">
                                                <button type="button" class="button" @click="takePhoto">
                                                    <img
                                                        src="https://img.icons8.com/material-outlined/50/000000/camera--v2.png">
                                                </button>
                                            </div>

                                            <div v-if="isPhotoTaken && isCameraOpen" class="camera-download">
                                                <a id="downloadPhoto" download="my-photo.jpg" class="button" role="button"
                                                    @click="downloadImage">
                                                    Download
                                                </a>
                                            </div>
                                        </div>
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
                <v-layout>

                    <v-flex md12></v-flex>

                </v-layout>

                <v-flex md12>
                    <!-- bande -->
                    <v-layout>
                        <v-flex md1>
                            <v-tooltip bottom>
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn :loading="loading" fab @click="onPageChange">
                                            <v-icon>autorenew</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Initialiser</span>
                            </v-tooltip>
                        </v-flex>
                        <v-flex md4>

                            <!-- {{ JSON.stringify(roless[0].update) }} -->

                            <v-text-field append-icon="search" label="Recherche..." single-line solo outlined rounded
                                hide-details v-model="query" @keyup="onPageChange" clearable></v-text-field>
                        </v-flex>

                        <v-flex md6></v-flex>

                        <v-flex md1>
                            <v-tooltip bottom color="black">
                                <template v-slot:activator="{ on, attrs }">
                                    <span v-bind="attrs" v-on="on">
                                        <v-btn @click="showModal" fab color="#B72C2C" dark>
                                            <v-icon>add</v-icon>
                                        </v-btn>
                                    </span>
                                </template>
                                <span>Ajouter une opération</span>
                            </v-tooltip>
                        </v-flex>
                    </v-layout>
                    <!-- bande -->

                    <br />
                    <v-card :loading="loading" :disabled="isloading">
                        <v-card-text>
                            
                            <v-simple-table>
                                <template v-slot:default>
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th class="text-left">Nom</th>
                                            <th class="text-left">Sexe</th>
                                            <th class="text-left">Age</th>
                                            <th class="text-left">GroupeS.</th>
                                            <th class="text-left">Catégorie</th>
                                            <th class="text-left">Province</th>
                                            <th class="text-left">Ville et quartier</th>
                                            <th class="text-left">Commune et Avenue</th>

                                            <th>Mise à jour</th>

                                            <th class="text-left">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="item in fetchData" :key="item.id">
                                            <td>

                                                <!-- image -->
                                                <img style="border-radius: 50px; width: 50px; height: 50px" :src="item.photo == null
                                                    ? `${baseURL}/fichier/avatar.png`
                                                    : `${baseURL}/fichier/` + item.photo
                                                    " />
                                                <!-- images -->
                                            </td>
                                            <td>{{ item.noms }}
                                            </td>
                                            <td>
                                                {{ item.sexe_malade }}
                                            </td>
                                            <td>

                                                {{ item.age_malade }}

                                            </td>
                                            <td>

                                                {{ item.groupesanguin }}

                                            </td>
                                            <td>{{ item.Categorie }}</td>
                                            <td>{{ item.nomProvince }}</td>
                                            <td>{{ item.nomVille + "-" + item.nomCommune }}</td>
                                            <td>{{ item.nomQuartier + "-" + item.nomAvenue }}</td>

                                            <td>
                                                {{ item.created_at | formatDate }}
                                                {{ item.created_at | formatHour }}
                                            </td>

                                            <td>
                                                <v-menu bottom rounded offset-y transition="scale-transition">
                                                    <template v-slot:activator="{ on }">
                                                        <v-btn icon v-on="on" small fab depressed text>
                                                            <v-icon>more_vert</v-icon>
                                                        </v-btn>
                                                    </template>

                                                    <v-list dense width="">

                                                        <v-list-item v-if="(roless[0].update == 'OUI')" link
                                                            @click="editData(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Modifier</v-list-item-title>
                                                        </v-list-item>

                                                        <!-- <v-list-item v-if="(roless[0].delete == 'OUI')" link
                                                            @click="desactiverData(item.id,item.author,item.created_at,item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">delete</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Supprimer</v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-list-item v-if="(roless[0].delete == 'OUI')" link
                                                            @click="clearP(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">delete</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title
                                                                style="margin-left: -20px">Supprimer</v-list-item-title>
                                                        </v-list-item>

                                                        <!-- clearP -->

                                                        <v-list-item link @click="printBill(item.id)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">print</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Imprimer Carte
                                                                Medicale</v-list-item-title>
                                                        </v-list-item>

                                                        <!-- <v-list-item link
                                                            @click="showProfileModalclient(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon>description</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Detail du
                                                                Malade</v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-divider></v-divider>
                                                        <v-subheader>Deroulement</v-subheader>
                                                        <v-divider></v-divider>

                                                        <!-- <v-list-item v-if="item.Categorie == 'ABONNE(E)'" link router
                                                            :to="'/admin/affectationabonne/' + item.id">
                                                            <v-list-item-icon>
                                                                <v-icon>mdi-account-check</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Prise en Charge
                                                            </v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-list-item v-if="item.Categorie == 'ABONNE(E)'"
                                                            @click="showAffectationAbonne(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">mdi-account-check</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Prise en Charge
                                                            </v-list-item-title>
                                                        </v-list-item>



                                                        <!-- <v-list-item link router :to="'/admin/mouvement_malade/' + item.id">
                                                            <v-list-item-icon>
                                                                <v-icon>mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Creer une Episodes
                                                                Maladie
                                                            </v-list-item-title>
                                                        </v-list-item> -->

                                                        <v-list-item link @click="showEpisodeMaladie(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">mdi-account-star</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Creer une Episodes
                                                                Maladie
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item link @click="showMaladieChronique(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">mdi-alert</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Signaler Maladies
                                                                Chroniques
                                                            </v-list-item-title>
                                                        </v-list-item>

                                                        <v-list-item link @click="showAnnexe_Patient(item.id, item.noms)">
                                                            <v-list-item-icon>
                                                                <v-icon color="#B72C2C">edit</v-icon>
                                                            </v-list-item-icon>
                                                            <v-list-item-title style="margin-left: -20px">Les Docuements en Annxe pour le Patient
                                                            </v-list-item-title>
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
                                :total-visible="7" @input="onPageChange"></v-pagination>
                        </v-card-text>
                    </v-card>
                    <!-- les composants -->

                    <!-- fin des composants -->
                </v-flex>
            </v-layout>
        </v-flex>
    </v-layout>
</template>
    
<script>
import { mapGetters, mapActions } from "vuex";
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";
import AvatarProfil from "./AvatarProfil.vue"
import avatarAvatar from './AvatarAction.vue'
import ModalMouvement_malade from './ModalMouvement_malade.vue';
import ModelAffectationAbonne from './ModalAffectationAbone.vue';
import MaladieChronique from './Consultations/MaladieChronique.vue';
import Annexe_Patient from './Consultations/Annexe_Patient.vue';

export default {
    components: {
        AvatarProfil,
        avatarAvatar,
        ModalMouvement_malade,
        ModelAffectationAbonne,
        MaladieChronique,
        Annexe_Patient
    },
    data() {
        return {
            header: "crud operation",
            titleComponent: "",
            query: "",
            dialog: false,
            loading: false,
            disabled: false,
            edit: false,

            isCameraOpen: false,
            isPhotoTaken: false,
            isShotPhoto: false,
            isLoading2: false,
            link: '#',

            style: {
                height: "0px",
            },
            svData: {
                id: "",
                noms: "",
                contact: "",
                mail: "",
                refAvenue: "",
                refCategieClient: "",
                author: "Admin",
                sexe_malade: "",
                dateNaissance_malade: "",
                etatcivil_malade: "",
                numeroMaison_malade: "",
                fonction_malade: "",
                groupesanguin: "",
                personneRef_malade: "",
                fonctioPersRef_malade: "",
                contactPersRef_malade: "",
                organisation_malade: "",
                numeroCarte_malade: "",
                dateExpiration_malade: "",
                Categorie: "",
                idPays: "",
                idProvince: "",
                idVille: "",
                idCommune: "",
                idQuartier: ""
            },
            stataData: {
                paysList: [],
                provinceList: [],
                villeList: [],
                communeList: [],
                quartierList: [],
                avenueList: [],


            },
            fetchData: null,
            titreModal: "",
            image: "",
            clientList: [],
            editor: ClassicEditor,
            editorConfig: {
                // The configuration of the editor.
                //  toolbar: [ 'bold', 'italic', '|', 'link' ]
            },

            inserer: '',
            modifier: '',
            supprimer: '',
            chargement: '',
            maladeList: [],
            etatSearch:false,
        };
    },

    computed: {
        ...mapGetters(["basicList", "paysList",
            "provinceList", "ListeEdition", "entrepriseList", "isloading"]),
    },
    methods: {
        ...mapActions(["getBasic", "getPays", "getCategorie",
            "getProvince", "getEntrepriseList", "getMyEntrepriseList"]),
        showModal() {
            this.dialog = true;
            this.titleComponent = "Enregistrement du Malade ";
            this.edit = false;
            this.resetObj(this.svData);
        },

        onPageTexteSearch(text) {
            if (text != "") {

                this.editOrFetch(`${this.apiBaseURL}/ad1/searchMaladeTeste?query=${text}`).then(
                    ({ data }) => {
                        var donnees = data.data;
                        this.maladeList = donnees;

                        this.etatSearch = true;

                    }
                );

            } else {

            }

        },

        setNom(text)
        {
            this.svData.noms = text;
            this.etatSearch = false;

        },

        testTitle() {
            if (this.edit == true) {
                this.titleComponent = "Modification du Malade ";
                this.style.height = "0px";
            } else {
                this.titleComponent = "Paramètrage du Client ";
                this.style.height = "0px";
            }
        },
        onPageChange() {
            //var connected = this.userData.id;
            this.fetch_data(`${this.apiBaseURL}/ad1/fetch_client?page=`);
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
        fetchListSelection() {
            this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_list_categorie`).then(
                ({ data }) => {
                    var donnees = data.data;
                    this.clientList = donnees;

                }
            );
        },
        updatePhoto() {

            this.isLoading(true);

            const config = {
                headers: { "content-type": "multipart/form-data" },
            };

            let formData = new FormData();
            formData.append("data", JSON.stringify(this.svData));
            formData.append("image", this.image);

            if (this.edit == true) {
                axios
                    .post(`${this.apiBaseURL}/ad1/update_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();

                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            } 
            else {
                axios
                    .post(`${this.apiBaseURL}/ad1/insert_client`, formData, config)
                    .then(({ data }) => {
                        this.image = "";
                        this.showMsg(data.data);

                        this.isLoading(false);
                        this.edit = false;
                        this.resetObj(this.svData);
                        this.onPageChange();
                        this.dialog = false;

                        // setTimeout(() => window.location.reload(), 2000);
                        document.getElementById("photo_input").value = "";
                        document.getElementById("output").src = "";
                    })
                    .catch((err) => this.svErr());
            }
        },

        validate() {
            if (this.$refs.form.validate()) {
                // this.isLoading(true);

                if (this.edit) {
                    this.updatePhoto();
                } else {
                    this.updatePhoto();
                }
            }
        },
        editData(id) {
            this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_single_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;


                    donnees.map((item) => {
                        this.svData.id = item.id;
                        this.titleComponent = "modification de  formation de l'entreprise ";
                        this.get_data_tug_pays(item.idPays);
                        this.get_data_tug_province(item.idProvince);
                        this.get_data_tug_commune(item.idVille);
                        this.get_data_tug_quartier(item.idCommune);
                        this.get_data_tug_Avenue(item.idQuartier)
                    });

                    this.getSvData(this.svData, data.data[0]);
                    this.edit = true;
                    this.dialog = true;
                }
            );
        },

        clearP(id) {
            this.confirmMsg().then(({ res }) => {
                var connected = this.userData.id;
                this.delGlobal(`${this.apiBaseURL}/ad1/delete_client/${id}`).then(
                    ({ data }) => {
                        this.successMsg(data.data);
                        this.onPageChange();
                    }
                );
            });
        },

        editTitleModal(id) {
            this.editOrFetch(`${this.apiBaseURL}/ad1/fetch_single_client/${id}`).then(
                ({ data }) => {
                    var donnees = data.data;
                    donnees.map((item) => {
                        this.titleComponent = "modification de  client de l'entreprise";
                    });
                }
            );
        },

        //les operation commence
        //fultrage de donnees
        async get_data_tug_pays(id_pays) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_province_tug_pays/${id_pays}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.provinceList = chart;
                    } else {
                        this.stataData.provinceList = [];
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

        async get_data_tug_province(idProvince) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_ville_tug_pays/${idProvince}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.villeList = chart;
                    } else {
                        this.stataData.villeList = [];
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

        async get_data_tug_commune(idVille) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_commune_tug_ville/${idVille}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.communeList = chart;
                    } else {
                        this.stataData.communeList = [];
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

        async get_data_tug_quartier(idCommune) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/fetch_quartier_tug_commune/${idCommune}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.quartierList = chart;
                    } else {
                        this.stataData.quartierList = [];
                    }

                    this.isLoading(false);

                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },

        async get_data_tug_Avenue(idQuartier) {
            this.isLoading(true);
            await axios
                .get(`${this.apiBaseURL}/ad1/getAvenueTug/${idQuartier}`)
                .then((res) => {
                    var chart = res.data.data;

                    if (chart) {
                        this.stataData.avenueList = chart;
                    } else {
                        this.stataData.avenueList = [];
                    }

                    this.isLoading(false);

                })
                .catch((err) => {
                    this.errMsg();
                    this.makeFalse();
                    reject(err);
                });
        },



        initialisation() {
            this.fetch_province_2();
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

        printBill(id) {
            window.open(`${this.apiBaseURL}/pdf_carte_medicale?id=` + id);
        },

        updateEtat() {
            this.etatSearch=false;
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

        showEpisodeMaladie(refMalade, name) {

            if (refMalade != '') {

                this.$refs.ModalMouvement_malade.$data.etat = true;
                this.$refs.ModalMouvement_malade.$data.refMalade = refMalade;
                // this.$refs.ModalMouvement_malade.$data.agemvt = age_malade;
                this.$refs.ModalMouvement_malade.$data.svData.refMalade = refMalade;
                // this.$refs.ModalMouvement_malade.$data.svData.agemvt = age_malade;
                this.$refs.ModalMouvement_malade.getRouteParamMalade(refMalade);
                this.$refs.ModalMouvement_malade.getAbonnement(refMalade, 'Encours');

                this.$refs.ModalMouvement_malade.fetchListSelection();
                this.$refs.ModalMouvement_malade.fetchListServices();
                this.$refs.ModalMouvement_malade.fetchListmedecin();
                this.$refs.ModalMouvement_malade.fetchListtypeconsultation();
                this.$refs.ModalMouvement_malade.fetchListDepartement();
                this.$refs.ModalMouvement_malade.fetchListTypeProduit();
                this.$refs.ModalMouvement_malade.get_mode_Paiement();

                this.$refs.ModalMouvement_malade.$data.titleComponent =
                    "Créer une épisode maladide pour " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },

        showAffectationAbonne(refMalade, name) {

            if (refMalade != '') {

                this.$refs.ModelAffectationAbonne.$data.etatModal = true;
                this.$refs.ModelAffectationAbonne.$data.refMalade = refMalade;
                this.$refs.ModelAffectationAbonne.$data.svData.refMalade = refMalade;
                this.$refs.ModelAffectationAbonne.fetchDataList_all(refMalade);

                this.$refs.ModelAffectationAbonne.$data.titleComponent =
                    "Créer une affectation abonné  " + name;

            } else {
                this.showError("Personne n'a fait cette action");
            }

        },

        showMaladieChronique(refMalade, name) {

            if (refMalade != '') {

                this.$refs.MaladieChronique.$data.etatModal = true;
                this.$refs.MaladieChronique.$data.refMalade = refMalade;
                this.$refs.MaladieChronique.$data.svData.refMalade = refMalade;
                this.$refs.MaladieChronique.fetchDataList();
                this.$refs.MaladieChronique.fetchListSelection();

                this.$refs.MaladieChronique.$data.titleComponent =
                    "Les Maladies Chroniques  " + name;

            } else {
                this.showError("Personne n'a fait cette action");
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
    desactiverData(valeurs,user_created,date_entree,noms) {
//
      var tables='tclient';
      var user_name=this.userData.name;
      var user_id=this.userData.id;
      var detail_information="Suppression d'un patient au nom de : "+noms+" par l'utilisateur "+user_name+"" ;

      this.confirmMsg().then(({ res }) => {
        this.delGlobal(`${this.apiBaseURL}/desactiver_data?tables=${tables}&user_name=${user_name}&user_id=${user_id}&valeurs=${valeurs}&user_created=${user_created}&date_entree=${date_entree}&detail_information=${detail_information}`).then(
          ({ data }) => {
            this.showMsg(data.data);
            this.onPageChange();
          }
        );
      });
    },





        //MaladieChronique

        // PARTIE CAPTURE IMAGERIE 


        toggleCamera() {
            if (this.isCameraOpen) {
                this.isCameraOpen = false;
                this.isPhotoTaken = false;
                this.isShotPhoto = false;
                this.stopCameraStream();
            } else {
                this.isCameraOpen = true;
                this.createCameraElement();
            }
        },

        createCameraElement() {
            this.isLoading2 = true;

            const constraints = (window.constraints = {
                audio: false,
                video: true
            });


            navigator.mediaDevices
                .getUserMedia(constraints)
                .then(stream => {
                    this.isLoading2 = false;
                    this.$refs.camera.srcObject = stream;
                })
                .catch(error => {
                    this.isLoading2 = false;
                    alert("May the browser didn't support or there is some errors.");
                });
        },

        stopCameraStream() {
            let tracks = this.$refs.camera.srcObject.getTracks();

            tracks.forEach(track => {
                track.stop();
            });
        },

        takePhoto() {
            if (!this.isPhotoTaken) {
                this.isShotPhoto = true;

                const FLASH_TIMEOUT = 50;

                setTimeout(() => {
                    this.isShotPhoto = false;
                }, FLASH_TIMEOUT);
            }

            this.isPhotoTaken = !this.isPhotoTaken;

            const context = this.$refs.canvas.getContext('2d');
            context.drawImage(this.$refs.camera, 0, 0, 450, 337.5);
        },
        downloadImage() {
            const download = document.getElementById("downloadPhoto");
            const canvas = document.getElementById("photoTaken").toDataURL("image/jpeg")
                .replace("image/jpeg", "image/octet-stream");
            download.setAttribute("href", canvas);
        }


    },
    created() {

        this.onPageChange();
        this.testTitle();
        this.onPageChange();
        this.getPays();
        this.getCategorie();
        this.fetchListSelection();

    },
};
</script>
<style lang="scss">   //  @import url('../../cssimage/image.scss');
</style>  
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
#etatSearch{
    width: 100%;
    height: 250px;
    max-height: 250vh;
    border: 1px bisque;
    border-radius: 20%;
}
</style>