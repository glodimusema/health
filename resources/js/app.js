/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import vuetify from './Vuetify'
import router from './router'

import Core from './mixins/core'
import Toasted from 'vue-toasted';

import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
// import VueHtmlToPaper from 'vue-html-to-paper';



window.Vue = require('vue').default;


import Vuex from 'vuex'  
Vue.use(Vuex)
Vue.mixin(Core);
Vue.use(Toasted)
Vue.use(VueSweetalert2)

import shareData from './store/index'
const store = new Vuex.Store(
  shareData
)

import VueApexCharts from 'vue-apexcharts'
Vue.use(VueApexCharts)

Vue.component('apexchart', VueApexCharts)

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('App', require('./components/App.vue').default);

Vue.component('login', require('./components/frontend/login.vue').default);

// Vue.use(VueHtmlToPaper, options);

// // or, using the defaults with no stylesheet
// Vue.use(VueHtmlToPaper);
// Vue.component('register', require('./frontend/register.vue').default);
// Vue.component('forgot', require('./frontend/forgot.vue').default);
// Vue.component('reset', require('./frontend/reset.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify,
    router,
    store
});
