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
    .js('node_modules/bootstrap/dist/js/bootstrap.js', 'public/js/bootstrap/')
    .js('resources/assets/js/bootstrap/tooltip.js', 'public/js/bootstrap/')
    .js('resources/assets/js/bootstrap/bootstrap-datepicker.js', 'public/js/bootstrap/')
    .js('node_modules/jquery/dist/jquery.js', 'public/js/jquery/')
    .js('node_modules/axios/dist/axios.js', 'public/js/axios/')
    .js('node_modules/lodash/lodash.js', 'public/js/lodash/')
    .js('node_modules/vue/dist/vue.js', 'public/js/vue/')
    .js('node_modules/moment/moment.js', 'public/js/moment/')
    .copy('node_modules/vee-validate/dist/vee-validate.js', 'public/js/vee-validate/')
    .copy('resources/assets/js/admin-lte/adminlte.min.js', 'public/js/admin-lte/')
    .js('resources/assets/js/vue-assets/master_data/product/vue_add_product.js', 'public/js/vue-assets/master_data/product/')
    .js('resources/assets/js/vue-assets/master_data/product/vue_index_product.js', 'public/js/vue-assets/master_data/product')
    .js('resources/assets/js/vue-assets/master_data/product/vue_edit_product.js', 'public/js/vue-assets/master_data/product')
    .js('resources/assets/js/vue-assets/master_data/service/vue_index_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/master_data/service/vue_add_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/master_data/service/vue_edit_service.js', 'public/js/vue-assets/master_data/service')
    .js('resources/assets/js/vue-assets/master_data/tag/vue_index_tag.js', 'public/js/vue-assets/master_data/tag')
    .js('resources/assets/js/vue-assets/selection/product/product_selection.js', 'public/js/vue-assets/selection/product/')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_show.js', 'public/js/vue-assets/feedback/product/')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_list.js', 'public/js/vue-assets/feedback/product')
    .js('resources/assets/js/vue-assets/feedback/product/feedback_product_edit.js', 'public/js/vue-assets/feedback/product')
    .js('resources/assets/js/vue-assets/selection/service/service_selection.js', 'public/js/vue-assets/selection/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_show.js', 'public/js/vue-assets/feedback/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_edit.js', 'public/js/vue-assets/feedback/service')
    .js('resources/assets/js/vue-assets/feedback/service/feedback_service_list.js', 'public/js/vue-assets/feedback/service')
    .copy('node_modules/vue-multiselect/dist/vue-multiselect.min.js', 'public/js/vue-multiselect/')
    .sass('resources/assets/sass/app.scss', 'public/css/admin-lte/template_all.css')
    .copy('node_modules/vue-multiselect/dist/vue-multiselect.min.css', 'public/css/vue-multiselect');
