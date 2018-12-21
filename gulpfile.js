const gulp = require('gulp');
const rename = require('gulp-rename');
const concat = require('gulp-concat');
const livereload = require('gulp-livereload');
const sourcemaps = require('gulp-sourcemaps');

// css
const sass = require('gulp-sass');
const postcss = require('gulp-postcss');
const autoprefixer = require('autoprefixer');
const cssnano = require('cssnano');
const streamqueue = require('streamqueue');

// js
const browserify = require('browserify');
const source = require('vinyl-source-stream');
const buffer = require('vinyl-buffer');
const babel = require('gulp-babel');
const uglify = require('gulp-uglify');

// images
const imagemin = require('gulp-imagemin');

gulp.task('styles', () => {
  return streamqueue(
    { objectMode: true },
    gulp.src('./node_modules/normalize.css/normalize.css')
      .pipe(sourcemaps.init()),
    // Add other external stylesheets to concatenate here with gulp.src().
    gulp.src('assets/scss/main.scss')
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
  )
    .pipe(concat('main.css'))
    .pipe(gulp.dest('dist'))
    .pipe(postcss([
      autoprefixer({ browsers: ['last 2 versions'] }),
      cssnano()
    ]))
    .pipe(rename({ suffix: '.min' }))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('dist'));
});

gulp.task('dev_styles', () => {
  return streamqueue(
    { objectMode: true },
    gulp.src('./node_modules/normalize.css/normalize.css')
      .pipe(sourcemaps.init()),
    // Add other external stylesheets to concatenate here with gulp.src().
    gulp.src('assets/scss/main.scss')
      .pipe(sourcemaps.init())
      .pipe(sass().on('error', sass.logError))
  )
    .pipe(concat('main.min.css'))
    .pipe(sourcemaps.write('.'))
    .pipe(gulp.dest('dist'))
    .pipe(livereload());

});


// gulp.task('dev_scripts', () => {
//   return browserify({
//     entries: ['./assets/index.js'],
//     debug: true
//   })
//     .bundle()
//     //Pass desired output filename to vinyl-source-stream
//     .pipe(source('main.min.js'))
//     .pipe(buffer())
//     .pipe(sourcemaps.init({ loadMaps: true }))
//     // Add transformation tasks to the pipeline here.
//     // Any tasks between sourcemaps.init and .write must be compatible with sourcemaps
//     // https://github.com/gulp-sourcemaps/gulp-sourcemaps/wiki/Plugins-with-gulp-sourcemaps-support
//     // .pipe(uglify())
//     .pipe(sourcemaps.write('./'))
//     // Start piping stream to tasks!
//     .pipe(gulp.dest('./dist/'))
//     .pipe(livereload());

// });

// gulp.task('scripts', () => {

//   return browserify({
//     entries: ['./assets/index.js'],
//     debug: true
//   })
//     .bundle()
//     //Pass desired output filename to vinyl-source-stream
//     .pipe(source('main.js'))
//     .pipe(buffer())
//     .pipe(sourcemaps.init({ loadMaps: true }))
//     // Add transformation tasks to the pipeline here.
//     .pipe(babel())
//     .pipe(gulp.dest('./dist/'))
//     .pipe(uglify())
//     .pipe(rename({ suffix: '.min' }))
//     .pipe(sourcemaps.write('./'))
//     // Start piping stream to tasks!
//     .pipe(gulp.dest('./dist/'));

// });

// gulp.task('images', () => {
//   gulp.src('assets/images/*')
//     .pipe(imagemin())
//     .pipe(gulp.dest('./dist'))
//     .pipe(livereload());
// });

gulp.task('refresh', () => {
  gulp.src('index.php')
    .pipe(livereload());
});

gulp.task('default', () => {
  gulp.start('styles');
});

gulp.task('watch', () => {
  livereload.listen();

  // Watch .scss files
  gulp.watch('assets/scss/**/*.scss', ['dev_styles']);

  // // Watch .js files
  // gulp.watch('assets/**/*.js', ['dev_scripts']);

  // Watch .php files
  gulp.watch('**/*.php', ['refresh']);

  // // Watch images
  // gulp.watch('assets/images/**/*', ['images']);

});
