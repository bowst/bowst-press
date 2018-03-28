var pkg = require('../package.json');
var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var colors = require('colors/safe');
var webpack = require('webpack');
var gulpWebpack = require('gulp-webpack');
const path = require('path');

let pathToScripts = path.resolve(pkg.config.jsPath);
let pathToScriptsDest = path.resolve(pkg.config.jsDest);

let webpackConfig = {
    entry: pathToScripts + '/main.js',
    output: {
        path: pathToScriptsDest,
        filename: 'main.js',
        sourceMapFilename: '[name].js.map'
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

function buildVendor() {
    return gulp
        .src([
            pkg.config.npmPath + '/popper.js/dist/umd/popper.js',
            pkg.config.npmPath + '/bootstrap/dist/js/bootstrap.js',
            pkg.config.npmPath + '/@fortawesome/fontawesome/index.js',
            pkg.config.npmPath + '/@fortawesome/fontawesome-free-regular/index.js',
            pkg.config.npmPath + '/@fortawesome/fontawesome-free-solid/index.js',
            pkg.config.npmPath + '/@fortawesome/fontawesome-free-brands/index.js'
        ])
        .pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest(pkg.config.jsDest));
}

function buildWithWebpack(done) {
    return gulp
        .src(pkg.config.jsPath + '/main.js')
        .pipe(gulpWebpack(webpackConfig, webpack, done))
        .pipe(gulp.dest(pkg.config.jsDest))
        .on('error', handleError);
}

const build = function(done) {
    buildVendor();
    buildWithWebpack(done);
};

module.exports = { build };
