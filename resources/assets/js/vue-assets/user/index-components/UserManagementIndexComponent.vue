<template>
    <div>
        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal_add_user">
            Add User <i class="fa fa-user-plus"></i>
        </button> <br> <br>

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
                            <button class="btn btn-warning">
                                <i class="fa fa-pencil-square"></i>
                            </button>
                            <button class="btn btn-danger">
                                <i class="fa fa-trash-o"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="modal_add_user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title text-green" id="myModalLabel">Add User</h4>
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
                                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('phone')}">
                                        <label for="phone">Phone Number</label>
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-phone"></i>
                                            </div>
                                            <input type="tel" name="phone" id="phone" class="form-control" placeholder="Enter user's phone number" v-model="user.phone"/>
                                        </div>
                                        <span class="help-block text-red" v-show="validator.errors.has('phone')">
                                            {{ validator.errors.first('phone') }}
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
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="button" class="btn btn-success" @click="addUser()">
                                Add User
                            </button>
                        </div>
                    </form>
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
                    phone: {
                        required: "Please enter customer's phone number"
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
        props: ['tenant_id'],
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
                validator: ''
            }
        },
        watch: {
            'user.name': function() {
                this.validator.validate('name', this.user.name);
            },
            'user.email': function () {
                this.validator.validate('email', this.user.email);
            },
            'user.phone': function () {
                this.validator.validate('phone', this.user.phone);
            },
            'user.role': function () {
                this.validator.validate('role', this.user.role);
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
                    phone: vm.user.phone,
                    role: vm.user.role
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/api/user_management/add-user";
                        axios.post(url, {
                            user: vm.user, tenant_id: vm.tenant_id
                        }).then(response => {
                            console.log(response.data);
                        }).catch(error => {
                            console.log(error);
                        });
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