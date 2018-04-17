<template>
    <div>
        <div class="alert alert-success alert-dismissible" role="alert" v-show="alertSuccess">
            <button type="button" class="close" aria-label="Close" @click="alertSuccess = false"><span aria-hidden="true">&times;</span></button>
            <strong>Success <i class="fa fa-check"></i> </strong> Tag has been updated, please go to <a v-bind:href="tag_index_url" class="alert-link">tag list</a> to see changes
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
                            <a id="777777" data-id="777777" class="btn btn-select-color" style="background: #777777;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="7E8C8D" data-id="7E8C8D" class="btn btn-select-color" style="background: #7E8C8D;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="C6382E" data-id="C6382E" class="btn btn-select-color" style="background: #C6382E;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="D55005" data-id="D55005" class="btn btn-select-color" style="background: #D55005;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="EF9E0E" data-id="EF9E0E" class="btn btn-select-color" style="background: #EF9E0E;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="25AF62" data-id="25AF62" class="btn btn-select-color" style="background: #25AF62;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="13A388" data-id="13A388" class="btn btn-select-color" style="background: #13A388;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="2482C0" data-id="2482C0" class="btn btn-select-color" style="background: #2482C0;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="8D45AB" data-id="8D45AB" class="btn btn-select-color" style="background: #8D45AB;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
                            </a>
                            <a id="2E3E4E" data-id="2E3E4E" class="btn btn-select-color" style="background: #2E3E4E;" @click="changeColor($event)">
                                <input type="radio" class="invisible"/>
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
                    Update Tag
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
        name: "edit-tag",
        props: ['tag_id', 'sysupdater'],
        data() {
            return {
                tag: {
                    systemId: '',
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
            this.getTag();
            this.validator = new Validator({
                name: 'required',
                bgColor: 'required'
            });
        },
        watch: {
            'tag.name': function () {
                if(this.alertSuccess === false) {
                    this.validator.validate('name', this.tag.name);
                }
            },
            'tag.bgColor': function () {
                if(this.alertSuccess === false) {
                    this.validator.validate('bgColor', this.tag.bgColor);
                }
            }
        },
        methods: {
            getTag: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/' + vm.tag_id + '/get-tag';

                axios.get(url).then(response => {
                    console.log(response.data.data);
                    vm.tag.systemId = response.data.data.systemId;
                    vm.tag.name = response.data.data.name;
                    vm.tag.defValue = response.data.data.defValue;
                    vm.tag.bgColor = response.data.data.bgColor;
                    $(response.data.data.bgColor).addClass('is-selected-color');
                }).catch(error => {
                    console.log(error);
                });
            },
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
                        const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/update-tag/';
                        axios.post(url, {
                            tag: vm.tag,
                            sysupdater: vm.sysupdater
                        }).then(response => {
                            if(response.data.message === 'success') {
                                vm.alertSuccess = true;
                            }
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