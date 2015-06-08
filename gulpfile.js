var gulp = require('gulp'),
    notify  = require('gulp-notify'),
    phpspec = require('gulp-phpspec'),
    _       = require('lodash'),
    shell   = require('gulp-shell');

function testNotification(status, pluginName, override) {
    var options = {
        title:   ( status == 'pass' ) ? 'Tests Passed' : 'Tests Failed',
        message: ( status == 'pass' ) ? 'All tests have passed!' : 'One or more tests failed...',
        icon:    __dirname + '/node_modules/gulp-' + pluginName +'/assets/test-' + status + '.png'
    };
    options = _.merge(options, override);
    return options;
}

gulp.task('clearScreen', shell.task(['clear']));

gulp.task('phpspec', function() {
    gulp.src('phpspec.yml')
        .pipe(phpspec('', {notify: true}))
        .on('error', notify.onError(testNotification('fail', 'phpspec')))
        .pipe(notify(testNotification('pass', 'phpspec')));
});

gulp.task('default', ['clearScreen', 'phpspec'], function() {
    gulp.watch(['./spec/**/*.php', './src/**/*.php'], ['clearScreen', 'phpspec']);
});