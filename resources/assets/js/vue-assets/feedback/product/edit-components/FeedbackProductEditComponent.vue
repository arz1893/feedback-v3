<template>
    <div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="select_customer">Select Customer</label>
                    <div class="input-group">
                        <multiselect id="customerId"
                                     name="customerId"
                                     v-model="selectedCustomer"
                                     :options="customerOptions"
                                     placeholder="Anonymous"
                                     label="name"
                                     track-by="name">
                        </multiselect>
                        <span class="input-group-btn">
                            <button class="btn btn-link" type="button">
                                <i class="fa fa-circle-plus"></i>
                            </button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "feedback-product-edit",
        props: ['feedback_product_id', 'tenant_id', 'syscreator'],
        data() {
            return {
                feedbackProduct: [],
                customerOptions: [],
                selectedCustomer: ''
            }
        },
        created() {
            this.getFeedbackProduct();
            this.getCustomerList();
            this.generateSelectedCustomer();
        },
        methods: {
            getFeedbackProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + vm.feedback_product_id + '/get-feedback-product';

                axios.get(url).then(response => {
                    vm.feedbackProduct = response.data.data;
                    console.log(vm.feedbackProduct);
                }).catch(error => {
                    console.log(error);
                });
            },
            getCustomerList: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/' + this.tenant_id + '/generate-select-customer';
                axios.get(url).then(response => {
                    this.customerOptions = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            generateSelectedCustomer: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + this.feedback_product_id + '/generate-selected-customer';
                axios.get(url).then(response => {
                    if(response.data !== null) {
                        vm.selectedCustomer = response.data;
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>