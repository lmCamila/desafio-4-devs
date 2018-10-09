Gulp = {
    self : null,
    browsersync : null,
    init : function(){
        Gulp.self = require('gulp'),
        Gulp.browsersync = require('browser-sync').create(),
        Gulp.startServer(),
        Gulp.default();
    },
    startServer : () =>{
        Gulp.self.task('browser-sync',function(){
            browsersync.init({
                server:{
                    baseDir: "./"
                }
            });
            Gulp.self.watch('./*.html').on('change', Gulp.browserSync.reload)
        });
    },
    default : () => {
        Gulp.self.task('default', ['browser-sync']);
    }
}
Gulp.init();





