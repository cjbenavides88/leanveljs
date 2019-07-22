export default [
    {
        path: '/' ,
        component: require('./views/RootView').default
    },
    {
        path: '/boards' ,
        component: require('./views/Board/BoardsView').default
    },
    // {
    //     path: '/dealers' ,
    //     component: require('./views/DealersView').default
    // },
    // {
    //     path: '/contact' ,
    //     component: require('./views/ContactView').default
    // },
];