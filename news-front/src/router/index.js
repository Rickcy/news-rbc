import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import NewsItem from '../views/NewsItem.vue'

const loader = require('../helpers/loader');

Vue.use(VueRouter);

const routes = [
    {
        path: '/',
        name: 'Home',
        component: Home,

    },
    {
        path: '/news/:id',
        name: 'news-details',
        component: NewsItem
    }
];

const router = new VueRouter({
    mode: 'history',
    base: process.env.BASE_URL,
    routes
});

router.beforeEach((to, from, next) => {
    loader.show();
    next()
});

router.afterEach(() => {
    loader.hide()
});

export default router
