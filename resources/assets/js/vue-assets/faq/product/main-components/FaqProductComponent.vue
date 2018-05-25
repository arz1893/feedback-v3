<template>
    <div>
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <img v-bind:src="product.img" class="media-object" width="80" height="65">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading" style="display: inline">
                    {{ product.name }}
                </h4>

                <span v-for="tag in product.productTags" class="label" v-bind:style="{ background: tag.bgColor }">
                    {{ tag.name }}
                </span> <br>

                <button v-if="user_rights.create === 1" class="btn btn-primary" data-toggle="modal" data-target="#modal_faq_product" style="margin-top: 0.8%;" @click="addTypeSubmit('add', 'Add FAQ')">
                    <i class="fa fa-plus"></i> Add FAQ
                </button>
            </div>
        </div>
        <br>

        <div class="text-center" v-show="loadStatus !== ''">
            <i class="fa fa-spinner fa-pulse fa-fw"></i>
            {{ loadStatus }}
        </div>

        <div class="alert alert-success" role="alert" v-show="showAlert">
            <strong>Info!</strong> {{ alertText }}
        </div>

        <div class="row">

            <div class="col-lg-12" v-show="faqProducts.length === 0">
                <div class="well">
                    This product dont have any FAQ yet
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-primary box-solid" v-for="faq in faqProducts">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ faq.question }}</h3>

                        <div class="box-tools pull-right">
                            <button v-if="user_rights.edit === 1" type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal_faq_product" @click="editFaqProduct(faq)"><i class="fa fa-pencil-square"></i></button>
                            <button v-if="user_rights.delete === 1" type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal_delete_faq_product" @click="setDeleteTarget(faq)"><i class="fa fa-trash-o"></i></button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        {{ faq.answer }}
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_faq_product" tabindex="-1" role="dialog" aria-labelledby="faqProductLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-primary" id="faqProductLabel">{{ title }}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert" id="alert_success" v-show="showAlert">
                            <button type="button" class="close" @click="showAlert = false"><span aria-hidden="true">&times;</span></button>
                            <strong>Info!</strong> {{ alertText }}
                        </div>

                        <div class="text-center" v-show="showLoadingState">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i>
                            Saving data, please wait...
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('question') }">
                            <label for="question">Question</label>
                            <input id="question" name="question" type="text" class="form-control" v-model="faqProduct.question">
                            <span class="help-block text-red" v-show="validator.errors.has('question')">{{ validator.errors.first('question') }}</span>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('answer') }">
                            <label for="answer">Answer</label>
                            <textarea id="answer" name="answer" class="form-control" v-model="faqProduct.answer" rows="6"></textarea>
                            <span class="help-block text-red" v-show="validator.errors.has('answer')">{{ validator.errors.first('answer') }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearState()">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateFaqSubmit()">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_delete_faq_product" tabindex="-1" role="dialog" aria-labelledby="deleteFaqLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-red" id="deleteFaqLabel">Warning!</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this faq ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteFaqProduct()">Delete</button>
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
                    question: {
                        required: "Please enter the question"
                    },
                    answer: {
                        required: "Please enter the answer"
                    }
                }
            }
        }
    });

    export default {
        name: "add-faq-product",
        props: ['product_id', 'user'],
        data() {
            return {
                faqProducts: [],
                product: [],
                faqProduct: {
                    systemId: '',
                    question: '',
                    answer: ''
                },
                user_rights: {
                    create: '',
                    edit: '',
                    delete: ''
                },
                type: '',
                searchStatus: '',
                validator: '',
                showAlert: false,
                alertText: '',
                showLoadingState: false,
                title: '',
                loadStatus: ''
            }
        },
        created() {
            this.getProduct();
            this.getFaqProducts();
            this.getUserRights();
            this.validator = new Validator({
                question: 'required',
                answer: 'required'
            });
        },
        watch: {
            'faqProduct.question': function () {
                if(this.showAlert === false) {
                    this.validator.validate('question', this.faqProduct.question);
                }
            },
            'faqProduct.answer': function() {
                if(this.showAlert === false) {
                    this.validator.validate('answer', this.faqProduct.answer);
                }
            }
        },
        methods: {
            getFaqProducts: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/' + vm.product_id + '/get-faq-products';
                vm.loadStatus = 'Loading...';

                function getFaqs() {
                    axios.get(url).then(response => {
                        console.log(response);
                        vm.faqProducts = response.data.data;
                        vm.loadStatus = '';
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(getFaqs, 1000);
                debounceFunction();
            },

            getUserRights: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/user_group/' + vm.user + '/get-faq-crud-rights';

                axios.get(url).then(response => {
                    vm.user_rights.create = response.data.user_rights.create;
                    vm.user_rights.edit = response.data.user_rights.edit;
                    vm.user_rights.delete = response.data.user_rights.delete;
                }).catch(error => {
                    console.log(error);
                });
            },

            editFaqProduct: function(currentFaqProduct) {
                this.type = 'update';
                this.title = 'Update FAQ';
                this.faqProduct.systemId = currentFaqProduct.systemId;
                this.faqProduct.question = currentFaqProduct.question;
                this.faqProduct.answer = currentFaqProduct.answer;
            },

            setDeleteTarget: function(currentFaqProduct) {
                this.faqProduct.systemId = currentFaqProduct.systemId;
                this.faqProduct.question = currentFaqProduct.question;
                this.faqProduct.answer = currentFaqProduct.answer;
            },

            deleteFaqProduct: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/delete-faq-product';
                axios.post(url, {
                    faqId: vm.faqProduct.systemId
                }).then(response => {
                    if(response.data.message === 'success') {
                        vm.clearState();
                        vm.getFaqProducts();
                        vm.showAlert = true;
                        vm.alertText = 'FAQ has been successfully deleted';
                        function showAlert() {
                            vm.showAlert = false;
                            vm.alertText = '';
                        }
                        let debounceFunction = _.debounce(showAlert, 3000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                })
            },

            getProduct: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + vm.product_id + '/get-product';

                axios.get(url).then(response => {
                    console.log(response.data);
                    vm.product = response.data.data;
                }).then(error => {
                    console.log(error);
                });
            },
            
            validateFaqSubmit: function () {
                let vm = this;
                vm.validator.validateAll({
                    question: vm.faqProduct.question,
                    answer: vm.faqProduct.answer
                }).then(result => {
                    if(result) {
                        if(vm.type === 'add') {
                            vm.showLoadingState = true;
                            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/add-faq-product';
                            function saveFaq() {
                                axios.post(url, {
                                    faqProduct: vm.faqProduct,
                                    productId: vm.product_id,
                                    syscreator: vm.user
                                }).then(response => {
                                    if(response.data.message === 'success') {
                                        vm.clearState();
                                        vm.alertText = 'FAQ has been added, now you can close this dialog';
                                        vm.showAlert = true;
                                        vm.showLoadingState = false;
                                        vm.getFaqProducts();
                                    }
                                }).catch(error => {
                                    console.log(error);
                                });
                            }
                            let debounceFunction = _.debounce(saveFaq, 1000);
                            debounceFunction();
                        } else if(vm.type === 'update') {
                            vm.showLoadingState = true;
                            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/update-faq-product';
                            function updateFaq() {
                                axios.post(url, {
                                    faqProduct: vm.faqProduct,
                                    syscreator: vm.user
                                }).then(response => {
                                    if(response.data.message === 'success') {
                                        vm.clearState();
                                        vm.alertText = 'FAQ has been updated, now you can close this dialog';
                                        vm.showAlert = true;
                                        vm.showLoadingState = false;
                                        vm.getFaqProducts();
                                    }
                                }).catch(error => {
                                    console.log(error);
                                });
                            }
                            let debounceFunction = _.debounce(updateFaq, 1000);
                            debounceFunction();
                        }
                    }
                }).catch(error => {
                    console.log(error);
                })
            },

            addTypeSubmit: function(type, title) {
                this.type = type;
                this.title = title;
                this.clearState();
            },

            clearState: function() {
                this.faqProduct.systemId = '';
                this.faqProduct.question = '';
                this.faqProduct.answer = '';
                this.showAlert = false;
                this.validator.errors.clear();
            }
        }
    }
</script>

<style scoped>

</style>