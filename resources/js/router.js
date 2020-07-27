/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
import SearchComponent from './components/SearchComponent';
import Login from './components/LoginComponent';

Vue.use(VueRouter);


const router = new VueRouter({
    routes: [
        { path: '/', component: SearchComponent, name: 'search' },
        { path: '/PBlogin', component: Login, name: 'login' },
        { path: '/PBregistration', component: Login, name: 'registration' },
        { path: '/PBlogin', component: Login, name: 'logout' },
        { path: '/PBregStepTwo', component: Login, name: 'regStepTwo' },
    ],
});



export default router;