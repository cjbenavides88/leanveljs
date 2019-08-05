export default [
    {
        path        : '/' ,
        component   : require('./views/RootView').default,
        name        : 'root'
    },
    {
        path        : '/profile',
        component   : require('./views/Profile/ProfileView').default,
        name        : 'profile',
        children    : [

        ]
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