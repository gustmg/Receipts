<template>
    <div id="warningProductCostModal" class="modal warningProductCostModal">
        <div class="modal-content">
            <div class="row">
                <div class="col m12">
                    <h6 class="noselect"><b>Alerta</b></h6>
                    <span class="noselect">El valor ingresado es menor al costo de compra del producto, por lo que se generaría una pérdida al venderlo bajo dicho precio. Se recomienda modificar la cantidad a un valor mayor.</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col m12">
                    <button class="modal-action modal-close waves-effect btn"><b>Entendido</b></button>
                </div>
            </div>
        </div>
    </div>
</template>
<style scoped>
    .warningProductCostModal{
        width: 37%;
        height: 40%;
    }
    .noselect{
        -webkit-touch-callout: none; /* iOS Safari */
        -webkit-user-select: none; /* Safari */
        -khtml-user-select: none; /* Konqueror HTML */
        -moz-user-select: none; /* Old versions of Firefox */
            -ms-user-select: none; /* Internet Explorer/Edge */
                user-select: none; /* Non-prefixed version, currently
                                    supported by Chrome, Edge, Opera and Firefox */
    }
</style>