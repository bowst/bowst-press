var gulp = require('gulp');
var sass = require('gulp-sass');
var install = require('gulp-install');
var concat = require('gulp-concat');
var minify = require('gulp-minify-css');
var merge = require('merge-stream');
var uglify = require('gulp-uglify');

var config = {
    sassPath: './src/sass',
    jsPath: './src/js',
    npmPath: './node_modules'
};

gulp.task('npm', function() {
    return gulp.src(['./package.json']).pipe(install());
});

gulp.task('css', function() {
    var sassStream, cssStream;

    // Compile CSS files
    cssStream = gulp.src([
        // node module & plugin CSS files (NOT sass) can go here
    ]);

    // Compile Sass
    sassStream = gulp.src(config.sassPath + '/globals.scss').pipe(
        sass({
            errLogTOConsole: true
        })
    );

    // Merge style streams and concatenate their contents into single file
    return merge(cssStream, sassStream)
        .pipe(concat('globals.css'))
        .pipe(minify())
        .pipe(gulp.dest('./public/css'));
});

gulp.task('vendor.js', function() {
    return gulp
        .src([config.npmPath + '/bootstrap-sass/assets/javascripts/bootstrap.js'])
        .pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('scripts.js', function() {
    return gulp
        .src([config.jsPath + '/*.js'])
        .pipe(concat('scripts.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('watch', ['npm', 'css', 'vendor.js', 'scripts.js'], function() {
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
    gulp.watch(config.jsPath + '/*.js', ['scripts.js']);
});

gulp.task('default', ['watch']);
