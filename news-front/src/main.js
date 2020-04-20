import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import jQuery from 'jquery';

window.$ = window.jQuery = jQuery;
import 'popper.js'
import 'bootstrap';
import 'bootstrap/dist/css/bootstrap.min.css'
import '../src/assets/css/fontawesome-all.css'
import '../src/assets/css/styles.css'
import '../src/assets/js/scripts.js';

Vue.config.productionTip = false;
if (process.env === 'development') {
    Vue.config.devtools = true;
}


new Vue({
    router,
    store,
    render: (h) => h(App)
}).$mount('#app');
