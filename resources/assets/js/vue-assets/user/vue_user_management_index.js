
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

Vue.component('user-management-index', require('./index-components/UserManagementIndexComponent.vue'));

const user_management_index = new Vue({
    el: '#user_management_index',
    data: {
        message: 'component mounted!'
    }
});
