<template>
    <button v-on:click="newProduct" style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light">
        <i class="material-icons">add</i>
    </button>    
</template>
<script>
    export default {
        mounted() {
            console.log('New product button component mounted');
        },

        methods: {
            newProduct: function() {
                $('#product_name,#product_description').characterCounter();
                $('#newProductModal').modal({
                    dismissible: false
                });
                $('#newProductModal').modal('open');
            },
        }
    }
</script>


