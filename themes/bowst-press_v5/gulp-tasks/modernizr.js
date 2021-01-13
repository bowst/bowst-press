var pkg = require('../package.json');
var gulp = require('gulp');
var modernizr = require('gulp-modernizr');

const modernizrOptions = {
    cache: false,
    devFile: `${pkg.config.jsDest}/libraries/modernizr.js`,
    dest: `${pkg.config.jsDest}/libraries/modernizr-custom.js`,

    // Based on default settings on http://modernizr.com/download/
    options: ['addtest', 'classes', 'html5printshiv', 'html5shiv', 'load', 'mq', 'setClasses'],

    // Define any tests you want to implicitly include.
    tests: ['rgba'],

    crawl: false
};

module.exports = function() {
    return gulp
        .src([`${pkg.config.sassPath}/**/*.{css,scss}`, `${pkg.config.jsPath}/**/*.js`])
        .pipe(modernizr(modernizrOptions))
        .pipe(gulp.dest(`${pkg.config.jsDest}/libraries`));
};
