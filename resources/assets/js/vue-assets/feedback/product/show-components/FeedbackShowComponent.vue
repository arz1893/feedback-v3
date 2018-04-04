<template>
    <div>
        <span class="text-red" v-show="productCategories.length === 0">Sorry you haven't add some category to this product, please add it first on master data</span>

        <div v-if="productCategories.length > 0">
            <div v-show="showNavigator">
                <a role="button" class="btn btn-link btn-lg" @click="getParentNodes()">
                    <i class="fa fa-arrow-circle-up"></i> Up One Level
                </a> <br>
            </div>

            <div v-show="showBack">
                <a role="button" class="btn btn-link btn-lg" id="btn_show_category_navigator" @click="goBack()">
                    <i class="fa fa-arrow-circle-left"></i> Back
                </a>
            </div>

            <div v-show="showForm === false">
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
                            <h4>Add Feedback to : {{  }}</h4>
                        </div>
                        <div class="panel-body">
                            <div class="">
                                <label for="customerId">Customer</label>
                                <div class="input-group input-group-md">
                                    <multiselect id="customerId"
                                                 name="customerId"
                                                 v-model="customer"
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
                                <label for="customer_rating">Rating</label> <br>
                                <a class="">
                                    <i id="very_bad"
                                       class="smiley_rating material-icons text-red"
                                       style="font-size: 3.5em;"
                                       :value="1">
                                        sentiment_very_dissatisfied
                                    </i>
                                </a>
                                <a class="">
                                    <i id="bad"
                                       class="smiley_rating material-icons text-yellow"
                                       style="font-size: 3.5em;"
                                       :value="2">
                                        sentiment_neutral
                                    </i>
                                </a>
                                <a class="">
                                    <i id="normal"
                                       class="smiley_rating material-icons text-green"
                                       style="font-size: 3.5em;"
                                       :value="3">
                                        sentiment_very_satisfied
                                    </i>
                                </a>
                                <br>
                            </div>

                            <div class="form-group">
                                <label for="customer_complaint">Complaint</label>
                                <textarea class="form-control" name="customer_complaint" id="customer_complaint" placeholder="Please enter customer's complaint" rows="6"></textarea>
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
                                            <input type="checkbox" name="is_need_call" id="is_need_call" value="1"/>
                                            Need Call ?
                                        </label>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="checkbox" name="is_urgent" id="is_urgent" value="1"/>
                                            Is Urgent ?
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-danger">
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

    export default {
        name: "feedback-show",
        props: ['product_id', 'tenant_id'],
        data() {
            return {
                productCategories: [],
                productCategory: {
                    id: '',
                    name: '',
                    parentId: '',
                    lgt: '',
                    rgt: '',
                    productId: '',
                    depth: ''
                },
                selectCustomer: [],
                customer: '',
                showForm: false,
                showAttachment: false,
                showNavigator: false,
                showBack: false
            }
        },
        created() {
            this.getRootNodes();
            this.getCustomerList();
        },
        methods: {
            getRootNodes: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + this.product_id + '/get-root-nodes';
                axios.get(url).then(response => {
                    this.productCategories = response.data.data;
                    this.showForm = false;
                    this.showNavigator = false;
                }).catch(error => {
                    console.log(error);
                });
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
                console.log(selectedCategory);
                let vm = this;
                if(selectedCategory.childs === 0) {
                    vm.productCategory.id = selectedCategory.id;
                    vm.productCategory.name = selectedCategory.name;
                    vm.productCategory.parentId = selectedCategory.parentId;
                    vm.productCategory.lgt = selectedCategory.lgt;
                    vm.productCategory.rgt = selectedCategory.rgt;
                    vm.productCategory.productId = selectedCategory.productId;
                    vm.productCategory.depth = selectedCategory.depth;
                    vm.showForm = true;
                    vm.showBack = true;
                    vm.showNavigator = false;
                } else {
                    vm.getChildNodes(selectedCategory.id);
                }
            },
            getParentNodes: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + vm.productCategory.parentId + '/get-parent-nodes';

                if(vm.productCategory.parentId === null) {
                    vm.getRootNodes();
                } else {
                    axios.get(url).then(response => {
                        console.log(response.data.data);
                        vm.productCategories = response.data.data;
                        vm.showForm = false;
                        vm.showNavigator = false;
                    }).catch(error => {
                        console.log(error);
                    });
                }
            },
            getChildNodes: function (parent_id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product_category/' + parent_id + '/get-child-nodes';
                axios.get(url).then(response => {
                    console.log(response.data.data);
                    vm.productCategories = response.data.data;
                    vm.showNavigator = true;
                }).catch(error => {
                    console.log(error);
                });
            },
            goBack: function () {
                this.showForm = false;
                this.showBack = false;
                this.showNavigator = true;
            }
        }
    }
</script>

<style scoped>

</style>