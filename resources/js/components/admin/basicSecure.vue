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
        <v-icon left> mdi-lock </v-icon>
        La Securité de mon compte
      </v-tab>

      <!--item 1  -->
      <v-tab-item>
        <v-card flat>
          <v-card-text>
           
            <Mysecurity />
          </v-card-text>
        </v-card>
      </v-tab-item>
      <!-- fin item 1 -->

     
    </v-tabs>
  </v-card>
</template>

<script>
import Mysecurity from "./mysecurity.vue";

export default {
  components: {
    Mysecurity,

  },
  data() {
    return {
      title: "Securité",
    };
  },
  methods: {},
};
</script>