<template>
  <v-app id="inspire">
    <!-- navigation -->
    <v-navigation-drawer v-model="drawer" app>
      <!-- navigation -->
      <Navigation :linkAdmin="linkAdmin" />
      <!-- fin navigation -->
    </v-navigation-drawer>
    <!-- fin navigation -->

    <!-- appbar -->
    <v-app-bar app elevate-on-scroll elevation="3" color="white">
      <v-app-bar-nav-icon @click="drawer = !drawer"> </v-app-bar-nav-icon>
      <v-spacer />
      <v-col lg="6" cols="6" xs="6">
        <!-- <v-form>
          <v-text-field
            class="p-0 m-0 mt-6"
            full-width
            dense
            append-icon="mdi-magnify"
            outlined
            rounded
            placeholder="Search"
          />
        </v-form> -->
      </v-col>
      <v-spacer />

      <v-btn @click="changeTheme" small fab depressed class="mr-2">
        <v-icon>{{ themeIcon }}</v-icon>
      </v-btn>

      <!-- notification -->

      <!-- <Notification /> -->

      <!-- fin notification -->

      <!-- navMenu avatar -->
      <NavMenu />
      <!-- fin navMenu avatar -->

      <v-spacer></v-spacer>

      <v-menu bottom rounded offset-y transition="scale-transition">
        <template v-slot:activator="{ on }">
          <v-btn icon x-large v-on="on">

            <v-tooltip bottom color="black">
              <template v-slot:activator="{ on, attrs }">

                <span v-bind="attrs" v-on="on">
                  <v-avatar size="48" color="rgb(183, 44, 44)">
                    <span class="white--text headline" style="text-transform: lowercase">
                      {{ userData.name | subStr }}
                    </span>
                  </v-avatar>
                </span>

              </template>
              <span>Mon comptes</span>
            </v-tooltip>

          </v-btn>
        </template>
        <v-card width="300">
          <v-card-text>
            <div style="text-align: center">
              <v-avatar size="60" color="rgb(183, 44, 44)">
                <span class="white--text headline">{{
                  userData.name | subStr
                }}</span>
              </v-avatar><br />
              <b style="text-transform: lowercase">{{
                userData.name
              }}</b>
              <br />
              {{ userData.email }}

              <!-- <v-btn :to="'/apps/profil/'+this.userData.teacher_id" small rounded outlined style="text-style:lowercase" >gérer mon compte school</v-btn> -->
              <br /><br />
              <v-divider></v-divider><br />
              <v-btn small outlined :href="`/logout`">
                <v-icon>exit_to_app</v-icon>
                déconnexion
              </v-btn>
            </div>
          </v-card-text>
        </v-card>
      </v-menu>

    </v-app-bar>
    <!-- fin apbar -->

    <v-main style="background: #f5f5f540">
      <v-container class="py-8 px-6" fluid>
        <router-view></router-view>
      </v-container>
    </v-main>
  </v-app>
</template>

