 <template>
  <div>
    <v-sheet color="grey lighten-4" class="pa-4" id="navimg">
      <div class="text-center">
        <v-avatar class="mb-4" color="grey darken-1" size="64" transparent>
          <img :src="`${baseURL}/images/logo.png`" />
        </v-avatar>

        <div>
          <h2 class="white--text">DOCS LA GRACE</h2>
          <!-- <h2 class="white--text">NEW HORIZON</h2> -->
        </div>
      </div>
    </v-sheet>

    <v-divider></v-divider>

    <v-list dense>
      <!-- mes menus -->

      <!-- test -->
      <v-list nav dense>
        <v-list-item-group color="#B72C2C">
          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links" :key="link.text" :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-icon v-bind="attrs" v-on="on">
                  <v-icon color="#B72C2C">{{ link.icon }}</v-icon>
                </v-list-item-icon>
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-item-group>
      </v-list>
      <!-- fin -->


      <v-list v-for="item in menuList" :key="item.id" nav dense style="margin-bottom: -18px;">
        <!-- {{ JSON.stringify(item) }} -->
        <!-- {{ JSON.stringify(linkAdmin.listGroup+''+item.numero_menu) }} -->

        <v-list-group v-for="list in linkAdmin.listGroup1" :key="list.id" :value="false" no-action group
         v-show="item.numero_menu == '1'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>


        <v-list-group v-for="list in linkAdmin.listGroup2" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '2'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup3" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '3'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup4" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '4'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup5" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '5'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup6" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '6'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup7" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '7'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup8" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '8'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup9" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '9'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup10" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '10'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup11" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '11'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup12" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '12'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>
        <v-list-group v-for="list in linkAdmin.listGroup13" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '13'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>

        <v-list-group v-for="list in linkAdmin.listGroup14" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '14'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>


        <v-list-group v-for="list in linkAdmin.listGroup15" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '15'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>


        <v-list-group v-for="list in linkAdmin.listGroup16" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '16'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>


        <v-list-group v-for="list in linkAdmin.listGroup17" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '17'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>


        <v-list-group v-for="list in linkAdmin.listGroup18" :key="list.id" :value="false" no-action group
          v-show="item.numero_menu == '18'">
          <template v-slot:activator>
            <v-list-item-icon>
              <v-icon color="#B72C2C">{{ list.icon }}</v-icon>
            </v-list-item-icon>

            <v-list-item-title>{{ list.text }}</v-list-item-title>
          </template>

          <v-list-item-group>

            <v-list-item v-for="submenu in list.items" :key="submenu.id" :to="submenu.href">
              <v-list-item-icon>
                <v-icon color="#B72C2C"></v-icon>
              </v-list-item-icon>
              <v-list-item-title>
                <span>{{ submenu.text }}</span>
              </v-list-item-title>
            </v-list-item>
          </v-list-item-group>
        </v-list-group>

      </v-list>






      <!-- script2 -->
      <v-list-group prepend-icon="settings" color="#B72C2C">
        <template v-slot:activator>
          <v-list-item-title>Paramètre</v-list-item-title>
        </template>

        <v-list-group no-action sub-group v-show="linkAdmin.links_operation.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Adresse</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>

        <v-list-group no-action sub-group v-show="linkAdmin.links_operation_2.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Gestion Entreprises</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation_2" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>

        </v-list-group>




        <!-- ========================================================================== -->


        <v-list-group no-action sub-group v-show="linkAdmin.links_systems.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Laboratoire</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation_3" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>


        <!-- =============================================================================== -->

        <v-list-group no-action sub-group v-show="linkAdmin.links_systems.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Consultation</v-list-item-title>
            </v-list-item-content>
          </template>

          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation_4" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>



        <!-- =============================================================================== -->

        <v-list-group no-action sub-group v-show="linkAdmin.links_systems.length > 0">
          <template v-slot:activator>
            <v-list-item-content>
              <v-list-item-title>Finances</v-list-item-title>
            </v-list-item-content>
          </template>


          <v-list-item style="text-decoration: none" v-for="link in linkAdmin.links_operation_5" :key="link.text"
            :to="link.href">
            <v-tooltip right color="black">
              <template v-slot:activator="{ on, attrs }">
                <v-list-item-title v-bind="attrs" v-on="on">{{
                  link.text
                }}</v-list-item-title>
              </template>
              <span>{{ link.text }}</span>
            </v-tooltip>
          </v-list-item>
        </v-list-group>





      </v-list-group>

      <!-- fin scripts 2 -->

      <v-divider></v-divider>

      <v-list-item style="text-decoration: none" :href="`${this.baseURL}/logout`">
        <v-list-item-action>
          <v-icon color="#B72C2C">exit_to_app</v-icon>
        </v-list-item-action>
        <v-list-item-content>
          <v-list-item-title>Déconnexion</v-list-item-title>
        </v-list-item-content>
      </v-list-item>

      <!-- fin scripts -->
    </v-list>
  </div>
</template>

<script>
export default {
  props: ['linkAdmin'],
  data() {
    return {
      titre: "",
      menuList: []
    }

  },
  methods: {
    fetchMenu() {
      this.editOrFetch(`${this.apiBaseURL}/fetch_menu_roles/${this.userData.id_role}`).then(
        ({ data }) => {
          var donnees = data.data;
          this.menuList = donnees;

          console.log(donnees);
        }
      );
    }
  },
  created() {
    this.fetchMenu();
  },

}
</script>

<style scoped>
#navimg {
  background-image: url("./background1.jpg");
  width: 100%;
  height: 140px;
}
</style>
