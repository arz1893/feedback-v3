<template>
    <div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="select_customer">Select Customer</label>
                    <div class="input-group input-group-md">
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
                                <i class="fa fa-plus-circle fa-2x"></i>
                            </button>
                        </span>
                    </div>
                </div>
                <div class="error">
                    <label for="customer_rating" :class="{ 'text-red': validator.errors.has('customer_rating') }">Rating</label>

                    <input type="radio" name="customer_rating" id="radio_dissatisfied" class="invisible" value="1" v-model="feedbackProduct.rating"/>
                    <input type="radio" name="customer_rating" id="radio_neutral" class="invisible" value="2" v-model="feedbackProduct.rating"/>
                    <input type="radio" name="customer_rating" id="radio_satisfied" class="invisible" value="3" v-model="feedbackProduct.rating"/>
                    <br>

                    <a role="button">
                        <i id="dissatisfied"
                           class="smiley_rating material-icons text-red"
                           data-value="1"
                           @click="changeRating($event)"
                           style="font-size: 3.5em;">
                            sentiment_very_dissatisfied
                        </i>
                    </a>
                    <a role="button">
                        <i id="neutral"
                           class="smiley_rating material-icons text-yellow"
                           data-value="2"
                           @click="changeRating($event)"
                           style="font-size: 3.5em;">
                            sentiment_neutral
                        </i>
                    </a>
                    <a role="button">
                        <i id="satisfied"
                           class="smiley_rating material-icons text-green"
                           data-value="3"
                           @click="changeRating($event)"
                           style="font-size: 3.5em;">
                            sentiment_very_satisfied
                        </i>
                    </a>
                    <br>
                    <span class="help text-red" v-show="validator.errors.has('customer_rating')">{{ validator.errors.first('customer_rating') }}</span>
                </div>
                <div class="form-group" :class="{'has-error': validator.errors.has('feedback')}">
                    <label for="feedback">Feedback</label>
                    <textarea class="form-control" name="feedback" id="feedback" placeholder="Please enter customer's feedback" rows="6" v-model="feedbackProduct.feedback"></textarea>
                    <span class="help text-red" v-show="validator.errors.has('feedback')">{{ validator.errors.first('feedback') }}</span>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="attachment">Change / Add attachment</label>
                    <input type="file" name="attachment" id="attachment" class="form-control-file" accept="image/*" v-on:change="previewImage($event)"/>
                </div>
            </div>


            <div class="form-group" v-if="feedbackProduct.image !== null" style="width: 180px;">
                <span class="mailbox-attachment-icon has-img">
                    <img src="" id="preview" v-bind:src="feedbackProduct.image">
                </span>

                <div class="mailbox-attachment-info">
                    <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                        <i class="fa fa-close"></i>
                    </a>
                    <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> attachment</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';
    import { Validator } from 'vee-validate';

    Vue.component('multiselect', MultiSelect);

    Vue.use(VeeValidate, {
        dictionary: {
            en: {
                custom: {
                    customer_rating: {
                        required: "Customer's  rating has not been set"
                    },
                    feedback: {
                        required: "Please enter customer's feedback"
                    },
                    name: {
                        required: "Please enter customer's name"
                    },
                    gender: {
                        required: "Gender has not been set yet"
                    },
                    phone: {
                        required: "Please enter customer's phone number"
                    },
                    birthdate: {
                        required: "Customer's birth date has not been set"
                    }
                }
            }
        }
    });

    export default {
        name: "feedback-product-edit",
        props: ['feedback_product_id', 'tenant_id', 'syscreator'],
        data() {
            return {
                feedbackProduct: {
                    systemId: '',
                    customer: '',
                    rating: '',
                    feedback: '',
                    fileName: '',
                    image: '',
                    need_call: 0,
                    is_urgent: 0
                },
                customerOptions: [],
                selectedCustomer: ''
            }
        },
        created() {
            this.getFeedbackProduct();
            this.getCustomerList();
            this.generateSelectedCustomer();

            this.validator = new Validator({
                customer_rating: 'required',
                feedback: 'required',
                name: 'required',
                gender: 'required',
                phone: 'required|numeric|min:10',
                birthdate: 'required',
                email: 'email'
            });
        },
        methods: {
            getFeedbackProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + vm.feedback_product_id + '/get-feedback-product';

                axios.get(url).then(response => {
                    vm.feedbackProduct.systemId = response.data.data.systemId;
                    vm.feedbackProduct.customer = response.data.data.customer;
                    vm.feedbackProduct.rating = response.data.data.customer_rating;
                    vm.feedbackProduct.feedback = response.data.data.customer_feedback;
                    vm.feedbackProduct.image = response.data.data.attachment;
                    vm.feedbackProduct.need_call = response.data.data.need_call;
                    vm.feedbackProduct.is_urgent = response.data.data.is_urgent;

                    switch (response.data.data.customer_rating) {
                        case 1 :{
                            $('#dissatisfied').addClass('is-selected');
                            break;
                        }
                        case 2 :{
                            $('#neutral').addClass('is-selected');
                            break;
                        }
                        case 3 : {
                            $('#satisfied').addClass('is-selected');
                        }
                    }

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
            },
            changeRating: function (event) {
                let vm = this;
                switch ($(event.currentTarget).data('value')) {
                    case 1: {
                        $(event.currentTarget).addClass('is-selected');
                        $('#neutral').removeClass('is-selected');
                        $('#satisfied').removeClass('is-selected');
                        vm.feedbackProduct.rating = 1;
                        console.log(vm.feedbackProduct.rating);
                        break;
                    }
                    case 2: {
                        $(event.currentTarget).addClass('is-selected');
                        $('#dissatisfied').removeClass('is-selected');
                        $('#satisfied').removeClass('is-selected');
                        vm.feedbackProduct.rating = 2;
                        console.log(vm.feedbackProduct.rating);
                        break;
                    }
                    case 3: {
                        $(event.currentTarget).addClass('is-selected');
                        $('#neutral').removeClass('is-selected');
                        $('#dissatisfied').removeClass('is-selected');
                        vm.feedbackProduct.rating = 3;
                        console.log(vm.feedbackProduct.rating);
                        break;
                    }
                }
            },
        }
    }
</script>

<style scoped>

</style>