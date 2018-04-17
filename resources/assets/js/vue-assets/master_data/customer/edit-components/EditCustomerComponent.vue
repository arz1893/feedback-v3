<template>
    <div>

        <div class="alert alert-success" role="alert" v-show="alertSuccess">
            <strong>Success <i class="fa fa-check"></i> </strong> A new customer has been added, please check the <a v-bind:href="index_url" class="alert-link">customer list</a>
        </div>

        <div class="col-lg-6 col-lg-offset-3">
            <div class="row form-margin-bottom">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="name" class="control-label">
                        Name <span class="text-danger">*</span>
                    </label>
                </div>
                <div class=" col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': validator.errors.has('name')}">
                    <input type="text"
                           name="name"
                           id="name"
                           class="form-control"
                           placeholder="Enter customer's name"
                           v-validate="'required'"
                           v-model="customer.name">
                    <span class="help-block text-red" v-show="validator.errors.has('name')">
                        {{ validator.errors.first('name') }}
                    </span>
                </div>
            </div>

            <div class="row form-margin-bottom">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="gender" class="control-label">
                        Gender <span class="text-danger">*</span>
                    </label>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8">
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="gender_male" value="1" v-model="customer.gender"> Male
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="gender" id="gender_female" value="0" v-model="customer.gender"> Female
                    </label>

                    <span class="help-block text-red" v-show="validator.errors.has('gender')">
                        {{ validator.errors.first('gender') }}
                    </span>
                </div>
            </div>

            <div class="row form-margin-bottom">
                <div class="form-group">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label for="phone" class="control-label">
                            Phone <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-6 col-xs-8" v-bind:class="{'has-error': validator.errors.has('phone')}">
                        <input name="phone"
                               id="phone"
                               type="text"
                               class="form-control"
                               placeholder="Enter your phone address"
                               v-model="customer.phone">
                        <span class="help-block text-red" v-show="validator.errors.has('phone')">
                            {{ validator.errors.first('phone') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row form-margin-bottom">
                <div class="form-group">
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                        <label for="birthdate" class="control-label">
                            Birthdate <span class="text-danger">*</span>
                        </label>
                    </div>
                    <div class="col-lg-7 col-md-5 col-sm-5 col-xs-8" v-bind:class="{'has-error': validator.errors.has('birthdate')}">
                        <input type="date"
                               name="birthdate"
                               class="form-control"
                               placeholder="Click here"
                               v-model="customer.birthdate">
                        <span class="help-block text-red" v-show="validator.errors.has('birthdate')">
                            {{ validator.errors.first('birthdate') }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="row form-margin-bottom">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <label for="email" class="control-label">
                        Email
                    </label>
                </div>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-8" v-bind:class="{'has-error': validator.errors.has('email')}">
                    <input type="email"
                           name="email"
                           id="email"
                           class="form-control"
                           placeholder="Enter customer's email"
                           v-model="customer.email">
                    <span class="help-block text-red" v-show="validator.errors.has('email')">
                        {{ validator.errors.first('email') }}
                    </span>
                </div>
            </div>

            <div class="form-group form-margin-bottom">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" placeholder="Enter customer's address" rows="4" v-model="customer.address"></textarea>
            </div>
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" name="nation" id="nation" placeholder="Nation" v-model="customer.nation"/>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                    <input type="text" class="form-control" id="city" name="city" placeholder="City" v-model="customer.city"/>
                </div>
            </div>

            <div class="form-group form-margin-bottom">
                <label for="memo">Memo</label>
                <textarea id="memo" name="memo" class="form-control" placeholder="Add memo if needed" rows="2" v-model="customer.memo"></textarea>
            </div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" @click="validateCustomer()">
                    Update Customer
                </button>
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
                        required: "Please enter customer's name"
                    },
                    gender: {
                        required: "Gender has not been set yet"
                    },
                    phone: {
                        required: "Please enter customer's phone number"
                    },
                    birthdate: {
                        required: "Customer's birth date has not been set"
                    }
                }
            }
        }
    });
    export default {
        name: "edit-customer",
        props: ['customer_id'],
        data() {
            return {
                customer: {
                    systemId: '',
                    name: '',
                    gender: '',
                    email: '',
                    phone: '',
                    birthdate: '',
                    address: '',
                    nation: '',
                    city: '',
                    memo: ''
                },
                validator: '',
                alertSuccess: false,
                index_url: window.location.protocol + "//" + window.location.host + "/" + 'customer'
            }
        },
        created() {
            this.getCustomer();
            this.validator = new Validator({
                name: 'required',
                gender: 'required',
                phone: 'required|numeric|min:10',
                birthdate: 'required',
                email: 'email'
            });
        },
        watch: {
            watch: {
                'customer.name': function () {
                    if(this.alertSuccess === false) {
                        this.validator.validate('name', this.customer.name);
                    }
                },
                'customer.gender': function () {
                    if(this.alertSuccess === false) {
                        this.validator.validate('gender', this.customer.gender);
                    }
                },
                'customer.birthdate': function () {
                    let vm = this;
                    console.log(vm.customer.birthdate);
                    if(this.alertSuccess === false) {
                        this.validator.validate('birthdate', this.customer.birthdate);
                    }
                },
                'customer.phone': function () {
                    if(this.alertSuccess === false) {
                        this.validator.validate('phone', this.customer.phone);
                    }
                },
                'customer.email': function () {
                    if(this.alertSuccess === false) {
                        this.validator.validate('email', this.customer.email);
                    }
                },
            },
        },
        methods: {
            validateCustomer: function () {
                let vm = this;

                vm.validator.validateAll({
                    name: vm.customer.name,
                    gender: vm.customer.gender,
                    phone: vm.customer.phone,
                    birthdate: vm.customer.birthdate,
                    email: vm.customer.email
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/update-customer/';
                        axios.post(url, {
                            customer: vm.customer
                        }).then(response => {
                            if(response.data !== '') {
                                vm.alertSuccess = true;
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            },

            getCustomer: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/customer/' + vm.customer_id + '/get-customer';
                axios.get(url).then(response => {
                    vm.customer.systemId = response.data.data.systemId;
                    vm.customer.name = response.data.data.name;
                    vm.customer.gender = response.data.data.gender;
                    vm.customer.email = response.data.data.email;
                    vm.customer.phone = response.data.data.phone;
                    vm.customer.birthdate = moment(response.data.data.birthdate).format("YYYY-MM-DD");
                    vm.customer.address = response.data.data.address;
                    vm.customer.nation = response.data.data.nation;
                    vm.customer.city = response.data.data.city;
                    vm.customer.memo = response.data.data.memo;

                    console.log({birthdate: response.data.data.birthdate});
                    console.log(vm.customer);

                }).catch(error => {
                    console.log(error);
                });
            }
        }
    }
</script>

<style scoped>

</style>