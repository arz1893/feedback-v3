<template>
    <div>
        <div class="media">
            <div class="media-left">
                <a href="#">
                    <img v-bind:src="service.img" class="media-object" width="80" height="65">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading" style="display: inline">
                    {{ service.name }}
                </h4>

                <span v-for="tag in service.serviceTags" class="label" v-bind:style="{ background: tag.bgColor }">
                    {{ tag.name }}
                </span> <br>

                <button class="btn btn-primary" data-toggle="modal" data-target="#modal_faq_service" style="margin-top: 0.8%;" @click="addTypeSubmit('add', 'Add FAQ')">
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

            <div class="col-lg-12" v-show="faqServices.length === 0">
                <div class="well">
                    This service dont have any FAQ yet
                </div>
            </div>

            <div class="col-lg-6">
                <div class="box box-primary box-solid" v-for="faq in faqServices">
                    <div class="box-header with-border">
                        <h3 class="box-title">{{ faq.question }}</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal_faq_service" @click="editFaqService(faq)"><i class="fa fa-pencil-square"></i></button>
                            <button type="button" class="btn btn-box-tool" data-toggle="modal" data-target="#modal_delete_faq_service" @click="setDeleteTarget(faq)"><i class="fa fa-trash-o"></i></button>
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
        <div class="modal fade" id="modal_faq_service" tabindex="-1" role="dialog" aria-labelledby="faqServiceLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-primary" id="faqServiceLabel">{{ title }}</h4>
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
                            <input id="question" name="question" type="text" class="form-control" v-model="faqService.question">
                            <span class="help-block text-red" v-show="validator.errors.has('question')">{{ validator.errors.first('question') }}</span>
                        </div>
                        <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('answer') }">
                            <label for="answer">Answer</label>
                            <textarea id="answer" name="answer" class="form-control" v-model="faqService.answer" rows="6"></textarea>
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
        <div class="modal fade" id="modal_delete_faq_service" tabindex="-1" role="dialog" aria-labelledby="deleteFaqLabel">
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
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteFaqService()">Delete</button>
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
        name: "faq-service",
        props: ['service_id', 'user'],
        data() {
            return {
                faqServices: [],
                service: [],
                faqService: {
                    systemId: '',
                    question: '',
                    answer: ''
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
            this.getService();
            this.getFaqServices();
            this.validator = new Validator({
                question: 'required',
                answer: 'required'
            });
        },
        watch: {
            'faqService.question': function () {
                if(this.showAlert === false) {
                    this.validator.validate('question', this.faqService.question);
                }
            },
            'faqService.answer': function() {
                if(this.showAlert === false) {
                    this.validator.validate('answer', this.faqService.answer);
                }
            }
        },
        methods: {
            getFaqServices: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_service/' + vm.service_id + '/get-faq-services';
                vm.loadStatus = 'Loading...';

                function getFaqs() {
                    axios.get(url).then(response => {
                        console.log(response);
                        vm.faqServices = response.data.data;
                        vm.loadStatus = '';
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(getFaqs, 1000);
                debounceFunction();
            },

            editFaqService: function(currentFaqService) {
                this.type = 'update';
                this.title = 'Update FAQ';
                this.faqService.systemId = currentFaqService.systemId;
                this.faqService.question = currentFaqService.question;
                this.faqService.answer = currentFaqService.answer;
            },

            setDeleteTarget: function(currentFaqService) {
                this.faqService.systemId = currentFaqService.systemId;
                this.faqService.question = currentFaqService.question;
                this.faqService.answer = currentFaqService.answer;
            },

            deleteFaqService: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_service/delete-faq-service';
                axios.post(url, {
                    faqId: vm.faqService.systemId
                }).then(response => {
                    if(response.data.message === 'success') {
                        vm.clearState();
                        vm.getFaqServices();
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

            getService: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + vm.service_id + '/get-service';

                axios.get(url).then(response => {
                    console.log(response.data);
                    vm.service = response.data.data;
                }).then(error => {
                    console.log(error);
                });
            },

            validateFaqSubmit: function () {
                let vm = this;
                vm.validator.validateAll({
                    question: vm.faqService.question,
                    answer: vm.faqService.answer
                }).then(result => {
                    if(result) {
                        if(vm.type === 'add') {
                            vm.showLoadingState = true;
                            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_service/add-faq-service';
                            function saveFaq() {
                                axios.post(url, {
                                    faqService: vm.faqService,
                                    serviceId: vm.service_id,
                                    syscreator: vm.user
                                }).then(response => {
                                    if(response.data.message === 'success') {
                                        vm.clearState();
                                        vm.alertText = 'FAQ has been added, now you can close this dialog';
                                        vm.showAlert = true;
                                        vm.showLoadingState = false;
                                        vm.getFaqServices();
                                    }
                                }).catch(error => {
                                    console.log(error);
                                });
                            }
                            let debounceFunction = _.debounce(saveFaq, 1000);
                            debounceFunction();
                        } else if(vm.type === 'update') {
                            vm.showLoadingState = true;
                            const url = window.location.protocol + "//" + window.location.host + "/" + 'api/faq_service/update-faq-service';
                            function updateFaq() {
                                axios.post(url, {
                                    faqService: vm.faqService,
                                    syscreator: vm.user
                                }).then(response => {
                                    if(response.data.message === 'success') {
                                        vm.clearState();
                                        vm.alertText = 'FAQ has been updated, now you can close this dialog';
                                        vm.showAlert = true;
                                        vm.showLoadingState = false;
                                        vm.getFaqServices();
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
            },

            clearState: function() {
                this.faqService.systemId = '';
                this.faqService.question = '';
                this.faqService.answer = '';
                this.showAlert = false;
                this.validator.errors.clear();
            }
        }
    }
</script>

<style scoped>

</style>