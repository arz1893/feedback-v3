
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../../bootstrap');
require('chart.js');
require('hchs-vue-charts');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding add-components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('feedback-product-report-all', require('./all-components/FeedbackProductReportAllComponent.vue'));

const feedback_product_report_all = new Vue({
    el: '#feedback_product_report_all',
    data: {
        message: 'component mounted!'
    }
});

