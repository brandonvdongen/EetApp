module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
        htmlmin: {                                     // Task
            dist: {                                      // Target
                options: {                                 // Target options
                    removeComments: true,
                    collapseWhitespace: true
                },
                files: {                                   // Dictionary of files
                    'dist/index.html': 'src/index.php'     // 'destination': 'source'
                }
            }
        },
        babel: {
            options: {
                sourceMap: false,
                presets: ['env']
            },
            dist: {
                files: [
                    {
                        expand: true,
                        cwd: 'src/',
                        src: ["js/*.js"],
                        dest: 'babel/'
                    }
                ]
            }
        },
        uglify: {
            options: {
                mangle: false
            },
            my_target: {
                files: [
                    {
                        expand: true,
                        cwd: 'babel/',
                        src: ["js/*.js"],
                        dest: 'dist/'
                    }
                ]
            }
        },
        cssmin: {
            target: {
                files: [{
                    expand: true,
                    cwd: 'src/css',
                    src: ['*.css'],
                    dest: 'dist/css',
                    ext: '.css'
                }]
            }
        },
        clean: {
            build: ['babel/'],
            release: ['dist/']
        }
    });


    grunt.loadNpmTasks('grunt-contrib-uglify');
    grunt.loadNpmTasks('grunt-contrib-clean');
    grunt.loadNpmTasks('grunt-contrib-htmlmin');
    grunt.loadNpmTasks('grunt-contrib-cssmin');

    grunt.registerTask('build', [
        'clean',
        'babel',
        'uglify',
        'cssmin',
        'htmlmin',
        'clean:build'
    ]);

    grunt.registerTask('default', ['build']);
}
;