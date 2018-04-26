
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('../../bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding add-components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('question-edit', require('./edit-components/EditQuestionComponent.vue'));

const question_edit = new Vue({
    el: '#question_edit',
    data: {
        message: 'component mounted!'
    }
});
