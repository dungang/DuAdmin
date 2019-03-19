var gulp = require('gulp'),
  minify = require('gulp-minify-css'),
  concat = require('gulp-concat'),
  rename = require('gulp-rename'),
  less = require('gulp-less'),
  // 当发生异常时提示错误 确保本地安装gulp-notify和gulp-plumber
  notify = require('gulp-notify'),
  plumber = require('gulp-plumber');

gulp.task('app-less', (done) => {
	  gulp.src('public/css/app.less')
	    .pipe(plumber({
	      errorHandler: notify.onError('Error: <%= error.message %>')
	    }))
	    .pipe(less())
	    .pipe(gulp.dest('./public/css'))
	    .pipe(minify({
	      compatibility: 'ie7'
	    }))
	    .pipe(rename({
	    	suffix: '.min'
	    }))
	    .pipe(gulp.dest('./public/css'));
	  done();
	});

gulp.task('backend-less', (done) => {
	  gulp.src('public/css/backend.less')
	    .pipe(plumber({
	      errorHandler: notify.onError('Error: <%= error.message %>')
	    }))
	    .pipe(less())
	    .pipe(gulp.dest('./public/css'))
	    .pipe(minify({
	      compatibility: 'ie7'
	    }))
	    .pipe(rename({
	    	suffix: '.min'
	    }))
	    .pipe(gulp.dest('./public/css'));
	  done();
	});

gulp.task('adminlte-less', (done) => {
	  gulp.src('public/adminlte/adminlte.less')
	    .pipe(plumber({
	      errorHandler: notify.onError('Error: <%= error.message %>')
	    }))
	    .pipe(less())
	    .pipe(gulp.dest('./public/adminlte/css'))
	    .pipe(minify({
	      compatibility: 'ie7'
	    }))
	    .pipe(rename({
	    	suffix: '.min'
	    }))
	    .pipe(gulp.dest('./public/adminlte/css'));
	  done();
	});
	
	gulp.task('tbk-less', (done) => {
	  gulp.src('public/tbk/tbk-theme.less')
	    .pipe(plumber({
	      errorHandler: notify.onError('Error: <%= error.message %>')
	    }))
	    .pipe(less())
	    .pipe(gulp.dest('./public/tbk/css'))
	    .pipe(minify({
	      compatibility: 'ie7'
	    }))
	    .pipe(rename({
	    	suffix: '.min'
	    }))
	    .pipe(gulp.dest('./public/tbk/css'));
	  done();
	});

gulp.task('watch', (done) => {
    gulp.watch([
		'./public/adminlte/less/*',
		'./public/css/*.less',
		'./public/tbk/*.less',
		'./public/tbk/less/*.less',
	], gulp.series('app-less','backend-less','adminlte-less','tbk-less'));
    return done();
});

gulp.task('default', gulp.series('watch'));