<script>
import Navigation from "./component/navigation.vue";
import Notification from "./component/notification.vue";
import NavMenu from "./component/navMenu.vue";
export default {
  name: "App",
  components: {
    Navigation,
    Notification,
    NavMenu,
  },
  data() {
    return {
      cards: ["Today", "Yesterday"],
      drawer: true,

      themeIcon: "dark_mode",
      lightBg: "background: rgb(246 248 250)",
      darkBg: "background:rgb(40, 42, 54)",

      linkAdmin: [],
    };
  },
  created() {
    this.showConnected();
    this.testLink();
  },
  methods: {
    showConnected() {
      var connected = this.userData.email;
      // console.log("user connected:" + connected);
    },
    changeTheme() {
      this.$vuetify.theme.dark = !this.$vuetify.theme.dark;
      !this.$vuetify.theme.dark ? this.lightMode() : this.darkMode();
    },
    lightMode() {
      this.themeIcon = "dark_mode";
      this.$store.state.bgColor = this.lightBg;
    },
    darkMode() {
      this.themeIcon = "light_mode";
      this.$store.state.bgColor = this.darkBg;
    },
    testLink() {
      if (this.userData.id_role == 1) {
        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/admin/dashstatistique",
            }
          ],

          links_operation: [

            {
              icon: "store",
              text: "Pays",
              href: "/admin/pays",
            },
            {
              icon: "store",
              text: "Province",
              href: "/admin/province",
            },
            {
              icon: "store",
              text: "Ville",
              href: "/admin/ville",
            },
            {
              icon: "store",
              text: "Commune",
              href: "/admin/commune",
            },

            {
              icon: "store",
              text: "Quartier",
              href: "/admin/quartier",
            },

            {
              icon: "store",
              text: "Avenue",
              href: "/admin/avenue",
            },

            {
              icon: "store",
              text: "Secteur d'activité",
              href: "/admin/secteur",
            },

            {
              icon: "store",
              text: "Forme juridique",
              href: "/admin/formeJuridique",
            },

            {
              icon: "store",
              text: "Mot de la semaine",
              href: "/admin/week",
            },


          ],

          links_operation_2: [
            {
              icon: "store",
              text: "Entreprise",
              href: "/admin/entreprise",
            },
            {
              icon: "store",
              text: "Utilisateurs",
              href: "/admin/utilisateurs",
            },
            {
              icon: "store",
              text: "Roles",
              href: "/admin/role",
            },
            {
              icon: "store",
              text: "Ménus",
              href: "/admin/ListeMenu",
            },
            {
              icon: "store",
              text: "Restaurer les entreprises",
              href: "/admin/restaureEntrep",
            },
            {
              icon: "store",
              text: "Historiques des données",
              href: "/admin/HistoriqueData",
            }
          ],
          links_operation_3: [
            {
              icon: "mdi-medical-bag",
              text: "Examens",
              href: "/admin/examen",
            },
            {
              icon: "mdi-medical-bag",
              text: "Cat.Examens",
              href: "/admin/categorie_examen",
            },
            {
              icon: "mdi-medical-bag",
              text: "GCat.Examens",
              href: "/admin/grand_categorie_examen",
            },
            {
              icon: "mdi-medical-bag",
              text: "Valeurs",
              href: "/admin/valeur_normale",
            },
            {
              icon: "mdi-medical-bag",
              text: "Tubes",
              href: "/admin/tube_examen",
            },
            {
              icon: "mdi-medical-bag",
              text: "Echantillon",
              href: "/admin/natureechantillon",
            },
            {
              icon: "mdi-medical-bag",
              text: "Méthode",
              href: "/admin/methodeexamen",
            },
            {
              icon: "mdi-medical-bag",
              text: "Unité",
              href: "/admin/unitevaleur",
            },
            {
              icon: "mdi-medical-bag",
              text: "Cat.Valeurs",
              href: "/admin/categorievaleur",
            }
            //Typedocumentneuro
          ],
          links_operation_4: [
            {
              icon: "mdi-medical-bag",
              text: "Maladies",
              href: "/admin/Maladie",
            },
            {
              icon: "mdi-medical-bag",
              text: "Type Documents Neuro",
              href: "/admin/Typedocumentneuro",
            },
            {
              icon: "groups",
              text: "ActeMedecin",
              href: "/admin/ActeMedecin",
            },
            {
              icon: "mdi-medical-bag",
              text: "Cat.Maladie",
              href: "/admin/CategorieMaladie",
            },
            {
              icon: "mdi-medical-bag",
              text: "Consultation",
              href: "/admin/type_consultation",
            },
            {
              icon: "mdi-medical-bag",
              text: "TypeMouvement",
              href: "/admin/type_mouvement_malade",
            },
            {
              icon: "mdi-medical-bag",
              text: "Fonct.Medecin",
              href: "/admin/fonction_medecin",
            },
            {
              icon: "mdi-medical-bag",
              text: "Services Hopital",
              href: "/admin/service_hopital",
            },
            {
              icon: "mdi-medical-bag",
              text: "Cat.Medecin",
              href: "/admin/categorie_medecin",
            },
            {
              icon: "mdi-medical-bag",
              text: "Type Plaie",
              href: "/admin/Hospi_TypePlaie",
            },
            {
              icon: "mdi-medical-bag",
              text: "Type Intervention",
              href: "/admin/Intervention",
            },
            {
              icon: "mdi-medical-bag",
              text: "Rubrique Surveil.",
              href: "/admin/RubriqueSurveillance",
            },
            {
              //CategorieSociete
              text: "Cat. Société",
              href: "/admin/CategorieSociete",
            },
            {
              icon: "mdi-medical-bag",
              text: "Organisations(Conv.)",
              href: "/admin/organisationabonne",
            }

          ],
          links_operation_5: [
            {
              icon: "groups",
              text: "Classes",
              href: "/admin/ClassesFin",
            },
            {
              icon: "groups",
              text: "Comptes",
              href: "/admin/CompteFin",
            },
            {
              icon: "groups",
              text: "Sous Comptes",
              href: "/admin/SousCompte",
            },
            {
              icon: "groups",
              text: "SSous Comptes",
              href: "/admin/SSousCompte",
            },
            {
              icon: "groups",
              text: "Type Compte",
              href: "/admin/TypeCompte",
            },
            {
              icon: "groups",
              text: "Config. Taux",
              href: "/admin/TTaux",
            },
            {
              icon: "groups",
              text: "Type Position",
              href: "/admin/TypePosition",
            },
            {
              icon: "groups",
              text: "Type Opération",
              href: "/admin/TypeOperation",
            },
            {
              icon: "groups",
              text: "Type Produit",
              href: "/admin/TypeProduit",
            },
            {
              icon: "groups",
              text: "Departements",
              href: "/admin/DepartementFin",
            },
            {
              icon: "groups",
              text: "ServicesRendus",
              href: "/admin/UniteProduction",
            },
            {
              icon: "groups",
              text: "ProduitFin",
              href: "/admin/ProduitFin",
            },
            {
              icon: "groups",
              text: "ActeMedecin",
              href: "/admin/ActeMedecin",
            },
            {
              text: "Rubriques",
              href: "/admin/compte",
            },
            {
              text: "Caisse&Banque",
              href: "/admin/Banque",
            },
            {
              text: "Tarifications",
              href: "/admin/typetarif",
            },
            {
              text: "ModePaie",
              href: "/admin/modepaie",
            }

          ],

          links_systems: [

            {
              icon: "api",
              text: "Souscription",
              href: "/admin/categoriesous",
            },

            {
              icon: "api",
              text: "Type Client",
              href: "/admin/categorieclient",
            },

            {
              icon: "store",
              text: "Type Produits",
              href: "/admin/categorieproduit",
            },
            {
              icon: "store",
              text: "Elèment Produits",
              href: "/admin/elementproduit",
            },
          ],

          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],

          listGroupAll: [
            {
              text: "Reception",
              icon: "mdi-account-multiple",
              items: [
                {
                  text: "Patients",
                  href: "/admin/malades",
                },

                {
                  text: "Triages",
                  href: "/admin/entete_triage",
                },
                {
                  text: "Rendez-vous",
                  href: "/admin/agenda_reception",
                },
                {
                  text: "Rapports Triage",
                  href: "/admin/RapportsJour_Patient",
                },
                {
                  icon: "store",
                  text: "Pays",
                  href: "/admin/pays",
                },
                {
                  icon: "store",
                  text: "Province",
                  href: "/admin/province",
                },
                {
                  icon: "store",
                  text: "Ville",
                  href: "/admin/ville",
                },
                {
                  icon: "store",
                  text: "Commune",
                  href: "/admin/commune",
                },

                {
                  icon: "store",
                  text: "Quartier",
                  href: "/admin/quartier",
                },

                {
                  icon: "store",
                  text: "Avenue",
                  href: "/admin/avenue",
                }
              ],
            },
            {  //Entete_Consultation_Jour
              text: "Consultation",
              icon: "mdi-account-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Entete_Consultation_Jour",
                },
                {
                  text: "Toutes les Consultations",
                  href: "/admin/entete_consultation",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Param.Maladies",
                  href: "/admin/Maladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Documents Neuro",
                  href: "/admin/Typedocumentneuro",
                },
                {
                  icon: "groups",
                  text: "Param.ActeMedecin",
                  href: "/admin/ActeMedecin",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Maladie",
                  href: "/admin/CategorieMaladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Consultation",
                  href: "/admin/type_consultation",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "TypeMouvement",
                  href: "/admin/type_mouvement_malade",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Services Hopital",
                  href: "/admin/service_hopital",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Plaie",
                  href: "/admin/Hospi_TypePlaie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Intervention",
                  href: "/admin/Intervention",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Rubrique Surveil.",
                  href: "/admin/RubriqueSurveillance",
                }

              ],
            },
            {
              text: "Urgences",
              icon: "mdi-needle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/urgences_jour",
                },
                {
                  text: "Toutes les Urgences",
                  href: "/admin/urgences",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },

          ],

          listGroup1: [
            {
              text: "Reception",
              icon: "mdi-account-multiple",
              items: [
                {
                  text: "Patients",
                  href: "/admin/malades",
                },

                {
                  text: "Triages",
                  href: "/admin/entete_triage",
                },
                {
                  text: "Rendez-vous",
                  href: "/admin/agenda_reception",
                },
                {
                  text: "Rapports Triage",
                  href: "/admin/RapportsJour_Patient",
                },
                {
                  icon: "store",
                  text: "Pays",
                  href: "/admin/pays",
                },
                {
                  icon: "store",
                  text: "Province",
                  href: "/admin/province",
                },
                {
                  icon: "store",
                  text: "Ville",
                  href: "/admin/ville",
                },
                {
                  icon: "store",
                  text: "Commune",
                  href: "/admin/commune",
                },

                {
                  icon: "store",
                  text: "Quartier",
                  href: "/admin/quartier",
                },

                {
                  icon: "store",
                  text: "Avenue",
                  href: "/admin/avenue",
                },

              ],
            },
          ],
          listGroup2: [
            {  //Entete_Consultation_Jour
              text: "Consultation",
              icon: "mdi-account-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Entete_Consultation_Jour",
                },
                {
                  text: "Toutes les Consultations",
                  href: "/admin/entete_consultation",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Param.Maladies",
                  href: "/admin/Maladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Documents Neuro",
                  href: "/admin/Typedocumentneuro",
                },
                {
                  icon: "groups",
                  text: "Param.ActeMedecin",
                  href: "/admin/ActeMedecin",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Maladie",
                  href: "/admin/CategorieMaladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Consultation",
                  href: "/admin/type_consultation",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "TypeMouvement",
                  href: "/admin/type_mouvement_malade",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Services Hopital",
                  href: "/admin/service_hopital",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Plaie",
                  href: "/admin/Hospi_TypePlaie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Intervention",
                  href: "/admin/Intervention",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Rubrique Surveil.",
                  href: "/admin/RubriqueSurveillance",
                }
              ],
            },
          ],
          listGroup3: [
            {
              text: "Urgences",
              icon: "mdi-needle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/urgences_jour",
                },
                {
                  text: "Toutes les Urgences",
                  href: "/admin/urgences",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup4: [
            {
              text: "Pédiatrie",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "CPS",
                  href: "/admin/EnteteCPS_Resultat",
                },
                {
                  text: "CPN",
                  href: "/admin/EnteteCPN_Resultat",
                }
                ,
                {
                  text: "Tests Cutanés",
                  href: "/admin/EnteteTestCutane",
                },
                {
                  text: "Archivages",
                  href: "/admin/Archivages",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                {
                  text: "Type Vaccin",
                  href: "/admin/VaccinEnfant",
                },
                {
                  text: "Catégorie Vaccin",
                  href: "/admin/CategorieVacEnfant",
                },
                {
                  text: "Période Vaccin",
                  href: "/admin/PeriodeVaccinEnfant",
                },
                {
                  text: "Stratégie Vaccination",
                  href: "/admin/StrategieVaccin",
                },
                {
                  text: "Modes Atteintes Enfants",
                  href: "/admin/ModeAtteinteEnfant",
                },
                {
                  text: "Période CPS",
                  href: "/admin/PeriodeCPS",
                },
                {
                  text: "Période Vaccination mère",
                  href: "/admin/PeriodeVaccinMere",
                },
                {
                  text: "Période CPN",
                  href: "/admin/PeriodeCPN",
                },
                {
                  text: "Période SP",
                  href: "/admin/PeriodeSP",
                },
                {
                  text: "Période CPON",
                  href: "/admin/PeriodeCPON",
                },
                {
                  text: "Période Peni",
                  href: "/admin/PeriodePeni",
                },
                {
                  text: "Rubrique Test Cutané",
                  href: "/admin/TypeTestCutane",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup5: [
            {
              text: "Laboratoire",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Prélevements",
                  href: "/admin/EntetePrelevement_Preleveur",
                },
                {
                  text: "Résultats",
                  href: "/admin/EntetePrelevement_Analyse",
                },
                {
                  text: "Tabultations",
                  href: "/admin/Tabilation",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Laboratoire",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Examens",
                  href: "/admin/examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Examens",
                  href: "/admin/categorie_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "GCat.Examens",
                  href: "/admin/grand_categorie_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Valeurs",
                  href: "/admin/valeur_normale",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Tubes",
                  href: "/admin/tube_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Echantillon",
                  href: "/admin/natureechantillon",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Méthode",
                  href: "/admin/methodeexamen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Unité",
                  href: "/admin/unitevaleur",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Valeurs",
                  href: "/admin/categorievaleur",
                },
                {
                  text: "Examen après Coloration",
                  href: "/admin/ExamenColore",
                },
                {
                  text: "Les Germes",
                  href: "/admin/GermeColore",
                },
                {
                  text: "Echantillons(Sperme)",
                  href: "/admin/NatureEchantillonSperme",
                },
                {
                  text: "Cat.Echantillons(Sperme)",
                  href: "/admin/CategorieEchantillonSperme",
                }
              ],
            },
          ],
          listGroup6: [
            {
              text: "Imageries",
              icon: "mdi-monitor-multiple",
              items: [
                {
                  text: "Imageries",
                  href: "/admin/ImageriesResultat",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                // {
                //   text: "Les Externes",
                //   href: "/admin/ImageriesResultatExt",
                // },
                {
                  text: "AnalyseImagerie",
                  href: "/admin/AnalyseImagerie",
                },
                {
                  text: "TypeAnalyse",
                  href: "/admin/TypeAnalyse",
                },
                {
                  text: "Interval Score",
                  href: "/admin/IntervalScore",
                },
                {
                  text: "Libellé Score",
                  href: "/admin/LibelleScore",
                },
                {
                  text: "Paramètre Score",
                  href: "/admin/ParametreScore",
                }
              ],
            },
          ],
          listGroup7: [
            {
              text: "Dialyse",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/EnteteDialyse_jour",
                },
                {
                  text: "Toutes les Dialyses",
                  href: "/admin/EnteteDialyse",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  text: "Vaccins",
                  href: "/admin/Vaccins",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                {
                  text: "Catégorie Vaccin",
                  href: "/admin/CategorieVaccin",
                },
                {
                  text: "Type Machine",
                  href: "/admin/TypeMachine",
                }
              ],
            },
          ],
          listGroup8: [
            {
              text: "Kinesitherapie",
              icon: "mdi-checkbox-multiple-marked-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Kinesitherapie_result_jour",
                },
                {
                  text: "Toutes Séances",
                  href: "/admin/Kinesitherapie_result",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup9: [
            {
              text: "Hospitalisation",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "En Hospitalisation",
                  href: "/admin/HospitalisationAll",
                },
                {
                  text: "Les Sorti(e)s",
                  href: "/admin/HospitalisationSortie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  text: "Salles",
                  href: "/admin/Salle",
                },
                {
                  text: "Service Hospi.",
                  href: "/admin/ServiceHopi",
                }
                // ,
                // {
                //   text: "Service Soins",
                //   href: "/admin/ServiceSoin",
                // }
              ],
            },
          ],
          listGroup10: [
            {
              text: "Réanimation",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "En Réanimations",
                  href: "/admin/ReanimationEncours",
                },
                {
                  text: "Les Sorti(e)s",
                  href: "/admin/ReanimationSortie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup11: [
            {
              text: "Bloc Operatoire",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/EnteteChirurgie_jour",
                },
                {
                  text: "Toutes les Chirurgies",
                  href: "/admin/EnteteChirurgie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup12: [
            {
              //EnteteBesoinAll
              text: "Pharmacie",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Approvisionements",
                  href: "/admin/entete_entree",
                },
                {
                  text: "Ventes",
                  href: "/admin/entete_vente",
                },
                {
                  text: "Besoin des Services",
                  href: "/admin/EnteteBesoinAll",
                },
                {
                  text: "Sortie/Services",
                  href: "/admin/entete_sortie",
                },
                {
                  text: "Medicaments",
                  href: "/admin/Medicament",
                },
                {
                  text: "Fournisseur",
                  href: "/admin/Fournisseur",
                },
                {
                  icon: "groups",
                  text: "ProduitFacturable",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Categorie",
                  href: "/admin/CategorieMedicament",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Pharmacie",
                }
              ],
            },
          ],
          listGroup13: [
            {
              text: "RH",
              icon: "mdi-account-settings",
              items: [
                {
                  text: "Personnels",
                  href: "/admin/medecin",
                },
                {
                  //FichePaieGlobale
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  //FichePaieGlobale
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                {
                  //FichePaieGlobale
                  text: "Rapports",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Catégorie Agent",
                  href: "/admin/CategorieAgent",
                },
                {
                  text: "Type RubriquesPaies",
                  href: "/admin/CategorieRubriquePers",
                },
                {
                  text: "RubriquesPaies",
                  href: "/admin/RubriquePaie",
                },
                {
                  text: "Param. RubriquesPaies",
                  href: "/admin/ParametreRubrique",
                },
                {
                  text: "Catégorie Service",
                  href: "/admin/CategorieServicePers",
                },
                {
                  text: "Service Pers.",
                  href: "/admin/ServicePersonnel",
                },
                {
                  text: "Année",
                  href: "/admin/Annee",
                },
                {
                  text: "Mois",
                  href: "/admin/Mois",
                },
                {
                  text: "Raison Familliale",
                  href: "/admin/RaisonFamilliale",
                },
                {
                  text: "Horaires",
                  href: "/admin/membres",
                }
              ],
            },
          ],
          listGroup14: [
            {  //RapportMedical_Finance
              text: "Facturations",
              icon: "mdi-cash-100",
              items: [
                // {
                //   text: "Facturation",
                //   href: "/admin/facturation",
                // },
                {
                  text: "Facturation",
                  href: "/admin/CreateFacture",
                },
                {
                  text: "Autorier Consultations",
                  href: "/admin/Consultation_Finance",
                },
                {
                  text: "Autorier Urgences",
                  href: "/admin/Urgence_Finance",
                },
                {
                  text: "Autorier le Prélevement",
                  href: "/admin/EntetePrelevement_Finance",
                },
                {
                  text: "Créer la Facture",
                  href: "/admin/CreateFacture",
                },
                {
                  text: "Autorier Imagerie",
                  href: "/admin/ImageriesFinance",
                },
                // {
                //   text: "Autorier Imagerie(Transfert)",
                //   href: "/admin/ImageriesFinanceExt",
                // },
                // {
                //   text: "Autorier Examens(Ordonances)",
                //   href: "/admin/Mvt_malade_Labo_Finance",
                // },
                {
                  text: "Autorier Rapprt Medical",
                  href: "/admin/RapportMedical_Finance",
                },
                {
                  text: "Autorier Kinesitherapie",
                  href: "/admin/Kinesitherapie_finance",
                },
                {
                  text: "Imprimer Attestations",
                  href: "/admin/EnteteAttestationFinance",
                },
                {
                  text: "Attestation Naissance",
                  href: "/admin/EnteteCPS_Finance",
                },
                {
                  text: "Sortie Hospitalisation",
                  href: "/admin/SortieHospitalisationFinance",
                },
                {
                  icon: "groups",
                  text: "ProduitFacturable",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Fiche Tarification",
                  href: "/admin/RapportTarification",
                },
                {
                  text: "Recherche Facture",
                  href: "/admin/RechercheFacture",
                },
                {
                  text: "Recherche Reçu",
                  href: "/admin/RechercheRecu",
                },
                {
                  text: "Rapport Det.Facturation",
                  href: "/admin/RapportsDetailFacture",
                },
                {
                  text: "Rapport Synt.Facturation",
                  href: "/admin/RapportsEnteteFacture"
                },
                {
                  text: "Rapport Det.Fact.Privé(e)s",
                  href: "/admin/RapportsDetailFacturePrivee",
                },
                {
                  text: "Rapport Synt.Fact.Privé(e)s",
                  href: "/admin/RapportsEnteteFacturePrivee"
                },
                {
                  text: "Rapport Paiement Privé(e)s",
                  href: "/admin/RapportsPaiementFacturePrivee"
                },
                {
                  text: "Rapport Det.Fact.Abonné(e)s",
                  href: "/admin/RapportsDetailFactureAbonne",
                },
                {
                  text: "Rapport Synt.Fact.Abonné(e)s",
                  href: "/admin/RapportsEnteteFactureAbonne"
                },
                {
                  text: "Rapport Paies Abonné(e)s",
                  href: "/admin/RapportsPaiementFactureAbonnee"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport des Paiements",
                  href: "/admin/RapportsPaiementFacture"
                },
                {
                  text: "Rapport Recettes/Depenses",
                  href: "/admin/RapportsJour_Caisse"
                }
                //RapportsPaiementFacture
              ],
            },
          ],
          listGroup15: [
            {
              text: "Trésorerie",
              icon: "mdi-cards",
              items: [
                {
                  text: "Facturation",
                  href: "/admin/facturation",
                },
                {
                  text: "Recettes",
                  href: "/admin/recette",
                },
                {
                  text: "Etat de Besoin",
                  href: "/admin/EnteteEtatBesoin",
                },
                {
                  //EnteteBonEngagement
                  text: "Bon d'Engagement",
                  href: "/admin/EnteteBonEngagement",
                },
                {
                  text: "Fiche Tarification",
                  href: "/admin/RapportTarification",
                },
                {
                  text: "Cloture de la Caisse",
                  href: "/admin/Cloture_Caisse",
                },
                {  //ClotureComptabilite
                  text: "Comptabilité(Opé.)",
                  href: "/admin/EnteteOperationComptable",
                },
                {  //ClotureComptabilite
                  text: "Cloture de la Comptabilité",
                  href: "/admin/ClotureComptabilite",
                },
                {
                  text: "Recherche Facture",
                  href: "/admin/RechercheFacture",
                },
                {
                  text: "Recherche Reçu",
                  href: "/admin/RechercheRecu",
                },
                {
                  text: "Rapport Det.Facturation",
                  href: "/admin/RapportsDetailFacture",
                },
                {
                  text: "Rapport Synt.Facturation",
                  href: "/admin/RapportsEnteteFacture"
                },
                {
                  text: "Rapport Det.Fact.Privé(e)s",
                  href: "/admin/RapportsDetailFacturePrivee",
                },
                {
                  text: "Rapport Synt.Fact.Privé(e)s",
                  href: "/admin/RapportsEnteteFacturePrivee"
                },
                {
                  text: "Rapport Paies Privé(e)s",
                  href: "/admin/RapportsPaiementFacturePrivee"
                },
                {
                  text: "Rapport Det.Fact.Abonné(e)s",
                  href: "/admin/RapportsDetailFactureAbonne",
                },
                {
                  text: "Rapport Synt.Fact.Abonné(e)s",
                  href: "/admin/RapportsEnteteFactureAbonne"
                },
                {
                  text: "Rapport Paies Abonné(e)s",
                  href: "/admin/RapportsPaiementFactureAbonnee"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport des Paiements",
                  href: "/admin/RapportsPaiementFacture"
                },
                {
                  text: "Rapport Comptabilité",
                  href: "/admin/RapportsComptabilite"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport Recettes/Depenses",
                  href: "/admin/RapportsJour_Caisse"
                },
                {
                  icon: "groups",
                  text: "ProduitFin",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Rubriques Depenses",
                  href: "/admin/compte",
                },
                {
                  text: "Cat.Rubriques EB",
                  href: "/admin/CategorieRubrique",
                },
                {
                  text: "Rubriques EB",
                  href: "/admin/Rubriques",
                },
                {
                  text: "Blocs(Finances)",
                  href: "/admin/Blocs",
                },
                {
                  //CategorieSociete
                  text: "Cat. Société",
                  href: "/admin/CategorieSociete",
                },
                {
                  text: "Les Services(Finances)",
                  href: "/admin/Provenance",
                }
                //Cloture_Caisse
              ],
            },
          ],
          listGroup16: [
            {
              text: "Secrétariat",
              icon: "print",
              items: [
                {
                  text: "Rapports Medicals",
                  href: "/admin/RapportMedical_Secretariat",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                }
              ],
            },
          ],
          listGroup17: [
            {
              text: "Logistique",
              icon: "mdi-cart-outline",
              items: [
                {
                  text: "Approvisionements",
                  href: "/admin/LogEnteteEntree",
                },
                {
                  text: "Sortie/Services",
                  href: "/admin/LogEnteteSortie",
                },
                {
                  text: "Requisitions",
                  href: "/admin/LogEnteteRequisition",
                },
                {
                  text: "Articles",
                  href: "/admin/Produits",
                },
                {
                  text: "Fournisseur",
                  href: "/admin/Fournisseur",
                },
                {
                  text: "Categorie Art.",
                  href: "/admin/categorieproduit",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Logistique",
                }
              ],
            },
          ],
          listGroup18: [
            {  //RapportTarification
              text: "Rapports",
              icon: "description",
              items: [
                {
                  text: "Rapport SNIS",
                  href: "/admin/RapportsSNIS",
                },
                // {
                //   text: "Rapport Det.Facturation",
                //   href: "/admin/RapportsDetailFacture",
                // },
                // {
                //   text: "Fiche de Tarification",
                //   href: "/admin/RapportTarification",
                // }
              ],
            },
          ],
          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };
      }
      else {

        this.linkAdmin = {
          links: [
            {
              icon: "mdi-microsoft-windows",
              text: "Tableau de bord",
              href: "/admin/dashstatistique",
            }
          ],

          links_operation: [

            // {
            //   icon: "store",
            //   text: "Pays",
            //   href: "/admin/pays",
            // },

            // {
            //   icon: "store",
            //   text: "Province",
            //   href: "/admin/province",
            // },
            // {
            //   icon: "store",
            //   text: "Commune",
            //   href: "/admin/commune",
            // },

            // {
            //   icon: "store",
            //   text: "Quartier",
            //   href: "/admin/quartier",
            // },

            // {
            //   icon: "store",
            //   text: "Avenue",
            //   href: "/admin/avenue",
            // },

            // {
            //   icon: "store",
            //   text: "Secteur d'activité",
            //   href: "/admin/secteur",
            // },

            // {
            //   icon: "store",
            //   text: "Forme juridique",
            //   href: "/admin/formeJuridique",
            // },

            // {
            //   icon: "store",
            //   text: "Mot de la semaine",
            //   href: "/admin/week",
            // },


          ],

          links_operation_2: [
            // {
            //   icon: "store",
            //   text: "Entreprise",
            //   href: "/admin/entreprise",
            // },
            // {
            //   icon: "store",
            //   text: "Utilisateurs",
            //   href: "/admin/utilisateurs",
            // },
            // {
            //   icon: "store",
            //   text: "Roles",
            //   href: "/admin/role",
            // },
            // {
            //   icon: "store",
            //   text: "Ménus",
            //   href: "/admin/ListeMenu",
            // },
            // {
            //   icon: "store",
            //   text: "Restaurer les entreprises",
            //   href: "/admin/restaureEntrep",
            // }
          ],
          links_operation_3: [
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Examens",
            //   href: "/admin/examen",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Cat.Examens",
            //   href: "/admin/categorie_examen",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "GCat.Examens",
            //   href: "/admin/grand_categorie_examen",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Valeurs",
            //   href: "/admin/valeur_normale",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Tubes",
            //   href: "/admin/tube_examen",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Echantillon",
            //   href: "/admin/natureechantillon",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Méthode",
            //   href: "/admin/methodeexamen",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Unité",
            //   href: "/admin/unitevaleur",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Cat.Valeurs",
            //   href: "/admin/categorievaleur",
            // }
            //Typedocumentneuro
          ],
          links_operation_4: [
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Maladies",
            //   href: "/admin/Maladie",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Type Documents Neuro",
            //   href: "/admin/Typedocumentneuro",
            // },
            // {
            //   icon: "groups",
            //   text: "ActeMedecin",
            //   href: "/admin/ActeMedecin",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Cat.Maladie",
            //   href: "/admin/CategorieMaladie",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Consultation",
            //   href: "/admin/type_consultation",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "TypeMouvement",
            //   href: "/admin/type_mouvement_malade",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Fonct.Medecin",
            //   href: "/admin/fonction_medecin",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Services Hopital",
            //   href: "/admin/service_hopital",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Cat.Medecin",
            //   href: "/admin/categorie_medecin",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Type Plaie",
            //   href: "/admin/Hospi_TypePlaie",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Type Intervention",
            //   href: "/admin/Intervention",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Rubrique Surveil.",
            //   href: "/admin/RubriqueSurveillance",
            // },
            // {
            //   icon: "mdi-medical-bag",
            //   text: "Organisations(Conv.)",
            //   href: "/admin/organisationabonne",
            // }

          ],
          links_operation_5: [
            // {
            //   icon: "groups",
            //   text: "Classes",
            //   href: "/admin/ClassesFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Comptes",
            //   href: "/admin/CompteFin",
            // },
            // {
            //   icon: "groups",
            //   text: "Sous Comptes",
            //   href: "/admin/SousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "SSous Comptes",
            //   href: "/admin/SSousCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Compte",
            //   href: "/admin/TypeCompte",
            // },
            // {
            //   icon: "groups",
            //   text: "Config. Taux",
            //   href: "/admin/TTaux",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Position",
            //   href: "/admin/TypePosition",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Opération",
            //   href: "/admin/TypeOperation",
            // },
            // {
            //   icon: "groups",
            //   text: "Type Produit",
            //   href: "/admin/TypeProduit",
            // },
            // {
            //   icon: "groups",
            //   text: "Departements",
            //   href: "/admin/DepartementFin",
            // },
            // {
            //   icon: "groups",
            //   text: "ServicesRendus",
            //   href: "/admin/UniteProduction",
            // },
            // {
            //   icon: "groups",
            //   text: "ProduitFin",
            //   href: "/admin/ProduitFin",
            // },
            // {
            //   icon: "groups",
            //   text: "ActeMedecin",
            //   href: "/admin/ActeMedecin",
            // },
            // {
            //   text: "Rubriques",
            //   href: "/admin/compte",
            // },
            // {
            //   text: "Caisse&Banque",
            //   href: "/admin/Banque",
            // },
            // {
            //   text: "Tarifications",
            //   href: "/admin/typetarif",
            // },
            // {
            //   text: "ModePaie",
            //   href: "/admin/modepaie",
            // }

          ],

          links_systems: [

            // {
            //   icon: "api",
            //   text: "Souscription",
            //   href: "/admin/categoriesous",
            // },

            // {
            //   icon: "api",
            //   text: "Type Client",
            //   href: "/admin/categorieclient",
            // },

            // {
            //   icon: "store",
            //   text: "Type Produits",
            //   href: "/admin/categorieproduit",
            // },
            // {
            //   icon: "store",
            //   text: "Elèment Produits",
            //   href: "/admin/elementproduit",
            // },
          ],

          sublinks: [
            {
              icon: "book",
              text: "A propos ",
              href: "/admin/about_page",
            },
          ],

          listGroupAll: [
            {
              text: "Reception",
              icon: "mdi-account-multiple",
              items: [
                {
                  text: "Patients",
                  href: "/admin/malades",
                },

                {
                  text: "Triages",
                  href: "/admin/entete_triage",
                },
                {
                  text: "Rendez-vous",
                  href: "/admin/agenda_reception",
                },
                {
                  text: "Rapports Triage",
                  href: "/admin/RapportsJour_Patient",
                },
                {
                  icon: "store",
                  text: "Pays",
                  href: "/admin/pays",
                },
                {
                  icon: "store",
                  text: "Province",
                  href: "/admin/province",
                },
                {
                  icon: "store",
                  text: "Ville",
                  href: "/admin/ville",
                },
                {
                  icon: "store",
                  text: "Commune",
                  href: "/admin/commune",
                },

                {
                  icon: "store",
                  text: "Quartier",
                  href: "/admin/quartier",
                },

                {
                  icon: "store",
                  text: "Avenue",
                  href: "/admin/avenue",
                },

              ],
            },
            {  //Entete_Consultation_Jour
              text: "Consultation",
              icon: "mdi-account-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Entete_Consultation_Jour",
                },
                {
                  text: "Toutes les Consultations",
                  href: "/admin/entete_consultation",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Param.Maladies",
                  href: "/admin/Maladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Documents Neuro",
                  href: "/admin/Typedocumentneuro",
                },
                {
                  icon: "groups",
                  text: "Param.ActeMedecin",
                  href: "/admin/ActeMedecin",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Maladie",
                  href: "/admin/CategorieMaladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Consultation",
                  href: "/admin/type_consultation",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "TypeMouvement",
                  href: "/admin/type_mouvement_malade",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Services Hopital",
                  href: "/admin/service_hopital",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Plaie",
                  href: "/admin/Hospi_TypePlaie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Intervention",
                  href: "/admin/Intervention",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Rubrique Surveil.",
                  href: "/admin/RubriqueSurveillance",
                }
              ],
            },
            {
              text: "Urgences",
              icon: "mdi-needle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/urgences_jour",
                },
                {
                  text: "Toutes les Urgences",
                  href: "/admin/urgences",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },

          ],

          listGroup1: [
            {
              text: "Reception",
              icon: "mdi-account-multiple",
              items: [
                {
                  text: "Patients",
                  href: "/admin/malades",
                },

                {
                  text: "Triages",
                  href: "/admin/entete_triage",
                },
                {
                  text: "Rendez-vous",
                  href: "/admin/agenda_reception",
                },
                {
                  text: "Rapports Triage",
                  href: "/admin/RapportsJour_Patient",
                },
                {
                  icon: "store",
                  text: "Pays",
                  href: "/admin/pays",
                },
                {
                  icon: "store",
                  text: "Province",
                  href: "/admin/province",
                },
                {
                  icon: "store",
                  text: "Ville",
                  href: "/admin/ville",
                },
                {
                  icon: "store",
                  text: "Commune",
                  href: "/admin/commune",
                },

                {
                  icon: "store",
                  text: "Quartier",
                  href: "/admin/quartier",
                },

                {
                  icon: "store",
                  text: "Avenue",
                  href: "/admin/avenue",
                }
              ],
            },
          ],
          listGroup2: [
            {  //Entete_Consultation_Jour
              text: "Consultation",
              icon: "mdi-account-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Entete_Consultation_Jour",
                },
                {
                  text: "Toutes les Consultations",
                  href: "/admin/entete_consultation",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Param.Maladies",
                  href: "/admin/Maladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Documents Neuro",
                  href: "/admin/Typedocumentneuro",
                },
                {
                  icon: "groups",
                  text: "Param.ActeMedecin",
                  href: "/admin/ActeMedecin",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Maladie",
                  href: "/admin/CategorieMaladie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Consultation",
                  href: "/admin/type_consultation",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "TypeMouvement",
                  href: "/admin/type_mouvement_malade",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Services Hopital",
                  href: "/admin/service_hopital",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Plaie",
                  href: "/admin/Hospi_TypePlaie",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Type Intervention",
                  href: "/admin/Intervention",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Rubrique Surveil.",
                  href: "/admin/RubriqueSurveillance",
                }
              ],
            },
          ],
          listGroup3: [
            {
              text: "Urgences",
              icon: "mdi-needle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/urgences_jour",
                },
                {
                  text: "Toutes les Urgences",
                  href: "/admin/urgences",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup4: [
            {
              text: "Pédiatrie",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "CPS",
                  href: "/admin/EnteteCPS_Resultat",
                },
                {
                  text: "CPN",
                  href: "/admin/EnteteCPN_Resultat",
                }
                ,
                {
                  text: "Tests Cutanés",
                  href: "/admin/EnteteTestCutane",
                },
                {
                  text: "Archivages",
                  href: "/admin/Archivages",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                {
                  text: "Type Vaccin",
                  href: "/admin/VaccinEnfant",
                },
                {
                  text: "Catégorie Vaccin",
                  href: "/admin/CategorieVacEnfant",
                },
                {
                  text: "Période Vaccin",
                  href: "/admin/PeriodeVaccinEnfant",
                },
                {
                  text: "Stratégie Vaccination",
                  href: "/admin/StrategieVaccin",
                },
                {
                  text: "Modes Atteintes Enfants",
                  href: "/admin/ModeAtteinteEnfant",
                },
                {
                  text: "Période CPS",
                  href: "/admin/PeriodeCPS",
                },
                {
                  text: "Période Vaccination mère",
                  href: "/admin/PeriodeVaccinMere",
                },
                {
                  text: "Période CPN",
                  href: "/admin/PeriodeCPN",
                },
                {
                  text: "Période SP",
                  href: "/admin/PeriodeSP",
                },
                {
                  text: "Période CPON",
                  href: "/admin/PeriodeCPON",
                },
                {
                  text: "Période Peni",
                  href: "/admin/PeriodePeni",
                },
                {
                  text: "Rubrique Test Cutané",
                  href: "/admin/TypeTestCutane",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup5: [
            {
              text: "Laboratoire",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Prélevements",
                  href: "/admin/EntetePrelevement_Preleveur",
                },
                {
                  text: "Résultats",
                  href: "/admin/EntetePrelevement_Analyse",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  text: "Tabultations",
                  href: "/admin/Tabilation",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Laboratoire",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Examens",
                  href: "/admin/examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Examens",
                  href: "/admin/categorie_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "GCat.Examens",
                  href: "/admin/grand_categorie_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Valeurs",
                  href: "/admin/valeur_normale",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Tubes",
                  href: "/admin/tube_examen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Echantillon",
                  href: "/admin/natureechantillon",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Méthode",
                  href: "/admin/methodeexamen",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Unité",
                  href: "/admin/unitevaleur",
                },
                {
                  icon: "mdi-medical-bag",
                  text: "Cat.Valeurs",
                  href: "/admin/categorievaleur",
                }
                ,
                {
                  text: "Examen après Coloration",
                  href: "/admin/ExamenColore",
                },
                {
                  text: "Les Germes",
                  href: "/admin/GermeColore",
                },
                {
                  text: "Echantillons(Sperme)",
                  href: "/admin/NatureEchantillonSperme",
                },
                {
                  text: "Cat.Echantillons(Sperme)",
                  href: "/admin/CategorieEchantillonSperme",
                }
              ],
            },
          ],
          listGroup6: [
            {
              text: "Imageries",
              icon: "mdi-monitor-multiple",
              items: [
                {
                  text: "Imageries",
                  href: "/admin/ImageriesResultat",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                // {
                //   text: "Les Externes",
                //   href: "/admin/ImageriesResultatExt",
                // },
                {
                  text: "AnalyseImagerie",
                  href: "/admin/AnalyseImagerie",
                },
                {
                  text: "TypeAnalyse",
                  href: "/admin/TypeAnalyse",
                },
                {
                  text: "Interval Score",
                  href: "/admin/IntervalScore",
                },
                {
                  text: "Libellé Score",
                  href: "/admin/LibelleScore",
                },
                {
                  text: "Paramètre Score",
                  href: "/admin/ParametreScore",
                }
              ],
            },
          ],
          listGroup7: [
            {
              text: "Dialyse",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/EnteteDialyse_jour",
                },
                {
                  text: "Toutes les Dialyses",
                  href: "/admin/EnteteDialyse",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  text: "Vaccins",
                  href: "/admin/Vaccins",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                {
                  text: "Catégorie Vaccin",
                  href: "/admin/CategorieVaccin",
                },
                {
                  text: "Type Machine",
                  href: "/admin/TypeMachine",
                }
              ],
            },
          ],
          listGroup8: [
            {
              text: "Kinesitherapie",
              icon: "mdi-checkbox-multiple-marked-circle",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/Kinesitherapie_result_jour",
                },
                {
                  text: "Toutes Séances",
                  href: "/admin/Kinesitherapie_result",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup9: [
            {
              text: "Hospitalisation",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "En Hospitalisation",
                  href: "/admin/HospitalisationAll",
                },
                {
                  text: "Les Sorti(e)s",
                  href: "/admin/HospitalisationSortie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                },
                {
                  text: "Salles",
                  href: "/admin/Salle",
                },
                {
                  text: "Service Hospi.",
                  href: "/admin/ServiceHopi",
                }
                // ,
                // {
                //   text: "Service Soins",
                //   href: "/admin/ServiceSoin",
                // }
              ],
            },
          ],
          listGroup10: [
            {
              text: "Réanimation",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "En Réanimations",
                  href: "/admin/ReanimationEncours",
                },
                {
                  text: "Les Sorti(e)s",
                  href: "/admin/ReanimationSortie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup11: [
            {
              text: "Bloc Operatoire",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Pour Aujourd'hui",
                  href: "/admin/EnteteChirurgie_jour",
                },
                {
                  text: "Toutes les Chirurgies",
                  href: "/admin/EnteteChirurgie",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                },
                { //RapportsJour_StockService
                  icon: "mdi-medical-bag",
                  text: "Fiche Stock/Service",
                  href: "/admin/RapportsJour_StockService",
                }
              ],
            },
          ],
          listGroup12: [
            {
              //Fournisseur
              text: "Pharmacie",
              icon: "mdi-medical-bag",
              items: [
                {
                  text: "Approvisionements",
                  href: "/admin/entete_entree",
                },
                {
                  text: "Ventes",
                  href: "/admin/entete_vente",
                },
                {
                  text: "Besoin des Services",
                  href: "/admin/EnteteBesoinAll",
                },
                {
                  text: "Sortie/Services",
                  href: "/admin/entete_sortie",
                },
                {
                  text: "Medicaments",
                  href: "/admin/Medicament",
                },
                {
                  text: "Fournisseur",
                  href: "/admin/Fournisseur",
                },
                {
                  icon: "groups",
                  text: "ProduitFacturable",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Categorie",
                  href: "/admin/CategorieMedicament",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Pharmacie",
                }
              ],
            },
          ],
          listGroup13: [
            {
              text: "RH",
              icon: "mdi-account-settings",
              items: [
                {
                  text: "Personnels",
                  href: "/admin/medecin",
                },
                {
                  //FichePaieGlobale
                  text: "Paiement Global",
                  href: "/admin/FichePaieGlobale",
                },
                {
                  //FichePaieGlobale
                  text: "Paiement/Agent",
                  href: "/admin/FichePaie",
                },
                {
                  //FichePaieGlobale
                  text: "Rapports",
                  href: "/admin/RapportsJour_Personnel",
                },
                {
                  text: "Catégorie Agent",
                  href: "/admin/CategorieAgent",
                },
                {
                  text: "Type RubriquesPaies",
                  href: "/admin/CategorieRubriquePers",
                },
                {
                  text: "RubriquesPaies",
                  href: "/admin/RubriquePaie",
                },
                {
                  text: "Param. RubriquesPaies",
                  href: "/admin/ParametreRubrique",
                },
                {
                  text: "Catégorie Service",
                  href: "/admin/CategorieServicePers",
                },
                {
                  text: "Service Pers.",
                  href: "/admin/ServicePersonnel",
                },
                {
                  text: "Année",
                  href: "/admin/Annee",
                },
                {
                  text: "Mois",
                  href: "/admin/Mois",
                },
                {
                  text: "Raison Familliale",
                  href: "/admin/RaisonFamilliale",
                },
                {
                  text: "Horaires",
                  href: "/admin/membres",
                }
              ],
            },
          ],
          listGroup14: [
            {  //RapportMedical_Finance
              text: "Facturations",
              icon: "mdi-cash-100",
              items: [
                {
                  text: "Facturation",
                  href: "/admin/facturation",
                },
                {
                  text: "Autorier Consultations",
                  href: "/admin/Consultation_Finance",
                },
                {
                  text: "Autorier Urgences",
                  href: "/admin/Urgence_Finance",
                },
                {
                  text: "Autorier le Prélevement",
                  href: "/admin/EntetePrelevement_Finance",
                },
                {
                  text: "Autorier Imagerie",
                  href: "/admin/ImageriesFinance",
                },
                // {
                //   text: "Autorier Imagerie(Transfert)",
                //   href: "/admin/ImageriesFinanceExt",
                // },
                // {
                //   text: "Autorier Examens(Ordonances)",
                //   href: "/admin/Mvt_malade_Labo_Finance",
                // },
                {
                  text: "Autorier Rapprt Medical",
                  href: "/admin/RapportMedical_Finance",
                },
                {
                  text: "Autorier Kinesitherapie",
                  href: "/admin/Kinesitherapie_finance",
                },
                {
                  text: "Imprimer Attestations",
                  href: "/admin/EnteteAttestationFinance",
                },
                {
                  text: "Attestation Naissance",
                  href: "/admin/EnteteCPS_Finance",
                },
                {
                  text: "Sortie Hospitalisation",
                  href: "/admin/SortieHospitalisationFinance",
                },
                {
                  icon: "groups",
                  text: "ProduitFacturable",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Fiche Tarification",
                  href: "/admin/RapportTarification",
                },
                {
                  text: "Recherche Facture",
                  href: "/admin/RechercheFacture",
                },
                {
                  text: "Recherche Reçu",
                  href: "/admin/RechercheRecu",
                },
                {
                  text: "Rapport Det.Facturation",
                  href: "/admin/RapportsDetailFacture",
                },
                {
                  text: "Rapport Synt.Facturation",
                  href: "/admin/RapportsEnteteFacture"
                },
                {
                  text: "Rapport Det.Fact.Privé(e)s",
                  href: "/admin/RapportsDetailFacturePrivee",
                },
                {
                  text: "Rapport Synt.Fact.Privé(e)s",
                  href: "/admin/RapportsEnteteFacturePrivee"
                },
                {
                  text: "Rapport Paiement Privé(e)s",
                  href: "/admin/RapportsPaiementFacturePrivee"
                },
                {
                  text: "Rapport Det.Fact.Abonné(e)s",
                  href: "/admin/RapportsDetailFactureAbonne",
                },
                {
                  text: "Rapport Synt.Fact.Abonné(e)s",
                  href: "/admin/RapportsEnteteFactureAbonne"
                },
                {
                  text: "Rapport Paies Abonné(e)s",
                  href: "/admin/RapportsPaiementFactureAbonnee"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport des Paiements",
                  href: "/admin/RapportsPaiementFacture"
                },
                {
                  text: "Rapport Recettes/Depenses",
                  href: "/admin/RapportsJour_Caisse"
                }
                //RapportsPaiementFacture
              ],
            },
          ],
          listGroup15: [
            {
              text: "Trésorerie",
              icon: "mdi-cards",
              items: [
                {
                  text: "Facturation",
                  href: "/admin/facturation",
                },
                {
                  text: "Recettes",
                  href: "/admin/recette",
                },
                {
                  text: "Etat de Besoin",
                  href: "/admin/EnteteEtatBesoin",
                },
                {
                  //EnteteBonEngagement
                  text: "Bon d'Engagement",
                  href: "/admin/EnteteBonEngagement",
                },
                {
                  text: "Fiche Tarification",
                  href: "/admin/RapportTarification",
                },
                {
                  text: "Cloture de la Caisse",
                  href: "/admin/Cloture_Caisse",
                },
                {  //ClotureComptabilite
                  text: "Comptabilité(Opé.)",
                  href: "/admin/EnteteOperationComptable",
                },
                {  //ClotureComptabilite
                  text: "Cloture de la Comptabilité",
                  href: "/admin/ClotureComptabilite",
                },
                {
                  text: "Recherche Facture",
                  href: "/admin/RechercheFacture",
                },
                {
                  text: "Recherche Reçu",
                  href: "/admin/RechercheRecu",
                },
                {
                  text: "Rapport Det.Facturation",
                  href: "/admin/RapportsDetailFacture",
                },
                {
                  text: "Rapport Synt.Facturation",
                  href: "/admin/RapportsEnteteFacture"
                },
                {
                  text: "Rapport Det.Fact.Privé(e)s",
                  href: "/admin/RapportsDetailFacturePrivee",
                },
                {
                  text: "Rapport Synt.Fact.Privé(e)s",
                  href: "/admin/RapportsEnteteFacturePrivee"
                },
                {
                  text: "Rapport Paies Privé(e)s",
                  href: "/admin/RapportsPaiementFacturePrivee"
                },
                {
                  text: "Rapport Det.Fact.Abonné(e)s",
                  href: "/admin/RapportsDetailFactureAbonne",
                },
                {
                  text: "Rapport Synt.Fact.Abonné(e)s",
                  href: "/admin/RapportsEnteteFactureAbonne"
                },
                {
                  text: "Rapport Paies Abonné(e)s",
                  href: "/admin/RapportsPaiementFactureAbonnee"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport des Paiements",
                  href: "/admin/RapportsPaiementFacture"
                },
                {
                  text: "Rapport Comptabilité",
                  href: "/admin/RapportsComptabilite"
                  //RapportsPaiementFactureAbonnee
                },
                {
                  text: "Rapport Recettes/Depenses",
                  href: "/admin/RapportsJour_Caisse"
                },
                {
                  icon: "groups",
                  text: "ProduitFin",
                  href: "/admin/ProduitFin",
                },
                {
                  text: "Rubriques Depenses",
                  href: "/admin/compte",
                },
                {
                  text: "Cat.Rubriques EB",
                  href: "/admin/CategorieRubrique",
                },
                {
                  text: "Rubriques EB",
                  href: "/admin/Rubriques",
                },
                {
                  text: "Blocs(Finances)",
                  href: "/admin/Blocs",
                },
                {
                  //CategorieSociete
                  text: "Cat. Société",
                  href: "/admin/CategorieSociete",
                },
                {
                  text: "Les Services(Finances)",
                  href: "/admin/Provenance",
                }
                //Cloture_Caisse
              ],
            },
          ],
          listGroup16: [
            {
              text: "Secrétariat",
              icon: "print",
              items: [
                {
                  text: "Rapports Medicals",
                  href: "/admin/RapportMedical_Secretariat",
                },
                {
                  text: "Les Attestations",
                  href: "/admin/EnteteAttestation",
                }
              ],
            },
          ],
          listGroup17: [
            {
              text: "Logistique",
              icon: "mdi-cart-outline",
              items: [
                {
                  text: "Approvisionements",
                  href: "/admin/LogEnteteEntree",
                },
                {
                  text: "Sortie/Services",
                  href: "/admin/LogEnteteSortie",
                },
                {
                  text: "Requisitions",
                  href: "/admin/LogEnteteRequisition",
                },
                {
                  text: "Articles",
                  href: "/admin/Produits",
                },
                {
                  text: "Fournisseur",
                  href: "/admin/Fournisseur",
                },
                {
                  text: "Categorie Art.",
                  href: "/admin/categorieproduit",
                },
                {
                  text: "Rapports",
                  href: "/admin/RapportsJour_Logistique",
                }
              ],
            },
          ],
          listGroup18: [
            {  //RapportTarification
              text: "Rapports",
              icon: "description",
              items: [
                {
                  text: "Rapport SNIS",
                  href: "/admin/RapportsSNIS",
                },
                // {
                //   text: "Rapport Det.Facturation",
                //   href: "/admin/RapportsDetailFacture",
                // },
                // {
                //   text: "Fiche de Tarification",
                //   href: "/admin/RapportTarification",
                // }
              ],
            },
          ],
          admins: [
            ["Management", ""],
            ["Settings", ""],
          ],
        };

      }
    },
  },
};
</script>


