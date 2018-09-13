const path = require('path')
const webpack = require('webpack')
const mix = require('laravel-mix')
//let SWPrecacheWebpackPlugin = require('sw-precache-webpack-plugin') //Our magic
const workboxPlugin = require('workbox-webpack-plugin')

// const { BundleAnalyzerPlugin } = require('webpack-bundle-analyzer')

mix
  .js('resources/assets/js/app.js', 'public/js')
  .sass('resources/assets/sass/app.scss', 'public/css')

  .sourceMaps()
  .disableNotifications()

if (mix.inProduction()) {
  mix.version()

  mix.extract([
    'vue',
    'vform',
    'axios',
    'vuex',
    'jquery',
    'popper.js',
    'vue-i18n',
    'vue-meta',
    'js-cookie',
    'bootstrap',
    'vue-router',
    'sweetalert2',
    'laravel-echo',
    'vue-analytics',
    'vue-lazyload',
    'pusher-js',
    'moment',
    'object-to-formdata',
    'vuex-router-sync',
    '@fortawesome/vue-fontawesome'
  ])

}

 mix.options({
      extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
      processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
      //purifyCss: true, // Remove unused CSS selectors.
      //uglify: {}, // Uglify-specific options. https://webpack.github.io/docs/list-of-plugins.html#uglifyjsplugin
      postCss: [require('autoprefixer')] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
    })

mix.webpackConfig({
  plugins: [
    // new BundleAnalyzerPlugin(),
    new webpack.ProvidePlugin({
      $: 'jquery',
      jQuery: 'jquery',
      'window.jQuery': 'jquery',
      Popper: ['popper.js', 'default']
    }),
    // new SWPrecacheWebpackPlugin({
    //     cacheId: 'pwa',
    //     filename: 'service-worker.js',
    //     staticFileGlobs: ['public/**/*.{css,eot,svg,ttf,woff,woff2,js,html}'],
    //     minify: true,
    //     stripPrefix: 'public/',
    //     handleFetch: true,
    //     dynamicUrlToDependencies: {
    //         '/': ['resources/views/index.blade.php']
    //     },
    //     staticFileGlobsIgnorePatterns: [/\.map$/, /mix-manifest\.json$/, /manifest\.json$/, /service-worker\.js$/],
    //     runtimeCaching: [
    //         {
    //             urlPattern: /^https:\/\/fonts\.googleapis\.com\//,
    //             handler: 'cacheFirst'
    //         }
    //     ]
    // })
    new workboxPlugin.GenerateSW({
        //  swSrc: './src/sw.js',
         swDest: path.join(`${__dirname}/public`, 'sw.js'),
         clientsClaim: true,
         skipWaiting: true,
         runtimeCaching: [
           {
             urlPattern: new RegExp(`https://justbookr.com`),
             handler: 'networkFirst',
             options: {
               cacheName: `JustBookr-${process.env.NODE_ENV}`
             }
           },
           {
          // Match any request ends with .png, .jpg, .jpeg or .svg.
          urlPattern: /\.(?:png|jpg|jpeg|svg)$/,

          // Apply a cache-first strategy.
          handler: 'cacheFirst'
        },
           {
             urlPattern: new RegExp('https://fonts.(googleapis|gstatic).com'),
             handler: 'cacheFirst',
             options: {
               cacheName: 'google-fonts'
             }
           }
         ],
         navigateFallback: '/https:\/\/justbookr.com/',
       }),
  ],
  resolve: {
    alias: {
      '~': path.join(__dirname, './resources/assets/js')
    }
  }
})
