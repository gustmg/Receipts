<template>
    <div class="container" style="margin-top:48px;">
        <div class="row">
            <div class="col m2">
                <button v-on:click="createBackup()" class="waves-effect waves-light btn">
                    Respaldar DB
                </button>
            </div>
        </div>
    </div>
</template>
<script>
    export default {
        methods: {
            createBackup: function() {
                axios
                    .post('createBackup')
                    .then(response => {
                        if (response.data == 1) {
                            M.toast({ html: 'I am a toast!', classes: 'rounded' })
                        }
                    })
                    .catch(error => console.log(error))
            },
        },
    }
</script>
