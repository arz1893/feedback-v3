<template>
    <div>
        <div class="alert alert-success alert-dismissible" role="alert" v-show="alertSuccess">
            <button type="button" class="close" aria-label="Close" @click="alertSuccess = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success <i class="fa fa-check"></i> </strong> A new tag has been added, please go to <a v-bind:href="tag_index_url" class="alert-link">tag list</a> to see all tag that has been added
        </div>

        <div class="col-lg-offset-3">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('name')}">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Tag Name" v-model="tag.name"/>
                        <span class="help-block text-red" v-show="validator.errors.has('name')">
                                {{ validator.errors.first('name') }}
                            </span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                    <div class="form-group">
                        <label for="defValue">Default Search</label>
                        <select id="defValue" name="defValue" class="form-control" v-model="tag.defValue">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12 error">
                    <div class="form-group" v-bind:class="{'has-error': validator.errors.has('bgColor')}">
                        <label for="bgColor">Select Color</label> <br>
                        <div class="btn-group" role="group">
                            <a data-id="777777" class="btn btn-select-color" style="background: #777777;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="777777" class="invisible" type="radio" name="bgColor" value="#777777" v-model="tag.bgColor">
                            </a>
                            <a data-id="7E8C8D" class="btn btn-select-color" style="background: #7E8C8D;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="7E8C8D" class="invisible" type="radio" name="bgColor" value="#7E8C8D" v-model="tag.bgColor">
                            </a>
                            <a data-id="C6382E" class="btn btn-select-color" style="background: #C6382E;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="C6382E" class="invisible" type="radio" name="bgColor" value="#C6382E" v-model="tag.bgColor">
                            </a>
                            <a data-id="D55005" class="btn btn-select-color" style="background: #D55005;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="D55005" class="invisible" type="radio" name="bgColor" value="#D55005" v-model="tag.bgColor">
                            </a>
                            <a data-id="EF9E0E" class="btn btn-select-color" style="background: #EF9E0E;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="EF9E0E" class="invisible" type="radio" name="bgColor" value="#EF9E0E" v-model="tag.bgColor">
                            </a>
                            <a data-id="25AF62" class="btn btn-select-color" style="background: #25AF62;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="25AF62" class="invisible" type="radio" name="bgColor" value="#25AF62" v-model="tag.bgColor">
                            </a>
                            <a data-id="13A388" class="btn btn-select-color" style="background: #13A388;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="13A388" class="invisible" type="radio" name="bgColor" value="#13A388" v-model="tag.bgColor">
                            </a>
                            <a data-id="2482C0" class="btn btn-select-color" style="background: #2482C0;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="2482C0" class="invisible" type="radio" name="bgColor" value="#2482C0" v-model="tag.bgColor">
                            </a>
                            <a data-id="8D45AB" class="btn btn-select-color" style="background: #8D45AB;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="8D45AB" class="invisible" type="radio" name="bgColor" value="#8D45AB" v-model="tag.bgColor">
                            </a>
                            <a data-id="2E3E4E" class="btn btn-select-color" style="background: #2E3E4E;" @click="changeColor($event)"> &nbsp; &nbsp; &nbsp;
                                <input id="2E3E4E" class="invisible" type="radio" name="bgColor" value="#2E3E4E" v-model="tag.bgColor">
                            </a>
                        </div>
                        <span class="help-block text-red" v-show="validator.errors.has('bgColor')">
                                {{ validator.errors.first('bgColor') }}
                            </span>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <button class="btn btn-primary" type="button" @click="validateTagSubmit()">
                    Add Tag
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
                        required: "Please enter tag name"
                    },
                    bgColor: {
                        required: 'Please choose one of the following color'
                    }
                }
            }
        }
    });

    export default {
        name: "add-tag-component",
        props: ['tenant_id', 'syscreator'],
        data() {
            return {
                tag: {
                    name: '',
                    defValue: 0,
                    bgColor: ''
                },
                validator: '',
                alertSuccess: false,
                tag_index_url: window.location.protocol + "//" + window.location.host + "/" + 'tag/'
            }
        },
        created() {
            this.validator = new Validator({
                name: 'required',
                bgColor: 'required'
            });
        },
        watch: {
            'tag.name': function () {
                this.validator.validate('name', this.tag.name);
            },
            'tag.bgColor': function () {
                console.log(this.tag.bgColor);
                this.validator.validate('bgColor', this.tag.bgColor);
            }
        },
        methods: {
            changeColor: function (event) {
                let vm = this;
                $('.btn-select-color').each(function () {
                    $(this).removeClass('is-selected-color');
                });
                let value = $(event.currentTarget).data('id');
                vm.tag.bgColor = '#' + value.toString();
                $(event.currentTarget).addClass('is-selected-color');
            },
            validateTagSubmit: function () {
                let vm = this;
                vm.validator.validateAll({
                    name: vm.tag.name,
                    bgColor: vm.tag.bgColor
                }).then(result => {
                    if(result) {
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/add-tag/';
                        axios.post(url, {
                            tag: vm.tag,
                            tenantId: vm.tenant_id,
                            syscreator: vm.syscreator
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.alertSuccess = true;
                                vm.clearState();
                            }
                        }).catch(error => {
                            console.log(error);
                        });
                    }
                }).catch(error => {
                    console.log(error);
                });
            },
            clearState: function () {
                let vm = this;
                vm.validator.errors.clear();
                vm.tag.name = '';
                vm.tag.defValue = 0;
                vm.tag.bgColor = '';
                $('.btn-select-color').each(function () {
                    $(this).removeClass('is-selected-color');
                });
            }
        }
    }
</script>

<style scoped>

</style>