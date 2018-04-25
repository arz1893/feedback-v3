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

                <button class="btn btn-primary" data-toggle="modal" data-target="#modal_add_faq_product" style="margin-top: 0.8%;">
                    Add FAQ
                </button>

                <button class="btn btn-default" data-toggle="collapse" data-target="#collapse_description" aria-expanded="false" aria-controls="collapse_description" style="margin-top: 0.8%;">
                    Show Description
                </button>
            </div>
        </div>
        <br>
        <div class="collapse" id="collapse_description">
            <div class="well">
                {{ product.description }}
            </div>
        </div>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <div class="panel panel-default" v-for="(faq, index) in faqProducts">
                <div class="panel-heading" role="tab" v-bind:id="'heading'+index">
                    <h4 class="panel-title">
                        <a role="button" data-toggle="collapse" data-parent="#accordion" v-bind:href="'#collapse'+index" aria-expanded="true" v-bind:aria-controls="'#collapse'+index">
                            {{ faq.question }}
                        </a>
                    </h4>
                </div>
                <div v-bind:id="'collapse'+index" class="panel-collapse collapse in" role="tabpanel" v-bind:aria-labelledby="'heading'+index">
                    <div class="panel-body">
                        {{ faq.answer }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_add_faq_product" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-primary" id="myModalLabel">Add FAQ</h4>
                    </div>
                    <div class="modal-body">
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
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="validateFaqSubmit()">Add FAQ</button>
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
        props: ['product_id', 'syscreator'],
        data() {
            return {
                faqProducts: [],
                product: [],
                faqProduct: {
                    question: '',
                    answer: ''
                },
                searchStatus: '',
                validator: ''
            }
        },
        created() {
            this.getProduct();
            this.getFaqProducts();
            this.validator = new Validator({
                question: 'required',
                answer: 'required'
            });
        },
        methods: {
            getFaqProducts: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/' + vm.product_id + '/get-faq-products';

                axios.get(url).then(response => {
                    console.log(response);
                    vm.faqProducts = response.data.data;
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
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_product/add-faq-product';
                        function saveFaq() {
                            axios.post(url, {
                                faqProduct: vm.faqProduct,
                                syscreator: vm.syscreator
                            }).then(response => {
                                if(response.data.message === 'success') {

                                }
                            }).catch(error => {
                                console.log(error);
                            });
                        }
                        let debounceFunction = _.debounce(saveFaq, 1000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                })
            }
        }
    }
</script>

<style scoped>

</style>