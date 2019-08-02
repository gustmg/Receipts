<template>
    <div class="row" style="margin-bottom:0px; !important;">
        <div class="col m8" style="padding-left:24px !important;">
            <div class="row" style="margin-bottom:0px; !important;">
                <div class="col m6">
                    <sale-search-bar-component :search-value.sync="searchProduct"></sale-search-bar-component>
                </div>
                <div class="col m6 center-align" style="padding-top:18px !important;">
                    <button v-on:click="showProductsList" class="mdc-button mdc-button--outlined">Lista de productos</button>&nbsp;&nbsp;
                    <button v-on:click="showServicesList" class="mdc-button mdc-button--outlined">Lista de servicios</button>
                </div>
                <div class="col m12 card">
                    <table class="centered">
                        <thead class="">
                            <tr>
                                <th style="width:10%;">Cantidad</th>
                                <th style="width:10%;">Tipo</th>
                                <th style="width:45%;">Descripción</th>
                                <th style="width:15%;">Precio Unitario</th>
                                <th style="width:15%;">Importe</th>
                                <th style="width:5%;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(article, index) in articles">
                                <td>
                                    <div class="input-field custom-sale-field">
                                        <input v-model="article.article_quantity" class="validate" type="number" min="1">
                                    </div>
                                </td>
                                <td>{{setArticleType(article.article_type)}}</td>
                                <td>{{article.article_description}}</td>
                                <td>
                                    <div class="input-field custom-sale-field">
                                        <input v-model="article.article_unit_price" class="validate" type="number" min="0.01" step="0.01" pattern="^\d*(\.\d{0,2})?$" >
                                    </div>
                                </td>
                                <td>${{getFormatedNumber(article.article_quantity*article.article_unit_price)}}</td>
                                <td><a class="selectable red-text" v-on:click="removeArticle(index)"><i class="material-icons">cancel</i></a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col m4" style="padding-left:24px !important;padding-top:8px !important;">
            <div class="row">
                <div class="col m12">
                    <span class="grey-text"><b>Información de venta</b></span><br>
                    <span><b>Folio:</b> {{lastSaleId}}</span><br>
                    <span><b>Fecha:</b> {{date}}</span><br>
                    <span><b>Venta realizada por:</b> {{worker.name}}</span><br>
                    <div class="row" style="padding-top:12px !important;">
                        <div class="col m12">
                            <div class="row">
                                <div class="col m12">
                                    <div class="switch">
                                        <label>
                                            <b>¿Cliente nuevo?</b>
                                            <input type="checkbox" v-model="newClientToggle" v-on:click="newClientToggleHandler">
                                            <span class="lever"></span>
                                        </label>
                                        <button v-on:click="showClientsList" class="mdc-button mdc-button--outlined" :disabled="newClientToggle == true">Buscar cliente</button>
                                    </div><br>
                                </div>
                                <div class="col m12">
                                    <form class="row">
                                        <div class="input-field col s4">
                                            <input placeholder="" v-model="clientId" id="receipt_client_id" type="text" disabled>
                                            <label for="client_id">No. de cliente</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input placeholder="" v-model="clientName" id="receipt_client_name" type="text" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientName" v-bind:class="{'valid': validClientName, 'invalid': invalidClientName}" data-length="50" maxlength="50" required>
                                            <label for="client_name">Nombre</label>
                                        </div>
                                        <div class="input-field col s8">
                                            <input placeholder="" v-model="clientEmail" id="receipt_client_email" type="email" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientEmail" v-bind:class="{'valid': validClientEmail, 'invalid': invalidClientEmail}" data-length="40" maxlength="40">
                                            <label for="client_email">E-mail</label>
                                        </div>
                                        <div class="input-field col s4">
                                            <input placeholder="" v-model="clientPhone" id="receipt_client_phone" type="tel" :disabled="newClientToggle == false" v-on:blur="validateReceiptClientPhone" v-bind:class="{'valid': validClientPhone, 'invalid': invalidClientPhone}" data-length="10" minlength="10" maxlength="10">
                                            <label for="client_phone">Teléfono</label>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="input-field col s12 m8" style="margin-top:0 !important;">
                            <select v-model="paymentForm" class="icons">
                                <option value="1" data-icon="svg/baseline-attach_money-24px.svg">Efectivo</option>
                                <option value="2" data-icon="svg/baseline-payment-24px.svg">Tarjeta de crédito / débito</option>
                            </select>
                            <label>Forma de pago</label>
                        </div>
                        <div class="col m8 switch">
                            <label>
                              Venta facturada
                              <input type="checkbox" v-model="vatChargeToggle">
                              <span class="lever"></span>
                            </label>
                        </div>
                        <div class="col m6">
                            <br><span><b>Subtotal: ${{getFormatedNumber(subtotalAmount)}}</b></span>
                            <br><span><b>IVA: ${{getFormatedNumber(vatAmount)}}</b></span>
                            <br><span><b>Total: ${{getFormatedNumber(totalAmount)}}</b></span>
                        </div>
                        <div class="col m6 right-align">
                            <button class="mdc-button mdc-button--outlined" v-on:click="saveSale" v-bind:disabled="validateForm">Realizar venta</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <clients-compact-list-modal-component :clients="clients" :client-id.sync="clientId" :client-name.sync="clientName" :client-phone.sync="clientPhone" :client-email.sync="clientEmail"></clients-compact-list-modal-component>
        <div id="servicesCompactListModal" class="modal servicesCompactListModal">
            <div class="modal-content">
                <!-- <client-search-bar-component></client-search-bar-component> -->
                <ul class="collection with-header">
                    <a class="collection-item selectable service-element" v-on:click="selectArticle(service, 1)" v-for="(service, index) in services">{{service.service_name}}</a>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            </div>
        </div>
        <div id="productsCompactListModal" class="modal productsCompactListModal">
            <div class="modal-content">
                <!-- <client-search-bar-component></client-search-bar-component> -->
                <ul class="collection with-header">
                    <a class="collection-item selectable product-element" v-on:click="selectArticle(product, 0)" v-for="(product, index) in products">{{product.product_name}}</a>
                </ul>
            </div>
            <div class="modal-footer">
                <button class="modal-action modal-close waves-effect btn-flat"><b>Cancelar</b></button>
            </div>
        </div>
    </div>
