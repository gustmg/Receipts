
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

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
Vue.component('clients-component', require('./components/clients/ClientsComponent.vue').default);
Vue.component('client-search-bar-component', require('./components/clients/ClientSearchBarComponent.vue').default);
Vue.component('clients-list-component', require('./components/clients/ClientsListComponent.vue').default);
Vue.component('new-client-button-component', require('./components/clients/NewClientButtonComponent.vue').default);
Vue.component('new-client-modal-component', require('./components/clients/NewClientModalComponent.vue').default);
Vue.component('update-client-modal-component', require('./components/clients/UpdateClientModalComponent.vue').default);
Vue.component('delete-client-modal-component', require('./components/clients/DeleteClientModalComponent.vue').default);

Vue.component('services-component', require('./components/services/ServicesComponent.vue').default);
Vue.component('service-search-bar-component', require('./components/services/ServiceSearchBarComponent.vue').default);
Vue.component('services-list-component', require('./components/services/ServicesListComponent.vue').default);
Vue.component('new-service-button-component', require('./components/services/NewServiceButtonComponent.vue').default);
Vue.component('new-service-modal-component', require('./components/services/NewServiceModalComponent.vue').default);
Vue.component('update-service-modal-component', require('./components/services/UpdateServiceModalComponent.vue').default);
Vue.component('delete-service-modal-component', require('./components/services/DeleteServiceModalComponent.vue').default);

Vue.component('receipts-component', require('./components/receipts/ReceiptsComponent.vue').default);
Vue.component('receipt-search-bar-component', require('./components/receipts/ReceiptSearchBarComponent.vue').default);
Vue.component('receipts-list-component', require('./components/receipts/ReceiptsListComponent.vue').default);
Vue.component('new-receipt-button-component', require('./components/receipts/NewReceiptButtonComponent.vue').default);
Vue.component('new-receipt-modal-component', require('./components/receipts/NewReceiptModalComponent.vue').default);
Vue.component('update-receipt-modal-component', require('./components/receipts/UpdateReceiptModalComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});
