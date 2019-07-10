require('./bootstrap');

import router       from './router'
import Navigator    from './components/Navigator/Navigator'

new Vue({
    el          :   '#app',
    router      : router,
    components  : {
        'navigator' : Navigator
    }
});