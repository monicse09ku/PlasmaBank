/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
import Vue from 'vue';
import VueRouter from 'vue-router';
import SearchComponent from './components/SearchComponent';
import Login from './components/LoginComponent';
import Registration from './components/RegComponent';
import UserInfo from './components/UserInfoComponent';
import Profile from './components/ProfileComponent';

Vue.use(VueRouter);


const router = new VueRouter({
    routes: [
        { path: '/', component: SearchComponent, name: 'search' },
        { path: '/PBlogin', component: Login, name: 'login' },
        { path: '/PBregistration', component: Registration, name: 'registration' },
        { path: '/PBlogin', component: Login, name: 'logout' },
        { path: '/PBuserinfo/:user_id', component: UserInfo, name: 'userInfo' },
        { path: '/profile', component: Profile, name: 'profile' },
    ],
});



export default router;