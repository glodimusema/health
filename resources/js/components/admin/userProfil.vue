<template>
  <v-card>
    <v-toolbar flat color="grey lighten-5" dark>
      <v-toolbar-title>
        <v-avatar>
          <img
            :src="
              userData.avatar == null
                ? `${baseURL}/images/avatar.png`
                : `${baseURL}/images/` + userData.avatar
            "
            alt=""
          />
        </v-avatar>
        <span class="black--text">{{ userData.name }}</span>
      </v-toolbar-title>
    </v-toolbar>
    <v-tabs orizontal>
      <v-tab>
        <v-icon left> mdi-account </v-icon>
        Mon Profil
      </v-tab>
     
      <v-tab>
        <v-icon left> mdi-access-point </v-icon>
        Informations basiques
      </v-tab>

      <v-tab>
        <v-icon left> satellite </v-icon>
        Mon Avatar
      </v-tab>
      <!--item 1  -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <ProfileConnected />
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- fin item 1 -->

      <!-- item 3 -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <Basic />
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- fin -->

      <!-- item 3 -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
            <BasicAvatar />
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- fin -->
    </v-tabs>
  </v-card>
</template>

<script>
import Basic from "./basic.vue";
import ProfileConnected from "./profileConnected.vue";
import BasicAvatar from "./basicAvatar.vue";
export default {
  components: {
    Basic,
    ProfileConnected,
    BasicAvatar,
  },
  data() {
    return {
      title: "Profil",

    };
  },
  methods: {},
};
</script>