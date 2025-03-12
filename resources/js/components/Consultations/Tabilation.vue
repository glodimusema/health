<template>
    <v-card>
      
      <v-tabs orizontal>
  
       
        <v-tab>
          <v-icon left> mdi-access-point </v-icon>
          Consultation 1
        </v-tab>
  
        <v-tab>
          <v-icon left> satellite </v-icon>
          Consultation 2
        </v-tab>
       
  
        <!-- item 3 -->
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <!-- <Basic v-bind:id="id" /> -->
              1
            </v-card-text>
          </v-card>
        </v-tab-item>
        <!-- fin -->
  
        <!-- item 3 -->
        <v-tab-item>
          <v-card flat>
            <v-card-text>
              <!-- <BasicAvatar /> -->
              2
            </v-card-text>
          </v-card>
        </v-tab-item>
        <!-- fin -->
      </v-tabs>
    </v-card>
  </template>
  
  <script>
//   import Basic from "./basic.vue";
//   import ProfileConnected from "./profileConnected.vue";
//   import BasicAvatar from "./basicAvatar.vue";
  export default {
    components: {
    //   Basic,
    //   ProfileConnected,
    //   BasicAvatar,
    },
    data() {
      return {
        title: "Profil",
  
      };
    },
    methods: {},
  };
  </script>