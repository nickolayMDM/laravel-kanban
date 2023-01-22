require('./bootstrap');

window.Vue = require('vue').default;

let VModal = require('vue-js-modal').default;
let VueCookies = require('vue-cookies');

import { library } from '@fortawesome/fontawesome-svg-core';
import { faPen, faXmark } from '@fortawesome/free-solid-svg-icons';
library.add(faPen);
library.add(faXmark);

let stateSync = require('./plugins/stateSync').default;

Vue.component('app', require('./components/App.vue').default);
Vue.use(VModal);
Vue.use(VueCookies);
Vue.use(stateSync);

new Vue({
    el: '#app',
});
