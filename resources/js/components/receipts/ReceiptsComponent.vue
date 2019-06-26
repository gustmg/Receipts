<template>
    <div class="row">
        <receipt-search-bar-component :search-value.sync="searchReceipt"></receipt-search-bar-component>
        <receipts-list-component :receipts="receipts" :key="componentKey"></receipts-list-component>
        <new-receipt-button-component></new-receipt-button-component>
        <new-receipt-modal-component :devices="devices" :receipt-client-id="receiptClient.client_id" :receipt-client-name="receiptClient.client_name" :receipt-client-phone="receiptClient.client_phone" :receipt-client-email="receiptClient.client_email" :last-client-id="lastClientId"></new-receipt-modal-component>
        <new-device-modal-component :accessories="accessories" :accessoryKey="componentAccessoryKey"></new-device-modal-component>
        <new-accessory-modal-component></new-accessory-modal-component>
        <clients-compact-list-modal-component :clients="clients" :receipt-client="receiptClient"></clients-compact-list-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            receipts: {
                type: Array
            },

            devices: {
                type: Array,
                default: function () { return [] }
            },

            receiptClient: { //TODO
                type: Object,
                default: function () {
                    return {
                        client_id: 0,
                        client_name:null,
                        client_email:null,
                        client_phone:null
                    }
                }
            },

            clients:{
                type: Array
            },
            
            searchValue: String
        },

        data() {
            return {
                searchReceipt: '',
                componentKey: 0,
                componentAccessoryKey: 0,
                accessories: [],
                lastClientId: this.clients[this.clients.length - 1].client_id + 1
            }
        },

        mounted() {
            console.log('Receipts component mounted');
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            },

            forceAccessoryRerender() {
                this.componentAccessoryKey += 1;
            }
        }
    }
</script>


