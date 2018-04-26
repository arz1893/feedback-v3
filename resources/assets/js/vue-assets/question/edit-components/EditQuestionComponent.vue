<template>
    <div>
        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">

                <div class="alert alert-success" role="alert" id="alert_success" v-show="alertSuccess" @click="alertSuccess = false">
                    <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong>Info!</strong> Question has been added, please look at <a role="button" class="alert-link">question list</a> to see all question from customer
                </div>

                <div class="form-group"  v-bind:class="{'has-error': validator.errors.has('customer')}">
                    <label for="customerId">Customer</label>
                    <div class="input-group">
                        <select class="form-control" name="customerId" id="customerId" v-model="question.customerId">
                            <option value="" selected>Choose...</option>
                            <option v-for="customer in selectCustomer" v-bind:value="customer.systemId">{{ customer.name }}</option>
                        </select>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-primary" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
                              <i class="fa fa-plus-circle"></i>
                          </button>
                        </span>
                    </div>
                    <span class="help-block text-red" v-show="validator.errors.has('customer')">
                    {{ validator.errors.first('customer') }}
                </span>
                </div>
                <div class="form-group" v-bind:class="{'has-error': validator.errors.has('question')}">
                    <label for="question">Question</label>
                    <textarea id="question" name="question" class="form-control" v-model="question.question" rows="5" placeholder="Enter Question"></textarea>
                    <span class="help-block text-red" v-show="validator.errors.has('question')">
                    {{ validator.errors.first('question') }}
                </span>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_need_call" id="is_need_call" value="1" v-model="question.is_need_call" v-bind:disabled="question.customer === '' || question.customer === null"/>
                        Need Call ?
                    </label>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" @click="validateQuestion()">
                        Update Question
                    </button>
                </div>
            </div>
        </div>

        <!-- Modal Add Customer -->
        <div class="modal fade" id="modal_add_customer" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clearModalCustomerState()"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-primary" id="myModalLabel">Add Customer</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert" v-show="alertCustomer">
                            <strong>Success <i class="fa fa-check"></i> </strong> A new customer has been added, now you can close the modal
                        </div>
                        <div style="margin-top: -3px;">
                            <div class="row form-margin-bottom">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="name" class="control-label">
                                        Name <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': validator.errors.has('name')}">
                                    <input type="text"
                                           name="name"
                                           id="name"
                                           class="form-control"
                                           placeholder="Enter customer's name"
                                           v-validate="'required'"
                                           v-model="customer.name">
                                    <span class="help-block text-red" v-show="validator.errors.has('name')">
                                        {{ validator.errors.first('name') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-margin-bottom">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="gender" class="control-label">
                                        Gender <span class="text-danger">*</span>
                                    </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="gender_male" value="1" v-model="customer.gender"> Male
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="gender" id="gender_female" value="0" v-model="customer.gender"> Female
                                    </label>

                                    <span class="help-block text-red" v-show="validator.errors.has('gender')">
                                        {{ validator.errors.first('gender') }}
                                    </span>
                                </div>
                            </div>

                            <div class="row form-margin-bottom">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label for="phone" class="control-label">
                                            Phone <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-8" v-bind:class="{'has-error': validator.errors.has('phone')}">
                                        <input name="phone"
                                               id="phone"
                                               type="text"
                                               class="form-control"
                                               placeholder="Enter your phone address"
                                               v-model="customer.phone">
                                        <span class="help-block text-red" v-show="validator.errors.has('phone')">
                                            {{ validator.errors.first('phone') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-margin-bottom">
                                <div class="form-group">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <label for="birthdate" class="control-label">
                                            Birthdate <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                    <div class="col-lg-5 col-md-5 col-sm-5 col-xs-8" v-bind:class="{'has-error': validator.errors.has('birthdate')}">
                                        <input type="date"
                                               name="birthdate"
                                               class="form-control"
                                               placeholder="Click here"
                                               v-model="customer.birthdate">
                                        <span class="help-block text-red" v-show="validator.errors.has('birthdate')">
                                            {{ validator.errors.first('birthdate') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-margin-bottom">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                    <label for="email" class="control-label">
                                        Email
                                    </label>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': validator.errors.has('email')}">
                                    <input type="email"
                                           name="email"
                                           id="email"
                                           class="form-control"
                                           placeholder="Enter customer's email"
                                           v-model="customer.email">
                                    <span class="help-block text-red" v-show="validator.errors.has('email')">
                                        {{ validator.errors.first('email') }}
                                    </span>
                                </div>
                            </div>

                            <div class="form-group form-margin-bottom">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address" placeholder="Enter customer's address" rows="2" v-model="customer.address"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" name="nation" id="nation" placeholder="Nation" v-model="customer.nation"/>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                    <input type="text" class="form-control" id="city" name="city" placeholder="City" v-model="customer.city"/>
                                </div>
                            </div>

                            <div class="form-group form-margin-bottom">
                                <label for="memo">Memo</label>
                                <textarea id="memo" name="memo" class="form-control" placeholder="Add memo if needed" rows="2" v-model="customer.memo"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearModalCustomerState()">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateCustomer()">Add Customer</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    import { Validator } from 'vee-validate';

    Vue.use(VeeValidate, {
        dictionary: {
            en: {
                custom: {
                    customer: {
                        required: 'Please select customer'
                    },
                    question: {
                        required: "Please enter customer's question"
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
        name: "edit-question",
        props: ['question_id', 'user', 'tenant_id'],
        data() {
            return {
                question: {
                    systemId: '',
                    question: '',
                    customerId: '',
                    is_need_call: ''
                },
                validator: '',
                selectCustomer: [],
                customer: {
                    name: '',
                    gender: '',
                    email: '',
                    phone: '',
                    birthdate: '',
                    address: '',
                    nation: '',
                    city: '',
                    memo: ''
                },
                alertCustomer: false,
                alertSuccess: false,
            }
        },
        created() {
            this.generateSelectCustomer();
            this.getQuestion();
            this.validator = new Validator({
                customer: 'required',
                question: 'required',
                name: 'required',
                gender: 'required',
                phone: 'required|numeric|min:10',
                birthdate: 'required',
                email: 'email'
            });
        },
        methods: {
            getQuestion: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/question/' + this.question_id + '/get-question';
                axios.get(url).then(response => {
                    console.log(response.data);
                    vm.question.systemId = response.data.data.systemId;
                    vm.question.question = response.data.data.question;
                    vm.question.customerId = response.data.data.customer.systemId;
                    vm.question.is_need_call = response.data.data.is_need_call;
                }).catch(error => {
                    console.log(error);
                });
            },
            generateSelectCustomer: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/' + this.tenant_id + '/generate-select-customer';
                axios.get(url).then(response => {
                    vm.selectCustomer = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            validateQuestion: function() {
                let vm = this;
                vm.validator.validateAll({
                    customer: vm.question.customerId,
                    question: vm.question.question
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/question/update-question';
                        axios.post(url, {
                            question: vm.question,
                            user: vm.user
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.alertSuccess = true;
                                vm.clearState();
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            validateCustomer: function () {
                let vm = this;

                vm.validator.validateAll({
                    name: vm.customer.name,
                    gender: vm.customer.gender,
                    phone: vm.customer.phone,
                    birthdate: vm.customer.birthdate,
                    email: vm.customer.email
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/add-customer/';
                        axios.post(url, {
                            customer: vm.customer,
                            tenantId: vm.tenant_id
                        }).then(response => {
                            console.log(response.data);
                            vm.generateSelectCustomer();
                            vm.question.customerId = response.data.systemId;
                            vm.alertCustomer = true;
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            clearState: function () {
                let vm = this;
                vm.question.customer = '';
                vm.question.content = '';
                vm.alertSuccess = true;
            },
            clearModalCustomerState: function () {
                let vm = this;
                vm.alertCustomer = false;
                vm.customer.name = '';
                vm.customer.gender = '';
                vm.customer.phone = '';
                vm.customer.birthdate = '';
                vm.customer.email = '';
                vm.customer.addres = '';
                vm.customer.city = '';
                vm.customer.nation = '';
                vm.customer.memo = '';
                vm.validator.errors.clear();
            }
        }
    }
</script>

<style scoped>

</style>