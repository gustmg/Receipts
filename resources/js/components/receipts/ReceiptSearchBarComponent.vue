<template>
	<div class="container">
		<div class="row" style="margin-bottom: 0;">
			<div class="card hoverable col s12 m12" style="float: none;">
				<div class="input-field valign-wrapper" >
					<i class="material-icons prefix">search</i>
					<input :value="search" @input="$emit('update:searchValue', $event.target.value)" placeholder="Buscar recepción" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
				</div>
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