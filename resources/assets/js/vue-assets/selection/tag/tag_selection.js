
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../bootstrap');

window.Vue = require('vue');
window.MultiSelect = require('vue-multiselect');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding add-components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('tag-selection', require('./container-component/TagSelectionContainer.vue'));

const tag_selection = new Vue({
    el: '#tag_selection',
    data: {
        message: 'component mounted!'
    }
});