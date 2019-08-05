


import Vue from 'vue';
window.Vue = Vue;

import VueRouter from 'vue-router';
Vue.use(VueRouter);

// import BootstrapVue from 'bootstrap-vue';
// Vue.use(BootstrapVue)
/**
 * Event Bus to communicate components globally
 */
const EventBus = new Vue();
Object.defineProperties(Vue.prototype, {
    $bus: {
        get: function () {
            return EventBus
        }
    }
});
Vue.use(EventBus);


/**
 * We'll load jQuery and the Bootstrap jQuery plugin which provides support
 * for JavaScript based Bootstrap features such as modals and tabs. This
 * code may be modified to fit the specific needs of your application.
 */

try {

    window.$ = window.jQuery = require('jquery');
    window.Popper = require('popper.js').default;
    window._ = require('lodash');
    window.moment = require('moment');
    require('bootstrap');
    require('jquery-toast-plugin');
    // window.swal     = require('sweetalert2');
    window.Velocity = require('velocity-animate');
} catch (e) {}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';


/**
 * AXIOS INTERCEPTORS
 */
axios.interceptors.response.use(function(response){
        if( response.config.hasOwnProperty('responseHandle')) {
            if( response.config.responseHandle === false ){
                return response;
            }else if(response.config.responseHandle === true){
                let data = response.data;
                if(data.error === "1"){
                    $.toast({
                        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        heading: 'Error',
                        text: data.payload.error_msg,
                        icon: 'error',
                    })
                }else{
                    $.toast({
                        hideAfter: 3000, // false to make it sticky or number representing the miliseconds as time after which toast needs to be hidden
                        heading: 'Success',
                        text: data.payload.error_msg,
                        icon: 'success',
                    })
                }
            }

        }
        return response;
    },
    function(error) {

        if( error.config.hasOwnProperty('errorHandle')) {
            if( error.config.errorHandle === false ){
                return Promise.reject(error)
            }else if(error.config.errorHandle === true){
                let resp = error.response;
                if ( resp.status > 400 && resp.status < 500 ) {
                    console.log(resp);
                    let errors = [];
                    for (let i in resp.data.errors) {
                        errors.push(resp.data.errors[i]);
                    }

                    $.toast({
                        hideAfter: 6000,
                        heading: 'Information',
                        text: errors,
                        icon: 'error',
                        showHideTransition: 'slide'
                    })
                }
            }else{
                return Promise.reject(error)
            }
        }
        return Promise.reject(error)
    });



/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo'

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     encrypted: true
// });

import twemoji from 'twemoji';
Vue.directive('emoji', {
    inserted (el) {
        el.innerHTML = twemoji.parse(el.innerHTML,{
            className   : 'v-emoji',
            // folder      : 'svg',
            // ext         : '.svg'
        })
    }
});


