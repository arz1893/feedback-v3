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
                                <label for="customer_rating" :class="{ 'text-red': errors.has('customer_rating') }">Rating</label>

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
                                <span class="help text-red" v-show="errors.has('customer_rating')">{{ errors.first('customer_rating') }}</span>
                            </div>

                            <div class="form-group" :class="{'has-error': errors.has('feedback')}">
                                <label for="feedback">Complaint</label>
                                <textarea class="form-control" name="feedback" id="feedback" placeholder="Please enter customer's feedback" rows="6" v-model="feedbackProduct.feedback" v-validate="'required'"></textarea>
                                <span class="help text-red" v-show="errors.has('feedback')">{{ errors.first('feedback') }}</span>
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
                                    <button type="button" class="btn btn-danger" @click="validateBeforeSubmit()">
                                        Add Feedback
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </transition>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    Vue.use(VeeValidate, {
        dictionary: {
            en: {
                custom: {
                    customer_rating: {
                        required: "Customer rating is not set"
                    },
                    feedback: {
                        required: "Please enter customer's feedback"
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
                }
            }
        },
        created() {
            this.getRootNodes();
            this.getCustomerList();
        },
        watch: {
            'feedbackProduct.customer': function () {
                if(this.feedbackProduct.customer === null || this.feedbackProduct.customer === '') {
                    this.feedbackProduct.need_call = 0;
                }
            }
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
            validateBeforeSubmit: function () {
                let vm = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
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
                });
            }
        }
    }
</script>

<style scoped>

</style>