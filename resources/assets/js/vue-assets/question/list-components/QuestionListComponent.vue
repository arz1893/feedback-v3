<template>
    <div>
        <table class="table table-bordered">
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
                            {{ question.customer }}
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
                        <a role="button" class="btn btn-warning">
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
                question: []
            }
        },
        created() {
            this.getAllQuestion();
        },
        methods: {
            getAllQuestion: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/question/" + this.tenant_id + '/get-all-question';

                axios.get(url).then(response => {
                    vm.questions = response.data.data;
                    console.log(vm.questions);
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>