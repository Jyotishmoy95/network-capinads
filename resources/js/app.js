require('./bootstrap');

require('alpinejs');

import Vue from 'vue'

Vue.component('dashboard', require('./vue/dashboard/Dashboard.vue').default);

const app = new Vue({
    el: '#app'
});
