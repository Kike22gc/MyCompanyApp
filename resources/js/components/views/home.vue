<template>
   <v-app id="inspire">
      <v-main>
        <Header></Header>
      </v-main>
   </v-app>
</template>

<script>

import axios from "axios";
import Header from "../header.vue";

export default {
    name: "Home",
    components: { },

    data() {
        return {
        };
    },

    created() {
      this.initialize();
    },

    mounted() {
    },

    methods: {
      initialize: function () {
      }
    },
    
};
</script>