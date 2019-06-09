// Load plugins
const gulp = require('gulp');
const del = require('del');
const sass = require('gulp-sass');
const htmlmin = require('gulp-htmlmin');
const php = require('gulp-connect-php');
const browsersync = require('browser-sync').create();
const merge = require("merge-stream");
const concat = require("gulp-concat");
const uglify = require("gulp-uglify");
const cleanCSS = require("gulp-clean-css");
const rename = require("gulp-rename");

// Clean vendor
function clean() {
  return del(['./dist/lib']);
}

// Bring third party dependencies from node_modules into dist/lib directory
function modules() {
  let fontAwesome = gulp.src('./node_modules/font-awesome/**/*').pipe(gulp.dest('./src/lib/font-awesome'));
  let jquery = gulp.src('./node_modules/jquery/dist/jquery.js').pipe(gulp.dest('./src/lib/jquery'));
  let bootstrap = gulp.src('./node_modules/bootstrap/dist/**/*').pipe(gulp.dest('./src/lib/bootstrap'));
  let moveImg = gulp.src('./src/img/*').pipe(gulp.dest('./dist/img'));
  return merge(fontAwesome, jquery, bootstrap, moveImg);
}

//BrowserSync
function browserSync(done) {
  browsersync.init({
    proxy:"localhost:3000",
    baseDir: "./",
    open:true,
    notify:false
  });
  done();
}

//PHP
function phpSync() {
  php.server({
    base:'./', 
    port:3000, 
    keepalive:true
  });
}

//BrowserSync Reload
function browserSyncReload(done) {
  browsersync.reload();
  done();
}

const html = () => {
  return gulp.src('./*.php')
    .pipe(htmlmin({ collapseWhitespace: true }))
    .pipe(gulp.dest('./public'));
}

// complieScss task
function complieScss() {
  return gulp.src(['./src/scss/**/*.scss'])
  .pipe(sass({
    outputStyle: "expanded"
  }))
  .pipe(gulp.dest("./src/css"))
  .pipe(browsersync.stream());
}

// bundleCSS task
function bundleCSS() {
  return gulp
  .src([
    './src/**/*.css',
    '!./src/**/*.min.css'
  ])
  .pipe(concat('bundle.css'))
  .pipe(cleanCSS())
  .pipe(rename({
    suffix: '.min'
  }))
  .pipe(gulp.dest("./dist/"))
  .pipe(browsersync.stream());
}

// bundleJs task
function bundleJs() {
  return gulp
    .src([
      './src/lib/**/*.js',
      './src/js/*.js',
      '!./src/**/*.min.js'
    ])
    .pipe(concat('bundle.js'))
    .pipe(uglify())
    .pipe(rename({
      suffix: '.min'
    }))
    .pipe(gulp.dest('./dist'))
    .pipe(browsersync.stream());
}

// Watch task
function watchFile() {
  gulp.watch("./src/js/**/*", js);
  gulp.watch("./src/scss/**/*", css);
  gulp.watch("./*.php", browserSyncReload);
}

// Define complex tasks
const js = gulp.series(bundleJs);
const css = gulp.series(complieScss, bundleCSS);
const build = gulp.series(clean, modules, gulp.parallel(css,js));
const watch = gulp.series(build, gulp.parallel(watchFile, phpSync, browserSync));

exports.js = js;
exports.clean = clean;
exports.modules = modules;
exports.html = html;
exports.js = bundleJs;
exports.css = css;
exports.dev = watch;
exports.build = build;
