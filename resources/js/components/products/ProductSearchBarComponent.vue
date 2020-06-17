<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper" >
                <i class="material-icons prefix">search</i>
                <input :value="search" @input="$emit('update:searchValueProduct', $event.target.value)" placeholder="Buscar servicio" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
            </div>
        </div>
    </div>
</template>
<style></style>
<script>
	export default {
		props: ['search'],
	}
</script>