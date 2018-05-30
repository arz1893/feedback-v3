<template>
    <div>

        <div class="alert alert-success" role="alert" v-show="showAlert">
            <button type="button" class="close" @click="showAlert = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success!</strong> {{ alertContent }}
        </div>

        <div class="row">
            <div class="col-lg-6 col-lg-offset-3">
                <div class="form-group" v-bind:class="{ 'has-error': validator.errors.has('user_group_name') }">
                    <input type="text" name="user_group_name" id="user_group_name" class="form-control" placeholder="Enter role name" v-model="user_group.name"/>
                    <span class="help-block text-red text-center" v-show="validator.errors.has('user_group_name')">
                        {{ validator.errors.first('user_group_name') }}
                    </span>
                </div>
            </div>
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
                                <input type="checkbox" name="feedback_list_answer" id="feedback_list_answer" v-model="user_group.feedback_list_answer"> Answer
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
            <button class="btn btn-primary" @click="validateBeforeSubmit()">
                Add Role <i class="fa fa-plus-circle"></i>
            </button>
            <button class="btn btn-default">
                Cancel
            </button>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_confirm_store" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-yellow" id="modalConfirmLabel">Alert!</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to add role with these permissions ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                        <button type="button" class="btn btn-primary" @click="addUserGroup()">Yes</button>
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
                    user_group_name: {
                        required: "Please enter role name"
                    }
                }
            }
        }
    });

    export default {
        name: "user-group-add",
        props: ['tenant_id', 'creator_id'],
        data() {
            return {
                user_group: {
                    name: '',
                    master_data_view: false,
                    master_data_create: false,
                    master_data_edit: false,
                    master_data_delete: false,
                    faq_view: false,
                    faq_create: false,
                    faq_edit: false,
                    faq_delete: false,
                    feedback_view: false,
                    feedback_create: false,
                    feedback_edit: false,
                    feedback_delete: false,
                    feedback_list_view: false,
                    feedback_list_answer: false,
                    feedback_list_edit: false,
                    feedback_list_delete: false,
                    question_view: false,
                    question_create: false,
                    question_edit: false,
                    question_delete: false,
                    question_list_view: false,
                    question_list_answer: false,
                    question_list_edit: false,
                    question_list_delete: false,
                    customer_view: false,
                    customer_create: false,
                    customer_edit: false,
                    customer_delete: false,
                    report_view: false,
                    report_action: false
                },
                validator: '',
                showAlert: false,
                alertContent: ''
            }
        },
        created() {
            this.validator = new Validator({
                user_group_name: 'required'
            });

            if(sessionStorage.getItem('role_added') === 'true') {
                this.showAlert = true;
                this.alertContent = "Role has been added";
                sessionStorage.removeItem('role_added');
            }
        },
        watch: {
            'user_group.name': function () {
                if(this.showAlert === false) {
                    this.validator.validate('user_group_name', this.user_group.name);
                }
            }
        },
        methods: {
            validateBeforeSubmit: function() {
                let vm = this;
                this.validator.validateAll({
                    user_group_name: vm.user_group.name
                }).then(result => {
                    if(result) {
                        $('#modal_confirm_store').modal('show');
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            addUserGroup: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_group/add-user-group";
                console.log(vm.user_group);
                axios.post(url, {
                    user_group: vm.user_group,
                    tenant_id: vm.tenant_id,
                    syscreator: vm.creator_id
                }).then(response => {
                    console.log(response.data);
                    if(response.data.error === undefined) {
                        sessionStorage.setItem('role_added', 'true');
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
    .form-control {
        text-align: center;
    }
</style>