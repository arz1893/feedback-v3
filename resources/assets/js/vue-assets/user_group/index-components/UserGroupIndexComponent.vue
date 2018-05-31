<template>
    <div>
        <a :href="add_url" type="button" class="btn btn-success">
            Add Role <i class="fa fa-plus-circle"></i>
        </a> <br> <br>

        <div class="alert alert-success" role="alert" v-if="showAlertDelete">
            <button type="button" class="close" aria-label="Close" @click="showAlertDelete = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ alertDeleteContent }}
        </div>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Permissions</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user_group, index) in user_groups">
                    <td>{{ index + 1 }}</td>
                    <td>
                        <a role="button" data-toggle="modal" data-target="#modalShowUserGroup" @click="getRoleRights(user_group.systemId, user_group.name)">
                            {{ user_group.name }}
                        </a>
                    </td>
                    <td>
                        <a v-bind:href="user_group.show_url" role="button">
                            Manage permissions here <i class="fa fa-cogs"></i>
                        </a>
                    </td>
                    <td>
                        <a role="button" class="btn btn-warning" @click="getUserGroup(user_group.systemId)" data-toggle="modal" data-target="#modalEditUserGroup">
                            <i class="fa fa-pencil-square"></i>
                        </a>
                        <a role="button" class="btn btn-danger" @click="selectUserGroup(user_group.systemId, user_group.name)" data-toggle="modal" data-target="#modalDeleteUserGroup">
                            <i class="fa fa-trash"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Modal -->
        <div class="modal fade" id="modalShowUserGroup" tabindex="-1" role="dialog" aria-labelledby="userGroupLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="userGroupLabel">{{ user_group.name }}</h4>
                    </div>
                    <div class="modal-body">
                        <h4>Permissions</h4>
                        <div class="panel panel-default">
                            <div class="panel-heading">FAQ CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.faq_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.faq_create"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.faq_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.faq_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Master Data CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.master_data_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.master_data_create"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.master_data_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.master_data_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Feedback Product CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.feedback_product_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Show: <span class="text-green" v-if="user_group.feedback_product_show"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Feedback Product List</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.feedback_product_list_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Answer: <span class="text-green" v-if="user_group.feedback_product_list_answer"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.feedback_product_list_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.feedback_product_list_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Feedback Service CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.feedback_service_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Show: <span class="text-green" v-if="user_group.feedback_service_show"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Feedback Service List</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.feedback_service_list_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Answer: <span class="text-green" v-if="user_group.feedback_service_list_answer"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.feedback_service_list_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.feedback_service_list_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Question CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.question_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.question_create"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.question_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.question_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Question List</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.question_list_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.question_list_answer"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.question_list_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.question_list_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Customer CRUD</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.customer_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.customer_create"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Edit: <span class="text-green" v-if="user_group.customer_edit"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Delete: <span class="text-green" v-if="user_group.customer_delete"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-heading">Report Permissions</div>
                            <div class="panel-body">
                                View: <span class="text-green" v-if="user_group.report_view"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                                Create: <span class="text-green" v-if="user_group.report_action"><i class="fa fa-check"></i></span> <span class="text-red" v-else><i class="fa fa-close"></i></span> &nbsp; &nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalEditUserGroup" tabindex="-1" role="dialog" aria-labelledby="editUserGroupLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="editUserGroupLabel">Edit Role</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-success alert-dismissible" role="alert" v-if="showAlertUpdate">
                            <button type="button" class="close" aria-label="Close" @click="showAlert = false"><span aria-hidden="true">&times;</span></button>
                            <strong>Info!</strong> Permission has been changed
                        </div>

                        <div class="text-center" v-if="showLoading">
                            <i class="fa fa-spinner fa-pulse fa-fw"></i> Loading...
                            <br>
                        </div>

                        <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('role_name') }">
                            <label for="user_group_name">Name</label>
                            <input type="text" name="user_group_name" id="user_group_name" class="form-control" v-model="user_group.name">
                            <span class="help-block text-red" v-show="validator.errors.has('role_name')">
                                {{ validator.errors.first('role_name') }}
                            </span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="updateUserGroup()">Update</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modalDeleteUserGroup" tabindex="-1" role="dialog" aria-labelledby="deleteUserGroupLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-red" id="deleteUserGroupLabel">Alert!</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to delete this role ? (including all user that this role)
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" @click="deleteUserGroup()">Delete</button>
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
                    role_name: {
                        required: "Please enter role name"
                    }
                }
            }
        }
    });

    export default {
        name: "user-group-index",
        props: ['tenant_id'],
        created() {
            this.getAllUserGroup();
            this.validator = new Validator({
                role_name: 'required'
            });

            if(sessionStorage.getItem('role_deleted') === 'true') {
                this.showAlertDelete = true;
                this.alertDeleteContent = "Role has been deleted";
                sessionStorage.removeItem('role_deleted');
            }
        },
        data() {
            return {
                user_group: {
                    systemId: '',
                    name: '',
                    master_data_view: '',
                    master_data_create: '',
                    master_data_edit: '',
                    master_data_delete: '',
                    faq_view: '',
                    faq_create: '',
                    faq_edit: '',
                    faq_delete: '',
                    feedback_product_view: '',
                    feedback_product_show: '',
                    feedback_product_list_view: '',
                    feedback_product_list_answer: '',
                    feedback_product_list_edit: '',
                    feedback_product_list_delete: '',
                    feedback_service_view: '',
                    feedback_service_show: '',
                    feedback_service_list_view: '',
                    feedback_service_list_answer: '',
                    feedback_service_list_edit: '',
                    feedback_service_list_delete: '',
                    question_view: '',
                    question_create: '',
                    question_edit: '',
                    question_delete: '',
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
                showAlertUpdate: false,
                showAlertDelete: false,
                alertDeleteContent: '',
                showLoading: false,
                user_groups: [],
                selectedUserGroup: {
                    systemId: '',
                    name: ''
                },
                validator: '',
                add_url: window.location.protocol + "//" + window.location.host + "/user_group/create"
            }
        },
        watch: {
            'user_group.name': function () {
                if(this.showAlert === false) {
                    this.validator.validate('role_name', this.user_group.name);
                }
            }
        },
        methods: {
            getAllUserGroup: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/user_group/' + this.tenant_id + '/' + 'get-all-user-group';
                axios.get(url).then(response => {
                    this.user_groups = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getRoleRights: function (usergroup_id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/" + usergroup_id + '/get-role-rights';
                axios.get(url).then(response => {
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
                    vm.user_group.question_edit = response.data.data.question_crud_rights.edit;
                    vm.user_group.question_delete = response.data.data.question_crud_rights.delete;
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
            getUserGroup: function(usergroup_id) {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/" + usergroup_id + '/get-user-group';
                axios.get(url).then(response => {
                    vm.user_group.systemId = response.data.user_group.systemId;
                    vm.user_group.name = response.data.user_group.name;
                }).catch(error => {
                    console.log(error);
                });
            },
            updateUserGroup: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/" + vm.user_group.systemId + '/update-user-group';
                vm.validator.validateAll({
                    role_name: vm.user_group.name
                }).then(result => {
                    if(result) {
                        vm.showLoading = true;
                        function sendRequest() {
                            axios.post(url, {
                                usergroup_name: vm.user_group.name
                            }).then(response => {
                                console.log(response.data);
                                vm.showAlert = true;
                                vm.showLoading = false;
                                vm.getUserGroup(vm.user_group.systemId);
                                vm.getAllUserGroup();
                            }).catch(error => {
                                console.log(error);
                            });
                        }
                        let debounceFunction = _.debounce(sendRequest, 1000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            selectUserGroup: function(usergroup_id, usergroup_name) {
                this.selectedUserGroup.systemId = usergroup_id;
                this.selectedUserGroup.name = usergroup_name;
            },
            deleteUserGroup: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/delete-user-group";
                console.log(vm.selectedUserGroup);
                axios.post(url, {
                    usergroup_id: vm.selectedUserGroup.systemId
                }).then(response => {
                    if(response.data.error === undefined) {
                        sessionStorage.setItem('role_deleted', 'true');
                        location.reload();
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>
    .modal-body {
        max-height: calc(70vh - 140px);
        overflow-y: auto;
    }
</style>