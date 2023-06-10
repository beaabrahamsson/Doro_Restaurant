//Variabler
const {src, dest, parallel, series, watch} = require('gulp');
const concat = require('gulp-concat');
const terser = require('gulp-terser');
const browserSync = require('browser-sync').create();
const sass = require('gulp-sass')(require('sass'));
const sourcemaps = require('gulp-sourcemaps');
const babel = require('gulp-babel');
const imagemin = require('gulp-imagemin');

//Sökvägar
const files = {
    htmlPath: "src/**/*.html",
    imagePath: "src/images/*",
    sassPath: "src/sass/main.scss",
    jsPath: "src/js/*.js"
}

//HTML-task, kopiera html
function copyHTML() {
    return src(files.htmlPath)
    .pipe(dest('pub'))
    .pipe(browserSync.stream());
}

//Image-task
function imageTask() {
    return src(files.imagePath)
    .pipe(imagemin()) //Minimerar bildfiler
    .pipe(dest('pub/images')) //Flyttar till pub
    .pipe(browserSync.stream());
}


//SASS-task
function sassTask() {
    return src(files.sassPath)
        .pipe(sourcemaps.init())
        .pipe(sass().on("error", sass.logError))
        .pipe(dest("pub/css"))
        .pipe(browserSync.stream());
}

function jsTask() {
    return src(files.jsPath)
    .pipe(babel({ //Transpilerar till ES5
        presets: ['@babel/preset-env']
        }))
    .pipe(concat('main.js')) //Konkatenerar
    .pipe(terser()) //Minimerar
    .pipe(dest('pub/js')) //Flyttar till pub
    .pipe(browserSync.stream());
}

//Watch-task
function watchTask() {
    //live-server
    browserSync.init({
        server: "./pub"
    });
    watch ([files.htmlPath, files.imagePath, files.sassPath, files.jsPath], parallel(copyHTML, imageTask, sassTask, jsTask)).on('change', browserSync.reload);
}

//Exporterar funktioner
exports.default = series(
    parallel(copyHTML, imageTask, sassTask, jsTask),
    watchTask
);