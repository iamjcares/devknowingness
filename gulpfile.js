//gulpfile.js
var gulp = require('gulp'),
	less = require('gulp-less'),
    notify  = require('gulp-notify'),
    phpunit = require('gulp-phpunit'),
    _       = require('lodash');

var theme = 'tubed';

var LessPluginAutoPrefix = require('less-plugin-autoprefix'),
    autoprefix= new LessPluginAutoPrefix({browsers: ["last 2 versions"]});

gulp.task('less', function() {
  // place code for your default task here
  gulp.src('public/content/themes/' + theme + '/assets/less/*.less')
  .pipe(less({
    plugins: [autoprefix]
  }))
  .pipe(gulp.dest('public/content/themes/' + theme + '/assets/css'))
  .pipe(notify("Yeah, buddy! Your CSS file is ready to go!"));

});
 
gulp.task('phpunit', function() {
    var options = {debug: true, notify: true};
    gulp.src('tests/*.php')
        .pipe(phpunit('', options))
        .on('error', notify.onError(testNotification('fail', 'phpunit')))
      	.pipe(notify(testNotification('pass', 'phpunit')));
});

function testNotification(status, pluginName, override) {
    var options = {
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? '\n\nAll tests have passed!\n\n' : '\n\nOne or more tests failed...\n\n',
        icon:    __dirname + '/node_modules/gulp-' + pluginName +'/assets/test-' + status + '.png'
    };
    options = _.merge(options, override);
  return options;
}

gulp.task('default', function(){
    gulp.run('phpunit');
    gulp.watch('app/**/*.php', function(){
        gulp.run('phpunit');
    });
    gulp.watch('public/content/themes/' + theme + '/**/*.php', function(){
        gulp.run('phpunit');
        
    });

    
    /*gulp.watch('public/content/themes/' + theme + '/*.php', function(){
        gulp.run('phpunit');
    });*/
    gulp.run('less');

    gulp.watch('public/content/themes/' + theme + '/assets/less/*.less', function(){
      gulp.run('less');
    });
});

