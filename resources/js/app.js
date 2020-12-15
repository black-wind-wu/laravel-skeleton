/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import store from './store'

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

Vue.component('send-mobile-verify-code', require('./widgets/SendMobileVerifyCode.vue').default);
Vue.component('notification-mark-as-read', require('./widgets/notification/MarkAsRead.vue').default);
Vue.component('support', require('./widgets/Support.vue').default);
Vue.component('collect', require('./widgets/Collect.vue').default);
Vue.component('follow', require('./widgets/Follow.vue').default);
Vue.component('go-top', require('./widgets/GoTop.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store,
    computed: {
        guest() {
            return this.$store.getters.guest;
        },
        username() {
            return this.$store.getters.username;
        },
        avatar() {
            return this.$store.getters.avatar;
        },
    },
    mounted() {
        this.$store.dispatch('app/init');
        this.$store.dispatch('user/init');
    }
});


