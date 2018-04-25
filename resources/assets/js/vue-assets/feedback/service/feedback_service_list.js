
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../bootstrap');

window.Vue = require('vue');
window.VeeValidate = require('vee-validate');
window.datePicker = require('vue-bootstrap-datetimepicker');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding add-components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('feedback-list', require('./list-components/FeedbackServiceListComponent.vue'));

const feedback_service_list = new Vue({
    el: '#feedback_service_list',
    data: {
        message: 'component mounted!'
    }
});

