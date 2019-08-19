
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap')
require('@node_modules/vuetify/dist/vuetify.min.css')

import Vue from 'vue'
import VueRouter from 'vue-router'
import App from './components/App.vue'
import router from './routes/index.js'
import Vuetify from 'vuetify'
 
Vue.use(Vuetify)
Vue.use(VueRouter)

window.Vue = Vue
window.Bus = new Vue()

const app = new Vue({
    el: '#app',
    render: h => h(App),
    router
});

window.app = app