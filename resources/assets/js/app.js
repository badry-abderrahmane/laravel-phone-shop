
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import VuejsDialog from "vuejs-dialog";
import Notifications from 'vue-notification'

// Tell Vue to install the plugin.
window.Vue = require('vue');

Vue.use(VuejsDialog);
Vue.use(Notifications);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.Event = new Vue();

/**
*  Series components
*/
Vue.component('series-list', require('./components/series/listSeries.vue'));
Vue.component('series-form', require('./components/series/formSeries.vue'));
/**
*  Products components
*/
Vue.component('products-list', require('./components/products/listProducts.vue'));
Vue.component('products-form', require('./components/products/formProducts.vue'));
Vue.component('product-options', require('./components/products/productOptions.vue'));
/**
*  Categories components
*/
Vue.component('categories-list', require('./components/categories/listCategories.vue'));
Vue.component('categories-form', require('./components/categories/formCategories.vue'));
/**
*  Options components
*/
Vue.component('options-list', require('./components/options/listOptions.vue'));
Vue.component('options-form', require('./components/options/formOptions.vue'));
/**
*  Colors components
*/
Vue.component('colors-list', require('./components/colors/listColors.vue'));
Vue.component('colors-form', require('./components/colors/formColors.vue'));
/**
*  Accessories components
*/
Vue.component('accessories-list', require('./components/accessories/listAccessories.vue'));
Vue.component('accessories-form', require('./components/accessories/formAccessories.vue'));
/**
*  Galleries components
*/
Vue.component('galleries-list', require('./components/galleries/listGalleries.vue'));
Vue.component('galleries-form', require('./components/galleries/formGalleries.vue'));
/**
*  Optiongroups components
*/
Vue.component('optiongroups-list', require('./components/optiongroups/listOptiongroups.vue'));
Vue.component('optiongroups-form', require('./components/optiongroups/formOptiongroups.vue'));



Vue.component('pagination', require('laravel-vue-pagination'));



const app = new Vue({
    el: '#app',

    methods:{

        addData:{

        },
    }
});
