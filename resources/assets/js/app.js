
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('navbar', require('./app/components/navbar/Navbar.vue'));
Vue.component('register', require('./app/components/auth/Register.vue'));
Vue.component('login', require('./app/components/auth/Login.vue'));
Vue.component('image-modal', require('./app/components/image/ImageModal.vue'));
Vue.component('tag', require('./app/components/Tag.vue'));

Vue.component('album', require('./app/components/image/Album.vue'));
Vue.component('avatar', require('./app/components/user/Avatar.vue'));
Vue.component('upload', require('./app/components/image/Upload.vue'));
Vue.component('photo', require('./app/components/image/Photo.vue'));
Vue.component('favorites', require('./app/components/user/Favorites.vue'));


import App from './app/components/App.vue'

import router from './app/router'
import store from './app/vuex'
import VeeValidate from 'vee-validate'

Vue.use(VeeValidate);

import VueAxios from 'vue-axios'
import VueAuthenticate from 'vue-authenticate'
import axios from 'axios';

Vue.use(VueAxios, axios);
Vue.use(VueAuthenticate, {
    baseUrl: 'http://localhost:8000',

    providers: {
        github: {
            clientId: 'xxx',
            name: 'github',
            url: '/login/github',
            authorizationEndpoint: 'http://github.com/login/oauth/authorize',
            redirectUri: 'http://localhost:8000/login/github/callback',
            optionalUrlParams: ['scope'],
            scope: ['user:email'],
            scopeDelimiter: ' ',
            oauthType: '2.0',
            popupOptions: { width: 1020, height: 618 }
        },

        google: {
            clientId: 'xxx',
            name: 'google',
            url: '/login/google',
            authorizationEndpoint: 'https://accounts.google.com/o/oauth2/auth',
            redirectUri: 'http://localhost:8000/login/google/callback',
            requiredUrlParams: ['scope'],
            optionalUrlParams: ['display'],
            scope: ['profile', 'email'],
            scopePrefix: 'openid',
            scopeDelimiter: ' ',
            display: 'popup',
            oauthType: '2.0',
            popupOptions: { width: 452, height: 633 }
        }
    }
});

const app = new Vue({
    el: '#app',
    router,
    store,
    components: { App }
});