</template>
<style type="text/css">
	.modal-content{
		padding-bottom: 0 !important;
	}

    .custom-sale-field{
        margin-top: 0 !important;
        margin-bottom: 0 !important;
    }
	
    .client-element, .service-element, .product-element{
        color:#039be5 !important;
    }
</style>
<script>
    export default {
        mounted() {
            document.addEventListener('DOMContentLoaded', function() {
              var elems = document.querySelectorAll('select');
              var instances = M.FormSelect.init(elems);
            });
        },

        props: {
            sales: {
                type: Array
            },
            
            products: {
                type: Array
            },

            services: {
                type: Array
            },

            clients: {
                type: Array
            },

            worker: {
                type: Object
            },
        },

        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                lastClientId: this.clients[this.clients.length - 1].client_id + 1,
                searchProduct: '',
                componentKey: 0,
                clientId: 0,
                clientName: null,
                clientEmail: null,
                clientPhone: null,
                validClientName: false,
                invalidClientName: false,
                validClientPhone: false,
                invalidClientPhone: false,
                validClientEmail: false,
                invalidClientEmail: false,
                newClientToggle: false,
                vatChargeToggle: false,
                paymentForm: "1",
                articles: []
            }
        },

        computed: {
            validateForm: function() {
                if(this.newClientToggle){
                    if(this.articles.length==0 || !this.validClientName || this.invalidClientPhone || this.invalidClientEmail){
                        return true;
                    }
                    else if(this.articles.length>0 && this.validateUnitPrices != 0){
                        return true;
                    }
                }
                else{
                    if(this.articles.length==0 || this.clientName==null){
                        return true;
                    }
                    else if(this.articles.length>0 && this.validateUnitPrices != 0){
                        return true;
                    }
                }
            },

            validateUnitPrices: function() {
                var amount_zero_prices=0;
                this.articles.forEach(article => {
                    if(article.article_unit_price==0){
                        amount_zero_prices=amount_zero_prices+1;
                    }
                });
                return amount_zero_prices;
            },

            lastSaleId: function() {
                if(this.sales.length > 0){
                    return this.sales[this.sales.length - 1].sale_id + 1;
                }
                else{
                    return 1;
                }
            },

            subtotalAmount: function() {
                var x=0;
                var subtotal;
                this.articles.forEach(article => {
                    subtotal=article.article_quantity*article.article_unit_price;
                    x=x+subtotal;
                });
                
                return x;
            },

            vatAmount: function() {
                if(this.vatChargeToggle){
                    return parseFloat(Math.round(this.subtotalAmount*0.16 * 100) / 100).toFixed(2);
                }
                else{
                    return parseFloat(Math.round(0 * 100) / 100).toFixed(2);
                }
            },

            totalAmount: function() {
                return (parseFloat(this.subtotalAmount) + parseFloat(this.vatAmount)).toFixed(2);
            },

            date: function() {
                var d = new Date();

                switch (d.getMonth()) {
                    case 0:
                        return "Enero"+d.getDate()+", "+d.getFullYear();
                    case 1:
                        return "Febrero"+d.getDate()+", "+d.getFullYear();
                    case 2:
                        return "Marzo"+d.getDate()+", "+d.getFullYear();
                    case 3:
                        return "Abril"+d.getDate()+", "+d.getFullYear();
                    case 4:
                        return "Mayo"+d.getDate()+", "+d.getFullYear();
                    case 5:
                        return "Junio"+d.getDate()+", "+d.getFullYear();
                    case 6:
                        return "Julio "+d.getDate()+", "+d.getFullYear();
                    case 7:
                        return "Agosto"+d.getDate()+", "+d.getFullYear();
                    case 8:
                        return "Septiembre"+d.getDate()+", "+d.getFullYear();
                    case 9:
                        return "Octubre"+d.getDate()+", "+d.getFullYear();
                    case 10:
                        return "Noviembre"+d.getDate()+", "+d.getFullYear();
                    case 11:
                        return "Diciembre"+d.getDate()+", "+d.getFullYear();
                    default:
                        break;
                }
            }
        },

        methods: {
            getFormatedNumber: function(number) {
                var int_amount=parseInt(number);
                var decimal_amount=(number%1).toFixed(2).slice(1);
                return int_amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + decimal_amount;
            },

            setTwoNumberDecimal: function() {
                this.value = parseFloat(this.value).toFixed(2);
            },

            showClientsList: function () {
                $('#clientsCompactListModal').modal({
                    dismissible: false
                });
                $('#clientsCompactListModal').modal('open');
            },

            showProductsList: function () {
                $('#productsCompactListModal').modal({
                    dismissible: false
                });
                $('#productsCompactListModal').modal('open');
            },

            showServicesList: function () {
                $('#servicesCompactListModal').modal({
                    dismissible: false
                });
                $('#servicesCompactListModal').modal('open');
            },

            newClientToggleHandler: function () {
                if(!this.newClientToggle){
                    this.clientId=this.lastClientId;
                    this.clientName=null;
                    this.clientEmail=null;
                    this.clientPhone=null;
                }
                else{
                    this.clientId=0;
                    this.clientName=null;
                    this.clientEmail=null;
                    this.clientPhone=null;
                }
                this.validClientName= false;
                this.invalidClientName=false;
                this.validClientPhone=false;
                this.invalidClientPhone=false;
                this.validClientEmail=false;
                this.invalidClientEmail=false;
            },

            validateReceiptClientName: function(e) {
                if(!this.clientName){
                    this.validClientName = false;
                    this.invalidClientName = true;
                    $('.receipt_name_helper').attr('data-error', 'Este campo no puede quedar vacío.');
                }
                else{
                    this.validClientName = true;
                    this.invalidClientName = false;
                }
            },

            validateReceiptClientPhone: function(e) {
                const PHONE_REGEXP = /^[0-9]*$/gm;

                if(this.clientPhone ==null || this.clientPhone.length == 0){
                    this.validClientPhone = false;
                    this.invalidClientPhone = false;
                }
                else if(!PHONE_REGEXP.test(this.clientPhone) || this.clientPhone.length < 10){
                    this.validClientPhone = false;
                    this.invalidClientPhone = true;
                    $('.receipt_phone_helper').attr('data-error', 'Número telefónico no válido.');
                }
                else{
                    this.validClientPhone = true;
                    this.invalidClientPhone = false;
                }
            },

            validateReceiptClientEmail: function(e) {
                const MAIL_REGEXP = /^[a-zA-Z0-9.!#$%&’*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;

                if(this.clientEmail ==null || this.clientEmail.length == 0){
                    this.validClientEmail = false;
                    this.invalidClientEmail = false;
                }
                else if(!MAIL_REGEXP.test(this.clientEmail)){
                    this.validClientEmail = false;
                    this.invalidClientEmail = true;
                    $('.receipt_email_helper').attr('data-error', 'Correo electrónico no válido.');
                }
                else{
                    this.validClientEmail = true;
                    this.invalidClientEmail = false;
                }
            },

            setArticleType: function(article_type) {
                if(article_type==0){
                    return "Producto";
                }
                else{
                    return "Servicio";
                }
            },

            selectArticle: function(article, article_type) {
                var newArticle = {
                    article_id: 0,
                    article_quantity: 1,
                    article_type: article_type,
                    article_description: null,
                    article_code:null,
                    article_unit_price: 0
                }
                if(article_type == 1){
                    newArticle.article_id=article.service_id;
                    newArticle.article_description=article.service_description;
                    newArticle.article_code=article.service_code;
                }
                else{
                    newArticle.article_id=article.product_id;
                    newArticle.article_description=article.product_description;
                    newArticle.article_code=article.product_code;
                }
                this.articles.push(newArticle);
                $('#servicesCompactListModal').modal('close');
                $('#productsCompactListModal').modal('close');
            },

            removeArticle: function(index) {
                this.articles.splice(index,1);
            },

            saveSale: function(){
                var newSale = {
                    sale_client_id : 0,
                    sale_payment_form_id : this.paymentForm,
                    sale_total_amount : this.totalAmount
                };

                if(this.newClientToggle){
                    this.saveClient();
                }

                axios.post('http://localhost:8000/sales',{
                    sale_client_id: this.clientId,
                    sale_payment_form_id: newSale.sale_payment_form_id,
                    sale_total_amount: newSale.sale_total_amount
                })
                .then((res)=>{
                    this.saveSaleArticles(res.data.sale_id);
                    // console.log("Venta guardada!");
                    // window.location.reload();
                })
                .catch(function(err){
                    console.log(err);
                });

                // this.$parent.receipts.push(newReceipt);
                // this.$parent.forceRerender();
                $('#newReceiptModal').modal('close');
            },

            saveClient: function() {
                axios.post('http://localhost:8000/clients',{
                    client_name: this.clientName,
                    client_phone: this.clientPhone,
                    client_email: this.clientEmail
                })
                .then((res)=>{
                    this.clientId=res.data.client_id;
                    // console.log("Cliente registrado con id: "+this.clientId);
                })
                .catch(function(err){
                    console.log(err);
                });
            },

            saveSaleArticles: function (sale_id) {
                this.articles.forEach(article => {
                    if(article.article_type == 1){
                        axios.post('http://localhost:8000/sales_services',{
                            sale_id: sale_id,
                            service_id: article.article_id,
                            service_quantity: article.article_quantity,
                            service_unit_price: article.article_unit_price,
                            service_description: article.article_description,
                            service_code: article.article_code
                        })
                        .then((res)=>{
                            // console.log("Equipo registrado");
                            
                        })
                        .catch(function(err){
                            console.log(err);
                        });
                    }
                    else{
                        axios.post('http://localhost:8000/sales_products',{
                            sale_id: sale_id,
                            product_id: article.article_id,
                            product_quantity: article.article_quantity,
                            product_unit_price: article.article_unit_price,
                            product_description: article.article_description,
                            product_code: article.article_code,
                        })
                        .then((res)=>{
                            console.log("Venta de productos registrados correctamente");   
                        })
                        .catch(function(err){
                            console.log(err);
                        });
                    }
                    
                });
                this.printSale(sale_id);
            },

            printSale: function(sale_id) {
                axios.post('http://localhost:8000/print',{
                    sale_id: sale_id,
                    tax: this.vatChargeToggle
                })
                .then((res)=>{
                    console.log(res.data.sale);   
                })
                .catch(function(err){
                    console.log(err);
                });
            }
        }
    }
</script>
