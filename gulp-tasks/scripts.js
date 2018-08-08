var pkg = require('../package.json');
var gulp = require('gulp');
var colors = require('colors/safe');
var webpack = require('webpack');
var gulpWebpack = require('gulp-webpack');
const path = require('path');

let pathToScripts = path.resolve(pkg.config.jsPath);
let pathToScriptsDest = path.resolve(pkg.config.jsDest);

let webpackConfig = {
    entry: pathToScripts + '/app.js',
    output: {
        path: pathToScriptsDest,
        filename: 'app.js',
        sourceMapFilename: '[file].map'
    },
    devtool: 'source-map',
    module: {
        rules: [
            {
                test: /\.js$/,
                loader: 'babel-loader',
                exclude: /node_modules/,
                options: {
                    presets: ['es2015']
                }
            }
        ]
    },
    plugins: [
        new webpack.ProvidePlugin({
            $: 'jquery', // Used for Bootstrap JavaScript components
            jQuery: 'jquery', // Used for Bootstrap JavaScript components
            Popper: ['popper.js', 'default'], // Used for Bootstrap dropdown, popup and tooltip JavaScript components
            Alert: 'exports-loader?Alert!bootstrap/js/dist/alert',
            Button: 'exports-loader?Button!bootstrap/js/dist/button',
            Carousel: 'exports-loader?Carousel!bootstrap/js/dist/carousel',
            Collapse: 'exports-loader?Collapse!bootstrap/js/dist/collapse',
            Dropdown: 'exports-loader?Dropdown!bootstrap/js/dist/dropdown',
            Modal: 'exports-loader?Modal!bootstrap/js/dist/modal',
            Popover: 'exports-loader?Popover!bootstrap/js/dist/popover',
            Scrollspy: 'exports-loader?Scrollspy!bootstrap/js/dist/scrollspy',
            Tab: 'exports-loader?Tab!bootstrap/js/dist/tab',
            Tooltip: 'exports-loader?Tooltip!bootstrap/js/dist/tooltip',
            Util: 'exports-loader?Util!bootstrap/js/dist/util'
        }),
        new webpack.DefinePlugin({
            'process.env.NODE_ENV': JSON.stringify('production')
        }),
        new webpack.LoaderOptionsPlugin({
            minimize: true,
            debug: false
        }),
        new webpack.optimize.UglifyJsPlugin({
            sourceMap: true,
            beautify: false,
            mangle: {
                screw_ie8: true,
                keep_fnames: true
            },
            compress: {
                screw_ie8: true
            },
            comments: false
        })
    ]
};

const handleError = function(err) {
    console.error('---------------------------');
    console.error(colors.red.bold('ERROR Building JS Bundle!'));
    console.error(colors.red(err.message));
    console.error('---------------------------');

    this.emit('end');
};

function buildWithWebpack(done) {
    return gulp
        .src(pkg.config.jsPath + '/app.js')
        .pipe(gulpWebpack(webpackConfig, webpack, done))
        .pipe(gulp.dest(pkg.config.jsDest))
        .on('error', handleError);
}

const build = function(done) {
    buildWithWebpack(done);
};

module.exports = { build };
