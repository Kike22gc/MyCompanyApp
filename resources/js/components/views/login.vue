<template>
   <v-app id="inspire">
      <v-main>
         <v-container fluid fill-height>
            <v-layout align-center justify-center>
               <v-flex sm12 lg10>
                  <v-card class="elevation-12">
                     <v-row>
                        <v-flex xs12 sm7> <!--IMAGEN LOGIN-->
                           <v-container fluid fill-height>
                              <v-layout align-center justify-center>
                                 <img src="images/logo2.png"/>
                              </v-layout>
                           </v-container> 
                        </v-flex>
                        <v-flex xs12 sm5> <!--FORMULARIO-->
                           <v-row class="d-flex center pa-md-2 mx-lg-auto">
                              <v-col cols="6">
                                 <v-btn text block @click="vShow='Login'">INICIAR SESIÓN</v-btn>
                              </v-col>
                              <v-col cols="6">
                                 <v-btn text block @click="vShow='SignUp'">REGISTRARSE</v-btn>
                              </v-col>
                           </v-row>
                           <v-row>
                              <v-col cols="11">
                                 <v-form v-model="vForm">
                                    <v-text-field
                                       v-for="item in items"
                                       v-if="vShow != 'Login'"
                                       :key="item.name"
                                       :v-model="item.model"
                                       :name="item.name"
                                       :label="item.name"
                                       :type="item.type"
                                       :prepend-icon="item.prependIcon"
                                       :append-icon="item.appendIcon"
                                       :rules="rulesRequired"
                                    >
                                    </v-text-field>

                                    <v-text-field
                                       prepend-icon="alternate_email"
                                       name="email"
                                       label="Email"
                                       type="text"
                                       v-model="vEmail"
                                       :rules="[rules.required, rules.email]"
                                    ></v-text-field>

                                    <v-text-field
                                       prepend-icon="lock"
                                       :append-icon="vpass_visible ? 'mdi-eye' : 'mdi-eye-off'"
                                       :type="vpass_visible ? 'text' : 'password'"
                                       @click:append="vpass_visible = !vpass_visible"
                                       name="Contraseña"
                                       label="Contraseña"
                                       counter 
                                       v-model="vPass"
                                       :rules="[rules.required]"
                                    ></v-text-field>
                                    <v-text-field
                                       v-if="vShow != 'Login'"
                                       prepend-icon="lock"
                                       name="Confirmar Contraseña"
                                       label="Confirmar Contraseña"
                                       type="password"
                                       v-model="vPassConfirm"
                                       :rules="[rules.required, rules.confirm]"
                                    ></v-text-field>
                                    
                                    <v-card-actions>
                                       <v-spacer></v-spacer>
                                       <v-btn v-if="vShow == 'Login'" color="primary" :disabled= !vForm @click="login()">Iniciar Sesion </v-btn>
                                       <v-btn v-if="vShow != 'Login'" color="primary" :disabled= !vForm @click="signUp()">Registrarse </v-btn>
                                    </v-card-actions>
                                 </v-form>
                              </v-col>
                           </v-row>
                        </v-flex>
                     </v-row>
                  </v-card>
               </v-flex>
            </v-layout>
         </v-container>
      </v-main>
   </v-app>
</template>

<script>
import axios from "axios";

export default {
   name: 'Login',

   data() {
      return {
         vShow: 'Login',
         
         vForm: null,

         items: [
                { model: 'vName',         name: 'Nombre',      label:'Nombre',      type: 'text',  prependIcon: 'person', },
                { model: 'vApellidos',    name: 'Apellidos',   label:'Apellidos',   type: 'text',  prependIcon: 'person',  },
                { model: 'vCompany',      name: 'Empresa',     label:'Empresa',     type: 'text',  prependIcon: 'apartment', },
              ],
         
         vName: null,
         vApellidos: null,
         vCompany: null,
         vEmail: 'a@a.es',
         vPass: 'A',
         vPassConfirm: null,   
         vpass_visible: false,     
         
         rulesRequired: [(v) => !!v || "Campo requerido"],
            
         rules: {
            required: (value) => !!value || "Campo requerido.",
            email: (value) => {
               const pattern =
                  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
               return pattern.test(value) || "Formato de email invalido.";
            },
            confirm: (value) => value == this.vPass || "Las contraseñas no coinciden.",
         },
         
      }
   },

   methods: {

      login: function ()
        {
            let Self = this;
            
            let credenciales = {
                email: this.vEmail,
                password: this.vPass,
            };

            axios
                .post("/api/user/login", credenciales)
                .then((response) => {
                    this.usuario = response.data[0];
                    
                    Self.$store.dispatch("setLogin", () => {
                        Self.$router.push("/home").catch((err) => err);
                    });
                })
                .catch((error) => {
                  console.log(error)
                    alert("Usuario y/o contraseña incorrectos");
                });
        },
        
      signUp: function ()
        {
            console.log(this.vApellidos);
            let credenciales = {
                name: this.vName,
                subname: this.vApellidos,
                company: this.vCompany,
                email: this.vEmail,
                password: this.vPass,
            };

            axios
                .post("/api/user/signUp", credenciales)
                .then((response) => {
                    alert("Usuario Creado Correctamente");
                    this.var_showScreen = 'login';
                })
                .catch((error) => {
                    alert("Error al crear el Usuario");
                });
        },
   }

};
</script>