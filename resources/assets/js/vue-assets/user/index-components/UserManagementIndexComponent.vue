<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_user">
            Add User <i class="fa fa-user-plus"></i>
        </button> <br> <br>

        <div class="text-center" v-show="showLoading">
            <i class="fa fa-spinner fa-pulse fa-fw"></i>
            <span>Loading...</span>
        </div>

        <div class="col-lg-12">
            <table class="table table-bordered table-striped" id="table_user">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Joined at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="user in users">
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.phone }}</td>
                        <td>{{ user.role }}</td>
                        <td>
                            <span v-if="user.status === 1" class="text-green">Active</span>
                            <span v-else class="text-red">Deactivated</span>
                        </td>
                        <td>
                            {{ user.created_at }}
                        </td>
                        <td>
                            <div v-if="user.role !== 'Administrator'">
                                <button type="button" class="btn btn-warning">
                                    <i class="fa fa-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_delete_user" @click="changeCurrentUser(user)">
                                    <i class="fa fa-trash-o"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal Add User -->
        <div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="addUserLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-green" id="addUserLabel">Add User</h4>
                    </div>
                    <div class="text-center" v-show="showLoading">
                        <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        <span>Sending...</span>
                    </div>
                    <div class="alert alert-dismissible" role="alert" v-show="alert.showAlert" v-bind:class="{ 'alert-success': alert.type === true, 'alert-danger': alert.type === false }" style="margin-bottom: -1%;">
                        <button type="button" class="close" @click="alert.showAlert = false"><span aria-hidden="true">&times;</span></button>
                        <strong>Info!</strong> {{ alert.alertContent }}
                    </div>
                    <form id="form_add_user">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('name')}">
                                        <label for="name">Name</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-address-card" aria-hidden="true"></i>
                                            </div>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter user's name" v-model="user.name"/>
                                        </div>
                                        <span class="help-block text-red" v-show="validator.errors.has('name')">
                                            {{ validator.errors.first('name') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('email')}">
                                        <label for="email">Email</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-envelope"></i>
                                            </div>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Enter user's email address" v-model="user.email"/>
                                        </div>
                                        <span class="help-block text-red" v-show="validator.errors.has('email')">
                                            {{ validator.errors.first('email') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('role')}">
                                        <label for="usergroupId">Role</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-user-secret"></i>
                                            </div>
                                            <select name="usergroupId" id="usergroupId" class="form-control" v-model="user.role">
                                                <option value="" selected>Select Role...</option>
                                                <option v-for="role in roles" :value="role.systemId">
                                                    {{ role.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <span class="help-block text-red" v-show="validator.errors.has('role')">
                                            {{ validator.errors.first('role') }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearState()">Close</button>
                            <button type="button" class="btn btn-success" @click="addUser()">
                                Add User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Delete User -->
        <div class="modal fade in" id="modal_delete_user" tabindex="-1" role="dialog" aria-labelledby="deleteUserLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-red" id="deleteUserLabel">Delete User</h4>
                    </div>
                    <div class="modal-body">
                        Are you sure want to dismiss "{{ user.name }}" ?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" @click="clearState()">Cancel</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" @click="deleteUser()">Delete</button>
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
                    name: {
                        required: "Please enter user's name"
                    },
                    email: {
                        required: "Please enter customer's email address"
                    },
                    role: {
                        required: "Please specify the user's role"
                    }
                }
            }
        }
    });

    export default {
        name: "user-management-index",
        props: ['tenant_id', 'creator_id'],
        created() {
            this.getAllUser();
            this.getAllUserRoles();

            this.validator = new Validator({
                name: 'required',
                email: 'required|email',
                phone: 'required',
                role: 'required'
            });
        },
        data() {
            return {
                roles: [],
                user: {
                    systemId: '',
                    name: '',
                    email: '',
                    phone: '',
                    role: ''
                },
                users: [],
                validator: '',
                showLoading: false,
                alert: {
                    type: true,
                    showAlert: false,
                    alertContent: ''
                },
                showModal: false
            }
        },
        watch: {
            'user.name': function() {
                if(this.alert.showAlert === false) {
                    this.validator.validate('name', this.user.name);
                }
            },
            'user.email': function () {
                if(this.alert.showAlert === false) {
                    this.validator.validate('email', this.user.email);
                }
            },
            'user.role': function () {
                if(this.alert.showAlert === false) {
                    this.validator.validate('role', this.user.role);
                }
            }
        },
        methods: {
            getAllUser: function() {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/user_management/' + this.tenant_id + '/' + 'get-all-user';
                axios.get(url).then(response => {
                    this.users = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getAllUserRoles: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/user_group/' + this.tenant_id + '/' + 'get-all-user-group';
                axios.get(url).then(response => {
                    this.roles = response.data.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            addUser: function () {
                let vm = this;
                vm.validator.validateAll({
                    name: vm.user.name,
                    email: vm.user.email,
                    role: vm.user.role
                }).then(result => {
                    if(result) {
                        vm.showLoading = true;
                        function sendRequest() {
                            const url = window.location.protocol + "//" + window.location.host + "/api/user_management/add-user";
                            axios.post(url, {
                                user: vm.user, tenant_id: vm.tenant_id, creator_id: vm.creator_id
                            }).then(response => {
                                if(response.data.error === undefined) {
                                    vm.alert.showAlert = true;
                                    vm.alert.alertContent = response.data.info;
                                    vm.alert.type = true;
                                } else {
                                    vm.alert.showAlert = true;
                                    vm.alert.alertContent = response.data.error;
                                    vm.alert.type = false;
                                }
                                vm.showLoading = false;
                                vm.clearState();
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
            clearState: function () {
                let vm = this;
                vm.user.name = '';
                vm.user.email = '';
                vm.user.phone = '';
                vm.user.role = '';
                vm.validator.errors.clear();
            },
            changeCurrentUser: function (currentUser) {
                let vm = this;
                vm.user.systemId = currentUser.systemId;
                vm.user.name = currentUser.name;
                vm.user.name = currentUser.name;
                vm.user.email = currentUser.email;
                vm.user.phone = currentUser.phone;
                vm.user.role = currentUser.role;
            },
            deleteUser: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/api/user_management/delete-user";
                axios.post(url, {
                    'user_id': vm.user.systemId
                }).then(response => {
                    vm.showLoading = true;
                    if(response.data.message !== undefined) {
                        function refreshData() {
                            vm.getAllUser();
                            vm.showLoading = false;
                        }
                        let debounceFunction = _.debounce(refreshData, 1000);
                        debounceFunction();
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>