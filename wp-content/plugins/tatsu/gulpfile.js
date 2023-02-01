var gulp = require( 'gulp' ),
    postcss = require( 'gulp-postcss' ),
    notify = require( 'gulp-notify' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    autoprefixer = require( 'autoprefixer' ),
    cssnano = require( 'cssnano' ),
    prompt = require( 'gulp-prompt' ),
    order = require( 'gulp-order' ),
    git = require( 'gulp-git' ),
    concat = require( 'gulp-concat' ),
    lec = require( 'gulp-line-ending-corrector' ),
    del = require( 'del' ),
    zip = require( 'gulp-zip' );

var zipPath = [ '../tatsu', '../tatsu/**', '!../tatsu/node_modules', '!../tatsu/node_modules/**', '!../tatsu/build', '!../tatsu/build/**', '!../tatsu/gulpfile.js', '!../tatsu/package.json', '!../tatsu/package-lock.json' ];


//checks git branch status
gulp.task('git:status', function(){
    git.revParse({args:'--abbrev-ref HEAD'}, function (err, branch) {
        console.log('Tatsu branch: ' + branch);
    });      
    return gulp.src( './' )
           .pipe( prompt.confirm() );
});

//css and js minification
gulp.task('clean:compile', [ 'git:status' ], function() {
    let cleanPath = ['./public/js/**/*.min.js', './public/css/**/*.min.css','./public/theme-assets/theme-main.min.css'];
    return del( cleanPath, { force : true });
});
//minify tatsu theme css
gulp.task( 'compile:themecss',[ 'clean:compile'], function() {
    return gulp.src(['./public/theme-assets/theme-main.css' ])
            .pipe(postcss([
                autoprefixer([
                    'last 3 version',
                    'ie >= 11'
                ]),
                cssnano({ minifyFontValues: false, discardUnused: false, 'postcss-reduce-idents' : false, zindex : false })
            ]))
            .pipe(lec())
            .pipe(rename({suffix : '.min'}))
            .pipe(gulp.dest('./public/theme-assets')) 
            .pipe( notify( { 
            message : 'Tatsu theme css Compilation successful',
            onLast : true
            }));  
});

gulp.task( 'compile:css', [ 'clean:compile'], function() {
    return gulp.src(['./public/css/**/*.css' ])
               .pipe(postcss([
                    autoprefixer([
                        'last 3 version',
                        'ie >= 11'
                    ]),
                    cssnano({ minifyFontValues: false, discardUnused: false, 'postcss-reduce-idents' : false, zindex : false })
                ]))
               .pipe(lec())
               .pipe(order([
                    'vendor.css',
                    'tatsu.css', 
                    'tatsu-shortcodes.css',        
                    'tatsu-header.css', 
                    'tatsu-css-animations.css'
                ]))
               .pipe(concat('tatsu.min.css'))
               .pipe(gulp.dest('./public/css'))
               .pipe( notify( { 
                    message : 'Css Compilation successful',
                    onLast : true
               }));   
});

gulp.task( 'compile:js', [ 'clean:compile', 'compile:css','compile:themecss'], function() {
        return  gulp.src( './public/js/**/*.js' )
                    .pipe( uglify() )
                    .pipe( lec() )
                    .pipe( rename( { suffix  : '.min' } ) )
                    .pipe( gulp.dest('./public/js'))
                    .pipe( notify( { 
                        message : 'Js Compilation successful',
                        onLast : true
                    }));
});

//creates zip
gulp.task( 'clean:zip', [ 'compile:js'], function() {
    return del([ './build/**' ], {force:true});
});

gulp.task('build', [ 'git:status', 'clean:compile', 'compile:css', 'compile:js', 'clean:zip' ], function() {
    gulp.src( zipPath, { base : '../' } )
        .pipe( zip( 'tatsu.zip' ) )
        .pipe( gulp.dest( './build/' ) )
        .pipe( notify({
            message : 'Zip process complete! Build Successfull',
            onLast : true
        }) );
});

gulp.task('zip', [ 'git:status' ], function() {
    gulp.src( zipPath, { base : '../' } )
        .pipe( zip( 'tatsu.zip' ) )
        .pipe( gulp.dest( './build/' ) )
        .pipe( notify({
            message : 'Zip process complete! Build Successfull',
            onLast : true
        }) );
});

gulp.task( 'default', [ 'build' ] );