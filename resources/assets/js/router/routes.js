export default [
    { path: '/', name: 'welcome', component: require('~/pages/welcome') },
  // Authenticated routes.
    ...middleware('auth', [
        { path: '/home', name: 'home', redirect: { name: 'profile.community' } },
        { path: '/sell/:isbn?', name: 'sell', component: require('~/pages/sell') },
        //{ path: '/posts', name: 'posts', component: require('~/pages/posts') },
        { path: '/business/home', name: 'business.home', component: require('~/pages/business/home') },
        { path: '/business/create', name: 'business.create', component: require('~/pages/business/create') },
        { path: '/stand/create', name: 'stand.create', component: require('~/pages/business/stands/create') },
        { path: '/business/admin/:id/stands/', name: 'business.stands', component: require('~/pages/business/stands') },
        { path: '/stand/:stand_id/add-books', name: 'stand.addBook', component: require('~/pages/addBook') },

        {
            path: '/settings',
            component: require('~/pages/settings/index'),
            children: [
                { path: '', redirect: { name: 'settings.profile' } },
                { path: 'profile', name: 'settings.profile', component: require('~/pages/settings/profile') },
                { path: 'university', name: 'settings.university', component: require('~/pages/settings/university') },
                { path: 'payment', name: 'settings.payment', component: require('~/pages/settings/payment') },
                { path: 'password', name: 'settings.password', component: require('~/pages/settings/password') },
                { path: 'authorized-apps', name: 'settings.applications', component: require('~/pages/settings/authorizedApplications') },
                { path: 'developer', name: 'settings.developer', component: require('~/pages/settings/developer') },
                { path: 'privacy', name: 'settings.privacy', component: require('~/pages/settings/privacy') },
            ]
        },
        {
            path: '/',
            component: require('~/pages/profile/posts'),
            children: [
                { path: '', redirect: { name: 'profile.community' } },
                { path: 'discover', name: 'profile.community', component: require('~/pages/profile/community') },
                { path: 'your-textbooks', name: 'profile.my-textbooks', component: require('~/pages/profile/my-textbooks') },
                { path: 'inbox', name: 'profile.inbox', component: require('~/pages/profile/inbox') }
            ]
        },
        { path: '/post/:id', name: 'post', component: require('~/pages/post/index') },
        { path: '/post/:id/buy', name: 'post.buy', component: require('~/pages/post/buy') },

        ...middleware('admin', [{
            path: '/data',
            component: require('~/pages/data/index'),
            children: [
                { path: '', redirect: { name: 'data.users' } },
                { path: 'users', name: 'data.users', component: require('~/pages/data/users') },
                { path: 'posts', name: 'data.posts', component: require('~/pages/data/posts') },
                { path: 'stats', name: 'data.stats', component: require('~/pages/data/stats') }
            ]
        }, ])
        // { path: '/example', name: 'example', component: require('~/pages/example'), middleware: ['admin'] },
    ]),
    //{ path: '/about', name: 'about', component: require('~/pages/about') },

    { path: '/your-university', name: 'profile.university', component: require('~/pages/university.vue') },

    { path: '/terms-and-conditions', name: 'toc', component: require('~/pages/toc') },
    { path: '/find/:query?', name: 'find', component: require('~/pages/find') },
    //{ path: '/+', name: 'plus', component: require('~/pages/plus') },
    { path: '/business', name: 'business', component: require('~/pages/business') },
    { path: '/stand/:stand_id', name: 'business.stands.single', component: require('~/pages/business/stands/single') },

    {
        path: '/textbook/:isbn',
        component: require('~/pages/book/index'),
        children: [
            { path: '', redirect: { name: 'textbook.posts' } },
            { path: 'posts', name: 'textbook.posts', component: require('~/pages/book/posts') },
            { path: 'info', name: 'textbook.info', component: require('~/pages/book/info') }
        ]
    },
    {
        path: '/country/:iso',
        component: require('~/pages/country/index'),
        children: [
            { path: '', redirect: { name: 'country.universities' } },
            { path: 'universities', name: 'country.universities', component: require('~/pages/country/universities') },
            { path: 'info', name: 'country.info', component: require('~/pages/country/info') }
        ]
    },
    {
        path: '/university/:id',
        component: require('~/pages/universities/index'),
        children: [
            { path: '', redirect: { name: 'universities.textbooks' } },
            { path: 'students', name: 'universities.users', component: require('~/pages/universities/users') },
            { path: 'textbooks', name: 'universities.textbooks', component: require('~/pages/universities/textbooks') },
            { path: 'info', name: 'universities.info', component: require('~/pages/universities/info') }
        ]
    },
    {
        path: '/business/:id',
        component: require('~/pages/businesses/index'),
        children: [
            { path: '', redirect: { name: 'businesses.info' } },
            { path: 'students', name: 'businesses.users', component: require('~/pages/businesses/users') },
            { path: 'stands', name: 'businesses.stands', component: require('~/pages/businesses/stands') },
            { path: 'info', name: 'businesses.info', component: require('~/pages/businesses/info') }
        ]
    },
    {
        path: '/user/:id',
        component: require('~/pages/user/index'),
        children: [
            { path: '', redirect: { name: 'profile.textbooks' } },
            { path: 'books', name: 'profile.textbooks', component: require('~/pages/user/textbooks') },
        ]
    },
    // Guest routes.
    ...middleware('guest', [
        { path: '/login', name: 'login', component: require('~/pages/auth/login') },
        { path: '/register', redirect: { name: 'register' } },
        { path: '/sign-up', name: 'register', component: require('~/pages/auth/register') },
        { path: '/password/reset', name: 'password.request', component: require('~/pages/auth/password/email') },
        { path: '/password/reset/:token', name: 'password.reset', component: require('~/pages/auth/password/reset') }
    ]),

    { path: '*', component: require('~/pages/errors/404.vue') }
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