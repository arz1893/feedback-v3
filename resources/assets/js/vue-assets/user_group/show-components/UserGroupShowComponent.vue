<template>
    <div>
        <h3 class="text-center">{{ user_group.name }}</h3>

        <div class="alert alert-success alert-dismissible" role="alert" v-if="showAlert">
            <button type="button" class="close" aria-label="Close" @click="showAlert = false"><span aria-hidden="true">&times;</span></button>
            <strong>Info!</strong> Permission has been changed
        </div>

        <div class="text-center" v-if="showLoading">
            <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading...
            <br>
        </div>

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
                    <strong>Feedback Product CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_view" id="feedback_product_view" v-model="user_group.feedback_product_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_show" id="feedback_product_show" v-model="user_group.feedback_product_show"> Show
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Feedback Service CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_view" id="feedback_service_view" v-model="user_group.feedback_service_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_show" id="feedback_service_show" v-model="user_group.feedback_service_show"> Show
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Report Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="report_view" id="report_view" v-model="user_group.report_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="report_action" id="report_action" v-model="user_group.report_action"> Action
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
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
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Feedback Product List Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_list_view" id="feedback_product_list_view" v-model="user_group.feedback_product_list_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_list_answer" id="feedback_product_list_answer" v-model="user_group.feedback_product_list_answer"> Answer
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_list_edit" id="feedback_product_list_edit" v-model="user_group.feedback_product_list_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_product_list_delete" id="feedback_product_list_delete" v-model="user_group.feedback_product_list_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Feedback Service List Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_list_view" id="feedback_service_list_view" v-model="user_group.feedback_service_list_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_list_answer" id="feedback_service_list_answer" v-model="user_group.feedback_service_list_answer"> Answer
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_list_edit" id="feedback_service_list_edit" v-model="user_group.feedback_service_list_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="feedback_service_list_delete" id="feedback_service_list_delete" v-model="user_group.feedback_service_list_delete"> Delete
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
                                <input type="checkbox" name="question_list_answer" id="question_list_answer" v-model="user_group.question_list_answer"> Answer
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

            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>Customer CRUD Permissions</strong>
                </div>
                <div class="panel-body">
                    <form class="form-inline">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="customer_view" id="customer_view" v-model="user_group.customer_view"> View
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="customer_create" id="customer_create" v-model="user_group.customer_create"> Create
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="customer_edit" id="customer_edit" v-model="user_group.customer_edit"> Edit
                            </label>
                        </div> &nbsp; &nbsp;
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="customer_delete" id="customer_delete" v-model="user_group.customer_delete"> Delete
                            </label>
                        </div> &nbsp; &nbsp;
                    </form>
                </div>
            </div>
        </div>

        <div class="text-center">
            <button class="btn btn-success" @click="updateRoleRights()">
                Update Permissions <i class="fa fa-refresh"></i>
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
                    feedback_product_view: false,
                    feedback_product_show: false,
                    feedback_product_list_view: false,
                    feedback_product_list_answer: false,
                    feedback_product_list_edit: false,
                    feedback_product_list_delete: false,
                    feedback_service_view: false,
                    feedback_service_show: false,
                    feedback_service_list_view: false,
                    feedback_service_list_answer: false,
                    feedback_service_list_edit: false,
                    feedback_service_list_delete: false,
                    question_view: '',
                    question_create: '',
                    question_list_view: '',
                    question_list_answer: '',
                    question_list_edit: '',
                    question_list_delete: '',
                    customer_view: '',
                    customer_create: '',
                    customer_edit: '',
                    customer_delete: '',
                    report_view: '',
                    report_action: ''
                },
                showLoading: false,
                showAlert: false
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
                    vm.user_group.feedback_product_view = response.data.data.feedback_product_crud_rights.view;
                    vm.user_group.feedback_product_show = response.data.data.feedback_product_crud_rights.show;
                    vm.user_group.feedback_product_list_view = response.data.data.feedback_product_list_crud_rights.view;
                    vm.user_group.feedback_product_list_answer = response.data.data.feedback_product_list_crud_rights.answer;
                    vm.user_group.feedback_product_list_edit = response.data.data.feedback_product_list_crud_rights.edit;
                    vm.user_group.feedback_product_list_delete = response.data.data.feedback_product_list_crud_rights.delete;
                    vm.user_group.feedback_service_view = response.data.data.feedback_service_crud_rights.view;
                    vm.user_group.feedback_service_show = response.data.data.feedback_service_crud_rights.show;
                    vm.user_group.feedback_service_list_view = response.data.data.feedback_service_list_crud_rights.view;
                    vm.user_group.feedback_service_list_answer = response.data.data.feedback_service_list_crud_rights.answer;
                    vm.user_group.feedback_service_list_edit = response.data.data.feedback_service_list_crud_rights.edit;
                    vm.user_group.feedback_service_list_delete = response.data.data.feedback_service_list_crud_rights.delete;
                    vm.user_group.question_view = response.data.data.question_crud_rights.view;
                    vm.user_group.question_create = response.data.data.question_crud_rights.create;
                    vm.user_group.question_list_view = response.data.data.question_list_crud_rights.view;
                    vm.user_group.question_list_answer = response.data.data.question_list_crud_rights.answer;
                    vm.user_group.question_list_edit = response.data.data.question_list_crud_rights.edit;
                    vm.user_group.question_list_delete = response.data.data.question_list_crud_rights.delete;
                    vm.user_group.customer_view = response.data.data.customer_crud_rights.view;
                    vm.user_group.customer_create = response.data.data.customer_crud_rights.create;
                    vm.user_group.customer_edit = response.data.data.customer_crud_rights.edit;
                    vm.user_group.customer_delete = response.data.data.customer_crud_rights.delete;
                    vm.user_group.report_view = response.data.data.report_view_rights.view;
                    vm.user_group.report_action = response.data.data.report_view_rights.action;
                }).catch(error => {
                    console.log(error);
                });
            },
            updateRoleRights: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/" + vm.usergroup_id + '/update-role-rights';
                vm.showLoading = true;
                function sendRequest() {
                    axios.post(url, {
                        user_group: vm.user_group
                    }).then(response => {
                        console.log(response.data);
                        vm.showLoading = false;
                        vm.showAlert = true;
                        vm.getRoleRights();
                    }).catch(error => {
                        console.log(error);
                    });
                }
                let debounceFunction = _.debounce(sendRequest, 1000);
                debounceFunction();
            }
        }
    }
</script>

<style scoped>

</style>