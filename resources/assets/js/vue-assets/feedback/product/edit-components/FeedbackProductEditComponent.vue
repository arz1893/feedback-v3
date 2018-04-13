<template>
    <div>
        <div class="alert alert-success alert-dismissible" role="alert" v-show="alertSuccess">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="alertSuccess = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success <i class="fa fa-check"></i> </strong> Current feedback has been updated, you can go back to <a v-bind:href="index_url" class="alert-link">feedback product list</a>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="select_customer">Select Customer</label>
                    <div class="input-group input-group-md">
                        <multiselect id="customerId"
                                     name="customerId"
                                     v-model="feedbackProduct.customer"
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
                    <pre class="code">
                        {{ feedbackProduct.customer }}
                    </pre>
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
                <div class="form-group">
                    <label>
                        <input type="checkbox" name="is_need_call" id="is_need_call" value="1" v-model="feedbackProduct.need_call" v-bind:disabled="feedbackProduct.customer === '' || feedbackProduct.customer === null"/>
                        Need Call ?
                    </label> &nbsp;
                    <label>
                        <input type="checkbox" name="is_urgent" id="is_urgent" value="1" v-model="feedbackProduct.is_urgent"/>
                        Is Urgent ?
                    </label>
                </div>
                <div class="form-group">
                    <button role="button" class="btn btn-success" @click="validateFeedbackProduct()"><i class="fa fa-wrench"></i> Update Feedback</button>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group">
                    <label for="attachment">Change / Add attachment</label>
                    <input type="file" name="attachment" id="attachment" class="form-control-file" accept="image/*" v-on:change="previewImage($event)"/>
                    <p class="help-block text-red" v-if="feedbackProduct.image === '' || feedbackProduct.image === null">You don't have any attachment on this feedback</p>
                    <p class="help-block text-red" v-else>Click file to change feedback attachment</p>
                </div>

                <div class="form-group" v-show="showAttachment" style="width: 180px;">
                    <span class="mailbox-attachment-icon has-img">
                        <img src="" id="preview" v-bind:src="feedbackProduct.image">
                    </span>
                    <div class="mailbox-attachment-info">
                        <a @click="clearAttachment()" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                            <i class="fa fa-close"></i>
                        </a>
                        <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> attachment</a>
                    </div>
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
                selectedCustomer: '',
                showAttachment: false,
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
                alertSuccess: false,
                alertCustomer: false,
                validator: '',
                index_url: window.location.protocol + "//" + window.location.host + "/" + 'feedback_product_list/'
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
        watch: {
            'feedbackProduct.customer': function () {
                if(this.feedbackProduct.customer === null || this.feedbackProduct.customer === '') {
                    this.feedbackProduct.need_call = 0;
                }
            },
            'feedbackProduct.image': function () {
                this.showAttachment = this.feedbackProduct.image !== '';
            },
            'feedbackProduct.rating': function () {
                this.validator.validate('customer_rating', this.feedbackProduct.rating);
            },
            'feedbackProduct.feedback': function () {
                this.validator.validate('feedback', this.feedbackProduct.feedback);
            },
            'customer.name': function () {
                this.validator.validate('name', this.customer.name);
            },
            'customer.gender': function () {
                this.validator.validate('gender', this.customer.gender);
            },
            'customer.birthdate': function () {
                this.validator.validate('birthdate', this.customer.birthdate);
            },
            'customer.phone': function () {
                this.validator.validate('phone', this.customer.phone);
            },
            'customer.email': function () {
                this.validator.validate('email', this.customer.email);
            },
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
                    vm.feedbackProduct.image = (response.data.data.attachment === null) ? '':response.data.data.attachment;
                    vm.feedbackProduct.need_call = response.data.data.is_need_call;
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
                        console.log(response.data);
                        vm.feedbackProduct.customer = {systemId: response.data[0].systemId, name: response.data[0].name};
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
            previewImage: function (event) {
                let files = event.target.files || event.dataTransfer.files;
                this.createImage(files[0]);

                var uploadedImage = event.target;
                if(uploadedImage.files && uploadedImage.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(uploadedImage.files[0]);
                }
                this.showAttachment = true;
            },
            createImage: function(file) {
                let reader = new FileReader();
                let vm = this;
                vm.feedbackProduct.fileName = file.name;
                reader.onload = (e) => {
                    vm.feedbackProduct.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            clearAttachment: function() {
                $('#preview').removeAttr('src');
                $('#attachment').val("");
                this.feedbackProduct.image = '';
                this.feedbackProduct.fileName = '';
                this.showAttachment = false;

                console.log(this.feedbackProduct.image);
            },
            validateFeedbackProduct: function () {
                let vm = this;
                vm.validator.validateAll({
                    customer_rating: vm.feedbackProduct.rating,
                    feedback: vm.feedbackProduct.feedback
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/update-feedback-product';
                        axios.post(url, {
                            feedbackProduct: vm.feedbackProduct,
                            updater: vm.syscreator
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.alertSuccess = true;
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
                            vm.getCustomerList();
                            vm.feedbackProduct.customer = {systemId: response.data.systemId, name: response.data.name};
                            vm.alertCustomer = true;
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
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