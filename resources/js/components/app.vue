<template>
    <v-app :class="getState">
        <v-main>
            <Login v-if="authentication === false"></Login>
            <router-view v-if="authentication"></router-view>
        </v-main>
    </v-app>
</template>

<script>
import { RouterView } from 'vue';
import Login from "./views/login.vue";

export default {
    components: { Login },
    name: "app",

    data() {
        return {
            authentication: null,
        };
    },

    computed: {
        getState() {
            const Self = this;
            this.$store.dispatch('setLogin', function() {
                Self.authentication = Self.$store.getters.isUserLogged;

                if (!Self.authentication) {
                    Self.$router.push("/").catch((err) => err);
                }
                if (Self.authentication && window.location.pathname == "/") {
                    Self.$router.push("/home").catch((err) => err);
                }
            });
        },
    },

    created() {

    },

    mounted() {
        this.authentication = this.$store.getters.isUserLogged;
        return this.authentication ? "user-logged" : "user-anonymous";
        
    },

    methods: {
    },
};
</script>
