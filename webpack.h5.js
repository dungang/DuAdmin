let mix = require('laravel-mix');
let del = require('del');
let MomentLocalesPlugin = require('moment-locales-webpack-plugin');
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for your application, as well as bundling up your JS files.
 |
 */
mix.webpackConfig({
    module: {
        rules: [
            {
                test: /\.less$/,
                use: [
                    // ...其他 loader 配置
                    {
                        loader: 'less-loader',
                        options: {
                            // 若使用 less-loader@5，请移除 lessOptions 这一级，直接配置选项。
                            lessOptions: {
                                modifyVars: {
                                    // 直接覆盖变量
                                    'text-color': '#111',
                                    'border-color': '#eee',
                                    'blue': '#ee0a24',
                                    // 或者可以通过 less 文件覆盖（文件路径为绝对路径）
                                    // hack: `true; @import "your-less-file-path.less";`,
                                },
                            },
                        },
                    },
                ],
            },
        ],
    },
    plugins: [
        new MomentLocalesPlugin({
            localesToKeep: ['es-us', 'zh-cn'],
        }),
    ]
})
    .options({
        processCssUrls: false,
        postCss: [
            //require('postcss-px-to-viewport'),
            require('postcss-pxtorem')({
                rootValue: 37.5,
                propList: ['*'],
            })
        ]
    })
    .extract([
        'vue', 'vue-router', 'axios', 'qs', 'vuex', 'moment'
    ])
    // 供求模块
    .js('addons/gq/H5/src/main.js', 'addons/gq/H5/dist')
    // 淘客首页
    // .js('addons/tbk/h5/src/main.js', 'addons/tbk/h5/dist')
    // 淘客会员
    // .js('addons/tbk/h5/src/storehouse.js', 'addons/tbk/h5/dist')
    .then(function () {
        del(['public/assets/*']);
    });
//mix.js('src/app.js', 'dist/').sass('src/app.scss', 'dist/');

// Full API
// mix.js(src, output);
// mix.react(src, output); <-- Identical to mix.js(), but registers React Babel compilation.
// mix.preact(src, output); <-- Identical to mix.js(), but registers Preact compilation.
// mix.coffee(src, output); <-- Identical to mix.js(), but registers CoffeeScript compilation.
// mix.ts(src, output); <-- TypeScript support. Requires tsconfig.json to exist in the same folder as webpack.mix.js
// mix.extract(vendorLibs);
// mix.sass(src, output);
// mix.less(src, output);
// mix.stylus(src, output);
// mix.postCss(src, output, [require('postcss-some-plugin')()]);
// mix.browserSync('my-site.test');
// mix.combine(files, destination);
// mix.babel(files, destination); <-- Identical to mix.combine(), but also includes Babel compilation.
// mix.copy(from, to);
// mix.copyDirectory(fromDir, toDir);
// mix.minify(file);
// mix.sourceMaps(); // Enable sourcemaps
// mix.version(); // Enable versioning.
// mix.disableNotifications();
// mix.setPublicPath('path/to/public');
// mix.setResourceRoot('prefix/for/resource/locators');
// mix.autoload({}); <-- Will be passed to Webpack's ProvidePlugin.
// mix.webpackConfig({}); <-- Override webpack.config.js, without editing the file directly.
// mix.babelConfig({}); <-- Merge extra Babel configuration (plugins, etc.) with Mix's default.
// mix.then(function () {}) <-- Will be triggered each time Webpack finishes building.
// mix.override(function (webpackConfig) {}) <-- Will be triggered once the webpack config object has been fully generated by Mix.
// mix.dump(); <-- Dump the generated webpack config object to the console.
// mix.extend(name, handler) <-- Extend Mix's API with your own components.
// mix.options({
//   extractVueStyles: false, // Extract .vue component styling to file, rather than inline.
//   globalVueStyles: file, // Variables file to be imported in every component.
//   processCssUrls: true, // Process/optimize relative stylesheet url()'s. Set to false, if you don't want them touched.
//   purifyCss: false, // Remove unused CSS selectors.
//   terser: {}, // Terser-specific options. https://github.com/webpack-contrib/terser-webpack-plugin#options
//   postCss: [] // Post-CSS options: https://github.com/postcss/postcss/blob/master/docs/plugins.md
// });
