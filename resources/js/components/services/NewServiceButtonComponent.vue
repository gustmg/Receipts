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
                $('#service_name,#service_description').characterCounter();
                $('#newServiceModal').modal({
                    dismissible: false
                });
                $('#newServiceModal').modal('open');
            },
        }
    }
</script>


