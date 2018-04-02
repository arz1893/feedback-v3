<template>
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group" v-bind:class="{'has-error' : errors.has('name')}">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Service's name" v-model="service.name" v-validate="'required'"/>
            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('name') }}</span>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="6" placeholder="Enter your service's description" v-model="service.description"></textarea>
        </div>

        <div class="form-group">
            <label for="select_tags">Tags</label>
            <multiselect id="select_tags" v-model="service.tags" :options="options" :multiple="true" :close-on-select="false" :clear-on-select="false" :hide-selected="true" :preserve-search="true" placeholder="Choose Tag" label="name" track-by="name"></multiselect>
        </div>

        <div class="form-group" v-bind:class="{'has-error': errors.has('image_cover')}">
            <label for="image_cover">Choose image</label>
            <input type="file" accept="image/*" class="form-control-file" name="image_cover" id="image_cover" aria-describedby="fileHelp" v-on:change='previewImage($event)' v-validate="'image'">
            <small id="fileHelp" class="form-text text-muted">Choose your service's image</small>
            <span v-show="errors.has('name')" class="text-danger">{{ errors.first('image') }}</span>
        </div>

        <div class="form-group" v-if="showAttachment" style="width: 180px;">
            <span class="mailbox-attachment-icon has-img"><img src="" id="preview"></span>
            <div class="mailbox-attachment-info">
                <a @click="clearAttachment($event)" class="btn btn-danger btn-xs pull-right" data-toggle="tooltip" data-placement="bottom" title="delete attachment">
                    <i class="fa fa-close"></i>
                </a>
                <a class="mailbox-attachment-name"><i class="fa fa-camera"></i> image</a>
            </div>
        </div>

        <div class="form-group">
            <button type="button" class="btn btn-primary" @click="validateBeforeSubmit()">
                <i class="fa fa-plus"></i> Add Service
            </button>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    Vue.use(VeeValidate);

    export default {
        name: "add-service",
        props: ['tenantid'],
        created() {
            this.getTagList();
        },
        data() {
            return {
                service: {
                    name: '',
                    description: '',
                    tags: [],
                    image: ''
                },
                fileName: '',
                showAttachment: false,
                options: []
            }
        },
        methods: {
            getTagList() {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/' + this.tenantid + '/generate-select-tag';
                axios.get(url).then(response => {
                    this.options = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            previewImage: function (event) {
                let files = event.target.files || event.dataTransfer.files;
                this.createImage(files[0]);

                var uploadedImage = event.target;
                if(uploadedImage.files && uploadedImage.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function (e) {
                        $('#preview').attr('src', e.target.result);
                    };
                    reader.readAsDataURL(uploadedImage.files[0]);
                }
                this.showAttachment = true;
            },
            clearAttachment: function(event) {
                $('#preview').removeAttr('src');
                $('#attachment').val("");
                $('#image_cover').val("");
                this.service.image = '';
                this.showAttachment = false;
            },
            createImage: function(file) {
                let reader = new FileReader();
                let vm = this;
                vm.fileName = file.name;
                reader.onload = (e) => {
                    vm.service.image = e.target.result;
                };
                reader.readAsDataURL(file);
            },
            validateBeforeSubmit: function () {
                const url = window.location.protocol + "//" + window.location.host + "/api/" + 'service/add-service/';
                let vm = this;
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        console.log(vm.service);
                        axios.post(url, {
                            service: vm.service,
                            fileName: vm.fileName,
                            tenantId: vm.tenantid
                        }).then(response => {
                            window.location.replace(window.location.protocol + "//" + window.location.host + '/service');
                        }).catch(error => {
                            console.log(error);
                        })
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>