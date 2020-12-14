<template>
    <div>
        <v-navigation-drawer v-model="drawer" app absolute temporary>
            <v-list shaped>
                <v-list-item-group>
                    <v-list-item class="my-1" dense>
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
                    <v-list-item class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Clientes</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="my-1" dense>
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
                    <v-list-item class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>POS</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                    <v-list-item class="my-1" dense>
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
                    <v-list-item class="my-1" dense>
                        <v-list-item-content>
                            <v-list-item-title>Salidas</v-list-item-title>
                        </v-list-item-content>
                    </v-list-item>
                </v-list-item-group>
            </v-list>
        </v-navigation-drawer>
        <v-app-bar class="primary white--text" fixed app>
            <v-app-bar-nav-icon class="white--text" @click.stop="drawer = !drawer"></v-app-bar-nav-icon>
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
    }
</script>
