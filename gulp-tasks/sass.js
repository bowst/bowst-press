var pkg = require('../package.json');
var gulp = require('gulp');
var sass = require('gulp-sass');
var postcss = require('gulp-postcss');
var autoprefixer = require('autoprefixer');
var pxtorem = require('postcss-pxtorem');
var mqpacker = require('css-mqpacker');
var uniqueSelectors = require('postcss-unique-selectors');
var sourcemaps = require('gulp-sourcemaps');
var minify = require('gulp-minify-css');
var concat = require('gulp-concat');
var merge = require('merge-stream');

const streamToBrowserSync = require('./browser-sync').stream;

const sassOptions = {
    includePaths: [pkg.config.sassPath, pkg.config.npmPath],
    errLogToConsole: true,
};

const autoprefixerOptions = {
    expand: true,
    flatten: true,
    browsers: [
        'last 1 major version',
        '>= 1%',
        'Chrome >= 45',
        'Firefox >= 38',
        'Edge >= 12',
        'Explorer >= 10',
        'iOS >= 9',
        'Safari >= 9',
        'Android >= 4.4',
        'Opera >= 30',
    ],
};

const pxToRemOptions = {
    propWhiteList: [
        'font',
        'font-size',
        'line-height',
        'letter-spacing',
        'margin',
        'margin-top',
        'margin-right',
        'margin-bottom',
        'margin-left',
        'padding',
        'padding-top',
        'padding-right',
        'padding-bottom',
        'padding-left',
    ],
};

const mqpackerOptions = {
    sort: true,
};

const build = function() {
    var cssStream, sassStream;

    // Compile CSS files
    cssStream = gulp.src([
        // node module & plugin CSS files (NOT sass) can go here
    ]);

    // Compile Sass
    sassStream = gulp
        .src(pkg.config.sassPath + '/**/*.scss')
        .pipe(sourcemaps.init())
        .pipe(
            sass(sassOptions).on('error', function(err) {
                console.error(err.message);
                this.emit('end');
            })
        )
        .pipe(
            postcss([
                autoprefixer(autoprefixerOptions),
                pxtorem(pxToRemOptions),
                mqpacker(mqpackerOptions),
                uniqueSelectors(),
            ])
        );

    return merge(cssStream, sassStream)
        .pipe(sourcemaps.init())
        .pipe(concat('globals.css'))
        .pipe(minify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(pkg.config.cssPath))
        .pipe(streamToBrowserSync());
};

module.exports = { build };
