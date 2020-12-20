require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios'

const base = axios.create({
    // baseURL: 'https://remak3.com/WebShop'
  });
  
Vue.prototype.$http = base;

import Vue from 'vue';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
Vue.use(VueSweetalert2);

import VueToast from 'vue-toast-notification';
import 'vue-toast-notification/dist/theme-sugar.css';
Vue.use(VueToast);

Vue.component('all-users', require('./components/AllUsers.vue').default);

Vue.component('role', require('./components/Role.vue').default);
Vue.component('permission', require('./components/Permission.vue').default);

Vue.component('category', require('./components/Category.vue').default);

Vue.component('variation', require('./components/Variation.vue').default);

Vue.component('variation-option', require('./components/VariationOption.vue').default);

Vue.component('gallery', require('./components/Gallery.vue').default);

Vue.component('product', require('./components/Product.vue').default);

Vue.component('product-management', require('./components/ProductManagement.vue').default);

Vue.component('product-feature', require('./components/Frontend/Featured.vue').default);

Vue.component('product-top-sell', require('./components/Frontend/TopSell.vue').default);

Vue.component('product-details', require('./components/Frontend/ProductDetails.vue').default);

Vue.directive('can', function (el, binding, vnode) {
  if(Laravel.permissions.indexOf(binding.value) !== -1){
     return vnode.elm.hidden = false;
  }else{
     return vnode.elm.hidden = true;
  }
})
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
