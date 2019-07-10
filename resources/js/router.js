import VueRouter from 'vue-router';
import routes from './routes';
export default new VueRouter({
    routes,
    //mode: 'history',
    linkActiveClass :   'is-active',
    linkExactActiveClass  :   'is-active'
});