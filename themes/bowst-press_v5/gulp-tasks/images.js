var pkg = require('../package.json');
var gulp = require('gulp');
var changed = require('gulp-changed');
var imagemin = require('gulp-imagemin');

const minify = function(){
    return gulp.src(`${pkg.config.images}/source/**/*.{svg,png,gif,jpg,jpeg}`)
        .pipe(changed(pkg.config.images))
        .pipe(imagemin({ optimizationLevel: 7 }))
        .pipe(gulp.dest(pkg.config.images));
}

module.exports = { minify }
