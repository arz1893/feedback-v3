<template>
    <div>
        <div v-show="questions.length === 0">
            <div class="well text-center">
                There is no question added yet
            </div>
        </div>

        <table class="table table-bordered" v-if="questions.length > 0">
            <thead>
                <tr>
                    <th>Created</th>
                    <th>Customer</th>
                    <th>Question</th>
                    <th>Answered?</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="question in questions">
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modal_show_question" @click="getQuestion(question)">
                            {{ question.created_at }}
                        </a>
                    </td>
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modal_show_question" @click="getQuestion(question)">
                            {{ question.customer.name }}
                        </a>
                    </td>
                    <td>
                        {{ question.question }}
                    </td>
                    <td>
                        <span v-if="question.is_answered === 1" class="text-green">
                            Yes
                        </span>
                        <span v-else class="text-red">
                            No
                        </span>
                    </td>
                    <td>
                        <a role="button" class="btn btn-warning" v-bind:href="question.show_edit_url">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_question" @click="getQuestion(question)">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="modal_show_question" tabindex="-1" role="dialog" aria-labelledby="modalShowLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-green" id="modalShowLabel">Question</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success" role="alert" v-show="alertQuestion">
                            <button type="button" class="close" @click="alertQuestion = false"><span aria-hidden="true">&times;</span></button>
                            <strong>info!</strong> Question has been answered, thank you
                        </div>

                        <h4 class="text-center text-navy">Q: {{ question.question }}</h4>
                        <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('answer') }">
                            <label for="answer">Answer :</label>
                            <textarea class="form-control" id="answer" name="answer" placeholder="What is you answer ?" v-model="question.answer" rows="4"></textarea>
                            <span class="help-block text-red" v-show="validator.errors.has('answer')">
                                {{ validator.errors.first('answer') }}
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearState()">Close</button>
                        <button type="button" class="btn btn-primary" @click="answerQuestion()">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_delete_question" tabindex="-1" role="dialog" aria-labelledby="modalDeleteLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-red" id="modalDeleteLabel">Warning!</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this question ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteQuestion()">Delete</button>
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
                    answer: {
                        required: 'Please enter the answer'
                    }
                }
            }
        }
    });

    export default {
        name: "question-list",
        props: ['tenant_id', 'user'],
        data() {
            return {
                questions: [],
                question: {
                    systemId: '',
                    customerId: '',
                    question: '',
                    answer: '',
                    is_need_call: ''
                },
                selectCustomer: [],
                alertQuestion: false,
                validator: ''
            }
        },
        created() {
            this.getAllQuestion();
            this.generateSelectCustomer();
            this.validator = new Validator({
                answer: 'required'
            });
        },
        watch: {
            'question.answer': function () {
                if(this.alertQuestion === false) {
                    this.validator.validate('answer', 'question.answer');
                }
            }
        },
        methods: {
            getAllQuestion: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/question/" + this.tenant_id + '/get-all-question';

                axios.get(url).then(response => {
                    console.log(response.data);
                    vm.questions = response.data.data;
                    console.log(vm.questions);
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
            getQuestion: function (selectedQuestion) {
                this.question.systemId = selectedQuestion.systemId;
                this.question.customerId = selectedQuestion.customerId;
                this.question.question = selectedQuestion.question;
                this.question.answer = selectedQuestion.answer;
            },
            answerQuestion: function () {
                let vm = this;
                vm.validator.validateAll({
                    answer: vm.question.answer
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/question/answer-question';
                        axios.post(url, {
                            question_id: vm.question.systemId,
                            answer: vm.question.answer
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.getAllQuestion();
                                vm.alertQuestion = true;
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            deleteQuestion: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/question/delete-question';
                axios.post(url, {
                    question_id: vm.question.systemId
                }).then(response => {
                    if(response.data.message === 'success') {
                        vm.getAllQuestion();
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            clearState: function () {
                this.question.systemId = '';
                this.question.customerId = '';
                this.question.question = '';
                this.question.answer = '';
                this.question.is_need_call = '';
                this.alertQuestion = false;
                this.validator.errors.clear();
            }
        },
    }
</script>

<style scoped>

</style>