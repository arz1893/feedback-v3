
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

window.Vue = require('vue');
window.MultiSelect = require('vue-multiselect');
window.VeeValidate = require('vee-validate');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding add-components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('user-group-add', require('./add-components/UserGroupAddComponent.vue'));

const user_group_add = new Vue({
    el: '#user_group_add',
    data: {
        message: 'component mounted!'
    }
});
