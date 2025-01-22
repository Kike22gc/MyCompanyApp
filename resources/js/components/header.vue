<template>
    <v-app>
        <div>
            <div class="d-none d-sm-flex">  <!--NAVBAR DESKTOP-->
                <v-app-bar >
                    <v-btn x-large text @click="toHome()">Inicio</v-btn>
                    
                    
                    <v-spacer></v-spacer>

                    <v-app-bar-nav-icon
                        class="ml-5"
                        @click="drawer = true"
                        v-if="this.$store.getters.isUserLogged"
                    ></v-app-bar-nav-icon>
                </v-app-bar>
                
                <v-navigation-drawer v-model="drawer" absolute temporary right>
                    
                    <template v-slot:prepend>
                        <v-list-item class="mt-4">
                            <img src="https://randomuser.me/api/portraits/women/82.jpg">                    
                        </v-list-item>

                        <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title><h1>{{vProfileName}}</h1></v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </template>
                    
                    <v-divider></v-divider><v-divider></v-divider>
                    <v-divider></v-divider><v-divider></v-divider>
                    
                    <v-divider></v-divider><v-divider></v-divider>
                    <v-divider></v-divider><v-divider></v-divider>

                    <v-list dense>
                        <v-list-item

                        v-for="item in items"
                        @click="menuActionClick(item.action)"
                        :key="item.title"
                        >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </v-list>

                </v-navigation-drawer>
            </div>

            <div class="d-flex d-sm-none">
                <v-app-bar >
                    <v-spacer></v-spacer>

                    <v-app-bar-nav-icon
                        class="ml-5"
                        @click="drawer = true"
                        v-if="this.$store.getters.isUserLogged"
                    ></v-app-bar-nav-icon>
                </v-app-bar>
                
                <v-navigation-drawer v-model="drawer" absolute temporary right>
                    
                    <template v-slot:prepend>
                        <v-list-item class="mt-4">
                            <img src="https://randomuser.me/api/portraits/women/82.jpg">                    
                        </v-list-item>

                        <v-list-item>
                        <v-list-item-content>
                            <v-list-item-title><h1>{{vProfileName}}</h1></v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </template>
                    
                    <v-divider></v-divider><v-divider></v-divider>
                    <v-divider></v-divider><v-divider></v-divider>
                    
                    <v-divider></v-divider><v-divider></v-divider>
                    <v-divider></v-divider><v-divider></v-divider>

                    <v-list dense>
                        <v-list-item

                        v-for="item in items"
                        @click="menuActionClick(item.action)"
                        :key="item.title"
                        >
                        <v-list-item-icon>
                            <v-icon>{{ item.icon }}</v-icon>
                        </v-list-item-icon>

                        <v-list-item-content>
                            <v-list-item-title>{{ item.title }}</v-list-item-title>
                        </v-list-item-content>
                        </v-list-item>
                    </v-list>

                </v-navigation-drawer>
            </div>
        </div>

        <Perfil
            v-bind:dialog="vShowProfile"
            @cancel="cancel"
        ></Perfil>
    </v-app>
</template>

<script>
import axios from "axios";

export default {
    name: "Header",

    data() {
        return {
            drawer: false,
            group: null,

            vProfileName: this.$store.getters.getUserName,

            vShowProfile: false,

            items: [
                { title: 'Inicio', icon: 'mdi-home-city', action: 'home' },
                { title: 'Mi Perfil', icon: 'mdi-account', action: 'profile' },
                { title: 'Users', icon: 'mdi-account-group-outline'},
                { title: 'Cerrar Sesión', icon: 'mdi-logout', action: 'logout'},
            ],
        };
    },

    mounted() {},

    methods: {

        menuActionClick(action) {
            if (action === "home") {
                this.toHome()
            } else if (action === "profile") {
                this.vShowProfile = true
            }else if (action === "logout") {
                this.logout()
            }
        },

        toHome: function () {
            this.$router.push("/home");
        },

        logout() {
            this.$store.dispatch("setLogout");
            this.$router.push("/");
        },

        cancel: function () {
            this.vShowProfile = false;
        }
    },
};
</script>