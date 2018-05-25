<template>
    <div>
        <h3 class="text-center">{{ user_group.name }}</h3>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Master Data CRUD Permissions (Products, Services, Tags)</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="master_data_view" id="master_data_view" v-model="user_group.master_data_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="master_data_create" id="master_data_create" v-model="user_group.master_data_create" :disabled="!user_group.master_data_view"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="master_data_edit" id="master_data_edit" v-model="user_group.master_data_edit" :disabled="!user_group.master_data_view"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="master_data_delete" id="master_data_delete" v-model="user_group.master_data_delete" :disabled="!user_group.master_data_view"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>FAQ CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="faq_view" id="faq_view" v-model="user_group.faq_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="faq_create" id="faq_create" v-model="user_group.faq_create"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="faq_edit" id="faq_edit" v-model="user_group.faq_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="faq_edit" id="faq_delete" v-model="user_group.faq_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Feedback CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_view" id="feedback_view" v-model="user_group.feedback_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_create" id="feedback_create" v-model="user_group.feedback_create"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_edit" id="feedback_edit" v-model="user_group.feedback_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_delete" id="feedback_delete" v-model="user_group.feedback_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Feedback List Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_list_view" id="feedback_list_view" v-model="user_group.feedback_list_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_list_answer" id="feedback_list_answer" v-model="user_group.feedback_list_answer"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_list_edit" id="feedback_list_edit" v-model="user_group.feedback_list_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_list_delete" id="feedback_list_delete" v-model="user_group.feedback_list_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Question CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_view" id="question_view" v-model="user_group.question_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_create" id="question_create" v-model="user_group.question_create"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_edit" id="question_edit" v-model="user_group.question_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_delete" id="question_delete" v-model="user_group.question_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Question List Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_list_view" id="question_list_view" v-model="user_group.question_list_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_list_answer" id="question_list_answer" v-model="user_group.question_list_answer"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_list_edit" id="question_list_edit" v-model="user_group.question_list_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="question_list_delete" id="question_list_delete" v-model="user_group.question_list_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button class="btn btn-success">
                Save Changes
            </button>
            <button class="btn btn-default">
                Cancel
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "user-group-show",
        props: ['usergroup_id'],
        data() {
            return {
                user_group: {
                    name: '',
                    master_data_view: '',
                    master_data_create: '',
                    master_data_edit: '',
                    master_data_delete: '',
                    faq_view: '',
                    faq_create: '',
                    faq_edit: '',
                    faq_delete: '',
                    feedback_view: '',
                    feedback_create: '',
                    feedback_edit: '',
                    feedback_delete: '',
                    feedback_list_view: '',
                    feedback_list_answer: '',
                    feedback_list_edit: '',
                    feedback_list_delete: '',
                    question_view: '',
                    question_create: '',
                    question_edit: '',
                    question_delete: '',
                    question_list_view: '',
                    question_list_answer: '',
                    question_list_edit: '',
                    question_list_delete: '',
                }
            }
        },
        created() {
            this.getRoleRights();
        },
        methods: {
            getRoleRights: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/" + vm.usergroup_id + '/get-role-rights';
                axios.get(url).then(response => {
                    console.log(response.data);
                    vm.user_group.name = response.data.data.name;
                    vm.user_group.master_data_view = response.data.data.master_data_rights.view;
                    vm.user_group.master_data_create = response.data.data.master_data_rights.create;
                    vm.user_group.master_data_edit = response.data.data.master_data_rights.edit;
                    vm.user_group.master_data_delete = response.data.data.master_data_rights.delete;
                    vm.user_group.faq_view = response.data.data.faq_crud_rights.view;
                    vm.user_group.faq_create = response.data.data.faq_crud_rights.create;
                    vm.user_group.faq_edit = response.data.data.faq_crud_rights.edit;
                    vm.user_group.faq_delete = response.data.data.faq_crud_rights.delete;
                    vm.user_group.feedback_view = response.data.data.feedback_crud_rights.view;
                    vm.user_group.feedback_create = response.data.data.feedback_crud_rights.create;
                    vm.user_group.feedback_edit = response.data.data.feedback_crud_rights.edit;
                    vm.user_group.feedback_delete = response.data.data.feedback_crud_rights.delete;
                    vm.user_group.feedback_list_view = response.data.data.feedback_list_crud_rights.view;
                    vm.user_group.feedback_list_answer = response.data.data.feedback_list_crud_rights.answer;
                    vm.user_group.feedback_list_edit = response.data.data.feedback_list_crud_rights.edit;
                    vm.user_group.feedback_list_delete = response.data.data.feedback_list_crud_rights.delete;
                    vm.user_group.question_view = response.data.data.question_crud_rights.view;
                    vm.user_group.question_create = response.data.data.question_crud_rights.create;
                    vm.user_group.question_edit = response.data.data.question_crud_rights.edit;
                    vm.user_group.question_delete = response.data.data.question_crud_rights.delete;
                    vm.user_group.question_list_view = response.data.data.question_list_crud_rights.view;
                    vm.user_group.question_list_answer = response.data.data.question_list_crud_rights.answer;
                    vm.user_group.question_list_edit = response.data.data.question_list_crud_rights.edit;
                    vm.user_group.question_list_delete = response.data.data.question_list_crud_rights.delete;
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>