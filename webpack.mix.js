const mix = require('laravel-mix');

// see https://github.com/tomaszbujnowicz/laravel-mix-tailwindcss-purgecss/blob/master/webpack.mix.js
require('laravel-mix-eslint');

mix
    // This is required for hot reloading
    .setPublicPath('./public')

    .postCss('resources/css/app.css', 'public/css/app.css',[
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



/*
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
.react('src/js/app.js', 'dist/js').sourceMaps()
.extract(['react', 'react-dom'])

.sass('src/scss/app.scss', 'dist/css')
//    .options({
//        processCssUrls: false,
//        postCss: [ tailwindcss('./tailwind.js') ],
//   })
.tailwind().sourceMaps();
*/

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |


mix.js('resources/js/app.js', 'public/js').postCss('resources/css/app.css', 'public/css', [
    require('postcss-import'),
    require('tailwindcss'),
    require('autoprefixer'),
]);
*/