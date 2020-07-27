require('./bootstrap');
import Vue from 'vue';

import Auth from './auth.js';
import APi from './Api.js';

window.auth = new Auth();
window.api = new APi;
window.Event = new Vue();

import App from './components/AppComponent';

import router from './router';


const app = new Vue({
    el: '#app',
    components: {
        'app-component': App
    },
    router
});
