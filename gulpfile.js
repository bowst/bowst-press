var gulp 		= require('gulp'),
	pump 		= require('pump'),
	sass 		= require('gulp-sass'),
	cssmin 		= require('gulp-cssmin'),
	concat 		= require('gulp-concat'),
	uglify  	= require('gulp-uglify'),
	livereload  = require('gulp-livereload');

// Paths variables
var paths = {
  'dev': {
    'sass': './src/sass/',
    'js': './src/js/'
  },
  'assets': {
    'css': './public/css/',
    'js': './public/js/'
  }

};

gulp.task('globals.css', function(){
	return gulp.src(paths.dev.sass + 'globals.scss')
		.pipe(sass())
		.pipe(cssmin())
		.pipe(gulp.dest(paths.assets.css))
		.pipe(livereload());
});

gulp.task('scripts.js', function (cb) {
	pump([
        gulp.src([
			'src/js/*.js'
    	])
    	.pipe(concat('scripts.js')),
        uglify(),
        gulp.dest(paths.assets.js)
    ],
    cb
  );
});

gulp.task('build', ['globals.css', 'scripts.js']);

gulp.task('watch', function(){
	livereload.listen();
	gulp.watch(paths.dev.sass + '**/*.scss', ['globals.css']);
	gulp.watch(paths.dev.js + '*.js', ['scripts.js']);
});
