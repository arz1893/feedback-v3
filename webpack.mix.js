let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/assets/js/app.js', 'public/js')
    .copy('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js/bootstrap/')
    .copy('resources/assets/js/bootstrap/tooltip.js', 'public/js/bootstrap/')
    .js('node_modules/jquery/dist/jquery.js', 'public/js/jquery/')
    .copy('node_modules/axios/dist/axios.js', 'public/js/axios/')
    .copy('node_modules/lodash/lodash.js', 'public/js/lodash/')
    .copy('node_modules/vue/dist/vue.js', 'public/js/vue/')
    .copy('node_modules/moment/moment.js', 'public/js/moment/')
    .copy('node_modules/vee-validate/dist/vee-validate.js', 'public/js/vee-validate/')
    .copy('resources/assets/js/admin-lte/adminlte.min.js', 'public/js/admin-lte/')
    .js('resources/assets/js/vue-assets/master_data/product/vue_add_product.js', 'public/js/vue-assets/master_data/product/')
    .js('resources/assets/js/vue-assets/master_data/product/vue_index_product.js', 'public/js/vue-assets/master_data/product')
    .js('resources/assets/js/vue-assets/master_data/product/vue_edit_product.js', 'public/js/vue-assets/master_data/product')
    .js('resources/assets/js/vue-assets/master_data/service/vue_index_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/master_data/service/vue_add_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/master_data/service/vue_edit_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/selection/product/product_selection.js', 'public/js/vue-assets/selection/product/')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_show.js', 'public/js/vue-assets/feedback/product/')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_list.js', 'public/js/vue-assets/feedback/product')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_edit.js', 'public/js/vue-assets/feedback/product')
    .js('resources/assets/js/vue-assets/selection/service/service_selection.js', 'public/js/vue-assets/selection/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_show.js', 'public/js/vue-assets/feedback/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_edit.js', 'public/js/vue-assets/feedback/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_list.js', 'public/js/vue-assets/feedback/service')
    .js('resources/assets/js/vue-assets/master_data/tag/vue_index_tag.js', 'public/js/vue-assets/master_data/tag')
    .js('resources/assets/js/vue-assets/master_data/tag/vue_add_tag.js', 'public/js/vue-assets/master_data/tag')
    .js('resources/assets/js/vue-assets/master_data/tag/vue_edit_tag.js', 'public/js/vue-assets/master_data/tag')
    .js('resources/assets/js/vue-assets/master_data/customer/vue_index_customer.js', 'public/js/vue-assets/master_data/customer')
    .js('resources/assets/js/vue-assets/master_data/customer/vue_add_customer.js', 'public/js/vue-assets/master_data/customer')
    .js('resources/assets/js/vue-assets/master_data/customer/vue_edit_customer.js', 'public/js/vue-assets/master_data/customer')
    .js('resources/assets/js/vue-assets/question/vue_question_index.js', 'public/js/vue-assets/question/')
    .js('resources/assets/js/vue-assets/question/vue_question_list.js', 'public/js/vue-assets/question')
    .copy('node_modules/vue-multiselect/dist/vue-multiselect.min.js', 'public/js/vue-multiselect/')
    .sass('resources/assets/sass/app.scss', 'public/css/admin-lte/template_all.css')
    .copy('node_modules/vue-multiselect/dist/vue-multiselect.min.css', 'public/css/vue-multiselect');
