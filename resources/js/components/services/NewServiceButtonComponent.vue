<template>
    <button v-on:click="newService" style="position:fixed;bottom: 24px;right: 24px;" class="btn-floating btn-large waves-effect waves-light">
        <i class="material-icons">add</i>
    </button>    
</template>
<script>
    export default {
        mounted() {
            console.log('New service button component mounted');
        },

        methods: {
            newService: function() {
                $('#newServiceModal').modal('open');
            },
        }
    }
</script>


