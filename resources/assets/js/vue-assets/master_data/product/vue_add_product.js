
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../bootstrap');

window.Vue = require('vue');
window.AddProductForm = require('./components/AddProductFormComponent');
window.TagComponent = require('./components/TagComponent');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tag-component', require('./components/TagComponent.vue'));

const add_product = new Vue({
    el: '#add_product',
    render (h) {
        return h('AddProductForm', {
            props: {
                product: this.product,
                showAttachment: this.showAttachment,
                tenantId: this.tenantId
            }
        })
    },
    components: {
        AddProductForm, TagComponent
    },
    data: {
        product: {
            name: '',
            description: '',
            tags: []
        },
        showAttachment: false,
        tenantId: $('#tenantId').val()
    },
    methods: {
        getValue(event) {

        }
    }

});
