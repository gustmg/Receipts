<template>
    <button v-on:click="newInventoryEntry" class="btn-floating btn-large">
        <i class="material-icons">add</i>
    </button>
</template>
<style scoped>
    .btn-floating{
        position: fixed;
        bottom: 24px;
        right: 24px;
    }
</style>
<script>
    export default {
        methods: {
            newInventoryEntry: function() {
                $('#newInventoryEntryModal').modal('open');
            },
        }
    }
</script>