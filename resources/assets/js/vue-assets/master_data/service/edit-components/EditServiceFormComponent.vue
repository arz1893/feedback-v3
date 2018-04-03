<template>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
                <div class="imagebox" style="width: 225px;">
                    <a role="button" onclick="$('#service_picture').trigger('click');">
                        <img v-if="service.img !== undefined" v-bind:src="service.img" class="">
                        <img v-else v-bind:src="default_image" class="">
                        <span class="imagebox-desc">
                            click to change picture <i class="fa fa-pencil"></i>
                        </span>
                    </a>
                </div>
            </div>

            <input type="file" id="service_picture" name="service_picture" style="display: none;" accept="image/*" v-on:change="changeServicePicture($event)">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your service name" v-model="service.name"/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter you service description" v-model="service.description" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label for="select_tags">Tags</label>
                <multiselect id="select_tags"
                             v-model="service.serviceTags"
                             :options="options"
                             :value="service.serviceTags"
                             :multiple="true"
                             :close-on-select="false"
                             :clear-on-select="false"
                             :hide-selected="true"
                             :preserve-search="true"
                             placeholder="Choose Tag"
                             label="name"
                             track-by="name">

                </multiselect>
            </div>
            <div class="form-group">
                <button type="button" class="btn btn-primary form-control" @click="updateService()">
                    Update Service
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "edit-service",
        props: ['tenant_id', 'service_id'],
        data() {
            return {
                service: [],
                options: [],
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                fileName: '',
                uploadedImage: ''
            }
        },
        created() {
            this.getTagList();
            this.getService();
        },
        watch: {
            uploadedImage: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/service/' + this.service_id + '/change-picture';
                axios.post(url, {
                    uploadedImage: this.uploadedImage,
                    fileName: this.fileName
                }).then(response => {
                    if(response.data.message === 'success') {
                        location.reload();
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        },
        methods: {
            getService: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/service/' + this.service_id + '/get-service';
                axios.get(url).then(response => {
                    vm.service = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getTagList: function() {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/' + this.tenant_id + '/generate-select-tag';
                axios.get(url).then(response => {
                    vm.options = response.data;
                }).catch(error => {
                    console.log(error);
                });
            },
            changeServicePicture: function (event) {
                let vm = this;
                let files = event.target.files || event.dataTransfer.files;
                let reader = new FileReader();
                vm.fileName = files[0].name;
                reader.onload = (e) => {
                    this.uploadedImage = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            },
            updateService: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/service/update-service';
                console.log(vm.service);
                axios.post(url, {service: vm.service}).then(response => {
                    if(response.data.message === 'success') {
                        window.location.replace(window.location.protocol + "//" + window.location.host + '/service');
                    }
                }).catch(error => {
                    console.log(error);
                });
            }
        },

    }
</script>

<style scoped>

</style>