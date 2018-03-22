var gulp = require('gulp');
var sass = require('gulp-sass');
var install = require('gulp-install');
var concat = require('gulp-concat');
var minify = require('gulp-minify-css');
var merge = require('merge-stream');
var uglify = require('gulp-uglify');
var autoprefixer = require('gulp-autoprefixer');
var sourcemaps = require('gulp-sourcemaps');
var browserSync = require('browser-sync');
var packageJSON = require('./package.json');

var config = {
    sassPath: './src/sass',
    jsPath: './src/js',
    npmPath: './node_modules'
};

// Fetch command line arguments
const arg = (argList => {
    let arg = {},
        a,
        opt,
        thisOpt,
        curOpt;
    for (a = 0; a < argList.length; a++) {
        thisOpt = argList[a].trim();
        opt = thisOpt.replace(/^\-+/, '');

        if (opt === thisOpt) {
            // argument value
            if (curOpt) arg[curOpt] = opt;
            curOpt = null;
        } else {
            // argument name
            curOpt = opt;
            arg[curOpt] = true;
        }
    }

    return arg;
})(process.argv);

gulp.task('npm', function() {
    return gulp.src(['./package.json']).pipe(install());
});

gulp.task('browser-sync', function() {
    if (arg.url) {
        browserSync({
            proxy: {
                target: arg.url
            },
            reloadDelay: 1000
        });
    }
});

gulp.task('bs-reload', function() {
    browserSync.reload();
});

gulp.task('css', function() {
    var sassStream, cssStream;

    // Compile CSS files
    cssStream = gulp.src([
        // node module & plugin CSS files (NOT sass) can go here
    ]);

    // Compile Sass
    sassStream = gulp
        .src(config.sassPath + '/globals.scss')
        .pipe(sourcemaps.init())
        .pipe(
            sass({
                errLogTOConsole: true
            })
        );

    // Merge style streams and concatenate their contents into single file
    return merge(cssStream, sassStream)
        .pipe(sourcemaps.init())
        .pipe(
            autoprefixer({
                browsers: packageJSON.browserslist,
                cascade: false
            })
        )
        .pipe(concat('globals.css'))
        .pipe(minify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/css'))
        .pipe(
            browserSync.reload({
                stream: true
            })
        );
});

gulp.task('vendor.js', function() {
    return gulp
        .src([
            config.npmPath + '/popper.js/dist/umd/popper.js',
            config.npmPath + '/bootstrap/dist/js/bootstrap.js'
        ])
        .pipe(concat('vendor.js'))
        .pipe(uglify())
        .pipe(gulp.dest('./public/js'));
});

gulp.task('scripts.js', function() {
    return gulp
        .src([config.jsPath + '/*.js'])
        .pipe(sourcemaps.init())
        .pipe(concat('scripts.js'))
        .pipe(uglify())
        .pipe(sourcemaps.write('.'))
        .pipe(gulp.dest('./public/js'))
        .pipe(
            browserSync.reload({
                stream: true
            })
        );
});

gulp.task('watch', ['npm', 'css', 'vendor.js', 'scripts.js', 'browser-sync'], function() {
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
    gulp.watch(config.jsPath + '/*.js', ['scripts.js']);
});

gulp.task('watch-css', ['css', 'browser-sync'], function() {
    gulp.watch(config.sassPath + '/**/*.scss', ['css']);
});

gulp.task('default', ['watch']);
