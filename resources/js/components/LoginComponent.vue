<template>
    <v-container>
        <v-row>
            <v-col cols="4" offset-md="4">
                <v-card>
                    <v-card-title>Inicio de sesión</v-card-title>
                    <v-card-text>
                        <v-form v-model="loginForm">
                            <v-text-field
                                v-model="email"
                                label="Correo electrónico"
                                rounded
                                filled
                                color="secondary"
                                :rules="rules"
                                dense
                                validate-on-blur
                            ></v-text-field>

                            <v-text-field
                                v-model="password"
                                label="Contraseña"
                                color="secondary"
                                :rules="rules"
                                rounded
                                filled
                                dense
                                type="password"
                                validate-on-blur
                            ></v-text-field>
                        </v-form>
                        <v-btn color="secondary" block :disabled="!loginForm" v-on:click="login">Iniciar sesión</v-btn>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>
<script>
    export default {
        data() {
            return {
                loginForm: false,
                email: '',
                password: '',
                rules: [v => !!v || 'Este campo es requerido'],
            }
        },

        methods: {
            login: function() {
                axios
                    .post('vuelogin', { email: this.email, password: this.password })
                    .then(res => location.reload())
                    // .then(res => console.log(res))
                    .catch(error => console.log(error))
            },
        },
    }
</script>
