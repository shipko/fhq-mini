requirejs.config({
    baseUrl: 'js/admin',
    paths: {
        app: '../app',
        ace: '../../bower_components/ace/build/src',
        jquery: '../vendors/jquery.min',
        'jquery.cookie': '../vendors/jquery.cookie',
        backbone: '../vendors/backbone',
        bootstrap: '../vendors/bootstrap.min',
        underscore: '../vendors/underscore-min',
        ejs: 'ejs',
        moment: '../vendors/moment',
        datetimepicker: '../vendors/datetimepicker',


        helpers: 'admin/helpers/helpers'
    }
});

requirejs(['main']);