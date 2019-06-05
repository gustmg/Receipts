<template>
    <div class="row">
        <new-service-button-component></new-service-button-component>
        <new-service-modal-component></new-service-modal-component>
    </div>
</template>
<script>
    export default {
        props: {
            services: {
                type: Array
            },
            searchValue:String,
        },

        data() {
            return {
                searchService: '',
                componentKey: 0
            }
        },

        mounted() {
            console.log('Services component mounted');
        },

        methods: {
            forceRerender() {
                this.componentKey += 1;  
            }
        }
    }
</script>

