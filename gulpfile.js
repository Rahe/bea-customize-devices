/*Load all plugin define in package.json*/
var gulp = require('gulp'),
	gulpLoadPlugins = require('gulp-load-plugins'),
	plugins = gulpLoadPlugins(),
	sourcemaps = require('gulp-sourcemaps');

/*JS task*/
gulp.task('dist', function () {
	gulp.src([ 'assets/js/admin.js' ])
		.pipe(plugins.jshint())
		.pipe(plugins.uglify())
		.pipe(sourcemaps.init({loadMaps: true}))
		.pipe(sourcemaps.write())
		.pipe(plugins.concat('admin.min.js'))
		.pipe(gulp.dest('assets/js/'));

	return gulp.src([ 'assets/css/admin.css' ])
		.pipe(plugins.uglifycss())
		.pipe(plugins.concat('admin.min.css'))
		.pipe(gulp.dest('assets/css/'));
});

gulp.task('check-js', function () {
	return gulp.src('assets/js/admin.js')
		.pipe(plugins.jshint())
		.pipe(plugins.jshint.reporter('default'));
});

// On default task, just compile on demand
gulp.task('default', function() {
	gulp.watch('assets/js/*.js', [ 'check-js']);
});