<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper" >
                <i class="material-icons prefix">search</i>
                <input :value="searchProductValue" @input="updateSearchProduct" placeholder="Buscar producto" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
            </div>
        </div>
    </div>
</template>
<style></style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
	export default {
		computed: {
            ...mapState({
                searchProductValue: state => state.searchProductValue
            })
        },

        methods: {
            ...mapActions(['updateSearchProductValue']),
            updateSearchProduct: function (event) {
                this.updateSearchProductValue(event.target.value);
            }
        }
	}
</script>