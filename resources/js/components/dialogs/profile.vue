<template>
    <v-app>
        <div>
            <div>
                <v-dialog v-model="dialog" persistent scrollable max-width="80%">
                    <v-card>
                        <v-toolbar dense>
                            <img src="https://randomuser.me/api/portraits/women/64.jpg" width="40px" height="40px">
                            <v-toolbar-title class="ml-4">{{userInfo.name}} {{userInfo.subname}}</v-toolbar-title>
                            
                            <v-spacer></v-spacer>
                            <v-icon>edit</v-icon>
                            <v-btn icon @click="cancel()" class="btn-close"><v-icon>mdi-close</v-icon></v-btn>
                        </v-toolbar>

                        <div class="d-none d-sm-flex"> <!--DESKTOP-->
                            <v-card-text>
                                <v-row class="mt-4">
                                    <v-col cols="4">
                                        <v-card height="auto" width="100%" fluid>
                                            <v-img v-if="image_url === null" src="images/no-profile-picture-icon.svg" width="380px" height="auto" align-center justify-center>
                                            </v-img>
                                            <v-img v-if="image_url !== null" :src="image_url" max-height="500px" max-width="380px"></v-img>
                                        </v-card>
                                        <v-file-input 
                                            type="file" id="file" ref="file" v-on:change="handleFileUpload()"
                                            style="display: none"
                                            v-model="image_name"
                                        >
                                        </v-file-input>
                                        <v-row class="mt-3">
                                            <v-spacer></v-spacer>
                                            <v-btn v-if="image_url === null" class="primary" @click="seleccionaImagen()">SUBIR IMAGEN</v-btn>
                                            <v-btn v-if="image_url !== null" class="secondary" @click="borraImagen()">ELIMINAR IMAGEN</v-btn>
                                            <v-spacer></v-spacer>
                                        </v-row>
                                    </v-col>
                                    <v-col cols="1"></v-col>
                                    <v-col cols="6">
                                        <v-form v-model="vForm">
                                            <v-text-field
                                                :v-model="userInfo.name" name="userInfo.name"
                                                :label="item.name"     type="text"
                                                :prepend-icon="item.prependIcon"
                                                >
                                            </v-text-field>

                                            <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="primary">Registrarse </v-btn>
                                            </v-card-actions>
                                        </v-form>
                                    </v-col>
                                    <v-col cols="1"></v-col>
                                </v-row>
                            </v-card-text>
                        </div>
                        <div class="d-flex d-sm-none">  <!--MOVIL-->
                            <v-card-text>
                                <v-row class="mt-1">
                                    <v-card height="300px" width="100%">
                                        <v-img v-if="image_url === null" 
                                            src="images/no-profile-picture-icon.svg" 
                                            width="100%" 
                                            height="100%" 
                                            align-center justify-center>
                                        </v-img>
                                        <v-img v-if="image_url !== null" 
                                            :src="image_url" 
                                            max-height="auto" 
                                            max-width="200px">
                                        </v-img>
                                    </v-card>
                                    <v-file-input 
                                        type="file" id="file" ref="file" v-on:change="handleFileUpload()"
                                        style="display: none"
                                        v-model="image_name"
                                    >
                                    </v-file-input>
                                </v-row>
                                <v-row class="mt-5">
                                    <v-spacer></v-spacer>
                                    <v-btn v-if="image_url === null" class="primary" @click="seleccionaImagen()">SUBIR IMAGEN</v-btn>
                                    <v-btn v-if="image_url !== null" class="secondary" @click="borraImagen()">ELIMINAR IMAGEN</v-btn>
                                    <v-spacer></v-spacer>
                                </v-row>
                            </v-card-text>
                        </div>

                    </v-card>
                </v-dialog>
            </div>
        </div>
    </v-app>
</template>

<script>
import axios from "axios";
export default {
    props: ["dialog", "userInfo"],

    data() {
        return {
            image_url: null,
            image_name: null,
            file: null,

            dateMenu: false,
            dateValue: null,

            vForm: false,
            var_ruta_imagen: null, 

            perfil: [],

            items: [
                { model: 'this.perfil.name',       name: 'Nombre',     label:'Nombre',     type: 'text',  prependIcon: 'person', },
                { model: 'this.userInfo.subname',    name: 'Apellidos',  label:'Apellidos',  type: 'text',  prependIcon: 'person',  },
              ],
        };
    },

    created() {
      
    },

    mounted: function() {
        this.initialize();
    },

    watch: {
        dateValue(newValue) {
            const arrayFecha = newValue.split("-");
            this.var_fecha = arrayFecha[2] + "/" + arrayFecha[1] + "/" + arrayFecha[0];
        },

        dialog(value){
            if (value) this.perfil = this.userInfo
            console.log(this.perfil)
        }
    },

    methods: {
        initialize: function () {
        }, 

        seleccionaImagen() {
            this.$refs.file.$refs.input.click();
        },

        handleFileUpload(){
            this.image_url = URL.createObjectURL(this.image_name)
        },

        borraImagen() {
            this.image_url = null;
            this.image_name = null;
        },

        createJugador: function () {

            if (this.image_url !== null) {
                //SUBIR IMAGEN AL SERVIDOR
                this.uploadFile();
            }
            else {
                this.crearJugador();
            }
        },
        
        uploadFile: function () {
            let formData = new FormData();
            formData.append('file', this.image_name);
            formData.append('user', this.var_team_active)

                axios.post( '/api/player/upload-image',
                    formData,
                    {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }
                )
                .then((response) => {
                    this.var_ruta_imagen = response.data.path;
                    this.crearJugador();
                })
                .catch((error) => {
                    alert("Error al subir la imagen");
                });
        },

        crearJugador: function () {
            let datos = {
                name: this.var_name,
                surname: this.var_apellidos,
                alias: this.var_alias,
                birthdate: this.dateValue,
                height: this.var_altura,
                weight: this.var_peso,
                number: this.var_dorsal,
                posicion: this.var_posicion,
                picture: this.var_ruta_imagen,
                team_active: this.var_team_active,
            };
            
            axios.post('/api/player/create', datos).then((response) => {
                location.reload();
            })
            .catch((error) => {
                alert("Error al crear el equipo para el usuario");
            });
        },

        cancel: function () {
            this.image_url = null;
            this.image_name = null;
            this.$emit("cancel");
        },
    },
    
    
};
</script>