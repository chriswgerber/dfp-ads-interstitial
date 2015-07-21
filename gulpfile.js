/*
 * Gulpfile
 */

var gulp = require('gulp'),
    plumber = require('gulp-plumber'),
    minifycss = require('gulp-minify-css'),
    concat = require('gulp-concat'),
    jshint = require('gulp-jshint'),
    include = require('gulp-include'),
    autoprefixer = require('gulp-autoprefixer'),
    stylish = require('jshint-stylish'),
    uglify = require('gulp-uglify'),
    rename = require('gulp-rename'),
    sass = require('gulp-sass'),
    js_filename = './assets/js/dfp_interstitial_ad.js',
    scss_filename = './assets/css/dfp_interstitial_ad.scss';

gulp.task('scss', function() {
  return gulp.src(scss_filename)
    .pipe(sass())
    .pipe(autoprefixer({
        browsers: ['last 2 versions'],
        cascade: false
      }))
    .pipe(rename({
        dirname: './assets/css/',
        basename: 'dfp_interstitial_ad',
        extname: '.css'
      }))
    .pipe(gulp.dest('./'))
    .pipe(minifycss())
    .pipe(rename({
        dirname: './assets/css/',
        suffix: '.min',
        extname: '.css'
      }))
    .pipe(gulp.dest('./'));
});

// Lint Task
gulp.task('lint', function() {
  return gulp.src(js_filename)
    .pipe(jshint('.jshintrc'))
    .pipe(jshint.reporter('jshint-stylish'));
});


// Uglify Registration Scripts
gulp.task('scripts', function() {
  return gulp.src(js_filename)
    .pipe(rename({
        dirname: './assets/js/',
        suffix: '.min',
        extname: '.js'
      }))
    .pipe(uglify())
    .pipe(gulp.dest('./'));
});

gulp.task('default', ['scss', 'lint', 'scripts'], function() {});
