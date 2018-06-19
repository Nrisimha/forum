'use strict';

require('bootstrap/dist/css/bootstrap.min.css');
require('font-awesome/css/font-awesome.min.css');
require('../css/bootstrap-extension.css');
require('../css/sidebar-nav.min.css');
require('../css/animate.css');
require('../css/style.css');
require('../css/colors/default.css');
require('../css/spinkit.css');
require('bootstrap');
require('../js/jquery.slimscroll');
require('../js/sidebar-nav');
require('../js/waves');
require('../js/custom');
// Require index.html so it gets copied to dist
require('./index.html');
var Elm = require('./Main.elm');
var mountNode = document.getElementById('main');

// .embed() can take an optional second argument. This would be an object describing the data we need to start a program, i.e. a userID or some token
var app = Elm.Main.embed(mountNode);

