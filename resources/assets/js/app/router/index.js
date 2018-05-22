import Vue from 'vue'
import VueRouter from 'vue-router'

import Home from './../../app/components/Home.vue'
import Explore from './../../app/components/Explore.vue'
import User from './../../app/components/user/User.vue'
import NotFound from './../../app/components/NotFound.vue'

Vue.use(VueRouter)

import beforeEnter from './beforeEnter'


const router = new VueRouter({
    routes: [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/explore',
            name: 'explore',
            component: Explore
        },
        {
            path: '/profile',
            name: 'user',
            component: User,
            beforeEnter: (to, from, next) => {
                beforeEnter(to, from, next)
            }
        },
        {
            path: '*',
            name: 'notfound',
            component: NotFound
        }
    ]
});

import beforeEach from './beforeEach'

router.beforeEach(beforeEach)

export default router