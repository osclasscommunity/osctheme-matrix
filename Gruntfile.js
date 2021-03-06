'use strict';

module.exports = function(grunt) {
    // Project configuration.
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        replace: { },
        watch: { },
        shell: { },
        sass: {
            dist: {
                options: {
                    style: 'compressed',
                    compass: true
                },
                files: {
                    'css/main.css': 'sass/main.scss'
                }
            }
        },
        copy: { }
    });

    var pkg = grunt.config.get('pkg');

    grunt.config('watch.matrix', {
        files: ['sass/**'],
        tasks: ['sass'],
        options: {
            interrupt: true,
        }
    });

    grunt.config('copy.matrix', {
        files: [
            {
                expand: true,
                src: [
                    '*.php',
                    'admin/**',
                    'common/**',
                    'css/**',
                    'favicon/**',
                    'fonts/**',
                    'images/**',
                    'js/**',
                    'languages/**'
                ],
                dest: 'dist/matrix'
            }
        ]
    });

    var archive = '../packages/matrix_' + pkg.version + '.zip';
    grunt.config('shell.compress_matrix', {
        command : 'cd dist/; zip -r ' + archive + ' matrix/;',
        options: {
            stdout: false
        }
    });

    grunt.registerTask('dist:matrix', ['sass', 'copy:matrix', 'shell:compress_matrix']);

    grunt.loadNpmTasks('grunt-contrib-copy');
    grunt.loadNpmTasks('grunt-contrib-watch');
    grunt.loadNpmTasks('grunt-contrib-sass');
    grunt.loadNpmTasks('grunt-shell');
    grunt.loadNpmTasks('grunt-text-replace');
};
