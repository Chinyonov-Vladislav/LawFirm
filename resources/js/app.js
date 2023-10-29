/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from "vue";
import axios from 'axios';
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import Fragment from 'vue-fragment';
import YmapPlugin from 'vue-yandex-maps'
require('./bootstrap');
window.Vue = require('vue').default;
axios.defaults.baseURL = "http://127.0.0.1:8000";
Vue.prototype.$axios = axios;
Vue.use(Fragment.Plugin);
Vue.use(VueSweetalert2);

const settings = {
    apiKey: '0fe42291-d6ce-44a8-a9db-528b8e67fef2',
    lang: 'ru_RU',
    coordorder: 'latlong',
    version: '2.1'
}
Vue.use(YmapPlugin, settings)


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


// компоненты
Vue.component('my-header', require('./components/LayoutComponents/Header.vue').default);
Vue.component('my-footer', require('./components/LayoutComponents/Footer.vue').default);
Vue.component('my-preloader', require('./components/LayoutComponents/Preloader.vue').default);
// страницы
Vue.component('main-page', require('./components/Pages/MainPage.vue').default);
Vue.component('page404', require('./components/Pages/Page404.vue').default);
Vue.component("login-page",require('./components/Pages/LoginPage.vue').default);
Vue.component("registration-page",require("./components/Pages/RegistrationPage.vue").default);
Vue.component("contact-page",require("./components/Pages/ContactPage.vue").default);
Vue.component("faq-page",require("./components/Pages/FAQPage.vue").default);
Vue.component("about-page",  require("./components/Pages/AboutUsPage.vue").default);
Vue.component("blog-page",require("./components/Pages/BlogPage.vue").default);
Vue.component("personal-cabinet-client", require("./components/Pages/PersonalCabinetClient.vue").default);
const app = new Vue({
    el: '#app',
});
