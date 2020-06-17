<template>
    <button v-on:click="newProduct" style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light">
        <i class="material-icons">add</i>
    </button>    
</template>
<script>
    import {mapMutations, mapActions} from "vuex";
    export default {
        mounted() {
            console.log('New product button component mounted');
        },

        methods: {
            ...mapActions(['openModal']),

            newProduct: function() {
                this.openModal($('#newProductModal'));
            },
        }
    }
</script>


