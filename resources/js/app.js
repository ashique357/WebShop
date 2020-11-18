require('./bootstrap');

window.Vue = require('vue');
import axios from 'axios'

Vue.prototype.$http = axios

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

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
});
