const mix = require('laravel-mix');

// see https://github.com/tomaszbujnowicz/laravel-mix-tailwindcss-purgecss/blob/master/webpack.mix.js
require('laravel-mix-eslint');

mix
    // This is required for hot reloading
    .setPublicPath('./public')

    .postCss('resources/css/app.css', './public/vendor/suilven/flickr-editor/css/app.css',[
        require('postcss-import'),
        require('tailwindcss'),
        require('postcss-nested'),
    ])

    .options({
        processCssUrls: false,
        terser: {
            extractComments: false, // Stop Mix from generating license file
        }
    })




// Add eslint to .jsx, .js and .vue files
.webpackConfig({
    module: {
        rules: [
            {
                test: /\.(jsx|js|vue)$/,
                loader: 'eslint-loader',
                enforce: 'pre',
                exclude: /(node_modules)/,
                options: {
                    formatter: require('eslint-friendly-formatter')
                }
            }
        ]
    },
})
    .js('resources/flickr-edit-app/src/index.js', './public/suilven/flickr-editor/js').options({
        terser: {
            terserOptions: {
                compress: {
                    drop_console: false
                }
            }
        }
    }) //.sourceMaps()
.react()
   .extract()

// for dev
    .copy('./public/vendor/suilven/flickr-editor/css/app.css', '/var/www/app/public/vendor/suilven/flickr-editor/css/app.css')
   // .copy('./public/vendor/suilven/flickr-editor/css/app.css.map', '/var/www/app/public/vendor/suilven/flickr-editor/css/app.css.map')
    .copy('./public/suilven/flickr-editor/js/index.js', '/var/www/app/public/vendor/suilven/flickr-editor/js/index.js')
   // .copy('./public/suilven/flickr-editor/js/index.js.map', '/var/www/app/public/vendor/suilven/flickr-editor/js/index.js.map')
   .copy('./public/suilven/flickr-editor/js/vendor.js', '/var/www/app/public/vendor/suilven/flickr-editor/js/vendor.js')
//    .copy('./public/suilven/flickr-editor/js/vendor.js.map', '/var/www/app/public/vendor/suilven/flickr-editor/js/vendor.js.map')
    .copy('./public/suilven/flickr-editor/js/manifest.js', '/var/www/app/public/vendor/suilven/flickr-editor/js/manifest.js')
