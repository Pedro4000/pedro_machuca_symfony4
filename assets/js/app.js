/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
require('../css/colors.scss');
require('../css/app.css');
require('../css/home.scss');
require('../css/registration.scss');
require('../css/navbar.scss');
require('../css/movies.scss');
require('../css/favorite.scss');




// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

// import React from 'react'
// import ReactDOM from 'react-dom'
import Greet from './apifilm';
import Favorite from './favorite';
