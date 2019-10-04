<template>
    <div class="row" style="margin-bottom:0px;">
        <div class="col s12" align="center">
            <div class="row">
                <div class="col s12">
                    <h5>Hola</h5>
                    <button v-on:click="downloadReport()">Descargar</button>
                </div>
            </div>
            <table class="centered highlight">
                <thead>
                    <tr>
                        <th>Folio</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Forma de pago</th>
                        <th>Monto total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(sale, index) in sales">
                        <td>{{sale.sale_id}}</td>
                        <td>{{formatDate(sale.created_at)}}</td>
                        <td>{{sale.client.client_name}}</td>
                        <td>{{sale.payment_form.payment_form_name}}</td>
                        <td>${{sale.sale_total_amount}}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>
<script>
    export default {
        props: {
            sales: {
                type: Array,
            }
        },

        methods: {
            formatDate: function (date) {
                var newDate = new Date(date);
                return newDate.getDate()+'/'+(newDate.getMonth()+1)+'/'+newDate.getFullYear()+' a las '+newDate.getHours()+':'+newDate.getMinutes()+' Hrs';
            },

            downloadReport: function() {
                axios.get('http://localhost:8000/sales/export/')
                .then((res)=>{
                    // console.log(res);
                })
                .catch(function(err){
                    console.log(err);
                });
            },

            data() {
                return {
                    csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                }
            }
        }
    }
</script>