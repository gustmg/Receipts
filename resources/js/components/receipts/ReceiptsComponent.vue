<template>
    <div class="row">
        <receipt-search-bar-component :search-value.sync="searchReceipt"></receipt-search-bar-component>
        <receipts-list-component :receipts="receipts" :key="componentKey"></receipts-list-component>
        <new-receipt-button-component></new-receipt-button-component>
        <new-receipt-modal-component :receipt-id="lastReceiptId" :worker="worker" :devices="devices" :client-id.sync="clientId" :client-name.sync="clientName" :client-phone.sync="clientPhone" :client-email.sync="clientEmail" :last-client-id="lastClientId"></new-receipt-modal-component>
        <new-device-modal-component :accessories="accessories" :accessoryKey="componentAccessoryKey"></new-device-modal-component>
        <new-accessory-modal-component></new-accessory-modal-component>
        <clients-compact-list-modal-component :clients="clients" :client-id.sync="clientId" :client-name.sync="clientName" :client-phone.sync="clientPhone" :client-email.sync="clientEmail"></clients-compact-list-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            receipts: {
                type: Array
            },

            // devices: {
            //     type: Array,
            //     default: function () { return [] }
            // },

            clients:{
                type: Array
            },

            worker: {
                type: Object
            },
            
            searchValue: String
        },

        data() {
            return {
                clientId: 0,
                clientName: null,
                clientPhone: null,
                clientEmail: null,
                searchReceipt: '',
                componentKey: 0,
                componentAccessoryKey: 0,
                devices: [],
                accessories: [],
                lastClientId: this.clients[this.clients.length - 1].client_id + 1
            }
        },

        mounted() {
            console.log('Receipts component mounted');
            console.log(this.receipts);
        },

        computed: {
            lastReceiptId: function() {
                if(this.receipts.length > 0){
                    return this.receipts[this.receipts.length - 1].receipt_id + 1;
                }
                else{
                    return 1;
                }
            }
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            },

            forceAccessoryRerender() {
                this.componentAccessoryKey += 1;
            },

            resetDevices() {
                this.devices=[];
            }
        }
    }
</script>


