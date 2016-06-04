var fs = require('fs');
module.exports = function (grunt) {

    // load all grunt tasks matching the ['grunt-*', '@*/grunt-*'] patterns
    require('load-grunt-tasks')(grunt);

    var directories = {
        composer: 'vendor',
        composerBin: 'vendor/bin',
        config: 'application/config',
        var: 'var'
    };

    var gruntConfig = {
        //ssh: grunt.file.readJSON('.sh'),
        pkg: grunt.file.readJSON('package.json'),
        basePath: './',
        templateName: '<%= pkg.theme %>',
        themePath: '<%= basePath %>/skin/front/<%= templateName %>',
        templateCss: '<%= basePath %>/resources/assets/lms_themes/learning_app/css',
        templateJs: '<%= basePath %>/resources/assets/lms_themes/learning_app/js',
        themeImagePath: '<%= themePath%>/images',

        environments: {
            options: {},
            staging: {
                options: {
                    host: '<%= ssh.staging.host %>',
                    username: '<%= ssh.staging.username %>',
                    password: '<%= ssh.staging.password %>',
                    port: '<%= ssh.staging.port %>',
                    deploy_path: '<%= ssh.staging.deploy_path %>',
                    debug: true,
                    releases_to_keep: '3'
                }
            },
            production: {
                options: {
                    host: '<%= ssh.production.host %>',
                    username: '<%= ssh.production.username %>',
                    password: '<%= ssh.production.password %>',
                    port: '<%= ssh.production.port %>',
                    deploy_path: '<%= ssh.production.deploy_path %>',
                    before_deploy: 'cd <%= ssh.production.deploy_path %>',
                    after_deploy: '',
                    releases_to_keep: '5',
                    release_subdir: 'upins'
                }
            }
        },

        githooks: {
            all: {
                // Will run the jshint and test:unit tasks at every commit
                //'pre-commit': 'jshint',
            }
        },

        jshint: {
            options: {
                jshintrc: '.jshintrc',
                reporter: require('jshint-stylish')
            },
            all: ['Gruntfile.js', '<%= templateJs %>/*.js']
        },
        jsvalidate: {
            files: [
                'Gruntfile.js', '<%= templateJs %>/*.js'
            ]
        },
        jsonlint: {
            files: [
                '*.json'
            ]
        },
        csslint: {
            options: {
                csslintrc: '.csslintrc'
            },
            all: {
                src: ['<%= templateCss%>/*.css']
            }
        },

        //Image compress
        imagemin: {
            upload: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: '<%=basePath%>/images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%=basePath%>/images/'
                }]
            },
            template: {
                options: {
                    optimizationLevel: 7,
                    progressive: true
                },
                files: [{
                    expand: true,
                    cwd: '<%= themeImagePath%>/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: '<%= themeImagePath%>/'
                }]
            }
        },
        //Minify css
        cssmin: {
            combine: {
                files: {
                    '<%= templateCss %>/app.min.css': [
                        '<%= templateCss %>/fix_new_template.css'
                    ]
                }
            },
            print: {
                files: {
                    '<%= templateCss %>/print.min.css': [
                        //'<%= templateCss%>/print.css',
                    ]
                }
            }

        },

        //Concat css
        concat_css: {
            options: {},
            files: {
                '<%= templateCss%>/app.combine.css': [
                    '<%= templateCss%>/style.css',
                    '<%= templateCss%>/login.css',
                ]
            },
        },
        //Combine js files - not minify
        concat: {
            dist: {
                src: [
                    '<%=basePath %>/common.js',
                    '<%=templateJs %>/social.js',
                    '<%=templateJs %>/app.js'
                ],
                dest: '<%=templateJs %>/app.combine.js'
            }
        },

        //Combine and minify js files
        uglify: {
            options: {
                mangle: false
            },
            build: {
                src: [
                    '<%=templateJs %>/all.js',
                    '<%=templateJs %>/app.js',
                    '<%=templateJs %>/main.js',
                ],
                dest: '<%=templateJs %>/app.min.js'
            }
        },

        watch: {
            js: {
                files: '<%= jshint.all %>',
                options: {
                    livereload: true,
                    interval: 100
                }
            },
            css: {
                files: '<%= csslint.all.src %>',
                options: {
                    livereload: true,
                    interval: 100
                }
            },
            php: {
                files: ['**/*.php'],
                options: {
                    livereload: true,
                    interval: 100
                }
            },

        }
    };


    //config grunt
    grunt.initConfig(gruntConfig);

    // register task(s).
    //grunt.registerTask('lint', ['jsvalidate', 'jshint:all','jsonlint','csslint']);
    //grunt.registerTask('copydb', ['copy:localConfig']);
    //grunt.registerTask('build', ['lint', 'concat', 'uglify', 'cssmin', 'imagemin']);
    //grunt.registerTask('default', ['copydb','lint']);

    grunt.registerTask('min', ['cssmin', 'uglify']);

};
