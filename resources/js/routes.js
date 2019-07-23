export default [
    {
        path        : '/' ,
        component   : require('./views/RootView').default,
        name        : 'root'
    },
    {
        path        : '/boards',
        component   : require('./views/Board/BoardsView').default,
        name        : 'boards'
    },
    {
        path        : '/board/:id' ,
        component   : require('./views/Board/BoardView').default,
        name        : 'board',
        props       : true
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