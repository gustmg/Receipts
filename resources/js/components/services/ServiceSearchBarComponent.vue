<template>
    <div class="row" style="margin-bottom: 0;">
        <div class="card hoverable col s10 offset-s1" style="float: none;">
            <div class="input-field valign-wrapper" >
                <i class="material-icons prefix">search</i>
                <input :value="searchServiceValue" @input="updateSearchService" placeholder="Buscar service" type="text" style="border-bottom: none!important;box-shadow: none!important;margin-bottom: 0;">
            </div>
        </div>
    </div>
</template>
<style></style>
<script>
    import {mapState, mapMutations, mapActions} from "vuex";
	export default {
		computed: {
            ...mapState('services',{
                searchServiceValue: state => state.searchServiceValue
            })
        },

        methods: {
            ...mapActions('services',['updateSearchServiceValue']),
            updateSearchService: function (event) {
                this.updateSearchServiceValue(event.target.value);
            }
        }
	}
</script>