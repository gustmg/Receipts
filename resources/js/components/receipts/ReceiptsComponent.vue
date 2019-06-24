<template>
    <div class="row">
        <receipt-search-bar-component :search-value.sync="searchReceipt"></receipt-search-bar-component>
        <receipts-list-component :receipts="receipts" :key="componentKey"></receipts-list-component>
        <new-receipt-button-component></new-receipt-button-component>
        <new-receipt-modal-component :devices="devices"></new-receipt-modal-component>
        <new-device-modal-component :accessories="accessories" :accessoryKey="componentAccessoryKey"></new-device-modal-component>
        <new-accessory-modal-component></new-accessory-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            receipts: {
                type: Array
            },
            
            searchValue: String,
        },

        data() {
            return {
                searchReceipt: '',
                componentKey: 0,
                componentAccessoryKey: 0,
                devices: [],
                accessories: []
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


