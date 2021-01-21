/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import './bootstrap'
import _ from 'lodash'
import Vue from 'vue'
import Vuex from 'vuex'
import VueFormulate from '@braid/vue-formulate'
import VueCurrencyInput from 'vue-currency-input'
import storeData from './store/index'
import vuetify from './plugins/vuetify'
import VueApexCharts from 'vue-apexcharts'

const vueCurrencyOptions = {
    globalOptions: {
        currency: 'MXN',
    },
}

Vue.use(Vuex)
Vue.use(VueCurrencyInput, vueCurrencyOptions)
Vue.use(VueFormulate)
Vue.use(VueApexCharts)

const store = new Vuex.Store(storeData)

Vue.mixin({
    methods: {
        formatNumberToCurrency: number => {
            var formatter = new Intl.NumberFormat('en-US', {
                style: 'currency',
                currency: 'USD',
            })

            return formatter.format(number)
        },
    },
})

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/clients/ExampleComponent.vue').default);
Vue.component('home-component', require('./components/HomeComponent.vue').default)
Vue.component('login-component', require('./components/LoginComponent.vue').default)
Vue.component('app-header-component', require('./components/AppHeaderComponent.vue').default)

Vue.component('clients-component', require('./components/clients/ClientsComponent.vue').default)
Vue.component('clients-table-component', require('./components/clients/ClientsTableComponent.vue').default)
Vue.component('client-search-bar-component', require('./components/clients/ClientSearchBarComponent.vue').default)
Vue.component('clients-list-component', require('./components/clients/ClientsListComponent.vue').default)
Vue.component('clients-list-modal-component', require('./components/clients/ClientsListModalComponent.vue').default)
Vue.component('new-client-modal-component', require('./components/clients/NewClientModalComponent.vue').default)
Vue.component('edit-client-dialog-component', require('./components/clients/EditClientDialogComponent.vue').default)
Vue.component('delete-client-dialog-component', require('./components/clients/DeleteClientDialogComponent.vue').default)

Vue.component('services-component', require('./components/services/ServicesComponent.vue').default)
Vue.component('service-search-bar-component', require('./components/services/ServiceSearchBarComponent.vue').default)
Vue.component('services-table-component', require('./components/services/ServicesTableComponent.vue').default)
Vue.component('services-list-modal-component', require('./components/services/ServicesListModalComponent.vue').default)
Vue.component('new-service-modal-component', require('./components/services/NewServiceModalComponent.vue').default)
Vue.component('edit-service-dialog-component', require('./components/services/EditServiceDialogComponent.vue').default)
Vue.component(
    'delete-service-dialog-component',
    require('./components/services/DeleteServiceDialogComponent.vue').default
)

Vue.component('products-component', require('./components/products/ProductsComponent.vue').default)
Vue.component('product-search-bar-component', require('./components/products/ProductSearchBarComponent.vue').default)
Vue.component('products-table-component', require('./components/products/ProductsTableComponent.vue').default)
Vue.component('products-list-modal-component', require('./components/products/ProductsListModalComponent.vue').default)
Vue.component(
    'products-list-dialog-component',
    require('./components/products/ProductsListDialogComponent.vue').default
)
Vue.component('new-product-modal-component', require('./components/products/NewProductModalComponent.vue').default)
Vue.component('edit-product-dialog-component', require('./components/products/EditProductDialogComponent.vue').default)
Vue.component(
    'delete-product-dialog-component',
    require('./components/products/DeleteProductDialogComponent.vue').default
)
Vue.component(
    'products-list-with-stocks-modal-component',
    require('./components/products/ProductsListWithStocksModalComponent.vue').default
)

Vue.component('receipts-component', require('./components/receipts/ReceiptsComponent.vue').default)
Vue.component('receipt-search-bar-component', require('./components/receipts/ReceiptSearchBarComponent.vue').default)
Vue.component('receipts-list-component', require('./components/receipts/ReceiptsListComponent.vue').default)
Vue.component('new-receipt-modal-component', require('./components/receipts/NewReceiptModalComponent.vue').default)
Vue.component(
    'update-receipt-modal-component',
    require('./components/receipts/UpdateReceiptModalComponent.vue').default
)

Vue.component('new-device-modal-component', require('./components/devices/NewDeviceModalComponent.vue').default)
Vue.component('devices-list-component', require('./components/devices/DevicesListComponent.vue').default)

Vue.component(
    'new-accessory-modal-component',
    require('./components/accessories/NewAccessoryModalComponent.vue').default
)

Vue.component('sales-component', require('./components/sales/SalesComponent.vue').default)
Vue.component('sale-info-component', require('./components/sales/SaleInfoComponent.vue').default)
Vue.component('sale-detail-component', require('./components/sales/SaleDetailComponent.vue').default)
Vue.component('sale-search-bar-component', require('./components/sales/SaleSearchBarComponent.vue').default)

Vue.component('reports-component', require('./components/reports/ReportsComponent.vue').default)
Vue.component('report-detail-dialog-component', require('./components/reports/ReportDetailDialogComponent.vue').default)

Vue.component(
    'inventory-entries-component',
    require('./components/inventory_entries/InventoryEntriesComponent.vue').default
)
Vue.component(
    'inventory-entries-list-component',
    require('./components/inventory_entries/InventoryEntriesListComponent.vue').default
)
Vue.component(
    'new-inventory-entry-modal-component',
    require('./components/inventory_entries/NewInventoryEntryModalComponent.vue').default
)
Vue.component(
    'inventory-entry-detail-modal-component',
    require('./components/inventory_entries/InventoryEntryDetailModalComponent.vue').default
)

Vue.component('inventory-exits-component', require('./components/inventory_exits/InventoryExitsComponent.vue').default)
Vue.component(
    'inventory-exits-list-component',
    require('./components/inventory_exits/InventoryExitsListComponent.vue').default
)
Vue.component(
    'new-inventory-exit-modal-component',
    require('./components/inventory_exits/NewInventoryExitModalComponent.vue').default
)
Vue.component(
    'inventory-exit-detail-modal-component',
    require('./components/inventory_exits/InventoryExitDetailModalComponent.vue').default
)

Vue.component('timeline-dialog-component', require('./components/devices/TimelineDialogComponent.vue').default)
Vue.component(
    'update-service-status-dialog-component',
    require('./components/devices/UpdateServiceStatusDialogComponent.vue').default
)

Vue.component('apexchart', VueApexCharts)

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    vuetify,
})
