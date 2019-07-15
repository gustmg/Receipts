<template>
	<div class="row" style="margin-bottom: 0;">
		<div class="card hoverable col s12 m12" style="float: none;">
			<div class="input-field valign-wrapper" >
				<i class="material-icons prefix">add_shopping_cart</i>
				<input :value="search" class="autocomplete" @input="$emit('update:searchValue', $event.target.value)" placeholder="Ingresar código de servicio o producto" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
			</div>
		</div>
	</div>
</template>
<style></style>
<script>
	export default {
		props: ['search'],

		mounted () {
			document.addEventListener('DOMContentLoaded', function() {
				var elems = document.querySelectorAll('.autocomplete');
				var instances = M.Autocomplete.init(elems, {data: {
						"Apple": null,
						"Microsoft": null,
						"Google": 'https://placehold.it/250x250'
				},
				});
			});

			console.log("Autocomplete mounted");
		}
	}
</script>