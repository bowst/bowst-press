var pkg = require('../package.json');
var gulp = require('gulp');
var concat = require('gulp-concat');
var uglify = require('gulp-uglify');
var sourcemaps = require('gulp-sourcemaps');

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

function buildCustom() {
    return gulp
        .src([pkg.config.jsPath + '/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest(pkg.config.jsDest));
}

const build = function() {
    buildVendor();
    buildCustom();
};

module.exports = { build };
