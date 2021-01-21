<template>
    <div>
        <v-navigation-drawer v-model="drawer" app temporary>
            <v-list shaped>
                <v-list-item-group>
                    <v-list-item href="/home" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Inicio</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="/receipts" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Recepciones</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-divider class="my-2"></v-divider>
                <v-list-item-group>
                    <v-list-item href="/clients" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Clientes</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="/services" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Servicios</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="/products" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Productos</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-divider class="my-2"></v-divider>
                <v-list-item-group>
                    <v-list-item href="/sales" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>POS</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="/reports" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Reportes</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
                <v-divider class="my-2"></v-divider>
                <v-list-item-group>
                    <v-list-item href="/inventory_entries" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Entradas</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item href="/inventory_exits" class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Salidas</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
            <template v-slot:append>
                <v-list>
                    <v-list-item-group>
                        <v-list-item class="my-1" dense v-on:click="logout()">
                            <v-list-item-content>
                                <v-list-item-title>Cerrar sesión</v-list-item-title>
                            </v-list-item-content>
                        </v-list-item>
                    </v-list-item-group>
                </v-list>
            </template>
        </v-navigation-drawer>
        <v-app-bar class="secondary primary--text" fixed app>
            <v-app-bar-nav-icon class="primary--text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
        </v-app-bar>
    </div>
</template>
<script>
    export default {
        data() {
            return {
                drawer: null,
            }
        },

        methods: {
            logout: async function() {
                await axios
                    .get('logout')
                    .then()
                    .catch(error => console.log(error))

                location.reload()
            },
        },
    }
</script>
