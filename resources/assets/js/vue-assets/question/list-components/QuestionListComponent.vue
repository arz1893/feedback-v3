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
                        <a role="button">
                            {{ question.created_at }}
                        </a>
                    </td>
                    <td>
                        <a role="button">
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
                        <button class="btn btn-danger">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: "question-list",
        props: ['tenant_id'],
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
                selectCustomer: []
            }
        },
        created() {
            this.getAllQuestion();
            this.generateSelectCustomer();
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
        }
    }
</script>

<style scoped>

</style>