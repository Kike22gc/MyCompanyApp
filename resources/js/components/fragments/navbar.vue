<v-navigation-drawer absolute temporary right>
        
    <v-list nav dense>
        <v-list-item-group v-model="group" active-class="deep-purple--text text--accent-4">
            <v-list-item @click="editProfile()">
                <v-list-item-icon>
                    <v-icon>manage_accounts</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Editar perfil</v-list-item-title>
            </v-list-item>
            <v-list-item @click="logout()">
                <v-list-item-icon>
                    <v-icon>mdi-logout</v-icon>
                </v-list-item-icon>
                <v-list-item-title>Cerrar sesión</v-list-item-title>
            </v-list-item>
        </v-list-item-group>
    </v-list>
</v-navigation-drawer>