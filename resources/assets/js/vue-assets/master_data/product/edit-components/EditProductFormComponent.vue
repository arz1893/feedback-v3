<template>
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="col-lg-offset-4 col-md-offset-4 col-sm-offset-3 col-xs-offset-2">
                <div class="imagebox" style="width: 225px;">
                    <a role="button" onclick="$('#product_picture').trigger('click');">
                        <img v-if="product.img !== undefined" v-bind:src="product.img" class="">
                        <img v-else v-bind:src="default_image" class="">
                        <span class="imagebox-desc">
                            click to change picture <i class="fa fa-pencil"></i>
                        </span>
                    </a>
                </div>
            </div>

            <input type="file" id="product_picture" name="product_picture" style="display: none;" accept="image/*" v-on:change="changeProductPicture($event)">

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your product name" v-model="product.name"/>
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description" class="form-control" placeholder="Enter you product description" v-model="product.description" rows="6"></textarea>
            </div>
            <div class="form-group">
                <label for="select_tag">Tags</label>
                <multiselect id="select_tags"
                             v-model="product.productTags"
                             :options="options"
                             :value="product.productTags"
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
                <button type="button" class="btn btn-primary form-control" @click="updateProduct()">
                    Update Product
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import MultiSelect from 'vue-multiselect';

    Vue.component('multiselect', MultiSelect);

    export default {
        name: "edit-product",
        props: ['product_id', 'tenant_id'],
        data() {
            return {
                product: [],
                options: [],
                default_image: window.location.protocol + "//" + window.location.host  + '/default-images/no-image.jpg',
                fileName: '',
                uploadedImage: ''
            }
        },
        created() {
            this.getProduct(this.product_id);
            this.getTagList();
        },
        watch: {
            uploadedImage: function () {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/product/' + this.product_id + '/change-picture';
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
            getProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/product/' + this.product_id + '/get-product';
                axios.get(url).then(response => {
                    vm.product = response.data.data;
                }).catch(error => {
                    console.log(error);
                })
            },
            getTagList: function() {
                const url = window.location.protocol + "//" + window.location.host + "/" + 'api/tag/' + this.tenant_id + '/generate-select-tag';
                axios.get(url).then(response => {
                    this.options = response.data;
                }).catch(error => {
                    console.log(error);
                })
            },

            changeProductPicture: function (event) {
                let vm = this;
                let files = event.target.files || event.dataTransfer.files;
                let reader = new FileReader();
                vm.fileName = files[0].name;
                reader.onload = (e) => {
                    this.uploadedImage = e.target.result;
                };
                reader.readAsDataURL(files[0]);
            },

            updateProduct: function () {
                let vm = this;
                const url = window.location.protocol + "//" + window.location.host + '/api/product/update-product';
                console.log(vm.product);
                axios.post(url, {product: vm.product}).then(response => {
                    if(response.data.message === 'success') {
                        window.location.replace(window.location.protocol + "//" + window.location.host + '/product');
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