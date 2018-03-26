<template>
    <div class="col-md-6 col-md-offset-3">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Product's name" v-model="product.name"/>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="6" placeholder="Enter your product's description" v-model="product.description"></textarea>
        </div>

        <div class="form-group">
            <label for="select_tags">Tags</label>
            <tag-component :tenantId="tenantId"></tag-component>
        </div>

        <div class="form-group">
            <label for="image_cover">Choose image</label>
            <input type="file" accept="image/*" class="form-control-file" name="image_cover" id="image_cover" aria-describedby="fileHelp" v-on:change='previewImage($event)'>
            <small id="fileHelp" class="form-text text-muted">Choose your product's image</small>
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
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-plus"></i> Add Product
            </button>
        </div>
    </div>
</template>

<script>
    export default {
        name: "AddProductFormComponent",
        props: {
            product: Object,
            showAttachment: Boolean,
            tenantId: String
        },
        mounted() {
            console.log(this.tenantId);
        }
    }
</script>

<style scoped>

</style>