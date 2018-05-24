<template>
    <div>
        <span class="text-red" v-show="productCategories.length === 0">Sorry you haven't add some category to this product, please add it first on master data</span>

        <div v-if="productCategories.length > 0">

            <button class="btn btn-link" v-show="showNavigator" @click="getParentNodes()">
                <i class="fa fa-arrow-circle-up"></i> Up one level
            </button>

            <a role="button" class="btn btn-link" v-show="showBack" @click="goBack()">
                <i class="fa fa-arrow-circle-left"></i> Back
            </a>

            <div class="alert alert-success" role="alert" id="alert_success" v-show="showAlert" @click="showAlert = false">
                <button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong>Info!</strong> Feedback has been added, please look at <a role="button" class="alert-link">feedback product list</a> to see all added feedback from customers
            </div>

            <div v-show="loadingState">
                <i class="fa fa-refresh fa-spin fa-fw"></i>
                Loading...
            </div>

            <div v-show="showForm === false && loadingState === false">
                <button v-for="productCategory in productCategories" class="btn btn-lg btn-info btn3d"
                        :node_id="productCategory.id"
                        :data-product_id="productCategory.productId"
                        :data-name="productCategory.name" @click="productCategoryAction(productCategory)">
                    <i class="ion ion-navigate" aria-hidden="true"></i> {{ productCategory.name }}
                    <span class="badge bg-teal" v-if="productCategory.childs > 0">{{ productCategory.childs }}</span>
                </button>
            </div>
        </div> <br>

        <div class="row">
            <div class="col-lg-6" v-show="showForm">
                <transition name="fadeDown">
                    <div class="panel panel-danger" id="panel_product">
                        <div class="panel-heading">
                            <h4>Add Feedback to : {{ productCategory.name }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="">
                                <label for="customerId">Customer</label>
                                <div class="input-group input-group-md">
                                    <multiselect id="customerId"
                                                 name="customerId"
                                                 v-model="feedbackProduct.customer"
                                                 :options="selectCustomer"
                                                 placeholder="Anonymous"
                                                 label="name"
                                                 track-by="name">
                                    </multiselect>
                                    <span class="input-group-btn">
                                      <button type="button" class="btn btn-link" id="btn_add_customer" data-toggle="modal" data-target="#modal_add_customer">
                                          <i class="fa fa-plus-circle fa-2x"></i>
                                      </button>
                                    </span>
                                </div>
                            </div>

                            <div class="error">
                                <label for="customer_rating" :class="{ 'text-red': validator.errors.has('customer_rating') }">Rating</label>

                                <input type="radio" name="customer_rating" id="radio_dissatisfied" class="invisible" value="1" v-model="feedbackProduct.rating" v-validate="'required|in:1,2,3'"/>
                                <input type="radio" name="customer_rating" id="radio_neutral" class="invisible" value="2" v-model="feedbackProduct.rating"/>
                                <input type="radio" name="customer_rating" id="radio_satisfied" class="invisible" value="3" v-model="feedbackProduct.rating"/>
                                <br>

                                <a role="button">
                                    <i id="dissatisfied"
                                       class="smiley_rating material-icons text-red"
                                       data-value="1"
                                       @click="changeRating($event)"
                                       style="font-size: 3.5em;">
                                        sentiment_dissatisfied
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
                                        sentiment_satisfied
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
                                <label for="attachment">Attach a file</label>
                                <input type="file" name="attachment" id="attachment" class="form-control-file" accept="image/*" v-on:change="previewImage($event)"/>
                            </div>

                            <div class="form-group" v-if="showAttachment" style="width: 180px;">
                                <span class="mailbox-attachment-icon has-img"><img src="" id="preview"></span>

                                <div class="mailbox-attachment-info">
                                    <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                                        <i class="fa fa-close"></i>
                                    </a>
                                    <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> attachment</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="is_need_call" id="is_need_call" value="1" v-model="feedbackProduct.need_call" v-bind:disabled="feedbackProduct.customer === '' || feedbackProduct.customer === null"/>
                                            Need Call ?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="is_urgent" id="is_urgent" value="1" v-model="feedbackProduct.is_urgent"/>
                                            Is Urgent ?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="button" class="btn btn-danger" @click="validateFeedbackSubmit()">
                                        Add Feedback
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
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
        name: "feedback-show",
        props: ['product_id', 'tenant_id', 'syscreator'],
        data() {
            return {
                productCategories: [],
                productCategory: [],
                previousNode: [],
                selectCustomer: [],
                selectedCustomer: [],
                showForm: false,
                showAttachment: false,
                showNavigator: false,
                showBack: false,
                loadingState: false,
                showAlert: false,
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
                validator: ''
            }
        },
        created() {
            this.getRootNodes();
            this.getCustomerList();

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
            'feedbackProduct.rating': function () {
                this.validator.validate('customer_rating', this.feedbackProduct.rating);
            },
            'feedbackProduct.feedback': function () {
                this.validator.validate('feedback', this.feedbackProduct.feedback);
            },
            'customer.name': function () {
                if(this.alertCustomer === false) {
                    this.validator.validate('name', this.customer.name);
                }
            },
            'customer.gender': function () {
                if(this.alertCustomer === false) {
                    this.validator.validate('gender', this.customer.gender);
                }
            },
            'customer.birthdate': function () {
                if(this.alertCustomer === false) {
                    this.validator.validate('birthdate', this.customer.birthdate);
                }
            },
            'customer.phone': function () {
                if(this.alertCustomer === false) {
                    this.validator.validate('phone', this.customer.phone);
                }
            },
            'customer.email': function () {
                if(this.alertCustomer === false) {
                    this.validator.validate('email', this.customer.email);
                }
            },
        },
        methods: {
            getRootNodes: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + this.product_id + '/get-root-nodes';
                vm.loadingState = true;
                function sendRequest() {
                    axios.get(url).then(response => {
                        vm.productCategories = response.data.data;
                        vm.showForm = false;
                        vm.loadingState = false;
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(sendRequest, 1000);
                debounceFunction();
            },
            getCustomerList: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/' + this.tenant_id + '/generate-select-customer';
                axios.get(url).then(response => {
                    this.selectCustomer = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            productCategoryAction: function (selectedCategory) {
                let vm = this;
                if(selectedCategory.childs === 0) {
                    vm.productCategory = selectedCategory;
                    vm.showForm = true;
                    vm.showBack = true;
                    vm.showNavigator = false;
                } else {
                    vm.previousNode = selectedCategory;
                    console.log(vm.previousNode);
                    vm.showNavigator = true;
                    vm.getChildNodes(selectedCategory.id);
                }
            },
            getParentNodes: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + vm.previousNode.id + '/get-parent-nodes';

                if(vm.previousNode.parentId === null) {
                    vm.showNavigator = false;
                    vm.getRootNodes();
                } else {
                    vm.loadingState = true;
                    function sendRequest() {
                        axios.get(url).then(response => {
                            console.log(response.data);
                            vm.productCategories = [];
                            for(let index in response.data.parentNodes) {
                                vm.productCategories.push(response.data.parentNodes[index]);
                            }
                            vm.previousNode = response.data.previousNode;
                            if(vm.previousNode === null) {
                                vm.showNavigator = false;
                            }
                            vm.loadingState = false;
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                    let debounceFunction = _.debounce(sendRequest, 1000);
                    debounceFunction();
                }
            },
            getChildNodes: function (parent_id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + parent_id + '/get-child-nodes';
                vm.loadingState = true;
                function sendRequest() {
                    axios.get(url).then(response => {
                        vm.productCategories = response.data.data;
                    }).catch(error => {
                        console.log(error);
                    });
                    vm.loadingState = false;
                }
                let debounceFunction = _.debounce(sendRequest, 1000);
                debounceFunction();
            },
            goBack: function () {
                let vm = this;
                vm.showForm = false;
                vm.showBack = false;
                console.log(vm.previousNode);
                console.log(vm.previousNode.length);
                if(vm.previousNode.parentId !== null && vm.previousNode.length === undefined) {
                    vm.showNavigator = true;
                }
                vm.feedbackProduct.customer = '';
                vm.feedbackProduct.rating = '';
                vm.feedbackProduct.feedback = '';
                vm.feedbackProduct.fileName = '';
                vm.feedbackProduct.image = '';
                vm.feedbackProduct.need_call = 0;
                vm.feedbackProduct.is_urgent = 0;
                $('#dissatisfied').removeClass('is-selected');
                $('#neutral').removeClass('is-selected');
                $('#satisfied').removeClass('is-selected');
                vm.$validator.reset();
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

            clearAttachment: function(event) {
                $('#preview').removeAttr('src');
                $('#attachment').val("");
                $('#image_cover').val("");
                this.feedbackProduct.image = '';
                this.showAttachment = false;
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
            validateFeedbackSubmit: function () {
                let vm = this;
                vm.validator.validateAll({
                    customer_rating: vm.feedbackProduct.rating,
                    feedback: vm.feedbackProduct.feedback
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/feedback_product/' + vm.tenant_id + '/add-feedback-product';
                        axios.post(url, {
                            feedbackProduct: vm.feedbackProduct,
                            productId: vm.product_id,
                            productCategoryId: vm.productCategory.id,
                            creator: vm.syscreator
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.showAlert = true;
                                vm.goBack();
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {

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