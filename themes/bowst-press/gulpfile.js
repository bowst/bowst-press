var pkg = require('./package.json');
var gulp = require('gulp');
var watch = require('gulp-watch');
var install = require('gulp-install');

const BrowserSync = require('./gulp-tasks/browser-sync');
const streamToBrowserSync = require('./gulp-tasks/browser-sync').stream;
const Modernizr = require('./gulp-tasks/modernizr');
const Images = require('./gulp-tasks/images');
const Scripts = require('./gulp-tasks/scripts');
const Sass = require('./gulp-tasks/sass');

gulp.task('npm', function() {
    return gulp.src(['./package.json']).pipe(install());
});

gulp.task('sass', Sass.build);

gulp.task('js', Scripts.build);
gulp.task('js-watch', ['js'], BrowserSync.reload);

gulp.task('modernizr', Modernizr);

gulp.task('browser-sync-init', BrowserSync.initialize);
gulp.task('reload-watch', BrowserSync.reload);

gulp.task('watch', ['npm', 'sass', 'js', 'browser-sync-init'], function() {
    gulp.watch(pkg.config.sassPath + '/**/*.scss', ['sass']);
    gulp.watch(pkg.config.jsPath + '/**/*.js', ['js-watch']);

    //Using gulp-watch instead of gulp.watch because it will catch NEW files
    watch(pkg.config.images + '/source/**/*.*', Images.minify);
    watch(pkg.config.images + '/*.*', function() {
        try {
            BrowserSync.reload();
        } catch (err) {
            //don't care!
        }
    });

    gulp.watch(
        ['./**/*.php', pkg.config.jsDest + '/libraries/modernizr-custom.js'],
        ['reload-watch']
    );
});

gulp.task('build', ['npm', 'sass', 'js', 'modernizr'], function() {
    gulp.watch(pkg.config.sassPath + '/**/*.scss', ['sass']);
});

gulp.task('watch-css', ['sass', 'browser-sync-init'], function() {
    gulp.watch(pkg.config.sassPath + '/**/*.scss', ['sass']);
});

gulp.task('default', ['watch']);
