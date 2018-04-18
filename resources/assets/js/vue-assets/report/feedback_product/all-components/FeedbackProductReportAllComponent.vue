<template>
    <div>
        <!--<div class="text-center">-->
            <!--<h5>Show by rating</h5>-->
            <!--<div class="btn-group" role="group" aria-label="...">-->
                <!--<button type="button" class="btn btn-default active">-->
                    <!--<i id="dissatisfied"-->
                       <!--class="material-icons text-red"-->
                       <!--data-value="1"-->
                       <!--style="font-size: 2em;">-->
                        <!--sentiment_very_dissatisfied-->
                    <!--</i>-->
                <!--</button>-->
                <!--<button type="button" class="btn btn-default">-->
                    <!--<i id="neutral"-->
                       <!--class="material-icons text-yellow"-->
                       <!--data-value="2"-->
                       <!--style="font-size: 2em;">-->
                        <!--sentiment_neutral-->
                    <!--</i>-->
                <!--</button>-->
                <!--<button type="button" class="btn btn-default">-->
                    <!--<i id="satisfied"-->
                       <!--class="material-icons text-green"-->
                       <!--data-value="3"-->
                       <!--style="font-size: 2em;">-->
                        <!--sentiment_very_satisfied-->
                    <!--</i>-->
                <!--</button>-->
            <!--</div>-->
        <!--</div>-->

        <div class="row">
            <div class="col-lg-6">
                <div class="btn-group" role="group" aria-label="...">
                    <a role="button" class="btn btn-xs btn-default">Daily</a>
                    <a role="button" class="btn btn-xs btn-default">Weekly</a>
                    <a role="button" class="btn btn-xs btn-default">Monthly</a>
                    <a role="button" class="btn btn-xs btn-default active">Yearly</a>
                </div>
            </div>
            <div class="col-lg-6">
                <form class="form-inline">
                    <div class="pull-right">
                        <label for="select_year">Select Year</label>
                        <select id="select_year" name="select_year" class="form-control">
                            <option v-for="n in 18" v-bind:value="2000 + n">{{ 2000 + n }}</option>
                        </select>
                    </div>
                </form>
            </div>
        </div>

        <chartjs-bar :datalabel="'Feedback'" :options="options" :labels="labels" :data="data" :backgroundcolor="'rgba(255,102,102,0.5)'" :bordercolor="'rgba(255,0,0,1)'"></chartjs-bar>
    </div>
</template>

<script>

    Vue.use(VueCharts);

    export default {
        name: "feedback-product-report-all",
        props: ['tenant_id'],
        data() {
            return {
                data: [],
                labels: [],
                options:{
                    responsive:true,
                    maintainAspectRatio:true,
                    scales: {
                        yAxes: [{
                            stacked: true
                        }]
                    }
                },
                width : '55vh',
                height : '80vw'
            }
        },
        created() {
            this.getAllFeedbackProduct();
        },
        methods: {
            getAllFeedbackProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product_report/' + vm.tenant_id + '/get-all-report/' + 3 + '/' + '2018' + '/' + '10';

                axios.get(url).then(response => {
                    console.log(response.data);
                    for(let i=0;i<response.data.data.length;i++) {
                        vm.data.push(response.data.data[i]);
                        vm.labels.push(response.data.labels[i]);
                    }
                    console.log({data: vm.data, labels: vm.labels});
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>