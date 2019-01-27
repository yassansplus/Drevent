var gulp = require('gulp'),
    compass =  require('gulp-compass'),
    cleanCSS = require('gulp-clean-css'),
    sass = require('gulp-sass'),
    plumber = require('gulp-plumber'),
    babel = require('gulp-babel'),
    browserSync = require('browser-sync'),
    sourcemaps = require('gulp-sourcemaps')

gulp.task('browser-sync', function() {
    browserSync.init({
        proxy: "http://127.0.0.1:8000"

    });
});




gulp.task('sass', function () {
    return gulp.src(['sass/**/**/*.scss'])
        .pipe(sourcemaps.init())
        .pipe(sass().on('error', sass.logError))
        .pipe(cleanCSS({compatibility: 'ie8'}))
        .pipe(sourcemaps.write())
        .pipe(gulp.dest('../assets/css/'))
        .pipe(browserSync.reload({
            stream: true
        }));
});

gulp.task('js', function () {
    return gulp.src('js/**/*.js')
        .pipe(plumber())
        .pipe(gulp.dest('../assets/js/'))
        .pipe(browserSync.reload({
            stream: true
        }));
});

gulp.task('default',['browser-sync'], function () {
    gulp.watch('sass/**/**/*.scss',['sass']);
    gulp.watch('js/**/*.js',['js']);
    gulp.watch('../../**/*.html.twig', browserSync.reload);
});

gulp.task('build', ['sass','js']);