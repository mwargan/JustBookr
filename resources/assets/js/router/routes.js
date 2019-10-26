export default [
    { path: '/', name: 'welcome', component: require('~/pages/welcome').default },
  // Authenticated routes.
    ...middleware('auth', [
        { path: '/home', name: 'home', redirect: { name: 'profile.community' } },
        { path: '/sell/:isbn?', name: 'sell', component: require('~/pages/sell').default },
        //{ path: '/posts', name: 'posts', component: require('~/pages/posts').default },
        { path: '/business/home', name: 'business.home', component: require('~/pages/business/home').default },
        { path: '/business/create', name: 'business.create', component: require('~/pages/business/create').default },
        { path: '/stand/create', name: 'stand.create', component: require('~/pages/business/stands/create').default },
        { path: '/business/admin/:id/stands/', name: 'business.stands', component: require('~/pages/business/stands').default },
        { path: '/stand/:stand_id/add-books', name: 'stand.addBook', component: require('~/pages/addBook').default },

        {
            path: '/settings',
            component: require('~/pages/settings/index').default,
            children: [
                { path: '', redirect: { name: 'settings.profile' } },
                { path: 'profile', name: 'settings.profile', component: require('~/pages/settings/profile').default },
                { path: 'university', name: 'settings.university', component: require('~/pages/settings/university').default },
                { path: 'payment', name: 'settings.payment', component: require('~/pages/settings/payment').default },
                { path: 'password', name: 'settings.password', component: require('~/pages/settings/password').default },
                { path: 'authorized-apps', name: 'settings.applications', component: require('~/pages/settings/authorizedApplications').default },
                { path: 'developer', name: 'settings.developer', component: require('~/pages/settings/developer').default },
                { path: 'privacy', name: 'settings.privacy', component: require('~/pages/settings/privacy').default },
            ]
        },
        {
            path: '/',
            component: require('~/pages/profile/posts').default,
            children: [
                { path: '', redirect: { name: 'profile.community' } },
                { path: 'discover', name: 'profile.community', component: require('~/pages/profile/community').default },
                { path: 'your-textbooks', name: 'profile.my-textbooks', component: require('~/pages/profile/my-textbooks').default },
                { path: 'inbox', name: 'profile.inbox', component: require('~/pages/profile/inbox').default }
            ]
        },
        { path: '/post/:id', name: 'post', component: require('~/pages/post/index').default },
        { path: '/post/:id/buy', name: 'post.buy', component: require('~/pages/post/buy').default },

        ...middleware('admin', [{
            path: '/data',
            component: require('~/pages/data/index').default,
            children: [
                { path: '', redirect: { name: 'data.users' } },
                { path: 'users', name: 'data.users', component: require('~/pages/data/users').default },
                { path: 'posts', name: 'data.posts', component: require('~/pages/data/posts').default },
                { path: 'stats', name: 'data.stats', component: require('~/pages/data/stats').default }
            ]
        }, ])
        // { path: '/example', name: 'example', component: require('~/pages/example'), middleware: ['admin'] },
    ]),
    //{ path: '/about', name: 'about', component: require('~/pages/about') },

    { path: '/your-university', name: 'profile.university', component: require('~/pages/university.vue').default },

    { path: '/terms-and-conditions', name: 'toc', component: require('~/pages/toc').default },

    { path: '/faq', name: 'faq', component: require('~/pages/faq').default },
    { path: '/find/:query?', name: 'find', component: require('~/pages/find').default },
    //{ path: '/+', name: 'plus', component: require('~/pages/plus') },
    { path: '/business', name: 'business', component: require('~/pages/business').default },
    { path: '/stand/:stand_id', name: 'business.stands.single', component: require('~/pages/business/stands/single').default },

    {
        path: '/textbook/:isbn',
        component: require('~/pages/book/index').default,
        children: [
            { path: '', redirect: { name: 'textbook.posts' } },
            { path: 'posts', name: 'textbook.posts', component: require('~/pages/book/posts').default },
            { path: 'info', name: 'textbook.info', component: require('~/pages/book/info').default }
        ]
    },
    {
        path: '/country/:iso',
        component: require('~/pages/country/index').default,
        children: [
            { path: '', redirect: { name: 'country.universities' } },
            { path: 'universities', name: 'country.universities', component: require('~/pages/country/universities').default },
            { path: 'info', name: 'country.info', component: require('~/pages/country/info').default }
        ]
    },
    {
        path: '/university/:id',
        component: require('~/pages/universities/index').default,
        children: [
            { path: '', redirect: { name: 'universities.textbooks' } },
            { path: 'students', name: 'universities.users', component: require('~/pages/universities/users').default },
            { path: 'textbooks', name: 'universities.textbooks', component: require('~/pages/universities/textbooks').default },
            { path: 'info', name: 'universities.info', component: require('~/pages/universities/info').default }
        ]
    },
    {
        path: '/business/:id',
        component: require('~/pages/businesses/index').default,
        children: [
            { path: '', redirect: { name: 'businesses.info' } },
            { path: 'students', name: 'businesses.users', component: require('~/pages/businesses/users').default },
            { path: 'stands', name: 'businesses.stands', component: require('~/pages/businesses/stands').default },
            { path: 'info', name: 'businesses.info', component: require('~/pages/businesses/info').default }
        ]
    },
    {
        path: '/user/:id',
        component: require('~/pages/user/index').default,
        children: [
            { path: '', redirect: { name: 'profile.textbooks' } },
            { path: 'books', name: 'profile.textbooks', component: require('~/pages/user/textbooks').default },
        ]
    },
    // Guest routes.
    ...middleware('guest', [
        { path: '/login', name: 'login', component: require('~/pages/auth/login').default },
        { path: '/register', redirect: { name: 'register' } },
        { path: '/sign-up', name: 'register', component: require('~/pages/auth/register').default },
        { path: '/password/reset', name: 'password.request', component: require('~/pages/auth/password/email').default },
        { path: '/password/reset/:token', name: 'password.reset', component: require('~/pages/auth/password/reset').default }
    ]),

    { path: '*', component: require('~/pages/errors/404.vue').default }
]

/**
 * @param  {String|Function} middleware
 * @param  {Array} routes
 * @return {Array}
 */
function middleware(middleware, routes) {
    routes.forEach(route =>
        (route.middleware || (route.middleware = [])).unshift(middleware)
    )

    return routes
}