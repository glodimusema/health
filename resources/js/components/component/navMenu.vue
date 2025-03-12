<template>
  <div>
    <v-menu offset-y>
      <template v-slot:activator="{ attrs, on }">
        <span style="cursor: pointer" v-bind="attrs" v-on="on">
          <!-- <v-chip link>
            <v-badge dot bottom color="green" offset-y="10" offset-x="10">
              <v-avatar size="60">
                <img :src="`${baseURL}/images/vue.png`" />
              </v-avatar>
            </v-badge>
            <span class="ml-3">Jane Smith</span>
          </v-chip> -->
        </span>
      </template>
      <v-list width="250" class="py-0">
        <v-list-item dense two-line>
          <v-list-item-avatar>
            <img
              :src="
                this.userData.avatar == null
                  ? `${baseURL}/images/logo.png`
                  : `${baseURL}/images/` + this.userData.avatar
              "
            />
          </v-list-item-avatar>

          <v-list-item-content>
            <v-list-item-title>{{ teacher_name  }}</v-list-item-title>
            <v-list-item-subtitle>
              {{ this.userData.email | subStr }}</v-list-item-subtitle
            >
          </v-list-item-content>
        </v-list-item>
        <v-divider />
        <v-list-item
          dense
          link
          v-for="(menu, i) in menus"
          :key="i"
          :to="menu.href"
        >
          <v-list-item-icon>
            <v-icon>{{ menu.icon }}</v-icon>
          </v-list-item-icon>
          <v-list-item-title>
            {{ menu.title }}
          </v-list-item-title>
        </v-list-item>

        <v-list-item dense link :href="`${this.baseURL}/logout`">
          <v-list-item-icon>
            <v-icon>mdi-logout</v-icon>
          </v-list-item-icon>
          <v-list-item-title> Déconnexion </v-list-item-title>
        </v-list-item>
      </v-list>
    </v-menu>
  </div>
</template>

<script>
export default {
  data() {
    return {
      titre: "",
      menus: [
        {
          title: "Profile",
          icon: "mdi-account",
          href: "/profil",
        },
      ],
      hader: "",
      teacher_name: window.school.user.name,
    };
  },
  created() {
    this.getInfoConnected();
  },
  methods: {
    getInfoConnected() {
      if (this.userData.id_role == 1) {
        this.menus = [
          {
            title2: "Malades",
            icon: "mdi-account-multiple-plus",
            href: "/admin/profil",
          },
          {
            title2: "Consultation",
            icon: "mdi-cart",
            href: "/admin/security",
          },
          {
            title2: "Laboratoire",
            icon: "mdi-cart",
            href: "/admin/security",
          },
          {
            title2: "Medecins",
            icon: "mdi-currency-usd",
            href: "/admin/security",
          },
          {
            title2: "Finances",
            icon: "mdi-cart",
            href: "/admin/security",
          },
          {
            title2: "Pharmacie",
            icon: "mdi-cart",
            href: "/admin/security",
          },
          {
            title2: "Rapports",
            icon: "description",
            href: "/admin/security",
          },
          {
            title2: "Paramètre notification",
            icon: "mdi-cog",
            href: "/admin/setting",
          },
        ];
      } else if (this.userData.id_role == 2) {
        
      } else if (this.userData.id_role == 3) {
        
      } else {
        this.menus = [
          { title: "Mon profil", href: "error/profil", icon: "person" },
        ];
      }
      // console.log(window.emerfine.user);
    },
  },
  filters: {
    subStr(value) {
      if (value.length > 20) {
        return value.slice(0, 20).toLowerCase();
      } else {
        return value;
      }
    },
    LowerCase(value) {
      return value.toLowerCase();
    },
  },
};
</script>