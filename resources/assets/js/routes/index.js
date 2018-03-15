import VuewRouter from 'vue-router'

const routes = [
    {
        path: '/',
        name: 'home',
        component: require('../components/login/Login.vue')
    },
    {
        path: '/',
        name: 'test',
        component: require('../components/login/Login.vue')
    },
]

export default new VuewRouter({
    routes
})