
import App from './App.vue'
import Vue from 'vue'
require('./bootstrap');

import Toaster from 'v-toaster'
// optional set default imeout, the default is 10000 (10 seconds).
Vue.use(Toaster, {timeout: 5000})
// You need a specific loader for CSS files like https://github.com/webpack/css-loader
import 'v-toaster/dist/v-toaster.css'


import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)
// window.Vue = require('vue');



new Vue({
    el: '#wawan',
    render: h => h(App),
    
});
